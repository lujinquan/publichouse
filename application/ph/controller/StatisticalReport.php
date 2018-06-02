<?php
/**
 * 维修报表
 * @author sky
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;
use think\Config;

class StatisticalReport extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
    	return $this->fetch();
    }
    /**
     *  小修月报表
     */
    public function lightRepairForm(){
        $count = $this->get_light_repair_count();
        print_r($count);exit();
    }
    /**
     * 季度维修计划明细表，每季度第一个月5号之前
     */
    public function middleQuarterForm(){
        // $large = $this->get_large_pending_approval();
        // $middle = $this->get_middle_pending_approval();
        // $total = $this->get_total_pending_approval();

        $large = $this->get_pending_approval('large');
        $middle = $this->get_pending_approval('middle');
        $total = $this->get_pending_approval('total');
        $ret = array(
            'large' => $large,
            'middle' => $middle,
            'total' => $total
            );
        print_r($res);exit();
    }
    /**
     * 老旧物业服务情况月报表
     */
    public function oldPropertyMonthForm(){
        $data = $this->get_old_property_of_month();
        print_r($data);exit();
    }
    /**
     * 房&线月报表
     */
    public function wireAndReformForm(){
        $wire = $this->wireMonthForm();
        $reform = $this->reformMonthForm();
        print_r($reform);exit();
    }
    /**
     * 老化电线月报表(房&线)
     */
    public function wireMonthForm(){
        $data = $this->get_wire_of_month();
        return $data;
        // print_r($data);exit();
    }
    /**
     * 危旧房翻修改造月报表(房&线)
     */
    public function reformMonthForm(){
        $data = $this->get_reform_of_month();
        return $data;
        // print_r($data);exit();
    }





    







// ============================================================================================= //
                    //函数分割线
