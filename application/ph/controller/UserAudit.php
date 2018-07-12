<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

/**
 * @title 使用权变更审核控制器
 * @author Mr.Lu
 * @description
 */
class UserAudit extends Base
{
    /**
     * @title 使用权变更审核主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/UserApply') -> get_all_use_lst();

        $useChanges = Db::name('use_change_type')->field('id, UseChangeTitle')->select();

        $this -> assign([
            'useChanges'=> $useChanges,
            'changeLst' => $data['arr'],
            'changeLstObj' => $data['obj'],
            'changeOption' => $data['option'],
        ]);

        return $this->fetch();
    }

    /**
     * @title 补充资料
     * @author Mr.Lu
     * @description
     */
    public function supply(){
        $changeOrderID = input('ChangeOrderID');

        if(empty($changeOrderID)) return jsons('4002' ,'未传入变更编号');

        if($this->request->isPost()) {

            $data = $this->request->post();

            $changeOrderID = $data['ChangeOrderID'];  //变更编号

            //halt($data);

            if(isset($_FILES) && $_FILES){ //由于目前前端的多文件上传一次只上传一个标题的多张图片，所以目前  $_FILES  只有一个元素，故 $ChangeImageIDS 只是一个字符串

                //在补充资料的时候，需要判断当前状态是否为补充资料阶段，即当前主订单的 Status == 2 ,如果不是，则返回提示信息不让补充
                $nowStatus = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

                if($nowStatus > 3){ return jsons('4001' ,'请注意检查当前流程状态');}

                //halt($_FILES);

                foreach($_FILES as $k1 => $v1){

                    $ChangeImageIDS[] = model('ph/UserAudit') -> uploads($v1,$k1);
                }

                $ChangeImageIDS = implode(',', $ChangeImageIDS);  //返回的是使用权变更的影像资料id(多个以逗号隔开)

            }

            //写入附件id前检查，若之前有相同标题的附件,返回true，执行修改操作，若没有相同标题的附件，返回false，执行添加操作

            //$checkStatus = model('ph/UserAudit')->check_file($data['title']);


            $oldImageIDS = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('ChangeImageIDS');

            if($oldImageIDS){
                if(isset($ChangeImageIDS)){
                    $changeImageIDS = $oldImageIDS.','.$ChangeImageIDS;
                }else{
                    $changeImageIDS = $oldImageIDS;
                }
            }else{
                if(isset($ChangeImageIDS)){
                    $changeImageIDS = $ChangeImageIDS;
                }     
            }
            if(isset($changeImageIDS)){
                $effect = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->setField('ChangeImageIDS' ,$changeImageIDS);
            }

            $update=[
                'IfReform'=>$data['IfReform'],
                'IfRepair'=>$data['IfRepair'],
                'IfCollection'=>$data['IfCollection'],
                'IfFacade'=>$data['IfFacade'],
                'IfCheck'=>isset($data['IfCheck'])?$data['IfCheck']:0,
            ];

            //资料补充成功后，做后置操作，修改主订单当前状态，创建子订单，即子订单记录
            Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->update($update);

            //生成子订单
            model('ph/UserAudit')->create_child_order($changeOrderID);

            return jsons('2000' ,'补充成功' );

        }

        //检查是否允许补充资料
        $checkSupply = model('ph/UserAudit')->check_supply($changeOrderID);

        if($checkSupply === false){

            return jsons('4005' ,'操作失败，请注意查看审核状态……');
        }

        $data['detail'] = model('ph/UserAudit')->get_change_detail_info($changeOrderID);

        $data['config'] = model('ph/UserAudit')->process_status($changeOrderID);

        $data['record'] = model('ph/UserAudit')->process_record($changeOrderID);

        if(!$data){
            jsons('4000' ,'获取失败');
        }

        return jsons('2000' ,'获取成功' ,$data);
    }

    /**
     * @title 查看明细
     * @author Mr.Lu
     * @description
     */
    public function detail(){

        $changeOrderID = input('ChangeOrderID'); //变更编号

        $res['detail'] = model('ph/UserAudit')->get_change_detail_info($changeOrderID);

        $res['config'] = model('ph/UserAudit')->process_status($changeOrderID);

        $res['urls'] = model('ph/UserAudit')->process_imgs_url($changeOrderID);

        $res['record'] = model('ph/UserAudit')->process_record($changeOrderID);

        //halt($res);

        return jsons('2000' ,'获取成功' ,$res);
    }

    /**
     * @title 审核(此处的审核有别与补充资料)
     * @author Mr.Lu
     * @description
     */
    public function process(){
   
        if($this->request->isPost()) {

            $data = $this->request->post();

            model('ph/UserAudit')->check_process($data['ChangeOrderID']);

            if(!isset($data['reson'])) $data['reson']='';
       
            $result = model('ph/UserAudit')->create_child_order($data['ChangeOrderID'], $data['reson']);

            if($result === true){

                return jsons('2000' ,'审核完成');
            }else{

                return jsons('4000' ,'审核异常');
            }
            
        }

    }
}