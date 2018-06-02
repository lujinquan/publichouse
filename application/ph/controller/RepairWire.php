<?php
/**
 * 老旧电线
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

class RepairWire extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
    	return $this->fetch();
    }

}