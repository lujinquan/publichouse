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
use think\Cache;

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
            if (isset($searchForm['IfSuspend']) && $searchForm['IfSuspend']) {  //检索暂停计租
                $where['IfSuspend'] = array('eq', $searchForm['IfSuspend']);
            }
            if (isset($searchForm['IfEmpty']) && $searchForm['IfEmpty']) {  //检索空租
                $where['IfEmpty'] = array('eq', $searchForm['IfEmpty']);
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

        if(!isset($wheres)){
            $wheres = 1;
        }

        $HouseIdList['obj'] = self::field('HouseID')->where($where)->order('CreateTime desc,HouseID desc')->paginate(config('paginate.list_rows'));
        $HouseIdList['HousePrerentSum'] = self::field('HouseID')->where($where)->sum('HousePrerent');
        $ApprovedRentSum = self::field('HouseID')->where($where)->where(['UseNature'=>['eq',1],'IfSuspend'=>['eq',0]])->sum('ApprovedRent');
        $HousePrerent = self::field('HouseID')->where($where)->where(['UseNature'=>['eq',1],'IfSuspend'=>['eq',0]])->sum('HousePrerent');
        $HouseIdList['ApprovedRentSum'] = bcsub($ApprovedRentSum,$HousePrerent,2);
        //$HouseIdList['HouseUseareaSum'] = self::field('HouseID')->where($where)->sum('HouseUsearea');
        $HouseIdList['LeasedAreaSum'] = self::field('HouseID')->where($where)->sum('LeasedArea');
        $HouseIdList['HouseAreaSum'] = self::field('HouseID')->where($where)->sum('HouseArea');
        //$HouseIdList['ArrearRentSum'] = self::field('HouseID')->where($where)->sum('ArrearRent');

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
        if (!$map) $map = 'OwnerType ,UseNature,LeasedArea,HouseID ,BanID ,BanAddress ,DiffRent,ArrearRent ,TenantID ,InstitutionID ,DoorID ,IfSuspend,IfEmpty,UnitID ,FloorID ,ComprisingArea ,HouseUsearea ,HouseArea ,HousePrerent ,Oprice ,PumpCost,ApprovedRent';
        $data = Db::name('house')->field($map)->where('HouseID', 'eq', $houseid)->find();
        if (!$data) {
            return array();
        }
        $data['ApprovedRent'] = count_house_rent($houseid);
        //$data['ApprovedRent'] = $data['ApprovedRent'];
        $data["OwnerType"] = get_owner($data["OwnerType"]);
        $data['IfSuspend'] = $data['IfSuspend']?'是':'否';
        $data['IfEmpty'] = $data['IfEmpty']?'是':'否';
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
                if($v3[15] != 12){
                    //先效验房间的信息是否完整填写
                    if (!in_array($k4, [0,4,5,6,7]) && ($v4 === '')) { //房间编号，绑定的第二个和第三个,四个，五个房屋可以为空
                        //halt($k4);
                        return jsons('4001', '请完善房间信息');
                    }
                }else{
                    if (in_array($k4, [1,13]) && ($v4 === '')) { //房间编号，绑定的第二个和第三个,四个，五个房屋可以为空
                        //halt($k4);
                        return jsons('4001', '请完善营业房间信息');
                    }
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


    public function ban_out()
    {
        ob_end_clean();

        Loader::import('phpexcel.PHPExcel', EXTEND_PATH);
        Loader::import('excel2007.Excel2007', EXTEND_PATH . 'PHPExcel\PHPExcel\Writer/');


        $objPHPExcel = new \PHPExcel();

        $where['Status'] = array('eq',1);
        $where['BanID'] = array('in',array('1050053257','1050043286','1050053298','1050033530','1050013569','1050053573','1050053574','1050053581','1050053585','1050053588','1050053591','1050043333','1050023602','1050023604','1050023606','1050023607','1050023608','1050073611','1050073626','1050073630','1050073639','1050073640'));

        $data = Db::name('ban')->field('TubulationID,BanID,AreaFour,OwnerType,BanPropertyID,BanYear,DamageGrade,StructureType,PropertySource,UseNature,BanArea,BanUsearea,EnterpriseNum,EnterpriseArea,EnterpriseOprice,EnterpriseRent,PartyNum,PartyArea,PartyOprice,PartyRent,CivilNum,CivilArea,CivilOprice,CivilRent,PreRent,TotalOprice,BanFloorNum')->where($where)->select();

        $insts = Db::name('institution')->column('id,Institution');

        foreach($data as &$d){
            $d['TubulationID'] = $insts[$d['TubulationID']];
            switch($d['OwnerType']){
                case 1:
                    $d['OwnerType'] = '0101'; //市属
                break;
                case 2:
                    $d['OwnerType'] = '0102'; //区属
                break;
                case 3:
                    $d['OwnerType'] = '0105'; //代管
                break;
                case 5:
                    $d['OwnerType'] = '0106'; //自管
                break;
                case 7:
                    $d['OwnerType'] = '0104'; //托管
                break;
                default:
                break;
            }
            switch($d['StructureType']){
                case 1:
                    $d['StructureType'] = '0307'; //钢混
                break;
                case 2:
                    $d['StructureType'] = '0303'; //砖木三等
                break;
                case 3:
                    $d['StructureType'] = '0302'; //砖木二等
                break;
                case 4:
                    $d['StructureType'] = '0304'; //砖混一等
                break;
                case 5:
                    $d['StructureType'] = '0305'; //砖混二等
                break;
                case 6:
                    $d['StructureType'] = '0301'; //砖木一等
                break;
                case 7:
                    $d['StructureType'] = '0308'; //简易
                break;
                default:
                break;
            }
            switch($d['DamageGrade']){
                case 1:
                    $d['DamageGrade'] = '0201'; //完好
                break;
                case 2:
                    $d['DamageGrade'] = '0202'; //基本
                break;
                case 3:
                    $d['DamageGrade'] = '0203'; //一般
                break;
                case 4:
                    $d['DamageGrade'] = '0204'; //严重
                break;
                case 5:
                    $d['DamageGrade'] = '0205'; //危险
                break;
                default:
                break;
            }
            switch($d['UseNature']){
                case 1:
                    $d['UseNature'] = '0401'; //住宅
                break;
                case 2:
                    $d['UseNature'] = '0402'; //企事业
                break;
                case 3:
                    $d['UseNature'] = '0403'; //机关
                break;
                default:
                break;
            }
        }

        //halt($data);

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
        $objActSheet->setTitle('楼栋明细');

        //设置对齐方式
        //$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //单个单元设置对齐方式

        //设置填充色,暂时取消填充色
        // $objActSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  //单个单元设置填充色
        // $objActSheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF00CCFF');


        //设置宽度
        $objActSheet->getColumnDimension('A')->setWidth(16);
        $objActSheet->getColumnDimension('B')->setWidth(16);
        $objActSheet->getColumnDimension('C')->setWidth(16);
        $objActSheet->getColumnDimension('D')->setWidth(30);
        $objActSheet->getColumnDimension('E')->setWidth(16);
        $objActSheet->getColumnDimension('F')->setWidth(16);
        $objActSheet->getColumnDimension('G')->setWidth(16);
        $objActSheet->getColumnDimension('H')->setWidth(16);
        $objActSheet->getColumnDimension('I')->setWidth(30);
        $objActSheet->getColumnDimension('J')->setWidth(16);
        $objActSheet->getColumnDimension('K')->setWidth(16);
        $objActSheet->getColumnDimension('L')->setWidth(16);
        $objActSheet->getColumnDimension('M')->setWidth(16);
        $objActSheet->getColumnDimension('N')->setWidth(16);
        $objActSheet->getColumnDimension('O')->setWidth(16);
        $objActSheet->getColumnDimension('P')->setWidth(16);
        $objActSheet->getColumnDimension('Q')->setWidth(16);
        $objActSheet->getColumnDimension('R')->setWidth(16);
        $objActSheet->getColumnDimension('S')->setWidth(16);
        $objActSheet->getColumnDimension('T')->setWidth(16);
        $objActSheet->getColumnDimension('U')->setWidth(16);
        $objActSheet->getColumnDimension('V')->setWidth(16);
        $objActSheet->getColumnDimension('W')->setWidth(16);
        $objActSheet->getColumnDimension('X')->setWidth(16);
        $objActSheet->getColumnDimension('Y')->setWidth(16);
        $objActSheet->getColumnDimension('Z')->setWidth(16);
        $objActSheet->getColumnDimension('AA')->setWidth(16);
        $objActSheet->getColumnDimension('AB')->setWidth(16);
        $objActSheet->getColumnDimension('AC')->setWidth(16);

        //设置母标题栏,合并第一行，并文字居中，加粗显示
        $objActSheet->mergeCells('A1:AC1');
        $objActSheet->setCellValue('A1', convertUTF8('楼栋数据'));
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);  //设置

        //$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');      //合并,从A1到F1
        //$objPHPExcel->getActiveSheet()->unmergeCells('A1:F1');    // 拆分

        //设置子标题栏
        $objActSheet->setCellValue('A2', convertUTF8('所属机构管段'));
        $objActSheet->setCellValue('B2', convertUTF8('楼栋编号'));
        $objActSheet->setCellValue('C2', convertUTF8('产别'));
        $objActSheet->setCellValue('D2', convertUTF8('楼栋地址'));
        $objActSheet->setCellValue('E2', convertUTF8('产权证号'));
        $objActSheet->setCellValue('F2', convertUTF8('建成年份'));
        $objActSheet->setCellValue('G2', convertUTF8('完损等级'));
        $objActSheet->setCellValue('H2', convertUTF8('结构类别'));
        $objActSheet->setCellValue('I2', convertUTF8('产权来源'));
        $objActSheet->setCellValue('J2', convertUTF8('使用性质'));
        $objActSheet->setCellValue('K2', convertUTF8('建筑面积'));
        $objActSheet->setCellValue('L2', convertUTF8('使用面积'));
        $objActSheet->setCellValue('M2', convertUTF8('权利人'));
        $objActSheet->setCellValue('N2', convertUTF8('权利人证件号码'));
        $objActSheet->setCellValue('O2', convertUTF8('企业栋'));
        $objActSheet->setCellValue('P2', convertUTF8('企业面积'));
        $objActSheet->setCellValue('Q2', convertUTF8('企业规租'));
        $objActSheet->setCellValue('R2', convertUTF8('企业原价'));
        $objActSheet->setCellValue('S2', convertUTF8('机关栋'));
        $objActSheet->setCellValue('T2', convertUTF8('机关面积'));
        $objActSheet->setCellValue('U2', convertUTF8('机关规租'));
        $objActSheet->setCellValue('V2', convertUTF8('机关原价'));
        $objActSheet->setCellValue('W2', convertUTF8('民用栋'));
        $objActSheet->setCellValue('X2', convertUTF8('民用面积'));
        $objActSheet->setCellValue('Y2', convertUTF8('民用规租'));
        $objActSheet->setCellValue('Z2', convertUTF8('民用原价'));
        $objActSheet->setCellValue('AA2', convertUTF8('规定租金'));
        $objActSheet->setCellValue('AB2', convertUTF8('原价'));
        $objActSheet->setCellValue('AC2', convertUTF8('总层数'));
        

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
        $objActSheet->getStyle('N2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('O2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('P2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Q2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('R2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('S2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('T2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('U2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('V2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('W2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('X2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Y2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Z2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('AA2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('AB2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('AC2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $count = count($data) + 2;  //下标为2的留给子标题栏
        for ($i = 3; $i <= $count; $i++) {
            $objActSheet->setCellValue('A' . $i, convertUTF8($data[$i - 3]['TubulationID']));    //所属机构管段
            $objActSheet->setCellValue('B' . $i, ' ' . convertUTF8($data[$i - 3]['BanID']) . ' ');  //楼栋编号
            $objActSheet->setCellValue('C' . $i, ' ' . convertUTF8($data[$i - 3]['OwnerType']) . ' ');       //产别
            $objActSheet->setCellValue('D' . $i, convertUTF8($data[$i - 3]['AreaFour']));         //楼栋地址
            $objActSheet->setCellValue('E' . $i, ' ' . convertUTF8($data[$i - 3]['BanPropertyID']) . ' '); //产权证号
            $objActSheet->setCellValue('F' . $i, convertUTF8($data[$i - 3]['BanYear']));    //建成年份
            $objActSheet->setCellValue('G' . $i, ' ' . convertUTF8($data[$i - 3]['DamageGrade']) . ' ');    //完损等级
            $objActSheet->setCellValue('H' . $i, ' ' . convertUTF8($data[$i - 3]['StructureType']) . ' ');          //结构类别
            $objActSheet->setCellValue('I' . $i, convertUTF8($data[$i - 3]['PropertySource']));          //产权来源
            $objActSheet->setCellValue('J' . $i, ' ' . convertUTF8($data[$i - 3]['UseNature']) . ' ');    //使用性质
            $objActSheet->setCellValue('K' . $i, convertUTF8($data[$i - 3]['BanArea']));    //建筑面积
            $objActSheet->setCellValue('L' . $i, convertUTF8($data[$i - 3]['BanUsearea']));          //使用面积
            $objActSheet->setCellValue('M' . $i, '');          //权利人
            $objActSheet->setCellValue('N' . $i, '');          //权利人证件号码
            $objActSheet->setCellValue('O' . $i, convertUTF8($data[$i - 3]['EnterpriseNum']));          //企栋数
            $objActSheet->setCellValue('P' . $i, convertUTF8($data[$i - 3]['EnterpriseArea']));          //企建面
            $objActSheet->setCellValue('Q' . $i, convertUTF8($data[$i - 3]['EnterpriseOprice']));          //企原价
            $objActSheet->setCellValue('R' . $i, convertUTF8($data[$i - 3]['EnterpriseRent']));          //企规租
            $objActSheet->setCellValue('S' . $i, convertUTF8($data[$i - 3]['PartyNum']));          //机栋数
            $objActSheet->setCellValue('T' . $i, convertUTF8($data[$i - 3]['PartyArea']));          //机建面
            $objActSheet->setCellValue('U' . $i, convertUTF8($data[$i - 3]['PartyOprice']));          //机原价
            $objActSheet->setCellValue('V' . $i, convertUTF8($data[$i - 3]['PartyRent']));          //机规租
            $objActSheet->setCellValue('W' . $i, convertUTF8($data[$i - 3]['CivilNum']));          //民栋数
            $objActSheet->setCellValue('X' . $i, convertUTF8($data[$i - 3]['CivilArea']));          //民建面
            $objActSheet->setCellValue('Y' . $i, convertUTF8($data[$i - 3]['CivilOprice']));          //民原价
            $objActSheet->setCellValue('Z' . $i, convertUTF8($data[$i - 3]['CivilRent']));          //民规租
            $objActSheet->setCellValue('AA' . $i, convertUTF8($data[$i - 3]['PreRent']));          //合计规租
            $objActSheet->setCellValue('AB' . $i, convertUTF8($data[$i - 3]['TotalOprice']));          //合计原价
            $objActSheet->setCellValue('AC' . $i, convertUTF8($data[$i - 3]['BanFloorNum']));          //总层数

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
            $objActSheet->getStyle('M' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('N' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('O' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('P' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Q' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('R' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('S' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('T' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('U' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('V' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('W' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('X' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Y' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Z' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('AA' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('AB' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('AC' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }


        //生成excel表格，自定义名
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        /*------------这种是保存到浏览器下载位置（客户端）-------------------*/

        $filename = '楼栋_' . date('YmdHis', time()) . '.xlsx';    //定义文件名

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


    public function house_out()
    {
        ob_end_clean();

        Loader::import('phpexcel.PHPExcel', EXTEND_PATH);
        Loader::import('excel2007.Excel2007', EXTEND_PATH . 'PHPExcel\PHPExcel\Writer/');


        $objPHPExcel = new \PHPExcel();

        $where['BanID'] = array('in',array('1050053299','1050043299','1050053295','1050033539','1050013568','1050053599','1050053598','1050053687','1050053685','1050053684','1050053691','1050043339','1050023692','1050023694','1050023690','1050023697','1050023688','1050073681','1050073666','1050073659','1050074651','1050073688'));

        $data = Db::name('house')->field('InstitutionID,HouseID,BanID,DoorID,HouseUsearea,UnitID,FloorID,HousePrerent,TenantName,PumpCost,DiffRent')->where($where)->select();

        $rData = Db::name('room')->field('RoomID,LeasedArea,RoomType,HouseID')->where('Status',1)->select();
        $a = [];
        foreach($rData as $r){
            $houseid = explode(',',$r['HouseID']);
            foreach($houseid as $h){
                
                $a[$h][$r['RoomType']][] = $r['LeasedArea'];
            }
        }

        $c = Db::name('change_order')->alias('a')->join('rent_cut_order b','a.HouseID = b.HouseID','left')->where(['a.ChangeType'=>1,'a.Status'=>1,'a.DateEnd'=>['>',201808]])->column('a.HouseID,a.CutType,a.InflRent,b.IDnumber');

        //halt($c);

        // foreach($a as $b){
        //     $s[$b['HouseID']][$b['RoomType']][] = $b['LeasedArea'];
        // }
        $insts = Db::name('institution')->column('id,Institution');

        foreach($data as &$d){
            if($d['TenantName']){
                $d['n'] = 1;
            }else{
                $d['n'] = 0;
            }
            if(isset($c[$d['HouseID']])){
               $d['CutType'] = $c[$d['HouseID']]['CutType'];
               $d['InflRent'] = $c[$d['HouseID']]['InflRent'];
               $d['IDnumber'] = $c[$d['HouseID']]['IDnumber'];
            }else{
               $d['CutType'] = '';
               $d['InflRent'] = '';
               $d['IDnumber'] = ''; 
            }
            $d['wosi'] = isset($a[$d['HouseID']][1])?array_sum($a[$d['HouseID']][1]):0; //卧室面积
            $d['wei'] = isset($a[$d['HouseID']][2])?array_sum($a[$d['HouseID']][2]):0; //卫生间面积
            $d['dow'] = isset($a[$d['HouseID']][3])?array_sum($a[$d['HouseID']][3]):0; //室内走道
            $d['tin'] = isset($a[$d['HouseID']][5])?array_sum($a[$d['HouseID']][5]):0; //厅堂
            $d['zu'] = isset($a[$d['HouseID']][6])?array_sum($a[$d['HouseID']][6]):0;  //厨房
            $d['InstitutionID'] = $insts[$d['InstitutionID']];
        }

        //halt($data);

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
        $objActSheet->setTitle('房屋明细');

        //设置对齐方式
        //$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //单个单元设置对齐方式

        //设置填充色,暂时取消填充色
        // $objActSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  //单个单元设置填充色
        // $objActSheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF00CCFF');


        //设置宽度
        $objActSheet->getColumnDimension('A')->setWidth(16);
        $objActSheet->getColumnDimension('B')->setWidth(16);
        $objActSheet->getColumnDimension('C')->setWidth(16);
        $objActSheet->getColumnDimension('D')->setWidth(16);
        $objActSheet->getColumnDimension('E')->setWidth(16);
        $objActSheet->getColumnDimension('F')->setWidth(16);
        $objActSheet->getColumnDimension('G')->setWidth(16);
        $objActSheet->getColumnDimension('H')->setWidth(16);
        $objActSheet->getColumnDimension('I')->setWidth(16);
        $objActSheet->getColumnDimension('J')->setWidth(16);
        $objActSheet->getColumnDimension('K')->setWidth(16);
        $objActSheet->getColumnDimension('L')->setWidth(16);
        $objActSheet->getColumnDimension('M')->setWidth(16);
        $objActSheet->getColumnDimension('N')->setWidth(16);
        $objActSheet->getColumnDimension('O')->setWidth(16);
        $objActSheet->getColumnDimension('P')->setWidth(16);
        $objActSheet->getColumnDimension('Q')->setWidth(16);
        $objActSheet->getColumnDimension('R')->setWidth(16);
        $objActSheet->getColumnDimension('S')->setWidth(16);
        $objActSheet->getColumnDimension('T')->setWidth(16);
        $objActSheet->getColumnDimension('U')->setWidth(16);
        $objActSheet->getColumnDimension('V')->setWidth(16);
        $objActSheet->getColumnDimension('W')->setWidth(16);
        $objActSheet->getColumnDimension('X')->setWidth(16);
        $objActSheet->getColumnDimension('Y')->setWidth(16);
        $objActSheet->getColumnDimension('Z')->setWidth(16);

        //设置母标题栏,合并第一行，并文字居中，加粗显示
        $objActSheet->mergeCells('A1:Z1');
        $objActSheet->setCellValue('A1', convertUTF8('房屋数据'));
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);  //设置

        //$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');      //合并,从A1到F1
        //$objPHPExcel->getActiveSheet()->unmergeCells('A1:F1');    // 拆分

        //设置子标题栏
        $objActSheet->setCellValue('A2', convertUTF8('所属机构管段'));
        $objActSheet->setCellValue('B2', convertUTF8('房屋编号'));
        $objActSheet->setCellValue('C2', convertUTF8('楼栋编号'));
        $objActSheet->setCellValue('D2', convertUTF8('门牌号码'));
        $objActSheet->setCellValue('E2', convertUTF8('使用面积'));
        $objActSheet->setCellValue('F2', convertUTF8('卧室面积'));
        $objActSheet->setCellValue('G2', convertUTF8('单元号'));
        $objActSheet->setCellValue('H2', convertUTF8('居住层'));
        $objActSheet->setCellValue('I2', convertUTF8('厅堂面积'));
        $objActSheet->setCellValue('J2', convertUTF8('厨房面积'));
        $objActSheet->setCellValue('K2', convertUTF8('卫生间面积'));
        $objActSheet->setCellValue('L2', convertUTF8('规定租金'));
        $objActSheet->setCellValue('M2', convertUTF8('原价'));
        $objActSheet->setCellValue('N2', convertUTF8('室内走道面积'));
        $objActSheet->setCellValue('O2', convertUTF8('租户姓名'));
        $objActSheet->setCellValue('P2', convertUTF8('泵费'));
        $objActSheet->setCellValue('Q2', convertUTF8('房屋基数'));
        $objActSheet->setCellValue('R2', convertUTF8('企业规租'));
        $objActSheet->setCellValue('S2', convertUTF8('机关规租'));
        $objActSheet->setCellValue('T2', convertUTF8('民用规租'));
        $objActSheet->setCellValue('U2', convertUTF8('建筑面积'));
        $objActSheet->setCellValue('V2', convertUTF8('户数'));
        $objActSheet->setCellValue('W2', convertUTF8('减免金额'));
        $objActSheet->setCellValue('X2', convertUTF8('低保证号'));
        $objActSheet->setCellValue('Y2', convertUTF8('减免类型'));
        $objActSheet->setCellValue('Z2', convertUTF8('基数租差'));
        

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
        $objActSheet->getStyle('N2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('O2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('P2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Q2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('R2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('S2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('T2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('U2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('V2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('W2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('X2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Y2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objActSheet->getStyle('Z2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $count = count($data) + 2;  //下标为2的留给子标题栏
        for ($i = 3; $i <= $count; $i++) {
            $objActSheet->setCellValue('A' . $i, convertUTF8($data[$i - 3]['InstitutionID']));    //所属机构管段
            $objActSheet->setCellValue('B' . $i, ' ' . convertUTF8($data[$i - 3]['HouseID']) . ' ');  //房屋编号
            $objActSheet->setCellValue('C' . $i, convertUTF8($data[$i - 3]['BanID']));       //楼栋编号
            $objActSheet->setCellValue('D' . $i, convertUTF8($data[$i - 3]['DoorID']));         //门牌号码
            $objActSheet->setCellValue('E' . $i, convertUTF8($data[$i - 3]['HouseUsearea'])); //使用面积
            $objActSheet->setCellValue('F' . $i, convertUTF8($data[$i - 3]['wosi']));    //卧室面积
            $objActSheet->setCellValue('G' . $i, convertUTF8($data[$i - 3]['UnitID']));    //单元号
            $objActSheet->setCellValue('H' . $i, convertUTF8($data[$i - 3]['FloorID']));          //居住层
            $objActSheet->setCellValue('I' . $i, convertUTF8($data[$i - 3]['tin']));          //厅堂面积
            $objActSheet->setCellValue('J' . $i, convertUTF8($data[$i - 3]['zu']));    //厨房面积
            $objActSheet->setCellValue('K' . $i, convertUTF8($data[$i - 3]['wei']));    //卫生间面积
            $objActSheet->setCellValue('L' . $i, convertUTF8($data[$i - 3]['HousePrerent']));          //规定租金
            $objActSheet->setCellValue('M' . $i, '');          //原价,
            $objActSheet->setCellValue('N' . $i, convertUTF8($data[$i - 3]['dow']));          //室内走道面积
            $objActSheet->setCellValue('O' . $i, convertUTF8($data[$i - 3]['TenantName']));          //租户姓名
            $objActSheet->setCellValue('P' . $i, convertUTF8($data[$i - 3]['PumpCost']));          //泵费
            $objActSheet->setCellValue('Q' . $i, '');          //房屋基数
            $objActSheet->setCellValue('R' . $i, '');          //企规租
            $objActSheet->setCellValue('S' . $i, '');          //机关规租
            $objActSheet->setCellValue('T' . $i, '');          //民用规租
            $objActSheet->setCellValue('U' . $i, '');          //建筑面积
            $objActSheet->setCellValue('V' . $i, convertUTF8($data[$i - 3]['n']));          //户数
            $objActSheet->setCellValue('W' . $i, convertUTF8($data[$i - 3]['InflRent']));          //减免金额
            $objActSheet->setCellValue('X' . $i, ' ' . convertUTF8($data[$i - 3]['IDnumber']) . ' ');          //低保证号
            $objActSheet->setCellValue('Y' . $i, convertUTF8($data[$i - 3]['CutType']));          //减免类型
            $objActSheet->setCellValue('Z' . $i, convertUTF8($data[$i - 3]['DiffRent']));          //基数租差

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
            $objActSheet->getStyle('M' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('N' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('O' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('P' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Q' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('R' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('S' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('T' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('U' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('V' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('W' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('X' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Y' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle('Z' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }


        //生成excel表格，自定义名
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        /*------------这种是保存到浏览器下载位置（客户端）-------------------*/

        $filename = '房屋_' . date('YmdHis', time()) . '.xlsx';    //定义文件名

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

    public function room_out()
    {
        ob_end_clean();

        Loader::import('phpexcel.PHPExcel', EXTEND_PATH);
        Loader::import('excel2007.Excel2007', EXTEND_PATH . 'PHPExcel\PHPExcel\Writer/');


        $objPHPExcel = new \PHPExcel();

        // $datas = Db::name('room')->alias('a')->join('ban b','a.BanID = b.BanID','left')->field('a.HouseID,a.BanID,a.UseArea,a.RoomType,a.FloorID,a.RoomNumber,a.LeasedArea,a.RentPoint,a.RoomRentMonth,b.BanFloorNum,b.BanPropertyID,b.StructureType')->where(['a.Status'=>1,'a.RoomPublicStatus'=>['<',3]])->select();

        // $dataHouse = Db::name('house')->column('HouseID,TenantName');

        // $roomTypes = Db::name('room_type_point')->column('id,RoomTypeName,Point');

        // $structTypes = Db::name('ban_structure_type')->column('id,NewPoint');
        // $data = [];
        // foreach($datas as $d){
        //     $houseid = explode(',',$d['HouseID']);
            
        //     foreach($houseid as $h){
        //         // if(!isset($structTypes[$d['StructureType']])){
        //         //         halt($d['BanID']);
        //         //     }
        //         $data[] = [
        //             'HouseID'=>$h, //房屋编号
        //             'TenantName'=>isset($dataHouse[$h])?$dataHouse[$h]:'', //租户姓名
        //             'DoorID'=>'', //门牌号码
        //             'BanPropertyID'=>$d['BanPropertyID'], //产权证号
        //             'RoomType'=>$roomTypes[$d['RoomType']]['RoomTypeName'], //房间类型
        //             'RoomNumber'=>$d['RoomNumber'], //间号
        //             'UseArea'=>$d['UseArea'], //实有面积
        //             'Point'=>100 - (100 * $roomTypes[$d['RoomType']]['Point']), //面积折减
        //             'LeasedArea'=>$d['LeasedArea'], //计租面积
        //             'RentPoint'=>100 - (100 * $d['RentPoint']), //基价折减率

        //             'Rpoint'=>$structTypes[$d['StructureType']], //实际基价
        //             'Cpoint'=> get_floor_point($d['FloorID'],$d['BanFloorNum'],0), //层次调解率
        //             'RoomRentMonth'=>$d['RoomRentMonth'], //月租金
        //         ];
        //     }
        // }

        // //halt($data);
        // $res = Cache::store('file')->set('room_data' . date('Y', time()), json_encode($data), 0);exit;

        $data = json_decode(Cache::store('file')->get('room_data2018'),true);

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
        $objActSheet->setTitle('计租表明细');

        //设置对齐方式
        //$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //单个单元设置对齐方式

        //设置填充色,暂时取消填充色
        // $objActSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);  //单个单元设置填充色
        // $objActSheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF00CCFF');


        //设置宽度
        $objActSheet->getColumnDimension('A')->setWidth(16);
        $objActSheet->getColumnDimension('B')->setWidth(16);
        $objActSheet->getColumnDimension('C')->setWidth(16);
        $objActSheet->getColumnDimension('D')->setWidth(16);
        $objActSheet->getColumnDimension('E')->setWidth(16);
        $objActSheet->getColumnDimension('F')->setWidth(16);
        $objActSheet->getColumnDimension('G')->setWidth(16);
        $objActSheet->getColumnDimension('H')->setWidth(16);
        $objActSheet->getColumnDimension('I')->setWidth(16);
        $objActSheet->getColumnDimension('J')->setWidth(16);
        $objActSheet->getColumnDimension('K')->setWidth(16);
        $objActSheet->getColumnDimension('L')->setWidth(16);
        $objActSheet->getColumnDimension('M')->setWidth(16);

        //设置母标题栏,合并第一行，并文字居中，加粗显示
        $objActSheet->mergeCells('A1:M1');
        $objActSheet->setCellValue('A1', convertUTF8('计租表数据'));
        $objActSheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);  //设置

        //$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');      //合并,从A1到F1
        //$objPHPExcel->getActiveSheet()->unmergeCells('A1:F1');    // 拆分

        //设置子标题栏
        $objActSheet->setCellValue('A2', convertUTF8('房屋编号'));
        $objActSheet->setCellValue('B2', convertUTF8('租户姓名'));
        $objActSheet->setCellValue('C2', convertUTF8('门牌号码'));
        $objActSheet->setCellValue('D2', convertUTF8('产权证号'));
        $objActSheet->setCellValue('E2', convertUTF8('房间类型'));
        $objActSheet->setCellValue('F2', convertUTF8('间号'));
        $objActSheet->setCellValue('G2', convertUTF8('实有面积'));
        $objActSheet->setCellValue('H2', convertUTF8('面积折减率'));
        $objActSheet->setCellValue('I2', convertUTF8('计租面积'));
        $objActSheet->setCellValue('J2', convertUTF8('基价折减率'));
        $objActSheet->setCellValue('K2', convertUTF8('实际基价'));
        $objActSheet->setCellValue('L2', convertUTF8('层次调解率'));
        $objActSheet->setCellValue('M2', convertUTF8('月租金'));

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
            $objActSheet->setCellValue('A' . $i, ' ' . convertUTF8($data[$i - 3]['HouseID']) . ' ');    //所属机构管段
            $objActSheet->setCellValue('B' . $i, convertUTF8($data[$i - 3]['TenantName']));  //房屋编号
            $objActSheet->setCellValue('C' . $i, convertUTF8($data[$i - 3]['DoorID']));       //楼栋编号
            $objActSheet->setCellValue('D' . $i, convertUTF8($data[$i - 3]['BanPropertyID']));         //门牌号码
            $objActSheet->setCellValue('E' . $i, convertUTF8($data[$i - 3]['RoomType'])); //使用面积
            $objActSheet->setCellValue('F' . $i, convertUTF8($data[$i - 3]['RoomNumber']));    //卧室面积
            $objActSheet->setCellValue('G' . $i, convertUTF8($data[$i - 3]['UseArea']));    //单元号
            $objActSheet->setCellValue('H' . $i, convertUTF8($data[$i - 3]['Point']));          //居住层
            $objActSheet->setCellValue('I' . $i, convertUTF8($data[$i - 3]['LeasedArea']));          //厅堂面积
            $objActSheet->setCellValue('J' . $i, convertUTF8($data[$i - 3]['RentPoint']));    //厨房面积
            $objActSheet->setCellValue('K' . $i, convertUTF8($data[$i - 3]['Rpoint']));    //卫生间面积
            $objActSheet->setCellValue('L' . $i, convertUTF8($data[$i - 3]['Cpoint']));          //规定租金
            $objActSheet->setCellValue('M' . $i, convertUTF8($data[$i - 3]['RoomRentMonth']));          //原价,

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
            $objActSheet->getStyle('M' . $i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }


        //生成excel表格，自定义名
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        /*------------这种是保存到浏览器下载位置（客户端）-------------------*/

        $filename = '计租表_' . date('YmdHis', time()) . '.xlsx';    //定义文件名

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





    public function out_copy()
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

        $filename = '楼栋_' . date('YmdHis', time()) . '.xlsx';    //定义文件名

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