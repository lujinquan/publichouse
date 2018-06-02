//添加房屋
$('#addRoom').click(function(){
	var PriceChoose = [];
	$('#RoomForm input').val('').prop('disabled',false);
	$('#PriceForm input:checked').prop('checked',false);
	$('select').val('');
	layer.open({
		type:1,
		area:['800px','600px'],
		resize:false,
		
		zIndex:100,
		title:['添加房间','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#RoomForm'),
		btn:['确定','取消'],
		success:function(){
			$('#PriceReduce').off('click');
			$('#PriceReduce').click(function(){
				layer.open({
					type:1,
					area:['600px','500px'],
					
					resize:false,
					zIndex:100,
					title:['基价折减','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#PriceForm'),
					btn:['确定','取消'],
					yes:function(child){
						var value = 0;
						for(var j = 0;j < $("input[name='PriceBox']").length;j++){
							if($("input[name='PriceBox']").eq(j).prop('checked')){
								value += parseInt($('.PriceValue').eq(j).text());
							}
							$('.ReduceRate').text(value+"%");
						}
						layer.close(child);
					}
				});
			});
		},
		yes:function(farther){
			console.log($('#addRoomType').val());
			if($('#addRoomType').val() == ''){
				layer.msg('请选择房间类型!');
				return false;
			}
			var data = new FormData($('#RoomForm')[0]);
			var TempData = [];
			PriceChoose =new FormData($('#PriceForm')[0]);
			for(var i of PriceChoose.entries()){
				console.log(i);
				TempData.push(i[1]);
			}
			data.append('PriceBox',TempData);
			$.ajax({
			  url: "/ph/Room/add",
			  type: "POST",
			  data: data,
			  processData: false,  // 不处理数据
			  contentType: false,  // 不设置内容类型
			  success:function(res){
			  	res = JSON.parse(res);
			  	console.log(res);
			  	layer.msg(res.msg);
				if(res.retcode == 2000){
					layer.close(farther);
					location.reload();
				}
			  }
			});
		}
	});
});
// 房屋修改
$('#reviseRoom').click(function(){
	$('#RoomForm input').val('').prop('disabled',false);
	$('#PriceForm input:checked').prop('checked',false);
	$('select').val('');
	var checkId = $("input:checked").val();
	console.log(checkId);
	if(checkId != 1){
		$.get('/ph/ConfirmRoom/edit/RoomID/'+checkId,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#RoomID").val(res.data.RoomID);
				$("#BanID").val(res.data.BanID);
				$("#RoomNumber").val(res.data.RoomNumber);
				$(".ReduceRate").text(res.data.RentPoint);
				$("#UnitID").val(res.data.UnitID);
				$("#FloorID").val(res.data.FloorID);
				$("input[name='UseArea']").val(res.data.UseArea);
				$("input[name='LeasedArea']").val(res.data.LeasedArea);
				$("#addRoomType").val(res.data.RoomType);
				
				if(res.data.HouseID != ''){
					var HouseID = res.data.HouseID.split(",");
					$("input[name='HouseID[1]']").val(HouseID[0]);
					$("input[name='HouseID[2]']").val(HouseID[1]);
				}
				if(res.data.RentPointIDS != ''){
					var RentPointIDS = res.data.RentPointIDS.split(",");
					var PriceDom = $("input[name='PriceBox']");
					for(var i = 0;i < RentPointIDS.length;i++){
						for(var j = 0;j < PriceDom.length;j++){
							if(PriceDom.eq(j).val() == RentPointIDS[i]){
								PriceDom.eq(j).prop("checked",true);
							}
						}
					}
				}
			});
			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				zIndex:100,
				title:['修改房间','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#RoomForm'),
				btn:['确定','取消'],
				success:function(){
					$('#PriceReduce').off('click');
					$('#PriceReduce').click(function(){
						layer.open({
							type:1,
							area:['600px','500px'],
							resize:false,
							zIndex:100,
							title:['基价折减','color:#FFF;font-size:1.6rem;font-weight:600;'],
							content:$('#PriceForm'),
							btn:['确定','取消'],
							yes:function(child){
								var value = 0;
								for(var j = 0;j < $("input[name='PriceBox']").length;j++){
									if($("input[name='PriceBox']").eq(j).prop('checked')){
										value += parseInt($('.PriceValue').eq(j).text());
									}
									$('.ReduceRate').text(value+"%");
								}
								layer.close(child);
							}
						});
					});
				},
				yes:function(farther){
					var data = new FormData($('#RoomForm')[0]);
					var TempData = [];
					PriceChoose =new FormData($('#PriceForm')[0]);
					for(var i of PriceChoose.entries()){
						console.log(i);
						TempData.push(i[1]);
					}
					data.append('RentPointIDS',TempData);
					
					
					$.ajax({
					  url: "/ph/ConfirmRoom/edit",
					  type: "POST",
					  data: data,
					  processData: false,  // 不处理数据
					  contentType: false,  // 不设置内容类型
					  success:function(res){
					  	res = JSON.parse(res);
					  	console.log(res);
					  	layer.msg(res.msg);
						layer.close(farther);
						location.reload();
					  }
					});
				}
		});
	}else{
		layer.msg('请选择要操作的条目');
	}
});
//删除
$('#deleteRoom').click(function(){
	var checkId = $("input:checked").val();
	console.log(checkId);
	if(checkId == 1){
		layer.msg('请先选择要修改的信息');
	}else{
		$.get('/ph/Room/delete/RoomID/'+checkId,function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == '2000'){
				layer.msg(res.msg);
				location.reload();
			}
		});
	}
});
//明细
$('.details').click(function(){
	var value = $(this).val();
	$.get('/ph/Room/detail/RoomID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		$("#DRoomID").text(res.data.RoomID);
		$("#DBanID").text(res.data.BanID);
		$("#DHouseID").text(res.data.HouseID);
		$("#DRoomType").text(res.data.RoomType);
		$("#DUnitID").text(res.data.UnitID);
		$("#DFloorID").text(res.data.FloorID);
		$("#DRentPoint").text(res.data.RentPoint);
		$("#DUseArea").text(res.data.UseArea);
		$("#DLeasedArea").text(res.data.LeasedArea);
		$("#DItems").text(res.data.Items);
		$("#DRoomNumber").text(res.data.RoomNumber);
		$(".BanAddress").text(res.data.BanAddress);
	});
	layer.open({
		type:1,
		area:['800px','600px'],
		resize:false,
		zIndex:100,
		title:['房间明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#RoomDetail'),
		btn:['确定','取消'],
		success:function(){}
	});
});

$('#PublicIdentifier').change(function(){
	var flag = $(this).prop('checked');
	if(flag == false){
		$('#HouseID_1,#HouseID_2').prop("disabled",false).val("");
	}else{
		$('#HouseID_1,#HouseID_2').prop('disabled',true).val("");
	}
});
queryData.action(1,'BanID');
queryData.actionD(2,'HouseID_1');
queryData.actionD(2,'HouseID_2');
// 楼栋信息查询
$('#DqueryBtn').click(function(){
	var value = $('#BanID').val();
	$.get('/ph/Api/get_ban_info/BanID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			$('#LossLevel').text(res.data.DamageGrade);
			$('#BuildStructure').text(res.data.StructureType);
		}
		else{
			layer.msg('无此信息！');
		}
	});
});