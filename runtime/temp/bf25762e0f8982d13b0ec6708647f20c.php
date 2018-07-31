<?php if (!defined('THINK_PATH')) exit(); /*a:10:{s:72:"/usr/share/nginx/publichouse/application/ph/view/change_apply/index.html";i:1531829126;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1532308676;s:42:"application/ph/view/change_apply/form.html";i:1532068856;s:53:"application/ph/view/change_apply/HouseChangeForm.html";i:1528342025;s:44:"application/ph/view/change_apply/detail.html";i:1528342025;s:56:"application/ph/view/change_apply/pause_choose_house.html";i:1531059200;s:44:"application/ph/view/house_info/RentForm.html";i:1531549142;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1532308676;}*/ ?>
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
  <!-- rent_reduction/租金减免、pauseRent/暂停计租、cancel/注销-->

<form id="derateApplyForm" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label id="houseLabel" class="label_style">房屋编号：</label>
      <input type="number" id="getInfo_1" class="label_input" placeholder="双击输入房屋编号" />
      <a class="am-btn am-btn-primary am-btn-sm" id="DQueryData">查询</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">楼栋编号：</label>
      <label id="BanID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">房屋地址：</label>
      <label id="BanAddress" class="label_content label_p_style" style="width:476px;"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style"> 产别：</label>
      <label id="OwnTypeD" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用性质：</label>
      <label id="useNature" class="label_content label_p_style"></label>
    </div>

    <div class="am-form-group am-u-sm-4 rent_reduction">
      <label class="label_style">计租表：</label>
      <a class="am-btn am-btn-primary am-btn-sm" id="rentMeterButton">查询</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <label id="HouseUsearea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">计租面积：</label>
      <label id="LeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4 am-u-end">
      <label class="label_style">月租金：</label>
      <label id="monthRent" class="label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">承租人：</label>
      <label id="TenantName" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">身份证号：</label>
      <label id="TenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">联系电话：</label>
      <label id="TenantTel" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-form-group am-u-sm-12 rent_reduction">
      <h2 class="label_title">填报信息：</h2>
  </div>
  <div class="am-form-group am-u-md-12 rent_reduction">
    <div class="am-u-sm-4">
        <label class="label_style">减免金额：</label>
        <input type="number" name="RemitRent" id="RemitRent" class="label_input" placeholder="减免金额"/>
    </div>
    <div class="am-u-sm-4">
        <label class="label_style">减免类型：</label>
        <select name="CutType" id="CutType" class="label_select">
            <option  value="" style="display:none">请选择</option>
            <?php foreach($cutTypeLst as $v1){;?>
            <option value="<?php echo $v1['id']; ?>"><?php echo $v1['CutName']; ?></option>
            <?php }; ?>
        </select>
    </div>
    <div class="am-form-group am-u-sm-4">
        <label class="label_style">减免证号：</label>
        <input type="number" name="IDnumber" class="label_input" id="IDnumber" />
    </div>
    <div class="am-form-group am-u-sm-12">
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
    <div class="am-form-group am-u-sm-12">
        <label class="label_style">低保证：</label>
          <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="basic" type="file" name="basic" multiple>
          </div>
          <div id="basicShow" class="am-u-md-12 img_content"></div>
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

  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">资料上传：</h2>
  </div>

  <div class="am-form-group am-u-sm-12 rent_reduction">
    <div class="am-form-group am-u-sm-3">
      <label>身份证：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="ID" type="file" name="ID" multiple>
        </div>
        <div id="IDShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 rent_reduction">
    <div class="am-form-group am-u-sm-3">
      <label>房产证：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
            <i class="am-icon-cloud-upload"></i> 选择要上传的文件
            <input id="houseBook" type="file" name="houseBook" multiple>
        </div>
        <div id="houseBookShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12 rent_reduction">
    <div class="am-form-group am-u-sm-3">
      <label>户口本：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="household" type="file" name="household" multiple>
        </div>
        <div id="householdShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 rent_reduction">
    <div class="am-form-group am-u-sm-3">
      <label>年租房合同(协议)：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="annualRentalContract" type="file" name="annualRentalContract" multiple>
        </div>
        <div id="annualRentalContractShow" class="am-u-md-12 img_content"></div>
  </div>

  <div class="am-form-group am-u-sm-12 rent_reduction">
      <div class="am-form-group am-u-sm-3">
          <label>住房保障申请表：</label>
      </div>
      <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="houseSecurity" type="file" name="houseSecurity" multiple>
      </div>
      <div id="houseSecurityShow" class="am-u-md-12 img_content"></div>
  </div>
