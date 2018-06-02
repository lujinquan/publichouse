<?php
namespace app\ph\controller;

use think\Db;

class ChangeAudit extends Base
{
    public function index(){

        $data = model('ph/ChangeAudit') -> get_all_change_lst();

        $changes = Db::name('process')->field('id, ProcessName')->select();

        //获取所有完损等级
        $damaLst = model('ph/BanInfo') -> get_all_damage_grade();

        $this -> assign([
            'changes' => $changes,
            'damaLst'    =>  $damaLst,
            'changeLst' => $data['arr'],
            'changeLstObj' => $data['obj'],
            'changeOption' => $data['option'],
        ]);

        return $this->fetch();
    }

    /**
     *  审批
     */
    public function process(){

        if($this->request->isPost()) {

            $data = $this->request->post();

            $checkProcess = model('ph/ChangeAudit')->check_process($data['ChangeOrderID']);  //检查是否可以审核

            if($checkProcess === false){
                return jsons('4005' ,'审批失败，请注意查看审核状态……');
            }

            $data['reson'] = isset($data['reson'])?$data['reson']:'';

            $result = model('ph/ChangeAudit')->create_child_order($data['ChangeOrderID'], $data['reson']); //执行审核

            if($result === true){

                return jsons('2000' ,'审核完成');
            }else{

                return jsons('4000' ,'审核异常');
            }

        }

    }

    //变更编号，变更类型
    /**
     * 注意： 详情由4个部分组成，a,顶层的房屋相关信息，b,第二层的附件信息，c,第三层审核状态信息，d,底层的审核记录
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [  ]
     */
    public function detail(){

        $changeOrderID = input('ChangeOrderID'); //变更编号

        $changeType = Db::name('change_order')->where('ChangeOrderID',$changeOrderID)->value('ChangeType');

        if(empty($changeOrderID)){

            return jsons('4000' ,'参数缺失');
        }

        if($changeType == 7){ //新发租的详情多加一些信息，房屋编号、租户、房屋状态；房屋编号、房间编号、房间状态
            $res['newRent'] = model('ph/ChangeAudit')->get_new_rent_detail($changeOrderID);
        }

        $res['detail'] = model('ph/ChangeAudit')->get_change_detail_info($changeOrderID);  //最上层

        $res['urls'] = model('ph/ChangeAudit')->process_imgs_url($changeOrderID );   // 第二层

        $res['config'] = model('ph/ChangeAudit')->process_status($changeOrderID );    // 第三层

        $res['record'] = model('ph/ChangeAudit')->process_record($changeOrderID );    // 最底层

        //halt($res);

        return jsons('2000' ,'获取成功' ,$res);
    }
}