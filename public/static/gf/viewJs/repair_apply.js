//小修申请
$('#addSRepair').click(function(){
	layer.open({
		type:1,
		area:['1000px','700px'],
		resize:false,
		zIndex:100,
		title:['小修申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#SRepair'),
		success:function(){

		},
		yes:function(){
			var data = $('#SRepair').serializeArray();
			console.log(data);
			$.post('/ph/RepairApply/lightRepairAdd',data,function(res){
				res = JSON.parse(res);
				console.log(res);
			})
		}
	})
});
//中修、排危、电器隐患整治申请
$('.addRepair').click(function(){
	var type = $(this).val();
	if(type == 2){
		var titleName = "中修申请";
	}else if(type == 3){
		var titleName = "排危申请";
	}else if(type == 4){
		var titleName = "电器线隐患整治";
	}
	layer.open({
		type:1,
		area:['600px','600px'],
		resize:false,
		zIndex:100,
		title:[titleName,'color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#repairDetail'),
		success:function(){
			$('#HouseID').val('').prop('disabled',false);
		},
		yes:function(){
			var url = null;
			if(type == 2){
				url = '/ph/RepairApply/middleRepairAdd';
			}else if(type == 3){
				url = '/ph/RepairApply/';
			}else if(type == 4){
				url = '/ph/RepairApply/repairWireAdd';
			}
			var BanID = $('#middleApplyBanID').val();
			var RepairContent = $('#RepairContent').val();
			var data = "BanID="+BanID+"&"+"RepairContent="+RepairContent;
			console.log(data);
			$.post(url, data, function(res){
				res = JSON.parse(res);
				console.log(res);
			})
		}
	})
});
//明细
$('.detailsBtn').click(function(){
	var thisValue = $(this).val();
	layer.open({
		type:1,
		area:['600px','600px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#repairDetail'),
		success:function(){
			$('#HouseID').val('dongdogn').prop('disabled',true);
		},
		yes:function(){

		}
	})
});
//删除
$('.deleteBtn').click(function(){
	var thisValue = $(this).val();
	layer.confirm('请确认删除维修申请',{title:'提示信息',icon:'2',skin:'lan_class'},function(conIndex){
		$.get('');
		layer.close(conIndex);
	});
});