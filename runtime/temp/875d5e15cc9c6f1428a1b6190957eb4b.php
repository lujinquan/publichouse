<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:62:"D:\phpStudy\WWW\ph/application/ph\view\change_audit\index.html";i:1527556860;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1527209267;s:49:"application/ph/view/change_audit/approveForm.html";i:1527556860;s:44:"application/ph/view/change_audit/detail.html";i:1523846105;s:50:"application/ph/view/change_audit/AdjustDetail.html";i:1526551061;s:48:"application/ph/view/change_audit/RoomDetail.html";i:1523846105;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>异动审核</title>
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
  
  <link rel="stylesheet" href="/public/static/gf/css/iconfont.css">
  <link rel="stylesheet" href="/public/static/gf/css/fileUpload.css">
  <!-- content start -->
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <small class="am-text-sm">异动管理</small> > 
        <small class="am-text-primary">异动审核</small>
      </div>
    </div>


    <div class="am-g">
      <div class="am-scrollable-horizontal">
          <table class="am-table am-table-striped am-table-hover table-main am-table-centered">
            <thead>
              <tr>
                <th class="table-check"></th>
        				<th class="table-id">#</th>
                        <th class="table-title">变更编号</th>
        				<!--<th class="table-title">楼栋编号</th>-->
        				<!--<th class="table-type">房屋编号</th>-->
        				<th class="table-author am-hide-sm-only">变更类型</th>
        				<th class="table-date am-hide-sm-only">申请机构</th>
        				<th class="table-set">操作人</th>
        				<th class="table-set">申请时间</th>
        				<th class="table-set">审核状态</th>
        				<th class="table-set" style="width:220px;">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
          <form action="<?php echo url('ChangeAudit/index'); ?>" method="post" id="queryForm">
		    <tr class="am-form-group am-form-inline">
              <td></td>
              <td></td>
              <td>
      				<div class="am-input-group am-input-group-sm">
                        <?php
                        if($changeOption != array()){
                            $ChangeOrderID = $changeOption['ChangeOrderID'];
                        }else{
                            $ChangeOrderID = '';
                        }
                     ?>
      				  <input style="width:182px;" type="text" class="am-form-field" name="ChangeOrderID" value="<?php echo $ChangeOrderID; ?>">
      				</div>
      			  </td>
                    <!--<td>-->
      				<!--<div class="am-input-group am-input-group-sm">-->
      				  <!--<input type="text" class="am-form-field">-->
      				<!--</div>-->
      			  <!--</td>-->
              <td>
        				<div class="am-input-group am-form" style="width:80px;">
                    <select name="ChangeType">
                        <option  value="" style="display:none">请选择</option>

                        <?php foreach($changes as $k0 => $v0){ ; 
                            if($changeOption != array()){

                                if($changeOption['ChangeType'] == $v0['id']){

                                    $select ='selected';
                                }else{

                                    $select ='';
                                }
                            }else{

                                $select ='';
                            }

                            ?>

                        <option value="<?php echo $v0['id']; ?>" <?php echo $select; ?> ><?php echo $v0['ProcessName']; ?></option>
                        <?php }; ?>
                    </select>
        				</div>
      			  </td>
                <td>
                    <div class="am-form-group am-form" style="width:100px;">
                        <?php if(session('user_base_info.institution_level')!=3){ ;?>
                        <select name="TubulationID">
                            <option  value="" style="display:none">请选择</option>

                            <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 
                                if($changeOption != array()){

                                    if($changeOption['TubulationID'] == $v10['id']){

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
                                if($changeOption != array()){

                                    if($changeOption['TubulationID'] == $v12['id']){

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
      				<div class="am-input-group am-input-group-sm">
                        <?php
                        if($changeOption != array()){
                            $UserName = $changeOption['UserName'];
                        }else{
                            $UserName = '';
                        }
                     ?>
      				  <input type="text" class="am-form-field" name="UserName" value="<?php echo $UserName; ?>">
      				</div>
      			  </td>

                <td>
                    <div class="am-input-group am-input-group-sm" style="width:210px;">
                            <?php
                        if($changeOption != array()){
                            $DateStart = $changeOption['DateStart'];
                            $DateEnd = $changeOption['DateEnd'];
                        }else{
                            $DateStart = '';
                            $DateEnd = '';
                        }
                     ?>
                        <div class="am-u-sm-6" style="padding:0;">
                            <input style="width:100px;" name="DateStart" value="<?php echo $DateStart; ?>" type="text" class="am-form-field" data-am-datepicker />
                        </div>
                        <div class="am-u-sm-6" style="padding:0;">
                            <input style="width:100px;" name="DateEnd" value="<?php echo $DateEnd; ?>" type="text" class="am-form-field" data-am-datepicker />
                        </div>
                    </div>
                </td>
                <td><div style="width:100px;"></div></td>
      			  <td>
                <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a id="clearBanInfo" class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/ChangeAudit/index.html"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
         </form>
		<!---查询-->

       <?php foreach($changeLst as $k => $v){ ;

          if(in_array($v['ProcessRoleID'],$useRoles)){

          $IfProcess = '';

          }else{

          $IfProcess = 'not-process';
          }

        ?>
          <tr class="check001">
              <td>
                <span class="piaochecked">
                  <input name="ID" class="checkId radioclass" type="radio" value="<?php echo $v['ChangeOrderID']; ?>" />
                </span>
              </td>
              <td><?php echo ++$k; ?></td>
              <td><?php echo $v['ChangeOrderID']; ?></td>
              <!--<td class="am-hide-sm-only"><?php echo $v['HouseID']; ?></td>-->
              <td class="am-hide-sm-only"><?php echo $v['ChangeType']; ?></td>
              <td class="am-hide-sm-only"><?php echo $v['InstitutionID']; ?></td>
              <td class="am-hide-sm-only"><?php echo $v['UserNumber']; ?></td>
              <td class="am-hide-sm-only"><?php echo $v['CreateTime']; ?></td>
              <td class="am-hide-sm-only"><?php echo $v['Status']; ?></td>
              <td>
                  <div class="am-btn-group am-btn-group-xs">
                      <?php if(in_array(368,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-text-primary am-btn-xs details details_btn am-hide-sm-only BtnDetail" value="<?php echo $v['ChangeOrderID']; ?>">明细</button>
                      <?php }; if(in_array(369,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnApprove <?php echo $IfProcess; ?>" value="<?php echo $v['ChangeOrderID']; ?>">审批</button>
                      <?php }; ?>
                  </div>
              </td>
          </tr>
         <?php }; ?>

          </tbody>
        </table>
          <div class="am-cf">
              共<?php echo $changeLstObj->total(); ?>条记录
              <div class="am-fr">
                  <?php echo $changeLstObj->render(); ?>
              </div>
          </div>
      </div>
    </div>
  </div>
  <!-- content end -->
  <!-- 租金减免||break、空租、暂停计租||pause、陈欠核销||WriteOff、注销||cancel --> 
<form id="approveForm" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-4">
      <label class="label_style" id="SerialNumber">房屋编号：</label>
    </div>
     <label class="p_style APhouseId"></label>
  </div>
  <div class="am-form-group am-u-md-6 LHide">
    <div class="am-u-md-4">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style APBanID"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">房屋地址：</label>
    </div>
     <label class="p_style APhouseAddress"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼层：</label>
    </div>
     <label class="p_style APFloorID"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">承租人：</label>
    </div>
     <label class="p_style APtenantName"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">联系电话：</label>
    </div>
     <label class="p_style APtenantTel"></label>
  </div>
    <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">身份证号：</label>
    </div>
     <label class="p_style APtenantNumber"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-4">
      <label class="label_style">备案时间：</label>
    </div>
    <div class="am-u-md-8" style="padding-right: 0">
     <label class="p_style APcreateTime"></label>
   </div>
  </div>
  <div class="am-form-group am-u-md-4 Uhide">
    <div class="am-u-md-6">
      <label class="label_style">使用面积：</label>
    </div>
     <label class="p_style APhouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">产别：</label>
    </div>
     <label class="p_style AownerType"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">计租面积：</label>
    </div>
     <label class="p_style APleasedArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">月租金：</label>
    </div>
     <label class="p_style HousePrerent"></label>
  </div>

<!--   <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">应收租金：</label>
    </div>
     <label class="p_style MuchMonth"></label>
  </div> -->
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免金额：</label>
    </div>
     <label class="p_style RemitRent"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免类型：</label>
    </div>
     <label id="breakType" class="p_style"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免时长：</label>
    </div>
     <label class="p_style MuchMonth"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">证件号：</label>
    </div>
     <label id="IDNumber" class="p_style"></label>
  </div>

  <!--<div class="am-form-group am-u-md-12 pause">-->
    <!--<div class="am-u-md-2">-->
      <!--<label class="label_style">暂停类型：</label>-->
    <!--</div>-->
     <!--<label id="pauseType"></label>-->
  <!--</div>-->

  <div class="am-form-group am-u-md-12 WriteOff">
    <div class="am-u-md-2">
      <label class="label_style">核销起始时间：</label>
    </div>
     <label class="WriteOffStartTime">拆迁注销</label>
  </div>
  <div class="am-form-group am-u-md-12 WriteOff">
    <div class="am-u-md-2">
      <label class="label_style">核销结束时间：</label>
    </div>
     <label class="WriteOffEndTime">拆迁注销</label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="layer-photos-demo" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="approveState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--- 租金减免、空租、暂停计租、陈欠核销、注销结束 -->


<!-- 维修异动 -->
<form id="repairChange" class="am-form" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">楼栋编号：</label>
    </div>
    <label id="RCBanID"></label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-4">
      <label class="label_style">房屋地址：</label>
    </div>
      <label id="RCBanAddress"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">异动原因：</label>
    </div>
      <label class="label_style" id="RCReason"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">维修类型：</label>
    </div>
    <label id="RCRepairType"></label>
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">异动前：</label>
    </div>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">使用性质：</label>
    </div>
     <label id="OldUseNature"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">产别：</label>
    </div>
     <label id="OldOwnerType"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">栋数：</label>
    </div>
     <label id="OldBanUnitNum"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">层次：</label>
    </div>
     <label id="OldBanFloorNum"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">结构：</label>
    </div>
     <label id="OldStructure"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">占地面积：</label>
    </div>
     <label id="OldCoveredArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建筑面积：</label>
    </div>
     <label id="OldTotalArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">完损等级：</label>
    </div>
     <label id="OldDamageGrade"></label>
  </div>
 
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">异动后：</label>
    </div>
  </div>

  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">使用性质：</label>
    </div>
     <label id="UseNature"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">产别：</label>
    </div>
     <label id="OwnerType"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">栋数：</label>
    </div>
     <label id="BanUnitNum"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">层次：</label>
    </div>
     <label id="BanFloorNum"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">结构：</label>
    </div>
     <label id="Structure"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">占地面积：</label>
    </div>
     <label id="CoveredArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建筑面积：</label>
    </div>
     <label id="TotalArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">完损等级：</label>
    </div>
     <label id="DamageGrade"></label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="RepairPhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="RepairState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--- 维修异动结束 -->

<!--房屋调整-->
<form id="houseAdjust" class="am-form" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-md-12 Ehide">
    <div class="am-u-md-3">
      <label for="doc-vld-email-2" class="label_style">房屋编号：</label>
    </div>
      <label class="HouseID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
    </div>
     <label class="BanID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">房屋地址：</label>
    </div>
     <label class="BanAddress"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">楼层：</label>
    </div>
     <label class="FloorID"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ehide">
    <div class="am-u-md-6">
      <label class="label_style">承租人：</label>
    </div>
     <label class="TenantName"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ehide">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">联系电话：</label>
    </div>
     <label class="TenantTel"></label>
  </div>
  
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">备案时间：</label>
    </div>
     <label class="CreateTime"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ehide">
    <div class="am-u-md-6">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="HouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ehide">
    <div class="am-u-md-6">
      <label class="label_style">计租面积：</label>
    </div>
     <label class="LeasedArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">完损等级：</label>
    </div>
     <label class="DamageGrade"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建筑结构：</label>
    </div>
     <label class="StructureType"></label>
  </div>
  <div class="am-form-group am-u-md-6 Ehide">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">身份证号：</label>
    </div>
     <label class="TenantID"></label>
  </div>
 <div class="am-form-group am-u-md-12 Dhide">
    <div class="am-u-md-2">
      <label>完损等级变更：</label>
    </div>
    <label class="DamageGradeChange">没找到数据</label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="AdjustPhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="AdjustState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--房屋调整结束 -->
<!-- 房改开始 -->
<form id="HouseChange" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">房屋编号：</label>
    </div>
     <label class="p_style CHouseId">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style CBanID">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋地址：</label>
    </div>
     <label class="p_style CHouseAddress">我家达数千</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼层：</label>
    </div>
     <label class="p_style CFloor">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">承租人：</label>
    </div>
     <label class="p_style CTenantName">冬冬</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">联系电话：</label>
    </div>
     <label class="p_style CTenantTel">010203040506</label>
  </div>
    <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">身份证号：</label>
    </div>
     <label class="p_style CTenantNumber">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="p_style CArea">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">计租面积：</label>
    </div>
     <label class="p_style CLeasedArea">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">产别：</label>
    </div>
     <label class="p_style CType">自管产</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">使用性质：</label>
    </div>
     <label class="p_style CUseProp">住宅</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋结构：</label>
    </div>
     <label class="p_style CHouseStructure">砖混一等</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建成年份：</label>
    </div>
     <label class="p_style CBuiltYear">9527</label>
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">产别：</label>
    </div>
     <label class="CType">自管产</label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="ChangePhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="ChangeState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!-- 房改结束 -->

<!-- 新发租开始(楼栋) -->
<div id="NLBan" class="am-form" style="display:none;margin-top:1.6rem;">

    <fieldset style="width:900px;">
    <div class="am-u-md-12" style="margin-bottom:20px;font-weight:bold;font-size:24px">楼栋信息</div>
    <div class="am-u-md-6">
    
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
        <div class="am-u-md-8">
        <p class="detail_p_style" id="BanID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-2" class="label_style">机构名称：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TubulationID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">产权证号：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanPropertyID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-4" class="label_style">完损等级：</label>
        <div  class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="DamageGrade1">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">是否改造产：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="ReformIf">加载中</p>
        </div>
      </div>  

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">土地证号：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanLandID">加载中</p>
        </div>
      </div>      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">不动产证号：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFreeholdID">加载中</p>
        </div>
      </div>  
        
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">总产数：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TotalHouseHolds">加载中</p>
        </div>
      </div>  
<!--暂无相关信息-->
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">附属设施：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="SubsidiaryFacility">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">规定租金：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="PreRent">加载中</p>
        </div>
      </div>
      
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">楼栋地址：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanAddress">加载中</p>
        </div>
      </div>    
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">产权来源：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="PropertySource">加载中</p>
        </div>
      </div>        
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">楼栋产别：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="OwnerType"></p>
        </div>
      </div>
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">拆迁状态：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="RemoveStatus">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">文物保护单位：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="ProtectculturalIf">加载中</p>
        </div>
      </div>  
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">产权是否分割：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="CutIf">加载中</p>
        </div>
      </div>
      <div class="am-form-group am-u-md-12">
        <label for="imgReload" class="label_style">影像资料：</label>
      </div>
      <div class="am-form-group am-u-md-12">
          <img class="am-form-group am-u-md-12" id="BanImageIDS" src="" style="width:300px;height:150px;">
      </div>
      
    </div>
<!--左右分割-->   
    <div class="am-u-md-6">
      <div class="am-form-group am-u-md-12">

        <label for="doc-select-5" class="label_style">产别：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="OwnerTypex">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">建成年份：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanYear">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-7" class="label_style">使用性质：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="UseNaturex">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">结构类别：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="StructureTypex">加载中</p>
        </div>
      </div>
      <!--新加-->
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">单元数量：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanUnitNum">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">楼层数量：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFloorNum">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">起始楼层：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFloorStart">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">机构：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TubulationID">加载中</p>
        </div>
      </div>  
    
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">楼栋维护费：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanRepairCost">加载中</p>
        </div>
      </div>  

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-name-2" class="label_style">企业建面：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style"  id="EnterpriseArea">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">机关建面：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style"  id="PartyArea">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-url-2" class="label_style">民用建面：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style"  id="CivilArea">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">合计建面：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="TotalArea">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">使用面积：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanUsearea">加载中</p>
        </div>
      </div>
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">历史优秀建筑：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="HistoryIf">加载中</p>
        </div>
      </div>      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">经纬度：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanGpsXY">加载中</p>
        </div>
      </div>
      <div class="am-form-group am-u-md-12" id="allMap" style="border:1px solid red;height:280px;">

      </div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-12"><h2>房屋信息</h2></div>
        <ul class="am-u-md-12">
            <li class="am-u-md-3">房屋编号</li>
            <li class="am-u-md-3">租户</li>
            <li class="am-u-md-6">房屋状态</li>
        </ul>
        <ul>
          <li class="am-u-md-3">10400188880001</li>
          <li class="am-u-md-3">张三</li>
          <li class="am-u-md-3">未确认</li>
          <li class="am-u-md-3">明细</li>
        </ul>
    </div><!--房屋-->
    <div class="am-u-md-12">
       <div class="am-u-md-12"><h2>房间信息</h2></div>
        <ul class="am-u-md-12">
            <li class="am-u-md-3">房屋编号</li>
            <li class="am-u-md-3">房间编号</li>
            <li class="am-u-md-6">房间状态</li>
        </ul>
        <ul>
          <li class="am-u-md-3">10400188880001</li>
          <li class="am-u-md-3">张三</li>
          <li class="am-u-md-3">未确认</li>
          <li class="am-u-md-3">明细</li>
        </ul>
    </div>
      <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="AdjustPhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="AdjustState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
    <div id="approveBan" class="am-u-md-12" style="padding-left:3rem;"></div>
    </fieldset>
  </div>
<!-- 新发租结束(楼栋) -->

<!-- 新发租开始(房屋) -->
<div id="NLHouse" class="am-form" style="display:none;margin-top:1.6rem;">

    <fieldset style="width:900px;">
    <div class="am-u-md-6">
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">房屋编号：</label>
        <div class="am-u-md-8">
        <p class="detail_p_style" id="NLHouseID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-2" class="label_style">单元号</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TubulationID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">楼层号：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanPropertyID">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-4" class="label_style">产权证号：</label>
        <div  class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="DamageGrade">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">门牌号码：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="ReformIf">加载中</p>
        </div>
      </div>  

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">使用面积：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanLandID">加载中</p>
        </div>
      </div>      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">是否住改非：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFreeholdID">加载中</p>
        </div>
      </div>  
        
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">计租面积：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TotalHouseHolds">加载中</p>
        </div>
      </div>  
<!--暂无相关信息-->
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">规定租金：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="SubsidiaryFacility">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">应收租金：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="PreRent">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">减免租金：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanAddress">加载中</p>
        </div>
      </div>    
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-age-2" class="label_style">房屋影像：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="PropertySource">加载中</p>
        </div>
      </div>
    </div>
<!--左右分割-->   
    <div class="am-u-md-6">
      <div class="am-form-group am-u-md-12">

        <label for="doc-select-5" class="label_style">使用性质：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="OwnerType">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-email-2" class="label_style">泵费：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style" id="BanYear">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-7" class="label_style">维修费：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="UseNature">加载中</p>
        </div>
      </div>

      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">计算原价：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="StructureType">加载中</p>
        </div>
      </div>
      <!--新加-->
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">实际原价：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanUnitNum">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">租户姓名：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFloorNum">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">欠租情况：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanFloorStart">加载中</p>
        </div>
      </div>
      
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">欠租原因：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="TubulationID">加载中</p>
        </div>
      </div>  
    
      <div class="am-form-group am-u-md-12">
        <label for="doc-select-8" class="label_style">户建面：</label>
        <div class="am-u-md-8" style="float:left;">
          <p class="detail_p_style" id="BanRepairCost">加载中</p>
        </div>
      </div>  

      <div class="am-form-group am-u-md-12">
        <label for="doc-vld-name-2" class="label_style">套内建面：</label>
        <div class="am-u-md-8">
          <p class="detail_p_style"  id="EnterpriseArea">加载中</p>
        </div>
      </div>
    </div>

    <div class="am-form-group am-u-md-12">
       <label class="label_style">房屋信息：</label>
    </div>
    <div class="am-form-group am-u-md-12">
       <div class="am-u-md-4">房屋编号</div>
       <div class="am-u-md-4">租户</div>
       <div class="am-u-md-4">明细</div>
    </div>
    <div class="am-form-group am-u-md-12">
       <div class="am-u-md-4">1230666</div>
       <div class="am-u-md-4">张珊</div>
       <div class="am-u-md-4">查看</div>
    </div>

    </fieldset>
  </div>
<!-- 新发租结束(房屋) -->

<!--管段调整开始-->
<form id="PipeAdjusted" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style PipeAdjustedBan">楼栋编号：</label>
    </div>
     <label class="p_style PipeBanId"></label>
  </div>
  <div id="PipeAdjustBan">
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋地址：</label>
    </div>
     <label class="p_style PipeHouseAddress"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">使用性质：</label>
    </div>
     <label class="p_style PipeUseNature"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">产别：</label>
    </div>
     <label class="p_style PipeType"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">栋数：</label>
    </div>
     <label class="p_style PipeUnitNumber"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">层次：</label>
    </div>
     <label class="p_style PipeFloorID"></label>
  </div>
    <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">结构：</label>
    </div>
     <label class="p_style PipeStructure"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="p_style PipeHouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">完损等级：</label>
    </div>
     <label class="p_style PipeDamageGrade"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">占地面积：</label>
    </div>
     <label class="p_style PipeCorverArea"></label>
  </div>
</div>
<div id="PipeAdjustHouse" style="display:none">
   <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label id="PipeBanNumd"></label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label for="doc-vld-email-2" class="label_style">房屋地址：</label>
    </div>
     <label id="PipeHouseAddressd"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">楼层：</label>
    </div>
     <label id="PipeLayerd"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">承租人：</label>
    </div>
     <label id="PipeRenterd"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label for="doc-vld-email-2" class="label_style">联系电话：</label>
    </div>
     <label id="PipePhoneNumd"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">身份证：</label>
    </div>
     <label id="PipeIDd"></label>
  </div>

  <div class="am-form-group am-u-md-8">
    <div class="am-u-md-3">
      <label for="doc-vld-email-2" class="label_style">备案时间：</label>
    </div>
     <label id="PipeTimed"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-8">
      <label class="label_style">建筑面积：</label>
    </div>
     <label id="PipeBulid"></label>
  </div>
  <div class="am-form-group am-u-md-4" style="float:left">
    <div class="am-u-md-7">
      <label class="label_style">计租面积：</label>
    </div>
    <label id="PipeRentArea"></label>
  </div> 
</div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">原管段：</label>
    </div>
     <label id="OldPipe"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">调整后管段：</label>
    </div>
     <label id="NewPipe"></label>
  </div>
  
  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="PipePhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="PipeState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--管段调整结束-->

<!-- 追加调整开始 -->
<form id="AddAdjusted" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">房屋编号：</label>
    </div>
     <label class="p_style AddHouseID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style AddBanID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋地址：</label>
    </div>
     <label class="p_style AddBanAddress"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼层：</label>
    </div>
     <label class="p_style AddFloorID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">承租人：</label>
    </div>
     <label class="p_style AddTenantName"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">联系电话：</label>
    </div>
     <label class="p_style AddTenantTel"></label>
  </div>
    <div class="am-form-group am-u-md-4">
    <div class="am-u-md-4">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="p_style AddHouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-4">
      <label class="label_style">备案时间：</label>
    </div>
     <label class="p_style AddCreateTime"></label>
  </div>
  
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">计租面积：</label>
    </div>
     <label class="p_style AddLeasedArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">身份证号：</label>
    </div>
     <label class="p_style AddTenantNumber"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">追加起始时间：</label>
    </div>
     <label id="AddTime"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">追加金额：</label>
    </div>
     <label id="AddMoney"></label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="AddPhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="AddState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!-- 追加调整结束-->
<form id="RentAdjust" class="am-form" style="display:none;margin-top:20px;">
    <div class="am-form-group am-u-md-12">
    <div class="am-u-md-4">
      <label  class="label_style">房屋编号：</label><label id="AdjustHouseNum"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label>楼栋编号：</label><label id="AdjustBanID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>房屋地址：</label><label id="AdjustBanAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>楼层：</label><label id="AdjustFloorID"></label>
    </div>
<!--     <div class="am-form-group am-u-sm-4">
      <label>房型：</label><label id="">5</label>
    </div> -->
    <div class="am-form-group am-u-sm-4">
      <label>承租人：</label><label id="AdjustTenantName"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>联系电话：</label><label id="AdjustTenantTel"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>身份证号：</label><label id="AdjustTenantNumber"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>备案时间：</label><label id="AdjustCreateTime"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>使用面积：</label><label id="AdjustHouseArea"></label>
    </div>
    
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>计租面积：</label><label id="AdjustLeasedArea"></label>
    </div>
    <div class="am-u-md-12">
      <div class="am-form-group am-u-sm-4 pd0">
      <label>产别：</label><label class="AdjustOwnType"></label>
      </div>
      <div class="am-form-group am-u-sm-8 mr0">
        <label>原租金：</label><label id="AdjustPrice"></label>
      </div>
      <div class="am-form-group am-u-sm-4 pd0">
        <label>产别：</label><label class="AdjustOwnTypeA"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label>原租金：</label><label id="AdjustPriceA"></label>
      </div>
    </div>
    <div class="am-u-md-12">
      <div class="am-form-group am-u-sm-4 pd0">
      <label>产别：</label><label class="AdjustOwnType"></label>
      </div>
      <div class="am-form-group am-u-sm-4 mr0" style="float:left">
        <label class="am-u-sm-3"  style="padding:0">原租金：</label><label id="AdjustNewPrice"></label>
      </div>
      </div>
      <div class="am-u-md-12">
      <div class="am-form-group am-u-sm-4 pd0">
        <label>产别：</label><label class="AdjustOwnTypeA"></label>
      </div>
       <div class="am-form-group am-u-sm-4 mr0" style="float:left">
        <label class="am-u-sm-3"  style="padding:0">原租金：</label><label id="AdjustNewPriceA"></label>
      </div>
    </div>
  </div><!--房屋编号-->
   <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="AddRentAdjust" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="AddRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--租金调整 -->
<!--分户-->
  <form id="SplitHouse" class="am-form" style="display:none;margin-top:20px;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6"  style="font-weight:bold">
      分户原始房屋
    </div>
    </div>
    <div class="am-form-group am-u-md-12">
    <div class="am-u-md-12">
      <label  class="label_style">房屋编号：</label><label id="SplitHouseID"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 mr0">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label>楼栋编号：</label><label id="SplitBanID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>房屋地址：</label><label id="SplitBanAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>楼层：</label><label id="SplitFloorID"></label>
    </div>
<!--     <div class="am-form-group am-u-sm-4">
      <label>房型：</label><label id="">5</label>
    </div> -->
    <div class="am-form-group am-u-sm-4">
      <label>承租人：</label><label id="SplitTenantName"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>联系电话：</label><label id="SplitTenantTel"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>身份证号：</label><label id="SplitTenantNumber"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>备案时间：</label><label id="SplitCreateTime"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>使用面积：</label><label id="SplitHouseArea"></label>
    </div>
    
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>计租面积：</label><label id="SplitLeasedArea"></label>
    </div> 
    <div class="am-form-group am-u-sm-12 am-u-end">
      <label class="fl">房间间号：</label>
      <ul class="SplitRoom">
        
      </ul>
    </div>
    
  </div><!--房屋编号-->
    <!--分户新增房屋-->
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6"  style="font-weight:bold">
      分户新增房屋
    </div>
    </div>
    <div class="am-form-group am-u-md-12">
    <div class="am-u-md-12">
      <label  class="label_style">房屋编号：</label><label id="SplitAddNum"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 mr0">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label>楼栋编号：</label><label id="SplitAddID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>房屋地址：</label><label id="SplitAddAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>楼层：</label><label id="SplitAddFloor"></label>
    </div>
<!--     <div class="am-form-group am-u-sm-4">
      <label>房型：</label><label id="">5</label>
    </div> -->
    <div class="am-form-group am-u-sm-4">
      <label>承租人：</label><label id="SplitAddName"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>联系电话：</label><label id="SplitAddTel"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>身份证号：</label><label id="SplitAddNumber"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>备案时间：</label><label id="SplitAddTime"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>使用面积：</label><label id="SplitAddArea"></label>
    </div>
    
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>计租面积：</label><label id="SplitAddLeased"></label>
    </div>  
     <div class="am-form-group am-u-sm-12 am-u-end">
      <label class="fl">房间间号：</label>
      <ul class="SplitRoom2">
       
      </ul>
    </div>
  </div>
   <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="SplitFile" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="SplitFileState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--分户结束-->
<!--并户-->
<form id="HouseHolds" class="am-form" style="display:none;margin-top:20px;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6"  style="font-weight:bold">
      并户保留房屋
    </div>
    </div>
    <div class="am-form-group am-u-md-12">
    <div class="am-u-md-12">
      <label  class="label_style">房屋编号：</label><label id="HoldsHouseNum"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 mr0">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label>楼栋编号：</label><label id="HoldsBanID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>房屋地址：</label><label id="HoldsBanAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>楼层：</label><label id="HoldsFloorID"></label>
    </div>
<!--     <div class="am-form-group am-u-sm-4">
      <label>房型：</label><label id="">5</label>
    </div> -->
    <div class="am-form-group am-u-sm-4">
      <label>承租人：</label><label id="HoldsTenantName"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>联系电话：</label><label id="HoldsTenantTel"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>身份证号：</label><label id="HoldsTenantNumber"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>备案时间：</label><label id="HoldsCreateTime"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>使用面积：</label><label id="HoldsHouseArea"></label>
    </div>
    
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>计租面积：</label><label id="HoldsLeasedArea"></label>
    </div>  
    <div class="am-form-group am-u-sm-12 am-u-end">
      <label class="fl">房间间号：</label>
      <ul class="HoldRoom">
       
      </ul>
    </div>
  </div><!--房屋编号-->
    <!--并户注销房屋-->
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6"  style="font-weight:bold">
      并户注销房屋
    </div>
    </div>
    <div class="am-form-group am-u-md-12">
     <div class="am-u-md-12">
      <label  class="label_style">房屋编号：</label><label id="CancelNum"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 mr0">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label>楼栋编号：</label><label id="CancelID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>房屋地址：</label><label id="CancelAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>楼层：</label><label id="CancelFloor"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>承租人：</label><label id="CancelName"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label>联系电话：</label><label id="CancelTel"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>身份证号：</label><label id="CancelNumber"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>备案时间：</label><label id="CancelTime"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>使用面积：</label><label id="CancelArea"></label>
    </div>
    
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label>计租面积：</label><label id="CancelLeased"></label>
    </div>  
    <div class="am-form-group am-u-sm-12 am-u-end">
      <label class="fl">房间间号：</label>
      <ul class="HoldRoom2">
       
      </ul>
    </div>
  </div>
   <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="HouseHoldsFile" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="HouseHoldsState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--并户结束-->
  <div id="banDetail" class="am-form" style="display:none;margin-top:1.6rem;">

    <fieldset>
       <div class="am-u-md-12" style="margin-bottom:20px;font-weight:bold;font-size:24px">楼栋信息</div>
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
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">拆迁状态：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="RemoveStatus"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="label_style">影像资料：</label>
            </div>
            <img class="am-form-group am-u-md-12" id="detailImgThree" src=""
                 style="width:310px;height:150px;float:left;">
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
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">经纬度：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanGpsXY"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12" id="allMapd" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;">

            </div>
           <ol id="Drecord" style="float: left;">
               
           </ol>

        </div>
        <div class="am-u-md-12">
        <div class="am-u-md-12"><h2>房屋信息</h2></div>
        <ul class="am-u-md-12 HouseDetail">
            <li class="am-u-md-6">房屋编号</li>
            <li class="am-u-md-2">租户</li>
            <li class="am-u-md-2" style="float:left">房屋状态</li>
        </ul>
        <ul class="HousedCopy" style="display:none">
          <li class="am-u-md-6" style="height:25px"></li>
          <li class="am-u-md-2" style="height:25px"></li>
          <li class="am-u-md-2" style="height:25px"></li>
          <li class="am-u-md-2 am-text-secondary cur" >明细</li>
        </ul>
    </div><!--房屋-->
    <div class="am-u-md-12 ARoomS">
       <div class="am-u-md-12"><h2>房间信息</h2></div>
        <ul class="am-u-md-12 RoomDetail">
            <li class="am-u-md-6">房屋编号</li>
            <li class="am-u-md-2">房间编号</li>
            <li class="am-u-md-2" style="float:left">房间状态</li>
        </ul>
        <ul class="RoomCopy" style="display:none">
          <li class="am-u-md-6" style="height:25px"></li>
          <li class="am-u-md-2" style="height:25px"></li>
          <li class="am-u-md-2" style="height:25px"></li>
          <li class="am-u-md-2 am-text-secondary cur">明细</li>
        </ul>
        <div class="ManyRoom">
            
        </div>
    </div>
     <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="NewRentPhotos" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="NewRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
    </fieldset>
</div>
  <div id="AdjustDetail" class="am-form" style="display:none;margin-top:1.6rem;">

	<table class="am-table am-table-striped am-table-hover am-table-centered">
			<colgroup>
			    <col width="150">
			    <col width="200">
			    <col>
			</colgroup>
            <thead>
              <tr>
        			<th class="table-title">原始数据</th>
        			<th class="table-author am-hide-sm-only">现有数据</th>
        			<th class="table-date am-hide-sm-only">名称</th>
              </tr>
          </thead>
          <tbody id="tbo">
              <tr class="am-form-group am-form-inline am-form tableCopy" style="display:none">
                <td></td>
                <td></td>
                <td></td>
              </tr>
          </tbody>
        </table>
  </div>

  <form  id="RoomDetail" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">
	  <fieldset id="InputForm" style="width:780px;">
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">房间间号：</label>
				<div class="am-u-md-8">
					<label id="RoomNumber"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">绑定楼栋：</label>
				<div class="am-u-md-8">
					<label id="DBanID"></label>
				</div>
			</div>	
				
			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">完损等级：</label>
				<div class="am-u-md-8">
					<label class="LossLevel">完好</label>
				</div>
			</div>	

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">房屋结构：</label>
				<div class="am-u-md-8">
					<label class="BuildStructure">砖混一等</label>
				</div>
			</div> -->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼栋地址：</label>
				<div class="am-u-md-8">
					<label class="BanAddress"></label>
				</div>
			</div>	
			<div class="am-form-group am-u-md-12">
			  	<label>3户及以上共用房间</label>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label>绑定房屋(3户以上共用无需填写)：</label>
			</div>
			<div class="am-form-group am-u-md-6 am-u-end">
				<label id="DHouseID"></label>
			</div>
		</div>
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">选择房间类型：</label>
				<div class="am-u-md-8">
					<label id="DRoomType"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元号：</label>
				<div class="am-u-md-8">
					<label id="DUnitID"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">层次：</label>
				<div class="am-u-md-8">
					<label id="DFloorID"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">基价折减：</label>
				<div class="am-u-md-8" data-am-validator>
					<label id="DItems"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">折减率：</label>
				<div class="am-u-md-8">
					<label id="DRentPoint"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">使用面积：</label>
				<div class="am-u-md-8">
					<label id="DUseArea"></label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">计租面积：</label>
				<div class="am-u-md-8">
					<label id="DLeasedArea"></label>
				</div>
			</div>
		</div>
	  </fieldset>
</form>

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

<script src="http://api.map.baidu.com/api?v=2.0&ak=2xlodrKVRyFNeopCajiMTfgIOr8dnUAe"></script>
<script type="text/javascript" src="/public/static/gf/js/DFileUpload.js"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/change_audit.js"></script>

</body>
</html>