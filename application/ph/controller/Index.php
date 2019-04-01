<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\Menu as MenuModel;
use think\Db;
use think\Session;
use think\Debug;


use util\PageTool;

class Index extends Base
{
    protected  $page = 5;  //代办事项中的分页每页记录数

    protected $beforeActionList = [
        'beforeIndex',
        'index' =>  ['except'=>''],
        //'three'  =>  ['only'=>'hello,data'],
    ];


    public function index()
    {
                

                
        $notice_list = self::get_notice_list();

        //halt($notice_list);
        $upload_file_list = self::get_upload_file_list();
        $short_cut_menus_list = self::get_short_cut_menus_list();
        // $short_cut_menus_list = '';
        //Debug::remark('begin');
        $get_wait_processing = self::get_wait_list();
        //halt($get_wait_processing);
        //Debug::remark('end');
        //halt('调试时间：'.Debug::getRangeTime('begin', 'end') . 's');
        $this->assign([
            'notice_list' => $notice_list,
            'upload_file_list' => $upload_file_list,
            'short_cut_menus_list' => $short_cut_menus_list,
            'wait_processing' => $get_wait_processing,
        ]);

        return $this->fetch(APP_PATH.request()->module().'/view/layout.html');
    }

    public function beforeIndex(){
        
    }

    /**
     * @title 查看用户详细资料
     * @author Mr.Lu
     * @description
     */
    public function  UserDetail(){

        $data = model('ph/UserManage')->get_user_detail();

        if($data){
            return jsons('2000','获取成功',$data);
        }else{
            return jsons('4000','获取失败');
        }

    }

    /**
     * 获取代办事项
     */
    public function get_wait_list(){

        $listAll = get_wait_processing();

        if($listAll == array()) return array();

        $num = count($listAll);

        //$page = 5;   //设置每页记录数
        $countnum = ($num<5)?$num:5;

        for($i=0;$i<$countnum;$i++){

            $list[] = $listAll[$i];
        }

        $pageTool = new PageTool($num,false,1);
        $nav = $pageTool->show();

        return array(
            'list' => $list,
            'nav' => $nav
        );
    }

    /**
     * 获取公告列表
     */
    public function get_notice_list(){
        $where = [];
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $pid = Db::name('institution')->where('id',$currentUserInstitutionID)->value('pid');
            $where['Institution'] = array('eq' ,$pid);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['Institution'] = array('eq' ,$currentUserInstitutionID);
        }else{    //用户为公司级别，则获取所有子管段
        }
        if(!$where){
            $where = 1;
        }
        //halt($where);
        $num = Db::name('notice')->where($where)->count();
        $list = Db::name('notice')->where($where)->order('UpdateTime desc')->page(1, 5)->select();

        $pageTool = new PageTool($num);
        $nav = $pageTool->show();

