<?php
namespace app\user\controller;
use app\user\model\User as UserModel;
use think\Controller;
use think\Cache;
use think\Hook;
use SendMessage\ServerCodeAPI;
use think\Cookie;

class Publics extends Controller
{
    public function signin()
    {
        if ($this->request->isPost()) {
            // 获取post数据
            $data = $this->request->post();
            // 验证数据
            $result = $this->validate($data, 'User.signin');
            if(true !== $result){
                // 验证失败 输出错误信息
                return jsons('4001', $result);
            }
            $UserModel = new UserModel;
            // 验证验证码
            if(!$UserModel->check($data['code'])){
                //验证码错误
                $this->error($UserModel->getError());
            }
            // 登录,返回登录管理员的id
            // $uid = $UserModel->login($data['UserName'], $data['Password'], $data['DogId'], $rememberme);
            $uid = $UserModel->login($data['UserName'], $data['Password']);

            $userNumber = $UserModel->get($uid)->Number;

            if ($uid) {
                // 记录行为,1为登入标识，由于登录不在权限表中所以创建一个标识
                action_log('登录系统',$userNumber , 6 , 1);
                $this->success('登录成功', url('ph/index/index'));
            } else {
                $this->error($UserModel->getError());
            }
        } else {
            
            $flag = input('flag');
            $this->assign('version',WEB_VERSION);
            return is_signin() && $flag != 1 ? $this->redirect('ph/index/index') : $this->fetch();   //自动登录功能
   
        }
    }

    public function weixinsignin()
    {
        if ($this->request->isPost()) {
            // 获取post数据
            $data = $this->request->post();
            // 验证数据
            $result = $this->validate($data, 'User.signin');
            $UserModel = new UserModel;
//            // 验证验证码
//            if(!$UserModel->check($data['code'])){
//                //验证码错误
//                $this->error($UserModel->getError());
//            }
            // 登录,返回登录管理员的id
            // $uid = $UserModel->login($data['UserName'], $data['Password'], $data['DogId'], $rememberme);
            $uid = $UserModel->login($data['UserName'], $data['Password']);
            $userNumber = $UserModel->get($uid)->Number;
            $instid = $UserModel->get($uid)->InstitutionID;
            if ($uid) {
                if($instid > 3){
                    // 记录行为,1为登入标识，由于登录不在权限表中所以创建一个标识
                    action_log('登录系统',$userNumber , 6 , 1);
                    return jsons('2000','登录成功',['number' => $userNumber]);
                }else{
                    return jsons('4000','请以房管员账号登录');
                }

            } else {
                $this->error($UserModel->getError());
            }
        } else {
            //halt(is_signin());
            if(model('user/User')->isLogin()){
                return $this->redirect('admin/index/index');
            } else{
                return $this->fetch();
            }           //return is_signin() ? $this->redirect('admin/index/index') : $this->fetch();   //自动登录功能
            //return $this->fetch();
        }
    }

    /**
     * 手机登录
     */
    public function telsignin(){
        if($this->request->isPost()){
            $data = $this->request->post();
            // 判断手机号是否存在
            $UserModel = new UserModel;
            // $ret = $UserModel->login('admin', 'admin', false);
            // return jsons('2000', '', $ret);
            $user = $UserModel->hasTelNum($data['telNum']);
            if(!$user){
                $this->error('手机账户不存在');
            } else if(!$user['Role']){
                $this->error('禁止访问，原因：未分配角色！');
            }
            $user = (object)$user;
            $auth = new ServerCodeAPI();
            if(!isset($data['code'])){
                $res = $auth->SendSmsCode($data['telNum']);
                $res = json_decode($res);
                if($res->code == '416'){
                    $this->error('验证次数过多，请更换登录方式');
                }
            } else {
                $res = $auth->CheckSmsYzm($data['telNum'], $data['code']);
                $res = json_decode($res);
                if($res->code == '200'){
                    $uid = $UserModel->codeLogin($user);
                    $userNumber = $UserModel->get($uid)->Number;
                    if ($uid) {
                        // 记录行为,1为登入标识，由于登录不在权限表中所以创建一个标识
                        action_log('登录系统',$userNumber , 6 , 1);
                        $this->success('登录成功', url('ph/index/index'));
                    } else {
                        $this->error($UserModel->getError());
                    }
                } else if($res->code == '413'){
                    $this->error('验证失败');
                } else {
                    $this->error('请重新获取');
                }
            }
        }
        
    }


    /**
     * 退出登录
     * @author Mr.Lu
     */
    public function signout()
    {
        // 记录行为,1为登录登出标识，由于登录不在权限表中所以创建一个标识
        $uid = session('user_base_info.uid');
        if($uid){
            action_log('退出系统',$uid , 6 , 1);
        }
        session(null);
        Cache::clear();

        //自动登录功能暂时不做
        //cookie('uid', null);
        //cookie('signin_token', null);

        return $this->redirect('signin');
    }

    


}
