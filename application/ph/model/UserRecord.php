<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Db;

class UserRecord extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__USE_CHANGE_ORDER__';

    public function get_all_record_lst(){

        //筛选出只属于当前机构的记录
        
        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if($currentUserLevel == 3){  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);

        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询

            $allInstitution = Db::name('institution')->field('id ,Institution,pid')
                                                     ->where('pid','eq',$currentUserInstitutionID)
                                                     ->select();


            foreach($allInstitution as $key => $value){

                $arrs[] = $value['id']; //保存所有子管段id
            }

            $where['InstitutionID'] = array('in' ,$arrs);

        }else{    //用户为公司级别，则获取所有子管段

         

        }

        $ChangeList['option'] =array();

        if($searchForm = input('post.')) {

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
            if ($searchForm['ChangeType']) {  //检索变更类型
                $where['ChangeType'] = array('eq', $searchForm['ChangeType']);
            }
            if ($searchForm['UserName']) {  //检索操作人姓名
                $where['UserName'] = array('like', '%'.$searchForm['UserName'].'%');
            }

            if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
                $start = strtotime($searchForm['DateStart']);
                $end = strtotime($searchForm['DateEnd']);
                //dump($start);dump($end);exit;
                if($start < $end){
                    $where['CreateTime'] = array('between',$start.",".$end);
                }
            }
            if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
                $start = strtotime($searchForm['DateStart']);
                //dump($start);exit;
                $where['CreateTime'] = array('egt',$start);
            }
            if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
                $end = strtotime($searchForm['DateEnd']);
                $where['CreateTime'] = array('elt',$end);
            }


        }

        $where['Status'] = array('in' , [1,0]);

        $ChangeList['obj'] = self::field('id')->where($where)->paginate(config('paginate.list_rows'));

        //dump($HouseIdList['obj']);exit;

        $arr = $ChangeList['obj']->all();

        if(!$arr){

            $ChangeList['arr'] = array();
        }

        foreach($arr as $v){

            $ChangeList['arr'][] = self::get_one_change_info($v['id']);

        }

        return $ChangeList;
    }

    public function get_one_change_info($id = '' ,$map=''){

        //使用权变更单号 ，房屋编号 ，变更类型 ，操作机构 ，操作人 ，操作时间 ，状态
        if(!$map) $map='ChangeOrderID ,HouseID ,ChangeType ,InstitutionID ,UserNumber ,CreateTime ,Status';
        $data = Db::name('use_change_order')->field($map)->where('id','eq',$id)->find();

        if(!$data){
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id' ,'eq' ,$data['InstitutionID'])->value('Institution');

        switch($data['ChangeType']){
            case 1:
                $data['ChangeType'] = '更名';
                break;
            case 2:
                $data['ChangeType'] = '过户';
                break;
            case 3:
                $data['ChangeType'] = '赠予';
                break;
            case 4:
                $data['ChangeType'] = '转让';
                break;
            default:
                break;
        }

        //echo $data['Status'];


        if($data['Status'] === 1){
            $data['Status'] = '通过';
        }

        if($data['Status'] === 0){
            $data['Status'] = '未通过';
        }

        //echo $data['Status'];exit;

        $data['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$data['UserNumber'])->value('UserName');

        $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);

        return $data;
    }
}