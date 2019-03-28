<?php


namespace app\ph\model;

use think\Model;
use think\Db;
use util\Tree;

class RentCut extends Model
{

    // 设置当前模型对应的完整数据表名称
    //protected $table = '__RENT_CUT_ORDER__';

    public function get_all_cut_lst()
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);

        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询

            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);

        } else {    //用户为公司级别，则获取所有子管段

        }

        $RentCutList['option'] = array();

        $searchForm = input('param.');

        foreach ($searchForm as &$val) { //去首尾空格
            $val = trim($val);
        }
        if (count($searchForm) > 4 && isset($searchForm['CutType'])) {

            $RentCutList['option'] = $searchForm;

            // if (isset($searchForm['InstitutionID']) && $searchForm['InstitutionID']) {   //检索机构

            //     $level = Db::name('institution')->where('id','eq',$searchForm['InstitutionID'])->value('Level');

            //     if($level == 3) {
            //         $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
            //     }elseif($level == 2){
            //         $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
            //     }
            // }
            if ($searchForm['CutType']) {   //检索产别
                $where['CutType'] = array('eq', $searchForm['CutType']);
            }
            if ($searchForm['MuchMonth']) {   //检索产别
                $where['MuchMonth'] = array('eq', $searchForm['MuchMonth']);
            }

            if ($searchForm['TenantID']) {  //模糊检索租户编号
                $where['TenantID'] = array('like', '%' . $searchForm['TenantID'] . '%');
            }
            if ($searchForm['HouseID']) {  //模糊检索租户编号
                $where['HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
            }
            // if ($searchForm['BanAddress']) {  //模糊检索楼栋地址
            //     $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            // }
            if ($searchForm['IDnumber']) {  //减免证件号码
                $where['IDnumber'] = array('like', '%' . $searchForm['IDnumber'] . '%');
            }

            // if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
            //     $start = $searchForm['DateStart'];
            //     $end = $searchForm['DateEnd'];
            //     //dump($start);dump($end);exit;
            //     if($start < $end){
            //         $where['BanYear'] = array('between',$start.",".$end);
            //     }
            // }
            // if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
            //     $start = $searchForm['DateStart'];
            //     //dump($start);exit;
            //     $where['BanYear'] = array('egt',$start);
            // }
            // if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
            //     $end = $searchForm['DateEnd'];
            //     $where['BanYear'] = array('elt',$end);
            // }

        }

        //$where['Startline'] = array('>', 197001);
        $where['a.Status'] = array('in', [0, 1]);
        //halt($where);

        $RentCutList['obj'] = Db::name('change_order')->alias('a')->join('rent_cut_order b','a.ChangeOrderID = b.ChangeOrderID','inner')->field('a.ChangeOrderID,a.CutType,a.TenantID,a.HouseID,b.IDnumber,MuchMonth')->where($where)->paginate(config('paginate.list_rows'));

        $RentCutList['arr'] = $RentCutList['obj']->all() ? $RentCutList['obj']->all() : array();

        return $RentCutList;
    }
}