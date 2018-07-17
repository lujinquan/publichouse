<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\UserManage as UserManageModel;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class UserManage extends Base
{
    public function index(){

        $userLst = model('ph/UserManage') -> get_all_user_lst();
        $instLst = $this -> BanInfoModel ->get_all_institution();//待调
        $postLst = Db::name('post')->field('id ,PostID ,PostName')->select();
        $allRole = Db::name('admin_role')->where('Status',1)->field('id ,RoleName')->select();
        $this->assign([
            'userLst' => $userLst['arr'],
            'userLstObj' => $userLst['obj'],
            'userOption' => $userLst['option'],
            'instLst' => $instLst,
            'postLst' => $postLst,
            'allRole' => $allRole,
        ]);

        return $this->fetch();
    }

    public function add(){

        if ($this->request->isPost()) {
            $data = $this->request->post();

            //halt($data);

            // 验证
            $result = $this->validate($data,'UserManage');

            if(true !== $result) {

                return jsons('4001',$result);
            }

            $data = model('ph/UserManage') -> apply_datebase($data);

            $userManageModel = new UserManageModel();

            //halt($data);
            unset($data['ConfirmPassword']);

            $maxNumber = Db::name('admin_user')->max('Number');

            $data['Number'] = $maxNumber + 1;

            if ($userManage = $userManageModel->allowField(true)->create($data)) {

                //halt($userManage);

                // 记录行为
                action_log('UserManage_add', UID  ,6, '编号:'.$data['UserName']);
                return jsons('2000','新增成功');

            } else {

                return jsons('4000','新增失败');

            }
        }
        echo '没有数据！';

    }

    public function  edit(){

        $UserManageModel = new UserManageModel;

        $id = input('id');

        if($this->request->isPost()){

            $data = $this->request->post();
            $res = Db::name('admin_user')->where('Number','eq',$data['Number'])->update($data);

            if ($res >0 || $res === 0) {

                // 记录行为
                action_log('UserManage_edit', UID  ,6, '编号:'.$data['Number']);
                return jsons('2000' ,'修改成功');
            }else{
                return jsons('4000' ,'修改失败');
            }
        }

        $map = 'Number ,UserName ,RealName ,Sex ,Tel ,CateID ,InstitutionID ,PostID ,Status';
        $data = Db::name('admin_user')->field($map)->where('id','eq',$id)->find();

        if($data){

            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');

    }

    public function  delete(){
        $id = input('id');
        if($id){
            $role = Db::name('admin_user')->where('id' ,'eq' ,$id)->value('Role');

            if($role){
                return jsons('4001','该用户已被分配角色无法删除');
            }

            $res = Db::name('admin_user')->where('id' ,'eq' ,$id)->delete();
            if($res){

                // 记录行为
                action_log('UserManage_delete', UID  ,6, '编号:'.$id);
                return jsons(2000 ,'删除成功');

            }else{

                return jsons(4000 ,'删除失败，参数异常！');

            }
        }

        return '没有数据';
    }

    public function userToRole(){
        $id = input('id');

        if($this->request->isPost()) {

            $data = $this->request->post();

            if(!isset($data['Role'])){

                return jsons('4001' ,'未分配任何角色');
            }

            $role = json_encode($data['Role']);

            $re = Db::name('admin_user')->where('id','eq' ,$data['id'])->setField('Role',$role);

            if($re){

                // 记录行为
                action_log('UserManage_userToRole', UID  ,6, '编号:'.$data['id']);
                return jsons('2000' ,'分配成功');

            }else{

                return jsons('4000' ,'分配失败');

            }
        }

        if($id){

            $oldRole = Db::name('admin_user')->where('id' ,'eq' ,$id)->value('Role');

            if($oldRole){
                $data['Role'] = json_decode($oldRole ,true);
            }else{
                $data['Role'] = array();
            }
            $data['id'] = $id;
            return jsons('2000','获取成功',$data);
        }

        echo '没有数据';
    }

}