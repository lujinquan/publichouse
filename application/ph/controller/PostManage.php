<?php
namespace app\ph\controller;

use app\ph\model\PostManage as PostManageModel;

use think\Db;

class PostManage extends Base
{
    public function index(){

        $PostManageModel = new PostManageModel;

        $PostLst = $PostManageModel -> get_all_post_lst();

        $this->assign([
            'postLst' => $PostLst['arr'] , //数据表记录重组数组
            'postLstObj' => $PostLst['obj'], //分页对象
        ]);

        return $this->fetch();
    }

    public function add(){

        if ($this->request->isPost()) {
            $data = $this->request->post();

            if(empty($data['PostName'])) return jsons('4001' ,'职务名称不能为空');

            $max = Db::name('post')->max('PostID');

            $data['PostID'] = $max + 1;

            if ($banInfo = PostManageModel::create($data)) {

                // 记录行为
                action_log('PostManage_add', UID  ,6, '编号为:'.$data['PostID']);
                return jsons('2000','新增成功');
            } else {
                return jsons('4000','新增失败');
            }
        }
        echo '没有数据！';

    }

    public function  edit(){

        $PostManageModel = new PostManageModel;

        $postID = input('PostID');

        if($this->request->isPost()){

            $data = $this->request->post();

            if(empty($data['PostName'])) return jsons('4001' ,'职务名称不能为空');

            if ($res = Db::name('post')->where('PostID','eq',$data['PostID'])->update($data)) {

                // 记录行为
                action_log('PostManage_edit', UID  ,6, '编号为:'.$data['PostID']);
                return jsons('2000' ,'修改成功');
            }else{
                return jsons('4000' ,'修改失败');
            }
        }

        $map = 'PostID ,PostName ,Status';
        $data = Db::name('post')->field($map)->where('PostID','eq',$postID)->find();

        if($data){

            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');

    }

    public function  delete(){
        $postID = input('PostID');

        if($postID){

            $res = Db::name('post')->where('PostID' ,'eq' ,$postID)->delete();

            if($res){

                // 记录行为
                action_log('PostManage_delete', UID  ,6, '编号为:'.$postID);
                return jsons(2000 ,'删除成功');

            }else{

                return jsons(4000 ,'删除失败，参数异常！');

            }
        }

        return '没有数据';
    }
}