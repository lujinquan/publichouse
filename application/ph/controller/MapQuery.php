<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class MapQuery extends Base
{

    public function index()
    {
        //所有产别
        $owerLst = $this->BanInfoModel->get_all_owner_type();

        $this->assign([
            'owerLst' => $owerLst,
        ]);

        return $this->fetch();
    }

}