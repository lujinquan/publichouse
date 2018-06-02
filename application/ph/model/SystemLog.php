<?php

namespace app\ph\model;

use think\Model;

/**
 * 日志记录模型
 * @package app\admin\model
 */
class SystemLog extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_LOG__';

    /**
     * 获取所有日志
     * @param $actionType = ''
     * @param string $order 排序
     * @author Mr.Lu
     * @return 
     */
    public static function get_all_logs()
    {
        //操作人编号 ，行为类别 ，具体行为描述，操作时间

        $searchForm = input('request.');
        //halt($searchForm);

        $LogsLst['option'] = $searchForm;

        if(isset($searchForm['UserID'])) {
            
            if ($searchForm['UserID']) {   //管理员编号
                $where['UserID'] = array('like', '%'.$searchForm['UserID'].'%');
            }
            if ($searchForm['ActionType']) {   //管理员编号
                $where['ActionType'] = array('eq', $searchForm['ActionType']);
            }

            if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
                $start = strtotime($searchForm['DateStart']);
                $end = strtotime($searchForm['DateEnd']);
                //dump($start);dump($end);exit;
                if($start < $end){
                    $where['CreateTime'] = array('between',$start.",".$end);
                }
            }
            if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
                $start = strtotime($searchForm['DateStart']);
                //dump($start);exit;
                $where['CreateTime'] = array('egt',$start);
            }
            if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
                $end = strtotime($searchForm['DateEnd']);
                $where['CreateTime'] = array('elt',$end);
            }

        }

        if(!isset($where)){
            $where = 1;
        }

        $LogsLst['obj'] = self::field('id ,UserID ,ActionType ,Remark ,CreateTime')->where($where)->order('CreateTime desc')->paginate(config('paginate.list_rows'));

        $LogsLst['arr'] = $LogsLst['obj']->all()?$LogsLst['obj']->all():array();

        $allTypeNames = get_all_log_type();

        foreach($LogsLst['arr'] as &$v){

            $v['CreateTime'] = date('Y-m-d H:i:s' ,$v['CreateTime']);

            $v['ActionType'] = $allTypeNames[$v['ActionType']];
        }

        return $LogsLst;

    }
}