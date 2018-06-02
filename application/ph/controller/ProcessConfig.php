<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\ProcessConfig as ProcessConfigModel;
use think\Db;

/**
 * @title  流程配置控制器
 * @author Mr.Lu
 * @description
 */
class ProcessConfig extends Base
{
    /**
     * @title 使用权变更申请主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/ProcessConfig') -> get_all_process_lst();

        $roles = Db::name('admin_role')->field('id, RoleName')->select();

        $changes = Db::name('change_type')->field('id, ChangeType')->select();

        $this -> assign([
            'processLst' => $data['arr'],
            'processLstObj' => $data['obj'],
            'roles' => $roles,
            'changes' => $changes,
        ]);

        return $this->fetch();
    }

    /**
     * @title 添加流程配置
     * @author Mr.Lu
     * @description
     */
    public function add(){

        if($this->request->isPost()){

            $data = $this->request->post();

            //halt($data);

            if(empty($data['ProcessTitle'])) return jsons('4001' ,'请选择审批流程类型');
            
            if(empty($data['Title'][1]) || empty($data['Title'][1])) return jsons('4002','请填写合法数据');

            $result = model('ph/ProcessConfig')->add($data);

            if($result === true){

                // 记录行为
                action_log('ProcessConfig_add', UID  ,6, '名称:'.$data['ProcessTitle']);
                return jsons('2000' ,'添加成功');
            }else{

                return jsons('4000' ,'添加失败');
            }

        }
    }


    /**
     * @title 修改流程配置
     * @author Mr.Lu
     * @description
     */
    public function edit(){

        $id = input('id');

        if($this->request->isPost()) {

            $data = $this->request->post();

            foreach($data['Title'] as  $v){
                
                if(empty($v)) return jsons('4001' ,'步骤名称不能存在空值');
            }

            foreach($data['Title'] as $key => $value){

                $map['pid'] = array('eq' ,$data['id']);
                $map['Total'] = array('eq' ,$key+1);

                Db::name('process_config')->where($map)->setField('Title', $value);
            }

            // 记录行为
            action_log('ProcessConfig_edit', UID  ,6, '编号:'.$data['id']);
            return jsons('2000' ,'修改成功'); 
        
        }

        $res = model('ph/ProcessConfig')->get_config_detail($id);

        if($res){

            return jsons('2000' ,'获取成功' ,$res);

        }else{

            return jsons('4000' ,'获取失败');

        }


    }

    /**
     * @title 删除流程配置
     * @author Mr.Lu
     * @description
     */
    public function delete(){

        $id = input('id');

        $res = Db::name('process_config')->where('id' ,'eq' ,$id)->delete();

        Db::name('process_config')->where('pid' ,'eq' ,$id)->delete();

        if($res){

            // 记录行为
            action_log('ProcessConfig_delete', UID  ,6, '编号:'.$id);
            return jsons('2000' ,'删除成功');
        }else{

            return jsons('4000' ,'删除失败');
        }
         
    }
}