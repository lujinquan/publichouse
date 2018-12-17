<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Config;
use think\Exception;
use think\Db;
use think\Loader;

class HouseReport extends Model
{
    public function index()
    {


        $instLst = Db::name('institution')->column('id');
        $ownerLst = [1,2,3,5,7];
        
        for ($i = 1;$i < 6; $i++) {
            foreach ($ownerLst as $owner) {
                foreach ($instLst as $ins) {



                    $where = array();
                    $belowWhere = array();

                    $where['Status'] = array('eq', 1);
                    $belowWhere['Status'] = array('eq', 1);
                    $belowWhere['UseNature'] = array('in', [1,2,3]);
                    $where['OwnerType'] = array('eq', $owner);
                    $belowWhere['OwnerType'] = array('eq', $owner);
                    if($ins == 2 || $ins == 3){
                        $where['InstitutionID'] = $ins;
                        $belowWhere['InstitutionPID'] = $ins;
                    }elseif($ins > 3){
                        $where['TubulationID'] = $ins;
                        $belowWhere['InstitutionID'] = $ins;
                    }

                    $below = Db::name('house')->where($belowWhere)->group('UseNature')->column('UseNature ,count(HouseID) as HouseIDS'); //底部的户数统计

                    switch ($i) {
                        case 1:
                            $results[1][$owner][$ins]['top'] = model('ph/HouseReport')->get_by_damage($where);
                            $results[1][$owner][$ins]['below'] = $below;
                            break;
                        case 2:
                            $results[2][$owner][$ins]['top'] = model('ph/HouseReport')->get_by_useNature($where);
                            $results[2][$owner][$ins]['below'] = $below;
                            break;
                        case 3;
                            $results[3][$owner][$ins]['top'] = model('ph/HouseReport')->get_by_institution($where);
                            $results[3][$owner][$ins]['below'] = $below;
                            break;
                        case 4:
                            $results[4][$owner][$ins]['top'] = model('ph/HouseReport')->get_by_year($where);
                            $results[4][$owner][$ins]['below'] = $below;
                            break;
                        case 5:
                            $results[5][$owner][$ins]['top'] = model('ph/HouseReport')->get_by_value($where);
                            $results[5][$owner][$ins]['below'] = $below;
                            break;
                        default:  //默认按
                            break;
                    }
                }
            }
        }



        return $results;
    }

