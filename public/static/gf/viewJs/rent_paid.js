//批量标记已打发票
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
		layer.msg('请选择批量操作对象！',{time:4000});
	}else{
		console.log(Orders);
		$.post('/ph/RentPaid/batchSign',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.confirm('批量操作成功！',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
					layer.close(conIndex);
				});
				location.reload();
			}else{
				layer.msg(res.msg,{time:4000});
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
		layer.msg('请选择批量操作对象！',{time:4000});
	}else{
		console.log(Orders);
		$.post('/ph/RentPaid/payBack',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "2000"){
				layer.msg(res.msg,{time:4000});
				location.reload();
			}else{
				layer.msg(res.msg,{time:4000});
			}
		});
	}
});
//查看详情
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
		$('#OwnerType').text(res.data.OwnerType);
		$('#UseNature').text(res.data.UseNature);
		$('#UnitID').text(res.data.UnitID);
		$('#FloorID').text(res.data.FloorID);
		$('#DoorID').text(res.data.DoorID);
		$('#TenantBalance').text(res.data.TenantBalance);
		$('#HousePrerent').text(res.data.HousePrerent);
		$('#CutRent').text(res.data.CutRent);
		$('#PumpCost').text(res.data.PumpCost);
		$('#DiffRent').text(res.data.DiffRent);
		$('#ReceiveRent').text(res.data.ReceiveRent);
		$('#PaidRent').text(res.data.PaidRent);
		$('#UnpaidRent').text(res.data.UnpaidRent);
		$('#RechargeRent').text(res.data.RechargeRent);
	});
	layer.open({
		type:1,
		area:['700px','600px'],
		resize:false,
		title:['缴费明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#details')
	});
});
//单个撤销