<?php


namespace app\ph\validate;

use think\Validate;

/**
 * 楼栋验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class ConfirmBanInfo extends Validate
{
    //定义验证规则
    protected $rule = [
        'AreaTwo|街道' => 'require|number',
        'AreaThree|社区' => 'require|number',
        'AreaFour|详细地址' => 'require',
        'BanNumber|栋号' => 'require|between:0,9',
        'TubulationID|管段' => 'require', 
        'DamageGrade|完损等级' => 'require',
        'OwnerType|产别' => 'require',
        'UseNature|使用性质' => 'require',
        'StructureType|结构类别' => 'require',
        'BanYear|建成年份' => 'require|between:1000,3000',
        'BanUnitNum|单元数量' => 'require|between:1,9',
        'BanFloorNum|楼层数量' => 'require|between:1,99',
        'EnterpriseArea|企业建面' => 'require',
        'PartyArea|机关建面' => 'require',
        'CivilArea|民用建面' => 'require',
        'BanUsearea|使用面积' => 'require',
        'EnterpriseNum|企栋数' => 'require|between:0,1',
        'PartyNum|机栋数' => 'require|between:0,1',
        'CivilNum|民栋数' => 'require|between:0,1',
        'xy|经纬度' => 'require',
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
