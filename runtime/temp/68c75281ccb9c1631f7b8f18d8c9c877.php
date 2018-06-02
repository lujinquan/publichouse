<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:62:"D:\phpStudy\WWW\ph/application/ph\view\change_apply\index.html";i:1527069859;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1527835358;s:42:"application/ph/view/change_apply/form.html";i:1527836110;s:53:"application/ph/view/change_apply/HouseChangeForm.html";i:1527835358;s:44:"application/ph/view/change_apply/detail.html";i:1523846105;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>异动申请</title>
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
        <div class="am-fl am-cf"><small class="am-text-sm">异动管理</small> >
            <small class="am-text-primary">异动申请</small>
        </div>
    </div>

    <div class="am-g">
        <div class="am-u-md-6">
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <?php if(in_array(365,$threeMenu)){ ; ?>
                    <button type="button" id="addApply" class="am-btn d-btn-1188F0 am-radius"><span class="am-icon-plus"></span> 异动申请</button>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="am-g">
        <div class="am-u-sm-12">
            <table class="am-table am-table-striped am-table-hover table-main am-table-centered">
                <thead>
                <tr>
                    <th class="table-check"></th>
                    <th class="table-id">#</th>
                    <th class="table-title">流程名称</th>
                    <th class="table-author am-hide-sm-only">定制人</th>
                    <th class="table-set">定制时间</th>
                    <th class="table-set">流程大类</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($processLst as $k => $v){ ;?>
                <tr class="check001">
                    <td>
                        <span class="piaochecked">
                            <input class="checkId radioclass" type="radio" name="choose" value="<?php echo $v['id']; ?>"/>
                        </span>
                    </td>
                    <td><?php echo $v['id']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['ProcessName']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['CreateUserName']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['CreateTime']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['IfBaseChange']; ?></td>
                </tr>
                <?php }; ?>

                </tbody>
            </table>
            <div class="am-cf">
                共<?php echo $processLstObj->total(); ?>条记录
                <div class="am-fr">
                    <?php echo $processLstObj->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content end -->
<!-- 新增租金减免、空租、暂停计租、陈欠核销、注销-->
<form id="derateApplyForm" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label id="houseLabel" class="label_style">房屋编号：</label>
      <input id="getInfo_1" class="label_input" required/>
      <button class="am-btn am-btn-primary am-btn-sm" id="DQueryData">查询</button>
    </div>
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">楼栋编号：</label>
      <label id="BanID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">房屋地址：</label>
      <label id="BanAddress" class="label_content label_p_style" style="width:476px;"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼层：</label>
      <label id="FloorID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 Hhide">
      <label class="label_style">承租人：</label>
      <label id="TenantName" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 Hhide">
      <label class="label_style">联系电话：</label>
      <label id="TenantTel" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 ">
      <label class="label_style">备案时间：</label>
      <label id="CreateTime" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 uHide">
      <label class="label_style">使用面积：</label>
      <label id="HouseArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 Hhide">
      <label class="label_style">身份证号：</label>
      <label id="TenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 uShow" style="display: none">
      <label class="label_style">产别：</label>
      <label id="OwnerTypec" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 Hhide">
      <label class="label_style">计租面积：</label>
      <label id="LeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 breaks">
      <label class="label_style"> 产别：</label>
      <label id="OwnTypeD" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end breaks">
      <label class="label_style">原金额：</label>
      <label id="oldPo" class="label_p_style"></label>
    </div>
  </div>

  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">填报信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-sm-4 breaks">
        <label class="label_style">减免金额：</label>
        <input name="RemitRent" id="RemitRent" class="label_input" placeholder="减免金额"/>
    </div>
    <div class="am-u-sm-4 breaks">
        <label class="label_style">减免类型：</label>
        <select name="CutType" id="CutType" class="label_select" required>
            <option  value="" style="display:none">请选择</option>
            <?php foreach($cutTypeLst as $v1){;?>
            <option value="<?php echo $v1['id']; ?>"><?php echo $v1['CutName']; ?></option>
            <?php }; ?>
        </select>
    </div>
    <div class="am-form-group am-u-sm-4 breaks">
        <label class="label_style">证件号：</label>
        <input name="IDnumber" class="label_input" id="IDnumber" />
    </div>
    <div class="am-form-group am-u-sm-12 breaks">
      <label class="label_style">有效期：</label>
      <select name="validity" id="validity" class="label_select">
          <option  value="" style="display:none">请选择</option>
          <option value="1">1个月</option>
          <option value="2">2个月</option>
          <option value="3">3个月</option>
          <option value="4">4个月</option>
          <option value="5">5个月</option>
          <option value="6">6个月</option>
          <option value="7">7个月</option>
          <option value="8">8个月</option>
          <option value="9">9个月</option>
          <option value="10">10个月</option>
          <option value="11">11个月</option>
          <option value="12">12个月</option>
      </select>
    </div>
    <div class="am-form-group am-u-sm-12 breaks">
        <label class="label_style">证件上传：</label>
          <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="ID" type="file" name="ID" multiple>
          </div>
          <div id="IDShow" class="am-u-md-12 img_content"></div>
    </div>
  </div>


   <div class="am-form-group am-u-sm-12 CutHide" style="display: none;">
    <div class="am-form-group am-u-sm-3">
     <label> 产别：<span  id="AOwnTypeD"></span></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <input type="number" name="ARemitRent" id="ARemitRent" class="am-u-sm-6" placeholder="减免金额"/>
    </div>
    <div class="am-form-group am-u-sm-5">
      <label class="am-u-sm-8">原金额：<span id="oldPt"></span></label>
    </div>
  </div>


<!-- 新增暂停计租 -->
<!--   <div class="am-form-group am-u-sm-12 PauseRent">
    <div class="am-u-sm-3">
      <label>暂停起始时间：</label>
    </div>
    <div class="am-u-sm-3 am-u-end">
        <input type="text" name="pasuseTimeStart" data-am-datepicker value=""> 
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 PauseRent">
    <div class="am-u-sm-3">
      <label>暂停结束时间：</label>
    </div>
    <div class="am-u-sm-3 am-u-end">
        <input type="text" name="pasuseTimeEnd" data-am-datepicker value=""> 
    </div>
  </div> -->

  <!--<div class="am-form-group am-u-sm-12 PauseRent">-->
    <!--<div class="am-u-sm-3">-->
      <!--<label>暂停类型：</label>-->
    <!--</div>-->
    <!--<div class="am-u-sm-3 am-u-end">-->
        <!--<select type="text" name="pasuseType" id="pasuseType">-->
          <!--<option id="0">未选择</option>-->
        <!--</select>-->
    <!--</div>-->
  <!--</div>-->
<!-- 新增暂停计租 -->


  <div class="am-form-group am-u-sm-12 CancelRent">
      <label class="label_style">注销类型：</label>
      <select name="CancelType" id="CancelType" class="label_p_style">
        <option value="1">房屋出售</option>
        <option value="2">危改拆除</option>
        <option value="3">落私发还</option>
        <option value="4">自然灭失</option>
        <option value="5">房屋划转</option>
        <option value="6">其他</option>
      </select>
  </div>
  <!-- <div class="am-form-group am-u-sm-12 CancelRent">
    <div class="am-u-sm-3">
      <label class="am-radio-inline">
        <input type="radio" name="cancel"> 出售公房
      </label>
    </div>
    <div class="am-u-sm-3 am-u-end">
      <label class="am-radio-inline">
        <input type="radio" name="cancel"> 拆迁注销
      </label>
    </div>
  </div> -->


  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">资料上传：</h2>
  </div>
  <div class="am-form-group am-u-sm-12 breaks">
    <div class="am-form-group am-u-sm-3">
      <label>租金核减审核表：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="AppForm" type="file" name="AppForm" multiple>
        </div>
        <div id="AppFormShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 breaks">
    <div class="am-form-group am-u-sm-3">
      <label>资金核减申请书：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="AppBook" type="file" name="AppBook" multiple>
        </div>
        <div id="AppBookShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 breaks">
    <div class="am-form-group am-u-sm-3">
      <label>户口簿：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="ReBooklet" type="file" name="ReBooklet" multiple>
        </div>
        <div id="ReBookletShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 breaks">
    <div class="am-form-group am-u-sm-3">
      <label>住房租约：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="HouseLease" type="file" name="HouseLease" multiple>
        </div>
        <div id="HouseLeaseShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 EmptyRent">
    <div class="am-form-group am-u-sm-3">
      <label>空租报告：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="EmptyReport" type="file" name="EmptyReport" multiple>
        </div>
        <div id="EmptyReportShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 PauseRent">
    <div class="am-form-group am-u-sm-3">
      <label>暂停计租报告：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="SuspendReport" type="file" name="SuspendReport" multiple>
        </div>
        <div id="SuspendReportShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 CancelRent">
    <div class="am-form-group am-u-sm-3">
      <label>新增注销材料：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CancelReport" type="file" name="CancelReport" multiple>
        </div>
        <div id="CancelReportShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 WriteOff">
    <div class="am-form-group am-u-sm-3">
      <label>核销起始时间：</label>
    </div>
    <div class="am-u-md-3 am-u-end">
      <input type="text" name="DateStart" data-am-datepicker="{format: 'yyyy-mm', viewMode: 'months', minViewMode: 'months'}" />
    </div>
  </div>

  <div class="am-form-group am-u-sm-12 WriteOff">
    <div class="am-form-group am-u-sm-3">
      <label>核销结束时间：</label>
    </div>
    <div class="am-u-md-3 am-u-end">
      <input type="text" name="DateEnd" data-am-datepicker="{format: 'yyyy-mm', viewMode: 'months', minViewMode: 'months'}" />
    </div>
  </div>
  <div class="am-form-group am-u-sm-12 WriteOff">
    <div class="am-form-group am-u-sm-3">
      <label>陈欠核销报告：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="WriteOffReport" type="file" name="WriteOffReport" multiple>
        </div>
        <div id="WriteOffShow" class="am-u-md-12 img_content"></div>
  </div>
</form>


<!-- 维修异动 -->
<form id="repairChange" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-12">
        <label class="label_style">楼栋编号：</label>
        <input type="text" name="BanID" id="houseID" class="label_input" placeholder="楼栋编号" required/>
        <button id="DRquery" class="am-btn am-btn-primary am-btn-sm">查询</button>
    </div>
    <div class="am-form-group am-u-md-12">
        <h2 class="label_title">异动前</h2>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">使用性质：</label>
      <label id='RUseNature' class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-8">
      <label class="label_style">房屋地址：</label>
      <label id="RCBanAddress" class="label_content label_p_style" style="width:474px;"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">产别：</label>
      <label id="ROwnerType" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">栋数：</label>
      <label id="RBanFloorNum" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">层次：</label>
      <label id="RBanUnitNum" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">结构：</label>
      <label id="RCStructureType" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">占地面积：</label>
      <label id="RCoveredArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">建筑面积：</label>
      <label id="RTotalArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">完损等级：</label>
      <label id="RCDamageGrade" class="label_content label_p_style"></label>
    </div>
   
    <div class="am-form-group am-u-md-12">
      <h2 class="label_title">异动后</h2>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">使用性质：</label>
        <select name="useProp" class="label_select" required>
            <option  value="" style="display:none">请选择</option>
            <?php foreach($natureLst as $v0){;?>
            <option value="<?php echo $v0['id']; ?>"><?php echo $v0['UseNature']; ?></option>
            <?php }; ?>
        </select>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">产别：</label>
        <select name="proCate" class="label_select" required>
            <option  value="" style="display:none">请选择</option>
            <?php foreach($owerLst as $v2){;?>
            <option value="<?php echo $v2['id']; ?>"><?php echo $v2['OwnerType']; ?></option>
            <?php }; ?>
        </select>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">栋数：</label>
      <input type="text" name="NumOfBuild" class="label_input"  required/>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">层次：</label>
        <input name="level" class="label_input" type="number" />
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">结构：</label>
        <select name="BuildStructure" class="label_select" required>
            <option  value="" style="display:none">请选择</option>
            <?php foreach($structureLst as $v3){;?>
            <option value="<?php echo $v3['id']; ?>"><?php echo $v3['StructureType']; ?></option>
            <?php }; ?>
        </select>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">占地面积：</label>
        <input type="text" name="CoversArea" class="label_input"  required/>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">建筑面积：</label>
        <input type="text" name="BuildArea" class="label_input"  required/>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">完损等级：</label>
        <select name="LossLevel" class="label_select" required>
            <option  value="" style="display:none">请选择</option>
            <?php foreach($damaLst as $v4){;?>
            <option value="<?php echo $v4['id']; ?>"><?php echo $v4['DamageGrade']; ?></option>
            <?php }; ?>
        </select>
    </div>

    <div class="am-form-group am-u-md-12">
        <label class="label_style">异动原因：</label>
        <textarea name="changeReason" style="width:784px;border:1px solid #D6E2F6;"></textarea>
    </div>
    <div class="am-form-group am-u-md-12">
        <label class="label_style">维修类型：</label>
        <select name="repairType" class="label_select">
            <option  value="" style="display:none">请选择</option>
            <option  value="1" >翻修</option>
            <option  value="2" >重建</option>
        </select>
    </div>
  </div>

  <div class="am-form-group am-u-md-12">
    <h2 class="label_title">异动后</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-sm-12">
      <div class="am-form-group am-u-sm-3">
        <label>房屋勘察表：</label>
      </div>
      <div class="am-form-group am-form-file am-u-md-5">
        <i class="am-icon-cloud-upload"></i> 选择要上传的文件
        <input id="survey" type="file" name="survey" multiple>
      </div>
      <div id="surveyShow" class="am-u-md-12 img_content"></div>
    </div>
    <div class="am-form-group am-u-sm-12">
      <div class="am-form-group am-u-sm-3">
        <label>图卡：</label>
      </div>
      <div class="am-form-group am-form-file am-u-md-5">
        <i class="am-icon-cloud-upload"></i> 选择要上传的文件
        <input id="pic" type="file" name="pic" multiple>
      </div>
      <div id="picShow" class="am-u-md-12 img_content"></div>
    </div>
  </div>
</form>
<!--- 维修异动结束 -->
<!--新增房屋调整-->
<form id="houseAdjust" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-12">
        <label class="label_style Ahouse">房屋编号：</label>
        <input type="text" name="HouseID" id="AdjustHouseID" class="label_input" placeholder="楼栋编号" required/>
        <button id="DAquery" class="am-btn am-btn-primary am-btn-sm">查询</button>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">楼栋编号：</label>
        <label id="ABanID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-8">
        <label class="label_style">房屋地址：</label>
        <label id="ABanAddress" class="label_content label_p_style" style="width:476px;"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">楼层：</label>
        <label id="AFloorID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">承租人：</label>
        <label id="ATenantName" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">联系电话：</label>
        <label id="ATenantTel" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">身份证号：</label>
        <label id="ATenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">使用面积：</label>
       <label id="ALeaseArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">建筑面积：</label>
       <label id="AHouseArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 Ahide">
        <label class="label_style">计租面积：</label>
       <label id="ALeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">完损等级：</label>
       <label id="ADamageGrade" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">建筑结构：</label>
       <label id="AStructureType" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 am-u-end">
        <label class="label_style">备案时间：</label>
       <label id="ACreateTime" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-form-group am-u-md-12">
    <h2 class="label_title">填报信息</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-4 am-u-end">
        <label>完损等级：</label>
          <select name="LevelChange" id="doc-select-4" class="label_select" required>
              <option  value="" style="display:none">请选择</option>
              <?php foreach($damaLst as $k2 =>$v2){; ?>
              <option value="<?php echo $v2['id']; ?>"><?php echo $v2['DamageGrade']; ?></option>
              <?php }; ?>
          </select>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">提交材料：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>房屋勘察表：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="AdjustSurvey" type="file" name="AdjustSurvey" multiple>
    </div>
    <div id="AdjustSurveyShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>图卡：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="AdjustPic" type="file" name="AdjustPic" multiple>
    </div>
    <div id="AdjustPicShow" class="am-u-md-12 img_content"></div>
  </div>
</form>
<!-- 新增房屋调整结束 -->

<!-- 新增新发租开始 -->
<form id="NewLease" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-12">
        <label id="NLIDName" class="label_style">房屋编号：</label>
        <input type="text" name="HouseID" id="NLHouseID" class="label_input" required/>
        <button id="NLAquery" class="am-btn am-btn-primary am-btn-sm NLShow">查询</button>
    </div>

    <div class="am-form-group am-u-md-12 addBuild">
      <div class="am-u-md-2">
        <label id="" class="label_style">房屋编号：</label>
      </div>
      <div class="am-u-md-3" style="margin-bottom:10px">
        <input type="text" name="buildID_1" id="NLHouseID_1" placeholder="房屋编号" required/>
      </div>
      <div><img src="/public/static/gf/icons/addh.png" id="addH" width="28px"></div>
      <div class="addB am-u-md-12" style="padding-left:0;"></div>
    </div>

    <div class="NLShow">
      <div class="am-form-group am-u-md-4">
          <label class="label_style">使用性质：</label>
          <label id="NLUseNature" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-8">
          <label for="doc-vld-email-2" class="label_style">房屋地址：</label>
          <label id="NLBanAddress" class="label_content label_p_style" style="width:474px;"></label>
      </div>

      <div class="am-form-group am-u-md-4">
          <label class="label_style">层数：</label>
          <label id="FloorIDo" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">层次：</label>
          <label id="NLFloorID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">产别：</label>
          <label id="NLOwnerType" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">结构：</label>
          <label id="NLStructureType" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">建筑面积：</label>
          <label id="NLHouseArea" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">户数：</label>
          <label class="label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">完损等级：</label>
          <label id="NLDamageGrade" class="label_content label_p_style"></label>
      </div>

      <div class="am-form-group am-u-md-12">
          <h2 class="label_title">新发租：</h2>
      </div>

     <div class="am-form-group am-u-md-12">
          <label class="label_style">租户编号：</label>
          <input type="number" id="TenantInput" class="label_input" />
          <button id="DQTenant" class="am-btn am-btn-primary am-btn-sm NLShow">查询</button>
      </div>
      <div class="am-form-group am-u-md-4">
          <label class="label_style">住户姓名：</label>
          <label id="TenantNameO" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-md-4 am-u-end">
          <label class="label_style">联系方式：</label>
          <label id="TenantTelO" class="label_content label_p_style"></label>
      </div>
    </div>

  </div>


  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">提交材料：</h2>
  </div>
  <div class="expand" style="display:none">   
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-3">
        <label for="doc-vld-email-2" id="" class="label_style2">正常房间：</label>
      </div>
      <ul class="am-u-md-9 expand-ul nomalRoom text-blue" >
          
      </ul>
    </div>
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-3">
        <label for="doc-vld-email-2" id="" class="label_style2">修改房间：</label>
      </div>
      <ul class="am-u-md-9 expand-ul modifyRoom text-blue">
          
      </ul>
    </div>
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-3">
        <label for="doc-vld-email-2" class="label_style2">未确认房间：</label>
      </div>
      <ul class="am-u-md-9 expand-ul unconfirmedRoom text-blue">
          
      </ul>
    </div>
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-3">
        <label for="doc-vld-email-2" id="" class="label_style2">删除房间：</label>
      </div>
      <ul class="am-u-md-9 expand-ul text-red deleteRoom">
         
      </ul>
    </div>
    <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>异动申请表：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="NLApplication2" type="file" name="NLApplication" multiple>
    </div>
    <div id="NLApplicationShow2" class="am-u-md-12 img_content"></div>
  </div>
    <div class="am-form-group am-u-md-12">
      <div class="am-form-group am-u-sm-12" style="font-weight:600;font-size:1.4rem;color:#898989">
       点击房间编号查看房屋明细
      </div>    
    </div>
</div> <!-- 扩建 -->  
  <div class="am-form-group am-u-sm-12 move">
    <div class="am-form-group am-u-sm-3">
      <label>异动申请表：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="NLApplication" type="file" name="NLApplication" multiple>
    </div>
    <div id="NLApplicationShow" class="am-u-md-12 img_content"></div>
  </div>

</form>
<!-- 新发租Form结束 -->

<!-- 新增管段调整开始 -->
<form id="Pipe" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
<div class="am-form-group am-u-md-12">
  <div class="am-form-group am-u-md-12">
      <label id="PipeName" class="label_style">楼栋编号：</label>
      <input type="text" name="PipeBanID" id="PipeBanID" class="label_input" placeholder="房屋编号" required/>
      <button id="PipeQuery" class="am-btn am-btn-primary am-btn-sm PipeShow">查询</button>
  </div>

<div id="PipeBan">
  <div class="am-form-group am-u-md-4">
      <label class="label_style">使用性质：</label>
     <label id="PipeUseNature" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-8">
      <label class="label_style">房屋地址：</label>
     <label id="PipeBanAddress" class="label_content label_p_style" style="width:474px;"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">产别：</label>
     <label id="PipeOwnerType" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">栋数：</label>
     <label id="PipeBuilding" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">层次：</label>
     <label id="PipeFloorID" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">结构：</label>
     <label id="PipeStructureType" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">建筑面积：</label>
     <label id="PipeHouseArea" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">完损等级：</label>
     <label id="PipeDamageGrade" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">占地面积：</label>
    <label id="PipeCorverArea" class="label_content label_p_style"></label>
  </div>
</div>

<div id="PipeHouse" style="display:none">
  <div class="am-form-group am-u-md-4">
      <label class="label_style">楼栋编号：</label>
     <label id="PipeBanNumd" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-8">
      <label class="label_style">房屋地址：</label>
     <label id="PipeHouseAddressd" class="label_content label_p_style" style="width:474px;"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">楼层：</label>
     <label id="PipeLayerd" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">承租人：</label>
     <label id="PipeRenterd" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">联系电话：</label>
     <label id="PipePhoneNumd" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">建筑面积：</label>
     <label id="PipeBulid" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4">
      <label class="label_style">计租面积：</label>
    <label id="PipeRentArea" class="label_content label_p_style"></label>
  </div>
</div>
 <div class="am-form-group am-u-md-4">
      <label class="label_style">备案时间：</label>
     <label id="PipeTimed" class="label_content label_p_style"></label>
  </div>

  <div class="am-form-group am-u-md-4">
    <label class="label_style">原管段：</label>
    <label id="PipeTubulationID" class="label_content label_p_style"></label>
  </div>
  <div class="am-form-group am-u-md-4 am-u-end">
      <label class="label_style">身份证：</label>
     <label id="PipeIDd" class="label_content label_p_style"></label>
  </div>

</div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">填报信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-4">
          <label class="label_style">调整管段：</label>
          <select name="PipeAdjusted" id="PipeAdjusted" class="label_p_style" required>
              <option  value="" style="display:none">请选择</option>
              <?php foreach($allInstitutions as $k10 => $v10){ if($v10['level'] == 1){; ?>
              <optgroup label="<?php echo $v10['Institution'] ;?>">
                  <?php  foreach($allInstitutions as $k11 => $v11){  if($v11['pid'] == $v10['id']){; ?>
                  <option value="<?php echo $v11['id']; ?>" ><?php echo $v11['Institution']; ?></option>
                  <?php }}; ?>
              </optgroup>
              <?php }}; ?>
          </select>
    </div>
  </div>

  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">提交材料：</h2>
  </div>

  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>异动申请表：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="PipeApplication" type="file" name="PipeApplication" multiple>
    </div>
    <div id="PipeApplicationShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 RentTipsBan">
      <div class="am-u-sm-12">将整栋楼从原管段调整到另一管段；</div>
  </div>
  <div class="am-form-group am-u-sm-12 RentTipsHouse" style="display:none">
      <div class="am-u-sm-12">将房屋从原管段调整到另一管段；</div>
  </div>
</form>
 
<!-- 新增管段调整结束-->

<!-- 新增追加调整开始 -->
<form id="Add" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基本信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-12">
        <label id="AddName" class="label_style">房屋编号：</label>
        <input type="text" name="AddHouseID" id="AddHouseID" class="label_input" placeholder="房屋编号" required />
        <button id="AddQuery" class="am-btn am-btn-primary am-btn-sm AddShow">查询</button>
    </div>

    <div class="am-form-group am-u-md-4">
        <label  class="label_style">楼栋编号：</label>
       <label id="AddBanID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-8">
        <label class="label_style">楼栋地址：</label>
       <label id="AddBanAddress" class="label_content label_p_style" style="width:474px;"></label>
    </div>

    <div class="am-form-group am-u-md-4">
        <label class="label_style">栋层：</label>
       <label id="AddFloorID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">承租人：</label>
       <label id="AddTenantName" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">建筑面积：</label>
       <label id="AddHouseArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">计租面积：</label>
      <label id="AddLeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">联系电话：</label>
       <label id="AddTenantTel" class="label_content label_p_style"></label>
    </div>

    <div class="am-form-group am-u-md-4">
        <label class="label_style">身份证号：</label>
       <label id="AddTenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-md-4 am-u-end">
        <label class="label_style">备案时间：</label>
       <label id="AddCreateTime" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">填报信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-md-4">
        <label>追加时间：</label>
        <input type="text" name="AddTime" id="AddTime" class="label_input" data-am-datepicker required />
    </div>
    <div class="am-form-group am-u-md-4 am-u-end">
        <label>追加金额：</label>
        <input type="number" name="AddMoney" class="label_input" id="AddMoney" required />
    </div>
  </div>

  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">提交材料：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>追加租金报告：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="AddApplication" type="file" name="PipeApplication" multiple>
    </div>
    <div id="AddApplicationShow" class="am-u-md-12 img_content"></div>
  </div>

</form>
<!-- 新增追加调整结束-->
<!-- 租金调整 -->
<form id="RentAdjust" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基本信息：</h2>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
        <label  class="label_style">房屋编号：</label>
        <input type="text" name="" id="AdjustHouseNum" class="label_input" required/>
        <a class="am-btn am-btn-primary am-btn-sm" id="AdjustQuery">查询</a>
    </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label id="AdjustBanID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label class="label_style">房屋地址：</label>
        <label id="AdjustBanAddress" class="label_content label_p_style" style="width:474px;"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼层：</label>
        <label id="AdjustFloorID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">承租人：</label>
        <label id="AdjustTenantName" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">联系电话：</label>
        <label id="AdjustTenantTel" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">备案时间：</label>
        <label id="AdjustCreateTime" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">使用面积：</label>
        <label id="AdjustHouseArea" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">身份证号：</label>
        <label id="AdjustTenantNumber" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">计租面积：</label>
        <label id="AdjustLeasedArea" class="label_content label_p_style"></label>
      </div>
    </div><!--房屋编号-->


 <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">产别：</label>
        <label class="AdjustOwnType label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
          <label class="label_style">原租金：</label>
          <label id="AdjustPrice" class="label_content label_p_style"></label>
      </div>
  </div>
 <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
          <label class="label_style">产别：</label>
          <label class="AdjustOwnTypeA label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
          <label class="label_style">原租金：</label>
          <label id="AdjustPriceA" class="label_content label_p_style"></label>
      </div>
  </div>
  <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">产别：</label>
        <label class="AdjustOwnType label_p_style"></label>
      </div>
      <div class="am-u-sm-8">
          <label class="label_style">原租金：</label>
          <input type="text" class="label_input" name="AdjustPrice" />
      </div>
      </div>
  <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
          <label class="label_style">产别：</label>
          <label class="AdjustOwnTypeA label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
          <label class="label_style">原租金：</label>
          <input type="text" class="label_input" name="AdjustPriceA"/>
      </div>
  </div>


  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">提交材料：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>租金调整报告：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="AdjustImage" type="file" name="NLApplication" multiple>
    </div>
  <div id="AdjustImaged" class="am-u-md-12 img_content"></div>
  </div>
</form>
<!-- 租金调整结束 -->
<!-- 新增分户 -->
  <form id="SplitHouse" style="display:none;margin-top:20px;">
    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">分户原始房屋：</h2>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-md-12">
        <label class="label_style">房屋编号：</label>
        <input type="text" id="SplitHouseNum" class="label_input" required/>
        <a class="am-btn am-btn-primary am-btn-sm" id="SplitQuery">查询</a>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label id="SplitBanID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label class="label_style">房屋地址：</label>
        <label id="SplitBanAddress" class="label_content label_p_style" style="width:464px;"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼层：</label>
        <label id="SplitFloorID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">承租人：</label>
        <label id="SplitTenantName" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">联系电话：</label>
        <label id="SplitTenantTel" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">身份证号：</label>
        <label id="SplitTenantNumber" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">备案时间：</label>
        <label id="SplitCreateTime" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">使用面积：</label>
        <label id="SplitHouseArea" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">计租面积：</label>
        <label id="SplitLeasedArea" class="label_content label_p_style"></label>
      </div>  
     
      <div class="am-u-md-12">选择需要分户的房间：</div>
        <ul class="am-u-md-12 SplitRoom mr10">
          
        </ul>
    </div>

    <!--房屋编号-->
    <!--分户新增房屋-->
    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">分户新增房屋:</h2>
    </div>
    <div class="am-u-sm-12">
        <div class="am-form-group am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <input type="text" name="" id="SplitAddNum" class="label_input" required/>
          <a class="am-btn am-btn-primary am-btn-sm" id="SplitAddQuery">查询</a>
        </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label id="SplitAddID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label class="label_style">房屋地址：</label>
        <label id="SplitAddAddress" class="label_content label_p_style" style="width:464px;"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼层：</label>
        <label id="SplitAddFloor" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">承租人：</label>
        <label id="SplitAddName" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">联系电话：</label>
        <label id="SplitAddTel" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">身份证号：</label>
        <label id="SplitAddNumber" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">备案时间：</label>
        <label id="SplitAddTime" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">使用面积：</label>
        <label id="SplitAddArea" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">计租面积：</label>
        <label id="SplitAddLeased" class="label_content label_p_style"></label>
      </div>
    </div>
  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">提交材料:</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>书面申请（双方）：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="SplitApplication" type="file" name="SplitApplication" multiple>
    </div>
    <div id="SplitApplicationShow" class="am-u-md-12 img_content"></div>
  </div>
   <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>户口簿：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="SplitRegister" type="file" name="SplitRegister" multiple>
    </div>
    <div id="SplitRegisterShow" class="am-u-md-12 img_content"></div>
  </div>
   <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>身份证（双方）：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="SplitCard" type="file" name="SplitCard" multiple>
    </div>
    <div id="SplitCardShow" class="am-u-md-12 img_content"></div>
  </div>
   <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>租赁合同：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="SplitRent" type="file" name="SplitRent" multiple>
    </div>
    <div id="SplitRentShow" class="am-u-md-12 img_content"></div>
  </div>
   <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3 pd0">
      <label>共同居住人意见书（签字）：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="SplitAdvice" type="file" name="SplitAdvice" multiple>
    </div>
    <div id="SplitAdviceShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-u-md-12">注：异动审批通过后，次月生效</div>
  </div>
</form>
    <!--分户新增房屋结束-->
   
<!-- 新增并户 -->
  <form id="HouseHolds" style="display:none;margin-top:20px;">
    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">并户保留房屋：</h2>
    </div>

    <div class="am-u-md-12">
      <div class="am-form-group am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <input type="text" id="HoldsHouseNum" class="label_input" required/>
          <a class="am-btn am-btn-primary am-btn-sm" id="HoldsQuery">查询</a>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label id="HoldsBanID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label class="label_style">房屋地址：</label>
        <label id="HoldsBanAddress" class="label_content label_p_style" style="width:474px;"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼层：</label>
        <label id="HoldsFloorID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">承租人：</label>
        <label id="HoldsTenantName" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">联系电话：</label>
        <label id="HoldsTenantTel" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">身份证号：</label>
        <label id="HoldsTenantNumber" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">备案时间：</label>
        <label id="HoldsCreateTime" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">使用面积：</label>
        <label id="HoldsHouseArea" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">计租面积：</label>
        <label id="HoldsLeasedArea" class="label_content label_p_style"></label>
      </div>  
    </div>
  <!--房屋编号-->
    <!--并户注销房屋-->
    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">并户注销房屋：</h2>
    </div>
    <div class="am-u-md-12">
        <div class="am-form-group am-u-md-12">
          <label  class="label_style">房屋编号：</label>
          <input type="text" id="CancelNum" class="label_input" required/>
          <a class="am-btn am-btn-primary am-btn-sm" id="CancelQuery">查询</a>
        </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4" style="padding-right: 0">
        <label class="label_style">楼栋编号：</label>
        <label id="CancelID" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-8">
        <label class="label_style">房屋地址：</label>
        <label id="CancelAddress" class="label_content label_p_style" style="width:474px;"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼层：</label>
        <label id="CancelFloor" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">承租人：</label>
        <label id="CancelName" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">联系电话：</label>
        <label id="CancelTel" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">身份证号：</label>
        <label id="CancelNumber" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">备案时间：</label>
        <label id="CancelTime" class="label_content label_p_style"></label>
      </div>
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">使用面积：</label>
        <label id="CancelArea" class="label_content label_p_style"></label>
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4 am-u-end">
        <label class="label_style">计租面积：</label>
        <label id="CancelLeased" class="label_content label_p_style"></label>
      </div>  
    </div>

    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">提交材料：</h2>
    </div>
    <div class="am-form-group am-u-md-12">
      <div class="am-form-group am-u-sm-12">
        <div class="am-form-group am-u-sm-3 pd0">
          <label>异动申请书：</label>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CancelApplication" type="file" name="CancelApplication" multiple>
        </div>
        <div id="CancelApplicationShow" class="am-u-md-12 img_content"></div>
      </div>
      <div class="am-u-md-12">注：异动审批通过后，次月生效</div>
    </div>
</form>
<!--新增并户结束-->

  <form id="HouseChange" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-form-group am-u-md-12">
        <label class="label_style">房屋编号：</label>
       <label class="label_p_style CHouseId"></label>
    </div>
    <div class="am-form-group am-u-md-4">
        <label class="label_style">楼栋编号：</label>
       <label class="label_p_style CBanID"></label>
    </div>
    <div class="am-form-group am-u-md-8">
      <label class="label_style">房屋地址：</label>
      <label class="label_p_style CHouseAddress" style="width:484px"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">楼层：</label>
      <label class="label_p_style CFloor"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">承租人：</label>
      <label class="label_p_style CTenantName"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">联系电话：</label>
      <label class="label_p_style CTenantTel"></label>
    </div>
      
    <div class="am-form-group am-u-md-4">
      <label class="label_style">建筑面积：</label>
      <label class="label_p_style CArea"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">计租面积：</label>
      <label class="label_p_style CLeasedArea"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">产别：</label>
      <label class="label_p_style CType"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">使用性质：</label>
      <label class="label_p_style CUseProp"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">房屋结构：</label>
      <label class="label_p_style CHouseStructure"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">备案时间：</label>
      <label class="label_p_style CBuiltYear"></label>
    </div>
    <div class="am-form-group am-u-md-4">
      <label class="label_style">身份证号：</label>
      <label class="label_p_style CTenantNumber"></label>
    </div>
    <div class="am-form-group am-u-md-4 am-u-end">
      <label class="label_style">产别：</label>
      <label class="label_p_style CType"></label>
    </div>
  </div>
  <div class="material_1" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <label class="label_title">提交材料：</label>
    </div>
    <div class="am-u-md-12">
      <div class="am-u-md-5">
        <p>*购买直管公有住房申请表：</p>
      </div>
      <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CHouseApp_1" type="file" name="CHouseApp_1" multiple>
      </div>
      <div id="CHouseApp_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>*武汉市房产管理局出售单元式直管公房审批表：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CApprovalForm_1" type="file" name="CApprovalForm_1" multiple>
        </div>
        <div id="CApprovalForm_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>*售房发票：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="InvoiceSale_1" type="file" name="InvoiceSale_1" multiple>
        </div>
        <div id="InvoiceSale_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>房屋使用权证（权属证明书）原件/复印件:</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CHouseUse" type="file" name="CHouseUse" multiple>
        </div>
        <div id="CHouseUseShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>最后一月租金发票：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CLastRentInvoice_1" type="file" name="CLastRentInvoice_1" multiple>
        </div>
        <div id="CLastRentInvoice_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>公共部位维修基金发票：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CPublicFundInvoice_1" type="file" name="CPublicFundInvoice_1" multiple>
        </div>
        <div id="CPublicFundInvoice_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>住房证复印件：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CCopyOfHouse" type="file" name="CCopyOfHouse" multiple>
        </div>
        <div id="CCopyOfHouseShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>房改批文：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CReApproval" type="file" name="CReApproval" multiple>
        </div>
        <div id="CReApprovalShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>房改交易清册（住户加盖私章）：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CTransactionList" type="file" name="CTransactionList" multiple>
        </div>
        <div id="CTransactionListShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>房改协议书（住户加盖私章）：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CReAgreement_1" type="file" name="CReAgreement_1" multiple>
        </div>
        <div id="CReAgreement_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>委托书（加住户私章）：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CAttorney" type="file" name="CAttorney" multiple>
        </div>
        <div id="CAttorneyShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>营业执照复印件：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CLicenseCopy" type="file" name="CLicenseCopy" multiple>
        </div>
        <div id="CLicenseCopyShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>具结书（公司对房地局出具）：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CAffidavit_1" type="file" name="CAffidavit_1" multiple>
        </div>
        <div id="CAffidavit_1Show" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>资金证明（商业银行出具的二联单）：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CProofOfFund" type="file" name="CProofOfFund" multiple>
        </div>
        <div id="CProofOfFundShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>房屋登记申请书：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CRegistration" type="file" name="CRegistration" multiple>
        </div>
        <div id="CRegistrationShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>评估单：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CAssessment" type="file" name="CAssessment" multiple>
        </div>
        <div id="CAssessmentShow" class="am-u-md-12"></div>
    </div>
    <div class="am-u-md-12">
        <div class="am-u-md-5">
            <p>法人代表证明：</p>
        </div>
        <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="CLegalCertificate" type="file" name="CLegalCertificate" multiple>
        </div>
        <div id="CLegalCertificateShow" class="am-u-md-12"></div>
    </div>
  </div>
      <!-- 样式二 -->
      <div class="material_2" style="padding-left:0;">
        <div class="am-form-group am-u-md-12">
          <div class="am-u-md-6">
            <label>提交材料：</label>
          </div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*购买直管公有住房申请表：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CHouseApp_2" type="file" name="CHouseApp_2" multiple>
            </div>
            <div id="CHouseApp_2Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*武汉市房产管理局出售单元式直管公房审批表：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CApprovalForm_2" type="file" name="CApprovalForm_2" multiple>
            </div>
            <div id="CApprovalForm_2Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*售房发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="InvoiceSale_2" type="file" name="InvoiceSale_2" multiple>
            </div>
            <div id="InvoiceSale_2Show" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>最后一月租金发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CLastRentInvoice_2" type="file" name="CLastRentInvoice_2" multiple>
            </div>
            <div id="CLastRentInvoice_2Show" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>公共部位维修基金发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CPublicFundInvoice_2" type="file" name="CPublicFundInvoice_2" multiple>
            </div>
            <div id="CPublicFundInvoice_2Show" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>房改协议书:</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CReAgreement_2" type="file" name="CReAgreement_2" multiple>
            </div>
            <div id="CReAgreement_1Show" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>产权复印件：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CCopyOfProp" type="file" name="CCopyOfProp" multiple>
            </div>
            <div id="CCopyOfPropShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>图纸：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CPicture" type="file" name="CPicture" multiple>
            </div>
            <div id="CPictureShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>房屋信息单（房地局出具）：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CHouseInformation" type="file" name="CHouseInformation" multiple>
            </div>
            <div id="CHouseInformationShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>户口簿：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CReBooklet" type="file" name="CReBooklet" multiple>
            </div>
            <div id="CReBookletShow" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>身份证复印件2分（夫妻双方）：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CCopyOfCard" type="file" name="CCopyOfCard" multiple>
            </div>
            <div id="CCopyOfCardShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>工领证明材料复印件（退休证等）：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CWorkCertificate" type="file" name="CWorkCertificate" multiple>
            </div>
            <div id="CWorkCertificateShow" class="am-u-md-12"></div>
        </div>
        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>具结书：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CAffidavit_2" type="file" name="CAffidavit_2" multiple>
            </div>
            <div id="CAffidavit_2Show" class="am-u-md-12"></div>
        </div>
      </div>
      <!-- 样式三 -->
      <div class="material_3" style="padding-left:0;">
        <div class="am-form-group am-u-md-12">
          <div class="am-u-md-6">
            <label>提交材料：</label>
          </div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*购买直管公有住房申请表：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CHouseApp_3" type="file" name="CHouseApp_3" multiple>
            </div>
            <div id="CHouseApp_3Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*武汉市房产管理局出售单元式直管公房审批表：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CApprovalForm_3" type="file" name="CApprovalForm_3" multiple>
            </div>
            <div id="CApprovalForm_3Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>*售房发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="InvoiceSale_3" type="file" name="InvoiceSale_3" multiple>
            </div>
            <div id="InvoiceSale_3Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>最后一月租金发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CLastRentInvoice_3" type="file" name="CLastRentInvoice_3" multiple>
            </div>
            <div id="CLastRentInvoice_3Show" class="am-u-md-12"></div>
        </div>

        <div class="am-u-md-12">
            <div class="am-u-md-5">
                <p>公共部位维修基金发票：</p>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="CPublicFundInvoice_3" type="file" name="CPublicFundInvoice_3" multiple>
            </div>
            <div id="CPublicFundInvoice_3Show" class="am-u-md-12"></div>
        </div>
      </div>

<!--     <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="FormState" class="am-u-md-12">
         <span class="process_style process_style_active">房管员</span><span class="line_style">——></span>
        <span class="process_style">房调员</span><span>——></span>
        <span class="process_style">所长</span><span>——></span>
        <span class="process_style">总公司科长</span><span>——></span>
        <span class="process_style">经管副总</span>
  </div>
  <div class="am-form-group am-u-md-12">
      <label>1.房管员［黄芳］于2017年6月13日提交了使用权变更申请；</label>
  </div> -->
</form>
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
<script type="text/javascript" src="/public/static/gf/viewJs/change_apply.js"></script>

</body>
</html>