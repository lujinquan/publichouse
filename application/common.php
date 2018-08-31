<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Mr.Lu <lu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Db;

//微信支付函数
function wxpay($body,$total_fee,$out_trade_no){
    //传入支付参数
    //$out_trade_no = date('Ymd').time().mt_rand();
    $params = [
        'body' => $body,
        'out_trade_no' => $out_trade_no,
        'total_fee' => $total_fee,
        'product_id' => $out_trade_no,
        'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/index/user/notifyPay',
    ];
    $result = \wxpayapi\NativePay::getPayImage($params,300,300);
    return $result;
}

//获取传入日期的上一个月份的日期：例如：传入201702，输出201701
function getlastMonthDays($date){
    if(strpos($date,'-') === false){    //将时间日期格式转化成2017-xx的格式即可
        $str = substr($date,0,4).'-'.substr($date,4,2);
    }
    $firstday = date('Y-m',strtotime($str));

    $date =date('Ym',strtotime($firstday)-3600*24*7);
    return $date;
}

//获取传入日期的下一个月份的日期：例如：传入201702，输出201703
function getnextMonthDays($date){
    if(strpos($date,'-') === false){    //将时间日期格式转化成2017-xx的格式即可
        $str = substr($date,0,4).'-'.substr($date,4,2);
    }
    $firstday = date('Y-m',strtotime($str));

    $date =date('Ym',strtotime($firstday)+3600*24*7);
    return $date;
}

function check($houseid,$banid){
    if($houseid){
        $flag = Db::name('change_order')->where(['HouseID'=>$houseid,'OrderDate'=>date('Ym'),'ChangeType'=>7,'Status'=>['>',0]])->find();
    }
    if($banid){
        $flag = Db::name('change_order')->where(['BanID'=>$banid,'OrderDate'=>date('Ym'),'ChangeType'=>7,'Status'=>['>',0]])->find();
    }
    if(isset($flag) && $flag){
        return jsons('4000','正在异动单中数据不能修改');
    }
}

// 应用公共文件
function tree($data,$pid=0,$level=0){
    //定义一个静态数组型变量
    static $tree = array();
    //遍历 $data
    foreach($data as $row){
        //获取pid=$pid的元素
        if($row['pid'] == $pid){
            $row['level'] = $level;
            //存储当前数据
            $tree[]=$row;
            //实现递归操作
            tree($data,$row['id'],$level+1);
        }
    }
    //返回遍历好的数据
    return $tree;
}

function get_attr($a,$pid=0){
    $tree = array();                                //每次都声明一个新数组用来放子元素  
    foreach($a as $v){
        if($v['pid'] == $pid){                      //匹配子记录  
            $v['children'] = get_attr($a,$v['id']); //递归获取子记录  
            if($v['children'] == null){
                unset($v['children']);             //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）  
            }
            $tree[] = $v;                           //将记录存入新数组  
        }
    }
    return $tree;                                  //返回新数组  
}

function convertUTF8($str){
    if (empty($str)) {
        return $str;
    }
    $code = mb_detect_encoding($str);     //$code为当前字符的字符编码

    if ($code == 'UFT-8') {
        return $str;
    } else {
        return iconv($code, 'utf-8', $str);
    }
}

/**
 * 生成pdf
 * @param  string $html      需要生成的内容
 */
