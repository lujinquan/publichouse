<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class ConfirmBanInfo extends Base
{
    public function index()
    {
        $areaTwo = $this->BanInfoModel->get_area(2);
        $areaThree = $this->BanInfoModel->get_area(3);
        $banLst = $this->BanInfoModel->get_all_ban_lst(array('eq' ,0));
        $this->assign([
            'banLst' => $banLst['arr'],
            'banLstObj' => $banLst['obj'],
            'banOption' => $banLst['option'],
            'areaTwo' => $areaTwo,
            'areaThree' => $areaThree,
        ]);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
            $data = array_no_space_str($this->request->post());
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            // 验证
            $result = $this->validate($data, 'ConfirmBanInfo');
            if (true !== $result) {
                return jsons('4001', $result);
            }
            if ($_FILES  && !isset($datas)) {   //文件上传
                foreach ($_FILES as $k => $v) {
                    if($v['error'] !== 0){
                        continue;
                    }
                    $BanImageIDS[] = model('BanInfo')->uploads($v, $k);
                }
                if(isset($BanImageIDS)){
                    $data['BanImageIDS'] = implode(',', $BanImageIDS);
                }
            }
            
            $arr = explode(',', $data['xy']);
            $areas = Db::name('area')->column('id,Code');
            $areaTwo = Db::name('area')->where('id', 'eq', $data['AreaTwo'])->value('AreaTitle');
            $areaThree = Db::name('area')->where('id', 'eq', $data['AreaThree'])->value('AreaTitle');
            $banID = '1' . $areas[$data['AreaTwo']] . $areas[$data['AreaThree']];
            $maxBanID = Db::name('ban')->where('BanID', 'like', $banID . '%')->max('BanID');
            $ban = new BanInfoModel;

            $data['BanGpsX'] = $arr[0]; 
            $data['BanGpsY'] = $arr[1]; 
            $data['InstitutionID'] = Db::name('institution')->where('id', 'eq', $data['TubulationID'])->value('pid'); 
            $data['BanID'] = $maxBanID?$maxBanID + 1:$banID . '001';
            $data['BanAddress'] = $areaTwo . $areaThree . $data['AreaFour']; 
            $data['CreateUserID'] = UID;
            $data['Status'] = 0; 
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea']; 
            $data['TotalNum'] = $data['CivilNum'] + $data['PartyNum'] + $data['EnterpriseNum']; 
            if($data['TotalNum'] > 1){
                return jsons('4000','合栋数在0-1之间');
            }
            $data['PreRent'] = $data['CivilRent'] + $data['PartyRent'] + $data['EnterpriseRent']; 
            $data['TotalOprice'] = $data['CivilOprice'] + $data['PartyOprice'] + $data['EnterpriseOprice'];
            
            if ($ban->allowField(true)->save($data)) {
                // 记录行为
                action_log('BanInfo_add', UID, 1, '编号为:' . $data['BanID']);
                return jsons('2000', '新增成功');
            } else {
                return jsons('4000', '新增失败');
            }
        }

    }

    public function edit()
    {
        $banID = input('BanID');
        if ($this->request->isPost()) {
            if(DATA_DEBUG){
                return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
            }
            $data = array_no_space_str($this->request->post());
//halt($data);
            $houseids = Db::name('change_order')->where(['ChangeType'=>7,'Status'=>['>',1]])->column('HouseID'); 
            if($houseids){
                $banids = Db::name('house')->where(['Status'=>0,'HouseID'=>['in',$houseids]])->column('BanID');
                if(in_array($data['BanID'],$banids)){
                    return jsons('4000','正在异动单中数据不能修改');
                }
            }


            $tempdatas = Db::name('ban')->where('BanID', 'eq', $banID)->find();
            $data['BanAddress'] = get_area($data['AreaTwo']).get_area($data['AreaThree']).$data['AreaFour'];
            $data['TotalNum'] = $data['CivilNum'] + $data['PartyNum'] + $data['EnterpriseNum'];
            $data['PreRent'] = $data['CivilRent'] + $data['PartyRent'] + $data['EnterpriseRent'];
            $data['TotalOprice'] = $data['CivilOprice'] + $data['PartyOprice'] + $data['EnterpriseOprice'];
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea'];
            $ChangeImageIDS = [];
            $imgStr = '';
            if ($_FILES) {
                foreach ($_FILES as $k => $v) {
                    if($v['error'] == 0){
                        $ChangeImageIDS[] = model('BanInfo')->uploads($v, $k);
                    }
                }
                // if(isset($ChangeImageIDS)){
                //     $data['imgs'] = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
                // }
            }

            if($ChangeImageIDS){
                $imgStr = implode(',', $ChangeImageIDS);
            }
            
            if($data['LandCertificate']){
                $imgStr =  $imgStr .','. $data['LandCertificate'];
            }
            if($data['RealEstate']){
                $imgStr =  $imgStr .','. $data['RealEstate'];
            }
            if($data['BanImageIDS']){
                $imgStr =  $imgStr .','. $data['BanImageIDS'];
            }

            $data['BanImageIDS'] = trim($imgStr,',');

            // 验证
            $arr = explode(',', $data['xy']);
            $data['BanGpsX'] = $arr[0];
            $data['BanGpsY'] = $arr[1];
            unset($data['xy']);
            unset($data['RealEstate']);
            unset($data['LandCertificate']);
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            $data['InstitutionID'] = Db::name('institution')->where('id', 'eq', $data['TubulationID'])->value('pid');
            $result = $this->validate($data,'ConfirmBanInfo');
            if(true !== $result){
                return jsons('4001' ,$result);
            }
            //等联动修改好了后，需要加上去   AreaTwo,AreaThree,
            $fields = 'BanNumber,AreaFour,TubulationID,BanPropertyID,DamageGrade,BanLandID,BanFreeholdID,CoveredArea,ActualArea,OwnerType,BanYear,UseNature,StructureType,BanUnitNum,BanFloorNum,BanFloorStart,HistoryIf,ReformIf,ProtectculturalIf,CutIf,BanGpsX,BanGpsY';
            $oldOneData = Db::name('ban')->field($fields)->where('BanID', 'eq', $banID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = config($k1);
                }
            }
            //halt($data);
            if ($banInfo = BanInfoModel::update($data)) {
                if($tempdatas['Status'] == 1){
                    Db::name('ban')->where('BanID', 'eq', $data['BanID'])->update(['Status' => 1]);
                }
                Db::name('house')->where('BanID', 'eq', $data['BanID'])->update(['InstitutionID'=> $data['TubulationID'],'InstitutionPID'=> $data['InstitutionID']]);
                Db::name('room')->where('BanID', 'eq', $data['BanID'])->update(['InstitutionID'=> $data['TubulationID'],'InstitutionPID'=> $data['InstitutionID']]);
                if ($data['OwnerType']) {
                    Db::name('house')->where('BanID', 'eq', $data['BanID'])->setField('OwnerType',$data['OwnerType']);
                }
                if ($data['BanAddress']){
                    Db::name('house')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['AreaFour']);
                    Db::name('room')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['AreaFour']);
                }
                if(!isset($allData)){$allData = array(); }
                // 记录行为
                action_log('BanInfo_edit', UID, 1, '编号为:' . $data['BanID'],json_encode($allData));
                return jsons('2000', '修改成功');
            } else {
                return jsons('4000', '修改失败');
            }
        }
        $data = Db::name('ban')->where('BanID', 'eq', $banID)->find();
        $data['BanRatio'] += 0;
        $data['BanImageIDS'] = Db::name('upload_file')->where('id' ,'in' ,explode(',',$data['BanImageIDS']))->field('id, FileTitle ,FileUrl')->select();
        return $data?jsons('2000', '获取成功', $data):jsons('4000', '获取失败');
    }

    public function delete()
    {
        if(DATA_DEBUG){
            return jsons('3000' ,'数据调试中，暂时无法进行相关业务');
        }
        $banID = input('BanID');

        $houseids = Db::name('change_order')->where(['ChangeType'=>7,'Status'=>['>',1]])->column('HouseID'); 
        if($houseids){
            $banids = Db::name('house')->where(['Status'=>0,'HouseID'=>['in',$houseids]])->column('BanID');
            if(in_array($banID,$banids)){
                return jsons('4000','正在异动单中数据不能修改');
            }
        }
        
        $style = input('style');
        if(!$banID || !$style){
            return jsons(4004 ,'参数异常……');
        }else{
            $res = Db::name('ban')->where('BanID', 'eq', $banID)->setField('Status',$style);
            if ($res) {
                // 将关联的房屋和房间状态都改为假删状态
                Db::name('house')->where('BanID','eq',$banID)->setField('Status',$style);
                Db::name('room')->where('BanID','eq',$banID)->setField('Status',$style);
                // 记录行为
                action_log('BanInfo_delete', UID, 1, '编号为:' . $banID);
                return jsons(2000, '删除成功');
            } else {
                return jsons(4000, '删除失败');
            }
        }
    }

    public function detail()
    {
        $banID = input('BanID');
        if ($banID) {
            //所有楼栋基础信息
            $banDetail = $this->BanInfoModel->get_one_ban_detail_info($banID);
            return jsons(2000, '获取成功', $banDetail);
        }
    }

    public function strucDetail()
    {
        $banID = input('BanID');
        $houseID = input('HouseID');
        if ($houseID) { //在楼栋结构中，点击房屋代号，返回对应的右侧基础信息
            $results = $this->HouseInfoModel->get_one_house_base_info($houseID);
            if ($results == array()) {
                return jsons('4001', '参数错误');
            }
            return jsons('2000', '获取房屋信息成功', $results);
        }
        if ($banID) {  //点击楼栋结构，从前台接收楼栋编号，返回对应信息
            $data = $this->BanInfoModel->get_one_ban_stru_info($banID);
            return  $data?jsons('2000', '获取成功', $data):jsons('4001', '该楼栋编号不存在');
        }
    }

}
