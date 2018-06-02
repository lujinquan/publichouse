<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Piginator;
use think\Exception;
use think\Db;

class RepairLight extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__REPAIR_LIGHT__';

    /**
     * 获得小修列表信息
     */
    public function get_repair_light_list(){
        $list = Db::name('repair_light')->where('state', 0)->select();
        return $list;
    }
    /**
     * 获得小修明细
     */
    public function get_repair_light_detail($applyId){
        return Db::name('repair_light')->where('ApplyID', $applyId)->find();
    }
    /**
     * 获得维修项目明细
     */
    public function get_light_project_items($applyId){
        return Db::name('repair_project')->where('ApplyID', $applyId)->select();
    }

}