//批量缴费
$('#rentPayment').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！',{time:4000});
	}else{
		console.log(Orders);
		$.post('/ph/RentPayable/batchPay',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量操作成功！',{time:4000});
				location.reload();
			}else{
				layer.msg(res.msg,{time:4000});
			}
		});
	}
});
//批量欠缴
$('#rentArrearage').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！',{time:4000});
	}else{
		console.log(Orders);
		$.post('/ph/RentPayable/batchCut',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量操作成功！',{time:4000});
				location.reload();
			}else{
				layer.msg(res.msg,{time:4000});
			}
		});
	}
});
//批量扣缴
$('#generateCharging').click(function(){
	// layer.msg('扣缴计算中,数据过大，耐心等待!',{time:600000});
	$.get('/ph/RentPayable/batchDebit/',function(res){
		res = JSON.parse(res);
		console.log(res);
		layer.msg(res.msg,{time:4000});
		location.reload();
	});
});
//批量全部已缴
$('#payAll').click(function(){
	// layer.msg('扣缴计算中,数据过大，耐心等待!',{time:600000});
	$.get('/ph/RentPayable/payAll',function(res){
		res = JSON.parse(res);
		console.log(res);
		layer.msg(res.msg,{time:4000});
		location.reload();
	});
});
//按上期欠缴处理
$('#dealAsLast').click(function(){
	// layer.msg('扣缴计算中,数据过大，耐心等待!',{time:600000});
	$.get('/ph/RentPayable/dealAsLast/',function(res){
		res = JSON.parse(res);
		console.log(res);
		layer.msg(res.msg,{time:4000});
		location.reload();
	});
});
//缴费
$('.payment').click(function(){
	var thisID = $(this).val();
	$.get('/ph/RentPayable/pay/RentOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		$('#HousePrerent').text(res.data.HousePrerent);
		$('#CutRent').text(res.data.CutRent);
		// $('#PumpCost').text(res.data.PumpCost);
		// $('#RepairCost').text(res.data.RepairCost);
		$('#ReceiveRent').text(res.data.ReceiveRent);
		$('#money').prop('value',res.data.ReceiveRent);
		layer.open({
			type:1,
			area:['600px','600px'],
			resize:false,
			title:['缴费','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#details'),
			btn:['确定','取消'],
			yes:function(thisIndex){
				var money = $('#money').val();
				$.post('/ph/RentPayable/pay',{RentOrderID:thisID,cost:money},function(res){
					res = JSON.parse(res);
					console.log(res);
					layer.msg(res.msg,{time:4000});
					layer.close(thisIndex);
					location.reload();
				});
			}
		});
	});
});
// 删除订单
$('#deleteCharging').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！',{time:4000});
	}else{
		console.log(Orders);
		$.post('/ph/RentPayable/batchDelete',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量删除成功！',{time:4000});
				location.reload();
			}else{
				layer.msg(res.msg,{time:4000});
			}
		});
	}
})