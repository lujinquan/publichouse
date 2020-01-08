<?php


namespace app\ph\model;

use think\Model;
use think\Db;
use util\Tree;
use think\Loader;
use think\paginator\driver\Bootstrap;

class RentCut extends Model
{

    // 设置当前模型对应的完整数据表名称
    //protected $table = '__RENT_CUT_ORDER__';

    public function get_all_cut_lst()
    {

        $currentUserInstitutionID = session('user_base_info.institution_id');

        $currentUserLevel = session('user_base_info.institution_level');

        if ($currentUserLevel == 3) {  //用户为管段级别，则直接查询

            $where['a.InstitutionID'] = array('eq', $currentUserInstitutionID);

        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询

            $where['a.InstitutionPID'] = array('eq', $currentUserInstitutionID);

        } else {    //用户为公司级别，则获取所有子管段

        }

        $RentCutList['option'] = array();

        $searchForm = input('param.');

        foreach ($searchForm as &$val) { //去首尾空格
            $val = trim($val);
        }
        if (isset($searchForm['CutType'])) {

            $RentCutList['option'] = $searchForm;

            // if (isset($searchForm['InstitutionID']) && $searchForm['InstitutionID']) {   //检索机构

            //     $level = Db::name('institution')->where('id','eq',$searchForm['InstitutionID'])->value('Level');

            //     if($level == 3) {
            //         $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
            //     }elseif($level == 2){
            //         $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
            //     }
            // }
            if (isset($searchForm['CutType']) && $searchForm['CutType']) {   //检索产别
                $where['a.CutType'] = array('eq', $searchForm['CutType']);
            }
            if (isset($searchForm['MuchMonth']) && $searchForm['MuchMonth']) {   //检索产别
                $where['b.MuchMonth'] = array('eq', $searchForm['MuchMonth']);
            }

            if (isset($searchForm['TenantName']) && $searchForm['TenantName']) {  //模糊检索租户编号
                $where['c.TenantName'] = array('like', '%' . $searchForm['TenantName'] . '%');
            }
            if (isset($searchForm['HouseID']) && $searchForm['HouseID']) {  //模糊检索租户编号
                $where['a.HouseID'] = array('like', '%' . $searchForm['HouseID'] . '%');
            }
            // if ($searchForm['BanAddress']) {  //模糊检索楼栋地址
            //     $where['BanAddress'] = array('like', '%'.$searchForm['BanAddress'].'%');
            // }
            if (isset($searchForm['IDnumber']) && $searchForm['IDnumber']) {  //减免证件号码
                $where['b.IDnumber'] = array('like', '%' . $searchForm['IDnumber'] . '%');
            }

            // if($searchForm['DateStart'] && $searchForm['DateEnd']){  //检索大于等于起始时间，且小于等于结束时间
            //     $start = $searchForm['DateStart'];
            //     $end = $searchForm['DateEnd'];
            //     //dump($start);dump($end);exit;
            //     if($start < $end){
            //         $where['BanYear'] = array('between',$start.",".$end);
            //     }
            // }
            // if($searchForm['DateStart'] && empty($searchForm['DateEnd'])){ //检索大于等于起始时间
            //     $start = $searchForm['DateStart'];
            //     //dump($start);exit;
            //     $where['BanYear'] = array('egt',$start);
            // }
            // if($searchForm['DateEnd'] && empty($searchForm['DateStart'])){ //检索小于等于结束时间
            //     $end = $searchForm['DateEnd'];
            //     $where['BanYear'] = array('elt',$end);
            // }

        }

        //$where['Startline'] = array('>', 197001);
        $where['a.Status'] = array('eq', 1);
        $where['a.ChangeType'] = array('eq', 1);
        //$where['d.Status'] = array('neq', 0);
        //$where['e.ChangeType'] = array('eq', 1);
        //halt($where);

        $result = Db::name('change_order')->alias('a')->join('rent_cut_order b','a.ChangeOrderID = b.ChangeOrderID','left')->join('tenant c','a.TenantID = c.TenantID','inner')->join('house e','a.HouseID = e.HouseID','left')->field('a.ChangeOrderID,a.CutType,c.TenantName,a.InflRent,a.HouseID,b.IDnumber,b.MuchMonth,a.DateEnd,e.IfSuspend,e.Status as HouseStatus')->where($where)->select();
        
        $usechanges = Db::name('use_change_order')->where(['CreateTime'=>['between time',[1577808000,1580486400]],'ChangeType'=>['neq',2],'Status'=>['eq',1]])->column('HouseID');
        //halt($usechanges);
        $startTime = strtotime(date('Y'.'-01-01'));
        $endTime = strtotime(date('Y'.'-01-17'));
//halt($result);
        $sresult = [];

        foreach($result as $v){
            $temps = Db::name('change_cut_year')->field('Status,FinishTime')->where(['ChangeOrderID'=>['eq',$v['ChangeOrderID']]])->order('id desc')->find();
            if(!empty($temps)){
                $v['Status'] = $temps['Status'];  
                $v['FinishTime'] = $temps['FinishTime']; 
                
            }else{
               $v['Status'] = null;  
               $v['FinishTime'] = 0;  
            }
            if(time() > $startTime && time() < $endTime && $v['DateEnd'] == 202001 && $v['IfSuspend'] == 0 && $v['HouseStatus'] == 1 && !in_array($v['HouseID'],$usechanges)){
                $v['is_process_year_cut'] = 1;
            }else{
                $v['is_process_year_cut'] = 0;
            }
            if($v['DateEnd'] == date('Ym')){
                $v['DateEnd'] = substr($v['DateEnd'],0,4).'-'.substr($v['DateEnd'],-2);
                array_unshift($sresult,$v);
            }else{
                $v['DateEnd'] = substr($v['DateEnd'],0,4).'-'.substr($v['DateEnd'],-2);
                $sresult[] = $v;
            } 
        }
        $re = [];
        $level = session('user_base_info.institution_level');

        foreach ($sresult as $key => $value) {
            if($level == 3){
                if(!$value['Status'] && in_array(581,session('three_menu_status')) && $v['is_process_year_cut']){
                    array_unshift($re,$value); 
                }else{
                    array_push($re,$value); 
                }
            }else{
                if($value['Status'] == 2 && in_array(582,session('three_menu_status'))){
                    array_unshift($re,$value); 
                }else{
                    array_push($re,$value); 
                }
            }        
        }
        
        //halt($re);
        $curpage = input('page') ? input('page') : 1;//当前第x页，有效值为：1,2,3,4,5...
        $listRow = 15;//每页215行记录
        //$showdata = array_chunk($s, $listRow, true);
        $showdata = array_slice($re, ($curpage - 1)*$listRow, $listRow,true);
        
        $p = Bootstrap::make($showdata, $listRow, $curpage, count($re), false, [
            'var_page' => 'page',
            'path'     => url('/ph/RentCut/index'),//这里根据需要修改url
            'query'    => [],
            'fragment' => '',
        ]);
        //halt($showdata);
        $p->appends($_GET);
        $RentCutList['arr'] = $showdata;
        $RentCutList['obj'] = $p;
        //halt($RentCutList['obj']);
        // $RentCutList['obj'] = Db::name('change_order')->alias('a')->join('rent_cut_order b','a.ChangeOrderID = b.ChangeOrderID','inner')->field('a.ChangeOrderID,a.CutType,a.TenantID,a.HouseID,b.IDnumber,MuchMonth,a.DateEnd')->where($where)->paginate(config('paginate.list_rows'));

        //$RentCutList['arr'] = $RentCutList['obj']->all() ? $RentCutList['obj']->all() : array();

        return $RentCutList;
    }

