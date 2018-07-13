require.config({
	baseUrl:"/public/static/gf/",
	paths:{
		"jquery":"js/jquery.min",
		"layer":"layer/layer"
	}
});
new file({
    button: "#transferApplication",
    show: "#transferApplicationShow",
    upButton: "#transferApplicationUp",
    size: 10240,
    url: "/ph/ChangeApply/add",
    ChangeOrderID: '',
    Type: 1,
    title: "书面申请报告"
});
$("#addTransfer").click(function(){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['1020px','700px'],
			resize:false,
			zIndex:100,
			title:['使用权变更申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			success:function(){
				$('.label_p_style').text('');
				$('.label_input').val('');
			},
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				// var IfReform = $("input[type=radio][name=IfReform]:checked").val();
				// var IfRepair = $("input[type=radio][name=IfRepair]:checked").val();
				// var IfCollection = $("input[type=radio][name=IfCollection]:checked").val();
				// var IfFacade = $("input[type=radio][name=IfFacade]:checked").val();
				var transferReason = $("#transferReason").val();
				var transferWay = $("#transferWay").val();
				var transferMoney = $("#transferMoney").val();

				var formData = fileTotall.getArrayFormdata();
				formData.append('houseid',ID);
				formData.append('oldID',oldID);
				formData.append('oldName',oldName);
				formData.append('newID',newID);
				formData.append('newName',newName);
				formData.append('transferType',transferWay);
				formData.append('transferRent',transferMoney);
				formData.append('transferReason',transferReason);

				$.ajax({
				    type: "post",
				    url: "/ph/UserApply/add",
				    data: formData,
				    processData: false,
				    contentType: false,
				    success: function(res) {
				        res = JSON.parse(res);
				        layer.msg(res.msg);
				        if(res.retcode == '2000'){
				            layer.close(thisIndex);
				            location.reload();
				        }
				    }
				});
			}
		});
	})
});
//申请修改
$('.BtnChange').click(function(){
	var ID = $(this).val();
		console.log(ID);
	$.get('/ph/UserApply/edit/ChangeOrderID/'+ID,function(res){
		res = JSON.parse(res);
			console.log(res);
			if(res.retcode == "4005"){
				layer.msg(res.msg);
			}else{
				revise_2(res,ID);
			}
	})
});
//申请删除
$('.BtnDel').click(function(){
	var ID = $(this).val();
	require(["layer","jquery"],function(layer){
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.confirm('确认删除？',{title:'提示信息',icon:'2',skin:'lan_class'},function(conIndex){
			$.get('/ph/UserApply/delete/ChangeOrderID/'+ID,function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.msg(res.msg);
				layer.close(conIndex);
				location.reload();
			});
		});
	});
});
//房屋编号输入
$('#queryAction').click(function(){
	var ID = $('#getInfo_1').val();
	$.get('/ph/Api/get_house_tenant/HouseID/'+ ID,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			$('.tenantID').text(res.data.TenantID);
			$('.tenantTel').text(res.data.TenantTel);
			$('.tenantName').text(res.data.TenantName);
		}else{
			layer.msg(res.msg);
		}
	});
});
//房屋编号插件
houseQuery.action("getInfo_1","1");
houseQuery.action("HouseIdInput","1");
tenantQuery.action('IdIput','','0,1',
	function(){
		var ID = $('#IdIput').val();
		$.get('/ph/Api/get_tenant_info/TenantID/'+ ID,function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == '2000'){
				$('#newTel').text(res.data.TenantNumber);
				$('#newNam').text(res.data.TenantName);
			}else{
				layer.msg(res.msg);
			}
			
		});
	}
);

//旧ID输入
$('#queryAction_1').click(function(){
	var ID = $('#HouseIdInput').val();
	$.get('/ph/Api/get_house_tenant/HouseID/'+ ID,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.retcode == '2000'){
			$('#oldID').text(res.data.TenantID);
			$('#oldName').text(res.data.TenantName);
			$('#oldTel').text(res.data.TenantNumber);
		}else{
			layer.msg(res.msg);
		}
	});
});
//新租户ID输入
// $('#IdIput').blur(function(){
// 	var ID = $('#IdIput').val();
// 	$.get('/ph/Api/get_tenant_info/TenantID/'+ ID,function(res){
// 		res = JSON.parse(res);
// 		if(res.retcode == '2000'){
// 			$('#newTel').text(res.data.TenantTel);
// 			$('#newNam').text(res.data.TenantName);
// 		}else{
// 			layer.msg(res.msg);
// 		}
		
// 	});
// });
function revise_2(res,id){
	require(["layer","jquery"],function(layer){
		$('#IdIput').val('');
		$('#HouseIdInput').val('');
		layer.config({	//真实layer的配置路径
			path:'/public/static/gf/layer/'
		});
		layer.open({
			type:1,
			area:['1020px','700px'],
			resize:false,
			zIndex:100,
			title:['转让申请修改','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForm'),
			btn:['确认','取消'],
			success:function(){
				$('#HouseIdInput').val(res.data.HouseID);//房屋ID
				$('#oldID').text(res.data.OldTenantID);
				$('#oldName').text(res.data.OldTenantName);
				$('#IdIput').val(res.data.NewTenantID);
				$('#transferReason').val(res.data.ChangeReason);
				$('#newNam').text(res.data.NewTenantName);
				$('#transferWay option[value='+res.data.TransferType+']').attr('selected','selected');
				$('#transferMoney').val(res.data.TransferRent);

				$('#transferWay option[value='+res.data.ChangeType+']').attr('selected',true);

				// $("input[name='IfReform'][value="+res.data.IfReform+"]").attr('checked','checked');
				// $("input[name='IfRepair'][value="+res.data.IfRepair+"]").attr('checked','checked');
				// $("input[name='IfCollection'][value="+res.data.IfCollection+"]").attr('checked','checked');
				// $("input[name='IfFacade'][value="+res.data.IfFacade+"]").attr('checked','checked');
			},
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				var newID = $('#IdIput').val();
				var newName = $('#newNam').text();
				// var IfReform = $("input[type=radio][name=IfReform]:checked").val();
				// var IfRepair = $("input[type=radio][name=IfRepair]:checked").val();
				// var IfCollection = $("input[type=radio][name=IfCollection]:checked").val();
				// var IfFacade = $("input[type=radio][name=IfFacade]:checked").val();
				var transferReason = $("#transferReason").val();
				var transferWay = $("#transferWay").val();
				var transferMoney = $("#transferMoney").val();

				var formData = fileTotall.getArrayFormdata();
				formData.append('ChangeOrderID',id);
				formData.append('HouseID',ID);
				formData.append('OldTenantID',oldID);
				formData.append('OldTenantName',oldName);
				formData.append('NewTenantID',newID);
				formData.append('NewTenantName',newName);
				formData.append('ChangeType',transferWay);
				formData.append('TransferRent',transferMoney);
				formData.append('ChangeReason',transferReason);

				$.ajax({
				    type: "post",
				    url: "/ph/UserApply/edit",
				    data: formData,
				    processData: false,
				    contentType: false,
				    success: function(res) {
				        res = JSON.parse(res);
				        layer.msg(res.msg);
				        if(res.retcode == '2000'){
				            layer.close(thisIndex);
				            location.reload();
				        }
				    }
				});
			}
		});
	});
}