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
use think\Cache;
use think\Loader;
use think\Debug;
use think\Db;

class RentCount extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__RENT_ORDER__';

    public function get_all_rent_lst()
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }

        $RentLst['option'] = array();

        $searchForm = input('param.');

        foreach ($searchForm as &$val) { //去首尾空格
            $val = trim($val);
        }

        if (isset($searchForm['HouseID'])) {

            $RentLst['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                //dump($level);exit;
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //模糊检索楼栋编号
                $where['HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
            }
            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%' . $searchForm['TenantName'] . '%');
            }
            if (isset($searchForm['BanAddress']) && $searchForm['BanAddress']) {  //模糊检索楼栋地址
                $where['BanAddress'] = array('like', '%' . $searchForm['BanAddress'] . '%');
            }
            if (isset($searchForm['CutType']) && $searchForm['CutType']) {  //检索减免类型
                $where['CutType'] = array('eq', $searchForm['CutType']);
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {  //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if (isset($searchForm['UseNature']) && $searchForm['UseNature']) {  //检索使用性质
                $where['UseNature'] = array('eq', $searchForm['UseNature']);
            }
            if (isset($searchForm['TenantID']) && $searchForm['TenantID']) {  //模糊检索租户id
                $where['TenantID'] = array('like', '%' . $searchForm['TenantID'] . '%');
            }
            if (isset($searchForm['CutNumber']) && $searchForm['CutNumber']) {  //模糊减免证件号
                $where['CutNumber'] = array('like', '%' . $searchForm['CutNumber'] . '%');
            }

        }

        if (!isset($where)) $where = 1;

        $RentLst['obj'] = Db::name('rent_config')->field('id')->where($where)->paginate(config('paginate.list_rows'));

        $RentLst['receiveRentTotal'] = Db::name('rent_config')->where($where)->sum('ReceiveRent');

        $arr = $RentLst['obj']->all();

        if (!$arr) {
            $RentLst['arr'] = array();
        }

        foreach ($arr as $v) {
            $RentLst['arr'][] = self::get_one_rent_info($v['id']);
        }

        return $RentLst;
    }

    public function get_one_rent_info($id)
    {

        //订单编号，房屋编号，机构名称，租户姓名，楼栋地址，单元号，楼层号，门牌号  规定租金  , 减免租金 ，减免类型，减免证件号，月应收租金  滞纳金额 ,泵费，维修费
        $maps = 'a.HouseID,a.InstitutionID,a.BanAddress,a.TenantID,a.CutRent,a.CutType,a.CutNumber,a.ReceiveRent,a.LateRent,b.UnitID,b.FloorID,a.OwnerType,b.UseNature,b.DoorID,b.BanID,b.PumpCost,b.RepairCost';
        $one = Db::name('rent_config')->alias('a')
            ->join('house b', 'a.HouseID = b.HouseID', 'left')
            ->where('a.id', 'eq', $id)
            ->field($maps)
            ->find();

        $one['InstitutionID'] = Db::name('institution')->where('id', 'eq', $one['InstitutionID'])->value('Institution');

        if ($one['CutType'] != 0) {

            $one['CutType'] = Db::name('cut_rent_type')->where('id', 'eq', $one['CutType'])->value('CutName');

        }

        $one['OwnerType'] = get_owner($one['OwnerType']);
        $one['UseNatureName'] = get_usenature($one['UseNature']);
        $one['TenantID'] = Db::name('tenant')->where('TenantID', 'eq', $one['TenantID'])->value('TenantName');

        $wheres['HouseID'] = array('eq', $one['HouseID']);

        $historyUnpaidRent = Db::name('rent_order')->where($wheres)->sum('UnpaidRent');

        $one['HistoryUnpaidRent'] = $historyUnpaidRent ? $historyUnpaidRent : '0.00';

        return $one;
    }

    public function get_all_rent_order_lst($where = array())
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {    //用户为公司级别，则获取所有子管段
        }
        $RentLst['option'] = array();

        $searchForm = input('param.');

        foreach ($searchForm as &$val) { //去首尾空格
            $val = trim($val);
        }

        if ($houseid = input('get.HouseID')) {
            //halt($houseid);
            $where['HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
        }

        if (count($searchForm) > 4 && isset($searchForm['HouseID'])) {

            $RentLst['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if (isset($searchForm['RentOrderID']) && $searchForm['RentOrderID']) {   //检索订单编号
                $where['RentOrderID'] = array('like', '%' . $searchForm['RentOrderID'] . '%');
            }
            if (isset($searchForm['HousePrerent']) && $searchForm['HousePrerent']) {   //检索规定租金
                $where['HousePrerent'] = array('eq', $searchForm['HousePrerent']);
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //模糊检索楼栋编号
                $where['HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
            }
            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%' . $searchForm['TenantName'] . '%');
            }
            if (isset($searchForm['BanAddress']) && $searchForm['BanAddress']) {  //模糊检索楼栋地址
                $where['BanAddress'] = array('like', '%' . $searchForm['BanAddress'] . '%');
            }
            if (isset($searchForm['CutType']) && $searchForm['CutType']) {  //检索减免类型
                $where['CutType'] = array('eq', $searchForm['CutType']);
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {  //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if (isset($searchForm['UseNature']) && $searchForm['UseNature']) {  //检索产别使用性质
                $where['UseNature'] = array('eq', $searchForm['UseNature']);
            }
            if (isset($searchForm['TenantID']) && $searchForm['TenantID']) {  //模糊检索租户id
                $where['TenantID'] = array('like', '%' . $searchForm['TenantID'] . '%');
            }
            if (isset($searchForm['CutNumber']) && $searchForm['CutNumber']) {  //模糊检索减免证件号
                $where['CutNumber'] = array('like', '%' . $searchForm['CutNumber'] . '%');
            }

            if (isset($searchForm['DateStart'])) {  //订单日期检索

                if ($searchForm['DateStart'] && $searchForm['DateEnd']) {  //检索大于等于起始时间，且小于等于结束时间
                    $start = (int)(str_replace('/', '', $searchForm['DateStart']));
                    $end = (int)(str_replace('/', '', $searchForm['DateEnd']));
                    //dump($start);dump($end);exit;
                    if ($start < $end) {
                        $where['OrderDate'] = array('between', $start . "," . $end);
                    }
                    if ($start > $end) {
                        $where['OrderDate'] = array('between', $end . "," . $start);
                    }
                    if ($start == $end) {
                        $where['OrderDate'] = array('eq', $start);
                    }
                }
                if ($searchForm['DateStart'] && empty($searchForm['DateEnd'])) { //检索大于等于起始时间
                    $start = (int)(str_replace('/', '', $searchForm['DateStart']));
                    $where['OrderDate'] = array('egt', $start);
                }
                if (empty($searchForm['DateStart']) && $searchForm['DateEnd']) { //检索小于等于结束时间
                    $end = (int)(str_replace('/', '', $searchForm['DateEnd']));
                    $where['OrderDate'] = array('elt', $end);
                }

            }

            if (isset($searchForm['UnpaidDateStart'])) {  //缴费日期检索

                if ($searchForm['UnpaidDateStart'] && $searchForm['UnpaidDateEnd']) {  //检索大于等于起始时间，且小于等于结束时间
                    $start = strtotime($searchForm['UnpaidDateStart']) - 1;
                    $end = strtotime($searchForm['UnpaidDateEnd']) + 24 * 3600;
                    //dump($start);dump($end);exit;
                    if ($start < $end) {
                        $where['PaidableTime'] = array('between', $start . "," . $end);
                    }
                }
                if ($searchForm['UnpaidDateStart'] && empty($searchForm['UnpaidDateEnd'])) { //检索大于等于起始时间
                    $start = strtotime($searchForm['UnpaidDateStart']);
                    //dump($start);exit;
                    $where['PaidableTime'] = array('gt', $start);
                }
                if ($searchForm['UnpaidDateEnd'] && empty($searchForm['UnpaidDateStart'])) { //检索小于等于结束时间
                    $end = strtotime($searchForm['UnpaidDateEnd']);
                    $where['PaidableTime'] = array('lt', $end);
                }
            }
        }
        //halt($where);

        if (!isset($where)) $where = 1;

        $RentLst['obj'] = self::field('RentOrderID')->where($where)->order('id desc')->paginate(config('paginate.list_rows'));
        $findOne = Db::name('rent_order')->where($where)
                    ->field('sum(UnpaidRent) as UnpaidRents,sum(PaidRent) as PaidRents,sum(ReceiveRent) as ReceiveRents')
                    ->find();
        $RentLst['UnpaidRents'] = $findOne['UnpaidRents'];
        $RentLst['PaidRents'] = $findOne['PaidRents'];
        $RentLst['ReceiveRents'] = $findOne['ReceiveRents'];

        $arr = $RentLst['obj']->all();

        if (!$arr) {
            $RentLst['arr'] = array();
        }

        foreach ($arr as $v) {
            $RentLst['arr'][] = self::get_one_rent_order_info($v['RentOrderID']);
        }

        return $RentLst;
    }

    public function get_one_rent_order_info($rentOrderID)
    {

        //订单编号，房屋编号，机构名称，租户姓名，楼栋地址，单元号，楼层号，门牌号  规定租金  , 减免租金 ，减免类型，减免证件号，月应收租金  滞纳金额 ,泵费，维修费
        //$maps = 'a.RentOrderID,a.HouseID,a.InstitutionID,a.TenantID,a.HousePrerent,a.CreateTime,a.CutRent,a.CutType,a.CutNumber,a.ReceiveRent,a.LateRent,a.PaidableTime,b.UnitID,b.FloorID,b.DoorID,b.BanID,b.PumpCost,b.RepairCost';

        $maps = 'a.* ,b.UnitID,b.FloorID,b.TenantName,b.DoorID,b.BanID,b.PumpCost,b.RepairCost';

        $one = Db::name('rent_order')->alias('a')
            ->join('house b', 'a.HouseID = b.HouseID', 'left')
            ->where('RentOrderID', 'eq', $rentOrderID)
            ->field($maps)
            ->find();

        //halt($one);
        $start = substr($one['OrderDate'], 0, 4);
        $end = substr($one['OrderDate'], 4);
        $str = ($start . '/' . $end);
        $one['OrderDate'] = $str;
        $one['OwnerType'] = get_owner($one['OwnerType']);
        $one['UseNature'] = get_usenature($one['UseNature']);
        $one['InstitutionID'] = Db::name('institution')->where('id', 'eq', $one['InstitutionID'])->value('Institution');
        $one['PaidableTime'] = date('Y/m/d', $one['PaidableTime']);
        $one['CreateTime'] = date('Y/m/d', $one['CreateTime']);

        if ($one['CutType'] != 0) {
            $one['CutType'] = Db::name('cut_rent_type')->where('id', 'eq', $one['CutType'])->value('CutName');
        }

        $one['TenantBalance'] = Db::name('tenant')->where('TenantID', 'eq', $one['TenantID'])->value('TenantBalance');
        $wheres['HouseID'] = array('eq', $one['HouseID']);
        $wheres['CreateTime'] = array('lt', $one['CreateTime']);
        return $one;
    }

    /**
     *  测试模式，一次帮整个公司全部配置一遍
     */
    public function config($ifPre)
    {


        //重新生成租金配置时，先删除原配置
        Db::name('rent_config')->delete(true);

        $where['Status'] = array('eq', 1);    //房屋必须是可用状态
        $where['IfEmpty'] = array('eq', 0);    // 是否空租
        $where['IfSuspend'] = array('eq', 0);  // 是否暂停计租
        //$where['InstitutionID'] = array('eq', $institutionID);  // 2或者3，紫阳所，粮道所
        //$where['InstitutionID'] = array('not in', [34, 35]);  //34为紫阳所私有，35为粮道所私有，不需要计算租金
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        $where['HousePrerent'] = array('>', 0); // 规租大于0
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $houseData = Db::name('house')->field($fields)->where($where)->select();
        
        $changeData = Db::name('change_order')->where(['ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->select();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        //halt($rentData);

        foreach($changeData as $c){
            $changedata[$c['HouseID']] = $c;
        }

        //halt($changedata);

        $str = '';

        if ($ifPre == 1) { //使用规定租金

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
        } else { //使用计算租金
            return jsons('4002' ,'暂时无法配置计算租金');

        }

        //Db::query("insert into ph_rent_config (HouseID ,TenantID ,InstitutionID) values ('12','13',1),('23','14',2)");
        $res = Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str, ','));

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    /**
     *  注意，两个所，分别计算
     */
    public function config11($ifPre)
    {

        $institutionID = session('user_base_info.institution_id');

        //验证合法性
        if (session('user_base_info.institution_level') != 3) {
            return jsons('4000', '您的角色没有计算租金权限……');
        }

        //重新生成租金配置时，先删除原配置
        Db::name('rent_config')->where('InstitutionID', 'eq', $institutionID)->delete();

        $where['Status'] = array('eq', 1);    //房屋必须是可用状态
        $where['IfEmpty'] = array('eq', 0);    // 是否空租
        $where['IfSuspend'] = array('eq', 0);  // 是否暂停计租
        $where['InstitutionID'] = array('eq', $institutionID);  // 2或者3，紫阳所，粮道所
        //$where['InstitutionID'] = array('not in', [34, 35]);  //34为紫阳所私有，35为粮道所私有，不需要计算租金
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        $where['HousePrerent'] = array('>', 0); // 规租大于0
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $houseData = Db::name('house')->field($fields)->where($where)->select();
        
        $changeData = Db::name('change_order')->where(['ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->select();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        //halt($rentData);

        foreach($changeData as $c){
            $changedata[$c['HouseID']] = $c;
        }

        //halt($changedata);

        $str = '';

        if ($ifPre == 1) { //使用规定租金

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
        } else { //使用计算租金
            return jsons('4002' ,'暂时无法配置计算租金');

        }

        //Db::query("insert into ph_rent_config (HouseID ,TenantID ,InstitutionID) values ('12','13',1),('23','14',2)");
        $res = Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str, ','));

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    /**
     *  租金订单生成，注意由所机构统一生成
     */
    public function add()
    {

        $institutionID = session('user_base_info.institution_id');

        //验证合法性
        if (session('user_base_info.institution_level') != 3) {
            return jsons('4000', '您的角色没有生成下月租金的权限……');
        }

        $nextDate = date('Ym');

        $where['OrderDate'] = $nextDate; //获取当月日期
        $where['InstitutionID'] = $institutionID;
        $result = Db::name('rent_order')->where($where)->field('Type')->find();
        $findOne = Db::name('rent_config')->find();

        
        if (!$findOne) {
            return jsons('4004', '请先生成租金配置');
        }

        if ($result) {
            return jsons('4003', '租金已生成，请勿重复操作……');
        } else {  //生成下月租金

            //然后再生成下月租金订单
            $sql = "insert into ph_rent_order (HouseID ,BanAddress,InstitutionPID,InstitutionID ,OwnerType, UseNature,IfPre,TenantID,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent) (select HouseID ,BanAddress,InstitutionPID,InstitutionID,OwnerType, UseNature,IfPre,TenantID ,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent from ph_rent_config where InstitutionID = $institutionID)";

            $flag = Db::execute($sql);

            if($flag){

                $sql1 = 'update ph_rent_order set OrderDate = "' . $nextDate . '" , CreateTime = '.time().', CreateUserID = '.UID.',Type = 1, RentOrderID = concat(HouseID ,OwnerType, ' . '"' . $nextDate . '")  where Type =0 and InstitutionID = ' . $institutionID;  //变成科学计算了
   
                Db::execute($sql1);
                return true;
            }else{
                return false;
            }

            


//            //添加后置操作，如果有扣缴的，执行扣缴操作
//
//            $data = Db::name('rent_order')->where($where)->field('HouseID ,TenantID ,ReceiveRent')->select();
//
//            foreach($data as $k1 => $v1){
//
//                $balance = Db::name('tenant')->where('TenantID' ,'eq' ,$v1['TenantID'])->value('TenantBalance');  //查询账户余额
//
//                if($balance > $v1['ReceiveRent']){
//
//                   $res = Db::name('tenant')->where('TenantID' ,'eq' ,$v1['TenantID'])->setDec('TenantBalance',$v1['ReceiveRent']);
//
//                   if($res){
//
//                       $where['HouseID'] = array('eq' ,$v1['HouseID']);
//
//                       Db::name('rent_order')->where($where)->setField('IfPaidable' ,1);
//                   }
//                }
//            }


        }
    }

}