<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class Photograph extends Base
{
    public function index(){

        return $this->fetch();
    }
}