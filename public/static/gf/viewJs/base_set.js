$(".conf-class").click(function(){
	var id = $(this).attr("id");
	$("#conf-class-id").text(id);
	if(id != '4'){
		var data = "id="+id;
		// alert(data);
		$.post("/ph/BaseSet/index", data, function(res){
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
	} else {
		var data = "id="+id;

		$.post('/ph/BaseSet/index', data, function(res){
			res = JSON.parse(res);
			console.log(res);
		
			var point = res.data;
			var filed_content ='<td width="20%">居住层次/楼房层数</td><td>四</td><td>五</td><td>六</td><td>七</td><td>八</td><td>九层及以上顶层</td>';
			var tb_content = 
				'<tr>'+
				'<td>一</td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-4-1" value="'+ point[4][1] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-5-1" value="'+ point[5][1] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-6-1" value="'+ point[6][1] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-1" value="'+ point[7][1] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-1" value="'+ point[8][1] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-1" value="'+ point[9][1] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>二</td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-4-2" value="'+ point[4][2] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-5-2" value="'+ point[5][2] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-6-2" value="'+ point[6][2] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-2" value="'+ point[7][2] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-2" value="'+ point[8][2] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-2" value="'+ point[9][2] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>三</td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-4-3" value="'+ point[4][3] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-5-3" value="'+ point[5][3] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-6-3" value="'+ point[6][3] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-3" value="'+ point[7][3] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-3" value="'+ point[8][3] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-3" value="'+ point[9][3] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>四</td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-4-4" value="'+ point[4][4] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-5-4" value="'+ point[5][4] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-6-4" value="'+ point[6][4] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-4" value="'+ point[7][4] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-4" value="'+ point[8][4] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-4" value="'+ point[9][4] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>五</td>'+
				'<td></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-5-5" value="'+ point[5][5] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-6-5" value="'+ point[6][5] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-5" value="'+ point[7][5] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-5" value="'+ point[8][5] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-5" value="'+ point[9][5] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>六</td>'+
				'<td></td>'+
				'<td></td>'+
				'<td><input class="floor_point" disabled="true" class="floor_point" type="text" name="t-6-6" value="'+ point[6][6] +'"></td>'+
				'<td><input class="floor_point" disabled="true" class="floor_point" type="text" name="t-7-6" value="'+ point[7][6] +'"></td>'+
				'<td><input class="floor_point" disabled="true" class="floor_point" type="text" name="t-8-6" value="'+ point[8][6] +'"></td>'+
				'<td><input class="floor_point" disabled="true" class="floor_point" type="text" name="t-9-6" value="'+ point[9][6] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>七</td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-7-7" value="'+ point[7][7] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-7" value="'+ point[8][7] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-7" value="'+ point[9][7] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>八</td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-8-8" value="'+ point[8][8] +'"></td>'+
				'<td><input class="floor_point" disabled="true" type="text" name="t-9-8" value="'+ point[9][8] +'"></td>'+
			'</tr>'+
			'<tr>'+
				'<td>九层及以上顶层</td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td><input class="floor_point" type="text" class="floor_point" disabled="true" name="t-9-9" value="'+ point[9][9] +'"></td>'+
			'</tr>';
			// 处理表格
			$("#field").empty();
			$("#tb").empty();
			$("#field").append(filed_content);
			$("#tb").append(tb_content);
			var m_d = '<tr><td></td><td></td><td></td><td></td><td></td><td></td>'+
					  '<td>'+
					  '<button class="conf-modify-id4 am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only" style="float:left;margin-right:5px;" >修改</button>&nbsp;'+
					  '<button class="conf-delete-id4 am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only" style="float:left;">保存</button>'+
					  '</td></tr>';
			$("#tb").append(m_d);
		})

	}
});

$("table").on('click', '.conf-modify-id4', function(){
	$(".floor_point").attr('disabled', false);
	// var val = $("input[name='t-9-9']").val();
	// alert(val);
});
$("table").on('click', '.conf-delete-id4', function(){
	var classId = $("#conf-class-id").text();
	var value = new Array();
	var key = new Array();
	$(".floor_point").each(function(index, dom){
		value[index] = dom.value;
		key[index] = dom.name;
	})
	var data = new Array(key, value);
	console.log(data);
	$.post('/ph/BaseSet/modify', {"data":data,"classId":classId}, function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			layer.msg('修改成功!',{time:4000});
			// location.reload();
		} else {
			layer.msg('数据未更改或修改失败',{time:4000});
		}
		$(".floor_point").attr('disabled', true);
	})
});



