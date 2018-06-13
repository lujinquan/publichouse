<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:61:"D:\phpStudy\WWW\gf/application/ph\view\tenant_info\index.html";i:1510885652;s:50:"D:\phpStudy\WWW\gf/application/ph\view\layout.html";i:1510905907;s:41:"application/ph/view/tenant_info/form.html";i:1508721795;s:43:"application/ph/view/tenant_info/detail.html";i:1507706244;s:43:"application/ph/view/tenant_info/modify.html";i:1499240882;s:43:"application/ph/view/notice/notice_info.html";i:1503709503;s:42:"application/ph/view/index/second_menu.html";i:1501656823;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>租户信息</title>
   
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
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">房屋档案</strong> / <small>租户信息</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
              <?php if(in_array(51,$threeMenu)){ ; ?>
            <button type="button" id="addTenant" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增租户</button>
              <?php }; if(in_array(52,$threeMenu)){ ; ?>
            <button type="button" id="reviseTenant" class="am-btn am-btn-default"><span class="am-icon-edit"></span> 修改租户</button>
              <?php }; if(in_array(519,$threeMenu)){ ; ?>
            <button type="button" id="deleteTenant" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除租户</button>
              <?php }; if(in_array(60,$threeMenu)){ ; ?>
            <!--<button type="button" id="outTenant" class="am-btn am-btn-default"><span class="am-icon-download"></span> 导出</button>-->
              <?php }; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-scrollable-horizontal">
          <table class="am-table am-table-striped am-table-hover table-main am-table-centered">
            <thead>
              <tr>
                <th class="table-check"></th>
        				<th class="table-id">#</th>
        				<th class="table-title">租户编号</th>
        				<th class="table-author am-hide-sm-only">租户姓名</th>
        				<th class="table-date am-hide-sm-only">联系电话</th>
        				<th class="table-set">余额</th>
         				<th class="table-set">欠租情况</th>
        				<th class="table-set">诚信分</th>
        				<th class="table-set">微信号</th>
        				<th class="table-set">QQ号</th>
                <th class="table-set">银行卡号</th>
                <th class="table-set">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
      <form id="queryForm" action="<?php echo url('TenantInfo/index'); ?>" method="post" autocomplete="off" >
		    <tr class="am-form-group am-form-inline am-form">
              <td></td>
              <td></td>
           <td>
              <div class="am-input-group am-input-group-sm">
                  <?php
                        if($tenantOption != array()){
                            $TenantID = $tenantOption['TenantID'];
                        }else{
                            $TenantID = '';
                        }
                     ?>
                <input name="TenantID" type="text" class="am-form-field" value="<?php echo $TenantID; ?>">
              </div>
            </td>
              <td>
				<div class="am-input-group am-input-group-sm">
                    <?php
                        if($tenantOption != array()){
                            $TenantName = $tenantOption['TenantName'];
                        }else{
                            $TenantName = '';
                        }
                     ?>
				  <input name="TenantName" type="text" class="am-form-field" value="<?php echo $TenantName; ?>">
				</div>
			  </td>
              <td>
				<div class="am-input-group am-input-group-sm">
                    <?php
                        if($tenantOption != array()){
                            $TenantTel = $tenantOption['TenantTel'];
                        }else{
                            $TenantTel = '';
                        }
                     ?>
				  <input name="TenantTel" type="text" class="am-form-field" value="<?php echo $TenantTel; ?>">
				</div>
			  </td>
          <td>
    				<div class="am-input-group am-input-group-sm">
                     <?php
                        if($tenantOption != array()){
                            $TenantBalance = $tenantOption['TenantBalance'];
                        }else{
                            $TenantBalance = '';
                        }
                     ?>
    				  <input name="TenantBalance" type="text" class="am-form-field" value="<?php echo $TenantBalance; ?>">
    				</div>
  			  </td>
          <td>
                  <div class="am-input-group am-input-group-sm">
                      <?php
                        if($tenantOption != array()){
                            $ArrearRent = $tenantOption['ArrearRent'];
                        }else{
                            $ArrearRent = '';
                        }
                     ?>
                      <input name="ArrearRent" type="text" class="am-form-field" value="<?php echo $ArrearRent; ?>">
                  </div>

  			  </td>
                <td>
                    <div class="am-input-group am-input-group-sm">
                    <?php
                        if($tenantOption != array()){
                            $TenantValue = $tenantOption['TenantValue'];
                        }else{
                            $TenantValue = '';
                        }
                     ?>
                        <input name="TenantValue" type="text" class="am-form-field" value="<?php echo $TenantValue; ?>">
                    </div>

                </td>
                <td>
                    <div class="am-input-group am-input-group-sm">
                    <?php
                        if($tenantOption != array()){
                            $TenantWeChat = $tenantOption['TenantWeChat'];
                        }else{
                            $TenantWeChat = '';
                        }
                     ?>
                        <input name="TenantWeChat" type="text" class="am-form-field"  value="<?php echo $TenantWeChat; ?>">
                    </div>

                </td>
                <td>
                    <div class="am-input-group am-input-group-sm">
                     <?php
                        if($tenantOption != array()){
                            $TenantQQ = $tenantOption['TenantQQ'];
                        }else{
                            $TenantQQ = '';
                        }
                     ?>
                        <input name="TenantQQ" type="text" class="am-form-field" value="<?php echo $TenantQQ; ?>">
                    </div>

                </td>
                <td>
                    <div class="am-input-group am-input-group-sm">
                     <?php
                        if($tenantOption != array()){
                            $BankID = $tenantOption['BankID'];
                        }else{
                            $BankID = '';
                        }
                     ?>
                        <input name="BankID" type="text" class="am-form-field" value="<?php echo $BankID; ?>">
                    </div>
                </td>
			         <td>
                <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-secondary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a class="am-btn am-btn-xs am-text-secondary ABtn" href="/ph/TenantInfo/index"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
      </form>
		<!---查询-->

		  <?php foreach($tenantLst as $k1 => $v1){; ?>

            <tr class="check001">
                <td>
                  <span class="piaochecked">
                    <input class="checkId radioclass" type="radio" name='choose' value="<?php echo $v1['TenantID']; ?>"/>
                  </span>
                </td>
                <td><?php echo ++$k1; ?></td>
                <td><?php echo $v1['TenantID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantName']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantTel']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantBalance']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['ArrearRent']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantValue']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantWeChat']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantQQ']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['BankID']; ?></td>
