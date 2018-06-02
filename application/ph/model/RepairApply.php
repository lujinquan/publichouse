<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Piginator;
use think\Exception;
use think\Session;
use think\Db;

class RepairApply extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__REPAIR_APPLY__';
    private $applyId = null;

    /**
     * 获得小修申请列表信息
     */
    public function get_repair_light_list(){
        $list = Db::name('repair_light')->select();
        return $list;
    }
    /**
     * 根据lightRepairList获取house列表
     */
    public function get_house_info($lightRepairList){
        $list = array();
        foreach ($lightRepairList as $apply) {
            $info = Db::name('house')->where('HouseID', $apply['HouseID'])->find();
            $list[] = $info;
        }
        return $list;
    }
    /**
     * 生成小修信息
     */
    public function light_repair_data($data){
        $lightRepairData['items'] = '';
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $lightRepairData[$key] = $value;
            } else {
                if ($key == 'ItemID') {
                    for ($i=0; $i < 4; $i++) { 
                        if($value[$i] != '请选择')
                            $lightRepairData['items'] .= $value[$i] . ',';
                    }
                }
            }
        }
        // return $lightRepairData;
        $houseId = $data['HouseID'];
        $houseDate = Db::name('house')->where('HouseID', $houseId)->find();
        $tenantDate = Db::name('tenant')->where('TenantID', $houseDate['TenantID'])->find();
        $banDate = Db::name('ban')->where('BanID', $houseDate['BanID'])->find();
        $institutionData = Db::name('institution')->where('id', $houseDate['InstitutionID'])->find();
        $lightRepairData['ApplyID'] = date('YmdHis', time()) . '';
        $lightRepairData['ApplyDepartment'] = Session::get('user_base_info.institution_name');
        $lightRepairData['Operator'] = Session::get('user_base_info.name');
        $lightRepairData['ApplyTime'] = date('Y-m-d H:i:s', time());
        $lightRepairData['UnitID'] = $houseDate['UnitID'];
        $lightRepairData['FloorID'] = $houseDate['FloorID'];
        $lightRepairData['TenantID'] = $houseDate['TenantID'];
        $lightRepairData['TenantName'] = $houseDate['TenantName'];
        $lightRepairData['TenantTel'] = $tenantDate['TenantTel'];
        $lightRepairData['Institution'] = $institutionData['Institution'];
        $lightRepairData['InstitutionID'] = $houseDate['InstitutionID'];
        $lightRepairData['InstitutionPID'] = $houseDate['InstitutionPID'];
        $lightRepairData['BanID'] = $banDate['BanID'];
        $lightRepairData['BanAddress'] = $banDate['BanAddress'];
        $lightRepairData['OwnerType'] = $banDate['OwnerType'];

        $this->applyId = $lightRepairData['ApplyID'];

    	return $lightRepairData;
    }
    /**
     * 生成小修维修项目信息
     */
    public function repair_items_data($data){
        $itemsData = array();
        for ($i=0; $i < 4; $i++) { 
            if($data['ItemID'][$i] == '请选择')
                break;
        }
        $k = $i;
    	foreach ($data as $key => $value) {
    		if (is_array($value)) {
    			for ($i=0; $i < $k; $i++) { 
    				$itemsData[$i][$key] = $value[$i];
    			}
    		}
    	}
        for ($i=0; $i < $k; $i++) { 
            $itemsData[$i]['ApplyID'] = $this->applyId;
        }
        
    	return $itemsData;
    }

    /**
     * 根据banId获取楼栋信息
     * @param $banId 楼栋编号
     * @return 如果$banId不为null，返回对应楼栋编号的数据，否则返回所有楼栋数据
     */
    public function get_ban_data($banId = null){
        if($banId !== null)
            return Db::name('ban')->where('BanID', $banId)->find();
        else
            return Db::name('ban')->select();
    }
    /**
     * 根据houseId获取住户信息
     * @param $houseId 住户编号
     * @return 如果$houseId不为null，返回对应住户编号的数据，否则返回所有住户数据
     */
    public function get_house_data($houseId = null){
        if($houseId !== null)
            return Db::name('house')->where('HouseID', $houseId)->find();
        else
            return Db::name('house')->select();
    }
    /**
     * 根据tenantId获取人口信息
     * @param $tenantId 人口编号
     * @return 如果$tenantId不为null，返回对应人口编号的数据，否则返回所有人口数据
     */
    public function get_tenant_data($tenantId = null){
        if($houseId !== null)
            return Db::name('tenant')->where('TenantID', $tenantId)->find();
        else
            return Db::name('tenant')->select();
    }

    /**
     * 生成中修信息(房屋维修)
     * @param $data 申请信息，包含楼栋编号、维修内容
     */
    public function middle_repair_data($data){
        $middleInfo = array();// 中修信息存储
        $repairContent = $data['RepairContent'];
        $banInfo = self::get_ban_data($data['BanID']);// 获取楼栋基本信息

        // 生成中修信息
        $middleInfo['ApplyTime'] = date('Y-m-d H:i:s', time());
        $lightRepairData['Department'] = Session::get('user_base_info.institution_name');
        $middleInfo['Operator'] = Session::get('user_base_info.name');
        $middleInfo['BanID'] = $banInfo['BanID'];
        $middleInfo['BanAddress'] = $banInfo['BanAddress'];
        $middleInfo['OwnerTypeBefore'] = $banInfo['OwnerType'];
        $middleInfo['UseNatureBefore'] = $banInfo['UseNature'];
        $middleInfo['DamageGradeBefore'] = $banInfo['DamageGrade'];
        $middleInfo['StructureTypeBefore'] = $banInfo['StructureType'];
        $middleInfo['BanNumBefore'] = 1;
        $middleInfo['FloorNumBefore'] = $banInfo['BanFloorNum'];
        $middleInfo['HouseNumBefore'] = $banInfo['TotalHouseholds'];
        $middleInfo['AreaBefore'] = $banInfo['TotalArea'];// 建筑面积
        $middleInfo['CoveredArea'] = $banInfo['CoveredArea'];
        $middleInfo['RepairContent'] = $repairContent;
        $middleInfo['State'] = '待审批';

        return $middleInfo;
    }
    /**
     * 生成电线隐患数据
     * @param $data 申请信息，包含楼栋编号、维修内容
     */
    public function wire_repair_data($data){
        $wireInfo = array();// 电线信息存储
        $wireContent = $data['RepairContent'];
        $banInfo = self::get_ban_data($data['BanID']);// 获取楼栋基本信息

        // 生成中修信息
        $wireInfo['ApplyTime'] = date('Y-m-d H:i:s', time());
        $lightRepairData['Department'] = Session::get('user_base_info.institution_name');
        $wireInfo['Operator'] = Session::get('user_base_info.name');
        $wireInfo['BanID'] = $banInfo['BanID'];
        $wireInfo['BanAddress'] = $banInfo['BanAddress'];
        $wireInfo['Street'] = '';
        $wireInfo['Community'] = '';
        $wireInfo['UseNature'] = $banInfo['UseNature'];
        $wireInfo['StructureType'] = $banInfo['StructureType'];
        $wireInfo['BanNum'] = 1;
        $wireInfo['FloorNum'] = $banInfo['BanFloorNum'];
        // $wireInfo['HouseCommonNum'] = '';
        // $wireInfo['HousePrivateNum'] = '';
        $wireInfo['Area'] = $banInfo['TotalArea'];// 建筑面积
        $wireInfo['HiddenDanger'] = $wireContent;
        $wireInfo['State'] = '待审批';

        return $wireInfo;
    }
}