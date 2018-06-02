<?php
/**
 * 租金计算控制器
 */
namespace app\ph\controller;

use think\Db;

class RentCount extends Base
{
    /**
     *  控制器主页
     *  租金计算
     */
    public function index(){

        $rentLst = model('ph/RentCount') ->get_all_rent_lst();
        $owerLst = $this->BanInfoModel->get_all_owner_type();

        $this->assign([
            'receiveRentTotal' => $rentLst['receiveRentTotal'],
            'owerLst' => $owerLst,
            'rentLst' => $rentLst['arr'],
            'rentLstObj' => $rentLst['obj'],
            'rentOption' => $rentLst['option'],
        ]);
        return $this->fetch();
    }

    /**
     *  租金配置, 注意：租金配置在系统正式使用之前只需要配置一次即可
     */
    public function conf(){

        model('ph/RentCount')->config(input('IfPre')); //是否使用规定租金作为租金基准

    }

    /**
     *  计算滞纳金
     */
    public function fine(){

    }

    /**
     *  计算下月租金，生成下月租金
     */
    public function add(){

        return model('ph/RentCount')->add()?jsons('2000' ,'生成成功!'):jsons('4001' ,'生成失败……');
    }

    /**
     *  计算租差
     */
    public function diff(){

    }
}