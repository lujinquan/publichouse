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

class RentDebit extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__RENT_ORDER__';

    public function revoke($rentOrderID){

        $res = Db::name('rent_order')->field('IfPaidable ,ReceiveRent ,PaidRent ,UnpaidRent ,Type ,TenantID')
                                     ->where('RentOrderID' ,'eq' ,$rentOrderID)
                                     ->find();

        if(!$res){
            return jsons('4001','撤销失败');
        }

        Db::name('rent_order')->where('RentOrderID' ,'eq' ,$rentOrderID)->update(['IfPaidable' => 0, 'PaidRent' => 0, 'UnpaidRent' => $res['ReceiveRent'],'Type' => 1 ,'PaidableTime' => 0]);

        Db::name('tenant')->where('TenantID' ,'eq' ,$res['TenantID'])->setInc('TenantBalance',$res['ReceiveRent']);

    }

}