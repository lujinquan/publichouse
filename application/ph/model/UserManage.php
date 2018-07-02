<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Paginator;
use think\Exception;
use think\Db;

class UserManage extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_USER__';

    public function get_all_user_lst(){

        $UserList['option'] =array();
        $searchForm = input('param.');
        foreach ($searchForm as &$val) { //去首尾空格
            $val = trim($val);
        }
        if(isset($searchForm['UserName'])) {

            $UserList['option'] = $searchForm;

            if (isset($searchForm['UserName']) && $searchForm['UserName']) {   //检索用户名
                $where['a.UserName'] = array('like', '%'.$searchForm['UserName'].'%');
            }
            if (isset($searchForm['InstitutionID']) && $searchForm['InstitutionID'])  {  //检索机构
                $where['a.InstitutionID'] = array('eq', $searchForm['InstitutionID']);
            }
            if (isset($searchForm['PostID']) && $searchForm['PostID']) {  //检索职务
                $where['b.PostID'] = array('eq', $searchForm['PostID']);
            }
        }

        $where = isset($where)?$where:1;

        $UserList['obj'] = Db::name('admin_user')->alias('a')
            ->join('post b','a.PostID = b.PostID','left')
            ->field('a.id')
            ->where($where)
            ->where('UserName','not in','test,刘悦')
            ->order('id desc')
            ->paginate(config('paginate.list_rows'));

        $arr = $UserList['obj']->all();

        if(!$arr){
            $UserList['arr'] = array();
        }

        foreach($arr as $v){
            $UserList['arr'][] = self::get_one_user_base_info($v['id']);
        }

        return $UserList;
    }

    public function get_one_user_base_info($userid = '',$map=''){

        //用户编号，登录账户，用户类别，姓名，机构名称，职务，性别，联系电话，有效性
        if(!$map) $map = "id ,Number ,UserName ,Role, CateID ,RealName ,InstitutionID ,PostID ,Sex ,Tel ,Status";

        $data = self::field($map)->where('id','eq',$userid)->find();
        if(!$data){
            return array();
        }

        $data['PostID'] = Db::name('post')->where('PostID','eq',$data['PostID'])->value('PostName');//机构名称
        $data['InstitutionID'] = Db::name('institution')->where('id','eq',$data['InstitutionID'])->value('Institution');   //机构管段名称
        //halt(json_decode($data['Role']));
        $data['Role'] = Db::name('admin_role')->where('id','in',json_decode($data['Role']))->value('group_concat(RoleName)');
        //$data['Role'] = rtrim($role,',');

        if($data['CateID'] == 1){
            $data['CateID'] = '职能部门';
        }else{
            $data['CateID'] = '管理部门';
        }
        if($data['Sex'] == 1){
            $data['Sex'] = '男';
        }else{
            $data['Sex'] = '女';
        }
        if($data['Status'] == 1){
            $data['Status'] = '有效';
        }else{
            $data['Status'] = '无效';
        }

        return $data;

    }

    public function apply_datebase($data = array()){
        
        $data['Salt'] = substr(uniqid(),7);

        $strPassword = (string)$data['Password'];

        $data['Password'] = md5(md5($strPassword.$data['Salt']));

        return $data;
        
    }

    public function get_user_detail(){

        $map = 'RealName ,Sex ,CateID ,PostID ,Tel ';

        $result = Db::name('admin_user')->field($map)->where('Number' ,'eq' ,UID)->find();

        if($result['Sex'] == 0) {
            $results['Sex'] = '女';
        }else{
            $results['Sex'] = '男';
        }
        if($result['CateID'] == 1){
            $results['CateID'] = '管理部门';
        }else{
            $results['CateID'] = '职能部门';
        }

        $results['Tel'] = $result['Tel'];
        $results['PostName'] = Db::name('post')->where('PostID' ,'eq' ,$result['PostID'])->value('PostName');
        $info = session('user_base_info');

        $results['name'] = $info['name'];
        $results['RealName'] = $result['RealName'];

        $results['InstitutionName'] = $info['institution_name'];
        $results['LastLoginTime'] = date('Y-m-d',$info['last_login_time']);

        $role = json_decode($info['role'],true);

        $roleName = Db::name('admin_role')->where('id','in',$role)->column('RoleName');

        $results['RoleName'] = implode(',',$roleName);

        return $results;
    }
}