<?php if (!defined('THINK_PATH')) exit(); /*a:22:{s:73:"/usr/share/nginx/publichouse/application/ph/view/change_record/index.html";i:1572706546;s:60:"/usr/share/nginx/publichouse/application/ph/view/layout.html";i:1573559825;s:44:"application/ph/view/change_audit/derate.html";i:1566211566;s:47:"application/ph/view/change_audit/emptyRent.html";i:1566211566;s:43:"application/ph/view/change_audit/pause.html";i:1566211566;s:44:"application/ph/view/change_audit/cancel.html";i:1566211566;s:47:"application/ph/view/change_audit/oldCancel.html";i:1566211566;s:52:"application/ph/view/change_audit/rentAdjustment.html";i:1566211566;s:45:"application/ph/view/change_audit/rentAdd.html";i:1566211566;s:49:"application/ph/view/change_audit/approveForm.html";i:1566211566;s:56:"application/ph/view/change_audit/buildingAdjustment.html";i:1566211566;s:48:"application/ph/view/change_audit/RoomDetail.html";i:1528342025;s:49:"application/ph/view/change_audit/houseAdjust.html";i:1566211566;s:45:"application/ph/view/change_audit/newRent.html";i:1561375216;s:49:"application/ph/view/change_audit/batchAdjust.html";i:1566211566;s:52:"application/ph/view/change_audit/buildingcancel.html";i:1572706546;s:48:"application/ph/view/change_audit/rentcancel.html";i:1572706546;s:40:"application/ph/view/ban_info/detail.html";i:1533511343;s:44:"application/ph/view/house_info/RentForm.html";i:1566211566;s:43:"application/ph/view/notice/notice_info.html";i:1528342025;s:42:"application/ph/view/index/second_menu.html";i:1531059200;s:38:"application/ph/view/index/version.html";i:1578586810;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>异动记录</title>
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
  
<link rel="stylesheet" href="/public/static/gf/css/iconfont.css">
<link rel="stylesheet" href="/public/static/gf/css/viewer.min.css">
<link rel="stylesheet" href="/public/static/gf/css/fileUpload.css">
<!-- content start -->
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><small class="am-text-sm">异动管理</small> /
            <small class="am-text-primary">异动记录</small>
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
                    <!--<th class="table-title">楼栋编号</th>-->
                    <!--<th class="table-type">房屋编号</th>-->
                    <th class="table-author am-hide-sm-only">变更类型</th>
                    <?php if(session('user_base_info.institution_level')!=3){ ;?>
                        <th class="table-date am-hide-sm-only">申请机构</th>
                    <?php }; ?>
                    <th class="table-set">产别</th>
        
                    <th class="table-set">金额</th>
                    <th class="table-set">申请人</th>
                    <th class="table-set">申请时间</th>
                    <th class="table-set">完成时间</th>
                    <th class="table-set">审核状态</th>
                    <th class="table-set">备注</th>
                    <th class="table-set" style="width:114px;">操作</th>
                </tr>
                </thead>
                <tbody>
                <!--查询-->
                <form action="<?php echo url('ChangeRecord/index'); ?>" method="post" id="queryForm">
                    <tr class="am-form-group am-form-inline">
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
                                <input style="width:200px;" type="text" class="am-form-field" name="ChangeOrderID" value="<?php echo $ChangeOrderID; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="am-input-group am-form" style="width:80px;">
                                <select name="ChangeType">
                                    <option value="" style="display:none">请选择</option>

                                    <?php foreach($changes as $k0 => $v0){ ; 

                                        if(isset($changeOption['ChangeType'])){

                                            if($changeOption['ChangeType'] == $v0['id']){

                                                $select ='selected';
                                            }else{

                                                $select ='';
                                            }
                                        }else{

                                            $select ='';
                                        }

                                    ?>

                                    <option value="<?php echo $v0['id']; ?>"
                                            <?php echo $select; ?>><?php echo $v0['ProcessName']; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </td>
                        <?php if(session('user_base_info.institution_level')!=3){ ;?>
                        <td>
                            <div class="am-form-group am-form" style="width:100px;">

                                <select name="TubulationID">
                                    <option value="" style="display:none">请选择</option>
                                    <?php if(session('user_base_info.institution_level')==1){;foreach($instLst as $k10 => $v10){ if($v10['level'] !=0 ){; 
                                if(isset($changeOption['TubulationID'])){
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
                                if(isset($changeOption['TubulationID'])){
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
                                    <?php }} ; ?>
                                </select>
                            </div>
                        </td>
                        <?php }; ?>
                        <td>
                  <div class="am-form-group am-form" style="width:70px;">
                      <select name="OwnerType">
                          <option  value="" style="display:none">请选择</option>
                          <?php foreach($owerLst as $k3 =>$v3){;

                                if(isset($changeOption['OwnerType'])){

                                    if($changeOption['OwnerType'] == $v3['id']){

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
                        <?php
                        if(isset($changeOption['InflRent'])){
                            $InflRent = $changeOption['InflRent'];
                        }else{
                            $InflRent = '';
                        }
                     ?>
                <input type="text" class="am-form-field" name="InflRent" value="<?php echo $InflRent; ?>"><?php echo $InflRentSum; ?>
              </div>
              </td>
                        <td>
                            <div class="am-input-group am-input-group-sm">
                                <?php
                                    if(isset($changeOption['UserName'])){
                                        $UserName = $changeOption['UserName'];
                                    }else{
                                        $UserName = '';
                                    }
                                 ?>
                                <input type="text" class="am-form-field" name="UserName" value="<?php echo $UserName; ?>">
                            </div>
                        </td>
                        <td>
                        <div class="am-input-group am-input-group-sm" style="width:140px;">
                                <?php
                        if(isset($changeOption['CreateTime'])){
                            $CreateTime = $changeOption['CreateTime'];  
                        }else{
                            $CreateTime = '';
                        }
                     ?>
                    <div class="am-u-sm-6" >
                          <input style="width:140px;" name="CreateTime" value="<?php echo $CreateTime; ?>" type="text" class="am-form-field" data-am-datepicker="{format: 'yyyy-mm',viewMode: 'months', minViewMode: 'months'}" value="">
                    </div>
                    
                        </div>
                    </td>
                    <td>
                        <div class="am-input-group am-input-group-sm" style="width:140px;">
                                <?php
                        if(isset($changeOption['FinishTime'])){
                            $FinishTime = $changeOption['FinishTime'];  
                        }else{
                            $FinishTime = '';
                        }
                     ?>
                    <div class="am-u-sm-6" >
                          <input style="width:140px;" name="FinishTime" value="<?php echo $FinishTime; ?>" type="text" class="am-form-field" data-am-datepicker="{format: 'yyyy-mm',viewMode: 'months', minViewMode: 'months'}" value="">
                    </div>
                    
                        </div>
                    </td>
                        <td><div class="am-form-group  am-form search_input">
                     
                    <select name="Status">
                        <option value="" style="display:none">请选择</option>
                        <option value="1" <?php if((isset($changeOption['Status']) && $changeOption['Status'] ==='1')): ?>selected<?php endif; ?>>成功</option>
                        <option value="0" <?php if((isset($changeOption['Status']) && $changeOption['Status'] === '0')): ?>selected<?php endif; ?>>失败</option>
                    </select>
                  </div></td>
                         <td><div style="width:200px;"></div></td>
                        <td>
                            <div class="am-btn-group am-btn-group-xs" style="width:114px;">
                              <button type="submit" class="am-btn am-btn-xs am-text-primary" id="queryBtn"><span class="DqueryIcon"></span>查询</button>
                              <a id="clearBanInfo" class="am-btn am-btn-xs am-text-primary ABtn" href="/ph/ChangeRecord/index.html"><span class="ResetIcon"></span>重置</a>
                            </div>
                        </td>
                    </tr>
                </form>
                <!---查询-->
                <?php foreach($changeLst as $k => $v){ ; ?>
                <tr class="check001">
                    <td>
                        <span class="piaochecked">
                            <input name="ID" class="checkId radioclass" type="radio" value="<?php echo $v['ChangeOrderID']; ?>"/>
                        </span>
                    </td>
                    <td><?php echo ++$k; ?></td>
                    <td><?php echo $v['ChangeOrderID']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['ChangeType']; ?></td>
                    <?php if(session('user_base_info.institution_level')!=3){ ;?>
                      <td class="am-hide-sm-only"><?php echo $v['InstitutionID']; ?></td>
                      <?php }; ?>
                      <td class="am-hide-sm-only"><?php echo $v['OwnerType']; ?></td>
                      
                      <td class="am-hide-sm-only"><?php echo $v['InflRent']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['UserNumber']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['CreateTime']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['FinishTime']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['Status']; ?></td>
                    <td class="am-hide-sm-only"><?php echo $v['Remark']; ?></td>
                    <td>
                        <div class="am-btn-group am-btn-group-xs">
                            <?php if(in_array(368,$threeMenu)){ ; ?>
                            <!--                       <button class="am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only BtnApprove" value="1">审批</button> -->
                            <button class="am-btn am-btn-default am-text-primary am-btn-xs details am-hide-sm-only BtnDetail" value="<?php echo $v['ChangeOrderID']; ?>">明细
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
<!-- 租金减免明细-->
<div id="derate" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content derateHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4" style="padding-right: 0">
          <label class="label_style">楼栋编号：</label>
          <label class="label_content derateBanID"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">楼栋地址：</label>
          <label class="label_content derateAddress" style="width:476px;"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style"> 产别：</label>
          <label class="label_content derateOwnertype"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content derateUseNature"></label>
        </div>
        <div class="am-u-sm-4 rent_reduction">
          <label class="label_style">计租表：</label>
          <a class="am-btn am-btn-primary am-btn-sm" id="rentMeterButton" style="font-size: 0.4rem;padding: 5px;border-radius: 4px;">查询</a>
        </div>
        <div class="am-u-sm-4 cancel">
          <label class="label_style">注销类别：</label>
          <label class="label_content cancelType"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content detateHouseUsearea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content derateLeasedArea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content derateHousePrerent"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">承租人：</label>
          <label class="label_content derateTenantName"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">身份证号：</label>
          <label class="label_content derateTenantNumber"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">联系电话：</label>
          <label class="label_content derateTenantTel"></label>
        </div>
    </div>

    <div class="am-form-group am-u-sm-12 rent_reduction">
      <h2 class="label_title">填报信息：</h2>
    </div>
    <div class="am-u-sm-12 rent_reduction">
        <div class="am-u-md-4">
          <label class="label_style">减免金额：</label>
          <label class="label_content derateMoney"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">减免类型：</label>
          <label class="label_content derateType"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">证件号：</label>
          <label class="label_content derateNumber"></label>
        </div>
    </div>
    <div class="am-u-sm-12 rent_reduction">
        <div class="am-u-sm-4 am-u-end">
          <label class="label_style">有效期：</label>
          <label class="label_content derateTime"></label>
        </div>
    </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="deratePhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <div class="am-form-group am-u-sm-3">
              <label>审通知书：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="noticeBook" type="file" name="noticeBook" multiple>
            </div>
            <div id="noticeBookShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="derateState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 空租-->
<div id="emptyRent" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content emptyRentHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4" style="padding-right: 0">
          <label class="label_style">楼栋编号：</label>
          <label class="label_content emptyRentBanID"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">楼栋地址：</label>
          <label class="label_content emptyRentAddress" style="width:476px;"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style"> 产别：</label>
          <label class="label_content emptyRentOwnertype"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content emptyRentLeasedArea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content emptyRentHouseUsearea"></label>
        </div>

    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content emptyRentUseNature"></label>
        </div>
        
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content emptyRentHousePrerent"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">备案时间：</label>
          <label class="label_content emptyRentCreateTime"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-12">
          <label class="label_style">异动事由：</label>
          <label class="label_content emptyRentReason"></label>
        </div>
    </div>

    <div class="am-form-group am-u-sm-12 empty_rent_cancel">
      <h2 class="label_title">租户信息：</h2>
    </div>
    <div class="am-u-sm-12 empty_rent_cancel">
        <div class="am-u-sm-4">
          <label class="label_style">租户ID：</label>
          <label class="label_content emptyRentTenantID"></label>
        </div>
    </div>
    <div class="am-u-sm-12 empty_rent_cancel">
        <div class="am-u-sm-4">
          <label class="label_style">租户姓名：</label>
          <label class="label_content emptyRentTenantName"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">身份证号：</label>
          <label class="label_content emptyRentTenantNumber"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">联系电话：</label>
          <label class="label_content emptyRentTenantTel"></label>
        </div>
    </div>



    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <h2 class="label_title">上传附近：</h2>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>空租情况说明报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="descriptionReport" type="file" name="descriptionReport" multiple>
            </div>
            <div id="descriptionReportShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>个人退房申请：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="personalCheckApplication" type="file" name="personalCheckApplication" multiple>
            </div>
            <div id="personalCheckApplicationShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>单位退房申请：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="unitCheckApplication" type="file" name="unitCheckApplication" multiple>
            </div>
            <div id="unitCheckApplicationShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>租户租约：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="tenantLease" type="file" name="tenantLease" multiple>
            </div>
            <div id="tenantLeaseShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>租户身份证：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="tenantIDFile" type="file" name="tenantIDFile" multiple>
            </div>
            <div id="tenantIDFileShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>其他：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="emptyRentOther" type="file" name="emptyRentOther" multiple>
            </div>
            <div id="emptyRentOtherShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-u-sm-12"><hr /></div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="emptyRentPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="emptyRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 暂停计租明细 -->
<div id="pause" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-md-4">
      <label id="houseLabel" class="label_style">楼栋编号：</label>
      <label class="label_content pauseBanId"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">楼栋地址：</label>
      <label class="label_content pauseAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼栋产别：</label>
      <label class="label_content pauseOwnerType"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">暂停租金：</label>
      <label class="label_content pauseInflRent"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">备案时间：</label>
      <label class="label_content pauseCreateTime"></label>
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
                  <td style="width:200px;" class="am-hide-sm-only">规定租金</td>
                  <td style="width:350px;" class="am-hide-sm-only">地址</td>
              </tr>
          </thead>
          <tbody id="pauseHouseDetail" style="height:200px;display:block;overflow-y:scroll;">


          </tbody>
      </table>
  </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>

        <div class="am-form-group am-u-sm-12">
            <ul id="pauseRentPhotos" class="am-u-md-12" style="margin-bottom:30px;"></ul>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <div class="am-form-group am-u-sm-3">
              <label>上传报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="pauseUploadReport" type="file" name="pauseUploadReport" multiple>
            </div>
            <div id="pauseUploadReportShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="pauseRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 注销明细-->
<div id="cancel" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content cancelHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content cancelUseNature"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">完损等级：</label>
          <label class="label_content cancelDamageGrade"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">产别：</label>
          <label class="label_content cancelOwnerTypes"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content cancelHouseUsearea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content cancelLeasedArea"></label>
        </div>
        <div class="am-u-sm-4 cancel">
          <label class="label_style">联系电话：</label>
          <label class="label_content cancelTenantTel"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">承租人：</label>
          <label class="label_content cancelTenantName"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">身份证号：</label>
          <label class="label_content cancelTenantNumber"></label>
        </div>
        <div class="am-u-sm-4">
          
          <label class="label_style">注销类别：</label>
          <label class="label_content CancelType"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">单元号：</label>
          <label class="label_content cancelUnitID"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">层次：</label>
          <label class="label_content cancelFloorID"></label>
        </div>
        <div class="am-u-sm-4">
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content cancelHousePrerent"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">租差：</label>
          <label class="label_content cancelDiffRent"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">泵费：</label>
          <label class="label_content cancelPumpCost"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">异动事由：</label>
          <label class="label_content Remark"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">备案时间：</label>
          <label class="label_content cancelCreateTime"></label>
        </div>
        <div class="am-u-sm-4">
            <label class="label_style">计租表：</label>
            <a class="am-btn am-btn-primary am-btn-sm" id="cancelMaterQuery">查看</a>
        </div>
    </div>


    <div class="am-form-group am-u-sm-12 rent_reduction">
      <h2 class="label_title">注销信息：</h2>
    </div>
    <div class="am-form-group am-u-sm-12">
      <div class="am-u-sm-12">
        <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact overflow_tbody" style="border:1px solid #ccc;">
            <thead style="display:block;">
                <tr>
                    <td style="width:150px;">#</td>
                    <td style="width:150px;" class="am-hide-sm-only">楼栋编号</td>
                    <td style="width:150px;" class="am-hide-sm-only">建筑面积/㎡</td>
                    <td style="width:150px;" class="am-hide-sm-only">计租面积/㎡</td>
                    <td style="width:200px;" class="am-hide-sm-only">房屋原价/元</td>
                    <td style="width:200px;" class="am-hide-sm-only">注销租金/元</td>
                    <td style="width:200px;" class="am-hide-sm-only">楼栋地址</td>
                </tr>
            </thead>
            <tbody id="cancelHouseDetail" style="height:200px;display:block;overflow-y:scroll;">


            </tbody>
        </table>
      </div>
    </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="cancelPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <div class="am-form-group am-u-sm-3">
              <label>注销报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="cancelUploadReport" type="file" name="cancelUploadReport" multiple>
            </div>
            <div id="cancelUploadReportShow" class="am-u-md-12 img_content"></div>
        </div>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="cancelState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 租金减免明细-->
<div id="oldCancel" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content oldCancelHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4" style="padding-right: 0">
          <label class="label_style">楼栋编号：</label>
          <label class="label_content oldCancelBanID"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">楼栋地址：</label>
          <label class="label_content oldCancelAddress" style="width:476px;"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style"> 产别：</label>
          <label class="label_content oldCancelOwnertype"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content oldCancelUseNature"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content oldCancelHousePrerent"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content oldCancelHouseUsearea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content oldCancelLeasedArea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">联系电话：</label>
          <label class="label_content oldCancelTenantTel"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">承租人：</label>
          <label class="label_content oldCancelTenantName"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">身份证号：</label>
          <label class="label_content oldCancelTenantNumber"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-8">
          <label class="label_style">异动事由：</label>
          <label class="label_content oldCancelReason"></label>
        </div>
    </div>


    <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">核销金额：</h2>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-4">
          <label class="label_style">以前年：</label>
          <label class="label_content oldCancelYear"></label>元
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">以前月：</label>
          <label class="label_content oldCancelMonth"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="">以前月核销总金额：</label>
          <label class="label_content oldCancelMonthMoney"></label>元
        </div>
    </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="oldCancelPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>陈欠核销情况说明报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="oldCancelBook" type="file" name="oldCancelBook" multiple>
            </div>
            <div id="oldCancelBookShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>其它：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="oldCancelOther" type="file" name="oldCancelOther" multiple>
            </div>
            <div id="oldCancelOtherShow" class="am-u-md-12 img_content"></div>
        </div>


        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="oldCancelState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 租金减免明细-->
<div id="rentAdjustment" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content rentHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content rentUseNature"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">完损等级：</label>
          <label class="label_content rentDamageGrade"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">产别：</label>
          <label class="label_content rentOwnerTypes"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content rentHouseUsearea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content rentLeasedArea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content rentHousePrerent"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">承租人：</label>
          <label class="label_content rentTenantName"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">身份证号：</label>
          <label class="label_content rentTenantNumber"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">联系电话：</label>
          <label class="label_content rentTenantTel"></label>
        </div>
    </div>

    <div class="am-u-sm-12">
        <div class="am-u-sm-8">
          <label class="label_style">异动事由：</label>
          <label class="label_content rentRemark"></label>
        </div>
    </div>


    <div class="am-form-group am-u-sm-12 rent_reduction">
      <h2 class="label_title">调整信息：</h2>
    </div>
    <div class="am-form-group am-u-sm-12">
      <div class="am-u-sm-12">
        <table class="am-table am-table-striped am-table-hover am-table-centered am-table-compact overflow_tbody" style="border:1px solid #ccc;">
            <thead style="display:block;">
                <tr>
                    <td style="width:150px;">#</td>
                    <td style="width:250px;" class="am-hide-sm-only">楼栋编号</td>
                    <td style="width:250px;" class="am-hide-sm-only">增加金额</td>
                    <td style="width:250px;" class="am-hide-sm-only">楼栋地址</td>
                </tr>
            </thead>
            <tbody id="rentBanDetail" style="height:200px;display:block;overflow-y:scroll;">


            </tbody>
        </table>
      </div>
    </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="rentPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <div class="am-form-group am-u-sm-3">
              <label>注销报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="rentUploadReport" type="file" name="rentUploadReport" multiple>
            </div>
            <div id="rentUploadReportShow" class="am-u-md-12 img_content"></div>
        </div>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="rentState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 租金减免明细-->
<div id="rentAdd" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content rentAddHouseID"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">楼栋编号：</label>
          <label class="label_content rentAddBanID"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">楼栋地址：</label>
          <label class="label_content rentAddAddress"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">使用性质：</label>
          <label class="label_content rentAddUseNature"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">使用面积：</label>
          <label class="label_content rentAddHouseUseArea"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">计租面积：</label>
          <label class="label_content rentAddLeasedArea"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">产别：</label>
          <label class="label_content rentAddOwnerType"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">规定租金：</label>
          <label class="label_content rentAddHousePrerent"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">完损等级：</label>
          <label class="label_content rentAddDamageGrade"></label>
        </div>
    </div>
    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">承租人：</label>
          <label class="label_content rentAddTenantName"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">身份证号：</label>
          <label class="label_content rentAddTenantNumber"></label>
        </div>
        <div class="am-u-sm-4">
          <label class="label_style">联系电话：</label>
          <label class="label_content rentAddTenantTel"></label>
        </div>
    </div>


    <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">追加金额：</h2>
    </div>

    <div class="am-form-group am-u-sm-12">
        <div class="am-u-sm-4">
          <label class="label_style">以前年：</label>
          <label class="label_content rentAddYear"></label>
        </div>
        <div class="am-u-sm-8">
          <label class="label_style">以前月：</label>
          <label class="label_content rentAddMonth"></label>
        </div>
    </div>

    <div class="am-form-group am-u-sm-12">
        <div class="am-u-sm-12">
          <label class="label_style">异动事由：</label>
          <label class="label_content rentAddReason"></label>
        </div>
    </div>

    <div class="am-form-group am-u-sm-12">
        <h2 class="label_title">查看附件：</h2>
    </div>
    <div class="am-form-group am-u-sm-12">
        <div id="rentAddPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
    </div>
    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="rentAddState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 租金减免||break、空租、暂停计租||pause、陈欠核销||WriteOff、注销||cancel --> 
<form id="approveForm" style="margin-top:1.6rem;display:none;">
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-4">
      <label class="label_style" id="SerialNumber">房屋编号：</label>
    </div>
     <label class="p_style APhouseId"></label>
  </div>
  <div class="am-form-group am-u-md-6 LHide">
    <div class="am-u-md-4">
      <label class="label_style">楼栋编号：</label>
    </div>
     <label class="p_style APBanID"></label>
  </div>
  <div class="am-form-group am-u-md-12">
    <div class="am-u-md-2">
      <label class="label_style">楼栋地址：</label>
    </div>
     <label class="p_style APhouseAddress"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">楼层：</label>
    </div>
     <label class="p_style APFloorID"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">承租人：</label>
    </div>
     <label class="p_style APtenantName"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">联系电话：</label>
    </div>
     <label class="p_style APtenantTel"></label>
  </div>
    <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">身份证号：</label>
    </div>
     <label class="p_style APtenantNumber"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-4">
      <label class="label_style">备案时间：</label>
    </div>
    <div class="am-u-md-8" style="padding-right: 0">
     <label class="p_style APcreateTime"></label>
   </div>
  </div>
  <div class="am-form-group am-u-md-4 Uhide">
    <div class="am-u-md-6">
      <label class="label_style">使用面积：</label>
    </div>
     <label class="p_style APhouseArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">产别：</label>
    </div>
     <label class="p_style AownerType"></label>
  </div>
  <div class="am-form-group am-u-md-4 Ahide">
    <div class="am-u-md-6">
      <label class="label_style">计租面积：</label>
    </div>
     <label class="p_style APleasedArea"></label>
  </div>
  <div class="am-form-group am-u-md-4">
    <div class="am-u-md-6">
      <label class="label_style">规定租金：</label>
    </div>
     <label class="p_style HousePrerent"></label>
  </div>

<!--   <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">应收租金：</label>
    </div>
     <label class="p_style MuchMonth"></label>
  </div> -->
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免金额：</label>
    </div>
     <label class="p_style RemitRent"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免类型：</label>
    </div>
     <label id="breakType" class="p_style"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">减免时长：</label>
    </div>
     <label class="p_style MuchMonth"></label>
  </div>
  <div class="am-form-group am-u-md-12 breaks">
    <div class="am-u-md-2">
      <label class="label_style">证件号：</label>
    </div>
     <label id="IDNumber" class="p_style"></label>
  </div>

  <!--<div class="am-form-group am-u-md-12 pause">-->
    <!--<div class="am-u-md-2">-->
      <!--<label class="label_style">暂停类型：</label>-->
    <!--</div>-->
     <!--<label id="pauseType"></label>-->
  <!--</div>-->

  <div class="am-form-group am-u-md-12 WriteOff">
    <div class="am-u-md-2">
      <label class="label_style">核销起始时间：</label>
    </div>
     <label class="WriteOffStartTime">拆迁注销</label>
  </div>
  <div class="am-form-group am-u-md-12 WriteOff">
    <div class="am-u-md-2">
      <label class="label_style">核销结束时间：</label>
    </div>
     <label class="WriteOffEndTime">拆迁注销</label>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>查看附件：</label>
      </div>
      <div id="layer-photos-demo" class="am-u-md-12"></div>
    </div>

    <div class="am-form-group am-u-md-12">
      <div class="am-u-md-6">
        <label>审批状态：</label>
      </div>
    </div>
    <div id="approveState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</form>
<!--- 租金减免、空租、暂停计租、陈欠核销、注销结束 -->
<!-- 楼栋调整-->
<div id="buildingAdjustment" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-4">
      <label class="label_style">楼栋编号：</label>
      <label id="buildingAdjustBanID" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">楼栋地址：</label>
      <label id="buildingAdjustAddress" class="label_content" style="width:492px;"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style"> 产别：</label>
      <label id="buildingAdjustOwnerType" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style"> 栋数：</label>
      <label id="buildingAdjustBanUnitNum" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">占地面积：</label>
      <label id="buildingAdjustCoveredArea" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">建筑面积：</label>
      <label id="buildingAdjustTotalArea" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">使用面积：</label>
      <label id="buildingAdjustBanUsearea" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼栋原价：</label>
      <label id="buildingAdjustTotalOprice" class="label_content"></label>
    </div>
  </div>


  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼栋租金：</label>
      <label id="buildingAdjustBanPrerent" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">异动事由：</label>
      <label id="buildingAdjustReason" class="label_content" style="width:492px;"></label>
    </div>    
  </div>

  <div class="am-form-group am-u-sm-12 empty_rent_cancel">
      <h2 class="label_title">房屋调整：</h2>
  </div>
  <div class="am-u-sm-12 empty_rent_cancel">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style" style="width:100px;">调整前完损等级：</label>
      <label id="beforeAdjustDamageGrade" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style" style="width:100px;">调整前结构类别：</label>
      <label id="beforeAdjustStructureType" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-sm-12 empty_rent_cancel">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style" style="width:100px;">调整后完损等级：</label>
      <label id="afterAdjustDamageGrade" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style" style="width:100px;">调整后结构类别：</label>
      <label id="afterAdjustStructureType" class="label_content"></label>
    </div>
  </div>
  <div class="am-u-sm-12 empty_rent_cancel">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style" style="width:100px;">调整后的地址：</label>
      <label id="afterAdjustadd" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <h2 class="label_title">上传附近：</h2>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>其他：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="buildingAdjustOther" type="file" name="buildingAdjustOther" multiple>
            </div>
            <div id="buildingAdjustOtherShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-u-sm-12"><hr /></div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="buildingAdjustPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>

        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="buildingAdjustState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
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
<!-- 房屋调整-->
<div id="houseAdjust" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>

    <div class="am-u-sm-12">
        <div class="am-u-md-12">
          <label class="label_style">房屋编号：</label>
          <label class="label_content houseAdjustHouseID"></label>
        </div>
    </div>

  	<div class="am-u-sm-12">
    	<div class="am-form-group am-u-sm-12">
      		<label class="label_style">计租表：</label>
      		<a class="am-btn am-btn-primary am-btn-sm" id="rentMaterQuery">查看</a>
    	</div>
  	</div>

    <div class="am-u-sm-12">
        <div class="am-u-sm-12">
          <label class="label_style">异动事由：</label>
          <label class="label_content houseAdjustRemark"></label>
        </div>
    </div>


    <div class="am-u-sm-12">
        <div class="am-u-sm-4">
          	<label class="label_style">备案时间：</label>
          	<label class="label_content houseAdjustCreateTime"></label>
        </div>
    </div>

    <div class="am-form-group am-u-sm-12">
      <h2 class="label_title">楼栋信息：</h2>
    </div>

    <style>
	  .adjusHouse_table tr,.adjusHouse_table td,.adjusHouse_table th{text-align:center;font-size:14px;padding:4px 5px;}
  </style>
    <div class="am-u-sm-12 " style="overflow-x:scroll">
    	<table class="adjusHouse_table" border="1" style="width:1360px;border:1px solid #D6E2F6;text-align:center;">
    		<tr>
    			<th colspan="2" rowspan="2">楼栋编号</th>
    			<th colspan="2" rowspan="2">楼栋地址</th>
    			<th colspan="3" rowspan="1">规定租金</th>
    			<th colspan="3" rowspan="1">计租面积</th>
    			<th colspan="3" rowspan="1">建筑面积</th>
    			<th colspan="3" rowspan="1">楼栋原价</th>
    		</tr>
			<tr>
    			<th>调整前</th>
    			<th>调整金额</th>
    			<th>调整后</th>
    			<th>调整前</th>
    			<th>调整面积</th>
    			<th>调整后</th>
    			<th>调整前</th>
    			<th>调整面积</th>
    			<th>调整后</th>
    			<th>调整前</th>
    			<th>调整金额</th>
    			<th>调整后</th>
    		</tr>
    		<tr class="ban_info" style="display:none;">
				<td colspan="2" rowspan="1" class=""></td>
				<td colspan="2" rowspan="1"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
    		</tr>
    	</table>
    </div>

    <div class="am-u-md-12" style="padding-left:0;">
		<div class="am-form-group am-u-sm-12 status_2" style="margin-top:30px;display:none;">
            <h2 class="label_title">上传附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>调整说明：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="adjustExplain" type="file" name="adjustExplain" multiple>
            </div>
            <div id="adjustExplainShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-form-group am-u-sm-3">
              <label>其它：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="HAOther" type="file" name="HAOther" multiple>
            </div>
            <div id="HAOtherShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="HAPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="HAState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!-- 新发租-->
<div id="newRent" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-4">
      <label class="label_style">房屋编号：</label>
      <label id="newRentHouseID" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style"> 租户ID：</label>
      <label id="newRentTenantID" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style"> 承租人：</label>
      <label id="newRentTenantName" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">身份证号：</label>
      <label id="newRentTenantNumber" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">联系电话：</label>
      <label id="newRentTenantTel" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">单元号：</label>
      <label id="newRentUnitID" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">层次：</label>
      <label id="newRentFloorID" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">建筑面积：</label>
      <label id="newRentHouseArea" class="label_content"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">房屋原价：</label>
      <label id="newRentOldOprice" class="label_content"></label>
    </div>  
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-12">
      <label class="label_style">新发类型：</label>
      <label id="newLeaseTypes" class="label_content" style="width:492px;"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-12">
      <label class="label_style">异动事由：</label>
      <label id="newRentReason" class="label_content" style="width:492px;"></label>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label class="label_style">楼栋信息：</label>
      <a class="am-btn am-btn-primary am-btn-sm" id="newRentBanInfo">明细</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-md-12">
      <label class="label_style">计租表：</label>
      <a class="am-btn am-btn-primary am-btn-sm" id="newRentDetail">明细</a>
    </div>
  </div>
  <div class="am-u-sm-12">
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">备案时间：</label>
      <label id="createTime" class="label_content"></label>
    </div>
  </div>

  <div class="am-u-md-12" style="padding-left:0;">
      <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
          <div class="am-u-sm-12"><hr /></div>
          <h2 class="label_title">上传附件：</h2>
      </div>
      <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
          <div class="am-form-group am-u-sm-3">
            <label>新发租情况说明：</label>
          </div>
          <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="newRentExplain" type="file" name="newRentExplain" multiple>
          </div>
          <div id="newRentExplainShow" class="am-u-md-12 img_content"></div>
      </div>
      <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
          <div class="am-form-group am-u-sm-3">
            <label>其它：</label>
          </div>
          <div class="am-form-group am-form-file am-u-md-5">
                <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                <input id="newRentOther" type="file" name="newRentOther" multiple>
          </div>
          <div id="newRentOtherShow" class="am-u-md-12 img_content"></div>
      </div>


      <div class="am-u-sm-12"><hr /></div>
      <div class="am-form-group am-u-sm-12">
          <h2 class="label_title">查看附件：</h2>
      </div>
      <div class="am-form-group am-u-sm-12">
          <div id="newRentPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
      </div>

      <div class="am-form-group am-u-sm-12">
          <h2 class="label_title">审批状态：</h2>
      </div>
      <div id="newRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
  </div>
</div>
<!-- 租金调整（批量）明细 -->
<div id="batch" class="am-form" style="display:none;margin-top:1.6rem;">
<button id="batchPrint">打印预览</button>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <div class="am-form-group am-u-md-4">
      <label id="houseLabel" class="label_style">楼栋编号：</label>
      <label class="label_content batchBanId"></label>
    </div>
    <div class="am-form-group am-u-sm-8">
      <label class="label_style">楼栋地址：</label>
      <label class="label_content batchAddress"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">楼栋产别：</label>
      <label class="label_content batchOwnerType"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">规定租金：</label>
      <label class="label_content batchPreRent"></label>
    </div>
    <div class="am-form-group am-u-sm-4">
      <label class="label_style">异动租金：</label>
      <label class="label_content batchDiff"></label>
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
                  <td style="width:200px;" class="am-hide-sm-only">规定租金</td>
                  <td style="width:200px;" class="am-hide-sm-only">计算租金</td>
                  <td style="width:200px;" class="am-hide-sm-only">租金异动</td>
              </tr>
          </thead>
          <tbody id="batchHouseDetail" style="height:200px;display:block;overflow-y:scroll;">


          </tbody>
      </table>
  </div>

    <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">异动事由：</h2>
        </div>
        <div class="am-form-group am-u-sm-12" style="padding-right:0;">
            <textarea id="batchReason" style="width:100%;height:80px;padding:4px 10px;" readonly></textarea>
        </div>
        <div class="am-form-group am-u-sm-12">
            <ul id="batchRentPhotos" class="am-u-md-12" style="margin-bottom:30px;"></ul>
        </div>

        <div class="am-form-group am-u-sm-12 status_2" style="display:none;">
            <div class="am-u-sm-12"><hr /></div>
            <div class="am-form-group am-u-sm-3">
              <label>上传报告：</label>
            </div>
            <div class="am-form-group am-form-file am-u-md-5">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                  <input id="batchUploadReport" type="file" name="batchUploadReport" multiple>
            </div>
            <div id="batchUploadReportShow" class="am-u-md-12 img_content"></div>
        </div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="batchRentState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
  <!-- 楼栋注销 S -->
<div id="buildingcancel" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
	<div class="am-u-sm-12">
	    <div class="am-form-group am-u-md-12">
	      <label class="label_style">楼栋编号：</label>
	      <input type="number" id="buildingcancelQueryBan" readonly class="label_input" style="width: 158px;" placeholder="">
	    </div>
	</div>
	<div class="am-u-sm-12">
	    <div class="am-form-group am-u-sm-12">
	      <label class="label_style">楼栋地址：</label>
	      <label id="buildingcancelAddress" class="label_p_style" style="width:470px;"></label>
	    </div>
	  </div>
      <div class="am-u-sm-12">
          <div class="am-form-group am-u-sm-12">
            <label class="label_style">异动事由：</label>
            <input id="buildingcancelReason" readonly class="label_input" style="width:470px;">
          </div>    
       </div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基数异动：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <table class="am-table am-table-bordered  am-table-hover">
	  <thead>
		  <tr>
			<th>楼栋编号</th>
			<th>异动状态</th>
			<th class="cancels">规定租金</th>
			<th class="cancels">使用面积</th>
			<th class="cancels">建筑面积</th>
			<th class="cancels">房屋原价</th>
		  </tr>
	  </thead>
	  <tbody>
		<tr>
		  <td id="floor_number"></td>
		  <td>异动前</td>
		  <td class="cancel_before_1" id="floor_prescribed"><input type="hidden" name="floor_prescribed" value=""><label></label></td>
		  <td class="cancel_before_2" id="floor_areaofuse"><input type="hidden" name="floor_areaofuse" value=""><label></label></td>
		  <td class="cancel_before_3" id="floor_builtuparea"><input type="hidden" name="floor_builtuparea" value=""><label></label></td>
		  <td class="cancel_before_4" id="floor_original"><input type="hidden" name="floor_original" value=""><label></label></td>
		</tr>
		<tr>
		  <td></td>
		  <td>异动</td>
		  <td class="cancel_change_1"><input type="hidden" name="cancel_change_1" value=""><label></label></td>
		  <td class="cancel_change_2"><input type="hidden" name="cancel_change_2" value=""><label></label></td>
		  <td class="cancel_change_3"><input type="hidden" name="cancel_change_3" value=""><label></label></td>
		  <td class="cancel_change_4"><input type="hidden" name="cancel_change_4" value=""><label></label></td>
		</tr>
		<tr>
		  <td></td>
		  <td>异动后</td>
		  <td class="cancel_after_1" id="changes_floor_prescribed"><input type="hidden" name="changes_floor_prescribed" value=""><label></label></td>
		  <td class="cancel_after_2" id="changes_floor_areaofuse"><input type="hidden" name="changes_floor_areaofuse" value=""><label></label></td>
		  <td class="cancel_after_3" id="changes_floor_builtuparea"><input type="hidden" name="changes_floor_builtuparea" value=""><label></label></td>
		  <td class="cancel_after_4" id="changes_floor_original"><input type="hidden" name="changes_floor_original" value=""><label></label></td>
		</tr>
	  </tbody>
	</table>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">注销明细：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
	 <table class="am-table am-table-bordered  am-table-hover j-house-box">
	 	  <thead>
	 		  <tr>
	 		    <th>房屋编号</th>
	 		    <th>承租人</th>
	 		    <th>房屋原价</th>
	 		    <th>建筑面积</th>
	 		    <th>规定租金</th>
	 		    <th>计租面积</th>
	 		  </tr>
	 	  </thead>
	 	  <tbody>
			  
		  </tbody>
	 	</table>
  </div>
  <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-u-sm-12"><hr /></div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="buildingcancelPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>
  
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="buildingcancelState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!--- 楼栋注销 E -->
  <!-- 楼栋注销 S -->
<div id="rentcancel" class="am-form" style="display:none;margin-top:1.6rem;">
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基础信息：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
	<div class="am-u-sm-12">
	    <div class="am-form-group am-u-md-12">
	      <label class="label_style">楼栋编号：</label>
	      <input type="number" id="rentcancelQueryBan" readonly class="label_input" style="width: 158px;" placeholder="">
	    </div>
	</div>
	<div class="am-u-sm-12">
	    <div class="am-form-group am-u-sm-12">
	      <label class="label_style">楼栋地址：</label>
	      <label id="rentcancelAddress" class="label_p_style" style="width:470px;"></label>
	    </div>
	  </div>
      <div class="am-u-sm-12">
          <div class="am-form-group am-u-sm-12">
            <label class="label_style">异动事由：</label>
            <input id="rentcancelReason" readonly class="label_input" style="width:470px;">
          </div>    
       </div>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">基数异动：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
    <table class="am-table am-table-bordered  am-table-hover">
	  <thead>
		  <tr>
			<th>楼栋编号</th>
			<th>异动状态</th>
			<th class="cancels">规定租金</th>
			<th class="cancels">使用面积</th>
			<th class="cancels">建筑面积</th>
			<th class="cancels">房屋原价</th>
		  </tr>
	  </thead>
	  <tbody>
		<tr>
		  <td id="floor_number_rentcancel"></td>
		  <td>异动前</td>
		  <td class="cancel_before_1" id="floor_prescribed"><input type="hidden" name="floor_prescribed" value=""><label></label></td>
		  <td class="cancel_before_2" id="floor_areaofuse"><input type="hidden" name="floor_areaofuse" value=""><label></label></td>
		  <td class="cancel_before_3" id="floor_builtuparea"><input type="hidden" name="floor_builtuparea" value=""><label></label></td>
		  <td class="cancel_before_4" id="floor_original"><input type="hidden" name="floor_original" value=""><label></label></td>
		</tr>
		<tr>
		  <td></td>
		  <td>异动</td>
		  <td class="cancel_change_1"><input type="hidden" name="cancel_change_1" value=""><label></label></td>
		  <td class="cancel_change_2"><input type="hidden" name="cancel_change_2" value=""><label></label></td>
		  <td class="cancel_change_3"><input type="hidden" name="cancel_change_3" value=""><label></label></td>
		  <td class="cancel_change_4"><input type="hidden" name="cancel_change_4" value=""><label></label></td>
		</tr>
		<tr>
		  <td></td>
		  <td>异动后</td>
		  <td class="cancel_after_1" id="changes_floor_prescribed"><input type="hidden" name="changes_floor_prescribed" value=""><label></label></td>
		  <td class="cancel_after_2" id="changes_floor_areaofuse"><input type="hidden" name="changes_floor_areaofuse" value=""><label></label></td>
		  <td class="cancel_after_3" id="changes_floor_builtuparea"><input type="hidden" name="changes_floor_builtuparea" value=""><label></label></td>
		  <td class="cancel_after_4" id="changes_floor_original"><input type="hidden" name="changes_floor_original" value=""><label></label></td>
		</tr>
	  </tbody>
	</table>
  </div>
  <div class="am-form-group am-u-sm-12">
    <h2 class="label_title">注销明细：</h2>
  </div>
  <div class="am-form-group am-u-sm-12">
	 <table class="am-table am-table-bordered  am-table-hover j-house-box">
	 	  <thead>
	 		  <tr>
	 		    <th>房屋编号</th>
	 		    <th>承租人</th>
	 		    <th>房屋原价</th>
	 		    <th>建筑面积</th>
	 		    <th>规定租金</th>
	 		    <th>计租面积</th>
	 		  </tr>
	 	  </thead>
	 	  <tbody>
			  
		  </tbody>
	 	</table>
  </div>
  <div class="am-u-md-12" style="padding-left:0;">
        <div class="am-u-sm-12"><hr /></div>
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">查看附件：</h2>
        </div>
        <div class="am-form-group am-u-sm-12">
            <div id="rentcancelPhotos" class="am-u-md-12" style="margin-bottom:30px;"></div>
        </div>
  
        <div class="am-form-group am-u-sm-12">
            <h2 class="label_title">审批状态：</h2>
        </div>
        <div id="rentcancelState" class="am-u-md-12" style="padding-left:3rem;"></div>
    </div>
</div>
<!--- 楼栋注销 E -->

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
			  <label for="doc-vld-email-2" class="label_style">楼栋地址：</label>
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
			  <label for="doc-vld-email-2" class="label_style">居住层：</label>
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
		    <li style="width:7%">实有面积</li>
		    <li style="width:7%">基价折减</li>
		    <li style="width:6%">计租面积</li>
		    <li style="width:7%">层次调解率</li>

		    <li style="width:4%">租金</li>
		    <li style="width:5%">计算租金</li>

		    <li style="width:4%">状态</li>
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
    			<!-- <div class="am-u-md-12">
    				<div class="am-u-md-6"><span class="w100">产别：</span><span class="w50 RentType"></span></div>
    				<div class="am-u-md-6"><span class="w100">规定租金：</span><span class="w50 RentPrice"></span></div>
    			</div> -->
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
						<span class="w100">月租金：</span><span class="w50 RentReceive"></span>元
					</div>
				</div>
				
    		</div>
    		<div class="am-u-md-3">
    			<div>实有面积：<span class="w50 RentHouseArea"></span></div>
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
<script type="text/javascript" src="/public/static/gf/js/viewer.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/change_audit.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/gf/viewJs/ban_form.js?v=<?php echo $version; ?>"></script>

</body>
</html>