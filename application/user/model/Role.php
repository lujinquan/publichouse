<?php
namespace app\user\model;

use think\Model;
use util\Tree;
use app\ph\model\Menu as MenuModel;

/**
 * 角色模型
 * @package app\admin\model
 */
class Role extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_ROLE__';

    // 自动写入时间戳
    //protected $autoWriteTimestamp = true;

    // 写入时，将菜单id转成json格式
    public function setMenuAuthAttr($value)
    {
        return json_encode($value);
    }

    // 读取时，将菜单id转为数组
    public function getMenuAuthAttr($value)
    {
        return json_decode($value, true);
    }

    /**
     * 获取树形角色
     * @param null $id 需要隐藏的角色id
     * @param string $default 默认第一个菜单项，默认为“顶级角色”，如果为false则不显示，也可传入其他名称
     * @author Mr.Lu
     * @return mixed
     */
    public static function getTree($id = null, $default = '')
    {
        $result[0]       = '顶级角色';
        $where['status'] = ['egt', 0];

        // 排除指定菜单及其子菜单
        if ($id !== null) {
            $hide_ids    = array_merge([$id], self::getChildsId($id));
            $where['id'] = ['notin', $hide_ids];
        }

        // 获取菜单
        $roles = Tree::config(['title' => 'name'])->toList(self::where($where)->column('id,pid,name'));
        foreach ($roles as $role) {
            $result[$role['id']] = $role['title_display'];
        }

        // 设置默认菜单项标题
        if ($default != '') {
            $result[0] = $default;
        }

        // 隐藏默认菜单项
        if ($default === false) {
            unset($result[0]);
        }
        return $result;
    }

    /**
     * 获取所有子角色id
     * @param string $pid 父级id
     * @author Mr.Lu
     * @return array
     */
    public static function getChildsId($pid = '')
    {
        $ids = self::where('pid', $pid)->column('id');
        foreach ($ids as $value) {
            $ids = array_merge($ids, self::getChildsId($value));
        }
        return $ids;
    }

    /**
     * 检查访问权限
     * @param int $id 需要检查的节点ID，默认检查当前操作节点
     * @author Mr.Lu
     * @return bool
     */
    public static function checkAuth($id = 0)
    {
//        // 当前用户的角色
//        $uid = session('user_base_info.uid');


        // id为1的是超级管理员，或者角色为1的，拥有最高权限(最高权限功能不设置)
//        if (session('user_auth.uid') == '1' || $uid == '1') {
//            return true;
//        }

        // 获取当前用户的权限
        $menu_auth = session('user_menu_auth');


//        $menu_auth = cache('role_menu_auth_'.$uid);
//
//        if (!$menu_auth) {
//            $menu_auth = session('user_menu_auth');
//            // 非开发模式，缓存数据
//            if (config('develop_mode') == 0) {
//                cache('role_menu_auth_'.$uid, $menu_auth);
//            }
//        }


        // 检查访问路径是否在权限菜单中
        if($menu_auth){
            $location = MenuModel::getLocation();
            //dump($location);dump($menu_auth);exit;
            return in_array($location, $menu_auth);
        }else{
            return false;
        }

//        // 检查权限
//        if ($menu_auth) {
//            if ($id !== 0) {
//                return in_array($id, $menu_auth);
//            }
//            // 获取当前操作的id
//            $location = MenuModel::getLocation();
//            $action   = end($location);
//
//            return in_array($action['id'], $menu_auth);
//        }
//
//        // 其他情况一律没有权限
//        return false;
    }
}