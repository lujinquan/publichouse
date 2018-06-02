<?php


namespace app\user\validate;

use think\Validate;

/**
 * 用户验证器
 * @package app\admin\validate
 * @author Mr.Lu
 */
class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'UserName|用户名' => 'require|number|unique:admin_user,UserName',
        //'RealName|昵称'  => 'require|unique:admin_user',
        //'Role|角色'      => 'require',
        //'email|邮箱'     => 'email|unique:admin_user',
        'Password|密码'  => 'require|length:3,20',
        'Phone|手机号'   => 'regex:^1\d{10}|unique:admin_user',
    ];

    //定义验证提示
    protected $message = [
        'UserName.require' => '请输入用户名',
        //'UserName.unique:admin_user,UserName' => '用户名不存在',
        //'email.require'    => '邮箱不能为空',
        //'email.email'      => '邮箱格式不正确',
        //'email.unique'     => '该邮箱已存在',
        //'Password.require' => '密码不能为空',
        'Password.length'  => '密码长度3-20位',
        'Phone.regex'     => '手机号不正确',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        'update'  =>  ['Password' => 'length:6,20', 'Phone', 'Role'],
        //登录
        'signin'  =>  ['UserName' => 'require', 'Password' => 'require|length:3,20'],
    ];
}
