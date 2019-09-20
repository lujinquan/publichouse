//批量撤销
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
		$.post('/ph/RentDebit/batchRevoke',{value:Orders},function(res){
			res = JSON.parse(res);
			console.log(res);
			layer.msg('批量操作成功！',{time:4000});
			location.reload();
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
		$('#PaidableTime').text(res.data.PaidableTime);
		$('#HouseID').text(res.data.HouseID);
		$('#BanAddress').text(res.data.BanAddress);
		$('#UnitID').text(res.data.UnitID);
		$('#FloorID').text(res.data.FloorID);
		$('#DoorID').text(res.data.DoorID);
		$('#HousePrerent').text(res.data.HousePrerent);
		$('#CutRent').text(res.data.CutRent);
		$('#ReceiveRent').text(res.data.ReceiveRent);
		$('#TenantName').text(res.data.TenantName);
		$('#TenantBalance').text(res.data.TenantBalance);
		$('#PaidRent').text(res.data.PaidRent);
	});
	layer.open({
		type:1,
		area:['600px','600px'],
		resize:false,
		title:['扣缴明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#details')
	});
});
//单个撤销
$('.cancel').click(function(){
	var thisID = $(this).val();
	console.log(thisID);
	$.get('/ph/RentDebit/revoke/RentOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		if(res.retcode == "2000"){
			layer.msg('撤销成功!',{time:4000});
			location.reload();
		}
	});
});
 $('.aId2').each(function (i) {
                            $(this).children().eq(0).attr('id', 'checkbox0' + i);
                            $(this).children().eq(1).attr('for', 'checkbox0' + i);

                        })