//新增租金减免
$('#derateApply').click(function(){
	var num=0;
	layer.open({
				type:1,
				area:['600px','600px'],
				resize:false,
				zIndex:100,
				title:['新增租金减免','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content: $('#derateApplyForm'),
				btn:['确定','取消'],
				success:function(){

					$(".breaks").show();
						$('#DQueryData').on("click",function(){
							var HouseID = $('#getInfo_1').val();
							$.get('/ph/Api/get_house_info/HouseID/'+HouseID,function(res){
								res = JSON.parse(res);
								console.log(res);
								layer.msg(res.msg,{time:4000});
								$("#BanID").text(res.data.BanID);
								$("#BanAddress").text(res.data.BanAddress);
								$("#CreateTime").text(res.data.CreateTime);
								$("#FloorID").text(res.data.FloorID);
								$("#HouseArea").text(res.data.HouseUsearea);
								//$("#HouseArea").text(res.data.HouseUsearea);
								$("#LeasedArea").text(res.data.LeasedArea);
								$("#TenantName").text(res.data.TenantName);
								$("#TenantNumber").text(res.data.TenantNumber);
								$("#TenantTel").text(res.data.TenantTel);
								
							});
						});
					houseQuery.action('getInfo_1','1');
					var one = new file({
						button:"#ID",
						show:"#IDShow",
						upButton:"#IDUp",
						size:5120,
						url:"/ph/ChangeApply/add",
						ChangeOrderID:'',
						Type:1,
						title:"证件上传"
					});
					var two = new file({
						button:"#AppForm",
						show:"#AppFormShow",
						upButton:"#AppFormUp",
						size:5120,
						url:"/ph/ChangeApply/add",
						ChangeOrderID:'',
						Type:1,
						title:"证件上传"
					});
					var three = new file({
						button:"#AppBook",
						show:"#AppBookShow",
						upButton:"#AppBookUp",
						size:5120,
						url:"/ph/ChangeApply/add",
						ChangeOrderID:'',
						Type:1,
						title:"证件上传"
					});
					var four = new file({
						button:"#ReBooklet",
						show:"#ReBookletShow",
						upButton:"#ReBookletUp",
						size:5120,
						url:"/ph/ChangeApply/add",
						ChangeOrderID:'',
						Type:1,
						title:"证件上传"
					});
					var five = new file({
						button:"#HouseLease",
						show:"#HouseLeaseShow",
						upButton:"#HouseLeaseUp",
						size:5120,
						url:"/ph/ChangeApply/add",
						ChangeOrderID:'',
						Type:1,
						title:"证件上传"
					});
				},
				yes:function(thisIndex){
					
					if($('#getInfo_1').val() == ""){
						layer.msg('房屋编号存在问题呢！！！',{time:4000});
					}else{
						var formData = fileTotall.getArrayFormdata();
			            if(fileTotall.array.length!=0){
						num++;
						if(num==1){
						formData.append("CutType",$('#CutType').val());
						formData.append("IDnumber",$('#IDnumber').val());
						formData.append("validity",$('#validity').val());
						formData.append("HouseID",$('#getInfo_1').val());
						formData.append("RemitRent",$('#RemitRent').val());
						formData.append("type",1);
			            $.ajax({
			                type:"post",
			                url:"/ph/ChangeApply/add",
			                data:formData,
			                processData:false,
			                contentType:false,
			                success:function(res){
			                	
			                    res = JSON.parse(res);
			                    layer.msg(res.msg,{time:4000});
			                    layer.close(thisIndex);
			                    location.reload();
			                }
			            });
						}						
			            }			           
					}
				}
			});
});
//查看明细
$('.details').click(function(){
	$('#services-box').html("");  
	var thisID = $(this).val();
	console.log(thisID);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('.APhouseId').text(res.data.detail.HouseID);
			$('.APBanID').text(res.data.detail.BanID);
			$('.APhouseAddress').text(res.data.detail.BanAddress);
			$('.APFloorID').text(res.data.detail.FloorID);
			$('.APtenantName').text(res.data.detail.TenantName);
			$('.APtenantTel').text(res.data.detail.TenantTel);
			$('.APtenantNumber').text(res.data.detail.TenantNumber);
			$('.APcreateTime').text(res.data.detail.CreateTime);
			$('.APhouseArea').text(res.data.detail.HouseArea);
			$('.APleasedArea').text(res.data.detail.LeasedArea);
			$('#breakTyped').text(res.data.detail.CutName);
			$('#IDNumberd').text(res.data.detail.IDnumber);
			$('#validityd').text(res.data.detail.MuchMonth);
			
			if(res.data.detail.CutYearRecord.length){
				$(".j-annual-box").show();
				for(var i = 0; i < res.data.detail.CutYearRecord.length; i++){
					// $(".j-annual-box").show();
					// $("#jtransferReasons").val(res.data.detail.CutYearRecord[i].CutNumber);//减免证号
					// $("#jtransferMoneys").val(res.data.detail.CutYearRecord[i].CutRent);//减免金额
					// $("#jtransferClasss").val(res.data.detail.CutYearRecord[i].CutType);//减免类型
					// metailShows('#jlayer-photos-demo-annual',res);
					if(res.data.detail.CutYearRecord[i].Status == 0){
						if(!res.data.detail.CutYearRecord[i].Reson){
							res.data.detail.CutYearRecord[i].Reson = '空';
						}
						var statuMsg = '年审不通过!,原因:'+ res.data.detail.CutYearRecord[i].Reson;
					}else if(res.data.detail.CutYearRecord[i].Status == 1){
						var statuMsg = '年审通过!';
					}else{
						var statuMsg = '年审中!';
					}
					var htmls ='<div class="am-u-md-12" style="padding-left:0;">\
								<div class="am-form-group am-u-md-12">\
									<div style="border-top: #ccc 1px solid; padding-bottom: 10px;  margin-left: 16px;"></div>\
									<div class="am-u-md-6">\
									  <label>年审信息：<span style="color:red">'+statuMsg +'</span></label>\
									</div>\
								</div>\
							  </div>\
					          <div class="am-form-group am-u-sm-12">\
									<div class="am-u-md-4" style="margin:20px auto 30px;">\
										<label class="label_style">减免类型：</label>\
										<input class="label_input" readonly id="jtransferClasss'+i+'" require value="'+ res.data.detail.CutYearRecord[i].CutType +'" />\
									</div>\
									<div class="am-u-md-4 transfer_money" style="padding-left:0;margin:20px auto 30px;">\
										<label class="label_style">减免金额：</label>\
										<input class="label_input" readonly id="jtransferMoneys'+i+'" require value="'+ res.data.detail.CutYearRecord[i].CutRent +'" />\
									</div>\
									<div class="am-u-md-4 transfer_reason" style="padding-left:0;margin:20px auto 30px;">\
										<label>减免证号：</label>\
										<input class="label_input" readonly id="jtransferReasons'+i+'" value="'+ res.data.detail.CutYearRecord[i].CutNumber +'" />\
									</div>\
								</div>\
								<div class="am-form-group am-u-md-12">\
								  <div class="am-u-md-6">\
									<label>年审信息：</label>\
								  </div>\
								  <div id="jlayer-photos-demo-annual'+i+'" class="am-u-md-12">\
								  </div>\
								</div>';
								$('#services-box').append(htmls);
								metailShows("#jlayer-photos-demo-annual"+i,res,1,i);
				}
			}
			else{
				$(".j-annual-box").hide();
			}
			
			processState('#approveState',res);
			metailShow('#layer-photos-demo',res);
			
			
			
		//res = JSON.parse(res);
		layer.open({
			type:1,
			area:['950px','600px'],
			resize:false,
			zIndex:100,
			title:['查看明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$("#approveForm")
		});
	});
});

