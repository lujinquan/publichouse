<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use app\ph\model\OldCutRent as OldCutRentModel;
use think\Request;
use think\Db;

class OldCutRent extends Base
{
    public function index()
    {
        $oldRentLst = model('ph/OldCutRent')->get_all_old_rent();

        $instArr = Db::name('institution')->column('id,Institution');
        //halt($oldRentLst['arr']);
        $this->assign([
            'instArr' => $instArr,
            'oldRentLst' => $oldRentLst['arr'],
            'oldRentObj' => $oldRentLst['obj'],
            'oldRentOption' => $oldRentLst['option'],
        ]);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //halt($data);
            $findOne = Db::name('house')->where('HouseID','eq',$data['HouseID'])
                ->field('BanAddress,ArrearRent,TenantID,OwnerType,UseNature,TenantName,HousePrerent,InstitutionID,InstitutionPID')
                ->find();
            if($findOne){
                if($findOne['ArrearRent'] < $data['PayRent'] && $data['PayYear'] < 2018){
                    return jsons('4005','收缴金额不能超过年度结欠金额');
                }
                // if($findOne['InstitutionID'] != session('user_base_info.institution_id')){
                //     return jsons('4006','请确认该房屋是否属于当前管段');
                // }
                $data['BanAddress'] = $findOne['BanAddress'];
                $data['TenantID'] = $findOne['TenantID'];
                $data['OwnerType'] = $findOne['OwnerType'];
                $data['UseNature'] = $findOne['UseNature'];
                $data['TenantName'] = $findOne['TenantName'];
                $data['HousePrerent'] = $findOne['HousePrerent'];
                $data['InstitutionID'] = $findOne['InstitutionID'];
                $data['InstitutionPID'] = $findOne['InstitutionPID'];
            }else{
                return jsons('4004','房屋编号不存在');
            }
            $data['CreateTime'] = time();
            $data['CreateUserID'] = UID;
            //halt($data);
            if (OldCutRentModel::create($data)) {
               if($data['PayYear'] < 2018){
                   Db::name('house')->where('HouseID',$data['HouseID'])->setDec('ArrearRent',$data['PayRent']);
               }
                // 记录行为
                //action_log('BanInfo_add', UID, 1, '编号为:' . $data['BanID']);
                return jsons('2000', '新增成功');
            } else {
                return jsons('4000', '新增失败');
            }
        }
    }

    public function detail()
    {
        $id = input('id');
        if(!$id) return jsons('4004','参数缺失');
        $one = Db::name('old_rent')->where('id','eq',$id)->field('HouseID,PayYear,PayMonth,PayRent')->find();
        $one['houseDetail'] = get_house_info($one['HouseID']);
        return jsons('2000','获取成功',$one);
    }

    public function delete()
    {
        $id = input('id');
        if(!$id) return jsons('4004','参数缺失');
        $find = Db::name('old_rent')->where('id','eq',$id)->find();

        if($find['OldPayMonth'] != date('Ym',time())){
            return jsons('4000','无法删除以前月收回的年度欠缴');
        }
        $re = Db::name('old_rent')->where('id','eq',$id)->delete();

        if($re){
            Db::name('house')->where('HouseID',$find['HouseID'])->setInc('ArrearRent',$find['PayRent']);
        }
        return $re?jsons('2000','删除成功'):jsons('4000','删除失败');
    }
}