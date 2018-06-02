<?php
/**
 * 租金欠缴控制器
 */
namespace app\ph\controller;

use think\Db;

class RentCut extends Base
{
    /**
     *  控制器主页
     */
    public function index(){

        //条件：类型为租金减免异动 ，且为已通过状态
        $rentLst = model('ph/RentCut') ->get_all_cut_lst();

        $cutTypes = Db::name('cut_rent_type')->column('id,CutName');

        $this->assign([
            'rentLst' => $rentLst['arr'],
            'rentLstObj' => $rentLst['obj'],
            'rentOption' => $rentLst['option'],
            'cutTypes' => $cutTypes,
        ]);
        return $this->fetch();
    }

    /**
     *  明细
     */
    public function detail(){

    }



}