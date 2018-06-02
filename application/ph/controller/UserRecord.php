<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
//use app\ph\model\BanInfo as BanInfoModel;
use think\Db;


/**
 * @title 使用权变更记录控制器
 * @author Mr.Lu
 * @description
 */
class UserRecord extends Base
{
    /**
     * @title 展示使用权变更记录
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/UserRecord') -> get_all_record_lst();

        $useChanges = Db::name('use_change_type')->field('id, UseChangeTitle')->select();

        $this -> assign([
            'useChanges'=> $useChanges,
            'changeLst' => $data['arr'],
            'changeLstObj' => $data['obj'],
            'changeOption' => $data['option'],
        ]);

        return $this->fetch();
    }
}