<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Db;

class CorrectRecord extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__COR_CHANGE_ORDER__';

    public function get_all_record_lst(){

        //筛选出只属于当前机构的记录
        
        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if($currentUserLevel == 3){  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);

        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询

            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);

        }

        $ChangeList['option'] =array();

        if($searchForm = input('param.')) {

            foreach ($searchForm as &$val) { //去首尾空格
                $val = trim($val);
            }

            $ChangeList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                //dump($level);exit;
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if ($searchForm['ChangeOrderID']) {   //变更编号
                $where['ChangeOrderID'] = array('like', '%'.$searchForm['ChangeOrderID'].'%');
            }
            if ($searchForm['HouseID']) {  //检索房屋编号
                $where['HouseID'] = array('like', '%'.$searchForm['HouseID'].'%');
            }
            if ($searchForm['BanAddress']) {  //检索楼栋地址
                $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            }
            if ($searchForm['OwnerType']) {  //检索变更类型
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            
            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){

                $starttime = strtotime($searchForm['CreateTime']);

                $endtime = $starttime + 3600*24;

                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }
            

        }

        $where['Status'] = array('in' , [1,0]);

        $map='ChangeOrderID ,HouseID ,ChangeType ,OwnerType,OldTenantName,HouseUsearea,InstitutionID,BanAddress,HousePrerent,UserNumber ,CreateTime ,Status';

        $ChangeList['obj'] = self::field($map)->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $arr = $ChangeList['obj']->all();

        if(!$arr){

            $ChangeList['arr'] = array();
        }else{

            $owners = Db::name('ban_owner_type')->column('id,OwnerType');

            $ins = Db::name('institution')->column('id,Institution');

            // $types = Db::name('cor_change_type')->column('id,UseChangeTitle');

            $users = Db::name('admin_user')->column('Number,UserName');

            foreach($arr as $v){

                if($v['Status'] == 1){
                    $v['Status'] = '成功';
                }elseif($v['Status'] == 0){
                    $v['Status'] = '失败';
                }

                $v['UserNumber'] = $users[$v['UserNumber']];
                $v['OwnerType'] = $owners[$v['OwnerType']];
                // $v['ChangeType'] = $types[$v['ChangeType']];
                $v['InstitutionID'] = $ins[$v['InstitutionID']];
                $v['CreateTime'] = date('Y-m-d H:i:s',$v['CreateTime']);
                
                $ChangeList['arr'][] = $v;

            }
        }

        return $ChangeList;
    }

    public function get_one_change_info($id = '' ,$map=''){

        //使用权变更单号 ，房屋编号 ，变更类型 ，操作机构 ，操作人 ，操作时间 ，状态
        if(!$map) $map='ChangeOrderID ,HouseID ,ChangeType ,OwnerType,HouseUsearea,InstitutionID ,BanAddress,HousePrerent,UserNumber ,CreateTime ,Status';
        $data = Db::name('cor_change_order')->field($map)->where('id','eq',$id)->find();

        if(!$data){
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id' ,'eq' ,$data['InstitutionID'])->value('Institution');

        // $data['ChangeType'] = Db::name('use_change_type')->where('id','eq',$data['ChangeType'])->value('UseChangeTitle');

        if($data['Status'] == 1){
            $data['Status'] = '成功';
        }

        if($data['Status'] === 0){
            $data['Status'] = '失败';
        }

        //echo $data['Status'];exit;

        $data['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$data['UserNumber'])->value('UserName');

        $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);

        return $data;
    }
}