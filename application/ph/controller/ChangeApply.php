<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class ChangeApply extends Base
{
    public function index(){

        $processLst = model('ph/ChangeApply') -> get_all_process_lst();

        //获取所有完损等级
        $damaLst = model('ph/BanInfo') -> get_all_damage_grade();

        //获取所有产别
        $owerLst = model('ph/BanInfo') -> get_all_owner_type();

        //获取所有使用性质
        $natureLst = model('ph/BanInfo') -> get_all_use_nature();

        //获取所有结构类别
        $structureLst = model('ph/BanInfo') -> get_all_structure_type();

        $this->assign([
            'natureLst' => $natureLst,
            'structureLst' => $structureLst,
            'owerLst'   =>  $owerLst,
            'damaLst'    =>  $damaLst,
            'processLst'  => $processLst['arr'],
            'processLstObj'  => $processLst['obj'],
        ]);

        return $this->fetch();
    }

    /**
     * 注意，接收来的 type值，和流程配置中的 Type值对应
     */
    public function add(){

        if ($this->request->isPost()) {
            $data = $this->request->post();
            //halt($data);
            if(!in_array($data['type'],[1,2,3,4,8,11,12])){
                return jsons('4001','程序正在升级中……');
            }

            $one = model('ph/ChangeApply')->check_apply_table($data);
            
            if (isset($_FILES) && $_FILES) {   //文件上传
                foreach ($_FILES as $k => $v) {
                    $ChangeImageIDS[] = model('ChangeApply')->uploads($v, $k ,$data['type']);
                }
                $ChangeImageIDS = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
            }

            $changeTypes = Db::name('change_type')->column('id,ChangeType');
            $datas['Status'] = 2;
            $datas['UserName'] = session('user_base_info.name');
            $datas['UserNumber'] = UID;
            $datas['CreateTime'] = time();
            $suffix = substr(uniqid(),-6);

            switch ($data['type']) {

                case 1:  //租金减免

                    if($data['RemitRent']){
                        $result['OwnerType'] = $one['OwnerType'];  
                        $result['RemitRent'] = $data['RemitRent'];  
                        if($result['RemitRent'] > $one['HousePrerent']){
                           return jsons('4002','减免金额额度不能超过规定租金'); 
                        }
                    }

                    //从表单传递进来的数据：房屋编号 ，减免类型， 证件号， 证件有效期
                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集
                    $datas['ProcessConfigName'] = $changeTypes[1];  //异动名称
                    $datas['TenantID'] = $one['TenantID']; //当前租户
                    $datas['OwnerType'] = $one['OwnerType']; //产别
                    $datas['UseNature'] = $one['UseNature']; //使用性质
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>1])->order('id desc')->value('id');        //找到最新的流程控制线路
                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'01'.$suffix;   //01代表租金减免
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id
                    $datas['CutType'] = $data['CutType'];  //减免类型
                    $datas['InflRent'] = $data['RemitRent'];  //减免类型
                    $datas['OrderDate'] = date('Ym', time());  //订单期 
                    $datas['DateEnd'] = date('Ym', strtotime($data['validity'].' month'));

                    $result['CutType'] = $data['CutType'];  //减免类型
                    $result['IDnumber'] = $data['IDnumber'];  //证件号码
                    $result['HouseID'] = $data['HouseID'];  //房屋编号
                    $result['TenantID'] = $datas['TenantID'];  //租户编号
                    $result['MuchMonth'] = $data['validity']; //证件过期时间
                    $result['InstitutionID'] = $datas['InstitutionID'];  //机构id
                    $result['InstitutionPID'] = $datas['InstitutionPID'];   //机构父id
                    $result['ChangeOrderID'] = $datas['ChangeOrderID']; //订单编号

                    Db::name('rent_cut_order')->insert($result);
                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 2:  // 空租：目前情况是异动类型和流程控制线路的值相同

                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集

                    if($data['emptyRentType'] == 1){ //新增空租

                    }else{
                        $datas['TenantID'] = $data['TenantID'];
                    }
                    $datas['Remark'] = $data['emptyRentReason'];
                    $datas['ChangeType'] = 2;  //异动类型
                    $datas['OwnerType'] = $one['OwnerType'];  //异动类型
                    $datas['UseNature'] = $one['UseNature'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[2];  //异动名称
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>2])->order('id desc')->value('id');        //找到最新的流程控制线路
                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['OrderDate'] = date('Ym', time());
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'02'.$suffix;   //02代表空租
                    $datas['InstitutionID'] = $one['InstitutionID'];
                    $datas['InstitutionPID'] = $one['InstitutionPID'];


                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 3:  // 暂停计租:目前有两种，一种是按户暂停，另一种是按楼栋，暂时都按照按户暂停

                    $one = Db::name('house')->where(['HouseID'=>['in',$data['houseID']]])
                                            ->field('sum(HousePrerent) as HousePrerents,BanID,OwnerType,InstitutionID, InstitutionPID')
                                            ->find();
                    $suffix = substr(uniqid(),-6);
                    $result['InflRent'] = $one['HousePrerents'];
                    $result['BanID'] = $one['BanID'];
                    $result['Status'] = 2;
                    $result['UserName'] = session('user_base_info.name');
                    $result['UserNumber'] = UID;
                    $result['CreateTime'] = time();
                    $result['HouseID'] = trim(implode(',',$data['houseID']),',');
                    $result['InstitutionID'] = $one['InstitutionID'];
                    $result['InstitutionPID'] = $one['InstitutionPID'];
                    $result['OwnerType'] = $one['OwnerType'];
                    $result['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集
                    $result['ChangeType'] = $data['type'];  //异动类型
                    $result['ProcessConfigName'] = $changeTypes[3];  //异动名称
                    $result['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>3])->order('id desc')->value('id');        //找到最新的流程控制线路

                    if(!$result['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $result['OrderDate'] = date('Ym', time());
                    $result['ChangeOrderID'] = date('YmdHis', time()).'03'.$suffix;   //03代表暂停计租

                    $res = Db::name('change_order')->insert($result);

                
                    break;

                case 4:  // 陈欠核销,按户来，核销掉一段时间的账目
//halt($data);
                    
                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['Remark'] = $data['oldCancelReason'];  //异动缘由
                    $datas['Deadline'] = $data['oldCancelMonthBefore'];  //异动缘由
                    $datas['OldMonthRent'] = $data['cancel_money'];  //核销的以前月的金额
                    $datas['OldYearRent'] = $data['oldCancelYearBefore'];  //核销的以前年的金额
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集

                    $datas['TenantID'] = Db::name('house')->where('HouseID' ,'eq' ,$data['HouseID'])->value('TenantID');  //当前租户

                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>4])->order('id desc')->value('id');        //找到最新的流程控制线路

                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['OrderDate'] = date('Ym', time());
                    $datas['ChangeType'] = $data['type'];   //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[4];  //异动名称
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'04'.$suffix;   //04代表陈欠核销
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id

                    $res = Db::name('change_order')->insert($datas);
                    break;

                case 5:  // 房改

                    $datas['HouseID'] = $data['HouseID'];  //房屋编号

                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集

                    $datas['TenantID'] = Db::name('house')->where('HouseID' ,'eq' ,$data['HouseID'])->value('TenantID');  //当前租户

                    $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('InstitutionPID ,InstitutionID,OwnerType,UseNature')->find();

                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];
                    $datas['ProcessConfigType'] = 5;        //流程控制线路
                    $datas['ChangeType'] = $data['type'];   //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[5];  //异动名称
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'05'.$suffix;   //04代表陈欠核销
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id

                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 6:  // 维修 ，此处只有楼栋维修才进入此异动

                    $datas['BanID'] = $data['BanID'];  //楼栋编号
                    $result['RepairReson'] = $data['changeReason'];  //维修理由
                    $result['RepairType'] = $data['repairType'];  //维修类型
                    $result['UseNature'] = $data['useProp'];  //楼栋使用性质
                    $result['OwnerType'] = $data['proCate'];  //楼栋产别
                    $result['BanUnitNum'] = $data['NumOfBuild'];  //单元数
                    $result['StructureType'] = $data['BuildStructure'];  //楼栋结构类别
                    $result['DamageGrade'] = $data['LossLevel'];  //楼栋完损等级
                    $result['CoveredArea'] = $data['CoversArea'];  //楼栋占地面积
                    $result['TotalArea'] = $data['BuildArea'];  //楼栋建筑面积
                    $result['BanFloorNum'] = $data['level'];  //楼层数

                    $OldData = Db::name('ban')->where('BanID' ,'eq' ,($data['BanID']))
                        ->field('OwnerType as OldOwnerType,StructureType as OldStructureType,UseNature as OldUseNature,TotalArea as OldTotalArea,CoveredArea as OldCoveredArea,DamageGrade as OldDamageGrade,BanFloorNum as OldBanFloorNum,BanUnitNum as OldBanUnitNum')
                        ->find();

                    $result = array_merge($result,$OldData);

                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集
                    $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID')->find();
                    $datas['InstitutionID'] = $one['TubulationID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionID'];   //机构父id

                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[6];  //异动名称
                    $datas['ProcessConfigType'] = 6;   //流程控制线路
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'06'.$suffix;   //06代表维修

                    $result['ChangeOrderID'] = $datas['ChangeOrderID'];

                    $result = Db::name('repair_change_order')->insert($result);

                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 7:  // 新发租  1空租新发租，2接管，3还建，4新建，5合建，6加改扩，7加建，8扩建，9,其他

                    //halt($data);ban_temp
                    if(isset($data['BanID'])){
                        $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('OwnerType,InstitutionID ,TubulationID,UseNature')->find();
                        $oldTotalArea = Db::name('ban_temp')->where('BanID', 'eq', $data['BanID'])->value('TotalArea');
                        if(!$one) {return jsons('4004','楼栋编号不存在');}
                        $datas['OwnerType'] = $one['OwnerType']; //产别
                        $datas['UseNature'] = $one['UseNature'];
                        $datas['InstitutionID'] = $one['TubulationID'];  //机构id
                        $datas['InstitutionPID'] = $one['InstitutionID'];   //机构父id
                        $datas['AddRent'] = $oldTotalArea;
                        
                    }else{
                        $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('OwnerType,InstitutionPID ,InstitutionID,UseNature')->find();
                        $oldTotalArea = Db::name('house')->alias('a')->join('ban_temp b','a.BanID = b.BanID','left')->where('HouseID', 'eq', $data['HouseID'])->value('TotalArea');
                        if(!$one) {return jsons('4004','房屋编号不存在');}
                        $datas['OwnerType'] = $one['OwnerType']; //产别
                        $datas['UseNature'] = $one['UseNature'];
                        $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                        $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id
                        $datas['AddRent'] = $oldTotalArea;
                        // Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->setField('Status',3);
                        Db::name('house')->alias('a')->join('ban b','a.BanID = b.BanID','left')->where('HouseID', 'eq', $data['HouseID'])->update(['a.Status'=>3,'b.Status'=>3]);
                    }


                    if($data['value'] == 1){  //空租新发租(就是将一个新增的临时状态房屋，改为正式状态)
                        $datas['HouseID'] = $data['HouseID'];  //新增的房屋编号
                        $one = Db::name('house')->where('HouseID',$data['HouseID'])->field('InstitutionID,InstitutionPID,Status,UseNature')->find();

                        Db::name('house')->where('HouseID',$data['HouseID'])->setField('Status',3);
                        Db::name('room')->where('HouseID','like','%'.$data['HouseID'].'%')->setField('Status',3);

                        $datas['TenantID'] = $data['TenantID'];  //租户id


                    }elseif($data['value'] ==7){ //还要处理多个房屋编号,加改扩中的加建

                        $datas['BanID'] = $data['BanID'];  //新增的楼栋编号

                        $data['houseId'] = array_filter($data['houseId']); //数组去空

                        foreach ($data['houseId'] as $houseids) {
                            $statuss = Db::name('house')->where('HouseID',$houseids)->value('Status');
                            if($statuss != 0){ return jsons('4003','加建的房屋必须为新增状态……');}
                        }

                        Db::name('house')->where('HouseID','in',$data['houseId'])->setField('Status',3); //将所有房屋的状态改成异动中，此时该房屋不能被修改

                        $datas['HouseID'] = implode(',',$data['houseId']);



                    }elseif($data['value'] ==8){ //加改扩中的扩建

                        //$data['HouseID']
                        $option['HouseID'] = array('like','%'.$data['HouseID'].'%');
                        $option['Status'] = array('neq',1);
                        $houseStatus = Db::name('Room')->where($option)->find();
                        if(!$houseStatus){
                            return jsons('4003','该房屋不符合改建异动类型……');
                        }else{
                            Db::name('Room')->where(['HouseID'=>['like','%'.$data['HouseID'].'%'],'Status'=>['neq',1]])->setField('Status',3); //将异常状态下的房间的状态改成异动中，此时这些房间不能被修改
                        }

                        $datas['HouseID'] = $data['HouseID'];  //新增的房间id

                    }else{

                        $datas['BanID'] = $data['BanID'];  //新增的楼栋编号
                        $houseStatus = Db::name('ban')->where('BanID',$data['BanID'])->value('Status');
                        if($houseStatus != 0){ return jsons('4003','楼栋必须为新增状态……');}
                        Db::name('ban')->where('BanID', 'eq', $data['BanID'])->setField('Status',3);
                        Db::name('house')->where('BanID','eq',$data['BanID'])->setField('Status',3);
                        Db::name('room')->where('BanID','eq',$data['BanID'])->setField('Status',3);
                        
                    }

                    $datas['UseNature'] = $one['UseNature'];
                    $datas['NewSendRentType'] = $data['value'];  //新发租类型：如接管，还建……
                    $datas['ChangeType'] = $data['type'];  //异动类型为新发租
                    $datas['ProcessConfigName'] = $changeTypes[7];  //异动名称
                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集
                    $datas['ProcessConfigType'] = 7;   //流程控制线路
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'07'.$suffix;   //07代表新发租


                    $res = Db::name('change_order')->insert($datas);



                    break;

                case 8:  // 注销
//halt($data);

                    $datas['Deadline'] = json_encode($data['Ban']);
                    //halt($datas['Deadline']);
                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['TenantID'] = $one['TenantID'];
                    $datas['InstitutionID'] = $one['InstitutionID'];
                    $datas['InstitutionPID'] = $one['InstitutionPID'];
                    $datas['OrderDate'] = date('Ym', time());  //订单期
                    $datas['InflRent'] = $one['HousePrerent'];
                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];
                    $datas['CancelType'] = $data['cancelType'];  //注销类型
                    $datas['Remark'] = $data['cancelReason'];  //异动缘由
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[8];  //异动名称
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>8])->order('id desc')->value('id');        //流程控制线路
                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'08'.$suffix;   //08代表注销
                    $res = Db::name('change_order')->insert($datas);
                    break;

                case 9:  // 房屋调整,实际指的是楼栋
                    //halt($data);
                    //从表单传递进来的数据：楼栋编号，楼栋完损等级
                    $datas['BanID'] = $data['BanID'];  //楼栋编号
                    $datas['Damage'] = $data['LevelChange'];  //楼栋完损等级
                    $datas['Deadline'] = Db::name('ban')->where('BanID',$data['BanID'])->value('DamageGrade');
                    if($datas['Damage'] == $datas['Deadline']){
                        return jsons('4001','变更前后的完损等级不能相同');
                    }
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[9];  //异动名称
                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集
                    $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID,OwnerType,UseNature')->find();
                    //halt($one);
                    $datas['ProcessConfigType'] = 9;        //流程控制线路
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'09'.$suffix;   //09代表房屋调整
                    $datas['OwnerType'] = $one['OwnerType'];  //产别
                    $datas['UseNature'] = $one['UseNature'];   //使用性质
                    $datas['InstitutionID'] = $one['TubulationID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionID'];   //机构父id
                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 10:  // 管段调整,实际指的是楼栋

                    //从表单传递进来的数据：楼栋编号，楼栋完损等级
                    if(isset($data['BanID'])){
                        $datas['BanID'] = $data['BanID'];  //楼栋编号
                        $one = Db::name('ban')->where('BanID', 'eq', $data['BanID'])->field('TubulationID ,InstitutionID,OwnerType,UseNature')->find();
                        $datas['InstitutionID'] = $one['TubulationID'];  //机构id
                        $datas['InstitutionPID'] = $one['InstitutionID'];   //机构父id
                    }else{
                        $datas['HouseID'] = $data['HouseID'];  //房屋编号
                        $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('InstitutionID ,InstitutionPID,OwnerType,UseNature')->find();
                        $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                        $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id
                    }


                    $datas['NewInstitutionID'] = $data['InstitutionID'];  //楼栋完损等级
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集
                    $datas['OwnerType'] = $one['OwnerType'];  //产别
                    $datas['UseNature'] = $one['UseNature'];   //使用性质
                    $datas['ProcessConfigType'] = 10;        //流程控制线路
                    $datas['ProcessConfigName'] = $changeTypes[10];  //异动名称
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'10'.$suffix;   //09代表房屋调整


                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 11:  // 租金追加调整,实际指的是房屋
