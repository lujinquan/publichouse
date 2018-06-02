<?php


namespace app\ph\validate;

use think\Validate;
use think\Db;

/**
 * 房间验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class UserManage extends Validate
{
    //定义验证规则
    protected $rule = [
        
        'UserName|账号名称'      => 'require|chsAlphaNum|max:18|unique:admin_user,UserName',
        'Password|登录密码'      => 'require|alphaDash|max:10',
        'ConfirmPassword|确认密码'      => 'require|confirm:Password',
        'RealName|真实姓名'      => 'require|chs|max:12',
        'InstitutionID|机构'      => 'require',
        'PostID|职务'      => 'require',
        'Tel|联系电话'  => 'require|regex:^1\d{10}',

    ];

    protected $message = [
        'UserName.require' => '登陆账号不能为空',
        'UserName.chsAlpha' => '登陆账号中只能存在汉字或字母数字',
        'UserName.max' => '登陆账号长度不合法',
        'UserName.unique' => '登陆账号已被注册',
        'RealName.require'    => '真实姓名不能为空',
        'RealName.chs'    => '请输入真实姓名',
        'RealName.max'    => '请输入真实姓名',
        'Password.require'    => '登录密码不能为空',
        'Password.max'    => '登录密码长度不能超过10位',
        'Password.alphaDash'    => '登录密码含有非法字符',
        'ConfirmPassword.confirm'    => '密码两次输入不一致',
        'PostID.require'    => '职务不能为空',
        'Tel.require' => '联系电话不为空',
        'Tel.regex'    => '请输入正确的联系方式',

    ];



    //定义验证场景
    protected $scene = [
        //更新
        //'update'  =>  ['Password' => 'length:6,20', 'Phone', 'Role'],
        //登录
//        'add'  =>  [
//            'BanID' => 'require|length:10',
//            'UseNature'      => 'require',
//            'PreRent'  => 'require',
//        ],
    ];
}