<?php


namespace app\ph\validate;

use think\Validate;

/**
 * 楼栋验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class BanInfo extends Validate
{
    //定义验证规则
    protected $rule = [
        'AreaTwo|街道' => 'require|number',
        'AreaThree|社区' => 'require|number',
        'AreaFour|详细地址' => 'require',
        'TubulationID|管段' => 'require',
        'OwnerType|产别' => 'require',
        'BanYear|建成年份' => 'require|between:1000,3000',
        'DamageGrade|完损等级' => 'require',
        'StructureType|结构类别' => 'number',
        'UseNature|使用性质' => 'require',
        'BanUnitNum|单元数量' => 'require',
        'BanFloorNum|楼层数量' => 'require',
        'EnterpriseArea|企业建面' => 'require',
        'PartyArea|机关建面' => 'require',
        'CivilArea|民用建面' => 'require',
        'BanUsearea|使用面积' => 'require',
    ];

    //定义个性化验证提示
    protected $message = [
        'BanYear.between'    => '建成年份不合法',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        //'update'  =>  ['Password' => 'length:6,20', 'Phone', 'Role'],
        //登录
//        'add'  =>  [
//            'BanID' => 'require|length:10',
//            'TubulationID' => 'require',
//        ],
    ];
}
