<?php
/**
 * 租金欠缴控制器
 */
namespace app\ph\controller;

use think\Db;

class RentUnpaid extends Base
{
    /**
     *  控制器主页
     */
    public function index(){

        $rentLst = model('ph/RentCount') ->get_all_rent_order_lst(array('Type'=>2,));

        //halt($rentLst['arr']);

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
     *  批量催缴
     */
    public function batchCall(){

        $ids = $_POST['value'];

        return jsons('4002','由于短信付费，功能暂时关闭……');

        if(!$ids){

            return jsons('4001' ,'参数错误');
        }

        model('ph/RentUnpaid') ->batch_call($ids);
    }

    /**
     *  批量缴费
     */
    public function payAll(){

        $ids = $_POST['value'];

        if(!$ids){

            return jsons('4001' ,'参数错误');
        }

        $orders = Db::name('rent_order')->where(['RentOrderID'=>['in',$ids],'OrderDate'=>['neq',date('Ym',time())]])->field('OwnerType,UseNature,InstitutionID,InstitutionPID,TenantID,UnpaidRent,TenantName,BanAddress,HouseID,HousePrerent,OrderDate,CreateTime')->select();
        $str =  '';
        
        foreach($orders as $v){

            $PayYear = date('Y',$v['CreateTime']);
            $OldPayMonth = date('Ym',time());

            $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
            $str .= "," . $v['HousePrerent'] . "," . $v['UnpaidRent'] . "," . $PayYear . "," . $v['OrderDate'] . "," . $OldPayMonth . ",'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'].  "," . UID . "," . time() . "),";
        }

        if($str){

            $res = Db::execute("insert into ".config('database.prefix')."old_rent (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,PayRent,PayYear,PayMonth,OldPayMonth,TenantName,BanAddress,OwnerType,UseNature,CreateUserID,CreateTime) values " . rtrim($str, ','));
        }

        $bool = Db::name('rent_order')->where(['RentOrderID'=>['in',$ids]])->update(['Type'=> 3 ,'PaidRent'=> ['exp','ReceiveRent'],'UnpaidRent'=>0]);

        return $bool?jsons('2000' ,'操作成功'):jsons('4000' ,'操作失败');

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

        return $bool?jsons('2000' ,'撤销成功'):jsons('4000' ,'往期订单无法撤销');
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
                Db::name('rent_order')->where($where)->setDec('UnpaidRent', $data['cost']);
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
                'CreateDate' => date('Ym',time()),
                'CreateUserID' => UID,
                'CreateTime' => time(),
            ];
            //halt($results);
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

    /**
     *  明细
     */
    public function detail(){

    }



}