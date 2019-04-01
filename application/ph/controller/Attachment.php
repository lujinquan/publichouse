<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

class Attachment extends Base
{
    public function index(){

        // $attachmentLst = model('ph/Attachment')->get_all_attachment_lst();
        $attachmentLst = model('ph/Attachment')->get_all_file_lst();

        //halt($attachmentLst['arr']);

        $this->assign([
            'attachmentLst'  => $attachmentLst['arr'],
            'attachmentLstObj'  => $attachmentLst['obj'],
            //'attachmentOption' => $attachmentLst['option'],
        ]);

        return $this->fetch();
    }

    /**
     * 上传文件
     */
    public function add(){
        //halt($_FILES['file']);
        static $k = 0;
        if(empty($_FILES))
            exit('no file');
        if($_FILES['file']['error'] != 0){
            exit('fail');
        } else {
            $title = $_POST['title'];
            $name = $_FILES['file']['name'];
            $name = iconv("UTF-8", "GB2312", $name);
            $k = rand(0, 10000);
            $suffix = substr($name, strrpos($name, '.'));
            $name = date('YmdHis', time()) . '_' . $k . $suffix;
            $rs = move_uploaded_file($_FILES['file']['tmp_name'], './uploads/files/'.$name);
            if($rs){
                $rs = model('ph/Attachment')->add_url_of_upload_files($title . $suffix, $name);
                if($rs){
                    return jsons('2000', '上传成功', $name);
                } else {
                    unlink('./uploads/files/'.$name);
                    return jsons('4000', '上传失败');
                }
            } else {
                return jsons('4000', '上传失败');
            }
        }
    }

    public function edit(){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $msg = $data['IsTop']?'置顶成功':'取消成功';
            $res = Db::name('file')->where('id',$data['id'])->setField('IsTop',$data['IsTop']);
            if($res !== false){
                return jsons('2000', $msg);
            }
        }
    }
    /**
     * 删除文件
     */
    public function delete(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = model('ph/Attachment')->delete_file($data['id']);
            return jsons('2000', '删除成功', $ret);
        }
    }
}