function pdf($html='<h1 style="color:red">hello word</h1>'){
    vendor('Tcpdf.tcpdf');
    $pdf = new \Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // 设置打印模式  
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 001');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    // 是否显示页眉  
    $pdf->setPrintHeader(false);
    // 设置页眉显示的内容  
    $pdf->SetHeaderData('logo.png', 60, 'baijunyao.com', '白俊遥博客', array(0,64,255), array(0,64,128));
    // 设置页眉字体  
    $pdf->setHeaderFont(Array('dejavusans', '', '12'));
    // 页眉距离顶部的距离  
    $pdf->SetHeaderMargin('5');
    // 是否显示页脚  
    $pdf->setPrintFooter(true);
    // 设置页脚显示的内容  
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    // 设置页脚的字体  
    $pdf->setFooterFont(Array('dejavusans', '', '10'));
    // 设置页脚距离底部的距离  
    $pdf->SetFooterMargin('10');
    // 设置默认等宽字体  
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // 设置行高  
    $pdf->setCellHeightRatio(1);
    // 设置左、上、右的间距  
    $pdf->SetMargins('10', '10', '10');
    // 设置是否自动分页  距离底部多少距离时分页  
    $pdf->SetAutoPageBreak(TRUE, '15');
    // 设置图像比例因子  
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->setFontSubsetting(true);
    $pdf->AddPage();
    // 设置字体  
    $pdf->SetFont('stsongstdlight', '', 14, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output('example_001.pdf', 'I');
}

function jsons($retcode='2000', $msg='', $data=[], $extend=""){

    if($data) $data = array_no_null($data);//去除null值
    $arr = ['retcode'=>(string)$retcode,
        'msg'=>$msg,
        'data'=>$data];
    if(!empty($extend))	$arr = array_merge($arr,$extend);
    echo json_encode($arr);
    die();
}

function array_no_null($arr) {
    if (is_array($arr)) {
        foreach ( $arr as $k => $v ) {
            if (is_numeric($v)) $arr[$k] = (string)$v;
            if (is_null($v)) $arr[$k] = '';

            elseif (is_array($v) || is_object($v)) {
                $arr[$k] = array_no_null($v);
            }
        }
    }
    return $arr;
}

    function is_signin()
    {
        return model('user/User')->isLogin();
    }



if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if (!function_exists('hook')) {
    /**
     * 监听钩子
     * @param string $name 钩子名称
     * @param array $params 参数
     * @author Mr.Lu
     */
    function hook($name = '', $params = []) {
        \think\Hook::listen($name, $params);
    }
}

if (!function_exists('clear_js')) {
    /**
     * 过滤js内容
     * @param string $str 要过滤的字符串
     * @author Mr.Lu
     * @return mixed|string
     */
    function clear_js($str = '')
    {
        $search ="/<script[^>]*?>.*?<\/script>/si";
        $str = preg_replace($search, '', $str);
        return $str;
    }
}

/**
 * 获取结构名称
 * @author Mr.Lu
 */
function get_structure($id){
    $structureType = Db::name('ban_structure_type')->where('id','eq',$id)->value('StructureType');
    return $structureType;
}

function get_institution($id){
    $institution = Db::name('institution')->where('id' ,'eq' ,$id)->value('Institution');
    return $institution;
}

/**
 * 获取产别名称
 * @author Mr.Lu
 */
function get_owner($id){
    $ownerType = Db::name('ban_owner_type')->where('id','eq',$id)->value('OwnerType');
    return $ownerType;
}

/**
 * 获取完损等级名称
 * @author Mr.Lu
 */
function get_damage($id){
    $damageGrade = Db::name('ban_damage_grade')->where('id','eq',$id)->value('DamageGrade');
    return $damageGrade;
}

/**
 * 获取使用性质名称
 * @author Mr.Lu
 */
function get_usenature($id){
    $useNature = Db::name('use_nature')->where('id','eq',$id)->value('UseNature');
    return $useNature;
}

function get_area($id){
    $areaTitle = Db::name('area')->where('id','eq',$id)->value('AreaTitle');
    return $areaTitle;
}

function get_all_log_type(){
    $areaTitle = Db::name('admin_log_type')->column('id,TypeName');
    return $areaTitle;
}

function get_all_institution_type(){
    $areaInstitution = Db::name('institution')->column('id,Institution');
    return $areaInstitution;
}

/**
 * 获取房间基价
 * @author Mr.Lu
 */
function get_room_type_point($id){
    $roomPoint = Db::name('room_type_point')->where('id','eq',$id)->value('Point');
    return $roomPoint;
}

/**
 * 获取结构基价
 * @author Mr.Lu
 */
function get_structure_type_point($id){
    $structurePoint = Db::name('ban_structure_type')->where('id','eq',$id)->value('NewPoint');
    return $structurePoint;
}

/**
 * 获取结构基价
 * @author Mr.Lu
 */
function get_rent_cut_point($banID){
    $id = Db::name('ban')->where('BanID' ,'eq' ,$banID)->value('StructureType');
    $structurePoint = Db::name('ban_structure_type')->where('id','eq',$id)->value('NewPoint');
    return $structurePoint;
}

if (!function_exists('action_log')) {
    /**
     * 记录行为日志，并执行该行为的规则
     * @param null $action 行为标识
     * @param null $model 触发行为的模型名
     * @param string $record_id 触发行为的记录id
     * @param null $user_id 执行行为的用户id
     * @param string $details 详情
     * @author Mr.Lu
     * @return bool|string
     */
    function action_log($action = null, $userID = null, $actionType = '',  $remark = null ,$description = '')
    {

        // 参数检查
        if(empty($action) || empty($actionType)){
            return '参数不能为空';
        }
        if(empty($userID)){
            $user_id = is_signin();
        }

        if($remark == 1){
            $actionName = $action;
            $desc = $actionName.'操作。';
        }else{
            $newAction = str_replace('_','/',$action);
            $actionName = Db::name('admin_menu')->where('UrlValue','like','%'.$newAction.'%')->value('Title');
            $desc = $actionName.'操作，'.$remark.'。';
        }

        $currentTime = date('Y-m-d H:i:s' ,request()->time());

        $institutionName = session('user_base_info.institution_name');

        $realName = model('ph/UserManage')->where('Number' ,$userID)->value('RealName');

        $data = [
            'Action'   => $action,
            'UserID'     => $userID,
            'InstitutionID'   => session('user_base_info.institution_id'),
            'ActionIP'   => get_client_ip(1),
            'ActionType'   => $actionType,
            'Remark'   => $institutionName.$realName.'于'.$currentTime.' 执行'.$desc,
            'CreateTime' => request()->time(),
            'Description' => $description,
        ];
        //halt($data);
        Db::name('admin_log')->insert($data);
    }

    function get_date($type="1" ,$sign="1"){

        //得到系统的年月
        $tmp_date=date("Ym");

        //切割出年份
        $tmp_year=substr($tmp_date,0,4);

        //切割出月份
        $tmp_mon =substr($tmp_date,4,2);

        $tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);

        $tmp_forwardmonth=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);

        if($sign == 1){

            //得到当前月的下一个月

            $fm_next_month['month'] = ltrim(date("m",$tmp_nextmonth),'0');
            $fm_next_month['year'] = date("Y",$tmp_nextmonth);

            if($type == 0){
                return $fm_next_month=date("Ym",$tmp_nextmonth);
            }

            return $fm_next_month;

        }else{

            //得到当前月的上一个月

            $fm_forward_month['month'] = ltrim(date("m",$tmp_forwardmonth),'0');
            $fm_forward_month['year'] = date("Y",$tmp_forwardmonth);

            if($type == 0){
                return $fm_forward_month=date("Ym",$tmp_forwardmonth);
            }

            return $fm_forward_month;

        }

    }
}

