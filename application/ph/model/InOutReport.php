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

class InOutReport extends Model
{
    /**
     * 代托管产收支明细表缓存数据
     * 机制：将所有产别，机构按照多维数组序列化存储，$data[产别][机构]
     * 这样要取出某个产别和机构的数据时直接读取缓存中的对应结构即可
     */
    public function index(){

        $instLst = Db::name('institution')->column('id');
        $owerLst = Db::name('ban_owner_type')->where('id','in',[3,7])->column('id');

        

        foreach ($owerLst as $ower) { //产别

            foreach ($instLst as $ins) {  //机构

                $where = [];
                $where['OrderDate'] = date('Ym',time());  //默认查询当月的订单
                $where['a.OwnerType'] = array('eq', $ower);
                if ($ins == 2 || $ins == 3) {
                    $where['a.InstitutionPID'] = $ins;
                } elseif ($ins > 3) {
                    $where['a.InstitutionID'] = $ins;
                }

                $data = Db::name('rent_order')->alias('a')
                    ->join('house b','a.HouseID = b.HouseID')
                    ->join('institution c','a.InstitutionID = c.id','left')
                    ->where($where)
                    ->field('a.InstitutionID,a.TenantName,a.HousePrerent,b.HouseArea,b.BanAddress,a.HousePrerent,c.Institution')
                    ->select();
                foreach($data as $key => &$value){
                    $value['RepairCost'] = 0.2 * ($value['HousePrerent']);  //修理费是房租的20%
                    $value['HandlerCost'] = 0.15 * ($value['HousePrerent']);  //管理费是房租的15%
                    $value['Cost'] = 0.65 * ($value['HousePrerent']);  //金额是房租的65%
                }
                $result[$ower][$ins] = $data;
            }
        }

        return $result;
    }
}