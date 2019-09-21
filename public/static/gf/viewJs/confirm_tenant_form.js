// require.config({
// 	baseUrl:"/public/static/gf/",
// 	paths:{
// 		"jquery":"js/jquery.min",
// 		"layer":"layer/layer"
// 	}
// });
/*租户信息*/
//租户信息新增
$("#addTenant").click(function(){
	
	$("#InputForm input[type='text']").val("");
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		var imgUp = $('#imgUp');
		var imgShow = $('#imgShow');
		readFile(imgUp,imgShow);
		layer.open({
			type:1,
			area:['800px','600px'],
			
			resize:false,
			zIndex:100,
			title:['添加租户','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TenantForm'),
			btn:['确定','取消'],
			yes:function(thisIndex){
				var data = new FormData($('#TenantForm')[0]);
				console.log(data);
				$.ajax({
					url:"/ph/ConfirmTenantInfo/add",
					type:"post",
					data:data,
					dataType:'JSON',
					processData: false,
					contentType: false
				}).done(function(result){
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.close(thisIndex);
						layer.msg(result.msg,{time:4000});
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg(result.msg,{time:4000});
					}
				});
			}
		});
	// })
});

/*修改租户信息*/
$("#reviseTenant").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var TenantID = obj.eq(i).val();
		}
	}
	console.log(TenantID);
	//var vanId = $('.checkId').eq(0).val();
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		if(TenantID == undefined){
			layer.msg('请先选择要修改的信息',{time:4000});
		}else{
			$.get('/ph/ConfirmTenantInfo/edit/TenantID/'+TenantID,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#TenantI").prop("value",res.data.TenantID);          //租户id
				$("#TenantTe").prop("value",res.data.TenantTel);          //联系电话
				$('#TenantAg').prop("value",res.data.TenantAge);     //年龄
				$('#TenantWeCha').prop("value",res.data.TenantWeChat);        //微信号
				$('#TenantNumbe').prop("value",res.data.TenantNumber);        //身份证号码
				$('#BanI').prop("value",res.data.BankID);                //银行卡号
				$('#ArrearRen').prop("value",res.data.ArrearRent);        //欠租情况
				$('#TenantNam').prop("value",res.data.TenantName);    //租户姓名
				$('#TenantBalanc').prop("value",res.data.TenantBalance);    //余额
				$('#TenantQ').prop("value",res.data.TenantQQ);    //租户QQ
				$('#BanNam').prop("value",res.data.BankName);    //银行名称
				$('#TenantValu').prop("value",res.data.TenantValue);    //租户诚信值
				$("input[name='TenantSex'][value='"+res.data.TenantSex+"']").attr("checked","checked");   //租户性别
				//影像上传修改
				var imgReload = $('#imgReload');
				var imgChange = $('#imgChange');
				readFile(imgReload,imgChange);
				layer.open({
					type:1,
					area:['800px','600px'],
					resize:false,
					zIndex:100,
					title:['修改租户','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#tenantModifyForm'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = new FormData($('#tenantModifyForm')[0]);
						console.log(data);
						$.ajax({
							url:"/ph/ConfirmTenantInfo/edit",
							type:"post",
							data:data,
							dataType:'JSON',
							processData: false,
							contentType: false
						}).done(function(result){
							
							console.log(1);
							if(result.retcode == 2000){
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(thisIndex);
								// 	layer.close(conIndex);
								// 	location.reload();
								// });
								
								layer.close(thisIndex);
								layer.msg(result.msg,{time:4000});
								location.reload();
							}else{
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(conIndex);
								// });
								//layer.close(thisIndex);
								layer.msg(result.msg,{time:4000});
							}
						});
					}
				});
			})
		}
	// })
});

