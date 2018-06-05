<?php
namespace app\ph\controller;

use think\Cache;
use think\Debug;

/**
 * 系统日志控制器
 */
class SystemLog extends Base
{
    private $nowmonth;
    private $cachetime = 0;

    protected function _initialize(){
        parent::_initialize();
        //$this->nowmonth = date('Ym',time());
        $this->nowmonth = '201801';
    }

    /**
     * 系统日志主页
     */
    public function index(){

        $data = model('ph/SystemLog') -> get_all_logs();
        $allTypes = get_all_log_type();
        $this -> assign([
            'LogOption' => $data['option'],
            'allTypes' => $allTypes,
            'LogsLst' => $data['arr'],
            'LogsLstObj' => $data['obj'],
        ]);
        return $this->fetch();
    }

    /**
     * 缓存产权统计报表
     */
    public function PropertyReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/PropertyReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('PropertyReport' . date('Y', time()), json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存房屋统计报表
     */
    public function HouseReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/HouseReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('HouseReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存月租金报表
     */
    public function RentReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        //return jsons('100','测试一下');
        $HouseReportdata = model('ph/RentReport')->index();

        Debug::remark('end');
        $res = Cache::store('file')->set('RentReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000',$this->nowmonth.'月报缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存租金分析报表
     */
    public function RentAnalysisReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/RentAnalysisReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('RentAnalysisReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存代托管收支明细报表
     */
    public function InOutReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/InOutReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('InOutReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存核减租金汇总报表
     */
    public function RentCutReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/RentCutReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('RentCutReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

    /**
     * 缓存危严房报表
     */
    public function DangerousReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $HouseReportdata = model('ph/DangerousReport')->index();
        Debug::remark('end');
        $res = Cache::store('file')->set('DangerousReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return $res?jsons('2000','缓存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','缓存失败');
    }

}