<!--                 <td class="am-hide-sm-only">ffff</td>
                <td class="am-hide-sm-only">ffff</td> -->
				  <td>
					  <div class="am-btn-group am-btn-group-xs">
                          <?php if(in_array(57,$threeMenu)){ ; ?>
						    <button class="am-btn am-btn-default am-btn-xs am-text-secondary details TenantDetailBtn" value="<?php echo $v1['TenantID']; ?>"> 明细</button>
                          <?php }; ?>
                      </div>
				  </td>
            </tr>

		  <?php }; ?>

          </tbody>
        </table>
		<div class="am-cf">
		  共<?php echo $tenantLstObj->total(); ?>条记录
		  <div class="am-fr">
			  <?php echo $tenantLstObj->render(); ?>
		  </div>
		</div>
      </div>
    </div>
  </div>

  <!-- content end -->
    <!-- <div id="deleteChoose" style="display:none;text-align: center;">
      <span class="piaochecked" style="float:none;">
        <input class="checkId radioclass" type="radio" name="roomDeleteType" value="2">
      </span>
      <span>房改</span>
      <span class="piaochecked" style="float:none;">
        <input class="checkId radioclass" type="radio" name="roomDeleteType" value="3">
      </span>
      <span>拆迁，已注销</span>
      <span class="piaochecked" style="float:none;">
        <input class="checkId radioclass" type="radio" name="roomDeleteType" value="4">
      </span>
      <span>数据合并</span>
      <span class="piaochecked" style="float:none;">
        <input class="checkId radioclass" type="radio" name="roomDeleteType" value="5">
      </span>
      <span>数据作废</span>
  </div> -->
  <div id="deleteChoose" style="display:none; text-align: center; margin: 20px;">
      <button id="HouseChange" class="am-btn am-btn-secondary " value="2" name="roomDeleteType" style="background: #0086ff;border:none">房改</button>
      <button id="HouseRemove" class="am-btn am-btn-secondary" value="3" name="roomDeleteType" style="background: #0086ff;border:none">拆迁，已注销</button>
      <button id="DateTogther" class="am-btn am-btn-secondary" value="4"  name="roomDeleteType"style="background: #0086ff;border:none">数据合并</button>
      <button id="DateLose" class="am-btn am-btn-secondary" value="5"  name="roomDeleteType"style="background: #0086ff;border:none">数据作废</button>
  </div>
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css"/>
<form  id="TenantForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset id="InputForm" style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">租户编号：</label>
			  <div class="am-u-md-8">
				<input type="number" name="TenantID" id="doc-vld-email-2" placeholder="租户编号" required/>
			  </div>
			</div>
 -->
			<!--<div class="am-form-group am-u-md-12">-->
				<!--<label for="doc-vld-email-2" class="label_style">房屋编号：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="HouseID" id="doc-vld-email-3" placeholder="产权证号" required/>-->
				<!--</div>-->
			<!--</div>-->		
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">联系电话：</label>
				<div class="am-u-md-8" >
					<input type="number" name="TenantTel" id="doc-vld-email-3" placeholder="联系电话" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">年龄：</label>
				<div class="am-u-md-8" >
					<input type="number" name="TenantAge" id="doc-vld-email-3" placeholder="年龄" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>	

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">微信号：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantWeChat" id="doc-vld-email-3" placeholder="微信号" required/>
				</div>
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">证件类型：</label>
				<div class="am-u-md-8" style="float:left;">
					<select name="TenantPaperType" id="doc-select-7" >
						<option value="1">身份证</option>
						<option value="2">护照</option>
						<option value="3">军官证</option>
						<option value="4">工商执照扫描件</option>
					</select>
				</div>
			</div> -->
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">身份证：</label>
				<div class="am-u-md-8" >
					<input type="text" name="TenantNumber" id="IDCard" placeholder="证件号码" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">银行卡号：</label>
				<div class="am-u-md-8" >
					<input type="number" name="BankID" id="doc-vld-email-5" placeholder="银行卡号" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">欠租情况：</label>
				<div class="am-u-md-8">
					<input type="number" name="ArrearRent" id="doc-vld-email-5" value="0.00" required/>
				</div>
			</div>
