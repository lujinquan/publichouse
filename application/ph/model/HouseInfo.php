<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Exception;
use think\Db;
use think\Loader;

class HouseInfo extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__HOUSE__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'CreateTime';
    //  关闭更新时间
    protected $updateTime = false;

    public function get_all_house_lst($status = array('eq', 0))
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');

        $where['Status'] = $status;

        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }


        $searchForm = input('request.');

        $HouseIdList['option'] = array();

        if (isset($searchForm['BanID'])) {

            foreach ($searchForm as &$val) { //去收尾空格
                $val = trim($val);
            }

            $HouseIdList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                //$where['InstitutionID'] = array('eq', $searchForm['InstitutionID']);
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {   //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
                //$wheres['AnathorOwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if (isset($searchForm['UseNature']) && $searchForm['UseNature']) {   //检索使用性质
                $where['UseNature'] = array('eq', $searchForm['UseNature']);
            }
            if ($searchForm['BanID']) {  //模糊检索楼栋编号

                $cwhere['Status'] = $status;
                $cwhere['BanID'] = $searchForm['BanID'];
                $houses = Db::name('room')->where($cwhere)->value('group_concat(HouseID) as houseids');
                $houseidArr = array_unique(explode(',',$houses));

                $houseidArr1 = Db::name('house')->where($cwhere)->column('HouseID');

                $houseArrs = array_unique(array_filter(array_merge($houseidArr,$houseidArr1)));
                array_multisort($houseArrs);
                $where['HouseID'] = $houseArrs?array('in',$houseArrs):'';

                //$where['BanID'] = array('like', '%' . $searchForm['BanID'] . '%');
            }
            if (isset($searchForm['BanAddress']) && $searchForm['BanAddress']) {  //模糊检索楼栋地址
                $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //模糊检索房屋编号
                $where['HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
            }
            if (isset($searchForm['HousePrerent']) && $searchForm['HousePrerent']) {  //检索房屋规定租金
                $where['HousePrerent'] = array('eq', $searchForm['HousePrerent']);
            }
            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%' . $searchForm['TenantName'] . '%');
            }
        }

        $BanID = input('param.BanID');
        if ($BanID) {  //接收查看房屋跳转，传递进来的BanID参数
            $map['Status'] = $status;
            $map['BanID'] = array('eq',$BanID);
            $houses = Db::name('room')->where($map)->value('group_concat(HouseID) as houseids');
            $houseidArr = array_unique(explode(',',$houses));

            $houseidArr1 = Db::name('house')->where($map)->column('HouseID');
            $houseArrs = array_unique(array_filter(array_merge($houseidArr,$houseidArr1)));
            //halt(count($houseArr));
            array_multisort($houseArrs);
            $where['HouseID'] = $houseArrs?array('in',$houseArrs):'';

            $HouseIdList['option']['BanID'] = $BanID;
        }

        //halt($where);
        if(!isset($wheres)){
            $wheres = 1;
        }

        $HouseIdList['obj'] = self::field('HouseID')->where($where)->order('CreateTime desc,HouseID desc')->paginate(config('paginate.list_rows'));
        $HouseIdList['HousePrerentSum'] = self::field('HouseID')->where($where)->sum('HousePrerent');
        $HouseIdList['HouseUseareaSum'] = self::field('HouseID')->where($where)->sum('HouseUsearea');
        $HouseIdList['LeasedAreaSum'] = self::field('HouseID')->where($where)->sum('LeasedArea');
        $HouseIdList['HouseAreaSum'] = self::field('HouseID')->where($where)->sum('HouseArea');
        $HouseIdList['ArrearRentSum'] = self::field('HouseID')->where($where)->sum('ArrearRent');

        //halt($HouseIdList['HousePrerentSum']);

        $arr = $HouseIdList['obj']->all();

        if (!$arr) {

            $HouseIdList['arr'] = array();
        }

        foreach ($arr as $v) {

            $HouseIdList['arr'][] = self::get_one_house_base_info($v['HouseID']);

        }

        return $HouseIdList;
    }

    public function get_one_house_base_info($houseid = '', $map = '')
    {

        //产别 ，使用性质，房屋编号 ，楼栋编号 ，楼栋地址，租户姓名，机构名称 ，门牌号码， 单元号，楼层号，使用面积 ，建筑面积，规定月租金 ，原价 ，泵费，基数租差
        if (!$map) $map = 'OwnerType ,UseNature,LeasedArea,HouseID ,BanID ,BanAddress ,ArrearRent ,TenantID ,InstitutionID ,DoorID ,IfSuspend,UnitID ,FloorID ,ComprisingArea ,HouseUsearea ,HouseArea ,HousePrerent ,Oprice ,PumpCost';
        $data = Db::name('house')->field($map)->where('HouseID', 'eq', $houseid)->find();
        if (!$data) {
            return array();
        }
        $data["OwnerType"] = get_owner($data["OwnerType"]);
        $data['IfSuspend'] = $data['IfSuspend']?'是':'否';
        $data["UseNature"] = get_usenature($data["UseNature"]);
        $data['id'] = $data["TenantID"];
        $data["TenantID"] = Db::name('tenant')->where('TenantID', 'eq', $data['TenantID'])->value('TenantName');
        //$data["TenantID"] = $data["TenantName"];
        $data["InstitutionID"] = Db::name('institution')->where('id', 'eq', $data['InstitutionID'])->value('Institution');

        return $data;

    }

    public function get_one_house_detail_info($houseid = '')
    {

        $map = '*';

        $data = self::get_one_house_base_info($houseid, $map);

        $one = Db::name('ban')->field('BanGpsX ,BanGpsY ,IfElevator ,IfFirst')->where('BanID', 'eq', $data['BanID'])->find();

        $data['BanGpsX'] = $one['BanGpsX'];
        $data['BanGpsY'] = $one['BanGpsY'];
        $data['IfElevator'] = $one['IfElevator'] ? '是':'否';
        $data['IfFirst'] = $one['IfFirst'] ? '是':'否';

        $data['HouseImageIDS'] = Db::name('upload_file')->where('id', 'eq', $data['HouseImageIDS'])->value('FileUrl');

        $data['UseNature'] = Db::name('use_nature')->where('id', 'eq', $data['UseNature'])->value('UseNature');   //使用性质

        $wheres['HouseID'] = array('like','%'.$houseid.'%');
        $wheres['Status'] = array('eq',1);

        $datass = Db::name('room')->alias('a')
            ->join('room_type_point b', 'a.RoomType = b.id', 'left')
            ->field('BanID,RoomID,UnitID,FloorID,RoomNumber,BanAddress,RoomTypeName,UseArea,LeasedArea,RoomPublicStatus')
            ->where($wheres)
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

            $data['RoomDetail'][$keys][0][] = $values['BanID'];
            $data['RoomDetail'][$keys][0][] = $values['UnitID'];
            $data['RoomDetail'][$keys][0][] = $values['FloorID'];
            $data['RoomDetail'][$keys][0][] = $values['RoomPublicStatus'];
            $data['RoomDetail'][$keys][0][] = $values['BanAddress'];
            $data['RoomDetail'][$keys][1][] = $values['RoomID'];
            $data['RoomDetail'][$keys][1][] = $values['RoomTypeName'];
            $data['RoomDetail'][$keys][1][] = $values['UseArea'];
            $data['RoomDetail'][$keys][1][] = $values['LeasedArea'];
            $data['RoomDetail'][$keys][1][] = $values['RoomNumber'];
        }
        //halt($data);
        if (!$data) {
            return array();
        }
        $data['IfWater'] = $data['IfWater'] ? '是':'否';
        $data['NonliveIf'] = $data['NonliveIf'] ? '是':'否';
        $data['change_record'] = self::get_house_change_record($houseid);
        return $data;
    }

    public function get_house_change_record($houseid)
    {
        $changeTypes = Db::name('change_type')->column('id,ChangeType');
        $institutions = Db::name('institution')->column('id,Institution');

        $where['Status'] = array('eq',1);
        $where['HouseID'] = array('eq',$houseid);

        $changeData = Db::name('change_order')->where($where)->field('ChangeOrderID,ChangeType,InstitutionID,FinishTime')->select();
        foreach ($changeData as $key => $value) {
            $data[$key][] = $value['ChangeOrderID'];
            $data[$key][] = date('Y年m月d日',$value['FinishTime']);
            $data[$key][] = $changeTypes[$value['ChangeType']];
            $data[$key][] = $institutions[$value['InstitutionID']];
        }
        return isset($data)?$data:array();
    }

    public function add($data = array())
    {

        //halt($data);

        $maxHouseID = Db::name('house')->where('HouseID', 'like', $data['BanID'] . '%')->max('HouseID');

        if (!$maxHouseID) {

            $data['HouseID'] = $data['BanID'] . '0001';
        } else {

            $data['HouseID'] = $maxHouseID + 1;
        }

        $struData = Db::name('ban')->where('BanID', 'eq', $data['BanID'])
            ->field('IfFirst ,BanFloorNum ,OwnerType')
            ->find();

        //获取层次调节率 ,电梯相关的暂时还没有具体计算在内
        $map['LiveFloor'] = array('eq', $data['FloorID']);
        $map['TotalFloor'] = array('eq', $struData['BanFloorNum']);

        $data['OwnerType'] = $struData['OwnerType'];

        $data['RegulationRate'] = Db::name('floor_point')->where($map)->value('FloorPoint');

        if ($data['FloorID'] >= 9 || $struData['BanFloorNum'] >= 9) $data['RegulationRate'] = 0.85; //9楼以上层次调解率为0.85

        if ($data['FloorID'] == 1 && !$struData['IfFirst']) $data['RegulationRate'] -= 0.02;

        if ($data['FloorID'] <= 3) $data['RegulationRate'] = 1;

        $data['PublicRent'] = ($data['Hall'] + $data['Toilet'] + $data['Kitchen'] + $data['InnerAisle']) * 0.5;

        //计算租金的时候
        $WallpaperPrice = $data['WallpaperArea'] * get_room_item_point(1);  //墙纸的加计租金
        $CeramicTilePrice = $data['CeramicTileArea'] * get_room_item_point(2);  //瓷砖的加计租金
        $BathtubPrice = $data['BathtubNum'] * get_room_item_point(3);     //浴盆的加计租金
        $BasinPrice = $data['BasinNum'] * get_room_item_point(4);  //面盆的加计租金
        $BelowFivePrice = $data['BelowFiveNum'] * get_room_item_point(5);   //5米以下的加计租金
        $MoreFivePrice = $data['MoreFiveNum'] * get_room_item_point(6); //5米以上的加计租金

        $data['PlusRent'] = $WallpaperPrice + $CeramicTilePrice + $BathtubPrice + $BasinPrice + $BelowFivePrice + $MoreFivePrice + $data['PublicRent'];

        $data['InstitutionPID'] = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->value('InstitutionID');

        $data['CreateUserID'] = UID;

        return $data;
    }

    public function uploads($file, $k1)
    {

        $title = config($k1); //上传文件标题

        Loader::import('uploads.Uploads', EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype', array('jpg', 'jpeg', 'gif', 'png')); //设置允许上传的类型
        $fileUpload->set('path', $_SERVER['DOCUMENT_ROOT'] . '/uploads/house/'); //设置保存的路径
        $fileUpload->set('maxsize', 1000000); //限制上传文件大小
        $fileUpload->set('israndname', true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload('HouseImageIDS');

        if ($res !== true) {

            return jsons('4003', $fileUpload->getErrorMsg());

        } else {  //上传成功

            $data['FileUrl'] = '/uploads/house/' . $fileUpload->getFileName();          //写入到数据库中的地址和存放地址 $targetPath 不一样
            $data['FileTitle'] = $title;
            $data['FileType'] = 1;        //图片类型
            $data['FileUse'] = 2;         //用途：房屋
            $data['UploadUserID'] = UID;
            $data['UploadTime'] = time();
            $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1
            if ($result == 1) {
                $fileID[] = Db::name('upload_file')->getLastInsID();
            }
        }

        return $fileIDS = implode(',', $fileID);
    }

    
    public function check_rent_table($data)
    {
        /*将一堆房间信息，切分组装成规定格式的房间信息*/

        $sort = Db::name('room_type_point')->column('Sort,id');

        foreach ($data['RoomType'] as $k1 => $v1) {
            $arr = array_chunk($v1, 15, false);
            foreach ($arr as $v2) {
                $v2[] = $sort[$k1+1];  //加1正好是房间类型的id
                $roomArr[] = $v2; //注意这个$roomArr是所有房间信息的集合，很重要
            }
        }
        //halt($roomArr);
        /*先校验房间信息填写是否完整必填的有（间号，绑定的楼栋，第一个绑定的房屋，单元号，层次，使用面积，基价折减率）*/
        foreach ($roomArr as $k3 => &$v3) {

            $v3[12] = empty($v3[12])?1:$v3[12];

            foreach ($v3 as $k4 => $v4) {
                //先效验房间的信息是否完整填写
                if (!in_array($k4, [0,4,5,6,7]) && $v4 === '') { //房间编号，绑定的第二个和第三个,四个，五个房屋可以为空
                    //halt($k4);
                    return jsons('4001', '请完善房间信息');
                }
            }

//            $banUnitFloorNum = Db::name('ban')->where('BanID',$v3[2])->field('BanUnitNum,BanFloorNum')->find();
//            if ($v3[8] > $banUnitFloorNum['BanUnitNum'] || !is_numeric($v3[8])) {
//                return jsons('4002','单元号'.$v3[8].'不合法或超出楼栋总单元数'.$banUnitFloorNum['BanUnitNum']);
//            }
//            if ($v3[9] > $banUnitFloorNum['BanFloorNum'] || !is_numeric($v3[9])) {
//                return jsons('4002','楼层号'.$v3[9].'不合法或超出楼栋总层数'.$banUnitFloorNum['BanFloorNum']);
//            }

            $houseArrs = array_filter(array($v3[3],$v3[4],$v3[5],$v3[6],$v3[7]));

//            if(count($houseArrs) != count(array_unique($houseArrs))){
//                return jsons('4002', '同一房间绑定的房屋不能相同');
//            }

            foreach ($houseArrs as $hv) {
                if(!in_array($hv ,array(666,888,999))){
                    $find = HouseInfo::get($hv);
                    if(!$find){ return jsons('4003','绑定的房屋编号'.$hv.'不存在');}
                } 
            }

        }
//halt($roomArr);
        return $roomArr;
    }


    public function out()
    {

        Loader::import('phpexcel.PHPExcel', EXTEND_PATH);
        Loader::import('excel2007.Excel2007', EXTEND_PATH . 'PHPExcel\PHPExcel\Writer/');


        $objPHPExcel = new \PHPExcel();

        $datas = self::get_all_house_lst();

        $data = $datas['arr'];

        //dump($data);exit;

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel); //保存excel—2007格式

        //设置文档基本属性
        $objProps = $objPHPExcel->getProperties();
        $objProps->setCreator("Mr Lu");
        $objProps->setLastModifiedBy("Zeal Li");
        $objProps->setTitle("Office XLS Test Document");
        $objProps->setSubject("Office XLS Test Document, Demo");
        $objProps->setDescription("Test document, generated by PHPExcel.");
        $objProps->setKeywords("office excel PHPExcel");
        $objProps->setCategory("race report");

        /*----------------创建sheet-----------------*/
        $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objPHPExcel->getActiveSheet();

        //设置当前活动sheet的名称
        $objActSheet->setTitle('公共房屋Sheet');

        //设置对齐方式
        //$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //单个单元设置对齐方式

        //设置填充色,暂时取消填充色
        // $objActSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  //单个单元设置填充色
        // $objActSheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF00CCFF');


        //设置宽度
        $objActSheet->getColumnDimension('A')->setWidth(16);
        $objActSheet->getColumnDimension('B')->setWidth(16);
        $objActSheet->getColumnDimension('C')->setWidth(20);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $objActSheet->getColumnDimension('E')->setWidth(22);
        $objActSheet->getColumnDimension('F')->setWidth(22);
        $objActSheet->getColumnDimension('G')->setWidth(16);
        $objActSheet->getColumnDimension('H')->setWidth(16);
        $objActSheet->getColumnDimension('I')->setWidth(16);
        $objActSheet->getColumnDimension('J')->setWidth(22);
        $objActSheet->getColumnDimension('K')->setWidth(16);
        $objActSheet->getColumnDimension('L')->setWidth(16);
        $objActSheet->getColumnDimension('M')->setWidth(16);

        //设置母标题栏,合并第一行，并文字居中，加粗显示
        $objActSheet->mergeCells('A1:M1');
        $objActSheet->setCellValue('A1', convertUTF8('房屋档案'));
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);  //设置

        //$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');      //合并,从A1到F1
        //$objPHPExcel->getActiveSheet()->unmergeCells('A1:F1');    // 拆分

        //设置子标题栏
        $objActSheet->setCellValue('A2', convertUTF8('房屋编号'));
        $objActSheet->setCellValue('B2', convertUTF8('楼栋编号'));
        $objActSheet->setCellValue('C2', convertUTF8('租户姓名'));
        $objActSheet->setCellValue('D2', convertUTF8('机构名称'));
        $objActSheet->setCellValue('E2', convertUTF8('门牌号码'));
        $objActSheet->setCellValue('F2', convertUTF8('单元号'));
        $objActSheet->setCellValue('G2', convertUTF8('楼层号'));
        $objActSheet->setCellValue('H2', convertUTF8('使用面积'));
        $objActSheet->setCellValue('I2', convertUTF8('建筑面积'));
        $objActSheet->setCellValue('J2', convertUTF8('规定月租金'));
        $objActSheet->setCellValue('K2', convertUTF8('原价'));
        $objActSheet->setCellValue('L2', convertUTF8('泵费'));
        $objActSheet->setCellValue('M2', convertUTF8('基数租差'));

        $objActSheet->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //批量居中
        $objActSheet->getStyle('B2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('C2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('D2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('E2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('F2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('G2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('H2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('I2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('J2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('K2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('L2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('M2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $count = count($data) + 2;  //下标为2的留给子标题栏
        for ($i = 3; $i <= $count; $i++) {
            $objActSheet->setCellValue('A' . $i, ' ' . convertUTF8($data[$i - 3]['HouseID']) . ' ');    //房屋编号
            $objActSheet->setCellValue('B' . $i, ' ' . convertUTF8($data[$i - 3]['BanID']) . ' ');  //楼栋编号
            $objActSheet->setCellValue('C' . $i, convertUTF8($data[$i - 3]['TenantID']));       //租户姓名
            $objActSheet->setCellValue('D' . $i, convertUTF8($data[$i - 3]['InstitutionID']) . ' ');         //机构名称
            $objActSheet->setCellValue('E' . $i, convertUTF8($data[$i - 3]['DoorID'])); //门牌号
            $objActSheet->setCellValue('F' . $i, convertUTF8($data[$i - 3]['UnitID']));    //单元号
            $objActSheet->setCellValue('G' . $i, convertUTF8($data[$i - 3]['FloorID']));    //楼层号
            $objActSheet->setCellValue('H' . $i, convertUTF8($data[$i - 3]['ComprisingArea']));          //使用面积
            $objActSheet->setCellValue('I' . $i, convertUTF8($data[$i - 3]['HouseArea']));          //建筑面积
            $objActSheet->setCellValue('J' . $i, convertUTF8($data[$i - 3]['HousePrerent']));    //规定月租金
            $objActSheet->setCellValue('K' . $i, convertUTF8($data[$i - 3]['Oprice']));    //原价
            $objActSheet->setCellValue('L' . $i, convertUTF8($data[$i - 3]['PumpCost']));          //泵费
           

            $objActSheet->getStyle('A' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //批量居中
            $objActSheet->getStyle('B' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('C' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('D' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('E' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('F' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('G' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('H' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('I' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('J' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('K' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('L' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
        }


        //生成excel表格，自定义名
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        /*------------这种是保存到浏览器下载位置（客户端）-------------------*/

        $filename = '公房_' . date('YmdHis', time()) . '.xls';    //定义文件名

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename=' . $filename);
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }
    
    
    
}