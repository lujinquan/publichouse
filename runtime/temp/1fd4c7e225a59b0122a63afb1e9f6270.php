<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:65:"D:\phpStudy\WWW\ph/application/ph\view\property_report\index.html";i:1526464322;s:50:"D:\phpStudy\WWW\ph/application/ph\view\layout.html";i:1526464322;s:44:"application/ph/view/form/property_right.html";i:1525251640;s:43:"application/ph/view/notice/notice_info.html";i:1523846106;s:42:"application/ph/view/index/second_menu.html";i:1523846106;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>产权统计</title>
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
  
<?php
    if($propertyOption){
        $owner = $owerLst[$propertyOption['OwnerType']];
        $inst = isset($propertyOption['TubulationID'])?$insArr[$propertyOption['TubulationID']]:$insArr[$institutionid];
        $year = $propertyOption['year']?$propertyOption['year']:date('Y',time());
    }else{
        $owner = '市属';
        $inst = session('user_base_info.institution_name');
        $year = date('Y',time());
    }
?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">统计报表</strong> /
            <small>产权统计</small>
        </div>
    </div>

    <div class="am-g">
        <div class="am-u-md-12">
            <h2 style="text-align:center;">武汉市房地局直管公房产权（<?php echo $owner; ?>）情况综合统计表</h2>
        </div>
        <form action="<?php echo url('PropertyReport/index'); ?>" method="post" class="am-form am-print-hide" style="margin-bottom:20px;padding-left:6px;">
            <div class="label_style">产别：</div>
            <div class="am-u-md-2">
                <select name="OwnerType" id="doc-select-7" >
                    <option  value="1" style="display:none">市属</option>
                    <?php foreach($owerLst as $k1 =>$v1){ ;

                    if($propertyOption != array()){
                            if($propertyOption['OwnerType'] == $k1){
                                $select ='selected';
                            }else{
                                $select ='';
                            }
                        }else{
                            $select ='';
                        }

                    ?>
                    <option value="<?php echo $k1; ?>" <?php echo $select; ?>><?php echo $v1;?></option>
                    <?php }; ?>
                </select>
            </div>
            <?php if(session('user_base_info.institution_level')==1){ ;?>
            <div class="label_style">机构：</div>

            <div class="am-u-md-2">
                <select name="TubulationID" id="doc-select-2">
                    <option  value="<?php echo session('user_base_info.institution_id'); ?>" style="display:none"><?php echo session('user_base_info.institution_name'); ?></option>
                    <?php foreach($instLst as $k10 => $v10){ if($v10['level'] <2 ){; 
                                if($propertyOption != array()){
                                    if($propertyOption['TubulationID'] == $v10['id']){
                                        $select ='selected';
                                    }else{
                                        $select ='';
                                    }
                                }else{
                                    $select ='';
                                }
                                ?>
                    <option value="<?php echo $v10['id']; ?>" <?php echo $select; ?>><?php echo $v10['Institution']; ?></option>
<?php }}; ?>
                </select>
                <?php } ; ?>

            </div>
            <div class="label_style">查询年份:</div>
            <div class="am-u-md-2">

                <input type="text" name="year" value="<?php echo $year; ?>" class="am-form-field" data-am-datepicker="{format: 'yyyy ', viewMode: 'years',minViewMode: 'years'}" placeholder="日历组件" data-am-datepicker readonly/>
            </div>
            <button type="submit" class="am-btn am-btn-xs am-btn-secondary"><span class="am-icon-search"></span>
                查询
            </button>
            <a type="button" class="am-btn am-btn-xs am-btn-secondary" href="/ph/PropertyReport/index.html"><span class="am-icon-reply"></span>
                重置
            </a>
            <button type="button" id="printForm" class="am-btn am-btn-xs am-btn-secondary"><span
                    class="am-icon-print"></span> 打印
            </button>
            <a type="button" class="am-btn am-btn-xs am-btn-secondary"  id="propertycache"><span class="am-icon-file-o"></span>
                缓存报表
            </a>
        </form>
        <div style="padding-left:6px;">
            <?php if($data){; ?>
<div style="display:inline-block;width:30%" class="DQueryType fontSize_12">产别：<?php echo $owner; ?></div>
<div style="display:inline-block;width:30%" class="DQueryType fontSize_12">填报单位：<?php echo $inst; ?></div>
<div style="display:inline-block;width:30%" class="time fontSize_12">填报时间：<?php echo $year; ?>年</div>
<table class="am-table am-table-bordered am-table-centered" id="PropertyForm">
        <thead>
            <tr>
                <th rowspan="4" colspan="2" class="am-text-middle">产权基本情况</th>
                <th rowspan="1" colspan="3" class="am-text-middle">房屋总计</th>
                <th rowspan="1" colspan="9" class="am-text-middle">其中：</th>
            </tr>
            <tr>
                <td rowspan="2" colspan="1" >栋</td>
                <td rowspan="2" colspan="2" >建筑面积</td>
                <td rowspan="1" colspan="3" >代管房屋</td>
                <td rowspan="1" colspan="3" >托管房屋</td>
                <td rowspan="1" colspan="3" >与私房、区直共有房屋</td>
            </tr>
            <tr>
                <td rowspan="1" colspan="1" >栋</td>
                <td rowspan="1" colspan="2" >建筑面积（㎡）</td>
                <td rowspan="1" colspan="1" >栋</td>
                <td rowspan="1" colspan="2" >建筑面积（㎡）</td>
                <td rowspan="1" colspan="1" >栋</td>
                <td rowspan="1" colspan="2" >建筑面积</td>
            </tr>
            <tr>
                <td rowspan="1" colspan="1" ><?php echo $data[0]['totalNum']; ?></td>
                <td rowspan="1" colspan="2" ><?php echo $data[0]['totalAreas']; ?></td>
                <td rowspan="1" colspan="1" ><?php echo $data[0]['daiNum']; ?></td>
                <td rowspan="1" colspan="2" ><?php echo $data[0]['daiAreas']; ?></td>
                <td rowspan="1" colspan="1" ><?php echo $data[0]['tuoNum']; ?></td>
                <td rowspan="1" colspan="2" ><?php echo $data[0]['tuoAreas']; ?></td>
                <td rowspan="1" colspan="1" ></td>
                <td rowspan="1" colspan="2" ></td>
            </tr>
            <tr>
                <td rowspan="4" colspan="2" class="am-text-middle">本期房屋增减</td>
                <td rowspan="1" colspan="3" class="am-text-middle">年房屋增加<span style="padding: 0 5px"><?php echo $data[1]['incNum']; ?></span>栋，建筑面积<span style="padding: 0 5px"></span><?php echo $data[1]['incAreas']; ?>㎡</td>
                <td rowspan="1" colspan="9" class="am-text-middle">年度房减少<span style="padding: 0 5px"><?php echo $data[1]['decNum']; ?></span>栋，建筑面积<span style="padding: 0 5px"></span><?php echo $data[1]['decAreas']; ?>㎡</td>
            </tr>
            <tr>
                <td rowspan="1" colspan="1" >接管</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['jieguanNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['jieguanArea']; ?></td>
                <td rowspan="1" colspan="1" >合建</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['hejianNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['hejianArea']; ?></td>
                <td rowspan="1" colspan="1" >公房出售</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['chushouNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['chushouArea']; ?></td>
                <td rowspan="1" colspan="1" >自然灭失</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['mieshiNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[2]['mieshiArea']; ?></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="1" >危改还建</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['huanjianNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['huanjianArea']; ?></td>
                <td rowspan="1" colspan="1" >加改扩</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['jiagaiNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['jiagaiArea']; ?></td>
                <td rowspan="1" colspan="1" >危改拆除</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['chaichuNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['chaichuArea']; ?></td>
                <td rowspan="1" colspan="1" >房屋划转</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['huazhuanNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[3]['huazhuanArea']; ?></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="1" >新建</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['xinjianNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['xinjianArea']; ?></td>
                <td rowspan="1" colspan="1" >其他</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['qitaOneNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['qitaOneArea']; ?></td>
                <td rowspan="1" colspan="1" >落私发还</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['fahuanNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['fahuanArea']; ?></td>
                <td rowspan="1" colspan="1" >其他</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['qitaTwoNum']; ?>栋</td>
                <td rowspan="1" colspan="1" ><?php echo $data[4]['qitaTwoArea']; ?></td>
            </tr>
            <tr>
                <td rowspan="1" colspan="3" class="am-text-middle">已登记房屋</td>
                <td rowspan="1" colspan="2" class="am-text-middle"><?php echo $data[5]['dengjiNum']; ?>栋</td>
                <td rowspan="1" colspan="4" class="am-text-middle">建筑面积<span style="padding: 0 5px"></span><?php echo $data[5]['dengjiArea']; ?>㎡</td>
                <td rowspan="1" colspan="5" class="am-text-middle">备注：<span style="padding: 0 5px"></span></td>
            </tr>

            </thead>

</table>
<?php }else{
    echo '<h2 align="center">暂无数据</h2>';
} ?>
        </div>
    </div>
</div>


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
</script>

<script type="text/javascript">
    $('#printForm').click(function () {
        window.print();
    });
    $('#propertycache').click(function () {
        $.ajax({ url: "/ph/SystemLog/PropertyReportCache", success: function(result){
            var results = jQuery.parseJSON(result);
            alert(results.msg);
        }});
    });
</script>

</body>
</html>