function get_cancel_type(){
    $data = Db::name('cancel_type')->column('id,Title');
    return $data;
}

function get_use_nature(){
    $data = Db::name('use_nature')->column('id,UseNature');
    return $data;
}

function get_all_institution(){
    $currentUserInstitutionID = session('user_base_info.institution_id');
    $currentUserLevel = session('user_base_info.institution_level');
    if($currentUserLevel == 3) {  //用户为管段级别，无添加修改权限，所以不分配机构数据到下拉菜单中
    }elseif($currentUserLevel == 2){  //所级别
        $datas = Db::name('institution')->field('id,Institution,pid')->where('pid','eq',$currentUserInstitutionID)->select();
        return $datas;
    }else{  //公司级别
        $datas = Db::name('institution')->field('id,Institution,pid')->select();
        return tree($datas);
    }
}

//通过房屋ID获取对应租户的详细信息
function get_tenantinfo_by_houseid($houseid = '',$map=''){

    $data = Db::name('house')->alias('a')
                             ->join('tenant b','a.TenantID = b.TenantID' ,'left')
                             ->where('a.HouseID' ,'eq' ,$houseid)
                             ->field($map)
                             ->find();

    if(!$data) {

        return array();
    }

    return $data;

}

function get_all(){

    $sql ='select count(BanID),group_concat(BanID) as BanIDS from ph_ban group by TubulationID order by TubulationID asc';

    $data = Db::name('ban')->query($sql);

    return $data;
}

