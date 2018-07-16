<?php
/**
 * 租金预收管理控制器
 */
namespace app\ph\controller;

use think\Db;

class RentPre extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
        //halt($allInstitutions);
        
        $preRentLst = model('ph/RentPre') ->get_all_rent_recharge_lst();

        $this->assign([
            'preRentLst' => $preRentLst['arr'],
            'preRentLstObj' => $preRentLst['obj'],
            'preRentOption' => $preRentLst['option'],
            'rechargeMoney' => $preRentLst['rechargeMoney']
        ]);
        
        return $this->fetch();
    }

    /**
     *  批量标记打印发票
     */
    public function batchSign(){

        $ids = $_POST['id'];

        if(!$ids){
            return jsons('4001' ,'参数错误');
        }

        $re = Db::name('rent_recharge')->where('id','in',$ids)->setField('IfPrint',1);

        if($re !== 0){

            return jsons('2000' ,'批量打印成功');
        }else{

            return jsons('4000' ,'批量打印失败，请注意查看打印状态');
        }
    }

    /**
     *  充值
     */
    public function recharge(){

        if ($this->request->isPost()) {

            $data = $this->request->post();

            $where = [
                    'Status' => 1,
                    'HouseID' => $data['HouseID'],
                ];
            $houseFind = Db::name('house')->where($where)->field('TenantID,OwnerType,UseNature,InstitutionID,InstitutionPID')->find();
            if(!$houseFind['TenantID']){
                return jsons('4001','房屋为非正常状态……');
            }
            $rentOrderID = Db::name('rent_order')->where(['HouseID'=>$data['HouseID'],'Type'=>2])->find();
            if($rentOrderID){
                return jsons('4002','该房屋有欠缴订单无法预充');
            }
            Db::name('house')->where('HouseID','eq',$data['HouseID'])->setInc('RechargeRent',$data['Money']);
            $re = Db::name('tenant')->where('TenantID' ,'eq' ,$houseFind['TenantID'])->setInc('TenantBalance',$data['Money']);
            if($re){
                $one = Db::name('tenant')->where('TenantID' ,'eq' ,$houseFind['TenantID'])->field('TenantName,TenantTel,TenantBalance')->find();
                $data['TenantID'] = $houseFind['TenantID'];
                $data['TenantName'] = $one['TenantName'];
                $data['OwnerType'] = $houseFind['OwnerType'];
                $data['UseNature'] = $houseFind['UseNature'];
                $data['InstitutionID'] = $houseFind['InstitutionID'];
                $data['InstitutionPID'] = $houseFind['InstitutionPID'];
                $data['CurrMoney'] = $one['TenantBalance'];
                $data['TempDate'] = date('Ymd',time());
                $data['CreateUserID'] = UID;
                $data['CreateTime'] = time();
                //$data['TenantTel'] = $one['TenantTel'];
                $res = Db::name('rent_recharge')->insert($data);
                return $res?jsons('2000' ,'充值成功'):jsons('4000' ,'充值失败');
            }else{
                return jsons('4000' ,'充值失败');
            }

        }
    }

    /**
     *  打印发票
     */
    public function invoice(){

        return jsons('2000','功能开发中……');
    }

    /**
     *  打印发票
     */
    public function delete(){

        $id = input('id');

        $find = Db::name('rent_recharge')->where('id',$id)->find();

        if($find){

            Db::name('house')->where('HouseID','eq',$data['HouseID'])->setInc('RechargeRent',$data['Money']);
            $re = Db::name('tenant')->where('TenantID' ,'eq' ,$houseFind['TenantID'])->setInc('TenantBalance',$data['Money']);

        }
    }


}