$("table").on('click', '.conf-modify', function(){
	// var contentDom = $(this).parent('div').parent('td').prev();
	// var confContent = $(this).parent('div').parent('td').prev().text();
	// var confId = $(this).parent('div').parent('td').prev().prev().text();
	var classId = $("#conf-class-id").text();
	// alert(classId);
	
	// $("#modify-content").val(confContent);
	// $("#modify-id").text(confId);
	switch(classId){
		case '1':
			{
				var title = '各类结构住房租金基价表';
				var contentDom = $(this).parent('div').parent('td').prev();
				var newPoint = $(this).parent('div').parent('td').prev().text();
				var oldPoint = $(this).parent('div').parent('td').prev().prev().text();
				var structureType = $(this).parent('div').parent('td').prev().prev().prev().text();
				var confId = $(this).parent('div').parent('td').prev().prev().prev().prev().text();
				$("#ban_structure_id").text(confId);
				$("#structure_type").val(structureType);
				$("#oldPoint").val(oldPoint);
				$("#newPoint").val(newPoint);
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id1"),
					success:function(){

					},
					yes:function(thisIndex){
						structureType = $("#structure_type").val();
						oldPoint = $("#oldPoint").val();
						newPoint = $("#newPoint").val();
						var data = 'classId='+classId+'&structureType='+structureType+'&oldPoint='+oldPoint+'&newPoint='+newPoint+'&confId='+confId;
						// alert(data);
						$.post('/ph/BaseSet/modify', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								contentDom.text(newPoint);
								contentDom.prev().text(oldPoint);
								contentDom.prev().prev().text(structureType);
								layer.close(thisIndex);
							}else{
								layer.msg(res.msg,{time:4000});
							}
						})
					}
				});
				break;
			}
		case '2':
			{
				var title = '住房使用面积的计算';
				var contentDom = $(this).parent('div').parent('td').prev();
				var point = contentDom.text();
				var roomTypeName = contentDom.prev().text();
				var confId = contentDom.prev().prev().text();
				$("#room_type_point_id").text(confId);
				$("#room_type_name").val(roomTypeName);
				$("#point").val(point);
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id2"),
					success:function(){

					},
					yes:function(thisIndex){
						confId = $("#room_type_point_id").text();
						roomTypeName = $("#room_type_name").val();
						point = $("#point").val();
						var data = 'classId='+classId+'&roomTypeName='+roomTypeName+'&point='+point+'&confId='+confId;
						// alert(data);
						$.post('/ph/BaseSet/modify', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								contentDom.text(point);
								contentDom.prev().text(roomTypeName);
								layer.close(thisIndex);
							}else{
								layer.msg(res.msg,{time:4000});
							}
						})
					}
				});
				break;
			}
		case '3':
			{
				var title = '住房租金基价折减表';
				var contentDom = $(this).parent('div').parent('td').prev();
				var point = contentDom.text();
				var item = contentDom.prev().text();
				var confId = contentDom.prev().prev().text();
				$("#rent_cut_point_id").text(confId);
				$("#item").val(item);
				$("#rent_cut_point_point").val(point);
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id3"),
					success:function(){

					},
					yes:function(thisIndex){
						confId = $("#rent_cut_point_id").text();
						item = $("#item").val();
						point = $("#rent_cut_point_point").val();
						var data = 'classId='+classId+'&item='+item+'&point='+point+'&confId='+confId;
						// alert(data);
						$.post('/ph/BaseSet/modify', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								contentDom.text(point);
								contentDom.prev().text(item);
								layer.close(thisIndex);
							}else{
								layer.msg(res.msg,{time:4000});
							}
						})
					}
				});
				break;
			}
		case '4':var title = '使用性质配置';break;
		case '5':
			{
				var title = '各项加计租金';
				var contentDom = $(this).parent('div').parent('td').prev();
				var unitPrice = contentDom.text();
				var ceil = contentDom.prev().text();
				var item = contentDom.prev().prev().text();
				var confId = contentDom.prev().prev().prev().text();
				$("#room_item_point_id").text(confId);
				$("#room_item_point_item").val(item);
				$("#ceil").val(ceil);
				$("#unit_price").val(unitPrice);
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id5"),
					success:function(){

					},
					yes:function(thisIndex){
						confId = $("#room_item_point_id").text();
						item = $("#room_item_point_item").val();
						ceil = $("#ceil").val();
						unitPrice = $("#unit_price").val();
						var data = 'classId='+classId+'&item='+item+'&ceil='+ceil+'&unitPrice='+unitPrice+'&confId='+confId;
						// alert(data);
						$.post('/ph/BaseSet/modify', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								contentDom.text(unitPrice);
								contentDom.prev().text(ceil);
								contentDom.prev().prev().text(item);
								layer.close(thisIndex);
							}else{
								layer.msg(res.msg,{time:4000});
							}
						})
					}
				});
				break;
			}
		default:var title = '';break;
	}
	// layer.open({
	// 	type:1,
	// 	area:['300px','250px'],
	// 	zIndex:100,
	// 	title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
	// 	btn:['确定','取消'],
	// 	content:$("#conf-modify"),
	// 	success:function(){

	// 	},
	// 	yes:function(){
	// 		var modify_content = $("#modify-content").val();
	// 		var data = 'classId='+classId+'&confId='+confId+'&confContent='+modify_content;
	// 		$.post('/ph/ParameterSet/modify', data, function(res){
	// 			res = JSON.parse(res);
	// 			console.log(res);
	// 			if (res.retcode == '2000') {
	// 				contentDom.text($("#modify-content").val());
	// 			}
	// 		})
	// 	}
	// })
});