//halt($data);
                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集
                    $datas['Remark'] = $data['RentAddReason'];
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[11];  //异动名称
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>11])->order('id desc')->value('id');        //流程控制线路
                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['OrderDate'] = date('Ym',time());
                    $datas['OldYearRent'] = $data['RentAddYear'];  
                    $datas['OldMonthRent'] = $data['RentAddMonth'];  
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'11'.$suffix;   //09代表房屋调整
                    $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('InstitutionPID ,InstitutionID,OwnerType,UseNature')->find();
                    $datas['OwnerType'] = $one['OwnerType'];  //产别
                    $datas['UseNature'] = $one['UseNature'];   //使用性质
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id

                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 12:  // 租金调整

                    $datas['HouseID'] = $data['HouseID'];  //房屋编号
                    $datas['ChangeImageIDS'] = isset($ChangeImageIDS)?$ChangeImageIDS:'';  //附件集
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[12];  //异动名称
                    $datas['ProcessConfigType'] = Db::name('process_config')->where(['Status'=>1,'Type'=>12])->order('id desc')->value('id');        //流程控制线路
                    if(!$datas['ProcessConfigType']){
                        return jsons('4001','请先联系超级管理员配置异动流程');
                    }
                    $datas['OrderDate'] = date('Ym',time());
                    $datas['Deadline'] = json_encode($data['Ban']);
                    $datas['Remark'] = $data['RentReason'];
                    $InflRent = 0;
                    foreach($data['Ban'] as $b){
                        $InflRent += $b['addRentMoney'];
                    }
                    $datas['InflRent'] = $InflRent;  //影响的金额
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'12'.$suffix;   //12代表租金调整
                    $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])
                        ->field('InstitutionPID ,InstitutionID,UseNature,OwnerType,HousePrerent')
                        ->find();
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id
                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];

                    $res = Db::name('change_order')->insert($datas);

                    break;

                case 13:  // 分户
                    //halt($data);

                    if(!$data['RoomNum']){return jsons('4001','参数错误……');}
                    $datas['HouseID'] = $data['HouseID'];  //分户原始房屋编号
                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集

                    $datas['NewHouseID'] = $data['SplitHouseID']; //分户新增的房屋编号

                    $datas['RoomID'] = $data['RoomNum']; //分出去的房间
                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[13];  //异动名称
                    $datas['ProcessConfigType'] = 13;        //流程控制线路
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'13'.$suffix;   //13代表分户

                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];
                    $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('InstitutionPID ,InstitutionID,UseNature,OwnerType,HousePrerent,AnathorOwnerType,AnathorHousePrerent')->find();
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id

                    $res = Db::name('change_order')->insert($datas);
                    Db::name('house')->where('HouseID','in',[$data['HouseID'],$data['SplitHouseID']])->setField('Status',3); //将两个房屋的状态改成异动中
                    break;

                case 14:  // 并户
                    
                    $datas['HouseID'] = $data['HouseID'];  //分户原始房屋编号
                    $datas['ChangeImageIDS'] = $ChangeImageIDS;  //附件集

                    $datas['NewHouseID'] = $data['SplitHouseID']; //分户新增的房屋编号

                    $datas['ChangeType'] = $data['type'];  //异动类型
                    $datas['ProcessConfigName'] = $changeTypes[14];  //异动名称
                    $datas['ProcessConfigType'] = 14;        //流程控制线路
                    $datas['ChangeOrderID'] = date('YmdHis', time()).'13'.$suffix;   //13代表分户

                    $one = Db::name('house')->where('HouseID', 'eq', $data['HouseID'])->field('InstitutionPID ,InstitutionID,UseNature,OwnerType,HousePrerent,AnathorOwnerType,AnathorHousePrerent')->find();
                    $datas['InstitutionID'] = $one['InstitutionID'];  //机构id
                    $datas['InstitutionPID'] = $one['InstitutionPID'];   //机构父id

                    $datas['OwnerType'] = $one['OwnerType'];
                    $datas['UseNature'] = $one['UseNature'];
                    $res = Db::name('change_order')->insert($datas);
                    Db::name('house')->where('HouseID','in',[$data['HouseID'],$data['SplitHouseID']])->setField('Status',3); //将两个房屋的状态改成异动中
                    break;

                    

                default:
            }

            return $res?jsons('2000', '新增成功'):jsons('4000', '新增失败');

        }



    }

    public function edit(){


    }

    public function delete(){


    }
}