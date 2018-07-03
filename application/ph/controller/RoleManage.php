<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\RoleManage as RoleManageModel;
use think\Db;

class RoleManage extends Base
{
    public function index(){

        $RoleManageModel = new RoleManageModel;

        $roleLst = $RoleManageModel -> get_all_role_lst();

        //dump($roleLst);exit;

        $treeMenu =Db::name('admin_menu')->field('id ,pid ,Level ,Title')->order('id')->select();

//        //临时转换三级菜单为二级菜单
//        foreach($treeMenu as $key =>&$value){
//            if($value['Level'] == 3){
//                foreach($treeMenu as $key1 => $value1){
//                    if($value['pid'] == $value1['id']){
//                        $value['pid'] = $value1['pid'];
//                        $value['Level'] = 2;
//                    }
//                }
//            }
//        }

        //unset($treeMenu[1]);  //默认的主页按钮不显示
        //halt($treeMenu);
        $this->assign([
            'roleLst' => $roleLst['arr'],
            'roleLstObj' => $roleLst['obj'],
            'treeMenu' => $treeMenu,
        ]);

        return $this->fetch();
    }
    
    public function add(){
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();

            if(empty($data['RoleName'])) return jsons('4001' ,'角色名称不能为空');

            if ($banInfo = RoleManageModel::create($data)) {

                $max = Db::name('post')->max('id');
                // 记录行为
                action_log('RoleManage_add', UID  ,6, '编号为:'.$max);
                return jsons('2000' ,'新增成功');
            } else {
                return jsons('4000' ,'新增失败');
            }
        }
        echo '没有数据！';
        //return $this->fetch();
    }

    public function  edit(){
        $id = input('id');

        if($this->request->isPost()){

            $data = $this->request->post();

            if(empty($data['RoleName'])) return jsons('4001' ,'角色名称不能为空');

            if ($banInfo = RoleManageModel::update($data)) {

                // 记录行为
                action_log('RoleManage_edit', UID  ,6, '编号为:'.$data['id']);
                return jsons('2000' ,'修改成功');
            }else{
                return jsons('4000' ,'修改失败');
            }
        }

        $map = 'id  ,RoleName ,Status ,Ifstation';
        $data = Db::name('admin_role')->field($map)->where('id','eq',$id)->find();

        if($data){

            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');

    }

    public function  delete(){
        $id = input('id');
        if($id){
            $res = Db::name('admin_role')->where('id' ,'eq' ,$id)->delete();
            if($res){

                // 记录行为
                action_log('RoleManage_delete', UID  ,6, '编号为:'.$id);
                return jsons(2000 ,'删除成功');
            }else{
                return jsons(4000 ,'删除失败，参数异常！');
            }
        }

        return '没有数据';
    }

    public function roleToMenu(){
        
        if($this->request->isPost()){

            $data = $this->request->post();
            //return jsons('900','程序优化中，请稍后访问……');

            //halt($data);
            if(!isset($data['id'])){
                return jsons('4002','未分配任何权限……');
            }
            if(!in_array('1',$data['id'])){
                array_unshift($data['id'] ,"1");
            }
            if(!in_array('2',$data['id'])){
                array_unshift($data['id'] ,"2");
            }

            //if($data) array_unshift($data['id'] ,"1" );  //默认首页都可以进入

            $newMenuAuth = json_encode($data['id']);

            $result = Db::name('admin_role')->where('id','eq',$data['Role'])->setField('MenuAuth',$newMenuAuth);

            if($result !== false){

                // 记录行为
                action_log('RoleManage_roleToMenu', UID  ,6, '编号为:'.$data['Role']);

                return jsons('2000' ,'分配成功');

            }else{

                return jsons('4000' ,'分配失败');
            }

        }

        $id = input('id');

        if($id){
            $menuAuth = Db::name('admin_role')->where('id' ,'eq' ,$id)->value('MenuAuth');

            $data = json_decode($menuAuth ,true);

            //获取该角色原有的菜单集合
            $menu['menu'] = Db::name('admin_menu')->where('id' ,'in' ,$data)->column('id');

            $menu['Role'] = $id;

            return jsons('2000' ,'获取成功', $menu);
        }
        return jsons('4000' ,'参数缺失');
    }
}