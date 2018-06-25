<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Loader;
use think\Db;
use util\Tree;

class RentPayable extends Model
{
    public function batch_debit(){

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }
        $where['OrderDate'] = array('eq' ,date('Ym',time()));
        $where['Type'] = array('eq' ,1);
        $where['IfPaidable'] = array('eq' ,0);
        //执行扣缴操作
        $data = Db::name('rent_order')->where($where)->field('RentOrderID ,HouseID ,TenantID ,ReceiveRent')->select();
        if(!$data){
            return jsons('4003' ,'没有'.date('Ym',time()).'月份的订单');
        }
        foreach($data as $k1 => $v1){
            $tenantBalance = Db::name('house')->where('HouseID',$v1['HouseID'])->value('RechargeRent');
            if($tenantBalance >= $v1['ReceiveRent']){   //如果账户余额充足
                //dump($v1['ReceiveRent']);halt($tenantBalance);
                $res = Db::name('house')->where('HouseID' ,'eq' ,$v1['HouseID'])->setDec('RechargeRent',$v1['ReceiveRent']);
                if($res){
                    Db::name('tenant')->where('TenantID' ,'eq' ,$v1['TenantID'])->setDec('TenantBalance',$v1['ReceiveRent']);
                    $rentOrderID[] = $v1['RentOrderID'];
                }
            }
        }
        if(!isset($rentOrderID)){
            return jsons('4005' ,'没有满足扣缴条件的订单');
        }
        $where['RentOrderID'] = array('in',$rentOrderID);
        $data = Db::name('rent_order')->where($where)->field('RentOrderID ,ReceiveRent')->select();
        foreach($data as $v){
            Db::name('rent_order')->where('RentOrderID','eq',$v['RentOrderID'])->update(['PaidRent'=> $v['ReceiveRent'],'IfPaidable' =>1, 'Type' =>3, 'UnpaidRent' =>0, 'PaidableTime' => time()]);
            //halt(Db::name('rent_order')->getLastSql());
        }
        return true;

    }

    public function batch_pay($ids){

        $re = Db::name('rent_order')->where('RentOrderID','in',$ids)->update(['Type'=>3 ,'UnpaidRent' =>0]);

        $data = Db::name('rent_order')->where('RentOrderID','in',$ids)->field('RentOrderID ,ReceiveRent ,PaidRent')->select();

        foreach($data as $v){

            Db::name('rent_order')->where('RentOrderID','eq',$v['RentOrderID'])->setField('PaidRent',$v['ReceiveRent']);
        }

        return true;
    }

    public function batch_sign($ids){

        $re = Db::name('rent_order')->where('RentOrderID','in',$ids)->update(['Type'=>3 ,'UnpaidRent' =>0]);

        $data = Db::name('rent_order')->where('RentOrderID','in',$ids)->field('RentOrderID ,ReceiveRent ,PaidRent')->select();

        foreach($data as $v){

            Db::name('rent_order')->where('RentOrderID','eq',$v['RentOrderID'])->setField('IfBatchSign',1);
        }

        return true;
    }

}