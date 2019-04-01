<?php
/**
 * 公告
 */
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;


class Notice extends Base
{
    /**
     *  控制器主页
     */
    public function index(){
        $notice_list = model('ph/Notice')->get_all_notice_list();
        // print_r($notice_list);exit();
        // $this->assign('notice_list', $notice_list);

        $this->assign([
            'notice_list_data'  => $notice_list['arr'],
            'notice_list_obj'  => $notice_list['obj']
        ]);
    	return $this->fetch();
    }

    /**
     * 发布公告
     */
    public function add(){
    	if($this->request->isPost()){
    		$data = $this->request->post();

            $key = mb_detect_encoding($data['content'], array('UNICODE','ASCII','GB2312','GBK','UTF-8'));

            //halt($key);

            // return jsons('2000', '发布成功', $data);
            $ret = model('ph/Notice')->notice_add($data);
    		return jsons('2000', '发布成功', $ret);
    	}
    }

    /**
     * 修改公告信息
     */
    public function modify(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $res = model('ph/Notice')->modify_notice_info($data);
            if($res !== false){
                return jsons('2000', '修改成功', 1);
            }
        }else{
            $data = Db::name('notice')->find(input('id'));
            if($data){
                return jsons('2000', '获取成功',$data);
            }else{
                return jsons('2000', '获取失败');
            }
        }

    }
    /**
     * 删除
     */
    public function delete(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = model('ph/Notice')->notice_delete($data);
            return jsons('2000', '删除成功', $ret);
        }
    }
}