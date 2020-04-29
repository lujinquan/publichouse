<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:71:"/usr/share/nginx/publichouse/application/ph/view/lease_audit/index.html";i:1566211566;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1573559825;s:43:"application/ph/view/lease_apply/detail.html";i:1537930001;s:43:"application/ph/view/lease_audit/print1.html";i:1539917348;s:43:"application/ph/view/lease_audit/print2.html";i:1539917348;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1578586810;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>租约审核</title>
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
  
  <link rel="stylesheet" href="/public/static/gf/css/iconfont.css?v=<?php echo $version; ?>">
  <link rel="stylesheet" href="/public/static/gf/css/viewer.min.css?v=<?php echo $version; ?>">
 <div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><small class="am-text-sm">租约管理</small> > <small class="am-text-primary">租约申请</small>&nbsp;&nbsp;<span style="font-size:14px;">租约已打印<i style="font-style:normal;color:red;"><?php echo $ids; ?></i>份</span>&nbsp;&nbsp;<span style="font-size:16px;">共<?php echo $leaseLstObj->total(); ?>条记录</span></div>
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
                <th class="table-set">楼栋地址</th>
                <th class="table-date am-hide-sm-only">结构</th>
                <th class="table-set">房屋层</th>
                <th class="table-set">居住层</th>
                <th class="table-set">承租人</th>
                <th class="table-set">流程状态</th>
                <?php if(in_array(101,$useRoles)){ ;?>
                <th class="table-set">打印时间</th>
                <th class="table-set">打印次数</th>
                <?php }; ?>
                <th class="table-set" style="">操作</th>
              </tr>
          </thead>
          <tbody>
		  <!--查询-->
          <form id="queryForm" action="<?php echo url('LeaseAudit/index'); ?>" method="post">
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
                  <input style="width:132px;" type="text" name="HouseID" class="am-form-field" value="<?php echo $HouseID; ?>">
                </div>
              </td>
              <?php if(session('user_base_info.institution_level')!=3){ ;?>
              <td>
                  <div class="am-form-group  am-form search_input">
                      
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
                <div class="am-input-group am-input-group-sm" style="width:60px;">
                  
                </div>
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
                <div class="am-form-group  am-form search_input">
                  <select name="admin_is">
                        <option value="" style="display:none">请选择</option>
                        <option value='112' 
                          <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '112')): ?>
                            selected
                            <?php endif; else: if((in_array('112',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >房管员</option>
                        <option value='116' 
                        <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '116')): ?>
                            selected
                            <?php endif; else: if((in_array('116',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >资料员</option>
                        <option value='111' 
                        <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '111')): ?>
                            selected
                            <?php endif; else: if((in_array('111',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >经管所长</option>
                        <option value='563' 
                        <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '563')): ?>
                            selected
                            <?php endif; else: if((in_array('563',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >经管科</option>
                        <option value='101' 
                        <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '101')): ?>
                            selected
                            <?php endif; else: if((in_array('101',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >经租会计</option>
                        <option value='1' 
                        <?php if((isset($leaseOption['admin_is']))): if(($leaseOption['admin_is'] === '1')): ?>
                            selected
                            <?php endif; else: if((in_array('1',json_decode(session('user_base_info.role'))))): ?>
                            selected 
                            <?php endif; endif; ?>
                        >全部</option>  
                  </select>
                </div>
              </td>
                
              <?php if(in_array(101,$useRoles)){ ;?>
              <td>
                <div class="am-form-group am-form search_input">
                  <select name="if_show">
                        <option value="" style="display:none">请选择</option>
                        <option value='1' <?php if((isset($leaseOption['if_show']) && ($leaseOption['if_show'] == 1))): ?>selected<?php endif; ?>>有</option>
                        <option value='2' <?php if((isset($leaseOption['if_show']) && ($leaseOption['if_show'] == 2))): ?>selected<?php endif; ?>>无</option>    
                    </select>
                </div>
              </td>
              <td>
                <div class="am-input-group am-input-group-sm" style="width:60px;"></div>
              </td>
              <?php }; ?>

              <td>
                <div class="am-btn-group am-btn-group-xs" style="width:136px;">
                  <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                  <a class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/LeaseAudit/index.html"><span class="ResetIcon"></span>重置</a>
                </div>
              </td>
            </tr>
        </form>
		<!---查询-->
          <?php foreach($leaseLst as $k => $v){

            if(in_array($v['ProcessRoleID'],$useRoles)){

              $IfProcess = '';
            }else{

              $IfProcess = 'not-process';
            }

          ?>
            <tr class="check001">
                <td>
                  <span class="piaochecked">
                    <input class="checkId radioclass" type="radio" value="" />
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
                <td ><a href="#"><?php echo $v['Status']; ?></a></td>
                <?php if(in_array(101,$useRoles)){ ;?>
                <td class="am-hide-sm-only"><?php echo $v['PrintTime']; ?></td>
                <td class="am-hide-sm-only"><?php echo $v['PrintTimes']; ?></td>
                <?php }; ?>
                <td>
                    <div class="am-btn-group am-btn-group-xs">
                        <?php if(in_array(563,$threeMenu)){ ; ?>
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only examine <?php echo $IfProcess; ?>" value="<?php echo $v['ChangeOrderID']; ?>">
                          审核
                        </button>
                        <?php }; if(in_array(559,$threeMenu) && ($IfProcess === '')){ ; ?>
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only print1" value="<?php echo $v['ChangeOrderID']; ?>">
                          租约打印
                        </button>
                        <?php }; if(in_array(561,$threeMenu) && ($IfProcess === '')){ ; ?>
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only uploadPic" value="<?php echo $v['ChangeOrderID']; ?>">
                          上传签字图片
                        </button>
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only butongguo <?php echo $IfProcess; ?>" value="<?php echo $v['ChangeOrderID']; ?>">
                          不通过
                        </button>
                        <?php }; if(in_array(562,$threeMenu)){ ; ?>
                        <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only detail_btn" value="<?php echo $v['ChangeOrderID']; ?>">
                          明细
                        </button>
                        <?php }; ?>
                    </div>
                </td>
            </tr>
          <?php }; ?>
  
          </tbody>
        </table>
		<div class="am-cf">
          
          <div class="am-fr">
          <?php echo $leaseLstObj->render(); ?>
          </div>
      </div>
      </div>
    </div>
  </div>


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
                    <td id="detailRoom14_data4"></td>

                    <td id="detailRoom16_data1"></td>
                    <td id="detailRoom16_data2"></td>
                    <td id="detailRoom16_data3"></td>
                    <td id="detailRoom16_data4"></td>
                    <td id="detailRoom16_data5"></td>
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
                    <td id="detailRoom17_data1"></td>
                    <td id="detailRoom17_data2"></td>
                    <td id="detailRoom17_data3"></td>
                    <td id="detailRoom17_data4"></td>
                    <td id="detailRoom17_data5"></td>
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
                            <td id="detailRoom18_data1"></td>
                            <td id="detailRoom18_data2"></td>
                            <td id="detailRoom18_data3"></td>
                            <td id="detailRoom18_data4"></td>
                            <td id="detailRoom18_data5"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="detailRoom19_data1"></td>
                            <td id="detailRoom19_data2"></td>
                            <td id="detailRoom19_data3"></td>
                            <td id="detailRoom19_data4"></td>
                            <td id="detailRoom19_data5"></td>
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

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">换租原因：</h2>
            <label class="am-u-sm-2" id="detailReason" style="font-weight:500;line-height:28px;"></label>
        </div>

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
  <style type="text/css">
    #leaseprint_1_{font-family:"SimSun"}
  .print_1_ table{border-spacing:0;border-top:1px solid #000;border-right:1px solid #000;}
  .print_1_ td,.print_1_ th{height:24px;border-left:1px solid #000;border-bottom:1px solid #000;font-size:13px;font-weight:400;padding:2px 1px;}
  #jbydtable td{padding:3px 2px;}
</style>
<div id="leaseprint_1_" class="print_1_" style="width:1080px;padding-left:50px;display:none;">
        <form id="Myprint_1_" width="1091px">
            <!--startprint2-->
            
            <!-- 基本信息 -->
            <div style="">
                <div style="margin-top:44px;margin-left:2%;float: left; width: 46%;height:611px;">
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

                <div style="float: left; width: 45%; margin-left: 4%;height:611px;">
                    <p class="topHeader" style="text-align: right;font-size:14px;margin:10px 0;">
                        租直NO:&nbsp;&nbsp;&nbsp;<span id="print_1_NO"></span>
                    </p>
                    <table id="table1" cellspacing="" cellpaddi ng="" style="height:611px;box-sizing:border-box">
                        <tbody><tr>
                            <td rowspan="2" style="width: 80px;">房屋坐落</td>
                            <td id="print_1_Address" rowspan="2" colspan="2" style="width: 130px;"></td>
                            <td rowspan="2" style="width: 50px;">结构</td>
                            <td id="print_1_Struct" rowspan="2" style="width: 80px;">
                                
                            </td>
                            <td style="width: 50px;">房屋层</td>
                            <td id="print_1_HouseFloor" style="width: 20px;">
                                
                            </td>
                        </tr>
                        <tr>
                            <td>居住层</td>
                            <td id="print_1_LiveFloor"></td>
                        </tr>
                        <tr>
                            <td style="height:48px;">承租人姓名</td>
                            <td id="print_1_RentName" style="width: 150px;height:48px;">

                            </td>
                            <td style="width: 80px;height:48px;">身份证号</td>
                            <td id="print_1_RentNumber" colspan="4" style="height:48px;">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2">承租人代表/监护人 姓名</td>
                            <td id="print_1_RentName1" rowspan="2"></td>
                            <td>身份证号</td>
                            <td id="print_1_RentNumber1" colspan="4"></td>
                        </tr>
                        <tr><td colspan="5">注：承租人代表/监护人无处置、转让、房改、征收等权利</td></tr>
                        <tr>
                            <td id="zztdheight" colspan="7" style="height: 498px; font-size: 18px;">
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
                                        <img id="print_1_imghid" src="/public/static/gf/img/zhang08.png" style="width: 130px; height: 130px; margin-top: -20px; margin-left: -50px; float: left;display:none;">
                                </div>
                                 
                                <img id="print_1_picCode" src="/" style="margin-left:25px;width:130px;height:130px;clear:both;float:left;display:none;">
                                <!-- divend2 -->
                                <div style="float: right; margin: -105px 35px 50px 50px;width:220px;">
                                    <span>承租人代表/监护人签章：</span>
                                    <div id="jhrdiv">
                                        <!-- divstart3 -->
                                            <div style="width:160px;height:60px;border:0px;" id="print_1_Represent"></div>
                                        <!-- divend3 -->
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="float: right; margin: -50px 40px 10px 50px;">
                                    租约签订日期&nbsp;&nbsp;<span id="print_1_Year"></span> 年<span id="print_1_Month"></span> 月<span id="print_1_Day"></span> 日
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>

            </div>
            
            <!--startprint1-->
            <div style="clear: both; padding-top: 75px;">
                <div style="float: left; width: 46%;margin-top:10px;margin-left:2%;">
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
                            <td id="print_1_Room1_data1">
                                
                            </td>
                            <td id="print_1_Room1_data2">
                                
                            </td>
                            <td id="print_1_Room1_data3">
                                
                            </td>
                            <td id="print_1_Room1_data4">
                                
                            </td>
                            <td rowspan="4" style="width: 75px;">三户以上共用</td>
                            <td style="width: 78px;">厅(堂)</td>
                            <td>0.50/个</td>
                            <td id="print_1_Room1_data5"></td>
                            <td id="print_1_Room1_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Room2_data1">
                                
                            </td>
                            <td id="print_1_Room2_data2">
                                
                            </td>
                            <td id="print_1_Room2_data3">
                                
                            </td>
                            <td id="print_1_Room2_data4">
                                
                            </td>
                            <td>厨房</td>
                            <td>0.50/个</td>
                            <td id="print_1_Room2_data5"></td>
                            <td id="print_1_Room2_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Room3_data1"></td>
                            <td id="print_1_Room3_data2"></td>
                            <td id="print_1_Room3_data3"></td>
                            <td id="print_1_Room3_data4"></td>
                            <td>卫生间</td>
                            <td>0.50/个</td>
                            <td id="print_1_Room3_data5">
                        
                            <td id="print_1_Room3_data6">
      
                            </td>
                        </tr>
                        <tr>
                            <td id="print_1_Room4_data1"></td>
                            <td id="print_1_Room4_data2"></td>
                            <td id="print_1_Room4_data3"></td>
                            <td id="print_1_Room4_data4"></td>
                            <td>室内走道</td>
                            <td>0.50/个</td>
                            <td id="print_1_Room4_data5">
               
                            <td id="print_1_Room4_data6">
                                
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="width: 75px;">厅堂</td>
                            <td>独</td>
                            <td id="print_1_Room5_data2">
                                
                            </td>
                            <td id="print_1_Room5_data3">
                                </td>
                            <td id="print_1_Room5_data4">
                                </td>
                            <td id="print_1_Room5_data5">
                                </td>
                            <td rowspan="2">高1至1.7米搁楼</td>
                            <td>5m²以下</td>
                            <td>0.50/个</td>
                            <td id="print_1_Room5_data6">
                                </td>
                            <td id="print_1_Room5_data7">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="print_1_Room6_data2">
                                </td>
                            <td id="print_1_Room6_data3">
                                </td>
                            <td id="print_1_Room6_data4">
                                </td>
                            <td id="print_1_Room6_data5">
                                </td>
                            <td>5m²以上</td>
                            <td>1.00/个</td>
                            <td id="print_1_Room6_data6">
                               </td>
                            <td id="print_1_Room6_data7">
                              </td>
                        </tr>
                        <tr>
                            <td rowspan="2">厨房</td>
                            <td>独</td>
                            <td id="print_1_Room7_data2">
                                </td>
                            <td id="print_1_Room7_data3">
                                </td>
                            <td id="print_1_Room7_data4">
                                </td>
                            <td id="print_1_Room7_data5">
                                </td>
                            <td colspan="2">二次供水<input type="hidden" name="ECGS_NAME" id="ECGS_NAME" value="二次供水" truetype="hidden"></td>
                            <td>0.08/m2<input type="hidden" name="ECGS_DW" id="ECGS_DW" value="0.08/m2" truetype="hidden"></td>
                            <td id="print_1_Room7_data8">
                                </td>
                            <td id="print_1_Room7_data9">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="print_1_Room8_data2">
                                </td>
                            <td id="print_1_Room8_data3">
                                </td>
                            <td id="print_1_Room8_data4">
                                </td>
                            <td id="print_1_Room8_data5">
                                </td>
                            <td id="print_1_Room8_data6" colspan="2"><input type="hidden" name="MP_NAME" id="MP_NAME" value="" truetype="hidden"></td>
                            <td id="print_1_Room8_data7"></td>
                            <td id="print_1_Room8_data8">
                                </td>
                            <td id="print_1_Room8_data9">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2">卫生间</td>
                            <td>独</td>
                            <td id="print_1_Room9_data2">
                                </td>
                            <td id="print_1_Room9_data3">
                                </td>
                            <td id="print_1_Room9_data4">
                                </td>
                            <td id="print_1_Room9_data5">
                                </td>
                            <td colspan="2"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="print_1_Room10_data2">
                                </td>
                            <td id="print_1_Room10_data3">
                                </td>
                            <td id="print_1_Room10_data4">
                                </td>
                            <td id="print_1_Room10_data5">
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
                            <td id="print_1_Room11_data2">
                                </td>
                            <td id="print_1_Room11_data3">
                                </td>
                            <td id="print_1_Room11_data4">
                                </td>
                            <td id="print_1_Room11_data5">
                                </td>
                            <td rowspan="3">无封闭阳台</td>
                           <td id="print_1_Room13_data5">
                        47-1</td>
                            <td id="print_1_Room13_data6">
                                </td>
                            <td id="print_1_Room13_data7">
                                </td>
                            <td id="print_1_Room13_data8">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="print_1_Room12_data2">
                               </td>
                            <td id="print_1_Room12_data3">
                                </td>
                            <td id="print_1_Room12_data4">
                                </td>
                            <td id="print_1_Room12_data5">
                                <input type="hidden" name="DOW_YZJ2" id="DOW_YZJ2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="55"></td>
                            <td id="print_1_Room14_data5">
                        <input class="jianhao" type="hidden" name="WFBYT_JHO2" id="WFBYT_JHO2" value="" truetype="hidden"></td>
                    <td id="print_1_Room14_data6">
                        <input type="hidden" name="WFBYT_SM2" id="WFBYT_SM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="56"></td>
                    <td id="print_1_Room14_data7">
                        <input type="hidden" name="WFBYT_JM2" id="WFBYT_JM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="57"></td>
                    <td id="print_1_Room14_data8">
                        <input type="hidden" name="WFBYT_YZJ2" id="WFBYT_YZJ2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="58"></td>
                            
                        </tr>
                        
                       <tr>
                    <td colspan="2" rowspan="3">封闭阳台</td>
                    <td id="print_1_Room13_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO1" id="FBYT_JHO1" value="" truetype="hidden"></td>
                    <td id="print_1_Room13_data2">
                        <input type="hidden" name="FBYT_SM1" id="FBYT_SM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="59"></td>
                    <td id="print_1_Room13_data3">
                        <input type="hidden" name="FBYT_JM1" id="FBYT_JM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="60"></td>
                    <td id="print_1_Room13_data4">
                        <input type="hidden" name="FBYT_YZJ1" id="FBYT_YZJ1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="61"></td>
                    <td id="print_1_Room15_data5">
                        <input class="jianhao" type="hidden" name="WFBYT_JHO3" id="WFBYT_JHO3" value="" truetype="hidden"></td>
                    <td id="print_1_Room15_data6">
                        <input type="hidden" name="WFBYT_SM3" id="WFBYT_SM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="62"></td>
                    <td id="print_1_Room15_data7">
                        <input type="hidden" name="WFBYT_JM3" id="WFBYT_JM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="63"></td>
                    <td id="print_1_Room15_data8">
                        <input type="hidden" name="WFBYT_YZJ3" id="WFBYT_YZJ3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="64"></td>
                </tr>

               <tr>
                     <td id="print_1_Room14_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO2" id="FBYT_JHO2" value="" truetype="hidden"></td>
                    <td id="print_1_Room14_data2">
                        <input type="hidden" name="FBYT_SM2" id="FBYT_SM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="65"></td>
                    <td id="print_1_Room14_data3">
                        <input type="hidden" name="FBYT_JM2" id="FBYT_JM2" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="66"></td>
                    <td id="print_1_Room14_data4"></td>

                    <td id="print_1_Room16_data1"></td>
                    <td id="print_1_Room16_data2"></td>
                    <td id="print_1_Room16_data3"></td>
                    <td id="print_1_Room16_data4"></td>
                    <td id="print_1_Room16_data5"></td>
                </tr>
                <tr>
                     <td id="print_1_Room15_data1">
                        <input class="jianhao" type="hidden" name="FBYT_JHO3" id="FBYT_JHO3" value="" truetype="hidden"></td>
                    <td id="print_1_Room15_data2">
                        <input type="hidden" name="FBYT_SM3" id="FBYT_SM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="68"></td>
                    <td id="print_1_Room15_data3">
                        <input type="hidden" name="FBYT_JM3" id="FBYT_JM3" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="69"></td>
                    <td id="print_1_Room15_data4"></td>

                    <td id="print_1_Room17_data1"></td>
                    <td id="print_1_Room17_data2"></td>
                    <td id="print_1_Room17_data3"></td>
                    <td id="print_1_Room17_data4"></td>
                    <td id="print_1_Room17_data5"></td>
                </tr>
                        <tr>
                            <td colspan="2">高1.7至2.2米搁楼</td>
                            <td id="print_1_Room12_data6">
                        <input class="jianhao" type="hidden" name="GL_JHO1" id="GL_JHO1" value="" truetype="hidden"></td>
                            <td id="print_1_Room12_data7">
                                <input type="hidden" name="GL_SM1" id="GL_SM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="71"></td>
                            <td id="print_1_Room12_data8">
                                <input type="hidden" name="GL_JM1" id="GL_JM1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="72"></td>
                            <td id="print_1_Room12_data9">
                                <input type="hidden" name="GL_YZJ1" id="GL_YZJ1" value="" class="validate[custom[onlyNumberWide]]" inputmode="positiveDecimal" onblur="gethj1()" truetype="hidden" yzid="73"></td>

                            <td id="print_1_Room18_data1"></td>
                            <td id="print_1_Room18_data2"></td>
                            <td id="print_1_Room18_data3"></td>
                            <td id="print_1_Room18_data4"></td>
                            <td id="print_1_Room18_data5"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="print_1_Room19_data1"></td>
                            <td id="print_1_Room19_data2"></td>
                            <td id="print_1_Room19_data3"></td>
                            <td id="print_1_Room19_data4"></td>
                            <td id="print_1_Room19_data5"></td>
                            <td colspan="2">合计</td>
                            <td id="print_1_Room16_data6">
                                <input type="hidden" name="" value="" truetype="hidden"></td>
                            <td id="print_1_Room16_data7">
                                
                            </td>
                            <td id="print_1_Room16_data8"></td>
                        </tr>
                        <tr>
                            <td colspan="2">合计</td>
                            <td id="print_1_Room20_data1">
                                <input class="jianhao" type="hidden" name="" value="" truetype="hidden"></td>
                            <td id="print_1_Room20_data2"></td>
                            <td id="print_1_Room20_data3"></td>
                            <td id="print_1_Room20_data4"></td>
                            <td colspan="2">核定月租金</td>
                            <td id="print_1_Room20_data5" colspan="3">
                                </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: center">资料员：<span id="print_1_Room21_data1"></span>
                                &nbsp;  &nbsp;  &nbsp;
                        经管所长：<span id="print_1_Room21_data2"></span>
                                &nbsp;  &nbsp;  &nbsp;经管科长：<span id="print_1_Room21_data3"></span>
                            </td>
                        </tr>
                    </tbody></table>
                </div>

                <div style="float: left; width: 45%; margin-left: 4%;margin-top:10px;">
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
                            <td id="print_1_Dev1_data1"></td>
                            <td id="print_1_Dev1_data2"></td>
                            <td id="print_1_Dev1_data3"></td>
                            <td></td>
                            <td id="print_1_Dev1_data4"></td>
                            <td id="print_1_Dev1_data5"></td>
                            <td id="print_1_Dev1_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Dev2_data1"></td>
                            <td id="print_1_Dev2_data2"></td>
                            <td id="print_1_Dev2_data3"></td>
                            <td></td>
                            <td id="print_1_Dev2_data4"></td>
                            <td id="print_1_Dev2_data5"></td>
                            <td id="print_1_Dev2_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Dev3_data1"></td>
                            <td id="print_1_Dev3_data2"></td>
                            <td id="print_1_Dev3_data3"></td>
                            <td></td>
                            <td id="print_1_Dev3_data4"></td>
                            <td id="print_1_Dev3_data5"></td>
                            <td id="print_1_Dev3_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Dev4_data1"></td>
                            <td id="print_1_Dev4_data2"></td>
                            <td id="print_1_Dev4_data3"></td>
                            <td></td>
                            <td id="print_1_Dev4_data4"></td>
                            <td id="print_1_Dev4_data5"></td>
                            <td id="print_1_Dev4_data6"></td>
                        </tr>
                        <tr>
                            <td id="print_1_Dev5_data1"></td>
                            <td id="print_1_Dev5_data2"></td>
                            <td id="print_1_Dev5_data3"></td>
                            <td></td>
                            <td id="print_1_Dev5_data4"></td>
                            <td id="print_1_Dev5_data5"></td>
                            <td id="print_1_Dev5_data6"></td>
                        </tr>
                        <tr>
                            <td id="fjtdheight" colspan="7" style="vertical-align: top; box-sizing: border-box;">
                                <p style="margin: 60px 0 30px 0; text-align: center;"><span style="font-size: 20px; width: 50px; border-bottom: 3px double #333333;">附记</span></p>
                                <div id="print_1_Text_other" style="height:338px;width:100%;border: none;" readonly="readonly"></div>
                                
                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <!--endprint1-->
            </div>
            <!--endprint2-->
        </form>
</div>
  <style type="text/css">
    #print2{font-family:"SimSun"}
    .outerControl table{border-spacing:0;border-top:1px solid #000;border-right:1px solid #000;}
    .outerControl td,.outerControl th{height:24px;border-left:1px solid #000;border-bottom:1px solid #000;font-size:12px;}
</style>
<!--startprint-->
<div class="outerControl" id="print2" style="width:661px;margin-left:20px;display:none;">
        <form id="MyForm">
            <!--startprint2-->
            <!--startprint1-->
            <!-- 基本信息 -->
            <div style="margin-top:10px;">
                <div style="width: 100%; ">
                    <div>
                        <img id="picCode_2" src="" style="margin-left:25px;width:90px;height:90px;clear:both;text-align:left;">
                        <p style="text-align:center;margin-top:-60px;font-size:18px;">武汉市公有房屋住宅租约信息单</p>
                        <p style="text-align:right;margin-right:20px;">
                            租直NO:&nbsp;&nbsp;&nbsp;<span id="printer_2_NO"></span>
                        </p>
                    </div>
                    <table id="table1" border="1" cellspacing="" cellpadding="" style="box-sizing:border-box;width:100%;margin-top:-10px;">
                        <tbody><tr>
                            <td rowspan="2" style="">房屋坐落</td>
                            <td id="printer_2_Address" rowspan="2" colspan="2" style="width: 130px;">
                                栅栏口16号</td>
                            <td rowspan="2" style="">结构</td>
                            <td id="printer_2_Struct" rowspan="2" style="">
                                钢混
                            </td>
                            <td style="">房屋层</td>
                            <td id="printer_2_HouseFloor" style="">
                                </td>
                        </tr>
                        <tr>
                            <td>居住层</td>
                            <td id="printer_2_LiveFloor">
                                </td>
                        </tr>
                        <tr>
                            <td style="">承租人姓名</td>
                            <td id="printer_2_RentName" style="">
                                </td>
                            <td style="">身份证号</td>
                            <td id="printer_2_RentNumber" colspan="4" style="">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2">承租人代表/监护人 姓名</td>
                            <td id="printer_2_RentName1" rowspan="2"></td>
                            <td>身份证号</td>
                            <td id="printer_2_RentNumber1" colspan="4"></td>
                        </tr>
                        <tr><td colspan="5">注：承租人代表/监护人无处置、转让、房改、征收等权利</td></tr>
                        <tr>
                            <td colspan="7" style=" font-size: 18px;">
                                <div style=" width: 100%; margin-top:20px;">
                    <!-- 评 租 情 况 记 载 -->
                    <p class="titleStyle" style="text-align:center;">评 租 情 况 记 载</p>
                    <table class="pzqk" cellspacing="" cellpadding="" style="width:100%;margin-top: 5px;height:538px;border-left-width:0px;border-right-width:0px;border-bottom-width:0px;">
                        <tbody><tr>
                            <th colspan="2" style="width: 85px;border-left:0px;">部位</th>
                            <th style="width: 40px;">间号</th>
                            <th style="width: 55px;">实有面积(m²)</th>
                            <th style="width: 55px;">计租面积(m²)</th>
                            <th style="width: 40px;">租金(元)</th>
                            <th colspan="2">项目</th>
                            <th>单价(元)</th>
                            <th style="width: 70px;">数量(m²)(件、个)</th>
                            <th style="width: 40px;border-right-width:0px;">租金(元)</th>
                        </tr>
                        <tr>
                            <td rowspan="4" colspan="2" style="border-left-width:0px;">卧室</td>
                            <td id="printer_2_Room1_data1">
                            
                                </td>
                            <td id="printer_2_Room1_data2">
                                
                                </td>
                            <td id="printer_2_Room1_data3">
                               </td>
                            <td id="printer_2_Room1_data4">
                               </td>
                            <td rowspan="4" style="width: 75px;">三户以上共用</td>
                            <td style="width: 78px;">厅(堂)</td>
                            <td>0.50/个</td>
                            <td id="printer_2_Room1_data5">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room1_data6">
                               </td>
                        </tr>
                        <tr>
                            <td id="printer_2_Room2_data1">
                                
                               </td>
                            <td id="printer_2_Room2_data2">
                                </td>
                            <td id="printer_2_Room2_data3">
                                </td>
                            <td id="printer_2_Room2_data4">
                               </td>
                            <td>厨房</td>
                            <td>0.50/个</td>
                            <td id="printer_2_Room2_data5">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room2_data6">
                                </td>
                        </tr>
                        <tr>
                            <td id="printer_2_Room3_data1">
                               </td>
                            <td id="printer_2_Room3_data2">
                                </td>
                            <td id="printer_2_Room3_data3">
                                </td>
                            <td id="printer_2_Room3_data4">
                                </td>
                            <td>卫生间</td>
                            <td>0.50/个</td>
                            <td id="printer_2_Room3_data5">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room3_data6">
                                </td>
                        </tr>
                        <tr>
                            <td id="printer_2_Room4_data1">
                                </td>
                            <td id="printer_2_Room4_data2">
                                </td>
                            <td id="printer_2_Room4_data3">
                                </td>
                            <td id="printer_2_Room4_data4">
                                </td>
                            <td>室内走道</td>
                            <td>0.50/个</td>
                            <td id="printer_2_Room4_data5">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room4_data6">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="width: 80px;border-left-width:0px;">厅堂</td>
                            <td>独</td>
                            <td id="printer_2_Room5_data2">
                                </td>
                            <td id="printer_2_Room5_data3">
                                </td>
                            <td id="printer_2_Room5_data4">
                                </td>
                            <td id="printer_2_Room5_data5">
                                </td>
                            <td rowspan="2">高1至1.7米搁楼</td>
                            <td>5m²以下</td>
                            <td>0.50/个</td>
                            <td id="printer_2_Room5_data6">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room5_data7">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="printer_2_Room6_data2">
                               </td>
                            <td id="printer_2_Room6_data3">
                                </td>
                            <td id="printer_2_Room6_data4">
                                </td>
                            <td id="printer_2_Room6_data5">
                                </td>
                            <td>5m²以上</td>
                            <td>1.00/个</td>
                            <td id="printer_2_Room6_data6">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room6_data7">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="border-left-width:0px;">厨房</td>
                            <td>独</td>
                            <td id="printer_2_Room7_data2">
                                </td>
                            <td id="printer_2_Room7_data3">
                                </td>
                            <td id="printer_2_Room7_data4">
                                </td>
                            <td id="printer_2_Room7_data5">
                                </td>
                            <td colspan="2">二次供水</td>
                            <td>0.08/m²</td>
                            <td id="printer_2_Room7_data8">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room7_data9">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="printer_2_Room8_data2">
                                </td>
                            <td id="printer_2_Room8_data3">
                                </td>
                            <td id="printer_2_Room8_data4">
                                </td>
                            <td id="printer_2_Room8_data5">
                                </td>
                           <td colspan="2"></td>
                            <td></td>
                            <td id="printer_2_Room8_data6">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room8_data7">
                                </td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="border-left-width:0px;">卫生间</td>
                            <td>独</td>
                            <td id="printer_2_Room9_data2">
                                </td>
                            <td id="printer_2_Room9_data3">
                                </td>
                            <td id="printer_2_Room9_data4">
                                </td>
                            <td id="printer_2_Room9_data5">
                                </td>
                            <td colspan="2">高1.7至2.2米搁楼</td>
                            <td id="printer_2_Room12_data7">
                            </td>
                            <td id="printer_2_Room12_data8">
                                </td>
                            <td style="border-right-width:0px;" id="printer_2_Room12_data9">
                                </td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="printer_2_Room10_data2">
                                </td>
                            <td id="printer_2_Room10_data3">
                                </td>
                            <td id="printer_2_Room10_data4">
                                </td>
                            <td id="printer_2_Room10_data5"></td>
                            <td colspan="2" id="printer_2_Room16_data1"></td>
                            <td id="printer_2_Room16_data3"></td>
                            <td id="printer_2_Room16_data4"></td>
                            <td style="border-right-width:0px;" id="printer_2_Room16_data5"></td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="border-left-width:0px;">室内走道</td>
                            <td>独</td>
                            <td id="printer_2_Room11_data2">
                                </td>
                            <td id="printer_2_Room11_data3">
                                </td>
                            <td id="printer_2_Room11_data4">
                                </td>
                            <td id="printer_2_Room11_data5">
                                </td>
                            <td colspan="2" id="printer_2_Room17_data1"></td>
                            <td id="printer_2_Room17_data3"></td>
                            <td id="printer_2_Room17_data4"></td>
                            <td style="border-right-width:0px;" id="printer_2_Room17_data5"></td>
                        </tr>
                        <tr>
                            <td>共</td>
                            <td id="printer_2_Room12_data2">
                                </td>
                            <td id="printer_2_Room12_data3">
                                </td>
                            <td id="printer_2_Room12_data4">
                                </td>
                            <td id="printer_2_Room12_data5">
                                </td>
                            <td colspan="2" id="printer_2_Room18_data1"></td>
                            <td id="printer_2_Room18_data3"></td>
                            <td id="printer_2_Room18_data4"></td>
                            <td style="border-right-width:0px;" id="printer_2_Room18_data5"></td>
                        </tr>
                       <tr>
                    <td colspan="2" rowspan="3" style="border-left-width:0px;">封闭阳台</td>
                    <td id="printer_2_Room13_data1">
                        </td>
                    <td id="printer_2_Room13_data2">
                        </td>
                    <td id="printer_2_Room13_data3">
                        </td>
                    <td id="printer_2_Room13_data4">
                        </td>
                    <td colspan="2" rowspan="3">无封闭阳台</td>
                    <td id="printer_2_Room13_data6">
                        </td>
                    <td id="printer_2_Room13_data7">
                        </td>
                    <td style="border-right-width:0px;" id="printer_2_Room13_data8">
                        </td>
                </tr>

               <tr>
                     <td id="printer_2_Room14_data1">
                        </td>
                    <td id="printer_2_Room14_data2">
                        </td>
                    <td id="printer_2_Room14_data3">
                        </td>
                    <td id="printer_2_Room14_data4">
                        </td>
                     <td id="printer_2_Room14_data6">
                        </td>
                    <td id="printer_2_Room14_data7">
                        </td>
                    <td style="border-right-width:0px;" id="printer_2_Room14_data8">
                        </td>
                </tr>
                <tr>
                     <td id="printer_2_Room15_data1">
                        </td>
                    <td id="printer_2_Room15_data2">
                        </td>
                    <td id="printer_2_Room15_data3">
                        </td>
                    <td id="printer_2_Room15_data4">
                        </td>
                     <td id="printer_2_Room15_data6">
                        </td>
                    <td id="printer_2_Room15_data7">
                        </td>
                    <td style="border-right-width:0px;" id="printer_2_Room15_data8">
                        </td>
                </tr>
                        <tr>
                            <td colspan="2" style="border-left-width:0px;" id="printer_2_Room19_data1"></td>
                            <td id="printer_2_Room19_data2"></td>
                            <td id="printer_2_Room19_data3"></td>
                            <td id="printer_2_Room19_data4"></td>
                            <td id="printer_2_Room19_data5"></td>
                            <td colspan="2">合计</td>
                            <td>
                                </td>
                            <td>
                                
                            </td>
                            <td id="printer_2_Room16_data8" style="border-right-width:0px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-left-width:0px;">合计</td>
                            <td id="printer_2_Room20_data1">
                               </td>
                            <td id="printer_2_Room20_data2"></td>
                            <td id="printer_2_Room20_data3"></td>
                            <td id="printer_2_Room20_data4"></td>
                            <td colspan="2">核定月租金</td>
                            <td colspan="3" style="border-right-width:0px;" id="printer_2_Room20_data5">
                                </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: center;border-left-width:0px;border-bottom-width:0px;border-right-width:0px;">资料员：<span id="printer_2_Room21_data1"></span>
                                &nbsp;  &nbsp;  &nbsp;
                                    经管所长：<span id="printer_2_Room21_data2"></span>
                                &nbsp;  &nbsp;  &nbsp;经管科长：<span id="printer_2_Room21_data3"></span>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="7" style=" font-size: 18px;">
                                        <div style="float:left;margin-left: 5px; margin-top: 40px;">
                                    <span>承租人：（乙方）</span>
                                    <input type="hidden" truetype="hidden">
                                </div>
                                <div style=" float:left;margin-top: 10px;margin-left:10px;">
                                    <div style="width:160px;height:60px;"></div>
                                </div>
                                <div style="float: left; margin-top:40px;margin-left:20px;">
                                    租约签订日期&nbsp;&nbsp;<span id="printer_2_Year">2018</span> 年<span id="printer_2_Month">05</span> 月<span id="printer_2_Day">31</span> 日
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>

            </div>
            <!--endprint2-->
        </form>
</div>
<!--endprint-->
  <div id="uploadPicDiv" style="display:none;">
      <div class="am-u-md-12 fileUpLoad">
          <div class="am-u-md-5">
              <p>租约签字图片：</p>
          </div>
          <div class="am-form-group am-form-file am-u-md-7">
              <i class="am-icon-cloud-upload"></i> 选择要上传的文件
              <input id="uploadPic" type="file" name="uploadPic" multiple>
          </div>
          <div id="uploadPicShow" class="am-u-md-12"></div>
      </div>
  </div>


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

<script type="text/javascript" src="/public/static/gf/js/viewer.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/lease_audit.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/js/DFileUpload.js?v=<?php echo $version; ?>"></script>

</body>
</html>