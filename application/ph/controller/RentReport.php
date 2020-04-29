<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class RentReport extends Base
{
    public function index(){

        $institutionid = session('user_base_info.institution_id');
        $ownerType = 1;               //默认查询产别为市属的数据
        $date = date('Ym',time());//默认查询时间为当前月的数据
        //$date = '202003';
        //提交检索条件处理
        $rentReportOption = array();
        if ($searchForm = input('post.')) {
            //halt($searchForm);
            $rentReportOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $institutionid = $searchForm['TubulationID'];
            }
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $ownerType = $searchForm['OwnerType'];
            }
            if ($searchForm['month']) {  //检索月份格式例如：2017-12
                $date = str_replace('-','',$searchForm['month']);
            }
        }
        $owerLst = [
            1 => '市属',
            2 => '区属',
            3 => '代管',
            5 => '自管',
            7 => '托管',
            10 => '市代托',
            11 => '市区代托',
            12 => '所有产别',
        ];
        $month = isset($rentReportOption['month'])?$rentReportOption['month']:date('Y-m',time());
        //$month = isset($rentReportOption['month'])?$rentReportOption['month']:'2020-03';
        //halt($date);
        //$month = isset($date)?$date:date('Ym',time());
// $find = Db::name('report')->where('id',20)->value('data');
// $datas = json_decode($find,true);
       // $datas = json_decode(Cache::store('file')->get('RentReport'.$date ,''),true);
        $dataJson = Db::name('report')->where(['type'=>'RentReport','date'=>$date])->value('data');
        $datas = json_decode($dataJson,true);
//halt($datas);
        //Cache::rm('RentReport201805');

        $result = isset($datas[$ownerType][$institutionid])?$datas[$ownerType][$institutionid]:array();

        //Cache::rm('RentReport201804');
        //halt($result);

        foreach ($result as &$ree) {
            foreach ($ree as &$rev) {
                if($rev === 0 || $rev === 0.00 || $rev === '0.00'){
                    $rev = '';
                }
            }
        }

        $this->assign([
            'rentReportOption' => $rentReportOption,
            'institutionid' =>$institutionid,
            'ownerType'=>$ownerType,
            'owerLst'=>$owerLst,
            'month' =>$month,
            'result' => $result,
        ]);

        return $this->fetch();
    }

    public function index_old(){

        //查询条件初始化
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }
        $where['OwnerType'] = array('eq',1);               //默认查询产别为市属的数据
        $where['OrderDate'] = array('eq',date('Ym',time()));//默认查询时间为当前月的数据


        //提交检索条件处理
        $rentReportOption = array();
        if ($searchForm = input('post.')) {
            $rentReportOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                //$where['InstitutionID'] = array('eq', $searchForm['InstitutionID']);
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['month']) {  //检索月份格式例如：2017-12
                $where['OrderDate'] = array('eq', str_replace('-','',$searchForm['month']));
            }
        }
        $where['UseNature'] = array('in','1,2,3'); //过滤掉可能出现的错误的使用性质信息

        //初始化基础数据
        $owerLst = $this->BanInfoModel->get_all_owner_type();

        //构造表格，需要的字段：房屋编号，规定租金，应收租金，实收租金，减免类型，减免金额，未缴金额
        $rentArray = Db::name('rent_order')->field('HouseID,HousePrerent,CutType,UseNature,CutRent,ReceiveRent,PaidRent,UnpaidRent')->where($where)->select();


        /*---------------------获取条件中的上月对应的数据---------(就是这一行数据：上期转结)-------*/
        $whereLastMonth = $where;
        //同时获取当前条件中的订单日期的上个月，用于计算上月转结数据
        //条件一样，只是日期是当前条件的上个月日期而已
        $whereLastMonth['OrderDate'][1] = getlastMonthDays($whereLastMonth['OrderDate'][1]);
        $rentArrayLastMonth = Db::name('rent_order')->field('HouseID,HousePrerent,UseNature')->where($whereLastMonth)->select();
        //以使用性质将数组分组
        if($rentArrayLastMonth == array()){
            $resultLast = array();
        }else{
            foreach ($rentArrayLastMonth as $k => $v) {
                $rentsLast[$v['UseNature']][] = $v;
            }
            //halt($rentsLast);
            $resultLast['totalHosuePrerentSum'] = 0;
            foreach ($rentsLast as $k0 => &$v0) {
                $housePrerents = array();
                foreach($v0 as $k1 => $v1){
                    $housePrerents[] = $v1['HousePrerent'];
                }
                $resultLast[0][$k0]['HousePrerentSum'] = array_sum($housePrerents);  //某个使用性质中的规定租金合计
                $resultLast['totalHosuePrerentSum'] += $resultLast[0][$k0]['HousePrerentSum'];   //所有使用性质的规定租金合计
            }

        }

        /*---------------------获取条件中的以前月份对应的数据---------(就是以前月这五列数据,排除上期结转这一行)-------*/
        $wherePastMonth = $where;
        $wherePastMonth['OrderDate'] = array('between',[substr($where['OrderDate'][1],0,4).'00',getlastMonthDays($where['OrderDate'][1])]);  //以前月就是查询的年份里面的查询月到1月之间的时间，如查询201711， 则以前年份为 201701至201710月
