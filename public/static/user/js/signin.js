function getkeyup(event) {
    var menu = $('#menu-btn-id').html();
    if (event.keyCode == 13) {
        if(menu == 'name'){
            btnClick();
        } else if(menu == 'tel') {
            sendCode();
        }
    }
}
$('#phoneNum').focus(function(){
	$(".error-box").hide();
	$('#vertical-bar-tel').attr('src', '/public/static/user/images/tel2.png');
	$(this).next().css('border', '1px solid #4087F1');
	$('#vertical-bar-tel').next().css('color', '#4087F1');
});
$('#phoneNum').blur(function(){
	$('#vertical-bar-tel').attr('src', '/public/static/user/images/tel.png');
	$(this).next().css('border', '1px solid #E1E1E1');
	$('#vertical-bar-tel').next().css('color', '#AFAFAF');
});
$('#code').focus(function(){
	$(".error-box").hide();
	$('#vertical-bar-code').attr('src', '/public/static/user/images/code2.png');
	$(this).next().next().css('border', '1px solid #4087F1');
	$('#vertical-bar-code').next().css('color', '#4087F1');
});
$('#code').blur(function(){
	$('#vertical-bar-code').attr('src', '/public/static/user/images/code.png');
	$(this).next().next().css('border', '1px solid #E1E1E1');
	$('#vertical-bar-code').next().css('color', '#AFAFAF');
});
$('#main-top-menu-tel').click(function(){
    $(this).css('cursor', 'default');
    $('#main-top-menu-name').css('cursor', 'pointer');
    $('#main-top-menu-name span').css({'color':'#999999','border-bottom':'none'});
    $('#main-top-menu-tel span').css({'color':'#1188F0','border-bottom':'2px solid #1188F0'});
    $(".error-box").hide();
    $('#menu-btn-id').html('tel');
	$('#tel-part').show();
	$('#name-part').hide();
});
$('#main-top-menu-name').click(function(){
    $(this).css('cursor', 'default');
    $('#main-top-menu-tel').css('cursor', 'pointer');
    $('#main-top-menu-name span').css({'color':'#1188F0','border-bottom':'2px solid #1188F0'});
    $('#main-top-menu-tel span').css({'color':'#999999','border-bottom':'none'});
    $(".error-box").hide();
    $('#menu-btn-id').html('name');
	$('#tel-part').hide();
	$('#name-part').show();
});
$('#UserName').focus(function(){
	$(".error-box").hide();
	$('#vertical-bar-user').attr('src', '/public/static/user/images/user2.png');
	$(this).next().css('borderBottom', '1px solid #4087F1');
	$('#vertical-bar-user').next().css('color', '#4087F1');
});
$('#UserName').blur(function(){
	$('#vertical-bar-user').attr('src', '/public/static/user/images/user.png');
	$(this).next().css('borderBottom', '1px solid #E1E1E1');
	$('#vertical-bar-user').next().css('color', '#AFAFAF');
});
$('#Password').focus(function(){
	$(".error-box").hide();
	$('#vertical-bar-pwd').attr('src', '/public/static/user/images/pwd2.png');
	$(this).next().css('borderBottom', '1px solid #4087F1');
	$('#vertical-bar-pwd').next().css('color', '#4087F1');
});
$('#Password').blur(function(){
	$('#vertical-bar-pwd').attr('src', '/public/static/user/images/pwd.png');
	$(this).next().css('borderBottom', '1px solid #E1E1E1');
	$('#vertical-bar-pwd').next().css('color', '#AFAFAF');
});
$('#yzm').focus(function(){
	$(".error-box").hide();
	$('#vertical-bar-code2').attr('src', '/public/static/user/images/code2.png');
	$(this).next().next().css('borderBottom', '1px solid #4087F1');
	$('#vertical-bar-code2').next().css('color', '#4087F1');
});
$('#yzm').blur(function(){
	$('#vertical-bar-code2').attr('src', '/public/static/user/images/code.png');
	$(this).next().next().css('borderBottom', '1px solid #E1E1E1');
	$('#vertical-bar-code2').next().css('color', '#AFAFAF');
});

