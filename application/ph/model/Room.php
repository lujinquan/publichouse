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

class Room extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = '__ROOM__';

    public function get_all_room_lst($status = array('eq', 0))
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);

        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询

            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);

        } else {    //用户为公司级别，则获取所有子管段

        }

        $where['Status'] = $status;

        $RoomList['option'] = array();

        $searchForm = input('request.');

        foreach ($searchForm as &$val) { //去收尾空格
            $val = trim($val);
        }

        if (isset($searchForm['RoomID'])) {

            $RoomList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id','eq',$searchForm['TubulationID'])->value('Level');

                if($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }elseif($level == 2){
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if (isset($searchForm['RoomType']) && $searchForm['RoomType']) {   //检索产别
                $where['RoomType'] = array('eq', $searchForm['RoomType']);
            }
            if (isset($searchForm['UnitID']) && $searchForm['UnitID']) {  //检索单元号
                $where['UnitID'] = array('eq', $searchForm['UnitID']);
            }
            if (isset($searchForm['FloorID']) && $searchForm['FloorID']) {  //检索楼层号
                $where['FloorID'] = array('eq', $searchForm['FloorID']);
            }


            if (isset($searchForm['BanID']) && $searchForm['BanID']) {  //模糊检索楼栋编号
                $where['BanID'] = array('like', '%' . $searchForm['BanID'] . '%');
            }
            if (isset($searchForm['BanAddress']) && $searchForm['BanAddress']) {  //模糊检索楼栋编号
                $where['BanAddress'] = array('like', '%' . $searchForm['BanAddress'] . '%');
            }
            if (isset($searchForm['RoomNumber']) && $searchForm['RoomNumber']) {  //模糊检索楼栋编号
                $where['RoomNumber'] = array('like', '%' . $searchForm['RoomNumber'] . '%');
            }

            if (isset($searchForm['RoomID']) && $searchForm['RoomID']) {  //模糊检索房间编号
                $where['RoomID'] = array('like', '%' . $searchForm['RoomID'] . '%');
            }

//            if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
//                $start = $searchForm['DateStart'];
//                $end = $searchForm['DateEnd'];
//                //dump($start);dump($end);exit;
//                if($start < $end){
//                    $where['BanYear'] = array('between',$start.",".$end);
//                }
//            }
//            if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
//                $start = $searchForm['DateStart'];
//                //dump($start);exit;
//                $where['BanYear'] = array('egt',$start);
//            }
//            if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
//                $end = $searchForm['DateEnd'];
//                $where['BanYear'] = array('elt',$end);
//            }
//
        }
        if (!isset($where)) {
            $where = 1;
        }

        $RoomList['obj'] = self::field('RoomID')->where($where)->order('CreateTime desc ,RoomID desc')->paginate(config('paginate.list_rows'));

        $arr = $RoomList['obj']->all();

        if (!$arr) {

            $RoomList['arr'] = array();

        } else {

            foreach ($arr as $v) {

                $RoomList['arr'][] = self::get_one_room_base_info($v['RoomID']);

            }

        }

        return $RoomList;
    }

    /**
     *  在房间信息主页中展示的部分
     *   目前有： 房间编号，楼栋编号 ，房间类型， 单元号 ，层次 ，使用面积 ，计租面积 ，规定月租金
     */
    public function get_one_room_base_info($roomID)
    {

        $map = 'OwnerType,RoomPrerent,c.Institution as InstitutionID,RoomID ,BanID ,BanAddress ,RoomTypeName ,RoomNumber,UnitID ,FloorID ,UseArea ,LeasedArea ,RoomRentMonth';

        $one = Db::name('room')->alias('a')
            ->join('room_type_point b', 'a.RoomType = b.id', 'left')
            ->join('institution c', 'a.InstitutionID = c.id', 'left')
            ->where('RoomID', 'eq', $roomID)
            ->field($map)
            ->find();

        return $one;

    }

    public function get_one_room_detail_info($roomID)
    {

        $one = Db::name('room')->where('RoomID', 'eq', $roomID)->find();

        $one['RoomType'] = Db::name('room_type_point')->where('id', 'eq', $one['RoomType'])->value('RoomTypeName');
        //halt($one['RentPoint']);
        $one['RentPoint'] = 100 * (1 - $one['RentPoint']) . '%';
        $one['InstitutionID'] = get_institution($one['InstitutionID']);
        if (!empty($one['RentPointIDS'])) {
            $arr = explode(',', $one['RentPointIDS']);
            $one['Items'] = Db::name('rent_cut_point')->where('id', 'in', $arr)->column('Item');
        }

        if($one['RoomPublicStatus'] == 1){
            $one['RoomClass'] = '私有';
        }elseif($one['RoomPublicStatus'] == 2){
            $one['RoomClass'] = '两户共用';
        }else{
            $one['RoomClass'] = '机构所有';
        }
        return $one;
    }

    public function add($data)   //添加
    {

        $datas['BanID'] = $data['BanID'];   //入库楼栋编号
        $datas['UseArea'] = $data['UseArea'];   //入库使用面积
        $datas['RentPointIDS'] = $data['RentPointIDS'];  //入库基价折减条件
        $datas['RoomID'] = $data['RoomID'];        //入库房屋编号
        $datas['RoomNumber'] = $data['RoomNumber']; //入库房间间号
        $datas['BanAddress'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('BanAddress');  //入库房间地址
        $datas['RoomType'] = $data['RoomType'];   //入库房间类型
        $datas['UnitID'] = $data['UnitID'];   //入库单元号
        $datas['FloorID'] = $data['FloorID'];   //入库楼层号
        $datas['RoomPrerent'] = $data['RoomPrerent'];   //房间规定租金
        $datas['OwnerType'] = $data['OwnerType'];   //产别
        $datas['UseNature'] = $data['UseNature'];   //使用性质
        $datas['CreateUserID'] = UID;   //入库操作人
        $datas['CreateTime'] = request()->time();   //入库添加时间
        $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID')->find();
        $datas['InstitutionID'] = $one['TubulationID'];   //入库机构id
        $datas['InstitutionPID'] = $one['InstitutionID'];   //入库机构父id

        //在对应的楼栋表中，自增楼栋使用面积
        //Db::name('ban')->where('BanID', 'eq', $datas['BanID'])->setInc('BanUsearea', $data['UseArea']);

        $houseids = array_values(array_unique(array_filter($data['HouseID'])));
        $datas['HouseID'] = trim(implode(',', $houseids), ',');    //绑定的房屋
        $houseidNum = count($houseids);
        $datas['RoomPublicStatus'] = $houseidNum;               //入库房间共用状态

        if ($houseidNum == 1) { //私有
            $roomAreaPoint = Db::name('room_type_point')->where('id', 'eq', $data['RoomType'])->value('Point');  //获取当前房间类型计租面积基数
            $datas['LeasedArea'] = $roomAreaPoint * $data['UseArea'];  //入库计租面积,注意 计租面积 = 使用面积 * 当前房间类型的计租面积基数
            Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('HouseUsearea', $data['UseArea']);
            Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('LeasedArea', $datas['LeasedArea']);

        } elseif ($houseidNum == 2) { //两户共用
            $roomAreaPoint = Db::name('room_type_point')->where('id', 'eq', $data['RoomType'])->value('Point');  //获取当前房间类型计租面积基数
            $datas['LeasedArea'] = $roomAreaPoint * $data['UseArea'];  //入库计租面积,注意 计租面积 = 使用面积 * 当前房间类型的计租面积基数
            Db::name('house')->where('HouseID', 'in', $houseids)->setInc('HouseUsearea', $data['UseArea'] / 2);
            Db::name('house')->where('HouseID', 'in', $houseids)->setInc('LeasedArea', $datas['LeasedArea'] / 2);

        } else { //三户及三户以上共用
            $datas['LeasedArea'] = 0;
        }

        if ($data['RentPointIDS']) {
            $arr = explode(',', $data['RentPointIDS']);
            $total = Db::name('rent_cut_point')->where('id', 'in', $arr)->sum('Point');
            //halt($total);
            $datas['RentPoint'] = 1 - $total;
        } else {
            $datas['RentPoint'] = 1;
        }

        //获取所在楼栋的结构基价
        $struData = Db::name('ban')->alias('a')
            ->join('ban_structure_type b', 'a.StructureType = b.id')
            ->where('a.BanID', 'eq', $data['BanID'])
            ->field('b.NewPoint,a.IfFirst,a.IfElevator,a.BanFloorNum')
            ->find();

        $emptyPoint = $struData['IfFirst']?0.98:1;

        $floorPoint = get_floor_point($data['FloorID'],$struData['BanFloorNum'],$struData['IfFirst']);

        if($houseidNum == 1){
            //计算该房间的租金：计租面积 * 实际基价 * 结构基价 * 基价折减率 * 架空率 * 层次调解率
            $datas['RoomRentMonth'] = $datas['LeasedArea'] * $roomAreaPoint * $datas['RentPoint'] * $struData['NewPoint'] * $emptyPoint * $floorPoint;  //入库房间计算租金
        }elseif($houseidNum == 2) {
            //计算该房间的租金：计租面积 * 实际基价 * 结构基价 * 基价折减率 * 架空率 * 层次调解率
            $datas['RoomRentMonth'] = $datas['LeasedArea'] * $roomAreaPoint * $datas['RentPoint'] * $struData['NewPoint'] * $emptyPoint * $floorPoint / 2;  //入库房间计算租金

        }else{
            $datas['RoomRentMonth'] = 0.5;
        }

        Db::name('house')->where('HouseID', 'in', $houseids)->setInc('ApprovedRent', $datas['RoomRentMonth']);

        return $datas;
    }

    public function edit($data)   //修改
    {

        $datas['BanID'] = $data['BanID'];   //入库楼栋编号
        $datas['UseArea'] = $data['UseArea'];   //入库使用面积
        $datas['RentPointIDS'] = $data['RentPointIDS'];  //入库基价折减条件
        $datas['RoomID'] = $data['RoomID'];        //入库房屋编号
        $datas['RoomNumber'] = $data['RoomNumber']; //入库房间间号
        $datas['BanAddress'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('BanAddress');  //入库房间地址

        $datas['RoomType'] = $data['RoomType'];   //入库房间类型
        $datas['UnitID'] = $data['UnitID'];   //入库单元号
        $datas['FloorID'] = $data['FloorID'];   //入库楼层号
        $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID')->find();
        $datas['InstitutionID'] = $one['TubulationID'];   //入库机构id
        $datas['InstitutionPID'] = $one['InstitutionID'];   //入库机构父id

        $houseids = array_values(array_unique(array_filter($data['HouseID'])));
        $datas['HouseID'] = trim(implode(',', $houseids), ',');    //绑定的房屋
        $houseidNum = count($houseids);
        $datas['RoomPublicStatus'] = $houseidNum;               //入库房间共用状态

        if ($houseidNum == 1) { //私有
            $roomAreaPoint = Db::name('room_type_point')->where('id', 'eq', $data['RoomType'])->value('Point');  //获取当前房间类型计租面积基数
            $datas['LeasedArea'] = $roomAreaPoint * $data['UseArea'];  //入库计租面积,注意 计租面积 = 使用面积 * 当前房间类型的计租面积基数

        } elseif ($houseidNum == 2) { //两户共用
            $roomAreaPoint = Db::name('room_type_point')->where('id', 'eq', $data['RoomType'])->value('Point');  //获取当前房间类型计租面积基数
            $datas['LeasedArea'] = $roomAreaPoint * $data['UseArea'];  //入库计租面积,注意 计租面积 = 使用面积 * 当前房间类型的计租面积基数

        } else { //三户及三户以上共用
            $datas['LeasedArea'] = 0;
        }

        if ($data['RentPointIDS']) {
            $arr = explode(',', $data['RentPointIDS']);
            $total = Db::name('rent_cut_point')->where('id', 'in', $arr)->sum('Point');
            //halt($total);
            $datas['RentPoint'] = 1 - $total;
        } else {
            $datas['RentPoint'] = 1;
        }
        //获取所在楼栋的结构基价
        $struData = Db::name('ban')->alias('a')
            ->join('ban_structure_type b', 'a.StructureType = b.id')
            ->where('a.BanID', 'eq', $data['BanID'])
            ->field('b.NewPoint,a.IfFirst,a.IfElevator,a.BanFloorNum')
            ->find();

        $emptyPoint = $struData['IfFirst']?0.98:1;

        $floorPoint = get_floor_point($data['FloorID'],$struData['BanFloorNum'],$struData['IfFirst']);

        if($houseidNum == 1){
            //计算该房间的租金：计租面积 * 实际基价 * 结构基价 * 基价折减率 * 架空率 * 层次调解率
            $datas['RoomRentMonth'] = $datas['LeasedArea'] * $roomAreaPoint * $datas['RentPoint'] * $struData['NewPoint'] * $emptyPoint * $floorPoint;  //入库房间计算租金
        }elseif($houseidNum == 2) {
            //计算该房间的租金：计租面积 * 实际基价 * 结构基价 * 基价折减率 * 架空率 * 层次调解率
            $datas['RoomRentMonth'] = $datas['LeasedArea'] * $roomAreaPoint * $datas['RentPoint'] * $struData['NewPoint'] * $emptyPoint * $floorPoint / 2;  //入库房间计算租金

        }else{
            $datas['RoomRentMonth'] = 0.5;
        }

        return $datas;
    }

    public function editRoom($data)   //修改
    {
//halt($data);
        $datas['BanID'] = $data['BanID'];   //入库楼栋编号
        $datas['UseArea'] = $data['UseArea'];   //入库使用面积
        //$datas['RentPointIDS'] = $data['RentPointIDS'];  //入库基价折减条件
        $datas['RoomID'] = $data['RoomID'];        //入库房屋编号
        $datas['RoomNumber'] = $data['RoomNumber']; //入库房间间号
        $datas['BanAddress'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('BanAddress');  //入库房间地址
        $roomAreaPoint = Db::name('room_type_point')->where('id', 'eq', $data['RoomType'])->value('Point');  //获取当前房间类型计租面积基数
        $datas['LeasedArea'] = $roomAreaPoint * $data['UseArea'];  //入库计租面积,注意 计租面积 = 使用面积 * 当前房间类型的计租面积基数
        $datas['RoomType'] = $data['RoomType'];   //入库房间类型
        $datas['UnitID'] = $data['UnitID'];   //入库单元号
        $datas['FloorID'] = $data['FloorID'];   //入库楼层号
        $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID')->find();
        $datas['InstitutionID'] = $one['TubulationID'];   //入库机构id
        $datas['InstitutionPID'] = $one['InstitutionID'];   //入库机构父id

        //先解绑之前的房屋，楼栋，并回滚面积
        $findOne = Db::name('room')->field('HouseID,BanID,UseArea,LeasedArea,RoomPublicStatus')->where('RoomID', $data['RoomID'])->find();
        //回滚楼栋使用面积
        Db::name('ban')->where('BanID', 'eq', $findOne['BanID'])->setDec('BanUsearea', $findOne['UseArea']);
        //回滚房屋使用面积,房间编号集
        if ($findOne['RoomPublicStatus'] == 1) {    //私有房屋


            Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('HouseUsearea', $findOne['UseArea']);
            Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('LeasedArea', $findOne['LeasedArea']);

        } elseif ($findOne['RoomPublicStatus'] == 2) {    //两户共用的房屋
            $findHouses = explode(',', $findOne['HouseID']);

            Db::name('house')->where('HouseID', 'in', $findHouses)->setDec('HouseUsearea', $findOne['UseArea'] / 2);
            Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('LeasedArea', $findOne['LeasedArea'] / 2);

        } else {

        }

        //  由于录入的房间所属的房屋并不在该房间实际所在楼栋中，所以表单提交的房屋和楼栋可以没有依存关系
        if (isset($data['HouseID'])) {  //  如果绑定了房屋

            if (!empty($data['HouseID'][1]) && empty($data['HouseID'][2])) {      //私有
                $datas['RoomPublicStatus'] = 1;               //入库房间共用状态
                $datas['HouseID'] = $data['HouseID'][1];      //入库房屋编号

                //在对应的房屋表中，自增房屋使用面积
                //添加，则直接将房间的使用面积、计租面积加到绑定的房屋中
                Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('HouseUsearea', $data['UseArea']);
                Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('LeasedArea', $datas['LeasedArea']);


            } else if (!empty($data['HouseID'][1]) && !empty($data['HouseID'][2])) {  //两户公共

                if ($data['HouseID'][1] == $data['HouseID'][2]) {
                    return jsons('4004', '两个房屋编号不能相同');
                }

                $datas['RoomPublicStatus'] = 2;
                $datas['HouseID'] = $data['HouseID'][1] . ',' . $data['HouseID'][2];

                //在对应的房屋表中，自增房屋使用面积
                Db::name('house')->where('HouseID', 'in', [$data['HouseID'][1], $data['HouseID'][2]])->setInc('HouseUsearea', $data['UseArea'] / 2);
                Db::name('house')->where('HouseID', 'in', [$data['HouseID'][1], $data['HouseID'][2]])->setInc('LeasedArea', $datas['LeasedArea'] / 2);

            }

        } else {  //三户及三户以上共用
            $datas['RoomPublicStatus'] = 3;
            $datas['HouseID'] = '';
        }

//halt($datas);
        if ($data['RentPointIDS']) {
            $arr = explode(',', $data['RentPointIDS']);  //
            $total = Db::name('rent_cut_point')->where('id', 'in', $arr)->sum('Point');
            $datas['RentPoint'] = $total * 100;
            $totalPoint = 1 - $total;  //实际基价率

        } else {
            $datas['RentPoint'] = 0;
            $totalPoint = 1;   //实际基价率

        }

        //获取所在楼栋的结构基价
        $struData = Db::name('ban')->alias('a')
            ->join('ban_structure_type b', 'a.StructureType = b.id')
            ->where('a.BanID', 'eq', $data['BanID'])
            ->field('b.NewPoint,a.IfFirst,a.IfElevator,a.BanFloorNum')
            ->find();

        //获取层次调节率
        $map['LiveFloor'] = array('eq', $data['FloorID']);
        $map['TotalFloor'] = array('eq', $struData['BanFloorNum']);
        $floorPoint = Db::name('floor_point')->where($map)->value('FloorPoint');

        if ($data['FloorID'] >= 9) $floorPoint = 0.85; //9楼以上层次调解率为0.85

        if ($data['FloorID'] == 1 && !$struData['IfFirst']) $floorPoint -= 0.02;

        //计算该房间的租金，注意此处的公式为： 结构基价 * 层次调解率 * 计租面积  * 实际基价率

        $datas['RoomRentMonth'] = $struData['NewPoint'] * $floorPoint * $datas['LeasedArea'] * $totalPoint;  //入库房间租金

        return $datas;
    }

    public function callback($RoomID)
    {
        //先解绑之前的房屋，楼栋，并回滚面积
        $findOne = Db::name('room')->field('HouseID,BanID,UseArea,LeasedArea,RoomPublicStatus')->where('RoomID', $RoomID)->find();
        //回滚楼栋使用面积
        Db::name('ban')->where('BanID', 'eq', $findOne['BanID'])->setDec('BanUsearea', $findOne['UseArea']);
        //回滚房屋使用面积,房间编号集
        if ($findOne['RoomPublicStatus'] == 1) {    //私有房屋

            Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('HouseUsearea', $findOne['UseArea']);
            Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('LeasedArea', $findOne['LeasedArea']);

        } elseif ($findOne['RoomPublicStatus'] == 2) {    //两户共用的房屋
            $findHouses = explode(',', $findOne['HouseID']);

            Db::name('house')->where('HouseID', 'in', $findHouses)->setDec('HouseUsearea', $findOne['UseArea'] / 2);
            Db::name('house')->where('HouseID', 'in', $findHouses)->setDec('LeasedArea', $findOne['LeasedArea'] / 2);

        } else {

        }
    }


}