function get_house_info($houseID){

    /*查询房屋信息*/
    $data = Db::name('house')->field('*')->where('HouseID','eq',$houseID)->find();

    if(empty($data)){return jsons('4004','房屋编号不存在');}

    $data['OwnerTypes'][0]['OwnerType'] = get_owner($data['OwnerType']);
    $data['OwnerTypes'][0]['HousePrerent'] = $data['HousePrerent'];
    $data['OwnerTypes'][1]['OwnerType'] = $data['AnathorOwnerType']?get_owner($data['AnathorOwnerType']):0;
    $data['OwnerTypes'][1]['HousePrerent'] = $data['AnathorHousePrerent']?$data['AnathorHousePrerent']:0;
    $data['UseNature'] = get_usenature($data['UseNature']);
    $data['CreateTime'] = date('Y-m-d H:i:s' ,$data['CreateTime']);
    $data['IfWaterName'] = $data['IfWater']?'是':'否';

    /*如果该房屋绑定了租户则，查询出【租户】的身份证号，联系电话*/
    if($data['TenantID']){
        $tenantOne = Db::name('tenant')->field('TenantNumber,TenantTel')
                                       ->where('TenantID','eq',$data['TenantID'])
                                       ->find();
        $data['TenantNumber'] = $tenantOne['TenantNumber'];
        $data['TenantTel'] = $tenantOne['TenantTel'];
    }else{
        $data['TenantNumber'] = '';
        $data['TenantTel'] = '';
    }

    /*如果该房屋绑定了楼栋则，查询出所属【楼栋】的完损等级，结构等级，占地面积，是否电梯，是否架空*/
    if($data['BanID']){
        $banOne = Db::name('ban')->field('DamageGrade ,StructureType ,CoveredArea ,IfElevator,IfFirst')
                                 ->where('BanID','eq',$data['BanID'])
                                 ->find();
        $data['DamageGrade'] = get_damage($banOne['DamageGrade']);
        $data['StructureType'] = get_structure($banOne['StructureType']);
        $data['CoveredArea'] = $banOne['CoveredArea'];
        $data['IfElevator'] = $banOne['IfElevator'];
        $data['IfFirst'] = $banOne['IfFirst'];
        if($data['IfElevator'] == 0){
            $data['IfElevatorName'] = '无电梯';
        }elseif($data['IfElevator'] == 1){
            $data['IfElevatorName'] = '有电梯且免费';
        }elseif($data['IfElevator'] == 2){
            $data['IfElevatorName'] = '有电梯需缴费';
        }
        //$data['IfElevatorName'] = $data['IfElevator']?'是':'否';
        $data['IfFirstName'] = $data['IfFirst']?'是':'否';
    }

    $data['RoomNumbers'] = Db::name('Room')->where('HouseID','like','%'.$houseID.'%')->column('RoomID,RoomNumber');

    return $data?$data:array();
}

function get_ban_info($banID){

    $map = 'BanAddress ,BanID ,DamageGrade,PreRent,StructureType ,BanAddress,UseNature ,BanFloorNum ,BanUsearea, TotalArea ,IfFirst,IfElevator, CoveredArea ,BanUnitNum ,OwnerType ,CreateTime ,TubulationID ,TotalOprice';

    $data = Db::name('ban')->where('BanID' ,'eq' ,$banID)->field($map)->find();
    $data['CreateTime'] = date('Y-m-d H:i:s',$data['CreateTime']);
    $data['DamageGrade'] = get_damage($data['DamageGrade']);
    $data['OwnerType'] = get_owner($data['OwnerType']);
    $data['NewPoint'] = Db::name('ban_structure_type')->where('id',$data['StructureType'])->value('NewPoint');
    $data['StructureType'] = get_structure($data['StructureType']);
    $data['UseNature'] = get_usenature($data['UseNature']);
    $data['InstitutionID'] = get_institution($data['TubulationID']);

    return $data;
}

