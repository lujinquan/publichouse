<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:58:"D:\phpStudy\WWW\gf/application/ph\view\ban_info\index.html";i:1512118957;s:50:"D:\phpStudy\WWW\gf/application/ph\view\layout.html";i:1510905907;s:38:"application/ph/view/ban_info/form.html";i:1510905907;s:40:"application/ph/view/ban_info/modify.html";i:1510885652;s:40:"application/ph/view/ban_info/detail.html";i:1512198636;s:47:"application/ph/view/ban_info/ban_structure.html";i:1512477037;s:43:"application/ph/view/notice/notice_info.html";i:1503709503;s:42:"application/ph/view/index/second_menu.html";i:1501656823;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>楼栋信息</title>
   
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
  
  <!-- content start -->
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">房屋档案</strong> / <small>楼栋信息</small></div>
    </div>

      <div class="am-g">
          <div class="am-u-sm-12 am-u-md-6">
              <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                      <?php if(in_array(45,$threeMenu)){ ; ?>
                      <button type="button" id="addBan" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增楼栋</button>
                      <?php }; if(in_array(46,$threeMenu)){ ; ?>
                      <button type="button" id="reviseBan" class="am-btn am-btn-default"><span class="am-icon-edit"></span> 修改楼栋</button>
                      <?php }; if(in_array(507,$threeMenu)){ ; ?>
                       <button type="button" id="deleteBan" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除楼栋</button>
                      <?php }; ?>
                  </div>
              </div>
          </div>
      </div>

    <div class="am-g">
      <div class="am-scrollable-horizontal">
          <table class="am-table am-table-striped am-table-hover table-main am-table-centered">
            <thead>
              <tr>
                <th class="table-check"></th>
        				<th class="table-id">#</th>
        				<th class="table-title">楼栋编号</th>
        				<th class="table-type">机构名称</th>
        				<th class="table-author am-hide-sm-only">产别</th>
        				<th class="table-date am-hide-sm-only">楼栋地址</th>
        				<th class="table-set">产权证号</th>
        				<th class="table-set">建成年份</th>
        				<th class="table-set">完损等级</th>
        				<th class="table-set">结构类别</th>
        				<th class="table-set">使用性质</th>
        				<th class="table-set">规定租金</th>
        				<th class="table-set" style="width:220px;">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
      <form action="<?php echo url('BanInfo/index'); ?>" method="post" id="queryForm"  >
		    <tr class="am-form-group am-form-inline am-form">
              <td></td>
              <td></td>
              <td>
                <div class="am-input-group am-input-group-sm">
                    <?php
                        if($banOption != array()){
                            $BanID = $banOption['BanID'];
                        }else{
                            $BanID = '';
                        }
                     ?>
                  <input name="BanID" type="text" class="am-form-field" value="<?php echo $BanID; ?>">
                </div>
          	  </td>
              <td>
                <div class="am-form-group search_input">
                    <?php if(session('user_base_info.institution_level')!=3){ ;?>
                    <select name="TubulationID" id="doc-select-2">
                        <option  value="" style="display:none">请选择</option>
                        <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){;                                 if($banOption != array()){
                                    if($banOption['TubulationID'] == $v10['id']){
                                        $select ='selected';
                                    }else{
                                        $select ='';
                                    }
                                }else{
                                    $select ='';
                                }
                                ?>
                            <option value="<?php echo $v10['id']; ?>" <?php echo $select; ?>><?php echo $v10['Institution']; ?></option>
                        <?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ;                                 if($banOption != array()){
                                    if($banOption['TubulationID'] == $v12['id']){
                                        $select ='selected';
                                    }else{
                                        $select ='';
                                    }
                                }else{
                                    $select ='';
                                }
                                ?>
                        <option value="<?php echo $v12['id']; ?>" <?php echo $select; ?>><?php echo $v12['Institution']; ?></option>
                        <?php }}} ; ?>
                    </select>
                </div>
          		</td>
              <td>
                  <div class="am-form-group search_input">
                      <select name="OwnerType" id="doc-select-5">
                          <option  value="" style="display:none">请选择</option>
                          <?php foreach($owerLst as $k3 =>$v3){;
                                if($banOption != array()){

                                    if($banOption['OwnerType'] == $v3['id']){

                                        $select ='selected';
                                    }else{

                                        $select ='';
                                    }
                                }else{

                                    $select ='';
                                }

                                ?>

                          <option value="<?php echo $v3['id']; ?>" <?php echo $select; ?>><?php echo $v3['OwnerType']; ?></option>
                          <?php }; ?>
                      </select>
                  </div>
          		</td>
              <td>
                <div class="am-input-group am-input-group-sm">
                    <?php
                        if($banOption != array()){
                            $BanAddress = $banOption['BanAddress'];
                        }else{
                            $BanAddress = '';
                        }
                     ?>
                  <input name="BanAddress" type="text" class="am-form-field" value="<?php echo $BanAddress; ?>">
                </div>
              </td>
              <td>
                <div class="am-input-group am-input-group-sm">
                    <?php
                        if($banOption != array()){
                            $BanPropertyID = $banOption['BanPropertyID'];
                        }else{
                            $BanPropertyID = '';
                        }
                     ?>
                  <input name="BanPropertyID" type="text" class="am-form-field" value="<?php echo $BanPropertyID; ?>">
                </div>
              </td>
              <td>
                <div class="am-input-group am-input-group-sm" style="width:150px;">
                    <?php
                         if($banOption != array()){
                            $DateStart = $banOption['DateStart'];
                            $DateEnd = $banOption['DateEnd'];
                        }else{
                            $DateStart = '';
                            $DateEnd = '';
                        }
                     ?>
                     <div class="am-u-sm-6" style="padding:0;">
                          <input style="width:70px;" name="DateStart" value="<?php echo $DateStart; ?>" type="text" class="am-form-field" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" >
                     </div>
                     <div class="am-u-sm-6" style="padding:0;">
                          <input style="width:70px;" name="DateEnd" value="<?php echo $DateEnd; ?>" type="text" class="am-form-field" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" >
                     </div>
                </div>
              </td>
              <td>
                  <div class="am-form-group search_input">
                      <select name="DamageGrade">
                          <option  value="" style="display:none">请选择</option>

                          <?php foreach($damaLst as $k2 =>$v2){;
                            if($banOption != array()){

                                if($banOption['DamageGrade'] == $v2['id']){

                                    $select ='selected';
                                }else{

                                    $select ='';
                                }
                            }else{

                                $select ='';
                            }

                            ?>

                          <option value="<?php echo $v2['id']; ?>" <?php echo $select; ?> ><?php echo $v2['DamageGrade']; ?></option>
                          <?php }; ?>
                      </select>
                  </div>
          		</td>
          			  <td>
                    <div class="am-form-group search_input">
                        <select name="StructureType" id="doc-select-8">
                            <option  value="" style="display:none">请选择</option>
                            <?php foreach($struLst as $k4 =>$v4){;                                if($banOption != array()){
                                    if($banOption['StructureType'] == $v4['id']){
                                        $select ='selected';
                                    }else{
                                        $select ='';
                                    }
                                }else{
                                    $select ='';
                                }
                                ?>
                            <option value="<?php echo $v4['id']; ?>" <?php echo $select; ?> ><?php echo $v4['StructureType']; ?></option>
                            <?php }; ?>
                        </select>
                    </div>
                  </td>
          			  <td>
                    <div class="am-form-group search_input">
                        <select name="UseNature" id="doc-select-7">
                            <option  value="" style="display:none">请选择</option>
                            <?php foreach($useNatureLst as $k5 =>$v5){ ;
                                if($banOption != array()){

                                    if($banOption['UseNature'] == $v5['id']){

                                        $select ='selected';
                                    }else{

                                        $select ='';
                                    }
                                }else{

                                    $select ='';
                                }

                                ?>

                            <option value="<?php echo $v5['id']; ?>" <?php echo $select; ?>><?php echo $v5['UseNature'];?></option>
                            <?php }; ?>
                        </select>
                    </div>
                  </td>
          			  <td><div style="width:50px;"></div></td>
              <td>
                <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-secondary" id="queryBtn"><span class="DqueryIcon" ></span>查询</button>
                  <a id="clearBanInfo" class="am-btn am-btn-xs am-text-secondary ABtn" href="/ph/BanInfo/index"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
          </form>
		<!---查询-->

          <?php foreach( $banLst as $k => $v){ ;?>
            <tr class="check001">
                <td >
                  <span class="piaochecked">
                    <input class="checkId radioclass" type="radio" name='choose' value="<?php echo $v['BanID']; ?>" />
                  </span>
                </td>
                <td><?php echo ++$k; ?></td>
                <td><?php echo $v['BanID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['TubulationID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['OwnerType']; ?></td>
                <td class="am-hide-sm-only">
                  <p style="height:18px;margin:10px 0 0;padding:0;line-height:18px;"><?php echo $v['BanAddress']; ?></p>
                </td>
                <td class="am-hide-sm-only"><?php echo $v['BanPropertyID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['BanYear']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['DamageGrade']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['StructureType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['UseNature']; ?></td>
                <td><?php echo $v['PreRent']; ?></td>
              <td>
                  <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                      <?php if(in_array(54,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-btn-xs am-text-secondary details details_btn" value="<?php echo $v['BanID']; ?>"> 明细</button>
                      <?php }; if(in_array(56,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-btn-xs am-text-secondary am-hide-sm-only structureBtn" value="<?php echo $v['BanID']; ?>">结构</button>
                      <?php }; if(in_array(61,$threeMenu)){ ; ?>
                      <a href="<?php echo url('HouseInfo/index',['BanID'=>$v['BanID'],'flag'=>'jump']); ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary am-hide-sm-only ABtn" > 房屋</a>
                      <?php }; ?>
                  </div>
              </td>
            </tr>
          <?php }; ?>

          </tbody>
        </table>
		<div class="am-cf">
		  共<?php echo $banLstObj->total(); ?>条记录
		  <div class="am-fr">
              <?php echo $banLstObj->render(); ?>
		  </div>
		</div>
          <hr />
      </div>
    </div>
  </div>
  <div id="deleteChoose" style="display:none; text-align: center; margin: 20px;">
      <button id="HouseChange" class="am-btn am-btn-secondary " value="2" name="banDeleteType" style="background: #0086ff;border:none">房改</button>
      <button id="HouseRemove" class="am-btn am-btn-secondary" value="3" name="banDeleteType" style="background: #0086ff;border:none">拆迁，已注销</button>
      <button id="DateTogther" class="am-btn am-btn-secondary" value="4"  name="banDeleteType"style="background: #0086ff;border:none">数据合并</button>
      <button id="DateLose" class="am-btn am-btn-secondary" value="5"  name="banDeleteType"style="background: #0086ff;border:none">数据作废</button>
  </div>
  <form  id="banForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset id="InputForm" style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-12">
			<div class="am-form-group am-u-md-12">
				<label>楼栋地址：</label>
				<div class="inline_70">
					<select ><option>武昌区</option></select>
				</div>
				<div class="inline_70">
					<select name="AreaTwo" id="AreaTwo" required>
						<option  value="" style="display:none">请选择</option>
<!-- 						<?php foreach($areaTwo as $k15 =>$v15){;?>
						<option value="<?php echo $v15['id']; ?>"><?php echo $v15['AreaTitle']; ?></option>
						<?php }; ?> -->
					</select>
				</div>
				<div class="inline_70">
					<select name="AreaThree" id="AreaThree" required>
						<option  value="" style="display:none">请选择</option>
<!-- 						<?php foreach($areaThree as $k16 =>$v16){;?>
						<option value="<?php echo $v16['id']; ?>"><?php echo $v16['AreaTitle']; ?></option>
						<?php }; ?> -->
					</select>
				</div>
				<input type="text" name="AreaFour" style="width:200px;display:inline-block;" />
			</div>
		</div>
		<div class="am-u-md-6">
<!-- 			<div class="am-form-group am-u-md-12">
			  <label  class="label_style">楼栋编号：</label>
			  <div class="am-u-md-8">
				<input type="number" name="BanID" id="DBanID" placeholder="楼栋编号" required/>
			  </div>
			</div> -->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label  class="label_style">楼栋编号：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<label id="DBanID"></label>-->
			  <!--</div>-->
			<!--</div>-->
			<?php if(session('user_base_info.institution_level')!=3){ ; ?>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-2" class="label_style">机构名称：</label>
			  <div class="am-u-md-8" style="float:left;">

				<select name="TubulationID" id="doc-select-2" required>
					<option  value="" style="display:none">请选择</option>

					<?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] == 1){; ?>
					  <optgroup label="<?php echo $v10['Institution'] ;?>">
						  <?php  foreach($instLst as $k11 => $v11){  if($v11['pid'] == $v10['id']){; ?>
						  		<option value="<?php echo $v11['id']; ?>" ><?php echo $v11['Institution']; ?></option>
						  <?php }}; ?>
					  </optgroup>

					<?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ; ?>

					<option value="<?php echo $v12['id']; ?>" ><?php echo $v12['Institution']; ?></option>

					<?php }} ; ?>


				</select>


			  </div>
			</div>
			<?php }; ?>

			<div class="am-form-group am-u-md-12">
				<label  class="label_style">产权证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanPropertyID" placeholder="产权证号" required/>
				</div>
			</div>


			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-4" class="label_style">完损等级：</label>
			  <div  class="am-u-md-8" style="float:left;">
				<select name="DamageGrade" id="doc-select-4" required>
					<option  value="" style="display:none">请选择</option>
					<?php foreach($damaLst as $k2 =>$v2){;?>
					<option value="<?php echo $v2['id']; ?>"><?php echo $v2['DamageGrade']; ?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>
			
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">是否改造产：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
				<!--<select name="StructureType" id="doc-select-8" >-->
						<!--<?php foreach($struLst as $k4 =>$v4){;?>-->
						<!--<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>-->
						<!--<?php }; ?>-->
				<!--</select>-->
			  <!--</div>-->
			<!--</div>-->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">土地证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanLandID" placeholder="土地证号" required/>
				</div>
			</div>			
			<div class="am-form-group am-u-md-12">
				<label  class="label_style">不动产证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFreeholdID"  placeholder="不动产证号" required/>
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">总户数：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalHouseholds"  placeholder="总户数" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">占地面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="CoveredArea" placeholder="占地面积" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">证载面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="ActualArea" placeholder="证载面积" required/>
				</div>
			</div>
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">栋建面：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="number" name="BanArea" placeholder="栋建面" required/>-->
				<!--</div>-->
			<!--</div>-->
		</div>
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">

			  <label for="doc-select-5" class="label_style">产别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="OwnerType" id="doc-select-5" required>
					<option  value="" style="display:none">请选择</option>
					<?php foreach($owerLst as $k3 =>$v3){;?>
					<option value="<?php echo $k3+1; ?>"><?php echo $v3['OwnerType']; ?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label  class="label_style">建成年份：</label>
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="选择年份" data-am-datepicker readonly/>-->
				<!--</div>-->
				<div class="am-u-md-8" data-am-validator>
					<input type="text" name="BanYear" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="建成年份" />
				</div>
				<!--<input type="text" class="am-u-md-8" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="日历组件" data-am-datepicker readonly/>-->

			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">使用性质：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="UseNature" id="doc-select-7" required class="">
					<option  value="" style="display:none">请选择</option>
					<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
					<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">结构类别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="StructureType" id="doc-select-8" required>
					<option  value="" style="display:none">请选择</option>
						<?php foreach($struLst as $k4 =>$v4){;?>
						<option value="<?php echo $v4['id']; ?>"><?php echo $v4['StructureType']; ?></option>
						<?php }; ?>
				</select>
			  </div>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUnitNum" placeholder="单元数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorNum" placeholder="总楼层数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">起始楼层：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorStart" placeholder="起始楼层数" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否历史优秀建筑：</label>
				<div class="am-u-md-6">
					<select name="HistoryIf" id="doc-select-5" required style="width:112%;">
						<!-- <option  value="" style="display:none">请选择</option> -->
						<option value="0">不是</option>
						<option value="1">省级</option>
						<option value="2">市级</option>
						<option value="3">区级</option>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">是否改造产： </label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ReformIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ReformIf" checked="checked" > 否
					</label>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否文物保护单位：</label>
			  <div class="am-u-md-6">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ProtectculturalIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ProtectculturalIf" checked="checked" > 否
					</label>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">产权是否分割：</label>
			  <div class="am-u-md-6"">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="CutIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="CutIf" checked="checked" > 否
					</label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfElevator" value="1" />
				<label>有电梯</label>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfFirst" value="1" />
				<label>居住第一层有架空层或木地板住房</label>
			</div>
		</div>

		<hr class="am-u-md-11"/>



		
		<div class="am-u-md-6">
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="" class="label_style">企业建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="EnterpriseArea" id="" minlength="1" placeholder="输入企业建面" required/>-->
			  <!--</div>-->
			<!--</div>-->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label  class="label_style">机关建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="PartyArea" placeholder="机关建面" required/>-->
			  <!--</div>-->
			<!--</div>-->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="" class="label_style">民用建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="CivilArea" id="" placeholder="民用建面" required/>-->
			  <!--</div>-->
			<!--</div>-->
			
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">使用面积：</label>
			  <div class="am-u-md-8">
				<input type="number" class=""  name="BanUsearea" id="" placeholder="使用面积" required />
			  </div>
			</div> -->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="" class="label_style">规定租金：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" class="" name="PreRent" id="" placeholder="0.00" value="" required />-->
			  <!--</div>-->
			<!--</div>-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="" class="label_style">计算租金：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" class="" name="CountRent" id="" placeholder="0.00" value="" required />-->
			  <!--</div>-->
			<!--</div>-->
			<input id="currentId" hidden value="">
			<div class="am-form-group am-u-md-12">
			  <label style="float:left;">土地证电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="LandCertificate" id="LandCertificate" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="LandShow" style="width:310px;height:150px;float:left;">

			<div class="am-form-group am-u-md-12">
			  <label style="float:left;">不动产电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="RealEstate" id="RealEstate" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="EstateShow" style="width:310px;height:150px;float:left;">

			<div class="am-form-group am-u-md-12">
			  <label class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="BanImageIDS" id="imageUp" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShow" style="width:310px;height:150px;float:left;">
		</div>

		<div class="am-u-md-6">
			<!-- <div class="am-form-group am-u-md-12">
				<label for="" class="label_style" >楼栋地址：</label>
				<div class="am-u-md-8">
					<input type="text" class="" name="BanAddress" id="BanAddress" placeholder="楼栋地址" required />
				</div>
			</div> 
			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style" >楼栋地址：</label>
				<div class="am-u-md-8">
					<label id="BanAddress"></label>
				</div>
			</div>-->
			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style" >经纬度：</label>
				<div class="am-u-md-8">
					<input type="text" class="" name="xy" id="getPosition" placeholder="楼栋地址" required />
				</div>
			</div>
			<div class="am-form-group am-u-md-12" id="FormMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;"></div>
		</div>

<!-- 		<hr class="am-u-md-11"/> -->

		<!--<div class="am-form-group am-u-md-12 padding_left">-->
			<!--<label for="" class="label_style" style="width:150px;">经纬度（地图接口）：</label>-->
			<!--<div class="am-u-md-5">-->
				<!--<input type="text" class=""  id="doc-vld-age-4" placeholder="规定租金" required />-->

			<!--</div>-->

			<!--<button style="padding-right:0.7rem" class="am-btn am-btn-default label_style" type="button">坐标拾取</button>-->

		<!--</div>-->

<!-- 		<div class="am-form-group am-u-md-12 padding_left">
			<label for="" class="label_style">产权来源：</label>
			<div class="am-u-md-9">
				<input type="text" class="" name="PropertySource" id="doc-vld-age-3" placeholder="产权来源" required />
			</div>
		</div> -->

	<!-- 	<hr class="am-u-md-11"/> -->
		
		<div class="am-form-group am-u-md-12 padding_left">
		  <label>拆迁状态： </label>
		  <label class="am-radio-inline">
			<input type="radio"  value="1" checked="checked" name="RemoveStatus" required> 未拆迁
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="2" name="RemoveStatus"> 已拆迁，未下基数
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="3" name="RemoveStatus">已拆迁，下基数
		  </label>
		</div>
	  </fieldset>
  </form>
  <form action="<?php echo url('BanInfo/edit'); ?>" method="post" id="modifyForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-12">
			<div class="am-form-group am-u-md-12">
				<label>楼栋地址：</label>
				<div class="inline_70">
					<select ><option>武昌区</option></select>
				</div>
				<div class="inline_70">
					<select name="AreaTwo" id="AreaTw" required>
						<option  value="" style="display:none">请选择</option>
<!-- 						<?php foreach($areaTwo as $k15 =>$v15){;?>
						<option value="<?php echo $v15['id']; ?>"><?php echo $v15['AreaTitle']; ?></option>
						<?php }; ?> -->
					</select>
				</div>
				<div class="inline_70">
					<select name="AreaThree" id="AreaThre" required>
						<option  value="" style="display:none">请选择</option>
						<?php foreach($areaThree as $k16 =>$v16){;?>
						<option value="<?php echo $v16['id']; ?>"><?php echo $v16['AreaTitle']; ?></option>
						<?php }; ?>
					</select>
				</div>
				<input type="text" name="AreaFour" id="AreaFou" style="width:200px;display:inline-block;" />
			</div>
		</div>
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-8">
				<input type="number" onfocus=this.blur() name="BanID" id="BanID" placeholder="楼栋编号" required/>
			  </div>
			</div>
		
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-2" class="label_style">机构名称：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="TubulationID" id="tubulationID" >

					<option  value="" style="display:none">请选择</option>

					<?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] == 1){; ?>
					<optgroup label="<?php echo $v10['Institution'] ;?>">
						<?php  foreach($instLst as $k11 => $v11){  if($v11['pid'] == $v10['id']){; ?>
						<option value="<?php echo $v11['id']; ?>" ><?php echo $v11['Institution']; ?></option>
						<?php }}; ?>
					</optgroup>

					<?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ; ?>

					<option value="<?php echo $v12['id']; ?>" ><?php echo $v12['Institution']; ?></option>

					<?php }} ; ?>


				</select>

			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">产权证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanPropertyID" id="BanPropertyID" placeholder="产权证号" required/>
				</div>
			</div>


			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-4" class="label_style">完损等级：</label>
			  <div  class="am-u-md-8" style="float:left;">
				<select name="DamageGrade" id="doc-select-4" class="DamageGraded" >
					<?php foreach($damaLst as $k2 =>$v2){;?>
					<option value="<?php echo $k2+1; ?>"><?php echo $v2['DamageGrade']; ?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>
			
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">是否改造产：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
				<!--<select name="StructureType" id="doc-select-8" >-->
						<!--<?php foreach($struLst as $k4 =>$v4){;?>-->
						<!--<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>-->
						<!--<?php }; ?>-->
				<!--</select>-->
			  <!--</div>-->
			<!--</div>-->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">土地证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanLandID" id="BanLandI" placeholder="土地证号" required/>
				</div>
			</div>			
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">不动产证号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFreeholdID" id="BanFreeholdI" placeholder="不动产证号" required/>
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">总户数：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalHouseholds" id="TotalHouseholds" placeholder="总户数" required/>
				</div>
			</div>	
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">影像资料：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="TotalHouseholds" id="doc-vld-email-3" placeholder="上传插件" required/>-->
				<!--</div>-->
			<!--</div>			-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">附属设施：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="TotalHouseholds" id="doc-vld-email-3" placeholder="做成多选按钮" required/>-->
				<!--</div>-->
			<!--</div>-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">占地面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="CoveredArea" id="editCoveredArea" placeholder="占地面积" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">证载面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="ActualArea" id="editActualArea" placeholder="证载面积" required/>
				</div>
			</div>
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">栋建面：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="number" name="BanArea" placeholder="栋建面" required/>-->
				<!--</div>-->
			<!--</div>-->
					
		</div>
		
		<div class="am-u-md-6">
			<!--<div class="am-form-group am-u-md-12">-->
				<!--<label for="doc-select-5" class="label_style">楼栋状态：</label>-->
				<!--<div class="am-u-md-8" style="float:left;">-->
					<!--<select name="BanStatus" id="BanStatus" >-->
						<!--<option  value="" style="display:none">请选择</option>-->
						<!--<option value="1" >正常</option>-->
						<!--<option value="2">已注销</option>-->
						<!--<option value="3">不在管辖范围内</option>-->
					<!--</select>-->
				<!--</div>-->
			<!--</div>-->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">产别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="OwnerType" id="ownerType" >
					<?php foreach($owerLst as $k3 =>$v3){;?>
					<option value="<?php echo $k3+1; ?>"><?php echo $v3['OwnerType']; ?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">建成年份：</label>
				<div class="am-u-md-8" data-am-validator>
					<input type="text" name="BanYear" id="BanYear" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="建成年份"/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">使用性质：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="UseNature" id="doc-select-7" class="UseNatured" >
					<option  value="" style="display:none">请选择</option>
					<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
					<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
					<?php }; ?>
				</select>
			  </div>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">结构类别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="StructureType" id="doc-select-8" class="StructureTyped" >
						<?php foreach($struLst as $k4 =>$v4){;?>
						<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>
						<?php }; ?>
				</select>
			  </div>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUnitNum" id="BanUnitNum" placeholder="单元数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorNum" id="BanFloorNum" placeholder="总楼层数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">起始楼层：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorStart" id="BanFloorStart" placeholder="起始楼层数" required/>
				</div>
			</div>
			

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否历史优秀建筑：</label>
				<div class="am-u-md-6">
					<select name="HistoryIf" id="HistoryIf" required style="width:112%;">
						<option  value="" style="display:none">请选择</option>
						<option value="0">不是</option>
						<option value="1">市级</option>
						<option value="2">区级</option>
						<option value="3">省级</option>
					</select>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
				<label class="label_style">是否改造产： </label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ReformIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ReformIf"> 否
					</label>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否文物保护单位：</label>
			  <div class="am-u-md-6">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ProtectculturalIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ProtectculturalIf"> 否
					</label>
				</div>
			</div>	
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">产权是否分割：</label>
			  <div class="am-u-md-6">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="CutIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="CutIf"> 否
					</label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfElevator" value="1" />
				<label>有电梯</label>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfFirst" value="1" />
				<label>居住第一层有架空层或木地板住房</label>
			</div>
		</div>

		<hr class="am-u-md-11"/>

		<div class="am-u-md-6">
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-vld-name-2" class="label_style">企业建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="EnterpriseArea" id="EnterpriseArea" minlength="1" placeholder="输入企业建面" required/>-->
			  <!--</div>-->
			<!--</div>-->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-vld-email-2" class="label_style">机关建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="PartyArea" id="PartyArea" placeholder="机关建面" required/>-->
			  <!--</div>-->
			<!--</div>-->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-vld-url-2" class="label_style">民用建面：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" name="CivilArea" id="CivilArea" placeholder="民用建面" required/>-->
			  <!--</div>-->
			<!--</div>-->
			
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">使用面积：</label>
			  <div class="am-u-md-8">
				<input type="number" class="" name="BanUsearea"  id="BanUsearea" placeholder="使用面积" required />
			  </div>
			</div> -->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-vld-age-2" class="label_style">规定租金：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" class="" name="PreRent" id="PreRent" value="0.00" required />-->
			  <!--</div>-->
			<!--</div>-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="" class="label_style">计算租金：</label>-->
			  <!--<div class="am-u-md-8">-->
				<!--<input type="number" class="" name="CountRent" id="" placeholder="0.00" value="" required />-->
			  <!--</div>-->
			<!--</div>-->

			<div class="am-form-group am-u-md-12">
			  <label for="editLandCertificate" style="float:left;">土地证电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="LandCertificate" id="editLandCertificate" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShowOne" style="width:310px;height:150px;float:left;">

			<div class="am-form-group am-u-md-12">
			  <label for="editRealEstate" style="float:left;">不动产电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="RealEstate" id="editRealEstate" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShowTwo" style="width:310px;height:150px;float:left;">

			<div class="am-form-group am-u-md-12">
			  <label for="editImgReload" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="BanImageIDS" id="editImgReload" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShowThree" style="width:310px;height:150px;float:left;">

		</div>
		<div class="am-u-md-6">
			<!--<div class="am-form-group am-u-md-12">-->
				<!--<label for="doc-vld-age-2" class="label_style" >楼栋地址：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" class="" name="BanAddress" id="BanAddressRe" placeholder="楼栋地址" required />-->
				<!--</div>-->
			<!--</div>-->
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-age-2" class="label_style" >经纬度：</label>
				<div class="am-u-md-8">
					<input type="text" class="" name="xy" id="xy" required />
				</div>
			</div>
			<div class="am-form-group am-u-md-12" id="ModifyMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;"></div>
		</div>

		<!--<hr class="am-u-md-11"/>

		<div class="am-form-group am-u-md-12 padding_left">-->
			<!--<label for="doc-vld-age-2" class="label_style" style="width:150px;">经纬度（地图接口）：</label>-->
			<!--<div class="am-u-md-5">-->
				<!--<input type="text" class=""  id="doc-vld-age-4" placeholder="规定租金" required />-->

			<!--</div>-->

			<!--<button style="padding-right:0.7rem" class="am-btn am-btn-default label_style" type="button">坐标拾取</button>-->

		<!--</div>


		<div class="am-form-group am-u-md-12 padding_left">
			<label for="doc-vld-age-2" class="label_style">产权来源：</label>
			<div class="am-u-md-9">
				<input type="text" class="" name="PropertySource" id="PropertySource" placeholder="产权来源" required />
			</div>
		</div>

		<hr class="am-u-md-11"/>-->
		
		<div class="am-form-group am-u-md-12 padding_left">
		  <label>拆迁状态： </label>
		  <label class="am-radio-inline">
			<input type="radio"  value="1" name="RemoveStatus"> 未拆迁
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="2" name="RemoveStatus"> 已拆迁，未下基数
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="3" name="RemoveStatus">已拆迁，下基数
		  </label>
		</div>
	  </fieldset>

  </form>

  <div id="banDetail" class="am-form" style="display:none;margin-top:1.6rem;">

    <fieldset style="width:780px;">
        <!--<legend>添加楼栋</legend>-->
        <div class="am-u-md-6">

            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-email-2" class="label_style">楼栋地址：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanAddress"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanID"></p>
                </div>
            </div>


            <div class="am-form-group am-u-md-12">
                <label for="doc-select-2" class="label_style">机构名称：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="TubulationID"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">

                <label for="doc-vld-email-2" class="label_style">产权证号：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanPropertyID"></p>
                </div>

            </div>

            <div class="am-form-group am-u-md-12">

                <label for="doc-select-4" class="label_style">完损等级：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="DamageGrade"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">土地证号：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanLandID"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">不动产证号：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanFreeholdID"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">总户数：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="DetailsTotalHouseHolds"></p>
                </div>
            </div>


            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">占地面积：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailsTotalArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">证载面积：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailActualArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">栋建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailBanArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">企业建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailEnterpriseArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">机关建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailPartyArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">民用建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailCivilArea"></p>
                </div>
            </div>
            <!--暂无相关信息-->
            <!-- <div class="am-form-group am-u-md-12">
              <label for="doc-select-8" class="label_style">附属设施：</label>
              <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="SubsidiaryFacility"></p>
              </div>
            </div> -->

            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-name-2" class="label_style">企业原价：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style"></p>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-email-2" class="label_style">机关原价：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style"></p>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-url-2" class="label_style">民用原价：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style"></p>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-age-2" class="label_style">合计原价：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style" id="TotalOprice"></p>-->
            <!--</div>-->
            <!--</div>-->
            <!--暂无相关信息-->
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">规定租金：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="PreRent"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">计算租金：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id=""></p>
                </div>
            </div>

            <!-- 			<div class="am-form-group am-u-md-12">
                          <label for="doc-vld-age-2" class="label_style">楼栋地址：</label>
                          <div class="am-u-md-8">
                                <p class="detail_p_style" id="BanAddress"></p>
                          </div>
                        </div>

                        <div class="am-form-group am-u-md-12">
                          <label for="doc-vld-age-2" class="label_style">产权来源：</label>
                          <div class="am-u-md-8">
                                <p class="detail_p_style" id="PropertySource"></p>
                          </div>
                        </div>
                        <div class="am-form-group am-u-md-12">
                          <label for="doc-vld-age-2" class="label_style">楼栋产别：</label>
                          <div class="am-u-md-8">
                                <p class="detail_p_style" id="OwnerType"></p>
                          </div>
                        </div> -->
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">拆迁状态：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="RemoveStatus"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="label_style">土地证电子版：</label>
            </div>
            <img class="am-form-group am-u-md-12" id="detailImgOne" src="" style="width:310px;height:150px;float:left;">
            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="label_style">不动产电子版：</label>
            </div>
            <img class="am-form-group am-u-md-12" id="detailImgTwo" src="" style="width:310px;height:150px;float:left;">
            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="label_style">影像资料：</label>
            </div>
            <img class="am-form-group am-u-md-12" id="detailImgThree" src=""
                 style="width:310px;height:150px;float:left;">
            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-select-8" class="label_style">影像资料：</label>-->
            <!--<img style="width:300px;height:130px;" src="" alt="picture">-->
            <!--</div>	-->
        </div>


        <!--左右分割-->


        <div class="am-u-md-6">
            <div class="am-form-group am-u-md-12">

                <label for="doc-select-5" class="label_style">产别：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="OwnerType"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">

                <label for="doc-vld-email-2" class="label_style">建成年份：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanYear"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-7" class="label_style">使用性质：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="UseNature"></p>
                </div>
            </div>


            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">结构类别：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="StructureType"></p>
                </div>
            </div>
            <!--新加-->
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">单元数量：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanUnitNum"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">楼层数量：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanFloorNum"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">起始楼层：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanFloorStart"></p>
                </div>
            </div>

            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-select-8" class="label_style">机构ID：</label>-->
            <!--<div class="am-u-md-8" style="float:left;">-->
            <!--<p class="detail_p_style" id="InstitutionID"></p>-->
            <!--</div>-->
            <!--</div>			-->
            <!-- <div class="am-form-group am-u-md-12">
              <label for="doc-select-8" class="label_style">机构：</label>
              <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="TubulationID"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-select-8" class="label_style">楼栋维护费：</label>
              <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanRepairCost"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-vld-name-2" class="label_style">企业建面：</label>
              <div class="am-u-md-8">
                    <p class="detail_p_style"  id="EnterpriseArea"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-vld-email-2" class="label_style">机关建面：</label>
              <div class="am-u-md-8">
                    <p class="detail_p_style"  id="PartyArea"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-vld-url-2" class="label_style">民用建面：</label>
              <div class="am-u-md-8">
                    <p class="detail_p_style"  id="CivilArea"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-vld-age-2" class="label_style">合计建面：</label>
              <div class="am-u-md-8">
                    <p class="detail_p_style" id="TotalArea"></p>
              </div>
            </div>

            <div class="am-form-group am-u-md-12">
              <label for="doc-vld-age-2" class="label_style">使用面积：</label>
              <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanUsearea"></p>
              </div>
            </div> -->
            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-age-2" class="label_style">楼栋状态：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style">楼栋编号</p>-->
            <!--</div>-->
            <!--</div>-->
            <div class="am-form-group am-u-md-12">

                <label for="doc-select-8" class="label_style lh15">历史优秀建筑：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="HistoryIf"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">是否改造产：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="ReformIf"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style lh15">文物保护单位：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="ProtectculturalIf"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style lh15">产权是否分割：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="CutIf"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">是否有电梯：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="IfElevator"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style lh15">居住第一层是否有架空层或木地板住房：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="IfFirst"></p>
                </div>
            </div>
            <!-- 			<div class="am-form-group am-u-md-12">
                              <input type="checkbox" style="margin-top:20px;" />
                              <label>有电梯：</label>
                        </div>
                        <div class="am-form-group am-u-md-12">
                             <input type="checkbox" style="margin-top:20px;" />
                             <label>居住第一层有架空层或木地板住房</label>
                        </div> -->

            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">经纬度：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanGpsXY"></p>
                </div>
            </div>

            <!--<div class="am-form-group am-u-md-12">-->
                <!--<label for="doc-vld-age-2" class="label_style">经纬度：</label>-->
                <!--<div class="am-u-md-8">-->
                    <!--<p class="detail_p_style" id="BanGpsXY"></p>-->
                <!--</div>-->
            <!--</div>-->

            <div class="am-form-group am-u-md-12" id="allMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;">

            </div>
           <ol id="Drecord" style="float: left;">
               
           </ol>

        </div>
    </fieldset>
</div>
  <div id="banStructure" style="display:none;margin-top:1.6rem;">
	<table class="am-u-md-3 am-table-striped am-table-centered">
		<thead><tr><th>楼栋信息</th></tr></thead>
		<tbody>
			<tr ><td>楼栋编号：</td></tr>
			<tr ><td id="Ban"></td></tr>
			<tr ><td>楼栋地址：</td></tr>
			<tr><td id="BanAddre"></td></tr>
			<tr ><td>结构类别：</td></tr>
			<tr><td id="StructureTy"></td></tr>
			<tr ><td>完损等级：</td></tr>
			<tr><td id="DamageGra"></td></tr>
			<tr ><td>单元数：</td></tr>
			<tr><td id="BanUnitN"></td></tr>
			<tr ><td>总层数：</td></tr>
			<tr><td id="BanFloorN"></td></tr>
		</tbody>
	</table>
	<div class="am-u-md-6 am-scrollable-horizontal" style="width:500px;">
		<table class="am-u-md-3 am-table am-table-striped am-table-centered am-text-nowrap">
			<thead class="BuildUnit">
				
				
					<!--数据库获取-->

					<!--数据库获取-->
			</thead>
			<tbody class="BuildFloor">
				<!--数据库获取-->
				<tr>
					<td>1</td>
					<td>
						<span class="ban_span">1</span><span class="ban_span">2</span>
						<!-- <span class="ban_span am-text-secondary">1</span><span class="ban_span">2</span>
						<span class="ban_span am-text-secondary">1</span><span class="ban_span">2</span>
						<span class="ban_span am-text-secondary">1</span><span class="ban_span">2</span>
						<span class="ban_span am-text-secondary">1</span><span class="ban_span">2</span>
						<span class="ban_span am-text-secondary">1</span><span class="ban_span">2</span> -->
					</td>
				</tr>
					<!--数据库获取-->
			</tbody>
		</table>
	</div>
	<div class="am-u-md-3" id="StructHouse" style="display:none; padding: 0">
		<table class="am-u-md-12 am-table-striped am-table-centered">
			<thead><tr><th>房屋信息</th></tr></thead>
			<tbody>
				<tr ><td>机构名称：</td></tr>
				<tr ><td id="dongStruc"> </td></tr>
				<tr ><td>租户姓名：</td></tr>
				<tr><td id="dongName"> </td></tr>
				<tr ><td>楼层号：</td></tr>
				<tr><td id="dongFloor"></td></tr>
				<tr ><td>单元号：</td></tr>
				<tr><td id="dongUnit"></td></tr>
<!-- 				<tr ><td>单元数：</td></tr>
				<tr><td id="dongUnitNum">4</td></tr> -->
				<tr ><td>门牌号码：</td></tr>
				<tr><td id="dongDoor"></td></tr>
				<tr ><td>规定月租金：</td></tr>
				<tr><td id="dongRent"></td></tr>
				<tr ><td>原价：</td></tr>
				<tr><td id="dongPrice"></td></tr>
				<tr ><td>合计使用面积：</td></tr>
				<tr><td id="dongArea"></td></tr>
				<tr ><td>建筑面积：</td></tr>
				<tr><td id="dongBuilArea"></td></tr>
				<tr ><td>泵费：</td></tr>
				<tr><td id="dongCost"></td></tr>
				<tr ><td>房屋基数：</td></tr>
				<tr><td id="dongBase"></td></tr>
			</tbody>
		</table>
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

<script src="http://api.map.baidu.com/api?v=2.0&ak=2xlodrKVRyFNeopCajiMTfgIOr8dnUAe"></script>
<script type="text/javascript" src="/public/static/gf/js/validation.js"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/confirm_ban_form.js"></script>

<script type="text/javascript" src="http://tajs.qq.com/stats?sId=62257953" charset="UTF-8"></script><!--腾讯统计-->
</body>
</html>
