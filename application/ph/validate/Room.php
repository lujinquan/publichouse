<?php


namespace app\ph\validate;

use think\Validate;
use think\Db;

/**
 * 房间验证器
 * @package app\ph\validate
 * @author Mr.Lu
 */
class Room extends Validate
{
    //定义验证规则
    protected $rule = [

        //'RoomID|房间编号' => 'require|number',
        'BanID|楼栋编号'      => 'require',
        //'BanYear|建成年份'  => 'require|number|length:4',
        'RoomType|房间类型'  => 'require',
//        'UnitID|单元号'  => 'require|number',
//        'FloorID|楼层号'  => 'require|number',
        'UseArea|房间使用面积'  => 'require|number',
        //'LeasedArea|房间计租面积'  => 'require|number', //中文占3个字符

    ];

    protected $message = [

    ];

//    protected function checkIfExist( $RoomID , $BanID){
//
//        halt($RoomID);
//
//        $roomNumber = $BanID.$RoomID;
//
//        halt($roomNumber);
//
//        $one = Db::name('room')->where('RoomID' ,'eq' ,$roomNumber)->value('RoomID');
//
//        if($one){
//           return jsons('4004','该房间间号已在此楼栋中存在');
//        }
//
//    }

    //定义验证场景
    protected $scene = [
        //更新
        //'update'  =>  ['Password' => 'length:6,20', 'Phone', 'Role'],
        //登录
//        'add'  =>  [
//            'BanID' => 'require|length:10',
//            'TubulationID' => 'require',
//            'OwnerType'      => 'require|number',
//            'BanAddress'  => 'require|max:10',
//            'BanPropertyID'      => 'require',
//            'BanYear'  => 'require',
//            'DamageGrade'      => 'require|number',
//            'StructureType'  => 'require|number',
//            'UseNature'      => 'require',
//            'PreRent'  => 'require',
//        ],
    ];
}