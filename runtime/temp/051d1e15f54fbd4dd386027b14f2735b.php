<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:50:"D:\phpStudy\WWW\gf/application/ph/view/layout.html";i:1510905907;s:43:"application/ph/view/notice/notice_info.html";i:1503709503;s:42:"application/ph/view/index/second_menu.html";i:1501656823;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>武房网公房管理系统</title>
   
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
  
<!--[if (gte IE 9)|!(IE)]><!-->

<script src="/public/static/gf/js/jquery.min.js"></script>
<script src="/public/static/gf/layer/layer.js"></script>

<!--<![endif]-->
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header am-print-hide">
  <div class="am-topbar-brand">
    <strong>武房网公房管理系统</strong>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
<!--       <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li> -->
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> <?php echo session('user_base_info.name').'('.session('user_base_info.institution_name').')'; ?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
          <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
          <li><a href="/user/Publics/signout/uid/<?php echo  $userBaseInfo['uid']; ?>"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:void(0);" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<div class="am-cf admin-main am-print-hide">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list" style="width: 100%;">
        

        <?php foreach($left_menu as $k => $v){
        if($v['level'] == 0){;
        ?>

        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav<?php echo $k+1; ?>'}"><span><img src="<?php echo  $v['Icons']; ?>" /></span><?php echo $v['Title']; ?><span class="am-icon-angle-right am-fr am-margin-right"></span></a>
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

            <li><a href="<?php echo '/'.$v1['UrlValue'];?>" class="am-cf <?php echo $light; ?>"><span class="<?php echo $right; ?>"></span> <?php echo $v1['Title']; ?><!-- <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span> --></a></li>

            <?php }}; ?>

          </ul>
        </li>

        <?php }}; ?>

        
        <!--<li><a href="/ph/index/index"><span class="am-icon-home"></span>我的工作</a></li>-->
        <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav1'}"><span class="am-icon-file"></span>房屋档案<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav1">-->
            <!--<li><a href="/ph/BanInfo/ban_info" class="am-cf"><span class="am-icon-check"></span>楼栋信息<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>房屋信息</a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>租户信息<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
            <!--<li><a href="admin-log.html"><span class="am-icon-calendar"></span>地图查询</a></li>-->
          <!--</ul>-->
        <!--</li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav2'}"><span class="am-icon-file"></span>使用权变更<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav2">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>使用权变更申请<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>使用权变更审批</a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>使用权变更记录<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav3'}"><span class="am-icon-file"></span>异动管理<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav3">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>异动申请<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>异动审批</a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>异动记录<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav4'}"><span class="am-icon-file"></span>租金管理<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav4">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>租金应缴<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>租金已缴</a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>预收管理<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>租金核减管理<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>欠缴管理<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>缴费通知<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>收缴助手<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav5'}"><span class="am-icon-file"></span>维修管理<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav5">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>维修申报<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>维修计划</a></li>-->
            <!--<li><a href="admin-gallery.html"><span class="am-icon-th"></span>维修情况<span class="am-badge am-badge-secondary am-margin-right am-fr">24</span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
        <!--<li><a href="admin-table.html"><span class="am-icon-table"></span>经营管理</a></li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav6'}"><span class="am-icon-file"></span>统计查询<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav6">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>公房情况统计<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>公房产权综合情况统计</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>房屋统计管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>租金收入月报表</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>租金统计</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>房屋维修统计</a></li>-->
          <!--</ul>-->
        <!--</li>-->
    <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav7'}"><span class="am-icon-file"></span>系统管理<span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav7">-->
            <!--<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span>用户管理<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>机构管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>职位管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>角色管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>安全管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>数据管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>设备管理</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>基数设置</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>参数设置</a></li>-->
            <!--<li><a href="admin-help.html"><span class="am-icon-puzzle-piece"></span>流程配置</a></li>-->
          <!--</ul>-->
        <!--</li>-->
        <!--<li><a href="admin-form.html"><span class="am-icon-pencil-square-o"></span>表单</a></li>-->
        <!--<li><a href="#"><span class="am-icon-sign-out"></span>注销</a></li>-->
      </ul>
  <!--
      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p>时光静好，与君语；细水流年，与君同。—— Amaze UI</p>
        </div>
      </div>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div>
    -->
    </div>
  </div>
  <!-- sidebar end -->

  <!-- content start -->
  
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">我的工作</strong></div>
    </div>
    <p class="am-padding" style="margin:0;padding-top:0;padding-bottom:18px;color:#666;font-size:16px;">快捷入口</p>
    <ul id="show_short_cut_menu" class="am-avg-sm-1 am-avg-md-5 am-margin am-padding am-text-center admin-content-list ">
      <?php
      if(isset($short_cut_menus_list)){
        foreach($short_cut_menus_list as $info){
          echo '<li><a class="short-cut-hover" href="'. '/' . $info['url'] .'" style="color:#333;"><span><img class="now-short-cut-list" src="'. $info['icon'] .'"/></span><br/>'. $info['title'] .'</a></li>';
        }
      }
      ?>
      <!-- <li><a href="#" style="color:#333;"><span class="am-icon-btn am-icon-file-text"></span><br/>待审批</a></li>
      <li><a href="#" style="color:#333;"><span class="am-icon-btn am-icon-briefcase"></span><br/>已审批</a></li>
      <li><a href="#" style="color:#333;"><span class="am-icon-btn am-icon-recycle"></span><br/>告示</a></li>
      <li><a href="#" style="color:#333;"><span class="am-icon-btn am-icon-user-md"></span><br/>私信</a></li> -->
      <li><a id="add_short_cut_menu" href="javascript:void(0)" style="color:#333;"><span class="am-icon-btn am-icon-bars"></span><br/>添加</a></li>
    </ul>

    <div class="am-g">
      <div class="am-u-sm-12">
        <table class="am-table am-table-bd am-table-striped admin-content-table">
          <thead>
          <tr>
            <th>序号</th><th>待办类型</th><th>订单号</th><th>生成时间</th><th>操作</th>
          </tr>
          </thead>
          <tbody id="index_wait_processing_content">

          <?php
                    if(isset($wait_processing) && !empty($wait_processing)){
                      foreach($wait_processing['list'] as $wait_k => $wait_v){
                        echo '<tr><td width="20%">'. ++$wait_k .'</td><td width="20%">'.$wait_v['ChangeType'].'</td><td>'. $wait_v['ChangeOrderID'] .'</td><td>'. $wait_v['CreateTime'] .'</td><td><div class="am-dropdown" data-am-dropdown><a style="color:#108EE9;" class="waitProcessing" href="/ph/ChangeAudit/index">立即处理</a></div></td></tr>';
                    }
          }
          ?>

          </tbody>
        </table>

        <ul id="wait_processing" class="am-pagination admin-content-pagination">
          <?php
              if(isset($wait_processing) && !empty($wait_processing)){
                  echo $wait_processing['nav'];
              }
              ?>
        </ul>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-md-6">
        <div class="am-panel am-panel-default">
          <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">文件下载</div>
          <div class="am-panel-bd am-collapse am-in" id="collapse-panel-1">
              <table class="am-table am-table-bd am-table-striped admin-content-table">
                <thead><tr><th>文件名</th><th></th><th>创建时间</th></tr></thead>
                <tbody id="index_upload_file_list_content">
                    <?php
                    if(isset($upload_file_list)){
                      foreach($upload_file_list['list'] as $info){
                        echo '<tr><td width="50%">'. $info['Title'] .'</td><td><a class="index-file-download am-icon-download" href="downloadFile?file='. $info['Url'] .'"></a></td><td>'. $info['Time'] .'</td></tr>';
                      }
                    }
                    ?>
                </tbody>
              </table>
            <ul id="upload_file_pages" class="am-pagination admin-content-pagination">
              <?php
              if(isset($upload_file_list)){
                  echo $upload_file_list['nav'];
              }
              ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="am-u-md-6">
        <div class="am-panel am-panel-default">
          <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">公告<span class="am-icon-chevron-down am-fr" ></span></div>
          <div class="am-panel-bd am-collapse am-in" id="collapse-panel-3">

            <table class="am-table am-table-bd am-table-striped admin-content-table">
              <thead><tr><th>标题</th><th>更新时间</th></tr></thead>
              <tbody id="index_notice_list_content">
                  <?php 
                  if(isset($notice_list)){
                    foreach($notice_list['list'] as $info){
                      echo '<tr><td width="50%"><a class="notice_info" id="'. $info['id'] .'" href="javascript:void(0)">' . $info['Title'] . '</a></td><td>'. $info['UpdateTime'] .'</td></tr>';
                    }
                  }
                  ?>
              </tbody>
            </table>
            <ul id="index_notice_pages" class="am-pagination admin-content-pagination">
              
              <?php

              if(isset($notice_list)){
                echo $notice_list['nav'];
              }

              ?>

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content end -->

</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <hr>
  <p class="am-padding-left">© 2017 CTNM.</p>
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
    <a id="pagePrev">上一页</a>
    <input id="pageNum" type="number" style="display:inline-block;width:50px;" value="1" />
    <a id="pageNext">下一页</a>
  </div>
  </div>
  
</div>
<!-- 查询器HTML文件结束 -->
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
	<font color="blue">提示：只能挑选四个快捷方式</font>
	<table id="check_menu"></table><br/>
	<span id="most_count" style="color:red" hidden="hidden">最多只能选择四项！</span>
</div>



<script src="/public/static/gf/js/amazeui.min.js"></script>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
<script src="/public/static/gf/js/app.js"></script>

<script type="text/javascript" src="/public/static/gf/viewjs/index_notice_page.js"></script>

<script type="text/javascript" src="http://tajs.qq.com/stats?sId=62257953" charset="UTF-8"></script><!--腾讯统计-->
</body>
</html>
