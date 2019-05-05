<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Loader;
use think\Db;

class LeaseAudit extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__LEASE_CHANGE_ORDER__';


    /**
     * 补充资料时获取的详情，此处和审批及明细中的详情不同点在于：补充资料的详情没有图片url数组信息
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [  ]
     */
    public function get_change_detail_info($changeOrderID){

        $find = Db::name('lease_change_order')->where('ChangeOrderID',$changeOrderID)->field('QrcodeUrl,Deadline,Szno,Recorde,Status')->find();

        $result = $find['Deadline']?json_decode($find['Deadline'],true):array();
        if($find['Status'] == 5){
            $result['applyText_other'] = preg_replace("/\(.*\)/", '', $result['applyText_other']);
        }
        $result['Recorde'] = $find['Recorde'];
        $result['QrcodeUrl'] = $find['QrcodeUrl'];
        $result['Szno'] = $find['Szno']; 

        return $result;
    }

    //不需要调试模式，ob_end_clean() 不能去掉否则乱码
    public function qrcode()
    {
        ob_end_clean();

        Loader::import('phpqrcode.phpqrcode', EXTEND_PATH);

        $code = substr(md5(substr(uniqid(),-6)),6).substr(uniqid(),-6);

        $value = 'https://ph.ctnmit.com/erweima/'.$code;          //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别 
        $matrixPointSize = 6;           //生成图片大小
        $url = '/uploads/qrcode/'.$code.'.png';
        $filename = $_SERVER['DOCUMENT_ROOT'].$url;

        $qrcode = new \QRcode;

        //$qrcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2); 
        $qrcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);

        return $url;
    }

    public function uploads($file,$k1){

        $title = config($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/usechange/'); //设置保存的路径
        $fileUpload->set('maxsize',5*1024*1024); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            //return jsons('4003' ,$fileUpload->getErrorMsg());
            return jsons('4003' ,'上传失败');

        }else{  //上传成功

            //多文件上传，遍历操作
            $names = $fileUpload->getFileName();

            foreach($names as $k => $v){

                $data['FileUrl']= '/uploads/usechange/'.$v;          //写入到数据库中的地址和存放地址 $targetPath 不一样
                $data['FileTitle'] = $title;
                $data['FileType'] = 1;        //图片类型
                $data['FileUse'] = 5;         //用途：使用权变更
                $data['UploadUserID'] = UID;
                $data['UploadTime'] = time();
                $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1

                if($result == 1) {
                     $fileID[] = Db::name('upload_file')->getLastInsID();
                }
            }

            return $fileIDS = implode(',', $fileID);

        }

    }

    //创建一个子订单，例如（补充资料完成，每次审核完成 ，）
    public function create_child_order($changeOrderID,$reson=''){
        
        //获取流程总人数
        $total = Db::name('lease_change_order')->alias('a')
                                             ->join('process_config b' ,'a.ProcessConfigType = b.id' ,'left')
                                             ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                             ->field('a.Deadline,a.Child,a.PrintTime,a.Status,b.Total')
                                             ->find();

        $where['ChangeOrderID'] = array('eq' ,$changeOrderID);

        //判断当前流程
        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        $deadline = json_decode($total['Deadline'],true);

        //若中间审核通过
        if($status < $total['Total'] && $reson == '') {

            if($status == 2){  //当资料员审核完成后
                $deadline['applyRoom21_data1'] = session('user_base_info.name');
            }elseif($status == 3){  //当行政所长审核完成后
                $deadline['applyRoom21_data2'] = session('user_base_info.name');
            }elseif($status == 4){  //当经管科审核完成后
                $deadline['applyRoom21_data3'] = session('user_base_info.name');
                $qrcodeUrl = $this->qrcode();
            }elseif($status == 5){ //当经租会计审核完成后
                if(!$total['PrintTime']){
                    return jsons('4000','请先打印租约！');
                }
            }

            Db::name('lease_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->setField('Deadline',json_encode($deadline));

            self::where($where)->setInc('Status',1); //步骤递进



        //若中间审核不通过
        }elseif($status < $total['Total'] && $reson != ''){

            self::where($where)->setField('Status',0); //状态重置为0


        // 若终审不通过,这里不存在，因为最后一个人没有权限不通过或通过
        }elseif($status == $total['Total'] && $reson != ''){
            //终审不通过则状态改为 0
            //self::where($where)->setField('Status',0);
            exit;
        // 若终审通过
        }elseif($status == $total['Total'] && $reson == ''){
            
            //终审通过则状态改为  1
            self::where($where)->setField('Status',1);
        }

        $child = json_decode($total['Child'],true);

        $s = [
                'Step' => $total['Status'],
                'Reson' => $reson,
                'IfValid' => $reson?0:1,
                'UserNumber' => UID,
                'CreateTime' => time(),
            ];

        array_unshift($child,$s);

        $jsonChild = json_encode($child);

        $re = Db::name('lease_change_order')->where($where)->setField('Child',$jsonChild);

        if(isset($qrcodeUrl)){
            self::where($where)->setField('QrcodeUrl',$qrcodeUrl);
        }

        return $re?true:false;

    }

    //检查文件是否曾上传过，false表示没有上传过，则执行添加操作
    public function check_file(){
        return false;
    }



    /**
     * 获取变更编号的url路径信息
     * @description  通过主订单编号来获取
     * @author Mr.Lu
     * @return array [ config 配置信息， status 现在进行到哪一个  ]
     */
    public function process_imgs_url($changeOrderID){
        $IDS = Db::name('lease_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('ChangeImageIDS');
        $images = explode(',' ,$IDS);

        if(!$images){

            return array();
        }else{

            $urls = Db::name('upload_file')->where('id' ,'in' ,$images)->field('FileUrl ,FileTitle')->select();
            return $urls;
        }

    }

    /**
     * 获取审批流程状态
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [ config 配置信息， status 现在进行到哪一个  ]
     */
    public function process_status($changeOrderID){

        $process = Db::name('lease_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)
                                                 ->field('ProcessConfigType , Status')
                                                 ->find();

        $datas['config'] = Db::name('process_config')->where('pid','eq',$process['ProcessConfigType'])
                                                     ->order('Total asc')
                                                     ->column('RoleName');

        $datas['status'] = $process['Status']-1;

        return $datas;

    }

    /**
     * 获取审批流程记录
     * @description  通过主订单编号来获取流程记录，例如：提交，补充资料，审核
     * @author Mr.Lu
     * @return array [  操作人 ，角色名称  ，操作时间 ，操作内容 ]
     */
    public function process_record($changeOrderID){

        $oneFind = Db::name('lease_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)
                                               ->field('Child,ProcessConfigType')
                                               ->find();

        $oneData = json_decode($oneFind['Child'],true);

        $result = [];

        foreach($oneData as $v){

             $map['pid'] = array('eq',$oneFind['ProcessConfigType']);
             $map['Total'] = array('eq' ,$v['Step']);

            $four = Db::name('process_config')->where($map)->value('Title');  //操作内容
            $one = Db::name('process_config')->where($map)->value('RoleName');  //角色名称
            $two = Db::name('admin_user')->where('Number' ,'eq' ,$v['UserNumber'])->value('UserName'); //操作人
            $three = date('Y-m-d H:i:s' ,$v['CreateTime']);

            if($v['IfValid'] == 1){
                $result[] = $one.' '.$two.' 于'.$three.' '.$four;
            }else{
               $result[] = $one.' '.$two.' 于'.$three.' '.$four.'失败，原因：'.$v['Reson'];
            }
        }

        return array_reverse($result);
    }

    /**
     * 检查是否可执行补充资料 :::  注意如果当前登录账号拥有多角色，例如同时有审批流中的多个角色，程序可能会出现BUG
     * @description  当，已有审批完成后
     * @author Mr.Lu
     * @return bool
     */
    public function check_supply($changeOrderID){

        //$status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        self::check_process($changeOrderID);

        // if($status > 3){

        //     return false;
        // }

        // return true;
    }

    /**
     * 检查是否可执行当前审批 :::  注意如果当前登录账号拥有多角色，例如同时有审批流中的多个角色，程序可能会出现BUG
     * @description  当，审批流程未到此处时，或， 已审批过时
     * @author Mr.Lu
     * @return bool
     */
    public function check_process($changeOrderID){

        $one =  Db::name('lease_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)
                                            ->field('Status ,ProcessConfigType ')
                                            ->find();

        $where['pid'] = array('eq' ,$one['ProcessConfigType']);
        $where['Total'] = array('eq' ,$one['Status']);

        $roleID = Db::name('process_config')->where($where)->value('RoleID');

        $currentRoles = json_decode(session('user_base_info.role'),true);

        if(!in_array($roleID ,$currentRoles)){

            return jsons('4005' ,'审批失败，请注意查看审核状态……');
        }

    }
}