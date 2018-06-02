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

class OrgManage extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__INSTITUTION__';

    public function get_all_org_lst(){

        $OrgLst['obj'] = self::field('id ,Institution ,Status')->order('id desc')->paginate(config('paginate.list_rows'));

        $OrgLst['arr'] = $OrgLst['obj']->all()?$OrgLst['obj']->all():array();

        foreach($OrgLst['arr'] as &$v){
            if($v['Status'] == 1){
                $v['Status'] = '有效';
            }else{
                $v['Status'] = '无效';
            }
        }

        return $OrgLst;
    }

    public function get_high_org_lst(){

        $data = self::field('id ,Institution ,Level ,Pid ')->where('Level','neq',3)->select();

        return $data;

    }
}