<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Config;
use app\ph\model\TenantInfo as TenantInfoModel;
use think\Db;

class ConfirmTenantInfo extends Base
{

    public function index()
    {
        //所有租户基础信息
        $tenantLst = $this -> TenantInfoModel ->get_all_tenant_lst();
        //所有机构
        $instLst = $this -> BanInfoModel ->get_all_institution();
        $this->assign([
            'tenantLst'  => $tenantLst['arr'],
            'tenantLstObj'  => $tenantLst['obj'],
            'tenantOption'  => $tenantLst['option'],
            'instLst' => $instLst,
        ]);
        return $this->fetch();
    }

    public function  add(){

        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            $maxid = Db::name('tenant')->max('TenantID');

            if(session('user_base_info.institution_level') != 3){
                return jsons('4001','请登录房管员账号添加租户信息');
            }

            $result = $this->validate($data,'TenantInfo');
            if(true !== $result) {
                return jsons('4001',$result);

            }

            $data['InstitutionID'] = session('user_base_info.institution_id');

            $data['InstitutionPID'] = Db::name('institution')->where('id','eq',$data['InstitutionID'])->value('pid');

            //检查是否重名
            $tenantName = Db::name('tenant')->where(['TenantName'=>$data['TenantName'],'InstitutionID'=>$data['InstitutionID'],'Status'=>['between',[0,1]]])->find();
            // if($tenantName){
            //     return jsons('4000','租户名已存在！');
            // }

            $data['TenantValue'] = $data['TenantValue']?$data['TenantValue']:100;
            $data['CreateUserID'] = UID;
            if($maxid){
               $data['TenantID'] = $maxid + 1; 
            }else{
               $data['TenantID'] = 10000;
            }
            $data['Status'] = 0;

            if ($tenantInfo = TenantInfoModel::create($data)) {
                // 记录行为
                action_log('TenantInfo_add', UID  ,3 , '编号为:'.$data['TenantID']);
                return jsons('2000' ,'新增成功');
            } else {
                return jsons('2000' ,'新增失败');
            }
        }
        
    }

    public function  edit(){

        if($this->request->isPost()){
            $data = array_no_space_str($this->request->post());

            $result = $this->validate($data,'TenantInfo');
            if(true !== $result) {
                return jsons('4001',$result);
            }
            $data['UpdateTime'] = time();
            $old = Db::name('tenant')->where('TenantID',$data['TenantID'])->field('TenantName,InstitutionID')->find();

            $tenantName = Db::name('tenant')->where([
                'TenantName'=>$data['TenantName'],
                'TenantID'=>['neq',$data['TenantID']],
                'InstitutionID'=>$old['InstitutionID'],
                'Status'=>['between',[0,1]],
                ])->find();

            if($tenantName){
                return jsons('4000','租户名已存在！');
            }
        
            $res = Db::name('tenant')->where('TenantID','eq',$data['TenantID'])->update($data);

            if ($res !== false) {
                if($data['TenantName']){  
                    //修改了租户的姓名后，将房屋里面绑定的该租户id的租户姓名同时改掉，后续可删掉此功能
                    Db::name('house')->where('TenantID',$data['TenantID'])->setField('TenantName',$data['TenantName']);
                }
                return jsons('2000' ,'更新成功');
            }else{
                return jsons('4000' ,'更新失败');
            }
        }

        $data = Db::name('tenant')->where('TenantID','eq',input('TenantID'))->find();
        
        return $data?jsons('2000','获取成功',$data):jsons('4000','获取失败');
    }


    public function  delete(){
        $tenantID = input('TenantID');

        $houseid = Db::name('house')->where('TenantID',$tenantID)->value('HouseID');
        $banid = Db::name('house')->where('HouseID',$houseid)->value('BanID');
        check($banid);

        if($houseid){
            return jsons(4001 ,'该租户已绑定编号为：'.$houseid.'的房屋，请先解绑！');
        }
        $res = Db::name('tenant')->where('TenantID' ,'eq' ,$tenantID)->delete();

        return $res?jsons(2000 ,'删除成功'):jsons(4000 ,'删除失败，参数异常！');     
    }

    public function detail(){
        $tenantDetail = $this -> TenantInfoModel ->get_one_ban_detail_info(input('TenantID'));
        return jsons(2000,'获取成功',$tenantDetail);      
    }


}
