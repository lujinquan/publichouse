<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"D:\phpStudy\WWW\ph/application/ph\view\rent_payable\index.html";i:1527069861;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1527069860;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>租金应缴</title>
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
    .am-nav>li.am-active>a, .am-nav>li.am-active>a:focus, .am-nav>li.am-active>a:hover{color:#FFF;}
    .am-topbar-nav>li>a:after{display:none;}
    body .ddd-class .layui-layer-title{background:#FFF;font-size:20px;}
    body .ddd-class .layui-layer-btn0{border-top:1px solid #E9E7E7}
    .div_input{text-align:center;}
    .div_input label{width:120px;display:inline-block;vertical-align:middle;text-align:right;font-size:20px;color:#999;font-weight:500;}
    .div_input input{height:35px;padding:5px;margin:10px 0;display:inline-block;vertical-align:middle;border:1px solid #ccc;border-radius:4px;}
    #offCanvas{margin-left: 44px;}
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
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
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

  <!-- content start -->
  
  <!-- content start -->
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><small class="am-text-sm">租金管理</small> > <small class="am-text-primary">租金应缴</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-8">
        <div class="am-btn-toolbar">
          <div class="am-btn-group-xs">
            <?php if(in_array(253,$threeMenu)){ ; ?>
            <button type="button" id="rentPayment" class="am-btn d-btn-1188F0 am-radius">
              <span class="am-icon-cog"></span> 批量缴费</button>
            <?php }; if(in_array(254,$threeMenu)){ ; ?>
            <button type="button" id="rentArrearage" class="am-btn d-btn-1188F0 am-radius">
              <span class="am-icon-cogs"></span> 批量欠缴</button>
              <?php }; if(in_array(255,$threeMenu)){ ; ?>
            <button type="button" id="generateCharging" class="am-btn d-btn-1188F0 am-radius">
              <span class="am-icon-crop"></span> 批量扣缴</button>
              <?php }; if(in_array(529,$threeMenu)){ ; ?>
            <button type="button" id="deleteCharging" class="am-btn d-btn-1188F0 am-radius">
              <span class="am-icon-trash-o"></span> 删除订单</button>
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
                <th class="table-title">#</th>
                <th class="table-author am-hide-sm-only">订单编号</th>
                <th class="table-date am-hide-sm-only">房屋编号</th>
                <th class="table-set">机构名称</th>
                <th class="table-set">产别</th>
                <th class="table-set">租户姓名</th>
                <th class="table-set">楼栋地址</th>
                <th class="table-set">规定租金</th>
                <th class="table-set">单元号</th>
                <th class="table-set">楼层号</th>
                <th class="table-set">门牌号</th>
                <th class="table-set">减免租金</th>
<!--                 <th class="table-set">泵费</th>
                <th class="table-set">维修费</th> -->
                <th class="table-set">应缴租金</th>
                <th class="table-set">历史欠租</th> 
                <th class="table-set">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
      <form action="<?php echo url('RentPayable/index'); ?>" method="post" id="queryForm">
		    <tr class="am-form-group am-form-inline am-form">
              <td></td>
              <td></td>
              <td>
                  <div class="am-input-group am-input-group-sm">
                      <?php
                        if($rentOption != array()){
                            $RentOrderID = $rentOption['RentOrderID'];
                        }else{
                            $RentOrderID = '';
                        }
                     ?>
                      <input style="width:152px;" name="RentOrderID" type="text" class="am-form-field" value="<?php echo $RentOrderID; ?>">
                  </div>
              </td>
              <td>
                  <div class="am-input-group am-input-group-sm">
                      <?php
                        if($rentOption != array()){
                            $HouseID = $rentOption['HouseID'];
                        }else{
                            $HouseID = '';
                        }
                     ?>
                      <input name="HouseID" type="text" class="am-form-field" value="<?php echo $HouseID; ?>">
                  </div>
              </td>
              <td>
                  <div class="am-form-group search_input">


                      <?php if(session('user_base_info.institution_level')!=3){ ;?>
                      <select name="TubulationID" id="doc-select-2">
                          <option  value="" style="display:none">请选择</option>

                          <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 

                                if($rentOption != array()){

                                    if($rentOption['TubulationID'] == $v10['id']){

                                        $select ='selected';
                                    }else{

                                        $select ='';
                                    }
                                }else{

                                    $select ='';
                                }

                                ?>

                          <option value="<?php echo $v10['id']; ?>" <?php echo $select; ?>><?php echo $v10['Institution']; ?></option>

                          <?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ; 

                                if($rentOption != array()){

                                    if($rentOption['TubulationID'] == $v12['id']){

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
                                if($rentOption != array()){
                                    if($rentOption['OwnerType'] == $v3['id']){
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
                        if($rentOption != array()){
                            $TenantName = $rentOption['TenantName'];
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
                        if($rentOption != array()){
                            $BanAddress = $rentOption['BanAddress'];
                        }else{
                            $BanAddress = '';
                        }
                     ?>
                      <input style="width:150px;" name="BanAddress" type="text" class="am-form-field" value="<?php echo $BanAddress; ?>">
                  </div>
              </td>
                <td>
                    <div class="am-input-group am-input-group-sm"><?php
                        if($rentOption != array()){
                            $HousePrerent = $rentOption['HousePrerent'];
                        }else{
                            $HousePrerent = '';
                        }
                     ?>
                        <input name="HousePrerent" type="text" class="am-form-field" value="<?php echo $HousePrerent; ?>">
                    </div>
                </td>
                <td><div style="width:50px;"></div></td>
                <td><div style="width:50px;"></div></td>
                <td><div style="width:50px;"></div></td>
                <td><div style="width:70px;"></div></td>
                <td><div style="width:50px;"></div></td>
                <td><div style="width:50px;"></div></td>
              <td>
                <div class="am-btn-group am-btn-group-xs">
                  <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/RentPayable/index.html"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
      </form>
		<!---查询-->
		<style type="text/css">
            		input[type='checkbox'] {
											  display: none;
											}
										label {
										  display: inline-block;
										  width: 20px;
										  height:20px;
										  position: relative;
										  background:url(/public/static/gf/icons/inputradio.png)no-repeat;
										  background-position: -32px 0px;
										  vertical-align: middle;
										  /*-webkit-transition: background 0.5s linear;*/
										}
							input[type='checkbox']:checked+label {
										  background-position: 0 0px;
							}
            	</style>
            	
          <?php foreach($rentLst as $k => $v){ ;?>
            <tr class="check002 thead_width">
                <td class="aId">               	
                	<input  class="checkId" type="checkbox" name='choose' value="<?php echo $v['RentOrderID']; ?>"/>
                	<label></label>
                </td>
                <td><?php echo ++$k; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['RentOrderID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['HouseID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['InstitutionID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['OwnerType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['TenantName']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['BanAddress']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['HousePrerent']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['UnitID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['FloorID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['DoorID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['CutRent']; ?></td>
<!--                 <td class="am-hide-sm-only"><?php echo $v['PumpCost']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['RepairCost']; ?></td> -->
                <td class="am-hide-sm-only"><?php echo $v['ReceiveRent']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['HistoryUnpaidRent']; ?></td>
      				  <td>
      					<div class="am-btn-toolbar" style="width:140px;">
      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary details payment" value="<?php echo $v['RentOrderID']; ?>">缴费</button>
      					</div>
      				  </td>
            </tr>
          <?php }; ?>

          </tbody>
        </table>
		<div class="am-cf">
		  共<?php echo $rentLstObj->total(); ?>条记录
		  <div class="am-fr">
              <?php echo $rentLstObj->render(); ?>
		  </div>
		</div>
      </div>
    </div>
  </div>
<form id="details" class="am-form" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-6">
      <div class="am-u-sm-4" style="padding: 0; font-size: 14px; font-weight: bold;">月租金：</div><div class="am-u-sm-8" id="HousePrerent" style="padding: 0; font-size: 14px; font-weight: bold;">0102030405</div>
    </div>
    <div class="am-form-group am-u-sm-6">
      <div class="am-u-sm-4" style="padding: 0; font-size: 14px; font-weight: bold;">减免租金：</div><div id="CutRent" class="am-u-sm-8" id="HousePrerent" style="padding: 0; font-size: 14px; font-weight: bold;">1</div>
    </div>
<!--     <div class="am-form-group am-u-sm-6">
      <label>泵费：</label><label id="PumpCost">2</label>
    </div>
    <div class="am-form-group am-u-sm-6">
      <label>维修费：</label><label id="RepairCost">5</label>
    </div> -->
    <div class="am-form-group am-u-sm-6">
      <div class="am-u-sm-4" style="padding: 0; font-size: 14px; font-weight: bold;">应缴租金：</div><div id="ReceiveRent" class="am-u-sm-8" style="padding: 0; font-size: 14px; font-weight: bold;">3000</div>
    </div>
    <div class="am-form-group am-u-sm-6">
      <input id="money" type="number" placeholder="请输入金额" />
    </div>
  </div>
</form>
  <!-- content end -->

</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <p style="text-align:center;margin:0;padding:1rem 0;background:#EDEDED;color:#999;">© 2017 CTNM.</p>
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
  <div class="am-u-md-12">
    <label>租户查询器</label>
  </div>
  <div class="am-u-md-12" style="padding:0">
      <div class="am-u-md-3" style="border:1px solid #ccc; width: 20%;">
    <p>请输入筛选条件</p>
    <div class="am-form-group">
      <label id="tenantAddSelect" for="doc-ipt-pwd-1">所属机构：</label>
    </div>
   <div class="am-form-group">
      <label for="doc-ipt-pwd-1">租户姓名：</label>
      <input type="text" class="" id="tenantTwo" placeholder="">
    </div>
    <div class="am-form-group">
      <label for="doc-ipt-pwd-1">联系电话：</label>
      <input type="text" class="" id="tenantThr" placeholder="">
    </div>
    <button id="tenantQueryClick" class="am-btn am-btn-primary">查询</button>
  </div>
  <div class="am-u-md-9" style="border:1px solid #ccc; width: 80%">
    <table class="am-table-bordered am-table-centered" style="width: 100%">
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
  <div class="am-u-md-12">
    <label>楼栋查询器</label>
  </div>
  <div class="am-u-md-12" style="padding:0">
      <div class="am-u-md-3" style="border:1px solid #ccc; width: 20%;">
    <p>请输入筛选条件</p>
    <div class="am-form-group">
      <label id="banAddSelect" for="doc-ipt-pwd-1">所属机构：</label>
    </div>
   <div class="am-form-group">
      <label for="doc-ipt-pwd-1">楼栋地址：</label>
      <input type="text" class="" id="banTwo" placeholder="">
    </div>
    <button id="banQueryClick" class="am-btn am-btn-primary">查询</button>
  </div>
  <div class="am-u-md-9" style="border:1px solid #ccc; width: 80%">
    <table class="am-table-bordered am-table-centered" style="width: 100%">
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
  <div class="am-u-md-12">
    <label>房屋查询器</label>
  </div>
  <div class="am-u-md-12" style="padding:0">
      <div class="am-u-md-3" style="border:1px solid #ccc; width: 20%;">
    <p>请输入筛选条件</p>
    <div class="am-form-group">
      <label id="houseAddSelect" for="doc-ipt-pwd-1">所属机构：</label>
    </div>
   <div class="am-form-group">
      <label for="doc-ipt-pwd-1">租户姓名：</label>
      <input type="text" class="" id="houseTwo" placeholder="">
    </div>
    <div class="am-form-group">
      <label for="doc-ipt-pwd-1">楼栋地址：</label>
      <input type="text" class="" id="houseThr" placeholder="">
    </div>
    <button id="houseQueryClick" class="am-btn am-btn-primary">查询</button>
  </div>
  <div class="am-u-md-9" style="border:1px solid #ccc; width: 80%">
    <table class="am-table-bordered am-table-centered" style="width: 100%">
      <thead>
          <th>楼栋编号</th>
          <th>房屋编号</th>
          <th>单元号</th>
          <th>楼层号</th>
          <th>租户姓名</th>
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
  <div class="div_input"><label>旧密码：</label><input id="oldPassword" type="password" placeholder="请输入旧密码" /></div>
  <div class="div_input"><label>新密码：</label><input id="newPassword" type="password" placeholder="请输入新密码" /></div>
  <div class="div_input"><label>确认密码：</label><input id="repeatPassword" type="password" placeholder="请再次输入新密码" /></div>
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
	<font color="blue">提示：只能挑选四个快捷方式</font>
	<table id="check_menu"></table><br/>
	<span id="most_count" style="color:red" hidden="hidden">最多只能选择四项！</span>
</div>
<script src="/public/static/gf/js/amazeui.min.js"></script>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
<script src="/public/static/gf/js/app.js"></script>
<script type="text/javascript">
  var body_height = $(document.body).height();
  var window_height = $(window).height();
  if(body_height < window_height){
    $("footer").css({'width':'100%','position':'fixed','bottom':'0'});
  }
  $('.admin-sidebar').height($('.admin-content').height());

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
var mouse_flag = false;
var mouse_start_x = null;
var mouse_end_x = null;
$('.am-table').mousedown(function(event){
  mouse_flag = true;
  mouse_start_x = event.clientX
  $(this).mousemove(function(event){
    var distance =$('.am-scrollable-horizontal').scrollLeft() + (event.clientX - mouse_start_x)/20;
    $('.am-scrollable-horizontal').scrollLeft(distance);
  })
})
$('.am-table').mouseup(function(event){
  mouse_flag = false;
  mouse_end_x = event.clientX;
  $(this).off("mousemove");
  $('.am-scrollable-horizontal').off("scrollLeft");
})
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

<script>
								
            	</script>
<script type="text/javascript" src="/public/static/gf/viewJs/rent_payable.js"></script>

</body>
</html>