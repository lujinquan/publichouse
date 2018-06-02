//明细
$('.detailsBtn').click(function(){
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
//中修计划
$('#addMRepair').click(function(){
	layer.open({
		type:1,
		area:['800px','700px'],
		resize:false,
		zIndex:100,
		title:['中修计划','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['审批通过','取消'],
		content:$('#approveForm'),
		success:function(){

		},
		yes:function(){

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