<?php
/**
 * 维修申请
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

class RepairLight extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
    	$lightRepairList = model('ph/RepairLight')->get_repair_light_list();
    	$this->assign([
            'lightRepairList' => $lightRepairList
            ]);
    	return $this->fetch();
    }
    /**
     * 小修明细
     */
    public function getLightDetail(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $light_detail = model('ph/RepairLight')->get_repair_light_detail($data['applyId']);
            $project_items = model('ph/RepairLight')->get_light_project_items($data['applyId']);
            $detail = array(
                'light_detail' => $light_detail,
                'project_items' => $project_items
                );
            return jsons('2000','获取成功', $detail);
        }
        echo '没有数据';
    }

}