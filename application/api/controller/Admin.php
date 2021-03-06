<?php

namespace app\api\controller;

use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
use think\Db;
use think\Debug;

/**
 * @title 房管员版的
 * @author Mr.Lu
 * @description
 */
class Admin extends Controller
{
    public function test()
    {
        // $roomid = input('roomid');
        // $houseid = input('houseid');
        // $str = '';
        // if($roomid){
        //     $roomRent = count_room_rent($roomid);
        //     $str .= '房间编号'.$roomid.'的计算租金：'.$roomRent.'元！';
        // }
        // if($houseid){
        //     $houseRent = count_house_rent($houseid);
        //     $str .= '房屋编号'.$houseid.'的计算租金：'.$houseRent.'元！';
        // }

        // halt($str);
        //以前年的欠款弄成订单
        //exit;
        $houses = Db::name('house')->where(['Status'=>1,'ArrearRent'=>['>',0]])->field('HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,BanAddress,ArrearRent,TenantID,TenantName')->select();
        $str = '';
        foreach($houses as $k => $v){
            $orderid = $v['HouseID'].$v['OwnerType'].'201701';
            $str .= "('" . $orderid . "','". $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
            $str .= "," . $v['ArrearRent'] . ",'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'];
            $str .= ",1," . $v['ArrearRent'] . "," . $v['ArrearRent'] . ",201712,2," . time() . "),";

        }

        $res = Db::execute("insert into ".config('database.prefix')."rent_order (RentOrderID,HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,OrderDate,Type,CreateTime) values " . rtrim($str, ','));

        if($res){
            halt(1);
        }

        // $hs = Db::name('house')->where('Status',1)->group('BanID')->column('BanID');

        // $banids = Db::name('ban')->where(['Status'=>1])->column('BanID');

        // $i = 0;
        // foreach($banids as $b){
        //     if(isset($arr[$b])){
        //         $c = isset($arr[$b]['CivilHolds'])?count($arr[$b]['CivilHolds']):0;
        //         $p = isset($arr[$b]['PartyHolds'])?count($arr[$b]['PartyHolds']):0;
        //         $e = isset($arr[$b]['EnterpriseHolds'])?count($arr[$b]['EnterpriseHolds']):0;
        //         Db::name('ban')->where('BanID',$b)->update(['CivilHolds'=>$c,'PartyHolds'=>$p,'EnterpriseHolds'=>$e]);
        //         ++$i;
                
        //     }
        // }
        // halt($i);
        //Db::name('ban')->field('BanID,')
    }


    /**
     *  注意，两个所，分别计算
     */
    public function config($ifPre = 1)
    {
        //重新生成租金配置时，先删除原配置
        Db::name('rent_config')->delete(true);

        $where['Status'] = array('eq', 1);    //房屋必须是可用状态
        $where['IfEmpty'] = array('eq', 0);    // 是否空租
        $where['IfSuspend'] = array('eq', 0);  // 是否暂停计租
        $where['InstitutionID'] = array('not in', [34, 35]);  //34为紫阳所私有，35为粮道所私有，不需要计算租金
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $houseData = Db::name('house')->field($fields)->where($where)->select();
 
        $changeData = Db::name('change_order')->where(['Status'=>1,'ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->select();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        foreach($changeData as $c){
            $changedata[$c['HouseID']] = $c;
        }

        $str = '';

        if ($ifPre == 1) { //使用规定租金

            foreach ($houseData as $v) {

                if ($v['AnathorHousePrerent'] > 0) {
                    $receiveRent = $v['AnathorHousePrerent'];  //应收租金，后期处理
                    $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
                    $str .= "," . $v['AnathorHousePrerent'] . ", 0, 0 '" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['AnathorOwnerType'] . "," . $v['UseNature'];
                    $str .= ",1," . $receiveRent . "," . $receiveRent . "," . 10000 . "," . time() . "),";
                }

                if(isset($changedata[$v['HouseID']])){
                    $cutType = $changedata[$v['HouseID']]['CutType'];
                    $cutRent = $changedata[$v['HouseID']]['InflRent'];
                }else{
                    $cutType = 0;
                    $cutRent = 0;
                }
                if(isset($rentData[$v['HouseID']])){
                    $historyUnpaidRent = $rentData[$v['HouseID']] + $v['ArrearRent'];
                }else{
                    $historyUnpaidRent = $v['ArrearRent'];
                }

                $receiveRent = $v['HousePrerent'] + $v['DiffRent'] + $v['PumpCost'] - $cutRent;

                $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
                $str .= "," . $v['HousePrerent'] . "," . $v['DiffRent'] . "," . $v['PumpCost'] . "," . $cutType . "," . $cutRent . ",'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'];
                $str .= ",1," . $receiveRent . "," . $receiveRent . "," . $historyUnpaidRent . "," . 10000 . "," . time() . "),";
            }
        } else { //使用计算租金
            return jsons('4002' ,'暂时无法配置计算租金');

        }

        $res = Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str, ','));

