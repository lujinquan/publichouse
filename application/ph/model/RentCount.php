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

        //halt($searchForm);

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
            if(isset($searchForm['DiffRent']) && $searchForm['DiffRent']){ 
                $where['DiffRent'] = array('>', 0);
            }
            if(isset($searchForm['PumpCost']) && $searchForm['PumpCost']){
                $where['PumpCost'] = array('>', 0);
            }
            if(isset($searchForm['CutRent']) && $searchForm['CutRent']){
                $where['CutRent'] = array('>', 0);
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

        $maps = 'HouseID,InstitutionID,BanAddress,TenantName,PumpCost,HousePrerent,DiffRent,CutRent,HistoryUnpaidRent,ReceiveRent,LateRent,OwnerType,UseNature';

        $RentLst['obj'] = Db::name('rent_config')->field($maps)->where($where)->paginate(config('paginate.list_rows'));

        $RentLst['receiveRentTotal'] = Db::name('rent_config')->where($where)->sum('ReceiveRent');

        $arr = $RentLst['obj']->all();

        if (!$arr) {
            $RentLst['arr'] = array();

        }else{

            $owners = Db::name('ban_owner_type')->column('id,OwnerType');
            $uses = Db::name('use_nature')->column('id,UseNature');
            $ins = Db::name('institution')->column('id,Institution');

            foreach ($arr as &$v) {
                $v['InstitutionID'] = $ins[$v['InstitutionID']];
                $v['OwnerType'] = $owners[$v['OwnerType']];
                $v['UseNature'] = $uses[$v['UseNature']];  

                $RentLst['arr'][] = $v;
            }
        }

        

        return $RentLst;
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
            if(isset($searchForm['DiffRent']) && $searchForm['DiffRent']){ 
                $where['DiffRent'] = array('>', 0);
            }
            if(isset($searchForm['PumpCost']) && $searchForm['PumpCost']){
                $where['PumpCost'] = array('>', 0);
            }
            if(isset($searchForm['CutRent']) && $searchForm['CutRent']){
                $where['CutRent'] = array('>', 0);
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
            if (isset($searchForm['OrderDate']) && $searchForm['OrderDate']) {  //订单日期检索              
                $where['OrderDate'] = array('eq', str_replace('/','',$searchForm['OrderDate']));
            }
            if(isset($searchForm['PaidableTime']) && $searchForm['PaidableTime']){

                $starttime = strtotime($searchForm['PaidableTime']);

                $endtime = $starttime + 3600*24;

                $where['PaidableTime'] = array('between',[$starttime,$endtime]);
            }

            // if (isset($searchForm['UnpaidDateStart'])) {  //缴费日期检索

            //     if ($searchForm['UnpaidDateStart'] && $searchForm['UnpaidDateEnd']) {  //检索大于等于起始时间，且小于等于结束时间
            //         $start = strtotime($searchForm['UnpaidDateStart']) - 1;
            //         $end = strtotime($searchForm['UnpaidDateEnd']) + 24 * 3600;
            //         //dump($start);dump($end);exit;
            //         if ($start < $end) {
            //             $where['PaidableTime'] = array('between', $start . "," . $end);
            //         }
            //     }
            //     if ($searchForm['UnpaidDateStart'] && empty($searchForm['UnpaidDateEnd'])) { //检索大于等于起始时间
            //         $start = strtotime($searchForm['UnpaidDateStart']);
            //         //dump($start);exit;
            //         $where['PaidableTime'] = array('gt', $start);
            //     }
            //     if ($searchForm['UnpaidDateEnd'] && empty($searchForm['UnpaidDateStart'])) { //检索小于等于结束时间
            //         $end = strtotime($searchForm['UnpaidDateEnd']);
            //         $where['PaidableTime'] = array('lt', $end);
            //     }
            // }
        }

        if (!isset($where)) $where = 1;

        $maps = 'RentOrderID,HouseID,InstitutionID,BanAddress,TenantID,TenantName,HousePrerent,PumpCost,DiffRent,CutRent,HistoryUnpaidRent,UnpaidRent,PaidRent,PaidableTime,ReceiveRent,LateRent,OwnerType,UseNature,CreateTime,OrderDate';

        $RentLst['obj'] = self::field($maps)->where($where)->order('id desc')->paginate(config('paginate.list_rows'));

        $RentLst['receiveRents'] = self::where($where)->value('sum(ReceiveRent) as ReceiveRents');

        //halt($RentLst['obj']);
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

        $owners = Db::name('ban_owner_type')->column('id,OwnerType');
        $uses = Db::name('use_nature')->column('id,UseNature');
        $ins = Db::name('institution')->column('id,Institution');

        foreach ($arr as $v) {
            $start = substr($v['OrderDate'], 0, 4);
            $end = substr($v['OrderDate'], 4);
            $str = ($start . '/' . $end);
            $v['OrderDate'] = $str;
            $v['OwnerType'] = $owners[$v['OwnerType']];
            $v['UseNature'] = $uses[$v['UseNature']];
            $v['InstitutionID'] = $ins[$v['InstitutionID']];
            $v['PaidableTime'] = date('Y/m/d', $v['PaidableTime']);
            $v['CreateTime'] = date('Y/m/d', $v['CreateTime']);
            $RentLst['arr'][] = $v;
        }

        return $RentLst;
    }

    public function get_one_rent_order_info($rentOrderID)
    {
        $owners = Db::name('ban_owner_type')->column('id,OwnerType');
        $uses = Db::name('use_nature')->column('id,UseNature');
        $ins = Db::name('institution')->column('id,Institution');

        $v = Db::name('rent_order')->alias('a')->join('house b','a.HouseID = b.HouseID','left')->field('a.*,b.UnitID,b.FloorID,b.RechargeRent')->where('a.RentOrderID',$rentOrderID)->find();
        $start = substr($v['OrderDate'], 0, 4);
        $end = substr($v['OrderDate'], 4);
        $str = ($start . '/' . $end);
        $v['OrderDate'] = $str;
        $v['OwnerType'] = $owners[$v['OwnerType']];
        $v['UseNature'] = $uses[$v['UseNature']];
        $v['InstitutionID'] = $ins[$v['InstitutionID']];
        $v['PaidableTime'] = date('Y/m/d', $v['PaidableTime']);
        $v['CreateTime'] = date('Y/m/d', $v['CreateTime']);
        $RentLst['arr'][] = $v;
        return $v;
    }

    /**
     *  测试模式，一次帮整个公司全部配置一遍
     */
    public function config11($ifPre)
    {


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

        Db::name('order_config')->where(['ReceiveRent'=>0])->delete();

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    /**
     *  注意，两个所，分别计算
     */
    public function config($ifPre)
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
        $where['InstitutionID'] = array('eq', $institutionID);  // 管段
        //$where['InstitutionID'] = array('not in', [34, 35]);  //34为紫阳所私有，35为粮道所私有，不需要计算租金
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        //$where['HousePrerent'] = array('>', 0); // 规租大于0
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $houseData = Db::name('house')->field($fields)->where($where)->select();
 
        $changeData = Db::name('change_order')->where(['Status'=>1,'ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->select();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        //halt($changedata);

        foreach($changeData as $c){
            $changedata[$c['HouseID']] = $c;
        }

        

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

                // 
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

        Db::name('rent_config')->where(['ReceiveRent'=>0,'InstitutionID'=>$institutionID])->delete();

        return $res?jsons('2000' ,'租金计算成功'):jsons('4001' ,'租金计算失败');
    }

    /**
     *  注意，两个所，分别计算
     */
    public function configOne($ifPre,$houseid)
    {

        Db::name('rent_config')->where('HouseID', 'eq', $houseid)->delete();

        $where['Status'] = array('eq', 1);    //房屋必须是可用状态
        $where['IfEmpty'] = array('eq', 0);    // 是否空租
        $where['IfSuspend'] = array('eq', 0);  // 是否暂停计租
        $where['InstitutionID'] = array('eq', $institutionID);  // 管段
        $where['OwnerType'] = array('neq', 6); // 6是生活用房
        $where['HouseChangeStatus'] = array('eq', 0); //是否房改，1为私房【房改】，0为公房

        $fields = 'HouseID,TenantID,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,TenantName,BanAddress,OwnerType,UseNature,AnathorOwnerType,AnathorHousePrerent,ApprovedRent,ArrearRent';
        $v = Db::name('house')->field($fields)->where($where)->find();
 
        $findData = Db::name('change_order')->where(['Status'=>1,'HouseID'=>$houseid,'ChangeType'=>1,'DateEnd'=>['>',date('Ym',time())]])->field('HouseID,CutType,InflRent')->find();

        $rentData = Db::name('rent_order')->where('Type',2)->group('HouseID')->column('HouseID,sum(UnpaidRent) as UnpaidRents');

        $str = '';

        if ($ifPre == 1) { //使用规定租金           

            if ($v['AnathorHousePrerent'] > 0) {
                $receiveRent = $v['AnathorHousePrerent'];  //应收租金，后期处理
                $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
                $str .= "," . $v['AnathorHousePrerent'] . ", 0, 0 '" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['AnathorOwnerType'] . "," . $v['UseNature'];
                $str .= ",1," . $receiveRent . "," . $receiveRent . "," . UID . "," . time() . "),";
            }

            if(isset($findData[$v['HouseID']])){
                $cutType = $findData[$v['HouseID']]['CutType'];
                $cutRent = $findData[$v['HouseID']]['InflRent'];
            }else{
                $cutType = 0;
                $cutRent = 0;
            }
            if(isset($rentData[$v['HouseID']])){
                $historyUnpaidRent = $rentData[$v['HouseID']] + $v['ArrearRent'];
            }else{
                $historyUnpaidRent = $v['ArrearRent'];
            }

            $receiveRent = $v['HousePrerent'] + $v['DiffRent'] + $v['PumpCost'] - $cutRent;

            $str .= "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID'];
            $str .= "," . $v['HousePrerent'] . "," . $v['DiffRent'] . "," . $v['PumpCost'] . "," . $cutType . "," . $cutRent . ",'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'];
            $str .= ",1," . $receiveRent . "," . $receiveRent . "," . $historyUnpaidRent . "," . UID . "," . time() . "),";
            
        } else { //使用计算租金
            return jsons('4002' ,'暂时无法配置计算租金');

        }

        $res = Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str, ','));

        return $res;
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

        /**
     *  租金订单生成，注意由所机构统一生成
     */
    public function addOne($houseid)
    {

        $institutionID = session('user_base_info.institution_id');

        //验证合法性
        if (session('user_base_info.institution_level') != 3) {
            return jsons('4000', '您的角色没有生成下月租金的权限……');
        }

        $nextDate = date('Ym');

        $where['OrderDate'] = $nextDate; //获取当月日期
        $where['HouseID'] = $houseid;
        $result = Db::name('rent_order')->where($where)->delete();
        $findOne = Db::name('rent_config')->where('HouseID',$houseid)->find();

        //然后再生成下月租金订单
        $sql = "insert into ph_rent_order (HouseID ,BanAddress,InstitutionPID,InstitutionID ,OwnerType, UseNature,IfPre,TenantID,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent) (select HouseID ,BanAddress,InstitutionPID,InstitutionID,OwnerType, UseNature,IfPre,TenantID ,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent from ph_rent_config where HouseID = $houseid)";

        $flag = Db::execute($sql);

        if($flag){

            $sql1 = 'update ph_rent_order set OrderDate = "' . $nextDate . '" , CreateTime = '.time().', CreateUserID = '.UID.',Type = 1, RentOrderID = concat(HouseID ,OwnerType, ' . '"' . $nextDate . '")  where Type =0 and InstitutionID = ' . $institutionID;  //变成科学计算了

            Db::execute($sql1);
            return true;
        }else{
            return false;
        }

        
    }

}