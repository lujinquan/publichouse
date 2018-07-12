//补充资料
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
				$('.approveName').text(res.data.detail.ChangeType);
				$('.useNature').text(res.data.detail.UseNature);
				$('.OwnerType').text(res.data.detail.OwnerType);
				$('.ChangeReason').text(res.data.detail.ChangeReason);

				$('.TransferRent').text(res.data.detail.TransferRent);
				$('.NewTenantName').text(res.data.detail.NewTenantName);
				$('.NewTenantNumber').text(res.data.detail.NewTenantNumber);
				$('.NewTenantTel').text(res.data.detail.NewTenantTel);
				$('.OldTenantName').text(res.data.detail.OldTenantName);
				$('.OldTenantNumber').text(res.data.detail.OldTenantNumber);
				$('.OldTenantTel').text(res.data.detail.OldTenantTel);

				$('.material_3_status_2').hide();
				if(res.data.config.status == '1'){//资料员补充资料
					$('.status_2').show();
					$('.status_3').hide();
					// new file({
					// 	button:"#approveApplyReport",
					// 	show:"#approveApplyReportShow",
					// 	upButton:"#approveApplyReportUp",
					// 	size:10240,
					// 	url:"/ph/UserAudit/supply",
					// 	ChangeOrderID:'',
					// 	title:"书面申请报告"
					// });
					$("input[name='IfReform'][value="+res.data.detail.IfReform+"]").attr('checked','checked');
					$("input[name='IfRepair'][value="+res.data.detail.IfRepair+"]").attr('checked','checked');
					$("input[name='IfCollection'][value="+res.data.detail.IfCollection+"]").attr('checked','checked');
					$("input[name='IfFacade'][value="+res.data.detail.IfFacade+"]").attr('checked','checked');
				}else if(res.data.config.status == '2'){//房调员补充资料
					$('.status_2').hide();
					$('.status_3').show();
					$('.material_1').show();

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
					new file({
						button:"#transferMaterial_1",
						show:"#transferMaterial_1Show",
						upButton:"#transferMaterial_1Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"死亡证"
					});
					new file({
						button:"#transferMaterial_2",
						show:"#transferMaterial_2Show",
						upButton:"#transferMaterial_2Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"原承租人户口"
					});
					new file({
						button:"#transferMaterial_3",
						show:"#transferMaterial_3Show",
						upButton:"#transferMaterial_3Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"现承租人户口"
					});
					new file({
						button:"#transferMaterial_4",
						show:"#transferMaterial_4Show",
						upButton:"#transferMaterial_4Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"住宅租约"
					});
					new file({
						button:"#transferMaterial_5",
						show:"#transferMaterial_5Show",
						upButton:"#transferMaterial_5Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"结婚证"
					});
					new file({
						button:"#transferMaterial_6",
						show:"#transferMaterial_6Show",
						upButton:"#transferMaterial_6Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"现承租人身份证"
					});
					new file({
						button:"#transferMaterial_7",
						show:"#transferMaterial_7Show",
						upButton:"#transferMaterial_7Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"武汉市直管公房承租人过户申请审批表"
					});
					new file({
						button:"#transferMaterial_8",
						show:"#transferMaterial_8Show",
						upButton:"#transferMaterial_8Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"武汉市直管公房承租人过户协议书"
					});
					new file({
						button:"#transferMaterial_9",
						show:"#transferMaterial_9Show",
						upButton:"#transferMaterial_9Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"共有子女材料证明"
					});
					new file({
						button:"#transferMaterial_10",
						show:"#transferMaterial_10Show",
						upButton:"#transferMaterial_10Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"离婚协议书"
					});
					new file({
						button:"#transferMaterial_11",
						show:"#transferMaterial_11Show",
						upButton:"#transferMaterial_11Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"武汉市公有房屋使用权转让协议"
					});
					new file({
						button:"#transferMaterial_12",
						show:"#transferMaterial_12Show",
						upButton:"#transferMaterial_12Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"武汉市公有住房承租权有偿转让申请书"
					});
					new file({
						button:"#transferMaterial_13",
						show:"#transferMaterial_13Show",
						upButton:"#transferMaterial_13Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"同意办理公有住房使用权转让或者代理转让协议"
					});
					new file({
						button:"#transferMaterial_14",
						show:"#transferMaterial_14Show",
						upButton:"#transferMaterial_14Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"材料承诺书"
					});
					new file({
						button:"#transferMaterial_15",
						show:"#transferMaterial_15Show",
						upButton:"#transferMaterial_15Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"家庭成员身份证明"
					});
					new file({
						button:"#transferMaterial_16",
						show:"#transferMaterial_16Show",
						upButton:"#transferMaterial_16Up",
						size:10240,
						url:"/ph/UserAudit/supply",
						ChangeOrderID:res.data.detail.ChangeOrderID,
						title:"缴费承诺书"
					});
				}else{

				}
				//metailShow('#lookingUpStatus3',res);
				processState('#FormState',res);
				AddInfo(ID,res.data.config.status,res.data.detail);
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
		$('.APtransferRent').text(res.data.detail.TransferRent);
		$('.AFloorID').text(res.data.detail.FloorID);
				$('.approveName').text(res.data.detail.ChangeType);
				$('.useNature').text(res.data.detail.UseNature);
				$('.OwnerType').text(res.data.detail.OwnerType);
				$('.ChangeReason').text(res.data.detail.ChangeReason);

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
				$('.approveName').text(res.data.detail.ChangeType);
				$('.useNature').text(res.data.detail.UseNature);
				$('.OwnerType').text(res.data.detail.OwnerType);
				$('.ChangeReason').text(res.data.detail.ChangeReason);


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
	if(status== '1' ||status== '2'){
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
			if(status == "1"){
				var formData = new FormData();
			}else{
				var formData = fileTotall.getArrayFormdata();
			}
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