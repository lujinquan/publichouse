<?php

namespace app\ph\controller;

use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
use app\ph\model\HouseInfo as HouseInfoModel;
use app\ph\model\Room as RoomModel;
use think\Db;
use think\Debug;

/**
 * @title 接口控制器
 * @author Mr.Lu
 * @description
 */
class Api extends Controller
{
    /**
     * @title 获取房屋对应的租户信息 ：注意，需要检测是否允许查询当前房屋信息（房管员只能查询自己所处管段的房屋）
     * @author Mr.Lu
     * @param  TenantID  房屋编号
     * @return array [ TenantID  租户编号 ， TenantName  租户姓名 ， TenantTel  租户电话  ]
     */
    public function get_house_tenant()
    {
        $houseID = input('HouseID');

        $institution = Db::name('house')->where('HouseID', 'eq', $houseID)->value('InstitutionID');

        if ($institution != session('user_base_info.institution_id')) {

            return jsons('4002', '请先确认房屋是否位于您所在的管段');
        }

        if (!$houseID) {

            return jsons('4000', '未传入房屋编号参数');
        }

        $data = Db::name('tenant')->alias('a')
            ->join('house b', 'a.TenantID = b.TenantID', 'left')
            ->where('b.HouseID', 'eq', $houseID)
            ->field('a.TenantID ,a.TenantName ,a.TenantTel,a.TenantNumber')
            ->find();

        if (!$data) {

            return jsons('4001', '找不到该房屋对应的租户信息');
        }

        return jsons('2000', '获取成功', $data);
    }

    function get_relation_area()
    {
        $data = Db::name('area')->select();
        return $data;
    }

    public function get_house_rent_detail()
    {
        $houseID = input('HouseID');

        if (!$houseID) {
            return jsons('4000', '未传入房屋编号参数');
        }

        $where['HouseID'] = array('like', '%' . $houseID . '%');
        $where['Status'] = array('eq', 1);

        $datass = Db::name('room')->alias('a')
            ->join('room_type_point b', 'a.RoomType = b.id', 'left')
            ->field('BanID,RoomID,UnitID,FloorID,RoomNumber,BanAddress,RoomTypeName,UseArea,LeasedArea,RoomPublicStatus')
            ->where($where)
            ->select();
        //halt($data);

        foreach ($datass as $keys => $values) {


            if ($values['RoomPublicStatus'] == 1) {
                $values['RoomPublicStatus'] = '私有';
            } elseif ($values['RoomPublicStatus'] == 2) {
                $values['RoomPublicStatus'] = '两户共有';
            } else {
                $values['RoomPublicStatus'] = '三户及三户以上共用';
            }

            $data[$keys][0][] = $values['BanID'];
            $data[$keys][0][] = $values['UnitID'];
            $data[$keys][0][] = $values['FloorID'];
            $data[$keys][0][] = $values['RoomPublicStatus'];
            $data[$keys][0][] = $values['BanAddress'];
            $data[$keys][1][] = $values['RoomID'];
            $data[$keys][1][] = $values['RoomTypeName'];
            $data[$keys][1][] = $values['UseArea'];
            $data[$keys][1][] = $values['LeasedArea'];
            $data[$keys][1][] = $values['RoomNumber'];
        }

        return jsons(2000, '获取成功', $data);
    }

    /**
     * 修改公告信息
     */
    public function show()
    {

        $data = $this->request->post();
        $ret = model('ph/Notice')->get_notice_info($data);
        return jsons('2000', '发布成功', $ret);

    }

    /**
     * @title 获取租户信息
     * @author Mr.Lu
     * @param  TenantID  租户编号
     * @return array [ TenantID  租户编号 ， TenantName  租户姓名 ， TenantTel  租户电话  ]
     */
    public function get_tenant_info()
    {
        $tenantID = input('TenantID');

        if (!$tenantID) {

            return jsons('4000', '未传入租户编号参数');
        }

        $data = Db::name('tenant')->where('TenantID', 'eq', $tenantID)->field('TenantID ,TenantName ,TenantTel,TenantBalance,TenantNumber')->find();

        if (!$data) {

            return jsons('4001', '找不到该租户信息');
        }

        return jsons('2000', '获取成功', $data);

    }

