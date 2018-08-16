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
    protected $table = '__USE_CHANGE_ORDER__';


    /**
     * 补充资料时获取的详情，此处和审批及明细中的详情不同点在于：补充资料的详情没有图片url数组信息
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [  ]
     */
    public function get_change_detail_info($changeOrderID){

        $deadline = Db::name('lease_change_order')->where('ChangeOrderID',$changeOrderID)->value('Deadline');
        return json_decode($deadline,true);


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
        $total = Db::name('use_change_order')->alias('a')
                                             ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                             ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                             ->value('Total');

        $where['ChangeOrderID'] = array('eq' ,$changeOrderID);

        //判断当前流程
        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        //若中间审核通过
        if($status < $total && $reson == '') {

            self::where($where)->setInc('Status',1); //步骤递进

            $datas['Status'] = 2;

        //若中间审核不通过
        }elseif($status < $total && $reson != ''){

            self::where($where)->setField('Status',0); //状态重置为0

            $datas['Status'] = 3;  //子订单状态：3为不通过，2为通过 ，1为待审核：  注意此时主订单状态已被重置

        // 若终审不通过
        }elseif($status == $total && $reson != ''){

            //终审不通过则状态改为 0
            self::where($where)->setField('Status',0);

            $datas['Status'] = 3;

        // 若终审通过
        }elseif($status == $total && $reson == ''){


            //终审通过则状态改为  1
            self::where($where)->setField('Status',1);

            //终审通过后，系统自动将变更数据更改,1更名，2过户，3赠予，4转让
            $changeOrderDetail = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->field('*')->find();

            Db::name('house')->where('TenantID','eq',$changeOrderDetail['OldTenantID'])->update(['TenantID'=>$changeOrderDetail['NewTenantID'],'TenantName'=>$changeOrderDetail['NewTenantName']]);

            $datas['Status'] = 2;

        }

        $option['FatherOrderID'] = array('eq' ,$changeOrderID);
        $option['IfValid'] = array('eq' ,1);
        $step = Db::name('use_child_order')->where($option)->max('Step');

        if(!$step){
            $datas['Step'] = 2;
        }else{
            $datas['Step'] = $step + 1;
        }

        $datas['FatherOrderID'] = $changeOrderID;  //父订单编号
        $datas['InstitutionID'] = session('user_base_info.institution_id'); //保存机构
        $datas['Reson'] = $reson; //不通过理由
        $datas['UserNumber'] = UID;
        $datas['CreateTime'] = time();

        $re = Db::name('use_child_order')->insert($datas);  //创建子订单

        if($status < $total && $reson != ''){
            Db::name('use_child_order')->where('FatherOrderID' ,'eq' ,$changeOrderID)->setField('IfValid' ,0); //重置之前的子订单状态为无效
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
        $IDS = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('ChangeImageIDS');
        $images = explode(',' ,$IDS);

        if(!$images){

            jsons('4004' ,'请先上传相关图片');
        }

        $urls = Db::name('upload_file')->where('id' ,'in' ,$images)->field('FileUrl ,FileTitle')->select();

        return $urls;

    }

    /**
     * 获取审批流程状态
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [ config 配置信息， status 现在进行到哪一个  ]
     */
    public function process_status($changeOrderID){

        $process = Db::name('use_change_order')->alias('a')
                                               ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                               ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                               ->field('b.Total, b.id ,a.Status')
                                               ->find();

        $datas['config'] = Db::name('process_config')->where('pid','eq',$process['id'])
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

        //获取，当前审批流程的名称、总步骤数、提交资料人员id ，提交时间
        $process = Db::name('use_change_order')->alias('a')
                                               ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                               ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                               ->field('b.Total, b.Title , b.id ,a.Status ,a.UserNumber ,a.CreateTime')
                                               ->find();

        $where['pid'] = array('eq' ,$process['id']);
        $where['Total'] = array('eq' ,1);

        $one = Db::name('process_config')->where($where)->field('RoleName ,Title')->find();


        $first['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$process['UserNumber'])->value('UserName');

        $first['CreateTime'] = date('Y-m-d H:i:s' ,$process['CreateTime']);

        $first['Reson'] = '';

        $first['RoleName'] = $one['RoleName'];

        $first['Step'] = $one['Title'];

        $first['Status'] = 2;

        //获取，所有子订单的，机构id，状态，理由，用户编号，审核时间： 注意在使用权变更中补充资料视为审核
        $record = Db::name('use_child_order')->where('FatherOrderID' ,'eq' ,$changeOrderID)
                                             ->field('Status ,Step ,Reson ,UserNumber ,CreateTime')
                                             ->order('CreateTime asc')
                                             ->select();



        foreach($record as $k3 => &$v3){

            $map['pid'] = array('eq',$process['id']);
            $map['Total'] = array('eq' ,$v3['Step']);

            if($v3['Status'] == 3){
                $v3['Status'] = '不通过';
            }

            $v3['Step'] = Db::name('process_config')->where($map)->value('Title');  //操作内容
            $v3['RoleName'] = Db::name('process_config')->where($map)->value('RoleName');  //角色名称
            $v3['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$v3['UserNumber'])->value('UserName'); //操作人
            $v3['CreateTime'] = date('Y-m-d H:i:s' ,$v3['CreateTime']);
        }

        array_unshift($record,$first);

        return $record;
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

        $one =  Db::name('use_change_order')->alias('a')
                                            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                            ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                            ->field('a.Status ,b.id ')
                                            ->find();

        $where['pid'] = array('eq' ,$one['id']);
        $where['Total'] = array('eq' ,$one['Status']);

        $roleID = Db::name('process_config')->where($where)->value('RoleID');

        $currentRoles = json_decode(session('user_base_info.role'),true);

        //dump($roleID);halt($currentRoles);

        if(!in_array($roleID ,$currentRoles)){

            return jsons('4005' ,'审批失败，请注意查看审核状态……');
        }

    }
}