        Db::name('rent_config')->where(['ReceiveRent'=>0])->delete();

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    // public function api()
    // {
    //     $result = [];
    //     $where['type'] = 'PropertyReport';
    //     $where['date'] = 2017;
    //     // $data = Db::name('report')->where($where)->value('data');
    //     // $datas = json_decode($data,true); //array_keys($datas) 1,2,5,6,11(6不用了)
    //     //第二级 1 公司 2紫阳所 3粮道所
    //     $result[1][2] = [
    //         [85,37584.41,16,919.73,2,367.41],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [77,34089.98],
    //     ]; //市属，紫阳
    //     $result[1][3] = [
    //         [125,41389.7,17,919.3,9,929.85],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [125,41389.7],
    //     ]; //市属，粮道
    //     $result[1][1] = [
    //         [210,78974.11,33,1839.03,11,1297.26],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [202,75479.68],
    //     ]; //市属，公司
    //     $result[2][2] = [
    //         [1440,264765,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1440,251671.65],
    //     ]; //区属，紫阳
    //     $result[2][3] = [
    //         [1224,243266.96,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1222,242849.62],
    //     ]; //区属，粮道
    //     $result[2][1] = [
    //         [2664,508031.96,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [2662,494521.27],
    //     ]; //区属，公司
    //     $result[5][2] = [
    //         [190,117143.21,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [118,82748.63],
    //     ]; //自管，紫阳
    //     $result[5][3] = [
    //         [304,116288.58,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [298,114616.65],
    //     ]; //自管，粮道
    //     $result[5][1] = [
    //         [494,233431.79,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [416,197365.28],
    //     ]; //自管，公司
    //     $result[6][2] = [
    //         [52,13020.15,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [37,8778.80],
    //     ]; //自管，紫阳
    //     $result[6][3] = [
    //         [61,16124.05,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [42,8827.05],
    //     ]; //自管，粮道
    //     $result[6][1] = [
    //         [113,29144.20,0,0,0,0],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [79,17605.85],
    //     ]; //自管，公司
    //     $result[10][2] = [
    //         [1715,419492.62,16,919.73,2,367.41],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1635,368510.26],
    //     ]; //所有产别，紫阳
    //     $result[10][3] = [
    //         [1653,400945.24,17,919.3,9,929.85],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1645,398855.97],
    //     ]; //所有产别，粮道
    //     $result[10][1] = [
    //         [3368,820437.86,33,1839.03,11,1297.26],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [3280,767366.23],
    //     ]; //所有产别，粮道
    //     $result[11][2] = [
    //         [1767,432512.77,16,919.73,2,367.41],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1672,377289.06],
    //     ]; //所有产别，紫阳
    //     $result[11][3] = [
    //         [1714,417069.29,17,919.3,9,929.85],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [1687,407683.02],
    //     ]; //所有产别，粮道
    //     $result[11][1] = [
    //         [3481,849582.06,33,1839.03,11,1297.26],
    //         [0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [0,0,0,0,0,0,0,0],
    //         [3359,784972.08],
    //     ]; //所有产别，粮道
    //     Db::name('report')->where($where)->update(['data'=>json_encode($result)]);
    //     // halt($result);
    //     // halt($datas[1][3]);
    //     exit;
    //     // $find = Db::name('report')->where('id',52)->value('data');
    //     // $res = json_decode($find,true);

