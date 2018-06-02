<?php


namespace app\ph\validate;

use think\Validate;
use think\Db;

/**
 * 异动验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class ChangeApply extends Validate
{
    //定义验证规则
    protected $rule = [

        'HouseID|房屋编号' => 'require',
        'CutType|减免类型' => 'require',
        'IDnumber|证件号码' => 'require|number|max:32',
        'validity|证件有效期' => 'require|date',

        'BanID|楼栋编号'  => 'require',


//        'UserName|账号名称'      => 'require|chsAlphaNum|max:18|unique:admin_user,UserName',
//        'Password|登录密码'      => 'require|alphaDash|max:10',
//        'ConfirmPassword|确认密码'      => 'require|confirm:Password',
//        'RealName|真实姓名'      => 'require|chs|max:12',
//        'InstitutionID|机构'      => 'require',
//        'PostID|职务'      => 'require',
//        'Tel|联系电话'  => 'require|regex:^1\d{10}',

    ];

    protected $message = [
        'HouseID.require' => '房屋编号不能为空',
        'CutType.require' => '减免类型不能为空',
        'IDnumber.require' => '证件号码不能为空',
        'IDnumber.number' => '证件号码必须为数字',
        'IDnumber.max'    => '证件号码长度不合法',
        'validity.require' => '证件有效期不能为空',
        'validity.date'    => '证件有效期格式不合法',
        'BanID.require'  => '楼栋编号不能为空',

//        'RealName.max'    => '请输入真实姓名',
//        'Password.require'    => '登录密码不能为空',
//        'Password.max'    => '登录密码长度不能超过10位',
//        'Password.alphaDash'    => '登录密码含有非法字符',
//        'ConfirmPassword.confirm'    => '密码两次输入不一致',
//        'PostID.require'    => '职务不能为空',
//        'Tel.require' => '联系电话不为空',
//        'Tel.regex'    => '请输入正确的联系方式',

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