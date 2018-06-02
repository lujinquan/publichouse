<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Config;
use think\Request;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class ConfirmBanInfo extends Base
{
    public function index()
    {
        //所有公共设施
        $faciLst = $this->BanInfoModel->get_all_facilities();
        //所有的街道
        $areaTwo = $this->BanInfoModel->get_area(2);
        //所有的社区
        $areaThree = $this->BanInfoModel->get_area(3);
        $banLst = $this->BanInfoModel->get_all_ban_lst();
        $this->assign([
            'banLst' => $banLst['arr'],
            'banLstObj' => $banLst['obj'],
            'banOption' => $banLst['option'],
            'faciLst' => $faciLst,
            'areaTwo' => $areaTwo,
            'areaThree' => $areaThree,
        ]);
        return $this->fetch();
    }

    //基础数据整理完了后用
    public function edit_after()
    {
        $banID = input('BanID');
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $tempdatas = Db::name('ban')->where('BanID', 'eq', $banID)->find();
            if($tempdatas['Status'] == 3){
                return jsons('4005','异动中的楼栋不能修改');
            }
            $data['BanAddress'] = get_area($data['AreaTwo']).get_area($data['AreaThree']).$data['AreaFour'];
            if ($_FILES) {
                foreach ($_FILES as $k => $v) {
                    if($v['error'] == 0){
                        $ChangeImageIDS[] = model('BanInfo')->uploads($v, $k);
                    }
                }
                if(isset($ChangeImageIDS)){
                    $data['BanImageIDS'] = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
                }
            }
            // 验证
            $arr = explode(',', $data['xy']);
            $data['BanGpsX'] = $arr[0];
            $data['BanGpsY'] = $arr[1];
            unset($data['xy']);
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            $data['InstitutionID'] = Db::name('institution')->where('id', 'eq', $data['TubulationID'])->value('pid');
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea'];
            $result = $this->validate($data,'BanInfo');
            if(true !== $result){
                return jsons('4001' ,$result);
            }
            //等联动修改好了后，需要加上去   AreaTwo,AreaThree,
            $fields = 'AreaFour,TubulationID,BanPropertyID,DamageGrade,BanLandID,BanFreeholdID,CoveredArea,ActualArea,OwnerType,BanYear,UseNature,StructureType,BanUnitNum,BanFloorNum,BanFloorStart,HistoryIf,ReformIf,ProtectculturalIf,CutIf,BanGpsX,BanGpsY';
            $oldOneData = Db::name('ban')->field($fields)->where('BanID', 'eq', $banID)->find();
            foreach($oldOneData as $k1=>$v1){
                if($data[$k1] != $v1){
                    $allData[$k1]['old'] = $v1;
                    $allData[$k1]['new'] = $data[$k1];
                    $allData[$k1]['name'] = Config::get($k1);
                }
            }
            if ($banInfo = BanInfoModel::update($data)) {
                if($tempdatas['Status'] == 1){
                    Db::name('ban')->where('BanID', 'eq', $data['BanID'])->update(['Status' => 2]);
                }
                Db::name('house')->where('BanID', 'eq', $data['BanID'])->update(['InstitutionID'=> $data['TubulationID'],'InstitutionPID'=> $data['InstitutionID']]);
                Db::name('room')->where('BanID', 'eq', $data['BanID'])->update(['InstitutionID'=> $data['TubulationID'],'InstitutionPID'=> $data['InstitutionID']]);
                if ($data['OwnerType']) {
                    Db::name('house')->where('BanID', 'eq', $data['BanID'])->setField('OwnerType',$data['OwnerType']);
                }
                if ($data['BanAddress']){
                    Db::name('house')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['BanAddress']);
                    Db::name('room')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['BanAddress']);
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
        $data['BanImageIDS'] = Db::name('upload_file')->where('id' ,'in' ,explode(',',$data['BanImageIDS']))->field('FileTitle ,FileUrl')->select();
        return $data?jsons('2000', '获取成功', $data):jsons('4000', '获取失败');
    }


    public function edit()
    {
        $banID = input('BanID');
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            //halt($data);
//            if ($data['OwnerType'] == $data['AnathorOwnerType']) {
//                return jsons('4003','两个产别不能相同');
//            }

            $tempdatas = Db::name('ban')->where('BanID', 'eq', $banID)->find();
            $data['BanAddress'] = get_area($data['AreaTwo']).get_area($data['AreaThree']).$data['AreaFour'];
            $data['TotalNum'] = $data['CivilNum'] + $data['PartyNum'] + $data['EnterpriseNum'];
            $data['PreRent'] = $data['CivilRent'] + $data['PartyRent'] + $data['EnterpriseRent'];
            $data['TotalOprice'] = $data['CivilOprice'] + $data['PartyOprice'] + $data['EnterpriseOprice'];
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea'];
            if ($_FILES) {
                foreach ($_FILES as $k => $v) {
                    if($v['error'] == 0){
                        $ChangeImageIDS[] = model('BanInfo')->uploads($v, $k);
                    }
                }
                if(isset($ChangeImageIDS)){
                    $data['BanImageIDS'] = implode(',', $ChangeImageIDS);   //返回的是使用权变更的影像资料id(多个以逗号隔开)
                }
            }
            // 验证
            $arr = explode(',', $data['xy']);
            $data['BanGpsX'] = $arr[0];
            $data['BanGpsY'] = $arr[1];
            unset($data['xy']);
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            $data['InstitutionID'] = Db::name('institution')->where('id', 'eq', $data['TubulationID'])->value('pid');
            $result = $this->validate($data,'BanInfo');
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
                    $allData[$k1]['name'] = Config::get($k1);
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
                    Db::name('house')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['BanAddress']);
                    Db::name('room')->where('BanID', 'eq', $data['BanID'])->setField('BanAddress',$data['BanAddress']);
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
        $data['BanImageIDS'] = Db::name('upload_file')->where('id' ,'in' ,explode(',',$data['BanImageIDS']))->field('FileTitle ,FileUrl')->select();
        return $data?jsons('2000', '获取成功', $data):jsons('4000', '获取失败');
    }

    public function delete()
    {
        $banID = input('BanID');
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
                return jsons(4000, '删除失败，参数异常！');
            }
        }
    }

    /**
     * 楼栋确认，由临时状态变为可用状态
     */
    public function confirm(){
        $banID = input('BanID');
        if(!$banID) return jsons('4000','参数缺失');
        $res = Db::name('ban')->where('BanID', 'eq', $banID)->setField('Status',1);
        if($res){
            return jsons('2000','确认成功！');
        }else{
            return jsons('4000','确认失败！');
        }
    }

}
