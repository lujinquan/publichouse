<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:76:"/usr/share/nginx/publichouse/application/ph/view/confirm_ban_info/index.html";i:1560686457;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1573559825;s:46:"application/ph/view/confirm_ban_info/form.html";i:1563009962;s:48:"application/ph/view/confirm_ban_info/modify.html";i:1563009962;s:48:"application/ph/view/confirm_ban_info/detail.html";i:1533511343;s:55:"application/ph/view/confirm_ban_info/ban_structure.html";i:1533511343;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1578586810;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>楼栋确认</title>
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
      <?php if(false): ?> <li><a href="javascript:;" class="olineOrder"><span class="am-icon-envelope-o"></span> 工单 <span class="am-badge am-badge-warning"></span></a></li> <?php endif; ?>
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
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <small class="am-text-sm">数据确认管理</small> > 
        <small class="am-text-primary">楼栋确认</small>
      </div>
    </div>

      <div class="am-g">
          <div class="am-u-sm-12 am-u-md-6">
              <div class="am-btn-toolbar">
                  <div class="am-btn-group-xs">
                      <?php if(in_array(540,$threeMenu)){ ; ?>
                      <button type="button" id="addBan" class="am-btn d-btn-1188F0 am-radius"><span class="am-icon-plus"></span> 新增楼栋</button>
                      <?php }; if(in_array(506,$threeMenu)){ ; ?>
                      <button type="button" id="reviseBan" class="am-btn d-btn-1188F0 am-radius"><span class="am-icon-edit"></span> 修改楼栋</button>
                      <?php }; if(in_array(507,$threeMenu)){ ; ?>
                      <button type="button" id="deleteBan" class="am-btn d-btn-1188F0 am-radius"><span class="am-icon-trash-o"></span> 删除楼栋</button>
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
                <?php if(session('user_base_info.institution_level')!=3){ ;?>
        				<th class="table-type">机构名称</th>
                <?php }; ?>
        				<th class="table-author am-hide-sm-only">产别</th>
        				<th class="table-date am-hide-sm-only">楼栋地址</th>
        				<th class="table-set">产权证号</th>
        				<th class="table-set">建成年份</th>
        				<th class="table-set">完损等级</th>
        				<th class="table-set">结构类别</th>
        				<th class="table-set">使用性质</th>
                        <th class="table-set">合建面</th>
        				<th class="table-set">规定租金</th>
        				<th class="table-set" style="width:220px;">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
      <form action="<?php echo url('ConfirmBanInfo/index'); ?>" method="post" id="queryForm" autocomplete="off">
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
              <?php if(session('user_base_info.institution_level')!=3){ ;?>
              <td>
                <div class="am-form-group search_input">
                    
                    <select name="TubulationID" id="doc-select-2">
                        <option  value="" style="display:none">请选择</option>
                        <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 
                                if($banOption != array()){
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
                        <?php }}}elseif(session('user_base_info.institution_level')==2){; foreach($instLst as $k12 => $v12){ ; 
                                if($banOption != array()){
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
                        <?php }} ; ?>
                    </select>
                </div>
          		</td>
              <?php } ; ?>
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
                  <input name="BanAddress" type="text" class="am-form-field">
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
              <td class="dong_none">
                <div class="am-input-group am-input-group-sm" style="width:150px;">
                    <?php
                         if($banOption != array()){
                            $BanYear = $banOption['BanYear'];
                        }else{
                            $BanYear = '';
                        }
                     ?>
                    <input style="width:140px;" name="BanYear" value="<?php echo $BanYear; ?>" type="text" class="am-form-field" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" >
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
                            <?php foreach($struLst as $k4 =>$v4){;
                                if($banOption != array()){
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
                <td class="dong_none">
                    <div class="am-input-group am-input-group-sm">
                        <?php
                        if($banOption != array()){
                            $TotalArea = $banOption['TotalArea'];
                        }else{
                            $TotalArea = '';
                        }
                     ?>
                        <input name="TotalArea" type="text" class="am-form-field" value="<?php echo $TotalArea; ?>">
                    </div>
                </td>
          			  <td><div style="width:50px;"></div></td>
              <td>
                <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a id="clearBanInfo" class="am-btn am-btn-xs am-text-primary ABtn" href="<?php echo url('ConfirmBanInfo/index'); ?>"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
          </form>
		<!---查询-->

          <?php foreach( $banLst as $k => $v){ ;?>
            <tr class="check001">
                <td>
                  <span class="piaochecked">
                    <input class="checkId radioclass" type="radio" name='choose' value="<?php echo $v['BanID']; ?>" />
                  </span>
                </td>
                <td><?php echo ++$k; ?></td>
                <td><?php echo $v['BanID']; ?></td>
                <?php if(session('user_base_info.institution_level')!=3){ ;?>
                <td class="am-hide-sm-only"><?php echo $v['TubulationID']; ?></td>
                <?php }; ?>
                <td class="am-hide-sm-only"><?php echo $v['OwnerType']; ?></td>
                <td class="am-hide-sm-only">
                  <p style="height:18px;margin:10px 0 0;padding:0;line-height:18px;"><?php echo $v['BanAddress']; ?></p>
                </td>
                <td class="am-hide-sm-only"><?php echo $v['BanPropertyID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['BanYear']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['DamageGrade']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['StructureType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['UseNature']; ?></td>
                <td><?php echo $v['TotalArea']; ?></td>
                <td><?php echo $v['PreRent']; ?></td>
              <td>
                  <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                      <?php if(in_array(54,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-text-primary am-btn-xs details details_btn" value="<?php echo $v['BanID']; ?>"> 明细</button>
                      <?php }; if(in_array(56,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only structureBtn" value="<?php echo $v['BanID']; ?>">结构</button>
                      <?php }; if(in_array(61,$threeMenu)){ ; ?>
                      <a href="<?php echo url('ConfirmHouseInfo/index',['BanID'=>$v['BanID'],]); ?>" class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only ABtn" > 房屋</a>
                      <?php }; if(in_array(514,$threeMenu)){ ; ?>
                      <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only ConfirmBanBtn" value="<?php echo $v['BanID']; ?>">确认</button>
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
      </div>
    </div>
  </div>
  <div id="deleteChoose" style="display:none; text-align: center; margin: 20px;">
      <button id="HouseChange" class="am-btn am-btn-secondary " value="10" name="banDeleteType" style="background: #0086ff;border:none">房改</button>
      <button id="HouseRemove" class="am-btn am-btn-secondary" value="11" name="banDeleteType" style="background: #0086ff;border:none">拆迁，已注销</button>
      <button id="DateTogther" class="am-btn am-btn-secondary" value="12"  name="banDeleteType"style="background: #0086ff;border:none">数据合并</button>
      <button id="DateLose" class="am-btn am-btn-secondary" value="13"  name="banDeleteType"style="background: #0086ff;border:none">数据作废</button>
  </div>
  <style>
	input[type=number][readonly].disable_class{background:#CCC;}
</style>
<form  id="banForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">
	  <fieldset id="InputForm" style="width:780px;">

		<div class="am-u-md-12">
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" style="float:left;">楼栋地址：</label>&nbsp;&nbsp;&nbsp;
				<div class="inline_70">
					<select ><option>武昌区</option></select>
				</div>
				<div style="width:120px;" class="inline_70">
					<select name="AreaTwo" id="AreaTwo" required>
						<option  value="" style="display:none">请选择街道</option>
					</select>
				</div>
				<div style="width:120px;" class="inline_70">
					<select name="AreaThree" id="AreaThree" required>
						<option  value="" style="display:none">请选择社区</option>
					</select>
				</div>
				<input type="text" name="AreaFour" style="width:215px;display:inline-block;" required/>
				&nbsp;&nbsp;&nbsp;&nbsp;<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
		</div>
		<div class="am-u-md-6">
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
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<?php }; ?>

			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">栋号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="BanNumber" minlength="1" placeholder="" required/>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<!-- <div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">原编号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="OldBanID" minlength="1" placeholder="" required/>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">企业建面：</label>
			  <div class="am-u-md-8">
				<input type="number" name="EnterpriseArea" class="disable_class" value="0" minlength="1" placeholder="系统计算获取" readonly="readonly" />
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">企业规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseRent" class="disable_class" value="0" minlength="1"  placeholder="系统计算获取" readonly="readonly"/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">企业原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseOprice" class="disable_class" value="0" minlength="1"  placeholder="系统计算获取" readonly="readonly"/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">企业栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseNum" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label class="label_style">机关建面：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyArea" class="disable_class" value="0" placeholder="系统计算获取" readonly="readonly"/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">机关规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyRent" class="disable_class" value="0" minlength="1" placeholder="系统计算获取" readonly="readonly" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">机关原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyOprice" class="disable_class" value="0" minlength="1" placeholder="系统计算获取" readonly="readonly" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">机关栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyNum" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>


			<div class="am-form-group am-u-md-12">
			  <label class="label_style">民用建面：</label>
			  <div class="am-u-md-8">
				<input type="number" name="CivilArea" class="disable_class" value="0" placeholder="系统计算获取" readonly="readonly" />
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">民用规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilRent" class="disable_class" value="0" minlength="1" placeholder="系统计算获取" readonly="readonly" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">民用原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilOprice" class="disable_class" value="0" minlength="1" placeholder="系统计算获取" readonly="readonly" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label class="label_style">民用栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilNum" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style">使用面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUsearea" class="disable_class" value="0" placeholder="系统计算获取" readonly="readonly" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style">楼栋租金：</label>
				<div class="am-u-md-8">
					<input type="number" name="PreRent" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style">楼栋原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalOprice" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div> -->

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">占地面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="CoveredArea" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">证载面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="ActualArea" placeholder=""/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label  class="label_style">产权证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanPropertyID" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">土地证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanLandID" />
				</div>
			</div>

			<!-- <div class="am-form-group am-u-md-15">
			  <label for="doc-select-12" class="label_style">拆迁状态：</label>
			  <label class="am-radio-inline">
				<input type="radio"  value="1" checked="checked" name="RemoveStatus" required> 未拆迁
			  </label>
			  <label class="am-radio-inline">
				<input type="radio" value="2" name="RemoveStatus"> 已拆未下基数
			  </label>
			  <label class="am-radio-inline">
				<input type="radio" value="3" name="RemoveStatus">已拆下基数
			  </label>
			</div> -->

			<!-- <div class="am-u-md-8">
				<label class="am-radio-inline">
					<input type="radio"  value="1" name="ReformIf" required> 是
				</label>
				<label class="am-radio-inline">
					<input type="radio" value="0" name="ReformIf" checked="checked" > 否
				</label>
			</div> -->
		</div>

		<div class="am-u-md-6">

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-4" class="label_style">完损等级：</label>
				<div  class="am-u-md-8" style="float:left;">
					<select name="DamageGrade" required>
						<option  value="" style="display:none">请选择</option>
						<?php foreach($damaLst as $k2 =>$v2){;?>
						<option value="<?php echo $v2['id']; ?>"><?php echo $v2['DamageGrade']; ?></option>
						<?php }; ?>
					</select>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">

			  <label for="doc-select-5" class="label_style">楼栋产别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="OwnerType" required>
					<option  value="" style="display:none">请选择</option>
					<?php foreach($owerLst as $k3 =>$v3){;?>
					<option value="<?php echo $v3['id']; ?>"><?php echo $v3['OwnerType']; ?></option>
					<?php }; ?>
				</select>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">使用性质：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="UseNature" required class="">
					<option  value="" style="display:none">请选择</option>
					<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
					<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
					<?php }; ?>
				</select>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">结构类别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="StructureType" required>
					<option  value="" style="display:none">请选择</option>
						<?php foreach($struLst as $k4 =>$v4){;?>
						<option value="<?php echo $v4['id']; ?>"><?php echo $v4['StructureType']; ?></option>
						<?php }; ?>
				</select>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label  class="label_style">建成年份：</label>
				<div class="am-u-md-8" data-am-validator>
					<input type="text" name="BanYear" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUnitNum" placeholder="" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorNum" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">起始楼层：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorStart" />
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">拆迁状态：</label>
				<div class="am-u-md-8">
					<select name="RemoveStatus">
						<option value="1">未拆迁</option>
						<option value="2">已拆未下基数</option>
						<option value="3">已拆且下基数</option>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">建筑状态：</label>
				<div class="am-u-md-8">
					<select name="HistoryIf">
						<option value="0">非优秀</option>
						<option value="1">省级</option>
						<option value="2">市级</option>
						<option value="3">区级</option>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">电梯状态：</label>
				<div class="am-u-md-8">
					<select name="IfElevator">
						<option value="0">无电梯</option>
						<option value="1">有电梯且免费</option>
						<option value="2">有电梯需缴费</option>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">产权来源：</label>
				<div class="am-u-md-8">
					<input type="text" name="PropertySource" placeholder="" />
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label  class="label_style">不动产证：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanFreeholdID"  />
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">总户数：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalHouseholds"  />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">栋系数：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanRatio" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" style="float:left;">是否改造产：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ReformIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ReformIf" checked="checked" > 否
					</label>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否文物保护：</label>
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
			  <div class="am-u-md-6">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="CutIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="CutIf" checked="checked" > 否
					</label>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfFirst" value="1" />
				<label>居住第一层有架空层或木地板住房</label>
			</div>
		</div>

		<hr class="am-u-md-11"/>



		
		<div class="am-u-md-6 j-upload">
			<input id="currentId" hidden value="">
			<div class="am-form-group am-u-md-12">
			  <label style="float:left;">土地证电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="LandCertificate" id="LandCertificate" multiple>
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="LandShow" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label style="float:left;">不动产电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="RealEstate" id="RealEstate" multiple>
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="EstateShow" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="BanImageIDS" id="imageUp" multiple>
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="imgShow" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>
		</div>

		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style" >经纬度：</label>
				<div class="am-u-md-8">
					<input type="text" class="" name="xy" id="getPosition" placeholder="" required />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12" id="FormMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;"></div>
		</div>
		
	
	  </fieldset>
  </form>
  <form action="<?php echo url('BanInfo/edit'); ?>" method="post" id="modifyForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-12">
			<div class="am-form-group am-u-md-12">
				<label>楼栋地址：</label>&nbsp;&nbsp;&nbsp;
				<div class="inline_70">
					<select ><option>武昌区</option></select>
				</div>
				<div style="width:120px;" class="inline_70">
					<select name="AreaTwo" id="AreaTw" required>
						<option  value="" style="display:none">请选择</option>
					</select>
				</div>
				<div style="width:120px;" class="inline_70">
					<select name="AreaThree" id="AreaThre" required>
						<option  value="" style="display:none">请选择</option>
						<?php foreach($areaThree as $k16 =>$v16){;?>
						<option value="<?php echo $v16['id']; ?>"><?php echo $v16['AreaTitle']; ?></option>
						<?php }; ?>
					</select>
				</div>
				<input type="text" name="AreaFour" id="AreaFou" style="width:215px;display:inline-block;" required/>
				&nbsp;&nbsp;&nbsp;&nbsp;<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
		</div>
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-8">
				<input type="number" onfocus=this.blur() name="BanID" id="BanID" required/>
			  </div>
<!-- 			  <label>
		        <input type="radio" name="BanSysID" value="1" checked>主楼栋
		      </label> -->
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
				<div class="am-u-md-7">
					<input type="number" name="AnathorBanID" id="AnathorBanID" />
				</div>
				<label>
			        <input type="radio" name="BanSysID" value="2" />主楼栋
			     </label>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">栋号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="BanNumber" id="BanNumber" required/>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<!-- <div class="am-form-group am-u-md-12">
			  <label for="" class="label_style">原编号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="OldBanID" id="OldBanID" required/>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div> -->

			<?php if(session('user_base_info.institution_level') < 3){;?>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">机构名称：</label>
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
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<?php }; ?>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">企业建面：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseArea" class="disable_class" id="EnterpriseArea" minlength="1" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">企业规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseRent" class="disable_class" id="EnterpriseRent" minlength="1" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">企业原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseOprice" class="disable_class" id="EnterprisePrice" minlength="1" readonly="readonly"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">企业栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="EnterpriseNum" id="EnterpriseNumber" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">机关建面：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyArea" class="disable_class" id="PartyArea" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">机关规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyRent" class="disable_class" id="PartyRent" minlength="1" readonly="readonly"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">机关原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyOprice" class="disable_class" id="PartyPrice" minlength="1" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">机关栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="PartyNum" id="PartyNumber" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">民用建面：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilArea" class="disable_class" id="CivilArea" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">民用规租：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilRent" class="disable_class" id="CivilRent" minlength="1" readonly="readonly"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">民用原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilOprice" class="disable_class" id="CivilPrice" minlength="1" readonly="readonly"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">民用栋数：</label>
				<div class="am-u-md-8">
					<input type="number" name="CivilNum" id="CivilNumber" minlength="1"  required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">使用面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUsearea" class="disable_class" id="BanUsearea" readonly="readonly" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">楼栋租金：</label>
				<div class="am-u-md-8">
					<input type="number" name="PreRent" id="PreRent" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div> -->

<!-- 			<div class="am-form-group am-u-md-12">
				<label for="" class="label_style">楼栋原价：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalOprice" id="TotalOprice" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div> -->

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">占地面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="CoveredArea" id="editCoveredArea" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">证载面积：</label>
				<div class="am-u-md-8">
					<input type="number" name="ActualArea" id="editActualArea" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">产权证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanPropertyID" id="BanPropertyID" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">土地证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanLandID" id="BanLandI" />
				</div>
			</div>			
			
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
				<label for="doc-select-4" class="label_style">完损等级：</label>
				<div  class="am-u-md-8" style="float:left;">
					<select name="DamageGrade" id="doc-select-4" class="DamageGraded" required>
						<?php foreach($damaLst as $k2 =>$v2){;?>
						<option value="<?php echo $k2+1; ?>"><?php echo $v2['DamageGrade']; ?></option>
						<?php }; ?>
					</select>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-5" class="label_style">楼栋产别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="OwnerType" id="ownerType" >
					<?php foreach($owerLst as $k3 =>$v3){;?>
					<option value="<?php echo $v3['id']; ?>"><?php echo $v3['OwnerType']; ?></option>
					<?php }; ?>
				</select>
			  </div>
<!-- 				<i style="font-style: normal; color:red; vertical-align: middle;">*主</i> -->
			</div>

<!-- 			<div class="am-form-group am-u-md-12">
				<label for="doc-select-5" class="label_style">楼栋产别：</label>
				<div class="am-u-md-8" style="float:left;">
					<select name="AnathorOwnerType" id="AnathorOwnerType" >
						<option value="0">请选择</option>
						<?php foreach($owerLst as $k9 =>$v9){;?>
						<option value="<?php echo $k9+1; ?>"><?php echo $v9['OwnerType']; ?></option>
						<?php }; ?>
					</select>
				</div>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">使用性质：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="UseNature" class="UseNatured" >
					<option  value="" style="display:none">请选择</option>
					<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
					<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
					<?php }; ?>
				</select>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">结构类别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="StructureType" class="StructureTyped">
						<?php foreach($struLst as $k4 =>$v4){;?>
						<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>
						<?php }; ?>
				</select>
			  </div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">建成年份：</label>
				<div class="am-u-md-8" data-am-validator>
					<input type="text" name="BanYear" id="BanYear" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanUnitNum" id="BanUnitNum" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层数量：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorNum" id="BanFloorNum" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">起始楼层：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanFloorStart" id="BanFloorStart" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">拆迁状态：</label>
				<div class="am-u-md-8">
					<select name="RemoveStatus" id="RemoveStatus">
						<option value="1">未拆迁</option>
						<option value="2">已拆未下基数</option>
						<option value="3">已拆且下基数</option>
					</select>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">建筑状态：</label>
				<div class="am-u-md-8">
					<select name="HistoryIf" id="HistoryIf">
						<option value="0">非优秀</option>
						<option value="1">市级</option>
						<option value="2">区级</option>
						<option value="3">省级</option>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">电梯状态：</label>
				<div class="am-u-md-8">
					<select name="IfElevator" id="doc-select-5" class="IfElevatorM">
						<option value="0">无电梯</option>
						<option value="1">有电梯且免费</option>
						<option value="2">有电梯需缴费</option>
					 </select>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">产权来源：</label>
				<div class="am-u-md-8">
					<input type="text" name="PropertySource" id="PropertySource" placeholder="" />
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">不动产证：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanFreeholdID" id="BanFreeholdI" />
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">总户数：</label>
				<div class="am-u-md-8">
					<input type="number" name="TotalHouseholds" id="TotalHouseholds" />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">栋系数：</label>
				<div class="am-u-md-8">
					<input type="number" name="BanRatio" id="BanRatio" required/>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" style="float:left;">是否改造产：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ReformIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ReformIf"> 否
					</label>
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" style="float:left;">是否文物保护：</label>
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
			<!-- <div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfElevator" value="1" />
				<label>有电梯</label>
			</div> -->
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfFirst" value="1" />
				<label>居住第一层有架空层或木地板住房</label>
			</div>
		</div>

		<hr class="am-u-md-11"/>

		<div class="am-u-md-6 j-upload">
			<div class="am-form-group am-u-md-12">
			  <label for="editLandCertificate" style="float:left;">土地证电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="LandCertificate" id="editLandCertificate" multiple>
				  <input type="hidden" name="LandCertificate" id="editLandCertificateHidden" class="j-edit" value="" >
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="imgShowOne" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="editRealEstate" style="float:left;">不动产电子版：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="RealEstate" id="editRealEstate" multiple>
				  <input type="hidden" name="RealEstate" id="editRealEstateHidden" class="j-edit" value="" >
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="imgShowTwo" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="editImgReload" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="BanImageIDS" id="editImgReload" multiple>
				  <input type="hidden" name="BanImageIDS" id="editBanImageIDSHidden" class="j-edit" value="" >
				</div>
				<div class="j-upload-img">
				  <img class="am-form-group am-u-md-12" id="imgShowThree" style="width:310px;height:150px;float:left;" src="/public/static/gf/icons/noimg.png">
				  <i  class="img_close j-hide"></i>
				</div>
			</div>
		</div>
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style" >经纬度：</label>
				<div class="am-u-md-8">
					<input type="text" name="xy" id="xy" required />
				</div>
				<i style="font-style: normal; color:red; vertical-align: middle;">*</i>
			</div>
			<div class="am-form-group am-u-md-12" id="ModifyMap" style="width:280px;height:262px;margin-top: 36px;
    margin-left: 14px;border:1px solid #D9D9D9;float:left;"></div>
		</div>
		
		
	  </fieldset>

  </form>

  <div id="banDetail" class="am-form" style="display:none;margin-top:1.6rem;">

    <fieldset style="width:780px;">
        <!--<legend>添加楼栋</legend>-->
        <div class="am-u-md-6">

            <div class="am-form-group am-u-md-12">
                <label class="label_style">楼栋地址：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanAddress"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label class="label_style">楼栋编号：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanID"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">栋号：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailBanNumber"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label class="label_style">机构名称：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="TubulationID"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label class="label_style">企业建面：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailEnterpriseArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">企业规租：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailEnterpriseRent"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">企业原价：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailEnterprisePrice"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">企业栋数：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailEnterpriseNumber"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label class="label_style">机关建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailPartyArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">机关规租：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailPartyRent"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">机关原价：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailPartyPrice"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-email-2" class="label_style">机关栋数：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailPartyNumber"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">民用建面：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailCivilArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">民用规租：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailCivilRent"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">民用原价：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailCivilPrice"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">民用栋数：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailCivilNumber"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">使用面积：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanUsearea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">占地面积：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="detailsTotalArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">证载面积：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailActualArea"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-email-2" class="label_style">产权证号：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailBanPropertyID"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">土地证号：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id="BanLandID"></p>
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
            <!--<label for="doc-vld-age-2" class="label_style">合计原价：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style" id="TotalOprice"></p>-->
            <!--</div>-->
            <!--</div>-->
            <!--暂无相关信息-->
            <!-- <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">规定租金：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="PreRent"></p>
                </div>
            </div> -->
<!--             <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">计算租金：</label>
                <div class="am-u-md-8" style="float:left;">
                    <p class="detail_p_style" id=""></p>
                </div>
            </div>
 -->
            <!-- 		<div class="am-form-group am-u-md-12">
                          <label for="doc-vld-age-2" class="label_style">楼栋地址：</label>
                          <div class="am-u-md-8">
                                <p class="detail_p_style" id="BanAddress"></p>
                          </div>
                        </div>

                        <div class="am-form-group am-u-md-12">
                          <label for="doc-vld-age-2" class="label_style">楼栋产别：</label>
                          <div class="am-u-md-8">
                                <p class="detail_p_style" id="OwnerType"></p>
                          </div>
                        </div> -->
            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="">土地证电子版：</label>
            </div>
            <img class="am-form-group am-u-md-12" id="detailImgOne" src="" style="width:310px;height:150px;float:left;">
            <div class="am-form-group am-u-md-12">
                <label for="imgReload" class="">不动产电子版：</label>
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
                <label for="doc-select-4" class="label_style">完损等级：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="DamageGrade"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-5" class="label_style">楼栋产别：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="OwnerType"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-7" class="label_style">使用性质：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="UseNature"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">结构类别：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="StructureType"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-email-2" class="label_style">建成年份：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="BanYear"></p>
                </div>
            </div>
            <!--新加-->
            <div class="am-form-group am-u-md-12">
                <label for="doc-select-8" class="label_style">单元数量：</label>
                <div class="am-u-md-8">
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
                <label for="doc-vld-age-2" class="label_style">拆迁状态：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailRemoveStatus"></p>
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
            </div> -->
            <!--<div class="am-form-group am-u-md-12">-->
            <!--<label for="doc-vld-age-2" class="label_style">楼栋状态：</label>-->
            <!--<div class="am-u-md-8">-->
            <!--<p class="detail_p_style">楼栋编号</p>-->
            <!--</div>-->
            <!--</div>-->
            <div class="am-form-group am-u-md-12">
                <label for="doc-vld-age-2" class="label_style">产权来源：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailPropertySource"></p>
                </div>
            </div>

            <div class="am-form-group am-u-md-12">
                <label class="label_style">总户数：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="DetailsTotalHouseHolds"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style">栋系数：</label>
                <div class="am-u-md-8">
                    <p class="detail_p_style" id="detailBanRatio"></p>
                </div>
            </div>
            <div class="am-form-group am-u-md-12">
                <label class="label_style lh15">历史优秀建筑：</label>
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
	<div class="am-u-md-6 am-scrollable-horizontal" style="width:490px;">
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
			<h3>2020-01-09</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统<?php echo $web_version; ?>更新提醒</h3>
			<p class="fun_title">优化</p>
			<p>1.租金减免年审优化：优化租金减免年审申请条件，附件分类显示，多次年审审批记录明细展示</p>
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-12-27</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.16更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.月租金报表：新增12月份及以后月份管段多产别月租金报表统计查询（“市代托”、“市区代托”、“所有产别”）</p>		
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-11-04</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.15更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.楼栋注销异动：新增楼栋注销异动类型，能够实现整栋楼的注销</p>
			<p>2.租金减免年审异动：新增租金减免年审异动，房管员（提交资料）——经租会计（确认年审）</p>
			<p class="fun_title">优化</p>
			<p>1.房屋详情页优化：增加字段 “绑定楼栋：XXXXXXXX（楼栋地址） XXXXXX（楼栋编号）”</p>
			<p>2.注销页面优化：注销申请页面必填项标*：注销租金、计租面积、建筑面积、原价</p>	
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-10-12</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.14更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.租金减免取消：租金管理的租金减免页面新增租金减免取消功能</p>
			<p class="fun_title">优化</p>
			<p>1.报表检测：新加“检测”按钮，按查询“管段”，“房管所”，“公司”，“产别”检测</p>
			<p>2.租金减免自动取消：若原租户有租金减免，使用权变更后，原租户该房屋的租金减免自动取消，且会反映到报表</p>
			<p>3.弹窗显示时常：系统中所有弹窗提示信息显示时长改为4s（已完成）</p>			
		</div>
	</div>
	<div class="content">
		<div class="version_time">
			<h3>2019-9-20</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统v1.5.13更新提醒</h3>
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

<script src="https://api.map.baidu.com/api?v=2.0&ak=2xlodrKVRyFNeopCajiMTfgIOr8dnUAe"></script>
<script type="text/javascript" src="/public/static/gf/js/validation.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/confirm_ban_form.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/map.js?v=<?php echo $version; ?>"></script>
			

</body>
</html>