    public function get_by_damage($where){

        $structureTypes = Db::name('ban_structure_type')->column('id,StructureType');

        //$k = 1 ,2 ,3 ,4 ,5 ,6 ,7 分别表示结构等级为 钢混 ，砖木三等 ，砖木二等 ，砖混一等 ，砖混二等 ，砖木一等 ，简易
        foreach($structureTypes as $k1 => $v1){
            //$i = 1 ,2 ,3 ,4 ,5 分别表示完损等级为 完好 ，基本 ，一般 ，严重 ，危险
            for($i = 1; $i<6; $i++){

                $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                    ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(TotalArea) as TotalAreas ')
                    ->where($where)
                    ->where(['StructureType'=>$k1,'DamageGrade'=>$i])
                    ->find();  //计算每一个（结构等级，使用性质）的结果集

                foreach ($datas[$k1][$i] as &$v2) {  //保证每个结果的值不为null ，避免报错
                    if(!$v2){$v2 = 0;}
                }

                $datas[$k1][$i]['StructureTypeName'] = $v1;

            }
        }

        // 将$v5[0],用作计算左侧合计部分
        $totalTotalAreas = 0;
        foreach ($datas as $k5 => &$v5) {
            $v5[0]['BanIDS'] = $v5[1]['BanIDS'] + $v5[2]['BanIDS'] + $v5[3]['BanIDS'] + $v5[4]['BanIDS'] + $v5[5]['BanIDS'];
            $v5[0]['TotalHouseholds'] = $v5[1]['TotalHouseholds'] + $v5[2]['TotalHouseholds'] + $v5[3]['TotalHouseholds'] + $v5[4]['TotalHouseholds'] + $v5[5]['TotalHouseholds'];
            $v5[0]['TotalAreas'] = $v5[1]['TotalAreas'] + $v5[2]['TotalAreas'] + $v5[3]['TotalAreas'] + $v5[4]['TotalAreas'] + $v5[5]['TotalAreas'];
            //halt($v5[0]['TotalAreas']);

            if($v5[0]['TotalAreas']){  //排除分母为0的情况
                $datas[$k5][1]['Percent'] = round($datas[$k5][1]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][2]['Percent'] = round($datas[$k5][2]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][3]['Percent'] = round($datas[$k5][3]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][4]['Percent'] = round($datas[$k5][4]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][5]['Percent'] = round($datas[$k5][5]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
            }else{
                $datas[$k5][1]['Percent'] = 0;
                $datas[$k5][2]['Percent'] = 0;
                $datas[$k5][3]['Percent'] = 0;
                $datas[$k5][4]['Percent'] = 0;
                $datas[$k5][5]['Percent'] = 0;
            }

            $totalTotalAreas += $v5[0]['TotalAreas'];
        }

        foreach ($datas as $k6 => $v6) {

            if($totalTotalAreas){
                $datas[$k6][0]['Percent'] = round($datas[$k6][0]['TotalAreas'] / $totalTotalAreas ,4) * 100;
            }else{
                $datas[$k6][0]['Percent'] = 0;
            }

            for($j = 0; $j <6; $j++){
                $total['banidsArr'][$j][] = $datas[$k6][$j]['BanIDS'];
                $total['householdsArr'][$j][] = $datas[$k6][$j]['TotalHouseholds'];
                $total['areasArr'][$j][] = $datas[$k6][$j]['TotalAreas'];
            }

        }

        // $total为最下面的合计部分
        foreach ($total as $k3 => $v3) {  //最下面的合计
            foreach ($v3 as $k4 => $v4) {
                $total[$k3][$k4] = array_sum($v4);
            }
        }

        //将两个数组整合成一个数组，便于前端遍历显示
        foreach ($datas as $k7 => $v7) {
            ksort($v7);
            foreach ($v7 as $k8 => $v8) {
                foreach ($v8 as $k9 => $v9) {
                    if($k9 == 'StructureTypeName') continue;
                    $result[$k7][] = $v9;
                }
            }
            array_unshift($result[$k7] ,$v7[1]['StructureTypeName']);
        }

        $result[0][0] = '合计';
        $result[0][1] = $total['banidsArr'][0];
        $result[0][2] = $total['householdsArr'][0];
        $result[0][3] = $total['areasArr'][0];
        $result[0][4] = 100;
        $result[0][5] = $total['banidsArr'][1];
        $result[0][6] = $total['householdsArr'][1];
        $result[0][7] = $total['areasArr'][1];
        $result[0][8] = $totalTotalAreas?round($total['areasArr'][1] / $totalTotalAreas ,4) * 100:0;
        $result[0][9] = $total['banidsArr'][2];
        $result[0][10] = $total['householdsArr'][2];
        $result[0][11] = $total['areasArr'][2];
        $result[0][12] = $totalTotalAreas?round($total['areasArr'][2] / $totalTotalAreas ,4) * 100:0;
        $result[0][13] = $total['banidsArr'][3];
        $result[0][14] = $total['householdsArr'][3];
        $result[0][15] = $total['areasArr'][3];
        $result[0][16] = $totalTotalAreas?round($total['areasArr'][3] / $totalTotalAreas ,4) * 100:0;
        $result[0][17] = $total['banidsArr'][4];
        $result[0][18] = $total['householdsArr'][4];
        $result[0][19] = $total['areasArr'][4];
        $result[0][20] = $totalTotalAreas?round($total['areasArr'][4] / $totalTotalAreas ,4) * 100:0;
        $result[0][21] = $total['banidsArr'][5];
        $result[0][22] = $total['householdsArr'][5];
        $result[0][23] = $total['areasArr'][5];
        $result[0][24] = $totalTotalAreas?round($total['areasArr'][5] / $totalTotalAreas ,4) * 100:0;
        //halt($result);

        return $result;
    }

    public function get_by_useNature($where){  //右侧的顺序是住宅，企业，机关

        $structureTypes = Db::name('ban_structure_type')->column('id,StructureType');

        //$k = 1 ,2 ,3 ,4 ,5 ,6 ,7 分别表示结构等级为 钢混 ，砖木三等 ，砖木二等 ，砖混一等 ，砖混二等 ，砖木一等 ，简易
        foreach($structureTypes as $k1 => $v1){
            //$i = 1 ,2 ,3 分别表示使用性质为 住宅 ，企业 ，机关
            for($i = 1; $i<4; $i++){

                if($i == 1){  //只有住宅需要统计使用面积
                    $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                        ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(CivilArea) as TotalAreas ,sum(PreRent) as BanPrerents,sum(BanUsearea) as  BanUseareas ')
                        ->where($where)
                        ->where(['StructureType'=>$k1,'UseNature'=>$i])
                        ->find();  //计算每一个（结构等级，使用性质）的结果集
                    //unset($datas[$k1][$i]['BanUseareas']);
                }elseif($i == 2){
                    $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                    ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(EnterpriseArea) as TotalAreas ,sum(PreRent) as BanPrerents')
                        ->where($where)
                        ->where(['StructureType'=>$k1,'UseNature'=>$i])
                        ->find();  //计算每一个（结构等级，使用性质）的结果集
                }elseif($i == 3){
                    $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                    ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(PartyArea) as TotalAreas ,sum(PreRent) as BanPrerents')
                        ->where($where)
                        ->where(['StructureType'=>$k1,'UseNature'=>$i])
                        ->find();  //计算每一个（结构等级，使用性质）的结果集
                }

                foreach ($datas[$k1][$i] as &$v2) {  //保证每个结果的值不为null ，避免报错
                    if(!$v2){$v2 = 0;}
                }

                $datas[$k1][$i]['StructureTypeName'] = $v1;

            }
        }
        // 将$v5[0],用作计算左侧合计部分
        $totalTotalAreas = 0;
        foreach ($datas as $k5 => &$v5) {
            $v5[0]['BanIDS'] = $v5[1]['BanIDS'] + $v5[2]['BanIDS'] + $v5[3]['BanIDS'];
            $v5[0]['TotalHouseholds'] = $v5[1]['TotalHouseholds'] + $v5[2]['TotalHouseholds'] + $v5[3]['TotalHouseholds'];
            $v5[0]['TotalAreas'] = $v5[1]['TotalAreas'] + $v5[2]['TotalAreas'] + $v5[3]['TotalAreas'];

            if($v5[0]['TotalAreas']){
                $datas[$k5][1]['Percent'] = round($datas[$k5][1]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][2]['Percent'] = round($datas[$k5][2]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][3]['Percent'] = round($datas[$k5][3]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                //halt($datas[$k5][1]['Percent']);
            }else{
                $datas[$k5][1]['Percent'] = 0;
                $datas[$k5][2]['Percent'] = 0;
                $datas[$k5][3]['Percent'] = 0;
            }
            $v5[0]['BanPrerents'] = $v5[1]['BanPrerents'] + $v5[2]['BanPrerents'] + $v5[3]['BanPrerents'];


            $totalTotalAreas += $v5[0]['TotalAreas'];
        }
//halt($datas);
        foreach ($datas as $k6 => $v6) {

            if($totalTotalAreas){
                $datas[$k6][0]['Percent'] = round($datas[$k6][0]['TotalAreas'] / $totalTotalAreas ,4) * 100;
            }else{
                $datas[$k6][0]['Percent'] = 0;
            }


            for($j = 0; $j <4; $j++){
                $total['banidsArr'][$j][] = $datas[$k6][$j]['BanIDS'];
                $total['householdsArr'][$j][] = $datas[$k6][$j]['TotalHouseholds'];
                $total['areasArr'][$j][] = $datas[$k6][$j]['TotalAreas'];
                if($j == 1){
                    $total['banUseareas'][$j][] = $datas[$k6][$j]['BanUseareas'];
                }

                $total['banPrerents'][$j][] = $datas[$k6][$j]['BanPrerents'];
            }

        }

        // $total为最下面的合计部分
        foreach ($total as $k3 => $v3) {  //最下面的合计
            foreach ($v3 as $k4 => $v4) {
                $total[$k3][$k4] = array_sum($v4);
            }
        }

        //将两个数组整合成一个数组，便于前端遍历显示
        foreach ($datas as $k7 => $v7) {
            ksort($v7);
            foreach ($v7 as $k8 => $v8) {
                foreach ($v8 as $k9 => $v9) {
                    if($k9 == 'StructureTypeName') continue;
                    $result[$k7][] = $v9;
                }
            }
            array_unshift($result[$k7] ,$v7[1]['StructureTypeName']);
        }

        $result[0][0] = '合计';
        $result[0][1] = $total['banidsArr'][0];
        $result[0][2] = $total['householdsArr'][0];
        $result[0][3] = $total['areasArr'][0];
        $result[0][4] = $total['banPrerents'][0];
        $result[0][5] = 100;
        $result[0][6] = $total['banidsArr'][1];
        $result[0][7] = $total['householdsArr'][1];
        $result[0][8] = $total['areasArr'][1];
        $result[0][9] = $total['banPrerents'][1];
        $result[0][10] = $total['banUseareas'][1];
        $result[0][11] = $totalTotalAreas?round($total['areasArr'][1] / $totalTotalAreas ,4) * 100:0;
        $result[0][12] = $total['banidsArr'][2];
        $result[0][13] = $total['householdsArr'][2];
        $result[0][14] = $total['areasArr'][2];
        $result[0][15] = $total['banPrerents'][2];
        $result[0][16] = $totalTotalAreas?round($total['areasArr'][2] / $totalTotalAreas ,4) * 100:0;
        $result[0][17] = $total['banidsArr'][3];
        $result[0][18] = $total['householdsArr'][3];
        $result[0][19] = $total['areasArr'][3];
        $result[0][20] = $total['banPrerents'][3];
        $result[0][21] = $totalTotalAreas?round($total['areasArr'][3] / $totalTotalAreas ,4) * 100:0;
        //halt($result);

        return $result;
    }

    public function get_by_institution($where){

        if(isset($where['InstitutionID'])){
            $institutions = Db::name('institution')->where('pid','eq',$where['InstitutionID'])->column('id,Institution');
            unset($where['InstitutionID']);

        }elseif(isset($where['TubulationID'])){
            $institutions = Db::name('institution')->where('id','eq',$where['TubulationID'])->column('id,Institution');
            unset($where['TubulationID']);
            //dump($where);halt($institutions);
        }else{
            $institutions = Db::name('institution')->where('id','neq',1)->column('id,Institution');
        }

        //$k = 1 ,2 ,3 ,4 ,5 ,6 ,7 分别表示结构等级为 钢混 ，砖木三等 ，砖木二等 ，砖混一等 ，砖混二等 ，砖木一等 ，简易
        foreach($institutions as $k1 => $v1){
            $wheres = array();
            if($k1 < 4){
                $wheres['InstitutionID'] = array('eq' ,$k1);
            }else{
                $wheres['TubulationID'] = array('eq' ,$k1);
            }
//dump($where);dump($wheres);exit;
            //$i = 1 ,2 ,3  分别表示使用性质为 住宅 ，企业 ，机关
            for($i = 1; $i<4; $i++){

                $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                    ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(TotalArea) as TotalAreas,sum(BanUsearea) as BanUseareas,sum(BanPrerent) as BanPrerents')
                    ->where($where)
                    ->where(['UseNature'=>$i])
                    ->where($wheres)
                    ->find();  //计算每一个（结构等级，使用性质）的结果集

                foreach ($datas[$k1][$i] as &$v2) {  //保证每个结果的值不为null ，避免报错
                    if(!$v2){$v2 = 0;}
                }

                if($i != 1){  //只有住宅需要统计使用面积
                    unset($datas[$k1][$i]['BanUseareas']);
                }

                $datas[$k1][$i]['InstitutionName'] = $v1;

            }
        }

        //halt($datas);

        // 将$v5[0],用作计算左侧合计部分
        $totalTotalAreas = 0;

        if(!isset($datas)){
            return array();
        }

        foreach ($datas as $k5 => &$v5) {
            $v5[0]['BanIDS'] = $v5[1]['BanIDS'] + $v5[2]['BanIDS'] + $v5[3]['BanIDS'];
            $v5[0]['TotalHouseholds'] = $v5[1]['TotalHouseholds'] + $v5[2]['TotalHouseholds'] + $v5[3]['TotalHouseholds'];
            $v5[0]['TotalAreas'] = $v5[1]['TotalAreas'] + $v5[2]['TotalAreas'] + $v5[3]['TotalAreas'];
            $v5[0]['BanPrerents'] = $v5[1]['BanPrerents'] + $v5[2]['BanPrerents'] + $v5[3]['BanPrerents'];

            if($v5[0]['TotalAreas']){
                $datas[$k5][1]['Percent'] = round($datas[$k5][1]['TotalAreas'] / $v5[0]['TotalAreas'] ,2) * 100;
                $datas[$k5][2]['Percent'] = round($datas[$k5][2]['TotalAreas'] / $v5[0]['TotalAreas'] ,2) * 100;
                $datas[$k5][3]['Percent'] = round($datas[$k5][3]['TotalAreas'] / $v5[0]['TotalAreas'] ,2) * 100;
            }else{
                $datas[$k5][1]['Percent'] = 0;
                $datas[$k5][2]['Percent'] = 0;
                $datas[$k5][3]['Percent'] = 0;
            }


            $totalTotalAreas += $v5[0]['TotalAreas'];
        }

        foreach ($datas as $k6 => $v6) {

            if($totalTotalAreas){
                $datas[$k6][0]['Percent'] = round($datas[$k6][0]['TotalAreas'] / $totalTotalAreas ,2) * 100;
            }else{
                $datas[$k6][0]['Percent'] = 0;
            }

            for($j = 0; $j <4; $j++){
                $total['banidsArr'][$j][] = $datas[$k6][$j]['BanIDS'];
                $total['householdsArr'][$j][] = $datas[$k6][$j]['TotalHouseholds'];
                $total['areasArr'][$j][] = $datas[$k6][$j]['TotalAreas'];
                if($j == 1){ //名用多一个使用面积
                    $total['useAreas'][$j][] = $datas[$k6][$j]['BanUseareas'];
                }
                $total['banPrerents'][$j][] = $datas[$k6][$j]['BanPrerents'];
                $total['Percent'][$j][] = $datas[$k6][$j]['Percent'];
            }

        }

        // $total为最下面的合计部分
        foreach ($total as $k3 => $v3) {  //最下面的合计
            foreach ($v3 as $k4 => $v4) {
                $total[$k3][$k4] = array_sum($v4);
            }
        }

        //将两个数组整合成一个数组，便于前端遍历显示
        foreach ($datas as $k7 => $v7) {
            ksort($v7);
            foreach ($v7 as $k8 => $v8) {
                foreach ($v8 as $k9 => $v9) {
                    if($k9 == 'InstitutionName') continue;
                    $result[$k7][] = $v9;
                }
            }
            array_unshift($result[$k7] ,$v7[1]['InstitutionName']);
        }

        //halt($total);

        //halt($result);

        $result[0][0] = '合计';
        $result[0][1] = $total['banidsArr'][0];
        $result[0][2] = $total['householdsArr'][0];
        $result[0][3] = $total['areasArr'][0];
        $result[0][4] = $total['Percent'][0];
        $result[0][5] = $total['banPrerents'][0];
        $result[0][6] = $total['banidsArr'][1];
        $result[0][7] = $total['householdsArr'][1];
        $result[0][8] = $total['areasArr'][1];
        $result[0][9] = $total['Percent'][1];
        $result[0][10] = $total['useAreas'][1];
        $result[0][11] = $total['banPrerents'][1];
        $result[0][12] = $total['banidsArr'][2];
        $result[0][13] = $total['householdsArr'][2];
        $result[0][14] = $total['areasArr'][2];
        $result[0][15] = $total['Percent'][2];
        $result[0][16] = $total['banPrerents'][2];
        $result[0][17] = $total['banidsArr'][3];
        $result[0][18] = $total['householdsArr'][3];
        $result[0][19] = $total['areasArr'][3];
        $result[0][20] = $total['Percent'][3];
        $result[0][21] = $total['banPrerents'][3];

        //halt($result);
        return $result;
    }

    public function get_by_year($where){

        $arr = ['1' => '1937年代' ,'2' => '40年代' ,'3' => '50年代' ,'4' => '60年代' ,'5' => '70年代' ,'6' =>'80年代以后'];
        foreach($arr as $k1 => $v1){
            switch ($k1) {
                case '1':
                    $wheres['BanYear'] = array('eq',1937);
                    break;
                case '2':
                    $wheres['BanYear'] = array('between',[1940,1949]);
                    break;
                case '3':
                    $wheres['BanYear'] = array('between',[1950,1959]);
                    break;
                case '4':
                    $wheres['BanYear'] = array('between',[1960,1969]);
                    break;
                case '5':
                    $wheres['BanYear'] = array('between',[1970,1979]);
                    break;
                case '6':
                    $wheres['BanYear'] = array('egt',1980);
                    break;
            }
            //$i = 1 ,2 ,3 ,4 ,5 分别表示完损等级为 完好 ，基本 ，一般 ，严重 ，危险
            for($i = 1; $i<6; $i++){

                $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                    ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(TotalArea) as TotalAreas')
                    ->where($where)
                    ->where($wheres)
                    ->where('DamageGrade',$i)
                    ->find();  //计算每一个（建成年份，完损等级）的结果集

                foreach ($datas[$k1][$i] as &$v2) {  //保证每个结果的值不为null ，避免报错
                    if(!$v2){$v2 = 0;}
                }

                $datas[$k1][$i]['YearName'] = $v1;

            }
        }

        // 将$v5[0],用作计算左侧合计部分
        $totalTotalAreas = 0;
        foreach ($datas as $k5 => &$v5) {
            $v5[0]['BanIDS'] = $v5[1]['BanIDS'] + $v5[2]['BanIDS'] + $v5[3]['BanIDS'] + $v5[4]['BanIDS'] + $v5[5]['BanIDS'];
            $v5[0]['TotalHouseholds'] = $v5[1]['TotalHouseholds'] + $v5[2]['TotalHouseholds'] + $v5[3]['TotalHouseholds'] + $v5[4]['TotalHouseholds'] + $v5[5]['TotalHouseholds'];
            $v5[0]['TotalAreas'] = $v5[1]['TotalAreas'] + $v5[2]['TotalAreas'] + $v5[3]['TotalAreas'] + $v5[4]['TotalAreas'] + $v5[5]['TotalAreas'];

            if($v5[0]['TotalAreas']){
                $datas[$k5][1]['Percent'] = round($datas[$k5][1]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][2]['Percent'] = round($datas[$k5][2]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][3]['Percent'] = round($datas[$k5][3]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][4]['Percent'] = round($datas[$k5][4]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
                $datas[$k5][5]['Percent'] = round($datas[$k5][5]['TotalAreas'] / $v5[0]['TotalAreas'] ,4) * 100;
            }else{
                $datas[$k5][1]['Percent'] = 0;
                $datas[$k5][2]['Percent'] = 0;
                $datas[$k5][3]['Percent'] = 0;
                $datas[$k5][4]['Percent'] = 0;
                $datas[$k5][5]['Percent'] = 0;
            }


            $totalTotalAreas += $v5[0]['TotalAreas'];
        }

        foreach ($datas as $k6 => $v6) {

            if($totalTotalAreas){
                $datas[$k6][0]['Percent'] = round($datas[$k6][0]['TotalAreas'] / $totalTotalAreas ,4) * 100;
            }else{
                $datas[$k6][0]['Percent'] = 0;
            }

            for($j = 0; $j <6; $j++){
                $total['banidsArr'][$j][] = $datas[$k6][$j]['BanIDS'];
                $total['householdsArr'][$j][] = $datas[$k6][$j]['TotalHouseholds'];
                $total['areasArr'][$j][] = $datas[$k6][$j]['TotalAreas'];
                //$total['Percent'][$j][] = $datas[$k6][$j]['Percent'];
            }

        }

        // $total为最下面的合计部分
        foreach ($total as $k3 => $v3) {  //最下面的合计
            foreach ($v3 as $k4 => $v4) {
                $total[$k3][$k4] = array_sum($v4);
            }
        }

        //将两个数组整合成一个数组，便于前端遍历显示
        foreach ($datas as $k7 => $v7) {
            ksort($v7);
            foreach ($v7 as $k8 => $v8) {
                foreach ($v8 as $k9 => $v9) {
                    if($k9 == 'YearName') continue;
                    $result[$k7][] = $v9;
                }
            }
            array_unshift($result[$k7] ,$v7[1]['YearName']);
        }

        $result[0][0] = '合计';
        $result[0][1] = $total['banidsArr'][0];
        $result[0][2] = $total['householdsArr'][0];
        $result[0][3] = $total['areasArr'][0];
        $result[0][4] = 100;
        $result[0][5] = $total['banidsArr'][1];
        $result[0][6] = $total['householdsArr'][1];
        $result[0][7] = $total['areasArr'][1];
        $result[0][8] = $totalTotalAreas?round($total['areasArr'][1] / $totalTotalAreas ,4) * 100:0;
        $result[0][9] = $total['banidsArr'][2];
        $result[0][10] = $total['householdsArr'][2];
        $result[0][11] = $total['areasArr'][2];
        $result[0][12] = $totalTotalAreas?round($total['areasArr'][2] / $totalTotalAreas ,4) * 100:0;
        $result[0][13] = $total['banidsArr'][3];
        $result[0][14] = $total['householdsArr'][3];
        $result[0][15] = $total['areasArr'][3];
        $result[0][16] = $totalTotalAreas?round($total['areasArr'][3] / $totalTotalAreas ,4) * 100:0;
        $result[0][17] = $total['banidsArr'][4];
        $result[0][18] = $total['householdsArr'][4];
        $result[0][19] = $total['areasArr'][4];
        $result[0][20] = $totalTotalAreas?round($total['areasArr'][4] / $totalTotalAreas ,4) * 100:0;
        $result[0][21] = $total['banidsArr'][5];
        $result[0][22] = $total['householdsArr'][5];
        $result[0][23] = $total['areasArr'][5];
        $result[0][24] = $totalTotalAreas?round($total['areasArr'][5] / $totalTotalAreas ,4) * 100:0;
        //halt($result);

        return $result;

    }

    public function get_by_value($where){

         $structureTypes = Db::name('ban_structure_type')->column('id,StructureType');

         //$k = 1 ,2 ,3 ,4 ,5 ,6 ,7 分别表示结构等级为 钢混 ，砖木三等 ，砖木二等 ，砖混一等 ，砖混二等 ，砖木一等 ，简易
         foreach($structureTypes as $k1 => $v1){
                //$i = 1 ,2 ,3 分别表示使用性质为 住宅 ，企业 ，机关
                for($i = 1; $i<4; $i++){

                    $datas[$k1][$i] = Db::name('ban')       //根据使用性质和结构类型分类
                        ->field('count(BanID) as BanIDS ,sum(TotalHouseholds) as TotalHouseholds, sum(TotalArea) as TotalAreas,sum(TotalOprice) as TotalOprices ,sum(BanUsearea) as  BanUseareas')
                        ->where($where)
                        ->where(['StructureType'=>$k1,'UseNature'=>$i])
                        ->find();  //计算每一个（结构等级，使用性质）的结果集

                    if($i != 1){  //只有住宅需要统计使用面积
                        unset($datas[$k1][$i]['BanUseareas']);
                    }

                    foreach ($datas[$k1][$i] as &$v2) {  //保证每个结果的值不为null ，避免报错
                        if(!$v2){$v2 = 0;}
                    }

                    $datas[$k1][$i]['StructureTypeName'] = $v1;

                }
         }

        // 将$v5[0],用作计算左侧合计部分
        foreach ($datas as $k5 => &$v5) {
            $v5[0]['BanIDS'] = $v5[1]['BanIDS'] + $v5[2]['BanIDS'] + $v5[3]['BanIDS'];
            $v5[0]['TotalHouseholds'] = $v5[1]['TotalHouseholds'] + $v5[2]['TotalHouseholds'] + $v5[3]['TotalHouseholds'];
            $v5[0]['TotalAreas'] = $v5[1]['TotalAreas'] + $v5[2]['TotalAreas'] + $v5[3]['TotalAreas'];
            $v5[0]['TotalOprices'] = $v5[1]['TotalOprices'] + $v5[2]['TotalOprices'] + $v5[3]['TotalOprices'];
        }

        foreach ($datas as $k6 => $v6) {

            for($j = 0; $j <4; $j++){
                $total['banidsArr'][$j][] = $datas[$k6][$j]['BanIDS'];
                $total['householdsArr'][$j][] = $datas[$k6][$j]['TotalHouseholds'];
                $total['areasArr'][$j][] = $datas[$k6][$j]['TotalAreas'];
                if($j == 1){
                    $total['banUseareas'][$j][] = $datas[$k6][$j]['BanUseareas'];
                }
                $total['opricesArr'][$j][] = $datas[$k6][$j]['TotalOprices'];
            }

        }

        // $total为最下面的合计部分
        foreach ($total as $k3 => $v3) {  //最下面的合计
            foreach ($v3 as $k4 => $v4) {
                $total[$k3][$k4] = array_sum($v4);
            }
        }

        //将两个数组整合成一个数组，便于前端遍历显示
        foreach ($datas as $k7 => $v7) {
            ksort($v7);
            foreach ($v7 as $k8 => $v8) {
                foreach ($v8 as $k9 => $v9) {
                    if($k9 == 'StructureTypeName') continue;
                    $result[$k7][] = $v9;
                }
            }
            array_unshift($result[$k7] ,$v7[1]['StructureTypeName']);
        }

        $result[0][0] = '合计';
        $result[0][1] = $total['banidsArr'][0];
        $result[0][2] = $total['householdsArr'][0];
        $result[0][3] = $total['areasArr'][0];
        $result[0][4] = $total['opricesArr'][0];
        $result[0][5] = $total['banidsArr'][1];
        $result[0][6] = $total['householdsArr'][1];
        $result[0][7] = $total['areasArr'][1];
        $result[0][8] = $total['banUseareas'][1];
        $result[0][9] = $total['opricesArr'][1];
        $result[0][10] = $total['banidsArr'][2];
        $result[0][11] = $total['householdsArr'][2];
        $result[0][12] = $total['areasArr'][2];
        $result[0][13] = $total['opricesArr'][2];
        $result[0][14] = $total['banidsArr'][3];
        $result[0][15] = $total['householdsArr'][3];
        $result[0][16] = $total['areasArr'][3];
        $result[0][17] = $total['opricesArr'][3];

        //halt($result);

        return $result;
    }
}