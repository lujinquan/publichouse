<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use app\ph\model\BanInfo as BanInfoModel;
use think\Db;

class BanInfo extends Base
{


    public function index()
    {

//halt(config());

        //所有公共设施
        //$faciLst = $this->BanInfoModel->get_all_facilities();
        //所有的街道
        $areaTwo = $this->BanInfoModel->get_area(2);
        //所有的社区
        $areaThree = $this->BanInfoModel->get_area(3);
        $banLst = $this->BanInfoModel->get_all_ban_lst(array('between' ,[1,9]));
//halt($banLst['option']);
        $this->assign([
            'totalArea' => $banLst['tatalAreas'],
            'totalUseArea' => $banLst['tatalUseAreas'],
            'tatalBanPrerent' => $banLst['tatalBanPrerents'],
            'banLst' => $banLst['arr'],
            'banLstObj' => $banLst['obj'],
            'banOption' => $banLst['option'],
            //'faciLst' => $faciLst,
            'areaTwo' => $areaTwo,
            'areaThree' => $areaThree,
        ]);
        return $this->fetch();
    }

    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            // 验证
            $result = $this->validate($data, 'BanInfo');
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
            if(!$data['xy']){
                return jsons('4002' ,'请输入经纬度');
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
            $data['BanID'] = $maxBanID?$maxBanID + 1:$banID . '0001'; 
            $data['BanAddress'] = $areaTwo . $areaThree . $data['AreaFour']; 
            $data['CreateUserID'] = UID;
            $data['Status'] = 0; 
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea']; 
            $data['TotalNum'] = $data['CivilNum'] + $data['PartyNum'] + $data['EnterpriseNum']; 
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

    public function addOld()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = array_no_space_str($this->request->post());
            $data['TubulationID'] = isset($data['TubulationID'])?$data['TubulationID']:session('user_base_info.institution_id');
            // 验证
            $result = $this->validate($data, 'BanInfo');
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
            if(!$data['xy']){
                return jsons('4002' ,'请输入经纬度');
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
            $data['BanID'] = $maxBanID?$maxBanID + 1:$banID . '0001'; 
            $data['BanAddress'] = $areaTwo . $areaThree . $data['AreaFour']; 
            $data['CreateUserID'] = UID; 
            $data['Status'] = 1; 
            $data['TotalArea'] = $data['CivilArea'] + $data['PartyArea'] + $data['EnterpriseArea']; 
            $data['TotalNum'] = $data['CivilNum'] + $data['PartyNum'] + $data['EnterpriseNum']; 
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
