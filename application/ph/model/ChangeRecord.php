<?php


namespace app\ph\model;

use think\Model;
use think\Db;
use util\Tree;

class ChangeRecord extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__CHANGE_ORDER__';

    public function get_all_record_lst(){

        //筛选出只属于当前机构的记录

        $where = [];

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

        if($changeorderid = input('get.')){
            //halt($changeorderid);
            if(isset($changeorderid['ChangeOrderID'])){
                $where['ChangeOrderID'] = array('like', '%'.$changeorderid['ChangeOrderID'].'%');
            }
        }

        $ChangeList['option'] =array();

        if($searchForm = input('param.')) {

            foreach ($searchForm as &$val) { //去收尾空格
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
            if (isset($searchForm['ChangeOrderID']) && $searchForm['ChangeOrderID']) {   //异动编号
                $where['ChangeOrderID'] = array('like', '%'.$searchForm['ChangeOrderID'].'%');
            }
            if (isset($searchForm['ChangeType']) && $searchForm['ChangeType']) {  //检索变更类型
                $where['ChangeType'] = array('eq', $searchForm['ChangeType']);
            }
            if (isset($searchForm['UserName']) && $searchForm['UserName']) {  //检索操作人名称
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
                $where['CreateTime'] = array('egt',$start);
            }
            if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
                $end = strtotime($searchForm['DateEnd']);
                $where['CreateTime'] = array('elt',$end);
            }

        }

        $where['Status'] = array('in' , [1,0]);

        //halt($where);

        $ChangeList['obj'] = self::field('id')->where($where)->paginate(config('paginate.list_rows'));//config('paginate.list_rows')

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
        $data = Db::name('change_order')->field($map)->where('id','eq',$id)->find();

        if(!$data){
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id' ,'eq' ,$data['InstitutionID'])->value('Institution');

        $data['ChangeType'] = Db::name('change_type')->where('id','eq',$data['ChangeType'])->value('ChangeType');
//halt($data['Status']);
        if($data['Status'] == 1){

            $data['Status'] = '通过';
        }else{
            $data['Status'] = '未通过';
        }

        // if($data['Status'] === 0){
            
            
        // }

        $data['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$data['UserNumber'])->value('UserName');

        $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);

        return $data;
    }

}