// ============================================================================================= //





    /**
     * 维修项目统计细节
     * @return 维修项目统计细节
     */
    public function get_light_repair_count(){
        /*$itemsData = Db::name('repair_project')->field('ItemID,sum(RealMaterialNum) sum')->group('ItemID')->select();*/
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
        $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        $sql = "select ApplyID,LaborCost,MaterialCost,ManageCost,Total from ph_repair_light where ApplyTime BETWEEN '" . $start . "' and '" . $end . "';";
        $lightRepairData = Db::query($sql);

        $in = array();
        foreach ($lightRepairData as $key => $value) {
            $in[] = $value['ApplyID'];
        }
        $ins = implode(',', $in);
        $sql = 'select ItemID,sum(RealMaterialNum) sum from ph_repair_project where ApplyID in(';
        $sql .= $ins;
        $sql .= ') GROUP BY ItemID';
        $count = Db::query($sql);

        $monthCost = array(
            'LaborCost' => 0, 
            'MaterialCost' => 0, 
            'ManageCost' => 0, 
            'Total' => 0
            );
        foreach ($lightRepairData as $key => $value) {
            $monthCost['LaborCost'] += $value['LaborCost'];
            $monthCost['MaterialCost'] += $value['MaterialCost'];
            $monthCost['ManageCost'] += $value['ManageCost'];
            $monthCost['Total'] += $value['Total'];
        }
        return array(
            'count' => $count,// 项目明细
            'monthCost' => $monthCost// 本月
            );
        // 累计待议
    }

    /**
     * 大修计划和小计
     */
    public function get_large_pending_approval(){
        $largeData = Db::name('repair_middle')->where('State', '待审批')->where('PlanCost', 'egt', Config::get('middleDevide'))->select();
        $largeCount = array(
            'BanNumBefore' => 0,
            'FloorNumBefore' => 0,
            'HouseNumBefore' => 0,
            'AreaBefore' => 0,
            'BanNumAfter' => 0,
            'FloorNumAfter' => 0,
            'AreaAfter' => 0,
            'PlanCost' => 0
            );
        foreach ($largeData as $info) {
            $largeCount['BanNumBefore'] += $info['BanNumBefore'];
            $largeCount['FloorNumBefore'] += $info['FloorNumBefore'];
            $largeCount['HouseNumBefore'] += $info['HouseNumBefore'];
            $largeCount['AreaBefore'] += $info['AreaBefore'];
            $largeCount['BanNumAfter'] += $info['BanNumAfter'];
            $largeCount['FloorNumAfter'] += $info['FloorNumAfter'];
            $largeCount['AreaAfter'] += $info['AreaAfter'];
            $largeCount['PlanCost'] += $info['PlanCost'];
        }
        return array(
            'largeData' => $largeData,
            'largeCount' => $largeCount
            );
    }
    /**
     * 中修计划和小计
     */
    public function get_middle_pending_approval(){
        $middleData = Db::name('repair_middle')->where('State', '待审批')->where('PlanCost', 'lt', Config::get('middleDevide'))->select();
        $middleCount = array(
            'BanNumBefore' => 0,
            'FloorNumBefore' => 0,
            'HouseNumBefore' => 0,
            'AreaBefore' => 0,
            'BanNumAfter' => 0,
            'FloorNumAfter' => 0,
            'AreaAfter' => 0,
            'PlanCost' => 0
            );
        foreach ($middleData as $info) {
            $middleCount['BanNumBefore'] += $info['BanNumBefore'];
            $middleCount['FloorNumBefore'] += $info['FloorNumBefore'];
            $middleCount['HouseNumBefore'] += $info['HouseNumBefore'];
            $middleCount['AreaBefore'] += $info['AreaBefore'];
            $middleCount['BanNumAfter'] += $info['BanNumAfter'];
            $middleCount['FloorNumAfter'] += $info['FloorNumAfter'];
            $middleCount['AreaAfter'] += $info['AreaAfter'];
            $middleCount['PlanCost'] += $info['PlanCost'];
        }
        return array(
            'middleData' => $middleData,
            'middleCount' => $middleCount
            );
    }
    /**
     * 合计
     */
    public function get_total_pending_approval(){
        $totalData = Db::name('repair_middle')->where('State', '待审批')->select();
        $totalCount = array(
            'BanNumBefore' => 0,
            'FloorNumBefore' => 0,
            'HouseNumBefore' => 0,
            'AreaBefore' => 0,
            'BanNumAfter' => 0,
            'FloorNumAfter' => 0,
            'AreaAfter' => 0,
            'PlanCost' => 0
            );
        foreach ($totalData as $info) {
            $totalCount['BanNumBefore'] += $info['BanNumBefore'];
            $totalCount['FloorNumBefore'] += $info['FloorNumBefore'];
            $totalCount['HouseNumBefore'] += $info['HouseNumBefore'];
            $totalCount['AreaBefore'] += $info['AreaBefore'];
            $totalCount['BanNumAfter'] += $info['BanNumAfter'];
            $totalCount['FloorNumAfter'] += $info['FloorNumAfter'];
            $totalCount['AreaAfter'] += $info['AreaAfter'];
            $totalCount['PlanCost'] += $info['PlanCost'];
        }
        return $totalCount;
    }

    /**
     * @param 获取的数据种类，包括大修large，中修middle，合计total
     * @return 相应数据
     */
    public function get_pending_approval($param){
        $data = null;
        switch ($param) {
            case 'large':
                $data = Db::name('repair_middle')->where('State', '待审批')->where('PlanCost', 'egt', Config::get('middleDevide'))->select();
                break;
            case 'middle':
                $data = Db::name('repair_middle')->where('State', '待审批')->where('PlanCost', 'lt', Config::get('middleDevide'))->select();
                break;
            case 'total':
                $data = Db::name('repair_middle')->where('State', '待审批')->select();
                break;
            default:
                break;
        }
        $count = array(
            'BanNumBefore' => 0,
            'FloorNumBefore' => 0,
            'HouseNumBefore' => 0,
            'AreaBefore' => 0,
            'BanNumAfter' => 0,
            'FloorNumAfter' => 0,
            'AreaAfter' => 0,
            'PlanCost' => 0
            );
        foreach ($data as $info) {
            $count['BanNumBefore'] += $info['BanNumBefore'];
            $count['FloorNumBefore'] += $info['FloorNumBefore'];
            $count['HouseNumBefore'] += $info['HouseNumBefore'];
            $count['AreaBefore'] += $info['AreaBefore'];
            $count['BanNumAfter'] += $info['BanNumAfter'];
            $count['FloorNumAfter'] += $info['FloorNumAfter'];
            $count['AreaAfter'] += $info['AreaAfter'];
            $count['PlanCost'] += $info['PlanCost'];
        }
        $ret = null;
        switch ($param) {
            case 'large':
                $ret = array(
                    'largeData' => $data,
                    'largeCount' => $count
                    );
                break;
            case 'middle':
                $ret = array(
                    'middleData' => $data,
                    'middleCount' => $count
                    );
                break;
            case 'total':
                $ret = $count;
                break;
            default:
                break;
        }
        return $ret;
    }

    /**
     * 老旧物业月报数据
     */
    public function get_old_property_of_month(){
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
        $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        $data = Db::name('repair_old_property')->select();
        return $data;
    }
    /**
     * 电线
     */
    public function get_wire_of_month(){
        $start = date('Y-m-01 00:00:00', strtotime(date("Y-m-d")));
        $end = date('Y-m-d 00:00:00', strtotime("$start +1 month -1 day"));
        $lastMonthEnd = date('Y-m-d 00:00:00',strtotime("$start -1 day"));
        $lastMonthStart = date('Y-m-d 00:00:00',strtotime("$start -1 month"));
        $okdata = Db::name('repair_wire')->where('State', '完成')->where('EndDate', 'BETWEEN', [$lastMonthStart,  $lastMonthEnd])->select();
        $nokdata = Db::name('repair_wire')->where('State', 'not in', ['待审批', '已审批', '完成'])->where('ApplyTime', 'elt', $lastMonthEnd)->select();
        // 总计
        $totalCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0,
            'wireLen' => 0
            );
        // 施工中
        $nokCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0,
            'wireLen' => 0
            );
        // 已完工
        $okCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0,
            'wireLen' => 0
            );
        // 已完工
        foreach ($okdata as $info) {
            $okCount['BanNum'] += $info['BanNum'];
            $okCount['HouseNum'] += $info['HouseCommonNum'] + $info['HousePrivateNum'];
            $okCount['Area'] += $info['Area'];
            $okCount['wireLen'] += $info['ChangeQuantityCommom'] + $info['ChangeQuantityPrivate'];
        }
        // 施工中
        foreach ($nokdata as $info) {
            $nokCount['BanNum'] += $info['BanNum'];
            $nokCount['HouseNum'] += $info['HouseCommonNum'] + $info['HousePrivateNum'];
            $nokCount['Area'] += $info['Area'];
            $nokCount['wireLen'] += $info['ChangeQuantityCommom'] + $info['ChangeQuantityPrivate'];
        }
        // 总计
        $totalCount['BanNum'] = $okCount['BanNum'] + $nokCount['BanNum'];
        $totalCount['HouseNum'] = $okCount['HouseNum'] + $nokCount['HouseNum'];
        $totalCount['Area'] = $okCount['Area'] + $nokCount['Area'];
        $totalCount['wireLen'] = $okCount['wireLen'] + $nokCount['wireLen'];
        $ret = array(
            'totalCount' => $totalCount,
            'nokCount' => $nokCount,
            'okCount' => $okCount
            );
        return $ret;
    }
    /**
     * 翻修重建月报数据
     */
    public function get_reform_of_month(){
        $start = date('Y-m-01 00:00:00', strtotime(date("Y-m-d")));
        $end = date('Y-m-d 00:00:00', strtotime("$start +1 month -1 day"));
        $lastMonthEnd = date('Y-m-d 00:00:00',strtotime("$start -1 day"));
        $lastMonthStart = date('Y-m-d 00:00:00',strtotime("$start -1 month"));
        $nokdata = Db::name('repair_middle')->where('State', 'not in', ['待审批', '已审批', '完成'])->where('ApplyTime', 'elt', $lastMonthEnd)->where('DamageGradeBefore', 'egt', Config::get('reformDevide'))->select();
        $okdata = Db::name('repair_middle')->where('State', '完成')->where('EndDate', 'between',[$lastMonthStart ,$lastMonthEnd])->where('DamageGradeBefore', 'egt', Config::get('reformDevide'))->select();
        // 总计
        $totalCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0,
            'cost' => 0
            );
        // 施工中
        $nokCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0
            );
        // 已完工
        $okCount = array(
            'BanNum' => 0,
            'HouseNum' => 0,
            'Area' => 0
            );
        foreach ($nokdata as $info) {
            // 施工中
            $nokCount['BanNum'] += $info['BanNumBefore'];
            $nokCount['HouseNum'] += $info['HouseNumBefore'];
            $nokCount['Area'] += $info['AreaBefore'];
            $totalCount['cost'] += $info['PlanCost'];
        }
        foreach ($okdata as $info) {
            $okCount['BanNum'] += $info['BanNumAfter'];
            $okCount['HouseNum'] += $info['FloorNumAfter'];
            $okCount['Area'] += $info['HouseNumAfter'];
            $monthCost['cost'] += $info['PlanCost'];
        }
        $totalCount['BanNum'] = $okCount['BanNum'] + $nokCount['BanNum'];
        $totalCount['HouseNum'] = $okCount['HouseNum'] + $nokCount['HouseNum'];
        $totalCount['Area'] = $okCount['Area'] + $nokCount['Area'];

        $ret = array(
            'totalCount' => $totalCount,
            'nokCount' => $nokCount,
            'okCount' => $okCount
            );
        return $ret;
    }

}