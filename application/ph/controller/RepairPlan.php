<?php
/**
 * 维修申请
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

class RepairPlan extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
    	return $this->fetch();
    }

}