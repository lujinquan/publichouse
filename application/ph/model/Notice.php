<?php

namespace app\ph\model;

use think\Model;
use think\Piginator;
use think\Exception;
use think\Db;
use think\Session;

class Notice extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__NOTICE__';

    public function get_all_notice_list(){
        $NoticeList['obj'] = self::order('IsTop desc,UpdateTime desc')->paginate(config('paginate.list_rows'));
        $NoticeList['arr'] = $NoticeList['obj']->all();
        return $NoticeList;
    }

    public function notice_add($data){
        $updateTime = date('Y-m-d H:i:s', time());
        $institution = $data['institution'];
        $title = $data['title'];
        $istop = $data['istop'];
        $content = $data['content'];
        $name = Session::get('user_base_info.name');
        $info = ['Name' =>$name, 'UpdateTime' => $updateTime, 'Institution' => $institution, 'Title' => $title, 'Content' => $content, 'IsTop' => $istop];
        $ret = Db::name('notice')->insert($info);
        return $ret;
    }

    public function get_notice_info($data){
    	$id = $data['id'];
    	return Db::name('notice')->find($id);
    }

    public function notice_delete($data){
    	$id = $data['id'];
    	return Db::name('notice')->delete($id);
    }

    public function modify_notice_info($data){
        $update = [];
        $update['id'] = $data['id'];
        if(isset($data['title'])){
            $update['title'] = $data['title'];
            $update['Institution'] = $data['institution'];
            $update['Title'] = $data['title'];
            $update['IsTop'] = $data['IsTop'];
            $update['Content'] = $data['content'];
        }else{
            $update['IsTop'] = $data['IsTop'];
        }
        //$updateTime = date('Y-m-d H:i:s', time());
        // $institution = $data['institution'];
        // $title = $data['title'];
        // $content = $data['content'];
        // $id = $data['id'];
        //$info = ['UpdateTime' => $updateTime, 'Institution' => $institution, 'Title' => $title, 'Content' => $content];
        $ret = Db::name('notice')->update($update);
        return $ret;
    }
}