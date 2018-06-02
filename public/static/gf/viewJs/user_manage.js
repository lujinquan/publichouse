
//新增用户信息
$("#addUser").click(function(){

		layer.open({
			type:1,
			area:['600px','600px'],
			resize:false,
			zIndex:100,
			title:['新增用户','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#UserForm'),
			btn:['确认','取消'],
			yes:function(thisIndex){
				var data = $('#UserForm').serializeArray();
				console.log(data);
				$.post('/ph/UserManage/add',data,function(result){
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

});

//修改用户信息
$("#reviseUser").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var ID = obj.eq(i).val();
		}
	}

	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		if(ID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{
			$.get('/ph/UserManage/edit/id/'+ID,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#Number").prop("value",res.data.Number);          //用户编号
				$("#UserName").prop("value",res.data.UserName);          //登录账号
				$("#RealName").prop("value",res.data.RealName);          //真实姓名
				$('#Tel').prop("value",res.data.Tel);        //联系方式
				$('#TenantAge').prop("value",res.data.TenantAge);     //年龄

				$("select[id='InstitutionID'] option[value='"+res.data.InstitutionID+"']").prop("selected","selected");   //所属机构
				$("select[id='PostID'] option[value='"+res.data.PostID+"']").prop("selected","selected");  //职务
				$("input[name='Sex'][value='"+res.data.Sex+"']").prop("checked","checked");   //用户性别
				$("input[name='CateID'][value='"+res.data.CateID+"']").prop("checked","checked");   //用户类型
				$("input[name='Status'][value='"+res.data.Status+"']").prop("checked","checked");   //是否有效

				layer.open({
					type:1,
					area:['600px','600px'],
					resize:false,
					zIndex:100,
					title:['修改用户','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#UserModifyForm'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = $('#UserModifyForm').serializeArray();
						console.log(data);
						$.post('/ph/UserManage/edit',data,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode == 2000){
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(thisIndex);
								// 	layer.close(conIndex);
								// 	location.reload();
								// });
								layer.close(thisIndex);
								layer.msg(result.msg);
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
			});
		}
	// });
});

//删除用户
$("#deleteUser").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var ID = obj.eq(i).val();
		}
	}
	if(ID == undefined){
		layer.msg('请先选择要修改的信息');
	}else{
		layer.confirm('确定删除用户信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){

					$.get('/ph/UserManage/delete/id/'+ ID,function(result){
						result = JSON.parse(result);
						if(result.retcode  == '2000' ){
							// layer.confirm('删除成功',function(index_2){
							// 	layer.close(index_2);
							// 	location.reload();
							// });
							layer.msg('删除成功!');
							location.reload();
						}
					});

			layer.close(index);
		});
	}
	// })
});

//分配角色
$("#assignRole").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var ID = obj.eq(i).val();
		}
	}
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		if(ID == undefined){
			layer.msg('请先选择用户');
		}else{
			$.get('/ph/UserManage/userToRole/id/'+ID,function(res){
				res = JSON.parse(res);
				console.log(res);
				//$("#Number").attr("value",res.data.Number);          //用户编号
				$("#id").prop("value",res.data.id);          //用户编号
				//$("select[id='InstitutionID'] option[value='"+res.data.InstitutionID+"']").attr("selected","selected");   //所属机构
				// $("select[id='PostID'] option[value='"+res.data.PostID+"']").attr("selected","selected");  //职务
				var len = res.data.Role.length;
				console.log(len);
				$("input[name='Role[]']").prop("checked",false);
				for(var i=0; i<len; i++){
					console.log(res.data.Role[0]);
					$("input[value="+res.data.Role[i]+"]").prop("checked",true);   //用户性别
				}
				// $("input[name='UserType'][value='"+res.data.UserType+"']").attr("checked","checked");   //用户类型
				// $("input[name='Status'][value='"+res.data.Status+"']").attr("checked","checked");   //是否有效
				layer.open({
					type:1,
					area:['600px','600px'],
					resize:false,
					zIndex:100,
					title:['分配角色','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#UserAssign'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = $('#UserAssign').serializeArray();
						console.log(data);
						$.post('/ph/UserManage/userToRole',data,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode == 2000){
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(thisIndex);
								// 	layer.close(conIndex);
								// });
								layer.msg(result.msg);
								layer.close(thisIndex);
							}else{
								// layer.confirm(result.msg,{title:'提示信息',icon:'2',skin:'lan_class'},function(conIndex){
								// 	layer.close(conIndex);
								// });
								layer.msg(result.msg);
							}
						});
					},
					cancel:function(){
						
					}
				});
			});
		}
	// });
});