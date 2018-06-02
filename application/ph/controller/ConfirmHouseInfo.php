<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Config;
use app\ph\model\HouseInfo as HouseInfoModel;
use think\Db;

class ConfirmHouseInfo extends Base
{

    public function index()
    {

        //所有楼房屋基础信息
        $houseLst = $this->HouseInfoModel->get_all_house_lst();
        $rentPoint = Db::name('rent_cut_point')->select();
        foreach ($houseLst['arr'] as $vhouse) {
            $housearr[] = $vhouse['HouseID'];
        }
        $houseidss = isset($housearr) ? implode(',', $housearr) : '';
        $this->assign([
            'houseidss' => $houseidss,
            'rentPoint' => $rentPoint,
            'houseLst' => $houseLst['arr'],
            'houseLstObj' => $houseLst['obj'],
            'houseOption' => $houseLst['option'],
        ]);
        return $this->fetch();
    }

    public function edit()
    {
        $houseID = input('HouseID');
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            //$data['Status'] = 0; //状态改为未确认状态
            $one = Db::name('ban')->field('TubulationID ,InstitutionID ,OwnerType ,AreaFour,BanAddress')->where('BanID', 'eq', $data['BanID'])->find();
            $data['InstitutionID'] = $one['TubulationID'];
            $data['InstitutionPID'] = $one['InstitutionID'];
            $data['OwnerType'] = $one['OwnerType'];
            $data['BanAddress'] = $one['AreaFour'];
            if ($data['TenantID']) {  //租户id可以先不填，如果填，则进行效验
                $tenantName = Db::name('tenant')->where('TenantID', 'eq', $data['TenantID'])->value('TenantName');
                if (!$tenantName) {
                    return jsons('4001', '该租户不存在');
                } else {
                    $data['IfEmpty'] = 0;
                    $data['TenantName'] = $tenantName;
                }
            }else{
                $data['IfEmpty'] = 1;
                $data['TenantName'] = '';
            }
            if ($_FILES['HouseImageIDS']['error'] == 0) {
                foreach ($_FILES as $k => $v) {
                    $HouseImageIDS[] = model('HouseInfo')->uploads($v, $k);
                }
                $data['HouseImageIDS'] = implode(',', $HouseImageIDS);   //返回的是该房屋的影像资料id
            }
            $result = $this->validate($data, 'HouseInfo');
            if (true !== $result) {
                return jsons('4001', $result);
            }
            $fields = 'HouseID,UnitID,FloorID,UseNature,OldOprice,TenantID,NonliveIf';
            $oldOneData = Db::name('house')->field($fields)->where('HouseID', 'eq', $houseID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = Config::get($k1);
                }
            }
            if ($houseInfo = HouseInfoModel::update($data)) {
                if(!isset($allData)){$allData = array(); }
                // 记录行为
                action_log('HouseInfo_edit', UID, 2, '编号为:' . $data['HouseID'],json_encode($allData));
                return jsons('2000', '修改成功');
            } else {
                return jsons('4000', '修改失败');
            }
        }
        $data = Db::name('house')->where('HouseID', 'eq', $houseID)->find();
        $data['OwnerType'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('OwnerType');
        $data['HouseImageIDS'] = Db::name('upload_file')->where('id', 'eq', $data['HouseImageIDS'])->field('FileUrl ,FileTitle')->find();
         return $data?jsons('2000', '获取成功', $data):jsons('4000', '获取失败');
    }

    public function delete()
    {
        $houseID = input('HouseID');
        $style = input('style');
        if(!$houseID || !$style){
            return jsons(4004 ,'参数异常……');
        }else{
            $res = Db::name('house')->where('HouseID', 'eq', $houseID)->setField('Status',$style);
            if ($res) {
                $roomIDS = Db::name('room')->where('HouseID',$houseID)->column('RoomID');
                foreach($roomIDS as $roomid){
                    $houseid = Db::name('room')->where('RoomID',$roomid)->value('RoomPublicStatus');
                    if ($houseid == 1) {
                        Db::name('room')->where('RoomID',$roomid)->setField('Status',$style);
                    }
                }
                //当假删房屋后，同时将房屋下的所有房间假删掉
                // 记录行为
                action_log('HouseInfo_delete', UID, 2, '编号为:' . $houseID);
                return jsons(2000, '删除成功');
            } else {
                return jsons(4000, '删除失败，参数异常！');
            }
        }
    }

    /**
     * 房屋确认，由临时状态变为可用状态
     */
    public function confirm()
    {
        $houseID = input('HouseID');
        if (!$houseID) return jsons('4000', '参数缺失');
        $res = Db::name('house')->where('HouseID', 'eq', $houseID)->setField('Status', 1);
        if ($res) {
            return jsons('2000', '确认成功！');
        } else {
            return jsons('4000', '确认失败！');
        }
    }
}