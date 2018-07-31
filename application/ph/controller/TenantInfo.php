<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Config;
use app\ph\model\TenantInfo as TenantInfoModel;
use think\Db;

class TenantInfo extends Base
{

    public function index()
    {

        //所有租户基础信息
        $tenantLst = $this -> TenantInfoModel ->get_all_tenant_lst(1);
        //所有机构
        //$instLst = $this -> BanInfoModel ->get_all_institution();
//halt($instLst);
        //dump($tenantLst);exit;

        $this->assign([
            'tenantLst'  => $tenantLst['arr'],
            'tenantLstObj'  => $tenantLst['obj'],
            'tenantOption'  => $tenantLst['option'],
            //'instLst' => $instLst,
        ]);

        return $this->fetch();
    }

    public function  add(){
        // 保存数据
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
//            if($_FILES['TenantImageIDS']){   //当上传图片
//                $fileID = $this -> TenantInfoModel -> uploads($_FILES['TenantImageIDS']);  //返回的是该租户的影像资料id(目前只能上传一张，所以只有一个id)
//                $data['TenantImageIDS'] = $fileID;  //写入数据表
//            }
            $maxid = Db::name('tenant')->max('TenantID');
            $result = $this->validate($data,'TenantInfo');
            if(true !== $result) {
                return jsons('4001',$result);

            }
            $data['InstitutionID'] = session('user_base_info.institution_id');

            $data['InstitutionPID'] = Db::name('institution')->where('id','eq',$data['InstitutionID'])->value('pid');

            $data['TenantValue'] = $data['TenantValue']?$data['TenantValue']:100;
            $data['CreateUserID'] = UID;
            if($maxid){
               $data['TenantID'] = $maxid + 1; 
            }else{
               $data['TenantID'] = 10000;
            }
            $data['Status'] = 1;
            if ($tenantInfo = TenantInfoModel::create($data)) {
                // 记录行为
                action_log('TenantInfo_add', UID  ,3 , '编号为:'.$data['TenantID']);
                return jsons('2000' ,'新增成功');
            } else {
                return jsons('2000' ,'新增失败');
            }
        }
        echo '没有数据！';
    }

    public function  edit(){
        $tenantID = input('TenantID');
        if($this->request->isPost()){
            $data = array_no_space_str($this->request->post());

            $result = $this->validate($data,'TenantInfo');
            if(true !== $result) {
                return jsons('4001',$result);
            }
            $data['Status'] = 1; //状态改为未确认状态
            $data['UpdateTime'] = time();
            $fields = 'TenantName,TenantTel,TenantAge,TenantWeChat,TenantNumber,BankID,ArrearRent,TenantSex,TenantBalance,TenantQQ,BankName,TenantValue';
            $oldOneData = Db::name('tenant')->field($fields)->where('TenantID', 'eq', $tenantID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = Config::get($k1);
                }
            }
            $data['InstitutionID'] = session('user_base_info.institution_id');
            $data['InstitutionPID'] = Db::name('institution')->where('id', 'eq', $data['InstitutionID'])->value('pid');

            $res = Db::name('tenant')->where('TenantID','eq',$data['TenantID'])->update($data);
            if ($res >0 || $res===0 ) {

                if($data['TenantName']){  //修改了租户的姓名后，将房屋里面绑定的该租户id的租户姓名同时改掉，后续可删掉此功能
                    Db::name('house')->where('TenantID',$data['TenantID'])->setField('TenantName',$data['TenantName']);
                }

                if(!isset($allData)){ $allData = array(); }
                // 记录行为
                action_log('TenantInfo_edit', UID  ,3 , '编号为:'.$data['TenantID'],json_encode($allData));
                return jsons('2000' ,'更新成功');
            }else{
                return jsons('4000' ,'更新失败，参数异常');
            }
        }

        $map = 'TenantID ,TenantName ,TenantTel ,TenantAge ,TenantSex ,TenantBalance ,ArrearRent ,TenantNumber ,BankName , BankID ,  TenantQQ , TenantWeChat , TenantValue';

        $data = Db::name('tenant')->field($map)->where('TenantID','eq',$tenantID)->find();

        if($data){
            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');
    }

    public function  delete(){
        $tenantID = input('TenantID');
        $style = input('style');
        if(!$tenantID || !$style){
            return jsons(4004 ,'参数异常……');
        }else{
            $houseid = Db::name('house')->where('TenantID',$tenantID)->value('HouseID');

            if($houseid){
                return jsons(4001 ,'该租户已绑定编号为：'.$houseid.'的房屋，请先解绑！');
            }
            $res = Db::name('tenant')->where('TenantID' ,'eq' ,$tenantID)->setField('Status',$style);
            
            if($res){
                // 记录行为
                action_log('TenantInfo_delete', UID  ,3 , '编号为:'.$tenantID);
                return jsons(2000 ,'删除成功');
            }else{
                return jsons(4000 ,'删除失败，参数异常！');
            }
        }
    }


    public function detail(){
        $tenantID = input('TenantID');

        //halt($tenantID);

        if($tenantID){

            //所有楼栋基础信息
            $tenantDetail = $this -> TenantInfoModel ->get_one_tenant_detail_info($tenantID);

            return jsons(2000,'获取成功',$tenantDetail);

        }
    }

}
