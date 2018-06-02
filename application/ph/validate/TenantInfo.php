<?php


namespace app\ph\validate;

use think\Validate;

/**
 * 租户验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class TenantInfo extends Validate
{
    //定义验证规则
    protected $rule = [
        
        //'TenantTel|联系电话'  => 'require|regex:^1\d{10}',
        'TenantName|租户姓名'  => 'require|max:90',
        'TenantBalance|账户余额' => 'require',

    ];

    //定义验证提示
    protected $message = [

    ];

    //定义验证场景
    protected $scene = [

    ];
}