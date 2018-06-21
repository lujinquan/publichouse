<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Config;
use think\Exception;
use think\Loader;
use think\Db;
use util\Tree;

class BanInfo extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__BAN__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'CreateTime';
    //  关闭更新时间
    protected $updateTime = false;

    public function get_all_ban_lst($status = array('eq' ,0)){

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        $where['Status'] = $status;

        if($currentUserLevel == 3){  //用户为管段级别，则直接查询

            $where['TubulationID'] = array('eq' ,$currentUserInstitutionID);

        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询

            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);

        }else{    //用户为公司级别，则获取所有子管段

        }

        $BanIdList['option'] =array();

        $searchForm = input('request.');
        //halt($searchForm);

        foreach ($searchForm as &$val) { //去收尾空格
            $val = trim($val);
        }

        if(isset($searchForm['BanID'])) {

            $BanIdList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id','eq',$searchForm['TubulationID'])->value('Level');

                if($level == 3) {
                    $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
                }elseif($level == 2){
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if ($searchForm['OwnerType']) {   //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['DamageGrade']) {  //检索完损等级
                $where['DamageGrade'] = array('eq', $searchForm['DamageGrade']);
            }
            if ($searchForm['StructureType']) {  //检索楼栋结构
                $where['StructureType'] = array('eq', $searchForm['StructureType']);
            }
            if ($searchForm['UseNature']) {  //检索使用性质
                $where['UseNature'] = array('eq', $searchForm['UseNature']);
            }
            if ($searchForm['BanID']) {  //模糊检索楼栋编号
                $where['BanID'] = array('like', '%'.$searchForm['BanID'].'%');
            }
            if ($searchForm['AreaFour']) {  //模糊检索楼栋地址
                $where['AreaFour'] = array('like', '%'.$searchForm['AreaFour'].'%');
            }
            if ($searchForm['TotalArea']) {  //模糊检索合建面
                $where['TotalArea'] = array('like', '%'.$searchForm['TotalArea'].'%');
            }
            if ($searchForm['BanPropertyID']) {  //模糊检索产权证号
                $where['BanPropertyID'] = array('like', '%'.$searchForm['BanPropertyID'].'%');
            }

            if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
                $start = $searchForm['DateStart'];
                $end = $searchForm['DateEnd'];
                //dump($start);dump($end);exit;
                if($start < $end){
                    $where['BanYear'] = array('between',$start.",".$end);
                }
            }
            if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
                $start = $searchForm['DateStart'];
                //dump($start);exit;
                $where['BanYear'] = array('egt',$start);
            }
            if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
                $end = $searchForm['DateEnd'];
                $where['BanYear'] = array('elt',$end);
            }

        }

        if(!isset($where)){
            $where = 1;
        }
        //halt($where);
        $BanIdList['obj'] = self::field('BanID')->where($where)->order('OldBanID asc')->paginate(config('paginate.list_rows'));

        $BanIdList['tatalAreas'] = self::where($where)->value('sum(TotalArea) as ToatalAreas');
        $BanIdList['tatalUseAreas'] = self::where($where)->value('sum(BanUsearea) as BanUseareas');
        $BanIdList['tatalBanPrerents'] = self::where($where)->value('sum(PreRent) as BanPrerents');
        //halt($BanIdList['tatalBanPrerents']);
        $arr = $BanIdList['obj']->all();

        if(!$arr){
            $BanIdList['arr'] = array();
        }

        foreach($arr as $v){
            $BanIdList['arr'][] = self::get_one_ban_base_info($v['BanID'],$status);
        }

        return $BanIdList;
    }

    public function get_one_ban_base_info($banid = '',$status = 1,$map=''){
        //楼栋编号，机构id(到管段),楼栋产别，地址，产权证号，建成年份，完损等级，结构类别，使用性质，规定租金
        if(!$map) $map = 'BanID ,OldBanID,TubulationID ,OwnerType ,AreaFour ,IfSuspend,BanUsearea ,BanAddress ,BanPropertyID ,BanYear ,DamageGrade ,StructureType ,UseNature ,PreRent,TotalArea';
        $data = self::field($map)->where('BanID','eq',$banid)->find();

        if(!$data){
            return array();
        }

        $where['Status'] = $status;
        $where['BanID'] = array('eq',$banid);

//        $houses = Db::name('room')->where($where)->value('group_concat(HouseID) as houseids');
//        $houseidArr = array_unique(explode(',',$houses));
        $houseArr = Db::name('house')->where($where)->column('HouseID');
        //$houseArr= array_unique(array_filter(array_merge($houseidArr,$houseidArr2)));
        array_multisort($houseArr);
        
        $data['TotalHouseNum'] = $houseArr?Db::name('house')->where('HouseID','in',$houseArr)->count():0;
        $data['IfSuspend'] = $data['IfSuspend']?'是':'否';
        $data['DamageGrade'] = get_damage($data['DamageGrade']);//完损等级
        $data['OwnerType'] = get_owner($data['OwnerType']);   //楼栋产别
        $data['StructureType'] = get_structure($data['StructureType']);//结构名称
        $data['TubulationID'] = get_institution($data['TubulationID']);   //机构管段名称
        $data['UseNature'] = get_usenature($data['UseNature']);   //使用性质

        return $data;

    }

    public function get_one_ban_detail_info($banid = ''){

        $oneData = Db::name('ban')->where('BanID' ,'eq' ,$banid)->find();

        $oneData['DamageGrade'] = get_damage($oneData['DamageGrade']);//完损等级
        $oneData['OwnerType'] = get_owner($oneData['OwnerType']);   //楼栋产别
        $oneData['StructureType'] = get_structure($oneData['StructureType']);//结构名称
        $oneData['TubulationID'] = get_institution($oneData['TubulationID']);   //机构管段名称
        $oneData['UseNature'] = get_usenature($oneData['UseNature']);   //使用性质

        $imgArr = explode(',',$oneData['BanImageIDS']);

        $oneData['BanImageIDS'] = Db::name('upload_file')->where('id' ,'in' ,$imgArr)->field('FileTitle ,FileUrl')->select();

        //$oneData['IfElevator'] = $oneData['IfElevator'] ? '是':'否';
        $oneData['IfFirst'] = $oneData['IfFirst'] ? '是':'否';
        $oneData['CutIf'] = $oneData['CutIf'] ? '是':'否';
        $oneData['ReformIf'] = $oneData['ReformIf'] ? '是':'否';
        $oneData['ProtectculturalIf'] = $oneData['ProtectculturalIf'] ? '是':'否';
        $oneData['CreateTime'] = date('Y-m-d H:i:s',$oneData['CreateTime']);

        if($oneData['IfElevator'] == 0){
            $oneData['IfElevator'] = '无电梯';
        }elseif($oneData['IfElevator'] == 1){
            $oneData['IfElevator'] = '有电梯且免费';
        }elseif($oneData['IfElevator'] == 2){
            $oneData['IfElevator'] = '有电梯需缴费';
        }

        switch($oneData['HistoryIf']){
            case 0:
                $oneData['HistoryIf'] = '否';
                break;
            case 1:
                $oneData['HistoryIf'] = '市级';
                break;
            case 2:
                $oneData['HistoryIf'] = '区级';
                break;
            case 3:
                $oneData['HistoryIf'] = '省级';
                break;
            default:
                break;
        }
        switch($oneData['RemoveStatus']){
            case 1:
                $oneData['RemoveStatus'] = '未拆迁';
                break;
            case 2:
                $oneData['RemoveStatus'] = '已拆迁，未下基数';
                break;
            case 3:
                $oneData['RemoveStatus'] = '已拆迁，已下基数';
                break;
            default:
                break;
        }

        $oneData['change_record'] = self::get_ban_change_record($banid);

        return $oneData;
    }

    public function get_ban_change_record($banid)
    {
        $changeTypes = Db::name('change_type')->column('id,ChangeType');
        $institutions = Db::name('institution')->column('id,Institution');

        $where['Status'] = array('eq',1);
        $where['BanID'] = array('eq',$banid);

        $changeData = Db::name('change_order')->where($where)->field('ChangeOrderID,ChangeType,InstitutionID,FinishTime')->select();
        foreach ($changeData as $key => $value) {
            $data[$key][] = $value['ChangeOrderID'];
            $data[$key][] = date('Y年m月d日',$value['FinishTime']);
            $data[$key][] = $changeTypes[$value['ChangeType']];
            $data[$key][] = $institutions[$value['InstitutionID']];
        }
        return isset($data)?$data:array();
    }

    //获取楼栋结构基础信息
    public function get_one_ban_stru_info($banid = ''){
        $map = 'BanID ,StructureType ,DamageGrade ,BanAddress ,BanUnitNum ,BanFloorNum';
        $data = self::field($map)->where('BanID' ,'eq' ,$banid)->find();

        if(!$data){
            return array();
        }

        //$maps['BanID'] = array('eq' ,$banid);
        for($i=1;$i<=$data['BanUnitNum'];$i++){ //遍历单元
            $maps['UnitID'] = array('eq',$i);
            for($j=1;$j<=$data['BanFloorNum'];$j++){ //遍历楼层
                $maps['FloorID'] = array('eq',$j);
                $houses = Db::name('room')->where('BanID',$banid)->value('group_concat(HouseID) as houseids');
                $housess = Db::name('house')->where('BanID',$banid)->column('HouseID');
                $houseArr = array_unique(array_merge(explode(',',$houses),$housess));
                $res = Db::name('house')->field('HouseID,DoorID')->where($maps)->where('HouseID','in',$houseArr)->select();

                $allHouse[$i][$j] = $res ? $res:array();
            }
        }

        $data['allHouse']=$allHouse?$allHouse:array();
        $data['DamageGrade'] = Db::name('ban_damage_grade')->where('id','eq',$data['DamageGrade'])->value('DamageGrade');//完损等级
        $data['StructureType'] = Db::name('ban_structure_type')->where('id','eq',$data['StructureType'])->value('StructureType');//结构名称

        return $data;
    }


    //获取所有该用户所属机构下的子机构目录
    public function get_all_institution(){

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if($currentUserLevel == 3) {  //用户为管段级别，无添加修改权限，所以不分配机构数据到下拉菜单中

        }elseif($currentUserLevel == 2){  //所级别

            $datas = Db::name('institution')->field('id,Institution,pid')->where('pid','eq',$currentUserInstitutionID)->select();

            return $datas;
        }else{  //公司级别

            $datas = Db::name('institution')->field('id,Institution,pid')->select();
            //halt($tree);
             //halt(tree($datas));
//halt($datas);
            return tree($datas);



        }


    }

    public function get_area($level = 2){

        $data = Db::name('area')->where('Level' ,'eq' ,$level)->field('id,Code,AreaTitle')->select();
        return $data;
    }

    //获取所有楼栋产别目录
    public function get_all_owner_type(){
        $data = Db::name('ban_owner_type')->field('id,OwnerType')->select();
        return $data;
    }

    //获取所有楼栋结构目录
    public function get_all_structure_type(){
        $data = Db::name('ban_structure_type')->field('id,StructureType')->select();
        return $data;
    }

    //获取所有楼栋完损等级目录
    public function get_all_damage_grade(){
        $data = Db::name('ban_damage_grade')->field('id,DamageGrade')->select();
        return $data;
    }

    //获取所有使用性质目录
    public function get_all_use_nature(){
        $data = Db::name('use_nature')->field('id,UseNature')->select();
        return $data;
    }

    //获取所有楼栋附近的公共设施目录
    public function get_all_facilities(){
        $data = Db::name('ban_facilities')->field('id,BanFacilities')->select();
        return $data;
    }

    public function get_all_cut_type(){
        $data = Db::name('cut_rent_type')->field('id,CutName')->select();
        return $data;
    }
    
    public function uploads($file,$k1){

        $title = Config::get($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/ban/'); //设置保存的路径
        $fileUpload->set('maxsize',1000000); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            return jsons('4003' ,$fileUpload->getErrorMsg());

        }else{  //上传成功

            $data['FileUrl']= '/uploads/ban/'.$fileUpload->getFileName();          //写入到数据库中的地址和存放地址 $targetPath 不一样
            $data['FileTitle'] = $title;
            $data['FileType'] = 1;        //图片类型
            $data['FileUse'] = 1;         //用途：楼栋
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
