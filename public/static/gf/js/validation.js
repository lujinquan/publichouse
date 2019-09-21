var Validation = {
  tel:function(data){
    if(!(/^1(3|4|5|7|8)\d{9}$/.test(data))){ 
        layer.msg("手机号码有误，请重填",{time:4000});
        return false; 
    }
  },
  bankCard:function(data){
    var regex = /^(998801|998802|622525|622526|435744|435745|483536|528020|526855|622156|622155|356869|531659|622157|627066|627067|627068|627069)\d{10}$/;  
    if (!(regex.test(data))) {  
        layer.msg('银行卡号有误！',{time:4000}); 
    }  
  },
  IDCard:function(data){
    var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
      if(!(reg.test(data))){  
          layer.msg("身份证输入不合法",{time:4000});  
      }
  },
  digit:function(data,number){
    console.log(number);
    var reg =new RegExp("^\\d{"+number+"}");
    if(!(reg.test(data))){
      layer.msg('位数错误！',{time:4000});
    }
  }
}