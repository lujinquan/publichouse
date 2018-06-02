<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\phpStudy\WWW\publichouse/application/user\view\publics\signin.html";i:1527493698;}*/ ?>
<!--<div style="text-align:center;margin:200px 0px;font-size:20px;">服务器已迁移，请<span style="font-weight:bold;"><a href="http://118.25.128.122" target="_blank">点击此处</a></span>访问……</div>-->
<!DOCTYPE html>
<html>
<head>
    <title>武昌区公房管理系统v1.0</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="/public/static/user/css/signin.css" rel="stylesheet" type="text/css" media="all">
    <script src="/public/static/user/js/jquery-1.10.2.min.js" type="text/javascript"></script>

</head>
<body onkeydown="getkeyup(event)">
    <div id="top-title-div">
        <span id="top-title-text">武房网公房管理系统</span>
    </div>
    <div id="center-div">
        <div id="main-div">
            <div id="main-top-menu">
                <div id="main-top-menu-name"><span id="main-top-menu-name-span">账号登录</span></div>
                <div id="main-top-menu-tel"><span id="main-top-menu-tel-span">手机登录</span></div>
                <span id="menu-btn-id">name</span>
            </div>
            <div id="main-prompt"><span class="error-box">输入验证码错误</span></div>

            <div id="tel-part" hidden="hidden">
                <div id="" class="">
                    <img id="vertical-bar-tel" class="img-margin" src="/public/static/user/images/tel.png"><span class="vertical-bar">|</span><input id="phoneNum" placeholder="输入手机号" maxlength="11" class="edging" type="text" name=""><div class="tel-hr"></div>
                </div>
                <div id="" class="">
                    <img id="vertical-bar-code" class="img-margin" src="/public/static/user/images/code.png"><span class="vertical-bar">|</span><input id="code" placeholder="验证码" maxlength="6" class="edging code1" type="text" name="" style="width:170px;"><button id="btn-code">发送验证码</button><div class="tel-hr"></div>
                </div>
                <div id="tel-div-login">
                    <button id="tel-btn-login" onclick="sendCode()" class="btn-login">登  录</button>
                </div>
            </div>

            <div id="name-part">
                <div id="" class="">
                    <img id="vertical-bar-user" class="img-margin" src="/public/static/user/images/user.png"><span class="vertical-bar">|</span><input id="UserName" placeholder="输入账号" maxlength="100" class="edging" type="text" name="">
                    <div class="tel-hr"></div>
                </div>
                <div id="" class="">
                    <img id="vertical-bar-pwd" class="img-margin" src="/public/static/user/images/pwd.png"><span class="vertical-bar">|</span><input id="Password" placeholder="输入密码" maxlength="100" class="edging" type="password" name=""><div class="tel-hr"></div>
                </div>
                <div id="" class="">
                    <img id="vertical-bar-code2" class="img-margin" src="/public/static/user/images/code.png"><span class="vertical-bar">|</span><input id="yzm" placeholder="验证码" maxlength="6" class="edging code2" type="text" name="" style="width:170px;">
                    <img id="ImageCheck" src="<?php echo captcha_src(); ?>" class="yzm-img" onclick="this.src='<?php echo captcha_src(); ?>?d='+Math.random();" title="点击刷新" alt="captcha" /><div class="tel-hr hr-super-dog"></div>
                </div>
                <div id="super-dog-div"><span id="super-dog">未检测到安全控件</span></div>
                <div id="name-div-login">
                    <button id="name-btn-login" onclick="btnClick()" class="btn-login">登  录</button>
                </div>
            </div>

        </div>
    </div>
    <footer>楚天新媒科技（武汉）有限公司</footer>
</body>
<script type="text/javascript" src="/public/static/user/js/signin.js"></script>
 <script src="/public/static/user/js/superdog.js" type="text/javascript"></script>
</html>