    public function uploads($file,$k1){

        $title = config($k1); //上传文件标题

        Loader::import('uploads.Uploads',EXTEND_PATH);

        $fileUpload = new \FileUpload();

        $fileUpload->set('allowtype',array('jpg','jpeg','gif','png')); //设置允许上传的类型
        $fileUpload->set('path',$_SERVER['DOCUMENT_ROOT'].'/uploads/changeOrder/'); //设置保存的路径
        $fileUpload->set('maxsize',5*1024*1024); //限制上传文件大小
        $fileUpload->set('israndname',true); //设置是否随机重命名文件， false不随机

        $res = $fileUpload->upload($k1);

        if($res !== true){

            //return jsons('4003' ,$fileUpload->getErrorMsg());
            return jsons('4003' ,'上传失败');

        }else{  //上传成功

            //多文件上传，遍历操作
            $names = $fileUpload->getFileName();

            foreach($names as $k => $v){

                $data['FileUrl']= '/uploads/changeOrder/'.$v;          //写入到数据库中的地址和存放地址 $targetPath 不一样
                $data['FileTitle'] = $title;                  
                $data['FileType'] = 1;        //图片类型
                $data['UploadUserID'] = UID;
                $data['UploadTime'] = time();
                $result = Db::name('upload_file')->insert($data);    //返回受影响的记录数，通常为1

                if($result == 1) {
                    $fileID[] = Db::name('upload_file')->getLastInsID();
                }
            }

            return $fileIDS = implode(',', $fileID);

        }

    }
}