<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:59:"D:\phpStudy\WWW\ph/application/ph\view\map_query\index.html";i:1524126854;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1526551061;s:41:"application/ph/view/map_query/detail.html";i:1523846105;s:47:"application/ph/view/map_query/house_detail.html";i:1523846105;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>地图查询</title>
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
    #offCanvas{margin-left: 50px;}
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
    <button class="am-btn am-btn-xs am-btn-secondary" id="offCanvas" data-value="false">隐藏侧边栏</button>
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
  
	<link rel="stylesheet" type="text/css" href="/public/static/gf/css/map.css">
	<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=2xlodrKVRyFNeopCajiMTfgIOr8dnUAe"></script>
	<!--  <script type="text/javascript" src="http://lbsyun.baidu.com/jsdemo/data/points-sample-data.js"/> -->

	<title></title>
</head>
<body>
    <div id="allmap" style="height:950px;"></div>
    <div  style="position: absolute;right:60px;top: 51px;">
		<?php if(session('user_base_info.institution_level')!=3){ ;?>
		<select class="check" name="TubulationID" id="doc-select-2">
			<option  value="" style="display:none" id="name2">机构名称</option>
			<?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; ?>

			<option value="<?php echo $v10['id']; ?>"><?php echo $v10['Institution']; ?></option>
			<?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ; ?>

			<option value="<?php echo $v12['id']; ?>" ><?php echo $v12['Institution']; ?></option>
			<?php }}} ; ?>
		</select>
		<select class="check" name="OwnerType" id="doc-select-5">
			<option  value="" style="display:none">产别</option>
			<?php foreach($owerLst as $k3 =>$v3){;?>
			<option value="<?php echo $v3['id']; ?>"><?php echo $v3['OwnerType']; ?></option>
			<?php }; ?>
		</select>
	</div><!-- 搜索  -->
	<div class="contentM">
		<div class="am-u-md-12 pd0 ">
		<div class="tit">地图查询</div>
		<div class="cha"><img src="/public/static/gf/icons/cha.png" width="100%" id="cha2"/></div>
		</div>
		<div class="pd10 fontS">
		<div class="am-u-md-12" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-6 basic_msg">楼栋基本信息</label> 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">楼栋编号：</label>
			  <div class="am-u-md-8" style="padding:7px; " id="BanID"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">楼栋地址：</label>
			  <div class="am-u-md-8" style="padding: 7px;  " id="BanAddress"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">机构名称：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="TubulationID" id="TubulationID"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg" >产别：</label>
			  <div class="am-u-md-8" style="padding:7px; " id="OwnerType"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg" >产权证号：</label>
			  <div class="am-u-md-8" style="padding: 7px;" id="BanPropertyID"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg" >完损等级：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="DamageGrade"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">结构类别：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="StructureType"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">使用性质：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="UseNature"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg" >建成年份：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="BanYear"></div>
			 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px; ">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">原价：</label>
			  <div class="am-u-md-8" style="padding:7px; "></div>		 			
		</div>
		<div class="am-u-md-4" style="padding-left: 10px; ">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg" >合建面：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="TotalOprice"></div>		 			
		</div>
		
		<div class="am-u-md-4" style="padding-left: 10px; float: left;">
			  <label for="doc-select-8" class="am-u-md-4 basic_msg">产权来源：</label>
			  <div class="am-u-md-8" style="padding: 7px; " id="PropertySource"></div>		 			
		</div>
		<div class="ban-btn">
			  <input type='button' value='明细' class='f12 detail-btn' id="check_btn" />
			 			
		</div>
		<div class="am-u-md-12 basic_h"></div>
		<div class="am-u-md-12" style="padding: 0;" id="oDiv">
			<div class="am-u-md-12" style="padding-left: 10px;">
			  <label for="doc-select-8" class="am-u-md-6 basic_msg">房屋基本信息</label> 			
			</div>
			<ul style="width: 17%;" class="map_p" id="HouseID">
				<li class="text-bold">房屋编号</li>
				
			</ul>
			<ul style="width: 15%;" class="map_p" id="TenantName">
				<li class="text-bold">租户姓名</li>
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="UseNatured">
				<li class="text-bold">使用性质</li>
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="DoorID">
				<li class="text-bold">门牌号码</li>
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="UnitID">
				<li class="text-bold">单元号</li>
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="FloorID">
				<li class="text-bold">楼层号</li>
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="UseArea">	
				<li class="text-bold">使用面积</li>
				
				
			</ul>
			<ul style="width: 10%;" class="map_p" id="RegularPrice">
				<li class="text-bold">规定租金</li>
				
				
			</ul>
			<ul style="width: 8%;" class="map_p" id="DetailM">
				<li class="text-bold">操作</li>
				
			</ul>
		
		</div>
		</div>
	</div>
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
			  <div  class="am-u-md-8" style="float:left;">
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
			<img class="am-form-group am-u-md-12" id="detailImgThree" src="" style="width:310px;height:150px;float:left;">
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
			  <label for="doc-select-8" class="label_style">历史优秀建筑：</label>
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
			  <label for="doc-select-8" class="label_style">文物保护单位：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ProtectculturalIf"></p>
			  </div>
			</div>	
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">产权是否分割：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="CutIf"></p>
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
			<div class="am-form-group am-u-md-12" id="allMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;">

			</div>
		</div>
	  </fieldset>
  </div>
	<div id="houseDetail" class="am-form" style="display:none;margin-top:1.6rem;">

	  <fieldset style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-8">
				<p class="detail_p_style" id="BanID">加载中</p>
			  </div>
			</div>

		
			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-select-2" class="label_style">机构名称：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="InstitutionID">加载中</p>
			  </div>
			</div> -->

			<div class="am-form-group am-u-md-12">

				<label for="doc-vld-email-2" class="label_style">单元号：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="UnitID">加载中</p>
				</div>

			</div>

			<div class="am-form-group am-u-md-12">

			  <label for="doc-select-4" class="label_style">楼层号：</label>
			  <div  class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="FloorID">加载中</p>
			  </div>
			</div>
			
		<!-- 	<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">产权证号：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="HousePID">加载中</p>
			  </div>
			</div>	 -->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">门牌号码：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="DoorID">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">房屋编号：</label>
			  <div class="am-u-md-8">
				<p class="detail_p_style" id="HouseID">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">使用性质：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="UseNature">加载中</p>
			  </div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">泵费：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="PumpCost">加载中</p>
			  </div>
			</div>		
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">维修费：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="RepairCost">加载中</p>
			  </div>
			</div>				
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">房屋基数：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="HouseBase">加载中</p>
			  </div>
			</div> -->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">计算原价：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="OldOprice">加载中</p>
			  </div>
			</div>
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">是否住改非：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="NonliveIf">加载中</p>
			  </div>
			</div>	

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">租户ID：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantID">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">房屋影像：</label>
					<img style="width:300px;height:130px;" src="" id="HouseImageIDS" alt="图片走丢了^-^">
			</div>	
		</div>

		
		
