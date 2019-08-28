<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Loader;
use think\Db;

class LeaseApply extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__LEASE_CHANGE_ORDER__';

    public function get_all_lease_lst($flag = ''){

        //筛选出只属于当前机构的申请
        
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
        }

        $where['Status'] = array('not in' ,[0,1]);

        if($flag == ''){
            $roleid = json_decode(session('user_base_info.role'));

            switch($roleid[0]){
                case 112:
                    $where['Status'] = array('eq',6);
                break;
                case 116:
                    $where['Status'] = array('eq',2);
                break;
                case 111:
                    $where['Status'] = array('eq',3);
                break;
                case 563:
                    $where['Status'] = array('eq',4);
                break;
                case 101:
                    $where['Status'] = array('eq',5);
                break;
                default:
                break;
            }
        }

        

        $ChangeList['option'] =array();
        if($searchForm = input('param.')) {
            foreach ($searchForm as &$val) { //去首尾空格
                $val = trim($val);
            }


            $ChangeList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {  //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //检索房屋编号
                $where['HouseID'] = array('like', '%'.$searchForm['HouseID'].'%');
            }
            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //检索租户姓名
                $where['TenantName'] = array('like', '%'.$searchForm['TenantName'].'%');
            }
            if (isset($searchForm['BanAddress']) && $searchForm['BanAddress']) {  //检索楼栋地址
                $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            }
            if (isset($searchForm['if_show']) && $searchForm['if_show']) {  //检索楼栋地址
                if($searchForm['if_show'] == 1){
                    $where['PrintTime'] = array('>', 0);
                }else{
                    $where['PrintTime'] = array('eq', 0);
                }
                //$where['BanAddress'] = array('like', '%'.$searchForm['if_show'].'%');
            }
            if (isset($searchForm['admin_is']) && $searchForm['admin_is']) {  //检索楼栋地址
               
                switch($searchForm['admin_is']){
                    case 112:
                        $where['Status'] = array('eq',6);
                    break;
                    case 116:
                        $where['Status'] = array('eq',2);
                    break;
                    case 111:
                        $where['Status'] = array('eq',3);
                    break;
                    case 563:
                        $where['Status'] = array('eq',4);
                    break;
                    case 101:
                        $where['Status'] = array('eq',5);
                    break;
                    default:
                        $where['Status'] = array('not in' ,[0,1]);
                    break;
                }
               
            }
            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){
                $starttime = strtotime($searchForm['CreateTime']);
                $endtime = $starttime + 3600*24;
                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }
        }

        //halt($searchForm); 

        $ChangeList['obj'] = self::field('id')->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $idsWhere = $where;
        $idsWhere['PrintTime'] = array('>', 0);
        //halt($idsWhere);
        $ChangeList['ids'] = self::where($idsWhere)->value('count(id) as ids');
        $arr = $ChangeList['obj']->all();

        if(!$arr){

            $ChangeList['arr'] = array();
        }

        //halt($arr);

        foreach($arr as $v){

            $ChangeList['arr'][] = self::get_one_change_info($v['id']);

        }

        //halt($ChangeList['arr']);
        return $ChangeList;
    }

    public function get_one_change_info($id = '' ,$map=''){

        if(!$map) $map='ChangeOrderID ,ProcessConfigType,HouseID ,TenantName,BanAddress, OwnerType,FloorNum,FloorID, StructureType, InstitutionID ,PrintTimes,PrintTime,CreateTime ,Status';
        $data = $this->field($map)->where('id','eq',$id)->find();

        if(!$data){
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id' ,'eq' ,$data['InstitutionID'])->value('Institution');
        
        //$data['StatusValue'] = $data['Status'];
        
        $re = $this->order_config_detail($data['ProcessConfigType'],$data['Status']);

        $data['Status'] = '待'.$re['RoleName'].$re['Title'];

        $data['ProcessRoleID'] = $re['RoleID'];

        $data['OwnerType'] = get_owner($data['OwnerType']);
        $data['StructureType'] = get_structure($data['StructureType']);
        $data['PrintTime'] =  $data['PrintTime']?date('Y-m-d H:i:s' ,$data['PrintTime']):'';
        $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);

        return $data;
    }


    /**
     * @title 获取租户信息
     * @author Mr.Lu
     * @param  $changeOrderID  变更编号
     * @param  $status  主订单状态
     * @return array [ RoleName  下一步操作的角色名称 ， Title  下一步操作的步骤标题 ]
     */
    public function order_config_detail($processid ,$status){

        $config = Db::name('process_config')->where('id','eq',$processid)->field('id ,Total')->find();

        $maps['pid'] = array('eq',$config['id']);
        $maps['Total'] = array('eq',$status);

        $res = Db::name('process_config')->where($maps)->field('RoleName ,Title ,RoleID')->find();

        return $res;
    }

    public function order_config($changeOrderID ){
        $config = Db::name('use_change_order')->alias('a')
            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
            ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
            ->value('Total');

        return $config;
    }

    /**
     * 检查是否可执行修改使用权变更
     * @description  当，已补充资料后
     * @author Mr.Lu
     * @return bool
     */
    public function check_edit($changeOrderID){

        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        if($status != 2){

            return false;
        }

        return true;
    }

    /**
     * 检查是否可执行删除使用权变更
     * @description  当，最后被确定为不通过的时候 ,或 ，还未补充资料的时候
     * @author Mr.Lu
     * @return bool
     */
    public function check_delete($changeOrderID){

        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        if($status == 0  || $status == 2){

            return true;
        }

        return false;
    }

    public function uploads($file,$k1){

        $title = config($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/changeOrder/'); //设置保存的路径
        $fileUpload->set('maxsize',5*1024*1024); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            return jsons('4003' ,$fileUpload->getErrorMsg());
            //return jsons('4003' ,'上传失败');

        }else{  //上传成功

            //多文件上传，遍历操作
            $names = $fileUpload->getFileName();

            foreach($names as $k => $v){

                $data['FileUrl']= '/uploads/changeOrder/'.$v;          //写入到数据库中的地址和存放地址 $targetPath 不一样
                $data['FileTitle'] = $title;                  
                $data['FileType'] = 1;        //图片类型
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

}