<?php


namespace app\ph\model;

use think\Model;
use think\Db;
use think\Loader;
use think\Config;
use util\Tree;

class ChangeApply extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__PROCESS__';

    public function get_all_process_lst(){

        $where = 1;

        $ProcessLst['obj'] = self::field('id ,ProcessName ,IfBaseChange,CreateUserID,CreateTime')->where($where)->paginate(config('paginate.list_rows'));

        $ProcessLst['arr'] = $ProcessLst['obj']->all()?$ProcessLst['obj']->all():array();

        foreach($ProcessLst['arr'] as &$v){

            $v['CreateUserName'] = Db::name('admin_user')->where('Number','eq',$v['CreateUserID'])->value('UserName');

            $v['CreateTime'] = date('Y/m/d',$v['CreateTime']);

            if($v['IfBaseChange'] == 1){

                $v['IfBaseChange'] = '基数异动';
            }else{
                
                $v['IfBaseChange'] = '非基数异动';
            }

        }

        return $ProcessLst;
    }

    public function uploads($file,$k1,$type){

        $title = Config::get($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/changeOrder/'); //设置保存的路径
        $fileUpload->set('maxsize',5*1024*1024); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            //return jsons('4003' ,$fileUpload->getErrorMsg());
            return jsons('4003' ,'上传失败');

        }else{  //上传成功

            //多文件上传，遍历操作
            $names = $fileUpload->getFileName();

            foreach($names as $k => $v){

                $data['FileUrl']= '/uploads/changeOrder/'.$v;          //写入到数据库中的地址和存放地址 $targetPath 不一样
                $data['FileTitle'] = $title;                  
                $data['FileType'] = 1;        //图片类型
                $data['FileUse'] = $type + 4;         //用途：异动
                $data['UploadUserID'] = UID;
                $data['UploadTime'] = time();
                $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1

                if($result == 1) {
                    $fileID[] = Db::name('upload_file')->getLastInsID();
                }
            }

            return $fileIDS = implode(',', $fileID);

        }

    }

    public function check_apply_table($data)
    {
        //校验该角色是否被允许提交异动申请
        $pid = Db::name('process_config')->where('Type','eq',$data['type'])->value('id');
        $nowRoleID = Db::name('process_config')->where('pid','eq',$pid)->where('Total','eq',1)->value('RoleID');
        $roles = json_decode(session('user_base_info.role'),true);  //获取该登录用户的所有角色
        if(!in_array($nowRoleID,$roles)){
            return jsons('4004','友情提示，您暂无权限提交异动单……');
        }

        if(!isset($data['type'])){
            return jsons('4000','参数缺失……');
        }

        switch ($data['type']) {
                case 1:  //租金减免
                    if(!$data['RemitRent']){
                        return jsons('4002','减免金额不能为空');
                    }else{
                       if(!preg_match("/^[1-9]*[1-9][0-9]*$/",$data['RemitRent'])){
                            return jsons('4003','减免金额请填写数字');
                        } 
                    }
                    if(!$data['CutType']){
                        return jsons('4002','减免类型不能为空');
                    }
                    if(!$data['validity']){
                        return jsons('4002','有效期不能为空');
                    }
                break;
                case 2:

                break;
                case 3:

                    if(!($data['houseID'])){
                        return jsons('4000','暂未选择任何房屋');
                    }
                    $arrs = Db::name('house')->where(['HouseID'=>['in',$data['houseID']]])->group('OwnerType')->column('OwnerType');
                    if(count($arrs) > 1){
                        return jsons('4004','所选房屋产别不能超过一种');
                    }
                break;

                default:
        }



    }





}