    //     // foreach($res as $p => $a){ //按1完损等级2使用性质3所属机构4建成年份5价值
    //     //     foreach($a as $k => $b){ // 按1市2区3代管自管7托管分  10 11 12
                
    //     //         foreach($b as $w => $c){ // 按机构
    //     //             foreach($c['data']['top'] as $r => $d){
    //     //                 $count = count($d);
    //     //                 //halt($i);
    //     //                 for($i= 0; $i < $count;$i++){
                            
    //     //                     if(!isset($res[$p][10][$w]['data']['top'][$r][$i])){
    //     //                         $res[$p]10][$w]['data']['top'][$r][$i] = 0;
    //     //                     }
    //     //                     if($i == 0){
    //     //                         $res[$p]10][$w]['data']['top'][$r][$i] =  $d[0];
    //     //                     }else{

    //     //                         $res[$p]10][$w]['data']['top'][$r][$i] += $d[$i];
    //     //                     } 

                             
    //     //                 }
    //     //             }

    //     //             $res[$p][$k][1]['data']['below'] = $res[$p][$k][2]['data']['below'] = $res[$p][$k][3]['data']['below'] = [];


    //     //         }


 
    //     //     }
    //     // }
    //     // //halt($res[1][1][2]);
    //     // //Db::name('report')->insert(['data'=>json_encode($res)]);
    //     // halt($res);

    // }

