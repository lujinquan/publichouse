<?php
namespace app\ph\controller;

use think\Db;

class ChangeRecord extends Base
{
    public function index(){

        $data = model('ph/ChangeRecord') -> get_all_record_lst();

        $changes = Db::name('process')->field('id, ProcessName')->select();
//halt($data['option']);
        //获取所有完损等级
        $damaLst = model('ph/BanInfo') -> get_all_damage_grade();

        $this -> assign([
            'changes' => $changes,
            'damaLst'    =>  $damaLst,
            'changeLst' => $data['arr'],
            'changeLstObj' => $data['obj'],
            'changeOption' => $data['option'],
        ]);

        return $this->fetch();
    }

}