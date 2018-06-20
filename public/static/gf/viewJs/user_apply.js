require.config({
	baseUrl:"/public/static/gf/",
	paths:{
		"jquery":"js/jquery.min",
		"layer":"layer/layer"
	}
});
//新增更名
$("#addRename").click(function(){
	require(["layer","jquery"],function(layer){
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['更名申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#RenameForm'),
			btn:['确认','取消'],
			yes:function(thisIndex){
				var ID = $('.tenantID').eq(0).text();
				var Name = $('.tenantName').text();
				var newName = $('#newName').val();
				var Houseid = $('#getInfo_1').val();
				$.post('/ph/UserApply/add',{type:1,houseid:Houseid,tenantid:ID,oldName:Name,newName:newName},function(result){
					result = JSON.parse(result);
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg);
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg(result.msg);
					}
				});
			}
		});
	})
});
//新增过户
$("#addTransferName").click(function(){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['过户申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				console.log(newName);
				$.post('/ph/UserApply/add',{type:2,houseid:ID,oldID:oldID,oldName:oldName,newID:newID,newName:newName},function(result){
					result = JSON.parse(result);
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisInde);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg);
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg(result.msg);
					}
				});
			}
		});
	})
});
//新增赠与
$("#addGift").click(function(){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['转增亲友申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				$.post('/ph/UserApply/add',{
					type:3,
					houseid:ID,
					oldID:oldID,
					oldName:oldName,
					newID:newID,
					newName:newName
				},function(result){
					result = JSON.parse(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg);
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg(result.msg);
					}
				});
			}
		});
	})
});
//新增转让
$("#addTransfer").click(function(){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['新增转让','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			success:function(){
				$('.label_p_style').text('');
				$('.label_input').val('');
			},
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				var IfReform = $("input[type=radio][name=IfReform]:checked").val();
				var IfRepair = $("input[type=radio][name=IfRepair]:checked").val();
				var IfCollection = $("input[type=radio][name=IfCollection]:checked").val();
				var IfFacade = $("input[type=radio][name=IfFacade]:checked").val();
				var transferWay = $("#transferWay").val();
				var transferMoney = $("#transferMoney").val();
				$.post('/ph/UserApply/add',
					{
						type:4,houseid:ID,
						oldID:oldID,
						oldName:oldName,
						newID:newID,
						newName:newName,
						transferType:transferWay,
						transferRent:transferMoney,
						IfReform:IfReform,
						IfRepair:IfRepair,
						IfCollection:IfCollection,
						IfFacade:IfFacade
					},function(result){
					result = JSON.parse(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg);
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg(result.msg);
					}
				});
			}
		});
	})
});
//申请修改
$('.BtnChange').click(function(){
	var ID = $(this).val();
		console.log(ID);
	$.get('/ph/UserApply/edit/ChangeOrderID/'+ID,function(res){
		res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "4005"){
				layer.msg(res.msg);
			}else{
				if(res.data.ChangeType == 1){
					revise_1(res,ID);
				}else{
					revise_2(res,ID);
				}
			}
	})
});
//申请删除
$('.BtnDel').click(function(){
	var ID = $(this).val();
	require(["layer","jquery"],function(layer){
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.confirm('确认删除？',{title:'提示信息',icon:'2',skin:'lan_class'},function(conIndex){
			$.get('/ph/UserApply/delete/ChangeOrderID/'+ID,function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.msg(res.msg);
				layer.close(conIndex);
				location.reload();
			});
		});
	});
});
//房屋编号输入
$('#queryAction').click(function(){
	var ID = $('#getInfo_1').val();
	$.get('/ph/Api/get_house_tenant/HouseID/'+ ID,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			$('.tenantID').text(res.data.TenantID);
			$('.tenantTel').text(res.data.TenantTel);
			$('.tenantName').text(res.data.TenantName);
		}else{
			layer.msg(res.msg);
		}
	});
});
//房屋编号插件
houseQuery.action("getInfo_1","1");
houseQuery.action("HouseIdInput","1");
tenantQuery.action('IdIput','','0,1',
	function(){
		var ID = $('#IdIput').val();
		$.get('/ph/Api/get_tenant_info/TenantID/'+ ID,function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == '2000'){
				//$('#newTel').text(res.data.TenantTel);
				$('#newNam').text(res.data.TenantName);
			}else{
				layer.msg(res.msg);
			}
			
		});
	}
);