$('.cancelRentCut').click(function(){
	var thisID = $(this).val();
	//console.log(thisID);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('.APhouseId').text(res.data.detail.HouseID);
		$('.APBanID').text(res.data.detail.BanID);
		$('.APhouseAddress').text(res.data.detail.BanAddress);
		$('.APFloorID').text(res.data.detail.FloorID);
		$('.APtenantName').text(res.data.detail.TenantName);
		$('.APtenantTel').text(res.data.detail.TenantTel);
		$('.APtenantNumber').text(res.data.detail.TenantNumber);
		$('.APcreateTime').text(res.data.detail.CreateTime);
		$('.APhouseArea').text(res.data.detail.HouseArea);
		$('.APleasedArea').text(res.data.detail.LeasedArea);
		$('#breakTypeds').text(res.data.detail.CutName);
		$('#IDNumberds').text(res.data.detail.IDnumber);
		$('#validityds').text(res.data.detail.MuchMonth);
		processState('#approveStateCancel',res);
		metailShow('#layer-photos-demo-cancel',res);
		//return false;
		//res = JSON.parse(res);
		layer.open({
			type:1,
			area:['950px','600px'],
			resize:false,
			zIndex:100,
			title:['减免年审','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$("#approveFormCancel"),
			btn:['保存','取消'],
            success: function(){
            	var one = new file({
					button:"#cancelapprove",
					show:"#cancelapproveShow",
					upButton:"#cancelapprove",
					size:5120,
					url:"/ph/RentCut/cancelCut",
					ChangeOrderID:'',
					Type:1,
					title:"取消减免报告上传"
				});
            },
            yes: function(thisIndex) {
                //if ($('#getInfo_1').val() == "") {
                    //layer.msg('房屋编号存在问题呢！！！',{time:4000});
                //} else {
                    var formData = fileTotall.getArrayFormdata();
                    // formData.append("CutType", $('#CutType').val());
                    // formData.append("IDnumber", $('#IDnumber').val());
                    // formData.append("validity", $('#validity').val());
                    // formData.append("HouseID", $('#getInfo_1').val());
                    // formData.append("RemitRent", $('#RemitRent').val());
                   
                    // if($('.CutHide').css('display')=='block'){
                    //     formData.append("ARemitRent", $('#ARemitRent').val());
                    // }
                    // formData.append("type", 1);
                    $.ajax({
                        type: "post",
                        url: "/ph/RentCut/cancelCut?ChangeOrderID="+thisID,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000},function(){
                            	//location.reload();
                            	if(res.retcode == '2000'){
	                                layer.close(thisIndex);
	                                location.reload();
	                            }
                            });
                            
                        }
                    });
                //}
            },
		});
	});
	// var id = $(this).val();
	// console.log(id);
	// layer.confirm('注意，一旦取消减免;将必须重新申请再减免。无法恢复！！！',{title:'取消减免',icon:'1',skin:'lan_class'},function(conIndex){
	// 	$.get('/ph/RentCount/cancelCut?id='+id,function(res){
	// 		res = JSON.parse(res);
	// 		layer.msg(res.msg,{time:4000},function(){
	// 			location.reload();
	// 		});
	// 	});
	// 	layer.close(conIndex);

	// });
});
//租金减免年审
$('.reviewRentCut').click(function(){
	var thisID = $(this).val();
	//console.log(thisID);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('.APhouseId').text(res.data.detail.HouseID);
		$('.APBanID').text(res.data.detail.BanID);
		$('.APhouseAddress').text(res.data.detail.BanAddress);
		$('.APFloorID').text(res.data.detail.FloorID);
		$('.APtenantName').text(res.data.detail.TenantName);
		$('.APtenantTel').text(res.data.detail.TenantTel);
		$('.APtenantNumber').text(res.data.detail.TenantNumber);
		$('.APcreateTime').text(res.data.detail.CreateTime);
		$('.APhouseArea').text(res.data.detail.HouseArea);
		$('.APleasedArea').text(res.data.detail.LeasedArea);
		$('#breakTyped3').text(res.data.detail.CutName);
		$('#IDNumberd3').text(res.data.detail.IDnumber);
		$('#validityd3').text(res.data.detail.MuchMonth);
		$('#transferWayHidden').val(res.data.detail.CutName);
		$('#transferWay').val(res.data.detail.CutType);
		$('#transferMoney').val(res.data.detail.InflRent);
		$('#transferReason').val(res.data.detail.IDnumber);
		processState('#approveStatereview',res);
		metailShow('#layer-photos-demo-review',res);
		//return false;
		//res = JSON.parse(res);
		layer.open({
			type:1,
			area:['950px','600px'],
			resize:false,
			zIndex:100,
			title:['租金减免年审','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$("#approveFormReview"),
			btn:['保存','取消'],
            success: function(){
            	var one = new file({
					button:"#TrApIDCard",
					show:"#TrApIDCardShow",
					upButton:"#TrApIDCard",
					size:5120,
					url:"/ph/RentCut/cancelCut",
					ChangeOrderID:'',
					Type:1,
					title:"身份证"
				});
				var two = new file({
					button:"#household",
					show:"#householdShow",
					upButton:"#household",
					size:5120,
					url:"/ph/RentCut/cancelCut",
					ChangeOrderID:'',
					Type:1,
					title:"户口本"
				});
				var three = new file({
					button:"#tenantLease",
					show:"#tenantLeaseShow",
					upButton:"#tenantLease",
					size:5120,
					url:"/ph/RentCut/cancelCut",
					ChangeOrderID:'',
					Type:1,
					title:"租约"
				});
				var four = new file({
					button:"#basic",
					show:"#basicShow",
					upButton:"#basic",
					size:5120,
					url:"/ph/RentCut/cancelCut",
					ChangeOrderID:'',
					Type:1,
					title:"低保证"
				});
            },
            yes: function(thisIndex) {
                //if ($('#getInfo_1').val() == "") {
                    //layer.msg('房屋编号存在问题呢！！！',{time:4000});
                //} else {
					var CutNumber = $("#transferReason").val();//减免证号
					var CutRent = $("#transferMoney").val();//减免金额
					var CutType = $("#transferWay").val();//减免类型
                    var formData = fileTotall.getArrayFormdata() || new FormData();
					formData.append('CutType',CutType);
					formData.append('CutRent',CutRent);
					formData.append('CutNumber',CutNumber);
					//formData.append('ChangeOrderID',changeorderid);
                    // formData.append("CutType", $('#CutType').val());
                    // formData.append("IDnumber", $('#IDnumber').val());
                    // formData.append("validity", $('#validity').val());
                    // formData.append("HouseID", $('#getInfo_1').val());
                    // formData.append("RemitRent", $('#RemitRent').val());
                   
                    // if($('.CutHide').css('display')=='block'){
                    //     formData.append("ARemitRent", $('#ARemitRent').val());
                    // }
                    // formData.append("type", 1);
					// changeCutYearProcess 审核
                    $.ajax({
                        type: "post",
                        url: "/ph/RentCut/changeCutYearAdd?ChangeOrderID="+thisID,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000},function(){
                            	//location.reload();
                            	if(res.retcode == '2000'){
	                                layer.close(thisIndex);
	                                location.reload();
	                            }
                            });
                            
                        }
                    });
                //}
            },
		});
	});
	// var id = $(this).val();
	// console.log(id);
	// layer.confirm('注意，一旦取消减免;将必须重新申请再减免。无法恢复！！！',{title:'取消减免',icon:'1',skin:'lan_class'},function(conIndex){
	// 	$.get('/ph/RentCount/cancelCut?id='+id,function(res){
	// 		res = JSON.parse(res);
	// 		layer.msg(res.msg,{time:4000},function(){
	// 			location.reload();
	// 		});
	// 	});
	// 	layer.close(conIndex);

	// });
});
//租金减免年审审核
$('.examineRentCut').click(function(){
	$('#services-box-year').html("");
	var thisID = $(this).val();
	//console.log(thisID);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+thisID,function(res){
		res = JSON.parse(res);
		console.log(res);
		$('.APhouseId').text(res.data.detail.HouseID);
		$('.APBanID').text(res.data.detail.BanID);
		$('.APhouseAddress').text(res.data.detail.BanAddress);
		$('.APFloorID').text(res.data.detail.FloorID);
		$('.APtenantName').text(res.data.detail.TenantName);
		$('.APtenantTel').text(res.data.detail.TenantTel);
		$('.APtenantNumber').text(res.data.detail.TenantNumber);
		$('.APcreateTime').text(res.data.detail.CreateTime);
		$('.APhouseArea').text(res.data.detail.HouseArea);
		$('.APleasedArea').text(res.data.detail.LeasedArea);
		$('#breakTyped4').text(res.data.detail.CutName);
		$('#IDNumberd4').text(res.data.detail.IDnumber);
		$('#validityd4').text(res.data.detail.MuchMonth);
		// $("#transferReasons").val(res.data.detail.CutYearRecord[0].CutNumber);//减免证号
		// $("#transferMoneys").val(res.data.detail.CutYearRecord[0].CutRent);//减免金额
		// $("#transferClasss").val(res.data.detail.CutYearRecord[0].CutType);//减免类型
		 processState('#approveStatereviews',res);
		metailShow('#layer-photos-demo-reviews',res);
		// metailShows('#layer-photos-demo-annual',res);
		 layerBox(thisID,'derate','租金减免年审审核',1,res.data.config.status);
		for(var i = 0; i < res.data.detail.CutYearRecord.length; i++){
				if(res.data.detail.CutYearRecord[i].Status == 0){
					if(!res.data.detail.CutYearRecord[i].Reson){
						res.data.detail.CutYearRecord[i].Reson = '空';
					}
					var statuMsg = '年审不通过!,原因:'+ res.data.detail.CutYearRecord[i].Reson;
				}else if(res.data.detail.CutYearRecord[i].Status == 1){
					var statuMsg = '年审通过!';
				}else{
					var statuMsg = '年审中!';
				}
				var htmlyear ='<div class="am-u-md-12" style="padding-left:0;">\
						<div class="am-form-group am-u-md-12">\
							<div style="border-top: #ccc 1px solid; padding-bottom: 10px;  margin-left: 16px;"></div>\
							<div class="am-u-md-6">\
							  <label>年审信息：<span style="color:red">'+statuMsg +'</span></label>\
							</div>\
						</div>\
					</div>\
					<div class="am-form-group am-u-sm-12">\
						<div class="am-u-md-4" style="margin:20px auto 30px;">\
							<label class="label_style">减免类型：</label>\
							<input class="label_input" readonly id="transferClasss'+i+'" require value="'+ res.data.detail.CutYearRecord[i].CutType +'"  />\
						</div>\
						<div class="am-u-md-4 transfer_money" style="padding-left:0;margin:20px auto 30px;">\
							<label class="label_style">减免金额：</label>\
							<input class="label_input" readonly id="transferMoneys'+i+'" require value="'+ res.data.detail.CutYearRecord[i].CutRent +'" />\
						</div>\
						<div class="am-u-md-4 transfer_reason" style="padding-left:0;margin:20px auto 30px;">\
							<label>减免证号：</label>\
							<input class="label_input" readonly id="transferReasons'+i+'" value="'+ res.data.detail.CutYearRecord[i].CutNumber +'"  />\
						</div>\
					</div>\
					<div class="am-form-group am-u-md-12">\
					  <div class="am-u-md-6">\
						<label>年审信息：</label>\
					  </div>\
					  <div id="layer-photos-demo-annual'+i+'" class="am-u-md-12">\
					  </div>\
					</div>';
			     $('#services-box-year').append(htmlyear);
			 	 metailShows("#layer-photos-demo-annual"+i,res,1,i);
		}
		//return false;
		//res = JSON.parse(res);
/* 		layer.open({
			type:1,
			area:['950px','600px'],
			resize:false,
			zIndex:100,
			title:['租金减免年审','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$("#changeCutYearProcess"),
			btn:['保存','取消'],
            success: function(){
            	
            },
            yes: function(thisIndex) {
                //if ($('#getInfo_1').val() == "") {
                    //layer.msg('房屋编号存在问题呢！！！',{time:4000});
                //} else {
                 var formData = fileTotall.getArrayFormdata() || new FormData();

					//formData.append('ChangeOrderID',changeorderid);
                    // formData.append("CutType", $('#CutType').val());
                    // formData.append("IDnumber", $('#IDnumber').val());
                    // formData.append("validity", $('#validity').val());
                    // formData.append("HouseID", $('#getInfo_1').val());
                    // formData.append("RemitRent", $('#RemitRent').val());
                   
                    // if($('.CutHide').css('display')=='block'){
                    //     formData.append("ARemitRent", $('#ARemitRent').val());
                    // }
                    // formData.append("type", 1);
					// changeCutYearProcess 审核
                    $.ajax({
                        type: "post",
                        url: "/ph/RentCut/changeCutYearProcess?ChangeOrderID="+thisID,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000},function(){
                            	//location.reload();
                            	if(res.retcode == '2000'){
	                                layer.close(thisIndex);
	                                location.reload();
	                            }
                            });
                            
                        }
                    });
                //}
            },
		}); */
		
		function layerBox(value,id,name,operation,status){
			var this_index = layer.open({
		        type: 1,
		        area: ['990px','780px'],
		        resize: false,
		        zIndex: 100,
		        title: [name, 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
		        content: $("#changeCutYearProcess"),
		        btn:operation==1?['通过','不通过']:'',
		        success: function(){
		
		        },
		        yes:function(){
		        	if(status == '1'){
		        		var formData = fileTotall.getArrayFormdata() || new FormData();
		                formData.append('deteleImg',delete_img_array.join(','));
		        	}else{
		        		var formData = new FormData();
		        	}
					formData.append('ChangeOrderID',value);
		        	processPass(formData,this_index);
		        },
		        btn2:function(){
					noPass(value);
				},
		        // btn3:function(){
		        //     goBack(value);
		        // }
		    })
		}
		// 审批通过事件
		function processPass(formData,this_index){
			$.ajax({
		        type:"post",
		        url:"/ph/RentCut/changeCutYearProcess?ChangeOrderID="+thisID,
		        data:formData,
		        processData:false,
		        contentType:false,
		        success:function(res){
		            res = JSON.parse(res);
		               console.log(res);
		            layer.msg(res.msg,{time:4000});
		            layer.close(this_index);
		            location.reload();
		        }
			})
		}
		// 审批不通过事件
		function noPass(value,reason){
			layer.open({
				type:1,
				area:['400px','400px'],
				resize:false,
				zIndex:100,
				title:['不通过原因','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:'<textarea id="reason" style="width:350px;height:290px;margin-top:10px;border:1px solid #c1c1c1;resize: none;margin-left: 25px;"></textarea>',
				btn:['确认'],
		        success:function(){
		            console.log(reason);
		            $('#reason').val(reason||'');
		        },
				yes:function(msgIndex){
					var reasonMsg = $('#reason').val();
					if (reasonMsg=='') {
						reasonMsg='空';
					}else{
						reasonMsg=$('#reason').val();
					}
					console.log(reasonMsg);
					$.post("/ph/RentCut/changeCutYearProcess?ChangeOrderID="+thisID,{ChangeOrderID:value,reson:reasonMsg,isfail:1},function(res){
						res = JSON.parse(res);
						console.log(res);
						layer.msg(res.msg,{time:4000});
						if(res.retcode == "2000"){
							layer.close(msgIndex);
							location.reload();
						}
					});
				}
			})
		}
		
		// 审批不通过事件
		function goBack(value,reason){
		    layer.open({
		        type:1,
		        area:['400px','400px'],
		        resize:false,
		        zIndex:100,
		        title:['打回原因','color:#FFF;font-size:1.6rem;font-weight:600;'],
		        content:'<textarea id="backReason" style="width:350px;height:290px;margin-top:10px;border:1px solid #c1c1c1;resize: none;margin-left: 25px;"></textarea>',
		        btn:['确认'],
		        success:function(){
		            console.log(reason);
		            $('#backReason').val(reason||'');
		        },
		        yes:function(msgIndex){
		            var reasonMsg = $('#backReason').val();
		            if (reasonMsg=='') {
		                reasonMsg='空';
		            }else{
		                reasonMsg=$('#backReason').val();
		            }
		            // console.log(reasonMsg);
		            $.post("/ph/RentCut/changeCutYearProcess?ChangeOrderID="+thisID,{ChangeOrderID:value,reson:reasonMsg,isfail:0},function(res){
		                res = JSON.parse(res);
		                console.log(res);
		                layer.msg(res.msg,{time:4000});
		                if(res.retcode == "2000"){
		                    layer.close(msgIndex);
		                    location.reload();
		                }
		            });
		        }
		    })
		}
	});
	// var id = $(this).val();
	// console.log(id);
	// layer.confirm('注意，一旦取消减免;将必须重新申请再减免。无法恢复！！！',{title:'取消减免',icon:'1',skin:'lan_class'},function(conIndex){
	// 	$.get('/ph/RentCount/cancelCut?id='+id,function(res){
	// 		res = JSON.parse(res);
	// 		layer.msg(res.msg,{time:4000},function(){
	// 			location.reload();
	// 		});
	// 	});
	// 	layer.close(conIndex);

	// });
});
//流程配置函数
function metailShow(id,res){
	var ImgLength = res.data.urls.length;
	var FatherDom = $(id);
	FatherDom.empty();
	for(var i = 0; i < ImgLength; i++){
		var ImgDom = $("<img style='width:100px;display:inline-block;' layer-pid="+i+" layer-src="+res.data.urls[i].FileUrl+" src="+res.data.urls[i].FileUrl+" alt="+res.data.urls[i].FileTitle+"/>");
		FatherDom.append(ImgDom);
	}
	console.log(id);
	layer.photos({
	  photos: id
	  ,anim: 5
	});
};
function metailShows(id,res,ctrl_status = 1,loopkey = 0){
	// var ImgLengths = res.data.detail.CutYearRecord[0].urls.length;
	// var FatherDoms = $(id);
	// FatherDoms.empty();
	// for(var i = 0; i < ImgLengths; i++){
	// 	var ImgDoms = $("<img style='width:100px;display:inline-block;' layer-pid="+i+" layer-src="+res.data.detail.CutYearRecord[0].urls[i].FileUrl+" src="+res.data.detail.CutYearRecord[0].urls[i].FileUrl+" alt="+res.data.detail.CutYearRecord[0].urls[i].FileTitle+"/>");
	// 	FatherDoms.append(ImgDoms);
	// }
	// console.log(id);
	// layer.photos({
	//   photos: id
	//   ,anim: 5
	// });
	
 var img_title = [];
 var img_array = [];
 res.data.detail.CutYearRecord[loopkey].urls.forEach(function(data){
 	var index = img_title.indexOf(data.FileTitle);
 	if(index < 0){
 		img_title.push(data.FileTitle);
 		img_array[img_array.length] = [];
 		img_array[img_array.length - 1].push(data.FileUrl);
 	}else{
 		img_array[index].push(data.FileUrl);
 	}
 });
	console.log('img_array:',img_array);
	var FatherDoms = $(id);
	FatherDoms.empty();
	for(var i = 0; i < img_title.length; i++){
		var title_dom = $("<p style='margin:5px auto;font-size:14px;'>" + img_title[i] + "</p>");
		FatherDoms.append(title_dom);
		for(var j = 0;j < img_array[i].length;j++){
	        if(res.data.config.status == '1' && ctrl_status == 1){
	            var ImgDoms = $("<li style='display:inline-block;position:relative;'>\
	                <img style='height:100px;padding:0 10px 10px 0;' layer-pid="+i+" data-original="+img_array[i][j]+" src="+img_array[i][j] + " alt="+img_title[i]+"/>\
	                <img style='width:20px;position:absolute;top:0;right:-2px;cursor:pointer;box-shadow: 0 0 5px #ccc;border-radius: 50%;' src='/public/static/gf/icons/delete.png' class='img_states2_close'>\
	                </li>");
	        }else{
	            var ImgDoms = $("<li style='display:inline-block;position:relative;'>\
	                <img style='height:100px;padding:0 10px 10px 0;' layer-pid="+i+" data-original="+img_array[i][j]+" src="+img_array[i][j] + " alt="+img_title[i]+"/>\
	                </li>");
	        }
			FatherDoms.append(ImgDoms);
		}
	}
	// layer.photos({
	//   photos: id
	//   ,anim: 5
	// });
	$(id+' img[layer-pid]').click(function(){
		var viewer = new Viewer($(id)[0],{
				hidden:function(){
					viewer.destroy();
				}
			}
		);
	});
	$(id+' .img_states2_close').click(function(){
	    var this_index = $(this).index(id+' .img_states2_close');
	    var img_src = $(id+' img[layer-pid]').eq(this_index).attr('data-original');
	    console.log(img_src);
	    delete_img_array.push(img_src);
	    $(id+' li').eq(this_index).remove();
	    console.log(delete_img_array);
	})
}
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