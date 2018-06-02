<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\paginator\driver\Bootstrap;
use think\Request;
use think\Db;

class InOutReport extends Base
{
    public function index(){

        //所有产别
        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->where('id','in',[3,7])->select();

        $institutionid = session('user_base_info.institution_id');
        $ownerType = 3;
        $date = date('Ym',time());

        $inoutReportOption = array();

        $searchForm = input('request.');
        if (isset($searchForm['OwnerType'])) {
            $inoutReportOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $institutionid = $searchForm['TubulationID'];
            }
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $ownerType = $searchForm['OwnerType'];
            }
            if ($searchForm['month']) {  //检索年月
                $date = str_replace('-','',$searchForm['month']);
            }
        }

        $datas = json_decode(Cache::store('file')->get('InOutReport'.$date ,''),true);

        $data = isset($datas[$ownerType][$institutionid])?$datas[$ownerType][$institutionid]:array();

        $this->assign([
            'arr' => [],
            'inoutReportOption' => $inoutReportOption,
            'owerLst' => $owerLst,
        ]);

        if ($data) {
            $curpage = input('page') ? input('page') : 1;//当前第x页，有效值为：1,2,3,4,5...
            $listRow = config('paginate.list_rows');
            $showdata =  array_chunk($data,$listRow, true);
            $p = Bootstrap::make($showdata[$curpage-1], $listRow, $curpage, count($data), false, [
                'var_page' => 'page',
                'path'     => url('/ph/InOutReport/index'),//这里根据需要修改url
                'query'    => [],
                'fragment' => '',
            ]);
            $p->appends($_GET);
            $this->assign([
                'arr' => $p->all(),
                'plist' => $p,
                'plistpage', $p->render(),
            ]);
        }
        
        return $this->fetch();
    }

    public function index_copy(){

        //所有产别
        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->where('id','in',[3,7])->select();

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['a.InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['a.InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }

        $inoutReportOption = array();

        $where['OrderDate'] = date('Ym',time());  //默认查询当月的订单
        $where['a.OwnerType'] = 3;

        $searchForm = input('request.');

        if (isset($searchForm['OwnerType'])) {

            $inoutReportOption = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                //$where['InstitutionID'] = array('eq', $searchForm['InstitutionID']);
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['a.InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['a.InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['a.OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['month']) {  //检索年月
                //$where['OrderDate'] = array('eq' ,str_replace('-','',$searchForm['month']));
            }
        }

        //halt($where);
        $dataObj = Db::name('rent_order')->alias('a')
            ->join('house b','a.HouseID = b.HouseID')
            ->join('institution c','a.InstitutionID = c.id','left')
            ->where($where)
            ->field('a.InstitutionID,a.TenantName,a.HousePrerent,b.HouseArea,b.BanAddress,a.HousePrerent,c.Institution')
            ->paginate(config('paginate.list_rows'));

        $arr = $dataObj->all();

        //halt($arr);
        foreach($arr as $key => &$value){

            $value['RepairCost'] = 0.2 * ($value['HousePrerent']);  //修理费是房租的20%
            $value['HandlerCost'] = 0.15 * ($value['HousePrerent']);  //管理费是房租的15%
            $value['Cost'] = 0.65 * ($value['HousePrerent']);  //金额是房租的65%
        }

        $this->assign([
            'dataObj' => $dataObj,
            'arr' => $arr,
            'inoutReportOption' => $inoutReportOption,
            'owerLst' => $owerLst,
        ]);
        return $this->fetch();
    }

    public function out(){

    }
}