/*删除租户信息*/
$("#deleteTenant").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var TenantID = obj.eq(i).val();
		}
	}
	if(TenantID == undefined){
		layer.msg('请先选择要修改的信息',{time:4000});
	}else{
		layer.open({
			type:1,
			area:['600px','130px'],
			title:['删除租户','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#deleteChoose'),
			// btn:['确定','取消'],
			// yes:function(thisIndex){
			// 	var oChecked='';
			// 		if($('input[name=infoDeleteType]:checked').val()==undefined){
			// 			oChecked='';
						
			// 		}else{
			// 			oChecked=$('input[name=infoDeleteType]:checked').val();
			// 		}
			// 	layer.confirm('确定删除租户信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
			// 		$.get('/ph/ConfirmTenantInfo/delete/TenantID/'+TenantID+'/style/'+oChecked,function(result){
			// 			result = JSON.parse(result);
			// 			if(result.retcode  == '2000' ){
			// 				layer.msg('删除成功');
			// 				location.reload();
			// 			}else{
			// 					layer.msg(result.msg);
			// 				}
			// 		});
			// 		layer.close(index);
			// 		layer.close(thisIndex);
			// 	});
			// }
		})
	}
});
$('#HouseChange,#HouseRemove,#DateTogther,#DateLose').click(function(){
		var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var TenantID = obj.eq(i).val();
		}
	}
	var oV= $(this).val();
	layer.confirm('确定租户删除信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
						$.get('/ph/ConfirmTenantInfo/delete/TenantID/'+TenantID+'/style/'+oV,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode  == '2000' ){
								layer.msg(result.msg,{time:4000});
								location.reload();
							}else{
								layer.msg(result.msg,{time:4000});
							}
						})
					})
})
$(".ConfirmTenantBtn").click(function(){

	var tenantID = $(this).val();

	layer.confirm('请确认此租户信息无误',{title:'提示信息',icon:'1',skin:'lan_class'},function(index){
		$.get('/ph/ConfirmTenantInfo/confirm/TenantID/'+tenantID,function(result){
			result = JSON.parse(result);
			console.log(result);
			if(result.retcode  == '2000' ){
				layer.msg(result.msg,{time:4000});
				location.reload();
			}else{
				layer.msg(result.msg,{time:4000});
			}
		});
	});

});

//租户信息查看明细
$(".TenantDetailBtn").click(function(){
	var TenantID = $(this).val();
	console.log(TenantID);
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/'
	// 	});
		$.get('/ph/TenantInfo/detail/TenantID/'+TenantID,function(res){
			res = JSON.parse(res);
			console.log(res);
			$('#TenantID').text(res.data.TenantID); //租户id
			$('#TenantName').text(res.data.TenantName); //租户名称
			$('#TenantTel').text(res.data.TenantTel); //租户电话
			$('#TenantAge').text(res.data.TenantAge); //年龄
			$('#TenantSex').text(res.data.TenantSex); //性别
			$('#TenantBalance').text(res.data.TenantBalance); //余额
			$('#ArrearRent').text(res.data.ArrearRent); //欠租情况
			$('#TenantNumber').text(res.data.TenantNumber); //身份证号码
			$('#BankName').text(res.data.BankName); //银行名称
			// console.log($('#BanName'));
			$('#BankID').text(res.data.BankID); //银行卡号
			$('#TenantQQ').text(res.data.TenantQQ);  //QQ号
			$('#TenantWeChat').text(res.data.TenantWeChat);  //微信号
			$('#TenantValue').text(res.data.TenantValue); //诚信值
			$('#CreateTime').text(res.data.CreateTime); //登记时间
			$('#CreateUserID').text(res.data.CreateUserID); //登记人名称
			$('#UpdateTime').text(res.data.UpdateTime); //最后更新时间
			$('#InstitutionName').text(res.data.InstitutionName); //登记机构
			
			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				title:['租户明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#TenantDetail')
			});
		})
	// })
});

var startDate = new Date(1991, 11, 17);
var endDate = new Date(2100, 11, 27);
$('#timeStart').datepicker().
  on('changeDate.datepicker.amui', function(event) {
    if (event.date.valueOf() > endDate.valueOf()) {
		// require(["layer","jquery"],function(){
		// 	layer.config({
		// 		path:'/public/static/gf/layer/'
		// 	});
			layer.msg('时间选择错误！',{time:4000});
		// });
    } else {
      startDate = new Date(event.date);
    }
   // $(this).datepicker('close');
  });

$('#timeEnd').datepicker().
  on('changeDate.datepicker.amui', function(event) {
    if (event.date.valueOf() < startDate.valueOf()) {
		// require(["layer","jquery"],function(){
		// 	layer.config({
		// 		path:'/public/static/gf/layer/'
		// 	});
			layer.msg('时间选择错误！',{time:4000});
		// });
    } else {
      endDate = new Date(event.date);
    }
    //$(this).datepicker('close');
  });

function readFile(fileUp,fileShow){
	if(typeof FileReader === 'undefined'){
		fileShow.text('浏览器不支持！');
	}else{
		fileUp.on('change',function(){
			var file = this.files[0];
			if(!/image\/\w+/.test(file.type)){
				layer.msg('文件必须是图片！',{time:4000});
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(){
				fileShow.attr('src',this.result);
			}
		})
	}
}
//电话、身份证、银行卡验证
// $('#doc-vld-email-3,#TenantTe').blur(function(){
// 	Validation.tel($(this).val());
// });
// $('#IDCard,#TenantNumber').blur(function(){
// 	Validation.IDCard($(this).val());
// });
// $('#doc-vld-email-5,#BanI').blur(function(){
// 	Validation.bankCard($(this).val());
// });