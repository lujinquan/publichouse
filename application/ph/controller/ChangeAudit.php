<?php
namespace app\ph\controller;

use think\Db;

class ChangeAudit extends Base
{
    public function index(){

        $data = model('ph/ChangeAudit') -> get_all_change_lst();

        //halt($data['arr']);

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

    //     /**
    //  * @title 补充资料
    //  * @author Mr.Lu
    //  * @description
    //  */
    // public function supply(){
    //     $changeOrderID = input('ChangeOrderID');

    //     if(empty($changeOrderID)) return jsons('4002' ,'未传入变更编号');

    //     if($this->request->isPost()) {
    //         $data = $this->request->post();
    //         $changeOrderID = $data['ChangeOrderID'];  //变更编号
    //         if($_FILES){ //由于目前前端的多文件上传一次只上传一个标题的多张图片，所以目前  $_FILES  只有一个元素，故 $ChangeImageIDS 只是一个字符串
    //             //在补充资料的时候，需要判断当前状态是否为补充资料阶段，即当前主订单的 Status == 2 ,如果不是，则返回提示信息不让补充
    //             $find = Db::name('change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->field('Type,Status')->find();
    //             if($find[''] > 3){ return jsons('4001' ,'请注意检查当前流程状态');}

    //             foreach($_FILES as $k1 => $v1){
    //                 $ChangeImageIDS[] = model('ph/UserAudit') -> uploads($v1,$k1);
    //             }
    //             $ChangeImageIDS = implode(',', $ChangeImageIDS);  //返回的是使用权变更的影像资料id(多个以逗号隔开)
    //         }

    //         if(isset($ChangeImageIDS)){ //执行添加

    //             $oldImageIDS = Db::name('change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('ChangeImageIDS');

    //             if($oldImageIDS){

    //                 $changeImageIDS = $oldImageIDS.','.$ChangeImageIDS;
    //             }else{

    //                 $changeImageIDS = $ChangeImageIDS;
    //             }

    //             $effect = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->setField('ChangeImageIDS' ,$changeImageIDS);
    //         }
        
            
    //         if($effect){

    //             //资料补充成功后，做后置操作，修改主订单当前状态，创建子订单，即子订单记录
    //             Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->update($update);

    //             //生成子订单
    //             model('ph/UserAudit')->create_child_order($changeOrderID);

    //             return jsons('2000' ,'补充成功' );

    //         }else{

    //             return jsons('4000' ,'补充失败' );

    //         }


    //     }

    //     //检查是否允许补充资料
    //     $checkSupply = model('ph/UserAudit')->check_supply($changeOrderID);

    //     if($checkSupply === false){

    //         return jsons('4005' ,'操作失败，请注意查看审核状态……');
    //     }

    //     $data['detail'] = model('ph/UserAudit')->get_change_detail_info($changeOrderID);

    //     $data['config'] = model('ph/UserAudit')->process_status($changeOrderID);

    //     $data['record'] = model('ph/UserAudit')->process_record($changeOrderID);

    //     if(!$data){
    //         jsons('4000' ,'获取失败');
    //     }

    //     return jsons('2000' ,'获取成功' ,$data);
    // }


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

            $find = Db::name('change_order')->where('ChangeOrderID',$data['ChangeOrderID'])->field('ChangeImageIDS,Status,ChangeType')->find();
            // if(!in_array($find['ChangeType'],[1,2,3,4,7,8,11,14])){
            //     return jsons('4001','开放时间：2019年1月7日，等待年报表确认！');
            // }
            // 删除附件
            if(isset($data['deteleImg']) && $data['deteleImg']){
                $deleteImgs = explode(',',$data['deteleImg']);
                $imgs = [];
                $oldImgs = explode(',',$find['ChangeImageIDS']);
                foreach($deleteImgs as $d){
                    $id = Db::name('upload_file')->where('FileUrl',$d)->value('id');
                    $imgs[] = $id;
                }
                $changeImags = implode(',',array_diff($oldImgs,$imgs));
                Db::name('change_order')->where('ChangeOrderID',$data['ChangeOrderID'])->setField('ChangeImageIDS',$changeImags);
                //dump($oldImgs);dump($imgs);halt(array_diff($oldImgs,$imgs));
            }
            if(in_array($find['ChangeType'] ,[1,2,3,4,7,8,9,12,14,15,16]) && $find['Status'] == 2){ //暂停计租，减免第二步要补充资料

                if(isset($_FILES) && $_FILES){         
                    foreach($_FILES as $k1 => $v1){
                        $ChangeImageIDS[] = model('ph/UserAudit') -> uploads($v1,$k1);
                    }
                    $ChangeImageIDS = implode(',', $ChangeImageIDS);  //返回的是使用权变更的影像资料id(多个以逗号隔开)
                    //halt($ChangeImageIDS);
                    if(isset($ChangeImageIDS)){ //执行添加

                        $changeImageIDS = $find['ChangeImageIDS']?$find['ChangeImageIDS'].','.$ChangeImageIDS:$ChangeImageIDS;    

                        $effect = Db::name('change_order')->where('ChangeOrderID' ,'eq' ,$data['ChangeOrderID'])->setField('ChangeImageIDS' ,$changeImageIDS);

                        if(!$effect){
                            return jsons('4003','添加资料失败');
                        }
                    }else{
                        return jsons('4002','请补充资料……');
                    }
                }
                
            }

            $data['reson'] = isset($data['reson'])?$data['reson']:'';

            $isfail = isset($data['isfail'])?$data['isfail']:2;
            $result = model('ph/ChangeAudit')->create_child_order($data['ChangeOrderID'], $data['reson'],$isfail); //执行审核

            return ($result === true)?jsons('2000' ,'审核完成'):jsons('4000' ,'审核异常');

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


    /**
     * 
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     */
    public function delete(){

        $changeOrderID = input('ChangeOrderID'); //变更编号

        $status = Db::name('change_order')->where('ChangeOrderID',$changeOrderID)->value('Status');

        $row = Db::name('use_child_order')->where('FatherOrderID',$changeOrderID)->find();

        if($status != 2){

            return jsons('4002' ,'异动单已在审核流程中，无法删除……');
        }elseif($status == 2 && $row){
            Db::name('change_order')->where('ChangeOrderID',$changeOrderID)->setField('Status',0);
        }else{

            $s = Db::name('change_order')->where('ChangeOrderID',$changeOrderID)->delete();
            if($s){
                return jsons('2000' ,'删除成功');
            }else{
                return jsons('4001' ,'删除失败');    
            }
        }

        
    }
}