//        $beginMonth = $where['OrderDate'][1];
//        $str = substr($where['OrderDate'][1],0,4).'00';
//        halt($wherePastMonth);
        $rentArrayPastMonth = Db::name('rent_order')->field('HousePrerent,UseNature,ReceiveRent,PaidRent,UnpaidRent')->where($wherePastMonth)->select();
        //以使用性质将数组分组
        if($rentArrayPastMonth == array()){
            $resultPast = array();
        }else {
            foreach ($rentArrayPastMonth as $k5 => $v5) {
                $rentsPast[$v5['UseNature']][] = $v5;
            }
            //halt($rentsPast);
            $resultPast['totalHosuePrerentSum'] = 0;
            $resultPast['totalReceiveRentSum'] = 0;
            $resultPast['totalPaidRentSum'] = 0;
            foreach ($rentsPast as $k6 => &$v6) {
                $housePrerents = array();
                $receiveRents = array();
                $paidRents = array();
                foreach($v6 as $k7 => $v7){
                    $housePrerents[] = $v7['HousePrerent'];
                    $receiveRents[] = $v7['ReceiveRent'];
                    $paidRents[] = $v7['PaidRent'];
                }

                $resultPast[7][$k6]['HousePrerentSum'] = array_sum($housePrerents);  //某个使用性质中的规定租金合计
                $resultPast[13][$k6]['ReceiveRentSum'] = array_sum($receiveRents);    //某个使用性质中的应收租金合计
                $resultPast[14][$k6]['PaidRentSum'] = array_sum($paidRents);  //某个使用性质中的实收租金合计

                $resultPast['totalHosuePrerentSum'] += $resultPast[7][$k6]['HousePrerentSum'];   //所有使用性质的规定租金合计
                $resultPast['totalReceiveRentSum'] += $resultPast[13][$k6]['ReceiveRentSum'];  //所有使用性质的应收租金合计
                $resultPast['totalPaidRentSum'] += $resultPast[14][$k6]['PaidRentSum'];    //所有使用性质的实收租金合计
            }
//halt($resultPast);
        }

        /*---------------------获取条件中的以前月份对应的数据---------(就是以前月这五列数据,只是上期结转那一行上的)-------*/



        /*---------------------获取条件中的月份对应的数据---------(就是这三行数据：规定租金，应收租金，实收租金)-------*/
        if($rentArray == array()){  //如果该数组为空
            $result = array();
        }else{
            foreach ($rentArray as $k1 => $v1) {
                $rents[$v1['UseNature']][] = $v1;
            }

            $result['totalHosuePrerentSum'] = 0;
            $result['totalReceiveRentSum'] = 0;
            $result['totalPaidRentSum'] = 0;
            foreach ($rents as $k2 => &$v2) {
                $housePrerent = array();
                $receiveRent = array();
                $paidRent = array();
                foreach($v2 as $k3 => $v3){
                    $housePrerent[] = $v3['HousePrerent'];
                    $receiveRent[] = $v3['ReceiveRent'];
                    $paidRent[] = $v3['PaidRent'];
                }

                $result[7][$k2]['HousePrerentSum'] = array_sum($housePrerent);  //某个使用性质中的规定租金合计
                $result[13][$k2]['ReceiveRentSum'] = array_sum($receiveRent);    //某个使用性质中的应收租金合计
                $result[14][$k2]['PaidRentSum'] = array_sum($paidRent);  //某个使用性质中的实收租金合计

                $result['totalHosuePrerentSum'] += $result[7][$k2]['HousePrerentSum'];   //所有使用性质的规定租金合计
                $result['totalReceiveRentSum'] += $result[13][$k2]['ReceiveRentSum'];  //所有使用性质的应收租金合计
                $result['totalPaidRentSum'] += $result[14][$k2]['PaidRentSum'];    //所有使用性质的实收租金合计
            }


        }


        $this->assign([
            'rentReportOption' => $rentReportOption,
            'owerLst' => $owerLst,
            'resultLast' => $resultLast,
            'resultPast' => $resultPast,
            'result' => $result,
        ]);

        return $this->fetch();
    }

    //临时录入
    public function add(){

        if ($this->request->isPost()) {

            $datas = $this->request->post();
            $data = $datas['data'];

            //halt($data);
            $arr = array("上期结转","基数增减-合计","基数增减-新发租","基数增减-注销","基数增减-出售","基数增减-租金调整","基数增减-管段调整","规定租金","非基数增减-合计","非基数增减-减免","非基数增减-空租","非基数增减-停租","非基数增减-陈欠核销","应收租金","实收租金","实收累计","结欠租金");

            if(!$data[17]) return jsons('4001' ,'请选择产别');
            if(!$data[18]) return jsons('4002' ,'请选择机构');

            foreach($data as $key => $value){

                if($key==17 || $key==18 || !$value[0]) continue;

                $result[$key]['One'] = $value[0];
                $result[$key]['Two'] = $value[1];
                $result[$key]['Three'] = $value[2];
                $result[$key]['Four'] = $value[3];
                $result[$key]['Five'] = $value[4];
                $result[$key]['Six'] = $value[5];
                $result[$key]['Seven'] = $value[6];
                $result[$key]['Eight'] = $value[7];
                $result[$key]['Nine'] = $value[8];
                $result[$key]['Ten'] = $value[9];
                $result[$key]['ReportType'] = $key;
                $result[$key]['CreateDate'] = date('Ym',time());
                $result[$key]['CreateTime'] = time();

                $result[$key]['ReportTypeTitle'] = $arr[$key];
                $result[$key]['OwnerType'] = $data[17];
                $result[$key]['InstitutionID'] = $data[18];
                $result[$key]['InstitutionPID'] = Db::name('institution')->where('id','eq',$data[18])->value('Pid');

            }

            $re = Db::name('rent_report')->insertAll($result);

            if($re){
                return jsons('2000','添加成功');
            }else{
                return jsons('4000','添加失败');
            }

        }
    }

    public function out(){

    }
}