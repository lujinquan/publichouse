<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:71:"/usr/share/nginx/publichouse/application/ph/view/rent_report/index.html";i:1528342025;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1532308676;s:41:"application/ph/view/form/rent_report.html";i:1531738055;s:46:"application/ph/view/form/rent_report_show.html";i:1528342025;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1532308676;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>月租金报表</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="/public/static/gf/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="/public/static/gf/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="" />
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css"/>
  <link rel="stylesheet" href="/public/static/gf/css/admin.css">
  <style>
    .am-topbar-nav>li>a:after{display:none;}
    body .ddd-class .layui-layer-title{background:#FFF;font-size:20px;}
    body .ddd-class .layui-layer-btn0{border-top:1px solid #E9E7E7}
    .div_input{text-align:center;}
    .div_input label{width:120px;display:inline-block;vertical-align:middle;text-align:right;font-size:20px;color:#999;font-weight:500;}
    .div_input input{height:35px;padding:5px;margin:10px 0;display:inline-block;vertical-align:middle;border:1px solid #ccc;border-radius:4px;}
    #offCanvas{margin-left: 44px;}

    #userName{color:#FFF;}
  </style>
  
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/public/static/gf/js/jquery.min.js"></script>
<script src="/public/static/gf/layer/layer.js"></script>

<!--<![endif]-->
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，系统暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header am-print-hide">
  <div class="am-topbar-brand">
    <strong>武房网公房管理系统</strong>
    <button class="am-btn am-btn-xs am-btn-secondary am-icon-bars" id="offCanvas" data-value="false"></button>
  </div>
  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
<!--       <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li> -->
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle name_style" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users" id="userName">
            <?php echo session('user_base_info.name').'('.session('user_base_info.institution_name').')'; ?>
          </span><span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <!-- <li><a href="#"><span class="am-icon-user"></span> 资料</a></li> -->
          <li><a href="#" id="modifyPassword"><span class="am-icon-cog"></span> 修改密码</a></li>
          <li><a href="/user/Publics/signout/uid/<?php echo  $userBaseInfo['uid']; ?>"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:void(0);" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list" id="collapase-nav-1" style="width: 100%;">
        
        <?php foreach($left_menu as $k => $v){
        if($v['level'] == 0){;
        ?>
        <li class="am-panel">
          <a class="am-cf d-parent" data-am-collapse="{parent: '#collapase-nav-1',target: '#collapse-nav<?php echo $k+1; ?>'}">
            <span><img src="<?php echo  $v['Icons']; ?>" /></span><?php echo $v['Title']; ?>
            <span class="am-icon-angle-right am-fr am-margin-right"></span>
          </a>
          <ul class="am-list am-collapse admin-sidebar-sub <?php if($v['id'] == $nowID){echo 'am-in';} ?> " id="collapse-nav<?php echo $k+1; ?>">
            <?php foreach($left_menu as $k1 => $v1){
            if($v1['level'] == 1 && $v1['pid'] == $v['id']){
              if($v1['UrlValue'] == $nowMvc){
                $light = 'light';
                $right = 'am-icon-check';
              }else{
                  $light ='';
                  $right = '';
              }
            ?>
            <li>
              <a href="<?php echo '/'.$v1['UrlValue'];?>" class="am-cf <?php echo $light; ?>">
                <span class="<?php echo $right; ?>"></span> <?php echo $v1['Title']; ?>
              </a>
            </li>
            <?php }}; ?>
          </ul>
        </li>
        <?php }}; ?>
        
      </ul>
    </div>
  </div>
  <!-- sidebar end -->
<!-- 版本version显示 -->
<div class="admin-content" style="display:none;"></div>
  <!-- content start -->
  
<style>.am-table {
    margin-bottom: 0;
}</style>
<div class="admin-content">
    <div class="am-cf am-padding am-print-hide">
        <div class="am-fl am-cf">
            <small class="am-text-sm">统计报表</small> >
            <small class="am-text-primary">月租金报表</small>
        </div>
    </div>
    <div class="am-g">
        <div class="am-u-md-12">
            <h2 style="text-align:center;">武汉市房地局经管月租金报表</h2>
        </div>
        <form action="<?php echo url('RentReport/index'); ?>" method="post" class="am-form am-print-hide am-u-md-12"
              style="margin-bottom:20px;">
            <div class="am-u-md-12">
                <div class="label_style">产别：</div>
                <div class="am-u-md-2">
                    <select name="OwnerType" id="OwnerType">
                        <option value="1" style="display:none">市属</option>
                        <?php foreach($owerLst as $k1 =>$v1){ $select =($ownerType == $k1)?'selected':''; ?>
                        <option value="<?php echo $k1; ?>" <?php echo $select; ?>><?php echo $v1; ?></option>
                        <?php }; ?>
                    </select>
                </div>

                <?php if(session('user_base_info.institution_level')!=3){; ?>
                <div class="label_style">机构：</div>
                <div class="am-u-md-2">
                    <select name="TubulationID" id="TubulationID">
                        <option value="<?php echo session('user_base_info.institution_id'); ?>"
                                style="display:none"><?php echo session('user_base_info.institution_name'); ?></option>
                        <?php if(session('user_base_info.institution_level')==1){
                                foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){
                                $select =($rentReportOption != array() && $rentReportOption['TubulationID'] == $v10['id'])?'selected':'';
                        ?>
                        <option value="<?php echo $v10['id']; ?>" <?php echo $select; ?>><?php echo $v10['Institution']; ?></option>
                        <?php }}}elseif(session('user_base_info.institution_level')==2){
                                foreach($instLst as $k12 => $v12){
                                $select =($rentReportOption != array() && $rentReportOption['TubulationID'] == $v12['id'])?'selected':'';
                        ?>
                        <option value="<?php echo $v12['id']; ?>" <?php echo $select; ?>><?php echo $v12['Institution']; ?></option>
                        <?php }} ; ?>
                    </select>
                </div>
                <?php }; ?>
                <div class="label_style">查询月份:</div>
                <div class="am-u-md-2">
                    <input type="text" name="month" class="am-u-md-8"
                           data-am-datepicker="{format: 'yyyy-mm', viewMode: 'years',minViewMode: 'months'}"
                           value="<?php echo $month; ?>" placeholder="日历组件" data-am-datepicker readonly/>
                </div>
<!--                 <button type="button" id="postData" class="am-btn am-btn-xs am-btn-secondary">
                    <span class="am-icon-check"></span> 提交
                </button> -->
                <button type="submit" class="am-btn am-btn-xs d-btn-1188F0 am-radius">
                    <span class="am-icon-search"></span> 查询
                </button>
                <a type="button" class="am-btn am-btn-xs d-btn-1188F0 am-radius" href="/ph/RentReport/index.html"><span class="am-icon-reply"></span> 重置</a>
                <button type="button" id="printForm" class="am-btn am-btn-xs d-btn-1188F0 am-radius"><span class="am-icon-print"></span> 打印
                </button>
                <a type="button" class="am-btn am-btn-xs d-btn-1188F0 am-radius" id="propertycache"><span
                        class="am-icon-file-o"></span>
                    缓存报表
                </a>
            </div>
        </form>
        <div style="padding:2% 3% 2% 1%;">
            <style>
    .td_input{
        width:50px;
        border:none;
        border-bottom:1px solid #ccc;
        outline:none;
    }
    #PropertyForm td{
        padding:0.5rem 0;
    }
</style>
<?php if($result){ ; ?>
<div style="display:inline-block;width:30%" class="DQueryType fontSize_12">产别：<?php if($ownerType < 10){echo $owerArr[$ownerType];}elseif($ownerType == 10){echo '市代托';}elseif($ownerType == 11){echo '全部';} ?></div>
<div style="display:inline-block;width:30%" class="DQueryType fontSize_12">填报单位：<?php echo $insArr[$institutionid]; ?></div>
<div style="display:inline-block;width:30%" class="time fontSize_12">填报时间：<?php echo $month; ?></div>

<form id="postDataForm">
<table class="am-table am-table-bordered am-table-centered" id="PropertyForm">
        <tbody>
            <tr>
                <th rowspan="2" colspan="3" class="am-text-middle">租金月报</th>
                <th rowspan="2" colspan="1" class="am-text-middle">合计</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(一)工商企事业用房</th>
                <th rowspan="1" colspan="3" class="am-text-middle once_hide">其中(一)</th>
                <th rowspan="1" colspan="3" class="am-text-middle once_hide">其中(二)</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(二)党政群机关用房</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(三)民用住宅用房</th>
            </tr>
            <tr>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
                <td rowspan="1" colspan="1" class="once_hide">本月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前年度</td>
                <td rowspan="1" colspan="1" class="once_hide">本月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前年度</td>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">上期结转</td>
                <?php if(isset($result[0])){ 
                    foreach($result[0] as $v0){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_1"><?php echo $v0; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="7" colspan="1"  class="am-text-middle">基数增减</td>
                <td rowspan="1" colspan="2">计</td>
                <?php if(isset($result[1])){ 
                    foreach($result[1] as $v1){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_2"><?php echo $v1; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">新发租</td>
                <?php if(isset($result[2])){ 
                    foreach($result[2] as $v2){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_3"><?php echo $v2; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">调整</td>
                <?php if(isset($result[3])){ 
                    foreach($result[3] as $v3){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_4"><?php echo $v3; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">注销</td>
                <?php if(isset($result[4])){ 
                    foreach($result[4] as $v4){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_5"><?php echo $v4; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">租差/泵费</td>
                <?php if(isset($result[5])){ 
                    foreach($result[5] as $v5){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_6"><?php echo $v5; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">公房出售</td>
                <?php if(isset($result[6])){ 
                    foreach($result[6] as $v6){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_7"><?php echo $v6; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            
            <tr>
                <td rowspan="1" colspan="2">管段调整</td>
                <?php if(isset($result[7])){ 
                    foreach($result[7] as $v7){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_8"><?php echo $v7; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">规定租金</td>
                <?php if(isset($result[8])){ 
                    foreach($result[8] as $v8){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_9"><?php echo $v8; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="8" colspan="1" class="am-text-middle">非基数增减</td>
                <td rowspan="1" colspan="2">计</td>
                <?php if(isset($result[9])){ 
                    foreach($result[9] as $v9){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_10"><?php echo $v9; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">减免</td>
                <?php if(isset($result[10])){ 
                    foreach($result[10] as $v10){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_11" style="color:red"><?php echo $v10; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?> 
            </tr>
            <tr>
                <td rowspan="1" colspan="2">空租</td>
                <?php if(isset($result[11])){ 
                    foreach($result[11] as $v11){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_12"><?php echo $v11; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">暂停计租</td>
                <?php if(isset($result[12])){ 
                    foreach($result[12] as $v12){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_13" style="color:red"><?php echo $v12; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">文化室</td>
                <?php if(isset($result[13])){ 
                    foreach($result[13] as $v13){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_14"><?php echo $v13; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">政策折减</td>
                <?php if(isset($result[14])){ 
                    foreach($result[14] as $v14){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_15"><?php echo $v14; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">陈欠核销</td>
                <?php if(isset($result[15])){ 
                    foreach($result[15] as $v15){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_16"><?php echo $v15; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">累计补差</td>
                <?php if(isset($result[16])){ 
                    foreach($result[16] as $v16){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_17"><?php echo $v16; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">应收租金</td>
                <?php if(isset($result[17])){ 
                    foreach($result[17] as $v17){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_18"><?php echo $v17; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">实收租金</td>
                <?php if(isset($result[18])){ 
                    foreach($result[18] as $v18){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_19"><?php echo $v18; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">实收累计</td>
                <?php if(isset($result[19])){ 
                    foreach($result[19] as $v19){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_20"><?php echo $v19; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">结欠租金</td>
                <?php if(isset($result[20])){ 
                    foreach($result[20] as $v20){
                ;?>
                <td rowspan="1" colspan="1" class="some_hide_21"><?php echo $v20; ?></td>
                <?php }}else{; ?>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <?php }; ?>
            </tr>
        </tbody>
</table>

</form>
<div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%">说明：</div>
    <div style="display:inline-block;width:25%">上项空栏：按使用性质填报的应填写：</div>
    <div style="display:inline-block;width:20%">（一）企事业用房租金收入，</div>
    <div style="display:inline-block;width:20%">（二）党政群机关用房租金收入，</div>
    <div style="display:inline-block;width:20%">（三）民用住宅租金收入，</div>
</div>
<div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%">补充资料：</div>
    <div style="display:inline-block;width:25%">本月份实有户数：企事业
        <span style="display:inline-block;width:20%;padding:20px;"><?php echo isset($result[100][2])?intval($result[100][3]):0; ?></span>户，
    </div>
    <div style="display:inline-block;width:20%">机关
        <span style="display:inline-block;width:20%;padding:20px;"><?php echo isset($result[100][2])?intval($result[100][2]):0; ?></span>户，
    </div>
    <div style="display:inline-block;width:20%">民用
        <span style="display:inline-block;width:20%;padding:20px;"><?php echo isset($result[100][2])?intval($result[100][1]):0; ?></span>户，
    </div>
</div>
<div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%"></div>
    <div style="display:inline-block;width:25%">单位负责人：<span id="below_com">区房产公司</span></div>
    <div style="display:inline-block;width:20%">制表人：<?php echo session('user_base_info.name'); ?></div>
    <div style="display:inline-block;width:20%">报出日期：<span class="time"><?php echo date('Y-m-d',time()); ?></span></div>
</div>
<?php }; ?>
            <style>
    .td_input{
        width:50px;
        border:none;
        border-bottom:1px solid #ccc;
        outline:none;
    }
</style>
<form id="dataShow" style="display:none;">
<table class="am-table am-table-bordered am-table-centered" >
        <tbody>
            <tr>
                <th rowspan="2" colspan="2" class="am-text-middle">租金月报</th>
                <th rowspan="2" colspan="1" class="am-text-middle">合计</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(一)工商企事业用房</th>
                <th rowspan="1" colspan="3" class="am-text-middle once_hide">其中(一)</th>
                <th rowspan="1" colspan="3" class="am-text-middle once_hide">其中(二)</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(二)党政群机关用房</th>
                <th rowspan="1" colspan="3" class="am-text-middle">(三)民用住宅用房</th>
            </tr>
            <tr>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
                <td rowspan="1" colspan="1" class="once_hide">本月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前年度</td>
                <td rowspan="1" colspan="1" class="once_hide">本月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前月份</td>
                <td rowspan="1" colspan="1" class="once_hide">以前年度</td>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
                <td rowspan="1" colspan="1">本月份</td>
                <td rowspan="1" colspan="1">以前月份</td>
                <td rowspan="1" colspan="1">以前年度</td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">上期结转</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="7" colspan="1"  class="am-text-middle">基数增减</td>
                <td rowspan="1" colspan="2">计</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">新发租</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">调整</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">注销</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">租差</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">公房出售</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">管段调整</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">规定租金</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="8" colspan="1"  class="am-text-middle">非基数增减</td>
                <td rowspan="1" colspan="2">计</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">减免</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">空租</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">暂停计租</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">文化室</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">政策折减</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2">陈欠核销</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="2"></td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">应收租金</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">实收租金</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">实收累计</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3">结欠租金</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1">0</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1" class="once_hide">42</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide">7836</td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1" class="once_hide"></td>
                <td rowspan="1" colspan="1">78</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1">45</td>
                <td rowspan="1" colspan="1"></td>
                <td rowspan="1" colspan="1"></td>
            </tr>
        </tbody>
</table>
</form>
<!-- <div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%">说明：</div>
    <div style="display:inline-block;width:25%">上项空栏：按使用性质填报的应填写：</div>
    <div style="display:inline-block;width:20%">（一）企事业用房租金收入，</div>
    <div style="display:inline-block;width:20%">（二）党政群机关用房租金收入，</div>
    <div style="display:inline-block;width:20%">（三）民用住宅租金收入，</div>
</div>
<div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%">补充资料：</div>
    <div style="display:inline-block;width:25%">本月份实有户数：企事业
        <span style="display:inline-block;width:20%"></span>户，
    </div>
    <div style="display:inline-block;width:15%">机关
        <span style="display:inline-block;width:40%"></span>户，
    </div>
    <div style="display:inline-block;width:15%">民用
        <span style="display:inline-block;width:40%"></span>户，
    </div>
</div>
<div style="display:inline-block;width:100%" class="fontSize_12">
    <div style="display:inline-block;width:8%"></div>
    <div style="display:inline-block;width:30%">单位负责人：<span id="below_com">区房产公司</span></div>
    <div style="display:inline-block;width:30%">制表人：</div>
    <div style="display:inline-block;width:30%">报出日期：<span class="time"></span></div>
</div> -->
        </div>
    </div>
</div>


</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <p id="version_show" style="text-align:center;margin:0;padding:1rem 0;background:#EDEDED;color:#999;cursor:pointer;">© 2017 CTNM 楚天新媒技术支持 <span style="color:#1188F0;">V1.4</span></p>
</footer>

<!-- 查询器HTML文件 -->
<div id="dataQuery" class="am-form" style="display:none;">
  <div class="am-u-md-12">
    <label>查询器</label>
  </div>
  <div class="am-u-md-12" style="padding:0">
      <div class="am-u-md-3" style="border:1px solid #ccc; width: 20%;">
    <p>请输入筛选条件</p>
    <div class="am-form-group">
      <label id="addSelect" for="doc-ipt-pwd-1">所属机构：</label>
    </div>
   <div class="am-form-group">
      <label for="doc-ipt-pwd-1">房屋地址：</label>
      <input type="text" class="" id="queryTwo" placeholder="">
    </div>
    <div class="am-form-group">
      <label for="doc-ipt-pwd-1">租户姓名：</label>
      <input type="text" class="" id="queryThr" placeholder="">
    </div>
    <button id="queryClick" class="am-btn am-btn-primary">查询</button>
  </div>
  <div class="am-u-md-9" style="border:1px solid #ccc; width: 80%">
    <table class="am-table-bordered am-table-centered" style="width: 100%">
      <thead>
          <th>楼栋编号</th>
          <th>房屋编号</th>
          <th style="width:60px;">单元号</th>
          <th style="width:60px;">楼层号</th>
          <th style="width:80px;">租户姓名</th>
          <th>房屋地址</th>
      </thead>
    </table>
    <a id="pagePrev" style="cursor:pointer;">上一页</a>
    <input id="pageNum" type="number" style="display:inline-block;width:50px;" value="1" />
    <a id="pageNext" style="cursor:pointer;">下一页</a>
  </div>
  </div>
</div>
<!-- 查询器HTML文件结束 -->
<!-- 租户查询器HTML文件 -->
<div id="tenantQuery" class="am-form" style="display:none;">
  <div class="am-u-md-12" style="padding:0">
    <div class="am-u-md-12 tenant_query_condition">
      <div class="am-form-group">
        <label id="tenantAddSelect">所属机构：</label>
      </div>
      <div class="am-form-group">
        <label>租户姓名：</label>
        <input type="text" id="tenantTwo">
      </div>
      <div class="am-form-group">
        <label>联系电话：</label>
        <input type="text" id="tenantThr">
      </div>
      <button id="tenantQueryClick" class="am-btn am-btn-primary am-btn-sm">查询</button>
    </div>
  <div class="am-u-md-12">
    <table class="am-table am-table-centered am-table-compact" style="width: 100%;border:1px solid #D6E2F6;">
      <thead>
          <th>租户ID</th>
          <th>租户姓名</th>
          <th style="width:100px;">联系电话</th>
          <th style="width:260px;">身份证</th>
          <th style="width:280px;">银行卡号</th>
          <th>银行机构</th>
      </thead>
    </table>
    <a id="tenantPagePrev" style="cursor:pointer;">上一页</a>
    <input id="tenantPageNum" type="number" style="display:inline-block;width:50px;" value="1" />
    <a id="tenantPageNext" style="cursor:pointer;">下一页</a>
    <a id="tenantPageGo" style="cursor:pointer;">跳转</a>
    <span>共</span><span id="tenantTotalPage"></span><span>页</span>
  </div>
  </div>
</div>
<!-- 租户查询器HTML文件结束 -->
<!-- 楼栋查询器HTML文件 -->
<div id="banQuery" class="am-form" style="display:none;">
  <div class="am-u-md-12" style="padding:0">
    <div class="am-u-md-12 ban_query_condition">
      <div class="am-form-group">
        <label id="banAddSelect">所属机构：</label>
      </div>
     <div class="am-form-group">
        <label>楼栋地址：</label>
        <input type="text" id="banTwo">
      </div>
      <button id="banQueryClick" class="am-btn am-btn-primary am-btn-sm">查询</button>
  </div>
  <div class="am-u-md-12">
    <table class="am-table am-table-centered am-table-compact" style="width: 100%;border:1px solid #D6E2F6;">
      <thead>
          <th>楼栋编号</th>
          <th>完损等级</th>
          <th>结构类别</th>
          <th>使用性质</th>
          <th>产别</th>
          <th>楼栋地址</th>
      </thead>
    </table>
    <a id="banPagePrev" style="cursor:pointer;">上一页</a>
    <input id="banPageNum" type="number" style="display:inline-block;width:50px;" value="1" />
    <a id="banPageNext" style="cursor:pointer;">下一页</a>
    <a id="banPageGo" style="cursor:pointer;">跳转</a>
    <span>共</span><span id="banTotalPage"></span><span>页</span>
  </div>
  </div>
</div>
<!-- 楼栋查询器HTML文件结束 -->
<!-- 房屋查询器HTML文件 -->
<div id="houseQuery" class="am-form" style="display:none;">
  <div class="am-u-md-12" style="padding:0">
    <div class="am-u-md-12 house_query_condition">
      <div class="am-form-group">
        <label id="houseAddSelect">所属机构：</label>
      </div>
      <div class="am-form-group">
        <label>租户姓名：</label>
        <input type="text" id="houseTwo" placeholder="">
      </div>
      <div class="am-form-group">
        <label>楼栋地址：</label>
        <input type="text" id="houseThr" placeholder="">
      </div>
      <button id="houseQueryClick" class="am-btn am-btn-primary am-btn-sm">查询</button>
    </div>
    <div class="am-u-md-12">
      <table class="am-table am-table-centered am-table-compact" style="width: 100%;border:1px solid #D6E2F6;">
        <thead>
            <th>楼栋编号</th>
            <th>房屋编号</th>
            <th>单元号</th>
            <th>楼层号</th>
            <th>租户姓名</th>
            <th>月租金</th>
            <th>楼栋地址</th>
        </thead>
      </table>
      <a id="housePagePrev" style="cursor:pointer;">上一页</a>
      <input id="housePageNum" type="number" style="display:inline-block;width:50px;" value="1" />
      <a id="housePageNext" style="cursor:pointer;">下一页</a>
      <a id="housePageGo" style="cursor:pointer;">跳转</a>
      <span>共</span><span id="houseTotalPage"></span><span>页</span>
    </div>
  </div>
</div>
<!-- 房屋查询器HTML文件结束 -->
<!-- 查询器HTML文件结束 -->

<!-- 修改密码 -->
<div id="changePassword" style="display:none;padding-top:60px;">
  <div class="div_input"><label>旧密码：</label><input id="oldPassword" style="width:270px" type="password" placeholder="请输入旧密码" /></div>
  <div class="div_input"><label>新密码：</label><input id="newPassword" style="width:270px" type="password" placeholder="长度为6~18位只能包含字母和数字" /></div>
  <div class="div_input"><label>确认密码：</label><input id="repeatPassword" style="width:270px" type="password" placeholder="请再次输入新密码" /></div>
</div>

<!-- 顶部浮动标题 -->
<div id="fixed_head"></div>
<!-- 顶部浮动标题结束 -->
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/public/static/gf/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<div id="notice_info_dialog" hidden="hidden">
	<div>
	    <span id="title_info"></span><br/>
	    <span id="name_info"></span><font style="font-size: 14px">发表于</font>
	    <span id="update_time_info"></span><br/><hr/>
	    <span id="content_info"></span>
	</div>
</div>
<div id="second_menu_list" style="margin: 20px;font-size: 15pt" hidden="hidden">
	<font color="blue">提示：请选择一个快捷方式</font>
	<table id="check_menu"></table><br/>
	<span id="most_count" style="color:red" hidden="hidden">最多只能选择四项！</span>
</div>
<style>
	#version{
		width:100%;
		padding:20px 0 20px 40px;
		background:#FFF;
		z-index:1117;
		display:none;
	}
	.version_time{
		width:120px;
		display:inline-block;
		vertical-align:top;
	}
	.version_time h3{
		color:#666;
		font-size:18px;
		font-weight:500;
	}
	.version_content{
		margin-left:-10px;
		padding-left:30px;
		border-left:2px dotted #ccc;
		display:inline-block;
		vertical-align:top;
	}
	.version_content h3{
		font-size:18px;
		color:#1188F0;
		font-weight:500;
	}
	.version_time p,.version_content p{
		margin:8px auto;
		font-size:14px;
		color:#666;
	}
	.dot{
		width:10px;
		height:10px;
		position: relative;
    	bottom: -10px;
		background:#1188F0;
		border-radius:50%;
		display:inline-block;
		vertical-align:top;
	}
	p.fun_title{
		font-weight:700;
		font-size:15px;
	}
</style>
<div id="version">
	<div class="title">
		<div class="version_time">
			<h3 style="font-size:24px;">更新时间</h3>
		</div>
		<div class="version_content" style="margin-left:4px;">
			<h3 style="font-size:24px;">武房公房系统版本更新日志</h3>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-07-16</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.4更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1. 注销异动上线</p>
			<p>2. 租金追加上线</p>
			<p class="fun_title">优化</p>
			<p>1.过户申请弹框改名为使用权变更申请</p>
			<p>2.扩大图片上传的内存</p>
			<p>3.修复一些弹框弹不出的问题</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-07-09</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.3更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.租金管理新增月份收欠版块</p>
			<p>2.月租金报表中泵费上基数</p>
			<p>3.租金管理版块上线</p>
			<p class="fun_title">优化</p>
			<p>1.租金应缴中添加按上期欠缴和租金全部已缴按钮，提供做报表的方便</p>
			<p>2.租金计算中添加泵费和租差字段，查询有泵费和租差的房屋</p>
			<p>3.预收管理添加删除按钮</p>
			<p>4.月份收欠记录以前月回收欠款的记录</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-07-02</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.2更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.使用权变更上线</p>
			<p>2.修改密码上线</p>
			<p class="fun_title">优化</p>
			<p>1.优化系统的主页界面</p>
			<p>2.优化系统左侧导航条展开方式</p>
			<p>3.头部添加隐藏导航条按钮，使数据展示完全</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-05-28</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.1更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.月租金报表1-6月份的数据</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-05-07</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.0更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.房屋统计报表、产权报表、月租金报表12月份的数据</p>
		</div>
	</div>
</div>
<script>
$('#version_show').click(function(){
	$('.admin-content:eq(0)').prepend($('#version').show()).show();
	$('.admin-content:eq(1)').hide();
	$('.admin-sidebar').height($('.admin-content:eq(0)').height());
})
</script>
<script src="/public/static/gf/js/amazeui.min.js"></script>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
<script src="/public/static/gf/js/app.js"></script>
<script type="text/javascript">
  var body_height = $(document.body).height();
  var window_height = $(window).height();
  if(body_height < window_height){
    $("footer").css({'width':'100%','position':'fixed','bottom':'0'});
  }
  $('.admin-sidebar').height($('.admin-content:eq(1)').height());

  // $('.d-parent').click(function(){
  //   setTimeout(function(){
  //     body_height = $(document.body).height();
  //     window_height = $(window).height();
  //     if(body_height > window_height){
  //       $("footer").css({'width':'100%','position':'relative','bottom':'0'});
  //     }else{
  //       $("footer").css({'width':'100%','position':'fixed','bottom':'0'});
  //     }
  //   },300);
  // });

// thead 上滑顶部固定
var thead_height = $('thead').offset().top;
var head_title_length = $('.table-main thead th').length;
var ul_dom =$("<ul class='title_ul'></ul>");
ul_dom.width($('.check001,.thead_width').width());
for(var i = 0;i < head_title_length;i++){
  if($(document).width()>992 && $(document).width() <= 1200
   && $('.table-main thead th').eq(i).hasClass('dong_none')){
    
  }else{
    var li_dom = $('<li></li>');
    li_dom.append($('.table-main thead th').eq(i).text());
    li_dom.width($('.table-main tbody tr:eq(1) td:eq('+i+')').width());
    ul_dom.append(li_dom);
  }
}
ul_dom.css({'position':'fixed','top':'0','z-index':'10','background':'#1188F0','color':'#FFF','display':'none','margin-left':'6px'});
$('.am-scrollable-horizontal').prepend(ul_dom);
$(document).scroll(function(){
  var body_scrollTop = $(document).scrollTop();
  if(body_scrollTop - thead_height > 0){
    $('.am-scrollable-horizontal ul').eq(0).css({'display':'block'});
   }else{
      $('.am-scrollable-horizontal ul').eq(0).css({'display':'none'});
  }
})
$('.am-scrollable-horizontal').scroll(function(){
  var scroll_left = $('.am-table').offset().left;
  $('.title_ul').css('left',scroll_left);
})
// 鼠标滑动,table左右滑动开始；
// var mouse_flag = false;
// var mouse_start_x = null;
// var mouse_end_x = null;
// $('.am-table').mousedown(function(event){
//   mouse_flag = true;
//   mouse_start_x = event.clientX
//   $(this).mousemove(function(event){
//     var distance =$('.am-scrollable-horizontal').scrollLeft() + (event.clientX - mouse_start_x)/20;
//     $('.am-scrollable-horizontal').scrollLeft(distance);
//   })
// })
// $('.am-table').mouseup(function(event){
//   mouse_flag = false;
//   mouse_end_x = event.clientX;
//   $(this).off("mousemove");
//   $('.am-scrollable-horizontal').off("scrollLeft");
// })
// 鼠标滑动,table左右滑动结束；

  $('#repeatPassword').blur(function(){
    var password_one = $('#newPassword').val();
    var password_two = $('#repeatPassword').val();
    if(password_one != password_two){
      layer.msg('确认密码和新密码不相同');
    }
  });
  $('#modifyPassword').click(function(){
    layer.open({
      type:1,
      skin: 'ddd-class',
      area:['600px','400px'],
      title:'修改密码',
      content:$('#changePassword'),
      btn:['确认','取消'],
      yes:function(thisIndex){
        var postData = {
          oldPassword:$('#oldPassword').val(),
          newPassword:$('#newPassword').val(),
          repeatPassword:$('#repeatPassword').val()
        };
        $.post('/ph/Api/edit_password',postData,function(res){
          res = JSON.parse(res);
          console.log(res);
          if(res.retcode == '2000'){
            layer.closeAll();
          }
          layer.msg(res.msg);
        })
      }
    })
  });

  window.onpopstate = function(e){
    console.log(e.state);
  }
  // header头部点击显示或隐藏 开始
  $('#offCanvas').click(function(){
    var data_value = $(this).attr('data-value');
    console.log(data_value);
    if(data_value == 'false'){
      $('.admin-sidebar').hide();
      $(this).attr('data-value','true');
    }else{
      $('.admin-sidebar').show();
      $(this).attr('data-value','false');
    }
  })
  // header头部点击显示或隐藏 结束
 
// admin-sidebar-sub左边列表栏样式选择开始
  var sidebar = $('.admin-sidebar-sub li a.light')
  sidebar.parents('.admin-sidebar-sub').siblings('a').css('color','#333');
// admin-sidebar-sub左边列表栏样式选择结束
</script>

<script type="text/javascript">
    $('#printForm').click(function () {
        window.print();
    });
    $('#propertycache').click(function () {
        $.ajax({
            url: "/ph/SystemLog/RentReportCache", success: function (result) {
                var results = jQuery.parseJSON(result);
                layer.msg(results.msg);
            }
        });
    });

    var flag = false;
    if (flag == false) {
        $('#postDataForm').show();
        $('#dataShow').hide();
    } else {
        $('#postDataForm').hide();
        $('#dataShow').show();
    }
    //月租金报表自管产、代管、托管的报表样式，没有其中一其中二
    var owner_type = $('#OwnerType').val();
    console.log(owner_type);
    if (owner_type == 3 || owner_type == 5 || owner_type == 7) {
        $('.once_hide').hide();
        for(var i = 4;i <= 9;i++){
            $('.some_hide').eq(i).hide();
            $('.some_hide_1').eq(i).hide();
            $('.some_hide_2').eq(i).hide();
            $('.some_hide_3').eq(i).hide();
            $('.some_hide_4').eq(i).hide();
            $('.some_hide_5').eq(i).hide();
            $('.some_hide_6').eq(i).hide();
            $('.some_hide_7').eq(i).hide();
            $('.some_hide_8').eq(i).hide();
            $('.some_hide_9').eq(i).hide();
            $('.some_hide_10').eq(i).hide();
            $('.some_hide_11').eq(i).hide();
            $('.some_hide_12').eq(i).hide();
            $('.some_hide_13').eq(i).hide();
            $('.some_hide_14').eq(i).hide();
            $('.some_hide_15').eq(i).hide();
            $('.some_hide_16').eq(i).hide();
            $('.some_hide_17').eq(i).hide();
            $('.some_hide_18').eq(i).hide();
            $('.some_hide_19').eq(i).hide();
            $('.some_hide_20').eq(i).hide();
            $('.some_hide_21').eq(i).hide();
        }
    }
</script>

</body>
</html>