</form>

<!-- 暂停计租 -->
<form id="pauseRent" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label id="houseLabel" class="label_style">房屋编号：</label>
      <a class="am-btn am-btn-primary am-btn-sm" id="pauseHouseQuery">查询</a>
    </div>
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">楼栋编号：</label>
      <label id="pauseBanID" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">房屋地址：</label>
      <label id="pauseBanAddress" class="label_content label_p_style" style="width:476px;"></label>
    </div>
    <div class="am-form-group am-u-sm-4 ">
      <label class="label_style">楼栋产别：</label>
      <label id="pauseOwnerType" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">暂停租金：</label>
      <label id="pauseHousePrerent" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">房屋明细：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
      <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact overflow_tbody" style="border:1px solid #ccc;">
          <thead style="display:block;">
              <tr>
                  <td style="width:200px;">#</td>
                  <td style="width:200px;" class="am-hide-sm-only">房屋编号</td>
                  <td style="width:200px;" class="am-hide-sm-only">承租人</td>
                  <td style="width:200px;" class="am-hide-sm-only">月租金</td>
                  <td style="width:350px;" class="am-hide-sm-only">房屋地址</td>
              </tr>
          </thead>
          <tbody id="pauseHouseDetail" style="height:200px;display:block;overflow-y:scroll;">


          </tbody>
      </table>
  </div>
</form>
<!--- 暂停计租 -->

   
<!-- 注销 -->
<form id="cancel" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label class="label_style">房屋编号：</label>
      <input id="getcancel" class="label_input" placeholder="双击输入房屋编号" />
      <a class="am-btn am-btn-primary am-btn-sm" id="cancelQueryData">查询</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">使用性质：</label>
      <label id="cancelUseNature" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">完损等级：</label>
      <label id="cancelDamageGrade" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">产别：</label>
      <label id="cancelOwnerType" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <label id="cancelHouseUsearea" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">计租面积：</label>
      <label id="cancelLeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">月租金：</label>
       <label id="cancelHousePrerent" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">承租人：</label>
      <label id="cancelTenantName" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">身份证号：</label>
      <label id="cancelTenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">联系电话：</label>
       <label id="cancelTenantTel" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">单元号：</label>
      <label id="cancelUnitID" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">层次：</label>
      <label id="cancelFloorID" class="label_content label_p_style"></label>
    </div>

    <div class="am-form-group am-u-sm-4">
      <label class="label_style">注销类别：</label>
      <select name="cancelType" id="cancelType" class="label_select" required>
          <option value="">请选择</option>
          <option value="1">房屋出售</option>
          <option value="2">危改拆除</option>
          <option value="3">落私发还</option>
          <option value="4">自然灭失</option>
          <option value="5">房屋划转</option>
          <option value="6">其他</option>
      </select>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-12">
      <label class="label_style">异动事由：</label>
       <input id="cancelReason" class="label_input" style="width:474px;" />
    </div>
  </div>

<div id="addBanNumber">
  <div class="cancel_BanNumber">
    <div class="am-form-group am-u-sm-12">
        <hr />
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label class="label_p_style banID"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">房屋地址：</label>
        <label class="label_p_style HouseAdress"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">注销租金：</label>
        <input type="number" class="label_input cancelPrent" />
      </div>
    </div>
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">建筑面积：</label>
        <input type="number" class="label_input houseArea" />
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">房屋原价：</label>
        <input type="number" class="label_input housePrice" />
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">使用面积：</label>
        <input type="number" class="label_input cancelHouseUsearea" />
      </div>
    </div>
  </div>
</div>

<div class="cancel_BanNumber" style="display:none;">
  <div class="am-form-group am-u-sm-12">
      <hr />
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼栋编号：</label>
      <label class="label_p_style banID"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">房屋地址：</label>
      <label class="label_p_style HouseAdress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">注销租金：</label>
      <input type="number" class="label_input cancelPrent" />
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">建筑面积：</label>
      <input type="number" class="label_input houseArea" />
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">房屋原价：</label>
      <input type="number" class="label_input housePrice" />
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <input type="number" class="label_input cancelHouseUsearea" />
    </div>
  </div>
</div>

  <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">资料上传：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label>武汉市直管公有住房出售收入专用票据：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="housingBill" type="file" name="housingBill" multiple>
    </div>
    <div id="housingBillShow" class="am-u-md-12 img_content"></div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label>武昌区房地局出售直管公有住房审批表：</label>
    </div>
    <div class="am-form-group am-form-file am-u-md-5">
          <i class="am-icon-cloud-upload"></i> 选择要上传的文件
          <input id="housingApprovalForm" type="file" name="housingApprovalForm" multiple>
    </div>
    <div id="housingApprovalFormShow" class="am-u-md-12 img_content"></div>
  </div>
