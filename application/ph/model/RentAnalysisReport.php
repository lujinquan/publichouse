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

class RentAnalysisReport extends Model
{
    /**
     * 核减租金汇总表缓存数据字段解释如下：
     * 1：rent_plan表中录入的年计划租金
     * 2：从查询时间的一月到查询月的总实收累计（如：查询201813月，表示从201801至201803所有实收累计）
     * 3: 2/1的百分比
     * 4: 企事业收入占企事业年计划百分比
     * 5：机关收入占机关年计划百分比
     * 6：民用收入占民用年计划百分比
     * 7：从查询时间的一月到查询月的总规定租金累计（如：查询201813月，表示从201801至201803所有实收累计）
     * 8: 9/(7-15)的百分比
     * 9：等于2
     * 10: 9/(9+18)的百分比
     * 11：【概念模糊暂不统计】
     * 12：【概念模糊暂不统计】
     * 13：【概念模糊暂不统计】
     * 14：本年减免的总金额
     * 15：其中企事业减免的总金额
     * 16: 14/7（本年减免的总金额除以本年规定的总金额）
     * 17：至今为止所有欠缴的总金额
     * 18：本年度欠缴的总金额
     */
    public function index(){
        //所有产别
        $owerLst = Db::name('ban_owner_type')->where('id','in',[1,3,7])->column('id');
        $instLst = Db::name('institution')->column('id');

        $nowStartDate = date('Y',time()).'00';   //当年第一个月
        $nowDate = date('Ym',time());
        $currYear = date('Y',time());
        $nowBeginMonth = date('Y',time()).'00';

        //区间段查询
        $wheres['OrderDate'] = array('between',[$nowStartDate,$nowDate]);  //当月日期
        $option['OrderDate'] = array('>',$nowBeginMonth);
        $options['OrderDate'] = array('<',$nowBeginMonth);

//        dump($where);   //检索机构，检索产别
//        dump($wheres);  //检索时间段，查询年第一个月到查询月份为止
//        dump($option);  //检索时间段所在的年份整年的时间段，默认为当前年整年的时间段，用于查询 “本年金额”，及相关数据
//        dump($options); //检索时间段所在的年份之前的时间段，默认为当前年以前的时间段，用于查询 “以前年份”，及相关数据


        //获取年计划
        $allInstitutionTypes = get_all_institution_type();
        $yearPlanData = Db::name('rent_plan')->where('Year',$currYear)
            ->field('InstitutionID ,YearPlan ,EnterprisePlan ,PartyPlan ,CivilPlan')
            ->select();
        foreach ($yearPlanData as $v0) {
            $yearPlanDatas[$v0['InstitutionID']] = $v0;
        }

        foreach ($owerLst as $ower) { //产别
            
            foreach ($instLst as $ins) {  //机构
                $where = array();
                $where['OwnerType'] = array('eq', $ower);
                if ($ins == 2 || $ins == 3) {
                    $where['InstitutionID'] = $ins;
                    $groupType = 'InstitutionID';
                } elseif ($ins == 1) {
                    $groupType = 'InstitutionPID';
                } else {
                    $where['InstitutionID'] = $ins;
                    $groupType = 'InstitutionID';
                }

                $re = array();
                for ($i =1; $i<4; $i++) { //分别是 住宅，企业，机关
                    $tempData = Db::name('rent_order')
                        ->field('sum(HousePrerent) as HousePrerents , sum(PaidRent) as PaidRents ,sum(CutRent) as CutRents,sum(UnpaidRent) as UnpaidRents, UseNature ,InstitutionID ,InstitutionPID')
                        ->where($where)
                        ->where('UseNature','eq',$i)
                        ->where($wheres)
                        ->group($groupType)
                        ->select();
                    if($tempData){
                        foreach ($tempData as $k1 => $v1) {
                            $re[] = $v1[$groupType];
                            $resNowYearPaid[$v1[$groupType]][$i] = $v1['PaidRents'];  //计算实收累计,$res[机构id][使用性质] = 本年度已缴的总金额
                            $resNowYearUnpaid[$v1[$groupType]][$i] = $v1['UnpaidRents'];  //计算欠缴累计,$res[机构id][使用性质] = 本年度欠缴的总金额
                            $resNowYearPrerent[$v1[$groupType]][$i] = $v1['HousePrerents'];  //计算规定租金累计,$res[机构id][使用性质] = 本年度规定租金总金额
                            $resNowYearCutrent[$v1[$groupType]][$i] = $v1['CutRents'];  //计算减免租金累计,$res[机构id][使用性质] = 本年度减免租金总金额
                            //$data[$v1[$groupType]][$i] = $v1;
                        }
                    }
                }

//                if($data){
//                    foreach ($data as $k3 => $v3) {
//                        $datas[$k3]['totalHousePrerents'] = 0;
//                        $datas[$k3]['totalCutRents'] = 0;
//                        foreach ($v3 as $k4 => $v4) {
//                            $datas[$k3]['totalHousePrerents'] += $v4['HousePrerents'];
//                            $datas[$k3]['totalCutRents'] += $v4['CutRents'];
//                        }
//                    }
//                }

                /*获取以前年的数据*/
                $oldData = Db::name('rent_order')
                    ->field('sum(HousePrerent) as HousePrerents , sum(UnpaidRent) as UnpaidRents, sum(PaidRent) as PaidRents ,sum(CutRent) as CutRents, UseNature ,InstitutionID ,InstitutionPID')
                    ->where($where)
                    ->where($options)
                    ->group($groupType)
                    ->select();
                foreach ($oldData as $k4 => $v4) {
                    $oldDatas[$v4[$groupType]] = $v4;
                }

                /*获取从以前到现在的数据*/
                $allData = Db::name('rent_order')
                    ->field('sum(UnpaidRent) as UnpaidRents, sum(PaidRent) as PaidRents ,sum(CutRent) as CutRents, UseNature ,InstitutionID ,InstitutionPID')
                    ->where($where)
                    ->group($groupType)
                    ->select();
                //halt($groupType);
                //halt($allData);
                foreach ($allData as $k5 => $v5) {
                    $allDatas[$v5[$groupType]] = $v5;
                }

                $re = array_unique($re);
                sort($re);
                foreach ($re as $k2 => $v2) { //遍历机构集合，$v2为每个机构的id

                    if(!isset($resNowYearPaid[$v2][1])){$resNowYearPaid[$v2][1] = 0;}
                    if(!isset($resNowYearPaid[$v2][2])){$resNowYearPaid[$v2][2] = 0;}
                    if(!isset($resNowYearPaid[$v2][3])){$resNowYearPaid[$v2][3] = 0;}

                    $result[$ower][$v2][0] = $allInstitutionTypes[$v2];    //机构名称
                    $result[$ower][$v2][1] = $yearPlanDatas[$v2]['YearPlan'];  //年计划数
                    $result[$ower][$v2][2] = array_sum($resNowYearPaid[$v2]); //实收累计【未处理】实际上还需要加上以前年的实收的，只是以前年的数据没有
                    $result[$ower][$v2][3] = round(($result[$ower][$v2][2]/$result[$ower][$v2][1])*100,2).'%';   //占年计划
                    $result[$ower][$v2][4] = round(($resNowYearPaid[$v2][2]/$yearPlanDatas[$v2]['EnterprisePlan'])*100,2).'%';  //企事业占年计划
                    $result[$ower][$v2][5] = round(($resNowYearPaid[$v2][3]/$yearPlanDatas[$v2]['PartyPlan'])*100,2).'%';  //机关占年计划
                    $result[$ower][$v2][6] = round(($resNowYearPaid[$v2][1]/$yearPlanDatas[$v2]['CivilPlan'])*100,2).'%';  //民用占年计划
                    $result[$ower][$v2][7] = array_sum($resNowYearPrerent[$v2]);    //规定租金
                    $result[$ower][$v2][8] = round(($result[$ower][$v2][2]/($result[$ower][$v2][7]-array_sum($resNowYearCutrent[$v2])))*100,2).'%'; //收缴率
                    $result[$ower][$v2][9] = $result[$ower][$v2][2]; //本年度实收金额
                    $result[$ower][$v2][10] = round($result[$ower][$v2][9]/($result[$ower][$v2][9]+array_sum($resNowYearUnpaid[$v2]))*100,2).'%';   //回收率【未处理】
                    $result[$ower][$v2][11] = 0;     //以前年度金额
                    $result[$ower][$v2][12] = 0;   //其中：在册陈欠
                    $result[$ower][$v2][13] = '0%';   //回收率【未处理】
                    $result[$ower][$v2][14] = array_sum($resNowYearCutrent[$v2]);    //损失金额
                    $result[$ower][$v2][15] = isset($resNowYearCutrent[$v2][2])?$resNowYearCutrent[$v2][2]:0;   //其中：企事业折减额【未处理】
                    $result[$ower][$v2][16] = round(($result[$ower][$v2][14]/$result[$ower][$v2][7])*100,2).'%'; //损失率
                    $result[$ower][$v2][17] = isset($allDatas[$v2])?$allDatas[$v2]['UnpaidRents']:0;   //从前到现在总金额
                    $result[$ower][$v2][18] = array_sum($resNowYearUnpaid[$v2]);   //其中：本年结欠【未处理】
                }
            }
        }

        $ziyang = Db::name('institution')->where('pid','eq',2)->column('id');
        $liangdao = Db::name('institution')->where('pid','eq',3)->column('id');


        foreach ($result as $rek => $rev) {
            foreach ($rev as $revk => $revv) {
                if($revk == 2 || $revk == 3){
                    $results[$rek][1][] = $revv;
                }
                if(in_array($revk,$ziyang)){
                    $results[$rek][2][] = $revv;
                    $results[$rek][$revk] = $revv;
                }
                if(in_array($revk,$liangdao)){
                    $results[$rek][3][] = $revv;
                    $results[$rek][$revk] = $revv;
                }
            }
        }

        return $results;
    }
}