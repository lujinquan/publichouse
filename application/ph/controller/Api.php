<?php

namespace app\ph\controller;

use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
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
            ->field('a.TenantID ,a.TenantName ,a.TenantTel')
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

        $data = Db::name('tenant')->where('TenantID', 'eq', $tenantID)->field('TenantID ,TenantName ,TenantTel,TenantBalance')->find();

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
        $map = 'a.TenantID ,a.TenantName ,a.ArrearRent ,a.RechargeRent ,a.FloorID ,a.BanID ,a.CreateTime ,a.InstitutionID ,a.HouseArea ,a.HouseUsearea,a.LeasedArea ,a.OwnerType ,a.AnathorOwnerType ,a.HousePrerent, a.AnathorHousePrerent ,b.DamageGrade ,b.UseNature ,b.StructureType ,b.BanAddress ,b.CoveredArea ,c.TenantTel';
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

        $map = 'BanAddress ,BanID ,DamageGrade ,StructureType ,UseNature ,OwnerType ,BanUnitNum ,BanFloorNum ,TotalArea ,BanUsearea ,CoveredArea ,TubulationID ,CreateTime';

        $data = Db::name('ban')->where('BanID', 'eq', $banID)->field($map)->find();

        $data['DamageGrade'] = get_damage($data['DamageGrade']);
        $data['UseNature'] = get_usenature($data['UseNature']);
        $data['OwnerType'] = get_owner($data['OwnerType']);
        $data['TubulationID'] = get_institution($data['TubulationID']);
        $data['StructureType'] = get_structure($data['StructureType']);
        $data['CreateTime'] = date('Y-m-d H:i:s', $data['CreateTime']);


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
        $rooms = Db::name('room')->field('RoomID,OwnerType,RoomNumber,RoomType,BanID,HouseID,UnitID,FloorID,UseArea,RentPoint,RentPointIDS,LeasedArea,RoomRentMonth,Status,RoomPublicStatus')
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
        $rooms = Db::name('room')->field('RoomID,OwnerType,RoomNumber,RoomType,BanID,HouseID,UnitID,FloorID,UseArea,RentPoint,RentPointIDS,LeasedArea,RoomRentMonth,Status')
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
            ->field('BanID ,HouseID ,UnitID ,FloorID ,TenantName,BanAddress')
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
            ->field('BanID ,DamageGrade ,StructureType ,OwnerType ,UseNature,BanAddress')
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
     * @title 房屋查询器接口
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
       

        $data = Db::name('house')->where($where)
            ->field('HouseID ,OwnerType,UseNature,TenantName,HousePrerent')
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

//    public function get_all_ban_info(){
//
//        if ($this->request->isPost()) {
//
//            $map = $this->request->post();
//        }
//
//        $currentUserInstitutionID = session('user_base_info.institution_id');
//
//        $currentUserLevel = session('user_base_info.institution_level');
//
//        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
//
//            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
//
//        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
//
//            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
//
//        }else{    //用户为公司级别，则获取所有子管段
//
//        }
//
//        $where['Status'] = array('eq' ,1);
//
//        if(isset($map['InstitutionID']) && $map['InstitutionID']){ //楼栋机构查询
//
//            $level = Db::name('institution')->where('id','eq',$map['InstitutionID'])->value('Level');
//            //dump($level);exit;
//            if($level == 3) {
//                $where['InstitutionID'] = array('eq', $map['InstitutionID']);
//            }elseif($level == 2){
//                $where['InstitutionPID'] = array('eq', $map['InstitutionID']);
//            }
//        }
//
//        if(isset($map['BanAddress']) && $map['BanAddress']){  //模糊检索楼栋地址
//
//            $where['BanAddress'] = array('like', '%'.$map['BanAddress'].'%');
//
//        }
//
//        if(isset($map['TenantName']) && $map['TenantName']){  //模糊检索租户姓名
//
//            $where['TenantName'] = array('like', '%'.$map['TenantName'].'%');
//
//        }
//
//        if(!isset($where)) $where =1;
//
//        $data = Db::name('ban')
//            //->join('ban b' ,'a.BanID = b.BanID','left')
//            ->where($where)
//            ->field('BanID ,BanAddress')
//            //->select();
//            ->paginate(config('paginate.list_rows'))
//            ->toArray();
//
//        $data['totalPage'] = ceil($data['total']/$data['per_page']);
//
//        return jsons('2000' ,'获取成功' ,$data);
//
//    }


    public function edit_password()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $id = session('user_base_info.uid');
            $one = Db::name('admin_user')->where('Number', $id)->field('Password,Salt')->find();
            if ($one['Password'] != md5(md5($data['oldPassword'] . $one['Salt']))) {
                return jsons('4002', '原密码输入错误……');
            }
            if (!preg_match("/^[A-Za-z0-9]+$/", $data['newPassword'])) {
                return jsons('4002', '新密码不合法');
            }
            if ($data['newPassword'] !== $data['repeatPassword']) {
                return jsons('4002', '密码输入不一致');
            }
            //exit;
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

        $points = Db::name('ban')->alias('a')->join('area b','a.AreaThree = b.id','left')->field('BanID ,BanGpsX ,BanGpsY,a.AreaFour,a.AreaThree,b.GpsX,b.GpsY,b.AreaTitle')->where($where)->select();
