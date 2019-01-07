<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Request;
use think\Db;

class PropertyReport extends Base
{
    public function index(){
       //临时缓存产权统计报表，每次访问都更新
//       $nowYear = date('Y',time());
//       $cacheTime = 3600*24*360;
//       $PropertyReportdata = model('ph/PropertyReport')->index();
//       Cache::store('file')->set('PropertyReport'.$nowYear,json_encode($PropertyReportdata),$cacheTime);

        //注意所有与私房、区直共有房屋还没做
        //获取所有产别，去除代管产、托管产
        //$owerLst = Db::name('ban_owner_type')->where('id','not in','3,7')->field('id,OwnerType')->select();
        $owerLst = [
            1 => '市属',
            2 => '区属',
            5 => '自管',
            6 => '生活',
            10 => '市区自',
            11 => '所有产别',
        ];
        //初始条件
        $institutionid = session('user_base_info.institution_id');
        $ownerType = 11;
        $date = date('Y',time());
        //$propertyOption['TubulationID'] = $institutionid;

        /*搜索条件*/
        $propertyOption = array();
        $searchForm = input('request.');
        if (isset($searchForm['OwnerType'])) {
            $propertyOption = $searchForm;
            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $institutionid = $searchForm['TubulationID'];
            }
            if (isset($searchForm['OwnerType']) && $searchForm['OwnerType']) {  //检索楼栋产别
                $ownerType = $searchForm['OwnerType'];
            }
            if (isset($searchForm['year']) && $searchForm['year']) {  //检索年
                $date = trim($searchForm['year']);
            }
        }
        //if($date == 2017){
            $dataJson = Db::name('report')->where(['type'=>'PropertyReport','date'=>$date])->value('data');
            $datas = json_decode($dataJson,true);
            // dump($ownerType);
            // dump($institutionid);
            
        // }else{
        //     $datas = json_decode(Cache::store('file')->get('PropertyReport'.$date ,''),true);
        // }
        //halt($dataJson);
        //dump($ownerType);dump($institutionid);exit;
        $data = $datas?$datas[$ownerType][$institutionid]:array();//halt($data);
// 原数据转换方法如下
// $results = [];
//         foreach($datas as $a => $z){
//             foreach($z as $b =>$y){
//                foreach($y as $c => $x){
//                     $j = 0;
//                     foreach($x as $d=>$i){
//                         $results[$a][$b][$c][$j] = $i;
//                         $j++;
//                     }            
//                 }
//             }
//         }
//halt($results);

        $this->assign([
            'institutionid' => $institutionid,
            'data' => $data,
            'propertyOption' => $propertyOption,
            'owerLst' => $owerLst,
        ]);
        
