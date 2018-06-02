<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:60:"D:\phpStudy\WWW\ph/application/ph\view\user_audit\index.html";i:1527503117;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1527835358;s:40:"application/ph/view/user_audit/form.html";i:1527836110;s:47:"application/ph/view/user_audit/approveForm.html";i:1527836110;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>使用权变更审核</title>
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
        <div class="am-fl am-cf"><small class="am-text-sm">使用权变更</small> >
            <small class="am-text-primary">使用权变更审核</small>
        </div>
    </div>

    <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
            <div class="am-btn-toolbar">
                <?php if(in_array(88,$threeMenu)){; ?>
                <div class="am-btn-group-xs">
                    <button type="button" id="addInfo" class="am-btn d-btn-1188F0"><span class="am-icon-edit"></span> 补充资料
                    </button>
                </div>
                <?php }; ?>
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
                    <th class="table-title">变更编号</th>
                    <th class="table-type">房屋编号</th>
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
                <form action="<?php echo url('UserAudit/index'); ?>" method="post">
                    <tr class="am-form-group am-form-inline am-form">
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
                            <input style="width:122px;" type="text" name="ChangeOrderID" class="am-form-field" value="<?php echo $ChangeOrderID; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="am-input-group am-input-group-sm">
                                <?php
                            if($changeOption != array()){
                                $HouseID = $changeOption['HouseID'];
                            }else{
                                $HouseID = '';
                            }
                         ?>
                            <input style="width:122px;" type="text" name="HouseID" class="am-form-field" value="<?php echo $HouseID; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="am-form-group search_input">
                                <select name="ChangeType" id="doc-select-5">
                                    <option value="" style="display:none">请选择</option>
                                    <?php foreach($useChanges as $k3 =>$v3){;
                                if($changeOption != array()){

                                    if($changeOption['ChangeType'] == $v3['id']){

                                        $select ='selected';
                                    }else{

                                        $select ='';
                                    }
                                }else{

                                    $select ='';
                                }

                                ?>

                                    <option value="<?php echo $v3['id']; ?>"
                                            <?php echo $select; ?>><?php echo $v3['UseChangeTitle']; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="am-form-group search_input">


                                <?php if(session('user_base_info.institution_level')!=3){ ;?>
                                <select name="TubulationID" id="doc-select-2">
                                    <option value="" style="display:none">请选择</option>

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

                                    <option value="<?php echo $v10['id']; ?>"
                                            <?php echo $select; ?>><?php echo $v10['Institution']; ?></option>

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

                                    <option value="<?php echo $v12['id']; ?>"
                                            <?php echo $select; ?>><?php echo $v12['Institution']; ?></option>

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
                                <input type="text" name="UserName" class="am-form-field" value="<?php echo $UserName; ?>">
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
                                    <input style="width:100px;" name="DateStart" value="<?php echo $DateStart; ?>" type="text" class="am-form-field" data-am-datepicker value="">
                                </div>
                                <div class="am-u-sm-6" style="padding:0;">
                                    <input style="width:100px;" name="DateEnd" value="<?php echo $DateEnd; ?>" type="text" class="am-form-field" data-am-datepicker value="">
                                </div>
                            </div>
                        </td>
                        <td><div style="min-width:110px;"></div></td>
                        <td>
                            <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                                <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                                <a id="clearUserApplyInfo" class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/UserAudit/index.html"><span class="ResetIcon"></span>重置</a>
                            </div>
                        </td>
                    </tr>
                </form>
                <!---查询-->

                <?php foreach($changeLst as $k1 => $v1){

                    if(in_array($v1['ProcessRoleID'],$useRoles)){

                    $IfProcess = '';

                    }else{

                    $IfProcess = 'not-process';
                    }

                ;?>
                <tr class="check001">
                    <td>
                        <span class="piaochecked">
                            <input name="ID" class="checkId radioclass" type="radio" value="<?php echo $v1['ChangeOrderID']; ?>"/></td>
                        </span>
                    <td><?php echo ++$k1; ?></td>
                    <td><?php echo $v1['ChangeOrderID']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v1['HouseID']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v1['ChangeType']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v1['InstitutionID']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v1['UserNumber']; ?></td>
                    <td><?php echo $v1['CreateTime']; ?></td>
                    <td><?php echo $v1['Status']; ?></td>
                    <td>
                        <div class="am-btn-group am-btn-group-xs">
                            <?php if(in_array(90,$threeMenu)){; ?>
                            <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnApprove <?php echo $IfProcess; ?>"
                                    value="<?php echo $v1['ChangeOrderID']; ?>">审批
                            </button>
                            <?php }; if(in_array(89,$threeMenu)){; ?>
                            <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnDetail "
                                    value="<?php echo $v1['ChangeOrderID']; ?>">查看明细
                            </button>
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
<form id="addForm" style="margin-top:1.6rem;display:none;">
    <div class="am-form-group am-u-md-12">
        <h2 class="label_title">基本信息：</h2>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">房屋编号：</label>
        <label class="label_p_style houseId"></label>
    </div>
    <div class="am-form-group am-u-md-8">
        <label class="label_style">房屋地址：</label>
        <label class="label_p_style houseAddress" style="width:484px;"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">楼层：</label>
        <label class="label_p_style FloorID"></label>
    </div>

    <div class="am-form-group am-u-md-4">
        <label class="label_style">承租人：</label>
        <label class="label_p_style tenantName"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">联系电话：</label>
        <label class="label_p_style tenantTel"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">身份证号：</label>
        <label class="label_p_style tenantNumber"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">实有面积：</label>
        <label class="label_p_style houseArea"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">计租面积：</label>
        <label class="label_p_style leasedArea"></label>
    </div>

    <div class="am-form-group am-u-md-4">
        <label class="label_style">申请类型：</label>
        <label id="TypeName" class="label_p_style">更名</label>
    </div>
    <div class="am-form-group am-u-md-4" >
        <label class="label_style" >备案时间：</label>
        <label class="label_p_style createTime"></label>
    </div>

    <div class="am-form-group am-u-md-12">
        <h2 class="label_title">产权户籍情况：</h2>
    </div>

    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>1、是否属代、托、改造产</p>
        </div>
        <div class="am-u-md-7">
            <label class="am-radio-inline">
                <input type="radio" value="1" name="IfReform" required> 是
            </label>
            <label class="am-radio-inline">
                <input type="radio" value="0" name="IfReform" checked="checked" > 否
            </label>
        </div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>2、是否是五年内新翻覆修房屋</p>
        </div>
        <div class="am-u-md-7">
            <label class="am-radio-inline">
                <input type="radio" value="1" name="IfRepair" required> 是
            </label>
            <label class="am-radio-inline">
                <input type="radio" value="0" name="IfRepair" checked="checked"  > 否
            </label>
        </div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>3、是否属于征收范围内房屋</p>
        </div>
        <div class="am-u-md-7">
            <label class="am-radio-inline">
                <input type="radio" value="1" name="IfCollection" required> 是
            </label>
            <label class="am-radio-inline">
                <input type="radio" value="0" name="IfCollection" checked="checked"  > 否
            </label>
        </div>
    </div>
    <div class="am-u-md-12" id="addContent">
        <div class="am-u-md-5">
            <p>4、是否属门面营业用房</p>
        </div>
        <div class="am-u-md-7">
            <label class="am-radio-inline">
                <input type="radio" value="1" name="IfFacade" required> 是
            </label>
            <label class="am-radio-inline">
                <input type="radio" value="0" name="IfFacade" checked="checked" > 否
            </label>
        </div>
    </div>

    <!-- 样式一 -->
    <div class="material_1" style="padding-left:0;">
        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">提交材料：</h2>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>更改姓名后户口簿：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="ReBooklet" type="file" name="ReBooklet" multiple>
            </div>
            <div id="Dshow" class="am-u-md-12"></div>
            <!-- <div id="ReBooklet" class="fileUploadContent"></div> -->
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>更改姓名后居民身份证：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="ReIDCard" type="file" name="file2" multiple>
            </div>
            <div id="ReIDCardShow" class="am-u-md-12"></div>
            <!-- <div id="ReIDCard" class="fileUploadContent"></div> -->
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房(民用住宅)租赁合同：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="ReContract" type="file" name="file3" multiple>
            </div>
            <div id="ReContractShow" class="am-u-md-12"></div>
            <!-- <div id="ReContract" class="fileUploadContent"></div> -->
        </div>
    </div>
    <!-- 样式二 -->
    <div class="material_2" style="padding-left:0;">
        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">提交材料：</h2>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnApplicationForm" type="file" name="CnApplicationForm" multiple>
            </div>
            <div id="CnApplicationFormShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人户口簿：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnApBooklet" type="file" name="CnApBooklet" multiple>
            </div>
            <div id="CnApBookletShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人身份证、图章：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnApIDCard" type="file" name="CnApIDCard" multiple>
            </div>
            <div id="CnApIDCardShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房（民用住宅）租赁合同：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnContract" type="file" name="CnContract" multiple>
            </div>
            <div id="CnContractShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>原承租人死亡的，提交死亡证明：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnDeathProve" type="file" name="CnDeathProve" multiple>
            </div>
            <div id="CnDeathProveShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>原承租人户籍迁出本市的，提交户籍注销证明：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnMigProve" type="file" name="CnMigProve" multiple>
            </div>
            <div id="CnMigProveShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>诉讼离婚的，提交人民法院判决书或者调解书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnLitig" type="file" name="CnLitig" multiple>
            </div>
            <div id="CnLitigShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>协议离婚的，提交经民政部门备案的离婚协议书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAgreement" type="file" name="CnAgreement" multiple>
            </div>
            <div id="CnAgreementShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>离婚证：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnDivorce" type="file" name="CnDivorce" multiple>
            </div>
            <div id="CnDivorceShow" class="am-u-md-12"></div>
        </div>

        <div class="am-form-group am-u-md-12">
            <div class="am-u-md-6">
                <label>附件：</label>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件一：公有住房指定承租人协议书（需公证）：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAttachmentOne" type="file" name="file2" multiple>
            </div>
            <div id="CnAttachmentOneShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件二：公有住房过户协议书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAttachmentTwo" type="file" name="CnAttachmentTwo" multiple>
            </div>
            <div id="CnAttachmentTwoShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件三：公有住房承租声明书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAttachmentThr" type="file" name="CnAttachmentThr" multiple>
            </div>
            <div id="CnAttachmentThrShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件四：公有住房承租保证书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAttachmentFour" type="file" name="CnAttachmentFour" multiple>
            </div>
            <div id="CnAttachmentFourShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件五：公有住房承租承诺书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="CnAttachmentFive" type="file" name="CnAttachmentFive" multiple>
            </div>
            <div id="CnAttachmentFiveShow" class="am-u-md-12"></div>
        </div>
    </div>
    <!-- 样式三 -->
    <div class="material_3" style="padding-left:0;">
        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">房屋结构检查：</h2>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>房屋结构查验是否通过</p>
            </div>
            <div class="am-u-md-7">
                <label class="am-radio-inline">
                    <input type="radio" value="1" name="IfCheck" required> 是
                </label>
                <label class="am-radio-inline">
                    <input type="radio" value="0" name="IfCheck" checked="checked"> 否
                </label>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>房屋结构查验情况：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrCheck" type="file" name="TrCheck" multiple>
            </div>
            <div id="TrCheckShow" class="am-u-md-12"></div>
        </div>

        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">提交材料：</h2>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrApplicationForm" type="file" name="TrApplicationForm" multiple>
            </div>
            <div id="TrApplicationFormShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人户口簿：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrApBooklet" type="file" name="TrApBooklet" multiple>
            </div>
            <div id="TrApBookletShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人身份证、图章：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrApIDCard" type="file" name="TrApIDCard" multiple>
            </div>
            <div id="TrApIDCardShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房（民用住宅）租赁合同：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrContract" type="file" name="TrContract" multiple>
            </div>
            <div id="TrContractShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>原承租人死亡的，提交死亡证明：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrDeathProve" type="file" name="TrDeathProve" multiple>
            </div>
            <div id="TrDeathProveShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>经公证的配偶及同户籍近亲同意使用权转让协议书（附件七）：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAgreementOne" type="file" name="TrAgreementOne" multiple>
            </div>
            <div id="TrAgreementOneShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房（民用住宅）使用权转让双方签订的国有公房（民用住宅）使用权转让协议书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAgreementTwo" type="file" name="TrAgreementTwo" multiple>
            </div>
            <div id="TrAgreementTwoShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>承租人与配偶不同户籍的，结婚证</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAgreementThr" type="file" name="TrAgreementThr" multiple>
            </div>
            <div id="TrAgreementThrShow" class="am-u-md-12"></div>
        </div>

        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">附件：</h2>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件六：承诺书</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentOne" type="file" name="TrAttachmentOne" multiple>
            </div>
            <div id="TrAttachmentOneShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件七：同意办理公有住房使用权转让或者代理转让协议书</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentTwo" type="file" name="TrAttachmentTwo" multiple>
            </div>
            <div id="TrAttachmentTwoShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件八 ：武昌区房地产公司房管所直管公房使用权转让备案单</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentThr" type="file" name="TrAttachmentThr" multiple>
            </div>
            <div id="TrAttachmentThrShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件九：协议书</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentFour" type="file" name="TrAttachmentFour" multiple>
            </div>
            <div id="TrAttachmentFourShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件十：同意办理公有住房使用权置换或者代理转让声明书</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentFive" type="file" name="TrAttachmentFive" multiple>
            </div>
            <div id="TrAttachmentFiveShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件十一：同意办理公有住房使用权置换或者代理转让声明书</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="TrAttachmentSix" type="file" name="TrAttachmentSix" multiple>
            </div>
            <div id="TrAttachmentSixShow" class="am-u-md-12"></div>
        </div>
    </div>

    <div class="am-form-group am-u-md-12">
        <h2 class="label_title">审批状态：</h2>
    </div>
    <div id="FormState" class="am-u-md-12">
               <!--  <span class="process_style process_style_active">房管员</span><span class="line_style">——></span>
                <span class="process_style">房调员</span><span>——></span>
                <span class="process_style">所长</span><span>——></span>
                <span class="process_style">总公司科长</span><span>——></span>
                <span class="process_style">经管副总</span> -->
    </div>
    <div class="am-form-group am-u-md-12">
        <!--<label>1.房管员［黄芳］于2017年6月13日提交了使用权变更申请；</label>-->
    </div>
</form>
<form id="approveForm" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-12">
      <h2 class="label_title">基本信息：</h2>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">房屋编号：</label>
      <label class="label_p_style APhouseId"></label>
  </div>

  <div class="am-form-group am-u-md-8">
      <label class="label_style">房屋地址：</label>
      <label class="label_p_style APhouseAddress" style="width:484px;"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">楼层：</label>
     <label class="label_p_style AFloorID"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">承租人：</label>
      <label class="label_p_style APtenantName"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">联系电话：</label>
      <label class="label_p_style APtenantTel"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">身份证号：</label>
      <label class="label_p_style APtenantNumber"></label>
  </div>
  
  <div class="am-form-group am-u-md-4">
      <label class="label_style">使用面积：</label>
      <label class="label_p_style APhouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">计租面积：</label>
      <label class="label_p_style APleasedArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">申请类型：</label>
      <label class="label_p_style" id="approveName"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">备案时间：</label>
     <label class="label_p_style APcreateTime"></label>
  </div>

  <div class="am-form-group am-u-md-12">
      <h2 class="label_title">产权户籍情况：</h2>
  </div>
  <div class="am-u-md-12">
      <div class="am-u-md-5">
          <p>1、是否属代、托、改造产</p>
      </div>
      <div class="am-u-md-7" id="IfReform">
   
      </div>
  </div>
  <div class="am-u-md-12">
      <div class="am-u-md-5">
          <p>2、是否是五年内新翻覆修房屋</p>
      </div>
      <div class="am-u-md-7" id="IfRepair">

      </div>
  </div>
  <div class="am-u-md-12">
      <div class="am-u-md-5">
          <p>3、是否属于征收范围内房屋</p>
      </div>
      <div class="am-u-md-7"  id="IfCollection">       
      </div>
  </div>
  <div class="am-u-md-12">
      <div class="am-u-md-5">
          <p>4、是否属门面营业用房</p>
      </div>
      <div class="am-u-md-7" id="IfFacade">

      </div>
  </div>


      <div class="am-u-md-12" style="padding-left:0;">

        <div class="houseHide">
          <div class="am-form-group am-u-md-12">
              <h2 class="label_title">房屋结构检查：</h2>
          </div>
          <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>房屋结构查验是否通过</p>
            </div>
            <div class="am-u-md-7" id="IfCheck" style="padding-left:25px;">

            </div>
          </div>
        </div>
          <!-- <div class="am-u-md-12">
              <div class="am-u-md-5">
                  <p>房屋结构查验是否通过</p>
              </div>
              <div class="am-u-md-7">
                <label class="am-radio-inline">
                  <input type="radio"  value="1" name="four"  required> 是
                </label>
                <label class="am-radio-inline">
                  <input type="radio" value="0" name="four" checked="checked"> 否
                </label>
              </div>
          </div> -->
        <div class="am-form-group am-u-md-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-md-12">
          <div id="layer-photos-demo" class="am-u-md-12">
<!--             <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请人户口簿">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请人身份证、图章：">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="国有公房（民用住宅）租赁合同：">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="申请书">
            <img style="width:100px;display:inline-block;" layer-pid="0" layer-src="/uploads/ban/33.jpg" src="/uploads/ban/33.jpg" alt="你好"> -->
          </div>
        </div>

       <!--  <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请书：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人户口簿：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>申请人身份证、图章：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房（民用住宅）租赁合同：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>原承租人死亡的，提交死亡证明：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>经公证的配偶及同户籍近亲同意使用权转让协议书（附件七）：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>国有公房（民用住宅）使用权转让双方签订的国有公房（民用住宅）使用权转让协议书：</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>承租人与配偶不同户籍的，结婚证</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-form-group am-u-md-12">
          <div class="am-u-md-6">
            <label>附件：</label>
          </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件六：承诺书</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件七：同意办理公有住房使用权转让或者代理转让协议书</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件八 ：武昌区房地产公司      房管所    直管公房使用权转让备案单</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件九：协议书</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件十：同意办理公有住房使用权置换或者代理转让声明书</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>附件十一：同意办理公有住房使用权置换或者代理转让声明书</p>
            </div>
            <div class="am-form-group am-form-file">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input type="file" multiple>
            </div>
        </div>
      </div> -->

  <div class="am-form-group am-u-md-12">
      <h2 class="label_title">审批状态：</h2>
  </div>  
  <div id="approveState" class="am-u-md-12" style="padding-left:3rem;">
<!--       <span class="process_style process_style_active">房管员</span><span class="line_style">——></span>
      <span class="process_style">房调员</span><span>——></span>
      <span class="process_style">所长</span><span>——></span>
      <span class="process_style">总公司科长</span><span>——></span>
      <span class="process_style">经管副总</span> -->
  </div>
<!--   <div class="am-form-group am-u-md-12 record">
      <label>1.房管员［黄芳］于2017年6月13日提交了使用权变更申请；</label>
      <label>1.房管员［黄芳］于2017年6月13日提交了使用权变更申请；</label>
  </div> -->
  </div>
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

<script type="text/javascript" src="/public/static/gf/js/DFileUpload.js"></script>
<!-- <script type="text/javascript" src="/public/static/gf/js/fileUpload.js"></script> -->
<script type="text/javascript" src="/public/static/gf/viewJs/user_audit.js"></script>

</body>
</html>