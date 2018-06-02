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

class RepairItem extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__REPAIR_ITEM__';
}