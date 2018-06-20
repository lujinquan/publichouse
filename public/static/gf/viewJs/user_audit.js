//补充资料
var dong = 1;
var DOM_1 = $('.material_1').clone(true);
var DOM_2 = $('.material_2').clone(true);
$('.material_1').remove();
$('.material_2').remove();
$('.material_3').hide();
$("#addInfo").click(function(){
	var obj = $('.checkId');
	for(var k in obj){
		if(obj[k].checked){
			var ID = obj[k].value;
		}
	}
	console.log(ID);
	if(ID == undefined){
		layer.msg('请先选择变更编号！');
	}else{
		$.get('/ph/UserAudit/supply/ChangeOrderID/'+ID,function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.retcode == 4005 || res.retcode == 5000){
				layer.msg(res.msg);
			}else{
				$('.changeType').text(res.data.detail.CreateTime);
				$('.houseArea').text(res.data.detail.HouseArea);
				$('.houseId').text(res.data.detail.HouseID);
				$('.leasedArea').text(res.data.detail.LeasedArea);
				$('.houseAddress').text(res.data.detail.BanAddress);
				$('.FloorID').text(res.data.detail.FloorID);
				$('.createTime').text(res.data.detail.CreateTime);

				$('.TransferRent').text(res.data.detail.TransferRent);
				$('.NewTenantName').text(res.data.detail.NewTenantName);
				$('.NewTenantNumber').text(res.data.detail.NewTenantNumber);
				$('.NewTenantTel').text(res.data.detail.NewTenantTel);
				$('.OldTenantName').text(res.data.detail.OldTenantName);
				$('.OldTenantNumber').text(res.data.detail.OldTenantNumber);
				$('.OldTenantTel').text(res.data.detail.OldTenantTel);
				$('.material_3_status_2').hide();
				if(res.data.config.status == '1'){
					$('.status_2').show();
					$('.status_3').hide();
					$("input[name='IfReform'][value="+res.data.detail.IfReform+"]").attr('checked','checked');
					$("input[name='IfRepair'][value="+res.data.detail.IfRepair+"]").attr('checked','checked');
					$("input[name='IfCollection'][value="+res.data.detail.IfCollection+"]").attr('checked','checked');
					$("input[name='IfFacade'][value="+res.data.detail.IfFacade+"]").attr('checked','checked');
				}else{
					$('.status_2').hide();
					$('.status_3').show();
					if(res.data.detail.IfReform=="0"){
						$('.IfReform').text('否');
					}else{
						$('.IfReform').text('是');
					}
					if(res.data.detail.IfRepair=="0"){
						$('.IfRepair').text('否');
					}else{
						$('.IfRepair').text('是');
					}
					if(res.data.detail.IfCollection=="0"){
						$('.IfCollection').text('否');
					}else{
						$('.IfCollection').text('是');
					}
					if(res.data.detail.IfFacade=="0"){
						$('.IfFacade').text('否');
					}else{
						$('.IfFacade').text('是');
					}
				}

				processState('#FormState',res);
			//类型判断开始
				if(res.data.detail.ChangeType=="更名"){
					$('#TypeName').text('更名');
					if($('.material_2')){
						$('.material_2').remove();
					}
					if($('.material_3')){
						$('.material_3').remove();
					}
					if($('.material_1').length == 0){
						$('#addContent').after(DOM_1);
					}
					var one = new file({
						button:"#ReBooklet",
						show:"#Dshow",
						upButton:"#ReBookletUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"更改姓名后户口簿"
					});
					var two = new file({
						button:"#ReIDCard",
						show:"#ReIDCardShow",
						upButton:"#ReIDCardUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"更改姓名后居民身份证"
					});
					var two = new file({
						button:"#ReContract",
						show:"#ReContractShow",
						upButton:"#ReContractUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"国有公房（民用住宅）租赁合同"
					});
					AddInfo(ID);
				}else if(res.data.detail.ChangeType=="过户"){
					$('#TypeName').text('过户');
					if($('.material_1')){
						$('.material_1').remove();
					}
					if($('.material_3')){
						$('.material_3').remove();
					}
					if($('.material_2').length == 0){
						$('#addContent').after(DOM_2);
					}
					new file({
						button:"#CnApplicationForm",
						show:"#CnApplicationFormShow",
						upButton:"#CnApplicationFormUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"申请书"
					});
					new file({
						button:"#CnApBooklet",
						show:"#CnApBookletShow",
						upButton:"#CnApBookletUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"申请人户口簿"
					});
					new file({
						button:"#CnApIDCard",
						show:"#CnApIDCardShow",
						upButton:"#CnApIDCardUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"申请人身份证、图章"
					});
					new file({
						button:"#CnContract",
						show:"#CnContractShow",
						upButton:"#CnContractUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"国有公房（民用住宅）租赁合同"
					});
					new file({
						button:"#CnDeathProve",
						show:"#CnDeathProveShow",
						upButton:"#CnDeathProveUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"原承租人死亡的，提交死亡证明"
					});
					new file({
						button:"#CnMigProve",
						show:"#CnMigProveShow",
						upButton:"#CnMigProveUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"原承租人户籍迁出本市的，提交户籍注销证明"
					});
					new file({
						button:"#CnLitig",
						show:"#CnLitigShow",
						upButton:"#CnLitigUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"诉讼离婚的，提交人民法院判决书或者调解书"
					});
					new file({
						button:"#CnAgreement",
						show:"#CnAgreementShow",
						upButton:"#CnAgreementUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"协议离婚的，提交经民政部门备案的离婚协议书"
					});
					new file({
						button:"#CnDivorce",
						show:"#CnDivorceShow",
						upButton:"#CnDivorceUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"离婚证"
					});
					new file({
						button:"#CnAttachmentOne",
						show:"#CnAttachmentOneShow",
						upButton:"#CnAttachmentOneUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"附件一：公有住房指定承租人协议书（需公证）"
					});
					new file({
						button:"#CnAttachmentTwo",
						show:"#CnAttachmentTwoShow",
						upButton:"#CnAttachmentTwoUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"附件二：公有住房过户协议书"
					});
					new file({
						button:"#CnAttachmentThr",
						show:"#CnAttachmentThrShow",
						upButton:"#CnAttachmentThrUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"附件三：公有住房承租声明"
					});
					new file({
						button:"#CnAttachmentFour",
						show:"#CnAttachmentFourShow",
						upButton:"#CnAttachmentFourUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"附件四：公有住房承租保证"
					});
					new file({
						button:"#CnAttachmentFive",
						show:"#CnAttachmentFiveShow",
						upButton:"#CnAttachmentFiveUp",
						size:1024,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"附件五：公有住房承租承诺书"
					});
					AddInfo(ID);
				}else if(res.data.detail.ChangeType=="赠予" || res.data.detail.ChangeType=="转让"){
					if(res.data.detail.ChangeType=="赠予"){
						$('#TypeName').text('转增亲友');
					}else{
						$('#TypeName').text('转让');
					}
					//DOM修改
					if($('.material_1')){
						$('.material_1').remove();
					}
					if($('.material_2')){
						$('.material_2').remove();
					}
					if(res.data.config.status == '1'){
						$('.material_3_status_2').show();
						new file({
							button:"#RecordSheet",
							show:"#RecordSheetShow",
							upButton:"#RecordSheetUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"直管公房有偿转让备案单"
						});
					}else{
						$('.status_3').show();
						$('.material_3').show();
						new file({
							button:"#TrApplicationForm",
							show:"#TrApplicationFormShow",
							upButton:"#TrCheckUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"住宅租约"
						});
						new file({
							button:"#TrApBooklet",
							show:"#TrApBookletShow",
							upButton:"#TrApBookletUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"原承租人户口"
						});
						new file({
							button:"#TrContract",
							show:"#TrContractShow",
							upButton:"#TrContractUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"现承租人户口"
						});
						new file({
							button:"#TrApIDCard",
							show:"#TrApIDCardShow",
							upButton:"#TrApIDCardUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"身份证"
						});
						new file({
							button:"#TrAgreementOne",
							show:"#TrAgreementOneShow",
							upButton:"#TrAgreementOneUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"结婚证"
						});
						new file({
							button:"#TrAgreementTwo",
							show:"#TrAgreementTwoShow",
							upButton:"#TrAgreementTwoUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"共有子女的证明材料"
						});
						new file({
							button:"#TrAgreementThr",
							show:"#TrAgreementThrShow",
							upButton:"#TrAgreementThrUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"亲属关系证明材料"
						});
						new file({
							button:"#TrDeathProve",
							show:"#TrDeathProveShow",
							upButton:"#TrDeathProveUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"死亡证"
						});
						new file({
							button:"#TrAttachmentOne",
							show:"#TrAttachmentOneShow",
							upButton:"#TrAttachmentOneUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"离婚证"
						});
						new file({
							button:"#TrAttachmentTwo",
							show:"#TrAttachmentTwoShow",
							upButton:"#TrAttachmentTwoUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"离婚协议书"
						});
						new file({
							button:"#TrAttachmentThr",
							show:"#TrAttachmentThrShow",
							upButton:"#TrAttachmentThrUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"过户协议书"
						});
						new file({
							button:"#TrAttachmentFour",
							show:"#TrAttachmentFourShow",
							upButton:"#TrAttachmentFourUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"武汉市直管公房使用权有偿转让、受让审批表"
						});
						new file({
							button:"#TrAttachmentFive",
							show:"#TrAttachmentFiveShow",
							upButton:"#TrAttachmentFiveUp",
							size:1024,
							url:"/ph/UserAudit/supply",
							ChangeOrderID:res.data.detail.ChangeOrderID,
							title:"武汉市公有房屋使用权转让协议"
						});
					}
					
					AddInfo(ID,res.data.config.status,res.data.detail);
				}
			//类型判断结束	
			}
		})
	}
});
//审批
$('.BtnApprove').click(function(){
	var value = $(this).val();
	$.get('/ph/UserAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		if(res.data.detail.ChangeType=='更名'||res.data.detail.ChangeType=='过户'){
			$('.houseHide').css('display','none');
		}else{
			$('.houseHide').css('display','block');
		}
		$('.APhouseId').text(res.data.detail.HouseID);
		$('.APcreateTime').text(res.data.detail.CreateTime);
		$('.APhouseArea').text(res.data.detail.HouseArea);
		$('.APleasedArea').text(res.data.detail.LeasedArea);
		$('.APhouseAddress').text(res.data.detail.BanAddress);
		$('.AFloorID').text(res.data.detail.FloorID);
		$('.OldTenantName').text(res.data.detail.OldTenantName);
		$('.OldTenantNumber').text(res.data.detail.OldTenantNumber);
		$('.OldTenantTel').text(res.data.detail.OldTenantTel);
		$('.NewTenantName').text(res.data.detail.NewTenantName);
		$('.NewTenantNumber').text(res.data.detail.NewTenantNumber);
		$('.NewTenantTel').text(res.data.detail.NewTenantTel);
		$('#approveName').text(res.data.detail.ChangeType);
		if(res.data.detail.IfReform=="0"){
			$('.IfReform').text('否');
		}else{
			$('.IfReform').text('是');
		}
		if(res.data.detail.IfRepair=="0"){
			$('.IfRepair').text('否');
		}else{
			$('.IfRepair').text('是');
		}
		if(res.data.detail.IfCollection=="0"){
			$('.IfCollection').text('否');
		}else{
			$('.IfCollection').text('是');
		}
		if(res.data.detail.IfFacade=="0"){
			$('.IfFacade').text('否');
		}else{
			$('.IfFacade').text('是');
		}
		
		processState('#approveState',res);
		metailShow('#layer-photos-demo',res);
	});
	layer.open({
		type:1,
		area:['990px','700px'],
		resize:false,
		zIndex:100,
		title:['审批','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#approveForm'),
		btn:['通过','不通过'],
		yes:function(thisIndex){
			$.post('/ph/UserAudit/process/',{ChangeOrderID:value},function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.msg(res.msg);
			});
			layer.close(thisIndex);
			 location.reload(); 
		},
		btn2:function(){
			layer.open({
				type:1,
				area:['400px','400px'],
				resize:false,
				zIndex:100,
				title:['不通过原因','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:'<textarea id="reason" style="width:350px;height:290px;margin-top:10px;border:1px solid #c1c1c1;resize: none;margin-left: 25px;"></textarea>',
				btn:['确认'],
				yes:function(msgIndex){
					var reasonMsg = $('#reason').val();
					if(reasonMsg==''){
						reasonMsg='无';
					}else{
						 reasonMsg = $('#reason').val();
					}
					console.log(reasonMsg);
					$.post('/ph/UserAudit/process/',{ChangeOrderID:value,reson:reasonMsg},function(res){
						res = JSON.parse(res);
						console.log(res);
						layer.msg(res.msg);
						console.log(res.msg);
					});
					layer.close(msgIndex);
					location.reload();
				}
			})
		}
	});
	layer.photos({
	  photos: '#layer-photos-demo'
	  ,anim: 5
	});
});
//明细
$('.BtnDetail').click(function(){
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
		$('.APcreateTime').text(res.data.detail.CreateTime);
		$('.APhouseArea').text(res.data.detail.HouseArea);
		$('.APhouseId').text(res.data.detail.HouseID);
		$('.APleasedArea').text(res.data.detail.LeasedArea);
		$('#approveName').text(res.data.detail.ChangeType);
		$('.APhouseAddress').text(res.data.detail.BanAddress);
		$('.AFloorID').text(res.data.detail.FloorID);
		$('.APtransferRent').text(res.data.detail.TransferRent);
		$('.OldTenantName').text(res.data.detail.OldTenantName);
		$('.OldTenantNumber').text(res.data.detail.OldTenantNumber);
		$('.OldTenantTel').text(res.data.detail.OldTenantTel);
		$('.NewTenantName').text(res.data.detail.NewTenantName);
		$('.NewTenantNumber').text(res.data.detail.NewTenantNumber);
		$('.NewTenantTel').text(res.data.detail.NewTenantTel);

		if(res.data.detail.IfReform==0){
			$('.IfReform').text('否');
		}else{
			$('.IfReform').text('是');
		}
		if(res.data.detail.IfRepair==0){
			$('.IfRepair').text('否');
		}else{
			$('.IfRepair').text('是');
		}
		if(res.data.detail.IfCollection==0){
			$('.IfCollection').text('否');
		}else{
			$('.IfCollection').text('是');
		}
		if(res.data.detail.IfFacade==0){
			$('.IfFacade').text('否');
		}else{
			$('.IfFacade').text('是');
		}
		
		// $('#IfRepair').text(res.data.detail.IfRepair);
		// $('#IfCollection').text(res.data.detail.IfCollection);
		// $('#IfFacade').text(res.data.detail.IfFacade);
		processState('#approveState',res);
		metailShow('#layer-photos-demo',res);
	});
	layer.open({
		type:1,
		area:['990px','700px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#approveForm')
	});
});

