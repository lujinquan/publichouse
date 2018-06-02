<?php
/**
 * 维修申请
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;
use think\Session;

class RepairApply extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
        $lightRepairList = model('ph/RepairApply')->get_repair_light_list();
        $houseList = model('ph/RepairApply')->get_house_info($lightRepairList);
        // print_r($lightRepairList);exit();
        $this->assign([
            'lightRepairList' => $lightRepairList,
            'houseList' => $houseList
            ]);
    	return $this->fetch();
    }
    /**
     *  提交小修订单信息
     */
    public function lightRepairAdd(){

        if($this->request->isPost()){
            $data = $this->request->post();
            // return jsons('2000','添加成功',$data);
            $lightRepairData = model('ph/RepairApply')->light_repair_data($data);
            // return jsons('2000','添加成功',$lightRepairData);

            $itemsData = model('ph/RepairApply')->repair_items_data($data);
            $resRepair = $resItems = null;
            $resRepair = Db::name('repair_light')->insert($lightRepairData);
            foreach ($itemsData as $value) {
                $resItems = Db::name('repair_project')->insert($value);
            }
            
            if( $resRepair && $resItems ){
                return jsons('2000','添加成功',$lightRepairData);
            } else {
                return jsons('4000','添加失败');
            }
        }
        echo '没有数据';
    	
    }
    /**
     *  中修申请（房屋维修）
     */
    public function middleRepairAdd(){
    	if($this->request->isPost()){
            $data = $this->request->post();
            $middleRepairData = model('ph/RepairApply')->middle_repair_data($data);
            Db::name('repair_middle')->insert($middleRepairData);
            return jsons('2000','添加成功');
        }
        echo '没有数据';
    }
    /**
     *  翻修改造
     */
    public function reconstructionAdd(){
    	
    }
    /**
     *  电器线隐患整治申请
     */
    public function repairWireAdd(){
    	if($this->request->isPost()){
            $data = $this->request->post();
            $wireData = model('ph/RepairApply')->wire_repair_data($data);
            Db::name('repair_wire')->insert($wireData);
            return jsons('2000','添加成功',$wireData);
        }
        echo '没有数据';
    }
    /**
     *  申请订单明细
     */
    public function applyDetail(){
        $applyId = input('ApplyID');
    	$lightRepairData = $this->RepairApplyModel->light_repair_detail($applyId);
        return jsons('2000','获取成功', $lightRepairData);
    }
    /**
     *  订单修改
     */
    public function modifyApply(){
    	
    }
    /**
     *  订单删除
     */
    public function deleteApply(){
    	$applyId = input('ApplyID');
        if($applyId){
            $res = Db::name('repair_apply')->where('ApplyID', $applyId)->delete();
            if($res){
                // 记录行为
                action_log('LightRepairInfo_delete', UID ,1, '编号为:'.$applyId);
                return jsons(2000 ,'删除成功');
            }else{
                return jsons(4000 ,'删除失败，参数异常！');
            }
        }

        return '没有数据';
    }

}