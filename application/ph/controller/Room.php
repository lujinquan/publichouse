<?php
namespace app\ph\controller;

use think\Cache;
use app\ph\model\Room as RoomModel;
use think\Db;

class Room extends Base
{
    public function index(){
        $rentPoint = Db::name('rent_cut_point')->select();
        $roomPoint = Db::name('room_type_point')->field('id ,RoomTypeName')->select();
        $roomData = model('ph/Room')->get_all_room_lst(array('between' ,[1,9]));
        //halt($roomData['arr']);
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

    public function add(){
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            // 验证
            $result = $this->validate($data,'Room');
            if(true !== $result) {
                return jsons('4001',$result);
            }
            $maxid = Db::name('room')->max('RoomID');
            $data['RoomID'] = $maxid + 1;
            $datas = model('ph/Room')->add($data);
            $datas['Status'] = 1;  //状态改为未确认状态
            if ($roomInfo = RoomModel::create($datas)) {
                // 记录行为
                //action_log('BanInfo_add', UID ,1, '编号为:'.$data['BanID']);
                return jsons('2000','新增成功');
            } else {
                return jsons('4000','新增失败');
            }
        }
    }

    public function detail(){
        $roomID = input('RoomID');
        $datas = model('ph/Room')->get_one_room_detail_info($roomID);
        return jsons('2000' ,'获取成功' ,$datas);
    }
}