//旧ID输入
$('#queryAction_1').click(function(){
	var ID = $('#HouseIdInput').val();
	$.get('/ph/Api/get_house_tenant/HouseID/'+ ID,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			$('#oldID').text(res.data.TenantID);
			$('#oldName').text(res.data.TenantName);
			//$('#oldTel').text(res.data.TenantTel);
		}else{
			layer.msg(res.msg);
		}
	});
});
//新租户ID输入
// $('#IdIput').blur(function(){
// 	var ID = $('#IdIput').val();
// 	$.get('/ph/Api/get_tenant_info/TenantID/'+ ID,function(res){
// 		res = JSON.parse(res);
// 		if(res.retcode == '2000'){
// 			$('#newTel').text(res.data.TenantTel);
// 			$('#newNam').text(res.data.TenantName);
// 		}else{
// 			layer.msg(res.msg);
// 		}
		
// 	});
// });
function revise_1(res,id){
	require(["layer","jquery"],function(layer){
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['更名申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#RenameForm'),
			btn:['确认','取消'],
			success:function(){
				$('#getInfo_1').val(res.data.HouseID);
				$('.tenantID').text(res.data.OldTenantID);
				$('.tenantName').text(res.data.OldTenantName);
				$('#newName').val(res.data.NewTenantName);
				$('#newTel').val(res.data.TenantTel);
				$('#newTel1').val(res.data.OldTenantTel);
				$('#oldTel1').val(res.data.OldTenantTel);
			},
			yes:function(thisIndex){
				var ID = $('.tenantID').eq(0).text();
				var Name = $('.tenantName').text();
				var newName = $('#newName').val();
				var Houseid = $('#getInfo_1').val();
				
				$.post('/ph/UserApply/edit',{ChangeOrderID:id,HouseID:Houseid,OldTenantID:ID,OldTenantName:Name,NewTenantName:newName},function(result){
					result = JSON.parse(result);
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm('修改成功',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg('修改成功！');
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm('修改失败',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg('修改失败');
					}
				});
			}
		});
	})
}
function revise_2(res,id){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['990px','700px'],
			resize:false,
			zIndex:100,
			title:['过户申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			success:function(){
				$('#HouseIdInput').val(res.data.HouseID);//房屋ID
				$('#oldID').text(res.data.OldTenantID);
				$('#oldName').text(res.data.OldTenantName);
				$('#IdIput').val(res.data.NewTenantID);
				$('#newNam').text(res.data.NewTenantName);
				$('#newTel').val(res.data.TenantTel);
				$('#newTel1').val(res.data.NewTenantTel);
				$('#oldTel1').val(res.data.OldTenantTel);
				$('#transferWay option[value='+res.data.TransferType+']').attr('selected','selected');
				$('#transferMoney').val(res.data.TransferRent);
				$("input[name='IfReform'][value="+res.data.IfReform+"]").attr('checked','checked');
				$("input[name='IfRepair'][value="+res.data.IfRepair+"]").attr('checked','checked');
				$("input[name='IfCollection'][value="+res.data.IfCollection+"]").attr('checked','checked');
				$("input[name='IfFacade'][value="+res.data.IfFacade+"]").attr('checked','checked');
			},
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				var IfReform = $("input[type=radio][name=IfReform]:checked").val();
				var IfRepair = $("input[type=radio][name=IfRepair]:checked").val();
				var IfCollection = $("input[type=radio][name=IfCollection]:checked").val();
				var IfFacade = $("input[type=radio][name=IfFacade]:checked").val();
				var transferWay = $("#transferWay").val();
				var transferMoney = $("#transferMoney").val();
				$.post('/ph/UserApply/edit',{
					ChangeOrderID:id,
					HouseID:ID,
					OldTenantID:oldID,
					OldTenantName:oldName,
					NewTenantID:newID,
					NewTenantName:newName,
					TransferType:transferWay,
					TransferRent:transferMoney,
					IfReform:IfReform,
					IfRepair:IfRepair,
					IfCollection:IfCollection,
					IfFacade:IfFacade
				},function(result){
					result = JSON.parse(result);
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm('修改成功',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisInde);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg('修改成功！');
						layer.close(thisIndex);
						location.reload();
					}else{
						// layer.confirm('修改失败',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// });
						layer.msg('修改失败！');
					}
				});
			}
		});
	});
}