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

class RentCutReport extends Model
{
    /**
     * 核减租金汇总表缓存数据
     * 机制：将所有产别，机构按照多维数组序列化存储，$data[产别][机构]
     * 这样要取出某个产别和机构的数据时直接读取缓存中的对应结构即可
     */
    public function index(){

        $owerLst = [1,3,7];
        $instLst = Db::name('institution')->column('id');
        $nowDate = date('Ym',time());
        $oldDate = date('Ym',strtotime('-1 month'));
        $startDate = date('Y',time()).'00';

        // $nowDate = '201802';
        // $oldDate = '201801';
        // $startDate = '201800';
        /*初始化条件*/

        $option['OrderDate'] = array('between',[$startDate,$oldDate]);
        $options['OrderDate'] = array('between',[$startDate,$nowDate]);
        $newWhere['OrderDate'] = array('eq', $nowDate);
        $oldWhere['OrderDate'] = array('eq', $oldDate);


        /*获取从查询的1月份到查询日期前一个月的累计减免*/
        foreach ($owerLst as $v) { //产别

            foreach ($instLst as $v2) {  //机构
                $where = array();
                $where['a.OwnerType'] = array('eq', $v);
                $where['CutType'] = array('neq',0);
                if($v2 == 2 || $v2 == 3){
                    $where['a.InstitutionPID'] = $v2;
                }elseif($v2 > 3){
                    $where['a.InstitutionID'] = $v2;
                }

                $lastData = Db::name('rent_order')->alias('a')
                    ->join('house b','a.HouseID = b.HouseID','left')
                    ->field('count(a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
                    ->where($where)
                    ->where($option)
                    ->find();
                /*获取从查询的1月份到查询日期的累计数据*/
                $totalData = Db::name('rent_order')->alias('a')
                    ->join('house b','a.HouseID = b.HouseID','left')
                    ->field('count(distinct a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
                    ->where($where)
                    ->where($options)
                    ->find();

                $oldData = Db::name('rent_order')->alias('a')
                    ->join('house b','a.HouseID = b.HouseID','left')
                    ->field('count(distinct a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
                    ->where($where)
                    ->where($oldWhere)
                    ->find();

                $newData = Db::name('rent_order')->alias('a')
                    ->join('house b','a.HouseID = b.HouseID','left')
                    ->join('ban c','b.BanID = c.BanID','left')
                    ->field('count(distinct a.id) as ids,sum(b.HouseUsearea) as HouseUseareas, sum(a.HousePrerent) as HousePrerents ,sum(a.CutRent) as CutRents,sum(a.PaidRent) as PaidRents')
                    ->where($where)
                    ->where($newWhere)
                    ->find();

                $result[$v][$v2][0]['ids'] = $oldData['ids']?$oldData['ids']:0;
                $result[$v][$v2][0]['HouseUseareas'] = $oldData['HouseUseareas']?$oldData['HouseUseareas']:0;
                $result[$v][$v2][0]['HousePrerents'] = $oldData['HousePrerents']?$oldData['HousePrerents']:0;
                $result[$v][$v2][0]['CutRents'] = $oldData['CutRents']?$oldData['CutRents']:0;
                $result[$v][$v2][0]['PaidRents'] = $oldData['PaidRents']?$oldData['PaidRents']:0;
                $result[$v][$v2][0]['LastCutRents'] = $lastData['CutRents']?$lastData['CutRents']:0;

                $result[$v][$v2][1]['ids'] = $newData['ids']?$newData['ids']:0;
                $result[$v][$v2][1]['HouseUseareas'] = $newData['HouseUseareas']?$newData['HouseUseareas']:0;
                $result[$v][$v2][1]['HousePrerents'] = $newData['HousePrerents']?$newData['HousePrerents']:0;
                $result[$v][$v2][1]['CutRents'] = $newData['CutRents']?$newData['CutRents']:0;
                $result[$v][$v2][1]['PaidRents'] = $newData['PaidRents']?$newData['PaidRents']:0;
                $result[$v][$v2][1]['LastCutRents'] = $newData['CutRents']?$newData['CutRents']:0;

                $result[$v][$v2][2]['ids'] = $result[$v][$v2][0]['ids']+$result[$v][$v2][1]['ids'];
                $result[$v][$v2][2]['HouseUseareas'] = $result[$v][$v2][0]['HouseUseareas']+$result[$v][$v2][1]['HouseUseareas'];
                $result[$v][$v2][2]['HousePrerents'] = $result[$v][$v2][0]['HousePrerents']+$result[$v][$v2][1]['HousePrerents'];
                $result[$v][$v2][2]['CutRents'] = $result[$v][$v2][0]['CutRents']+$result[$v][$v2][1]['CutRents'];
                $result[$v][$v2][2]['PaidRents'] = $result[$v][$v2][0]['PaidRents']+$result[$v][$v2][1]['PaidRents'];
                $result[$v][$v2][2]['LastCutRents'] = $totalData['CutRents']?$totalData['CutRents']:0;

            }

        }

        return $result;
    }
}