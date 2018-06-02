//批量缴费
$('#withHolding').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！');
	}else{
		console.log(Orders);
		$.post('/ph/RentPayable/batchPay',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量操作成功！');
				location.reload();
			}else{
				layer.msg(res.msg);
			}
		});
	}
});
//批量催缴
$('#PressForMoney').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！');
	}else{
		console.log(Orders);
		$.post('/ph/RentUnpaid/batchCall',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量操作成功！');
				location.reload();
			}
		});
	}
});

//批量撤回
$('#batchRevocation').click(function(){
	var Orders = [];
	var checkDom = $('.checkId');
	var length = checkDom.length;
	for(var i = 0;i < length;i++){
		if(checkDom[i].checked){
			Orders.push(checkDom[i].value);
		}
	}
	if(Orders.length == 0){
		layer.msg('请选择批量操作对象！');
	}else{
		console.log(Orders);
		$.post('/ph/RentUnpaid/payBack',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg('批量操作成功！');
				location.reload();
			}
		});
	}
});

//查看明细
$('.details').click(function(){
	var thisID = $(this).val();
	$.get('/ph/RentPaid/detail/RentOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('#RentOrderID').text(res.data.RentOrderID);
		$('#InstitutionID').text(res.data.InstitutionID);
		$('#OrderDate').text(res.data.OrderDate);
		$('#TenantName').text(res.data.TenantName);
		$('#HouseID').text(res.data.HouseID);
		$('#BanAddress').text(res.data.BanAddress);
		$('#UnitID').text(res.data.UnitID);
		$('#FloorID').text(res.data.FloorID);
		$('#DoorID').text(res.data.DoorID);
		//$('#TenantBalance').text(res.data.TenantBalance);
		$('#HousePrerent').text(res.data.HousePrerent);
		$('#CutRent').text(res.data.CutRent);
		$('#ReceiveRent').text(res.data.ReceiveRent);
		$('#PaidRent').text(res.data.PaidRent);
		$('#UnpaidRent').text(res.data.UnpaidRent);
		$('#LateRent').text(res.data.LateRent);
	});
	layer.open({
		type:1,
		area:['600px','600px'],
		resize:false,
		title:['欠缴明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#details')
	});
});
//单个缴费
$('.payment').click(function(){
	var thisID = $(this).val();
	$.get('/ph/RentPayable/pay/RentOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('#ReceiveRents').text(res.data.ReceiveRent);
		$('#LateRents').text(res.data.LateRent);
		$('#PaidRents').text(res.data.PaidRent);
		$('#UnpaidRents').text(res.data.UnpaidRent);
		layer.open({
			type:1,
			area:['600px','600px'],
			resize:false,
			title:['缴费','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#payForMoney'),
			btn:['确定','取消'],
			yes:function(thisIndex){
				var money = $('#money').val();
				var date = $('#CreateDate').val();
				$.post('/ph/RentPayable/pay',{RentOrderID:thisID,cost:money,CreateDate:date},function(res){
					res = JSON.parse(res);
					if(res.retcode == 2000){
						layer.msg(res.msg);						
						layer.close(thisIndex);						
						location.reload();
						}else{
							layer.msg(res.msg);							
						}	
					
				});
			}
		});
	});
});