<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-27
 * Time: 9:42
 */

namespace app\ph\model;

use think\Model;
use think\Exception;
use think\Db;

class ProcessConfig extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__PROCESS_CONFIG__';

    public function get_all_process_lst(){
        //$where = 1;

        $where['pid'] = array('eq' , 0);

        $processLst['obj'] = self::field('id ,Title ,CreateUser ,CreateTime')->where($where)->order('id asc')->paginate(config('paginate.list_rows'));

        $processLst['arr'] = $processLst['obj']->all();

        if(!$processLst['arr']){

            $processLst['arr'] = array();
        }

        foreach($processLst['arr'] as &$v){

            $v['CreateUser'] = Db::name('admin_user')->where('Number' ,'eq' ,$v['CreateUser'])->value('UserName');
            $v['CreateTime'] = date('Y-m-d H:i:s' ,$v['CreateTime']);

        }

        return $processLst;
    }

    public function add($data){

        $num = self::where('pid','eq',0)->count();

        $main['Type'] = $data['ProcessTitle'];
        $main['pid'] = 0;
        $main['Title'] = Db::name('change_type')->where('id','eq',$data['ProcessTitle'])->value('ChangeType');
        $main['Total'] = count($data['Title']);
        $main['CreateUser'] = UID;
        $main['CreateTime'] = time();

        $pid = self::insertGetId($main);

        $datas = array();

        foreach($data['Title'] as $key => $value){

            $datas[$key]['Title'] = $value;
            $datas[$key]['pid'] = $pid;
        }

        foreach($data['RoleID'] as $key1 => $value1){

            $datas[$key1]['RoleID'] = $value1;
            $datas[$key1]['Total'] = $key1 + 1;

            $datas[$key1]['RoleName'] = Db::name('admin_role')->where('id' ,'eq' ,$value1)->value('RoleName');
        }

        //halt($datas);
        $result = self::insertAll($datas);

        if($result){

            return true;
        }else{

            return false;
        }

    }

    public function get_config_detail($id){

         $type= self::where('id','eq',$id)->value('Type');

        $data['ProcessTitle'] = $type;

        $result = self::where('pid','eq',$id)->field('RoleID ,Title')->select();

        foreach($result as $key2 => $value2){

            $data['RoleID'][] = $value2['RoleID'];
            $data['Title'][] = $value2['Title'];
        }

        return $data;
    }
}