<!--左右分割-->		
		
		
		<div class="am-u-md-6">	
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">实际原价：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="Oprice">加载中</p>
			  </div>
			</div>	 -->
			
<!-- 

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">欠租原因：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="ArrearrentReason">加载中</p>
				</div>
			</div> -->

			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-7" class="label_style">信息录入状态：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
					<!--<p class="detail_p_style" id="InputStatus">加载中</p>-->
			  <!--</div>-->
			<!--</div>-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">计租面积：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="LeasedArea">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">使用面积：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="HouseUsearea">加载中</p>
			  </div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">规定租金：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="HousePrerent">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-url-2" class="label_style">应收租金：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="ReceiveRent">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">减免租金：</label>
			  <div class="am-u-md-8">
					<p class="detail_p_style" id="RemitRent">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">欠租情况：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ArrearRent">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">户建面：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="HouseArea">加载中</p>
			  </div>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">套内建面：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>


			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">墙布（纸）护墙板：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">瓷砖、马赛克、地板砖：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">浴盆：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">面盆：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">空间1至1.7米(5㎡以下)：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">阁楼(含1.7米)(5㎡以上)：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">其他应收款：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
					<!--<p class="detail_p_style" id="OPayments">加载中</p>-->
			  <!--</div>-->
			<!--</div>-->
			<!---->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">金额：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
					<!--<p class="detail_p_style" id="Payment">加载中</p>-->
			  <!--</div>-->
			<!--</div>-->
			
		</div>
	  </fieldset>
  </div>
</body>
<script type="text/javascript" src="/public/static/gf/viewJs/mapQuery.js"></script>
</html>


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
$('.am-scrollable-horizontal').scroll(function(){
  var scroll_left = $('.am-table').offset().left;
  $('.title_ul').css('left',scroll_left);
  console.log(scroll_left);
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
  // header头部点击显示或隐藏 开始
  $('#offCanvas').click(function(){
    var data_value = $(this).attr('data-value');
    console.log(data_value);
    if(data_value == 'false'){
      $('.admin-sidebar').hide();
      $(this).attr('data-value','true').text('显示侧边栏');
    }else{
      $('.admin-sidebar').show();
      $(this).attr('data-value','false').text('隐藏侧边栏');
    }
  })
  // header头部点击显示或隐藏 结束
</script>

<script type="text/javascript" src="/public/static/gf/viewjs/index_notice_page.js"></script>

</body>
</html>