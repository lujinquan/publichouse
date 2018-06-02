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

            //检查当前充值的租户是否位于当前机构
//            $tenantInstitutionID = Db::name('tenant')->where('TenantID' ,'eq' ,$data['TenantID'])->value('InstitutionID');
//            $currentUserInstitutionID = session('user_base_info.institution_id');
//            $currentUserLevel = session('user_base_info.institution_level');
//            if($currentUserLevel == 3){  //用户为管段级别，则直接查询
//                $option[] = $currentUserInstitutionID;
//            }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
//                $option = Db::name('institution')->where('pid' ,'eq' ,$currentUserInstitutionID)->column('id');
//            }else{    //用户为公司级别，则获取所有子管段
//                $option = Db::name('institution')->where('Level' ,'eq' ,3)->column('id');
//            }
//            if(!in_array($tenantInstitutionID ,$option )){
//                return jsons('4000' ,'请确认该租户是否属于当前机构……');
//            }



            $where = [
                    'Status' => 1,
                    'HouseID' => $data['HouseID'],
                ];
            $tenantid = Db::name('house')->where($where)->value('TenantID');
            if(!$tenantid){
                return jsons('4001','房屋为非正常状态……');
            }
            Db::name('house')->where('HouseID','eq',$data['HouseID'])->setInc('RechargeRent',$data['Money']);
            $re = Db::name('tenant')->where('TenantID' ,'eq' ,$tenantid)->setInc('TenantBalance',$data['Money']);
            if($re){
                $one = Db::name('tenant')->where('TenantID' ,'eq' ,$tenantid)->field('TenantName,TenantTel,TenantBalance,InstitutionID,InstitutionPID')->find();
                $data['TenantID'] = $tenantid;
                $data['TenantName'] = $one['TenantName'];
                $data['InstitutionID'] = $one['InstitutionID'];
                $data['InstitutionPID'] = $one['InstitutionPID'];
                $data['CurrMoney'] = $one['TenantBalance'];
                $data['CreateUserID'] = UID;
                $data['CreateTime'] = time();
                $data['TenantTel'] = $one['TenantTel'];
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


    }


}