//halt($data['point']);
        foreach($points as $key => $value){
            $data['point'][$value['AreaThree']]['name'] = $value['AreaTitle'];
            $data['point'][$value['AreaThree']]['GpsX'] = $value['GpsX'];
            $data['point'][$value['AreaThree']]['GpsY'] = $value['GpsY'];
            $data['point'][$value['AreaThree']]['detail'][] = $value;
        }

        //halt($data['point']);

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
                $allData[$i]['name'] = Config::get($k1);
                $allData[$i]['status'] = 0;
                $i++;
            }
        } else {
            foreach ($oldOneData as $k1 => $v1) {
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $newOneData[$k1];
                $allData[$i]['name'] = Config::get($k1);
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
                $allData[$i]['name'] = Config::get($k1);
                $allData[$i]['status'] = 0;
                $i++;
            }
        } else {
            foreach ($oldOneData as $k1 => $v1) {
                $allData[$i]['old'] = $v1;
                $allData[$i]['new'] = $newOneData[$k1];
                $allData[$i]['name'] = Config::get($k1);
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

        //halt($data);

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

        //halt($data);

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
        $res = Db::name('house')->limit(100)->column('HouseID,HousePrerent');
//halt($res);
        $arr = [];

        foreach($res as $k => $v){
            //count_house_rent($k);
             $arr[] = [
                        'HouseID' => $k,
                        'CountRent' => count_house_rent($k),
                        'HousePrerent' => $v, 
                    ];
        }

        Db::name('house_diff')->insertAll($arr);
        
        //halt($res);

        // $res1 = Db::name('ban')->column('BanID,PreRent');

        // $arr = [];
        // foreach($res1 as $k => $v){
        //     if(isset($res[$k])){
        //         if($v != $res[$k]){
        //             $arr[] = [
        //                 'BanID' => $k,
        //                 'FromBan' => $v,
        //                 'FromHouse' => $res[$k],
        //                 'Diff' => $res[$k] - $v,
        //             ];
                    
        //         }
        //     }
            
        // }
        
        //halt($arr);



        //$arr = Db::query("select max(BanID) from ld_zanting where BanID !='' group by BanID");
        // $arr = Db::table('ld_zanting')->where('BanID > 0')->group('BanID')->column('max(id)');

        // $re = Db::table('ld_zanting')->where('id','not in',$arr)->delete();
       
        // halt($re);

        //将房间使用面积统计到楼栋中去，
//        $res = Db::name('room')->field('sum(UseArea) as UseAreas,BanID')->group('BanID')->select();
//        foreach($res as $v){
//            Db::name('ban')->where('BanID',$v['BanID'])->update(['BanUsearea'=>$v['UseAreas']]);
//        }

//        //将同时绑定两个房屋的房间的面积计算到房屋中去
//        $arr = Db::name('room')->field('UseArea,LeasedArea,HouseID')->where('RoomPublicStatus = 2')->select();
//        $k = 0;
//        foreach($arr as $v){
//            $houseids = explode(',',$v['HouseID']);
//            $data[$k]['HouseID'] = $houseids[0];
//            $data[$k]['UseArea'] = $v['UseArea']/2;
//            $data[$k]['LeasedArea'] = $v['LeasedArea']/2;
//            $k++;
//            $data[$k]['HouseID'] = $houseids[1];
//            $data[$k]['UseArea'] = $v['UseArea']/2;
//            $data[$k]['LeasedArea'] = $v['LeasedArea']/2;
//            $k++;
//        }
//        foreach ($data as $value) {
//            Db::name('house')->where('HouseID',$value['HouseID'])->setInc('HouseUsearea',$value['UseArea']);
//            Db::name('house')->where('HouseID',$value['HouseID'])->setInc('LeasedArea',$value['LeasedArea']);
//        }

/*       //将楼栋地址同步到房屋表中去
        $res = Db::execute("update ph_house as a inner join ph_ban as b on a.BanID = b.BanID set a.BanAddress = b.AreaFour");
        halt('本次操作有'.$res.'条记录受影响');*/


/*        //将租户的姓名同步到房屋表中去
        $res = Db::execute("update ph_house as a inner join ph_tenant as b on a.TenantID = b.TenantID set a.TenantName = b.TenantName");
        halt('本次操作有'.$res.'条记录受影响');*/

//        //以管段分查询出同一地址下姓名重复的名字
//        $data = [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
//        $insti = Db::name('institution')->column('id,Institution');
//        foreach($data as $dav){
//            $a = Db::name('house')->where(['InstitutionID'=>$dav,'Status'=>1])->column('HouseID,concat(BanAddress,TenantID) as BanTenant');
//            $b = Db::name('house')->where(['InstitutionID'=>$dav,'Status'=>1])->column('HouseID,TenantName');
//            foreach($a as $k1 => $v1){ //$sql = Db::name('house')->getLastSql();
//                foreach($a as $k2 => $v2){
//                    if($v1 === $v2 && $k1 != $k2){
//                        $arr[$insti[$dav]][] = $b[$k1];
//                    }
//                }
//            }
//            if(isset($arr[$insti[$dav]])){
//                $arr[$insti[$dav]] = array_unique($arr[$insti[$dav]]);
//            }
//        }
//        halt($arr);

//        //以管段分查询出同楼栋下间号重复的房间编号
//        $data = [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
//        $insti = Db::name('institution')->column('id,Institution');
//        foreach($data as $dav){
//            $a = Db::name('room')->where(['InstitutionID'=>$dav,'Status'=>1])->column('RoomID,concat(BanID,RoomNumber) as BanRoom');
//            foreach($a as $k1 => $v1){
//                foreach($a as $k2 => $v2){
//                    if($v1 === $v2 && $k1 != $k2){
//                        $arr[$insti[$dav]][] = $k1;
//                    }
//                }
//            }
//            if(isset($arr[$insti[$dav]])){
//                $arr[$insti[$dav]] = array_unique($arr[$insti[$dav]]);
//            }
//        }
//        halt($arr);

        // //以管段分查询出同楼栋下间号重复的房间编号
        // $data = [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
        // $insti = Db::name('institution')->column('id,Institution');
        // foreach($data as $dav){
        //     $a = Db::name('ban')->where(['TubulationID'=>$dav,'Status'=>1,'OldBanID'=>''])->column('BanID');
        //     $arr[$insti[$dav]][] = $a;
        // }
        // halt($arr);


        halt('ok');

    }

    public function dingshiqi()
    {

        ignore_user_abort(TRUE);    //关掉浏览器，PHP脚本也可以继续执行.
        set_time_limit(0);        // 通过set_time_limit(0)可以让程序无限制的执行下去
        $i = 1;
        $cacheTime = 3600 * 24 * 360;
        do {                         //当循环结束时脚本也就结束了
            $nowDate = date('d', time());
            $nowMonth = date('Ym', time());
            $nowMonth = '201801';
            $nowYear = date('Y', time());

            if ($nowYear === '2018') {  //每个月的1号，开始执行生成报表程序
                Debug::remark('begin');

//                //1、【测试ok】产权统计报表，按年缓存，3.467774s
//                $PropertyReportdata = model('ph/PropertyReport')->index();
//                Cache::store('file')->set('PropertyReport' . $nowYear, json_encode($PropertyReportdata), $cacheTime);

//                //2、【测试ok】房屋统计报表，230.078125s
//                $HouseReportdata = model('ph/HouseReport')->index();
//                Cache::store('file')->set('HouseReport' . $nowMonth, json_encode($HouseReportdata), $cacheTime);

                // //3、【测试ok】月租金报表，35.386719s
                // $RentReportdata = model('ph/RentReport')->index();
                // Cache::store('file')->set('RentReport' . $nowMonth, json_encode($RentReportdata), $cacheTime);

//                //4、【测试ok】租金分析报表，10.304688s
//                $RentAnalysisReportdata = model('ph/RentAnalysisReport')->index();
//                Cache::store('file')->set('RentAnalysisReport' . $nowMonth, json_encode($RentAnalysisReportdata), $cacheTime);
//
//                //5、【测试ok】代托管收支明细报表，1.724609s
//                $InOutdata = model('ph/InOutReport')->index();
//                Cache::store('file')->set('InOutReport' . $nowMonth, json_encode($InOutdata), $cacheTime);
//
//                //6、【测试ok】核减租金汇总表，10.236328s
//                $RentCutReportdata = model('ph/RentCutReport')->index();
//                Cache::store('file')->set('RentCutReport' . $nowMonth, json_encode($RentCutReportdata), $cacheTime);
//
//                //7、【测试ok】缓存危严房基本情况，消耗0.063476s
//                $DangerousReportdata = model('ph/DangerousReport')->index();
//                Cache::store('file')->set('DangerousReport' . $nowMonth, json_encode($DangerousReportdata), $cacheTime);


                Debug::remark('end');
                echo Debug::getRangeTime('begin', 'end') . 's';

                exit;

            }

            sleep(60 * 60 * 24);// 等待1天，相当于每隔1天再次循环一次


        } while ($i == 1);

    }
}