<?php


namespace app\ph\model;

use think\Model;
use think\Exception;
use think\Loader;
use app\ph\model\BanInfo as BanInfoModel;
use app\ph\model\HouseInfo as HouseInfoModel;
use app\ph\model\TenantInfo as TenantInfoModel;
use think\paginator\driver\Bootstrap;
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
        $currentRoleIDS = json_decode(session('user_base_info.role'));

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

        if ($searchForm = input('param.')) {

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
            if ($searchForm['InflRent']) {  //检索变更类型
                $where['InflRent'] = array('eq', $searchForm['InflRent']);
            }
            if ($searchForm['UserName']) {  //检索操作人名称
                $where['UserName'] = array('like', '%' . $searchForm['UserName'] . '%');
            }

            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){

                $c = substr_count($searchForm['CreateTime'],'-');
                
                $starttime = strtotime($searchForm['CreateTime']);

                if($c == 2){
                    $endtime = $starttime + 3600*24;
                }elseif($c == 1){
                    $endtime = $starttime + 3600*24*30;
                }else{
                    $endtime = $starttime + 3600*24*365;
                }             

                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }

        }
//halt($where);
        $where['Status'] = array('not in', [0, 1]);

        $ChangeList['obj'] = self::field('id')->where($where)->order('CreateTime asc')->paginate(config('paginate.list_rows'));
        $ChangeList['InflRentSum'] = self::field('id')->where($where)->sum('InflRent');
        $arr = self::field('id')->where($where)->order('CreateTime asc')->select();
        $s = $sr = [];
        foreach($arr as $d){
            $reone = self::get_one_change_info($d['id']);
            //halt($currentRoleID);
            if(in_array($reone['ProcessRoleID'],$currentRoleIDS)){
                $s[] = $reone;
            }else{
                $sr[] = $reone;
            }

            //halt($reone);
        }
        $sresult = array_merge($s , $sr);
        if($sresult){
            //$data = array();
            $curpage = input('page') ? input('page') : 1;//当前第x页，有效值为：1,2,3,4,5...
            $listRow = 15;//每页215行记录
            //$showdata = array_chunk($s, $listRow, true);
            $showdata = array_slice($sresult, ($curpage - 1)*$listRow, $listRow,true);
            
            $p = Bootstrap::make($showdata, $listRow, $curpage, count($sresult), false, [
                'var_page' => 'page',
                'path'     => url('/ph/ChangeAudit/index'),//这里根据需要修改url
                'query'    => [],
                'fragment' => '',
            ]);
            
            $p->appends($_GET);
            $ChangeList['arr'] = $showdata;
            $ChangeList['obj'] = $p;

        }else{
            $arr = $ChangeList['obj']->all();
            if (!$arr) {
                $ChangeList['arr'] = array();
            }
            foreach ($arr as $v) {
                $ChangeList['arr'][] = self::get_one_change_info($v['id']);
            } 
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
            case 15:     //  租金调整(批量)
                $data = self::get_fifteen_detail($changeOrderID);
                break;
            case 16:     //  租金调整(批量)
                $data = self::get_sixteen_detail($changeOrderID);
                break;
            case 17:     //  租金调整(批量)
                $data = self::get_seventeen_detail($changeOrderID);
                break;
            case 18:     //  楼栋注销
                $data = self::get_eighteen_detail($changeOrderID);
                break;
            default:
        }

        return $data;
    }

    public function get_one_detail($changeOrderID)
    {  //获取租金减免的详情

        $oneData = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('InflRent,HouseID,TenantID,Remark,CreateTime')->find();

        $data = get_house_info($oneData['HouseID']);

        $datas = Db::name('rent_cut_order')->alias('a')
            ->join('cut_rent_type b', 'a.CutType = b.id', 'left')->where('ChangeOrderID', 'eq', $changeOrderID)
            ->field('b.CutName ,a.IDnumber,a.MuchMonth,a.CutType')
            ->find();
        $cuttypes = Db::name('cut_rent_type')->column('id,CutName');
        $CutYearRecord = Db::name('change_cut_year')->where(['ChangeOrderID'=>$changeOrderID])->select();
        foreach($CutYearRecord as &$v){
            $v['urls'] = Db::name('upload_file')->where('id', 'in', $v['ChangeImageIDS'])->field('FileUrl ,FileTitle')->select();
            $v['CutType'] = $cuttypes[$v['CutType']];
        }

        $data['CutYearRecord'] = $CutYearRecord;
        $data['Remark'] = $oneData['Remark'];
        $data['InflRent'] = $oneData['InflRent'];
        $data['CutName'] = $datas['CutName'];
        $data['CutType'] = $datas['CutType'];
        $data['IDnumber'] = $datas['IDnumber'];
        $data['MuchMonth'] = $datas['MuchMonth'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['TenantID'] = $oneData['TenantID'];
        // $tenantInfo = Db::name('tenant')->where(['TenantID'=>['eq',$oneData['TenantID']]])->find();
        // if($tenantInfo){
        //    $data['TenantName'] = $tenantInfo['TenantName']; 
        //    $data['TenantTel'] = $tenantInfo['TenantTel']; 
        //    $data['TenantNumber'] = $tenantInfo['TenantNumber']; 
        //    //$data['TenantName'] = $tenantInfo['TenantName']; 
        // }
        
        $data['type'] = 1;

        // $IDS = Db::name('change_order')->where($where)->value('ChangeImageIDS');
        // $images = explode(',', $IDS);

        // if (!$images) {
        //     jsons('4004', '请先上传相关图片');
        // }
        // $urls = Db::name('upload_file')->where('id', 'in', $images)->field('FileUrl ,FileTitle')->select();


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
        return '';
    }

    public function get_seven_detail($changeOrderID)
    {   

        //新发租
        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('HouseID,Remark,NewLeaseType,CreateTime')->find();

        $data = get_house_info($oneData['HouseID']);
        $data['NewLeaseType'] = Db::name('new_lease_type')->where('id', 'eq', $oneData['NewLeaseType'])->value('Title');
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
        $houseInfo = Db::name('house')->where('HouseID',$one['HouseID'])->find();

        /*if($one['OldMonthRent']){
            $order_date = getlastMonthDays($one['OrderDate']);
            //$order_date = '202003';
            $rent_order_id = $one['HouseID'].$one['OwnerType'].$order_date;
            
            $HousePrerent = $one['OldMonthRent'];
            $stt = "";
            $stt = "('". $rent_order_id . "','". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',". $HousePrerent . "," . $HousePrerent . "," . $HousePrerent. ",2," .$order_date . "," . $one['UserNumber'] . "," . time() . "),";
            Db::execute("insert into ".config('database.prefix')."rent_order (RentOrderID,HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,ReceiveRent,UnpaidRent,Type,OrderDate,CreateUserID,CreateTime) values " . rtrim($stt, ','));
        }
        if($one['OldYearRent']){
            $order_date = (substr($one['OrderDate'],0,4) - 1).'12';
            //halt($order_date);
            //$order_date = '202003';
            $rent_order_id = $one['HouseID'].$one['OwnerType'].$order_date;
            
            $HousePrerent = $one['OldYearRent'];
            $stt = "";
            $stt = "('". $rent_order_id . "','". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',". $HousePrerent . "," . $HousePrerent . "," . $HousePrerent. ",2," .$order_date . "," . $one['UserNumber'] . "," . time() . "),";
            Db::execute("insert into ".config('database.prefix')."rent_order (RentOrderID,HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,ReceiveRent,UnpaidRent,Type,OrderDate,CreateUserID,CreateTime) values " . rtrim($stt, ','));
        }*/
        
        $data = get_house_info($one['HouseID']);
        $data['OldYearRent'] = $one['OldYearRent'];
        $data['OldMonthRent'] = $one['OldMonthRent'];
        $data['Remark'] = $one['Remark'];
        $data['IfTakeBack'] = $one['IfTakeBack'];
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
        $data['afterAdjustadd'] = isset($jsons['afterAdjustadd'])?$jsons['afterAdjustadd']:'';
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

    public function get_fifteen_detail($changeOrderID)
    {
        //房屋编号
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();

        $data = get_ban_info($one['BanID']);

        $deadline = json_decode($one['Deadline'],true);

        $data['InstitutionPID'] = get_institution($one['InstitutionPID']);
        $data['ChangeOrderID'] = $one['ChangeOrderID'];
        $data['Qrcode'] = $one['RoomID'];
        $data['Remark'] = $one['Remark'];
        $data['InflRent'] = $one['InflRent'];
        $data['TotalChangeNum'] = count($deadline['houseArr']);
        $data['Deadline'] = $deadline;

        $data['type'] = 15;

        return $data;
    }

    public function get_sixteen_detail($changeOrderID)
    {
        //房屋编号
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();

        $data = get_ban_info($one['BanID']);

        $deadline = json_decode($one['Deadline'],true);

        $data['InstitutionPID'] = get_institution($one['InstitutionPID']);
        $data['ChangeOrderID'] = $one['ChangeOrderID'];
        $data['Qrcode'] = $one['RoomID'];
        $data['Remark'] = $one['Remark'];
        $data['InflRent'] = $one['InflRent'];
        $data['TotalChangeNum'] = count($deadline['houseArr']);
        $data['Deadline'] = $deadline;

        $data['type'] = 16;

        return $data;
    }

    public function get_seventeen_detail($changeOrderID)
    {
        //房屋编号
        $one = self::where('ChangeOrderID', 'eq', $changeOrderID)->find();

        $data = get_ban_info($one['BanID']);

        $deadline = json_decode($one['Deadline'],true);

        $data['InstitutionPID'] = get_institution($one['InstitutionPID']);
        $data['ChangeOrderID'] = $one['ChangeOrderID'];
        $data['Qrcode'] = $one['RoomID'];
        $data['Remark'] = $one['Remark'];
        $data['InflRent'] = $one['InflRent'];
        $data['TotalChangeNum'] = count($deadline['houseArr']);
        $data['Deadline'] = $deadline;

        $data['type'] = 17;

        return $data;
    }

    public function get_eighteen_detail($changeOrderID)
    {   
        //楼栋注销
        $oneData = self::where('ChangeOrderID', 'eq', $changeOrderID)->field('BanID,Remark,CancelType,Deadline,CreateTime')->find();
        $data = get_ban_info($oneData['BanID']);
        $data['House'] = json_decode($oneData['Deadline']);
        $data['Remark'] = $oneData['Remark'];
        $data['OrderCreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);
        $data['type'] = 18;


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

    //创建一个子订单，例如（补充资料完成，每次审核完成 ，$isfail 0打回，1不通过，2通过
    public function create_child_order($changeOrderID, $reson = '',$isfail = 0)
    {   //此处有别与使用权变更，不通过打回的时候直接进入记录

        //获取流程总人数
        $total = Db::name('change_order')->alias('a')
            ->join('process_config b', 'a.ProcessConfigType = b.id', 'left')
            ->where('a.ChangeOrderID', 'eq', $changeOrderID)
            ->value('Total');

        $where['ChangeOrderID'] = array('eq', $changeOrderID);

        $option['FatherOrderID'] = array('eq', $changeOrderID);
        $option['IfValid'] = array('eq', 1);
        // $step = Db::name('use_child_order')->where($option)->max('Step');
        $step = Db::name('use_child_order')->where($option)->order('id desc')->value('Step');

        if (!$step) {
            $datas['Step'] = 2;
        } else {
            $datas['Step'] = $step + 1;
        }

        //判断当前流程，，通过比对当前进行到第几步和流程总步数，来确定是否为终审
        $status = self::where($where)->value('Status');

       //dump($isfail);dump($status);halt($total);
        //若审核不通过
        if ($isfail == 0) {
            //终审不通过则状态改为 0
            self::where($where)->update(['Status' => 2]);
            $datas['Status'] = 3;
            $datas['Step'] = 2;
        } elseif ($status < $total && $isfail == 2) {
            self::where($where)->setInc('Status', 1); //步骤递进
            $datas['Status'] = 2;
        //若审核不通过
        } elseif ($reson != '' && $isfail == 1) {

            //终审不通过则状态改为 0
            self::where($where)->update(['Status' => 0, 'FinishTime' => time()]);

            $datas['Status'] = 3;
            $datas['Step'] = 2;

        // 若终审通过
        } elseif ($status == $total && $reson == '' && $isfail != 0) {

            $changeType = self::where($where)->value('ChangeType');
model('ph/ChangeAudit')->after_process($changeOrderID, $changeType);
        // try {
        //     //终审通过后，系统直接将对应的数据修改为异动后的数据
        //     model('ph/ChangeAudit')->after_process($changeOrderID, $changeType);  //终审通过后，系统直接更改相关的
        // } catch (\Exception $e) {
        //     // 这是进行异常捕获
        //     return jsons('4001','未知错误！');
        // }
            

            //终审通过则状态改为  1,并写入最终通过时间
            self::where($where)->update(['Status' => 1, 'FinishTime' => time(),'OrderDate'=> date('Ym')]);

            $datas['Status'] = 2;

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

                //删除之前过期的减免统计
                Db::name('rent_table')->where(['ChangeType'=>['eq',1],'HouseID'=>$one['HouseID']])->delete();

                $str = "( 1,'". $one['ChangeOrderID'] . "','" .$one['HouseID']. "','" .$one['BanID'] . "',".$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent']. ", " . $one['CutType'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). "," . $one['DateEnd'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,CutType,OwnerType,UseNature,OrderDate,DateEnd) values " . rtrim($str, ','));

                break;
            case 2:  //空租异动完成后的，系统处理

                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();
                
                Db::name('house')->where('HouseID', 'eq', $one['HouseID'])->update(['IfEmpty' => 1]);
   
                $str = "( 2,'". $one['ChangeOrderID'] . "','" .$one['HouseID']. "','" .$one['BanID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()) .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                
                break;

            case 3:  //暂停计租异动完成后的，系统处理

                $houseModel = new HouseInfoModel;

                //修改对应的房屋的状态为暂停计租
                $changeFind = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->field('ChangeOrderID,HouseID,BanID,OrderDate,ChangeType')->find();

                $arr = explode(',',$changeFind['HouseID']);
                if(strpos($changeFind['HouseID'],',')){
                    
                    $houseModel->where('HouseID', 'in', $arr)->setField('IfSuspend', 1);
                    $housearr = $houseModel->where('HouseID', 'in', $arr)->field('HouseID,InstitutionID,InstitutionPID,BanID,HousePrerent,OwnerType,UseNature')->select();

                    $str = '';
                    foreach($housearr as $v){
                        $str .= "('" .$changeFind['ChangeOrderID'] . "','". $v['HouseID'] . "','". $changeFind['BanID']."',". $changeFind['ChangeType'] . ",". $v['InstitutionID'] . "," . $v['InstitutionPID'] . "," . $v['HousePrerent'] . ", " . $v['OwnerType'] . "," . $v['UseNature'] . "," . date('Ym',time()). "),";
                    }

                }else{
                    $houseModel->where('HouseID', 'eq', $changeFind['HouseID'])->setField('IfSuspend', 1);
                    $housearr = $houseModel->where('HouseID', 'eq', $changeFind['HouseID'])->field('InstitutionID,InstitutionPID,HousePrerent,OwnerType,UseNature')->find();
                    $str = "('" . $changeFind['ChangeOrderID'] . "','". $changeFind['HouseID']. "','". $changeFind['BanID']. "',".$changeFind['ChangeType'] . ",". $housearr['InstitutionID'] . "," . $housearr['InstitutionPID'] . "," . $housearr['HousePrerent'] . ", " . $housearr['OwnerType'] . "," . $housearr['UseNature'] . "," . date('Ym',time()). ")";
                }

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeOrderID,HouseID,BanID,ChangeType,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                // 3、修改租金配置表,删除不可用状态房屋对应的租金配置记录
                Db::name('rent_config')->where('HouseID', 'in', $arr)->delete();
                
                // 5、删除该房屋本月订单
                Db::name('rent_order')->where(['HouseID'=> ['in', $arr],'OrderDate'=>['eq',date('Ym')]])->delete();
                
                // 6、自动取消减免
                Db::name('rent_table')->where(['HouseID'=>['in',$changeFind['HouseID']],'ChangeType'=>1,'InflRent'=>['>',0]])->update(['InflRent'=>0,'DateEnd'=>date('Ym')]);

                // 7、自动取消减免
                Db::name('change_order')->where(['HouseID'=>['in',$changeFind['HouseID']],'ChangeType'=>1,'InflRent'=>['>',0]])->update(['DateEnd'=>date('Ym')]);

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
                        // Db::name('rent_order')->where(['HouseID'=>$one['HouseID'],'OrderDate'=>$arr[$v]])->update([
                        //         'PaidRent' => ['exp','ReceiveRent'],
                        //         'UnpaidRent' => 0,
                        //         'Type' => 3,
                        // ]);
                        Db::name('rent_order')->where(['HouseID'=>$one['HouseID'],'OrderDate'=>$arr[$v]])->delete();
                    }    
                }
                Db::name('rent_order')->where(['HouseID'=>$one['HouseID'],'OrderDate'=>['<',date('Y').'00']])->delete();
                //Db::name('house')->where('HouseID',$one['HouseID'])->setDec('ArrearRent',$one['OldYearRent']);

                $str = "( 4,'". $one['ChangeOrderID'] . "','". $one['HouseID']. "','". $one['BanID']. "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['OldMonthRent'] . ", " . $one['OldYearRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,OldMonthRent,OldYearRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;
            case 5:  //房改异动完成后的，系统处理
                //修改对应的房屋的状态为注销
                $houseID = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->value('HouseID');
                Db::name('house')->where('HouseID', 'eq', $houseID)->setField('Status', 100); //为历史数据，不可用状态
                Db::name('room')->where('HouseID', 'eq', $houseID)->setField('Status', 100);  //1000为历史数据，不可用状态
                //修改租金配置表,删除不可用状态房屋对应的租金配置记录
                // Db::name('rent_config')->where('HouseID', 'eq', $houseID)->delete();
                break;

            case 6:  //维修异动完成后的，系统处理
                
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
                                'BanUsearea' => ['exp','BanUsearea+'.$v['LeasedArea']],
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
                            //'BanUsearea' => ['exp','BanUsearea+'.$v['HouseUsearea']],
                        ]
                    );
                    

                Db::name('house')->where('HouseID',$findOne['HouseID'])->update(['Status'=>1]);

                $v = Db::name('house')->where('HouseID',$findOne['HouseID'])->find();


                Db::name('room')->where('HouseID',$findOne['HouseID'])->setField('Status',1);

                if($v['TenantID']){
                    Db::name('tenant')->where('TenantID',$v['TenantID'])->setField('Status',1);
                }

                // 增加当前新发房屋的租金配置
                model('ph/RentCount')->configOne($findOne['HouseID']);
                // 增加当前新发房屋的租金订单
                model('ph/RentCount')->addOne($findOne['HouseID']);

                // 插入到统计表中
                $str = "( 7,'". $findOne['ChangeOrderID'] . "','" .$findOne['HouseID']. "','" .$findOne['BanID']. "'," .$findOne['InstitutionID'] . "," .$findOne['NewLeaseType'] . "," . $findOne['InstitutionPID'] . "," . $findOne['InflRent'] . "," . $v['HouseArea'] ."," . $v['LeasedArea'] ."," . $v['OldOprice'] .", " . $findOne['OwnerType'] . "," . $findOne['UseNature'] . "," . date('Ym',time()). ")";
                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,NewLeaseType,InstitutionPID,InflRent,Area,UseArea,Oprice,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));
                break;

            case 8:  //注销异动完成后的，系统处理
                //$nextMonthDate = date('Y', time());

                $changeFind = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find(); 
                $deadline = json_decode($changeFind['Deadline'],true);

                // 1、处理对楼栋的影响
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
                    Db::name('ban')->where('BanID',$v['banID'])->update(
                        [
                            'TotalArea' => ['exp','TotalArea-'.$v['houseArea']],
                            'TotalOprice' => ['exp','TotalOprice-'.$v['housePrice']],
                            'PreRent' => ['exp','PreRent-'.$v['cancelPrent']],
                        ]
                    );
                    
                }
                // 2、修改对应的楼栋底下的房屋的状态为注销
                Db::name('house')->where('HouseID', 'eq', $changeFind['HouseID'])->setField('Status', 10);
                Db::name('room')->where('HouseID', 'eq', $changeFind['HouseID'])->setField('Status',10);
                $str = "( 8,'".$changeFind['ChangeOrderID']."','".$changeFind['HouseID']."','".$changeFind['BanID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $changeFind['InflRent'] . ", ". $deadline[0]['houseArea'] . ", ". $deadline[0]['cancelHouseUsearea'] . ", ". $deadline[0]['housePrice'] . ", " . $changeFind['OwnerType'] . "," . $changeFind['UseNature'] . "," . date('Ym',time()). "," . $changeFind['CancelType'] .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,Area,UseArea,Oprice,OwnerType,UseNature,OrderDate,CancelType) values " . rtrim($str, ','));

                // 3、修改租金配置表,删除不可用状态房屋对应的租金配置记录
                Db::name('rent_config')->where('HouseID', 'eq', $changeFind['HouseID'])->delete();
                
                // 4、如果注销的房屋之前有暂停计租，就把暂停计租的金额归0
                $changeorderid = Db::name('change_order')->where(['ChangeType'=>3,'HouseID'=>['like','%'.$changeFind['HouseID'].'%']])->value('ChangeOrderID');
                Db::name('rent_table')->where(['ChangeOrderID'=>$changeorderid,'HouseID'=>['like','%'.$changeFind['HouseID'].'%']])->update(['InflRent'=>0]);
      
                //5、删除该房屋本月订单
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
                                    'CivilArea' => ['exp','CivilArea+'.$a['TotalAreaChange']],
                                    'CivilOprice' => ['exp','CivilOprice+'.$a['TotalOpriceChange']],
                                    'CivilRent' => ['exp','CivilRent+'.$a['PreRentChange']],
                                    'BanUsearea' => ['exp','BanUsearea+'.$a['BanUseareaChange']],
                                ]
                            );
                        break;
                           
                        case 2:
                         
                            Db::name('ban')->where('BanID',$a['BanID'])->update(
                                [
                                    'EnterpriseArea' => ['exp','EnterpriseArea+'.$a['TotalAreaChange']],
                                    'EnterpriseOprice' => ['exp','EnterpriseOprice+'.$a['TotalOpriceChange']],
                                    'EnterpriseRent' => ['exp','EnterpriseRent+'.$a['PreRentChange']],
                                ]
                            );
                        break;
            
                        case 3:
                            
                            Db::name('ban')->where('BanID',$a['BanID'])->update(
                                [
                                    'PartyArea' => ['exp','PartyArea+'.$a['TotalAreaChange']],
                                    'PartyOprice' => ['exp','PartyOprice+'.$a['TotalOpriceChange']],
                                    'PartyRent' => ['exp','PartyRent+'.$a['PreRentChange']],
                                ]
                            );
                        break;

                    }

                    Db::name('ban')->where('BanID',$a['BanID'])->update(
                        [
                            'TotalArea' => $a['TotalAreaAfter'],
                            'TotalOprice' => $a['TotalOpriceAfter'],
                            'PreRent' => $a['PreRentAfter'],
                            //'BanUsearea' => $a['BanUseareaAfter'],
                        ]
                    );

                    //将异动信息加入到产权报表中
                    // if($a['TotalAreaChange'] > 0){
                    //     $str1 = "( 7,'".$oneData['ChangeOrderID']."',".$oneData['InstitutionID'] . "," . $oneData['InstitutionPID'] . ",6, ". $a['TotalAreaChange'] . ", " . $oneData['OwnerType'] . "," . $oneData['UseNature'] . "," . date('Ym',time()) .")";
                    //     Db::execute("insert into ".config('database.prefix')."rent_table ( ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,NewLeaseType,InflRent,OwnerType,UseNature,OrderDate) values " . $str1);
                    // }else if($a['TotalAreaChange'] < 0){
                    //     $str1 = "( 8,'".$oneData['ChangeOrderID']."',".$oneData['InstitutionID'] . "," . $oneData['InstitutionPID'] . ",6," . abs($a['TotalAreaChange']) . ", " . $oneData['OwnerType'] . "," . $oneData['UseNature'] . "," . date('Ym',time()) .")";
                    //     Db::execute("insert into ".config('database.prefix')."rent_table ( ChangeType,ChangeOrderID,InstitutionID,InstitutionPID,CancelType,InflRent,OwnerType,UseNature,OrderDate) values " . $str1);
                    // }

                }

              

                if($oneData['InflRent'] != 0){
                    $findHouse = Db::name('house')->where('HouseID',$oneData['HouseID'])->find();

                    //自动更新房屋规租
                    Db::name('house')->where('HouseID',$oneData['HouseID'])->update(['HousePrerent'=>['exp','HousePrerent+'.$oneData['InflRent']]]);

                    Db::name('rent_config')->where(['HouseID'=> ['eq', $oneData['HouseID']]])->update(['HousePrerent'=>$findHouse['HousePrerent']]);

                    Db::name('rent_order')->where(['HouseID'=> ['eq', $oneData['HouseID']],'OrderDate'=>['eq',date('Ym',time())]])->update(['HousePrerent'=>$findHouse['HousePrerent'],'ReceiveRent'=>['exp','ReceiveRent+'.$oneData['InflRent']],'Type'=>1,'PaidRent'=>0,'UnpaidRent'=>['exp','ReceiveRent+'.$oneData['InflRent']]]);
                }
               
                //房屋调整合并到 调整里面，所以是12
                $str = "( 12,'".$oneData['ChangeOrderID']."','".$oneData['HouseID']."','".$oneData['BanID'] ."',".$oneData['InstitutionID'] . "," . $oneData['InstitutionPID'] . "," . $oneData['InflRent'] ."," . $arr[0]['TotalAreaChange'] .", " . $oneData['OwnerType'] . "," . $oneData['UseNature'] . "," . date('Ym',time()) .")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,Area,OwnerType,UseNature,OrderDate) values " . $str);

                break;
            case 10:  //管段调整异动完成后的，系统处理 （待完善）

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

                if($one['IfTakeBack'] == 1){ //如果已收回
                    $st = "('". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',".$houseInfo['HousePrerent'] . "," . $one['OldMonthRent'] . "," . date('Ym',strtotime('-1 month')) . ", " .date('Y',time()) . ", " . date('Ym',time()) . "," . $one['UserNumber'] . "," . time() . "),";

                    $st .= "('". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',".$houseInfo['HousePrerent'] . "," . $one['OldYearRent'] . ",'', 2017 , " . date('Ym',time()) . "," . $one['UserNumber'] . "," . time() . "),";

                    Db::execute("insert into ".config('database.prefix')."old_rent (HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,PayRent,PayMonth,PayYear,OldPayMonth,CreateUserID,CreateTime) values " . rtrim($st, ','));
                }else{ //没有收回就创建租金欠缴订单
                    if($one['OldMonthRent'] > 0){
                        $order_date = getlastMonthDays($one['OrderDate']);
                        //$order_date = '202003';
                        $rent_order_id = $one['HouseID'].$one['OwnerType'].$order_date;
                        
                        $HousePrerent = $one['OldMonthRent'];
                        $stt = "";
                        $stt = "('". $rent_order_id . "','". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',". $HousePrerent . "," . $HousePrerent . "," . $HousePrerent. ",2," .$order_date . "," . $one['UserNumber'] . "," . time() . "),";
                        Db::execute("insert into ".config('database.prefix')."rent_order (RentOrderID,HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,ReceiveRent,UnpaidRent,Type,OrderDate,CreateUserID,CreateTime) values " . rtrim($stt, ','));
                    }
                    if($one['OldYearRent'] > 0){
                        $order_date = (substr($one['OrderDate'],0,4) - 1).'12';
                        //halt($order_date);
                        //$order_date = '202003';
                        $rent_order_id = $one['HouseID'].$one['OwnerType'].$order_date;
                        
                        $HousePrerent = $one['OldYearRent'];
                        $stt = "";
                        $stt = "('". $rent_order_id . "','". $one['HouseID'] . "'," .$one['OwnerType'] . "," . $one['InstitutionID'] . "," . $one['InstitutionPID'] . ", " .$one['UseNature'] . ", " . $houseInfo['TenantID'] . ",'" . $houseInfo['TenantName'] . "','" . $houseInfo['BanAddress']."',". $HousePrerent . "," . $HousePrerent . "," . $HousePrerent. ",2," .$order_date . "," . $one['UserNumber'] . "," . time() . "),";
                        Db::execute("insert into ".config('database.prefix')."rent_order (RentOrderID,HouseID,OwnerType,InstitutionID,InstitutionPID,UseNature,TenantID,TenantName,BanAddress,HousePrerent,ReceiveRent,UnpaidRent,Type,OrderDate,CreateUserID,CreateTime) values " . rtrim($stt, ','));
                    }
                }
                

                //追收做到调整里面了
                $str = "( 12,'". $one['ChangeOrderID'] . "','" .$one['HouseID']. "','" .$one['BanID']. "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['OldMonthRent'] . ", " .$one['OldYearRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,OldMonthRent,OldYearRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;
            case 12:  //租金调整异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                Db::name('house')->where('HouseID', 'eq', $changeFind['HouseID'])->setDec('HousePrerent', $one['InflRent']);

                $str = "( 12,'". $one['ChangeOrderID'] . "','" .$one['HouseID']. "','" .$one['BanID']. "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $one['InflRent'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). ")";

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

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
                            $roomrent = count_room_rent($room);
                            Db::name('room')->where('RoomID',$room)->setField('RoomRentMonth',$roomrent);
                        }
                        
                    }
                }
                if($jsons['afterAdjustadd']){
                    Db::name('ban')->where('BanID',$oneData['BanID'])->update(['AreaFour'=>$jsons['afterAdjustadd']]);
                    Db::name('house')->where('BanID','eq',$oneData['BanID'])->update(['BanAddress'=>$jsons['afterAdjustadd']]);
                }
                break;
            case 15:  //租金调整(批量)异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                $deadline = json_decode($one['Deadline'],true);

                $str = '';

                foreach($deadline['houseArr'] as $v){
                    Db::name('house')->where('HouseID',$v['HouseID'])->update(['HousePrerent'=>$v['ApprovedRent']]);
                    $str .= "( 12,'". $one['ChangeOrderID'] . "','" .$v['HouseID']. "','" .$one['BanID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $v['Diff'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). "),";
                }

                Db::name('ban')->where('BanID',$one['BanID'])->update(['PreRent'=>['exp','PreRent+'.$one['InflRent']],'CivilRent'=>['exp','CivilRent+'.$one['InflRent']]]);
                
                $url = $this->qrcode();

                Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->update(['RoomID'=>$url]);

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;
                
            case 16:  //租金调整(批量)异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                $deadline = json_decode($one['Deadline'],true);

                $str = '';

                foreach($deadline['houseArr'] as $v){
                    Db::name('house')->where('HouseID',$v['HouseID'])->update(['HousePrerent'=>$v['ApprovedRent']]);
                    $str .= "( 12,'". $one['ChangeOrderID'] . "','" .$v['HouseID'] . "','" .$one['BanID']. "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $v['Diff'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). "),";
                }

                Db::name('ban')->where('BanID',$one['BanID'])->update(['PreRent'=>['exp','PreRent+'.$one['InflRent']],'CivilRent'=>['exp','CivilRent+'.$one['InflRent']]]);
                
                $url = $this->qrcode();

                Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->update(['RoomID'=>$url]);

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;

            case 17:  //租金调整(批量)异动完成后的，系统处理
                $one = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find();

                $deadline = json_decode($one['Deadline'],true);

                $str = '';

                foreach($deadline['houseArr'] as $v){
                    Db::name('house')->where('HouseID',$v['HouseID'])->update(['HousePrerent'=>$v['ApprovedRent']]);
                    $str .= "( 12,'". $one['ChangeOrderID'] . "','" .$v['HouseID']. "','" .$one['BanID'] . "'," .$one['InstitutionID'] . "," . $one['InstitutionPID'] . "," . $v['Diff'] . ", " . $one['OwnerType'] . "," . $one['UseNature'] . "," . date('Ym',time()). "),";
                }

                Db::name('ban')->where('BanID',$one['BanID'])->update(['PreRent'=>['exp','PreRent+'.$one['InflRent']],'CivilRent'=>['exp','CivilRent+'.$one['InflRent']]]);
                
                $url = $this->qrcode();

                Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->update(['RoomID'=>$url]);

                Db::name('ban_change')->where('BanID', 'eq', $one['BanID'])->update(['Status'=>1]);

                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,HouseID,BanID,InstitutionID,InstitutionPID,InflRent,OwnerType,UseNature,OrderDate) values " . rtrim($str, ','));

                break;

            case 18:  //楼栋注销异动完成后的，系统处理
                //$nextMonthDate = date('Y', time());

                $changeFind = Db::name('change_order')->where('ChangeOrderID', 'eq', $changeOrderID)->find(); 
                

                // 1、处理对楼栋的影响
                if($changeFind['Deadline']){
                    $deadline = json_decode($changeFind['Deadline'],true);
                    foreach($deadline['houses'] as $v){
                        Db::name('house')->where('HouseID',$v['house_id'])->update(['Status' => 10]);           
                    }
                }
                

                // 2、修改对应的楼栋底下的房屋的状态为注销
                $row = Db::name('ban')->where('BanID', 'eq', $changeFind['BanID'])->find();

                $str = '';

                if($row['CivilArea'] > 0 || $row['CivilOprice'] > 0 || $row['CivilRent'] > 0 || $row['BanUsearea'] > 0){
                    $str .= "(8,'".$changeFind['ChangeOrderID']."','".$changeFind['BanID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $row['CivilRent'] . ",". $row['CivilArea'] . ",". $row['BanUsearea'] . ",". $row['CivilOprice'] . "," . $changeFind['OwnerType'] . ",1," . date('Ym',time()). "," . $changeFind['CancelType'] .")";
                    //$str .= "( 8,'".$changeFind['ChangeOrderID'] . "','','" .$changeFind['BanID']             ."')";
                }

                if($row['EnterpriseArea'] > 0 || $row['EnterpriseOprice'] > 0 || $row['EnterpriseRent'] > 0){
                    $str .= "( 8,'".$changeFind['ChangeOrderID']."','".$changeFind['BanID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $row['EnterpriseRent'] . ",". $row['EnterpriseArea'] . ",0,". $row['EnterpriseOprice'] . "," . $changeFind['OwnerType'] . ",2," . date('Ym',time()). "," . $changeFind['CancelType'] .")";
                }

                if($row['PartyArea'] > 0 || $row['PartyOprice'] > 0 || $row['PartyRent'] > 0){
                    $str .= "( 8,'".$changeFind['ChangeOrderID']."','".$changeFind['BanID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $row['PartyRent'] . ",". $row['PartyArea'] . ",0, ". $row['PartyOprice'] . "," . $changeFind['OwnerType'] . ",3," . date('Ym',time()). "," . $changeFind['CancelType'] .")";
                }


                Db::name('ban')->where('BanID', 'eq', $changeFind['BanID'])->setField('Status', 10);
                Db::name('room')->where('BanID', 'eq', $changeFind['BanID'])->setField('Status',10);
                // $str .= "( 8,'".$changeFind['ChangeOrderID']."','".$changeFind['HouseID']."','".$changeFind['BanID']."',".$changeFind['InstitutionID'] . "," . $changeFind['InstitutionPID'] . "," . $changeFind['InflRent'] . ", ". $deadline[0]['houseArea'] . ", ". $deadline[0]['cancelHouseUsearea'] . ", ". $deadline[0]['housePrice'] . ", " . $changeFind['OwnerType'] . "," . $changeFind['UseNature'] . "," . date('Ym',time()). "," . $changeFind['CancelType'] .")";
//halt($str);
                Db::execute("insert into ".config('database.prefix')."rent_table (ChangeType,ChangeOrderID,BanID,InstitutionID,InstitutionPID,InflRent,Area,UseArea,Oprice,OwnerType,UseNature,OrderDate,CancelType) values " . rtrim($str, ','));
//exit;
                // // 3、修改租金配置表,删除不可用状态房屋对应的租金配置记录
                // Db::name('rent_config')->where('HouseID', 'eq', $changeFind['HouseID'])->delete();
                
                // // 4、如果注销的房屋之前有暂停计租，就把暂停计租的金额归0
                // $changeorderid = Db::name('change_order')->where(['ChangeType'=>3,'HouseID'=>['like','%'.$changeFind['HouseID'].'%']])->value('ChangeOrderID');
                // Db::name('rent_table')->where(['ChangeOrderID'=>$changeorderid,'InflRent'=>$changeFind['InflRent']])->update(['InflRent'=>0]);
      
                // //5、删除该房屋本月订单
                // Db::name('rent_order')->where(['HouseID'=> ['eq', $changeFind['HouseID']],'OrderDate'=>['eq',date('Ym',time())]])->delete();


                break;

            default:
                break;
        }
    }

    public function qrcode()
    {
        ob_end_clean();

        Loader::import('phpqrcode.phpqrcode', EXTEND_PATH);

        $code = substr(md5(substr(uniqid(),-6)),6).substr(uniqid(),-6);

        $value = 'https://ph.ctnmit.com/erweima_zujin/'.$code;          //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别 
        $matrixPointSize = 6;           //生成图片大小
        $url = '/uploads/qrcode/'.$code.'.png';
        $filename = $_SERVER['DOCUMENT_ROOT'].$url;

        $qrcode = new \QRcode;

        //$qrcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2); 
        $qrcode::png($value,$filename,$errorCorrectionLevel, $matrixPointSize, 2);

        return $url;
    }

    /**
     * 检查是否可执行当前审批
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
        $count = count($record);
        $i = 1;
        foreach ($record as $k3 => &$v3) {

            $map['pid'] = array('eq', $process['id']);
            $map['Total'] = array('eq', $v3['Step']);

            if ($v3['Status'] == 3) {
                $v3['Status'] = '发回';
            }
            if ($process['Status'] == 0 && $i == $count) {
                $v3['Status'] = '不通过';
            }

            $userRow = Db::name('admin_user')->where('Number', 'eq', $v3['UserNumber'])->field('UserName,Role')->find();
            $roleArr = json_decode($userRow['Role'],true);
            $v3['Step'] = Db::name('process_config')->where($map)->value('Title');  //操作内容
            $v3['RoleName'] = Db::name('admin_role')->where('id', 'eq', $roleArr[0])->value('RoleName');  //角色名称
            $v3['UserNumber'] = $userRow['UserName']; //操作人
            $v3['CreateTime'] = date('Y-m-d H:i:s', $v3['CreateTime']);

            $i++;
        }
        //halt($record);
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
        $statusArr = [
            '0'=>'未确认',
            '1'=>'正常', 
            '2'=>'修改中', 
            '3'=>'异动中',
            '4'=>'删除中',
            '10'=>'注销',
            '13'=>'注销',
        ];

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