<?php


namespace app\ph\model;

use think\Model;
use app\ph\model\BanInfo as BanInfoModel;
use app\ph\model\HouseInfo as HouseInfoModel;
use app\ph\model\TenantInfo as TenantInfoModel;
use think\Db;
use util\Tree;

class ChangeAudit extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = '__CHANGE_ORDER__';

    public function get_all_change_lst()
    {

        //筛选出只属于当前机构的申请

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);

        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询

            $allInstitution = Db::name('institution')->field('id ,Institution,pid')
                ->where('pid', 'eq', $currentUserInstitutionID)
                ->select();


            foreach ($allInstitution as $key => $value) {

                $arrs[] = $value['id']; //保存所有子管段id
            }

            $where['InstitutionID'] = array('in', $arrs);

        } else {    //用户为公司级别，则获取所有子管段


        }

        $ChangeList['option'] = array();

        if ($searchForm = input('post.')) {

            foreach ($searchForm as &$val) { //去首尾空格
                $val = trim($val);
            }

            $ChangeList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                //dump($level);exit;
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if ($searchForm['ChangeOrderID']) {   //异动编号
                $where['ChangeOrderID'] = array('like', '%' . $searchForm['ChangeOrderID'] . '%');
            }
            if ($searchForm['ChangeType']) {  //检索变更类型
                $where['ChangeType'] = array('eq', $searchForm['ChangeType']);
            }
            if ($searchForm['OwnerType']) {  //检索变更类型
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            // if ($searchForm['UseNature']) {  //检索变更类型
            //     $where['UseNature'] = array('eq', $searchForm['UseNature']);
            // }
            if ($searchForm['InflRent']) {  //检索变更类型
                $where['InflRent'] = array('eq', $searchForm['InflRent']);
            }
            if ($searchForm['UserName']) {  //检索操作人名称
                $where['UserName'] = array('like', '%' . $searchForm['UserName'] . '%');
            }

            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){

                $starttime = strtotime($searchForm['CreateTime']);

                $endtime = $starttime + 3600*24;

                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }
            
            // if ($searchForm['DateStart'] && $searchForm['DateEnd']) {  //检索大于等于起始时间，且小于等于结束时间
            //     $start = strtotime($searchForm['DateStart']);
            //     $end = strtotime($searchForm['DateEnd']);
            //     //dump($start);dump($end);exit;
            //     if ($start < $end) {
            //         $where['CreateTime'] = array('between', $start . "," . $end);
            //     }
            // }
            // if ($searchForm['DateStart'] && empty($searchForm['DateEnd'])) { //检索大于等于起始时间
            //     $start = strtotime($searchForm['DateStart']);
            //     //dump($start);exit;
            //     $where['CreateTime'] = array('egt', $start);
            // }
            // if ($searchForm['DateEnd'] && empty($searchForm['DateStart'])) { //检索小于等于结束时间
            //     $end = strtotime($searchForm['DateEnd']);
            //     $where['CreateTime'] = array('elt', $end);
            // }

        }

        $where['Status'] = array('not in', [0, 1]);

        $ChangeList['obj'] = self::field('id')->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $arr = $ChangeList['obj']->all();

        if (!$arr) {

            $ChangeList['arr'] = array();
        }

        foreach ($arr as $v) {

            $ChangeList['arr'][] = self::get_one_change_info($v['id']);

        }

        return $ChangeList;
    }

    public function get_one_change_info($id = '', $map = '')
    {

        //异动编号 ，房屋编号 ，异动类型 ，操作机构 ，操作人 ，操作时间 ，状态
        if (!$map) $map = 'ChangeOrderID ,HouseID ,ChangeType ,OwnerType ,UseNature, InflRent, InstitutionID ,UserNumber ,CreateTime ,Status';
        $data = self::field($map)->where('id', 'eq', $id)->find();

        if (!$data) {
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id', 'eq', $data['InstitutionID'])->value('Institution');

        $data['ChangeType'] = Db::name('change_type')->where('id', 'eq', $data['ChangeType'])->value('ChangeType');

        $res = self::order_config_detail($data['ChangeOrderID'], $data['Status']);

        $data['ProcessRoleID'] = $res['RoleID'];

        $data['UseNature'] = get_usenature($data['UseNature']);
        $data['OwnerType'] = get_owner($data['OwnerType']); 

        $data['Status'] = '待' . $res['RoleName'] . $res['Title'];

        $data['UserNumber'] = Db::name('admin_user')->where('Number', 'eq', $data['UserNumber'])->value('UserName');

        $data['CreateTime'] = date('Y-m-d H:i:s', $data['CreateTime']);

        return $data;
    }

    /**
     * 每个异动的顶部详情都应该不一样，所以每个case分别获取，暂时做成一样的
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [  ]
     */
    public function get_change_detail_info($changeOrderID)
    {

        $changeType = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->value('ChangeType');

        switch ($changeType) {
            case 1:    // 租金减免
                $data = self::get_one_detail($changeOrderID);
                break;
            case 2:    // 空租
                $data = self::get_two_detail($changeOrderID);
                break;
            case 3:     //  暂停计租
                $data = self::get_three_detail($changeOrderID);
                break;
            case 4:     //  陈欠核销
                $data = self::get_four_detail($changeOrderID);
                break;
            case 5:     //  房改
                $data = self::get_five_detail($changeOrderID);
                break;
            case 6:     //  维修
                $data = self::get_six_detail($changeOrderID);
                break;
            case 7:     //  新发租
                $data = self::get_seven_detail($changeOrderID);
                break;
            case 8:     //  注销
                $data = self::get_eight_detail($changeOrderID);
                break;
            case 9:     //  房屋调整
                $data = self::get_nine_detail($changeOrderID);
                break;
            case 10:     //  管段调
                $data = self::get_ten_detail($changeOrderID);
                break;
            case 11:     //  租金追加调整
                $data = self::get_eleven_detail($changeOrderID);
                break;
            case 12:     //  租金调整
                $data = self::get_twelve_detail($changeOrderID);
                break;
            case 13:     //  分户
                $data = self::get_thirteen_detail($changeOrderID);
                break;
            case 14:     //  并户
                $data = self::get_fourteen_detail($changeOrderID);
                break;
            default:
        }

        return $data;
    }

    public function get_one_detail($changeOrderID)
    {  //获取租金减免的详情

        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('InflRent,HouseID,Remark,CreateTime')->find();

        $data = get_house_info($oneData['HouseID']);

        $datas = Db::name('rent_cut_order')->alias('a')
            ->join('cut_rent_type b', 'a.CutType = b.id', 'left')->where('ChangeOrderID', 'eq', $changeOrderID)
            ->field('b.CutName ,a.IDnumber,a.MuchMonth')
            ->find();
        $data['Remark'] = $oneData['Remark'];
        $data['InflRent'] = $oneData['InflRent'];
        $data['CutName'] = $datas['CutName'];
        $data['IDnumber'] = $datas['IDnumber'];
        $data['MuchMonth'] = $datas['MuchMonth'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 1;

        return $data;
    }

    public function get_two_detail($changeOrderID)
    {   //空租

        //房屋编号
        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Remark,TenantID,CreateTime')->find();
        $data = get_house_info($oneData['HouseID']);
        //$tenatinfo = Db::name('tenant')->where('TenantID',$oneData['TenantID'])->field('')->find();
        $data['Remark'] = $oneData['Remark'];
        $data['Tenant'] = Db::name('tenant')->where('TenantID',$oneData['TenantID'])->field('TenantID,TenantName,TenantTel,TenantNumber')->find();
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 2;
        return $data;
    }

    public function get_three_detail($changeOrderID)
    {   //暂停计租

        //房屋编号
        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('InflRent,HouseID,BanID,CreateTime,Remark')->find();

        $data['ban'] = get_ban_info($oneData['BanID']);
        $data['Remark'] = $oneData['Remark'];
        $houses = explode(',',$oneData['HouseID']);
        $data['house'] = Db::name('house')->where(['HouseID'=>['in',$houses]])
                                     ->field('HouseID,TenantName,HousePrerent,BanAddress')
                                     ->select();
        $data['InflRent'] = $oneData['InflRent'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 3;

        return $data;
    }

    public function get_four_detail($changeOrderID)
    {   //陈欠核销

        //房屋编号
        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('OldMonthRent,HouseID,OldYearRent,Remark,Deadline,CreateTime')->find();
        $data = get_house_info($oneData['HouseID']);
        $data['OldMonthRent'] = $oneData['OldMonthRent'];
        $data['OldYearRent'] = $oneData['OldYearRent'];
        $data['Deadline'] = $oneData['Deadline'];
        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 4;
        return $data;
    }

    public function get_five_detail($changeOrderID)
    {   //房改

        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Remark,CreateTime')->find();
        $data = get_house_info($oneData['HouseID']);
        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 5;

        return $data;

    }

    public function get_six_detail($changeOrderID)
    {   //维修

        //楼栋编号
        //$banID = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('BanID');

        //$maps = 'RepairType ,OwnerType ,StructureType ,UseNature ,TotalArea ,CoveredArea ,DamageGrade ,RepairReson ,BanUnitNum ,BanFloorNum';

        $oneNew = Db::name('repair_change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

        $banID = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->value('BanID');

        $oneNew['BanAddress'] = Db::name('ban')->where('BanID', 'eq', $banID)->value('BanAddress');
        $oneNew['BanID'] = $banID;
        $oneNew['OwnerType'] = get_owner($oneNew['OwnerType']);

        $oneNew['Structure'] = get_structure($oneNew['StructureType']);

        $oneNew['UseNature'] = get_usenature($oneNew['UseNature']);

        $oneNew['DamageGrade'] = get_damage($oneNew['DamageGrade']);

        $oneNew['OldOwnerType'] = get_owner($oneNew['OldOwnerType']);

        $oneNew['OldStructure'] = get_structure($oneNew['OldStructureType']);

        $oneNew['OldUseNature'] = get_usenature($oneNew['OldUseNature']);

        $oneNew['OldDamageGrade'] = get_damage($oneNew['OldDamageGrade']);

        if ($oneNew['RepairType'] == 1) {

            $oneNew['RepairType'] = '翻修';

        } else {

            $oneNew['RepairType'] = '重建';
        }

        $oneNew['type'] = 6;

        return $oneNew;

    }

    public function get_seven_detail($changeOrderID)
    {   

        //新发租
        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Remark,CreateTime')->find();

        $data = get_house_info($oneData['HouseID']);

        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 7;

        return $data;
    }

    public function get_eight_detail($changeOrderID)
    {   

        //注销
        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Deadline,Remark,CancelType,CreateTime')->find();
        $data = get_house_info($oneData['HouseID']);
        $data['CancelType'] = Db::name('cancel_type')->where('id', 'eq', $oneData['CancelType'])->value('Title');
        $data['Ban'] = json_decode($oneData['Deadline']);
        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 8;

        return $data;
    }

    public function get_nine_detail($changeOrderID)
    {   
        //房屋编号
        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Deadline,Remark,CreateTime')->find();

        $data = get_house_info($oneData['HouseID']);
        $data['Ban'] = json_decode($oneData['Deadline']);
        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 9;

        return $data;
    }

    public function get_ten_detail($changeOrderID)
    {   //管段调整

        //房屋编号
        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('BanID,HouseID,NewInstitutionID')->find();

        if($oneData['BanID']){
            $data = get_ban_info($oneData['BanID']);
            $data['BanID'] = $oneData['BanID'];
        }else{
            $banid = Db::name('house')->where('HouseID',$oneData['HouseID'])->value('BanID');
            $data[0] = get_ban_info($banid);
            $data[1] = get_house_info($oneData['HouseID']);
            $data['HouseID'] = $oneData['HouseID'];
        }

        $data['NewInstitutionID'] = get_institution($oneData['NewInstitutionID']);



        $data['type'] = 10;

        return $data;
    }

    public function get_eleven_detail($changeOrderID)
    {   
        //租金追加调整
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();
        $data = get_house_info($one['HouseID']);
        $data['OldYearRent'] = $one['OldYearRent'];
        $data['OldMonthRent'] = $one['OldMonthRent'];
        $data['Remark'] = $one['Remark'];
        $data['type'] = 11;
        return $data;
    }

    public function get_twelve_detail($changeOrderID)
    {   
        //租金调整
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();
        $data = get_house_info($one['HouseID']);
        $data['Ban'] = json_decode($one['Deadline'],true);
        $data['Remark'] = $one['Remark'];
        $data['type'] = 12;
        return $data;
    }

    public function get_thirteen_detail($changeOrderID)
    {   //分户

        //房屋编号
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,NewHouseID,RoomID')->find();
        $roomids = explode(',',$one['RoomID']);

        $data['OldHouseInfo'] = get_house_info($one['HouseID']);
        $data['OldHouseInfo']['RoomNumbers'] = Db::name('Room')->where(['HouseID'=>['like','%'.$one['HouseID'].'%'],'RoomID'=>['not in',$roomids]])->column('RoomNumber,RoomID');

        $data['NewHouseInfo'] = get_house_info($one['NewHouseID']);
        $data['NewHouseInfo']['RoomNumbers'] = Db::name('Room')->where('RoomID','in',$roomids)->column('RoomNumber,RoomID');

        $data['type'] = 13;

        return $data;
    }

    public function get_fourteen_detail($changeOrderID)
    {
        //房屋编号
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();

        $jsons = json_decode($one['Deadline'],true);

        $data = get_ban_info($one['BanID']);

        $data['Remark'] = $one['Remark'];

        $data['beforeDamage'] = get_damage($jsons['beforeDamage']);
        $data['beforeStructure'] = get_structure($jsons['beforeStructure']);
        if($jsons['afterDamage']){
            $data['afterDamage'] = get_damage($jsons['afterDamage']);   
        }
        if($jsons['afterStructure']){
            $data['afterStructure'] = get_structure($jsons['afterStructure']);
        }

        $data['type'] = 14;

        return $data;
    }


    /**
     * @title 获取租户信息
     * @author Mr.Lu
     * @param  $changeOrderID  变更编号
     * @param  $status  主订单状态
     * @return array [ RoleName  下一步操作的角色名称 ， Title  下一步操作的步骤标题 ]
     */
    public function order_config_detail($changeOrderID, $status)
    {
        $config = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where('a.ChangeOrderID', 'eq', $changeOrderID)
            ->field('b.id, b.Title ,b.Total')
            ->find();

        $maps['pid'] = array('eq', $config['id']);
        $maps['Total'] = array('eq', $status);

        $res = Db::name('process_config')->where($maps)->field('RoleName ,Title ,RoleID')->find();

        return $res;

    }

    //创建一个子订单，例如（补充资料完成，每次审核完成 ，）
    public function create_child_order($changeOrderID, $reson = '')
    {   //此处有别与使用权变更，不通过打回的时候直接进入记录

        //获取流程总人数
        $total = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where('a.ChangeOrderID', 'eq', $changeOrderID)
            ->value('Total');

        $where['ChangeOrderID'] = array('eq', $changeOrderID);

        //判断当前流程，，通过比对当前进行到第几步和流程总步数，来确定是否为终审
        $status = self::where($where)->value('Status');

        //若中间审核通过
        if ($status < $total && $reson == '') {

            self::where($where)->setInc('Status', 1); //步骤递进

            $datas['Status'] = 2;

            //若审核不通过
        } elseif ($reson != '') {

            //终审不通过则状态改为 0
            self::where($where)->setField('Status', 0);

            $datas['Status'] = 3;

            // 若终审通过
        } elseif ($status == $total && $reson == '') {

            //终审通过则状态改为  1,并写入最终通过时间
            self::where($where)->update(['Status' => 1, 'FinishTime' => time()]);

            $changeType = self::where($where)->value('ChangeType');


            //终审通过后，系统直接将对应的数据修改为异动后的数据
            model('ph/ChangeAudit')->after_process($changeOrderID, $changeType);  //终审通过后，系统直接更改相关的

            $datas['Status'] = 2;

        }

        $option['FatherOrderID'] = array('eq', $changeOrderID);
        $option['IfValid'] = array('eq', 1);
        $step = Db::name('use_child_order')->where($option)->max('Step');

        if (!$step) {
            $datas['Step'] = 2;
        } else {
            $datas['Step'] = $step + 1;
        }

        $datas['FatherOrderID'] = $changeOrderID;  //父订单编号
        $datas['InstitutionID'] = session('user_base_info.institution_id'); //保存机构
        $datas['Reson'] = $reson; //不通过理由
        $datas['UserNumber'] = UID;
        $datas['CreateTime'] = time();

        //halt($datas);
        $re = Db::name('use_child_order')->insert($datas);  //创建子订单

        if ($status < $total && $reson != '') {
            Db::name('use_child_order')->where('FatherOrderID', 'eq', $changeOrderID)->setField('IfValid', 0); //重置之前的子订单状态为无效
        }

        if ($re) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * 检查是否可执行当前审批 :::  注意如果当前登录账号拥有多角色，例如同时有审批流中的多个角色，程序可能会出现BUG
     * @description  还没测试
     * @author Mr.Lu
     * @return bool
     */
    public function after_process($changeOrderID, $changeType)
    {

        switch ($changeType) {
            case 1:  //租金减免异动完成后的，系统处理

                $one = Db::name('change_order')->alias('a')->join('rent_cut_order b','a.ChangeOrderID = b.ChangeOrderID','left')->where('a.ChangeOrderID',$changeOrderID)->field('b.IDnumber,a.*')->find();
                //将减免的金额写入到房屋减免字段中去
                Db::name('house')->where('HouseID', $one['HouseID'])->setInc('RemitRent', $one['InflRent']);

                //将减免类型，减免金额，减免证件号写入到租金配置中去 
                $rentconfigfind = Db::name('rent_config')->where('HouseID', $one['HouseID'])->find();  

                if($rentconfigfind){
                    Db::name('rent_config')->where('HouseID', $one['HouseID'])
                                            ->update([
                                                'CutType' => $one['CutType'],
                                                'CutRent' => $one['InflRent'], 
                                                'CutNumber' => $one['IDnumber'],
                                                'ReceiveRent'=>['exp','ReceiveRent'-$one['InflRent']],
                                                'UnpaidRent'=>['exp','UnpaidRent'-$one['InflRent']] ,
                                            ]);
                }
                $rentorderfind = Db::name('rent_order')->where(['OrderDate'=>['eq',date('Ym',time())],'HouseID'=>$one['HouseID']])->find();        
                if($rentconfigfind){
                    Db::name('rent_order')->where(['OrderDate'=>['eq',date('Ym',time())],'HouseID'=>$one['HouseID']])
                                            ->update([
                                                'CutType' => $one['CutType'],
                                                'CutRent' => $one['InflRent'], 
                                                'CutNumber' => $one['IDnumber'],
                                                'ReceiveRent'=>['exp','ReceiveRent'-$one['InflRent']],
                                                'UnpaidRent'=>['exp','UnpaidRent'-$one['InflRent']] ,
                                            ]);
                }

                $str = "( 1,'". $one['ChangeOrderID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . $one['OrderDate']. "," . $one['DateEnd'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate,DateEnd) values " . rtrim($str, ','));

                break;
            case 2:  //空租异动完成后的，系统处理
                //修改对应的房屋的状态为空租
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();
                // if($one['TenantID']){
                //     $tenantName = Db::name('tenant')->where('TenantID',$one['TenantID'])->value('TenantName');
                //     Db::name('house')->where('HouseID', 'eq', $one['HouseID'])->update(['IfEmpty' => 0, 'TenantID' => $one['TenantID'], 'TenantName' => $tenantName]);
                //     Db::name('rent_table')->where(['ChangeType'=>2,'HouseID'=>$one['HouseID']])->setField('InflRent',0);
                // }else{
                Db::name('house')->where('HouseID', 'eq', $one['HouseID'])->update(['IfEmpty' => 1]);
                Db::name('rent_config')->where('HouseID', 'eq', $one['HouseID'])->delete();
                Db::name('rent_order')->where(['HouseID'=>['eq', $one['HouseID']],'OrderDate'=>date('Ym',time())])->delete();

                $str = "( 2,'". $one['ChangeOrderID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . $one['OrderDate'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                //}  
                
                break;

            case 3:  //暂停计租异动完成后的，系统处理

                $houseModel = new HouseInfoModel;

                //修改对应的房屋的状态为暂停计租
                $changeFind = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('ChangeOrderID,HouseID,OrderDate,ChangeType')->find();

                if(strpos($changeFind['HouseID'],',')){
                    $arr = explode(',',$changeFind['HouseID']);
                    $houseModel->where('HouseID', 'in', $arr)->setField('IfSuspend', 1);
                    $housearr = $houseModel->where('HouseID', 'in', $arr)->field('InstitutionID,InstitutionPID,HousePrerent,OwnerType,UseNature')->select();

                    $str = '';
                    foreach($housearr as $v){
                        $str .= "('" .$changeFind['ChangeOrderID'] . "',". $changeFind['ChangeType'] . ",". $v['InstitutionID'] . "," . $v['InstitutionPID'] . "," . $v['HousePrerent'] . ", " . $v['OwnerType'] . "," . $v['UseNature'] . "," . $changeFind['OrderDate']. "),";
                    }

                }else{
                    $houseModel->where('HouseID', 'eq', $changeFind['HouseID'])->setField('IfSuspend', 1);
                    $housearr = $houseModel->where('HouseID', 'eq', $changeFind['HouseID'])->field('InstitutionID,InstitutionPID,HousePrerent,OwnerType,UseNature')->find();
                    $str = "('" . $changeFind['ChangeOrderID'] . "',".$changeFind['ChangeType'] . ",". $v['InstitutionID'] . "," . $v['InstitutionPID'] . "," . $v['HousePrerent'] . ", " . $v['OwnerType'] . "," . $v['UseNature'] . "," . $changeFind['OrderDate']. ")";
                }
//halt($str);
                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeOrderID,ChangeType,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                
                break;

            case 4:  //陈欠核销异动完成后的，系统处理 （待完善，将所有满足条件的账抹平）
                //将所有该房屋对应的时间段的租金订单全部修改为完全缴纳状态，注意已缴、欠缴、已缴状态
                $one = Db::name('change_order')->where('ChangeOrderID','eq',$changeOrderID)->find();

                if($one['Deadline']){
                    $e = strpos($one['Deadline'],',')?explode(',',$one['Deadline']):['0'=>$one['Deadline']];
                    $year = date('Y',time());
                    $arr = [
                     '1' => $year.'01',
                     '2' => $year.'02',
                     '3' => $year.'03',
                     '4' => $year.'04',
                     '5' => $year.'05',
                     '6' => $year.'06',
                     '7' => $year.'07',
                     '8' => $year.'08',
                     '9' => $year.'09',
                     '10' => $year.'10',
                     '11' => $year.'11',
                     '12' => $year.'12',
                    ];
                    foreach($e as $v){
                        Db::name('rent_order')->where(['HouseID'=>$one['HouseID'],'OrderDate'=>$arr[$v]])->update([
                                'PaidRent' => ['exp','ReceiveRent'],
                                'UnpaidRent' => 0,
                                'Type' => 3,
                        ]);
                    }    
                }
                Db::name('house')->where('HouseID',$one['HouseID'])->setDec('ArrearRent',$one['OldYearRent']);

                $str = "( 4,'". $one['ChangeOrderID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['OldMonthRent'] . ", " . $one['OldYearRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . $one['OrderDate']. ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,OldMonthRent,OldYearRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;
            case 5:  //房改异动完成后的，系统处理
                //修改对应的房屋的状态为注销
                $houseID = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->value('HouseID');
                Db::name('house')->where('HouseID', 'eq', $houseID)->setField('Status', 100); //为历史数据，不可用状态
                Db::name('room')->where('HouseID', 'eq', $houseID)->setField('Status', 100);  //1000为历史数据，不可用状态
                //修改租金配置表,删除不可用状态房屋对应的租金配置记录
                Db::name('rent_config')->where('HouseID', 'eq', $houseID)->delete();
                break;

            case 6:  //维修异动完成后的，系统处理
                $banid = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->value('BanID');
                $findOne = Db::name('repair_change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('OwnerType,UseNature,StructureType,BanUnitNum,DamageGrade,CoveredArea,TotalArea,BanFloorNum')->find();
                $res['BanID'] = $banid;
                $res['OwnerType'] = $findOne['OwnerType'];
                $res['UseNature'] = $findOne['UseNature'];
                $res['StructureType'] = $findOne['StructureType'];
                $res['BanUnitNum'] = $findOne['BanUnitNum'];
                $res['DamageGrade'] = $findOne['DamageGrade'];
                $res['CoveredArea'] = $findOne['CoveredArea'];
                $res['TotalArea'] = $findOne['TotalArea'];
                $res['BanFloorNum'] = $findOne['BanFloorNum'];
                Db::name('ban')->update($res);
                Db::name('room')->where('BanID',$banid)->update(['OwnerType'=>$findOne['OwnerType']]);
                break;

            case 7:  //新发租异动完成后的，系统处理
                
                $findOne = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                Db::name('house')->where('HouseID',$findOne['HouseID'])->update(['Status'=>1]);

                $v = Db::name('house')->where('HouseID',$findOne['HouseID'])->find();
                
                Db::name('ban')->where('BanID',$findOne['BanID'])->update([
                    'Status'=>1

                    ]);

                switch($findOne['UseNature']){
                    case 1:
                        Db::name('ban')->where('BanID',$v['BanID'])->update(
                            [
                                'CivilArea' => ['exp','CivilArea+'.$v['HouseArea']],
                                'CivilOprice' => ['exp','CivilOprice+'.$v['OldOprice']],
                                'CivilRent' => ['exp','CivilRent+'.$v['HousePrerent']],
                                'BanUsearea' => ['exp','BanUsearea+'.$v['HouseUsearea']],
                            ]
                        );
                    break;
                       
                    case 2:
                     
                        Db::name('ban')->where('BanID',$v['BanID'])->update(
                            [
                                'EnterpriseArea' => ['exp','EnterpriseArea+'.$v['HouseArea']],
                                'EnterpriseOprice' => ['exp','EnterpriseOprice+'.$v['OldOprice']],
                                'EnterpriseRent' => ['exp','EnterpriseRent+'.$v['HousePrerent']],
                            ]
                        );
                    break;
        
                    case 3:
                        
                        Db::name('ban')->where('BanID',$v['BanID'])->update(
                            [
                                'PartyArea' => ['exp','PartyArea+'.$v['HouseArea']],
                                'PartyOprice' => ['exp','PartyOprice+'.$v['OldOprice']],
                                'PartyRent' => ['exp','PartyRent+'.$v['HousePrerent']],
                            ]
                        );
                    break;

                }

                Db::name('ban')->where('BanID',$v['BanID'])->update(
                        [
                            'TotalArea' => ['exp','TotalArea+'.$v['HouseArea']],
                            'TotalOprice' => ['exp','TotalOprice+'.$v['OldOprice']],
                            'PreRent' => ['exp','PreRent+'.$v['HousePrerent']],
                            'BanUsearea' => ['exp','BanUsearea+'.$v['HouseUsearea']],
                        ]
                    );
                    

                Db::name('house')->where('HouseID',$findOne['HouseID'])->update(['Status'=>1]);

                $v = Db::name('house')->where('HouseID',$findOne['HouseID'])->find();


                Db::name('room')->where('HouseID',$findOne['HouseID'])->setField('Status',1);

                if($v['TenantID']){
                    Db::name('tenant')->where('TenantID',$v['TenantID'])->setField('Status',1);
                }

                $str1 = "('" . $v['HouseID'] . "','" . $v['TenantID'] . "'," . $v['InstitutionID'] . "," . $v['InstitutionPID']."," . $v['HousePrerent'] . "," . $v['DiffRent'] . "," . $v['PumpCost'] . ",0,0,'" . $v['TenantName'] . "','" . $v['BanAddress'] . "'," . $v['OwnerType'] . "," . $v['UseNature'] .",1," . $v['HousePrerent'] . "," . $v['HousePrerent'] . ",0," . UID . "," . time() . "),";

                Db::execute("insert into ".config('database.prefix')."rent_config (HouseID ,TenantID ,InstitutionID,InstitutionPID,HousePrerent,DiffRent,PumpCost,CutType,CutRent,TenantName,BanAddress,OwnerType,UseNature,IfPre,ReceiveRent,UnpaidRent,HistoryUnpaidRent,CreateUserID,CreateTime) values " . rtrim($str1, ','));

                Db::execute("insert into ph_rent_order (HouseID ,BanAddress,InstitutionPID,InstitutionID ,OwnerType, UseNature,IfPre,TenantID,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent) (select HouseID ,BanAddress,InstitutionPID,InstitutionID,OwnerType, UseNature,IfPre,TenantID ,TenantName,CutType,CutNumber,CutRent,HousePrerent,DiffRent,PumpCost,ReceiveRent,LateRent,UnpaidRent,HistoryUnpaidRent from ph_rent_config where HouseID = ".$findOne['HouseID'].")");

                Db::execute('update ph_rent_order set OrderDate = "' . date('Ym') . '" , CreateTime = '.time().', CreateUserID = '.UID.',Type = 1, RentOrderID = concat(HouseID ,OwnerType, ' . '"' . date('Ym') . '")  where HouseID = ' . $findOne['HouseID']); 

                $str = "( 7,'". $findOne['ChangeOrderID'] . "'," .$findOne['InstitutionID'] . "," . $findOne['InstitutionPID'] . "," . $findOne['InflRent'] . ", " . $findOne['OwnerType'] . "," . $findOne['UseNature'] . "," . $findOne['OrderDate']. ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                break;

            case 8:  //注销异动完成后的，系统处理
                //$nextMonthDate = date('Y', time());

                $changeFind = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();
                
                $deadline = json_decode($changeFind['Deadline'],true);

                foreach($deadline as $v){
                    switch($changeFind['UseNature']){
                        case 1:
                            Db::name('ban')->where('BanID',$v['banID'])->update(
                                [
                                    'CivilArea' => ['exp','CivilArea-'.$v['houseArea']],
                                    'CivilOprice' => ['exp','CivilOprice-'.$v['housePrice']],
                                    'CivilRent' => ['exp','CivilRent-'.$v['cancelPrent']],
                                    'BanUsearea' => ['exp','BanUsearea-'.$v['cancelHouseUsearea']],
                                ]
                            );
                        break;
                           
                        case 2:
                         
                            Db::name('ban')->where('BanID',$v['banID'])->update(
                                [
                                    'EnterpriseArea' => ['exp','EnterpriseArea-'.$v['houseArea']],
                                    'EnterpriseOprice' => ['exp','EnterpriseOprice-'.$v['housePrice']],
                                    'EnterpriseRent' => ['exp','EnterpriseRent-'.$v['cancelPrent']],
                                ]
                            );
                        break;
            
                        case 3:
                            
                            Db::name('ban')->where('BanID',$v['banID'])->update(
                                [
                                    'PartyArea' => ['exp','PartyArea-'.$v['houseArea']],
                                    'PartyOprice' => ['exp','PartyOprice-'.$v['housePrice']],
                                    'PartyRent' => ['exp','PartyRent-'.$v['cancelPrent']],
                                ]
                            );
                        break;

                    }
                    
                }
                //修改对应的楼栋底下的房屋的状态为注销
                Db::name('house')->where('HouseID', 'eq', $changeFind['HouseID'])->setField('Status', 10);

                $str = "( 8,'".$changeFind['ChangeOrderID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $changeFind['InflRent'] . ", " . $changeFind['OwnerType'] . "," . $changeFind['UseNature'] . "," . $changeFind['OrderDate']. "," . $changeFind['CancelType'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate,CancelType) values " . rtrim($str, ','));
                //修改租金配置表,删除不可用状态房屋对应的租金配置记录
                Db::name('rent_config')->where('HouseID', 'eq', $changeFind['HouseID'])->delete();
                //删除该房屋本月订单
                Db::name('rent_order')->where(['HouseID'=> ['eq', $changeFind['HouseID']],'OrderDate'=>['eq',date('Ym',time())]])->delete();
                break;

            case 9:  //房屋调整异动完成后的，系统处理
                $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();
                $arr = json_decode($oneData['Deadline'],true);
                foreach($arr as $a){
                    switch($oneData['UseNature']){
                        case 1:
                            Db::name('ban')->where('BanID',$a['BanID'])->update(
                                [
                                    'CivilArea' => $a['TotalAreaAfter'],
                                    'CivilOprice' => $a['TotalOpriceAfter'],
                                    'CivilRent' => $a['PreRentAfter'],
                                    'BanUsearea' => $a['BanUseareaAfter'],
                                ]
                            );
                        break;
                           
                        case 2:
                         
                            Db::name('ban')->where('BanID',$a['BanID'])->update(
                                [
                                    'EnterpriseArea' => $a['TotalAreaAfter'],
                                    'EnterpriseOprice' => $a['TotalOpriceAfter'],
                                    'EnterpriseRent' => $a['PreRentAfter'],
                                ]
                            );
                        break;
            
                        case 3:
                            
                            Db::name('ban')->where('BanID',$a['BanID'])->update(
                                [
                                    'PartyArea' => $a['TotalAreaAfter'],
                                    'PartyOprice' => $a['TotalOpriceAfter'],
                                    'PartyRent' => $a['PreRentAfter'],
                                ]
                            );
                        break;

                    }

                    Db::name('ban')->where('BanID',$a['BanID'])->update(
                        [
                            'TotalArea' => $a['TotalAreaAfter'],
                            'TotalOprice' => $a['TotalOpriceAfter'],
                            'PreRent' => $a['PreRentAfter'],
                            'BanUsearea' => $a['BanUseareaAfter'],
                        ]
                    );
                }

                // Db::name('house')->where('HouseID',$oneData['HouseID'])->update(['HousePrerent'=>['exp','HousePrerent+'.$oneData['InflRent']]]);
                
                //房屋调整合并到 调整里面，所以是12
                $str = "( 12,'".$oneData['ChangeOrderID']."',".$oneData['InstitutionID'] . "," . $oneData['InstitutionPID'] . "," . $oneData['InflRent'] . ", " . $oneData['OwnerType'] . "," . $oneData['UseNature'] . "," . $oneData['OrderDate'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table ( ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
 
                // //修改租金配置表,删除不可用状态房屋对应的租金配置记录
                // Db::name('rent_config')->where('HouseID', 'eq', $oneData['HouseID'])->update([
                //         'HousePrerent' => ['exp','HousePrerent+'.$oneData['InflRent']],
                //         'ReceiveRent' => ['exp','ReceiveRent+'.$oneData['InflRent']],
                //     ]);
                // //删除该房屋本月订单
                // Db::name('rent_order')->where(['HouseID'=> ['eq', $oneData['HouseID']],'OrderDate'=>['eq',date('Ym',time())]])->update([
                //         'HousePrerent' => ['exp','HousePrerent+'.$oneData['InflRent']],
                //         'ReceiveRent' => ['exp','ReceiveRent+'.$oneData['InflRent']],
                //         'PaidRent' => 0,
                //         'UnpaidRent' => ['exp','ReceiveRent+'.$oneData['InflRent']],
                //         'Type' => 1,
                //     ]);
                
                break;
            case 10:  //管段调整异动完成后的，系统处理 （待完善）
                //修改对应的楼栋所属的管段，注意此时关联到，该楼栋下所有的房屋，房间对应的所属管段机构的相应调整
                $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('BanID,HouseID,NewInstitutionID')->find();
                $pid = Db::name('institution')->where('id', 'eq', $oneData['NewInstitutionID'])->value('pid');
                $map['InstitutionID'] = $pid;
                $map['TubulationID'] = $oneData['NewInstitutionID'];
                $maps['InstitutionPID'] = $pid;
                $maps['InstitutionID'] = $oneData['NewInstitutionID'];
                if ($oneData['BanID']) {
                    Db::name('ban')->where('BanID', 'eq', $oneData['BanID'])->update($map); //修改楼栋的所属机构
                    Db::name('house')->where('BanID', 'eq', $oneData['BanID'])->update($maps);  //修改楼栋下的房屋的所属机构
                    Db::name('room')->where('BanID', 'eq', $oneData['BanID'])->update($maps);   //修改楼栋下的房间的所属机构
                    $tenantids = Db::name('house')->where('BanID', 'eq', $oneData['BanID'])->column('TenantID');
                    Db::name('tenant')->where('TenantID', 'in', $tenantids)->update($maps);
                    //同时修改租金配置表，换成新的机构id
                    $houseids = Db::name('house')->where('BanID', 'eq', $oneData['BanID'])->column('HouseID');
                    Db::name('rent_config')->where('HouseID', 'in', $houseids)->update($maps);
                }else{
                    Db::name('house')->where('HouseID', 'eq', $oneData['HouseID'])->update($maps);  //修改楼栋下的房屋的所属机构
                    Db::name('rent_config')->where('HouseID', 'eq', $oneData['HouseID'])->update($maps);
                }
                break;

            case 11:  //租金追加调整异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                $houseInfo = Db::name('house')->where('HouseID',$one['HouseID'])->find();

                $st = "('". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',".$houseInfo['HousePrerent'] . "," . $one['OldMonthRent'] . "," . date('Ym',strtotime('-1 month')) . ", " .date('Y',time()) . ", " . date('Ym',time()) . "," . $one['UserNumber'] . "," . time() . "),";

                $st .= "('". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',".$houseInfo['HousePrerent'] . "," . $one['OldYearRent'] . ",'', 2017 , " . date('Ym',time()) . "," . $one['UserNumber'] . "," . time() . "),";

                Db::execute("insert into ".config('database.prefix')."old_rent (HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,PayRent,PayMonth,PayYear,OldPayMonth,CreateUserID,CreateTime) values " . rtrim($st, ','));

                //追收做到调整里面了
                $str = "( 12,'". $one['ChangeOrderID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['OldMonthRent'] . ", " .$one['OldYearRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . $one['OrderDate']. ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,OldMonthRent,OldYearRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;
            case 12:  //租金调整异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                Db::name('house')->where('HouseID', 'eq', $changeFind['HouseID'])->setDec('HousePrerent', $one['InflRent']);

                $str = "( 12,'". $one['ChangeOrderID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . $one['OrderDate']. ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;

            case 13:  //分户异动完成后的，系统处理(分户后的面积，金额处理没做)

                $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,NewHouseID,RoomID')->find();
                Db::name('house')->where('HouseID','eq',$oneData['HouseID'])->setField('Status',1);
                Db::name('house')->where('HouseID','eq',$oneData['NewHouseID'])->setField('Status',1);
                Db::name('room')->where('RoomID','in',explode(',',$oneData['RoomID']))->update(['HouseID'=>$oneData['NewHouseID'],'Status'=>1]);
                $areaArr1 = count_house_area($oneData['NewHouseID']);
                $rentArr1 = count_house_rent($oneData['NewHouseID']);
                Db::name('house')->where('HouseID','eq',$oneData['NewHouseID'])->update(['HouseUsearea'=>$areaArr1['HouseUsearea'],'LeasedArea'=>$areaArr1['LeaseArea'],'ApprovedRent'=>$rentArr1]);
                $areaArr2 = count_house_area($oneData['HouseID']);
                $rentArr2 = count_house_rent($oneData['HouseID']);
                Db::name('house')->where('HouseID','eq',$oneData['HouseID'])->update(['HouseUsearea'=>$areaArr2['HouseUsearea'],'LeasedArea'=>$areaArr2['LeaseArea'],'ApprovedRent'=>$rentArr2]);
                break;

            case 14:  //楼栋调整异动完成后的，系统处理(并户后的面积，金额处理没做)

                $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                $jsons = json_decode($oneData['Deadline'],true);

                if($jsons['afterDamage']){
                    Db::name('ban')->where('BanID',$oneData['BanID'])->update(['DamageGrade'=>$jsons['afterDamage']]);
                }
                if($jsons['afterStructure']){
                    Db::name('ban')->where('BanID',$oneData['BanID'])->update(['StructureType'=>$jsons['afterStructure']]);

                    $roomArr = Db::name('room')->where('BanID',$oneData['BanID'])->column('RoomID,RoomRentMonth');
                    if($roomArr){
                        foreach($roomArr as $room){
                            $roomrent = count_room_rent($k);
                            Db::name('room')->where('RoomID',$k)->setField('RoomRentMonth',$roomrent);
                        }
                        
                    }
                }


                break;

            default:
                break;
        }
    }

    /**
     * 检查是否可执行当前审批 :::  注意如果当前登录账号拥有多角色，例如同时有审批流中的多个角色，程序可能会出现BUG
     * @description  当，审批流程未到此处时，或， 已审批过时
     * @author Mr.Lu
     * @return bool
     */
    public function check_process($changeOrderID)
    {

        $one = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where('a.ChangeOrderID', 'eq', $changeOrderID)
            ->field('a.Status ,b.id ')
            ->find();

        $where['pid'] = array('eq', $one['id']);
        $where['Total'] = array('eq', $one['Status']);

        $roleID = Db::name('process_config')->where($where)->value('RoleID');

        $currentRoles = json_decode(session('user_base_info.role'), true);

        if (!in_array($roleID, $currentRoles)) {
            return false;
        }else{
           return true; 
        }

        
    }

    /**
     * 获取审批流程记录
     * @description  通过主订单编号来获取流程记录，例如：提交，补充资料，审核
     * @author Mr.Lu
     * @return array [  操作人 ，角色名称  ，操作时间 ，操作内容 ]
     */
    public function process_record($changeOrderID)
    {

        //$where['a.ChangeOrderID'] = array('eq' ,$changeOrderID);
        //$where['a.ChangeType'] = array('eq' ,$changeType);

        //获取，当前审批流程的名称、总步骤数、提交资料人员id ，提交时间
        $process = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where('a.ChangeOrderID', 'eq', $changeOrderID)
            ->field('b.Total, b.Title , b.id ,a.Status ,a.UserNumber ,a.CreateTime')
            ->find();

        $where['pid'] = array('eq', $process['id']);
        $where['Total'] = array('eq', 1);

        $one = Db::name('process_config')->where($where)->field('RoleName ,Title')->find();

        $first['UserNumber'] = Db::name('admin_user')->where('Number', 'eq', $process['UserNumber'])->value('UserName');

        $first['CreateTime'] = date('Y-m-d H:i:s', $process['CreateTime']);

        $first['Reson'] = '';

        $first['RoleName'] = $one['RoleName'];

        $first['Step'] = $one['Title'];

        $first['Status'] = 2;

        //获取，所有子订单的，机构id，状态，理由，用户编号，审核时间： 注意在使用权变更中补充资料视为审核
        $record = Db::name('use_child_order')->where('FatherOrderID', 'eq', $changeOrderID)
            ->field('Status ,Step ,Reson ,UserNumber ,CreateTime')
            ->order('CreateTime asc')
            ->select();

        foreach ($record as $k3 => &$v3) {

            $map['pid'] = array('eq', $process['id']);
            $map['Total'] = array('eq', $v3['Step']);

            if ($v3['Status'] == 3) {
                $v3['Status'] = '不通过';
            }

            $v3['Step'] = Db::name('process_config')->where($map)->value('Title');  //操作内容
            $v3['RoleName'] = Db::name('process_config')->where($map)->value('RoleName');  //角色名称
            $v3['UserNumber'] = Db::name('admin_user')->where('Number', 'eq', $v3['UserNumber'])->value('UserName'); //操作人
            $v3['CreateTime'] = date('Y-m-d H:i:s', $v3['CreateTime']);
        }

        array_unshift($record, $first);

        return $record;
    }

    /**
     * 获取变更编号的url路径信息
     * @description  通过主订单编号来获取
     * @author Mr.Lu
     * @return array [ config 配置信息， status 现在进行到哪一个  ]
     */
    public function process_imgs_url($changeOrderID)
    {

        $where['ChangeOrderID'] = array('eq', $changeOrderID);
        //$where['ChangeType'] = array('eq' ,$changeType);

        $IDS = Db::name('change_order')->where($where)->value('ChangeImageIDS');
        $images = explode(',', $IDS);

        if (!$images) {

            jsons('4004', '请先上传相关图片');
        }

        $urls = Db::name('upload_file')->where('id', 'in', $images)->field('FileUrl ,FileTitle')->select();

        return $urls;

    }

    /**
     * 获取审批流程状态
     * @description  通过主订单编号来获取流程配置，和当前流程状态
     * @author Mr.Lu
     * @return array [ config 配置信息， status 现在进行到哪一个  ]
     */
    public function process_status($changeOrderID)
    {

        $wheres['a.ChangeOrderID'] = array('eq', $changeOrderID);
        //$wheres['a.ChangeType'] = array('eq' ,$changeType);

        $process = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where($wheres)
            ->field('b.Total, b.id ,a.Status')
            ->find();

        $datas['config'] = Db::name('process_config')->where('pid', 'eq', $process['id'])
            ->order('Total asc')
            ->column('RoleName');

        $datas['status'] = $process['Status'] - 1;

        return $datas;

    }

    /**
     * 获取新发租的一些详情
     * @description  房屋编号、租户、房屋状态；房屋编号、房间编号、房间状态
     * @author Mr.Lu
     * @return array
     */
    public function get_new_rent_detail($changeOrderID)
    {
        $statusArr = ['未确认', '正常', '修改中', '异动中', '删除中'];

        $findOne = Db::name('change_order')->field('HouseID,BanID')->where('ChangeOrderID', $changeOrderID)->find();

        if ($findOne['HouseID']) { //如果是新发租的房屋
            $houseFind = Db::name('house')->field('HouseID,TenantName,Status')->where('HouseID', $findOne['HouseID'])->find();

            $houseFind['Status'] = $statusArr[$houseFind['Status']];
            $result['house'][] = $houseFind;

            $roomData = Db::name('room')->field('RoomID,Status')->where(['HouseID'=>['like', '%' . $findOne['HouseID'] . '%'],'Status'=>['eq',3]])->select();
            foreach ($roomData as $roomv) {
                $result['room'][] = [
                    'HouseID' => $findOne['HouseID'],
                    'RoomID' => $roomv['RoomID'],
                    'Status' => $statusArr[$roomv['Status']],
                ];
            }

        } else { //如果是新发租的楼栋

            $houseDatas = Db::name('house')->where('BanID', $findOne['BanID'])->field('HouseID,TenantName,Status')->select();

            foreach ($houseDatas as $houses) {
                $houses['Status'] = $statusArr[$houses['Status']];
                $result['house'][] = $houses;
            }

            $roomDatas = Db::name('room')->where('BanID', $findOne['BanID'])->field('RoomID,HouseID,Status')->select();

            foreach ($roomDatas as $roomvs) {

                $result['room'][] = [
                    'HouseID' => $roomvs['HouseID'],
                    'RoomID' => $roomvs['RoomID'],
                    'Status' => $statusArr[$roomvs['Status']],
                ];
            }
        }
        return isset($result)?$result:[];
    }
}