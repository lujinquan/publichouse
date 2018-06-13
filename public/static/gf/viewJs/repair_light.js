//明细
$('.detailsBtn').click(function(){
	var applyid = $(this).val();
	console.log(applyid);
	$.post("/ph/RepairLight/getLightDetail", {"applyId":applyid}, function(res){
		res = JSON.parse(res);
		console.log(res.data.light_detail);
		var light_detail = res.data.light_detail;
		$("input[name='Institution']").val(light_detail.Institution);
		$("input[name='BanAddress']").val(light_detail.BanAddress);
		var ownerType = '';
		switch(light_detail.OwnerType){
			case '1': ownerType = '市属'; break;
			case '2': ownerType = '区属'; break;
			case '3': ownerType = '代管'; break;
			case '4': ownerType = '预留'; break;
			case '5': ownerType = '自管'; break;
			case '6': ownerType = '生活'; break;
			case '7': ownerType = '托管'; break;
			default:ownerType = '';break;
		}
		$("input[name='OwnerType']").val(ownerType);
		$("input[name='AccountID']").val(light_detail.AccountID);
		$("input[name='LaborCost']").val(light_detail.LaborCost);
		$("input[name='MaterialCost']").val(light_detail.MaterialCost);
		$("input[name='CompanyToTenant']").val(light_detail.CompanyToTenant);
		$("input[name='Total']").val(light_detail.Total);
		$("input[name='CoefficientSalary']").val(light_detail.CoefficientSalary);
		$("input[name='ManageCost']").val(light_detail.ManageCost);
		$("input[name='TenantToCompany']").val(light_detail.TenantToCompany);
		$("input[name='EquipmentChange']").val(light_detail.EquipmentChange);
		$("input[name='ECTotal']").val(light_detail.ECTotal);
		$("input[name='ECLaborCost']").val(light_detail.ECLaborCost);
		$("input[name='ECManageCost']").val(light_detail.ECManageCost);
		$("input[name='ECMaterialCost']").val(light_detail.ECMaterialCost);
		$("input[name='RepairQuality']").val(light_detail.RepairQuality);
		$("input[name='InspectionRecord']").val(light_detail.InspectionRecord);
		$("input[name='TenantOpinion']").val(light_detail.TenantOpinion);
		$("input[name='AccountingClerk']").val(light_detail.AccountingClerk);
		$("input[name='CreateUserName']").val(light_detail.CreateUserName);
		$("input[name='Repairman']").val(light_detail.Repairman);
		$("input[name='CreateTime']").val(light_detail.CreateTime);
		$("input[name='TenantName']").val(light_detail.TenantName);
		var project_items = res.data.project_items;
		for (var i = 0; i < project_items.length; i++) {
			$("input[name='QuotaNumber[" + i + "]']").val(project_items[i].QuotaNumber);
			$("select[name='ItemID[" + i + "]']").val(project_items[i].ItemID);
			$("input[name='UnitOne[" + i + "]']").val(project_items[i].UnitOne);
			$("input[name='ProjectNum[" + i + "]']").val(project_items[i].ProjectNum);
			$("input[name='PersonNum[" + i + "]']").val(project_items[i].PersonNum);
			$("input[name='ratio[" + i + "]']").val(project_items[i].ratio);
			$("input[name='PreWorkdays[" + i + "]']").val(project_items[i].PreWorkdays);
			$("input[name='RealWorkdays[" + i + "]']").val(project_items[i].RealWorkdays);
			$("input[name='MaterialName[" + i + "]']").val(project_items[i].MaterialName);
			$("input[name='UnitTwo[" + i + "]']").val(project_items[i].UnitTwo);
			$("input[name='UnitPrice[" + i + "]']").val(project_items[i].UnitPrice);
			$("input[name='PreMaterialNum[" + i + "]']").val(project_items[i].PreMaterialNum);
			$("input[name='PreMaterialCost[" + i + "]']").val(project_items[i].PreMaterialCost);
			$("input[name='RealMaterialNum[" + i + "]']").val(project_items[i].RealMaterialNum);
			$("input[name='RealMaterialCost[" + i + "]']").val(project_items[i].RealMaterialCost);
			$("input[name='OldMaterialNum[" + i + "]']").val(project_items[i].OldMaterialNum);
			$("input[name='OldMaterialCost[" + i + "]']").val(project_items[i].OldMaterialCost);
		}
	});
	layer.open({
		type:1,
		area:['800px','700px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#detailForm'),
		success:function(){

		},
		yes:function(){
			
		}
	});
});
//维修处理
$('.repairHandle').click(function(){
	layer.open({
		type:1,
		area:['800px','700px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['打印表单','维修完成','取消'],
		content:$('#repairForm'),
		success:function(){
			var one = new file({
				button:"#survey",
				show:"#surveyShow",
				upButton:"#surveyUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"图纸"
			});
			var two = new file({
				button:"#afterHandle",
				show:"#afterHandleShow",
				upButton:"#afterHandleUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"图纸"
			});
		},
		yes:function(){
			window.print();
		},
		btn2:function(){

		}
	});
});
//流程配置函数
function processState(id,res){
	var ConfigLength = res.data.config.config.length;
	var RecordLength = res.data.record.length;
	var FatherDom = $(id);
	var status = parseInt(res.data.config.status) * 2 - 1;
	FatherDom.empty();
	for(var i = 0; i < ConfigLength;i++){
		var SpanDom = $('<span class="process_style">'+res.data.config.config[i]+'</span><span>——></span>');
		FatherDom.append(SpanDom);
	}
	FatherDom.find('span').last().remove();
	for(var j = 0; j < status; j++){
		if(j % 2== 0){
			FatherDom.find('span').eq(j).addClass('process_style_active');
		}else{
			FatherDom.find('span').eq(j).addClass('line_style');
		}
	}
	for(var k = 1;k <= RecordLength;k++){
		if(res.data.record[k-1].Status == 2){
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1].RoleName+"［"+res.data.record[k-1].UserNumber+"］于"+res.data.record[k-1].CreateTime+res.data.record[k-1].Step+"；</p>");
		}else{
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1].RoleName+"［"+res.data.record[k-1].UserNumber+"］于"+res.data.record[k-1].CreateTime+res.data.record[k-1].Status+"，原因："+res.data.record[k-1].Reson+"；</p>");
		}
		
		FatherDom.append(RecordDom);
	}
}