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
        $fileUpload->set('maxsize',1000000); //限制上传文件大小
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
}