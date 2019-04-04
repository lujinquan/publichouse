$('.addLease').click(function(){
	houseQuery.action('leaseHouseInput','1');
	$('#applyYear').val(getYear());
	$('#applyMonth').val(getMonth());
	$('#applyDay').val(getDay());

	$('.applyYear').text(getYear());
	$('.applyMonth').text(getMonth());
	$('.applyDay').text(getDay());
	layer.open({
		type:1,
		area:['1200px','750px'],
		resize:false,
		zIndex:100,
		title:['租约申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseAdd'),
		btn:['确认','取消'],
		success:function(){
			$('#leaseHouseQuery').click(function(){
				$.get('/ph/api/lease_house_info/HouseID/'+$('#leaseHouseInput').val(),function(res){
					res = JSON.parse(res);
					console.log(res);
					$('#applyNO').val(res.data.house.Szno);
					$('#applyAddress').val(res.data.house.BanAddress);
					$('#applyStruct').val(res.data.house.StructureType);
					$('#applyHouseFloor').val(res.data.house.BanFloorNum);
					$('#applyLiveFloor').val(res.data.house.FloorID);
					$('#applyRentName').val(res.data.house.TenantName);
					$('#applyRentNumber').val(res.data.house.TenantNumber);
					$('#applyRentTel').val(res.data.house.TenantTel);
					$('#applyRoom1_data5').val(res.data.house.Hall);
					$('#applyRoom1_data6').val(res.data.house.HallRent);
					$('#applyRoom2_data5').val(res.data.house.Kitchen);
					$('#applyRoom2_data6').val(res.data.house.KitchenRent);
					$('#applyRoom3_data5').val(res.data.house.Toilet);
					$('#applyRoom3_data6').val(res.data.house.ToiletRent);
					$('#applyRoom4_data5').val(res.data.house.InnerAisle);
					$('#applyRoom4_data6').val(res.data.house.InnerAisleRent);
					$('#applyRoom5_data6').val(res.data.house.BelowFiveNum);
					$('#applyRoom5_data7').val(res.data.house.BelowFiveNumRent);
					$('#applyRoom6_data6').val(res.data.house.MoreFiveNum);
					$('#applyRoom6_data7').val(res.data.house.MoreFiveNumRent);
					if(parseInt(res.data.house.PumpCost) != 0){
						$('#applyRoom7_data8').val(res.data.house.TotalLeaseArea);
					}else{
						$('#applyRoom7_data8').val(0);
					}

					$('#applyRoom7_data9').val(res.data.house.PumpCost);
					$('#applyRoom20_data2').val(res.data.house.TotalUseArea);
					$('#applyRoom20_data3').val(res.data.house.TotalLeaseArea);
					$('#applyRoom20_data4').val(res.data.house.TotalRoomMonth);
					$('#applyRoom20_data5').val(res.data.house.HeDingRoomMonth);
					var ws = 1;
					var fb = 13;
					var wfb = 13;
					var bg = 16,
						flag_12 = 0,//高1.7至2.2米搁楼标识（1个）
						flag_13 = 0;//无封闭阳台标识（3个）
					res.data.room.sort(function(a,b){
						return b.RoomType - a.RoomType;
					});
					console.log(res.data.room);
					for(var i = 0;i < res.data.room.length;i++){
						var this_data = res.data.room[i];
						switch(this_data.RoomType){
							case "1":
								$('#applyRoom'+ws+'_data1').val(this_data.RoomNumber);
								$('#applyRoom'+ws+'_data2').val(this_data.UseArea);
								$('#applyRoom'+ws+'_data3').val(this_data.LeasedArea);
								$('#applyRoom'+ws+'_data4').val(this_data.RoomRentMonth);
								if(ws < 4){
									ws++;
								}
								break;
							case "2":
								if(this_data.RoomPublicStatus =="独"){
									$('#applyRoom9_data2').val(this_data.RoomNumber);
									$('#applyRoom9_data3').val(this_data.UseArea);
									$('#applyRoom9_data4').val(this_data.LeasedArea);
									$('#applyRoom9_data5').val(this_data.RoomRentMonth);
								}else{
									$('#applyRoom10_data2').val(this_data.RoomNumber);
									$('#applyRoom10_data3').val(this_data.UseArea);
									$('#applyRoom10_data4').val(this_data.LeasedArea);
									$('#applyRoom10_data5').val(this_data.RoomRentMonth);
								}
								break;
							case "3":
								if(this_data.RoomPublicStatus =="独"){
									$('#applyRoom11_data2').val(this_data.RoomNumber);
									$('#applyRoom11_data3').val(this_data.UseArea);
									$('#applyRoom11_data4').val(this_data.LeasedArea);
									$('#applyRoom11_data5').val(this_data.RoomRentMonth);
								}else{
									$('#applyRoom12_data2').val(this_data.RoomNumber);
									$('#applyRoom12_data3').val(this_data.UseArea);
									$('#applyRoom12_data4').val(this_data.LeasedArea);
									$('#applyRoom12_data5').val(this_data.RoomRentMonth);
								}
								break;
							case "4":
								$('#applyRoom'+fb+'_data1').val(this_data.RoomNumber);
								$('#applyRoom'+fb+'_data2').val(this_data.UseArea);
								$('#applyRoom'+fb+'_data3').val(this_data.LeasedArea);
								$('#applyRoom'+fb+'_data4').val(this_data.RoomRentMonth);
								fb++;
								break;
							case "5":
								if(this_data.RoomPublicStatus =="独"){
									$('#applyRoom5_data2').val(this_data.RoomNumber);
									$('#applyRoom5_data3').val(this_data.UseArea);
									$('#applyRoom5_data4').val(this_data.LeasedArea);
									$('#applyRoom5_data5').val(this_data.RoomRentMonth);
								}else{
									$('#applyRoom6_data2').val(this_data.RoomNumber);
									$('#applyRoom6_data3').val(this_data.UseArea);
									$('#applyRoom6_data4').val(this_data.LeasedArea);
									$('#applyRoom6_data5').val(this_data.RoomRentMonth);
								}
								break;
							case "6":
								if(this_data.RoomPublicStatus =="独"){
									$('#applyRoom7_data2').val(this_data.RoomNumber);
									$('#applyRoom7_data3').val(this_data.UseArea);
									$('#applyRoom7_data4').val(this_data.LeasedArea);
									$('#applyRoom7_data5').val(this_data.RoomRentMonth);
								}else{
									$('#applyRoom8_data2').val(this_data.RoomNumber);
									$('#applyRoom8_data3').val(this_data.UseArea);
									$('#applyRoom8_data4').val(this_data.LeasedArea);
									$('#applyRoom8_data5').val(this_data.RoomRentMonth);
								}
								break;
							case "7":
								if(bg < 20){
									$('#applyRoom'+bg+'_data1').val('');
									$('#applyRoom'+bg+'_data2').val(this_data.RoomNumber);
									$('#applyRoom'+bg+'_data3').val(this_data.UseArea);
									$('#applyRoom'+bg+'_data4').val(this_data.LeasedArea);
									$('#applyRoom'+bg+'_data5').val(this_data.RoomRentMonth);
									bg++;
								}
								break;
							case "8":
									if(flag_13 < 3){
										$('#applyRoom'+wfb+'_data5').val(this_data.RoomNumber);
										$('#applyRoom'+wfb+'_data6').val(this_data.UseArea);
										$('#applyRoom'+wfb+'_data7').val(this_data.LeasedArea);
										$('#applyRoom'+wfb+'_data8').val(this_data.RoomRentMonth);
										wfb++;
										flag_13++;
									}else{
										$('#applyRoom'+bg+'_data1').val('无封闭阳台');
										$('#applyRoom'+bg+'_data2').val(this_data.RoomNumber);
										$('#applyRoom'+bg+'_data3').val(this_data.UseArea);
										$('#applyRoom'+bg+'_data4').val(this_data.LeasedArea);
										$('#applyRoom'+bg+'_data5').val(this_data.RoomRentMonth);
										if(bg < 19){
											bg++;
										}
									}
								break;
							case "9":
									$('#applyRoom'+bg+'_data1').val('高2.20米以上搁楼');
									$('#applyRoom'+bg+'_data2').val(this_data.RoomNumber);
									$('#applyRoom'+bg+'_data3').val(this_data.UseArea);
									$('#applyRoom'+bg+'_data4').val(this_data.LeasedArea);
									$('#applyRoom'+bg+'_data5').val(this_data.RoomRentMonth);
									if(bg < 19){
										bg++;
									}
								break;
							case "10":
									if(flag_12 < 1){
										$('#applyRoom12_data6').val(this_data.RoomNumber);
										$('#applyRoom12_data7').val(this_data.UseArea);
										$('#applyRoom12_data8').val(this_data.LeasedArea);
										$('#applyRoom12_data9').val(this_data.RoomRentMonth);
										flag_12++;
									}else{
										$('#applyRoom'+bg+'_data1').val('高1.7至2.2米搁楼');
										$('#applyRoom'+bg+'_data2').val(this_data.RoomNumber);
										$('#applyRoom'+bg+'_data3').val(this_data.UseArea);
										$('#applyRoom'+bg+'_data4').val(this_data.LeasedArea);
										$('#applyRoom'+bg+'_data5').val(this_data.RoomRentMonth);
										if(bg < 19){
											bg++;
										}
									}
								break;
						}
					}
					$('.input_remark').off('blur');
				    $('.input_remark').blur(function(){
				    	var str_new = $('.remark label').text() + '&nbsp&nbsp'
				    	 + $('.remark select option:selected').text() + '&nbsp&nbsp'
				    	 + $('.input_remark').val();
				    	
				    	if(res.data.house.Recorde != ''){
				    		str_new = str_new + ';' + res.data.house.Recorde;
				    	}
				    	$('.applyText_other').val(str_new);
				    	console.log(str_new);
				    });


				    var recorde_array = res.data.house.Recorde.split(';');
					for(var i = 0,length = recorde_array.length;i < length; i++){
						$('.remark').append($('<p>'+recorde_array[i]+'</p>'));
					}
				    $('.remark select').off('change');
				    $('.remark select').change(function(){
				    	if($(this).val() == "3" || $(this).val() == "4"){
				    		$.get('/ph/Api/lease_use?HouseID'+$('#leaseHouseInput').val(),function(res){
				    			res = JSON.parse(res);
				    			$('.input_remark').val(res.data.recorde).show();
				    		})
				    	}else if($(this).val() == "6"){
				    		$('.input_remark').show();
				    	}else{
				    		$('.input_remark').hide();
				    	}


				    	var str_new = $('.remark label').text() + '&nbsp&nbsp' 
				    	+ $('.remark select option:selected').text() + '&nbsp&nbsp' 
				    	+ $('.input_remark').val();
				    	
				    	if(res.data.house.Recorde != ''){
				    		str_new = str_new + ';' + res.data.house.Recorde;
				    	}
				    	$('.applyText_other').val(str_new);
				    	console.log(str_new);
				    })
				})
			})
			new file({
		        button: "#leaseApplication1",
		        show: "#leaseApplication1_Show",
		        upButton: "#leaseApplication1_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		    new file({
		        button: "#leaseApplication2",
		        show: "#leaseApplication2_Show",
		        upButton: "#leaseApplication2_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		    new file({
		        button: "#leaseApplication3",
		        show: "#leaseApplication3_Show",
		        upButton: "#leaseApplication3_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		},
		yes:function(){
			var data = $('#MyForm').serializeArray();;
			var formData = fileTotall.getArrayFormdata();
			if(!formData){
				formData = new FormData();
			}
			for(var i = 0;i < data.length;i++){
				formData.append(data[i].name,data[i].value);
			}

			formData.append('houseID',$('#leaseHouseInput').val());
			formData.append('applyReason',$('.applyReason').val());
			$.ajax({
                type: "post",
                url: "/ph/LeaseApply/add",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    res = JSON.parse(res);
                    layer.msg(res.msg);
                    if(res.retcode == '2000'){
                        location.reload();
                    }
                }
            });
		},
		btn2:function(){
			$('#MyForm input').val('');
			$('#MyForm select').val('请选择');
			$('#leaseApplication1_Show').empty();
			$('#leaseApplication2_Show').empty();
			$('#leaseApplication3_Show').empty();
		},
		cancel:function(){
			$('#MyForm input').val('');
			$('#MyForm select').val('请选择');
			$('#leaseApplication1_Show').empty();
			$('#leaseApplication2_Show').empty();
			$('#leaseApplication3_Show').empty();
		}
	})
})
$('.BtnDetail').click(function(){
	var houseID = $(this).val();
	console.log(houseID);
	layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约详情','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		// btn:['确认','取消'],
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+houseID,function(res){
				var res = JSON.parse(res);
				var data = res.data.detail;
				console.log(data);
				data.applyNO = data.Szno;
				for(var key in data){
					var name_id = key.replace(/apply/,'detail');
					if(key.indexOf('Text_other') > -1){
						var recorde_array = data[key].split(';');
						$('#detailText_other').empty();
						for(var i = 0,length = recorde_array.length;i < length; i++){
							$('#detailText_other').append($('<p>'+recorde_array[i]+'</p>'));
						}
						console.log(recorde_array);
					}else{
						$('#'+name_id).text(data[key]);
					}
				}
				if(data.QrcodeUrl != ""){
					$('#imghid').show();
					$('#picCode').show().prop('src',data.QrcodeUrl);
				}else{
					$('#imghid').hide();
					$('#picCode').hide();
				}
				processState('#leaseApplyState',res);
            	metailShow('#leaseApplyPhotos',res);
			})
			
		}
	})
})

