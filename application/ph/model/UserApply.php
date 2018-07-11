<?php

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Db;

class UserApply extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__USE_CHANGE_ORDER__';

    public function get_all_use_lst(){

        //筛选出只属于当前机构的申请
        
        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if($currentUserLevel == 3){  //用户为管段级别，则直接查询

            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);

        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询

            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);

        }else{    //用户为公司级别，则获取所有子管段


        }

        $ChangeList['option'] =array();

        if($searchForm = input('post.')) {

            foreach ($searchForm as &$val) { //去首尾空格
                $val = trim($val);
            }

            //halt($searchForm);

            $ChangeList['option'] = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                //dump($level);exit;
                if ($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }
            if (isset($searchForm['ChangeOrderID']) && $searchForm['ChangeOrderID']) {   //变更编号
                $where['ChangeOrderID'] = array('like', '%'.$searchForm['ChangeOrderID'].'%');
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //检索房屋编号
                $where['HouseID'] = array('like', '%'.$searchForm['HouseID'].'%');
            }
            if (isset($searchForm['ChangeType']) && $searchForm['ChangeType']) {  //检索变更类型
                $where['ChangeType'] = array('eq', $searchForm['ChangeType']);
            }
            if (isset($searchForm['UserName']) && $searchForm['UserName']) {  //检索操作人姓名
                $where['UserName'] = array('like', '%'.$searchForm['UserName'].'%');
            }
            if(isset($searchForm['CreateTime']) && $searchForm['CreateTime']){

                $starttime = strtotime($searchForm['CreateTime']);

                $endtime = $starttime + 3600*24;

                $where['CreateTime'] = array('between',[$starttime,$endtime]);
            }

        }

        $where['Status'] = array('not in' ,[0,1]);

        $ChangeList['obj'] = self::field('id')->where($where)->paginate(config('paginate.list_rows'));

        $arr = $ChangeList['obj']->all();

        if(!$arr){

            $ChangeList['arr'] = array();
        }

        //halt($arr);

        foreach($arr as $v){

            $ChangeList['arr'][] = self::get_one_change_info($v['id']);

        }

        //halt($ChangeList['arr']);
        return $ChangeList;
    }

    public function get_one_change_info($id = '' ,$map=''){

        //使用权变更单号 ，房屋编号 ，变更类型 ，操作机构 ，操作人 ，操作时间 ，状态
        if(!$map) $map='ChangeOrderID ,HouseID ,ChangeType ,HouseUsearea,BanAddress,OldTenantName, HousePrerent, OwnerType,InstitutionID ,UserNumber ,CreateTime ,Status';
        $data = $this->alias('a')->field($map)->where('id','eq',$id)->find();

        if(!$data){
            return array();
        }

        $data['InstitutionID'] = Db::name('institution')->where('id' ,'eq' ,$data['InstitutionID'])->value('Institution');

        $data['ChangeType'] = Db::name('use_change_type')->where('id','eq',$data['ChangeType'])->value('UseChangeTitle');

        $res = self::order_config_detail($data['ChangeOrderID'],$data['Status']);

        $data['Status'] = '待'.$res['RoleName'].$res['Title'];

        $data['ProcessRoleID'] = $res['RoleID'];

        $data['OwnerType'] = get_owner($data['OwnerType']);

        $data['UserNumber'] = Db::name('admin_user')->where('Number' ,'eq' ,$data['UserNumber'])->value('UserName');

        $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);

        return $data;
    }


    /**
     * @title 获取租户信息
     * @author Mr.Lu
     * @param  $changeOrderID  变更编号
     * @param  $status  主订单状态
     * @return array [ RoleName  下一步操作的角色名称 ， Title  下一步操作的步骤标题 ]
     */
    public function order_config_detail($changeOrderID ,$status){
        $config = Db::name('use_change_order')->alias('a')
                                              ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                              ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                              ->field('b.id, b.Title ,b.Total')
                                              ->find();

        $maps['pid'] = array('eq',$config['id']);
        $maps['Total'] = array('eq',$status);

        $res = Db::name('process_config')->where($maps)->field('RoleName ,Title ,RoleID')->find();

        return $res;

    }

    public function order_config($changeOrderID ){
        $config = Db::name('use_change_order')->alias('a')
            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
            ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
            ->value('Total');



        return $config;

    }

    /**
     * 检查是否可执行修改使用权变更
     * @description  当，已补充资料后
     * @author Mr.Lu
     * @return bool
     */
    public function check_edit($changeOrderID){

        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        if($status != 2){

            return false;
        }

        return true;
    }

    /**
     * 检查是否可执行删除使用权变更
     * @description  当，最后被确定为不通过的时候 ,或 ，还未补充资料的时候
     * @author Mr.Lu
     * @return bool
     */
    public function check_delete($changeOrderID){

        $status = self::where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        if($status == 0  || $status == 2){

            return true;
        }

        return false;
    }

}