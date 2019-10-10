$('#rentAllocation').click(function(){
	$.get('/ph/RentCount/conf/IfPre/1',function(res){

	res = JSON.parse(res);
	if(res.retcode == 2000){
		// layer.open({
		// 	time: 2000,
		// 	content: res.msg
		// });
			layer.msg(res.msg,{time:4000});
			location.reload();
			}
	});
	// layer.open({
	// 	type: 1,
	// 	area:['400px','400px'],
	// 	resize:false,
	// 	zIndex:100,
	// 	title:['租金配置','color:#FFF;font-size:1.6rem;font-weight:600;'],
	// 	content: $('#allocation'),
	// 	btn:['确定','取消'],
	// 	yes:function(thisIndex){

	// 		var IfPre = $('input[name="allocationChoose"]:checked').val();
			
	// 		$.get('/ph/RentCount/conf/IfPre/'+IfPre,function(res){

	// 		res = JSON.parse(res);
	// 		if(res.retcode == 2000){
	// 				layer.msg(res.msg);
	// 				location.reload();
	// 				}
	// 		});
			
	// 		layer.close(thisIndex);
	// 	}
	// });
});
$('#rentCount').click(function(){
	layer.confirm('计算滞纳金大概需要10分钟！',{title:'计算滞纳金',icon:'1',skin:'lan_class'},function(conIndex){
		$.get('/ph/RentCount/add',function(res){
			res = JSON.parse(res);
			console.log(res);
		});
		layer.close(conIndex);
	});
});
$('#generateRent').click(function(){
	layer.confirm('请确认租金配置无误！',{title:'生成本期租金',icon:'1',skin:'lan_class'},function(conIndex){
		$.get('/ph/RentCount/add',function(res){
			res = JSON.parse(res);
			console.log(res);
			layer.msg(res.msg,{time:4000});
		});
		layer.close(conIndex);
	});
});
$('.cancelRentCut').click(function(){
	var id = $(this).val();
	console.log(id);
	layer.confirm('注意，一旦取消减免;将必须重新申请再减免。无法恢复！！！',{title:'取消减免',icon:'1',skin:'lan_class'},function(conIndex){
		$.get('/ph/RentCount/cancelCut?id='+id,function(res){
			res = JSON.parse(res);
			layer.msg(res.msg,{time:4000});
			location.reload();
		});
		layer.close(conIndex);

	});
});
$('.rentApply').click(function(){
	var ID = $(this).val();
	if(ID == ''){
		layer.msg('功能开发中...',{time:4000});
	}else{
		$.get('',function(res){
			res = JSON.parse(res);
			layer.open({
				type: 1,
				area:['600px','600px'],
				resize:false,
				zIndex:100,
				title:['租金配置','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content: $('#rentApply'),
				btn:['确定','取消'],
				yes:function(){

				}
			});
		})
	}
})