$('.BtnDel').click(function(){
	var ChangeOrderID = $(this).val();
	console.log(ChangeOrderID);
	$.get('/ph/LeaseApply/delete/ChangeOrderID/'+ChangeOrderID,function(res){
		var res = JSON.parse(res);
		console.log(res);
		layer.msg(res.msg);
		if(res.retcode == '2000'){
			location.reload();
		}
	})
})


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
			var ImgDom = $("<li style='width:100px;display:inline-block;'><img style='width:100px;' layer-pid="+i+" data-original="+
				img_array[i][j]+" src="+img_array[i][j] + " alt="+img_title[i]+"/></li>");
			FatherDom.append(ImgDom);
		}
	}
	
	// layer.photos({
	//   photos: id
	//   ,anim: 5
	// });
	$(id+' img').click(function(){
		console.log(id);
		var viewer = new Viewer($(id)[0],{
				hidden:function(){
					viewer.destroy();
				}
			}
		);
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
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1]+"；</p>");
		}else{
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1]+"；</p>");
		}
		FatherDom.append(RecordDom);
	}
}

function getDay(){
	return new Date().getDate();
}

function getMonth(){
	return (new Date().getMonth() + 1);
}

function getYear(){
	var date = new Date();
	var year = date.getFullYear();
	return year;
}