<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Exception;
use think\Db;

class RentPre extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__RENT_RECHARGE__';

    public function get_all_rent_recharge_lst()
    {
        $preRentLst['option'] =array();
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
        }

        if($searchForm = input('param.')) {

            foreach ($searchForm as &$val) { //去首尾空格
                $val = trim($val);
            }
            $preRentLst['option'] = $searchForm;

            //halt($searchForm);

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $level = Db::name('institution')->where('id','eq',$searchForm['TubulationID'])->value('Level');
                if($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }elseif($level == 2){
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%'.$searchForm['TenantName'].'%');
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {   //检索产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if (isset($searchForm['UseNature']) && $searchForm['UseNature']) {   //检索使用性质
                $where['UseNature'] = array('eq', $searchForm['UseNature']);
            }
            if (isset($searchForm['IfPrint']) && $searchForm['IfPrint']) {  //检索是否打印过发票
                $where['IfPrint'] = array('eq', $searchForm['IfPrint']);
            }
            if (isset($searchForm['TenantID']) && $searchForm['TenantID']) {  //模糊检索租户编号
                $where['TenantID'] = array('like', '%'.$searchForm['TenantID'].'%');
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //模糊检索房屋编号
                $where['HouseID'] = array('like', '%'.$searchForm['HouseID'].'%');
            }
            if(isset($searchForm['TempDate']) && $searchForm['TempDate']){     
                $where['TempDate'] = array('eq',str_replace('/','',$searchForm['TempDate']));   
            }
        }
        if(!isset($where)){
            $where = 1;
        }

        $preRentLst['obj'] = self::field('*')->order('id desc')->where($where)->paginate(config('paginate.list_rows'));

        $preRentLst['rechargeMoney'] = self::where($where)->value('sum(Money) as rechargeMoney');

        $preRentLst['arr'] = $preRentLst['obj']->all() ? $preRentLst['obj']->all() : array();

        foreach ($preRentLst['arr'] as $k => &$v) {

            $v["OwnerType"] = get_owner($v["OwnerType"]);
            $v["UseNature"] = get_usenature($v["UseNature"]);
            $v['CreateTime'] = date('Y/m/d' ,$v['CreateTime']);
            $v['Institution'] = get_institution($v['InstitutionID']);
            $v['IfPrintSign'] = $v['IfPrint'] == 1?'是':'否';
            
        }

        return $preRentLst;
    }
}