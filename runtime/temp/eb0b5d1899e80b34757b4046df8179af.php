<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:68:"D:\phpStudy\WWW\ph/application/ph\view\confirm_house_info\index.html";i:1523846105;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1523846105;s:50:"application/ph/view/confirm_house_info/detail.html";i:1523846105;s:48:"application/ph/view/confirm_house_info/form.html";i:1523846105;s:50:"application/ph/view/confirm_house_info/modify.html";i:1523846105;s:52:"application/ph/view/confirm_house_info/RentForm.html";i:1523846105;s:53:"application/ph/view/confirm_house_info/RentFormM.html";i:1523846105;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>房屋确认</title>
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
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">数据确认管理</strong> / <small>房屋确认</small></div>
    </div>

      <div class="am-g">
          <div class="am-u-sm-12 am-u-md-6">
              <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                      <?php if(in_array(508,$threeMenu)){ ; ?>
                      <button type="button" id="addHouse" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增房屋</button>
                      <?php }; if(in_array(509,$threeMenu)){ ; ?>
                      <button type="button" id="reviseHouse" class="am-btn am-btn-default"><span class="am-icon-edit"></span> 修改房屋</button>
                      <?php }; if(in_array(510,$threeMenu)){ ; ?>
                      <button type="button" id="deleteHouse" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除房屋</button>
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
                <th class="table-title">房屋编号</th>
                <th class="table-type">楼栋编号</th>
                <th class="table-type">楼栋地址</th>
                <th class="table-author">租户姓名</th>
                <th class="table-date">机构名称</th>
                <th class="table-set">产别</th>
                <th class="table-set">使用性质</th>
                <th class="table-set dong_none">单元号</th>
                <th class="table-set dong_none">楼层号</th>
                <th class="table-set">使用面积</th>
                <th class="table-set">计租面积</th>
                <th class="table-set dong_none">建筑面积</th>
                <th class="table-set">规定月租金</th>
                <th class="table-set">操作</th>
            </tr>
          </thead>
        <tbody>
		  <!--查询-->
      <form action="<?php echo url('ConfirmHouseInfo/index'); ?>" method="post" id="queryForm" autocomplete="off">
    		<tr class="am-form-group am-form-inline am-form">
            <td></td>
            <td></td>
                <td>
                    <div class="am-input-group am-input-group-sm">
                    <?php
                        if($houseOption != array()){
                            $HouseID = $houseOption['HouseID'];
                        }else{
                            $HouseID = '';
                        }
                     ?>
                      <input name="HouseID" type="text" class="am-form-field" value="<?php echo $HouseID; ?>">
                    </div>
                </td>

                <td>
                    <div class="am-input-group am-input-group-sm">
                     <?php
                        if($houseOption != array()){
                            $BanID = $houseOption['BanID'];
                        }else{
                            $BanID = '';
                        }
                     ?>
                      <input name="BanID" type="text" class="am-form-field" value="<?php echo $BanID; ?>">
                    </div>
                </td>
                <td>
            <div class="am-input-group am-input-group-sm">
                     <?php
                        if($houseOption != array()){
                            $BanAddress = $houseOption['BanAddress'];
                        }else{
                            $BanAddress = '';
                        }
                     ?>
              <input name="BanAddress" type="text" class="am-form-field" value="<?php echo $BanAddress; ?>">
            </div>
           </td>
                 <td>
    				<div class="am-input-group am-input-group-sm">
                     <?php
                        if($houseOption != array()){
                            $TenantName = $houseOption['TenantName'];
                        }else{
                            $TenantName = '';
                        }
                     ?>
    				  <input name="TenantName" type="text" class="am-form-field" value="<?php echo $TenantName; ?>">
    				</div>
    			 </td>

                  <td>
                      <div class="am-form-group search_input">


                          <?php if(session('user_base_info.institution_level')!=3){ ;?>
                          <select name="TubulationID" id="doc-select-2">
                              <option  value="" style="display:none">请选择</option>

                              <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 

                                if($houseOption != array()){

                                    if($houseOption['TubulationID'] == $v10['id']){

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

                                if($houseOption != array()){

                                    if($houseOption['TubulationID'] == $v12['id']){

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
                                if($houseOption != array()){
                                    if($houseOption['OwnerType'] == $v3['id']){
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
                    <div class="am-form-group search_input">
                        <select name="UseNature" id="doc-select">
                            <option value="" style="display:none">请选择</option>
                            <?php foreach($useNatureLst as $k0 =>$v0){;
                                if($houseOption != array()){
                                    if($houseOption['UseNature'] == $v0['id']){
                                        $select ='selected';
                                    }else{
                                        $select ='';
                                    }
                                }else{
                                    $select ='';
                                }
                                ?>

                            <option value="<?php echo $v0['id']; ?>"
                                    <?php echo $select; ?>><?php echo $v0['UseNature']; ?></option>
                            <?php }; ?>
                        </select>
                    </div>
                </td>


                <td>
                    <div class="am-input-group am-input-group-sm">
                    <?php
                        if($houseOption != array()){
                            $UnitID = $houseOption['UnitID'];
                        }else{
                            $UnitID = '';
                        }
                     ?>
                      <input name="UnitID" type="text" class="am-form-field" value="<?php echo $UnitID; ?>">
                    </div>
                 </td>
                  <td>
            				<div class="am-input-group am-input-group-sm">
                            <?php
                                if($houseOption != array()){
                                    $FloorID = $houseOption['FloorID'];
                                }else{
                                    $FloorID = '';
                                }
                             ?>
            				  <input name="FloorID" type="text" class="am-form-field" value="<?php echo $FloorID; ?>">
            				</div>
    			  </td>
    			  <td><div style="width:50px;"></div></td>
    			  <td><div style="width:50px;"></div></td>
    			  <td><div style="width:60px;"></div></td>
            <td><div style="width:50px;"></div></td>
            <td>
              <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                <button type="submit" class="am-btn am-btn-xs am-text-secondary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                <a id="clearHouseInfo" class="am-btn am-btn-xs am-text-secondary ABtn" href="/ph/ConfirmHouseInfo/index.html"><span class="ResetIcon"></span>重置</a>
              </div>
            </td>
        </tr>
        </form>
		<!---查询-->

		  <?php foreach($houseLst as $k1 => $v1){; ?>

            <tr class="check001">
                <td>
                    <span class="piaochecked">
                        <input class="checkId radioclass input" type="radio" name="choose" value="<?php echo $v1['HouseID']; ?>"/>
                    </span>
                </td>
                <td><?php echo ++$k1; ?></td>
                <td><?php echo $v1['HouseID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['BanID']; ?></td>
                <td class="am-hide-sm-only">
                  <p style="height:18px;margin:10px 0 0;padding:0;line-height:18px;"><?php echo $v1['BanAddress']; ?></p>
                </td>
                <td class="am-hide-sm-only"><?php echo $v1['TenantID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['InstitutionID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['OwnerType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['UseNature']; ?></td>
                <td class="dong_none"><?php echo $v1['UnitID']; ?></td>
                <td class="dong_none"><?php echo $v1['FloorID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['HouseUsearea']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['LeasedArea']; ?></td>
                <td class="dong_none"><?php echo $v1['HouseArea']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v1['HousePrerent']; ?></td>
				  <td>
					  <div class="am-btn-group am-btn-group-xs">
						    <button class="am-btn am-btn-default am-btn-xs am-text-secondary details HouseDetailBtn" value="<?php echo $v1['HouseID']; ?>"> 明细</button>
                <a href="<?php echo url('TenantInfo/index',['TenantID'=>$v1['id'],]); ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary am-hide-sm-only ABtn">查看租户</a>
                 <button class="am-btn am-btn-default am-btn-xs am-text-secondary RentForm" value="<?php echo $v1['HouseID']; ?>"> 计租表
                            </button>
                          <button class="am-btn am-btn-default am-btn-xs am-text-secondary details ConfirmHouseBtn" value="<?php echo $v1['HouseID']; ?>"> 确认</button>
					   </div>
				  </td>
            </tr>
     
		<?php }; ?>

          </tbody>
        </table>
		<div class="am-cf">
		  共<?php echo $houseLstObj->total(); ?>条记录
		  <div class="am-fr">

				<?php echo $houseLstObj->render(); ?>

		  </div>
		</div>

      </div>
    </div>
  </div>

  <!-- content end -->
  <div id="deleteChoose" style="display:none; text-align: center; margin: 20px;">
      <button id="HouseChange" class="am-btn am-btn-secondary " value="10" name="houseDeleteType" style="background: #0086ff;border:none">房改</button>
      <button id="HouseRemove" class="am-btn am-btn-secondary" value="11" name="houseDeleteType" style="background: #0086ff;border:none">拆迁，已注销</button>
      <button id="DateTogther" class="am-btn am-btn-secondary" value="12"  name="houseDeleteType"style="background: #0086ff;border:none">数据合并</button>
      <button id="DateLose" class="am-btn am-btn-secondary" value="13"  name="houseDeleteType"style="background: #0086ff;border:none">数据作废</button>
  </div>
   <table class="am-table am-table-bordered am-table-radius PriceBoxNum" style="display:none">
        <tbody>

        <?php foreach($rentPoint as $k => $v){ ; ?>
        <tr class="cur">
            <td><input class="Boxes" type="checkbox" name="PriceBox" value="<?php echo $v['id']; ?>"></td>
            <td><?php echo $v['id']; ?></td>
            <td><?php echo $v['Item']; ?></td>
            <td class="PriceValue"><?php echo 100 * $v['Point']; ?></td>
        </tr>
        <?php }; ?>

        </tbody>
  </table>
<form id="PriceForm" style="display:none">
            
</form>
  <div id="houseDetail" class="am-form" style="display:none;margin-top:1.6rem;">

	  <fieldset >
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-3">
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
			  <label for="doc-select-8" class="label_style">租户ID：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="TenantID">加载中</p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="Name" class="label_style">建筑面积：</label>
				<div class="am-u-md-8">
					<p class="detail_p_style" id="HouseArea">加载中</p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">是否住改非：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="NonliveIf">加载中</p>
			  </div>
			</div>	
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
			  <label  class="label_style">欠租情况：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ArrearRent">加载中</p>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label  class="label_style">户建面：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="HouseArea">加载中</p>
			  </div>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label  class="label_style">套内建面：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="ComprisingArea">加载中</p>
			  </div>
			</div>
			
			<!--<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">房屋影像：</label>
					<img style="width:300px;height:130px;" src="" id="HouseImageIDS" alt="图片走丢了^-^">
			</div>	-->

			
			<div class="am-form-group am-u-md-12"><label>三户共用情况：</label></div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">厅堂：</label>
			  <div class="am-u-md-5" style="float:left;">
					<p class="detail_p_style" id="Commonliving">加载中</p>
			  </div>
			  <div class="yuan">个</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">卫生间：</label>
			  <div class="am-u-md-5" style="float:left;">
					<p class="detail_p_style" id="Commonwc">加载中</p>
			  </div>
			  <div class="yuan">个</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">厨房：</label>
			  <div class="am-u-md-5" style="float:left;">
					<p class="detail_p_style" id="Commonkit">加载中</p>
			  </div>
			  <div class="yuan">个</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">内走道：</label>
			  <div class="am-u-md-5" style="float:left;">
					<p class="detail_p_style" id="Commonway">加载中</p>
			  </div>
			  <div class="yuan">个</div>
			</div>
		</div>

		
		
<!--左右分割-->		
		
		
		<div class="am-u-md-3">	
			
			<div class="am-form-group am-u-md-12">
			  <label>加计租金</label>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style" style="line-height: 15px">墙布（纸）护墙板：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DWallpaperArea">加载中</p>
			  </div>
			  <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style" style="line-height: 15px">瓷砖、马赛克、地板砖：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DCeramicTileArea">加载中</p>
			  </div>
			  <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">浴盆：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DBathtubNum">加载中</p>
			  </div>
			   <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">面盆：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DBasinNum">加载中</p>
			  </div>
			   <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style" style="line-height: 15px">空间1至1.7米(5㎡以下)：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DBelowFiveNum">加载中</p>
			  </div>
			   <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style" style="line-height: 15px">阁楼(含1.7米)(5㎡以上)：</label>
			  <div class="am-u-md-7 qb_style2" style="float:left;">
					<p class="detail_p_style" id="DMoreFiveNum">加载中</p>
			  </div>
			   <div class="yuan">元</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <img id="ComprisingImg" width="100%">
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
			<!--<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">经纬度：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="xy">加载中</p>
			  </div>
			</div>	-->
			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">经纬度：</label>
			  <div class="am-u-md-8" style="float:left;">
					<p class="detail_p_style" id="xy">加载中</p>
			  </div>
			</div>	 -->
			<div class="am-form-group am-u-md-12" id="mapHouse" style="width:312px;height:150px;float:left; display: none"></div>
			 <ol id="Drecord" style="float: left;">
               
           </ol>
		</div>
		<div class="am-u-md-6" style="padding-right: 0">
			<div class="am-form-group am-u-md-12"><label>计租表</label></div>
			

			<div class="add_1">
				
			</div>

			<div class="am-u-md-12">
			<div class="am-u-md-6">
				<div class="am-form-group am-u-md-12">
				  <label for="doc-select-8" class="label_style">维修费：</label>
				  <div class="am-u-md-8" style="float:left;">
						<p class="detail_p_style" id="Countrepaire">加载中</p>
				  </div>
				</div>

				<div class="am-form-group am-u-md-12">
				  <label for="doc-select-8" class="label_style">泵费：</label>
				  <div class="am-u-md-8" style="float:left;">
						<p class="detail_p_style" id="Countprice">加载中</p>
				  </div>
				</div>
				<div class="am-form-group am-u-md-12">
				  <label for="doc-select-8" class="label_style">减免租金：</label>
				  <div class="am-u-md-8" style="float:left;">
						<p class="detail_p_style" id="Countcut">加载中</p>
				  </div>
				</div>
				<div class="am-form-group am-u-md-12">
				  <label for="doc-select-8" class="label_style">层次调解率：</label>
				  <div class="am-u-md-8" style="float:left;">
						<p class="detail_p_style" id="Countchat">加载中</p>
				  </div>
				</div>
			</div>
			<div class="am-u-md-6" style="padding-left: 0" >
			
			<div class="am-form-group am-u-md-12">
				<div class="am-u-md-9" >
					<label for="doc-select-8" class="label_style"  style="width: 100%;">无上水下水，无厕所房间 ：</label>
				</div>
				<div class="am-u-md-3" style="float:left;">
						<p class="detail_p_style" id="IfWater"></p>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<div class="am-u-md-9" >
				<label for="doc-select-8" class="label_style" style="width: 100%;">是否有电梯：</label>
				</div>
			  <div class="am-u-md-3" style="float:left;">
					<p class="detail_p_style" id="IfElevator"></p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
				<div class="am-u-md-9" >
				<label for="doc-select-8" class="label_style" style="width: 100%;line-height: 15px;" >居住第一层是否有架空层或木地板住房：</label>
				</div>
			  <div class="am-u-md-3" >
					<p class="detail_p_style" id="IfFirst"></p>
			  </div>
			</div>
			<div class="am-form-group am-u-md-12" style="margin-bottom: 45px;">
			  
			</div>
			</div> 
		</div>
		</div>
		</div>
	  </fieldset>
  </div>

  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css"/>
<form action="<?php echo url('HouseInfo/add'); ?>" method="post" id="houseForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">
	  <fieldset id="InputForm" style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
				<div class="am-u-md-7">
					<input type="text" name="BanID" id="DBanID" placeholder="楼栋编号" required/>
				</div>
				<a class="am-btn QBtn" id="DqueryBtn" style="padding: 5px 0">查询</a>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">单元号：</label>
				<div class="am-u-md-8">
					<input type="text" name="UnitID" placeholder="单元号" required/>
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层号：</label>
				<div class="am-u-md-8">
					<input type="text" name="FloorID" placeholder="楼层号" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">门牌号码：</label>
				<div class="am-u-md-8">
					<input type="text" name="DoorID" id="doc-vld-email-3" placeholder="例如输入302，3表示楼层" required/>
				</div>
			</div>

			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">房屋编号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="HouseID" id="DHouseID" placeholder="房屋编号" required/>
			  </div>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">房屋编号：</label>
			  <div class="am-u-md-8">
				<label id="DHouseID"></label>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-7" class="label_style">使用性质：</label>
				<div class="am-u-md-8" style="float:left;">
					<select name="UseNature" id="doc-select-7" required>
						<option  value="" style="display:none">请选择</option>
						<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
						<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
						<?php }; ?>
					</select>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="PumpCost" class="label_style">泵费：</label>
				<div class="am-u-md-8">
					<input type="text" name="PumpCost" id="PumpCost" placeholder="泵费" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="RepairCost" class="label_style">维修费：</label>
				<div class="am-u-md-8">
					<input type="text" name="RepairCost" id="RepairCost" placeholder="维修费" required/>
				</div>
			</div>
			
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="HouseBase" class="label_style">房屋基数：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseBase" id="HouseBase" placeholder="房屋基数" required/>
				</div>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="OldOprice" class="label_style">计算原价：</label>
				<div class="am-u-md-8">
					<input type="text" name="OldOprice" id="OldOprice" placeholder="计算原价" required/>
				</div>
			</div>
			
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="Oprice" class="label_style">实际原价：</label>
				<div class="am-u-md-8">
					<input type="text" name="Oprice" id="Oprice" placeholder="实际原价" required/>
				</div>
			</div> -->
			<div class="am-form-group am-u-md-12">
			  <label for="Name" class="label_style">租户ID：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantID" id="TenantID" placeholder="租户ID" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">是否住改非：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="NonliveIf"  required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="NonliveIf" checked="checked"> 否
					</label>
				</div>
			</div>

			<div class="am-form-group am-u-md-12"><label>三户共用情况：</label></div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">厅堂：</label>
				<div class="am-u-md-8">
					<input type="text" name="Hall" id="hall" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">卫生间：</label>
				<div class="am-u-md-8">
					<input type="text" name="Toilet" id="toilet" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">厨房：</label>
				<div class="am-u-md-8">
					<input type="text" name="Kitchen" id="kitchen" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">内走道：</label>
				<div class="am-u-md-8">
					<input type="text" name="InnerAisle" id="InnerAisle" placeholder="" required/>
				</div>
			</div>
		</div>
		
		<div class="am-u-md-6">
			<!-- <div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">计租面积：</label>
				<div class="am-u-md-8">
					<input type="text" name="LeasedArea" id="LeasedArea" placeholder="计租面积" required/>
				</div>
			</div> -->

			<!--新加-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">房间数：</label>-->
				<!--&lt;!&ndash;<div class="am-u-md-8">&ndash;&gt;-->
					<!--&lt;!&ndash;<input type="text" name="Paper" id="doc-vld-email-2" placeholder="证件类型" required/>&ndash;&gt;-->
				<!--&lt;!&ndash;</div>&ndash;&gt;-->
				<!--<div class="am-u-md-8" style="float:left;">-->
					<!--<input type="text" name="RoomNumber" id="doc-vld-email-10" placeholder="房间数" required/>-->
				<!--</div>-->
			<!--</div>-->
			<!-- <div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">使用面积：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseUsearea" id="HouseUsearea" placeholder="使用面积" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">规定租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="HousePrerent" id="HousePrerent" placeholder="规定租金" required/>
				</div>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="ReceiveRent" class="label_style">应收租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="ReceiveRent" id="ReceiveRent" placeholder="应收租金" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="RemitRent" class="label_style">减免租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="RemitRent" id="RemitRent" placeholder="减免租金" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="ArrearRent" class="label_style">欠租情况：</label>
				<div class="am-u-md-8">
					<input type="text" name="ArrearRent" id="ArrearRent" placeholder="欠租情况" required/>
				</div>
			</div> -->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="ArrearrentReason" class="label_style">欠租原因：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="ArrearrentReason" id="ArrearrentReason" placeholder="欠租原因" required/>-->
				<!--</div>-->
			<!--</div>-->
<!-- 			<div class="am-form-group am-u-md-12">
			  <label for="HouseArea" class="label_style">户建面：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseArea" id="HouseArea" placeholder="户建面：" required/>
				</div>
			</div> -->

			<div class="am-form-group am-u-md-12">
			  <label for="ComprisingArea" class="label_style">套内建面：</label>
				<div class="am-u-md-8">
					<input type="text" name="ComprisingArea" id="ComprisingArea" placeholder="套内建面" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">规定租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="HousePrerent" id="AHousePrerent" placeholder="规定租金" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<input type="checkbox" name="IfWater" value="1" /><label>无上水下水、无厕所房间</label>
			</div>

			<div class="am-form-group am-u-md-12"><label>加计租金：</label></div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">墙布(纸)护墙板：</label>
				<div class="am-u-md-7 qb_style2" >
					<input type="text" name="WallpaperArea" id="wallcloth" placeholder="" required/>
				</div>
				<div class="yuan">m²</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">瓷砖、马赛克、地板砖：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="CeramicTileArea" id="FloorTile" placeholder="" required/>
				</div>
				<div class="yuan">m²</div>
			</div>
			<div class="am-form-group am-u-md-12 mb">
			  <label for="" class="label_style am-u-4 qb_style">浴盆：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BathtubNum" id="bathtub" placeholder="" required/>
				</div>
				<div class="yuan">件</div>
			</div>
			<div class="am-form-group am-u-md-12 mb">
			  <label for="" class="label_style am-u-4 qb_style">面盆：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BasinNum" id="basin" placeholder="" required/>
				</div>
				<div class="yuan">件</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">空间1至1.7米(5㎡以下)：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BelowFiveNum" id="space" placeholder="" required/>
				</div>
				<div class="yuan">个</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">阁楼(含1.7米)(5㎡以上)：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="MoreFiveNum" id="attic" placeholder="" required/>
				</div>
				<div class="yuan">个</div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="imgUp" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="HouseImageIDS" id="imgUp" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgShow" style="width:312px;height:150px;float:left;">
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="OPayments" class="label_style">其他应收款：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="OPayments" id="OPayments" placeholder="其他应收款" required/>-->
				<!--</div>-->
			<!--</div>-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="Payment" class="label_style">金额：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="Payment" id="Payment" placeholder="金额" required/>-->
				<!--</div>-->
			<!--</div>-->

		</div>
<!-- 		<div class="am-u-md-12" style="text-align:center;margin-top:2rem;">
			<button class="am-btn am-btn-secondary btn_big" type="submit">提交</button>
		</div> -->
	  </fieldset>
  </form>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
  <link rel="stylesheet" href="/public/static/gf/css/amazeui.datetimepicker.css"/>
<form action="<?php echo url('HouseInfo/edit'); ?>" method="post" id="houseModifyForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	<fieldset style="width:780px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
				<div class="am-u-md-7">
					<input type="text" name="BanID" id="BanI" placeholder="楼栋编号" required/>
				</div>
				<a class="am-btn QBtn2" id="DqueryBtn2" style="padding: 5px 0">查询</a>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">单元号：</label>
				<div class="am-u-md-8">
					<input type="text" name="UnitID" id="UnitI" placeholder="单元号" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">楼层号：</label>
				<div class="am-u-md-8">
					<input type="text" name="FloorID" id="FloorI" placeholder="楼层号" required/>
				</div>
			</div>

			 <div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">门牌号码：</label>
				<div class="am-u-md-8">
					<input type="text" name="DoorID" id="DoorI" placeholder="门牌号码" required/>
				</div>
			</div> 
		<!--	<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">产别：</label>
				<div class="am-u-md-8">
					<select name="OwnerType" id="OwnerType" disabled="disabled">
						<option  value="" style="display:none">请选择</option>
						<?php foreach($owerLst as $k3 =>$v3){;?>
						<option value="<?php echo $k3+1; ?>"><?php echo $v3['OwnerType']; ?></option>
						<?php }; ?>
					</select>
				</div>
			</div>-->
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">房屋编号：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseID" id="HouseI" onfocus=this.blur() placeholder="房屋编号" required/>
				</div>
<!-- 				<div class="am-u-md-8">
					<label id="mDHouseID"></label>
			  	</div> -->
			</div>

			<!-- <input type="hidden" name="DHouseID" id="mDHouseID" /> -->

			<div class="am-form-group am-u-md-12">
				<label for="doc-select-7" class="label_style">使用性质：</label>
				<div class="am-u-md-8" style="float:left;">
					<select name="UseNature" id="UseNature" >
						<option  value="" style="display:none">请选择</option>
						<?php foreach($useNatureLst as $k5 =>$v5){ ;?>
						<option value="<?php echo $v5['id']; ?>"><?php echo $v5['UseNature'];?></option>
						<?php }; ?>
					</select>
				</div>
			</div>
			<!--<div class="am-form-group am-u-md-12">
				<label for="PumpCost" class="label_style">泵费：</label>
				<div class="am-u-md-8">
					<input type="text" name="PumpCost" id="PumpCos" placeholder="泵费" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="RepairCost" class="label_style">维修费：</label>
				<div class="am-u-md-8">
					<input type="text" name="RepairCost" id="RepairCos" placeholder="维修费" required/>
				</div>
			</div>

			 <div class="am-form-group am-u-md-12">
				<label for="HouseBase" class="label_style">房屋基数：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseBase" id="HouseBas" placeholder="房屋基数" required/>
				</div>
			</div> 

			<div class="am-form-group am-u-md-12">
			  <label for="RepairCost" class="label_style">维修费：</label>
				<div class="am-u-md-8">
					<input type="text" name="RepairCost" id="RepairCost" placeholder="维修费" required/>
				</div>
			</div>-->

			<div class="am-form-group am-u-md-12">
				<label for="OldOprice" class="label_style">计算原价：</label>
				<div class="am-u-md-8">
					<input type="text" name="OldOprice" id="OldOpric" placeholder="计算原价" required/>
				</div>
			</div>

			<!-- <div class="am-form-group am-u-md-12">
				<label for="Oprice" class="label_style">实际原价：</label>
				<div class="am-u-md-8">
					<input type="text" name="Oprice" id="Opric" placeholder="实际原价" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12"><label>三户共用情况：</label></div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">厅堂：</label>
				<div class="am-u-md-8">
					<input type="text" name="Hall" id="mhall" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">卫生间：</label>
				<div class="am-u-md-8">
					<input type="text" name="Toilet" id="mtoilet" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">厨房：</label>
				<div class="am-u-md-8">
					<input type="text" name="Kitchen" id="mkitchen" placeholder="" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">内走道：</label>
				<div class="am-u-md-8">
					<input type="text" name="InnerAisle" id="mInnerAisle" placeholder="" required/>
				</div>
			</div> -->


		</div>

		<div class="am-u-md-6">
<!-- 			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">计租面积：</label>
				<div class="am-u-md-8">
					<input type="text" name="LeasedArea" id="LeasedAre" placeholder="计租面积" required/>
				</div>
			</div> -->

			<!--新加-->
			<!--<div class="am-form-group am-u-md-12">-->
			<!--<label for="doc-select-8" class="label_style">房间数：</label>-->
			<!--&lt;!&ndash;<div class="am-u-md-8">&ndash;&gt;-->
			<!--&lt;!&ndash;<input type="text" name="Paper" id="doc-vld-email-2" placeholder="证件类型" required/>&ndash;&gt;-->
			<!--&lt;!&ndash;</div>&ndash;&gt;-->
			<!--<div class="am-u-md-8" style="float:left;">-->
			<!--<input type="text" name="RoomNumber" id="doc-vld-email-10" placeholder="房间数" required/>-->
			<!--</div>-->
			<!--</div>-->
<!-- 			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">使用面积：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseUsearea" id="HouseUseare" placeholder="使用面积" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">规定租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="HousePrerent" id="HousePreren" placeholder="规定租金" required/>
				</div>
			</div> -->

<!-- 
			<div class="am-form-group am-u-md-12">
				<label for="ReceiveRent" class="label_style">应收租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="ReceiveRent" id="ReceiveRen" placeholder="应收租金" required/>
				</div>
			</div>

			<div class="am-form-group am-u-md-12">
				<label for="RemitRent" class="label_style">减免租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="RemitRent" id="RemitRen" placeholder="减免租金" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="ArrearRent" class="label_style">欠租情况：</label>
				<div class="am-u-md-8">
					<input type="text" name="ArrearRent" id="ArrearRen" placeholder="欠租情况" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="ArrearrentReason" class="label_style">欠租原因：</label>
				<div class="am-u-md-8">
					<input type="text" name="ArrearrentReason" id="ArrearrentReaso" placeholder="欠租原因" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="HouseArea" class="label_style">户建面：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseArea" id="HouseAre" placeholder="户建面：" required/>
				</div>
			</div> -->
			<div class="am-form-group am-u-md-12">
				<label for="ComprisingArea" class="label_style">套内建面：</label>
				<div class="am-u-md-8">
					<input type="text" name="ComprisingArea" id="ComprisingAre" placeholder="套内建面" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="Name" class="label_style">租户ID：</label>
				<div class="am-u-md-8">
					<input type="text" name="TenantID" id="TenantI" placeholder="租户ID" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="Name" class="label_style">建筑面积：</label>
				<div class="am-u-md-8">
					<input type="text" name="HouseArea" id="HouseAre" placeholder="建筑面积" required/>
				</div>
			</div>
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">是否住改非：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="NonliveIf" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="NonliveIf"> 否
					</label>
				</div>
			</div>
<!-- 			<div class="am-form-group am-u-md-12">
				<label for="ApprovedRent" class="label_style">规定租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="ApprovedRent" id="mApprovedRent" placeholder="规定租金" required/>
				</div>
			</div> 
			<div class="am-form-group am-u-md-12">
				<label for="doc-select-8" class="label_style">规定租金：</label>
				<div class="am-u-md-8">
					<input type="text" name="HousePrerent" id="MHousePrerent" placeholder="规定租金" required/>
				</div>
			</div> 
			<div class="am-form-group am-u-md-12">
				<input type="checkbox"  id="mIfWater"/><label>无上水下水、无厕所房间</label>
			</div>

			<div class="am-form-group am-u-md-12"><label>加计租金：</label></div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">墙布(纸)护墙板：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="WallpaperArea" id="mwallcloth" placeholder="" required/>
				</div>
				<div class="yuan">m²</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">瓷砖、马赛克、地板砖：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="CeramicTileArea" id="mFloorTile" placeholder="" required/>
				</div>
				<div class="yuan">m²</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style mb">浴盆：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BathtubNum" id="mbathtub" placeholder="" required/>
				</div>
				<div class="yuan">件</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style mb">面盆：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BasinNum" id="mbasin" placeholder="" required/>
				</div>
				<div class="yuan">件</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">空间1至1.7米(5㎡以下)：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="BelowFiveNum" id="mspace" placeholder="" required/>
				</div>
				<div class="yuan">个</div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="" class="label_style am-u-4 qb_style" style="line-height: 15px">阁楼(含1.7米)(5㎡以上)：</label>
				<div class="am-u-md-7 qb_style2">
					<input type="text" name="MoreFiveNum" id="mattic" placeholder="" required/>
				</div>
				<div class="yuan">个</div>
			</div>-->


			<div class="am-form-group am-u-md-12">
			  <label for="imgReload" class="label_style">影像资料：</label>
				<div class="am-form-group am-form-file am-u-md-8">
				  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
				  <input type="file" name="HouseImageIDS" id="imgReload" multiple>
				</div>
			</div>
			<img class="am-form-group am-u-md-12" id="imgChange" style="width:312px;height:150px;float:left;">
			<!--<div class="am-form-group am-u-md-12">-->
			<!--<label for="OPayments" class="label_style">其他应收款：</label>-->
			<!--<div class="am-u-md-8">-->
			<!--<input type="text" name="OPayments" id="OPayments" placeholder="其他应收款" required/>-->
			<!--</div>-->
			<!--</div>-->
			<!--<div class="am-form-group am-u-md-12">-->
			<!--<label for="Payment" class="label_style">金额：</label>-->
			<!--<div class="am-u-md-8">-->
			<!--<input type="text" name="Payment" id="Payment" placeholder="金额" required/>-->
			<!--</div>-->
			<!--</div>-->

		</div>
<!-- 		<div class="am-u-md-12" style="text-align:center;margin-top:2rem;">
			<button class="am-btn am-btn-secondary btn_big" type="submit">提交</button>
		</div> -->
	</fieldset>
</form>
<script src="/public/static/gf/js/amazeui.datetimepicker.min.js"></script>
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
<div id="RentForm" class="am-form" style="display:none;">
	<div class="am-u-md-12">
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-6">
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
			  <div class="am-u-md-6">
				<p class="detail_p_style RentName"></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">单元号：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style RentUnit"></p>
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
	    	<li style="width:10%">房间编号</li>
		    <li style="width:5%">间号</li>
		    <li style="width:10%">绑定楼栋</li>
		    <li style="width:5%">共用情况</li>
		    <li style="width:10%">绑定房屋</li>
		 
		    <li style="width:5%">单元号</li>
		    <li style="width:5%">层次</li>
		    <li style="width:10%">使用面积</li>
		    <li style="width:10%">基价折减</li>
		    <li style="width:5%">计租面积</li>
		    <li style="width:10%">层次调解率</li>
		    <li style="width:5%">月租金</li>
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



  <ul class="am-u-md-12 house_style exRoom ul-mr" style="display:none; height:35px;font-size:1.2rem">
	<li style="width:5%;height:35px"><input type="text" class="RoomStyle fontS1" readonly="readonly" ></li>
	<li style="width:3%" class="m5"><input type="text" class="fontS1"></li>
	<li style="width:6%" class="m5"><input type="text" class="QueryBanID fontS1"></li>

	<li style="width:8%" class="m5"><input type="text" class="QueryHouse fontS1"></li>
	<li style="width:8%" class="m5"><input type="text"  class="QueryHouse fontS1"></li>
	<li style="width:8%" class="m5"><input type="text"  class="QueryHouse fontS1"></li>
	<li style="width:8%" class="m5"><input type="text" class="QueryHouse fontS1"></li>
	<li style="width:8%" class="m5"><input type="text"  class="QueryHouse fontS1"></li>
	
	<li style="width:3%" class="m5"><input type="text" class="fontS1"></li>
	<li style="width:3%" class="m5"><input type="text" class="fontS1"></li>
	<li style="width:5%" class="m5"><input type="text" class="fontS1"></li>
	<li style="width:5%" class="m5">
	<input type="hidden">
	<input type="text" class="QueryCut" readonly="readonly">
	</li>
	<li style="width:5%;height:35px"></li>
	<li style="width:5%;height:35px"></li>
	<li style="width:5%;height:35px"></li>
	<li style="width:5%" class="delSD"><input type="hidden" class="pStatus" value="0"><img src="/public/static/gf/icons/del.png" class="del-styled"></li>
</ul>
<input type="text" value="" name="AddRent[deleteRoom][]" class="deleteRoom" style="display:none">
<form  id="RentFormM" class="am-form" data-am-validator style="display:none;font-size:1.4rem">
 <fieldset >

	<div class="am-u-md-12">
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-6">
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
			  <div class="am-u-md-6">
				<p class="detail_p_style RentName"></p>
			  </div>
		</div>
		<div class="am-u-md-2">
			  <label for="doc-vld-email-2" class="label_style">单元号：</label>
			  <div class="am-u-md-6">
				<p class="detail_p_style RentUnit"></p>
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
    	<ul class="am-u-md-12 house_style RentTit ul-mr">
	    	<li style="width:5%" class="m5">房间编号</li>
		    <li style="width:3%" class="m5">间号</li>
		    <li style="width:6%" >绑定楼栋</li>
		    <li style="width:8%" class="m5">绑定房屋</li>
		    <li style="width:8%" class="m5">绑定房屋</li>
		    <li style="width:8%" class="m5">绑定房屋</li>
		    <li style="width:8%" class="m5">绑定房屋</li>
		    <li style="width:8%" class="m5">绑定房屋</li>
		    <li style="width:3%" class="m5">单元号</li>
		    <li style="width:3%" class="m5">层次</li>                                                                                     
		    <li style="width:5%" class="m5">使用面积</li>
		    <li style="width:5%" class="m5">基价折减</li>
		    <li style="width:5%" >计租面积</li>
		    <li style="width:5%" >层次调解率</li>
		    <li style="width:5%" >月租金</li>
		    <li style="width:5%" >状态</li>
    </ul>
    </div>
    <div class="am-u-md-12 text-center mb20 ModifyDetail" style='display:none;margin-bottom:5px'>
    	<div class="am-u-md-12 nomal titRD">
    		<div class="am-u-md-1 Mrname" style="text-align:left;"></div>
    		<div class="triD"><img src="/public/static/gf/icons/NtriD.png" width="100%" class="pulld"></div>
    	</div>
    	<div class="RoomDeTd">
	    	<div class="am-u-md-12 house_style Mnum" style="display:none;margin:0 0 10px 0;">
	    		
	    	</div>
	    	<div class="am-u-md-12 am-text-secondary text-center"><span class="addRoom cur">+新增房间</span></div><!--新增房间-->
    	</div>
    	
    </div><!--卧室-->
    
    <div class="am-u-md-12" style="display:none" id="aSumRoom">
    	
    </div><!-- 删除房间间号 -->
    <div class="am-u-md-12 addP">
    	<div class="am-u-md-12 text-bold">加计租金</div>
    	<div class="am-u-md-12">
    		<div class="am-u-md-3">
    			<div><span class="w200">墙布(纸)护墙板</span><span class="w50 mr "><input type="text"  width="100%" class="RentWallpaperd" name='AddRent[RentWallpaper]' /></span>m²</div>
				<div><span class="w200">瓷砖、马赛克、地板砖</span><span class="w50 mr "><input type="text"  width="100%" class="RentCeramicd" name='AddRent[RentCeramic]'/></span>m²</div>
				<div><span class="w200">浴盆</span><span class="w50 mr"><input type="text"  width="100%" class="RentBathd" name='AddRent[RentBath]' /></span>件</div>
				<div><span class="w200">面盆</span><span class="w50 mr"><input type="text"  width="100%" class="RentBasind" name='AddRent[RentBasin]' /></span>件</div>
				<div><span class="w200">空间1至1.7米(5㎡以下)</span><span class="w50 mr"><input type="text"  width="100%" class="RentBelowd" name='AddRent[RentBelow]' /></span>个</div>
				<div><span class="w200">阁楼(含1.7米)(5㎡以上)</span><span class="w50 mr"><input type="text"  width="100%" class="RentMored" name='AddRent[RentMore]' /></span>个</div>
    		</div>
    		<div class="am-u-md-6">
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">产别：</span>
    				<span class="w90 mr">
	    				<select name="AddRent[TypeF][OwnerType]" id="doc" class="ROwnerTypeF">
							<option value="0" >请选择</option>
							<?php foreach($owerLst as $k8 =>$v8){;?>
							<option value="<?php echo $v8['id']; ?>"><?php echo $v8['OwnerType']; ?></option>
							<?php }; ?>
						</select>
    				</span >
    				</div>
    				<div class="am-u-md-6"><span class="w100">规定租金：</span><span class="w90 mr"><input type="text" class="RentPriced" name="AddRent[TypeF][RPrice]"></span></div>
    			</div>
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">产别：</span>
    				<span class="w90 mr">
    					<select name="AddRent[TypeS][OwnerType]" id="doc-select" class="ROwnerTypeS">
							<option value="0">请选择</option>
							<?php foreach($owerLst as $k7 =>$v7){;?>
							<option value="<?php echo $v7['id']; ?>"><?php echo $v7['OwnerType']; ?></option>
							<?php }; ?>
						</select>
    				</span>
    				</div>
    				<div class="am-u-md-6"><span class="w100">规定租金：</span><span class="w90 mr"><input type="text" class="RentPriced" name="AddRent[TypeS][RPrice]"></span></div>
    			</div>
    			<div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">计算租金：</span><span class="w90 RentApproved" name="StipulateR"></span></div>
    				<div class="am-u-md-6">
						<span class="w100">租差：</span><span class="w90 mr"><input type="text" class="diffRentd" name='AddRent[DiffRent]'></span>
					</div>
    			</div>
				
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">减免租金：</span><span class="w90 RentRemit"></span>
					</div>
					<div class="am-u-md-6">
						<span class="w100">协议租金：</span><span class="w90 mr"><input type="text" class="agreementRentd" name='AddRent[ProtocolRent]'></span>
					</div>
				</div>
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">泵费：</span><span class="w90 mr"><input type="text" class="RentPumpd" name='AddRent[PumpPrice]'></span>
					</div>
				</div>
				<div class="am-u-md-12">
					<div class="am-u-md-6">
						<span class="w100">应收租金：</span><span class="w90 RentReceive"></span>
					</div>
				</div>
				
    		</div>
    		<div class="am-u-md-3">
    			<div>使用面积：</span><span class="w50 RentHouseArea"></span></div>
				<div>计租面积：</span><span class="w50 RentLeased"></span></div>
				
				<div><label><input type="checkbox" class="RentWd" name="AddRent[RIfWater]">无上下水，无厕所的房屋</label></div>
				
    		</div>                                 
    	</div>
    </div><!-- 加计租金 -->

 

</fieldset>
 </form>
   

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

<script src="http://api.map.baidu.com/api?v=2.0&ak=2xlodrKVRyFNeopCajiMTfgIOr8dnUAe"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/confirm_house_form.js"></script>

</body>
</html>