$("table").on('click', '.conf-add', function(){
	var classId = $("#conf-class-id").text();
	// // var modify_content_add = $("#modify-content-add").val();
	// // alert(classId);

	switch(classId){
		case '1':
			{
				var title = '各类结构住房租金基价表';
				$("#ban_structure_id").text('');
				$("#structure_type").val('');
				$("#oldPoint").val('');
				$("#newPoint").val('');
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id1"),
					success:function(){

					},
					yes:function(thisIndex){
						
						var structureType = $("#structure_type").val();

						var oldPoint =$("#oldPoint").val();
						var newPoint =$("#newPoint").val();
						if (oldPoint=='') {
							oldPoint='0.00';
						}else{
							oldPoint =parseFloat($("#oldPoint").val()).toFixed(2);
						}
						if (newPoint=='') {
							newPoint='0.00';
						}else{
							newPoint = parseFloat($("#newPoint").val()).toFixed(2);
						}
						var data = 'classId='+classId+'&structureType='+structureType+'&oldPoint='+oldPoint+'&newPoint='+newPoint;
						// alert(data);
						$.post('/ph/BaseSet/add', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								// var structure_type=$('#structure_type').prop('value');
								// var oldPoint = $('#oldPoint').prop('value');
								// var newPoint = $('#newPoint').prop('value');
								var num =$("#tb tr").length-2;
								$("#tb tr").eq(num).after('<tr><td>'+res.data+'</td><td>'+structureType+'</td><td>'+oldPoint+'</td><td>'+newPoint+'</td><td>'+'<div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button><button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button></div>'+'</td></tr>');
								layer.close(thisIndex);
							}
						})
					}
				})
				break;
			}
		case '2':
			{
				var title = '住房使用面积的计算';
				$("#room_type_point_id").text('');
				$("#room_type_name").val('');
				$("#point").val('');
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id2"),
					success:function(){

					},
					yes:function(thisIndex){

						roomTypeName = $("#room_type_name").val();
						point = $("#point").val();
						if (point=='') {
							point='0.00';
						}else{
							point =parseFloat($("#point").val()).toFixed(2);
						}
						var data = 'classId='+classId+'&roomTypeName='+roomTypeName+'&point='+point;
						$.post('/ph/BaseSet/add', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								var num =$("#tb tr").length-2;
								$("#tb tr").eq(num).after('<tr><td>'+res.data+'</td><td>'+roomTypeName +'</td><td>'+point+'</td><td>'+'<div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button><button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button></div>'+'</td></tr>');
								layer.close(thisIndex);
							}
						})
					}
				})
				break;
			}
		case '3':
			{
				var title = '住房租金基价折减表';
				$("#rent_cut_point_id").text('');
				$("#item").val('');
				$("#rent_cut_point_point").val('');
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id3"),
					success:function(){

					},
					yes:function(thisIndex){
						var item = $("#item").val();
						
						 var point = $("#rent_cut_point_point").val();
						 // console.log(typeof point);
						if (point=='') {
							point='0.00';
						}else{
							point = parseFloat($("#rent_cut_point_point").val()).toFixed(2);
							console.log(point);
						}
						var data = 'classId='+classId+'&item='+item+'&point='+point;
						$.post('/ph/BaseSet/add', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								var num =$("#tb tr").length-2;
								$("#tb tr").eq(num).after('<tr><td>'+res.data+'</td><td>'+item+'</td><td>'+point+'</td><td>'+'<div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button><button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button></div>'+'</td></tr>');
								layer.close(thisIndex);
							}
						})
					}
				})
				break;
			}
		case '4':var title = '使用性质配置';break;
		case '5':
			{
				var title = '各项加计租金';
				$("#room_item_point_id").text('');
				$("#room_item_point_item").val('');
				$("#ceil").val('');
			 $("#unit_price").val('');
				
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
					btn:['确定','取消'],
					content:$("#conf-modify-id5"),
					success:function(){

					},
					yes:function(thisIndex){
						// confId = $("#room_item_point_id").text();
						item = $("#room_item_point_item").val();
						ceil = $("#ceil").val();
						unitPrice = $("#unit_price").val();
						if (unitPrice=='') {
							unitPrice='0.00';
						}else{
							unitPrice = parseFloat($("#unit_price").val()).toFixed(2);
						}
						var data = 'classId='+classId+'&item='+item+'&ceil='+ceil+'&unitPrice='+unitPrice;
						$.post('/ph/BaseSet/add', data, function(res){
							res = JSON.parse(res);
							console.log(res);
							if (res.retcode == '2000') {
								var num =$("#tb tr").length-2;
								$("#tb tr").eq(num).after('<tr><td>'+res.data+'</td><td>'+item+'</td><td>'+ceil+'</td><td>'+unitPrice+'</td><td>'+'<div class="am-btn-group am-btn-group-xs am-u-md-offset-4"><button class="conf-modify am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">修改</button><button class="conf-delete am-btn am-btn-default am-btn-xs am-text-primary am-hide-sm-only">删除</button></div>'+'</td></tr>');
								layer.close(thisIndex);
							}
						})
					}
				})
				break;
			}
		default:var title = '';break;
	}
	// layer.open({
	// 	type:1,
	// 	area:['300px','250px'],
	// 	zIndex:100,
	// 	title:[title,'color:#FFF;font-size:1.6rem;font-weight:600;'],
	// 	btn:['确定','取消'],
	// 	content:$("#conf-modify-add"),
	// 	success:function(){

	// 	},
	// 	yes:function(){
	// 		var modify_add_content = $("#modify-content-add").val();
	// 		var data = 'classId='+classId+'&confContent='+modify_add_content;
	// 		$.post('/ph/ParameterSet/add', data, function(res){
	// 			res = JSON.parse(res);
	// 			console.log(res);
	// 			if (res.retcode == '2000') {
	// 				alert(res.data);
	// 			}
	// 		})
	// 	}
	// })
});

$("table").on('click', '.conf-delete', function(){
	var classId = $("#conf-class-id").text();
	switch(classId){
		case '1':
			var confId = $(this).parent('div').parent('td').prev().prev().prev().prev().text();
			break;
		case '2':
			var confId = $(this).parent('div').parent('td').prev().prev().prev().text();
			break;
		case '3':
			var confId = $(this).parent('div').parent('td').prev().prev().prev().text();
			break;
		case '4':break;
		case '5':
			var confId = $(this).parent('div').parent('td').prev().prev().prev().prev().text();
			break;
		default:break;
	}
	// var confId = $(this).parent('div').parent('td').prev().prev().prev().prev().text();
	var _this =$(this);
	var data = 'classId='+classId+'&confId='+confId;
	// alert(data);
	layer.alert('确认删除?',{icon:2,skin:'lan_class'},function(this_index){
		$.post('/ph/BaseSet/delete', data, function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.data){
			   layer.msg('删除成功',{icon: 1,skin:'lan_class'},function(thisIndex){	
					_this.parent().parent().parent().remove();
				})
			}else {
				layer.msg('删除成功',{icon: 2,skin:'lan_class'});
			}
			layer.close(thisIndex);
		})
	})
});