function get_room_item_point($id){

    $unitPrice = Db::name('room_item_point')->where('id' ,'eq' ,$id)->value('UnitPrice');

    return $unitPrice;
}

function get_institution_level($id){

    $currentUserLevel = Db::name('institution')->where('id', 'eq', $id)->value('Level');

    return $currentUserLevel;
}

function pdf_info($houseID){

    $map = 'BanID,OwnerType ,BanAddress,TenantName,HousePrerent ,HouseArea,UnitID,FloorID,AnathorOwnerType ,AnathorHousePrerent ,UseNature ,ComprisingArea ,IfWater,WallpaperArea,CeramicTileArea,BathtubNum,BasinNum,BelowFiveNum ,MoreFiveNum,PumpCost,ApprovedRent,ReceiveRent,RemitRent,HouseUsearea,LeasedArea,DiffRent,ProtocolRent';

    $housedata = Db::name('house')->where('HouseID' ,'eq' ,$houseID)->field($map)->find();

    $bandata = Db::name('ban')->where('BanID','eq',$housedata['BanID'])
                              ->field('StructureType,BanAddress,IfElevator ,IfFirst')
                              ->find();

    $housedata['OwnerType'] = get_owner($housedata['OwnerType']);

    $structureTypePoints = Db::name('ban_structure_type')->column('id,NewPoint');
    $housedata['StructureTypePoint'] = $structureTypePoints[$bandata['StructureType']];
    $housedata['AnathorOwnerType'] = $housedata['AnathorOwnerType']?get_owner($housedata['AnathorOwnerType']):'无';
    $housedata['AnathorHousePrerent'] = $housedata['AnathorHousePrerent']?$housedata['AnathorHousePrerent']:0;
    $housedata['StructureType'] = get_structure($bandata['StructureType']);
    $housedata['UseNature'] = get_usenature($housedata['UseNature']);
    $housedata['IfWaterName'] = $housedata['IfWater']?'是':'否';
    $housedata['IfElevatorName'] = $bandata['IfElevator']?'是':'否';
    $housedata['IfFirstName'] = $bandata['IfFirst']?'是':'否';

    $roomArr = Db::name('Room')->where('HouseID','like','%'.$houseID.'%')
                               ->field('BanID,RoomID,RoomNumber,RoomType,RoomName,RoomPublicStatus,HouseID,UnitID,FloorID,RentPoint,UseArea,LeasedArea,RoomRentMonth')
                               ->select();

    $pointArr =Db::name('room_type_point')->column('id,Point');

    if(empty($roomArr)){
        $roomArr = array();
    }else{
        foreach ($roomArr as $key => &$value) {
            $housearr = explode(',',$value['HouseID']);
            $value['HouseIDOne'] = $housearr[0];
            $value['HouseIDTwo'] = isset($housearr[1])?$housearr[1]:'';
            $value['HouseIDThree'] = isset($housearr[2])?$housearr[2]:'';

            if($value['RoomPublicStatus'] == 1){
                $value['RoomPublicStatusName'] = '独用';
            }else{
                $value['RoomPublicStatusName'] = '共用';
            }
            $value['Point'] = $pointArr[$value['RoomType']];
        }
    }

    $data['houseinfo'] = $housedata;
    $data['roominfo'] = $roomArr;
    return $data;

}


