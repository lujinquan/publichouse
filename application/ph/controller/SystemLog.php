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
        //$this->nowmonth = '202003';
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
        //$nowmonth = '201912';
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
     * 缓存产权统计报表
     */
    public function PropertyReportYearCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $nowyear = $this->nowyear;
        //$nowyear = '2019';
        $HouseReportdata = model('ph/PropertyReportYear')->index($nowyear);
        Debug::remark('end');
        $where = [
            'type' => 'PropertyReport',
            'date' => $nowyear,
        ];
        $res = Db::name('report')->where($where)->find();
        if($res){
            $re = Db::name('report')->where($where)->update(['data'=>json_encode($HouseReportdata)]);
        }else{
            $re = Db::name('report')->insert([
                'data'=>json_encode($HouseReportdata),
                'type'=>'PropertyReport',
                'date'=>$nowyear,
            ]);
        }
        // $res = Cache::store('file')->set('PropertyReport' . date('Y', time()), json_encode($HouseReportdata), $this->cachetime);
        //halt($re);
        return ($re !== false)?jsons('2000',$nowyear.'报表保存成功，耗时'.Debug::getRangeTime('begin', 'end') . 's'):jsons('4000','保存失败');
    }

    /**
     * 缓存房屋统计报表
     */
    public function HouseReportCache(){

        set_time_limit(0);
        Debug::remark('begin');
        $month = $this->nowmonth;
        //$month = '201912';
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

        if ($this->request->isAjax()) {
           
            $getData = $this->request->get();
            if($getData){
                $currentUserInstitutionID = session('user_base_info.institution_id');

                if(isset($getData['TubulationID'])){
                    $currentUserInstitutionID = $getData['TubulationID'];
                }
                $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
                $whereRent = [];
                //$whereRent['type'] = 1;
                $whereRent['OrderDate'] = str_replace('-', '', $getData['month']);
                $owerLst = [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    5 => 5,
                    7 => 7,
                    10 => '1,3,7',
                    11 => '1,2,3,7',
                    12 => '1,2,3,5,7',
                ];

                $whereRent['OwnerType'] = array('in',$owerLst[$getData['OwnerType']]);

                if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
                    $whereRent['InstitutionID'] = array('eq', $currentUserInstitutionID);
                } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
                    $whereRent['InstitutionPID'] = array('eq', $currentUserInstitutionID);
                } else {   //用户为公司级别，则获取所有子管段
                }

                $counts = Db::name('rent_order')->where($whereRent)->count('id');

                $whereRent['type'] = 1;

                $countss = Db::name('rent_order')->where($whereRent)->count('id');
                //dump($counts);halt($countss);
                $msg = '';
                if(!$counts){
                    $msg = '请先生成'.$getData['month'].'月，账单！';
                }else{
                    if($countss){
                        $msg = '您有 '. $countss . ' 条账单未处理！';
                    }else{
                        $msg = '检测完成！';
                    }  
                }
            
                return jsons('2000',$msg);
            }
            
            
        }


        $date = $this->nowmonth;
        //$date = 201912;
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
        
        //$res = Cache::store('file')->set('RentReport' . $this->nowmonth, json_encode($HouseReportdata), $this->cachetime);
        return ($re !== false)?jsons('2000',$date.'月报，保存成功！'):jsons('4000','保存失败');
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