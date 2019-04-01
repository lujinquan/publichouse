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
use think\Config;
use think\Loader;
use think\Db;
use util\Tree;
use think\Session;

class Attachment extends Model
{

    // 设置当前模型对应的完整数据表名称
    // protected $table = '__UPLOAD_FILE__';
    protected $table = '__FILE__';


    public function get_all_attachment_lst(){

        $attachmentList['obj'] = Db::name('upload_file')->field('id')->order('id desc')->paginate(config('paginate.list_rows'));

        $arr = $attachmentList['obj']->all();

        if(!$arr){
            $attachmentList['arr'] = array();
        }

        foreach($arr as $v){
            $attachmentList['arr'][] = self::get_one_attachment_base_info($v['id']);
        }

        return $attachmentList;
    }

    public function get_one_attachment_base_info($id){

        $map = 'id ,FileTitle ,FileUrl ,FileUse ,UploadUserID ,UploadTime';

        $one = Db::name('upload_file')->where('id','eq',$id)->field($map)->find();

        //$one['FileUrl'] = $_SERVER['DOCUMENT_ROOT'].$one['FileUrl'];

        //halt($_SERVER['DOCUMENT_ROOT']);

        $one['FileUrl'] = $one['FileUrl'];

        $one['FileUse'] = Db::name('upload_file_type')->where('id' ,'eq' ,$one['FileUse'])->value('FileUse');

        $one['UserName'] = Db::name('admin_user')->where('Number' ,'eq' ,$one['UploadUserID'])->value('UserName');

        $one['UploadTime'] = date('Y-m-d H:i:s' ,$one['UploadTime']);

        return $one;
    }

    /**
     * 获取所有文件信息
     */
    public function get_all_file_lst(){
        $fileList['obj'] = Db::name('file')->order('IsTop desc,Time desc')->paginate(config('paginate.list_rows'));
        $fileList['arr'] = $fileList['obj']->all();
        return $fileList;
    }

    /**
     * 上传文件
     */
    public function add_url_of_upload_files($title, $name){
        $uploaduser = Session::get('user_base_info.name');
        $time = date('Y-m-d H:i:s', time());
        $info = ['Url' => '/uploads/files/'.$name, 'Title' => $title, 'UploadUser' => $uploaduser, 'Time' => $time];
        return Db::name('file')->insert($info);
    }
    /**
     * 删除文件
     */
    public function delete_file($id){
        $info = Db::name('file')->field('Url')->find($id);
        unlink('.' . $info['Url']);
        return Db::name('file')->delete($id);
    }
}