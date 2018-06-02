<?php
/**
 * 基数设置
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

class BaseSet extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
    	if ($this->request->isPost()) {
    		$data = $this->request->post();
    		$id = $data['id'];
            $data = null;
            switch ($id) {
                case '1':// 各类结构住房租金基价表
                    $data = $this->ban_structure_type();
                    break;
                case '2':// 住房使用面积的计算
                    $data = $this->room_type_point();
                    break;
                case '3':// 住房租金基价折减表
                    $data = $this->rent_cut_point();
                    break;
                case '4':// 楼栋层次调节率
                    $data = $this->floor_point();
                    break;
                case '5':// 各项加计租金
                    $data = $this->room_item_point();
                    break;
                
                default:
                    # code...
                    break;
            }
            return jsons('2000', '查询成功', $data);
    	}

    	$structure_type = Db::name('ban_structure_type')->select();
    	$this->assign(['structure_type' => $structure_type]);
    	return $this->fetch();
    }

    /**
     * 修改
     */
    public function modify(){
    	if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_modify($data);
            if ($ret) {
                return jsons('2000', '配置成功', $ret);
            } else {
                return jsons('4000', '配置失败', $ret);
            }
        }
        echo '没有数据';
    }
    /**
     * 基数配置增加
     */
    public function add(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_add($data);
            if ($ret) {
                return jsons('2000', '配置成功', $ret);
            } else {
                return jsons('4000', '配置失败', $ret);
            }
        }
        echo '没有数据';
    }
    /**
     * 基数配置删除
     */
    public function delete(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_delete($data);
            if ($ret) {
                return jsons('2000', '删除成功', $ret);
            } else {
                return jsons('4000', '删除失败', $ret);
            }
        }
        echo '没有数据';
    }


    /**
     * 各类结构住房租金基价表
     */
    public function ban_structure_type(){
        $data = Db::name('ban_structure_type')->field('id field0,StructureType field1, OldPoint field2, NewPoint field3')->select();
        $field = array('序号', '结构级别', '现行标准', '调整标准');
        return array(
            'data' => $data,
            'field' => $field
            );
    }
    /**
     * 住房使用面积的计算
     */
    public function room_type_point(){
        $data = Db::name('room_type_point')->field('id field0,RoomTypeName field1, (1-Point)*100 field2')->select();
        $field = array('序号', '项目', '面积折减率(%)');
        return array(
            'data' => $data,
            'field' => $field
            );
    }
    /**
     * 住房使用面积的计算
     */
    public function rent_cut_point(){
        $data = Db::name('rent_cut_point')->field('id field0,Item field1,Point*100 field2')->select();
        $field = array('序号', '项目', '折减率(%)');
        return array(
            'data' => $data,
            'field' => $field
            );
    }
    /**
     * 楼栋层次调节率
     */
    public function floor_point(){
    	$data = Db::name('floor_point')->select();
    	$arr = array();
    	foreach ($data as $info) {
    		$arr[$info['TotalFloor']][$info['LiveFloor']] = $info['FloorPoint'];
    	}
    	return $arr;
    }
    /**
     * 各项加计租金
     */
    public function room_item_point(){
        $data = Db::name('room_item_point')->field('id field0,Item field1,Ceil field2,UnitPrice field3')->select();
        $field = array('序号', '项目', '单位', '单价');
        return array(
            'data' => $data,
            'field' => $field
            );
    }

    /**
     * 更改数据库中参数配置
     * @param $data 需要更改的配置参数
     */
    public function parameter_modify($data){
    	$classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 各类结构住房租金基价表
            	$structureType = $data['structureType'];
            	$oldPoint = $data['oldPoint'];
            	$newPoint = $data['newPoint'];
            	$confId = $data['confId'];
                $ret = $this->ban_structure_type_modify($confId, $structureType, $oldPoint, $newPoint);
                break;
            case '2':// 住房使用面积的计算
            	$roomTypeName = $data['roomTypeName'];
            	$point = $data['point'];
            	$confId = $data['confId'];
                $ret = $this->room_type_point_modify($confId, $roomTypeName, $point);
                break;
            case '3':// 住房租金基价折减表
            	$item = $data['item'];
            	$point = $data['point'];
            	$confId = $data['confId'];
                $ret = $this->rent_cut_point_modify($confId, $item, $point);
                break;
            case '4':// 使用性质配置
                $ret = $this->floor_point_modify($data['data']);
                break;
            case '5':// 各项加计租金
            	$item = $data['item'];
            	$ceil = $data['ceil'];
            	$unitPrice = $data['unitPrice'];
            	$confId = $data['confId'];
                $ret = $this->room_item_point_modify($confId, $item, $ceil, $unitPrice);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
    public function ban_structure_type_modify($confId, $structureType, $oldPoint, $newPoint){
    	$ret = Db::name('ban_structure_type')
    				->where('id', $confId)
    				->update([
    					'StructureType' => $structureType,
    					'OldPoint' => $oldPoint,
    					'NewPoint' => $newPoint
    					]);
        return $ret;
    }
    public function room_type_point_modify($confId, $roomTypeName, $point){
    	$ret = Db::name('room_type_point')
    				->where('id', $confId)
    				->update([
    					'RoomTypeName' => $roomTypeName,
    					'Point' => 1-($point*1.0/100)
    					]);
        return $ret;
    }
    public function rent_cut_point_modify($confId, $item, $point){
    	$ret = Db::name('rent_cut_point')
    				->where('id', $confId)
    				->update([
    					'Item' => $item,
    					'Point' => $point*1.0/100
    					]);
        return $ret;
    }
    public function floor_point_modify($data){
    	$len = count($data[0]);
    	$key = $data[0];
    	$val = $data[1];
    	$ret = 0;
    	for ($i=0; $i < $len; $i++) { 
    		$nums = explode('-', $key[$i]);
    		$point = $val[$i];
    		$ret += Db::name('floor_point')->where(['TotalFloor' => $nums[1], 'LiveFloor' => $nums[2]])->update(['FloorPoint' => $point]);
    	}
    	return $ret;
    }
    public function room_item_point_modify($confId, $item, $ceil, $unitPrice){
    	$ret = Db::name('room_item_point')
    				->where('id', $confId)
    				->update([
    					'Item' => $item,
    					'Ceil' => $ceil,
    					'UnitPrice' => $unitPrice
    					]);
        return $ret;
    }

    /**
     * 增加
     */
    public function parameter_add($data){
    	$classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 各类结构住房租金基价表
            	$structureType = $data['structureType'];
            	$oldPoint = $data['oldPoint'];
            	$newPoint = $data['newPoint'];
            	// $confId = $data['confId'];
                $ret = $this->ban_structure_type_add($structureType, $oldPoint, $newPoint);
                break;
            case '2':// 住房使用面积的计算
            	$roomTypeName = $data['roomTypeName'];
            	$point = $data['point'];
                $ret = $this->room_type_point_add($roomTypeName, $point);
                break;
            case '3':// 住房租金基价折减表
            	$item = $data['item'];
            	$point = $data['point'];
                $ret = $this->rent_cut_point_add($item, $point);
                break;
            case '4':// 使用性质配置
                // $ret = $this->use_nature_modify($confId, $confContent);
                break;
            case '5':// 各项加计租金
            	$item = $data['item'];
            	$ceil = $data['ceil'];
            	$unitPrice = $data['unitPrice'];
            	// $confId = $data['confId'];
                $ret = $this->room_item_point_add($item, $ceil, $unitPrice);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
    public function ban_structure_type_add($structureType, $oldPoint, $newPoint){
    	$data = ['StructureType' => $structureType, 'OldPoint' => $oldPoint, 'NewPoint'  => $newPoint];
        $ret = Db::name('ban_structure_type')->insert($data);
        $addId = Db::name('ban_structure_type')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function room_type_point_add($roomTypeName, $point){
    	$data = ['RoomTypeName' => $roomTypeName, 'Point' => 1-($point*1.0/100)];
        $ret = Db::name('room_type_point')->insert($data);
        $addId = Db::name('room_type_point')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function rent_cut_point_add($item, $point){
    	$data = ['Item' => $item, 'Point' => $point*1.0/100];
        $ret = Db::name('rent_cut_point')->insert($data);
        $addId = Db::name('rent_cut_point')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function room_item_point_add($item, $ceil, $unitPrice){
    	$data = ['Item' => $item, 'Ceil' => $ceil, 'UnitPrice' => $unitPrice];
        $ret = Db::name('room_item_point')->insert($data);
        $addId = Db::name('room_item_point')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }

    /**
     * 删除
     */
    public function parameter_delete($data){
    	$confId = $data['confId'];
        $classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 各类结构住房租金基价表
                $ret = $this->ban_structure_type_delete($confId);
                break;
            case '2':// 住房使用面积的计算
                $ret = $this->room_type_point_delete($confId);
                break;
            case '3':// 住房租金基价折减表
                $ret = $this->rent_cut_point_delete($confId);
                break;
            case '4':// 使用性质配置
                // $ret = $this->use_nature_modify($confId, $confContent);
                break;
            case '5':// 各项加计租金
                $ret = $this->room_item_point_delete($confId);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
    public function ban_structure_type_delete($confId){
    	return Db::name('ban_structure_type')->delete($confId);
    }
    public function room_type_point_delete($confId){
    	return Db::name('room_type_point')->delete($confId);
    }
    public function rent_cut_point_delete($confId){
    	return Db::name('rent_cut_point')->delete($confId);
    }
    public function room_item_point_delete($confId){
    	return Db::name('room_item_point')->delete($confId);
    }

}