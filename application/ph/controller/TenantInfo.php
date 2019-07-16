<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
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
            if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
            $data = array_no_space_str($this->request->post());
            
            $maxid = Db::name('tenant')->max('TenantID');
            $result = $this->validate($data,'TenantInfo');
            if(true !== $result) {
                return jsons('4001',$result);

            }
            if ($_FILES) {   //文件上传
                //halt($_FILES);
                foreach ($_FILES as $k => $v) {
                    if($v['error'] !== 0){
                        continue;
                    }

                    $TenantImageIDS[$k] = model('TenantInfo')->uploads($v, $k);
                }
                if(isset($TenantImageIDS)){
                    $data['TenantImageIDS'] = json_encode($TenantImageIDS);
                }
            }else{
                if(isset($data['IDCardFace'])){
                    unset($data['IDCardFace']);
                }
                if(isset($data['IDCardReverse'])){
                    unset($data['IDCardReverse']);
                }
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
            if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
            $data = array_no_space_str($this->request->post());

            $result = $this->validate($data,'TenantInfo');

            if(true !== $result) {
                return jsons('4001',$result);
            }
            $TenantImageIDS = [];
            if ($_FILES) {   //文件上传
                //halt($_FILES);
                foreach ($_FILES as $k => $v) {
                    if($v['error'] !== 0){
                        continue;
                    }

                    $TenantImageIDS[$k] = model('TenantInfo')->uploads($v, $k);
                }
                // if(isset($TenantImageIDS)){
                //     $data['TenantImageIDS'] = json_encode($TenantImageIDS);
                // }
            }
            //halt($TenantImageIDS);
            $data['Status'] = 1; //状态改为未确认状态
            $data['UpdateTime'] = time();
            $fields = 'TenantName,TenantTel,TenantAge,TenantWeChat,TenantImageIDS,TenantNumber,BankID,ArrearRent,TenantSex,TenantBalance,TenantQQ,BankName,TenantValue';
            $oldOneData = Db::name('tenant')->field($fields)->where('TenantID', 'eq', $tenantID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($k1 == 'TenantImageIDS'){
                    continue;
                }
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = config($k1);
                }
            }
            if(session('user_base_info.institution_level') ==3){
                $data['InstitutionID'] = session('user_base_info.institution_id');
                $data['InstitutionPID'] = Db::name('institution')->where('id', 'eq', $data['InstitutionID'])->value('pid');
            }
         
                
            //dump($data);halt($TenantImageIDS);
            if(!isset($TenantImageIDS['IDCardFace']) && $data['IDCardFaceM']){
                $TenantImageIDS['IDCardFace'] = $data['IDCardFaceM'];

            }
            if(!isset($TenantImageIDS['IDCardReverse']) && $data['IDCardReverseM']){
                $TenantImageIDS['IDCardReverse'] = $data['IDCardReverseM'];
            }
          
            $data['TenantImageIDS'] = $TenantImageIDS?json_encode($TenantImageIDS):'';
            //halt($data);
            
            unset($data['IDCardFace']);
            unset($data['IDCardFaceM']);
            unset($data['IDCardReverse']);
            unset($data['IDCardReverseM']);
            //halt($data);
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

        $map = 'TenantID ,TenantName ,TenantTel ,TenantAge ,TenantSex ,TenantBalance ,ArrearRent ,TenantNumber ,BankName , BankID , TenantImageIDS, TenantQQ , TenantWeChat , TenantValue';

        $data = Db::name('tenant')->field($map)->where('TenantID','eq',$tenantID)->find();
        if($data['TenantImageIDS']){
            //$r = json_decode($data['TenantImageIDS'],true);
            $data['TenantImageIDS'] = json_decode($data['TenantImageIDS'],true);
            if(isset($data['TenantImageIDS']['IDCardFace'])){
                $data['IDCardFace'] = Db::name('upload_file')->where('id', $data['TenantImageIDS']['IDCardFace'])->value('FileUrl');
            }
            if(isset($data['TenantImageIDS']['IDCardReverse'])){
                $data['IDCardReverse'] = Db::name('upload_file')->where('id', $data['TenantImageIDS']['IDCardReverse'])->value('FileUrl');
            }
            
              
        }
        

        if($data){
            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');
    }

    public function  delete(){
        if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
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

        $map = 'TenantID ,TenantName ,TenantTel ,TenantAge ,TenantSex ,TenantBalance ,ArrearRent ,TenantNumber ,BankName , BankID , TenantImageIDS, TenantQQ , TenantWeChat , TenantValue';

        $data = Db::name('tenant')->field($map)->where('TenantID','eq',$tenantID)->find();
        if($data['TenantImageIDS']){
            $r = json_decode($data['TenantImageIDS'],true);
            //halt($r);
            if(isset($r['IDCardFace'])){
                $data['IDCardFace'] = Db::name('upload_file')->where('id',$r['IDCardFace'])->value('FileUrl');
            }
            if(isset($r['IDCardReverse'])){
                $data['IDCardReverse'] = Db::name('upload_file')->where('id',$r['IDCardReverse'])->value('FileUrl');
            }
            
              
        }
        if($data['TenantSex'] == 1){
            $data['TenantSex'] = '男';
        }else{
            $data['TenantSex'] = '女';
        }
        

        if($data){
            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');
    }

}
