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
    url: "/ph/CorrectApply/add",
    ChangeOrderID: '',
    Type: 1,
    title: "书面申请报告"
});
new file({
    button: "#transferApprovalForm",
    show: "#transferApprovalFormShow",
    upButton: "#transferApprovalFormUp",
    size: 10240,
    url: "/ph/CorrectApply/add",
    ChangeOrderID: '',
    Type: 1,
    title: "审批表"
});
new file({
    button: "#transferOther",
    show: "#transferOtherShow",
    upButton: "#transferOtherUp",
    size: 10240,
    url: "/ph/CorrectApply/add",
    ChangeOrderID: '',
    Type: 1,
    title: "其它"
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
			title:['别字更正申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#TransferForms'),
			btn:['确认','取消'],
			success:function(){
				$('.label_p_style').text('');
				$('.label_input').val('');
				$('.transfer_money').show();
				$('.transfer_reason').show();
				$('.fileUpLoad').show();

				// $('#transferWay').change(function(){
				// 	var transferWay_value = $(this).val();
				// 	if(transferWay_value == '1'){
				// 		$('.transfer_money').show();
				// 		$('.transfer_reason').show();
				// 		$('.fileUpLoad').hide();
				// 	}else if(transferWay_value == '2'){
				// 		$('.transfer_money').hide();
				// 		$('.transfer_reason').show();
				// 		$('.fileUpLoad').hide();
				// 	}else{
				// 		$('.transfer_money').hide();
				// 		$('.transfer_reason').hide();
				// 		$('.fileUpLoad').show();
				// 	}
				// })
			},
			yes:function(thisIndex){
				var ID = $('#HouseIdInput').val();//房屋ID
				var oldID = $('#oldID').text();
				var oldName = $('#oldName').text();
				// var newID = $('#IdIput').val();
				// var newName = $('#newNam').text();
				// var IfReform = $("input[type=radio][name=IfReform]:checked").val();
				// var IfRepair = $("input[type=radio][name=IfRepair]:checked").val();
				// var IfCollection = $("input[type=radio][name=IfCollection]:checked").val();
				// // var IfFacade = $("input[type=radio][name=IfFacade]:checked").val();
				// var transferReason = $("#transferReason").val();
				// var transferWay = $("#transferWay").val();
				// var transferMoney = $("#transferMoney").val();
				var transferName = $("#transferName").val();//别字更正
				var card = $("#newCard").val();//别字更正
				var formData = fileTotall.getArrayFormdata() || new FormData();
				formData.append('houseid',ID);
				formData.append('oldID',oldID);
				formData.append('oldName',oldName);
				// formData.append('newID',newID);
				// formData.append('newName',newName);
				// formData.append('transferType',transferWay);
				// formData.append('transferRent',transferMoney);
				// formData.append('transferReason',transferReason);
				formData.append('transferName',transferName);
				formData.append('card',card);
				$.ajax({
				    type: "post",
				    url: "/ph/CorrectApply/add",
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
//变更类型增加别字更正
// $('#transferWay').change(function(){ 
// 	if($("#transferWay option:selected").text()=='别字更正')
// 	{
// 		$(".transfer_name").show();
// 		$(".transfer_money").hide();
// 		$(".transfer_reason").hide();

// $(".transfer_money").hide();	}
// 	else
// 	{
// 		$(".transfer_name").hide();
// 		$(".transfer_money").show();
// 		$(".transfer_reason").show();
// 	}
// }) 
//申请修改
$('.BtnChange').click(function(){
	var ID = $(this).val();
		console.log(ID);
	$.get('/ph/CorrectApply/edit/ChangeOrderID/'+ID,function(res){
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
			$.get('/ph/CorrectApply/delete/ChangeOrderID/'+ID,function(res){
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
				    url: "/ph/CorrectApply/edit",
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