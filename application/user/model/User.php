<?php

namespace app\user\model;

use think\Model;
use think\helper\Hash;
use app\user\model\Role as RoleModel;
use think\Cache;
use think\Db;

/**
 * 后台用户模型
 * @package app\admin\model
 */
class User extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_USER__';

    // 自动写入时间戳
    //protected $autoWriteTimestamp = true;

    /**
     * 用户登录
     * @param string $username 用户名
     * @param string $password 密码
     * @param bool $rememberme 记住登录
     * @author Mr.Lu
     * @return bool|mixed
     */
    public function login($username = '', $password = '', $dogid = '', $rememberme = false)
    {
        $username = trim($username);
        $password = trim($password);

        // 匹配登录方式
        if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $username)) {
            // 邮箱登录
            $map['email'] = $username;
        } elseif (preg_match("/^1\d{10}$/", $username)) {
            // 手机号登录
            $map['mobile'] = $username;
        } else {
            // 用户名登录
            $map['UserName'] = $username;
        }

        $map['Status'] = 1;

        // 查找用户
        $user = $this::get($map);

        if (!$user) {
            return jsons('4003','用户不存在或被禁用！');
        } else {
            // 检查是否分配用户组
            if (empty($user['Role'])) {
                //$this->error = '禁止访问，原因：未分配角色！';
                return jsons('4003','未被分配角色！');
                //return false;
            }
            $roleArr = json_decode($user['Role'],true);
            $if = Db::name('admin_role')->where(['id'=>['in',$roleArr],'Status'=>0])->find();
            if($if){
                return jsons('4003','角色已失效！');
            }
            //验证加密狗是否匹配
            /*if($user->DogId == null || $user->DogId == ''){
                $this->error = '未匹配安全控件';
                return false;
            } else if($user->DogId != $dogid){
                $this->error = '安全控件与用户不匹配';
                return false;
            }*/

            // 检查是可登录后台
//            if (!RoleModel::where('id', $user['role'])->value('access')) {
//                $this->error = '禁止访问，原因：用户所在角色禁止访问后台！';
//                return false;
//            }
            //!Hash::check((string)$password, $user->password)
            //dump(md5(md5($password.$user->salt)));exit;
            $newPassword = (string)$password;

            //$a = $newPassword.$user->Salt;
//halt($a);
            //halt(md5(md5($a)));

            if (($user->Password == md5(md5($newPassword.$user->Salt)))==false) {

                //$this->error = '密码错误！';
                return jsons('4003','密码错误！');
            } else {
                $uid = $user->id;

                // 更新登录信息
                $user->LastLoginTime = request()->time();
                $user->LastLoginIp   = get_client_ip(1);
                $user->LoginTimes += 1;

                if ($user->save()) {
                    // 自动登录
                    $this->autoLogin($this::get($uid), $rememberme);
                };

                return $uid;
            }
        }
        return false;
    }

    /**
     * 自动登录
     * @param $user 用户对象
     * @param bool $rememberme 是否记住登录，默认7天
     * @author Mr.Lu
     */
    public function autoLogin($user, $rememberme = false)
    {
        // 记录登录SESSION和COOKIES
        $userBaseInfo = array(
            'uid'             => $user->Number,     //用户表中的id
            'name'       => Db::name('admin_user')->where('id', $user->id)->value('UserName'),
            'group'           => $user->Group,
            'role'            => $user->Role,
            'institution_id'        => $user->InstitutionID,
            'institution_name'       => Db::name('institution')->where('id', $user->InstitutionID)->value('Institution'),
            'institution_level'       => Db::name('institution')->where('id', $user->InstitutionID)->value('Level'),
            //'avatar'          => $user->avatar,
            //'username'        => $user->UserName,
            //'nickname'        => $user->nickname,
            'last_login_time' => $user->LastLoginTime,
            'last_login_ip'   => get_client_ip(1),
        );

        session('user_base_info', $userBaseInfo);
        session('user_auth_sign', $this->dataAuthSign($userBaseInfo));



        // 保存用户节点权限
//        $url_value = [];
//        if ($user->role != 1) {
//            $menu_auth = Db::name('admin_role')->where('id', session('user_auth.role'))->value('menu_auth');
//            if ($menu_auth) {
//                $menu_auth = json_decode($menu_auth, true);
//                $url_value = Db::name('admin_menu')->where('id', 'in', $menu_auth)->where('url_value', 'neq', '')->column('id', 'url_value');
//            }
//        }
        $url_value = [];
        if($user->Role != null){
            $roles = json_decode($user->Role, true);
            //$roles = explode(',',$user->Role);
            //取多角色的权限菜单并集
            $role_array = Db::name('admin_role')->where('id', 'in', $roles)->where('Status', 'neq', 0)->column('MenuAuth','id');
            foreach($role_array as $v){
                $v = json_decode($v, true);
                $url_value = array_merge($url_value,$v);
            }
            $menu_auth = array_unique($url_value);

            //生成所有该用户的权限菜单
            $url_values =  Db::name('admin_menu')->where('id', 'in', $menu_auth)->where('UrlValue', 'neq', '')->column('UrlValue','id');
            //生成导航菜单的权限树
            $url_values_tree =  Db::name('admin_menu')->where('id', 'in', $menu_auth)->where('UrlValue', 'neq', '')->where('Level','neq',3)->field('id,Title,Icons,UrlValue,pid')->select();
            //保存左侧的权限树
            session('left_menu_tree',tree($url_values_tree));

            //三级菜单
            $url_values_three =  Db::name('admin_menu')->where('id', 'in', $menu_auth)->where('UrlValue', 'neq', '')->where('Level','eq',3)->column('id');
            //保存三级按钮组
            session('three_menu_status' ,$url_values_three);

        }
        //保存管理员权限菜单id和url路径
        session('user_menu_auth', $url_values);

        //文件缓存

        // 记住登录，目前暂无记住密码，此功能暂无作用
        if ($rememberme) {
            $signin_token = $user->UserName.$user->id.$user->LastLoginTime;
            cookie('uid', $user->id, 24 * 3600 * 7);
            cookie('signin_token', $this->dataAuthSign($signin_token), 24 * 3600 * 7);
        }

    }

    /**
     * 数据签名认证
     * @param array $data 被认证的数据
     * @author Mr.Lu
     * @return string 签名
     */
    public function dataAuthSign($data = [])
    {
        // 数据类型检测
        if(!is_array($data)){
            $data = (array)$data;
        }
        // 排序
        ksort($data);
        // url编码并生成query字符串
        $code = http_build_query($data);
        // 生成签名
        $sign = sha1($code);
        return $sign;
    }

    /**
     * 判断是否登录
     * @author Mr.Lu
     * @return int 0或用户id
     */
    public function isLogin()
    {
        $user = session('user_base_info');

        if (empty($user)) {
            return '';
        }else{
            return $user['uid'];
        }
    }

    public function check($code='')
    {
        //halt($code);
        $captcha = new \think\captcha\Captcha();
        if (!$captcha->check($code)) {
            $this->error = '验证码错误';
            return false;
        } else {
            return true;
        }
    }

    public function hasTelNum($telNum){
        $ret = Db::name('admin_user')->where('Tel', $telNum)->find();
        if($ret){
            return $ret;
        } else {
            return false;
        }
    }
    public function codeLogin($user){
        $uid = $user->id;
        $map['id'] = $uid;
        $map['Status'] = 1;
        $user = $this::get($map);
        // 更新登录信息
        $user->LastLoginTime = request()->time();
        $user->LastLoginIp   = get_client_ip(1);
        if ($user->save()) {
            $this->autoLogin($this::get($uid));
        }
        return $uid;
    }
}