</form>


<!-- 规定租金调整 -->
<form id="RentAdjustment" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label class="label_style">房屋编号：</label>
      <input id="getRent" class="label_input" placeholder="双击输入房屋编号" />
      <a class="am-btn am-btn-primary am-btn-sm" id="RentQueryData">查询</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">使用性质：</label>
      <label id="RentUseNature" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">完损等级：</label>
      <label id="RentDamageGrade" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">产别：</label>
      <label id="RentOwnerType" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <label id="RentHouseUsearea" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">计租面积：</label>
      <label id="RentLeasedArea" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">月租金：</label>
       <label id="RentHousePrerent" class="label_content label_p_style"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">承租人：</label>
      <label id="RentTenantName" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">身份证号：</label>
      <label id="RentTenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">联系电话：</label>
       <label id="RentTenantTel" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-12">
      <label class="label_style">异动事由：</label>
       <input id="RentReason" class="label_input" style="width:474px;" />
    </div>
  </div>


  <div class="am-form-group am-u-sm-12" style="margin-top:20px;">
      <hr />
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div id="addRent">
    <div class="Rent_BanNumber">
      <div class="am-u-sm-12">
        <div class="am-form-group am-u-sm-4">
          <label class="label_style">楼栋编号：</label>
          <label class="label_p_style banID"></label>
        </div>
        <div class="am-form-group am-u-sm-4">
          <label class="label_style">房屋地址：</label>
          <label class="label_p_style HouseAdress"></label>
        </div>
        <div class="am-form-group am-u-sm-4">
          <label class="label_style">增加金额：</label>
          <input type="number" class="label_input addRentMoney" />
        </div>
      </div>
      <div class="am-form-group am-u-sm-12" style="margin-top:20px;">
          <hr />
      </div>
    </div>
  </div>

  <div class="Rent_BanNumber" style="display:none;">
    <div class="am-u-sm-12">
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">楼栋编号：</label>
        <label class="label_p_style banID"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">房屋地址：</label>
        <label class="label_p_style HouseAdress"></label>
      </div>
      <div class="am-form-group am-u-sm-4">
        <label class="label_style">增加金额：</label>
        <input type="number" class="label_input addRentMoney" />
      </div>
    </div>
    <div class="am-form-group am-u-sm-12" style="margin-top:20px;">
        <hr />
    </div>
  </div>


</form>


<!-- 租金追加调整 -->
<form id="RentAdditional" style="display:none;margin-top:20px;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label class="label_style">房屋编号：</label>
      <input id="getRentAdd" class="label_input" placeholder="双击输入房屋编号" />
      <a class="am-btn am-btn-primary am-btn-sm" id="RentAddQueryData">查询</a>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">楼栋编号：</label>
      <label id="RentAddBanID" class="label_p_style"></label>
    </div>

    <div class="am-form-group am-u-sm-8">
      <label class="label_style">房屋地址：</label>
      <label id="RentAddAddress" class="label_p_style" style="width:476px;"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4" style="padding-right: 0">
      <label class="label_style">使用性质：</label>
      <label id="RentAddUseNature" class="label_content label_p_style"></label>
    </div>

    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <label id="RentAddHouseUseArea" class="label_p_style"></label>
    </div>

    <div class="am-form-group am-u-sm-4">
      <label class="label_style">计租面积：</label>
      <label id="RentAddLeasedArea" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">产别：</label>
       <label id="RentAddOwnerType" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">月租金：</label>
       <label id="RentAddHousePrerent" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">完损等级：</label>
       <label id="RentAddDamageGrade" class="label_p_style"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">承租人：</label>
      <label id="RentAddTenantName" class="label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">身份证号：</label>
      <label id="RentAddTenantNumber" class="label_content label_p_style"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">联系电话：</label>
      <label id="RentAddTenantTel" class="label_content label_p_style"></label>
    </div>
  </div>

  <div class="am-form-group am-u-sm-12" style="margin-top:20px;">
      <hr />
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">追加金额：</h2>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">以前年：</label>
      <input type="number" class="label_input" id="RentAddYear" style="margin-right:10px;" />元
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">以前月：</label>
      <input type="number" class="label_input" id="RentAddMonth" style="margin-right:10px;" />元
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-12">
      <label class="label_style">异动事由：</label>
      <input class="label_input RentAddReason" style="width:476px;" />
    </div>
  </div>
