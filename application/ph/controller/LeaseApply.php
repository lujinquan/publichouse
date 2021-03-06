<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\HouseInfo as HouseInfoModel;
use think\Db;

/**
 * @title 使用权变更申请控制器
 * @author Mr.Lu
 * @description
 */
class LeaseApply extends Base
{
    /**
     * @title 使用权变更申请主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/LeaseApply') -> get_all_lease_lst($flag = 'apply');
        
        $this -> assign([
            'leaseLst' => $data['arr'],
            'leaseLstObj' => $data['obj'],
            'leaseOption' => $data['option'],
        ]);

        return $this->fetch();
    }

    /**
     * @title 添加申请
     * @author Mr.Lu
     * @description
     */
    public function add(){
        if ($this->request->isPost()) {
            if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
            // $data = $this->request->post();
            $data = array_no_space_str($this->request->post());
            //halt($data);
            $f = Db::name('lease_change_order')->where(['HouseID'=>$data['houseID'],'Status'=>['>',1]])->find();

            if($f){
                return jsons('4000','请勿重复申请');
            }

            $unpaidRent = Db::name('rent_order')->where(['HouseID'=>$data['houseID']])->sum('UnpaidRent');

            if($unpaidRent > 0){
                return jsons('4002','该房屋累计欠租'.$unpaidRent.'元，无法申请租约！');
            }
            

            if (isset($_FILES) && $_FILES) {   //文件上传
                foreach ($_FILES as $k => $v) {
                    $ChangeImageIDS[] = model('LeaseApply')->uploads($v, $k);
                }
                $ChangeImageIDS = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
            }


            $one = Db::name('house')->alias('a')
                                  ->join('ban b','a.BanID = b.BanID','left')
                                  ->join('tenant c','a.TenantID = c.TenantID','left')
                                  ->field('a.Szno,a.BanAddress,a.InstitutionID,a.InstitutionPID,a.UseNature,a.OwnerType,b.StructureType,b.BanFloorNum,a.FloorID,c.TenantID,c.TenantName')
                                  ->where('a.HouseID',$data['houseID'])
                                  ->find();  
            if(!$one['InstitutionID']){
                return jsons('4000','注意房屋编号前后空格，请刷新页面后，再次提交！');
            }

            $val = Db::name('config')->where('id',1)->value('Value'); 
            $datas['Recorde'] = $data['Recorde'];
            $datas['Szno'] = $one['Szno'].$val;
            $datas['InstitutionID'] = $one['InstitutionID'];
            $datas['InstitutionPID'] = $one['InstitutionPID'];
            $datas['BanAddress'] = $one['BanAddress'];
            $datas['UseNature'] = $one['UseNature'];
            $datas['OwnerType'] = $one['OwnerType'];
            $datas['StructureType'] = $one['StructureType'];
            $datas['FloorNum'] = $one['BanFloorNum'];
            $datas['FloorID'] = $one['FloorID'];
            $datas['TenantID'] = $one['TenantID']; //新租户id
            $datas['TenantName'] = $one['TenantName']; //新租户名称
            $datas['HouseID'] = $data['houseID'];
            $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:''; 
            $datas['ChangeOrderID'] = date('YmdHis', time()).'101'.substr(uniqid(),-5);
            $datas['CreateTime'] = time();

            $datas['Deadline'] = json_encode($data);
            $s[] = [
                'Step' => 1,
                'Reson' => '',
                'IfValid' => 1,
                'UserNumber' => UID,
                'CreateTime' => $datas['CreateTime'],
            ];

            $datas['Child'] = json_encode($s);

            $id = Db::name('process_config')->where(['Type'=>101,'Status'=>1])->max('id');
            if($id){
                $datas['ProcessConfigType'] = $id;
            }else{
                return jsons('4000','请先配置租约申请流程！');
            }

            $datas['Status'] = 2; //待审批状态
//halt($datas);
            if (Db::name('lease_change_order')->insert($datas)) {

                return jsons('2000', '添加成功');
            } else {

                return jsons('4000', '添加失败');
            }

        }
    }

    /**
     * @title 删除租约申请
     * @author Mr.Lu
     * @description
     */
    public function delete(){
        if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }

        $orderID = input('ChangeOrderID');

        $status = Db::name('lease_change_order')->where('ChangeOrderID',$orderID)->value('Status');
        
        if($status != 2){
            return jsons('4005' ,'已进入审核状态无法删除');
        }else{
            Db::name('lease_change_order')->where('ChangeOrderID',$orderID)->delete();
            action_log('LeaseApply_delete', UID  ,101, '变更编号:'.$orderID);
            return jsons(2000 ,'删除成功');
        }

    }
}