    public function get_house_info()
    {

        $houseID = input('HouseID');
        $institution = Db::name('house')->where('HouseID', 'eq', $houseID)->value('InstitutionID');

//        if($institution != session('user_base_info.institution_id')){
//
//            return jsons('4002' ,'请先确认房屋是否位于您所在的管段');
//        }

        if (!$houseID) {
            return jsons('4000', '未传入房屋编号参数');
        }
        $map = 'a.*,b.DamageGrade ,b.StructureType ,b.AreaFour,b.PreRent,b.TotalArea,b.TotalOprice,b.BanUsearea,b.BanAddress ,b.CoveredArea ,c.TenantTel,c.TenantNumber';
        //承租人姓名
        $data = Db::name('house')->alias('a')
            ->join('ban b', 'a.BanID = b.BanID', 'left')
            ->join('tenant c', 'a.TenantID = c.TenantID', 'left')
            ->where('a.HouseID', 'eq', $houseID)
            ->field($map)
            ->find();

        $data['OwnerType'] = get_owner($data['OwnerType']);
        $data['AnathorOwnerType'] = $data['AnathorOwnerType'] ? get_owner($data['AnathorOwnerType']) : '暂无';
        $data['DamageGrade'] = get_damage($data['DamageGrade']);
        $data['TubulationID'] = get_institution($data['InstitutionID']);
        $data['StructureType'] = get_structure($data['StructureType']);
        $data['UseNature'] = get_usenature($data['UseNature']);
        $data['CreateTime'] = date('Y-m-d H:i:s', $data['CreateTime']);

        $arr = Db::name('room')->where('HouseID','like','%'.$houseID.'%')->group('BanID')->column('BanID');

        $begin = date('Y',time()).'00';
        $now = date('Ym',strtotime('-1 month'));
        $data['Room'] = Db::name('rent_order')->where(['OrderDate'=>['between',[$begin,$now]],'HouseID'=>$houseID,'Type'=>2])->field('OrderDate,UnpaidRent')->select();

        if($arr){
            $data['Ban'] = Db::name('ban')->alias('a')->join('ban_owner_type b','a.OwnerType = b.id','left')->where('BanID','in',$arr)->field('a.BanID,a.AreaFour as BanAddress,a.PreRent,a.TotalArea,a.BanUsearea,a.TotalOprice,b.OwnerType')->select();

            //halt($data['BanDetail']);
        }else{

           $data['Ban'][] = [
                'BanID' => $data['BanID'],
                'BanAddress' => $data['AreaFour'],
                'OwnerType' => $data['OwnerType'],
                'PreRent' => $data['PreRent'],
                'TotalArea' => $data['TotalArea'],
                'BanUsearea' => $data['BanUsearea'],
                'TotalOprice' => $data['TotalOprice'],
           ]; 
        }

    
        

        if (!$data) {
            return jsons('4001', '找不到该房屋对应的租户信息');
        }

        $data['RoomNumbers'] = Db::name('Room')->where('HouseID', 'like', '%' . $houseID . '%')->column('RoomNumber,RoomID');

        $data['BanAddress'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('BanAddress');
        return jsons('2000', '获取成功', $data);
    }


    public function get_ban_info()
    {

        $banID = input('BanID');

        $map = 'BanAddress ,BanID ,DamageGrade ,StructureType ,UseNature ,OwnerType ,BanUnitNum ,BanFloorNum ,TotalArea ,BanUsearea ,CoveredArea ,TubulationID ,CreateTime ,PreRent,TotalOprice';

        $data = Db::name('ban')->where('BanID', 'eq', $banID)->field($map)->find();

        $data['DamageGrade'] = get_damage($data['DamageGrade']);
        $data['UseNature'] = get_usenature($data['UseNature']);
        $data['OwnerType'] = get_owner($data['OwnerType']);
        $data['TubulationID'] = get_institution($data['TubulationID']);
        $data['StructureType'] = get_structure($data['StructureType']);
        $data['CreateTime'] = date('Y-m-d H:i:s', $data['CreateTime']);
//halt($data);

        return jsons('2000', '获取成功', $data);
    }

    /**
     * 获取某个楼栋的详细信息
     */
    public function get_ban_detail_info()
    {
        $banID = input('BanID');
        if (!$banID) return jsons('4004', '参数缺失');
        $data['top'] = model('ph/BanInfo')->get_one_ban_detail_info($banID);
        $data['bottom'] = Db::name('house')->field('HouseID ,TenantName ,UseNature,DoorID ,UnitID ,FloorID ,HouseUsearea ,HousePrerent')->where('BanID', 'eq', $banID)->select();
        foreach ($data['bottom'] as &$value) {
            $value['UseNature'] = get_usenature($value['UseNature']);
        }
        return jsons('2000', '获取成功', $data);
    }


    /**
     * @title 获取所有机构接口（根据当前登录的id权限判断）
     * @method  POST
     * @author Mr.Lu
     * @param  InstitutionID  机构ID
     * @param  BanAddress  楼栋地址
     * @param  TenantName  租户姓名
     * @param  page  页数
     * @param  InstitutionID  机构ID
     * @return array [ TenantID  租户编号 ， TenantName  租户姓名 ， TenantTel  租户电话  ]
     */
    public function get_all_institution()
    {

        return jsons('2000', '获取成功', get_all_institution());
    }

    /**
     * @title 房屋计租表接口（展示部分）
     * @author Mr.Lu
     * @param  HouseID  房屋编号
     * @return array
     */
    public function get_rent_table_detail()
    {
        $houseid = input('HouseID');
        $result['houseDetail'] = get_house_info($houseid);
        $itemPrices = Db::name('room_item_point')->column('id,UnitPrice');
        $result['houseDetail']['WallpaperArea'] = $result['houseDetail']['WallpaperArea'] * $itemPrices[1];
        $result['houseDetail']['CeramicTileArea'] = $result['houseDetail']['CeramicTileArea'] * $itemPrices[2];
        $result['houseDetail']['BathtubNum'] = $result['houseDetail']['BathtubNum'] * $itemPrices[3];
        $result['houseDetail']['BasinNum'] = $result['houseDetail']['BasinNum'] * $itemPrices[4];
        $result['houseDetail']['BelowFiveNum'] = $result['houseDetail']['BelowFiveNum'] * $itemPrices[5];
        $result['houseDetail']['MoreFiveNum'] = $result['houseDetail']['MoreFiveNum'] * $itemPrices[6];
        //halt($result);
        //获取顶部所属楼栋信息
        $result['banDetail'] = get_ban_info($result['houseDetail']['BanID']);
        //获取所拥有的房间信息
        $rooms = Db::name('room')->field('RoomID,OwnerType,RoomNumber,RoomType,BanID,HouseID,UnitID,FloorID,UseArea,RoomPrerent,RentPoint,RentPointIDS,LeasedArea,RoomRentMonth,Status,RoomPublicStatus')
            ->where(['HouseID' => ['like', '%' . $houseid . '%'], 'Status' => ['<', 5]])
            ->select();
        $roomTypeNames = Db::name('room_type_point')->column('id,RoomTypeName');
        $sort = Db::name('room_type_point')->column('id,Sort');

        foreach ($rooms as $key => $value) {
            $value['RentPoint'] = (100 - $value['RentPoint'] * 100) . '%';
            $value['OwnerType'] = get_owner($value['OwnerType']);
            $value['FloorPoint'] = ((get_floor_point($value['FloorID'], $result['banDetail']['BanFloorNum'], $result['banDetail']['IfElevator'])) * 100) . '%'; 
            $value['RoomName'] = $roomTypeNames[$value['RoomType']];
            switch ($value['RoomPublicStatus']) {
                case 1:
                    $value['RoomPublicStatus'] = '独用';
                    break;
                default:
                    $value['RoomPublicStatus'] = '共用';
                    break;
            }

            switch ($value['Status']) {
                case 0:
                    $value['Status'] = '未确认';
                    break;
                case 1:
                    $value['Status'] = '正常';
                    break;
                case 2:
                    $value['Status'] = '修改中';
                    break;
                case 3:
                    $value['Status'] = '异动中';
                    break;
                case 4:
                    $value['Status'] = '删除中';
                    break;
                default:
                    break;
            }
            $result['roomDetail'][$sort[$value['RoomType']]][] = $value;
        }

        if (isset($result['roomDetail'])) {
            ksort($result['roomDetail']);
        }

        return jsons('2000', '获取成功', $result);
    }

    /**
     * @title 房屋计租表接口（修改默认部分）
     * @author Mr.Lu
     * @param  HouseID  房屋编号
     * @return array
     */
    public function get_edit_rent_table_detail()
    {
        $houseid = input('HouseID');
        $result['houseDetail'] = get_house_info($houseid);
        //获取顶部所属楼栋信息
        $result['banDetail'] = get_ban_info($result['houseDetail']['BanID']);

        //获取所拥有的房间信息
        $rooms = Db::name('room')->field('RoomID,OwnerType,RoomNumber,RoomType,BanID,HouseID,UnitID,FloorID,UseArea,RentPoint,RoomPrerent,RentPointIDS,LeasedArea,RoomRentMonth,Status')
            ->where(['HouseID' => ['like', '%' . $houseid . '%'], 'Status' => ['<', 5]])
            ->select();
        //halt($rooms);
        $roomTypeNames = Db::name('room_type_point')->order('Sort asc')->column('Sort,RoomTypeName');
        $sort = Db::name('room_type_point')->column('id,Sort');
        $result['roomTypes'] = $roomTypeNames;
        foreach ($rooms as $key => $value) {
            $value['RentPoint'] = (100 - $value['RentPoint'] * 100) . '%';
            $value['FloorPoint'] = ((get_floor_point($value['FloorID'], $result['banDetail']['BanFloorNum'], $result['banDetail']['IfElevator'])) * 100) . '%';
            $value['RoomName'] = $roomTypeNames[$value['RoomType']];

            $result['roomDetail'][$sort[$value['RoomType']]][] = $value;
        }

        return jsons('2000', '获取成功', $result);
    }

    /**
     * @title 新发租扩建房屋编号
     * @author Mr.Lu
     * @return array [ TenantID  租户编号 ， TenantName  租户姓名 ， TenantTel  租户电话  ]
     */
    public function get_house_detail_status()
    {
        $houseid = input('HouseID');
        $roomsArr = Db::name('room')->field('RoomID,Status')->where('HouseID', 'like', '%' . $houseid . '%')->select();
        $data = array();
        foreach ($roomsArr as $key => $value) {
            switch ($value['Status']) {
                case 0:
                    $data['unconfirmedRoom'][] = $value['RoomID'];
                    break;
                case 1:
                    $data['nomalRoom'][] = $value['RoomID'];
                    break;
                case 2:
                    $data['editRoom'][] = $value['RoomID'];
                    break;
                case 4:
                    $data['deleteRoom'][] = $value['RoomID'];
                    break;
                default:
                    break;
            }
        }

        return jsons('2000', '获取成功', $data);

    }

    /**
     * @title 房屋查询器接口
     * @author Mr.Lu
     */
    public function get_all_ban_info()
    {

        if ($this->request->isPost()) {
            $map = $this->request->post();
        }
        //默认查询条件
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);

        //检索查询条件
        if (isset($map['InstitutionID']) && $map['InstitutionID']) { //楼栋机构查询
            $level = Db::name('institution')->where('id', 'eq', $map['InstitutionID'])->value('Level');
            if ($level == 3) {
                $where['TubulationID'] = array('eq', $map['InstitutionID']);
            } elseif ($level == 2) {
                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
            }
        }
        if (isset($map['BanID']) && $map['BanID']) {  //模糊检索租户姓名
            $where['BanID'] = array('like', '%' . $map['BanID'] . '%');
        }
        if (isset($map['DamageGrade']) && $map['DamageGrade']) {  //检索完损等级
            $where['DamageGrade'] = array('eq', $map['DamageGrade']);
        }
        if (isset($map['StructureType']) && $map['StructureType']) {  //检索结构等级
            $where['StructureType'] = array('eq', $map['StructureType']);
        }
        if (isset($map['OwnerType']) && $map['OwnerType']) {  //检索产别
            $where['OwnerType'] = array('eq', $map['OwnerType']);
        }
        if (isset($map['UseNature']) && $map['UseNature']) {  //检索使用性质
            $where['UseNature'] = array('eq', $map['UseNature']);
        }
        if (isset($map['BanAddress']) && $map['BanAddress']) {  //模糊检索楼栋地址
            $where['BanAddress'] = array('like', '%' . $map['BanAddress'] . '%');
        }
        if (isset($map['Status']) && $map['Status']) {  //检索楼栋状态
            $where['Status'] = array('in', $map['Status']);
        }

        $data = Db::name('ban')->where($where)
            ->field('BanID ,DamageGrade ,StructureType ,OwnerType ,UseNature,BanAddress')
            ->paginate(config('paginate.list_rows'))
            ->toArray();

        if ($data['data']) {
            foreach ($data['data'] as &$v) {
                $v['DamageGrade'] = get_damage($v['DamageGrade']);//完损等级
                $v['OwnerType'] = get_owner($v['OwnerType']);   //楼栋产别
                $v['StructureType'] = get_structure($v['StructureType']);//结构名称
                $v['UseNature'] = get_usenature($v['UseNature']);   //使用性质
            }
        }

        $data['totalPage'] = ceil($data['total'] / $data['per_page']);
        return jsons('2000', '获取成功', $data);

    }

