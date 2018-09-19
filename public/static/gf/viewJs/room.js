//添加房屋
var flag=true;
var num=0;
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
			$('#editRoomID').hide();
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
							$('.ReduceRate').text(value);
						}
						layer.close(child);
					}
				});
			});
		},
		yes:function(farther){
			//console.log('bbb');
			console.log($('#addRoomType').val());
			if($('#addRoomType').val() == ''){
				layer.msg('请选择房间类型!');
				return false;
			}
			//console.log(num)

			var data = new FormData($('#RoomForm')[0]);
			var TempData = [];
			PriceChoose =new FormData($('#PriceForm')[0]);
			for(var i of PriceChoose.entries()){
				console.log(i);
				TempData.push(i[1]);
			}
			data.append('RentPointIDS',TempData);
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
			  	//layer.close(farther);
				// 	location.reload();
			  	// console.log('aaa');
				if(res.retcode == 2000){
					layer.close(farther);
					location.reload();
					console.log('bbb');
				}else{
					flag=true;
				}
			  }
			});
		}
	});
});
// 房屋修改
$('#reviseRoom').click(function(){
	$('#editRoomID').show();
	$('#RoomForm input').val('').prop('disabled',false);
	$('#PriceForm input:checked').prop('checked',false);
	$('select').val('');
	var checkId = $("input:checked").val();
	console.log(checkId);
	if(checkId != 1){
		$.get('/ph/Room/edit/RoomID/'+checkId,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#RoomID").val(res.data.RoomID);
				$("#BanID").val(res.data.BanID);
				$("input[name='RoomNumber']").val(res.data.RoomNumber);
				$(".ReduceRate").text(res.data.RentPoint);
				$("#UnitID").val(res.data.UnitID);
				$("#FloorID").val(res.data.FloorID);
				$("input[name='UseArea']").val(res.data.UseArea);
				$("input[name='LeasedArea']").val(res.data.LeasedArea);
				$("#addRoomType").val(res.data.RoomType);
				$("#addUseNature").val(res.data.UseNature);
				$("#addOwnerType").val(res.data.OwnerType);
				$("#RoomPrerent").val(res.data.RoomPrerent);
				$('.BanAddress').text(res.data.BanAddress);
				if(res.data.HouseID != ''){
					var HouseID = res.data.HouseID.split(",");
					$("input[name='HouseID[1]']").val(HouseID[0]);
					$("input[name='HouseID[2]']").val(HouseID[1]);
					$("input[name='HouseID[3]']").val(HouseID[2]);
					$("input[name='HouseID[4]']").val(HouseID[3]);
					$("input[name='HouseID[5]']").val(HouseID[4]);
					$("input[name='HouseID[6]']").val(HouseID[5]);
					$("input[name='HouseID[7]']").val(HouseID[6]);
					$("input[name='HouseID[8]']").val(HouseID[7]);
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
					// data.append('RoomID',$("#RoomID").val());
					
					$.ajax({
					  url: "/ph/Room/edit",
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
		layer.open({
			type:1,
			area:['600px','130px'],
			title:['删除房间','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#deleteChoose'),
			// btn:['确定','取消'],
			// yes:function(thisIndex){
			// 	var oChecked='';
			// 		if($('input[name=roomDeleteType]:checked').val()==undefined){
			// 			oChecked='';
						
			// 		}else{
			// 			oChecked=$('input[name=roomDeleteType]:checked').val();
			// 		}
			// 	layer.confirm('确定删除房间信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
			// 		$.get('/ph/ConfirmRoom/delete/RoomID/'+checkId+'/style/'+oChecked,function(result){
			// 			result = JSON.parse(result);
			// 			if(result.retcode  == '2000' ){
			// 				layer.msg('删除成功');
			// 				location.reload();
			// 			}else{
			// 					layer.msg(result.msg);
			// 				}
			// 		});
			// 		layer.close(index);
			// 		layer.close(thisIndex);
			// 	});
			// }
		})
	}
});
$('#HouseChange,#HouseRemove,#DateTogther,#DateLose').click(function(){
		var checkId = $("input:checked").val();
	var oV= $(this).val();
	layer.confirm('确定房间删除信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
						$.get('/ph/Room/delete/RoomID/'+checkId+'/style/'+oV,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode  == '2000' ){
								layer.msg(result.msg);
								location.reload();
							}else{
								layer.msg(result.msg);
							}
						})
					})
})
// $(".ConfirmRoomBtn").click(function(){

// 	var roomID = $(this).val();

// 	layer.confirm('请确认此房间信息无误',{title:'提示信息',icon:'1',skin:'lan_class'},function(index){
// 		$.get('/ph/ConfirmRoom/confirm/RoomID/'+roomID,function(result){
// 			result = JSON.parse(result);
// 			if(result.retcode  == '2000' ){
// 				layer.msg(result.msg);
// 				location.reload();
// 			}else{
// 				layer.msg(result.msg);
// 			}
// 		});
// 	});

// });

//明细
$('.details').click(function(){
	$('#DItems').empty();
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
		$('.BanAddress').text(res.data.BanAddress);
		$('#RoomNumber').text(res.data.RoomNumber);
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

queryData.actionD(1,'BanID');
queryData.actionD(2,'HouseID_1');
queryData.actionD(2,'HouseID_2');
queryData.actionD(2,'HouseID_3');
queryData.actionD(2,'HouseID_4');
queryData.actionD(2,'HouseID_5');
queryData.actionD(2,'HouseID_6');
queryData.actionD(2,'HouseID_7');
queryData.actionD(2,'HouseID_8');

// 楼栋信息查询
$('#DqueryBtn').click(function(){
	var value = $('#BanID').val();
	$.get('/ph/Api/get_ban_info/BanID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			// $('#LossLevel').text(res.data.DamageGrade);
			// $('#BuildStructure').text(res.data.StructureType);
			$('.BanAddress').text(res.data.BanAddress);
		}
		else{
			layer.msg('无此信息！');
		}
	});
});