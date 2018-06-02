<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
//use app\ph\model\BanInfo as BanInfoModel;
use think\Db;


/**
 * 参数配置
 */
class ParameterSet extends Base
{
    /**
     * 主页ajax显示
     */
    public function index(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $id = $data['id'];
            $data = null;
            switch ($id) {
                case '1':// 楼栋结构配置
                    $data = $this->ban_structure_type();
                    break;
                case '2':// 楼栋类别配置
                    $data = $this->ban_owner_type();
                    break;
                case '3':// 楼栋完损等级配置
                    $data = $this->ban_damage_grade();
                    break;
                case '4':// 使用性质配置
                    $data = $this->use_nature();
                    break;
                
                default:
                    # code...
                    break;
            }
            return jsons('2000', '查询成功', $data);
        }

        $structure_type = Db::name('ban_structure_type')->select();
        $this->assign([
            'structure_type' => $structure_type
            ]);
        return $this->fetch();
    }

    /**
     * 参数配置更改
     */
    public function modify(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_modify($data);
            //halt($ret);
            if ($ret || $ret===0) {
                return jsons('2000', '配置成功');
            } else {
                return jsons('4000', '配置失败');
            }
        }
        echo '没有数据';
    }

    /**
     * 参数配置增加
     */
    public function add(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_add($data);
            if ($ret) {
                return jsons('2000', '配置成功', $ret);
            } else {
                return jsons('4000', '配置失败', $ret);
            }
        }
        echo '没有数据';
    }

    /**
     * 参数配置删除
     */
    public function delete(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $ret = $this->parameter_delete($data);
            if ($ret) {
                return jsons('2000', '删除成功', $ret);
            } else {
                return jsons('4000', '删除失败', $ret);
            }
        }
        echo '没有数据';
    }

    /**
     * 楼栋结构配置
     */
    public function ban_structure_type(){
        $data = Db::name('ban_structure_type')->field('id field0,StructureType field1')->select();
        $field = array('编号', '类别');
        return array(
            'data' => $data,
            'field' => $field
            );
    }

    /**
     * 楼栋产别配置
     */
    public function ban_owner_type(){
        $data = Db::name('ban_owner_type')->field('id field0,OwnerType field1')->select();
        $field = array('编号', '产别');
        return array(
            'data' => $data,
            'field' => $field
            );
    }
    /**
     * 楼栋完损等级配置
     */
    public function ban_damage_grade(){
        $data = Db::name('ban_damage_grade')->field('id field0,DamageGrade field1')->select();
        $field = array('编号', '完损等级');
        return array(
            'data' => $data,
            'field' => $field
            );
    }
    /**
     * 使用性质配置
     */
    public function use_nature(){
        $data = Db::name('use_nature')->field('id field0,UseNature field1')->select();
        $field = array('编号', '使用性质');
        return array(
            'data' => $data,
            'field' => $field
            );
    }

    /**
     * 更改数据库中参数配置
     * @param $data 需要更改的配置参数
     */
    public function parameter_modify($data){
        $confContent = $data['confContent'];
        $confId = $data['confId'];
        $classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 楼栋结构配置
                $ret = $this->ban_structure_type_modify($confId, $confContent);
                break;
            case '2':// 楼栋类别配置
                $ret = $this->ban_owner_type_modify($confId, $confContent);
                break;
            case '3':// 楼栋完损等级配置
                $ret = $this->ban_damage_grade_modify($confId, $confContent);
                break;
            case '4':// 使用性质配置
                $ret = $this->use_nature_modify($confId, $confContent);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }

    public function ban_structure_type_modify($confId, $confContent){
        $ret = Db::name('ban_structure_type')->where('id', $confId)->setField('StructureType', $confContent);
        return $ret;
    }
    public function ban_owner_type_modify($confId, $confContent){
        $ret = Db::name('ban_owner_type')->where('id', $confId)->setField('OwnerType', $confContent);
        return $ret;
    }
    public function ban_damage_grade_modify($confId, $confContent){
        $ret = Db::name('ban_damage_grade')->where('id', $confId)->setField('DamageGrade', $confContent);
        return $ret;
    }
    public function use_nature_modify($confId, $confContent){
        $ret = Db::name('use_nature')->where('id', $confId)->setField('UseNature', $confContent);
        return $ret;
    }

    /**
     * 参数配置增加
     * @param $data 需要添加的数据
     */
    public function parameter_add($data){
        $confContent = $data['confContent'];
        $classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 楼栋结构配置
                $ret = $this->ban_structure_type_add($confContent);
                break;
            case '2':// 楼栋类别配置
                $ret = $this->ban_owner_type_add($confContent);
                break;
            case '3':// 楼栋完损等级配置
                $ret = $this->ban_damage_grade_add($confContent);
                break;
            case '4':// 使用性质配置
                $ret = $this->use_nature_add($confContent);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
    public function ban_structure_type_add($confContent){
        $data = ['StructureType' => $confContent];
        $ret = Db::name('ban_structure_type')->insert($data);
        $addId = Db::name('ban_structure_type')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function ban_owner_type_add($confContent){
        $data = ['OwnerType' => $confContent];
        $ret = Db::name('ban_owner_type')->insert($data);
        $addId = Db::name('ban_owner_type')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function ban_damage_grade_add($confContent){
        $data = ['DamageGrade' => $confContent];
        $ret = Db::name('ban_damage_grade')->insert($data);
        $addId = Db::name('ban_damage_grade')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }
    public function use_nature_add($confContent){
        $data = ['UseNature' => $confContent];
        $ret = Db::name('use_nature')->insert($data);
        $addId = Db::name('use_nature')->getLastInsID();
        if($ret)
            return $addId;
        else
            return 0;
    }

    /**
     * 参数配置删除
     * @param $data 需要删除的数据
     */
    public function parameter_delete($data){
        $confId = $data['confId'];
        $classId = $data['classId'];
        $ret = null;
        switch ($classId) {
            case '1':// 楼栋结构配置
                $ret = $this->ban_structure_type_delete($confId);
                break;
            case '2':// 楼栋类别配置
                $ret = $this->ban_owner_type_delete($confId);
                break;
            case '3':// 楼栋完损等级配置
                $ret = $this->ban_damage_grade_delete($confId);
                break;
            case '4':// 使用性质配置
                $ret = $this->use_nature_delete($confId);
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
    public function ban_structure_type_delete($confId){
        return Db::name('ban_structure_type')->delete($confId);
    }
    public function ban_owner_type_delete($confId){
        return Db::name('ban_owner_type')->delete($confId);
    }
    public function ban_damage_grade_delete($confId){
        return Db::name('ban_damage_grade')->delete($confId);
    }
    public function use_nature_delete($confId){
        return Db::name('use_nature')->delete($confId);
    }
}