function get_wait_processing(){

    $roleArr = json_decode(session('user_base_info.role'),true);

    $institutionLevel = session('user_base_info.institution_level');

    if($institutionLevel == 2){
        $where['a.InstitutionPID'] = session('user_base_info.institution_id');

    }elseif($institutionLevel == 3){
        $where['a.InstitutionID'] = session('user_base_info.institution_id');
        
    }

    $where['Status'] = array('not in','0,1'); 

    $useData = Db::name('use_change_order')->alias('a')->join('use_change_type b','a.ChangeType = b.id','left')->field('a.ChangeOrderID ,a.CreateTime ,b.UseChangeTitle as ChangeType ,a.Status')->order('a.CreateTime desc')->limit(5)->select();

    foreach($useData as $u){

        $config = Db::name('use_change_order')->alias('a')
            ->join('process_config b' ,'a.ProcessConfigType = b.Type' ,'left')
            ->where('a.ChangeOrderID' ,'eq' ,$u['ChangeOrderID'])
            ->order('a.CreateTime desc')
            ->field('b.id, b.Title ,b.Total')
            ->find();

        $maps['pid'] = array('eq',$config['id']);
        $maps['Total'] = array('eq',$u['Status']);

        $roleid = Db::name('process_config')->where($maps)->value('RoleID');

        unset($u['Status']);

        $u['CreateTime'] = date('Y-m-d H:i:s',$u['CreateTime']);

        $u['type'] = 1;

        if(in_array($roleid,$roleArr)){
            $datas[] = $u;
        }
    }

    $changeData = Db::name('change_order')->alias('a')
        ->join('change_type b','a.ChangeType = b.id','left')
        ->where($where)
        ->field('a.ChangeOrderID ,a.CreateTime ,b.ChangeType ,a.Status')
        ->order('a.CreateTime desc')
        ->limit(5)
        ->select();

    foreach($changeData as $v){

        $config = Db::name('change_order')->alias('a')
            ->join('process_config b' ,'a.ProcessConfigType = b.id' ,'left')
            ->where('a.ChangeOrderID' ,'eq' ,$v['ChangeOrderID'])
            ->order('a.CreateTime desc')
            ->field('b.id, b.Title ,b.Total')
            ->find();

        $maps['pid'] = array('eq',$config['id']);
        $maps['Total'] = array('eq',$v['Status']);

        $roleid = Db::name('process_config')->where($maps)->value('RoleID');

        unset($v['Status']);

        $v['CreateTime'] = date('Y-m-d H:i:s',$v['CreateTime']);
        
        $v['type'] = 2;

        if(in_array($roleid,$roleArr)){
            $datas[] = $v;
        }
    }
//halt($datas);
    if(!isset($datas)) return array();

    return $datas;
}

//房屋租金计算方式：各房间 + 加计租金 + 三户共用金额 + 租差 + 协议租金
function count_house_rent($houseid){

    if(in_array($houseid,array(666,888,999))){
        return 0;
    }
    
    $where['HouseID'] = array('like','%'.$houseid.'%');
    $where['Status'] = array('eq',1);
    $where['RoomPublicStatus'] = array('<',3); //去掉3户共用的房间

    //$roomArr = Db::name('room')->where($where)->column('RoomID');
    $roomArr = Db::name('room')->where($where)->field('RoomID,RoomRentMonth')->select();
    if($roomArr){
        foreach ($roomArr as $value) {

            //$rent[] = count_room_rent($value);
            $rent[] = $value['RoomRentMonth'];
        }
        //dump($rent);
        $sumrent = array_sum($rent);
    }else{
        $sumrent = 0;
    }

    //halt($sumrent);
    //PlusRent加计租金，PublicRent三户共用房间的金额，DiffRent租差，ProtocolRent协议租金
    $find = Db::name('house')->field('PublicRent,UseNature')->where('HouseID',$houseid)->find();

    $jiaji = $find['PublicRent']?$find['PublicRent']:0;

    $houseRent = $sumrent + $jiaji;

    if($find['UseNature'] == 1){
        $houseRent = round($houseRent,1);
    }else{
        $houseRent = round($houseRent,2);
    }

    return $houseRent;
}

