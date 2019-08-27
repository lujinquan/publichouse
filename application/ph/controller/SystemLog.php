<?php
namespace app\ph\controller;

use think\Cache;
use think\Debug;
use think\Db;

/**
 * 系统日志控制器
 */
class SystemLog extends Base
{
    private $nowmonth;
    private $cachetime = 0;

    protected function _initialize(){
        parent::_initialize();
        $this->nowmonth = date('Ym',time());
        $this->nowyear = date('Y',time());
        //$this->nowyear = '2018';
        //$this->nowmonth = '201906';
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
        $nowmonth = $this->nowmonth;
        //$nowmonth = '201906';
        $HouseReportdata = model('ph/PropertyReport')->index($nowmonth);
        Debug::remark('end');
        $where = [
            'type' => 'PropertyReport',
            'date' => $nowmonth,
        ];
        $res = Db::name('report')->where($where)->find();
        if($res){
            $re = Db::name('report')->where($where)->update(['data'=>json_encode($HouseReportdata)]);
        }else{
            $re = Db::name('report')->insert([
                'data'=>json_encode($HouseReportdata),
                'type'=>'PropertyReport',
                'date'=>$nowmonth,
            ]);
        }
        // $res = Cache::store('file')->set('PropertyReport' . date('Y', time()), json_encode($HouseReportdata), $this->cachetime);
        //halt($re);
        return ($re !== false)?jsons('2000',$nowmonth.'报表保存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','保存失败');
    }

    /**
     * 缓存房屋统计报表
     */
    public function HouseReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $month = $this->nowmonth;
        //$month = '201906';
        $HouseReportdata = model('ph/HouseReports')->runCache();
        //$s = Cache::store('file')->get('HouseReport' . $month);
        $where = [
            'type'=>'HouseReport',
            'date'=>$month,
        ];
        //Cache::store('file')->set(('HouseReport'.$month), json_encode($HouseReportdata), $this->cachetime);
        $res = Db::name('report')->where($where)->find();
//halt($HouseReportdata);
        if($res){
            $re = Db::name('report')->where($where)->update(['data'=>json_encode($HouseReportdata)]);
        }else{
            $re = Db::name('report')->insert([
                'data'=>json_encode($HouseReportdata),
                'type'=>'HouseReport',
                'date'=>$month,
            ]);
        }
        Debug::remark('end');

        if($re !== false){
            return $this->success($month.'报表，保存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's','HouseReport/index');
        }else{
            return $this->error($month.'报表，保存失败，耗时'.Debug::getRangeTime('begin', 'end') . 's','HouseReport/index');
        }

        //$res = Cache::store('file')->set('HouseReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        //return $re?jsons('2000','保存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','保存失败');
    }

    /**
     * 缓存月租金报表
     */
    public function RentReportCache(){
        $date = $this->nowmonth;
        //$date = 201907;
        set_time_limit(0);
        Debug::remark('begin');
        //halt($date);
        //return jsons('100','测试一下');
        $HouseReportdata = model('ph/RentReports')->index($date);
        

        Debug::remark('end');
        $where = [
            'type'=>'RentReport',
            'date'=> $date,
        ];
        $res = Db::name('report')->where($where)->find();
        //halt($res);
        if($res){
            $re = Db::name('report')->where($where)->update(['data'=>json_encode($HouseReportdata)]);
        }else{
            $re = Db::name('report')->insert([
                'data'=>json_encode($HouseReportdata),
                'type'=>'RentReport',
                'date'=>$date,
            ]);
        }
        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        $whereRent = [];
        $whereRent['type'] = 1;

        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $whereRent['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $whereRent['InstitutionPID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }
        $counts = Db::name('rent_order')->where($whereRent)->count('id');
        $msg = '。';
        if($counts){
            $msg = '，您有 '. $counts . ' 条账单未处理！';
        }
        //$res = Cache::store('file')->set('RentReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return ($re !== false)?jsons('2000',$date.'月报，保存成功'.$msg):jsons('4000','保存失败');
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