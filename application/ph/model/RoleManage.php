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
use think\Db;

class RoleManage extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_ROLE__';

    public function get_all_role_lst(){

        $RoleLst['obj'] = self::field('id ,RoleName ,Ifstation ,Status')->order('Status desc')->paginate(config('paginate.list_rows'));

        $RoleLst['arr'] = $RoleLst['obj']->all()?$RoleLst['obj']->all():array();

        foreach($RoleLst['arr'] as &$v){
            if($v['Status'] == 1){
                $v['Status'] = '有效';
            }else{
                $v['Status'] = '无效';
            }
            if($v['Ifstation'] == 1){
                $v['Ifstation'] = '是';
            }else{
                $v['Ifstation'] = '否';
            }
        }

        //dump($RoleLst['data']);exit;

        return $RoleLst;
    }
}