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
use think\Loader;
use think\Db;

class PropertyReport extends Model
{
    /**
     * 产权统计报表缓存数据
     * 机制：将所有产别，机构按照多维数组序列化存储，$data[产别][机构]
     * 这样要取出某个产别和机构的数据时直接读取缓存中的对应结构即可
     */
    public function index(){
        //注意所有与私房、区直共有房屋还没做
        //获取所有产别，去除代管产、托管产
        //$owerLst = Db::name('ban_owner_type')->where('id','not in','3,7')->column('id');
        ////初始化查询条件，默认市属、当前月份、当前机构,市属是包含市属，代管和托管
        // $owerLst = [1,2,5,6,11];
        // $instLst = [1,2,3];
        //初始化查询条件，默认市属、当前月份、当前机构,市属是包含市属，代管和托管
        $propertyWhere = [
            'OwnerType' => array('in',[1,2,3,5,7]),
            'Status' => array('eq',1),
        ];

        $dengjiWhere = [
            'OwnerType' => array('in',[1,2,3,5,7]),
            'BanPropertyID' => array('>',0),
            'Status' => array('eq',1),
        ];

        $xinfaWhere = [
            'OwnerType' => array('in',[1,2,3,5,7]),
            'ChangeType' => array('eq',7),
            'Status' => array('eq',1),
        ];

        $zhuxiaoWhere = [
            'OwnerType' => array('in',[1,2,3,5,7]),
            'ChangeType' => array('eq',8),
            'Status' => array('eq',1),
        ];
        
        $propertyData = Db::name('ban')->field('OwnerType,TubulationID,sum(TotalNum) as totalNums, sum(TotalArea) as totalAreas')
                              ->where($propertyWhere)
                              ->group('OwnerType,TubulationID')
                              ->select();

        $dengjiData = Db::name('ban')->field('OwnerType,TubulationID,sum(TotalNum) as totalNums, sum(TotalArea) as totalAreas')
                              ->where($dengjiWhere)
                              ->group('OwnerType,TubulationID')
                              ->select();

        $xinfaChangeData = Db::name('rent_table')->field('OwnerType,InstitutionID,NewLeaseType, sum(Area) as areas, sum(ChangeNum) as changeNums')
                              ->where($xinfaWhere)
                              ->group('OwnerType,InstitutionID,NewLeaseType')
                              ->select();

        $zhuxiaoChangeData = Db::name('rent_table')->field('OwnerType,InstitutionID,CancelType, sum(Area) as areas, sum(ChangeNum) as changeNums')
                              ->where($zhuxiaoWhere)
                              ->group('OwnerType,InstitutionID,CancelType')
                              ->select();

        //重组为规定格式的产权基本数据
        foreach($propertyData as $k1 => $v1){
            $propertydata[$v1['OwnerType']][$v1['TubulationID']] = [
                'totalNums' => $v1['totalNums'],
                'totalAreas' => $v1['totalAreas'],
            ];
        }

        foreach($dengjiData as $k4 => $v4){
            $dengjidata[$v4['OwnerType']][$v4['TubulationID']] = [
                'totalNums' => $v4['totalNums'],
                'totalAreas' => $v4['totalAreas'],
            ];
        }

        foreach($xinfaChangeData as $k2 => $v2){
            $xinfaChangedata[$v2['OwnerType']][$v2['InstitutionID']][$v2['NewLeaseType']] = [
                'areas' => $v2['areas'],
                'changeNums' => $v2['changeNums'],
            ];
        }

        foreach($zhuxiaoChangeData as $k3 => $v3){
            $zhuxiaoChangedata[$v3['OwnerType']][$v3['InstitutionID']][$v3['CancelType']] = [
                'areas' => $v3['areas'],
                'changeNums' => $v3['changeNums'],
            ];
        }

         //保证每一个产别，机构，下的每一个字段都不缺失（没有的以0来补充）
        $ownertypes = [1,2,3,5,7]; //市、区、代、自、托
        foreach ($ownertypes as $owner) {
            for ($j=4;$j<34;$j++) {

                if(!isset($propertydata[$owner][$j])){
                    $propertydata[$owner][$j] = [
                        'totalNums' => 0,
                        'totalAreas' => 0, 
                    ];
                }

                if(!isset($dengjidata[$owner][$j])){
                    $dengjidata[$owner][$j] = [
                        'totalNums' => 0,
                        'totalAreas' => 0, 
                    ];
                }

                for($k=1;$k<7;$k++){
                    if(!isset($xinfaChangedata[$owner][$j][$k])){
                        $xinfaChangedata[$owner][$j][$k] = [ 
                            'areas' => 0,
                            'changeNums' => 0,
                        ];
                    }
                }

                for($i=1;$i<7;$i++){
                    if(!isset($zhuxiaoChangedata[$owner][$j][$i])){
                        $zhuxiaoChangedata[$owner][$j][$i] = [
                            'areas' => 0,
                            'changeNums' => 0,
                        ];
                    }
                }

            }
        }
        //halt($propertydata);

        $ownertype = [1,2,5];
        foreach ($ownertype as $owners) { //处理市、区、代、自、托
            for ($a = 4; $a < 34; $a++) { //每个管段，从4开始……
                    
                if($owners === 1){
                    $result[$owners][$a][0][0] = $propertydata[1][$a]['totalNums'] + $propertydata[3][$a]['totalNums'] + $propertydata[7][$a]['totalNums']; //市属楼栋
                    $result[$owners][$a][0][1] = $propertydata[1][$a]['totalAreas'] + $propertydata[3][$a]['totalAreas'] + $propertydata[7][$a]['totalAreas']; //市属建筑面积
                    $result[$owners][$a][0][2] = $propertydata[3][$a]['totalNums']; //代管楼栋
                    $result[$owners][$a][0][3] = $propertydata[3][$a]['totalAreas']; //代管建筑面积
                    $result[$owners][$a][0][4] = $propertydata[7][$a]['totalNums']; //托管楼栋
                    $result[$owners][$a][0][5] = $propertydata[7][$a]['totalAreas']; //托管建筑面积

                    $result[$owners][$a][5][0] = $dengjidata[1][$a]['totalNums'] + $dengjidata[3][$a]['totalNums'] + $dengjidata[7][$a]['totalNums']; //登记楼栋
                    $result[$owners][$a][5][1] = $dengjidata[1][$a]['totalAreas'] + $dengjidata[3][$a]['totalAreas'] + $dengjidata[7][$a]['totalAreas']; //登记建筑面积
                }else{
                    $result[$owners][$a][0][0] = $propertydata[$owners][$a]['totalNums']; //市属楼栋
                    $result[$owners][$a][0][1] = $propertydata[$owners][$a]['totalAreas']; //年增加建筑面积
                    $result[$owners][$a][0][2] = 0;
                    $result[$owners][$a][0][3] = 0;
                    $result[$owners][$a][0][4] = 0;
                    $result[$owners][$a][0][5] = 0;

                    $result[$owners][$a][5][0] = $dengjidata[$owners][$a]['totalNums']; //登记楼栋
                    $result[$owners][$a][5][1] = $dengjidata[$owners][$a]['totalAreas']; //登记建筑面积
                }

                // if($a == 14 && $owners == 2){
                //     halt($xinfaChangedata[$owners][$a]);
                // }
               
                $result[$owners][$a][1][0] = $xinfaChangedata[$owners][$a][1]['changeNums'] + $xinfaChangedata[$owners][$a][2]['changeNums'] +$xinfaChangedata[$owners][$a][3]['changeNums'] +$xinfaChangedata[$owners][$a][4]['changeNums'] +$xinfaChangedata[$owners][$a][5]['changeNums'] +$xinfaChangedata[$owners][$a][6]['changeNums']; //新发楼栋
                $result[$owners][$a][1][1] = $xinfaChangedata[$owners][$a][1]['areas'] + $xinfaChangedata[$owners][$a][2]['areas'] +$xinfaChangedata[$owners][$a][3]['areas'] +$xinfaChangedata[$owners][$a][4]['areas'] +$xinfaChangedata[$owners][$a][5]['areas'] +$xinfaChangedata[$owners][$a][6]['areas']; //新发建筑面积
                $result[$owners][$a][1][2] = $zhuxiaoChangedata[$owners][$a][1]['changeNums'] + $zhuxiaoChangedata[$owners][$a][2]['changeNums'] +$zhuxiaoChangedata[$owners][$a][3]['changeNums'] +$zhuxiaoChangedata[$owners][$a][4]['changeNums'] +$zhuxiaoChangedata[$owners][$a][5]['changeNums'] +$zhuxiaoChangedata[$owners][$a][6]['changeNums']; //注销楼栋
                $result[$owners][$a][1][3] = $zhuxiaoChangedata[$owners][$a][1]['areas'] + $zhuxiaoChangedata[$owners][$a][2]['areas'] +$zhuxiaoChangedata[$owners][$a][3]['areas'] +$zhuxiaoChangedata[$owners][$a][4]['areas'] +$zhuxiaoChangedata[$owners][$a][5]['areas'] +$zhuxiaoChangedata[$owners][$a][6]['areas']; //注销建筑面积

                $result[$owners][$a][2][0] = $xinfaChangedata[$owners][$a][1]['changeNums']; //接管栋数
                $result[$owners][$a][2][1] = $xinfaChangedata[$owners][$a][1]['areas']; //接管建面
                $result[$owners][$a][2][2] = $xinfaChangedata[$owners][$a][4]['changeNums']; //合建栋数
                $result[$owners][$a][2][3] = $xinfaChangedata[$owners][$a][4]['areas']; //合建建面
                $result[$owners][$a][2][4] = $zhuxiaoChangedata[$owners][$a][1]['changeNums']; //出售栋数
                $result[$owners][$a][2][5] = $zhuxiaoChangedata[$owners][$a][1]['areas']; //出售建面
                $result[$owners][$a][2][6] = $zhuxiaoChangedata[$owners][$a][4]['changeNums']; //灭失栋数
                $result[$owners][$a][2][7] = $zhuxiaoChangedata[$owners][$a][4]['areas']; //灭失建面

                $result[$owners][$a][3][0] = $xinfaChangedata[$owners][$a][2]['changeNums']; //还建栋数
                $result[$owners][$a][3][1] = $xinfaChangedata[$owners][$a][2]['areas']; //还建建面
                $result[$owners][$a][3][2] = $xinfaChangedata[$owners][$a][5]['changeNums']; //加改扩栋数
                $result[$owners][$a][3][3] = $xinfaChangedata[$owners][$a][5]['areas']; //加改扩建面
                $result[$owners][$a][3][4] = $zhuxiaoChangedata[$owners][$a][2]['changeNums']; //危改拆除栋数
                $result[$owners][$a][3][5] = $zhuxiaoChangedata[$owners][$a][2]['areas']; //危改拆除建面
                $result[$owners][$a][3][6] = $zhuxiaoChangedata[$owners][$a][5]['changeNums']; //房屋划转栋数
                $result[$owners][$a][3][7] = $zhuxiaoChangedata[$owners][$a][5]['areas']; //房屋划转建面

                $result[$owners][$a][4][0] = $xinfaChangedata[$owners][$a][3]['changeNums']; //新建栋数
                $result[$owners][$a][4][1] = $xinfaChangedata[$owners][$a][3]['areas']; //新建建面
                $result[$owners][$a][4][2] = $xinfaChangedata[$owners][$a][6]['changeNums']; //其他扩栋数
                $result[$owners][$a][4][3] = $xinfaChangedata[$owners][$a][6]['areas']; //其他建面
                $result[$owners][$a][4][4] = $zhuxiaoChangedata[$owners][$a][3]['changeNums']; //落私发还栋数
                $result[$owners][$a][4][5] = $zhuxiaoChangedata[$owners][$a][3]['areas']; //落私发还建面
                $result[$owners][$a][4][6] = $zhuxiaoChangedata[$owners][$a][6]['changeNums']; //其他栋数
                $result[$owners][$a][4][7] = $zhuxiaoChangedata[$owners][$a][6]['areas']; //其他建面
                
                

            }
        }
        
        //第一步：处理市代托，市区代托，全部下的公司，紫阳，粮道的数据（注意只有所和公司才有市代托、市区代托、全部）
        $ownertypess = [1,2,5,11]; //市、区、自、全部
        foreach ($ownertypess as $own) {

            for ($d = 4; $d >0; $d--) {
                //公司和所，从1到3（1公司，2紫阳，3粮道），注意顺序公司的数据由所加和得来，所以是3、2、1的顺序
                if($own < 10 && $d ==3){ //粮道所，的市、区、自
                    $result[$own][$d] = array_merge_adds($result[$own][19],$result[$own][20],$result[$own][21],$result[$own][22],$result[$own][23],$result[$own][24],$result[$own][25],$result[$own][26],$result[$own][27],$result[$own][28],$result[$own][29],$result[$own][30],$result[$own][31],$result[$own][32],$result[$own][33]);
                }elseif($own < 10 && $d ==2){ //紫阳所，的市、区、自
                    $result[$own][$d] = array_merge_adds($result[$own][4],$result[$own][5],$result[$own][6],$result[$own][7],$result[$own][8],$result[$own][9],$result[$own][10],$result[$own][11],$result[$own][12],$result[$own][13],$result[$own][14],$result[$own][15],$result[$own][16],$result[$own][17],$result[$own][18]);
                }elseif($own < 10 && $d ==1){ //公司，的市、区、自
                    $result[$own][$d] = array_merge_add($result[$own][2] ,$result[$own][3]);
                }elseif($own == 11 && $d > 1){ 
                    $result[$own][$d] = array_merge_add(array_merge_add($result[1][$d] ,$result[2][$d]),$result[5][$d]);
                }elseif($own == 11 && $d == 1){
                    $result[$own][$d] = array_merge_add($result[$own][2] ,$result[$own][3]);
                }

            }
        }

        foreach($result as &$res){
            foreach($res as &$re){
                foreach($re as &$r){
                    foreach($r as &$s){
                        if($s > 0){
                            $s = rtrim(rtrim($s,'0'),'.');
                        }else{
                            $s = '';
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function index_old(){
        //注意所有与私房、区直共有房屋还没做
        //获取所有产别，去除代管产、托管产
        //$owerLst = Db::name('ban_owner_type')->where('id','not in','3,7')->column('id');
        $owerLst = [1,2,5,6,11];
        $instLst = [1,2,3];
        //初始化查询条件，默认市属、当前月份、当前机构,市属是包含市属，代管和托管
        $wheres['DateStart'] = array('eq',date('Y',time()));
        $wheres['b.Status'] = array('eq',1);
        $wheres['ChangeType'] = array('eq',7);
        foreach ($owerLst as  $v1) {
            foreach ($instLst as  $v2) {
                $where = array();
                $changeWhere = array();
                $where['Status'] = array('eq',1);
                if($v1 == 1){
                    $changeWhere['OwnerType'] = array('in',[1,3,7]);
                    $where['OwnerType'] = array('eq',$v1);
                }elseif($v1 > 1 && $v1< 11){
                    $changeWhere['OwnerType'] = array('eq',$v1);
                    $where['OwnerType'] = array('eq',$v1);
                }else{
                    $where['OwnerType'] = array('in',[1,2,3,5,7]);
                }

                if($v2 == 2 || $v2 == 3){
                    $where['InstitutionID'] = $v2;
                    $changeWhere['InstitutionPID'] = $v2;
                }

                //获取市属的所有楼栋数量和，建筑面积
                $one = Db::name('ban')->where($where)->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')->find();


                //获取市属的所有楼栋数量和，建筑面积
                //halt($where);
                $two = array();
                $three = array();

                //if($v1 == 11 && $v2 == 1){halt($where);}

                if(isset($where['OwnerType'][1]) && $where['OwnerType'][1] == 1){
                    $options = $where;

                    unset($options['OwnerType']);
                    $one = Db::name('ban')->where($options)
                        ->where('OwnerType','in',[1,3,7])
                        ->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')
                        ->find();
                    $two = Db::name('ban')->where($options)->where('OwnerType',3)->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')->find();
                    $three = Db::name('ban')->where($options)->where('OwnerType',7)->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')->find();
                    $four = Db::name('ban')->where($options)
                        ->where('BanPropertyID != ""')
                        ->where('OwnerType','in',[1,3,7])
                        ->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')
                        ->find();
                }else{
                    $four = Db::name('ban')->where($where)
                        ->where('BanPropertyID != ""')
                        ->field('sum(TotalNum) as num, sum(TotalArea) as totalAreas')
                        ->find();
                }

                $result[$v1][$v2][0]['totalNum'] = $one['num'];   //楼栋栋数总计
                $result[$v1][$v2][0]['totalAreas'] = $one['totalAreas'];//楼栋建筑面积总计
                $result[$v1][$v2][0]['daiNum'] = isset($two['num'])?$two['num']:0; //代管楼栋栋数
                $result[$v1][$v2][0]['daiAreas'] = isset($two['totalAreas'])?$two['totalAreas']:0;  //代管建筑面积
                $result[$v1][$v2][0]['tuoNum'] = isset($three['num'])?$three['num']:0;  //代管楼栋栋数
                $result[$v1][$v2][0]['tuoAreas'] = isset($three['totalAreas'])?$three['totalAreas']:0;  //代管楼栋栋数


                /********************************* 下面的部分 ***********************************/

                //注销异动：1房屋出售，2危改拆除，3落私发还，4自然灭失，5房屋划转，6其他
                $decData = Db::name('rent_table')->where(['ChangeType'=>8])->where($changeWhere)->field('CancelType,BanID')->select();
                $decnum = 1;
                $decdatas = [];
                if($decData){
                    foreach ($decData as $changev) {
                        $banTotalArea = Db::name('ban')->where('BanID',$changev['BanID'])->value('TotalArea');
                        $decdatas[$changev['CancelType']]['BanID'][] = $changev['BanID'];
                        $decdatas[$changev['CancelType']]['TotalArea'][] = $banTotalArea;
                        $decdatas['TotalArea'][] = $banTotalArea;
                        $decdatas['Num'] = $decnum++;
                    }
                }

                //新发租异动：1空租新发租，【2接管，3还建，4新建，5合建，6加改扩，9,其他 】，7加建，8扩建
                $incData = Db::name('change_order')->where(['ChangeType'=>7,'Status'=>1])->where($changeWhere)->field('NewSendRentType,BanID,AddRent,HouseID')->select();

                //halt($incData);
                
                $incnum = 1;
                $incdatas = [];

                //目前是加改扩：一条加改扩异动并不增加1栋楼，只是面积增加了
                if($incData){
                    foreach ($incData as $changev) {
                        if(in_array($changev['NewSendRentType'],[2,3,4,5,7,8,9])){
                            
                            if($changev['NewSendRentType'] ==7){
                                $banTotalArea = Db::name('ban')->where('BanID',$changev['BanID'])->value('TotalArea');
                                $incdatas[6]['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                                $incdatas['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                            }elseif($changev['NewSendRentType'] == 8){
                                $banTotalArea = Db::name('house')->alias('a')->join('ban b','a.BanID = b.BanID','left')->where('HouseID',$changev['HouseID'])->value('b.TotalArea');
                                $incdatas[6]['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                                $incdatas['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                            }else{
                                $banTotalArea = Db::name('ban')->where('BanID',$changev['BanID'])->value('TotalArea');
                                $incdatas['Num'] = $incnum++;
                                $incdatas['TotalArea'][] = $banTotalArea;
                            }

                            // if($changev['NewSendRentType'] == 8){
                            //     Db::name('house')->alias('a')->join('ban b','a.BanID = b.BanID','left')->where('HouseID',$changev['HouseID'])->value('b.TotalArea');
                            //     $incdatas[6]['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                            // }
                            // $incdatas['TotalArea'][] = $banTotalArea - $changev['AddRent'];
                            //$incdatas['Num'] = $incnum++;
                        }
                    }
                }


                $result[$v1][$v2][1]['incNum'] = isset($incdatas['Num'])?$incdatas['Num']:0; //年增加楼栋
                $result[$v1][$v2][1]['incAreas'] = isset($incdatas['TotalArea'])?array_sum($incdatas['TotalArea']):0; //年增加建筑面积
                $result[$v1][$v2][1]['decNum'] = isset($decdatas['Num'])?$decdatas['Num']:0; //年减少楼栋
                $result[$v1][$v2][1]['decAreas'] = isset($decdatas['TotalArea'])?array_sum($decdatas['TotalArea']):0; //年减少建筑面积

                $result[$v1][$v2][2]['jieguanNum'] = isset($incdatas[2])?count($incdatas[2]['BanID']):0; //接管栋数
                $result[$v1][$v2][2]['jieguanArea'] = isset($incdatas[2])?array_sum($incdatas[2]['TotalArea']):0; //接管建面
                $result[$v1][$v2][2]['hejianNum'] = isset($incdatas[5])?count($incdatas[5]['BanID']):0;  //合建栋数
                $result[$v1][$v2][2]['hejianArea'] = isset($incdatas[5])?array_sum($incdatas[5]['TotalArea']):0; //合建建面
                $result[$v1][$v2][2]['chushouNum'] = isset($decdatas[1])?count($decdatas[1]['BanID']):0;  //出售栋数
                $result[$v1][$v2][2]['chushouArea'] = isset($decdatas[1])?array_sum($decdatas[1]['TotalArea']):0; //出售建面
                $result[$v1][$v2][2]['mieshiNum'] = isset($decdatas[4])?count($decdatas[4]['BanID']):0;  //灭失栋数
                $result[$v1][$v2][2]['mieshiArea'] = isset($decdatas[4])?array_sum($decdatas[4]['TotalArea']):0; //灭失建面

                $result[$v1][$v2][3]['huanjianNum'] = isset($incdatas[3])?count($incdatas[3]['BanID']):0;  //还建栋数
                $result[$v1][$v2][3]['huanjianArea'] = isset($incdatas[3])?array_sum($incdatas[3]['TotalArea']):0;  //还建建面
                $result[$v1][$v2][3]['jiagaiNum'] = 0;  //加改栋数
                //$result[$v1][$v2][3]['jiagaiNum'] = isset($incdatas[6])?count($incdatas[6]['BanID']):0;  //加改栋数
                $result[$v1][$v2][3]['jiagaiArea'] = isset($incdatas[6])?array_sum($incdatas[6]['TotalArea']):0;  //加改建面
                $result[$v1][$v2][3]['chaichuNum'] = isset($decdatas[2])?count($decdatas[2]['BanID']):0;  //拆除栋数
                $result[$v1][$v2][3]['chaichuArea'] = isset($decdatas[2])?array_sum($decdatas[2]['TotalArea']):0;  //拆除建面
                $result[$v1][$v2][3]['huazhuanNum'] = isset($decdatas[5])?count($decdatas[5]['BanID']):0;  //划转栋数
                $result[$v1][$v2][3]['huazhuanArea'] = isset($decdatas[5])?array_sum($decdatas[5]['TotalArea']):0;  //划转建面

                $result[$v1][$v2][4]['xinjianNum'] = isset($incdatas[4])?count($incdatas[4]['BanID']):0;  //新建栋数
                $result[$v1][$v2][4]['xinjianArea'] = isset($incdatas[4])?array_sum($incdatas[4]['TotalArea']):0;  //新建建面
                $result[$v1][$v2][4]['qitaOneNum'] = isset($incdatas[9])?count($incdatas[9]['BanID']):0;   //其他1栋数
                $result[$v1][$v2][4]['qitaOneArea'] = isset($incdatas[9])?array_sum($incdatas[9]['TotalArea']):0;  //其他1建面
                $result[$v1][$v2][4]['fahuanNum'] = isset($decdatas[3])?count($decdatas[3]['BanID']):0;    //发还栋数
                $result[$v1][$v2][4]['fahuanArea'] = isset($decdatas[3])?array_sum($decdatas[3]['TotalArea']):0;  //发还建面
                $result[$v1][$v2][4]['qitaTwoNum'] = isset($decdatas[6])?count($decdatas[6]['BanID']):0;   //其他2栋数
                $result[$v1][$v2][4]['qitaTwoArea'] = isset($decdatas[6])?array_sum($decdatas[6]['TotalArea']):0;  //其他2建面

                $result[$v1][$v2][5]['dengjiNum'] = isset($four['num'])?$four['num']:0;   //已登记的楼栋数
                $result[$v1][$v2][5]['dengjiArea'] = isset($four['totalAreas'])?$four['totalAreas']:0;  //已登记的楼栋建面
            }
        }
//halt($result);
        return $result;
    }
}