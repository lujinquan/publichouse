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
        $totalTops = Db::name('notice')->where('IsTop',1)->count();
        //dump($totalTops);halt($data);
        if($totalTops > 2 && $data['istop'] == 1){
            return jsons('4000', '置顶数不能超过3条');die;
        }
        $createTime = date('Y-m-d H:i:s', time());
        $institution = $data['institution'];
        $title = $data['title'];
        $istop = $data['istop'];
        $content = $data['content'];
        $name = Session::get('user_base_info.name');
        $info = ['Name' =>$name, 'CreateTime' => $createTime ,'UpdateTime' => $createTime, 'Institution' => $institution, 'Title' => $title, 'Content' => $content, 'IsTop' => $istop];
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
        $totalTops = Db::name('notice')->where('IsTop',1)->count();
        $row = Db::name('notice')->where('id',$data['id'])->find();
        if($totalTops > 2 && $data['IsTop'] == 1 && $row['IsTop'] != 1){
            
                return jsons('4000', '置顶数不能超过3条');
            
        }
        
        if(isset($data['title'])){
            if($data['title'] != $row['Title'] || $data['institution'] != $row['Institution'] || $data['content'] != $row['Content'] ){
                $update['UpdateTime'] = date('Y-m-d H:i:s',time());
            }
        }
        
            
        
        if(isset($data['title'])){
            $update['Title'] = $data['title'];
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