</form>
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
  <div class="am-u-sm-12" id="banLinkHouseForm" style="display:none;">
  <div class="am-tabs" data-am-tabs>
      <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active"><a href="#tab1" style="margin-right:0;">选择</a></li>
        <li><a href="#tab2" style="margin-right:0;">已选</a></li>
      </ul>
      <div class="am-tabs-bd">
        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
          <div class="am-u-sm-8">
            <h2 class="label_title">查找楼栋编号：</h2>
          </div> 
          <div class="am-u-sm-4">
            <input class="label_input" id="banLinkInput" placeholder="输入地址查询" />
            <button class="am-btn am-btn-primary am-btn-sm" id="banLinkSearch">查询</button>
          </div>
          <div class="am-u-sm-12">
              <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact" style="border:1px solid #ccc;margin-bottom:0;">
                  <thead style="display:block;">
                      <tr>
                          <th style="width:150px;" class="table-id">楼栋编号</th>
                          <th style="width:150px;" class="table-title">完损等级</th>
                          <th style="width:150px;" class="table-author">结构类别</th>
                          <th style="width:150px;" class="table-set">产别</th>
                          <th style="width:150px;" class="table-set">使用性质</th>
                          <th style="width:350px;" class="table-set">楼栋地址</th>
                      </tr>
                  </thead>
                  <tbody id="pauseBanAdd" style="height:200px;display:block;overflow-y:scroll;">

                  </tbody>
              </table>
          </div>
          <div class="am-u-sm-12">
            <h2 class="label_title">选择暂停房屋：</h2>
          </div>
          <div class="am-u-sm-12">
                <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact overflow_tbody" style="border:1px solid #ccc;margin-bottom:0;">
                    <thead style="display:block;">
                        <tr>
                            <td style="width:150px;"><input type="checkbox" id="allChoose"></td>
                            <td style="width:150px;" class="am-hide-sm-only">房屋编号</td>
                            <td style="width:150px;" class="am-hide-sm-only">产别</td>
                            <td style="width:150px;" class="am-hide-sm-only">使用性质</td>
                            <td style="width:150px;" class="am-hide-sm-only">承租人</td>
                            <td style="width:350px;" class="am-hide-sm-only">月租金</td>
                        </tr>
                    </thead>
                    <tbody id="pauseHouseAdd" style="height:250px;display:block;overflow-y:scroll;">
                    </tbody>
                </table>
          </div>
        </div>
        <div class="am-tab-panel am-fade" id="tab2">
          <div class="am-u-sm-12">
            <h2 class="label_title">已选暂停房屋：</h2>
          </div>
          <div class="am-u-sm-12">
                <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact overflow_tbody" style="border:1px solid #ccc;margin-bottom:0;">
                    <thead style="display:block;">
                        <tr>
                            <td style="width:150px;">操作</td>
                            <td style="width:150px;" class="am-hide-sm-only">房屋编号</td>
                            <td style="width:150px;" class="am-hide-sm-only">产别</td>
                            <td style="width:150px;" class="am-hide-sm-only">使用性质</td>
                            <td style="width:150px;" class="am-hide-sm-only">承租人</td>
                            <td style="width:350px;" class="am-hide-sm-only">月租金</td>
                        </tr>
                    </thead>
                    <tbody id="pauseHouseChoose" style="height:530px;display:block;overflow-y:scroll;">
                    </tbody>
                </table>
          </div>
        </div>
    </div>
  </div>
</div>
  <style type="text/css">
	body .yue-class .layui-layer-btn0{
		color: #3bb4f2!important;
		text-decoration: underline!important;
		background: none!important;
		border:none!important;
	}
	body .yue-class .layui-layer-btn1{
		border-radius: 4px!important;
    	background-color: #0084FF!important;
    	color: #ffffff!important;
	}
