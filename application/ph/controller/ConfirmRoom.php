<?php
namespace app\ph\controller;

use think\Cache;
use think\Config;
use app\ph\model\Room as RoomModel;
use think\Db;

class ConfirmRoom extends Base
{
    public function index(){
        $rentPoint = Db::name('rent_cut_point')->select();
        $roomPoint = Db::name('room_type_point')->field('id ,RoomTypeName')->select();
        $roomData = model('ph/Room')->get_all_room_lst();
        $roomTypeData = Db::name('room_type_point')->field('id ,RoomTypeName')->select();
        $this->assign([
            'rentPoint' => $rentPoint,
            'roomPoint' => $roomPoint,
            'roomTypeData' => $roomTypeData,
            'roomDataLst' => $roomData['arr'],
            'roomDataObj'=> $roomData['obj'],
            'roomOption' => $roomData['option'],
        ]);
        return $this->fetch();
    }

    public function edit(){
        $roomID = input('RoomID');
        if($this->request->isPost()){
            $data = array_no_space_str($this->request->post());
            //halt($data);
            $datas = model('ph/Room')->edit($data);  //1是为了区分添加和修改的，因为修改中的RoomID是不需要拼接的
            $datas['Status'] = 1; //状态改为未确认状态
            $fields = 'UnitID,FloorID,BanID,UseArea,RentPointIDS';
            $oldOneData = Db::name('room')->field($fields)->where('RoomID', 'eq', $roomID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = Config::get($k1);
                }
            }
            $oldHouses = Db::name('room')->where('RoomID','eq',$data['RoomID'])->value('HouseID');
            $oldHouseArr = explode(',',$oldHouses);
            if ($roomInfo = RoomModel::update($datas)) {
                $newHouses = Db::name('room')->where('RoomID','eq',$data['RoomID'])->value('HouseID');
                $newHouseArr = explode(',',$newHouses);
                $houseARR = array_merge(array_diff($oldHouseArr , $newHouseArr),array_diff($newHouseArr ,$oldHouseArr));
                array_map('change_house_data',$houseARR);
                if(!isset($allData)){$allData = array(); }
                // 记录行为
                action_log('Room_edit', UID ,8, '编号为:'.$data['RoomID'],json_encode($allData));
                return jsons('2000','修改成功');
            } else {
                return jsons('4000','修改失败');
            }
        }
        $data = Db::name('room')->where('RoomID','eq',$roomID)->find();
        $data['RentPoint'] = 100*(1-$data['RentPoint']).'%';
        if($data){
            return jsons('2000','获取成功',$data);
        }
        return jsons('4000','获取失败');
    }

    //注意：这是假删除，只是改变了该条记录的状态值，，同时将关联数据回滚
    public function delete(){
        $roomID = input('RoomID');
        $style = input('style');
        if(!$roomID || !$style){
            return jsons(4004 ,'参数异常……');
        }else{
            $res = Db::name('room')->where('RoomID' ,'eq' ,$roomID)->setField('Status',$style);
            if($res){
                model('ph/Room')->callback($roomID);
                // 记录行为
                //action_log('BanInfo_delete', UID ,1, '编号为:'.$banID);
                return jsons(2000 ,'删除成功');
            }else{
                return jsons(4000 ,'删除失败，参数异常！');
            }
        }
    }

    /**
     * 房间确认，由临时状态变为可用状态
     */
    public function confirm(){
        $roomID = input('RoomID');
        if(!$roomID) return jsons('4000','参数缺失');
        $res = Db::name('room')->where('RoomID', 'eq', $roomID)->setField('Status',1);
        if($res){
            $houseids = Db::name('room')->where('RoomID', 'eq', $roomID)->value('HouseID');
            if($houseids){
                $houseArr = explode(',',$houseids);
                foreach ($houseArr as $house) {
                    $temphouse = count_house_rent($house);
                    Db::name('house')->where('HouseID', 'eq', $house)->setField('ApprovedRent',$temphouse);
                }
            }
            return jsons('2000','确认成功！');
        }else{
            return jsons('4000','确认失败！');
        }
    }

}