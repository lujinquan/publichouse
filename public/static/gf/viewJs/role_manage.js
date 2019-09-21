// 角色增加
$("#addRole").click(function(){
	layer.open({
		type:1,
		area:['400px','350px'],
		resize:false,
		zIndex:100,
		title:['新增角色','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#RoleForm'),
		btn:['确定','取消'],
		yes:function(thisIndex){
			var data = $('#RoleForm').serializeArray();
			console.log(data);
			$.post('/ph/RoleManage/add',data,function(result){
				result = JSON.parse(result);
				if(result.retcode == 2000){
					layer.msg(result.msg,{time:4000});
					layer.close(thisIndex);
					location.reload();
				}else{
					layer.msg(result.msg,{time:4000});
				}
			});
		}
	});
});

/*修改角色*/
$("#reviseRole").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var RoleID = obj.eq(i).val();
		}
	}
	console.log(RoleID);
		if(RoleID == undefined){
			layer.msg('请先选择要修改的信息',{time:4000});
		}else{
			$.get('/ph/RoleManage/edit/id/'+RoleID,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#id").prop("value",res.data.id);          //房屋编号
				$("#RoleName").prop("value",res.data.RoleName);          //租户id

				$("input[name='Status'][value='"+res.data.Status+"']").prop("checked","checked");   //租户状态
				$("input[name='Ifstation'][value='"+res.data.Ifstation+"']").prop("checked","checked");   //租户性别

				layer.open({
					type:1,
					area:['400px','350px'],
					resize:false,
					zIndex:100,
					title:['修改角色','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#RoleModifyForm'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = $('#RoleModifyForm').serializeArray();
						console.log(data);
						$.post('/ph/RoleManage/edit',data,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode == 2000){
								layer.msg(result.msg,{time:4000});
								layer.close(thisIndex);
								location.reload();
							}else{
								layer.msg(result.msg,{time:4000});
							}
						});
					}
				});
			})
		}
});

/*删除角色信息*/
$("#deleteRole").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var RoleID = obj.eq(i).val();
		}
	}
	if(RoleID == undefined){
		layer.msg('请先选择要修改的信息',{time:4000});
	}else{
		layer.confirm('确定删除角色信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){

					$.get('/ph/RoleManage/delete/id/'+RoleID,function(result){
						result = JSON.parse(result);
						if(result.retcode  == '2000' ){
							layer.msg(result.msg,{time:4000});
							location.reload();
						}else{
							layer.msg(result.msg,{time:4000});
						}
					});

			layer.close(index);
		});
	}
});

/*权限分配*/
$("#permission").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var RoleID = obj.eq(i).val();
		}
	}
	if(RoleID == undefined){
		layer.msg('请先选择角色',{time:4000});
	}else{
		$.get('/ph/RoleManage/roleToMenu/id/'+RoleID,function(res){
			res = JSON.parse(res);
			console.log(res);

			$("input[name='id[]']").prop("checked",false);
			$(".FatherName").prop("checked",false);
			$("#Role").prop("value",res.data['Role']);
			var len = res.data.menu.length;
			for(i=0; i<len; i++){
				$("input[name='id[]'][value='"+res.data['menu'][i]+"']").prop("checked","checked");   //选中原子权限菜单
			}
			layer.open({
				type:1,
				area:['600px','600px'],
				resize:false,
				zIndex:100,
				title:['分配权限','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#permissionForm'),
				btn:['确定','取消'],
				yes:function(thisIndex){
					var data = $('#permissionForm').serializeArray();
					console.log(data);
					$.post('/ph/RoleManage/roleToMenu',data,function(result){
						result = JSON.parse(result);
						console.log(result);
						if(result.retcode == 2000){
							// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
							// 	layer.close(thisIndex);
							// 	layer.close(conIndex);
							// });
							layer.msg(result.msg,{time:4000});
							layer.close(thisIndex);
						}else{
							// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
							// 	layer.close(conIndex);
							// });
							layer.msg(result.msg,{time:4000});
						}
					});
				}
			});
		})
	}
});

//全选和单选的样式
$('.FatherName').click(function(){
	var father_flag = false;
	var FatherCheck = $(this).prop("checked");
	var thisFatherDom = $(this).parents('.second_level').siblings().andSelf().find('h3 input');
	var ChildDom = $(this).parent().siblings('ul').children('li');
	var fatherDom = $(this).parents('.am-collapse').siblings('div').find('input');
	if(FatherCheck == true){
		ChildDom.find("input").prop("checked",true);
		fatherDom.prop("checked",true);
	}else{
		ChildDom.find("input").prop("checked",false);
		for(var j = 0;j < thisFatherDom.length;j++){
			console.log(thisFatherDom.eq(j).prop("checked"));
			if(thisFatherDom.eq(j).prop("checked") == true){
				father_flag = true;
				break;
			}
		}
		if(father_flag == false){
			fatherDom.prop("checked",false);
		}
	}
});
$(".li_style input").click(function(){
	var ChildCheck = $(this).prop("checked");
	var BrotherDom = $(this).parent('li').siblings().andSelf();
	var FatherDom = $(this).parents('ul').siblings('h3').children('input');
	var gradFatherDom = $(this).parents('.am-collapse').siblings('div').find('input');
	var thisFatherDom = $(this).parents('.second_level').siblings().andSelf().find('h3 input');
	var flag = false;
	var father_flag = false;
	if(ChildCheck == true){
		FatherDom.prop("checked",true);
		gradFatherDom.prop("checked",true);
	}else{
		for(var i = 0; i < BrotherDom.length;i++){
			console.log(BrotherDom.eq(i).children('input').prop("checked"));
			if(BrotherDom.eq(i).children('input').prop("checked") == true){
				flag = true;
				break;
			}
		}
		if(flag == false){
			FatherDom.prop("checked",false);
		}
		console.log(thisFatherDom.length);
		for(var j = 0;j < thisFatherDom.length;j++){
			console.log(thisFatherDom.eq(j).prop("checked"));
			if(thisFatherDom.eq(j).prop("checked") == true){
				father_flag = true;
				break;
			}
		}
		if(father_flag == false){
			gradFatherDom.prop("checked",false);
		}
	} 
});