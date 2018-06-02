<?php
/**
 * 租金应缴控制器
 */
namespace app\ph\controller;

use think\Db;

class RentPayable extends Base
{
    /**
     *  控制器主页
     */
    public function index(){

        //条件：Type 为应缴状态,且不显示当前月份的前面月的租金订单
        $currDate = date('Ym',time());
        //$rentLst = model('ph/RentCount') ->get_all_rent_order_lst(array('Type'=>1,'OrderDate'=>array('>=',$currDate)));
        $rentLst = model('ph/RentCount') ->get_all_rent_order_lst(array('Type'=>1));
        //halt($rentLst['arr']);
        $owerLst = $this->BanInfoModel->get_all_owner_type();
        $this->assign([
            'owerLst' => $owerLst,
            'rentLst' => $rentLst['arr'],
            'rentLstObj' => $rentLst['obj'],
            'rentOption' => $rentLst['option'],
        ]);
        return $this->fetch();
    }

    /**
     *  批量缴费
     */
    public function batchPay(){
        $ids = $_POST['value'];
        if(!$ids){
            return jsons('4001' ,'参数错误');
        }
        model('ph/RentPayable') ->batch_pay($ids);
        return jsons('2000' ,'批量缴费成功');
    }

    /**
     *  批量删除
     */
    public function batchDelete(){
        $ids = $_POST['value'];
        if(!$ids){
            return jsons('4001' ,'参数错误');
        }

        $res = Db::name('rent_order')->where('RentOrderID','in',$ids)->update(['Type'=>10]);

        return $res?jsons('2000' ,'订单删除成功'):jsons('4000' ,'订单删除失败');
    }

    /**
     *  批量欠费
     */
    public function batchCut(){
        $ids = $_POST['value'];
        if(!$ids){
            return jsons('4001' ,'参数错误');
        }
        $bool = Db::name('rent_order')->where('RentOrderID','in',$ids)->update(['Type'=> 2 ,'UnpaidRentCopy'=> ['exp','UnpaidRent']]);
        return $bool?jsons('2000' ,'批量欠缴成功'):jsons('4000' ,'批量欠缴失败');
    }

    /**
     *  批量扣款
     */
    public function batchDebit(){

        $bool = model('ph/RentPayable') ->batch_debit();

        if($bool === true){

            return jsons('2000' ,'批量缴费成功');
        }else{

            return jsons('4000' ,'批量缴费失败');
        }
    }

    /**
     *  缴款
     */
    public function pay(){

        $rentOrderID = input('RentOrderID');

        if ($this->request->isPost()) {
            $data = $this->request->post();

            $where['RentOrderID'] = array('eq', $data['RentOrderID']);

            $result = Db::name('rent_order')->where($where)->field('OrderDate, InstitutionID,InstitutionPID,OwnerType,UseNature ,HouseID,UnpaidRent, PaidRent ,ReceiveRent,Type')->find();

            if ($result['UnpaidRent'] < $data['cost']) {

                return jsons('4003', '缴费金额不能超过欠缴金额');

            } elseif ($result['UnpaidRent'] == $data['cost']) {

                Db::name('rent_order')->where($where)->update(['UnpaidRent' => 0, 'Type' => 3, 'PaidRent' => $result['ReceiveRent']]);

            } else {

                if($result['Type'] == 1){
                    Db::name('rent_order')->where($where)->setDec('UnpaidRent', $data['cost']);
                    Db::name('rent_order')->where($where)->update(['UnpaidRentCopy'=>['exp','UnpaidRent']]);
                }else{
                    Db::name('rent_order')->where($where)->setDec('UnpaidRent', $data['cost']);
                }
                Db::name('rent_order')->where($where)->setField('Type', 2);
                Db::name('rent_order')->where($where)->setInc('PaidRent', $data['cost']);

            }

            $results = [
                'RentOrderID' => $data['RentOrderID'],
                'Rent' => $data['cost'],
                'OrderDate' => $result['OrderDate'],
                'InstitutionID' => $result['InstitutionID'],
                'InstitutionPID' => $result['InstitutionPID'],
                'HouseID' => $result['HouseID'],
                'OwnerType' => $result['OwnerType'],
                'UseNature' => $result['UseNature'],
                'CreateDate' => isset($data['CreateDate'])?str_replace('-','',$data['CreateDate']):date('Ym',time()),
                'CreateUserID' => UID,
                'CreateTime' => time(),
            ];

            Db::name('rent_recovery')->insert($results);

            return jsons('2000', '缴款成功');

        }


        $result = model('ph/RentCount')->get_one_rent_order_info($rentOrderID);

        //halt($result);

        $datas = [
            'HousePrerent' => $result['HousePrerent'],  //规定租金
            'CutRent' => $result['CutRent'],    //减免租金
            'PumpCost' => $result['PumpCost'],    //泵费
            'RepairCost' => $result['RepairCost'],  //维修费
            'ReceiveRent' => $result['ReceiveRent'],  //应缴租金
            'LateRent' => $result['LateRent'],  //滞纳金
            'ReceiveRent' => $result['ReceiveRent'],  //应收租金
            'PaidRent' => $result['PaidRent'],  //已缴租金
            'UnpaidRent' => $result['UnpaidRent'],  //欠缴租金
        ];

        return jsons('2000'  ,'获取成功' ,$datas);
    }
}