<?php


namespace app\ph\validate;

use think\Validate;

/**
 * 租户验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class HouseInfo extends Validate
{
    protected $rule = [

        'UseNature|使用性质'  => 'require',
        'UnitID|单元号'  => 'require',
        'FloorID|楼层号'  => 'require',
        'DiffRent|租差'  => 'require',
        'ProtocolRent|协议租金'  => 'require',

    ];

    protected $message = [
//        'HouseID.require' => '房屋编号不能为空',
//        'HouseID.length' => '房屋编号必须为10位数长度',
    ];

    //定义验证场景
    protected $scene = [

    ];
}