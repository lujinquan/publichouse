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

class RentUnpaid extends Model
{
    public function batch_call($ids = array()){

        $re = Db::name('rent_order')->alias('a')
                                    ->join('tenant b','a.TenantID = b.TenantID','left')
                                    ->where('a.RentOrderID','in',$ids)
                                    ->field('a.TenantID ,a.TenantName,b.TenantBalance')
                                    ->select();

        $AppKey = config('AppKey');

        $AppSecret = config('AppSecret');

        $templateNumber = config('TemplateNumber');

        $serverAPI = new \SendMessage\ServerAPI($AppKey,$AppSecret,'fsockopen');

        if($re){

            foreach($re as &$v){
                //短信接口，所以需要调试，避免大量短信浪费
                halt($v);

                $v['TenantTel'] = Db::name('tenant')->where('TenantID' ,'eq' ,$v['TenantID'])->value('TenantTel');

                //发送模板短信
                $serverAPI->sendSMSTemplate($templateNumber,array($v['TenantTel']),array($v['TenantName'], $v['TenantBalance']));

            }

            //$serverAPI->sendSMSTemplate('3059645','18674012767',array('Mr.lu', '12.5'));

        }

    }
}