function count_room_rent($roomid){
    //初始数据
    $roomOne = Db::name('room')->where('RoomID',$roomid)->field('LeasedArea,RentPoint,RoomType,UseNature,FloorID,BanID,RoomPublicStatus')->find();
    $banOne =  Db::name('ban')->where('BanID',$roomOne['BanID'])->field('StructureType,BanFloorNum,IfFirst,IfElevator')->find();

    if($roomOne['RoomPublicStatus'] > 2){ //三户共用直接无租金
        return 0.5;
    }

    //层次调解率，与居住层，有无电梯，楼栋总层数有关
    $floorPoint = get_floor_point($roomOne['FloorID'], $banOne['BanFloorNum'], $banOne['IfElevator']);
    $structureTypePoint = get_structure_type_point($banOne['StructureType']);
    //房间的架空率，与楼栋是否一层为架空层有关
    $emptyPoint = $banOne['IfFirst']?0.98:1;

    //if($roomid = '121640'){
//dump($roomOne['LeasedArea']);dump($roomOne['RentPoint']);dump($structureTypePoint);dump($emptyPoint);halt($floorPoint);
    //}
    
    //计算租金= 计租面积 * 实际基价 * 结构基价 * 基价折减率 * 架空率 * 层次调解率
    $roomRent = $roomOne['LeasedArea'] * $roomOne['RentPoint'] * $structureTypePoint * $emptyPoint * $floorPoint;

    // if($roomOne['RoomPublicStatus'] == 2){ //被两户共用了，就只取一半
    //     $roomRent = $roomRent / 2;
    // }

    return round($roomRent,2);
}

function get_floor_point($liveFloor,$BanFloorNum,$ifElevator){
    //dump($liveFloor);dump($BanFloorNum);dump($ifElevator);
    if($ifElevator == 0){ //无电梯
        if($BanFloorNum>3){
            $floorPoint = Db::name('floor_point')->where(['TotalFloor'=> $BanFloorNum ,'LiveFloor'=> $liveFloor])->value('FloorPoint');
            if ($liveFloor >= 9) $floorPoint = 0.85; //9楼以上层次调解率为0.85
        }else{
            $floorPoint = 1;
        }
        
    }elseif($ifElevator == 1){  //有电梯，免费用
        if($liveFloor<4){
            if($BanFloorNum>3){
                $floorPoint = Db::name('floor_point')->where(['TotalFloor'=> $BanFloorNum ,'LiveFloor'=> $liveFloor])->value('FloorPoint');
                if ($liveFloor >= 9) $floorPoint = 0.85; //9楼以上层次调解率为0.85
            }else{
                $floorPoint = 1;
            }
            
        }elseif($liveFloor>3 && $liveFloor!=$BanFloorNum){
            $floorPoint = 1.05;
        }elseif($liveFloor>3 && $liveFloor==$BanFloorNum){
            $floorPoint = 0.85;
        }
    }elseif($ifElevator == 2){ //有电梯，需交费
        if($liveFloor<3){
           if($BanFloorNum>3){
                $floorPoint = Db::name('floor_point')->where(['TotalFloor'=> $BanFloorNum ,'LiveFloor'=> $liveFloor])->value('FloorPoint');
                if ($liveFloor >= 9) $floorPoint = 0.85; //9楼以上层次调解率为0.85
            }else{
                $floorPoint = 1;
            }
        }elseif($liveFloor>2 && $liveFloor!=$BanFloorNum){
            $floorPoint = 1;
        }elseif($liveFloor>2 && $liveFloor==$BanFloorNum){
            $floorPoint = 0.85;
        }
    }

    return isset($floorPoint)?$floorPoint:1;
}

function count_house_area($houseid){
    if(in_array($houseid,array(666,888,999))){
        return array('HouseUsearea' =>0, 'LeaseArea' =>0);
    }else{
        $roomidArr = Db::name('room')->where('HouseID','like','%'.$houseid.'%')->field('RoomID,UseArea,LeasedArea')->select();
        if($roomidArr){
            foreach ($roomidArr as $v) {
                $useAreaArr[] = $v['UseArea'];
                $leasedAreaArr[] = $v['LeasedArea'];
            }
            return array('HouseUsearea' => array_sum($useAreaArr), 'LeaseArea' => array_sum($leasedAreaArr));
        }else{
            return array('HouseUsearea' =>0, 'LeaseArea' =>0);
        }
    }
}

function change_house_data($houseid){
    $edit['ApprovedRent'] = count_house_rent($houseid);
    $find = count_house_area($houseid);
    $edit['HouseUsearea'] = $find['HouseUsearea'];
    $edit['LeasedArea'] = $find['LeaseArea'];
    Db::name('house')->where('HouseID','eq',$houseid)->update($edit);
}