    /**
     * @title 房屋查询器接口
     * @author Mr.Lu
     */
    public function get_all_house_info()
    {

        if ($this->request->isPost()) {
            $map = $this->request->post();
        }
        //默认查询条件
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);

        //检索查询条件
        if (isset($map['InstitutionID']) && $map['InstitutionID']) { //楼栋机构查询
            $level = Db::name('institution')->where('id', 'eq', $map['InstitutionID'])->value('Level');
            if ($level == 3) {
                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
            } elseif ($level == 2) {
                $where['InstitutionPID'] = array('eq', $map['InstitutionID']);
            }
        }
        if (isset($map['HouseID']) && $map['HouseID']) {  //模糊检索租户姓名
            $where['HouseID'] = array('like', '%' . $map['HouseID'] . '%');
        }
        if (isset($map['BanAddress']) && $map['BanAddress']) {  //模糊检索楼栋地址
            $where['BanAddress'] = array('like', '%' . $map['BanAddress'] . '%');
        }
        if (isset($map['TenantName']) && $map['TenantName']) {  //模糊检索租户姓名
            $where['TenantName'] = array('like', '%' . $map['TenantName'] . '%');
        }
        if (isset($map['Status']) && $map['Status']) {  //检索房屋状态
            $where['Status'] = array('in', $map['Status']);
        }