        return array(
            'list' => $list,
            'nav' => $nav
            );
    }

    /**
     * ajax获取公告列表
     */
    public function noticePageList(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = self::ajax_get_notice_list($data);
            return jsons('2000', '查询成功', $ret);
        }
    }
    public function ajax_get_notice_list($data){
        $id = $data['id'];
        $search = $data['search'];

        $where = [];
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = session('user_base_info.institution_level');
        if($currentUserLevel == 3){  //用户为管段级别，则直接查询
            $pid = Db::name('institution')->where('id',$currentUserInstitutionID)->value('pid');
            $where['Institution'] = array('eq' ,$pid);
        }elseif($currentUserLevel == 2){  //用户为所级别，则获取所有该所子管段，查询
            $where['Institution'] = array('eq' ,$currentUserInstitutionID);
        }else{    //用户为公司级别，则获取所有子管段
        }

        $where['Title'] = array('like' ,'%'.$search.'%');


        $num = Db::name('notice')->where($where)->count();
        if($data['id'] == '-1'){
            $id = ceil($num/5);
        }
        $list = Db::name('notice')->where($where)->order('IsTop desc,UpdateTime desc')->page($id, 5)->select();
        $pageTool = new PageTool($num, $data['id']);
        $nav = $pageTool->show();
        return array(
            'list' => $list,
            'nav' => $nav
            );
    }

    /**
     * 获取文件下载列表
     */
    public function get_upload_file_list(){
        $num = Db::name('file')->count();
        $list = Db::name('file')->order('IsTop desc,Time desc')->page(1, 5)->select();
        $pageTool = new PageTool($num);
        $nav = $pageTool->show();
        return array(
            'list' => $list,
            'nav' => $nav
            );
    }

    /**
     * index获取快捷方式列表
     */
    public function get_short_cut_menus_list(){
        //$user = Session::get('user_base_info.name');
        
        $data = Db::name('short_cut')->where('CreateUserID', UID)->select();

        $arr = [];

        if($data){

            foreach($data as $d){
                $arr[$d['Step']] = $d;
            }

            return $arr;

        }else{

            return array();
        }
        //halt($data);
        // $arr = array();
        // foreach ($data as $info) {
        //     $tmp = explode('|', $info['Url']);
        //     if(!isset($tmp[1]))
        //         $tmp[1] = '';
        //     $arr[] = array('url' => $tmp[0], 'icon' => $tmp[1], 'title' => $info['Title']);
        // }
        
    }

    /**
     * ajax获取代办事项
     */
    public function waitProcessing(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = self::ajax_get_wait_processing($data);
            return jsons('2000', '查询成功', $ret);
        }
    }
    public function ajax_get_wait_processing($data){

        $listAll = get_wait_processing();

        $num = count($listAll);

        //halt($num);

        if($data['id'] == '-1'){
            $data['id'] = ceil($num/$this->page);
        }

        $min = ($data['id']-1)*$this->page;
        $max = $data['id']*$this->page;

        //dump($min);dump($max);exit;

        for($i= $min; $i<$max; $i++){

            $list[] = $listAll[$i];
        }

        //halt($list);

        $pageTool = new PageTool($num,$data['id'],1);
        $nav = $pageTool->show();

        return array(
            'list' => $list,
            'nav' => $nav
        );
//        $num = Db::name('file')->count();
//        $id = $data['id'];
//        if($id == '-1'){
//            $id = ceil($num / 5);
//        }
//        $list = Db::name('file')->order('Time desc')->page($id, 5)->select();
//        $pageTool = new PageTool($num, $data['id']);
//        $nav = $pageTool->show();
//        return array(
//            'list' => $list,
//            'nav' => $nav
//        );
    }

    /**
     * ajax获取文件列表
     */
    public function uploadfilePageList(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = self::ajax_get_upload_file_list($data);
            return jsons('2000', '查询成功', $ret);
        }
    }
    public function ajax_get_upload_file_list($data){
        $id = $data['id'];
        $search = $data['search'];
        $num = Db::name('file')->where('Title like "%'.$search.'%"')->count();
        if($id == '-1'){
            $id = ceil($num / 5);
        }
        $list = Db::name('file')->where('Title like "%'.$search.'%"')->order('Time desc')->page($id, 5)->select();
        $pageTool = new PageTool($num, $data['id']);
        $nav = $pageTool->show();
        return array(
            'list' => $list,
            'nav' => $nav
            );
    }

    /**
     * 下载文件
     */
    public function downloadFile(){
        if($this->request->isGet()){
            $data = $this->request->get();
            self::download_by_path($data['file'], date('YmdHis', time()) . substr($data['file'], strrpos($data['file'], '.')));
        }
    }
    function download_by_path($path_name, $save_name){
       ob_end_clean();
       $path_name = '.' . $path_name;
       $hfile = fopen($path_name, "rb") or die("Can not find file: $path_name\n");
       Header("Content-type: application/octet-stream");
       Header("Content-Transfer-Encoding: binary");
       Header("Accept-Ranges: bytes");
       Header("Content-Length: ".filesize($path_name));
       Header("Content-Disposition: attachment; filename=\"$save_name\"");
       while (!feof($hfile)) {
          echo fread($hfile, 32768);
       }
       fclose($hfile);
    }

    /**
     * 获取二级菜单
     */
    public function secondlevelMenu(){

        $tree = Session::get('left_menu_tree');
        foreach ($tree as $info) {
            if ($info['Title'] == '主页') {
                continue;
            }
            if($info['level'] == '1')
                $arr[] = $info;
        }
        //halt($arr);
        return jsons('2000', '查询成功', $arr);
    }

    /**
     * 修改快捷方式
     */
    public function shortCutModify(){
        if($this->request->isGet()){
            $id = input('id');
            if($id){
                $re = Db::name('short_cut')->where(['CreateUserID' => UID, 'Step'=>$id])->delete();
                if($re){
                    return jsons('2000', '删除成功');
                }else{
                    return jsons('4000', '删除失败');
                }
            }
        }

        if($this->request->isPost()){
            $data = $this->request->post();

            $findone = Db::name('short_cut')->where(['CreateUserID' => UID, 'Step'=>$data['id']])->find();

            if($findone){
                $re = Db::name('short_cut')->where(['CreateUserID' => UID, 'Step'=>$data['id']])->update(['Url'=>'/'.$data['url']]);
            }else{
                $re = Db::name('short_cut')->insert(['Step'=>$data['id'],'Url'=>'/'.$data['url'],'CreateUserID' => UID]); 
            }
            

            //halt(Db::name('short_cut')->getLastSql());
            if($re){
               $icons = Db::name('admin_menu')->where('UrlValue',$data['url'])->field('Icons,Title')->find();
               if($icons){
                    Db::name('short_cut')->where(['CreateUserID' => UID, 'Step'=>$data['id']])->update(['Icon'=>$icons['Icons'],'Title'=>$icons['Title']]);
               }
               return jsons('2000', '修改成功');
            }else{
               return jsons('4000', '修改失败'); 
            }
            
        }
    }



}