function array_merge_adds($arr1,$arr2,$arr3,$arr4,$arr5,$arr6,$arr7,$arr8,$arr9,$arr10,$arr11,$arr12,$arr13,$arr14,$arr15){
    //dump($arr1);halt($arr2);
    foreach ($arr1 as $k1 => $ar) {
        foreach ($ar as $k2 => $ar) {
            $add1 = bcadd($ar , $arr2[$k1][$k2] , 2);
            $add2 = bcadd($arr3[$k1][$k2] , $arr4[$k1][$k2] , 2);
            $add3 = bcadd($arr5[$k1][$k2] , $arr6[$k1][$k2] , 2);
            $add4 = bcadd($arr7[$k1][$k2] , $arr8[$k1][$k2] , 2);
            $add5 = bcadd($arr9[$k1][$k2] , $arr10[$k1][$k2] , 2);
            $add6 = bcadd($arr11[$k1][$k2] , $arr12[$k1][$k2] , 2);
            $add7 = bcadd($arr13[$k1][$k2] , $arr14[$k1][$k2] , 2);
            $adds8 = bcadd($add1 , $add2 , 2);
            $adds9 = bcadd($add3 , $add4 , 2);
            $adds10 = bcadd($add5 , $add6 , 2);
            $adds11 = bcadd($arr15[$k1][$k2] , $add7 , 2);
            $adds12 = bcadd($adds8 , $adds9 , 2);
            $adds13 = bcadd($adds10 , $adds11 , 2);
            $re[$k1][$k2] = bcadd($adds12 , $adds13 , 2);
        }
    }
    return $re;

}

function array_merge_add($arr1,$arr2){
    //dump($arr1);halt($arr2);
    foreach ($arr1 as $k1 => $ar) {
        foreach ($ar as $k2 => $ar) {
            $re[$k1][$k2] = bcadd($ar , $arr2[$k1][$k2] , 2);
        }
    }
    return $re;

}

function array_bcadd($arr = array()){
    if(count($arr) > 1){
        $j = 0;
        foreach($arr as $s){
            $j = bcadd($s , $j , 2);
        }
    }else{
        $j = $arr[0];
    }
    return $j;
}

function array_no_space_str($arr){
    if((array)$arr){
        foreach($arr as &$v){
            if($v){
                $v =  str_replace(' ','',$v);
            }
        }
        return $arr;
    }
    return array();

}

/**
 * 列出本地目录的文件
 * @param string $path
 * @param string $pattern
 * @return array
 */
function list_file($path, $pattern = '*')
{
    if (strpos($pattern, '|') !== false) {
        $patterns = explode('|', $pattern);
    } else {
        $patterns [0] = $pattern;
    }
    $i = 0;
    $dir = array();
    if (is_dir($path)) {
        $path = rtrim($path, '/') . '/';
    }
    foreach ($patterns as $pattern) {
        $list = glob($path . $pattern);
        if ($list !== false) {
            foreach ($list as $file) {
                $dir [$i] ['filename'] = basename($file);
                $dir [$i] ['path'] = dirname($file);
                $dir [$i] ['pathname'] = realpath($file);
                $dir [$i] ['owner'] = fileowner($file);
                $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                $dir [$i] ['atime'] = fileatime($file);
                $dir [$i] ['ctime'] = filectime($file);
                $dir [$i] ['mtime'] = filemtime($file);
                $dir [$i] ['size'] = filesize($file);
                $dir [$i] ['type'] = filetype($file);
                $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                $dir [$i] ['isDir'] = is_dir($file);
                $dir [$i] ['isFile'] = is_file($file);
                $dir [$i] ['isLink'] = is_link($file);
                $dir [$i] ['isReadable'] = is_readable($file);
                $dir [$i] ['isWritable'] = is_writable($file);
                $i++;
            }
        }
    }
    $cmp_func = create_function('$a,$b', '
        if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
            return  $a["filename"]>$b["filename"]?1:-1;
        }else{
            if($a["isDir"]){
                return -1;
            }else if($b["isDir"]){
                return 1;
            }
            if($a["filename"]  ==  $b["filename"])  return  0;
            return  $a["filename"]>$b["filename"]?-1:1;
        }
        ');
    usort($dir, $cmp_func);
    return $dir;
}
