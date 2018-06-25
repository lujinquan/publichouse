<?php

namespace app\api\controller;

use app\user\model\User as UserModel;
use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
use think\Db;
use think\Debug;

/**
 * @title 接口控制器
 * @author Mr.Lu
 * @description
 */
class Manage extends Controller
{
    public function signin()
    {
        if ($this->request->isPost()) {
            // 获取post数据
            $data = $this->request->post();

            $UserModel = new UserModel;

            $uid = $UserModel->login($data['username'], $data['password']);

            $userNumber = $UserModel->get($uid)->Number;

            $userRole = $UserModel->get($uid)->Role;

            $allowRoles = json_decode($userRole);

            if(in_array('112',$allowRoles) || in_array('116',$allowRoles) || in_array('117',$allowRoles)){
                return jsons('4000','非审核人员不能登录该系统');
            }
                
            return $uid?jsons('2000','登录成功！',['number'=>$userNumber]):jsons('4000','登录失败');
            
            
            
        } else {

            return is_signin() ? jsons('2000','登录成功！'): jsons('4000','登录失败');   //自动登录功能
            //return $this->fetch();
        }
    }

    /**
     * 退出登录
     * @author Mr.Lu
     */
    public function signout()
    {
        // 记录行为,1为登录登出标识，由于登录不在权限表中所以创建一个标识
        // $uid = session('user_base_info.uid');
        // if($uid){
        //     action_log('退出系统',$uid , 6 , 1);
        // }
        // session(null);
        // Cache::clear();

        //自动登录功能暂时不做
        //cookie('uid', null);
        //cookie('signin_token', null);

        return jsons('2000','退出成功',array());
    }

    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
            }

            $notices = Db::name('notice')->field('id, Title,UpdateTime')->order('UpdateTime desc')->limit(10)->select();

            foreach ($notices as &$v) {
                $v['UpdateTime'] = date('Y/m/d', strtotime($v['UpdateTime']));
            }

            $result['notices'] = $notices;
            $result['rents'] = Db::name('rent_order')->where(['OrderDate' => date('Ym', time()), 'InstitutionID' => $findOne['InstitutionID']])->field('sum(ReceiveRent) as ReceiveRents, sum(PaidRent) as PaidRents')->find();
            return jsons('2000', '获取成功', $result);

        }
    }

    public function getUseRecordlst(){

        if ($this->request->isGet()) {

            $data = $this->request->get();

            if (!isset($data['number'])) {
                 return jsons('4001', '参数缺失');
            }
            //筛选出只属于当前机构的申请
            $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();

            if(!$findOne){
                return jsons('4002', '参数错误');
            }

            $level = Db::name('institution')->where('id',$findOne['InstitutionID'])->column('Level');

            
            if($level == 3){  //用户为管段级别，则直接查询
                $where['InstitutionID'] = array('eq' ,$level);
            }elseif($level == 2){  //用户为所级别，则获取所有该所子管段，查询
                $where['InstitutionPID'] = array('eq' ,$level);
            }

            $where['Status'] = array('in' ,[0,1]);

            $ChangeList['obj'] = Db::name('use_change_order')->field('id')->where($where)->paginate(config('paginate.list_rows'));

            $arr = $ChangeList['obj']->all();

            if(!$arr){

                $ChangeList['arr'] = array();
            }

            //halt($arr);

            foreach($arr as $v){

                $k = $this->get_one_change_info($v['id'],$findOne['Role']);

                if($k['Status']){

                    $ChangeList['arr'][] = $k;
                }

                //$ChangeList['arr'][] = $this->get_one_change_info($v['id']);
            }

             if(isset($ChangeList['arr'])){
                return jsons('2000','获取成功',$ChangeList['arr']);
            }else{
                return jsons('2000','获取成功',array());
            }
        }

    }

    public function getUselst(){

        if ($this->request->isGet()) {

            $data = $this->request->get();

            if (!isset($data['number'])) {
                 return jsons('4001', '参数缺失');
            }
            //筛选出只属于当前机构的申请
            $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();

            if(!$findOne){
                return jsons('4002', '参数错误');
            }

            $level = Db::name('institution')->where('id',$findOne['InstitutionID'])->value('Level');

            
            if($level == 3){  //用户为管段级别，则直接查询
                $where['InstitutionID'] = array('eq' ,$findOne['InstitutionID']);
            }elseif($level == 2){  //用户为所级别，则获取所有该所子管段，查询
                $where['InstitutionPID'] = array('eq' ,$findOne['InstitutionID']);
            }

            $where['Status'] = array('not in' ,[0,1]);

            $ChangeList['obj'] = Db::name('use_change_order')->field('id')->where($where)->paginate(config('paginate.list_rows'));

            $arr = $ChangeList['obj']->all();

            if(!$arr){

                $ChangeList['arr'] = array();
            }

            //halt($arr);

            foreach($arr as $v){

                $k = $this->get_one_change_info($v['id'] ,$findOne['Role']);

                if(!isset($k['flag'])){
                    $ChangeList['arr']['before'][] = $k;
                }else{
                    $ChangeList['arr']['ing'][] = $k;
                }

                
                

                //$ChangeList['arr'][] = $this->get_one_change_info($v['id']);
            }

            if(!isset($ChangeList['arr']['before'])){
                $ChangeList['arr']['before'] = array();
            }
            if(!isset($ChangeList['arr']['ing'])){
               $ChangeList['arr']['ing'] = array(); 
            }

            $where['Status'] = array('in' ,[0,1]);



            $ChangeLists['obj'] = Db::name('use_change_order')->field('id')->where($where)->paginate(config('paginate.list_rows'));


            $arr1 = $ChangeLists['obj']->all();
//halt($arr1);
            if(!$arr1){

                $ChangeList['arr']['after'] = array();

            }else{
                
               foreach($arr1 as $v1){

                $g = $this->get_one_change_info($v1['id'] ,$findOne['Role']);

                
                $ChangeList['arr']['after'][] = $g;

                //$ChangeList['arr'][] = $this->get_one_change_info($v['id']);
                } 
            }  

             if(isset($ChangeList['arr'])){
                return jsons('2000','获取成功',$ChangeList['arr']);
            }else{
                return jsons('2000','获取成功',array());
            }
        }
        
    }

    /**
     * @title 查看明细
     * @author Mr.Lu
     * @description
     */
    public function detail(){

        if ($this->request->isGet()) {

            $data = $this->request->get();

            if (!isset($data['number'])) {
                 return jsons('4001', '参数缺失');
            }
            $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();

            if(!$findOne){
                return jsons('4002', '参数错误');
            }

            $changeOrderID = input('ChangeOrderID'); //变更编号

            $res['detail'] = model('ph/UserAudit')->get_change_detail_info($changeOrderID);

            $res['config'] = model('ph/UserAudit')->process_status($changeOrderID);

            $res['urls'] = model('ph/UserAudit')->process_imgs_url($changeOrderID);

            $res['record'] = model('ph/UserAudit')->process_record($changeOrderID);

            

            return jsons('2000' ,'获取成功' ,$res);
        }
    }

    /**
     * @title 审核(此处的审核有别与补充资料)
     * @author Mr.Lu
     * @description
     */
    public function process(){


        if ($this->request->isPost()) {

            $data = $this->request->post();

            if (!isset($data['number'])) {
                 return jsons('4001', '参数缺失');
            }
            $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();

            if(!$findOne){
                return jsons('4002', '参数错误');
            }

            defined('UID') or define('UID', $data['number']);

        
            $one =  Db::name('use_change_order')->alias('a')
                                            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                            ->where('a.ChangeOrderID' ,'eq' ,$data['ChangeOrderID'])
                                            ->field('a.Status ,b.id ')
                                            ->find();

            $where['pid'] = array('eq' ,$one['id']);
            $where['Total'] = array('eq' ,$one['Status']);

            $roleID = Db::name('process_config')->where($where)->value('RoleID');

            $currentRoles = json_decode($findOne['Role'],true);

            if(!in_array($roleID ,$currentRoles)){

                return jsons('4005' ,'审批失败，请注意查看审核状态……');
            }

            if(!isset($data['reason'])) $data['reason']='';
            
            $result = $this->create_child_order($data['ChangeOrderID'], $data['reason'],$findOne['InstitutionID']);

            if($result === true){

                return jsons('2000' ,'审核完成');
            }else{

                return jsons('4000' ,'审核异常');
            }
                
            
        }

    }

    //创建一个子订单，例如（补充资料完成，每次审核完成 ，）
    public function create_child_order($changeOrderID,$reson='',$inst){

        //获取流程总人数
        $total = Db::name('use_change_order')->alias('a')
                                             ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
                                             ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
                                             ->value('Total');

        $where['ChangeOrderID'] = array('eq' ,$changeOrderID);

        //判断当前流程
        $status = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');

        //若中间审核通过
        if($status < $total && $reson == '') {

            Db::name('use_change_order')->where($where)->setInc('Status',1); //步骤递进

            $datas['Status'] = 2;

        //若中间审核不通过
        }elseif($status < $total && $reson != ''){

            Db::name('use_change_order')->where($where)->setField('Status',2); //状态重置为待第二个角色操作

            $datas['Status'] = 3;  //子订单状态：3为不通过，2为通过 ，1为待审核：  注意此时主订单状态已被重置

        // 若终审不通过
        }elseif($status == $total && $reson != ''){

            //终审不通过则状态改为 0
            Db::name('use_change_order')->where($where)->setField('Status',0);

            $datas['Status'] = 3;

        // 若终审通过
        }elseif($status == $total && $reson == ''){

            //终审通过则状态改为  1
            Db::name('use_change_order')->where($where)->setField('Status',1);

            //终审通过后，系统自动将变更数据更改,1更名，2过户，3赠予，4转让
            $changeOrderDetail = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->field('*')->find();

            if($changeOrderDetail['ChangeType'] == 1){ //更名

                Db::name('tenant')->where('TenantID','eq',$changeOrderDetail['OldTenantID'])->setField('TenantName',$changeOrderDetail['NewTenantName']);

                Db::name('house')->where('TenantID','eq',$changeOrderDetail['OldTenantID'])->setField('TenantName',$changeOrderDetail['NewTenantName']);

            }else{
                Db::name('house')->where('TenantID','eq',$changeOrderDetail['OldTenantID'])->update(['TenantID'=>$changeOrderDetail['NewTenantID'],'TenantName'=>$changeOrderDetail['NewTenantName']]);

            }

            $datas['Status'] = 2;

        }

        $option['FatherOrderID'] = array('eq' ,$changeOrderID);
        $option['IfValid'] = array('eq' ,1);
        $step = Db::name('use_child_order')->where($option)->max('Step');

        if(!$step){
            $datas['Step'] = 2;
        }else{
            $datas['Step'] = $step + 1;
        }

        $datas['FatherOrderID'] = $changeOrderID;  //父订单编号
        $datas['InstitutionID'] = $inst; //保存机构
        $datas['Reson'] = $reson; //不通过理由
        $datas['UserNumber'] = UID;
        $datas['CreateTime'] = time();

        $re = Db::name('use_child_order')->insert($datas);  //创建子订单

        if($status < $total && $reson != ''){
            Db::name('use_child_order')->where('FatherOrderID' ,'eq' ,$changeOrderID)->setField('IfValid' ,0); //重置之前的子订单状态为无效
        }


        if($re){
            return true;
        }else{
            return false;
        }
        

    }

    public function get_one_change_info($id = '' ,$userid = ''){

        $data = Db::name('use_change_order')->alias('a')
                                            ->join('house b' ,'a.HouseID = b.HouseID','left')
                                            ->field('a.ChangeOrderID,a.HouseID,a.ChangeType,a.Status,b.TenantName,b.HousePrerent')
                                            ->where('a.id','eq',$id)
                                            ->find();

        if(!$data){
            return array();
        }

        switch($data['ChangeType']){
            case 1:
                $data['ChangeType'] = '更名';
                break;
            case 2:
                $data['ChangeType'] = '过户';
                break;
            case 3:
                $data['ChangeType'] = '赠予';
                break;
            case 4:
                $data['ChangeType'] = '转让';
                break;
            default:
                break;
        }


        $res = $this->order_config_detail($data['ChangeOrderID'],$data['Status']);

        //halt($userid);

        $s = in_array($res['RoleID'],json_decode($userid));

        //halt($s);
        $data['Status'] = $res['RoleName'];

        if(!$s){
            $data['flag'] = 1;    
        }

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

    public function order_config($changeOrderID){
        $config = Db::name('use_change_order')->alias('a')
            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
            ->where('a.ChangeOrderID' ,'eq' ,$changeOrderID)
            ->value('Total');

        return $config;

    }

    /**
     * 小程序获取单条公告详情的接口
     */
    public function noticeInfo()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                
            }

            $notice = Db::name('notice')->where('id', $data['id'])->field('id, Title, UpdateTime, Content, Name')->find();

            if ($notice) {
                return jsons('2000', '获取成功', $notice);
            } else {
                return jsons('4005', '获取失败');
            }
        }
    }

    /**
     * 获取订单列表
     */
    public function orderList()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'OrderDate' => date('Ym', time()),
                'InstitutionID' => $findOne['InstitutionID'],
                'Type' => 1, //订单生成状态
            ];
            if (isset($data['TenantName']) && $data['TenantName']) {
                $where['TenantName'] = array('like','%'.$data['TenantName'].'%');
            }
            $rentList = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, OrderDate, ReceiveRent ,TenantName')
                ->paginate(config('paginate.list_rows'))
                ->toArray();

            foreach ($rentList['data'] as &$v) {
                $v['OrderDate'] = substr($v['OrderDate'], 0, 4) . '年' . substr($v['OrderDate'], 4, 2) . '月';
            }

            $rentList['total_page'] = ceil($rentList['total'] / $rentList['per_page']);
            return jsons('2000', '获取成功', $rentList);

        }
    }


}