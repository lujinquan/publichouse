<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use app\user\model\Role as RoleModel;
use think\Model;
use think\Exception;
use think\Db;
use think\Paginator;
use think\Loader;
use util\Tree;

class TenantInfo extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__TENANT__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'CreateTime';
    //  关闭更新时间
    protected $updateTime = 'UpdateTime';

    public function get_all_tenant_lst($status = 0)
    {
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        $where['Status'] = array('eq' ,$status);
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $where['InstitutionID'] = array('eq' ,$currentUserInstitutionID);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionPID'] = array('eq' ,$currentUserInstitutionID);
        }else{    //用户为公司级别，则获取所有子管段
        }
        $TenantID = input('TenantID');
        if($TenantID){  //接收查看房屋跳转，传递进来的BankID参数
            //dump($BankID);exit;
            $where['TenantID'] = array('eq',$TenantID);
        }
        $TenantIdList['option'] =array();
        $searchForm = input('request.');
        foreach ($searchForm as &$val) { //去收尾空格
            $val = trim($val);
        }
        if(isset($searchForm['TenantID'])){
            $TenantIdList['option'] = $searchForm;    
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构

                $level = Db::name('institution')->where('id','eq',$searchForm['TubulationID'])->value('Level');

                if($level == 3) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }elseif($level == 2){
                    $where['InstitutionPID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if ($searchForm['TenantID']) {  //模糊检索租户编号
                $where['TenantID'] = array('like', '%'.$searchForm['TenantID'].'%');
            }
            if ($searchForm['TenantName']) {  //模糊检索租户姓名
                $where['TenantName'] = array('like', '%'.$searchForm['TenantName'].'%');
            }
            if ($searchForm['TenantTel']) {  //模糊检索租户电话号码
                $where['TenantTel'] = array('like', '%'.$searchForm['TenantTel'].'%');
            }
            if ($searchForm['TenantBalance']) {  //模糊检索租户金额
                $where['TenantBalance'] = array('like', '%'.$searchForm['TenantBalance'].'%');
            }
            if ($searchForm['TenantNumber']) {  //模糊检索租户欠租情况
                $where['TenantNumber'] = array('like', '%'.$searchForm['TenantNumber'].'%');
            }

        }

        if(!isset($where)){
            $where = 1;
        }
//halt($where);
        $TenantIdList['obj'] = self::field('TenantID')->where($where)->order('TenantID desc')->paginate(config('paginate.list_rows'));
        $arr = $TenantIdList['obj']->all();
        if(!$arr){
            $TenantIdList['arr'] = array();
        }
        foreach($arr as $v){
            $TenantIdList['arr'][] = self::get_one_tenant_base_info($v['TenantID']);
        }

        return $TenantIdList;
    }

    public function get_one_tenant_base_info($tenantid = '',$map=''){

        //租户编号，租户姓名，联系电话 ，余额，欠租情况 ，诚信分 ，微信号 ，QQ号 ，银行卡账号
        if(!$map) $map = 'TenantID,TenantName,InstitutionID,InstitutionPID,TenantTel,TenantBalance,TenantValue,TenantWeChat,TenantQQ,BankID,TenantNumber ';

        $data = Db::name('tenant')->field($map)->where('TenantID','eq',$tenantid)->find();

        $data['InstitutionID'] = get_institution($data['InstitutionID']);   //机构管段名称

        if(!$data){
            return array();
        }

        return $data;


    }

    public function get_one_tenant_detail_info($tenantid = ''){
        $data = self::where('TenantID',$tenantid)->find();
        if($data['TenantSex'] === 1){
            $data['TenantSex'] = '男';
        }else{
            $data['TenantSex'] = '女';
        }
        return $data;
    }

    public function uploads($file ,$k){

        $title = config($k); //上传文件标题
        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/tenant/'); //设置保存的路径
        $fileUpload->set('maxsize',1000000); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机
        $res = $fileUpload->upload($k);

        if($res !== true){

            return jsons('4003' ,$fileUpload->getErrorMsg());

        }else{  //上传成功

            $data['FileUrl']= '/uploads/tenant/'.$fileUpload->getFileName();          //写入到数据库中的地址和存放地址 $targetPath 不一样
            $data['FileTitle'] = $title;
            $data['FileType'] = 1;        //图片类型
            $data['FileUse'] = 3;         //用途：租户
            $data['UploadUserID'] = UID;
            $data['UploadTime'] = time();
            $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1
            if($result == 1) {
                $fileID = Db::name('upload_file')->getLastInsID();
                return $fileID;
            }

        }

    }

}