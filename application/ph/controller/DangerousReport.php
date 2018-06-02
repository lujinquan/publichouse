<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Paginator;
use think\paginator\driver\Bootstrap;
use think\Db;

class DangerousReport extends Base
{
    public function index(){



        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->select();
        $nowMonth = date('Ym',time());

        //halt($data);

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['TubulationID'] =  $currentUserInstitutionID;
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = $currentUserInstitutionID;
        } else {   //用户为公司级别，则获取所有子管段
            $where['Status'] = 1;
        }
        $where['OwnerType'] = 1; //默认市属
        $dangerousOption = [];
        $dangerousOption['TubulationID'] = $currentUserInstitutionID;
        $dangerousOption['OwnerType'] = 1;
        $dangerousOption['month'] = $nowMonth;
        $searchForm = input('request.');
        //halt($searchForm);
        if (isset($searchForm['OwnerType'])) {
            $dangerousOption = $searchForm;
            $dangerousOption['TubulationID'] = $currentUserInstitutionID;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['TubulationID'] = $searchForm['TubulationID'];
                    if(isset($where['Status'])) unset($where['Status']);
                } elseif ($level == 2) {
                    $where['InstitutionID'] = $searchForm['TubulationID'];
                    if(isset($where['Status'])) unset($where['Status']);
                }
            }
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = $searchForm['OwnerType'];
            }
            if ($searchForm['month']) {  //检索年月
                $nowMonth = (int)str_replace('-','',$searchForm['month']);
            }
        }
//halt($where);

        $data = json_decode(Cache::store('file')->get('DangerousReport'.$nowMonth ,''),true);
        if ($data) {
            foreach($data as $key => &$value){
                if(isset($where['OwnerType']) && $value['OwnerType'] != $where['OwnerType']){

                    unset($data[$key]);
                }
                if(!isset($where['Status'])){
                    if(isset($where['TubulationID']) && $value['TubulationID'] != $where['TubulationID']){
                        unset($data[$key]);
                    }
                    if(isset($where['InstitutionID']) && $value['InstitutionID'] != $where['InstitutionID']){
                        unset($data[$key]);
                    }
                }
            }
        }else{
            $data = array();
        }
//halt($dangerousOption);
        $curpage = input('page') ? input('page') : 1;//当前第x页，有效值为：1,2,3,4,5...
        $listRow = config('paginate.list_rows');
        $showdata =  array_chunk($data,$listRow, true);
        //halt($showdata);
        if($showdata == array()){
            $showdata[0] = array();
        }
        $p = Bootstrap::make($showdata[$curpage-1], $listRow, $curpage, count($data), false, [
            'var_page' => 'page',
            'path'     => url('/ph/DangerousReport/index'),//这里根据需要修改url
            'query'    => [],
            'fragment' => '',
        ]);

        $p->appends($_GET);
        $this->assign('plist', $p);
        $this->assign('plistpage', $p->render());
        //halt($dangerousOption);
        $propertyOption = array();
        $this->assign([
            'dangerousOption' => $dangerousOption,
            'propertyOption' => $propertyOption,
            'owerLst' => $owerLst,   //产别
        ]);
        return $this->fetch();
    }

    public function index_copy(){

        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->select();

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }

        $where['OwnerType'] = 1; //默认市属

        $dangerousOption = [];

        $searchForm = input('request.');

        if (isset($searchForm['OwnerType'])) {

            $dangerousOption = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['month']) {  //检索年月
                $where['DamageChangeDate'] = array('<',(int)str_replace('-','',$searchForm['month']));
            }
        }
//halt($where);
        $where['a.Status'] = 1;

        $map = 'BanAddress ,BanUnitNum ,BanYear ,BanFloorNum ,b.DamageGrade ,TubulationID ,TotalArea ,PreRent ,Institution';

        $data['obj'] = Db::name('ban')->alias('a')
            ->join('ban_damage_grade b','a.DamageGrade = b.id','left')
            ->join('institution c','a.TubulationID = c.id','left')
            ->field($map)
            ->where('a.DamageGrade','in',[4,5])
            ->where($where)
            ->paginate(config('paginate.list_rows'));

        $data['arr'] = $data['obj']->all();

        $propertyOption = array();

        $this->assign([
            'data' => $data,
            'dangerousOption' => $dangerousOption,
            'propertyOption' => $propertyOption,
            'owerLst' => $owerLst,   //产别
        ]);
        return $this->fetch();
    }

    public function out(){

    }
}