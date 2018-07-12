<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\OldMonthRent as OldMonthRentModel;
use think\Request;
use think\Db;

class OldMonthRent extends Base
{
    public function index()
    {
        $oldRentLst = model('ph/OldMonthRent')->get_all_old_rent();
        $instArr = Db::name('institution')->column('id,Institution');
        $this->assign([
            'instArr' => $instArr,
            'oldRentLst' => $oldRentLst['arr'],
            'oldRentObj' => $oldRentLst['obj'],
            'oldRentOption' => $oldRentLst['option'],
        ]);
        return $this->fetch();
    }

    public function detail()
    {
        $id = input('id');
        if(!$id) return jsons('4004','参数缺失');
        $one = Db::name('old_rent')->where('id','eq',$id)->field('HouseID,PayYear,PayMonth,PayRent')->find();
        $one['houseDetail'] = get_house_info($one['HouseID']);
        return jsons('2000','获取成功',$one);
    }

}