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

    /**
     *  取消减免
     */
    public function cancelCut(){
        $data = $this->request->param();
        

        if (isset($_FILES) && $_FILES) {   //文件上传
            foreach ($_FILES as $k => $v) {
                $ChangeImageIDS[] = model('RentCut')->uploads($v, $k);
            }
            $ChangeImageIDS = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
        }else{
            return jsons('4000','请上传取消租金减免报告！');
        }
        $row = Db::name('change_order')->where(['ChangeOrderID'=>$data['ChangeOrderID'],'ChangeType'=>1,'InflRent'=>['>',0]])->field('ChangeImageIDS,HouseID')->find();
        if(!$row){
            return jsons('4000','参数错误！');
        }
        $imgs = $row['ChangeImageIDS']?($row['ChangeImageIDS'].','.$ChangeImageIDS):$ChangeImageIDS;
//dump($ChangeImageIDS);halt($data);
        //$id = input('id/s');
        //原租户如果有减免则取消减免
        Db::name('rent_table')->where(['ChangeOrderID'=>$data['ChangeOrderID'],'ChangeType'=>1,'InflRent'=>['>',0]])->update(['InflRent'=>0,'DateEnd'=>date('Ym')]);
        Db::name('change_order')->where(['ChangeOrderID'=>$data['ChangeOrderID'],'ChangeType'=>1,'InflRent'=>['>',0]])->update(['DateEnd'=>date('Ym'),'ChangeImageIDS'=>$imgs]);
        //是否使用规定租金作为租金基准
        Db::name('rent_config')->where(['HouseID'=>$row['HouseID']])->update(['CutType'=>0,'CutRent'=>0,'ReceiveRent'=>['exp','HousePrerent+DiffRent+PumpCost'],'UnpaidRent'=>['exp','HousePrerent+DiffRent+PumpCost']]);
        
        return jsons('2000','取消成功');
    }



}