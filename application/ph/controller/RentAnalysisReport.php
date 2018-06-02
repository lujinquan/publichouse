<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class RentAnalysisReport extends Base
{

    public function index(){
        //所有产别
        $owerLst = Db::name('ban_owner_type')->field('id,OwnerType')->where('id','in',[1,3,7])->select();

        //初始条件
        $institutionid = session('user_base_info.institution_id');
        $ownerType = 1;
        $date = date('Ym',time());

        /*搜索条件*/
        $rentAnalysisReportOption = array();
        $searchForm = input('request.');
        if (isset($searchForm['OwnerType'])) {
            $rentAnalysisReportOption = $searchForm;
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

        $datas = json_decode(Cache::store('file')->get('RentAnalysisReport'.$date ,''),true);

        $data = isset($datas[$ownerType][$institutionid])?$datas[$ownerType][$institutionid]:array();

        $this->assign([
            'data' => $data,
            'ownerType' =>$ownerType,
            'institutionid' =>$institutionid,
            'rentAnalysisReportOption' => $rentAnalysisReportOption,
            'owerLst' => $owerLst,   //产别
        ]);

        return $this->fetch();
    }

    //年计划录入
    public function add(){
        if ($this->request->isPost()) {
            $datas = $this->request->post();

            $data = $datas['data'];
            foreach($data as $key => $value){

                if(!$value['1']) continue;

                $result[$key]['InstitutionID'] = $value[0];
                $result[$key]['YearPlan'] = $value[1];
                $result[$key]['EnterprisePlan'] = $value[2];
                $result[$key]['PartyPlan'] = $value[3];
                $result[$key]['CivilPlan'] = $value[4];

                $result[$key]['Year'] = date('Y',time());

                $result[$key]['CreateUserID'] = UID;
                $result[$key]['CreateTime'] = time();

                $where['InstitutionID'] = $value[0];
                $where['Year'] = date('Y',time());

                $id = Db::name('rent_plan')->where($where)->value('id');

                if($id){
                    Db::name('rent_plan')->delete($id);
                }
            }

            if(!isset($result)) return jsons('4001','录入信息不能为空……');

            if(Db::name('rent_plan')->insertAll($result)){
                return jsons('2000' ,'录入成功');
            }else{
                return jsons('4000' ,'录入失败');
            }
        }
    }

    public function out(){

    }
}