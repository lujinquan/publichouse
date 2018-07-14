$(".conf-class").click(function(){
	var id = $(this).attr("id");
	$("#conf-class-id").text(id);
	var data = "id="+id;
	// alert(data);
	$.post("/ph/ParameterSet/index", data, function(res){
		if(res !== null){
			res = JSON.parse(res);
			console.log(res);
			$("#field").empty();
			$("#tb").empty();
			for (var i = res.data.field.length-1; i >= 0; i--) {
				$("#field").prepend('<td>' + res.data.field[i] +'</td>');
			}
			$("#field").append('<td>操作</td>');
			var len = res.data.field.length;
			var tb = res.data.data;
			for (var i = 0; i < tb.length; i++) {
				var buffer = '';
				buffer += '<tr>';
				for (var j = 0; j < len; j++) {
					buffer += '<td>';
					buffer += eval("(" + "tb[i].field" + j + ")");
					buffer += '</td>';
				}
				buffer += '<td width="20%">' + 
						  '<div class="am-btn-group am-btn-group-xs am-u-md-offset-4">' + 
						  '<button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button>' +
						  '<button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button>' +
						  '</div>' +
						  '</td>';
				buffer += '</tr>';
				$("#tb").append(buffer);
			}
			var oT = $('<tr></tr>');
			$('#tb').append(oT);
			console.log(oT);
			for (var i = 0; i < len; i++) {
				 oT.append('<td style="border-left:1px solid #ddd;"></td>');
			}
			oT.append('<td width="20%"><div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-add am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">增加</button></div></td>');
		}
	});
});


$("table").on('click', '.conf-modify', function(){
	
	var contentDom = $(this).parent('div').parent('td').prev();
	var confContent = $(this).parent('div').parent('td').prev().text();
	var confId = $(this).parent('div').parent('td').prev().prev().text();
	var classId = $("#conf-class-id").text();
	
	$("#modify-content").val(confContent);
	$("#modify-id").text(confId);
	switch(classId){
		case '1':var title = '楼栋结构配置';break;
		case '2':var title = '楼栋产别配置';break;
		case '3':var title = '楼栋完损等级配置';break;
		case '4':var title = '使用性质配置';break;
		default:var title = '';break;
	}
	layer.open({
		type:1,
		area:['400px','400px'],
		resize:false,
		zIndex:100,
		title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$("#conf-modify"),
		success:function(){

		},
		yes:function(thisIndex){
			var modify_content = $("#modify-content").val();
			var data = 'classId='+classId+'&confId='+confId+'&confContent='+modify_content;
			$.post('/ph/ParameterSet/modify', data, function(res){
				res = JSON.parse(res);
				console.log(res);
				if (res.retcode == '2000') {
					contentDom.text($("#modify-content").val());
					layer.close(thisIndex);
				}else{
					layer.msg(res.msg);
				}
			})
		}
	})
});

$("table").on('click', '.conf-add', function(){
	var classId = $("#conf-class-id").text();
	// var modify_content_add = $("#modify-content-add").val();
	// alert(classId);
	var o_this=$(this);
//$('.aBut button')
	switch(classId){
		case '1':var title = '楼栋结构配置';break;
		case '2':var title = '楼栋产别配置';break;
		case '3':var title = '楼栋完损等级配置';break;
		case '4':var title = '使用性质配置';break;
		default:var title = '';break;
	}
	layer.open({
		type:1,
		area:['400px','400px'],
		resize:false,
		zIndex:100,
		title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$("#conf-modify-add"),
		success:function(){
			
		},
		yes:function(thisIndex){
			var modify_add_content = $("#modify-content-add").val();
			var data = 'classId='+classId+'&confContent='+modify_add_content;
			$.post('/ph/ParameterSet/add', data, function(res){
				res = JSON.parse(res);
				console.log(res);
				
				if (res.retcode == '2000') {
//					layer.close(thisIndex);
//					window.location.reload();
				var num =$("#tb tr").length-2;
				var add_value = $('#modify-content-add').prop('value');
				$("#tb tr").eq(num).after('<tr><td>'+res.data+'</td><td>'+add_value+'</td><td>'+'<div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button><button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button></div>'+'</td></tr>');
				layer.close(thisIndex);
				add_value = $('#modify-content-add').prop('value','');

				}
			})
		}
	})
});

$("table").on('click', '.conf-delete', function(){
	var classId = $("#conf-class-id").text();
	var confId = $(this).parent('div').parent('td').prev().prev().text();
	var _this =$(this);
	var data = 'classId='+classId+'&confId='+confId;
	layer.alert('确认删除?',{icon:2,skin:'lan_class'},function(this_index){
		$.post('/ph/ParameterSet/delete', data, function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == '2000'){
			   layer.msg(res.msg,function(){
					_this.parent().parent().parent().remove();
				})
			}else{
				layer.msg(res.msg);
			}
			layer.close(this_index);
		})
	})
});