    public function old_api()
    {
        $result = [];
        $where['type'] = 'PropertyReport';
        $where['date'] = 2017;
        $data = Db::name('report')->where($where)->value('data');
        $datas = json_decode($data,true); //array_keys($datas) 1,2,5,6,11(6不用了)
        //第二级 1 公司 2紫阳所 3粮道所
        $result[1][2] = [
            [85,37584.41,16,919.73,2,367.41],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [77,34089.98],
        ]; //市属，紫阳
        $result[1][3] = [
            [125,41389.7,17,919.3,9,929.85],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [125,41389.7],
        ]; //市属，粮道
        $result[1][1] = [
            [210,78974.11,33,1839.03,11,1297.26],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [202,75479.68],
        ]; //市属，公司
        $result[2][2] = [
            [1440,264765,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [1440,251671.65],
        ]; //区属，紫阳
        $result[2][3] = [
            [1224,243266.96,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [1222,242849.62],
        ]; //区属，粮道
        $result[2][1] = [
            [2664,508031.96,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [2662,494521.27],
        ]; //区属，公司
        $result[5][2] = [
            [190,117143.21,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [118,82748.63],
        ]; //自管，紫阳
        $result[5][3] = [
            [304,116288.58,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [298,114616.65],
        ]; //自管，粮道
        $result[5][1] = [
            [494,233431.79,0,0,0,0],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [416,197365.28],
        ]; //自管，公司
        $result[11][2] = [
            [1715,419492.62,16,919.73,2,367.41],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [1635,368510.26],
        ]; //所有产别，紫阳
        $result[11][3] = [
            [1653,400945.24,17,919.3,9,929.85],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [1645,398855.97],
        ]; //所有产别，粮道
        $result[11][1] = [
            [3368,820437.86,33,1839.03,11,1297.26],
            [0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0],
            [3280,767366.23],
        ]; //所有产别，粮道
        //Db::name('report')->where($where)->update(['data'=>json_encode($result)]);
        // halt($result);
        // halt($datas[1][3]);
        exit;
        // $find = Db::name('report')->where('id',52)->value('data');
        // $res = json_decode($find,true);

        // foreach($res as $p => $a){ //按1完损等级2使用性质3所属机构4建成年份5价值
        //     foreach($a as $k => $b){ // 按1市2区3代管自管7托管分  10 11 12
                
        //         foreach($b as $w => $c){ // 按机构
        //             foreach($c['data']['top'] as $r => $d){
        //                 $count = count($d);
        //                 //halt($i);
        //                 for($i= 0; $i < $count;$i++){
                            
        //                     if(!isset($res[$p][10][$w]['data']['top'][$r][$i])){
        //                         $res[$p]10][$w]['data']['top'][$r][$i] = 0;
        //                     }
        //                     if($i == 0){
        //                         $res[$p]10][$w]['data']['top'][$r][$i] =  $d[0];
        //                     }else{

        //                         $res[$p]10][$w]['data']['top'][$r][$i] += $d[$i];
        //                     } 

                             
        //                 }
        //             }

        //             $res[$p][$k][1]['data']['below'] = $res[$p][$k][2]['data']['below'] = $res[$p][$k][3]['data']['below'] = [];


        //         }


 
        //     }
        // }
        // //halt($res[1][1][2]);
        // //Db::name('report')->insert(['data'=>json_encode($res)]);
        // halt($res);

    }

    public function api_old()
    {
        $find = Db::name('report')->where('id',46)->value('data');
        $res = json_decode($find,true);

        foreach($res as $p => $a){ //按1完损等级2使用性质3所属机构4建成年份5价值
            foreach($a as $k => $b){ // 按1市2区3代管自管7托管分
                //halt($b);
                foreach($b as $w => $c){ // 按机构
                    foreach($c['data']['top'] as $r => $d){
                        $count = count($d);
                        //halt($i);
                        for($i= 0; $i < $count;$i++){
                            if($w<19 && $w >2){ //紫阳所
                                if(!isset($res[$p][$k][2]['data']['top'][$r][$i])){
                                    $res[$p][$k][2]['data']['top'][$r][$i] = 0;
                                }
                                if($i == 0){
                                    $res[$p][$k][2]['data']['top'][$r][$i] =  $d[0];
                                }else{

                                    $res[$p][$k][2]['data']['top'][$r][$i] += $d[$i];
                                }  
                            }elseif($w>18){
                                if(!isset($res[$p][$k][3]['data']['top'][$r][$i])){
                                    $res[$p][$k][3]['data']['top'][$r][$i] = 0;
                                }
                                if($i == 0){
                                    $res[$p][$k][3]['data']['top'][$r][$i] =  $d[0];
                                }else{

                                    $res[$p][$k][3]['data']['top'][$r][$i] += $d[$i];
                                } 
                            }
                            if(!isset($res[$p][$k][1]['data']['top'][$r][$i])){
                                $res[$p][$k][1]['data']['top'][$r][$i] = 0;
                            }
                            if($i == 0){
                                $res[$p][$k][1]['data']['top'][$r][$i] =  $d[0];
                            }else{

                                $res[$p][$k][1]['data']['top'][$r][$i] += $d[$i];
                            } 

                             
                        }
                    }

                    $res[$p][$k][1]['data']['below'] = $res[$p][$k][2]['data']['below'] = $res[$p][$k][3]['data']['below'] = [];
                // $b[2] = $b[4] + $b[5] + $b[6] + $b[7] + $b[8] + $b[9] + $b[10] + $b[11] + $b[12] +$b[13] + $b[14] + $b[15] + $b[16] + $b[17] + $b[18];
                // $b[3] = $b[19] + $b[20] + $b[21] + $b[22] + $b[23] + $b[24] + $b[25] + $b[26] + $b[27] +$b[28] + $b[29] + $b[30] + $b[31] + $b[32] + $b[33];
                // $b[1] = $b[2] + $b[3];

                }
                // if($k == 2){
                //     $b[2] = $b[4] + $b[5];
                //     dump($b[4]);dump($b[5]);halt($b[2]);  
                // }
                
            }
        }
//halt($res[1][1][2]);
        //Db::name('report')->insert(['data'=>json_encode($res)]);
        halt($res);


        //halt(date('Y-m-d'));
        // $month = '2017';
        // $RentReport = Cache::store('file')->get('PropertyReport'.$month);
        // $row['data'] = $RentReport;
        // $row['type'] = '月租金报表'.$month;
        //Db::name('report')->insert($row);
        
        // id = 44的产权统计表
        // 一级：产别 1 2 5 6 11 市、区、自 、市代托、全部
        // 二级：机构 1 2 3 ,例如获取区属紫阳所的，如下：
        //$find = Db::name('report')->where('id',44)->value('data');$res = json_decode($find,true);halt($res[2][2]);
        
        // 一级：产别 1 2 3 5 7 10 11 12
        //  1 => '市属',
        // 2 => '区属',
        // 3 => '代管',
        // 5 => '自管',
        // 7 => '托管',
        // 10 => '市代托',
        // 11 => '市区代托',
        // 12 => '所有产别',
        // 二级：机构 1——33,例如获取区属紫阳01管段的，如下：
        //$find = Db::name('report')->where('id',14)->value('data');$res = json_decode($find,true);halt($res[2][4]);
        




        //halt($RentReport);
    }

    /**
     * 小程序主页接口【公告、应缴金额、已缴金额】
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }

            $notices = Db::name('notice')->field('id, Title,UpdateTime')->order('UpdateTime desc')->limit(10)->select();

            foreach ($notices as &$v) {
                $v['UpdateTime'] = date('Y/m/d', strtotime($v['UpdateTime']));
            }

            $result['notices'] = $notices;
            $result['rents'] = Db::name('rent_order')->where(['OrderDate' => date('Ym', time()), 'InstitutionID' => $findOne['InstitutionID']])->field('sum(ReceiveRent) as ReceiveRents, sum(PaidRent) as PaidRents')->find();
            return jsons('2000', '获取成功', $result);

        }
    }

    /**
     * 小程序获取单条公告详情的接口
     */
    public function noticeInfo()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }

            $notice = Db::name('notice')->where('id', $data['id'])->field('id, Title, UpdateTime, Content, Name')->find();

            if ($notice) {
                return jsons('2000', '获取成功', $notice);
            } else {
                return jsons('4005', '获取失败');
            }
        }
    }

    /**
     * 获取订单列表
     */
    public function orderList()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'OrderDate' => date('Ym', time()),
                'InstitutionID' => $findOne['InstitutionID'],
                'Type' => 1, //订单生成状态
            ];
            if (isset($data['TenantName']) && $data['TenantName']) {
                $where['TenantName'] = array('like','%'.$data['TenantName'].'%');
            }
            $rentList = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, OrderDate, ReceiveRent ,TenantName')
                ->paginate(config('paginate.list_rows'))
                ->toArray();

            foreach ($rentList['data'] as &$v) {
                $v['OrderDate'] = substr($v['OrderDate'], 0, 4) . '年' . substr($v['OrderDate'], 4, 2) . '月';
            }

            $rentList['total_page'] = ceil($rentList['total'] / $rentList['per_page']);
            return jsons('2000', '获取成功', $rentList);

        }
    }

    /**
     * 小程序支付页面生成二维码
     */
    public function nativeapi()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'InstitutionID' => $findOne['InstitutionID'],
                'RentOrderID' => $data['RentOrderID'],
                'Type' => 1,
            ];

            $orderInfo = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, TenantName, OrderDate, ReceiveRent')
                ->find();

            if (!$orderInfo) {
                return jsons('4005', '未知错误');
            }
            //halt($orderInfo);
            Loader::import('wxpay.WxPayNativePay', EXTEND_PATH);
            Loader::import('wxpay.log', EXTEND_PATH);

            $notify = new \NativePay();

            //模式二
            /**
             * 流程：
             * 1、调用统一下单，取得code_url，生成二维码
             * 2、用户扫描二维码，进行支付
             * 3、支付完成之后，微信服务器会通知支付成功
             * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
             */
            $wxPayConfig = new \WxPayConfig();
            $out_trade_no = $wxPayConfig::MCHID . date("YmdHis");
            $input = new \WxPayUnifiedOrder();
            $input->SetBody($orderInfo['TenantName']);
            $input->SetAttach($orderInfo['RentOrderID']); //自定义订单号参数
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($orderInfo['ReceiveRent'] * 100); //以1分钱为单位
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600)); //设置二维码过期时间10分钟
            $input->SetGoods_tag("goods_tag"); //设置商品标识
            $input->SetNotify_url("https://ph.ctnmit.com/api/Admin/orderQuery"); //设置回调地址
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id("123456789");

            $result = $notify->GetPayUrl($input);

            if (isset($result["code_url"])) {
                jsons('2000', '获取成功', ['url' => $result["code_url"], 'out_trade_no' => $out_trade_no, 'orderInfo' => $orderInfo]);
            } else {
                jsons('4000', '获取失败');
            }
        }
    }

    /**
     * 小程序订单支付状态查询功能【前端采用定时器访问该接口】
     */
    public function orderQuery()
    {
        Loader::import('wxpay.lib.WxPayApi', EXTEND_PATH);
        Loader::import('wxpay.log', EXTEND_PATH);

        $WxPayApi = new \WxPayApi();

        //用微信订单号来查询订单支付状态【暂时不用】
        if (isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != "") {
            $transaction_id = $_REQUEST["transaction_id"];
            $input = new \WxPayOrderQuery();
            $input->SetTransaction_id($transaction_id);
            //printf_info(WxPayApi::orderQuery($input));
            $result = $WxPayApi::orderQuery($input);
            echo $result['trade_state'];
            exit();
        }

        //用商户订单号来查询订单支付状态
        if (isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != "") {
            $out_trade_no = $_REQUEST["out_trade_no"];
            $input = new \WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);
            //printf_info(WxPayApi::orderQuery($input));
            $result = $WxPayApi::orderQuery($input);
            if ($result['trade_state'] == 'SUCCESS') {

                $type = Db::name('rent_order')->where('RentOrderID', $result['attach'])->value('Type');
                if ($type == 1) { //改变订单状态
                    $res = [
                        'PaidableTime' => strtotime($result['time_end']), //交易时间
                        'OpenID' => $result['openid'], //用户微信在商户中的唯一openid
                        'OutTradeNo' => $result['out_trade_no'], //商户订单号
                        'TransactionID' => $result['transaction_id'], //微信订单号
                        'PaidRent' => $result['total_fee'] / 100, //已支付
                        'UnpaidRent' => 0, //未支付
                        'Type' => 3, //修改状态为已支付状态
                    ];
                    Db::name('rent_order')->where('RentOrderID', $result['attach'])->update($res);
                }
            }
            return jsons('2000', '获取成功', ['trade_state' => $result['trade_state']]);
        }
    }

    /**
     * 小程序已缴且未打票的订单列表
     */
    public function orderNoTicketList()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'OrderDate' => date('Ym', time()),
                'InstitutionID' => $findOne['InstitutionID'],
                'IfBatchSign' => 0, //未打印订单
                'Type' => 3, //已缴费状态
            ];
            $rentList = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, OrderDate, ReceiveRent ,TenantName')
                ->paginate(config('paginate.list_rows'))
                ->toArray();

            foreach ($rentList['data'] as &$v) {
                $v['OrderDate'] = substr($v['OrderDate'], 0, 4) . '年' . substr($v['OrderDate'], 4, 2) . '月';
            }

            $rentList['total_page'] = ceil($rentList['total'] / $rentList['per_page']);
            return jsons('2000', '获取成功', $rentList);

        }
    }

    /**
     * 小程序订单打印详情信息
     */
    public function orderTicketInfo()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
        }
        $where = [
            'InstitutionID' => $findOne['InstitutionID'],
            'RentOrderID' => $data['RentOrderID'],
            'IfBatchSign' => 0,
            'Type' => 3,
        ];

        $orderInfo = Db::name('rent_order')->where($where)
            ->field('RentOrderID, BanAddress, TenantName, OrderDate, ReceiveRent')
            ->find();

        if ($orderInfo) {
            return jsons('2000', '获取成功', $orderInfo);
        } else {
            return jsons('4005', '订单信息有误');
        }

    }

    /**
     * 小程序订单打票返回标识接口
     */
    public function orderTicketChange()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
        }
        $where = [
            'InstitutionID' => $findOne['InstitutionID'],
            'RentOrderID' => $data['RentOrderID'],
            'Type' => 3,
        ];

        $flag = Db::name('rent_order')->where($where)->setField('IfBatchSign', 1);

        if ($flag) {
            return jsons('2000', '标记打印成功');
        } else {
            return jsons('4000', '标记打印失败');
        }
    }


}