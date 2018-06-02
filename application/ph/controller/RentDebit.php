<?php
/**
 * 租金扣缴控制器
 */
namespace app\ph\controller;

use think\Db;

class RentDebit extends Base
{
    /**
     *  控制器主页
     */
    public function index(){

        $rentLst = model('ph/RentCount') ->get_all_rent_order_lst(array('Type'=>3,'IfPaidable'=>1));

        $this->assign([
            'rentLst' => $rentLst['arr'],
            'rentLstObj' => $rentLst['obj'],
            'rentOption' => $rentLst['option'],
        ]);

        return $this->fetch();
    }

    /**
     *  批量撤销扣缴
     */
    public function batchRevoke(){

        $ids = $_POST['value'];

        if(!$ids){
            return jsons('4001' ,'参数错误');
        }

        foreach($ids as $v){
            model('ph/RentDebit')->revoke($v);
        }

        return jsons('2000' ,'批量撤销成功');
    }

    /**
     *  扣缴明细
     */
    public function detail(){

    }

    /**
     *  撤销
     */
    public function revoke(){

        $rentOrderID = input('RentOrderID');

        model('ph/RentDebit')->revoke($rentOrderID);

        return jsons('2000' ,'撤销成功');
    }


}