<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;
use think\Model;
use think\Config;
use think\Exception;
use think\Loader;
use think\Db;


class OldCutRent extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__OLD_RENT__';

    public function get_all_old_rent()
    {
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
        }else{    //用户为公司级别，则获取所有子管段
        }

        $OldRentList['option'] =array();

        $searchForm = input('request.');

        foreach ($searchForm as &$val) { //去收尾空格
            $val = trim($val);
        }

        if(isset($searchForm['HouseID'])) {
            $OldRentList['option'] = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $level = Db::name('institution')->where('id','eq',$searchForm['TubulationID'])->value('Level');
                if($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }elseif($level == 2){
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if ($searchForm['OldPayMonth']) {  //检索缴费日期
                $where['OldPayMonth'] = array('eq', str_replace('-','',$searchForm['OldPayMonth']));
            }
            if ($searchForm['HouseID']) {  //模糊检索房屋编号
                $where['HouseID'] = array('like', '%'.$searchForm['HouseID'].'%');
            }
            if ($searchForm['BanAddress']) {  //模糊检索楼栋地址
                $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            }
            if ($searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%'.$searchForm['TenantName'].'%');
            }

        }

        $where = isset($where)?$where:1;

        $fields = '*';
        $OldRentList['obj'] = self::field($fields)->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $OldRentList['arr'] = $OldRentList['obj']?$OldRentList['obj']->all():array();

        return $OldRentList;
    }
}