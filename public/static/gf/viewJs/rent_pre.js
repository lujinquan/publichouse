$('#recharge').click(function(){
	// houseQuery.action('houseID','2');
	//queryData.actionD(2,'houseID');
	houseQuery.action('houseID','1');
	$('#rechargeForm input').val('');
	$('#name').text('');
	$('#phoneNumber').text('');
	$('#currentMoney').text('');
	$('#HousePrerent').text('');
	layer.open({
		type:1,
		area:['650px','600px'],
		resize:false,
		zIndex:100,
		title:['充值','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content: $('#rechargeForm'),
		btn:['充值','取消'],
		success:function(){
			$('#houseID').off('blur');
			$('#houseID').blur(function(){
				var houseID = $('#houseID').val();
				$.get('/ph/Api/get_house_info/HouseID/'+houseID,function(res){
					res = JSON.parse(res);
					console.log(res);
					$('#name').text(res.data.TenantName);
					$('#phoneNumber').text(res.data.TenantTel);
					$('#currentMoney').text(res.data.RechargeRent);//房屋余额
					$('#HousePrerent').text(res.data.HousePrerent);
				});
			});
		},
		yes:function(){
			layer.open({
				type:1,
				area:['400px','400px'],
				resize:false,
				zIndex:100,
				title:['充值','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#rechargeSure'),
				btn:['确认','取消'],
				success:function(){
					$('#rentIDT').text($('#houseID').val());
					$('#rentName').text($('#name').text());
					$('#rentHouseMoney').text($('#HousePrerent').text());
					$('#rentMoney').text($('#inputMoney').val());
				},
				yes:function(thisIndex){
					var houseID = $('#houseID').val();
					var money = $('#inputMoney').val();
					$.post('/ph/RentPre/recharge',{HouseID:houseID,Money:money},function(res){
						res = JSON.parse(res);
						console.log(res);
						layer.msg(res.msg,{time:4000});
						layer.close(thisIndex);
						if(res.retcode == '2000'){
							location.reload();
						}
					});
				}
			});
		}
	});
});
//打印发票
$('#printInvoice').click(function(){
	var orders = [];
	var checkDom = $('.checkId');
	var DomLength = checkDom.length;
	for(var i = 0;i < DomLength;i++){
		if(checkDom[i].checked){
			orders.push(checkDom[i].value);
		}
	}
	if(orders == ''){
		layer.msg('请先选择要处理的数据!',{time:4000});
	}else{
		layer.confirm('请确认批量标记打印发票',{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
			$.post('/ph/RentPre/batchSign',{id:orders},function(res){
				res = JSON.parse(res);
				layer.msg(res.msg,{time:4000});
				location.reload();
			});
			layer.close(conIndex);
			
		});
	}
});

$('.deleteButton').click(function(){
	var value = $(this).val();
	console.log(value);
	layer.confirm('确认要删除？', {icon: 3, title:'提示',skin:'lan_class'}, function(index){
		$.get('/ph/RentPre/delete/id/'+value,function(res){
			res = JSON.parse(res);
			layer.msg(res.msg,{time:4000});
			layer.close(index);
			location.reload();
		})
	});
})