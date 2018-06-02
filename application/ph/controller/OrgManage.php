<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\OrgManage as OrgManageModel;
use think\Db;

class OrgManage extends Base
{
    public function index(){

        $OrgManageModel = new OrgManageModel;

        $orgLst = $OrgManageModel -> get_all_org_lst();

        $highOrg = $OrgManageModel -> get_high_org_lst();

        //dump($data);exit;

        $this->assign([
            'orgLst' => $orgLst['arr'],
            'orgLstObj' => $orgLst['obj'],
            'highOrg' => $highOrg,
        ]);

        return $this->fetch();
    }

    public function add(){
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();

            if(empty($data['Institution'])) return jsons('4001' ,'机构名称不能为空');

            if(empty($data['id'])) return jsons('4002' ,'暂不支持添加顶级机构，请选择父级机构');

            $fatherLevel = Db::name('institution')->where('id','eq',$data['id'])->value('Level');

            $arr['Institution'] = $data['Institution'];  //机构名称
            $arr['pid'] = $data['id'];  //父id
            $arr['Level'] = $fatherLevel + 1;    //级别
            $arr['Status'] = $data['Status'];    //有效性
            
            if ($banInfo = OrgManageModel::create($arr)) {

                // 记录行为
                action_log('OrgManage_add', UID  ,6, '名称为:'.$data['Institution']);

                return jsons('2000' ,'新增成功');

            } else {

                return jsons('4000' ,'新增失败');
            }
        }
        echo '没有数据！';

    }

    public function  edit(){
        $id = input('id');

        if($this->request->isPost()){


            $data = $this->request->post();

            $findOne = Db::name('institution')->where('id',$data['id'])->field('Level,pid')->find();

            if($findOne['pid'] != $data['pid']){
   
                if($findOne['Level'] == 2){
                    $where = [
                        'InstitutionID' => $data['id'],
                        'Status' => 1,
                    ];
                }elseif($findOne['Level'] == 3){
                    $where = [
                        'TubulationID' => $data['id'],
                        'Status' => 1,
                    ];
                }else{
                    $where = [
                        'Status' => 1,
                    ];
                }

                $flag = Db::name('ban')->where($where)->find();
                if($flag){
                    return jsons('4001','该机构有辖属楼栋不允许修改父级机构');
                }
            }


            if ($banInfo = OrgManageModel::update($data)) {

                // 记录行为
                action_log('OrgManage_edit', UID  ,6, '编号:'.$data['id']);
                return jsons('2000' ,'修改成功');

            }else{

                return jsons('4000' ,'修改失败');

            }
        }

        $map = 'id ,Institution  ,pid ,Status ';
        $data = Db::name('institution')->field($map)->where('id','eq',$id)->find();

        if($data){

            return jsons('2000','获取成功',$data);
        }

        return jsons('4000','获取失败');

    }

    public function  delete(){
        $id = input('id');
        if($id){

            $findOne = Db::name('institution')->where('id',$id)->field('Level,pid')->find();
            if($findOne['Level'] == 2){
                    $where = [
                        'InstitutionID' => $id,
                        'Status' => 1,
                    ];
            }elseif($findOne['Level'] == 3){
                $where = [
                    'TubulationID' => $id,
                    'Status' => 1,
                ];
            }else{
                $where = [
                    'Status' => 1,
                ];
            }

            $flag = Db::name('ban')->where($where)->find();
            
            if($flag){
                return jsons('4001','该机构有辖属楼栋不允许删除');
            }
            $res = Db::name('institution')->where('id' ,'eq' ,$id)->delete();

            if($res){

                // 记录行为
                action_log('OrgManage_delete', UID  ,6, '编号:'.$id);
                return jsons(2000 ,'删除成功');

            }else{

                return jsons(4000 ,'删除失败，参数异常！');

            }
        }

        return '没有数据';
    }
}