        $data = Db::name('house')->where($where)
            ->field('BanID ,HouseID ,UnitID ,FloorID ,TenantName,BanAddress,HousePrerent')
            ->paginate(config('paginate.list_rows'))
            ->toArray();
        $data['totalPage'] = ceil($data['total'] / $data['per_page']);
        return jsons('2000', '获取成功', $data);

    }

    /**
     * @title 楼栋查询器接口
     * @author Mr.Lu
     */
    public function get_all_ban()
    {

        if ($this->request->isPost()) {
            $map = $this->request->post();
        }
        //默认查询条件
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);

        //检索查询条件
        if (isset($map['InstitutionID']) && $map['InstitutionID']) { //楼栋机构查询
            $level = Db::name('institution')->where('id', 'eq', $map['InstitutionID'])->value('Level');
            if ($level == 3) {
                $where['TubulationID'] = array('eq', $map['InstitutionID']);
            } elseif ($level == 2) {
                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
            }
        }

        $data = Db::name('ban')->where($where)
            ->field('BanID ,DamageGrade ,StructureType ,OwnerType ,UseNature,AreaFour')
            ->select();

        $dams = Db::name('ban_damage_grade')->column('id,DamageGrade');
        $owns = Db::name('ban_owner_type')->column('id,OwnerType');
        $strs = Db::name('ban_structure_type')->column('id,StructureType');
        $uses= Db::name('use_nature')->column('id,UseNature');

        if ($data) {
            foreach ($data as &$v) {
                $v['DamageGrade'] = $dams[$v['DamageGrade']];//完损等级
                $v['OwnerType'] = $owns[$v['OwnerType']];   //楼栋产别
                $v['StructureType'] = $strs[$v['StructureType']];//结构名称
                $v['UseNature'] = isset($uses[$v['UseNature']])?$uses[$v['UseNature']]:'';   //使用性质
            }
        }

        return jsons('2000', '获取成功', $data);

    }

    /**
     * @title 异动的时候调用的查询
     * @author Mr.Lu
     */
    public function get_all_house()
    {

        if ($this->request->isGet()) {
            $map = $this->request->get();
        }
        //默认查询条件
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);
        $where['BanID'] = array('eq',input('BanID'));
        $where['IfSuspend'] = array('eq', 0);
        $where['HouseChangeStatus'] = array('eq', 0);
       
        $data = Db::name('house')->where($where)
            ->field('HouseID ,OwnerType,UseNature,TenantName,HousePrerent,BanAddress')
            ->select();

        $owns = Db::name('ban_owner_type')->column('id,OwnerType');
        $uses= Db::name('use_nature')->column('id,UseNature');

        if ($data) {
            foreach ($data as &$v) {
                $v['OwnerType'] = $owns[$v['OwnerType']];   //楼栋产别
                $v['UseNature'] = isset($uses[$v['UseNature']])?$uses[$v['UseNature']]:'';   //使用性质
            }
        }
        
        return jsons('2000', '获取成功', $data);

    }

    /**
     * @title 房屋查询器接口
     * @author Mr.Lu
     */
    public function get_all_info()
    {

        if ($this->request->isPost()) {
            $map = $this->request->post();
        }
        //默认查询条件
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);

        //检索查询条件
        if (isset($map['InstitutionID']) && $map['InstitutionID']) { //楼栋机构查询
            $level = Db::name('institution')->where('id', 'eq', $map['InstitutionID'])->value('Level');
            if ($level == 3) {
                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
            } elseif ($level == 2) {
                $where['InstitutionPID'] = array('eq', $map['InstitutionID']);
            }
        }
        if (isset($map['HouseID']) && $map['HouseID']) {  //模糊检索租户姓名
            $where['HouseID'] = array('like', '%' . $map['HouseID'] . '%');
        }
        if (isset($map['BanAddress']) && $map['BanAddress']) {  //模糊检索楼栋地址
            $where['BanAddress'] = array('like', '%' . $map['BanAddress'] . '%');
        }
        if (isset($map['TenantName']) && $map['TenantName']) {  //模糊检索租户姓名
            $where['TenantName'] = array('like', '%' . $map['TenantName'] . '%');
        }
        if (isset($map['Status']) && $map['Status']) {  //检索房屋状态
            $where['Status'] = array('in', $map['Status']);
        }

        $data = Db::name('house')->where($where)
            ->field('BanID ,HouseID ,UnitID ,FloorID ,TenantName,BanAddress')
            ->paginate(config('paginate.list_rows'))
            ->toArray();
        $data['totalPage'] = ceil($data['total'] / $data['per_page']);
        return jsons('2000', '获取成功', $data);

    }

    public function get_all_tenant_info()
    {
        if ($this->request->isPost()) {
            $map = $this->request->post();
        }
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $where['Status'] = array('eq', 1);
        if (isset($map['InstitutionID']) && $map['InstitutionID']) { //楼栋机构查询
            $level = Db::name('institution')->where('id', 'eq', $map['InstitutionID'])->value('Level');
            if ($level == 3) {
                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
            } elseif ($level == 2) {
                $where['InstitutionPID'] = array('eq', $map['InstitutionID']);
            }
        }
        if (isset($map['TenantTel']) && $map['TenantTel']) {  //模糊检索租户联系方式
            $where['TenantTel'] = array('like', '%' . $map['TenantTel'] . '%');
        }
        if (isset($map['TenantName']) && $map['TenantName']) {  //模糊检索租户姓名
            $where['TenantName'] = array('like', '%' . $map['TenantName'] . '%');
        }
        if (isset($map['Status']) && $map['Status']) {  //检索租户状态
            $where['Status'] = array('in', $map['Status']);
        }

        $data = Db::name('tenant')->where($where)
            ->field('TenantID ,TenantName, TenantTel ,TenantNumber ,BankID ,BankName ')
            ->paginate(config('paginate.list_rows'))
            ->toArray();

        $data['totalPage'] = ceil($data['total'] / $data['per_page']);

        return jsons('2000', '获取成功', $data);
    }

    //房屋统计查询接口
    public function queryHouseReport_old()
    {
        //$where['Status'] = array('eq', 1);

        //主页面默认数据
        $institutionid = session('user_base_info.institution_id');
        $ownerType = 1;
        $queryType = 1;
        $date = date('Ym', time());

        $HouseIdList['option'] = array();
        if ($searchForm = input('post.')) {
            $propertyOption = $searchForm;
            if (!empty($searchForm['TubulationID'])) {   //检索机构
                $institutionid = $searchForm['TubulationID'];
            }
            if (!empty($searchForm['OwnerType'])) {  //检索楼栋产别
                $ownerType = $searchForm['OwnerType'];
            }
            if (!empty($searchForm['QueryType'])) {  //检索楼栋产别
                $queryType = $searchForm['QueryType'];
            }
            if (!empty($searchForm['month'])) {
                $date = str_replace('-', '', $searchForm['month']);
            }
        }
        $datas = json_decode(Cache::store('file')->get('HouseReport' . $date, ''), true);
        $results['data'] = $datas ? $datas[$queryType][$ownerType][$institutionid] : array();
        //halt($results['data']);
        $results['option'] = $propertyOption;

        return jsons('2000', '获取成功', $results);
    }

    public function queryRentEntry()
    {
        $houseid = input('HouseID');
        $data = Db::name('rent_entry')->where('HouseID',$houseid)
            ->field('HouseID,OldYearUnpaid,Month,MonthUnpaid,MonthPaid,YearReceived')
            ->select();
        if($data){
            foreach ($data as $k => $v) {
                $result[$k] = [$v['MonthUnpaid'] , $v['MonthPaid'], $v['YearReceived']];
            }
            $result[] = [$houseid ,$data[0]['OldYearUnpaid']];
            return jsons('2000','获取成功',$result);
        }else{
            return jsons('2000','获取成功');
        }
    }

    public function queryHouseReport()
    {
        //主页面默认数据
        $where['Status'] = 1;
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        //halt($currentUserLevel);
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['TubulationID'] = $currentUserInstitutionID;
        } elseif($currentUserLevel == 2){
            $where['InstitutionID'] = $currentUserInstitutionID;
            //return jsons('4000','数据核对期间，只能以房管员的账号来查看');
            $where['OwnerType'] = 1;
        }else{
            $where['OwnerType'] = 1;
        }
        $result['option'] = array();
        if ($searchForm = input('post.')) {
            $result['option'] = $searchForm;
            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = $searchForm['OwnerType'];
            }
            switch($searchForm['QueryType']){
                case '1':
                    $result['data'] = model('ph/HouseReports')->get_by_damage($where);
                    break;
                case '2':
                    $result['data'] = model('ph/HouseReports')->get_by_useNature($where);
                    break;
                case '3';
                    $result['data'] = model('ph/HouseReports')->get_by_institution($where);
                    break;
                case '4':
                    $result['data'] = model('ph/HouseReports')->get_by_year($where);
                    break;
                case '5':
                    $result['data'] = model('ph/HouseReports')->get_by_value($where);
                    break;
                default:
                    break;
            }
            return jsons('2000', '获取成功', $result);
        }
    }


    public function edit_password()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $id = session('user_base_info.uid');
            $one = Db::name('admin_user')->where('Number', $id)->field('Password,Salt')->find();
            if ($one['Password'] != md5(md5($data['oldPassword'] . $one['Salt']))) {
                return jsons('4002', '原密码输入错误……');
            }
            if (!preg_match("/^[A-Za-z0-9]{6,18}+$/", $data['newPassword'])) {
                return jsons('4002', '新密码不合法');
            }
            if ($data['newPassword'] !== $data['repeatPassword']) {
                return jsons('4002', '密码输入不一致');
            }

            $newPassword = md5(md5($data['newPassword'] . $one['Salt']));
            $res = Db::name('admin_user')->where('Number', $id)->setField('Password', $newPassword);
            if ($res) {
                return jsons('2000', '修改成功');
            } else {
                return jsons('4000', '修改失败');
            }
        }
    }

    /**
     * @title 获取楼栋经纬度
     * @author Mr.Lu
     * @param  RoomType  房间类型 ，FloorID  层次 , BanID  楼栋编号， IfThree  是否三户共用
     * @param
     * @return array [ TenantID  租户编号 ， TenantName  租户姓名 ， TenantTel  租户电话  ]
     */
    public function get_ban_map_point()
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }

        if ($this->request->isPost()) {
            $searchForm = $this->request->post();
            if ($searchForm) {
                if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                    $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');

                    if ($level == 3) {
                        $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
                    } elseif ($level == 2) {
                        $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                    }
                }
                if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {
                    $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
                }
            }
        }

        if (!isset($where)) {
            $where = 1;
        }

        if (isset($searchForm)) {
            $data['options'] = $searchForm;
        }

        $houses = Db::name('house')->group('BanID')->column('BanID, count(HouseID) as HouseIDs');

        $points = Db::name('ban')->alias('a')->join('area b','a.AreaThree = b.id','left')->field('BanID ,BanGpsX ,BanGpsY,a.AreaFour,a.AreaThree,b.GpsX,b.GpsY,b.AreaTitle')->where($where)->select();
 
        foreach($points as $key => $value){
            
            $data['point'][$value['AreaThree']]['name'] = $value['AreaTitle'];
            $data['point'][$value['AreaThree']]['GpsX'] = $value['GpsX'];
            $data['point'][$value['AreaThree']]['GpsY'] = $value['GpsY'];
            $data['point'][$value['AreaThree']]['detail'][] = $value;
            if(!isset($data['point'][$value['AreaThree']]['TotalHouse'])){
                $data['point'][$value['AreaThree']]['TotalHouse'] = 0;
            }
            if(isset($houses[$value['BanID']])){
            $data['point'][$value['AreaThree']]['TotalHouse'] += $houses[$value['BanID']];
            }
            
        }

        if ($data) {
            return jsons('2000', '获取成功', $data);
        } else {
            return jsons('2000', '获取失败');
        }


    }

    public function get_log_info()
    {
        $info = Db::name('admin_log')->where('id', 'eq', input('id'))->value('Description');
        return $info?jsons('2000','获取成功',json_decode($info,true)):jsons('2000','获取成功');
    }

    public function get_room_change_details()
    {
        $roomID = input('RoomID');
        $fields = 'RoomRentMonth,UnitID,FloorID,UseArea,LeasedArea,RentPoint';
        $newOneData = Db::name('room')->field($fields)->where('RoomID', 'eq', $roomID)->find();
        $oldOneData = Db::name('room_temp')->field($fields)->where('RoomID', 'eq', $roomID)->find();
        $i = 0;
        if (!$oldOneData) {
            foreach ($newOneData as $k1 => $v1) {
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $v1;
                $allData[$i]['name'] = config($k1);
                $allData[$i]['status'] = 0;
                $i++;
            }
        } else {
            foreach ($oldOneData as $k1 => $v1) {
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $newOneData[$k1];
                $allData[$i]['name'] = config($k1);
                if ($newOneData[$k1] != $v1) {
                    $allData[$i]['status'] = 1;
                } else {
                    $allData[$i]['status'] = 0;
                }
                $i++;
            }
        }
        return jsons('2000', '获取成功', $allData);
    }

    public function get_house_change_details()
    {
        $houseID = input('HouseID');
        $fields = 'BanID,HouseID,UnitID,FloorID,DoorID,HousePrerent,ReceiveRent,HouseArea,ComprisingArea,DiffRent,PlusRent,ProtocolRent,WallpaperArea,CeramicTileArea,BathtubNum,BasinNum,BelowFiveNum,MoreFiveNum,RemitRent,IfWater';
        $newOneData = Db::name('house')->field($fields)->where('HouseID', 'eq', $houseID)->find();
        $oldOneData = Db::name('house_temp')->field($fields)->where('HouseID', 'eq', $houseID)->find();

        $i = 0;
        if (!$oldOneData) {

            foreach ($newOneData as $k1 => $v1) {
                if ($k1 == 'IfWater') {
                    $v1 = $v1 ? '是' : '否';
                }
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $v1;
                $allData[$i]['name'] = config($k1);
                $allData[$i]['status'] = 0;
                $i++;
            }
        } else {
            foreach ($oldOneData as $k1 => $v1) {
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $newOneData[$k1];
                $allData[$i]['name'] = config($k1);
                if ($newOneData[$k1] != $v1) {
                    $allData[$i]['status'] = 1;
                } else {
                    $allData[$i]['status'] = 0;
                }
                $i++;
            }
        }
        return jsons('2000', '获取成功', $allData);
    }

    // //不需要调试模式，ob_end_clean() 不能去掉否则乱码
    // public function qrcode()
    // {
    //     ob_end_clean();

    //     Loader::import('phpqrcode.phpqrcode', EXTEND_PATH);

    //     $code = substr(md5(substr(uniqid(),-6)),6).substr(uniqid(),-6);

    //     $value = 'http://web.ph.com/erweima/'.$code;          //二维码内容
    //     $errorCorrectionLevel = 'H';    //容错级别 
    //     $matrixPointSize = 5;           //生成图片大小
    //     $filename = $_SERVER['DOCUMENT_ROOT'].'/uploads/qrcode/'.$code.'.png';

    //     $qrcode = new \QRcode;

    //     //$qrcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2); 
    //     $qrcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);

    //     return $filename;
    // }

    public function codeCert()
    {
        $route = $this->request->route();

        $upload = '/uploads/qrcode/'.$route['name'].'.png';

        $filename = $_SERVER['DOCUMENT_ROOT'].$upload;

        $find = Db::name('lease_change_order')->where('QrcodeUrl',$upload)->find();
        if(!$find){
            $find = Db::name('lease_change_order')->where('QrcodeUrl','like','%'.$route['name'].'%')->find();
        }

        $detail = json_decode($find['Deadline'],true);

        $date = $detail['applyYear'].'年'.$detail['applyMonth'].'月'.$detail['applyDay'].'日';

        if(is_file($filename)){
            $info = <<<EOF

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge,
    chrome=1" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="Description" content=""/>
    <meta name="keywords" content=""/>
    <title></title>
    <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <!-- <script src="/public/static/gf/js/jquery.min.js"></script> -->

    <style>
        body{width:100%;margin:0;padding:0;background:url('/public/static/gf/img/750_success.jpg') no-repeat;background-size:cover;}
        header{margin-top:80px;margin-bottom:20px;font-size:22px;text-align:center;}
        table{width:74%;margin:0 13%;font-size:14px;}
        table td{height:20px;font-size:14px;}
        tr>td+td{text-align:right;}
        table tr{height:30px;}
    </style>
</head>
<body>
    <header>防伪鉴定证书</header>
    <table cellspacing="0" cellpadding="0" >
        <tr>
            <td width="31%">租直NO</td>
            <td>{$find['Szno']}</td>
        </tr>
        <tr>
            <td>房屋编号</td>
            <td>{$find['HouseID']}</td>
        </tr>
        <tr>
            <td>房屋地址</td>
            <td>{$find['BanAddress']}</td>
        </tr>
        <tr>
            <td>结构类别</td>
            <td>{$detail['applyStruct']}</td>
        </tr>
        <tr>
            <td>房屋层</td>
            <td>{$find['FloorNum']}</td>
        </tr>
        <tr>
            <td>居住层</td>
            <td>{$find['FloorID']}</td>
        </tr>
        <tr>
            <td>承租人姓名</td>
            <td>{$find['TenantName']}</td>
        </tr>
        <tr>
            <td>承租人身份证</td>
            <td>{$detail['applyRentNumber']}</td>
        </tr>
        <tr>
            <td>租约签订日期</td>
            <td>{$date}</td>
        </tr>
        <tr style="height:100px;">
            <td colspan="2" style="position:relative;text-align:right;">
                武汉市住房保障和房屋管理局
                <img style="width:90px;position:absolute;top:20px;right:20%;" src="/public/static/gf/img/zhang08.png" />
            </td>
        </tr>
    </table>
</body>
</html>

EOF;
        }else{

$info = <<<EOF
            
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge,
    chrome=1" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="Description" content=""/>
    <meta name="keywords" content=""/>
    <title></title>
    <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <!-- <script src="/public/static/gf/js/jquery.min.js"></script> -->

    <style>
        body{width:100%;margin:0;padding:0;background:url('/public/static/gf/img/750_fail.jpg') no-repeat;background-size:cover;}
        header{margin-top:80px;margin-bottom:20px;font-size:22px;text-align:center;}
        table{width:74%;margin:0 13%;font-size:14px;}
        table td{height:20px;font-size:14px;}
        tr>td+td{text-align:right;}
        table tr{height:30px;}
    </style>
</head>
<body>
    <header>防伪鉴定证书</header>
    <table cellspacing="0" cellpadding="0" >
        <tr>
            <td style="height:230px;font-size:16px;text-align:center;">此租约鉴定无效</td>
        </tr>
        <tr style="height:100px;">
            <td colspan="2" style="position:relative;text-align:right;">
                武汉市住房保障和房屋管理局
                <img style="width:90px;position:absolute;top:20px;right:20%;" src="/public/static/gf/img/zhang08.png" />
            </td>
        </tr>
    </table>
</body>
</html>

EOF;
        }

        echo $info;
    }

    public function pdf()
    {

        $ownerType = input('OwnerType');
        $tubulationid = input('TubulationID');
        //$dateTime = input('DateTime'); //暂时未用到

        $where['OwnerType'] = 1; //默认市属

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['a.TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['a.InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }


        if ($tubulationid) {   //检索机构

            $level = Db::name('institution')->where('id', 'eq', $tubulationid)->value('Level');
            if ($level == 3) {
                $where['a.TubulationID'] = array('eq', $tubulationid);
            } elseif ($level == 2) {
                $where['a.InstitutionID'] = array('eq', $tubulationid);
            }
        }

        if ($ownerType) {  //检索楼栋产别
            $where['OwnerType'] = $ownerType;
        }
//        if ($dateTime) {  //检索年月
//            $where['DamageChangeDate'] = array('<',(int)str_replace('-','',$dateTime));
//        }

        $initialOwnerType = get_owner($where['OwnerType']);

        $where['a.Status'] = 1;
        $map = 'BanAddress ,BanUnitNum ,BanYear ,BanFloorNum ,b.DamageGrade ,TubulationID ,TotalArea ,PreRent ,Institution';

        $data = Db::name('ban')->alias('a')
            ->join('ban_damage_grade b', 'a.DamageGrade = b.id', 'left')
            ->join('institution c', 'a.TubulationID = c.id', 'left')
            ->field($map)
            ->where('a.DamageGrade', 'in', [4, 5])
            ->where($where)
            ->select();

        ob_clean();

        Loader::import('tcpdf.tcpdf', EXTEND_PATH);

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Mr.Lu');
        $pdf->SetTitle('危严放统计报表');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//        $pdf->setPrintHeader(false);  //去掉页头
//        $pdf->setPrintFooter(false);  //去掉页脚

        $pdf->SetHeaderData('', 100, '危严房统计(' . $initialOwnerType . ')', '', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(20, 20, 6);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $pdf->setFontSubsetting(true);
        $pdf->SetFont('stsongstdlight', '', 10, '', true);
        $pdf->setCellHeightRatio(3);

        $pdf->AddPage();

        ///$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $html = '';
        $html .= '<table class="first" cellpadding="0" cellspacing="0">
              <tr>
              <td width="140" align="center">房屋坐落</td>
              <td width="80" align="center">栋号</td>
              <td width="80" align="center">建成年份</td>
              <td width="80" align="center">层数</td>
              <td width="80" align="center">完损等级</td>
              <td width="80" align="center">机构类别</td>
              <td width="80" align="center">建筑面积</td>
              <td width="80" align="center">规定租金</td>
             </tr>';

        foreach ($data as $v) {
            $html .= '<tr><td width="140" align="center">';
            $html .= $v['BanAddress'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['BanUnitNum'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['BanYear'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['BanFloorNum'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['DamageGrade'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['Institution'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['TotalArea'];
            $html .= '</td><td width="80" align="center">';
            $html .= $v['PreRent'];
            $html .= '</td></tr>';
        }
        $html .= '</table>';

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output('危严房报表.pdf', 'I');

    }

    public function pdf_inout()
    {

        $ownerType = input('OwnerType');
        $tubulationid = input('TubulationID');
        //$dateTime = input('DateTime'); //暂时未用到

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['a.InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['a.InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }

        $where['OrderDate'] = date('Ym', time());  //默认查询当月的订单
        $where['a.OwnerType'] = 3;

        if ($tubulationid) {   //检索机构
            $level = Db::name('institution')->where('id', 'eq', $tubulationid)->value('Level');
            if ($level == 3) {
                $where['a.InstitutionID'] = array('eq', $tubulationid);
            } elseif ($level == 2) {
                $where['a.InstitutionPID'] = array('eq', $tubulationid);
            }
        }

        if ($ownerType) {  //检索楼栋产别
            $where['a.OwnerType'] = $ownerType;
        }

        $initialOwnerType = get_owner($where['a.OwnerType']);
//halt($where);
        $data = Db::name('rent_order')->alias('a')
            ->join('house b', 'a.HouseID = b.HouseID')
            ->join('institution c', 'a.InstitutionID = c.id', 'left')
            ->where($where)
            ->field('a.InstitutionID,a.TenantName,a.HousePrerent,b.HouseArea,b.BanAddress,a.HousePrerent,c.Institution')
            ->select();

        foreach ($data as $key => &$value) {

            $value['RepairCost'] = 0.2 * ($value['HousePrerent']);  //修理费是房租的20%
            $value['HandlerCost'] = 0.15 * ($value['HousePrerent']);  //管理费是房租的15%
            $value['Cost'] = 0.65 * ($value['HousePrerent']);  //金额是房租的65%
        }

        ob_clean();

        Loader::import('tcpdf.tcpdf', EXTEND_PATH);

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Mr.Lu');
        $pdf->SetTitle($initialOwnerType . '产收支明细表');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//        $pdf->setPrintHeader(false);  //去掉页头
//        $pdf->setPrintFooter(false);  //去掉页脚

        $pdf->SetHeaderData('', 100, $initialOwnerType . "产收支明细表", '', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(6, 20, 6);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $pdf->setFontSubsetting(true);
        $pdf->SetFont('stsongstdlight', '', 10, '', true);
        $pdf->setCellHeightRatio(3);

        $pdf->AddPage();

        ///$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $html = '';
        $html .= '<table class="first" cellpadding="0" border="1"  valign="middle" align="center" cellspacing="0">
              <tr>
                <th rowspan="2" colspan="1" width="30" class="am-text-middle">序号</th>
                <th rowspan="2" colspan="1" width="80" class="am-text-middle">管段</th>
                <th rowspan="2" colspan="1" class="am-text-middle">账号</th>
                <th rowspan="2" colspan="1" class="am-text-middle">业主姓名</th>
                <th rowspan="2" colspan="1" width="120" class="am-text-middle">房屋地址</th>
                <th rowspan="2" colspan="1" class="am-text-middle">建筑面积</th>
                <th rowspan="1" colspan="2" width="80" class="am-text-middle">收入</th>
                <th rowspan="1" colspan="3" class="am-text-middle">支出</th>
                <th rowspan="2" colspan="1" class="am-text-middle">金额</th>
                <th rowspan="2" colspan="1" class="am-text-middle">备注</th>
             </tr>
             <tr>
                <th rowspan="1" colspan="1" width="40" class="am-text-middle">房租</th>
                <th rowspan="1" colspan="1" width="40" class="am-text-middle">其中:企</th>
                <th rowspan="1" colspan="1" class="am-text-middle">房产税</th>
                <th rowspan="1" colspan="1" class="am-text-middle">修理费</th>
                <th rowspan="1" colspan="1" class="am-text-middle">管理费</th>
            </tr>';
        $i = 1;
        foreach ($data as $v) {
            $html .= '<tr><td>';
            $html .= $i;    //序号
            $html .= '</td><td>';
            $html .= $v['Institution']; //管段
            $html .= '</td><td>';
            $html .= '';    //账号
            $html .= '</td><td>';
            $html .= $v['TenantName'];  //业主姓名
            $html .= '</td><td>';
            $html .= $v['BanAddress'];  //房屋地址
            $html .= '</td><td>';
            $html .= $v['HouseArea'];   //建筑面积
            $html .= '</td><td>';
            $html .= $v['HousePrerent'];    //房租
            $html .= '</td><td>';
            $html .= '';    //其中：企
            $html .= '</td><td>';
            $html .= '';    //房产税
            $html .= '</td><td>';
            $html .= $v['RepairCost'];  //修理费
            $html .= '</td><td>';
            $html .= $v['HandlerCost']; //管理费
            $html .= '</td><td>';
            $html .= $v['Cost'];    //金额
            $html .= '</td><td>';
            $html .= '';    //备注
            $html .= '</td></tr>';
            $i++;
        }
        $html .= '</table>';

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output($initialOwnerType . '产收支明细表.pdf', 'I');

    }

    public function test()
    {
        // $arr = Db::name('house')->where(['Status'=>1,'RechargeRent'=>['>',0]])->column('HouseID,RechargeRent');

        // $rent = Db::name('rent_order')->where(['Type'=>3,'OrderDate'=>'201807'])->column('HouseID,PaidRent');
        // $i = 1;
        // foreach($arr as $k => $v){
        //     if(isset($rent[$k]) && ($v > $rent[$k])){
        //         $i++;
        //         Db::name('rent_order')->where(['HouseID'=>$k,'OrderDate'=>'201807'])->update(['IfPaidable'=>1]);
        //         Db::name('house')->where('HouseID',$k)->setDec('RechargeRent',$rent[$k]);
        //         //exit;
        //     }
        // }
        // $arr = Db::name('house')->where(['Status'=>1,'RechargeRent'=>['>',0]])->field('HouseID,TenantID,RechargeRent')->select();

        // $rent = Db::name('tenant')->column('TenantID,TenantBalance');
        // $i = 1;
        // foreach($arr as  $v){
        //         if(isset($rent[$v['TenantID']])){
        //             //halt(1);
        //             $i++;
        //          Db::name('tenant')->where(['TenantID'=>$v['TenantID']])->setInc('TenantBalance',$v['RechargeRent']);
        //         }
                
        //         //Db::name('house')->where('HouseID',$k)->setDec('RechargeRent',$rent[$k]);
        //         //exit;
            
        // }
        // halt($i);
        // exit;
        //halt($rent);
    }

    /**
     * [clearLog 清除系统日志，只保留最近一周的日志]
     * @return [type] [description]
     */
    public function clearLog()
    {
        // 删除指定时间的日志(默认1周)
        $timebf=config('timebf')?:604800;
        //halt($timebf);
        foreach (list_file(LOG_PATH) as $f) {
            if ($f ['isDir']) {
                foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                    if ($ff ['isFile']) {
                        //halt(date('Y-m-d H:i:s',$ff['mtime']));
                        if (time() - $ff ['mtime'] > $timebf) {
                            @unlink($ff ['pathname']);
                        }
                    }
                }
            }
        }
        echo 'ok';
    }

    public function count_houses()
    {   
        $housemodel = new HouseInfoModel;

        // $offset = 0;
        // $length = 10000;  
        $res = Db::name('house')->column('HouseID,ApprovedRent');
        //$res = Db::name('house')->where('ApprovedRent','=',0)->column('HouseID,ApprovedRent');
        //$res = Db::name('room')->column('RoomID,RoomRentMonth');
        $j = 0;
        //$res = ['10900918250336'=>0];
        foreach($res as $k => $v){  
             $j++;
             $s = count_house_rent($k);
             //dump($k.'计算租金是：');halt($s);
             $housemodel->save(['ApprovedRent'=>$s],['HouseID'=>$k]);
             //halt($k);
        }

        halt($j);

    }

    public function count_rooms()
    {
        $roommodel = new RoomModel;

        $res = Db::name('room')->column('RoomID,RoomRentMonth');
        $j = 0;
 
        foreach($res as $k => $v){  
             $j++;
             $s = count_room_rent($k);
             $roommodel->save(['RoomRentMonth'=>$s],['RoomID'=>$k]);
        }
        halt($j);
    }

    /**
     *  测试模式，一次帮整个公司全部配置一遍
     */
    public function config()
    {

        define('UID',10000);
        //重新生成租金配置时，先删除原配置
        Db::name('rent_config')->delete(true);

        $where['Status'] = array('eq', 1);    //房屋必须是可用状态
        $where['IfEmpty'] = array('eq', 0);    // 是否空租
        $where['IfSuspend'] = array('eq', 0);  // 是否暂停计租
        //$where['InstitutionID'] = array('eq', $institutionID);  // 2或者3，紫阳所，粮道所
        //$where['InstitutionID'] = array('not in', [34, 35]);  //34为紫阳所私有，35为粮道所私有，不需要计算租金
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        //$where['HousePrerent'] = array('>', 0); // 规租大于0
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $houseData = Db::name('house')->field($fields)->where($where)->select();
        
        $changeData = Db::name('change_order')->where(['Status'=>1,'ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->select();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        //halt($rentData);

        foreach($changeData as $c){
            $changedata[$c['HouseID']] = $c;
        }

        //halt($changedata);

        $str = '';

        //if ($ifPre == 1) { //使用规定租金

            foreach ($houseData as $v) {

                if ($v['AnathorHousePrerent'] > 0) {
                    $receiveRent = $v['AnathorHousePrerent'];  //应收租金，后期处理
                    $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
                    $str .= "," . $v['AnathorHousePrerent'] . ", 0, 0 '" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['AnathorOwnerType'] . "," . $v['UseNature'];
                    $str .= ",1," . $receiveRent . "," . $receiveRent . "," . UID . "," . time() . "),";
                }

                if(isset($changedata[$v['HouseID']])){
                    $cutType = $changedata[$v['HouseID']]['CutType'];
                    $cutRent = $changedata[$v['HouseID']]['InflRent'];
                }else{
                    $cutType = 0;
                    $cutRent = 0;
                }
                if(isset($rentData[$v['HouseID']])){
                    $historyUnpaidRent = $rentData[$v['HouseID']] + $v['ArrearRent'];
                }else{
                    $historyUnpaidRent = $v['ArrearRent'];
                }

                //$receiveRent = $v['HousePrerent'] + $v['DiffRent'];
                
                $receiveRent = $v['HousePrerent'] + $v['DiffRent'] + $v['PumpCost'] - $cutRent;

                $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
                $str .= "," . $v['HousePrerent'] . "," . $v['DiffRent'] . "," . $v['PumpCost'] . "," . $cutType . "," . $cutRent . ",'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'];
                $str .= ",1," . $receiveRent . "," . $receiveRent . "," . $historyUnpaidRent . "," . UID . "," . time() . "),";
            }
        // } else { //使用计算租金
        //     return jsons('4002' ,'暂时无法配置计算租金');

        // }

        //Db::query("insert into ph_rent_config (HouseID ,TenantID ,InstitutionID) values ('12','13',1),('23','14',2)");
        $res = Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str, ','));

        Db::name('rent_config')->where(['ReceiveRent'=>0])->delete();

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    public function lease_house_info()
    {
        $houseid = input('HouseID');

        $result = [];

        $result['house'] = Db::name('house')->alias('a')
                                      ->join('ban b','a.BanID = b.BanID','left')
                                      ->join('tenant c','a.TenantID = c.TenantID','left')
                                      ->join('ban_structure_type d','b.StructureType = d.id','left')
                                      ->field('a.UseNature,a.Szno,a.BanAddress,d.StructureType,b.BanFloorNum,a.FloorID,c.TenantName,c.TenantNumber,c.TenantTel,a.Hall,a.Kitchen,a.Toilet,a.InnerAisle,a.BelowFiveNum,a.MoreFiveNum,a.PumpCost')
                                      ->where('a.HouseID',$houseid)
                                      ->find();

        // $s = [
        //     '1' => '老证换新证',
        //     '2' => '遗失补发',
        //     '3' => '亲属转让',
        //     '4' => '正常过户',
        //     '5' => '新发租',
        //     '6' => '其他',
        // ];

        // if($recorde){
        //     foreach($recorde as &$r){
        //         $r['CreateTime'] = date('Y年m月d日',$r['CreateTime']);
        //         $r['Type'] = $s[$r['Type']];
        //     }
        // }

        $result['house']['Recorde'] = Db::name('lease_change_order')->where('HouseID',$houseid)->order('CreateTime desc')->value('Recorde');

        if(empty($result['house'])){
            return jsons('4000','参数错误');
        }

        $val = Db::name('config')->where('id',1)->value('Value');

        $result['house']['Szno'] = $result['house']['Szno'].$val;
        
        $result['house']['TotalUseArea'] = 0;
        $result['house']['TotalLeaseArea'] = 0;
        $result['house']['TotalRoomMonth'] = 0;
        $result['house']['HallRent'] = 0;
        $result['house']['ToiletRent'] = 0;
        $result['house']['AisleRent'] = 0;
        $result['house']['KitchenRent'] = 0;

        $result['house']['BelowFiveNumRent'] = 0.5 * $result['house']['BelowFiveNum'];
        $result['house']['MoreFiveNumRent'] = 1 * $result['house']['MoreFiveNum'];

        $rooms = Db::name('room')->field('RoomType,RoomName,RoomNumber,UseArea,LeasedArea,RoomRentMonth,RoomPublicStatus')
            ->where(['HouseID' => ['like', '%' . $houseid . '%'], 'Status'=>1])
            ->select();

        if(empty($rooms)){
            $rooms = array();
        }else{
            $i = 0;
            $j = 0;
            $k = 0;
            $result['house']['Hall'] = 0;
            $result['house']['Toilet'] = 0;
            $result['house']['InnerAisle'] = 0;
            $result['house']['Kitchen'] = 0;
            foreach($rooms as $v){
                switch ($v['RoomPublicStatus']) {
                    case 1:
                        $v['RoomPublicStatus'] = '独';
                        $i += $v['UseArea'];
                        $j += $v['LeasedArea'];
                        $k += $v['RoomRentMonth'];
                        $room[] = $v;
                        break;
                    case 2:
                        $v['RoomPublicStatus'] = '共';
                        $i += $v['UseArea'];
                        $j += $v['LeasedArea'];
                        $k += $v['RoomRentMonth'];
                        $room[] = $v;
                        break;
                    default:
                        if($v['RoomType'] == 5){ //三户共用厅堂
                            $result['house']['Hall'] += 1;
                        }elseif($v['RoomType'] == 2){ //三户共用卫生间
                            $result['house']['Toilet'] += 1;
                        }elseif($v['RoomType'] == 3){ //三户共用室内走道
                            $result['house']['InnerAisle'] += 1;
                        }elseif($v['RoomType'] == 6){ //三户共用厨房
                            $result['house']['Kitchen'] += 1;
                        }
                        break;
                }
             
            }

            $result['house']['HallRent'] = 0.5 * $result['house']['Hall'];
            $result['house']['ToiletRent'] = 0.5 * $result['house']['Toilet'];
            $result['house']['InnerAisleRent'] = 0.5 * $result['house']['InnerAisle'];
            $result['house']['KitchenRent'] = 0.5 * $result['house']['Kitchen'];

            $result['house']['TotalUseArea'] = $i;
            $result['house']['TotalLeaseArea'] = $j;
            $s = $result['house']['HallRent'] + $result['house']['ToiletRent'] + $result['house']['InnerAisleRent'] + $result['house']['KitchenRent'] + $k;
            $result['house']['TotalRoomMonth'] = $s;
            $result['house']['HeDingRoomMonth'] = ($result['house']['UseNature'] == 1)?round($s,1):$s;
        }

        $result['house']['PumpCost'] = ($result['house']['PumpCost'] != 0)?round(0.08 * $result['house']['TotalLeaseArea'],1):0;
        
        $result['room'] = isset($room)?$room:array();

        return jsons('2000', '获取成功', $result);
    }

    public function lease_use()
    {
        $houseid = input('HouseID');
        $row = Db::name('use_change_order')->where(['HouseID'=>$houseid,'Status'=>1])->order('CreateTime desc')->field('OldTenantName,NewTenantName')->find();
        $result['recorde'] = $row?$row['OldTenantName'].'转让给'.$row['NewTenantName']:'';
        return jsons('2000', '获取成功', $result);
    }
}