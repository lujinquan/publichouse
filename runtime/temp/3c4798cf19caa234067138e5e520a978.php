<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:71:"/usr/share/nginx/publichouse/application/ph/view/lease_apply/index.html";i:1537405974;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1534760328;s:41:"application/ph/view/lease_apply/form.html";i:1537405974;s:43:"application/ph/view/lease_apply/detail.html";i:1536300630;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1537405974;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>租约申请</title>
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
<div class="admin-content am-print-hide" style="display:none;"></div>
  <!-- content start -->
  
  <link rel="stylesheet" href="/public/static/gf/css/iconfont.css">
  <link rel="stylesheet" href="/public/static/gf/css/viewer.min.css">
  <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><small class="am-text-sm">租约管理</small> > <small class="am-text-primary">租约申请</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group-xs">
            <button type="button" class="am-btn d-btn-1188F0 am-radius addLease"><span class="am-icon-plus"></span>  租约申请</button>
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
    				<th class="table-type">房屋编号</th>
            <?php if(session('user_base_info.institution_level')!=3){ ;?>
    				<th class="table-type">机构名称</th>
            <?php }; ?>
    				<th class="table-author am-hide-sm-only">产别</th>
            <th class="table-set">房屋地址</th>
    				<th class="table-date am-hide-sm-only">结构</th>
	          <th class="table-set">房屋层</th>
	          <th class="table-set">居住层</th>
	          <th class="table-set">承租人</th>
    				<th class="table-set">流程状态</th>
    				<th class="table-set" style="width:114px;">操作</th>
              	</tr>
          </thead>
          <tbody>
		  <!--查询-->
          <form id="queryForm" action="<?php echo url('LeaseApply/index'); ?>" method="post">
		    <tr class="am-form-group am-form-inline">
              <td></td>
              <td></td>
              
              <td>
        				<div class="am-g am-input-group am-input-group-sm">
                    <?php
                        if($leaseOption != array()){
                            $HouseID = $leaseOption['HouseID'];
                        }else{
                            $HouseID = '';
                        }
                     ?>
        				  <input style="width:122px;" type="text" name="HouseID" class="am-form-field" value="<?php echo $HouseID; ?>">
        				</div>
        			</td>
             

              <?php if(session('user_base_info.institution_level')!=3){ ;?>
              <td>
                  <div class="am-form-group am-form search_input">
                      
                      <select name="TubulationID">
                          <option value="" style="display:none">请选择</option>
                          <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 
                      if(isset($leaseOption['TubulationID'])){
                          if($leaseOption['TubulationID'] == $v10['id']){
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
                      if(isset($leaseOption['TubulationID'])){
                          if($leaseOption['TubulationID'] == $v12['id']){
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
                          <?php }} ; ?>
                      </select>
                  </div>
              </td>
              <?php } ; ?>


       
             <td>
                  <div class="am-form-group  am-form search_input">
                      <select name="OwnerType">
                          <option value="" style="display:none">请选择</option>
                          <?php foreach($owerLst as $k3 =>$v3){;
                            if(isset($leaseOption['OwnerType'])){
                                if($leaseOption['OwnerType'] == $v3['id']){
                                    $select ='selected';
                                }else{
                                    $select ='';
                                }
                            }else{
                                $select ='';
                            }
                            ?>

                          <option value="<?php echo $v3['id']; ?>" <?php echo $select; ?>>
                              <?php echo $v3['OwnerType']; ?>
                          </option>
                          <?php }; ?>
                      </select>
                  </div>
              </td>

              <td>
                <div class="am-g am-input-group am-input-group-sm">
                  <?php
                        if($leaseOption != array()){
                            $BanAddress = $leaseOption['BanAddress'];
                        }else{
                            $BanAddress = '';
                        }
                     ?>
                  <input style="width:122px;" type="text" name="BanAddress" class="am-form-field" value="<?php echo $BanAddress; ?>">
                </div>
              </td>

              <td>
                <div class="am-input-group am-input-group-sm" style="width:60px;"></div>
              </td>
         
              <td>
        			   <div class="am-input-group am-input-group-sm" style="width:60px;"></div>
        		  </td>
              <td>
                  <div class="am-input-group am-input-group-sm" style="width:60px;"></div>
              </td>
              <td>
        			   <div class="am-g am-input-group am-input-group-sm">
                      <?php
                        if($leaseOption != array()){
                            $TenantName = $leaseOption['TenantName'];
                        }else{
                            $TenantName = '';
                        }
                     ?>
                  <input style="width:122px;" type="text" name="TenantName" class="am-form-field" value="<?php echo $TenantName; ?>">
                </div>
        		  </td>
              

              <td>
          			<div class="am-input-group am-input-group-sm" style="width:60px;"></div>
          		</td>
              <td>
                <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/LeaseApply/index.html"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
        </form>
		<!---查询-->
        <?php foreach($leaseLst as $k => $v){; ?>
            <tr class="check001">
                <td>
                  <span class="piaochecked">
                    <input class="checkId radioclass" type="radio" value="<?php echo $v['ChangeOrderID']; ?>" />
                  </span>
                 </td>
                <td><?php echo $k+1; ?></td>
                <td><?php echo $v['HouseID']; ?></td>
                <?php if(session('user_base_info.institution_level')!=3){ ;?>
                <td><?php echo $v['InstitutionID']; ?></td>
                <?php }; ?>
                <td class="am-hide-sm-only"><?php echo $v['OwnerType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['BanAddress']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['StructureType']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['FloorNum']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['FloorID']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['TenantName']; ?></td>
                <td><a href="#"><?php echo $v['Status']; ?></a></td>
                <td>
                    <div class="am-btn-group am-btn-group-xs">
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnDetail" value="<?php echo $v['ChangeOrderID']; ?>">详情</button>
                    </div>
                    <div class="am-btn-group am-btn-group-xs">
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnDel" value="<?php echo $v['ChangeOrderID']; ?>">删除</button>
                    </div>
                </td>
            </tr>
        <?php }; ?>

          </tbody>
        </table>
		<div class="am-cf">
          共<?php echo $leaseLstObj->total(); ?>条记录
          <div class="am-fr">
          <?php echo $leaseLstObj->render(); ?>
          </div>
      </div>
      </div>
    </div>
  </div>


  <style type="text/css">
    input {
        border: none;
        height: 25px;
        outline: none;
        width: 120px;
        padding: 5px;
        font-size: 14px;
    }
    .outerControl .textContent {
        border: 1px solid #333333;
        padding: 0 74px 50px 74px;
        margin: 0px auto;
        margin-top: 50px;
    }
    .textinput {
        background-color: #ffffff;
        border-top: solid 1px #a7b5bc;
        border-left: solid 1px #a7b5bc;
        border-right: solid 1px #ced9df;
        border-bottom: solid 1px #ced9df;
        color: #333333;
        width: 200px;
        height: 28px;
        line-height: 28px;
    }
    .outerControl table{width:100%;border-spacing:0;border-top:1px solid #ccc;border-right:1px solid #ccc;text-align: center;}
    .outerControl td,.outerControl th{height:24px;border-left:1px solid #ccc;border-bottom:1px solid #ccc;font-size:12px;}
    .pzqk input{width:80px;}
    .fwClass input {
        width: 120px;
        height: 28px;
        line-height: 28px;
    }
    .remark{width:100%;height:250px;padding:5px;text-align:left;}
    .remark label{font-size:14px;font-weight:400;}
    .remark select,.remark input{width:150px;height:26px;margin-left:20px;border:1px solid #ccc;}
    .remark>input{width:300px;line-height:26px;}
    .remark p{font-size:14px;margin:10px auto;}
</style>
<div id="leaseAdd" class="outerControl" style="margin-left:125px;margin-top:20px;display:none;">
        <form id="MyForm" style="width:950px;">
            <!-- 基本信息 -->
            <div class="am-form-group am-u-md-12" style="padding-left:0;">
                <h2 class="label_title">租约申请：</h2>
            </div>
            <div class="am-u-md-8" style="margin-bottom:20px;">
                <label class="label_style">房屋编号：</label>
                <input type="text" class="label_input" id="leaseHouseInput" placeholder="房屋编号" required/>
                <a class="am-btn am-btn-primary am-btn-sm" id="leaseHouseQuery">查询</a>
            </div>
            <div class="am-u-md-4">
                租直NO:
                <input readonly type="text" id="applyNO" value="" class="validate[required] textinput" style="text-decoration: underline; font-family: 微软雅黑; font-size: 13px;" truetype="textinput" yzid="1">
            </div>
            <table border="1" cellspacing="" cellpadding="">
                <tbody>
                <tr>
                    <td rowspan="2">房屋坐落</td>
                    <td rowspan="2">
                        <textarea style="width: 200px; height: 50px; font-size: 13px; border: none; outline: none; font-family: 微软雅黑;" name="applyAddress" id="applyAddress" class="validate[required] textarea" truetype="textarea" yzid="2"></textarea></td>
                    <td rowspan="2" style="width: 40px;">结构</td>
                    <td rowspan="2">
                        <input readonly type="text" style="width: 150px; font-family: 微软雅黑; font-size: 13px;" name="applyStruct" id="applyStruct" value="" truetype="textinput" class="textinput">
                    </td>
                    <td style="width: 50px;">房屋层</td>
                    <td>
                        <input readonly type="text" style="width: 100px; font-family: 微软雅黑; font-size: 13px;" name="applyHouseFloor" id="applyHouseFloor" value="" truetype="textinput" class="textinput"></td>
                </tr>
                <tr>
                    <td>居住层</td>
                    <td>
                        <input readonly type="text" style="width: 100px; font-family: 微软雅黑; font-size: 13px;" name="applyLiveFloor" id="applyLiveFloor" value="" truetype="textinput" class="textinput"></td>
                </tr>
                <tr>
                    <td rowspan="2">承租人姓名</td>
                    <td rowspan="2">
                        <input readonly style="width: 150px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRentName" id="applyRentName" value="" class="validate[required] textinput" truetype="textinput" yzid="3"></td>
                    <td colspan="2">身份证号</td>
                    <td colspan="4">
                        <input readonly style="width: 300px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRentNumber" id="applyRentNumber" value="" maxlength="18" truetype="textinput" class="textinput"></td>
                </tr>
                <tr>
                     <td colspan="2">承租人电话</td>
                    <td colspan="4">
                        <input readonly style="width: 300px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRentTel" id="applyRentTel" value="" maxlength="11" truetype="textinput" class="textinput"></td>
                </tr>
                <tr>
                    <td>承租人代表/监护人 姓名</td>
                    <td>
                        <input readonly style="width: 150px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRentName1" id="applyRentName1" truetype="textinput" class="textinput"></td>
                    <td colspan="2">监护人身份证号</td>
                    <td colspan="4">
                        <input readonly style="width: 300px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRentNumber1" id="applyRentNumber1" maxlength="18" truetype="textinput" class="textinput"></td>
                </tr>
                <tr>
                    <td colspan="6">注：承租人代表/监护人无处置、转让、房改、征收等权利</td>
                </tr>
                <tr>
                    <td colspan="8" style="height: 400px; font-size: 24px;">
                        <div style="float: left; margin: 0 130px 50px 75px;">
                            <span>出租人：（甲方）</span><br>
                            <span style="color:red;font-size:14px;">区公司审核后在此盖章</span>
                            
                        </div>
                        <div style="float: right; margin: 0 75px 50px 50px;">
                            <span>承租人：（乙方）</span><br>
                          
                            <span style="color:red;font-size:14px;">打印证件时在此签字</span>
                           
                        </div>
                        <div style="clear: both;"></div>
                        
                        <div style="float: right; margin: 0 75px 50px 50px;">
                            <span>承租人代表/监护人签章：</span><br>
                            <input style="height: 30px; width: 200px;" type="" name="applyRepresent" value="">
                        </div>
                        <div style="clear: both;"></div>
                        <div style="float: right; margin: 0 75px 50px 50px;">
                            租约签订日期
                            <input style="width: 50px;" name="applyYear" id="applyYear" value="2018" class="validate[required]" yzid="4">
                            年
                            <input style="width: 30px;" name="applyMonth" id="applyMonth" value="08" class="validate[required]" yzid="5">
                            月
                            <input style="width: 30px;" name="applyDay" id="applyDay" value="16" class="validate[required]" yzid="6">
                            日
                        </div>
                    </td>
                </tr>
            </tbody></table>
            <!-- 评 租 情 况 记 载 -->
            <hr style="margin-top:30px;" />
            <div class="am-form-group am-u-md-12" style="padding-left:0;">
                <h2 class="label_title">评租情况记载：</h2>
            </div>
            <table class="pzqk" border="1" cellspacing="" cellpadding="">
                <tbody><tr>
                    <th colspan="2">部位</th>
                    <th>间号</th>
                    <th>实有面积（m²）</th>
                    <th>计租面积（m²）</th>
                    <th>租金（元）</th>
                    <th colspan="2">项目</th>
                    <th>单价（元）</th>
                    <th>数量（m²）（件、个）</th>
                    <th>租金（元）</th>
                </tr>
                <tr>
                    <td rowspan="4" colspan="2">卧室</td>
                    <td>
                        <input readonly class="jianhao textinput" type="text" name="applyRoom1_data1" id="applyRoom1_data1" value="" truetype="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly type="" name="applyRoom1_data2" id="applyRoom1_data2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="7"></td>
                    <td>
                        <input readonly type="" name="applyRoom1_data3" id="applyRoom1_data3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="8"></td>
                    <td>
                        <input readonly type="" name="applyRoom1_data4" id="applyRoom1_data4" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="9"></td>
                    <td rowspan="4">三户以上共用</td>
                    <td>厅（堂）</td>
                    <td>0.50/个</td>
                    <td>
                        <input readonly type="" name="applyRoom1_data5" id="applyRoom1_data5" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="10"></td>
                    <td>
                        <input readonly type="" name="applyRoom1_data6" id="applyRoom1_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="11"></td>
                </tr>
                <tr>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom2_data1" id="applyRoom2_data1" value=""></td>
                    <td>
                        <input readonly type="" name="applyRoom2_data2" id="applyRoom2_data2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="12"></td>
                    <td>
                        <input readonly type="" name="applyRoom2_data3" id="applyRoom2_data3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="13"></td>
                    <td>
                        <input readonly type="" name="applyRoom2_data4" id="applyRoom2_data4" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="14"></td>
                    <td>厨房</td>
                    <td>0.50/个</td>
                    <td>
                        <input readonly type="" name="applyRoom2_data5" id="applyRoom2_data5" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="15"></td>
                    <td>
                        <input readonly type="" name="applyRoom2_data6" id="applyRoom2_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="16"></td>
                </tr>
                <tr>
                    <td>
                        <input readonly class="jianhao textinput" type="text" name="applyRoom3_data1" id="applyRoom3_data1" truetype="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly type="" name="applyRoom3_data2" id="applyRoom3_data2" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="17"></td>
                    <td>
                        <input readonly type="" name="applyRoom3_data3" id="applyRoom3_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="18"></td>
                    <td>
                        <input readonly type="" name="applyRoom3_data4" id="applyRoom3_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="19"></td>
                    <td>卫生间</td>
                    <td>0.50/个</td>
                    <td>
                        <input readonly type="" name="applyRoom3_data5" id="applyRoom3_data5" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="20"></td>
                    <td>
                        <input readonly type="" name="applyRoom3_data6" id="applyRoom3_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="21"></td>
                </tr>
                <tr>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom4_data1" id="applyRoom4_data1"></td>
                    <td>
                        <input readonly type="" name="applyRoom4_data2" id="applyRoom4_data2" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="22"></td>
                    <td>
                        <input readonly type="" name="applyRoom4_data3" id="applyRoom4_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="23"></td>
                    <td>
                        <input readonly type="" name="applyRoom4_data4" id="applyRoom4_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="24"></td>
                    <td>室内走道</td>
                    <td>0.50/个</td>
                    <td>
                        <input readonly type="" name="applyRoom4_data5" id="applyRoom4_data5" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="25"></td>
                    <td>
                        <input readonly type="" name="applyRoom4_data6" id="applyRoom4_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="26"></td>
                </tr>
                <tr>
                    <td rowspan="2">厅堂</td>
                    <td><input readonly type="text" name="applyRoom5_data1" value="独" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom5_data2" id="applyRoom5_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom5_data3" id="applyRoom5_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="27"></td>
                    <td>
                        <input readonly type="" name="applyRoom5_data4" id="applyRoom5_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="28"></td>
                    <td>
                        <input readonly type="" name="applyRoom5_data5" id="applyRoom5_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="29"></td>
                    <td rowspan="2">高1至1.7米搁楼</td>
                    <td>5m²以下</td>
                    <td>0.50/个</td>
                    <td>
                        <input readonly type="" name="applyRoom5_data6" id="applyRoom5_data6" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="30"></td>
                    <td>
                        <input readonly type="" name="applyRoom5_data7" id="applyRoom5_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="31"></td>
                </tr>
                <tr>
                    <td><input readonly type="text" name="applyRoom6_data1" value="共" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom6_data2" id="applyRoom6_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom6_data3" id="applyRoom6_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="32"></td>
                    <td>
                        <input readonly type="" name="applyRoom6_data4" id="applyRoom6_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="33"></td>
                    <td>
                        <input readonly type="" name="applyRoom6_data5" id="applyRoom6_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="34"></td>
                    <td>5m²以上</td>
                    <td>1.00/个</td>
                    <td>
                        <input readonly type="" name="applyRoom6_data6" id="applyRoom6_data6" value="0" class="validate[custom[onlyNumber]]" inputmode="positiveDecimal" yzid="35"></td>
                    <td>
                        <input readonly type="" name="applyRoom6_data7" id="applyRoom6_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1();gethj2()" yzid="36"></td>
                </tr>
                <tr>
                    <td rowspan="2">厨房</td>
                    <td><input readonly type="text" name="applyRoom7_data1" value="独" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom7_data2" id="applyRoom7_data2" value=""></td>
                    <td>
                        <input readonly type="" name="applyRoom7_data3" id="applyRoom7_data3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="37"></td>
                    <td>
                        <input readonly type="" name="applyRoom7_data4" id="applyRoom7_data4" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="38"></td>
                    <td>
                        <input readonly type="" name="applyRoom7_data5" id="applyRoom7_data5" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="39"></td>
                     <td colspan="2">
                        <input readonly type="text" name="applyRoom7_data6" id="applyRoom7_data6" value="二次供水" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input readonly type="text" name="applyRoom7_data7" id="applyRoom7_data7" value="0.08/m2" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input readonly type="" name="applyRoom7_data8" id="applyRoom7_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" yzid="40"></td>
                    <td>
                        <input readonly type="" name="applyRoom7_data9" id="applyRoom7_data9" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" yzid="41"></td>
                </tr>
                <tr>
                    <td><input readonly type="text" name="applyRoom8_data1" value="共" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom8_data2" id="applyRoom8_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom8_data3" id="applyRoom8_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="42"></td>
                    <td>
                        <input readonly type="" name="applyRoom8_data4" id="applyRoom8_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="43"></td>
                    <td>
                        <input readonly type="" name="applyRoom8_data5" id="applyRoom8_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="44"></td>
                    <td colspan="2">
                        <input type="text" name="applyRoom8_data6" id="applyRoom8_data6" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td><input type="text" name="applyRoom8_data7" id="applyRoom8_data7" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="" name="applyRoom8_data8" id="applyRoom8_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj2()" yzid="45"></td>
                    <td>
                        <input type="" name="applyRoom8_data9" id="applyRoom8_data9" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj2()" yzid="46"></td>
                    
                </tr>
                <tr>
                    <td rowspan="2">卫生间</td>
                    <td><input readonly type="text" name="applyRoom9_data1" value="独" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom9_data2" id="applyRoom9_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom9_data3" id="applyRoom9_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="47"></td>
                    <td>
                        <input readonly type="" name="applyRoom9_data4" id="applyRoom9_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="48"></td>
                    <td>
                        <input readonly type="" name="applyRoom9_data5" id="applyRoom9_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="49"></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input readonly type="text" name="applyRoom10_data1" value="共" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom10_data2" id="applyRoom10_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom10_data3" id="applyRoom10_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="50"></td>
                    <td>
                        <input readonly type="" name="applyRoom10_data4" id="applyRoom10_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="51"></td>
                    <td>
                        <input readonly type="" name="applyRoom10_data5" id="applyRoom10_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="52"></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan="2">室内走道</td>
                    <td><input readonly type="text" name="applyRoom11_data1" value="独" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom11_data2" id="applyRoom11_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom11_data3" id="applyRoom11_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="53"></td>
                    <td>
                        <input readonly type="" name="applyRoom11_data4" id="applyRoom11_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="54"></td>
                    <td>
                        <input readonly type="" name="applyRoom11_data5" id="applyRoom11_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="55"></td>
                    <td></td>
                    <td style="font-weight:bold;">间号</td>
                    <td style="font-weight:bold;">实有面积（m²）</td>
                    <td style="font-weight:bold;">计租面积（m²）</td>
                    <td style="font-weight:bold;">租金（元）</td>
                </tr>
                <tr>
                    <td><input readonly type="text" name="applyRoom12_data1" value="共" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom12_data2" id="applyRoom12_data2"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data3" id="applyRoom12_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="56"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data4" id="applyRoom12_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="57"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data5" id="applyRoom12_data5" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="58"></td>
                    <td>高1.7至2.2米搁楼</td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom12_data6" id="applyRoom12_data6"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data7" id="applyRoom12_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="59"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data8" id="applyRoom12_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="60"></td>
                    <td>
                        <input readonly type="" name="applyRoom12_data9" id="applyRoom12_data9" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="61"></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3">封闭阳台</td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom13_data1" id="applyRoom13_data1"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data2" id="applyRoom13_data2" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="62"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data3" id="applyRoom13_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="63"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data4" id="applyRoom13_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="64"></td>
                    <td rowspan="3">无封闭阳台</td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom13_data5" id="applyRoom13_data5"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data6" id="applyRoom13_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="65"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data7" id="applyRoom13_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="66"></td>
                    <td>
                        <input readonly type="" name="applyRoom13_data8" id="applyRoom13_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="67"></td>
                </tr>

               <tr>
                     <td>
                        <input readonly class="jianhao" type="" name="applyRoom14_data1" id="applyRoom14_data1"></td>
                    <td>
                        <input readonly type="" name="applyRoom14_data2" id="applyRoom14_data2" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="68"></td>
                    <td>
                        <input readonly type="" name="applyRoom14_data3" id="applyRoom14_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="69"></td>
                    <td>
                        <input readonly type="" name="applyRoom14_data4" id="applyRoom14_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="70"></td>
                   <td>
                        <input readonly class="jianhao" type="" name="applyRoom14_data5" id="applyRoom14_data5"></td>  
                   <td>
                        <input readonly type="" name="applyRoom14_data6" id="applyRoom14_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="71"></td>
                    <td>
                        <input readonly type="" name="applyRoom14_data7" id="applyRoom14_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="72"></td>
                    <td>
                        <input readonly type="" name="applyRoom14_data8" id="applyRoom14_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="73"></td>
                </tr>
                <tr>
                     <td>
                        <input readonly class="jianhao" type="" name="applyRoom15_data1" id="applyRoom15_data1"></td>
                    <td>
                        <input readonly type="" name="applyRoom15_data2" id="applyRoom15_data2" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="74"></td>
                    <td>
                        <input readonly type="" name="applyRoom15_data3" id="applyRoom15_data3" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="75"></td>
                    <td>
                        <input readonly type="" name="applyRoom15_data4" id="applyRoom15_data4" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="76"></td>
                    <td>
                        <input readonly class="jianhao" type="" name="applyRoom15_data5" id="applyRoom15_data5"></td> 
                    <td>
                        <input readonly type="" name="applyRoom15_data6" id="applyRoom15_data6" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="77"></td>
                    <td>
                        <input readonly type="" name="applyRoom15_data7" id="applyRoom15_data7" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="78"></td>
                    <td>
                        <input readonly type="" name="applyRoom15_data8" id="applyRoom15_data8" value="0" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" yzid="79"></td>
                </tr>
                
                 <tr>
                    <td colspan="2"> 
                        <input type="text" name="applyRoom16_data1" id="applyRoom16_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom16_data2" id="applyRoom16_data2" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom16_data3" id="applyRoom16_data3" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom16_data4" id="applyRoom16_data4" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom16_data5" id="applyRoom16_data5" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td colspan="2" rowspan="4">合计</td>
                    <td rowspan="4">
                        <input readonly type="" name="applyRoom16_data6" id="applyRoom16_data6" value="" readonly="true">
                    </td>
                    <td rowspan="4">
                        <input readonly type="" name="applyRoom16_data7" id="applyRoom16_data7" value="" readonly="true">
                    </td>
                    <td rowspan="4">
                        <input type="" name="applyRoom16_data8" id="applyRoom16_data8" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                        <input type="text" name="applyRoom17_data1" id="applyRoom17_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom17_data2" id="applyRoom17_data2" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom17_data3" id="applyRoom17_data3" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom17_data4" id="applyRoom17_data4" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom17_data5" id="applyRoom17_data5" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="applyRoom18_data1" id="applyRoom18_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom18_data2" id="applyRoom18_data2" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom18_data3" id="applyRoom18_data3" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom18_data4" id="applyRoom18_data4" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom18_data5" id="applyRoom18_data5" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="applyRoom19_data1" id="applyRoom19_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom19_data2" id="applyRoom19_data2" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom19_data3" id="applyRoom19_data3" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom19_data4" id="applyRoom19_data4" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                    <td>
                        <input type="text" name="applyRoom19_data5" id="applyRoom19_data5" value="0" onblur="gethj1()" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">合计</td>
                    <td>
                        <input readonly class="jianhao" name="applyRoom20_data1" id="applyRoom20_data1"></td>
                    <td>
                        <input readonly type="" name="applyRoom20_data2" id="applyRoom20_data2" value="" readonly="true"></td>
                    <td>
                        <input readonly type="" name="applyRoom20_data3" id="applyRoom20_data3" value="" readonly="true"></td>
                    <td>
                        <input readonly type="" name="applyRoom20_data4" id="applyRoom20_data4" value="" readonly="true"></td>
                    <td colspan="2">核定月租金</td>
                    <td colspan="3">
                        ¥<input readonly style="width: 150px; font-family: 微软雅黑; font-size: 13px;" type="text" name="applyRoom20_data5" id="applyRoom20_data5" value="" class="validate[custom[onlyNumberWide]] textinput" onblur="gethdyzj()" truetype="textinput" yzid="80">元</td>
                </tr>
                <tr>
                    <td colspan="11">资料员：<input readonly style="width: 120px; margin-right: 30px;" type="" name="applyRoom21_data1" id="applyRoom21_data1">
                        &nbsp;  &nbsp;  &nbsp;
                        经管所长：<input readonly style="width: 120px; margin-right: 30px;" type="" name="applyRoom21_data2" id="applyRoom21_data2">
                        &nbsp;  &nbsp;  &nbsp;
                        经管科长：<input readonly style="width: 120px; margin-right: 30px;" type="" name="applyRoom21_data3" id="applyRoom21_data3" value="">
                    </td>
                </tr>
            </tbody></table>
            <!-- 房屋构件设备点交记载 -->
            <hr style="margin-top:30px;" />
            <div class="am-form-group am-u-md-12" style="padding-left:0;">
                <h2 class="label_title">房屋构件设备点交记载：</h2>
            </div>
            <table class="fwClass" border="1" cellspacing="" cellpadding="">
                <tbody><tr>
                    <td>名称</td>
                    <td>数量</td>
                    <td>附注</td>
                    <td></td>
                    <td>名称</td>
                    <td>数量</td>
                    <td>附注</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="applyDev1_data1" id="applyDev1_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev1_data2" id="applyDev1_data2" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="81" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev1_data3" id="applyDev1_data3" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td></td>
                    <td>
                        <input type="text" name="applyDev1_data4" id="applyDev1_data4" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev1_data5" id="applyDev1_data5" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="82" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev1_data6" id="applyDev1_data6" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="applyDev2_data1" id="applyDev2_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev2_data2" id="applyDev2_data2" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="83" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev2_data3" id="applyDev2_data3" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td></td>
                    <td>
                        <input type="text" name="applyDev2_data4" id="applyDev2_data4" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev2_data5" id="applyDev2_data5" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="84" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev2_data6" id="applyDev2_data6" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="applyDev3_data1" id="applyDev3_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev3_data2" id="applyDev3_data2" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="85" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev3_data3" id="applyDev3_data3" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td></td>
                    <td>
                        <input type="text" name="applyDev3_data4" id="applyDev3_data4" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev3_data5" id="applyDev3_data5" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="86" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev3_data6" id="applyDev3_data6" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="applyDev4_data1" id="applyDev4_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev4_data2" id="applyDev4_data2" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="87" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev4_data3" id="applyDev4_data3" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td></td>
                    <td>
                        <input type="text" name="applyDev4_data4" id="applyDev4_data4" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev4_data5" id="applyDev4_data5" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="88" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev4_data6" id="applyDev4_data6" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="applyDev5_data1" id="applyDev5_data1" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev5_data2" id="applyDev5_data2" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="89" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev5_data3" id="applyDev5_data3" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td></td>
                    <td>
                        <input type="text" name="applyDev5_data4" id="applyDev5_data4" value="" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev5_data5" id="applyDev5_data5" value="0" class="validate[custom[onlyNumber]] textinput" truetype="textinput" yzid="90" style="font-family: 微软雅黑; font-size: 13px;"></td>
                    <td>
                        <input type="text" name="applyDev5_data6" id="applyDev5_data6" value="" truetype="textinput" class="textinput" style="font-family: 微软雅黑; font-size: 13px;"></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p style="margin: 60px 0 30px 0;"><span style="font-size: 20px; width: 50px; border-bottom: 3px double #333333;">附记</span></p>
                        <div class="remark">
                            <label>
                                <span class="applyYear"></span>年<span class="applyMonth"></span>月<span class="applyDay"></span>日</label>
                            <select>
                                <option>请选择</option>
                                <option value="1">老证换新证</option>
                                <option value="2">遗失补发</option>
                                <option value="3">亲属转让</option>
                                <option value="4">正常过户</option>
                                <option value="5">新发租</option>
                                <option value="6">其他</option>
                            </select>
                            <input style="display:none;" placeholder="备注" class="input_remark" />
                          
                            <input type="hidden" class="applyText_other" name="applyText_other" />
                            <input type="hidden" class="applyText_other" name="Recorde" />
                        </div>
                        <!-- <textarea name="applyText_other" style="width:100%;height:250px;border:none;">

                        </textarea> -->
                    </td>
                </tr>
            </tbody></table>
            <!-- 约定事项 -->
            <hr style="margin-top:30px;" />
            <div class="am-form-group am-u-md-12" style="padding-left:0;">
                <h2 class="label_title">约定事项：</h2>
            </div>
            <div class="textContent">
                <p style="margin: 60px 0 30px 0; text-align: center;"><span style="font-size: 24px; width: 50px; border-bottom: 3px double #333333;">约定事项</span></p>
                <p>1、承租人代表履行直管公房的看管义务、负责缴纳租金等事项。</p>
                <p>2、监护人代未成年人、无民事行为能力或限制民事行为能力人的承租人履行直管公房的看管义务、负责缴纳租金等事项，待被监护人成年或具备完全民事行为能力时，办理承租人过户手续。</p>
                <p>3、出租人（下称甲方）和承租人（下称乙方）应遵守《武汉市房产管理条例》和租约约定的相关规定。</p>
                <p>4、对房屋的自然损坏或合同约定由甲方修缮的，甲方负责修复。不及时修复，致使房屋发生破坏性事故，造成乙方财产损失或者人身伤害的，甲方应当承担赔偿责任。</p>
                <p>5、乙方应当合理使用房屋及附属设施，不得擅自拆改，扩建或增添。确需变动的，必须征得甲方同意并签订书面合同。</p>
                <p>6、乙方不得在室内堆放易燃易爆物品，家庭用电负荷必须与房屋配备电表容量相匹配，如乙方使用不当造成房屋损坏或人身财产损失的，由乙方负责修复或赔偿。</p>
                <p>7、乙方应于本月月底前交付当月租金，不得拖欠；逾期未交，房管所下达催缴通知单仍未缴纳的，乙方除应支付拖欠租金外，还应按月支付欠租总额3%的违约金。</p>
                <p>8、乙方有下列行为之一的，甲方有权终止合同，收回房屋：</p>
                <p>（1）将承租的房屋擅自转租的；</p>
                <p>（2）将承租的房屋转让、转借他人或擅自调换使用的；</p>
                <p>（3）将承租的房屋擅自拆改结构或改变用途的；</p>
                <p>（4）拖欠租金累计六个月以上的；</p>
                <p>（5）利用承租房屋进行违法活动。</p>
                <p></p>
                <p style="text-align: right; margin-top: 40px;">武汉市住房保障和房屋管理局印制</p>
            </div>
            <p style="text-align: center;">
<!--                 <input readonly type="hidden" id="ZY_ID" name="ZY_ID" value="4ff0beadb0704926a1be7c544fbb020e" truetype="hidden">
                <input readonly type="hidden" id="ZGGF_FILE" name="ZGGF_FILE" truetype="hidden">
                <input readonly type="hidden" id="ZGGF_HZYY" name="ZGGF_HZYY" truetype="hidden">
                <input readonly type="hidden" id="czr1" truetype="hidden">
                <input readonly type="hidden" id="czr" name="czr" truetype="hidden">
                <input readonly type="hidden" id="gdzjxt" name="gdzjxt" truetype="hidden">
                <input readonly type="hidden" id="hidstream" name="hidstream" value="" truetype="hidden">
                <input readonly type="hidden" id="gdzjhj1" name="gdzjhj1" truetype="hidden" value="21.53">
                <input readonly type="hidden" id="gdzjhj2" name="gdzjhj2" truetype="hidden" value="0">
                <input readonly type="hidden" id="ZGGF_BY2" name="ZGGF_BY2" truetype="hidden">
                <input readonly type="hidden" id="ZGGF_BY3" name="ZGGF_BY3" truetype="hidden"> -->
            </p>

        </form>
            
            <div class="am-form-group am-u-md-12">
                <h2 class="label_title">附件上传：</h2>
            </div>
            <div class="am-u-md-12 fileUpLoad">
                <div class="am-u-md-4">
                    <p>计租表：</p>
                </div>
                <div class="am-form-group am-form-file am-u-md-8">
                    <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                    <input readonly id="leaseApplication1" type="file" name="leaseApplication1" multiple>
                </div>
                <div id="leaseApplication1_Show" class="am-u-md-12"></div>
            </div>
            <div class="am-u-md-12 fileUpLoad">
                <div class="am-u-md-4">
                    <p>住宅租约：</p>
                </div>
                <div class="am-form-group am-form-file am-u-md-8">
                    <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                    <input readonly id="leaseApplication2" type="file" name="leaseApplication2" multiple>
                </div>
                <div id="leaseApplication2_Show" class="am-u-md-12"></div>
            </div>
            <div class="am-u-md-12 fileUpLoad">
                <div class="am-u-md-4">
                    <p>身份证：</p>
                </div>
                <div class="am-form-group am-form-file am-u-md-8">
                    <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                    <input readonly id="leaseApplication3" type="file" name="leaseApplication3" multiple>
                </div>
                <div id="leaseApplication3_Show" class="am-u-md-12"></div>
            </div>
            <div class="am-u-md-12">
                <label class="label_style">换租原因：</label>
                <input type="text" class="label_input applyReason" name="applyReason" value="老证换新证" required/>
            </div>
</div>
  <style type="text/css">
  .detail table{border-spacing:0;border-top:1px solid #000;border-right:1px solid #000;}
  .detail td,.detail th{height:24px;border-left:1px solid #000;border-bottom:1px solid #000;font-size:13px;font-weight:400;padding:2px 0;}
</style>
<div id="leaseDetail" class="detail" style="width:1080px;padding-left:50px;display:none;">
        <form id="MyDetail" width="1091px">
            <!--startprint2-->
            
            <!-- 基本信息 -->
            <div style="margin-top: 40px;">
                <div style="margin-top:44px;float: left; width: 46%; margin-left: 2%;height:611px;">
                    <!-- 约定事项 -->
                    <div class="textContent">
                        <table id="jbydtable" style="height:611px;box-sizing:border-box;border:1px solid #000;">
                            <tbody>
                            <tr>
                                <td style="border:0px;"><p style="margin: 10px 0 10px 0; text-align: center;"><span style="font-size: 24px; width: 100px; border-bottom: 3px double #333333;">约定事项</span></p></td>
                            </tr>
                            <tr>
                                <td style="border:0px;">1、承租人代表履行直管公房的看管义务、负责缴纳租金等事项。</td>
                            </tr>
                            <tr>
                                <td style="border:0px;" rowspan="3">2、监护人代未成年人、无民事行为能力或限制民事行为能力人的承租人履行直管公房的看管义务、负责缴纳租金等事项，待被监护人成年或具备完全民事行为能力时，办理承租人过户手续。</td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;" rowspan="2">3、出租人（下称甲方）和承租人（下称乙方）应遵守《武汉市房产管理条例》和租约约定的相关规定。</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;letter-spacing:2px;" rowspan="2">4、对房屋的自然损坏或合同约定由甲方修缮的，甲方负责修复。不及时修复，致使房屋发生破坏性事故，造成乙方财产损失或者人身伤害的，甲方应当承担赔偿责任。</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;" rowspan="2">5、乙方应当合理使用房屋及附属设施，不得擅自拆改，扩建或增添。确需变动的，必须征得甲方同意并签订书面合同。</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;letter-spacing:2px;" rowspan="2">6、乙方不得在室内堆放易燃易爆物品，家庭用电负荷必须与房屋配备电表容量相匹配，如乙方使用不当造成房屋损坏或人身财产损失的，由乙方负责修复或赔偿。</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;letter-spacing:2px;" rowspan="2">7、乙方应于本月底前交付当月租金，不得拖欠；逾期未交，房管所下达催缴通知单仍未缴纳的，乙方除应支付拖欠租金外，还应按月支付欠租总额3%的违约金。</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;">8、乙方有下列行为之一的，甲方有权终止合同，收回房屋：</td>
                            </tr>
                            <tr>
                                <td style="border:0px;">（1）将承租的房屋擅自转租的；</td>
                            </tr>
                            <tr>
                                <td style="border:0px;">（2）将承租的房屋转让、转借他人或擅自调换使用的；</td>
                            </tr>
                            <tr>
                                <td style="border:0px;">（3）将承租的房屋擅自拆改结构或改变用途的；</td>
                            </tr>
                            <tr>
                                <td style="border:0px;">（4）拖欠租金累计六个月以上的；</td>
                            </tr>
                            <tr>
                                <td style="border:0px;">（5）利用承租房屋进行违法活动。</td>
                            </tr>
                            <tr>
                                <td style="border:0px;" rowspan="2"></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td style="border:0px;text-align:right;">武汉市住房保障和房屋管理局印制</td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>

                <div style="float: left; width: 46%; margin-left: 4%;height:611px;">
                    <p class="topHeader" style="text-align: right;">
                        租直NO:&nbsp;&nbsp;&nbsp;<span id="detailNO"></span>
                    </p>
                    <table id="table1" cellspacing="" cellpadding="" style="height:611px;box-sizing:border-box">
                        <tbody><tr>
                            <td rowspan="2" style="width: 80px;">房屋坐落</td>
                            <td id="detailAddress" rowspan="2" colspan="2" style="width: 130px;"></td>
                            <td rowspan="2" style="width: 50px;">结构</td>
                            <td id="detailStruct" rowspan="2" style="width: 80px;">
                                
                            </td>
                            <td style="width: 80px;">房屋层</td>
                            <td id="detailHouseFloor" style="width: 20px;">
                                
                            </td>
                        </tr>
                        <tr>
                            <td>居住层</td>
                            <td id="detailLiveFloor"></td>
                        </tr>
                        <tr>
                            <td style="height:48px;" rowspan="2">承租人姓名</td>
                            <td id="detailRentName" style="width: 150px;height:48px;" rowspan="2">

                            </td>
                            <td style="width: 50px;height:48px;">身份证号</td>
                            <td id="detailRentNumber" colspan="4" style="height:48px;">
                                </td>
                        </tr>
                        <tr>
                            
                            <td style="width: 30px;height:48px;">承租人电话</td>
                            <td id="detailRentTel" colspan="4" style="height:48px;">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2">承租人代表/监护人 姓名</td>
                            <td id="detailRentName1" rowspan="2">
                                </td>
                              <td>身份证号</td>
                        <td id="detailRentNumber1" colspan="4">
                        
                        </td>
                            
                        </tr>
                        <tr><td colspan="5">注：承租人代表/监护人无处置、转让、房改、征收等权利</td></tr>
                        <tr>
                            <td id="zztdheight" colspan="7" style="height: 386px; font-size: 18px;">
                                <div style="float: left; margin-left: 20px; margin-top: 0px;">
                                    <span>出租人：（甲方）</span><br>

                                </div>
                                <div style="float: left; margin-left: 40px; margin-top: 0px;">
                                    <span>承租人：（乙方）</span><br>
                                    
                                    <input type="hidden" id="czr1" value="" truetype="hidden">
                                    <div id="signature" style="clear: both; margin-top: 10px;">
                                        <!-- divstart -->
                                                <div style="width:160px;height:60px;border:0px;"></div>

                                        <!-- divend -->
                                    </div>
                                </div>
                                <!-- divstart2 -->
                                <div id="div1" style="clear: both; float: left; margin: -30px 130px 30px 75px; width: 150px; height: 150px;">
                                        <img id="imghid" src="/public/static/gf/img/zhang08.png" style="width: 130px; height: 130px; margin-top: -20px; margin-left: -50px; float: left;display:none;">
                                </div>
                                 
                                <img id="picCode" src="/" style="margin-left:25px;width:106px;height:106px;clear:both;float:left;display:none;">
                                <!-- divend2 -->
                                <div style="float: right; margin: -105px 35px 50px 50px;width:220px;">
                                    <span>承租人代表/监护人签章：</span>
                                    <div id="jhrdiv">
                                        <!-- divstart3 -->
                                            <div style="width:160px;height:60px;border:0px;" id="detailRepresent"></div>
                                        <!-- divend3 -->
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="float: right; margin: -50px 40px 10px 50px;">
                                    租约签订日期&nbsp;&nbsp;<span id="detailYear"></span> 年<span id="detailMonth"></span> 月<span id="detailDay"></span> 日
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>

            </div>
            
            <!--startprint1-->
            <div style="clear: both; padding-top: 75px;">
                <div style="float: left; width: 46%; margin-left: 2%;margin-top:10px;">
                    <!-- 评 租 情 况 记 载 -->
                    <p class="titleStyle" style="text-align: center;font-size: 24px;margin-top: 0px;">评 租 情 况 记 载</p>
                    <table class="pzqk" cellspacing="" cellpadding="" style="margin-top: 5px;height:538px;">
                        <tbody><tr>
                            <th colspan="2" style="width: 85px;">部位</th>
                            <th style="width: 40px;">间号</th>
                            <th style="width: 55px;">实有面积(m²)</th>
                            <th style="width: 55px;">计租面积(m²)</th>
                            <th style="width: 40px;">租金(元)</th>
                            <th colspan="2">项目</th>
                            <th style="width: 60px;">单价(元)</th>
                            <th style="width: 70px;">数量（m²）（件、个）</th>
                            <th style="width: 40px;">租金(元)</th>
                        </tr>
                        <tr>
                            <td rowspan="4" colspan="2">卧室</td>
                            <td id="detailRoom1_data1">
                                
                            </td>
                            <td id="detailRoom1_data2">
                                
                            </td>
                            <td id="detailRoom1_data3">
                                
                            </td>
                            <td id="detailRoom1_data4">
                                
                            </td>
                            <td rowspan="4" style="width: 75px;">三户以上共用</td>
                            <td style="width: 78px;">厅(堂)</td>
                            <td>0.50/个</td>
                            <td id="detailRoom1_data5"></td>
                            <td id="detailRoom1_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailRoom2_data1">
                                
                            </td>
                            <td id="detailRoom2_data2">
                                
                            </td>
                            <td id="detailRoom2_data3">
                                
                            </td>
                            <td id="detailRoom2_data4">
                                
                            </td>
                            <td>厨房</td>
                            <td>0.50/个</td>
                            <td id="detailRoom2_data5"></td>
                            <td id="detailRoom2_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailRoom3_data1"></td>
                            <td id="detailRoom3_data2"></td>
                            <td id="detailRoom3_data3"></td>
                            <td id="detailRoom3_data4"></td>
                            <td>卫生间</td>
                            <td>0.50/个</td>
                            <td id="detailRoom3_data5">
                        
                            <td id="detailRoom3_data6">
      
                            </td>
                        </tr>
                        <tr>
                            <td id="detailRoom4_data1"></td>
                            <td id="detailRoom4_data2"></td>
                            <td id="detailRoom4_data3"></td>
                            <td id="detailRoom4_data4"></td>
                            <td>室内走道</td>
                            <td>0.50/个</td>
                            <td id="detailRoom4_data5">
               
                            <td id="detailRoom4_data6">
                                
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="width: 75px;">厅堂</td>
                            <td>独</td>
                            <td id="detailRoom5_data2">
                                
                            </td>
                            <td id="detailRoom5_data3">
                                </td>
                            <td id="detailRoom5_data4">
                                </td>
                            <td id="detailRoom5_data5">
                                </td>
                            <td rowspan="2">高1至1.7米搁楼</td>
                            <td>5m²以下</td>
                            <td>0.50/个</td>
                            <td id="detailRoom5_data6">
                                </td>
                            <td id="detailRoom5_data7">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="detailRoom6_data2">
                                </td>
                            <td id="detailRoom6_data3">
                                </td>
                            <td id="detailRoom6_data4">
                                </td>
                            <td id="detailRoom6_data5">
                                </td>
                            <td>5m²以上</td>
                            <td>1.00/个</td>
                            <td id="detailRoom6_data6">
                               </td>
                            <td id="detailRoom6_data7">
                              </td>
                        </tr>
                        <tr>
                            <td rowspan="2">厨房</td>
                            <td>独</td>
                            <td id="detailRoom7_data2">
                                </td>
                            <td id="detailRoom7_data3">
                                </td>
                            <td id="detailRoom7_data4">
                                </td>
                            <td id="detailRoom7_data5">
                                </td>
                            <td colspan="2">二次供水<input type="hidden" name="ECGS_NAME" id="ECGS_NAME" value="二次供水" truetype="hidden"></td>
                            <td>0.08/m2<input type="hidden" name="ECGS_DW" id="ECGS_DW" value="0.08/m2" truetype="hidden"></td>
                            <td id="detailRoom7_data8">
                                </td>
                            <td id="detailRoom7_data9">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="detailRoom8_data2">
                                </td>
                            <td id="detailRoom8_data3">
                                </td>
                            <td id="detailRoom8_data4">
                                </td>
                            <td id="detailRoom8_data5">
                                </td>
                            <td id="detailRoom8_data6" colspan="2"><input type="hidden" name="MP_NAME" id="MP_NAME" value="" truetype="hidden"></td>
                            <td id="detailRoom8_data7"></td>
                            <td id="detailRoom8_data8">
                                </td>
                            <td id="detailRoom8_data9">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2">卫生间</td>
                            <td>独</td>
                            <td id="detailRoom9_data2">
                                </td>
                            <td id="detailRoom9_data3">
                                </td>
                            <td id="detailRoom9_data4">
                                </td>
                            <td id="detailRoom9_data5">
                                </td>
                            <td colspan="2"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="detailRoom10_data2">
                                </td>
                            <td id="detailRoom10_data3">
                                </td>
                            <td id="detailRoom10_data4">
                                </td>
                            <td id="detailRoom10_data5">
                                </td>
                            <td></td>
                            <td>间号</td>
                            <td>实有面积(m²)</td>
                            <td>计租面积(m²)</td>
                            <td>租金(元)</td>
                        </tr>
                        <tr>
                            <td rowspan="2">室内走道</td>
                            <td>独</td>
                            <td id="detailRoom11_data2">
                                </td>
                            <td id="detailRoom11_data3">
                                </td>
                            <td id="detailRoom11_data4">
                                </td>
                            <td id="detailRoom11_data5">
                                </td>
                            <td rowspan="3">无封闭阳台</td>
                           <td id="detailRoom13_data5">
                        47-1</td>
                            <td id="detailRoom13_data6">
                                </td>
                            <td id="detailRoom13_data7">
                                </td>
                            <td id="detailRoom13_data8">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="detailRoom12_data2">
                               </td>
                            <td id="detailRoom12_data3">
                                </td>
                            <td id="detailRoom12_data4">
                                </td>
                            <td id="detailRoom12_data5">
                                <input type="hidden" name="DOW_YZJ2" id="DOW_YZJ2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="55"></td>
                            <td id="detailRoom14_data5">
                        <input class="jianhao" type="hidden" name="WFBYT_JHO2" id="WFBYT_JHO2" value="" truetype="hidden"></td>
                    <td id="detailRoom14_data6">
                        <input type="hidden" name="WFBYT_SM2" id="WFBYT_SM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="56"></td>
                    <td id="detailRoom14_data7">
                        <input type="hidden" name="WFBYT_JM2" id="WFBYT_JM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="57"></td>
                    <td id="detailRoom14_data8">
                        <input type="hidden" name="WFBYT_YZJ2" id="WFBYT_YZJ2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="58"></td>
                            
                        </tr>
                        
                       <tr>
                    <td colspan="2" rowspan="3">封闭阳台</td>
                    <td id="detailRoom13_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO1" id="FBYT_JHO1" value="" truetype="hidden"></td>
                    <td id="detailRoom13_data2">
                        <input type="hidden" name="FBYT_SM1" id="FBYT_SM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="59"></td>
                    <td id="detailRoom13_data3">
                        <input type="hidden" name="FBYT_JM1" id="FBYT_JM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="60"></td>
                    <td id="detailRoom13_data4">
                        <input type="hidden" name="FBYT_YZJ1" id="FBYT_YZJ1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="61"></td>
                    <td id="detailRoom15_data5">
                        <input class="jianhao" type="hidden" name="WFBYT_JHO3" id="WFBYT_JHO3" value="" truetype="hidden"></td>
                    <td id="detailRoom15_data6">
                        <input type="hidden" name="WFBYT_SM3" id="WFBYT_SM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="62"></td>
                    <td id="detailRoom15_data7">
                        <input type="hidden" name="WFBYT_JM3" id="WFBYT_JM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="63"></td>
                    <td id="detailRoom15_data8">
                        <input type="hidden" name="WFBYT_YZJ3" id="WFBYT_YZJ3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="64"></td>
                </tr>

               <tr>
                     <td id="detailRoom14_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO2" id="FBYT_JHO2" value="" truetype="hidden"></td>
                    <td id="detailRoom14_data2">
                        <input type="hidden" name="FBYT_SM2" id="FBYT_SM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="65"></td>
                    <td id="detailRoom14_data3">
                        <input type="hidden" name="FBYT_JM2" id="FBYT_JM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="66"></td>
                    <td id="detailRoom14_data4">
                        <input type="hidden" name="FBYT_YZJ2" id="FBYT_YZJ2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="67"></td>
                     <td> <input type="hidden" name="ZGGF_FJLX4" id="ZGGF_FJLX4" value="" truetype="hidden"></td>
                            <td> <input type="hidden" name="ZGGF_FJH4" id="ZGGF_FJH4" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FSM4" id="ZGGF_FSM4" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FJM4" id="ZGGF_FJM4" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FYZJ4" id="ZGGF_FYZJ4" value="" truetype="hidden"></td>
                </tr>
                <tr>
                     <td id="detailRoom15_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO3" id="FBYT_JHO3" value="" truetype="hidden"></td>
                    <td id="detailRoom15_data2">
                        <input type="hidden" name="FBYT_SM3" id="FBYT_SM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="68"></td>
                    <td id="detailRoom15_data3">
                        <input type="hidden" name="FBYT_JM3" id="FBYT_JM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="69"></td>
                    <td id="detailRoom15_data4">
                        <input type="hidden" name="FBYT_YZJ3" id="FBYT_YZJ3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="70"></td>
                      <td><input type="hidden" name="ZGGF_FJLX1" id="ZGGF_FJLX1" value="" truetype="hidden"></td>
                        <td><input type="hidden" name="ZGGF_FJH1" id="ZGGF_FJH1" value="" truetype="hidden"></td>
                        <td><input type="hidden" name="ZGGF_FSM1" id="ZGGF_FSM1" value="" truetype="hidden"></td>
                        <td><input type="hidden" name="ZGGF_FJM1" id="ZGGF_FJM1" value="" truetype="hidden"></td>
                        <td><input type="hidden" name="ZGGF_FYZJ1" id="ZGGF_FYZJ1" value="" truetype="hidden"></td>
                </tr>
                        <tr>
                            <td colspan="2">高1.7至2.2米搁楼</td>
                            <td id="detailRoom12_data6">
                        <input class="jianhao" type="hidden" name="GL_JHO1" id="GL_JHO1" value="" truetype="hidden"></td>
                            <td id="detailRoom12_data7">
                                <input type="hidden" name="GL_SM1" id="GL_SM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="71"></td>
                            <td id="detailRoom12_data8">
                                <input type="hidden" name="GL_JM1" id="GL_JM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="72"></td>
                            <td id="detailRoom12_data9">
                                <input type="hidden" name="GL_YZJ1" id="GL_YZJ1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="73"></td>
                            <td> <input type="hidden" name="ZGGF_FJLX3" id="ZGGF_FJLX3" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FJH3" id="ZGGF_FJH3" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FSM3" id="ZGGF_FSM3" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FJM3" id="ZGGF_FJM3" value="" truetype="hidden"></td>
                            <td><input type="hidden" name="ZGGF_FYZJ3" id="ZGGF_FYZJ3" value="" truetype="hidden"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="detailRoom16_data1"> <input type="hidden" name="ZGGF_FJLX2" id="ZGGF_FJLX2" value="" truetype="hidden"></td>
                            <td id="detailRoom16_data2"><input type="hidden" name="ZGGF_FJH2" id="ZGGF_FJH2" value="" truetype="hidden"></td>
                            <td id="detailRoom16_data3"><input type="hidden" name="ZGGF_FSM2" id="ZGGF_FSM2" value="" truetype="hidden"></td>
                            <td id="detailRoom16_data4"><input type="hidden" name="ZGGF_FJM2" id="ZGGF_FJM2" value="" truetype="hidden"></td>
                            <td id="detailRoom16_data5"><input type="hidden" name="ZGGF_FYZJ2" id="ZGGF_FYZJ2" value="" truetype="hidden"></td>
                            <td colspan="2">合计</td>
                            <td id="detailRoom16_data6">
                                <input type="hidden" name="" value="" truetype="hidden"></td>
                            <td id="detailRoom16_data7">
                                
                            </td>
                            <td id="detailRoom16_data8"></td>
                        </tr>
                        <tr>
                            <td colspan="2">合计</td>
                            <td id="detailRoom20_data1">
                                <input class="jianhao" type="hidden" name="" value="" truetype="hidden"></td>
                            <td id="detailRoom20_data2"></td>
                            <td id="detailRoom20_data3"></td>
                            <td id="detailRoom20_data4"></td>
                            <td colspan="2">核定月租金</td>
                            <td id="detailRoom20_data5" colspan="3">
                                </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: center">资料员：<span id="detailRoom21_data1"></span>
                                &nbsp;  &nbsp;  &nbsp;
                        经管所长：<span id="detailRoom21_data2"></span>
                                &nbsp;  &nbsp;  &nbsp;经管科长：<span id="detailRoom21_data3"></span>
                            </td>
                        </tr>
                    </tbody></table>
                </div>

                <div style="float: left; width: 46%; margin-left: 4%;margin-top:10px;">
                    <!-- 房屋构件设备点交记载 -->
                    <p class="titleStyle" style="text-align: center;font-size: 24px;margin-top: 0px;">房屋构件设备点交记载</p>
                    <table class="fwClass" cellspacing="" cellpadding="" style="width:100%;height: 538px;box-sizing:border-box;">
                        <tbody><tr>
                            <td>名称</td>
                            <td>数量</td>
                            <td>附注</td>
                            <td></td>
                            <td>名称</td>
                            <td>数量</td>
                            <td>附注</td>
                        </tr>
                        <tr>
                            <td id="detailDev1_data1"></td>
                            <td id="detailDev1_data2"></td>
                            <td id="detailDev1_data3"></td>
                            <td></td>
                            <td id="detailDev1_data4"></td>
                            <td id="detailDev1_data5"></td>
                            <td id="detailDev1_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailDev2_data1"></td>
                            <td id="detailDev2_data2"></td>
                            <td id="detailDev2_data3"></td>
                            <td></td>
                            <td id="detailDev2_data4"></td>
                            <td id="detailDev2_data5"></td>
                            <td id="detailDev2_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailDev3_data1"></td>
                            <td id="detailDev3_data2"></td>
                            <td id="detailDev3_data3"></td>
                            <td></td>
                            <td id="detailDev3_data4"></td>
                            <td id="detailDev3_data5"></td>
                            <td id="detailDev3_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailDev4_data1"></td>
                            <td id="detailDev4_data2"></td>
                            <td id="detailDev4_data3"></td>
                            <td></td>
                            <td id="detailDev4_data4"></td>
                            <td id="detailDev4_data5"></td>
                            <td id="detailDev4_data6"></td>
                        </tr>
                        <tr>
                            <td id="detailDev5_data1"></td>
                            <td id="detailDev5_data2"></td>
                            <td id="detailDev5_data3"></td>
                            <td></td>
                            <td id="detailDev5_data4"></td>
                            <td id="detailDev5_data5"></td>
                            <td id="detailDev5_data6"></td>
                        </tr>
                        <tr>
                            <td id="fjtdheight" colspan="7" style="vertical-align: top; box-sizing: border-box;">
                                <p style="margin: 60px 0 30px 0; text-align: center;"><span style="font-size: 20px; width: 50px; border-bottom: 3px double #333333;">附记</span></p>
                                <div id="detailText_other" style="height:338px;width:100%;border: none;padding:5px;" readonly="readonly">

                                </div>
                                
                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <!--endprint1-->
            </div>
            <!--endprint2-->
        </form>
    <div class="print1_hide">
        <div class="am-u-sm-12"><hr /></div>

        <div class="am-form-group am-u-sm-2">
            <h2 class="label_title">换租原因：</h2>
        </div>
        <label id="detailReason" style="font-weight:500;line-height:28px;"></label>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="leaseApplyPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="leaseApplyState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>


</div>

<a href="#" class="am-show-sm-only admin-menu am-print-hide" data-am-offcanvas="{target: '#admin-offcanvas'}">
  <span class="am-icon-btn am-icon-th-list"></span>
</a>

<footer class="am-print-hide">
  <p id="version_show" style="text-align:center;margin:0;padding:1rem 0;background:#EDEDED;color:#999;cursor:pointer;">© 2017 CTNM 楚天新媒技术支持 <span style="color:#1188F0;">V1.5</span></p>
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
			<h3>2018-08-06</h3>
		</div>
		<div class="dot"></div>
		<div class="version_content">
			<h3>武房公房系统V1.5更新提醒</h3>
			<p class="fun_title">新增</p>
			<p>1.房屋调整异动上线</p>
			<p>2.楼栋调整异动上线</p>
			<p>3.租金减免异动上线</p>
			<p>4.空租异动上线</p>
			<p>5.暂停计租异动上线</p>
			<p>6.陈欠核销异动上线</p>
			<p>7.新发租异动上线</p>
			<p class="fun_title">优化</p>
			<p>1.租金追加上传资料</p>
			<p>2.使用权变更上传资料</p>
			<p>3.异动与楼栋、房屋和报表的关联</p>
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
<script type="text/javascript" src="/public/static/gf/js/viewer.min.js"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/lease_apply.js"></script>

</body>
</html>