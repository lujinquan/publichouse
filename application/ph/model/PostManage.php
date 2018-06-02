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

class PostManage extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__POST__';

    public function get_all_post_lst(){


        $PostLst['obj'] = self::field('PostID ,PostName ,Status')->order('id desc')->paginate(config('paginate.list_rows'));
        
        $PostLst['arr'] = $PostLst['obj']->all()?$PostLst['obj']->all():array();


        foreach($PostLst['arr'] as $k=> &$v){
            if($v['Status'] == 1){
                $v['Status'] = '有效';
            }else{
                $v['Status'] = '无效';
            }
        }
        //dump($PostLst);exit;
        return $PostLst;
    }
}