<!-- 
			<div class="am-form-group am-u-md-12">
			  <label for="imgUp" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="TenantImageIDS" id="imgUp" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShow" style="width:300px;height:150px;"> -->
		</div>
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">租户姓名：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantName" id="doc-vld-email-3" placeholder="租户姓名" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">性别：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="TenantSex" checked="checked" required> 男
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="TenantSex"> 女
					</label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">余额：</label>
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="选择年份" data-am-datepicker readonly/>-->
				<!--</div>-->
				<div class="am-u-md-8" data-am-validator>
					<input type="number" name="TenantBalance" id="doc-vld-email-10" value="0.00" required/>
				</div>
				<!--<input type="text" class="am-u-md-8" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="日历组件" data-am-datepicker readonly/>-->
			</div>

			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">QQ号：</label>
				<div class="am-u-md-8">
					<input type="number" name="TenantQQ" id="doc-vld-email-3" placeholder="QQ号" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">银行机构：</label>
				<div class="am-u-md-8" >
					<input type="text" name="BankName" id="doc-vld-email-3" placeholder="银行机构" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">诚信值：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantValue" id="doc-vld-email-3" placeholder="诚信值" required/>
				</div>
			</div>
		</div>
	  </fieldset>
  </form>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
  <div id="TenantDetail" class="am-form" style="display:none;margin-top:1.6rem;">

	  <fieldset>
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">租户编号：</label>
			  <div class="am-u-md-8">
				<p class="detail_p_style" id="TenantID">加载中</p>
			  </div>
			</div>

			<!--<div class="am-form-group am-u-md-12">-->
				<!--<label for="doc-vld-email-2" class="label_style">房屋编号：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<p class="detail_p_style" id="HouseID">加载中</p>-->
				<!--</div>-->
			<!--</div>-->
		
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-2" class="label_style">联系电话：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantTel">加载中</p>
					
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-4" class="label_style">年龄：</label>
			  <div  class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantAge">加载中</p>
			  </div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">微信号：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantWeChat">加载中</p>
			  </div>
			</div>	
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">身份证：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantNumber">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">银行卡号：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="BankID">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">登记人：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="CreateUserID">加载中</p>
			  </div>
			</div>	
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">更新时间：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="UpdateTime">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">欠租情况：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ArrearRent">加载中</p>
			  </div>
			</div>
		</div>
		
