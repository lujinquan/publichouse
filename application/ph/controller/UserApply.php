<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

/**
 * @title 使用权变更申请控制器
 * @author Mr.Lu
 * @description
 */
class UserApply extends Base
{
    /**
     * @title 使用权变更申请主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/UserApply') -> get_all_use_lst();

        $useChanges = Db::name('use_change_type')->field('id, UseChangeTitle')->select();
        
        $this -> assign([
            'useChanges'=> $useChanges,
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

            $data = $this->request->post();

            if ($data['type'] == 1) {  //更名
                $datas['HouseID'] = $data['houseid']; //房屋编号
                $datas['OldTenantID'] = $data['tenantid'];  //租户编号
                $datas['OldTenantName'] = $data['oldName']; //原租户名称

                if(empty($data['newName']) || empty($data['houseid'])) return jsons('4005' ,'请完善相关信息！');

                $datas['NewTenantName'] = $data['newName']; //新租户名称
            } else {  //过户 ，赠予 ，转让
                $datas['HouseID'] = $data['houseid']; //房屋编号
                $datas['OldTenantID'] = $data['oldID']; //原租户id
                $datas['OldTenantName'] = $data['oldName']; //原租户名称
                $datas['NewTenantID'] = $data['newID']; //新租户id
                $datas['NewTenantName'] = $data['newName']; //新租户名称

                if(empty($data['newID']) || empty($data['newName']) || empty($data['houseid'])) return jsons('4005' ,'请完善相关信息！');
            }

            $datas['ChangeType'] = $data['type']; //申请的类型：1，更名，2，正常过户，3，转赠亲友，4，转让


            $one = Db::name('house')->where('HouseID', 'eq', $data['houseid'])->field('InstitutionPID ,InstitutionID')->find();

            $datas['InstitutionID'] = $one['InstitutionID'];
            $datas['InstitutionPID'] = $one['InstitutionPID'];

            $datas['ChangeOrderID'] = date('YmdHis', time());
            //$datas['InstitutionID'] = session('user_base_info.institution_id'); //机构id(此处登记的是当前房管员的所属机构)
            $datas['UserNumber'] = UID; //操作人id
            $datas['CreateTime'] = time();
            $datas['ProcessConfigType'] = 100;  //100为使用权变更(对应change_type表)
            $datas['Status'] = 2; //待审批状态

            if (Db::name('use_change_order')->insert($datas)) {

                // 记录行为
                action_log('UserApply_add', UID  ,7, '变更编号:'.$datas['ChangeOrderID']);
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
        $map = 'HouseID ,ChangeType , OldTenantID ,OldTenantName , NewTenantID ,NewTenantName';
        $oldData = Db::name('use_change_order')->field($map)->where('ChangeOrderID' ,'eq' ,$orderID)->find();
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