$(function(){
    $('#btn-code').click(function(){
        getCode($('#btn-code'))
    });
    var v = getCookie('ph_code_sceond_down');
    if(v > 0){
        settime($('#btn-code'));
    }
})
function getCode(obj){
	var objtip = $(".error-box");
    var telNum = $('#phoneNum').val();
    if($.trim(telNum) == ''){
        
        objtip.show();
        objtip.html('手机号不能为空');
    } else if(!isPhoneNum(telNum)){
       
        objtip.show();
        objtip.html('请输入有效的手机号码！');
    } else {
    	objtip.hide();
        $.post('/user/Publics/telsignin', 'telNum='+telNum, function(res){
            
            if(res.code == 0){
                objtip.show();
                objtip.html(res.msg);
            } else {
                setCookie('ph_code_sceond_down', 60, 60);
                settime(obj);
            }
        });
        
    }
}
function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=")
        if (c_start!=-1)
        { 
        c_start=c_start + c_name.length+1 
        c_end=document.cookie.indexOf(";",c_start)
        if (c_end==-1) c_end=document.cookie.length
        return unescape(document.cookie.substring(c_start,c_end))
        } 
    }
    return "";
}
var countdown;
function settime(obj){
    countdown=getCookie('ph_code_sceond_down');
    if (countdown == 0) { 
        obj.removeAttr("disabled");
        obj.css('color', '#4287EC');
        obj.css('cursor', 'pointer');
        obj.html("重新发送");
        return;
    } else { 
        obj.attr("disabled", true);
        obj.css('color', '#999999');
        obj.css('cursor', 'default');
        obj.html("重新发送(" + countdown + ")");
        countdown--;
        setCookie('ph_code_sceond_down', countdown, countdown+1);
    } 
    setTimeout(function(){settime(obj)}, 1000);
}
//校验手机号是否合法
function isPhoneNum(num){
    var phonenum = num;
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
    if(!myreg.test(phonenum)){ 
        return false; 
    }else{
        return true;
    }
} 
function sendCode(){
    var objtip = $(".error-box");
    var telNum = $('#phoneNum').val();
    var code = $('#code').val();
    if($.trim(telNum) == ''){
        
        objtip.show();
        objtip.html('手机号不能为空');
    } else if(!isPhoneNum(telNum)){
        
        objtip.show();
        objtip.html('请输入有效的手机号码！');
    } else if($.trim(code) == ''){
        
        objtip.show();
        objtip.html('验证码不能为空');
    } else {
       
	    $.post('/user/Publics/telsignin', 'telNum='+telNum+'&code='+code, function(result){
	        if (result.code ==1) {
	            setCookie('ph_code_sceond_down', 0, 1);
	            objtip.html('');
	            objtip.css('color', 'blue');
	            objtip.show();
	            objtip.html("登陆成功 正在跳转...");
	            window.location.href = result.url;
	        } else {
                objtip.show();
	            objtip.html(result.msg);
	        }
	    });
    }
}
function btnClick() {
    objtip = $(".error-box");
    if ($.trim($("#UserName").val()) == "输入账号" || $.trim($("#UserName").val()) == "") {
        objtip.show();
        objtip.html("账号不能为空！");
        return false;
    } else if ($.trim($("#Password").val()) == "") {
        objtip.show();
        objtip.html("密码不能为空！");
        return false;
    } else if ($.trim($("#yzm").val()) == "输入验证码" || $.trim($("#yzm").val()) == "") {
        objtip.show();
        objtip.html("请输入验证码！");
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: "/user/Publics/signin",
            async: true,
            data: { UserName: $("#UserName").val(), Password: $("#Password").val(), code: $("#yzm").val() },
            dataType: "json",
            success: function (result) {
                console.log(result);
                if (result.code ==1) {
                        objtip.html('');
			            objtip.css('color', 'blue');
			            objtip.show();
			            objtip.html("登陆成功 正在跳转...");
                        window.location.href = result.url;

                } else {
                    objtip.show();
                    objtip.html(result.msg);
                    $('#ImageCheck').attr('src','/captcha.html?d='+Math.random());//地址是否改变？
                }
            },
            failure: function (result) {
                objtip.show();
                objtip.html(result.msg);
            },
            error: function (e) {
            },
            completed: function (xhr) {
                alert(xhr);
            }
        });
    }
}