//资料补充弹窗封装
function AddInfo(ID,status,detail){
	if(status== '1'){
		var btn = ['确认','取消','不通过'];
	}else{
		var btn = ['确认','取消'];
	}
	layer.open({
		type:1,
		area:['990px','700px'],
		resize:false,
		zIndex:100,
		title:['资料补充','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#addForm'),
		btn:btn,
		cancel:function(){
			$('.fileUploadContent').empty();
		},
		yes:function(thisIndex){
			var formData = fileTotall.getArrayFormdata();
			console.log(formData);
			formData.append('ChangeOrderID',ID);
			if(status== '1'){
				formData.append('IfReform',$("input[name='IfReform']:checked").val());
				formData.append('IfRepair',$("input[name='IfRepair']:checked").val());
				formData.append('IfCollection',$("input[name='IfCollection']:checked").val());
				formData.append('IfFacade',$("input[name='IfFacade']:checked").val());
			}else{
				formData.append('IfReform',detail.IfReform);
				formData.append('IfRepair',detail.IfRepair);
				formData.append('IfCollection',detail.IfCollection);
				formData.append('IfFacade',detail.IfFacade);
			}
			$.ajax({
                type:"post",
                url:"/ph/UserAudit/supply",
                data:formData,
                processData:false,
                contentType:false,
                success:function(res){
                    res = JSON.parse(res);
                       console.log(res);
                    layer.msg(res.msg);
                 
                    layer.close(thisIndex);
                    location.reload();
                }
            });
		},
		btn2:function(){

		},
		btn3:function(){
			layer.open({
				type:1,
				area:['400px','400px'],
				resize:false,
				zIndex:100,
				title:['不通过原因','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:'<textarea id="reason" style="width:350px;height:290px;margin-top:10px;border:1px solid #c1c1c1;resize: none;margin-left: 25px;"></textarea>',
				btn:['确认'],
				yes:function(msgIndex){
					var reasonMsg = $('#reason').val();
					if(reasonMsg==''){
						reasonMsg='无';
					}else{
						 reasonMsg = $('#reason').val();
					}
					console.log(reasonMsg);
					$.post('/ph/UserAudit/process/',{ChangeOrderID:ID,reson:reasonMsg},function(res){
						res = JSON.parse(res);
						console.log(res);
						layer.msg(res.msg);
						console.log(res.msg);
					});
					layer.close(msgIndex);
					location.reload();
				}
			})
		}
	});
}
//查看附件函数
function metailShow(id,res){
	var ImgLength = res.data.urls.length;
	var img_title = [];
	var	img_array = [];
	res.data.urls.forEach(function(data){
		var index = img_title.indexOf(data.FileTitle);
		if(index < 0){
			img_title.push(data.FileTitle);
			img_array[img_array.length] = [];
			img_array[img_array.length - 1].push(data.FileUrl);
		}else{
			img_array[index].push(data.FileUrl);
		}
	});
	var FatherDom = $(id);
	FatherDom.empty();
	for(var i = 0; i < img_title.length; i++){
		var title_dom = $("<p style='margin:5px auto;font-size:14px;'>" + img_title[i] + "</p>");
		FatherDom.append(title_dom);
		for(var j = 0;j < img_array[i].length;j++){
			var ImgDom = $("<img style='width:100px;display:inline-block;' layer-pid="+i+" layer-src="+
				img_array[i][j]+" src="+img_array[i][j] + " alt="+img_title[i]+"/>");
			FatherDom.append(ImgDom);
		}
	}
	layer.photos({
	  photos: '#layer-photos-demo'
	  ,anim: 5
	});
}
//流程配置函数
function processState(id,res){
	var ConfigLength = res.data.config.config.length;
	var RecordLength = res.data.record.length;
	var FatherDom = $(id);
	var status = parseInt(res.data.config.status) * 2 - 1;
	FatherDom.empty();
	for(var i = 0; i < ConfigLength;i++){
		var SpanDom = $('<span class="process_style">'+res.data.config.config[i]+'</span><span><i class="am-icon-lg am-icon-long-arrow-right" +\
			style="margin:auto 4px;"></i></span>');
		FatherDom.append(SpanDom);
	}
	FatherDom.find('span').last().remove();
	for(var j = 0; j < status; j++){
		if(j % 2== 0){
			FatherDom.find('span').eq(j).addClass('process_style_active');
		}else{
			FatherDom.find('span').eq(j).find('i').addClass('line_style');
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