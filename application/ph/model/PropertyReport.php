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
                $decData = Db::name('change_order')->where(['ChangeType'=>8,'Status'=>1])->where($changeWhere)->field('CancelType,BanID')->select();
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