<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use app\user\model\LeaseAudit as LeaseAuditModel;
use think\Model;
use think\Exception;
use think\Db;

class LeaseRecord extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__LEASE_CHANGE_ORDER__';

    public function get_all_lease_lst(){

        //筛选出只属于当前机构的申请
        
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
        }

        $ChangeList['option'] =array();

        $where['Status'] = array('in' ,[0,1]);
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
            if (isset($searchForm['Status']) && $searchForm['Status'] !== '') {  //检索房屋状态
                $where['Status'] = array('eq', $searchForm['Status']);
            }
            
            // if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){
            //     $starttime = strtotime($searchForm['CreateTime']);
            //     $endtime = $starttime + 3600*24;
            //     $where['CreateTime'] = array('between',[$starttime,$endtime]);
            // }
            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){

                $c = substr_count($searchForm['CreateTime'],'-');
                
                $starttime = strtotime($searchForm['CreateTime']);

                if($c == 2){
                    $endtime = $starttime + 3600*24;
                }elseif($c == 1){
                    $endtime = $starttime + 3600*24*30;
                }else{
                    $endtime = $starttime + 3600*24*365;
                }             

                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }

        }

        $fields = 'id,ChangeOrderID ,ProcessConfigType,HouseID ,TenantName,BanAddress, OwnerType,FloorNum,FloorID, StructureType, InstitutionID ,PrintTimes,PrintTime,CreateTime ,Status';
        
//halt($where);
        $ChangeList['obj'] = self::field($fields)->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $arr = $ChangeList['obj']->all();

        if(!$arr){

            $ChangeList['arr'] = array();
        }
        //$datas = $ChangeList['obj']->toArray();
        //halt($ChangeList['obj']->toArray());
        $datas = [];
        foreach($arr as &$v){
            $row = Db::name('house')->field('TenantName,Status')->where('HouseID','eq',$v['HouseID'])->find();
            if($row){
                if($row['TenantName'] != $v['TenantName']){
                    $v['HouseStatus'] = 100;
                }else{
                    $v['HouseStatus'] = $row['Status'];
                }
                

            }
            $v['InstitutionID'] = config('insts')[$v['InstitutionID']];
        
            $v['Status'] = $v['Status']?'成功':'失败';
     
            $v['OwnerType'] = config('owners')[$v['OwnerType']];
            $v['StructureType'] = config('structs')[$v['StructureType']];
            $v['PrintTime'] =  $v['PrintTime']?date('Y-m-d H:i:s' ,$v['PrintTime']):'';
            $v['CreateTime'] = date('Y-m-d' ,$v['CreateTime']);
            
        }
       

        $ChangeList['arr'] = $arr;
        //self::get_one_change_info($datas);
        //halt($datas);

        //halt($ChangeList['option']);
        return $ChangeList;
    }

//     public function get_one_change_info($id = '' ,$map=''){
// //halt(config('owners')[1]);
//         if(!$map) $map='a.ChangeOrderID ,a.ProcessConfigType,a.HouseID ,a.TenantName,a.BanAddress, a.OwnerType,a.FloorNum,a.FloorID, a.StructureType, a.InstitutionID ,a.PrintTimes,a.PrintTime,a.CreateTime ,a.Status,b.Status as HouseStatus';
//         $data = Db::name('lease_change_order')->alias('a')->join('house b','a.HouseID = b.HouseID','left')->field($map)->where('id','in',$id)->select();
// //halt($data);
//         if(!$data){
//             return array();
//         }

//         $data['InstitutionID'] = config('insts')[$data['InstitutionID']];
        
//         $data['Status'] = $data['Status']?'成功':'失败';
 
//         $data['OwnerType'] = config('owners')[$data['OwnerType']];
//         $data['StructureType'] = config('structs')[$data['StructureType']];
//         $data['PrintTime'] =  $data['PrintTime']?date('Y-m-d H:i:s' ,$data['PrintTime']):'';
//         $data['CreateTime'] = date('Y-m-d' ,$data['CreateTime']);
// //halt($data);
//         return $data;
//     }

}