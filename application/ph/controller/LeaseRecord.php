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
class LeaseRecord extends Base
{
    /**
     * @title 展示使用权变更记录
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/LeaseRecord')->get_all_lease_lst();
        $this -> assign([    
            'leaseLst' => $data['arr'],
            'leaseLstObj' => $data['obj'],
            'leaseOption' => $data['option'],
        ]);

        return $this->fetch();
    }
}