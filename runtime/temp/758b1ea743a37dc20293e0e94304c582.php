<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:72:"/usr/share/nginx/publichouse/application/ph/view/repair_light/index.html";i:1528342025;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1566211566;s:44:"application/ph/view/repair_light/detail.html";i:1528342025;s:47:"application/ph/view/form/small_repair_form.html";i:1528342025;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1569149220;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>小修</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="/public/static/gf/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="/public/static/gf/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="" />
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.min.css?v=<?php echo $version; ?>"/>
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css?v=<?php echo $version; ?>"/>
  <link rel="stylesheet" href="/public/static/gf/css/admin.css?v=<?php echo $version; ?>">
  <style>
    .am-topbar-nav>li>a:after{display:none;}
    body .ddd-class .layui-layer-title{background:#FFF;font-size:20px;}
    body .ddd-class .layui-layer-btn0{border-top:1px solid #E9E7E7}
    .div_input{text-align:center;}
    .div_input label{width:120px;display:inline-block;vertical-align:middle;text-align:right;font-size:20px;color:#999;font-weight:500;}
    .div_input input{height:35px;padding:5px;margin:10px 0;display:inline-block;vertical-align:middle;border:1px solid #ccc;border-radius:4px;}
    #offCanvas{margin-left: 44px;}

    #userName{color:#FFF;}
    .indexhover>a:hover {
      color: #fff;
      opacity:0.78;
    }
    
  </style>
  
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/public/static/gf/js/jquery.min.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/gf/layer/layer.js?v=<?php echo $version; ?>"></script>

<!--<![endif]-->
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，系统暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header am-print-hide">
  <div class="am-topbar-brand">
    <strong><span class="indexhover"><a href="/">武房网公房管理系统</a></span></strong>
    <button class="am-btn am-btn-xs am-btn-secondary am-icon-bars" id="offCanvas" data-value="false"></button>
  </div>
  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li><a href="javascript:;" class="olineOrder"><span class="am-icon-envelope-o"></span> 工单 <span class="am-badge am-badge-warning"></span></a></li>
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
<div class="admin-content am-print-hide" style="display:none;"></div>
  <!-- content start -->
  
  <!-- content start -->
  <div class="admin-content am-print-hide">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <small class="am-text-sm">维修管理</small> > 
        <small class="am-text-primary">小修</small>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
              <?php if(in_array(45,$threeMenu)){ ; ?>
            <button type="button" id="addMRepair" class="am-btn d-btn-1188F0 am-radius"><span class="am-icon-plus"></span> 维修等级调整</button>
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
        <th class="table-set">联系电话</th>
      <!--  <th class="table-set">原价</th>-->
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
                  <td><div style="width:70px;"></div></td>
                  <td></td>
              <td><button id="queryBtn" class="am-btn am-btn-xs am-text-primary" style="border:1px solid #e6e6e6;">查询</button></td>
            </tr>
          </form>
    <!---查询-->

            <?php foreach($lightRepairList as $info){ ?>
            <tr class="check001">
                <td>
                	<span class="piaochecked">
                			<input class="checkId radioclass"  type="radio" name='choose' value=""/>
                	</span>
                </td>
                <td></td>
                <td><?php echo $info['BanID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['HouseID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['BanAddress']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['UnitID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['FloorID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['ApplyDepartment']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['Operator']; ?></td>
                <td class="am-hide-sm-only"><?php echo $info['ApplyTime']; ?></td>
                <td class="am-hide-sm-only">小修</td>
                <td class="am-hide-sm-only"><?php echo $info['TenantName']; ?></td>
                <td><?php echo $info['TenantTel']; ?></td>
                <td>
                    <div class="am-btn-group am-btn-group-xs" style="width:140px;">
                      <input type="text" hidden="hidden" value="<?php echo $info['ApplyID']; ?>">
                      <button class="am-btn am-btn-default am-text-primary am-btn-xs details detailsBtn" value="<?php echo $info['ApplyID']; ?>"> 明细</button>
                      <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only repairHandle addMaterial" value="<?php echo $info['ApplyID']; ?>">维修处理</button>
                      <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only" value="<?php echo $info['ApplyID']; ?>">验收</button>
                    </div>
                </td>
            </tr>
            <?php } ?>
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

  <div class="am-g tableForm">
	<div class="am-u-md-12">
		<h2 style="text-align:center;">房屋修理单</h2>
	</div>
	<div class="am-u-md-2">管养段：<span><input name="Institution" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">工程地点：<span><input name="BanAddress" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">产别：<span><input name="OwnerType" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">账号：<span><input name="AccountID" value="" style="width:120px;" /></span></div>
	<div class="am-u-md-2">编号：<span><input name="Number" value="" style="width:120px;" /></span></div>
	<div class="am-u-md-2">武汉市房地产公司</div>
	<table class="am-table am-table-bordered am-table-centered">
	    <thead>
	        <tr>
	            <th rowspan="2" colspan="1" class="am-text-middle">定额编号</th>
	            <th rowspan="2" colspan="3" class="am-text-middle">修理项目</th>
	            <th rowspan="2" class="am-text-middle">计量单位</th>
	            <th rowspan="2" class="am-text-middle">工程数量</th>
	            <th rowspan="2" class="am-text-middle">人工含量</th>
	            <th rowspan="2" class="am-text-middle">应乘系数</th>
	            <th rowspan="2" class="am-text-middle">定额工日</th>
	            <th rowspan="2" class="am-text-middle">实作工日</th>
	            <th rowspan="2" colspan="2" class="am-text-middle">材料名称</th>
	            <th rowspan="2" class="am-text-middle">单价</th>
	            <th rowspan="2" class="am-text-middle">单价</th>
	            <th rowspan="1" colspan="2">定额材料</th>
	            <th rowspan="1" colspan="4">实耗材料</th>
	        </tr>
	        <tr>
	            <th rowspan="1" colspan="1">数量</th>
	            <th rowspan="1" colspan="1">金额(元)</th>
	            <th rowspan="1" colspan="1">数量</th>
	            <th rowspan="1" colspan="1">金额(元)</th>
	            <th rowspan="1" colspan="1">数量<br/>(其中旧料)</th>
	            <th rowspan="1" colspan="1">金额(元)<br/>(其中旧料)</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr>
	            <td><input type="text" value="" name="QuotaNumber[0]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[0]" style="width:120px;">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[0]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[0]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" value="" name="QuotaNumber[1]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[1]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[1]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[1]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" name="QuotaNumber[2]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[2]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[2]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[2]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" name="QuotaNumber[3]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[3]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[3]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[3]" style="width:70px;" /></td>
	        </tr>
	        <tr>
				<td colspan="4">人工费(元)<span><input type="text" name="LaborCost" /></span></td>
				<td colspan="4">材料费(元)<span><input type="text" name="MaterialCost" /></span></td>
				<td colspan="4">赔偿住户费(元)<span><input type="text" name="CompanyToTenant" /></span></td>
				<td rowspan="2" colspan="4">合计<span><input type="text" name="Total" /></span></td>
				<td rowspan="2" colspan="4">备注<span><input type="text" name="Remark" /></span></td>
	        </tr>
	        <tr>
				<td colspan="4"><label class="am-u-sm-6" style="padding:0;">系数工资(元)</label><div class="am-u-sm-6" style="padding:0;"><input type="text" name="CoefficientSalary" /></div></td>
				<td colspan="4">管理费(元)<span><input type="text" name="ManageCost" /></span></td>
				<td colspan="4">住户赔偿费(元)<span><input type="text" name="TenantToCompany" /></span></td>
	        </tr>
	        <tr>
				<td colspan="2">设备增减</td>
				<td colspan="2"><input type="text" name="EquipmentChange"></td>
				<td colspan="2">合计</td>
				<td colspan="2"><input type="text" name="ECTotal"></td>
				<td colspan="2">人工费</td>
				<td colspan="2"><input type="text" name="ECLaborCost"></td>
				<td colspan="2">管理费</td>
				<td colspan="2"><input type="text" name="ECManageCost"></td>
				<td colspan="2">材料费</td>
				<td colspan="2"><input type="text" name="ECMaterialCost"></td>
	        </tr>
	        <tr>
				<td colspan="1">修理质量</td>
				<td colspan="5"><input type="text" name="RepairQuality" value=""></td>
				<td colspan="1">检查记载</td>
				<td colspan="5"><input type="text" name="InspectionRecord" value=""></td>
				<td colspan="1">住户意见</td>
				<td colspan="7"><input type="text" name="TenantOpinion" value=""></td>
	        </tr>
	    </tbody>
	</table>
	<div class="am-u-md-2">核算员：<input name="AccountingClerk" value="" style="width:150px"></div>
	<div class="am-u-md-2">房管员：<input name="CreateUserName" value="" style="width:150px"></div>
	<div class="am-u-md-2">修理员：<input name="Repairman" value="" style="width:150px"></div>
	<div class="am-u-md-2">日期：<input name="CreateTime" value="" style="width:150px"></div>
	<div class="am-u-md-2">承租人：<input name="TenantName" value="" style="width:150px"><input name="TenantID" value="" hidden="hidden" style="width:150px"></div>
	<div class="am-u-md-2">联系方式：<input name="TenantTel" value="" style="width:130px"></div>
</div>

  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">勘察照片：</label>
    </div>
     <img style="width:200px;height:100px;border:1px solid red;" src="" />
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-3">
      <label class="label_style">维修后照片：</label>
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

<form id="repairForm" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style houseAddress">010203040506</label>
  </div>

  <div class="am-g tableForm">
	<div class="am-u-md-12">
		<h2 style="text-align:center;">房屋修理单</h2>
	</div>
	<div class="am-u-md-2">管养段：<span><input name="Institution" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">工程地点：<span><input name="BanAddress" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">产别：<span><input name="OwnerType" value="" style="width:120px;"></span></div>
	<div class="am-u-md-2">账号：<span><input name="AccountID" value="" style="width:120px;" /></span></div>
	<div class="am-u-md-2">编号：<span><input name="Number" value="" style="width:120px;" /></span></div>
	<div class="am-u-md-2">武汉市房地产公司</div>
	<table class="am-table am-table-bordered am-table-centered">
	    <thead>
	        <tr>
	            <th rowspan="2" colspan="1" class="am-text-middle">定额编号</th>
	            <th rowspan="2" colspan="3" class="am-text-middle">修理项目</th>
	            <th rowspan="2" class="am-text-middle">计量单位</th>
	            <th rowspan="2" class="am-text-middle">工程数量</th>
	            <th rowspan="2" class="am-text-middle">人工含量</th>
	            <th rowspan="2" class="am-text-middle">应乘系数</th>
	            <th rowspan="2" class="am-text-middle">定额工日</th>
	            <th rowspan="2" class="am-text-middle">实作工日</th>
	            <th rowspan="2" colspan="2" class="am-text-middle">材料名称</th>
	            <th rowspan="2" class="am-text-middle">单价</th>
	            <th rowspan="2" class="am-text-middle">单价</th>
	            <th rowspan="1" colspan="2">定额材料</th>
	            <th rowspan="1" colspan="4">实耗材料</th>
	        </tr>
	        <tr>
	            <th rowspan="1" colspan="1">数量</th>
	            <th rowspan="1" colspan="1">金额(元)</th>
	            <th rowspan="1" colspan="1">数量</th>
	            <th rowspan="1" colspan="1">金额(元)</th>
	            <th rowspan="1" colspan="1">数量<br/>(其中旧料)</th>
	            <th rowspan="1" colspan="1">金额(元)<br/>(其中旧料)</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr>
	            <td><input type="text" value="" name="QuotaNumber[0]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[0]" style="width:120px;">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[0]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[0]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[0]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" value="" name="QuotaNumber[1]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[1]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[1]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[1]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[1]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" name="QuotaNumber[2]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[2]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[2]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[2]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[2]" style="width:70px;" /></td>
	        </tr>
	        <tr>
	            <td><input type="text" name="QuotaNumber[3]" style="width:53px;"></td>
	            <td colspan="3">
	            	<select name="ItemID[3]">
	            		<option>请选择</option>
						<option value="1">包扎水管</option>
						<option value="2">清洗消毒更换水箱</option>
						<option value="3">更换水管</option>
						<option value="4">更换水配件</option>
						<option value="5">更换电线</option>
						<option value="6">更换电配件</option>
						<option value="7">更换闸刀</option>
						<option value="8">化粪池改造</option>
						<option value="9">沟道改进</option>
						<option value="10">阴井改造</option>
						<option value="11">配阴井盖</option>
						<option value="12">更换大便器</option>
						<option value="13">疏通化粪池</option>
						<option value="14">疏通阴井</option>
						<option value="15">疏通管道</option>
						<option value="16">更换门窗</option>
						<option value="17">简修门窗</option>
						<option value="18">修补平顶</option>
						<option value="19">挖补木地板</option>
						<option value="20">加固木楼房</option>
						<option value="21">装配玻璃</option>
						<option value="22">更换藤条</option>
						<option value="23">更换瓦条</option>
						<option value="24">更换简沟</option>
						<option value="25">平屋面洽漏</option>
						<option value="26">布瓦更红瓦</option>
						<option value="27">红布瓦检漏</option>
						<option value="28">砍粉墙面</option>
						<option value="29">挖补地坪</option>
						<option value="30">其他维修</option>
	            	</select>
	            </td>
	            <td><input type="text" value="" name="UnitOne[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ProjectNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PersonNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="ratio[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreWorkdays[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealWorkdays[3]" style="width:70px;" /></td>
	            <td colspan="2"><input type="text" value="" name="MaterialName[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitTwo[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="UnitPrice[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="PreMaterialCost[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="RealMaterialCost[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialNum[3]" style="width:70px;" /></td>
	            <td><input type="text" value="" name="OldMaterialCost[3]" style="width:70px;" /></td>
	        </tr>
	        <tr>
				<td colspan="4">人工费(元)<span><input type="text" name="LaborCost" /></span></td>
				<td colspan="4">材料费(元)<span><input type="text" name="MaterialCost" /></span></td>
				<td colspan="4">赔偿住户费(元)<span><input type="text" name="CompanyToTenant" /></span></td>
				<td rowspan="2" colspan="4">合计<span><input type="text" name="Total" /></span></td>
				<td rowspan="2" colspan="4">备注<span><input type="text" name="Remark" /></span></td>
	        </tr>
	        <tr>
				<td colspan="4"><label class="am-u-sm-6" style="padding:0;">系数工资(元)</label><div class="am-u-sm-6" style="padding:0;"><input type="text" name="CoefficientSalary" /></div></td>
				<td colspan="4">管理费(元)<span><input type="text" name="ManageCost" /></span></td>
				<td colspan="4">住户赔偿费(元)<span><input type="text" name="TenantToCompany" /></span></td>
	        </tr>
	        <tr>
				<td colspan="2">设备增减</td>
				<td colspan="2"><input type="text" name="EquipmentChange"></td>
				<td colspan="2">合计</td>
				<td colspan="2"><input type="text" name="ECTotal"></td>
				<td colspan="2">人工费</td>
				<td colspan="2"><input type="text" name="ECLaborCost"></td>
				<td colspan="2">管理费</td>
				<td colspan="2"><input type="text" name="ECManageCost"></td>
				<td colspan="2">材料费</td>
				<td colspan="2"><input type="text" name="ECMaterialCost"></td>
	        </tr>
	        <tr>
				<td colspan="1">修理质量</td>
				<td colspan="5"><input type="text" name="RepairQuality" value=""></td>
				<td colspan="1">检查记载</td>
				<td colspan="5"><input type="text" name="InspectionRecord" value=""></td>
				<td colspan="1">住户意见</td>
				<td colspan="7"><input type="text" name="TenantOpinion" value=""></td>
	        </tr>
	    </tbody>
	</table>
	<div class="am-u-md-2">核算员：<input name="AccountingClerk" value="" style="width:150px"></div>
	<div class="am-u-md-2">房管员：<input name="CreateUserName" value="" style="width:150px"></div>
	<div class="am-u-md-2">修理员：<input name="Repairman" value="" style="width:150px"></div>
	<div class="am-u-md-2">日期：<input name="CreateTime" value="" style="width:150px"></div>
	<div class="am-u-md-2">承租人：<input name="TenantName" value="" style="width:150px"><input name="TenantID" value="" hidden="hidden" style="width:150px"></div>
	<div class="am-u-md-2">联系方式：<input name="TenantTel" value="" style="width:130px"></div>
</div>

  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>上传勘察照片：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="survey" type="file" name="survey" multiple>
        </div>
        <div id="surveyShow" class="am-u-md-12"></div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-sm-3">
      <label>上传维修后照片：</label>
    </div>
        <div class="am-form-group am-form-file am-u-md-5">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="afterHandle" type="file" name="afterHandle" multiple>
        </div>
        <div id="afterHandleShow" class="am-u-md-12"></div>
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
  <!-- content end -->


</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <p id="version_show" style="text-align:center;margin:0;padding:1rem 0;background:#EDEDED;color:#999;cursor:pointer;">© 2017 CTNM 楚天新媒技术支持 <span style="color:#1188F0;"><?php echo $web_version; ?></span></p>
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
      <label for="doc-ipt-pwd-1">楼栋地址：</label>
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
          <th>楼栋地址</th>
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
        <input type="text" id="houseThr" autocomplete="off">
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
            <th>规定租金</th>
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
			<h3>2019-9-20</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统<?php echo $web_version; ?>更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.产权统计（年）：新增加按年统计产权</p>
			<p class="fun_title">优化</p>
			<p>1.异动审核：异动审核中将需要登录人审核的异动排在上方，并且审核状态字段为蓝色加粗</p>
			<p>2.租约记录：租约记录页面申请时间搜索精确到月，并且列表中的租约申请时间精确到天</p>
			<p>3.租约失效：将已做的使用权变更异动的原租户的二维码变为失效</p>		
			<p>4.注销申请：注销申请填写时建筑面积、原价、计租面积、注销租金必填</p>		
			<p>5.租约记录：租约记录中，已失效的租约信息置灰显示</p>
			<p>6.暂停计租：已申请暂停计租的房屋无法再次申请暂停计租，无法选择并且置灰显示，存在欠租的房屋则标红显示</p>
			<p>7.系统公告时间：公告发布后，只修改置顶，文件发表时间不会改变，只有修改公告内容，发表时间才会发生变化</p>
			<p>8.使用权变更搜索条件：使用权变更申请、审核、记录列表都可根据原租户、现租户、使面、规租搜索</p>			
			<p>9.系统角色排序：系统角色按添加时间正序排列</p>		
			<p>10.异动审核：增加租金统计功能</p>		
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-9-12</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.12更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.陈欠核销页面：显示核销中金额（以前年和以前月之和），年份连选，选择以前月时，选中较大的月份前面的月份自动全部选中</p>	
			<p>2.使用权变更搜索：增加筛选条件“姓名”，可以输入变更后的租户姓名进行搜索使用权变更记录</p>	
			<p>3.使用权变更：使用权变更后，原租约二维码自动失效，使用权变更申请页面，红色提示语“使用权变更完成后，原租约自动失效”</p>
			<p>4.月租金报表检测：点击“缓存报表”，系统自动检测，并弹出提示信息，需要房管员手动点击关闭信息</p>
			<p>5.租约申请：租约申请页面提示语“租约申请成功后，原租约自动失效”</p>	
			<p>6.异动记录：异动记录列表新增“完成时间”字段（精确到月），可以根据完成时间搜索</p>	
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-8-30</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.11更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.忘记密码功能：用户忘记密码后，可通过手机接收验证码的方式重置密码</p>
			<p class="fun_title">优化</p>
			<p>1.异动记录：异动记录可对状态进行筛选查询</p>	
			<p>2.年度收欠：年度收欠列表中剔除月度收欠账单</p>	
			<p>3.租约记录：租约记录中的房屋层、居住层删去，新增租约申请时间字段</p>
			<p>4.月租金报表：生成月租金报表的时候检测并提示当前有XX条账单未处理</p>
			<p>5.公告发布时间：公告时间以第一次发布时间为准，后期修改公告，不改变发布时间</p>	
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-8-17</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.10更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.名称字段的统一：系统中的“房屋地址”全部改为“楼栋地址”</p>
			<p>2.租约打印：租约打印时，若为“老证换新证”，打印出的纸质租约仅显示最新一条“老证换新证”记录</p>
			<p>3.附件上传：注销业务中，房管员提交申请时，在附件上传中增加一个“其它”附件类型，用于上传其它附件</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-8-2</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.09更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.增加出证时间：房屋信息列表增加“出证时间”字段，显示最近一次出证时间，未出证则不显示</p>
			<p>2.租约审核增加失败功能：租约审核时，待审批流程走到最后一步“待房管员提交签字”时，增加房管员点击失败的功能，由房管员判断此条记录是成功还是失败</p>
			<p>3.楼栋地址调整：楼栋调整中新增楼栋地址调整，需要上传产权证／产权清册（以产权清册为准，必须上传）／经租帐／图卡</p>
			<p>4.数据自动触发刷新：楼栋层高调整后，计租表相关数据自动刷新</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-7-26</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.08更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.楼栋地址调整：楼栋调整中新增楼栋地址调整，需要上传产权证／划转清册</p>
			<p>2.房屋信息里删除“年度欠租”：房屋信息页面列表去掉“年度欠租”字段，查询欠租请到租金管理页面查询</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-7-19</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.07更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.审批记录：优化审批打回时，审批者的角色名称混乱</p>
			<p>2.异动名称：去除异动申请中无效和废弃的异动类型</p>	
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-7-12</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.06更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.房屋信息及数据确认：修复附件上传、更新、删除</p>
			<p>2.提示：系统中需要双击查询的都加上提示词</p>
			<p>3.异动：各异动关联的房屋和楼栋编号同步到异动统计表中便于后期导出</p>		
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-7-5</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.05更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.数据确认增加房管员删除权限</p>
			<p>2.异动前提条件设置-无欠租</p>
			<p>3.数据锁定：新发租申请后，数据确认中的楼栋、房屋、租户信息均不可修改</p>
			<p>4.权限新增：房管员新增数据确认中楼栋、房屋、租户的删除权限</p>
			<p class="fun_title">优化</p>
			<p>1.详情页优化：日志、流程配置、租户信息详情显示混乱</p>
			<p>2.翻页问题：计租表的欠租情况点入中翻页问题优化</p>
			<p>3.租金字段统一：系统中关于租金的字段命名统一</p>
			<p>4.数据确认中必填项优化：数据确认中楼栋的产权证号、租户的联系方式和身份证号设置为必填项</p>
			<p>5.增加营业和杂件类型：数据确认中的计租表增加营业和杂间类型，与房屋信息中保持一致</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-6-28</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.04更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.租金批量调整（仅针对楼层调整后）：因错层调整引起的租金变化<br>新增同一楼栋下房屋租金批量调整（(仅针对楼层调整后)<br>步骤和租金调整(0.2,0.3,0.4,0.5)一致</p>
			<p>2.别字更正：别字更正需要填写身份证号，且异动生效后身份证号自动更新至租户信息</p>
			<p>3.新发租：新发租申请时类型选择“接管／危改还建／新建／合建／加改扩／其他”<br>具体描述填写至“异动事由”</p>
			<p class="fun_title">优化</p>
			<p>1.月租金报表：只有房管所和区公司保留复合型产别筛选“市代托／市区代托／所有产别”即选择机构“XX所XX管段”<br>无法查看“市代托／市区代托／所有产别”月租金报表</p>
			<p>2.异动名称：异动名称按照使用频率排列</p>
			<p>3.申请租约按钮删除：租约记录中“申请租约”按钮去掉</p>
			<p>4.租户身份证上传：租户上传身份证页面优化</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-6-21</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.03更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.新发条件限制：房屋申请新发租必须满足两个条件，否则无法新发租：<br>a) 房屋已绑定租户 <br>b) 房屋已填写规定租金</p>
			<p>2.房屋信息列表增加“月租金字段”</p>
			<p class="fun_title">优化</p>
			<p>1.金额的统计：异动记录中统计“租金”</p>
			<p>2.泵费处理：<br>a) 泵费不设计计算公式，以后台录入数据为准 <br>b) 租约泵费显示与计租表保持一致 <br>c) 紫阳所部分泵费已上账</p>
			<p>3.规范租金相关字段：<br>a) 规定租金（房管员数据）= 房间租金之和 + 营业租金/协议租金 <br>b) 计算租金（系统数据）= 房间计算租金之和+营业租金/协议租金 <br>c) 月租金 = 规定租金（计算租金）+ 租差 + 泵费 <br>d) 应收租金 = 月租金 - 减免</p>
			<p>4.登录自动退出时长：登录误操作7200s（2小时）自动退出</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-6-14</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.02更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.计算租金统计：所有计算租金标红的房屋租金，在上方显示出统计金额（与规定租金的差值）</p>
			<p>2.暂停计租筛选：房屋信息中筛选暂停计租的房屋，列表置灰显示</p>
			<p>3.减免金额统计：租金计算中统计出减免总金额</p>
			<p>4.租金减免再申请：租金减免过程中减免金额调整，重新申请减免，之前的减免自动失效</p>
			<p class="fun_title">优化</p>
			<p>1.减免截止日期：本年度减免截止日期统一顺延至年底12月份</p>
			<p>2.管段／月份查询：异动记录增加增加管段、月份查询</p>
			<p>3.营业租金的填写：营业房间在其他房屋类型中显示，且有正常计算租金及面积，多余的租金填写在“营业”中，只需要填写房间号和规定租金</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-6-10</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.01更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.别字更正异动</p>
			<p>2.计租表增加杂间和营业类型的房间</p>
			<p class="fun_title">优化</p>
			<p>1.租约申请房屋层和居住层变为可修改项</p>
			<p>2.租金计算中，加入减免金额统计</p>
			<p>3.房屋调整异动增加房管员上传资料的功能</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2018-08-06</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5更新提醒</h3>
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
			<h3>2018-07-16</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.4更新提醒</h3>
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
			<h3>武房公房系统v1.3更新提醒</h3>
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
			<h3>武房公房系统v1.2更新提醒</h3>
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
			<h3>武房公房系统v1.1更新提醒</h3>
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
			<h3>武房公房系统v1.0更新提醒</h3>
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
<script src="/public/static/gf/js/amazeui.min.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/gf/js/app.js?v=<?php echo $version; ?>"></script>
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
  $('.olineOrder').click(function(){
    var username = "<?php echo session('user_base_info.name'); ?>";
    $.post('https://pro.ctnmit.com/admin.php/system/publics/index.html',{'username':username,'key':'iwejsdhenskh34kwe'},function(res){
          //res = JSON.parse(res);
          console.log(res);
          if(res.code){
            window.open(res.url+'?user_id='+res.user_id+'&secret='+res.key);
          }else{
            layer.msg(res.msg);
          }
          
        })
  })
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
<script type="text/javascript" src="/public/static/gf/viewJs/repair_light.js"></script>

</body>
</html>