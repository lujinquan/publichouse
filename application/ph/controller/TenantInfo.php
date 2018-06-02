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

    public function detail(){
        $tenantID = input('TenantID');

        if($tenantID){

            //所有楼栋基础信息
            $tenantDetail = $this -> TenantInfoModel ->get_one_ban_detail_info($tenantID);

            return jsons(2000,'获取成功',$tenantDetail);

        }
    }

}