        return $this->fetch();
    }

    public function index_copy(){

        //注意所有与私房、区直共有房屋还没做

        //获取所有产别，去除代管产、托管产
        $owerLst = Db::name('ban_owner_type')->where('id','not in','3,7')->field('id,OwnerType')->select();

        //初始化查询条件，默认市属、当前月份、当前机构
        $wheres['DateStart'] = array('eq',date('Y',time()));
        $wheres['Status'] = array('eq',1);
        $wheres['ChangeType'] = array('eq',7);
        $where['OwnerType'] = array('eq',1);
        $where['Status'] = array('eq',1);
        $currentUserInstitutionID = session('user_base_info.institution_id');
        $currentUserLevel = Db::name('institution')->where('id', 'eq', $currentUserInstitutionID)->value('Level');
        if ($currentUserLevel == 3) { //用户为管段级别，则直接查询
            $where['TubulationID'] = array('eq', $currentUserInstitutionID);
        } elseif ($currentUserLevel == 2) {  //用户为所级别，则获取所有该所子管段，查询
            $where['InstitutionID'] = array('eq', $currentUserInstitutionID);
        } else {   //用户为公司级别，则获取所有子管段
        }

        //检索条件
        if ($searchForm = input('post.')) {

            $propertyOption = $searchForm;

            if (isset($searchForm['TubulationID']) && $searchForm['TubulationID']) {   //检索机构
                $level = Db::name('institution')->where('id', 'eq', $searchForm['TubulationID'])->value('Level');
                if ($level == 3) {
                    $where['TubulationID'] = array('eq', $searchForm['TubulationID']);
                } elseif ($level == 2) {
                    $where['InstitutionID'] = array('eq', $searchForm['TubulationID']);
                }
            }

            if ($searchForm['OwnerType']) {  //检索楼栋产别
                $where['OwnerType'] = array('eq', $searchForm['OwnerType']);
            }
            if ($searchForm['year']) {  //检索月份
                $wheres['DateStart'] = $searchForm['year'];
            }

        }

        //获取市属的所有楼栋数量和，建筑面积
        $one = Db::name('ban')->where($where)->field('count(BanID) as num, sum(TotalArea) as totalAreas')->find();

        //获取市属的所有楼栋数量和，建筑面积
        //halt($where);

        if($where['OwnerType'][1] == 1){
            $options = $where;
            unset($options['OwnerType']);
            $two = Db::name('ban')->where($options)->where('OwnerType',3)->field('count(BanID) as num, sum(TotalArea) as totalAreas')->find();
            $three = Db::name('ban')->where($options)->where('OwnerType',7)->field('count(BanID) as num, sum(TotalArea) as totalAreas')->find();
        }else{
            $two = array();
            $three = array();
        }



        //获取市属的所有楼栋数量和，建筑面积


        $bans = Db::name('ban')->where('OwnerType',$where['OwnerType'][1])->column('BanID');
//halt($wheres);
        $data = Db::name('change_order')->alias('a')   //统计后六个
        ->join('Ban b','a.BanID = b.BanID','left')
            ->where($wheres)
            ->field('a.CancelType ,a.BanID ,b.TotalArea')
            ->select();


        $cutSum = 0;
        $cutTotalArea = 0;

        //halt($data);
        if(!$data){
            $five = array();
        }else{
            foreach ($data as $key => $value) {
                if(in_array($value['BanID'],$bans)){  //如果
                    $five[$value['CancelType']][] = $value['TotalArea'];
                }
            }
            foreach ($five as $k => &$v) {
                $cutSum += count($v);  //
                $v['totalArea'] = array_sum($v);
                $cutTotalArea += $v['totalArea'];
            }
        }

//        if ($where['OwnerType'] != 1) {  //查询不是市属则，将代管和托管的数据归零
//            $two = array();
//            $three = array();
//        }

        //halt($changeData);

//        $seven = 0; // 所有与私房、区直共有房屋的楼栋数量
//        $eight = 0; // 所有与私房、区直共有房屋的楼栋建面和
//
//        $HouseIdList['option'] = array();
//

//        if (!isset($where)) {
//            $where = 1;
//        }
//
//        $nowYear = date('Y',time());
//        $map = $where;
//
//        if(isset($where['Year'])){
//            unset($map['Year']);
//            unset($map['Month']);
//        }
//
//        $increase = Db::name('ban_change_record')->field('count(id) as ids ,sum(BanAreaAdd) as BanAreaAdds')->where('BanAreaAdd','>',0)->where($map)->where('Year','eq',$nowYear)->find();
//        $nine = $increase['ids']; //年房屋增加栋数
//        $ten = $increase['BanAreaAdds'];  //年增加建筑面积
//
//        $reduce = Db::name('ban_change_record')->field('count(id) as ids ,sum(BanAreaAdd) as BanAreaAdds')->where('BanAreaAdd','<',0)->where($map)->where('Year','eq',$nowYear)->find();
//        $eleven = $reduce['ids']; //年房屋减少栋数
//        $twelve = abs($reduce['BanAreaAdds']);  //年减少建筑面积
//
//        $total = Db::name('ban_change_record')->where($where)->group('SourceType')->column('count(id) as ids','SourceType');
//
//        $thirteen = isset($total[2])?$total[2]:0; //本期房屋增减，接管栋数
//        $fourteen = isset($total[4])?$total[4]:0; //本期房屋增减，合建栋数
//        $fifteen = isset($total[6])?$total[6]:0; //本期房屋增减，公房出售栋数
//        $sixteen = isset($total[10])?$total[10]:0; //本期房屋增减，自然灭失栋数
//        $seventeen = isset($total[7])?$total[7]:0; //本期房屋增减，危改还建栋数
//        $eighteen = isset($total[5])?$total[5]:0; //本期房屋增减，加改扩栋数
//        $nineteen = isset($total[8])?$total[8]:0; //本期房屋增减，危改拆除栋数
//        $twenty = isset($total[11])?$total[11]:0; //本期房屋增减，房屋划转栋数
//        $twentyone = isset($total[3])?$total[3]:0; //本期房屋增减，新建栋数
//        $twentytwo = isset($total[12])?$total[12]:0; //本期房屋增减，其他栋数
//        $twentythree = isset($total[9])?$total[9]:0; //本期房屋增减，落私发还栋数
//        $twentyfour = isset($total[12])?$total[12]:0; //本期房屋增减，其他栋数

        if(!isset($propertyOption)){
            $propertyOption = array();
        }

        $this->assign([
            'cutSum' => $cutSum,
            'cutTotalArea' => $cutTotalArea,
            'one' => $one,
            'two' => $two,
            'three' => $three,
//            'four' => $four,
            'five' => $five,
//            'six' => $six,
//            'seven' => $seven,
//            'eight' => $eight,
//            'nine' => $nine,
//            'ten' => $ten,
//            'eleven' => $eleven,
//            'twelve' => $twelve,
//            'thirteen' => $thirteen,
//            'fourteen' => $fourteen,
//            'fifteen' => $fifteen,
//            'sixteen' => $sixteen,
//            'seventeen' => $seventeen,
//            'eighteen' => $eighteen,
//            'nineteen' => $nineteen,
//            'twenty' => $twenty,
//            'twentyone' => $twentyone,
//            'twentytwo' => $twentytwo,
//            'twentythree' => $twentythree,
//            'twentyfour' => $twentyfour,

            'propertyOption' => $propertyOption,
            'owerLst' => $owerLst,
        ]);

        return $this->fetch();
    }
    
    public function out(){
        
    }
}