<?php
/**
 * 租金已缴控制器
 */
namespace app\ph\controller;

use think\Db;

class RentPaid extends Base
{
    /**
     *  控制器主页
     */
    public function index(){

        //条件：Type 为已缴状态 ，IfPaidable 为非扣缴状态
        $rentLst = model('ph/RentCount') ->get_all_rent_order_lst(array('Type'=>3,'IfPaidable'=>0));

        $this->assign([
            'rentLst' => $rentLst['arr'],
            'unpaidRents' => $rentLst['UnpaidRents'],
            'paidRents' => $rentLst['PaidRents'],
            'receiveRents' => $rentLst['ReceiveRents'],
            'rentLstObj' => $rentLst['obj'],
            'rentOption' => $rentLst['option'],
        ]);
        return $this->fetch();
    }

    /**
     *  批量标记打印发票
     */
    public function batchSign(){
        $ids = $_POST['value'];

        if(!$ids){
            return jsons('4001' ,'参数错误');
        }

        model('ph/RentPayable') ->batch_sign($ids);

        return jsons('2000' ,'批量缴费成功');
    }

    /**
     *  批量欠费
     */
    public function batchCut(){

    }

    /**
     *  批量撤销
     */
    public function payBack(){

        $ids = $_POST['value'];

        if(!$ids){

            return jsons('4001' ,'参数错误');
        }

        $bool = Db::name('rent_order')->where(['RentOrderID'=>['in',$ids],'OrderDate'=>date('Ym',time())])->update(['Type'=> 1 ,'PaidRent'=>0,'UnpaidRent'=> ['exp','ReceiveRent']]);

        return $bool?jsons('2000' ,'撤销成功'):jsons('4000' ,'撤销订单不合法');
    }

    /**
     *  明细
     */
    public function detail(){

        $rentOrderID = input('RentOrderID');

        $data = model('ph/RentCount')->get_one_rent_order_info($rentOrderID);

        if($data){

            return jsons('2000' ,'获取成功' ,$data);
        }else{

            return jsons('4000' ,'获取失败');
        }
    }

    /**
     *  打印发票
     */
    public function invoice(){

    }


}