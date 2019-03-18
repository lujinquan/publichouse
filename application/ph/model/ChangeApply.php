<?php


namespace app\ph\model;

use think\Model;
use app\ph\model\HouseInfo as HouseModel;
use app\ph\model\BanInfo as BanModel;
use think\Db;
use think\Loader;
use util\Tree;

class ChangeApply extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__PROCESS__';

    public function get_all_process_lst(){

        $where['Status'] = 1;

        $ProcessLst['obj'] = self::field('id ,ProcessName ,IfBaseChange,CreateUserID,CreateTime')->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $ProcessLst['arr'] = $ProcessLst['obj']->all()?$ProcessLst['obj']->all():array();

        foreach($ProcessLst['arr'] as &$v){

            $v['CreateUserName'] = Db::name('admin_user')->where('Number','eq',$v['CreateUserID'])->value('UserName');

            $v['CreateTime'] = date('Y/m/d',$v['CreateTime']);

            if($v['IfBaseChange'] == 1){

                $v['IfBaseChange'] = '基数异动';
            }else{
                
                $v['IfBaseChange'] = '非基数异动';
            }

        }

        return $ProcessLst;
    }

    public function uploads($file,$k1,$type){

        $title = config($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/changeOrder/'); //设置保存的路径
        $fileUpload->set('maxsize',5*1024*1024); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            //return jsons('4003' ,$fileUpload->getErrorMsg());
            return jsons('4003' ,'上传失败');

        }else{  //上传成功

            //多文件上传，遍历操作
            $names = $fileUpload->getFileName();

            foreach($names as $k => $v){

                $data['FileUrl']= '/uploads/changeOrder/'.$v;          //写入到数据库中的地址和存放地址 $targetPath 不一样
                $data['FileTitle'] = $title;                  
                $data['FileType'] = 1;        //图片类型
                $data['FileUse'] = $type + 4;         //用途：异动
                $data['UploadUserID'] = UID;
                $data['UploadTime'] = time();
                $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1

                if($result == 1) {
                    $fileID[] = Db::name('upload_file')->getLastInsID();
                }
            }

            return $fileIDS = implode(',', $fileID);

        }

    }

    public function check_apply_table($data)
    {
        //校验该角色是否被允许提交异动申请
        $pid = Db::name('process_config')->where('Type','eq',$data['type'])->value('id');
        $nowRoleID = Db::name('process_config')->where('pid','eq',$pid)->where('Total','eq',1)->value('RoleID');
        $roles = json_decode(session('user_base_info.role'),true);  //获取该登录用户的所有角色
        if(!in_array($nowRoleID,$roles)){
            return jsons('4004','友情提示，您暂无权限提交异动单……');
        }

        if(!isset($data['type'])){
            return jsons('4000','参数缺失……');
        }

        switch ($data['type']) {
                case 1:  //租金减免
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>1,'Status'=>['>',1],'DateEnd'=>['>=',date('Ym',time())]])->find();
                    if($ifin){
                        return jsons('4001','该房屋正在减免异动中');
                    }
                    $houseModel = new HouseModel;

                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'IfSuspend'=>0,
                        'IfEmpty'=>0,
                        'HouseChangeStatus'=>0,
                        ];

                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    if(!$data['RemitRent']){
                        return jsons('4002','减免金额不能为空');
                    }else{
                       if(!preg_match("/^\d+(\.\d+)?$/",$data['RemitRent'])){
                            return jsons('4003','减免金额请填写数字');
                        } 
                    }
                    if(!$data['CutType']){
                        return jsons('4002','减免类型不能为空');
                    }
                    if(!$data['validity']){
                        return jsons('4002','有效期不能为空');
                    }
                    return $finds;
                break;
                case 2:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>2,'Status'=>['>',1],'OrderDate'=>date('Ym',time())])->find();
                    if($ifin){
                        return jsons('4001','该房屋正在空租异动中');
                    }
                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                        ];
                    $houseModel = new HouseModel;
                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,IfEmpty,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }  
                    if($data['emptyRentType'] == 1 && $finds['IfEmpty'] == 1){ //新增空租
                        return jsons('4002','房屋已为空租状态');
                    }
                    return $finds;
                break;
                case 3:

                    if(!($data['houseID'])){
                        return jsons('4000','未选择任何房屋');
                    }
                    $houseids = Db::name('change_order')->where(['HouseID'=>['in',$data['houseID']],'ChangeType'=>3,'Status'=>['>',1]])->column('HouseID');
                    if($houseids){
                        $implodeHouses = implode(',',$houseids);
                        return jsons('4005','该房屋:'.$implodeHouses.'已经在暂停异动中了');
                    }

                    $arrs = Db::name('house')->where(['HouseID'=>['in',$data['houseID']]])->group('OwnerType')->column('OwnerType');
                    if(count($arrs) > 1){
                        return jsons('4004','所选房屋产别不能超过一种');
                    }

                    $findwhere = [
                        'HouseID'=>['in',$data['houseID']],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                    ];

                    $finds = Db::name('house')->where($findwhere)
                                            ->field('sum(HousePrerent) as HousePrerents,BanID,OwnerType,InstitutionID, InstitutionPID')
                                            ->find();

                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    return $finds;

                break;
                case 4:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>4,'Status'=>['>',1]])->find();
                    if($ifin){
                        return jsons('4001','该房屋已经在陈欠核销异动订单中了');
                    }
                    $houseModel = new HouseModel;
                    if(!($data['oldCancelYearBefore']) && !($data['oldCancelMonthBefore'])){
                        return jsons('4000','请选择核销项');
                    }
                    if($data['oldCancelYearBefore']){
                        $v= Db::name('rent_order')->where(['HouseID'=>$data['HouseID'],'OrderDate'=>['<',date('Y').'00']])->sum('UnpaidRent');
                        if($data['oldCancelYearBefore'] != $v){
                          return jsons('4000','年度核销金额与以前年欠缴金额不等');  
                        }
                    }
                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                    ];

                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();

                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    return $finds;
                break;
                case 7:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>7,'Status'=>['>',1]])->find();
                    if($ifin){
                        return jsons('4001','该房屋已经在新发租异动订单中了');
                    }
                    $houseModel = new HouseModel;
                    
                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>0,
                        'HouseChangeStatus'=>0,
                    ];
                    $finds = $houseModel->field('InstitutionPID,BanID,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();

                    if(!$finds){
                        return jsons('4002','房屋状态需为异动状态');
                    }
                    return $finds;
                break;
                case 8:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>8,'Status'=>['>',1]])->find();
                    if($ifin){
                        return jsons('4001','该房屋正在注销异动订单中处理……');
                    }
                    $houseModel = new HouseModel;

                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                        ];

                    $finds = $houseModel->field('InstitutionPID,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    if(!($data['HouseID'])){
                        return jsons('4000','未选择任何房屋');
                    }
                    if(!($data['cancelType'])){
                        
                        return jsons('4000','未选择注销类型');
                    }else{
                        $canceltype = Db::name('cancel_type')->where('id',$data['cancelType'])->find();
                        if(!$canceltype){
                            return jsons('4001','注销类型不合法');
                        }
                    }
                    if(!$data['Ban']){
                        return jsons('4001','请完善异动信息');
                    }
                    return $finds;
                break;
                case 9:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>9,'Status'=>['>',1]])->find();
                    if($ifin){
                        return jsons('4001','该房屋正在房屋调整异动订单中处理……');
                    }

                    $s = 0;
                    foreach($data['Ban'] as $v){
                        $s += $v['PreRentChange'];
                    }
                    $houseModel = new HouseModel;

                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                        ];

                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    
                    $finds['InflRent'] = $s;

                    if(!($data['HouseID'])){
                        return jsons('4000','未选择任何房屋');
                    }
                    return $finds;
                break;
                case 11:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>11,'Status'=>['>',0],'OrderDate'=>date('Ym',time())])->find();
                    //halt($ifin);
                    if($ifin){
                        return jsons('4001','该房屋已在租金追加调整异动单中……');
                    }
                    if(!$data['RentAddYear'] && !($data['RentAddMonth'])){
                        return jsons('4002','以前年和以前月数据不能同时为空');
                    }
                    $houseModel = new HouseModel;

                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                        ];

                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    return $finds;
                break;
                case 12:
                    $ifin = Db::name('change_order')->where(['HouseID' =>['eq' ,$data['HouseID']],'ChangeType'=>12,'Status'=>['>',0],'OrderDate'=>date('Ym',time())])->find();
                    if($ifin){
                        return jsons('4001','该房屋已在租金调整异动单中……');
                    }
                    $houseModel = new HouseModel;

                    $findwhere = [
                        'HouseID'=>$data['HouseID'],
                        'Status'=>1,
                        'HouseChangeStatus'=>0,
                        ];

                    $finds = $houseModel->field('InstitutionPID ,InstitutionID,HousePrerent,TenantID,OwnerType,UseNature')
                                        ->where($findwhere)
                                        ->find();
                    if(!$finds){
                        return jsons('4002','房屋状态异常');
                    }
                    if(!$data['Ban']){
                        return jsons('4001','请完善异动信息');
                    }
                    return $finds;
                break;
                case 14:
                    $ifin = Db::name('change_order')->where(['BanID' =>['eq' ,$data['BanID']],'ChangeType'=>14,'Status'=>['>',0],'OrderDate'=>date('Ym',time())])->find();
                    if($ifin){
                        return jsons('4001','该楼栋已在楼栋调整异动单中……');
                    }
                    $banModel = new BanModel;

                    $findwhere = [
                        'BanID'=>$data['BanID'],
                        'Status'=>1,
                        ];

                    $finds = $banModel->field('TubulationID ,InstitutionID,DamageGrade,StructureType,OwnerType,UseNature')
                                      ->where($findwhere)
                                      ->find();
                    if(!$finds){
                        return jsons('4002','楼栋状态异常');
                    }
                    if(!$data['afterAdjustDamageGrade'] && !$data['afterAdjustStructureType']){
                        return jsons('4001','请完善异动信息');
                    }
                    //halt($finds);
                    return $finds;
                case 15:
                    $ifin = Db::name('change_order')->where(['BanID' =>['eq' ,$data['banID']],'ChangeType'=>15,'Status'=>['>',0],'OrderDate'=>date('Ym',time())])->find();
                    if($ifin){
                        return jsons('4001','该楼栋已在租金调整（批量）异动单中……');
                    }
                    $banModel = new BanModel;

                    $findwhere = [
                        'BanID'=>$data['banID'],
                        'Status'=>1,
                        ];

                    $finds = $banModel->field('TubulationID ,InstitutionID,DamageGrade,StructureType,OwnerType,UseNature,TotalOprice,PreRent,TotalArea')
                                      ->where($findwhere)
                                      ->find();
                    if(!$finds){
                        return jsons('4002','楼栋状态异常');
                    }
                    // if(!$data['afterAdjustDamageGrade'] && !$data['afterAdjustStructureType']){
                    //     return jsons('4001','请完善异动信息');
                    // }
                    //halt($finds);
                    return $finds;
                break;



                default:
        }



    }





}