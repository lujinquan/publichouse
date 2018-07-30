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
        //halt($houseLst['arr']);
        $houseidss = isset($housearr) ? implode(',', $housearr) : '';
        $this->assign([
            'houseidss' => $houseidss,
            'rentPoint' => $rentPoint,
            'houseLst' => $houseLst['arr'],
            'houseLstObj' => $houseLst['obj'],
            'houseOption' => $houseLst['option'],
            'HousePrerentSum' => $houseLst['HousePrerentSum'],
            'HouseUseareaSum' => $houseLst['HouseUseareaSum'],
            'LeasedAreaSum' => $houseLst['LeasedAreaSum'],
            'HouseAreaSum' => $houseLst['HouseAreaSum'],
            'ArrearRentSum' => $houseLst['ArrearRentSum'],
        ]);
        return $this->fetch();
    }

    //【所有人都可以添加】，根据楼栋判断管段
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            $dataOne = Db::name('ban')->field('TubulationID,InstitutionID,BanAddress,AreaFour')->where('BanID', 'eq', $data['BanID'])->find();
            $data['InstitutionID'] = $dataOne['TubulationID'];
            $data['InstitutionPID'] = $dataOne['InstitutionID'];
            $data['BanAddress'] = $dataOne['AreaFour'];
            if (!$data['InstitutionID']) {
                return jsons('4000', '楼栋编号不存在');
            }
            $tenantName = Db::name('tenant')->where('TenantID', 'eq', $data['TenantID'])->value('TenantName');
            if ($data['TenantID']) {  //租户id可以先不填，如果填，则进行效验
                if (!$tenantName) {
                    return jsons('4001', '该租户不存在');
                } else {
                    $data['TenantName'] = $tenantName;
                }
            }else{
                $data['IfEmpty'] = 1;  //不填租户，就标示为空租状态
            }
            $maxHouseID = Db::name('house')->where('HouseID', 'like', $data['BanID'] . '%')->max('HouseID');
            if (!$maxHouseID) {
                $data['HouseID'] = $data['BanID'] . '001';
            } else {
                $data['HouseID'] = $maxHouseID + 1;
            }
            $result = $this->validate($data, 'HouseInfo');
            if (true !== $result) {
                return jsons('4001', $result);
            }
            $data['Status'] = 0;  //状态改为未确认状态
            if ($_FILES) {   //文件上传
                foreach ($_FILES as $k => $v) {
                    if ($v['error'] !== 0) {
                        continue;
                    }
                    $HouseImageIDS[] = model('HouseInfo')->uploads($v, $k);
                }
                if (isset($HouseImageIDS)) {
                    $data['HouseImageIDS'] = implode(',', $HouseImageIDS);   //返回的是该房屋的影像资料id
                }
            }
            $houseInfoModel = new HouseInfoModel();
            if ($houseInfoModel->allowField(true)->save($data)) {
                // 记录行为
                action_log('HouseInfo_add', UID, 2, '编号为:' . $data['HouseID']);
                return jsons('2000', '新增成功');
            } else {
                return jsons('4000', '新增失败');
            }
        }
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

    /**
     * 计租表修改
     */
    public function renttable()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //halt($data);
            //验证数据合法性
            /*如果有未确认状态的要删除的房间则，再次删除*/
            if (isset($data['AddRent']['deleteRoom'])) {
                foreach ($data['AddRent']['deleteRoom'] as $v) {
                    //先解绑之前的房屋，楼栋，并回滚面积
                    $finds = Db::name('room')->field('HouseID,BanID,UseArea,LeasedArea,RoomPublicStatus')->where('RoomID', $v)->find();
                    //回滚房屋使用面积,房间编号集
                    if ($finds['RoomPublicStatus'] == 1) {    //私有房屋
                        Db::name('house')->where('HouseID', 'eq', $finds['HouseID'])->setDec('HouseUsearea', $finds['UseArea']);
                        Db::name('house')->where('HouseID', 'eq', $finds['HouseID'])->setDec('LeasedArea', $finds['LeasedArea']);
                    } elseif ($finds['RoomPublicStatus'] == 2) {    //两户共用的房屋
                        $findHouse = explode(',', $finds['HouseID']);
                        Db::name('house')->where('HouseID', 'in', $findHouse)->setDec('HouseUsearea', $finds['UseArea'] / 2);
                        Db::name('house')->where('HouseID', 'in', $findHouse)->setDec('LeasedArea', $finds['LeasedArea'] / 2);
                    }
                }
                Db::name('room')->where('RoomID', 'in', $data['AddRent']['deleteRoom'])->delete();
            }

            if (isset($data['RoomType'])) {
                $roomArr = model('ph/HouseInfo')->check_rent_table($data);
                //halt($roomArr);
                foreach ($roomArr as $k5 => $v5) {
                    if (isset($data['PriceBox' . ($k5 + 1)])) { //写入基价折减的条件，id用逗号分隔
                        $rentPointIDS = $data['PriceBox' . ($k5 + 1)];
                    }
                    /*  $v5的示例
                    array(12){
                        [0] =&gt; string(6) "120942"       房间编号
                        [1] =&gt; string(2) "10"           间号
                        [2] =&gt; string(10) "1010022266"       绑定的楼栋编号
                        [3] =&gt; string(14) "10100222667294"   绑定的第一个房屋编号
                        [4] =&gt; string(0) ""              绑定的第二个房屋编号
                        [5] =&gt; string(0) ""              绑定的第三个房屋编号
                        [6] =&gt; string(0) ""              绑定的第四个房屋编号
                        [7] =&gt; string(0) ""              绑定的第五个房屋编号
                        [8] =&gt; string(1) "2"             产别
                        [9] =&gt; string(1) "2"             单元号
                        [10] =&gt; string(1) "2"            楼层号
                        [11] =&gt; string(5) "25.00"        使用面积
                        [12] =&gt; string(3) "75%"          基价折减率
                        [13] =&gt; string(1) "0"            状态值0为正常，1为点击垃圾桶
                        [14] =&gt; int(1)                   该房间的房间类型
                    }
                    */

                    //如果重新绑定了楼栋，则重新将，机构，楼栋地址，产别付给房间
                    $institutionArr = Db::name('ban')->field('InstitutionID,TubulationID,OwnerType,BanAddress')->where('BanID', $v5[2])->find();
                    $houses = array_filter(array($v5[3], $v5[4], $v5[5],$v5[6],$v5[7])); //将传入的房屋编号放入数组并去空
                    $diffHouses = array_merge(array_diff($houses, array($data['AddRent']['HouseID'])));
                    $one = Db::name('room_type_point')->where('id', $v5[14])->field('RoomTypeName,Point')->find();
                    $datas = [
                        'RoomID' => $v5[0],
                        'InstitutionID' => $institutionArr['TubulationID'],
                        'InstitutionPID' => $institutionArr['InstitutionID'],
                        'OwnerType' => $v5[8],
                        'BanAddress' => $institutionArr['BanAddress'],
                        'RoomNumber' => $v5[1],
                        'BanID' => $v5[2],
                        'HouseID' => implode(',', $houses),
                        'RoomPublicStatus' => count($houses),
                        'UnitID' => (int)$v5[9],
                        'FloorID' => (int)$v5[10],
                        'UseArea' => $v5[11],
                        'RentPoint' => $v5[12],
                        'RoomType' => $v5[14],
                        'LeasedArea' => $v5[11] * $one['Point'],
                        'RoomName' => $one['RoomTypeName'],
                        'RentPointIDS' => $rentPointIDS,
                    ];
                    if ($datas['RoomID']) {  //如果房间编号存在，则为修改
                        $datas['UpdateTime'] = time();
                        $findOnes = Db::name('room')->where('RoomID', $v5[0])->find();
                        /*比对数据，如果不同则标注为修改中状态 ，status为2*/
                        $roomCheckFieldArr = ['BanID', 'HouseID', 'UnitID','RoomNumber', 'OwnerType','FloorID', 'UseArea', 'RentPoint']; //修改房间的时候，需要效验的字段
                        $flag = 1;
                        //halt($v5);
                        //dump($datas);dump($findOnes);exit;
                        foreach ($roomCheckFieldArr as $v6) { //修改中状态
                            if($v6 == 'HouseID'){
                                //dump($houses);halt(explode(',',$findOnes['HouseID']));
                                $findHouses = explode(',',$findOnes['HouseID']);
                                if(array_diff($findHouses,$houses) || array_diff($houses,$findHouses)){
                                    $flag = 2;
                                }
                            }elseif($findOnes[$v6] != $datas[$v6]){
                                $datas['Status'] = 2;
                                $flag = 2;
                            }
                        }

                        //halt($flag);
                        if ($flag == 1 && $v5[13] == 0) {  //啥都没改，还是正常状态
                            //halt(1);
                            $datas['Status'] = 1;
                        }else{
                            //halt(2);
                            //halt($diffHouses);
                            if ($v5[13] == 1) { //删除中状态
                                $datas['Status'] = 4;
                                $flag = 3;
                            }
                            //修改，或者删除，要回滚面积
                            $findOne = Db::name('room')->field('HouseID,BanID,UseArea,LeasedArea,RoomPublicStatus')->where('RoomID', $v5[0])->find();
                            if ($findOne['RoomPublicStatus'] == 1) {    //私有房屋
                                Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('HouseUsearea', $findOne['UseArea']);
                                Db::name('house')->where('HouseID', 'eq', $findOne['HouseID'])->setDec('LeasedArea', $findOne['LeasedArea']);
                            } elseif ($findOne['RoomPublicStatus'] == 2) {    //两户共用的房屋
                                $findHouses = explode(',', $findOne['HouseID']);
                                Db::name('house')->where('HouseID', 'in', $findHouses)->setDec('HouseUsearea', $findOne['UseArea'] / 2);
                                Db::name('house')->where('HouseID', 'in', $findHouses)->setDec('LeasedArea', $findOne['LeasedArea'] / 2);
                            } elseif ($findOne['RoomPublicStatus'] > 2) {
                                Db::name('house')->where('HouseID', 'in', $houses)->setDec('PublicRent', 0.5);
                            }
                            //将新面积数据加上去，如果是删除，就不需要这一步
                            if ($flag == 2 && $datas['RoomPublicStatus'] == 1) {
                                //添加，则直接将房间的使用面积、计租面积加到绑定的房屋中
                                Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('HouseUsearea', $datas['UseArea']);
                                Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('LeasedArea', $datas['LeasedArea']);
                            } elseif ($flag == 2 && $datas['RoomPublicStatus'] == 2) {
                                $datas['LeasedArea'] = $datas['LeasedArea'] / 2;
                                Db::name('house')->where('HouseID', 'in', $houses)->setInc('HouseUsearea', $datas['UseArea'] / 2);
                                Db::name('house')->where('HouseID', 'in', $houses)->setInc('LeasedArea', $datas['LeasedArea'] / 2);
                            } elseif ($flag == 2 && $datas['RoomPublicStatus'] > 2) {
                                Db::name('house')->where('HouseID', 'in', $houses)->setInc('PublicRent', 0.5);
                                $datas['LeasedArea'] = 0;
                            }
                            if ($flag == 2) { //修改房间
                                $datas['Status'] = 0;
                                //halt($datas);
                                Db::name('room')->update($datas);
                                $tempRent = count_room_rent($datas['RoomID']);
                                
                                Db::name('room')->where('RoomID', $datas['RoomID'])->setField('RoomRentMonth', $tempRent);
                                //halt($a);
                            } elseif ($flag == 3) { //删除房间

                                Db::name('room')->where('RoomID', $v5[0])->delete();
                            }
                            if ($diffHouses) {
                                foreach ($diffHouses as $diff) {
                                    $houseTemps = count_house_rent($diff);
                                    Db::name('house')->where('HouseID',$diff)->setField('ApprovedRent',$houseTemps);
                                }
                            }
                        }
                    } else { //不存在，则为新增

                        //halt($datas['RoomType']);
                        $maxid = Db::name('room')->max('RoomID');
                        $datas['RoomID'] = $maxid + 1;
                        $datas['Status'] = 0;
                        $datas['RoomName'] = Db::name('room_type_point')->where('id',$datas['RoomType'])->value('RoomTypeName');
                        $datas['CreateUserID'] = session('user_base_info.uid');
                        $datas['CreateTime'] = time();
                        if ($datas['RoomPublicStatus'] == 1) {
                            Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('HouseUsearea', $datas['UseArea']);
                            Db::name('house')->where('HouseID', 'eq', $datas['HouseID'])->setInc('LeasedArea', $datas['LeasedArea']);
                        } elseif ($datas['RoomPublicStatus'] == 2) {
                            $datas['LeasedArea'] = $datas['LeasedArea'] / 2;
                            Db::name('house')->where('HouseID', 'in', $houses)->setInc('HouseUsearea', $datas['UseArea'] / 2);
                            Db::name('house')->where('HouseID', 'in', $houses)->setInc('LeasedArea', $datas['LeasedArea'] / 2);
                        } elseif ($datas['RoomPublicStatus'] > 2) {
                            $datas['LeasedArea'] = 0;
                            Db::name('house')->where('HouseID', 'in', $houses)->setInc('PublicRent', 0.5); //三户共用的加5毛钱
                        }
                        //halt($datas);
                        Db::name('room')->insert($datas);
                        $tempRent = count_room_rent($datas['RoomID']);
                        Db::name('room')->where('RoomID', $datas['RoomID'])->update(['RoomRentMonth' => $tempRent]);
                        foreach ($houses as $hous) {
                            $houseTemp = count_house_rent($hous);
                            Db::name('house')->where('HouseID',$hous)->setField('ApprovedRent',$houseTemp);
                        }
                    }
                }
            }
            //halt(1);
            /*正式开始处理房间信息集*/
            $houseArr = [
                'Status' => 1, //此阶段全部调整为1状态
                'HouseID' => $data['AddRent']['HouseID'],
                'WallpaperArea' => $data['AddRent']['RentWallpaper'],
                'CeramicTileArea' => $data['AddRent']['RentCeramic'],
                'BathtubNum' => $data['AddRent']['RentBath'],
                'BasinNum' => $data['AddRent']['RentBasin'],
                'BelowFiveNum' => $data['AddRent']['RentBelow'],
                'MoreFiveNum' => $data['AddRent']['RentMore'],
                'OwnerType' => $data['AddRent']['TypeF']['OwnerType'],
                'HousePrerent' => $data['AddRent']['TypeF']['RPrice'],
                'AnathorOwnerType' => $data['AddRent']['TypeS']['OwnerType'],
                'AnathorHousePrerent' => $data['AddRent']['TypeS']['RPrice'],
                'DiffRent' => $data['AddRent']['DiffRent'],
                'ProtocolRent' => $data['AddRent']['ProtocolRent'],
                'PumpCost' => $data['AddRent']['PumpPrice'],
                'IfWater' => $data['AddRent']['RIfWater'],
                //'ApprovedRent' => count_house_rent($data['AddRent']['HouseID']),
            ];
            if(!$houseArr['OwnerType'] && $houseArr['AnathorOwnerType']){
                $houseArr['OwnerType'] = $data['AddRent']['TypeS']['OwnerType'];
                $houseArr['HousePrerent'] = $data['AddRent']['TypeS']['RPrice'];
                $houseArr['AnathorOwnerType'] = $data['AddRent']['TypeF']['OwnerType'];
                $houseArr['AnathorHousePrerent'] = $data['AddRent']['TypeF']['RPrice'];
            }
            $itemPrices = Db::name('room_item_point')->column('id,UnitPrice');
            $houseArr['PlusRent'] = $houseArr['WallpaperArea'] * $itemPrices[1] + $houseArr['CeramicTileArea'] * $itemPrices[2] + $houseArr['BathtubNum'] * $itemPrices[3] + $houseArr['BasinNum'] * $itemPrices[4] + $houseArr['BelowFiveNum'] * $itemPrices[5] + $houseArr['MoreFiveNum'] * $itemPrices[6];

            //halt($houseArr);
            $res = Db::name('house')->update($houseArr);
            $temp = count_house_rent($data['AddRent']['HouseID']);
            Db::name('house')->where('HouseID', $data['AddRent']['HouseID'])->setField('ApprovedRent', $temp);
            //Db::name('system_tag')->where('TagType','RentSubmitTag')->setField('Tag',1);
            return ($res !== false) ? jsons('2000', '操作成功') : jsons('4000', '操作失败');
        }
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