<?php
namespace app\ph\controller;

use app\ph\model\BanInfo as BanInfoModel;
use app\ph\model\HouseInfo as HouseInfoModel;
use app\ph\model\TenantInfo as TenantInfoModel;
use app\user\model\Role as RoleModel;
use think\Cache;
use think\Db;

use think\Controller;

class Base extends Controller
{
    protected $BanInfoModel;
    protected $HouseInfoModel;
    protected $TenantInfoModel;

        protected function _initialize()
    {
        $this->BanInfoModel = new BanInfoModel;
        $this->HouseInfoModel = new HouseInfoModel;
        $this->TenantInfoModel = new TenantInfoModel;

        //所有产别
        $owerLst = $this->BanInfoModel->get_all_owner_type();
        $owerArr = Db::name('ban_owner_type')->column('id,OwnerType');
        $insArr = Db::name('institution')->column('id,Institution');
        //所有结构
        $struLst = $this->BanInfoModel->get_all_structure_type();
        //所有完损等级
        $damaLst = $this->BanInfoModel->get_all_damage_grade();
        //所有使用性质
        $useNatureLst = $this->BanInfoModel->get_all_use_nature();

        // 判断是否登录，并定义用户ID常量
        defined('UID') or define('UID', $this->isLogin());

        if(!UID){
            return $this->redirect('user/Publics/signin');
        }

//halt(ini_get_all('session'));
        // 检查权限
        if (!RoleModel::checkAuth()) return jsons('5000','权限不足！');

        $leftMenu = session('left_menu_tree'); //左侧二级权限树

        $userBaseInfo = session('user_base_info'); //当前登录用户基本信息

        //同一个账号第二次登录会挤掉第一次的登录
        $lastLoginTime = Db::name('admin_user')->where('Number',UID)->value('LastLoginTime');
        if($userBaseInfo['last_login_time'] < $lastLoginTime){ 
            return $this->success('您的账号于'.date('Y年m月d日 H时i分s秒',$lastLoginTime).'在另一个地方登录……','User/Publics/signin?flag=1','',5);
            //return $this->redirect('/templates/jump.html',['lastLoginTime'=>$lastLoginTime]);
        }

        $useRoles = json_decode(session('user_base_info.role'),true); //当前用户的角色数组

        $threeMenu = session('three_menu_status'); //三级按钮状态组

        $model      = request()->module();
        $controller = request()->controller();
        $action     = request()->action();
        $nowMvc = $model.'/' .$controller.'/'.$action;  //当前操作的MVC

        $nowID = Db::name('admin_menu')->where('UrlValue','eq',$nowMvc)->value('pid'); //一级菜单折叠标识
        
        $instLst = get_all_institution();
//halt($instLst);
        $allInstitutions = tree(Db::name('institution')->field('id,Institution,pid,Level')->select());

        $cutTypeLst = $this->BanInfoModel ->get_all_cut_type();

        $this->assign([
            'version' => WEB_VERSION,
            'left_menu' => $leftMenu ,
            'nowMvc' => $nowMvc,
            'nowID' => $nowID,
            'userBaseInfo' => $userBaseInfo ,
            'threeMenu' => $threeMenu,
            'insArr' => $insArr,
            'owerArr' => $owerArr,
            'owerLst' => $owerLst,
            'damaLst' => $damaLst,
            'struLst' => $struLst,
            'useNatureLst' => $useNatureLst,
            'useRoles' => $useRoles,
            'instLst' => $instLst,
            'allInstitutions' => $allInstitutions,
            'cutTypeLst' => $cutTypeLst,
        ]);

    }

    /**
     * 检查是否登录，没有登录则跳转到登录页面
     * @author Mr.Lu
     * @return int
     */
    final protected function isLogin()
    {
//        $one = session('user_base_info');
//        dump($one['last_login_time']);dump(time());exit;
        //halt(is_signin());
        // 判断是否登录
        $uid = is_signin();
        if ($uid === 'time_out') {
            // 已登录
            $this->success('登陆超时，本次登录',url('user/publics/signin'));

        } elseif($uid === 'empty_user') {
            // 未登录
            $this->redirect('user/publics/signin');
        }else{
            return $uid;
        }
    }
}