</style>
<div id="RentForm" class="am-form" style="display:none;font-size:1.4rem;">
	<div class="am-u-md-12">
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-6" style="padding:0;">
				<p class="detail_p_style RentBan" ></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">房屋结构：</label>
			  <div class="am-u-md-6" style="padding:0">
				<p class="detail_p_style RentStructure" ></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">结构基价：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style RentPoint"></p>
			  </div>
		</div>
		<div class="am-u-md-6">
			  <label for="doc-vld-email-2" class="label_style">房屋地址：</label>
			  <div class="am-u-md-8">
				<p class="detail_p_style RentAddress" ></p>
			  </div>
		</div>
	</div><!-- 第一排 -->
    <div class="am-u-md-12">
    	<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">户名：</label>
			  <div class="am-u-md-6" style="padding:0;">
				<p class="detail_p_style RentName"></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">楼层数量：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style BanFloorNum"></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">层次：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style RentLayer" ></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">户建面：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style" ></p>
			  </div>
		</div>
		<div class="am-u-md-4">
			  <label for="doc-vld-email-2" class="label_style">套内建面：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style RentComprising" ></p>
			  </div>
		</div>
    </div> <!--第二排-->
    <div class="am-u-md-12 text-center">
    	<ul class="am-u-md-12 Rtitle">
	    	<li style="width:9%">房间编号</li>
		    <li style="width:5%">间号</li>
		    <li style="width:9%">绑定楼栋</li>
		    <li style="width:5%">共用情况</li>
		    <li style="width:9%">绑定房屋</li>
		 	<li style="width:6%">产别</li>
		    <li style="width:6%">单元号</li>
		    <li style="width:6%">层次</li>
		    <li style="width:7%">使用面积</li>
		    <li style="width:7%">基价折减</li>
		    <li style="width:7%">计租面积</li>
		    <li style="width:7%">层次调解率</li>
		    <li style="width:7%">月租金</li>
		    <li style="width:5%">状态</li>
    	</ul>
    </div>
    
	<div class="am-u-md-12 text-center mb20 RentExample" style="display:none;margin-bottom:5px;">
    	<div class="am-u-md-12 nomal titR">
    		<div class="am-u-md-1 RentRoomName" style="text-align:left;"></div>
    		<div class="triD"><img src="/public/static/gf/icons/NtriD.png" width="100%" class="pull"></div>
    	</div>
    	<div class="RoomDeT clearfloat">
	    	<div class="am-u-md-12 house_style RentTit ul-mr">
	    		
	    	</div>
	    	<!-- <ul class="am-u-md-12 house_style RentDate"> -->

	    	
    	</div>
    </div><!--卧室-->
   <!--房间信息-->
    
    
    <div class="am-u-md-12 addPrice">
    	<div class="am-u-md-12 text-bold">加计租金</div>
    	<div class="am-u-md-12">
    		<div class="am-u-md-3">
    			<div><span class="w200">墙布(纸)护墙板</span><span class="w50 RentWallpaper"></span>元</div>
				<div><span class="w200">瓷砖、马赛克、地板砖</span><span class="w50 RentCeramic"></span>元</div>
				<div><span class="w200">浴盆</span><span class="w50 RentBath"></span>元</div>
				<div><span class="w200">面盆</span><span class="w50 RentBasin"></span>元</div>
				<div><span class="w200">空间1至1.7米(5㎡以下)</span><span class="w50 RentBelow"></span>元</div>
				<div><span class="w200">阁楼(含1.7米)(5㎡以上)</span><span class="w50 RentMore"></span>元</div>
    		</div>
    		<div class="am-u-md-6">
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">产别：</span><span class="w50 RentType"></span></div>
    				<div class="am-u-md-6"><span class="w100">规定租金：</span><span class="w50 RentPrice"></span></div>
    			</div>
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">产别：</span><span class="w50 RentType"></span></div>
    				<div class="am-u-md-6"><span class="w100">规定租金：</span><span class="w50 RentPrice"></span></div>
    			</div>
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">计算租金：</span><span class="w50 RentApproved"></span></div>
    				<div class="am-u-md-6"><span class="w100">欠租情况：</span><a href="#" class="am-text-secondary OweLink" target="_blank">点击查看</a></div>
    			</div>
				
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">减免租金：</span><span class="w50 RentRemit"></span>元
					</div>
					<div class="am-u-md-6"><span class="w100">租差：</span><span class="w50 diffRent"></span></div>
					
				</div>
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">泵费：</span><span class="w50 RentPump"></span>元
					</div>
					<div class="am-u-md-6"><span class="w100">协议租金：</span><span class="w50 agreementRent"></span></div>
				</div>
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">应收租金：</span><span class="w50 RentReceive"></span>元
					</div>
				</div>
				
    		</div>
    		<div class="am-u-md-3">
    			<div>使用面积：<span class="w50 RentHouseArea"></span></div>
				<div>计租面积：<span class="w50 RentLeased"></span></div>
				<div>有电梯：<span class="RentEle"></span></div>
				<div><label><input type="checkbox" class="RentW" onclick="return false" >无上下水，无厕所的房屋</label></div>
				
				<div><label><input type="checkbox" class="RentE" onclick="return false">居住第一层有架空层或木地板住房</label></div>
    		</div>                                 
    	</div>
    </div><!-- 加计租金 -->
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

<script type="text/javascript" src="/public/static/gf/js/DFileUpload.js"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/change_apply.js"></script>

</body>
</html>