<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use util\Tree;

/**
 * 节点模型
 * @package app\admin\model
 */
class Menu extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_MENU__';

    // 自动写入时间戳
    //protected $autoWriteTimestamp = true;

    // 将节点url转为小写
    public function setUrlValueAttr($value)
    {
        return strtolower(trim($value));
    }

    // 获取侧边栏的菜单导航栏【新】
    public static function getSidebarMenus($id = '', $module = '', $controller = '')
    {
        $module     = $module == '' ? request()->module() : $module;
        $controller = $controller == '' ? request()->controller() : $controller;
        $menus      = cache('_sidebar_menus.' . $module . '_' . $controller);
        if (!$menus) {
            // 获取当前节点地址
            $location = self::getLocation($id);
            // 当前顶级节点id
            $top_id = $location[0]['id'];
            // 获取顶级节点下的所有节点
            $map = [
                'Status' => 1,
                'Module' => $module
            ];
            // 非开发模式，只显示可以显示的菜单
            if (config('develop_mode') == 0) {
                $map['online_hide'] = 0;
            }
            $menus = self::where($map)->order('sort,id')->column('id,Pid,Module,Title,UrlValue,UrlType,UrlTarget');

            // 解析模块链接
            foreach ($menus as $key => &$menu) {
                // 没有访问权限的节点不显示
                if (!RoleModel::checkAuth($menu['id'])) {
                    unset($menus[$key]);
                    continue;
                }
                if ($menu['url_value'] != '' && $menu['url_type'] == 'module') {
                    $menu['url_value']  = url($menu['url_value']);
                }
            }
            $menus = Tree::toLayer($menus, $top_id, 2);

            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache('_sidebar_menus.' . $module . '_' . $controller, $menus);
            }
        }
        return $menus;
    }

    /**
     * 递归修改所属模型
     * @param int $id 父级节点id
     * @param string $module 模型名称
     * @author Mr.Lu
     * @return bool
     */
    public static function changeModule($id = 0, $module = '')
    {
        if ($id > 0) {
            $ids = self::where('Pid', $id)->column('id');
            if ($ids) {
                foreach ($ids as $id) {
                    self::where('id', $id)->setField('Module', $module);
                    self::changeModule($id, $module);
                }
            }
        }
        return true;
    }

    /**
     * 获取树形节点
     * @param int $id 需要隐藏的节点id
     * @param string $default 默认第一个节点项，默认为“顶级节点”，如果为false则不显示，也可传入其他名称
     * @param string $module 模型名
     * @author Mr.Lu
     * @return mixed
     */
    public static function getMenuTree($id = 0, $default = '', $module = '')
    {
        $result[0]       = '顶级节点';
        $where['Status'] = ['egt', 0];
        if ($module != '') {
            $where['Module'] = $module;
        }

        // 排除指定节点及其子节点
        if ($id !== 0) {
            $hide_ids    = array_merge([$id], self::getChildsId($id));
            $where['id'] = ['notin', $hide_ids];
        }

        // 获取节点
        $menus = Tree::toList(self::where($where)->order('Pid,id')->column('id,Pid,Title'));
        foreach ($menus as $menu) {
            $result[$menu['id']] = $menu['title_display'];
        }

        // 设置默认节点项标题
        if ($default != '') {
            $result[0] = $default;
        }

        // 隐藏默认节点项
        if ($default === false) {
            unset($result[0]);
        }

        return $result;
    }

    /**
     * 获取顶部节点
     * @param string $max 最多返回多少个
     * @param string $cache_tag 缓存标签
     * @author Mr.Lu
     * @return array
     */
    public static function getTopMenu($max = '', $cache_tag = '')
    {
        $menus = cache($cache_tag);
        if (!$menus) {
            // 非开发模式，只显示可以显示的菜单
            if (config('develop_mode') == 0) {
                $map['online_hide'] = 0;
            }
            $map['Status'] = 1;
            $map['Pid']    = 0;
            $menus = self::where($map)->order('sort,id')->limit($max)->column('id,Pid,Module,Title,UrlValue,UrlType,UrlTarget');
            foreach ($menus as $key => &$menu) {
                // 没有访问权限的节点不显示
                if (!RoleModel::checkAuth($menu['id'])) {
                    unset($menus[$key]);
                    continue;
                }
                if ($menu['UrlValue'] != '' && $menu['UrlType'] == 'Module') {
                    $url = explode('/', $menu['url_value']);
                    $menu['controller'] = $url[1];
                    $menu['action']     = $url[2];
                    $menu['UrlValue']  = url($menu['UrlValue']);
                }
            }
            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache($cache_tag, $menus);
            }
        }
        return $menus;
    }

    /**
     * 获取侧栏节点
     * @param string $id 模块id
     * @param string $module 模块名
     * @param string $controller 控制器名
     * @author Mr.Lu
     * @return array|mixed
     */
    public static function getSidebarMenu($id = '', $module = '', $controller = '')
    {
        $module     = $module == '' ? request()->module() : $module;
        $controller = $controller == '' ? request()->controller() : $controller;
        $menus      = cache('_sidebar_menus.' . $module . '_' . $controller);
        if (!$menus) {
            // 获取当前节点地址
            $location = self::getLocation($id);
            // 当前顶级节点id
            $top_id = $location[0]['id'];
            // 获取顶级节点下的所有节点
            $map = [
                'Status' => 1,
                'Module' => $module
            ];
            // 非开发模式，只显示可以显示的菜单
            if (config('develop_mode') == 0) {
                $map['online_hide'] = 0;
            }
            $menus = self::where($map)->order('Sort,id')->column('id,Pid,Module,Title,UrlValue,UrlType,UrlTarget');

            // 解析模块链接
            foreach ($menus as $key => &$menu) {
                // 没有访问权限的节点不显示
                if (!RoleModel::checkAuth($menu['id'])) {
                    unset($menus[$key]);
                    continue;
                }
                if ($menu['UrlValue'] != '' && $menu['UrlType'] == 'Module') {
                    $menu['UrlValue']  = url($menu['UrlValue']);
                }
            }
            $menus = Tree::toLayer($menus, $top_id, 2);

            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache('_sidebar_menus.' . $module . '_' . $controller, $menus);
            }
        }
        return $menus;
    }

    /**
     * 获取指定节点ID的位置
     * @param string $id 节点id，如果没有指定，则取当前节点id
     * @param bool $del_last_url 是否删除最后一个节点的url地址
     * @param bool $check 检查节点是否存在，不存在则抛出错误
     * @author Mr.Lu
     * @return array
     * @throws \think\Exception
     */
    public static function getLocation($id = '', $del_last_url = false, $check = true)
    {
        $model      = request()->module();
        $controller = request()->controller();
        $action     = request()->action();

        // 如果为校验权限调用，则直接返回当前的访问节点路径
        if($id == ''){
            return $current_url = $model.'/'.$controller.'/'.$action;
        }

        //暂时做到这里
        if ($id != '') {
            $cache_name = 'location.menu_'.$id;
        } else {
            $cache_name = 'location.'.$model.'_'.$controller.'_'.$action;
        }

        $location = cache($cache_name);

        if (!$location) {
            $map['Pid'] = ['<>', 0];
            $map['UrlValue'] = strtolower($model.'/'.trim(preg_replace("/[A-Z]/", "_\\0", $controller), "_").'/'.$action);

            // 当前操作对应的节点ID
            $curr_id  = $id == '' ? self::where($map)->value('id') : $id;

            // 获取节点ID是所有父级节点
            $location = Tree::getParents(self::column('id,Pid,Title,UrlValue'), $curr_id);

            if ($check && empty($location)) {
                throw new Exception('获取不到当前节点地址，可能未添加节点', 9001);
            }

            // 剔除最后一个节点url
            if ($del_last_url) {
                $location[count($location) - 1]['UrlValue'] = '';
            }

            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache($cache_name, $location);
            }
        }
        return $location;
    }

    /**
     * 根据分组获取节点
     * @param string $group 分组名称
     * @param bool|string $fields 要返回的字段
     * @param array $map 查找条件
     * @author Mr.Lu
     * @return array
     */
    public static function getMenusByGroup($group = '', $fields = true, $map = [])
    {
        $map['Module'] = $group;
        return self::where($map)->order('Sort,id')->column($fields, 'id');
    }

    /**
     * 获取节点分组
     * @author Mr.Lu
     * @return array
     */
    public static function getGroup()
    {
        $map['Status'] = 1;
        $map['Pid']    = 0;
        $menus = self::where($map)->order('id,Sort')->column('Module,Title');
        return $menus;
    }

    /**
     * 获取所有子节点id
     * @param int $pid 父级id
     * @author Mr.Lu
     * @return array
     */
    public static function getChildsId($pid = 0)
    {
        $ids = self::where('Pid', $pid)->column('id');
        foreach ($ids as $value) {
            $ids = array_merge($ids, self::getChildsId($value));
        }
        return $ids;
    }
}
