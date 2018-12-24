<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class HouseReport extends Base
{

    public function index_old(){

        //主页面默认数据
        $institutionid = session('user_base_info.institution_id');
        $date = date('Ym',time());

        $datas = json_decode(Cache::store('file')->get('HouseReport'.$date ,''),true);
        $result = $datas?$datas[5][1][$institutionid]:array();

        if($datas){
            $result = $datas[5][1][$institutionid];
        }else{
            $result['top'] = 0;
            $result['below'] = 0;
        }

        $this->assign([
            'propertyOption' => [],
            'result' => $result['top'],
            'below' => $result['below'],
        ]);
        return $this->fetch();


    }
    

    public function index(){

        //主页面默认数据
        $where['Status'] = 1;
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['TubulationID'] = $currentUserInstitutionID;
            $where['OwnerType'] = 1;
        } elseif($currentUserLevel == 2){
            $where['InstitutionID'] = $currentUserInstitutionID;
            //return jsons('4000','数据核对期间，只能以房管员的账号来查看');
            $where['OwnerType'] = 1;
        }else{
            $where['OwnerType'] = 12;
        }
        $HouseIdList['option'] = array();
        if ($searchForm = input('post.')) {
            halt($searchForm);
            $HouseIdList['option'] = $searchForm;
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = $searchForm['OwnerType'];
            }
            // 2017年的房屋统计表直接读缓存数据
            if(substr($searchForm['month'],0,4) == '2017'){
                $data = Db::name('report')->where(['type'=>'HouseReport','date'=>2017])->value('data');
                $sdata = json_decode($data,true);
                $result = $sdata[$searchForm['QueryType']][$searchForm['OwnerType']][$searchForm['TubulationID']]; 

            // 不是2017年的就直接计算统计
            }else{
                $data = Db::name('report')->where(['type'=>'HouseReport','date'=>$searchForm['month']])->value('data');
                $sdata = json_decode($data,true);
                $result = $sdata[$searchForm['QueryType']][$searchForm['OwnerType']][$searchForm['TubulationID']];

                // switch($searchForm['QueryType']){
                //     case '1':
                //         $result['data'] = model('ph/HouseReports')->get_by_damage($where);
                //         break;
                //     case '2':
                //         $result['data'] = model('ph/HouseReports')->get_by_useNature($where);
                //         break;
                //     case '3';
                //         $result['data'] = model('ph/HouseReports')->get_by_institution($where);
                //         break;
                //     case '4':
                //         $result['data'] = model('ph/HouseReports')->get_by_year($where);
                //         break;
                //     case '5':
                //         $result['data'] = model('ph/HouseReports')->get_by_value($where);
                //         break;
                //     default:
                //         break;
                // }


            
            }
        }else{   //默认按价值查看
            $where = isset($where)?$where:0;
            //halt($where);
            $result = model('ph/HouseReports')->get_by_value($where);

            //$data = Db::name('report')->where(['type'=>'HouseReport','date'=>date('Ym',time())])->value('data');
            //$sdata = json_decode($data,true);
            //$result = $sdata[5][1][$currentUserInstitutionID];
            //halt($result['top']);
            $this->assign([
                'propertyOption' => [],
                'result' => $result['top'],
                'below' => $result['below'],
                //'result' => $result,
            ]);
        }
        $owerLst = [
            1 => '市属',
            2 => '区属',
            3 => '代管',
            5 => '自管',
            6 => '生活',
            7 => '托管',
            10 => '市代托',
            11 => '市区代托',
            12 => '所有产别',
        ];
        $propertyOption = array();

        $this->assign([
            'owerLst' => $owerLst,
            'propertyOption' => $propertyOption,
        ]);

        return $this->fetch();
    }

    public function out(){

    }
}