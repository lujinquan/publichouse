
//机构信息新增
$("#addOrg").click(function(){
		layer.open({
			type:1,
			area:['450px','350px'],
			resize:false,
			zIndex:100,
			title:['新增机构','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#OrgForm'),
			btn:['确定','取消'],
			yes:function(thisIndex){
				var data = $('#OrgForm').serializeArray();
				$.post('/ph/OrgManage/add',data,function(result){
					result = JSON.parse(result);
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg,{time:4000});
						layer.close(thisIndex);
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
$("#reviseOrg").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var OrgID = obj.eq(i).val();
		}
	}
	console.log(OrgID);
	//var vanId = $('.checkId').eq(0).val();
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		if(OrgID == undefined){
			layer.msg('请先选择要修改的信息',{time:4000});
		}else{
			$.get('/ph/OrgManage/edit/id/'+OrgID,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#Institution").prop("value",res.data.Institution);          //机构名称
				$("#id").prop("value",res.data.id);
				$("select[id='pid'] option[value='"+res.data.pid+"']").prop("selected","selected");   //所属机构
				$("input[name='Status'][value='"+res.data.Status+"']").prop("checked","checked");   //是否有效
				layer.open({
					type:1,
					area:['450px','350px'],
					resize:false,
					zIndex:100,
					title:['修改机构','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#OrgModifyForm'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = $('#OrgModifyForm').serializeArray();
						console.log(data);
						$.post('/ph/OrgManage/edit',data,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode == 2000){
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(thisIndex);
								// 	layer.close(conIndex);
								// 	location.reload();
								// });
								layer.msg(result.msg,{time:4000});
								layer.close(thisIndex);
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
			});
		}
	// });
});

/*删除租户信息*/
$("#deleteOrg").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var OrgID = obj.eq(i).val();
		}
	}
	if(OrgID == undefined){
		layer.msg('请先选择要修改的信息',{time:4000});
	}else{
		layer.confirm('确定删除机构信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){

					$.get('/ph/OrgManage/delete/id/'+ OrgID,function(result){
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