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
class CorrectApply extends Base
{
    /**
     * @title 使用权变更申请主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/CorrectApply') -> get_all_use_lst();

        // $useChanges = Db::name('use_change_type')->field('id, UseChangeTitle')->select();
        
        $this -> assign([
            //'useChanges'=> $useChanges,
            'changeLst' => $data['arr'],
            'changeLstObj' => $data['obj'],
            'changeOption' => $data['option'],
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
            $data = $this->request->post();
            //halt($data);
            if(empty($data['houseid']) || empty($data['transferName'])) {
                return jsons('4005' ,'请完善相关信息！');
            }
            if(empty($data['card'])){
               return jsons('4005' ,'请填写身份证信息！');  
            }
            if (isset($_FILES) && $_FILES) {   //文件上传
                foreach ($_FILES as $k => $v) {
                    $ChangeImageIDS[] = model('CorrectApply')->uploads($v, $k);
                }
                $ChangeImageIDS = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
            }
            $datas['HouseID'] = $data['houseid']; //房屋编号
            $datas['OldTenantID'] = $data['oldID'];  //原租户编号
            $datas['OldTenantName'] = $data['oldName']; //原租户名称
            $datas['NewTenantName'] = $data['transferName']; 
            $datas['NewCard'] = $data['card'];
            $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';


            $one = Db::name('house')->where('HouseID', 'eq', $data['houseid'])->field('InstitutionPID ,InstitutionID,OwnerType,UseNature,HousePrerent,BanAddress,HouseUsearea')->find();

            
            $datas['InstitutionID'] = $one['InstitutionID'];
            $datas['InstitutionPID'] = $one['InstitutionPID'];
            $datas['BanAddress'] = $one['BanAddress'];
            $datas['UseNature'] = $one['UseNature'];
            $datas['OwnerType'] = $one['OwnerType'];
            $datas['HousePrerent'] = $one['HousePrerent'];
            $datas['HouseUsearea'] = $one['HouseUsearea'];

            $datas['ChangeOrderID'] = date('YmdHis', time());
            //$datas['InstitutionID'] = session('user_base_info.institution_id'); //机构id(此处登记的是当前房管员的所属机构)
            $datas['UserNumber'] = UID; //操作人id
            $datas['CreateTime'] = time();

            $id = Db::name('process_config')->where('Type',199)->max('id');

            //halt($id);

            $datas['ProcessConfigType'] = 199;  //100为使用权变更(对应change_type表)
            $datas['Status'] = 2; //待审批状态

            if (Db::name('cor_change_order')->insert($datas)) {

                $dataChild = [
                    'FatherOrderID' => $datas['ChangeOrderID'],
                    'InstitutionID' => $datas['InstitutionID'],
                    'Step' => 1,
                ];

                // 记录行为
                action_log('CorrectApply_add', UID  ,7, '变更编号:'.$datas['ChangeOrderID']);
                return jsons('2000', '添加成功');
            } else {

                return jsons('4000', '添加失败');
            }

        }
    }


    /**
     * @title 修改使用权变更申请
     * @author Mr.Lu
     * @description
     */
    public function edit(){
        if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
        $orderID = input('ChangeOrderID'); //订单号
        $checkEdit = model('ph/UserApply')->check_edit($orderID);
        if($checkEdit === false){
            return jsons('4005' ,'操作失败，请注意查看审核状态……');
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $res = Db::name('use_change_order')->where('ChangeOrderID','eq',$data['ChangeOrderID'])->update($data);
            if( $res >0 || $res===0 ){
                // 记录行为
                action_log('UserApply_edit', UID  ,7, '变更编号:'.$data['ChangeOrderID']);
                return jsons('2000' ,'修改成功');
            }else{
                return jsons('4000' ,'修改失败');
            }
        }
        //$map = 'HouseID ,ChangeType , OldTenantID ,OldTenantName , NewTenantID ,NewTenantName';
        $oldData = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$orderID)->find();
        $oldData['OldTenantTel'] = Db::name('tenant')->where('TenantID','eq',$oldData['OldTenantID'])->value('TenantTel');
        $oldData['NewTenantTel'] = Db::name('tenant')->where('TenantID','eq',$oldData['NewTenantID'])->value('TenantTel');
        if(!$oldData){
            return jsons('4000' ,'订单号不存在');
        }
        return jsons('2000' ,'获取成功' , $oldData);

    }

    /**
     * @title 删除使用权变更申请
     * @author Mr.Lu
     * @description
     */
    public function delete(){
        if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
        $orderID = input('ChangeOrderID');

        $checkDelete = model('ph/UserApply')->check_delete($orderID);

        if($checkDelete === false){

            return jsons('4005' ,'友情提示，只有最终未通过的变更记录才可以删除……');
        }

        if($orderID){
            $res = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$orderID)->delete();
            if($res){

                // 记录行为
                action_log('UserApply_delete', UID  ,7, '变更编号:'.$orderID);
                return jsons(2000 ,'删除成功');

            }else{

                return jsons(4000 ,'删除失败，参数异常！');

            }
        }

        return '没有数据';
    }
}