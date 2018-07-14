$("#addPost").click(function(){
	layer.open({
		type:1,
		area:['450px','280px'],
		resize:false,
		zIndex:100,
		title:['新增职务','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#PostForm'),
		btn:['确认','取消'],
		yes:function(thisIndex){
			var data = $('#PostForm').serializeArray();
			console.log(data);
			$.post('/ph/PostManage/add',data,function(result){
				result = JSON.parse(result);
				if(result.retcode == 2000){
					layer.msg(result.msg);
					layer.close(thisIndex);
					location.reload();
				}else{
					// layer.msg(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
					// 	layer.close(conIndex);
					// });
					layer.msg(result.msg);
				}
			});
		}
	});
});

/*修改职务信息*/
$("#revisePost").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var PostID = obj.eq(i).val();
		}
	}
	console.log(PostID);

	if(PostID == undefined){
		layer.msg('请先选择要修改的信息');
	}else{
		$.get('/ph/PostManage/edit/PostID/'+PostID,function(res){
			res = JSON.parse(res);
			console.log(res);
			$("#PostI").attr("value",res.data.PostID);          //职务编号
			$("#PostNam").attr("value",res.data.PostName);          //职务名称
			$("input[name='Status'][value='"+res.data.Status+"']").attr("checked","checked");   //职务有效性
			layer.open({
				type:1,
				area:['450px','280px'],
				resize:false,
				zIndex:100,
				title:['修改职务','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#PostModifyForm'),
				btn:['确定','取消'],
				yes:function(thisIndex){
					var data = $('#PostModifyForm').serializeArray();
					console.log(data);
					$.post('/ph/PostManage/edit',data,function(result){
						result = JSON.parse(result);
						console.log(result);
						if(result.retcode == 2000){
							// layer.msg(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
							// 	layer.close(conIndex);
							// });
							layer.msg(result.msg);
							layer.close(thisIndex);
							location.reload();
						}else{
							// layer.msg(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
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

/*删除租户信息*/
$("#deletePost").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var PostID = obj.eq(i).val();
		}
	}
	if(PostID == undefined){
		layer.msg('请先选择要修改的信息');
	}else{
		layer.confirm('确定删除职务信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
			$.get('/ph/PostManage/delete/PostID/'+ PostID,function(result){
				result = JSON.parse(result);
				if(result.retcode  == '2000' ){
					layer.msg(result.msg);
					location.reload();
				}else{
					layer.msg(result.msg);
				}
			});
			layer.close(index);
		});
	}
});