<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:64:"D:\phpStudy\WWW\ph/application/ph\view\repair_examine\index.html";i:1523846106;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1523846105;s:46:"application/ph/view/repair_examine/detail.html";i:1523846106;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>维修审批</title>
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
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">维修管理</strong> / <small>维修审批</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
              <?php if(in_array(45,$threeMenu)){ ; ?>
            <button type="button" id="addMRepair" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 中修审批</button>
              <?php }; if(in_array(46,$threeMenu)){ ; ?>
            <button type="button" id="addBRepair" class="am-btn am-btn-default addRepair" value="2"><span class="am-icon-save"></span> 大修审批</button>
              <?php }; if(in_array(47,$threeMenu)){ ; ?>
            <button type="button" id="addSafetyRepair" class="am-btn am-btn-default addRepair" value="3"><span class="am-icon-trash-o"></span> 排危审批</button>
              <?php }; if(in_array(47,$threeMenu)){ ; ?>
            <button type="button" class="am-btn am-btn-default addRepair" value="4"><span class="am-icon-trash-o"></span> 电器线隐患整治审批</button>
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
        <th class="table-title">楼栋编号</th>
				<th class="table-title">房屋编号</th>
				<th class="table-type">楼栋地址</th>
				<th class="table-author am-hide-sm-only">单元号</th>
				<th class="table-date am-hide-sm-only">楼层</th>
				<th class="table-set">申请机构</th>
				<th class="table-set">操作人</th>
				<th class="table-set">申请时间</th>
				<th class="table-set">维修大项</th>
				<th class="table-set">承租人</th>
				<!--<th class="table-set">建筑面积</th>
				<th class="table-set">原价</th>-->
				<th class="table-set" style="width:220px;">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
      <form id="query" action="<?php echo url('BanInfo/index'); ?>" method="post">
		    <tr class="am-form-group am-form-inline am-form">
              <td></td>
              <td></td>
              <td>
                <div class="am-input-group am-input-group-sm">
                  <input name="BanID" type="text" class="am-form-field" value="">
                </div>
          	  </td>
              <td>
                <div class="am-input-group am-input-group-sm">
                  <input name="HouseID" type="text" class="am-form-field" value="">
                </div>
              </td>
              <td>
                <div class="am-form-group search_input">
                    <select name="TubulationID" id="doc-select-2">
                        <option  value="" style="display:none">请选择</option>
                            <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
          		</td>
              <td>
                  <div class="am-form-group search_input">
                      <select name="OwnerType" id="doc-select-5">
                          <option  value="" style="display:none">请选择</option>
                          <option value="" ></option>
                      </select>
                  </div>
          		</td>
              <td>
                <div class="am-input-group am-input-group-sm">
                  <input name="BanAddress" type="text" class="am-form-field">
                </div>
              </td>
              <td>
                <div class="am-input-group am-input-group-sm">
                  <input name="BanYear" type="text" class="am-form-field" value="">
                </div>
              </td>
              <td>
                    <!--<div class="am-form-group am-select-group-sm">-->
                      <!--<select name="DamageGrade">-->
                        <!--<option>中国</option>-->
                        <!--<option>武汉</option>-->
                      <!--</select>-->
                    <!--</div>-->
                      <div class="am-form-group search_input">
                          <select name="DamageGrade">
                              <option  value="" style="display:none">请选择</option>
                              <option value="" ></option>
                          </select>
                      </div>

          			  </td>
          			  <td>
                     <div class="am-form-group search_input am-input-group-sm" style="width: 190px;">                                  
                          <div class="am-u-sm-6 " style="padding:0; ">
                                <input style="width:90px;margin: 0; " name="CreateTime[0]" type="text" class="am-form-field" data-am-datepicker value="">
                          </div>
                          <div class="am-u-sm-6" style="padding:0;">
                                <input style="width:90px;margin: 0; " name="CreateTime[1]" type="text" class="am-form-field" data-am-datepicker value="">
                          </div>
                      </div>
                  </td>
          			  <td>
                    <div class="am-form-group search_input">
                        <select name="UseNature" id="doc-select-7">
                            <option  value="" style="display:none">请选择</option>
                            <option value=""></option>
                        </select>
                    </div>
                  </td>
          			  <td></td>
              <td>
                <button id="queryBtn" class="am-btn am-btn-xs am-text-secondary" style="border:1px solid #e6e6e6;">查询</button>
                <a class="am-btn am-btn-xs am-text-secondary" style="border:1px solid #e6e6e6;background:#FFF;" href="/ph/RepairExamine/index.html">重置</a>

              </td>
            </tr>
          </form>
		<!---查询-->

            <tr class='check001'>
                <td>
                	<span class="piaochecked">
                			<input class="checkId radioclass"  type="radio" name='choose' value=""/>
                	</span>
                </td>
                <td></td>
                <td></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td class="am-hide-sm-only"></td>
                <td><a href="#"></a></td>
              <td>
                  <div class="am-btn-group am-btn-group-xs">
                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary details detailsBtn" value=""> 明细</button>
                    <button class="am-btn am-btn-default am-btn-xs am-text-secondary am-hide-sm-only addMaterial" value="">审批</button>
                  </div>
              </td>
            </tr>
          </tbody>
        </table>
		<div class="am-cf">
		  共9527条记录
		  <div class="am-fr">
             这里是分页
		  </div>
		</div>
      </div>
    </div>
  </div>

  <form id="detailForm" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style houseAddress">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋地址：</label>
    </div>
     <label class="p_style">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">单元号：</label>
    </div>
     <label class="p_style">010203040506</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">使用性质：</label>
    </div>
     <label class="p_style tenantName">冬冬</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">完损等级：</label>
    </div>
     <label class="p_style tenantTel">一般损坏</label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">房屋类型：</label>
    </div>
     <label class="p_style tenantNumber">010203040506</label>
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">预算金额：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">修前：</label>
    </div>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">栋数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">层数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">户数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">修后：</label>
    </div>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">栋数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">层数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">户数：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-6">
    <div class="am-u-md-3">
      <label class="label_style">建筑面积：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">开工时间：</label>
    </div>
     <label class="p_style tenantNumber">5</label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">维修内容：</label>
    </div>
     <label class="p_style tenantNumber">外墙漏水</label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">图纸：</label>
    </div>
     <img style="width:200px;height:100px;border:1px solid red;" src="" />
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">维修方案：</label>
    </div>
     <img style="width:200px;height:100px;border:1px solid red;" src="" />
  </div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-6">
      <label>审批状态：</label>
    </div>
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

<form id="approveForm" style="margin-top:1.6rem;display:none;">

</form>
  <!-- content end -->


</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <p style="text-align:center;margin:0;padding:1rem 0;background:#0e90d2;color:#FFF;">© 2017 CTNM.</p>
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
ul_dom.width($('.check001').width());
for(var i = 0;i < head_title_length;i++){
  var li_dom = $('<li></li>');
  li_dom.append($('.table-main thead th').eq(i).text());
  li_dom.width($('.table-main tbody tr:eq(1) td:eq('+i+')').width());
  ul_dom.append(li_dom);
}
ul_dom.css({'position':'fixed','top':'0','z-index':'1000','background':'#0e90d2','color':'#FFF','display':'none','margin-left':'6px'});
$('.am-scrollable-horizontal').prepend(ul_dom);
$(document).scroll(function(){
  var body_scrollTop = $(document).scrollTop();
  if(body_scrollTop - thead_height > 0){
    $('.am-scrollable-horizontal ul').eq(0).css({'display':'block'});
   }else{
      $('.am-scrollable-horizontal ul').eq(0).css({'display':'none'});
  }
})

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

</script>

<script type="text/javascript" src="/public/static/gf/viewJs/repair_examine.js"></script>

</body>
</html>