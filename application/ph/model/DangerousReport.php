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

class DangerousReport extends Model
{
    public function index(){

        $map = 'BanAddress ,BanUnitNum ,BanYear ,BanFloorNum ,OwnerType,b.DamageGrade ,TubulationID ,InstitutionID,TotalArea ,PreRent ,Institution,a.Status';

        $data = Db::name('ban')->alias('a')
            ->join('ban_damage_grade b','a.DamageGrade = b.id','left')
            ->join('institution c','a.TubulationID = c.id','left')
            ->field($map)
            ->where('a.DamageGrade','in',[4,5])
            ->where('a.Status',1)
            ->select();
        
        return $data;
    }
}