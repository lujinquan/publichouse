<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class RentCutReport extends Base
{
    public function index(){


        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->where('id','in',[1,3,7])->select();

        //初始条件
        $institutionid = session('user_base_info.institution_id');
        $ownerType = 1;
        $date = date('Ym',time());

        /*搜索条件*/
        $rentcutOption = array();
        $searchForm = input('request.');
        if (isset($searchForm['OwnerType'])) {
            $rentcutOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $institutionid = $searchForm['TubulationID'];
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {  //检索楼栋产别
                $ownerType = $searchForm['OwnerType'];
            }
            if (isset($searchForm['month']) && $searchForm['month']) {  //检索年月
                $date = str_replace('-','',$searchForm['month']);
            }
        }

        $datas = json_decode(Cache::store('file')->get('RentCutReport'.$date ,''),true);

        $data = $datas?$datas[$ownerType][$institutionid]:array();

        $this->assign([
            'data' => $data,
            'rentcutOption' => $rentcutOption,
            'owerLst' => $owerLst,   //产别
        ]);
        
        return $this->fetch();
    }

    public function index_copy(){

        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->where('id','in',[1,3,7])->select();
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['a.InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['a.InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }
        $nowDate = date('Ym',time());
        $oldDate = date('Ym',strtotime('-1 month'));
        $startDate = date('Y',time()).'00';

        /*初始化条件*/
        $where['CutType'] = array('neq',0);
        $where['b.OwnerType'] = array('eq', 1);
        $option['OrderDate'] = array('between',[$startDate,$oldDate]);
        $options['OrderDate'] = array('between',[$startDate,$nowDate]);

        /*搜索条件*/
        $rentcutOption = array();
        $searchForm = input('request.');
        if (isset($searchForm['OwnerType'])) {
            $rentcutOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['a.InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['a.InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['b.OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['month']) {  //检索年月
                $searchMonth = str_replace('-','',$searchForm['month']);
                $beginMonth = substr($searchForm['month'],0,4).'00';
                $newWhere['OrderDate'] = array('eq',$searchMonth);
                $oldWhere['OrderDate'] = array('eq',date('Ym',strtotime($searchForm['month']." - 1 month")));
                $option['OrderDate'] = array('between',[$beginMonth,date('Ym',strtotime($searchForm['month']." - 1 month"))]);
                $options['OrderDate'] = array('between',[$beginMonth,$searchMonth]);
            }
        }

        if(!isset($newWhere)){
            $newWhere['OrderDate'] = array('eq', $nowDate);
            $oldWhere['OrderDate'] = array('eq', $oldDate);
        }

        //halt($where);
        if (!isset($where)) {
            $where = 1;
        }
        //实际核减户数，使用面积，月规定租金，核减租金，已收租金，累计损失租金

        //dump($where);dump($newWhere);dump($oldWhere);dump($option);dump($options);exit;

        /*获取从查询的1月份到查询日期前一个月的累计减免*/
        $lastData = Db::name('rent_order')->alias('a')
            ->join('house b','a.HouseID = b.HouseID','left')
            ->field('count(a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
            ->where($where)
            ->where($option)
            ->find();
        /*获取从查询的1月份到查询日期的累计数据*/
        $totalData = Db::name('rent_order')->alias('a')
            ->join('house b','a.HouseID = b.HouseID','left')
            ->field('count(a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
            ->where($where)
            ->where($options)
            ->find();

        $oldData = Db::name('rent_order')->alias('a')
            ->join('house b','a.HouseID = b.HouseID','left')
            ->field('count(a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
            ->where($where)
            ->where($oldWhere)
            ->find();

        $newData = Db::name('rent_order')->alias('a')
            ->join('house b','a.HouseID = b.HouseID','left')
            ->join('ban c','b.BanID = c.BanID','left')
            ->field('count(a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
            ->where($where)
            ->where($newWhere)
            ->find();

        $this->assign([
            'lastData' => $lastData,
            'totalData' => $totalData,
            'oldData' => $oldData,
            'newData' => $newData,
            'rentcutOption' => $rentcutOption,
            'owerLst' => $owerLst,   //产别
        ]);

        return $this->fetch();
    }

    public function out(){

    }
}