$('.BtnChange').click(function(){
	var value = $(this).val();
	console.log(value);
	$.get('/ph/UserAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.data.detail.ChangeType=='更名'||res.data.detail.ChangeType=='过户'){
			$('.houseHide').css('display','none');
		}else{
			$('.houseHide').css('display','block');
		}
		$('.APcreateTimer').text(res.data.detail.CreateTime);
		$('.APhouseArear').text(res.data.detail.HouseArea);
		$('.APhouseIdr').text(res.data.detail.HouseID);
		$('.APleasedArear').text(res.data.detail.LeasedArea);
		$('.APtenantIDr').text(res.data.detail.TenantID);
		$('.APtenantNamer').text(res.data.detail.TenantName);
		$('.APtenantNumberr').text(res.data.detail.TenantNumber);
		$('.APtenantTelr').text(res.data.detail.TenantTel);
		 $('#approveNamer').text(res.data.detail.ChangeType);
		$('.APhouseAddressr').text(res.data.detail.BanAddress);
		$('.AFloorIDr').text(res.data.detail.FloorID);
		if(res.data.detail.IfReform==0){
			$('#IfReformr').text('否');
		}else{
			$('#IfReformr').text('是');
		}
		if(res.data.detail.IfRepair==0){
			$('#IfRepairr').text('否');
		}else{
			$('#IfRepairr').text('是');
		}
		if(res.data.detail.IfCollection==0){
			$('#IfCollectionr').text('否');
		}else{
			$('#IfCollectionr').text('是');
		}
		if(res.data.detail.IfFacade==0){
			$('#IfFacader').text('否');
		}else{
			$('#IfFacader').text('是');
		}
		if(res.data.detail.IfCheck==0){
			$('#IfCheckr').text('否');
		}else{
			$('#IfCheckr').text('是');
		}
		processState('#approveState',res);
		metailShow('#layer-photos-demo',res);
	});
	layer.open({
		type:1,
		area:['850px','600px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#detailForm'),
	});
});
//查看附件函数
function metailShow(id,res){
	var ImgLength = res.data.urls.length;
	var FatherDom = $(id);
	FatherDom.empty();
	for(var i = 0; i < ImgLength; i++){
		var ImgDom = $("<img style='width:100px;display:inline-block;' layer-pid="+i+" layer-src="+res.data.urls[i].FileUrl+" src="+res.data.urls[i].FileUrl+" alt="+res.data.urls[i].FileTitle+"/>");
		FatherDom.append(ImgDom);
	}
	layer.photos({
	  photos: '#layer-photos-demo'
	  ,anim: 5
	});
}
//流程配置函数
function processState(id,res){
	var ConfigLength = res.data.config.config.length;
	console.log(ConfigLength);
	var RecordLength = res.data.record.length;
	var FatherDom = $(id);
	var status = parseInt(res.data.config.status) * 2 - 1;
	FatherDom.empty();
	for(var i = 0; i < ConfigLength;i++){
		var SpanDom = $('<span class="process_style">'+res.data.config.config[i]+'</span><span>——></span>');
		FatherDom.append(SpanDom);
	}
	FatherDom.find('span').last().remove();
	for(var j = 0; j < ConfigLength*2-1; j++){
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