<!--左右分割-->		
		
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">租户姓名：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="TenantName">加载中</p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">性别：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantSex">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">余额：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantBalance">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">QQ号：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantQQ">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">银行机构：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="BankName">加载中</p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">诚信值：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="TenantValue">加载中</p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">登记机构：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="InstitutionName">加载中</p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">登记时间：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="CreateTime">加载中</p>
			  </div>
			</div>
			
		</div>
	  </fieldset>
  </div>
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css"/>

<form id="tenantModifyForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset id="InputForm" style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">租户编号：</label>
			  <div class="am-u-md-8">
				<input type="number" name="TenantID" onfocus=this.blur() id="TenantI" placeholder="租户编号" required/>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">联系电话：</label>
				<div class="am-u-md-8">
					<input type="number" name="TenantTel" id="TenantTe" placeholder="联系电话" required/>
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">年龄：</label>
				<div class="am-u-md-8">
					<input type="number" name="TenantAge" id="TenantAg" placeholder="年龄" required/>
				</div>
			</div>	

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">微信号：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantWeChat" id="TenantWeCha" placeholder="微信号" required/>
				</div>
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">证件类型：</label>
				<div class="am-u-md-8" style="float:left;">
					<select name="TenantPaperType" id="doc-select-7" >
						<option value="1">身份证</option>
						<option value="2">护照</option>
						<option value="3">军官证</option>
						<option value="4">工商执照扫描件</option>
					</select>
				</div>
			</div> -->
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">身份证：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantNumber" id="TenantNumbe" placeholder="证件号码" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">银行卡号：</label>
				<div class="am-u-md-8">
					<input type="number" name="BankID" id="BanI" placeholder="银行卡号" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">欠租情况：</label>
				<div class="am-u-md-8">
					<input type="number" name="ArrearRent" id="ArrearRen" value="0.00" required/>
				</div>
			</div>
<!-- 
			<div class="am-form-group am-u-md-12">
			  <label for="imgUp" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="TenantImageIDS" id="imgUp" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShow" style="width:300px;height:150px;"> -->
		</div>
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">租户姓名：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantName" id="TenantNam" placeholder="租户姓名" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">性别：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="TenantSex" checked="checked" required> 男
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="TenantSex"> 女
					</label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">余额：</label>
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="选择年份" data-am-datepicker readonly/>-->
				<!--</div>-->
				<div class="am-u-md-8" data-am-validator>
					<input type="number" name="TenantBalance" id="TenantBalanc" value="0.00" required/>
				</div>
				<!--<input type="text" class="am-u-md-8" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="日历组件" data-am-datepicker readonly/>-->
			</div>

			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">QQ号：</label>
				<div class="am-u-md-8">
					<input type="number" name="TenantQQ" id="TenantQ" placeholder="QQ号" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">银行机构：</label>
				<div class="am-u-md-8">
					<input type="text" name="BankName" id="BanNam" placeholder="银行机构" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">诚信值：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantValue" id="TenantValu" placeholder="诚信值" required/>
				</div>
			</div>
		</div>
	  </fieldset>
</form>

<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>

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

<script type="text/javascript" src="/public/static/gf/js/validation.js"></script>
<script src="/public/static/gf/js/require.js" data-main="/public/static/gf/viewJs/tenant_form.js"></script>

<script type="text/javascript" src="http://tajs.qq.com/stats?sId=62257953" charset="UTF-8"></script><!--腾讯统计-->
</body>
</html>
