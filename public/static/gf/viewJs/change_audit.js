//审批
$('.BtnApprove').click(function(){
	var value = $(this).val(),
		CordID = "#approveForm";
	$(".breaks").hide();
	$(".pause").hide();
	$(".WriteOff").hide();
	$(".cancel").hide();
	$('#SerialNumber').text('房屋编号:');
	$(".LHide").css('display','block');
	console.log(value);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		var type = res.data.detail.type;
		if(type == 1){
			layer.open({
                type: 1,
                area: ['990px','780px'],
                resize: false,
                zIndex: 100,
                title: ['租金减免详情', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#derate'),
                btn:['通过','不通过'],
                success: function(){
                	$('.derateHouseID').text(res.data.detail.HouseID);
                	$('.derateBanID').text(res.data.detail.BanID);
                	$('.derateAddress').text(res.data.detail.BanAddress);
                	$('.derateOwnertype').text(res.data.detail.OwnerTypes[0].OwnerType);
                	$('.derateUseNature').text(res.data.detail.UseNature);
                	$('.detateHouseUsearea').text(res.data.detail.HouseUsearea);
                	$('.derateLeasedArea').text(res.data.detail.LeasedArea);
                	$('.derateHousePrerent').text(res.data.detail.HousePrerent);
                	$('.derateTenantName').text(res.data.detail.TenantName);
                	$('.derateTenantNumber').text(res.data.detail.TenantNumber);
                	$('.derateTenantTel').text(res.data.detail.TenantTel);
                	$('.derateMoney').text(res.data.detail.RemitRent);
                	$('.derateType').text(res.data.detail.CutName);
                	$('.derateNumber').text(res.data.detail.MuchMonth);
                	$('.derateTime').text(res.data.detail.IDnumber);
                	if(res.data.config.status == '1'){
						$('.status_2').show();
					}
					processState('#derateState',res);
					metailShow('#deratePhotos',res);
                }
            })
		}else if(type == 2){
			$(".breaks").hide();
			$(".pause").hide();
			$(".WriteOff").hide();
			$(".cancel").hide();
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
		}else if(type == 3){
			new file({
                show: "#pauseUploadReportShow",
                upButton: "#pauseUploadReportUp",
                size: 1024,
                url: "/ph/ChangeApply/add",
                button: "#pauseUploadReport",
                ChangeOrderID: '',
                Type: 1,
                title: "上传报告"
            });
			var thisIndex = layer.open({
                type: 1,
                area: ['990px','780px'],
                resize: false,
                zIndex: 100,
                title: ['暂停计租审批', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#pauseDetail'),
                btn:['通过','不通过'],
                success: function() {
                	var house_str = '';
                	$('.pauseBanId').text(res.data.detail.ban.BanID);
                	$('.pauseAddress').text(res.data.detail.ban.BanAddress);
                	$('.pauseOwnerType').text(res.data.detail.ban.OwnerType);
                	$('.pauseInflRent').text(res.data.detail.InflRent);
                	$('.pauseCreateTime').text(res.data.detail.ban.CreateTime);
                	for(var i = 0;i < res.data.detail.house.length;i++){
                		house_str += '<tr>\
			                <td style="width:200px;">'+i+'</td>\
			                <td style="width:200px;">'+res.data.detail.house[i].HouseID+'</td>\
			                <td style="width:200px;">'+res.data.detail.house[i].TenantName+'</td>\
			                <td style="width:350px;">'+res.data.detail.house[i].HousePrerent+'</td>\
			            </tr>';
                	}
                	$('#pauseHouseDetail').append($(house_str));
					processState('#pauseRentState',res);
					metailShow('#pauseRentPhotos',res);
					if(res.data.config.status == '1'){
						$('.status_2').show();
					}
                },
                yes:function(){
					var formData = fileTotall.getArrayFormdata();
					formData.append('ChangeOrderID',value);
                	$.ajax({
		                type:"post",
		                url:'/ph/ChangeAudit/process/',
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
                	})
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
							if (reasonMsg=='') {
								reasonMsg='空';
							}else{
								reasonMsg=$('#reason').val();
							}
							console.log(reasonMsg);
							$.post('/ph/ChangeAudit/process/',{ChangeOrderID:value,reson:reasonMsg},function(res){
								res = JSON.parse(res);
								console.log(res);
								layer.msg(res.msg);
								if(res.retcode == "2000"){
									layer.close(msgIndex);
									location.reload();
								}
							});
						}
					})
				}
            })
		}else if(type == 4){
			$(".breaks").hide();
			$(".pause").hide();
			$(".WriteOff").show();
			$(".cancel").hide();
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.WriteOffStartTime').text(res.data.detail.DateStart);
			$('.WriteOffEndTime').text(res.data.detail. DateEnd);
		}else if(type == 8){
			$(".breaks").hide();
			$(".pause").hide();
			$(".WriteOff").hide();
			$(".cancel").show();
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.Ahide').css('display','none');
			$('.APFloorID').text(res.data.detail.BanFloorNum);
			$('.APhouseArea').text(res.data.detail.BanUsearea);
			$('#SerialNumber').text('楼栋编号:');
			$('.APhouseId').text(res.data.detail.BanID);
		}else if(type == 5){
			metailShow('#AdjustPhotos',res);
			processState('#AdjustState',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.Ehide').css('display','block');
			$('.HouseID').text(res.data.detail.HouseID);
			$('.BanID').text(res.data.detail.BanID);
			$('.BanAddress').text(res.data.detail.BanAddress);
			$('.FloorID').text(res.data.detail.FloorID);
			$('.TenantName').text(res.data.detail.TenantName);
			$('.TenantTel').text(res.data.detail.TenantTel);
			$('.TenantNumber').text(res.data.detail.TenantNumber);
			$('.CreateTime').text(res.data.detail.CreateTime);
			$('.HouseArea').text(res.data.detail.HouseArea);
			$('.LeasedArea').text(res.data.detail.LeasedArea);
			$('.DamageGrade').text(res.data.detail.DamageGrade);
			$('.StructureType').text(res.data.detail.StructureType);
			$('.Dhide').css('display','none');
			// $('.DamageGradeChange').text(res.data.detail.StructureType);//
			CordID = "#houseAdjust";

		}else if(type == 6){//维修
			processState('#RepairState',res);
			metailShow('#RepairPhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('#RCBanID').text(res.data.detail.BanID);
			$('#RCReason').text(res.data.detail.RepairReson);
			$('#RCRepairType').text(res.data.detail.RepairType);
			$('#OldUseNature').text(res.data.detail.OldUseNature);
			$('#OldOwnerType').text(res.data.detail.OldOwnerType);
			$('#OldBanUnitNum').text(res.data.detail.OldBanUnitNum);
			$('#OldBanFloorNum').text(res.data.detail.OldBanFloorNum);
			$('#OldStructure').text(res.data.detail.OldStructure);
			$('#OldCoveredArea').text(res.data.detail.OldCoveredArea);
			$('#OldTotalArea').text(res.data.detail.OldTotalArea);
			$('#OldDamageGrade').text(res.data.detail.OldDamageGrade);
			$('#RCBanAddress').text(res.data.detail.BanAddress);
			$('#UseNature').text(res.data.detail.UseNature);
			$('#OwnerType').text(res.data.detail.OwnerType);
			$('#BanUnitNum').text(res.data.detail.BanUnitNum);
			$('#BanFloorNum').text(res.data.detail.BanFloorNum);
			$('#Structure').text(res.data.detail.Structure);
			$('#CoveredArea').text(res.data.detail.CoveredArea);
			$('#TotalArea').text(res.data.detail.TotalArea);
			$('#DamageGrade').text(res.data.detail.DamageGrade);

			CordID = "#repairChange";
		}else if(type == 7){//新发租
			 $('.ManyRoom').children('.RoomCopy').remove();
			 $(".HousedCopy:eq(0)").hide();
			 $(".HousedCopy:eq(0)").nextAll().remove();
			CordID = "#banDetail";
			if(res.data.BanGpsX==""||res.data.BanGpsY==""){
				res.data.BanGpsX = "114.334228";
				res.data.BanGpsY = "30.560372";
			};
			$('p[id=BanID]').text(res.data.detail.BanID);                 //楼栋编号
			$('p[id=BanAddress]').text(res.data.detail.BanAddress);       //楼栋地址
			$('p[id=BanPropertyID]').text(res.data.detail.BanPropertyID); //产权证号
			$('p[id=BanYear]').text(res.data.detail.BanYear);             //建造年份
			$('p[id=DamageGrade]').text(res.data.detail.DamageGrade);     //完损等级
			$('p[id=OwnerType]').text(res.data.detail.OwnerType);         //楼栋产别
			$('p[id=PreRent]').text(res.data.detail.PreRent);             //规定租金
			$('p[id=StructureType]').text(res.data.detail.StructureType); //结构类型
			$('p[id=TubulationID]').text(res.data.detail.TubulationID);   //机构名称
			$('p[id=UseNature]').text(res.data.detail.UseNature);         //使用性质
			$('p[id=BanFloorNum]').text(res.data.detail.BanFloorNum);     //总楼层数
			$('p[id=BanFloorStart]').text(res.data.detail.BanFloorStart); //起始楼层数
			$('p[id=BanFreeholdID]').text(res.data.detail.BanFreeholdID); //不动产证号

			$('#DetailsTotalHouseHolds').text(res.data.detail.TotalHouseholds);
			$('#detailsTotalArea').text(res.data.detail.CoveredArea);
			$('#detailActualArea').text(res.data.detail.ActualArea);
			$('#detailBanArea').text(res.data.detail.BanArea);
			$('#detailEnterpriseArea').text(res.data.detail.EnterpriseArea);
			$('#detailPartyArea').text(res.data.detail.PartyArea);
			$('#detailCivilArea').text(res.data.detail.CivilArea);
			//$('#detailBanArea').text(res.data.BanArea); //计算租金
			$('#IfElevator').html(res.data.detail.IfElevator);
			$('#IfFirst').html(res.data.detail.IfFirst);
			$('p[id=BanLandID]').text(res.data.detail.BanLandID);         //土地证号
			$('p[id=BanUnitNum]').text(res.data.detail.BanUnitNum);       //总单元数
			$('p[id=CivilArea]').text(res.data.detail.CivilArea);         //民建面
			$('p[id=PartyArea]').text(res.data.detail.PartyArea);         //机关建面
			$('p[id=EnterpriseArea]').text(res.data.detail.EnterpriseArea);         //企业建面
			$('p[id=BanUsearea]').text(res.data.detail.BanUsearea);       //使用面积
			$('p[id=CutIf]').text(res.data.detail.CutIf);                 //产权是否分隔
			$('p[id=HistoryIf]').text(res.data.detail.HistoryIf);         //是否历史优秀建筑
			$('p[id=ProtectculturalIf]').text(res.data.detail.ProtectculturalIf);  //是否文物保护建筑
			$('p[id=ReformIf]').text(res.data.detail.ReformIf);           //是否改造产
			$('p[id=TotalArea]').text(res.data.detail.TotalArea);         //合建面积
			$('p[id=PropertySource]').text(res.data.detail.PropertySource);         //产权来源
			$('p[id=RemoveStatus]').text(res.data.detail.RemoveStatus);         //拆迁状态
			$('p[id=BanGpsXY]').text(res.data.detail.BanGpsX+','+res.data.detail.BanGpsY);         //经纬度
			if(res.data.detail.BanImageIDS.length ==3){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.detail.BanImageIDS[1].FileUrl);		//图片影像
				$('#detailImgThree').attr('src',res.data.detail.BanImageIDS[2].FileUrl);		//图片影像
			}else if(res.data.detail.BanImageIDS.length ==2){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.detail.BanImageIDS[1].FileUrl);		//图片影像
			}else if(res.data.detail.BanImageIDS.length ==1){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);	
			}
			if(res.data.newRent.house){
				var house_length = res.data.newRent.house.length;
			console.log(house_length);
			if(house_length > 0){
				for(var r=0;r<house_length;r++){
					$('.HouseDetail').after($('.HousedCopy').eq(0).clone());
					$('.HousedCopy').eq(r).show();
					$('.HousedCopy').eq(r).children().eq(0).text(res.data.newRent.house[r].HouseID);
					$('.HousedCopy').eq(r).children().eq(1).text(res.data.newRent.house[r].TenantName);
					$('.HousedCopy').eq(r).children().eq(2).text(res.data.newRent.house[r].Status);
				}
			}
			}
			
			// $('.HousedCopy').children().eq(0).text(res.data.newRent.house.HouseID);
			// $('.HousedCopy').children().eq(1).text(res.data.newRent.house.TenantName);
			// $('.HousedCopy').children().eq(2).text(res.data.newRent.house.Status);//房屋信息
			if(res.data.newRent.room){
				var aNewRent=res.data.newRent.room;
			for(var r=0;r<res.data.newRent.room.length;r++){
				$('.ManyRoom').append($('.RoomCopy').eq(0).clone().show());
					console.log(aNewRent[r].HouseID);
				$('.RoomCopy').eq(r+1).children().eq(0).text(aNewRent[r].HouseID);
				$('.RoomCopy').eq(r+1).children().eq(1).text(aNewRent[r].RoomID);
				$('.RoomCopy').eq(r+1).children().eq(2).text(aNewRent[r].Status);
			}
			}
			
			$('.RoomCopy .cur').click(function() {
				$('.tableCopy:gt(0)').remove();
				var RentID = $(this).siblings().eq(1).text();
				console.log(RentID);
				$.get('/ph/Api/get_room_change_details/RoomID/'+RentID,function(res){
					res=JSON.parse(res);
					console.log(res.data.length);
					// console.log(res);
					for(var i=0;i<res.data.length;i++){
						$('#tbo').append($('.tableCopy').eq(0).clone());
						$('.tableCopy:gt(0)').show();
						$('.tableCopy').eq(i+1).children().eq(0).text(res.data[i].old);
						$('.tableCopy').eq(i+1).children().eq(1).text(res.data[i].new);
						$('.tableCopy').eq(i+1).children().eq(2).text(res.data[i].name);
						if(res.data[i].status==1){
							$('.tableCopy').eq(i+1).children().eq(2).addClass('am-text-secondary');
						}
					 }
					layer.open({
						type:1,
						area:['800px','600px'],
						resize:false,
						title:['调整明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
						content:$('#AdjustDetail')
					});
				})//房间信息

			})//房间点击
			$('.HousedCopy').on('click','.cur',function(){
				
				$('.tableCopy:gt(0)').remove();
				var RentHouseID=$(this).siblings().eq(0).text();
				console.log(RentHouseID);
				$.get('/ph/Api/get_house_change_details/HouseID/'+RentHouseID,function(res){
						res=JSON.parse(res);
					console.log(res.data.length);
					// console.log(res);
					for(var i=0;i<res.data.length;i++){
						$('#tbo').append($('.tableCopy').eq(0).clone());
						$('.tableCopy:gt(0)').show();
						$('.tableCopy').eq(i+1).children().eq(0).text(res.data[i].old);
						$('.tableCopy').eq(i+1).children().eq(1).text(res.data[i].new);
						$('.tableCopy').eq(i+1).children().eq(2).text(res.data[i].name);
						if(res.data[i].status==1){
							$('.tableCopy').eq(i+1).children().eq(2).addClass('am-text-secondary');
						}
					 }
					layer.open({
						type:1,
						area:['800px','600px'],
						resize:false,
						title:['调整明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
						content:$('#AdjustDetail')
					});
				});
			});
				// $('#banDetail').css('display','block');
				var allMap = new BMap.Map("allMapd",{enableMapClick: false});
				allMap.clearOverlays();
		//		allMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 15);

				var point2 = new BMap.Point(res.data.detail.BanGpsX,res.data.detail.BanGpsY);
				allMap.centerAndZoom(point2, 15);		
		//		allMap.setCenter(point2);
				
				marker = new BMap.Marker(point2);
				allMap.addOverlay(marker);   
					console.log(res);
			processState('#NewRentState',res);
			metailShow('#NewRentPhotos',res);
			// metailShow('#approveBan',res);
		}else if(type == 9){//房屋调整(最后调整)
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.Ehide').css('display','none');
			$('.HouseID').text(res.data.detail.HouseID);
			$('.BanID').text(res.data.detail.BanID);
			$('.BanAddress').text(res.data.detail.BanAddress);
			$('.FloorID').text(res.data.detail.BanFloorNum);
			$('.TenantName').text(res.data.detail.TenantName);
			$('.TenantTel').text(res.data.detail.TenantTel);
			$('.TenantNumber').text(res.data.detail.TenantNumber);
			$('.CreateTime').text(res.data.detail.CreateTime);
			$('.HouseArea').text(res.data.detail.TotalArea);
			$('.LeasedArea').text(res.data.detail.LeasedArea);
			$('.DamageGrade').text(res.data.detail.DamageGrade);
			$('.StructureType').text(res.data.detail.StructureType);
			$('.Dhide').css('display','block');
			$('.DamageGradeChange').text(res.data.detail.NewDamage);//
			processState('#AdjustState',res);
			metailShow('#AdjustPhotos',res);
			CordID = "#houseAdjust";
		}else if(type == 10){//管段调整
			processState('#PipeState',res);
			metailShow('#PipePhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			if(res.data.detail.HouseID){
				console.log()
				$('#PipeAdjustBan').hide();
				$('#PipeAdjustHouse').show();
				$('.PipeAdjustedBan').text('房屋编号：');
				$('.PipeBanId').text(res.data.detail[1].HouseID);
				$("#PipeBanNumd").text(res.data.detail[0].BanID);
				$("#PipeHouseAddressd").text(res.data.detail[0].BanAddress);
				$("#PipeLayerd").text(res.data.detail[1].FloorID);
				$("#PipeRenterd").text(res.data.detail[1].TenantName);
				$("#PipePhoneNumd").text(res.data.detail[1].TenantTel);
				$("#PipeIDd").text(res.data.detail[1].TenantNumber);
				$("#PipeTimed").text(res.data.detail[0].CreateTime);
				$("#PipeBulid").text(res.data.detail[1].CoveredArea);
				$("#PipeRentArea").text(res.data.detail[1].LeasedArea);
				$('#PipeTubulationID').text(res.data.detail[0].TubulationID);
				$('#OldPipe').text(res.data.detail[0].InstitutionID);
				$('#NewPipe').text(res.data.detail.NewInstitutionID);
			}else{
				$('.PipeBanId').text(res.data.detail.BanID);
				$('.PipeHouseAddress').text(res.data.detail.BanAddress);
				$('.PipeUseNature').text(res.data.detail.UseNature);
				$('.PipeUnitNumber').text(res.data.detail.BanUnitNum);
				$('.PipeFloorID').text(res.data.detail.BanFloorNum);
				$('.PipeStructure').text(res.data.detail.StructureType);
				$('.PipeDamageGrade').text(res.data.detail.DamageGrade);
				$('#OldPipe').text(res.data.detail.InstitutionID);
				$('#NewPipe').text(res.data.detail.NewInstitutionID);
				$('.PipeType').text(res.data.detail.OwnerType);
				$('.PipeHouseArea').text(res.data.detail.TotalArea);
				$('.PipeCorverArea').text(res.data.detail.CoveredArea);
			}
			CordID = "#PipeAdjusted";
		}else if(type == 11){//租金追加调整
			processState('#AddState',res);
			metailShow('#AddPhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.AddHouseID').text(res.data.detail.HouseID);
			$('.AddBanID').text(res.data.detail.BanID);
			$('.AddBanAddress').text(res.data.detail.BanAddress);
			$('.AddFloorID').text(res.data.detail.FloorID);
			$('.AddTenantName').text(res.data.detail.TenantName);
			$('.AddTenantTel').text(res.data.detail.TenantTel);
			$('.AddTenantNumber').text(res.data.detail.TenantNumber);
			$('.AddCreateTime').text(res.data.detail.CreateTime);
			$('.AddHouseArea').text(res.data.detail.HouseArea);
			$('.AddLeasedArea').text(res.data.detail.LeasedArea);
			$('#AddTime').text(res.data.detail.DateStart);
			$('#AddMoney').text(res.data.detail.AddRent);
			CordID = "#AddAdjusted";
		}else if(type==12){
			CordID="#RentAdjust";
			processState('#AddRentState',res);
			metailShow('#AddRentAdjust',res);
			$("#AdjustBanID").text(res.data.detail.BanID);
			$("#AdjustBanAddress").text(res.data.detail.BanAddress);
			$("#AdjustFloorID").text(res.data.detail.FloorID);
			$("#AdjustTenantName").text(res.data.detail.TenantName);
			$("#AdjustTenantTel").text(res.data.detail.TenantTel);
			$("#AdjustTenantNumber").text(res.data.detail.TenantNumber);
			$("#AdjustCreateTime").text(res.data.detail.CreateTime);
			$("#AdjustHouseArea").text(res.data.detail.HouseArea);
			$("#AdjustLeasedArea").text(res.data.detail.LeasedArea);
			$('.AdjustOwnType').text(res.data.detail.OwnerTypes[0].OwnerType);
			$('#AdjustPrice').text(res.data.detail.OwnerTypes[0].HousePrerent);
			$('.AdjustOwnTypeA').text(res.data.detail.OwnerTypes[1].OwnerType);
			$('#AdjustPriceA').text(res.data.detail.OwnerTypes[1].HousePrerent);
			$('#AdjustHouseNum').text(res.data.detail.HouseID);
			$('#AdjustNewPrice').text(res.data.detail.NewHousePrerent);
			$('#AdjustNewPriceA').text(res.data.detail.NewAnathorHousePrerent);
		}else if(type==13){
			$('.SplitNum').unbind('click');
			$('.SplitRoom').children().remove();
			$('.SplitRoom2').children().remove();
			CordID="#SplitHouse";
			processState('#SplitFileState',res);
			metailShow('#SplitFile',res);
			var Oldarr=[];
			var OldRoomNumbers=res.data.detail.OldHouseInfo.RoomNumbers;
			for(var i in OldRoomNumbers){
				Oldarr.push(i);
			}
			for(var n=0;n<Oldarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Oldarr[n]+'</i><input type="hidden" value="'+OldRoomNumbers[Oldarr[n]]+'"/></li>';
				$('.SplitRoom').append(RoomHtml);
			}
			var Newarr=[];
			var NewRoomNumbers=res.data.detail.NewHouseInfo.RoomNumbers;
			for(var i in NewRoomNumbers){
				Newarr.push(i);
			}
			for(var n=0;n<Newarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Newarr[n]+'</i><input type="hidden" value="'+NewRoomNumbers[Newarr[n]]+'"/></li>';
				$('.SplitRoom2').append(RoomHtml);
			}
			$("#SplitHouseID").text(res.data.detail.OldHouseInfo.HouseID);
			$("#SplitBanID").text(res.data.detail.OldHouseInfo.BanID);
			$("#SplitBanAddress").text(res.data.detail.OldHouseInfo.BanAddress);
			$("#SplitFloorID").text(res.data.detail.OldHouseInfo.FloorID);
			$("#SplitTenantName").text(res.data.detail.OldHouseInfo.TenantName);
			$("#SplitTenantTel").text(res.data.detail.OldHouseInfo.TenantTel);
			$("#SplitTenantNumber").text(res.data.detail.OldHouseInfo.TenantNumber);
			$("#SplitCreateTime").text(res.data.detail.OldHouseInfo.CreateTime);
			$("#SplitHouseArea").text(res.data.detail.OldHouseInfo.HouseArea);
			$("#SplitLeasedArea").text(res.data.detail.OldHouseInfo.LeasedArea);
			$("#SplitAddID").text(res.data.detail.NewHouseInfo.BanID);
			$("#SplitAddAddress").text(res.data.detail.NewHouseInfo.BanAddress);
			$("#SplitAddFloor").text(res.data.detail.NewHouseInfo.FloorID);
			$("#SplitAddName").text(res.data.detail.NewHouseInfo.TenantName);
			$("#SplitAddTel").text(res.data.detail.NewHouseInfo.TenantTel);
			$("#SplitAddNumber").text(res.data.detail.NewHouseInfo.TenantNumber);
			$("#SplitAddTime").text(res.data.detail.NewHouseInfo.CreateTime);
			$("#SplitAddArea").text(res.data.detail.NewHouseInfo.HouseArea);
			$("#SplitAddLeased").text(res.data.detail.NewHouseInfo.LeasedArea);
			$("#SplitAddNum").text(res.data.detail.NewHouseInfo.HouseID);
		}else if(type==14){
			$('.SplitNum').unbind('click');
			$('.HoldRoom').children().remove();
			$('.HoldRoom2').children().remove();
			CordID="#HouseHolds";
			processState('#HouseHoldsState',res);
			metailShow('#HouseHoldsFile',res);
			var Oldarr=[];
			var OldRoomNumbers=res.data.detail.OldHouseInfo.RoomNumbers;
			for(var i in OldRoomNumbers){
				Oldarr.push(i);
			}
			for(var n=0;n<Oldarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Oldarr[n]+'</i><input type="hidden" value="'+OldRoomNumbers[Oldarr[n]]+'"/></li>';
				$('.HoldRoom').append(RoomHtml);
			}
			var Newarr=[];
			var NewRoomNumbers=res.data.detail.NewHouseInfo.RoomNumbers;
			for(var i in NewRoomNumbers){
				Newarr.push(i);
			}
			for(var n=0;n<Newarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Newarr[n]+'</i><input type="hidden" value="'+NewRoomNumbers[Newarr[n]]+'"/></li>';
				$('.HoldRoom2').append(RoomHtml);
			}
			$("#HoldsHouseNum").text(res.data.detail.OldHouseInfo.HouseID);
			$("#HoldsBanID").text(res.data.detail.OldHouseInfo.BanID);
			$("#HoldsBanAddress").text(res.data.detail.OldHouseInfo.BanAddress);
			$("#HoldsFloorID").text(res.data.detail.OldHouseInfo.FloorID);
			$("#HoldsTenantName").text(res.data.detail.OldHouseInfo.TenantName);
			$("#HoldsTenantTel").text(res.data.detail.OldHouseInfo.TenantTel);
			$("#HoldsTenantNumber").text(res.data.detail.OldHouseInfo.TenantNumber);
			$("#HoldsCreateTime").text(res.data.detail.OldHouseInfo.CreateTime);
			$("#HoldsHouseArea").text(res.data.detail.OldHouseInfo.HouseArea);
			$("#HoldsLeasedArea").text(res.data.detail.OldHouseInfo.LeasedArea);
			$("#CancelID").text(res.data.detail.NewHouseInfo.BanID);
			$("#CancelAddress").text(res.data.detail.NewHouseInfo.BanAddress);
			$("#CancelFloor").text(res.data.detail.NewHouseInfo.FloorID);
			$("#CancelName").text(res.data.detail.NewHouseInfo.TenantName);
			$("#CancelTel").text(res.data.detail.NewHouseInfo.TenantTel);
			$("#CancelNumber").text(res.data.detail.NewHouseInfo.TenantNumber);
			$("#CancelTime").text(res.data.detail.NewHouseInfo.CreateTime);
			$("#CancelArea").text(res.data.detail.NewHouseInfo.HouseArea);
			$("#CancelLeased").text(res.data.detail.NewHouseInfo.LeasedArea);
			$("#CancelNum").text(res.data.detail.NewHouseInfo.HouseID);
			
		}
});
})



//明细
$('.BtnDetail').click(function(){
	var value = $(this).val(),
		CordID = "#approveForm";
	$(".breaks").hide();
	$(".pause").hide();
	$(".WriteOff").hide();
	$(".cancel").hide();
	$('#SerialNumber').text('房屋编号:');
	$(".LHide").css('display','block');
	console.log(value);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		var type = res.data.detail.type;
		if(type == 1 || type == 2 || type == 3 || type == 4 || type == 8){
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
			$('.MuchMonth').text(res.data.detail.MuchMonth);
			$('.RemitRent').text(res.data.detail.RemitRent);
			$('.AownerType').text(res.data.detail.OwnerType);
			$('.HousePrerent').text(res.data.detail.HousePrerent||res.data.detail.PreRent);
			//$('#approveName').text(res.data.detail.ChangeType);
			if(type == 1){
				layer.open({
                    type: 1,
                    area: ['990px','780px'],
                    resize: false,
                    zIndex: 100,
                    title: ['租金减免详情', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                    content: $('#derate'),
                    success: function(){
                    	$('.derateHouseID').text(res.data.detail.HouseID);
                    	$('.derateBanID').text(res.data.detail.BanID);
                    	$('.derateAddress').text(res.data.detail.BanAddress);
                    	$('.derateOwnertype').text(res.data.detail.OwnerTypes[0].OwnerType);
                    	$('.derateUseNature').text(res.data.detail.UseNature);
                    	$('.detateHouseUsearea').text(res.data.detail.HouseUsearea);
                    	$('.derateLeasedArea').text(res.data.detail.LeasedArea);
                    	$('.derateHousePrerent').text(res.data.detail.HousePrerent);
                    	$('.derateTenantName').text(res.data.detail.TenantName);
                    	$('.derateTenantNumber').text(res.data.detail.TenantNumber);
                    	$('.derateTenantTel').text(res.data.detail.TenantTel);
                    	$('.derateMoney').text(res.data.detail.RemitRent);
                    	$('.derateType').text(res.data.detail.CutName);
                    	$('.derateNumber').text(res.data.detail.MuchMonth);
                    	$('.derateTime').text(res.data.detail.IDnumber);
						processState('#derateState',res);
						metailShow('#deratePhotos',res);
                    }
                })
			}else if(type == 2){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").hide();
				$(".cancel").hide();
				$('.Uhide').css('display','block');
				$('.Ushow').css('display','none');
			}else if(type == 3){
				layer.open({
                    type: 1,
                    area: ['990px','780px'],
                    resize: false,
                    zIndex: 100,
                    title: ['暂停计租详情', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                    content: $('#pauseDetail'),
                    success: function(){
                    	var house_str = '';
                    	$('.pauseBanId').text(res.data.detail.ban.BanID);
                    	$('.pauseAddress').text(res.data.detail.ban.BanAddress);
                    	$('.pauseOwnerType').text(res.data.detail.ban.OwnerType);
                    	$('.pauseInflRent').text(res.data.detail.InflRent);
                    	$('.pauseCreateTime').text(res.data.detail.ban.CreateTime);
                    	$('.status_2').hide();
                    	for(var i = 0;i < res.data.detail.house.length;i++){
                    		house_str += '<tr>\
				                <td style="width:200px;">'+i+'</td>\
				                <td style="width:200px;">'+res.data.detail.house[i].HouseID+'</td>\
				                <td style="width:200px;">'+res.data.detail.house[i].TenantName+'</td>\
				                <td style="width:350px;">'+res.data.detail.house[i].HousePrerent+'</td>\
				            </tr>';
                    	}
                    	$('#pauseHouseDetail').append($(house_str));
						processState('#pauseRentState',res);
						metailShow('#pauseRentPhotos',res);
                    }
                })
			}else if(type == 4){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").show();
				$(".cancel").hide();
				$('.Uhide').css('display','block');
				$('.Ushow').css('display','none');
				$('.WriteOffStartTime').text(res.data.detail.DateStart);
				$('.WriteOffEndTime').text(res.data.detail. DateEnd);
			}else if(type == 8){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").hide();
				$(".cancel").show();
				$('.Uhide').css('display','block');
				$('.Ushow').css('display','none');
				$('.Ahide').css('display','none');
					$('.APFloorID').text(res.data.detail.BanFloorNum);
					$('.APhouseArea').text(res.data.detail.BanUsearea);
					$('#SerialNumber').text('楼栋编号:');
					$('.APhouseId').text(res.data.detail.BanID);
			}
			//processState('#approveState',res);
			//metailShow('#layer-photos-demo',res);
			//CordID = "#approveForm";
		}else if(type == 5){
			metailShow('#AdjustPhotos',res);
			processState('#AdjustState',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.Ehide').css('display','block');
			$('.HouseID').text(res.data.detail.HouseID);
			$('.BanID').text(res.data.detail.BanID);
			$('.BanAddress').text(res.data.detail.BanAddress);
			$('.FloorID').text(res.data.detail.FloorID);
			$('.TenantName').text(res.data.detail.TenantName);
			$('.TenantTel').text(res.data.detail.TenantTel);
			$('.TenantNumber').text(res.data.detail.TenantNumber);
			$('.CreateTime').text(res.data.detail.CreateTime);
			$('.HouseArea').text(res.data.detail.HouseArea);
			$('.LeasedArea').text(res.data.detail.LeasedArea);
			$('.DamageGrade').text(res.data.detail.DamageGrade);
			$('.StructureType').text(res.data.detail.StructureType);
			$('.Dhide').css('display','none');
			// $('.DamageGradeChange').text(res.data.detail.StructureType);//
			CordID = "#houseAdjust";

		}else if(type == 6){//维修
			processState('#RepairState',res);
			metailShow('#RepairPhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('#RCBanID').text(res.data.detail.BanID);
			$('#RCReason').text(res.data.detail.RepairReson);
			$('#RCRepairType').text(res.data.detail.RepairType);
			$('#OldUseNature').text(res.data.detail.OldUseNature);
			$('#OldOwnerType').text(res.data.detail.OldOwnerType);
			$('#OldBanUnitNum').text(res.data.detail.OldBanUnitNum);
			$('#OldBanFloorNum').text(res.data.detail.OldBanFloorNum);
			$('#OldStructure').text(res.data.detail.OldStructure);
			$('#OldCoveredArea').text(res.data.detail.OldCoveredArea);
			$('#OldTotalArea').text(res.data.detail.OldTotalArea);
			$('#OldDamageGrade').text(res.data.detail.OldDamageGrade);
			$('#RCBanAddress').text(res.data.detail.BanAddress);
			$('#UseNature').text(res.data.detail.UseNature);
			$('#OwnerType').text(res.data.detail.OwnerType);
			$('#BanUnitNum').text(res.data.detail.BanUnitNum);
			$('#BanFloorNum').text(res.data.detail.BanFloorNum);
			$('#Structure').text(res.data.detail.Structure);
			$('#CoveredArea').text(res.data.detail.CoveredArea);
			$('#TotalArea').text(res.data.detail.TotalArea);
			$('#DamageGrade').text(res.data.detail.DamageGrade);
			CordID = "#repairChange";
		}else if(type == 7){//新发租
			//$('.HousedCopy li:lt(3)').empty();
			 $('.ManyRoom').children('.RoomCopy').remove();
			 $(".HousedCopy:eq(0)").hide();
			 $(".HousedCopy:eq(0)").nextAll().remove();
			CordID = "#banDetail";
			if(res.data.BanGpsX==""||res.data.BanGpsY==""){
				res.data.BanGpsX = "114.334228";
				res.data.BanGpsY = "30.560372";
			};
			$('p[id=BanID]').text(res.data.detail.BanID);                 //楼栋编号
			$('p[id=BanAddress]').text(res.data.detail.BanAddress);       //楼栋地址
			$('p[id=BanPropertyID]').text(res.data.detail.BanPropertyID); //产权证号
			$('p[id=BanYear]').text(res.data.detail.BanYear);             //建造年份
			$('p[id=DamageGrade]').text(res.data.detail.DamageGrade);     //完损等级
			$('p[id=OwnerType]').text(res.data.detail.OwnerType);         //楼栋产别
			$('p[id=PreRent]').text(res.data.detail.PreRent);             //规定租金
			$('p[id=StructureType]').text(res.data.detail.StructureType); //结构类型
			$('p[id=TubulationID]').text(res.data.detail.TubulationID);   //机构名称
			$('p[id=UseNature]').text(res.data.detail.UseNature);         //使用性质
			$('p[id=BanFloorNum]').text(res.data.detail.BanFloorNum);     //总楼层数
			$('p[id=BanFloorStart]').text(res.data.detail.BanFloorStart); //起始楼层数
			$('p[id=BanFreeholdID]').text(res.data.detail.BanFreeholdID); //不动产证号

			$('#DetailsTotalHouseHolds').text(res.data.detail.TotalHouseholds);
			$('#detailsTotalArea').text(res.data.detail.CoveredArea);
			$('#detailActualArea').text(res.data.detail.ActualArea);
			$('#detailBanArea').text(res.data.detail.BanArea);
			$('#detailEnterpriseArea').text(res.data.detail.EnterpriseArea);
			$('#detailPartyArea').text(res.data.detail.PartyArea);
			$('#detailCivilArea').text(res.data.detail.CivilArea);
			//$('#detailBanArea').text(res.data.BanArea); //计算租金
			$('#IfElevator').html(res.data.detail.IfElevator);
			$('#IfFirst').html(res.data.detail.IfFirst);
			$('p[id=BanLandID]').text(res.data.detail.BanLandID);         //土地证号
			$('p[id=BanUnitNum]').text(res.data.detail.BanUnitNum);       //总单元数
			$('p[id=CivilArea]').text(res.data.detail.CivilArea);         //民建面
			$('p[id=PartyArea]').text(res.data.detail.PartyArea);         //机关建面
			$('p[id=EnterpriseArea]').text(res.data.detail.EnterpriseArea);         //企业建面
			$('p[id=BanUsearea]').text(res.data.detail.BanUsearea);       //使用面积
			$('p[id=CutIf]').text(res.data.detail.CutIf);                 //产权是否分隔
			$('p[id=HistoryIf]').text(res.data.detail.HistoryIf);         //是否历史优秀建筑
			$('p[id=ProtectculturalIf]').text(res.data.detail.ProtectculturalIf);  //是否文物保护建筑
			$('p[id=ReformIf]').text(res.data.detail.ReformIf);           //是否改造产
			$('p[id=TotalArea]').text(res.data.detail.TotalArea);         //合建面积
			$('p[id=PropertySource]').text(res.data.detail.PropertySource);         //产权来源
			$('p[id=RemoveStatus]').text(res.data.detail.RemoveStatus);         //拆迁状态
			$('p[id=BanGpsXY]').text(res.data.detail.BanGpsX+','+res.data.detail.BanGpsY);         //经纬度
			if(res.data.detail.BanImageIDS.length ==3){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.detail.BanImageIDS[1].FileUrl);		//图片影像
				$('#detailImgThree').attr('src',res.data.detail.BanImageIDS[2].FileUrl);		//图片影像
			}else if(res.data.detail.BanImageIDS.length ==2){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.detail.BanImageIDS[1].FileUrl);		//图片影像
			}else if(res.data.detail.BanImageIDS.length ==1){
				$('#detailImgOne').attr('src',res.data.detail.BanImageIDS[0].FileUrl);	
			}
			if(res.data.newRent.house){
				var house_length = res.data.newRent.house.length;
			console.log(house_length);
			if(house_length > 0){
				for(var r=0;r<house_length;r++){
					$('.HouseDetail').after($('.HousedCopy').eq(0).clone());
					$('.HousedCopy').eq(r).show();
					$('.HousedCopy').eq(r).children().eq(0).text(res.data.newRent.house[r].HouseID);
					$('.HousedCopy').eq(r).children().eq(1).text(res.data.newRent.house[r].TenantName);
					$('.HousedCopy').eq(r).children().eq(2).text(res.data.newRent.house[r].Status);
				}
			}
			}
			
			// $('.HousedCopy').children().eq(0).text(res.data.newRent.house.HouseID);
			// $('.HousedCopy').children().eq(1).text(res.data.newRent.house.TenantName);
			// $('.HousedCopy').children().eq(2).text(res.data.newRent.house.Status);//房屋信息
			if(res.data.newRent.room){
				var aNewRent=res.data.newRent.room;
			for(var r=0;r<res.data.newRent.room.length;r++){
				$('.ManyRoom').append($('.RoomCopy').eq(0).clone().show());
					console.log(aNewRent[r].HouseID);
				$('.RoomCopy').eq(r+1).children().eq(0).text(aNewRent[r].HouseID);
				$('.RoomCopy').eq(r+1).children().eq(1).text(aNewRent[r].RoomID);
				$('.RoomCopy').eq(r+1).children().eq(2).text(aNewRent[r].Status);
			}
			}
			
			

			// $('#banDetail').css('display','block');
				var allMap = new BMap.Map("allMapd",{enableMapClick: false});
				allMap.clearOverlays();
		//		allMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 15);

				var point2 = new BMap.Point(res.data.detail.BanGpsX,res.data.detail.BanGpsY);
				allMap.centerAndZoom(point2, 15);		
		//		allMap.setCenter(point2);
				
				marker = new BMap.Marker(point2);
				allMap.addOverlay(marker);   
			processState('#NewRentState',res);
			metailShow('#NewRentPhotos',res);
			$('.RoomCopy .cur').click(function() {
				$('.tableCopy:gt(0)').remove();
				var RentID = $(this).siblings().eq(1).text();
				console.log(RentID);
				$.get('/ph/Api/get_room_change_details/RoomID/'+RentID,function(res){
					res=JSON.parse(res);
					console.log(res.data.length);
					// console.log(res);
					for(var i=0;i<res.data.length;i++){
						$('#tbo').append($('.tableCopy').eq(0).clone());
						$('.tableCopy:gt(0)').show();
						$('.tableCopy').eq(i+1).children().eq(0).text(res.data[i].old);
						$('.tableCopy').eq(i+1).children().eq(1).text(res.data[i].new);
						$('.tableCopy').eq(i+1).children().eq(2).text(res.data[i].name);
						if(res.data[i].status==1){
							$('.tableCopy').eq(i+1).children().eq(2).addClass('am-text-secondary');
						}
					 }
					layer.open({
						type:1,
						area:['800px','600px'],
						resize:false,
						title:['调整明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
						content:$('#AdjustDetail')
					});
				})//房间信息

			})//房间点击
			$('.HousedCopy').on('click','.cur',function(){
				$('.tableCopy:gt(0)').remove();
				var RentHouseID=$(this).siblings().eq(0).text();
				console.log(RentHouseID);
				$.get('/ph/Api/get_house_change_details/HouseID/'+RentHouseID,function(res){
						res=JSON.parse(res);
					console.log(res.data.length);
					// console.log(res);
					for(var i=0;i<res.data.length;i++){
						$('#tbo').append($('.tableCopy').eq(0).clone());
						$('.tableCopy:gt(0)').show();
						$('.tableCopy').eq(i+1).children().eq(0).text(res.data[i].old);
						$('.tableCopy').eq(i+1).children().eq(1).text(res.data[i].new);
						$('.tableCopy').eq(i+1).children().eq(2).text(res.data[i].name);
						if(res.data[i].status==1){
							$('.tableCopy').eq(i+1).children().eq(2).addClass('am-text-secondary');
						}
					 }
					layer.open({
						type:1,
						area:['800px','600px'],
						resize:false,
						title:['调整明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
						content:$('#AdjustDetail')
					});
				});
			});
		}else if(type == 9){//房屋调整(最后调整)
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.Ehide').css('display','none');
			$('.HouseID').text(res.data.detail.HouseID);
			$('.BanID').text(res.data.detail.BanID);
			$('.BanAddress').text(res.data.detail.BanAddress);
			$('.FloorID').text(res.data.detail.BanFloorNum);
			$('.TenantName').text(res.data.detail.TenantName);
			$('.TenantTel').text(res.data.detail.TenantTel);
			$('.TenantNumber').text(res.data.detail.TenantNumber);
			$('.CreateTime').text(res.data.detail.CreateTime);
			$('.HouseArea').text(res.data.detail.TotalArea);
			$('.LeasedArea').text(res.data.detail.LeasedArea);
			$('.DamageGrade').text(res.data.detail.DamageGrade);
			$('.StructureType').text(res.data.detail.StructureType);
			$('.Dhide').css('display','block');
			$('.DamageGradeChange').text(res.data.detail.NewDamage);//
			processState('#AdjustState',res);
			metailShow('#AdjustPhotos',res);
			CordID = "#houseAdjust";
		}else if(type == 10){//管段调整
			processState('#PipeState',res);
			metailShow('#PipePhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			console.log(res.data.detail.HouseID);
			if(res.data.detail.HouseID){
				console.log()
				$('#PipeAdjustBan').hide();
				$('#PipeAdjustHouse').show();
				$('.PipeAdjustedBan').text('房屋编号：');
				$('.PipeBanId').text(res.data.detail[1].HouseID);
				$("#PipeBanNumd").text(res.data.detail[0].BanID);
				$("#PipeHouseAddressd").text(res.data.detail[0].BanAddress);
				$("#PipeLayerd").text(res.data.detail[1].FloorID);
				$("#PipeRenterd").text(res.data.detail[1].TenantName);
				$("#PipePhoneNumd").text(res.data.detail[1].TenantTel);
				$("#PipeIDd").text(res.data.detail[1].TenantNumber);
				$("#PipeTimed").text(res.data.detail[0].CreateTime);
				$("#PipeBulid").text(res.data.detail[1].CoveredArea);
				$("#PipeRentArea").text(res.data.detail[1].LeasedArea);
				$('#PipeTubulationID').text(res.data.detail[0].TubulationID);
				$('#OldPipe').text(res.data.detail[0].InstitutionID);
				$('#NewPipe').text(res.data.detail.NewInstitutionID);
			}else{
				$('.PipeBanId').text(res.data.detail.BanID);
				$('.PipeHouseAddress').text(res.data.detail.BanAddress);
				$('.PipeUseNature').text(res.data.detail.UseNature);
				$('.PipeUnitNumber').text(res.data.detail.BanUnitNum);
				$('.PipeFloorID').text(res.data.detail.BanFloorNum);
				$('.PipeStructure').text(res.data.detail.StructureType);
				$('.PipeDamageGrade').text(res.data.detail.DamageGrade);
				$('#OldPipe').text(res.data.detail.InstitutionID);
				$('#NewPipe').text(res.data.detail.NewInstitutionID);
				$('.PipeType').text(res.data.detail.OwnerType);
				$('.PipeHouseArea').text(res.data.detail.TotalArea);
				$('.PipeCorverArea').text(res.data.detail.CoveredArea);
			}
			
			
			CordID = "#PipeAdjusted";
		}else if(type == 11){//租金追加调整
			processState('#AddState',res);
			metailShow('#AddPhotos',res);
			$('.Uhide').css('display','block');
			$('.Ushow').css('display','none');
			$('.AddHouseID').text(res.data.detail.HouseID);
			$('.AddBanID').text(res.data.detail.BanID);
			$('.AddBanAddress').text(res.data.detail.BanAddress);
			$('.AddFloorID').text(res.data.detail.FloorID);
			$('.AddTenantName').text(res.data.detail.TenantName);
			$('.AddTenantTel').text(res.data.detail.TenantTel);
			$('.AddTenantNumber').text(res.data.detail.TenantNumber);
			$('.AddCreateTime').text(res.data.detail.CreateTime);
			$('.AddHouseArea').text(res.data.detail.HouseArea);
			$('.AddLeasedArea').text(res.data.detail.LeasedArea);
			$('#AddTime').text(res.data.detail.DateStart);
			$('#AddMoney').text(res.data.detail.AddRent);
			CordID = "#AddAdjusted";
		}else if(type == 12){
			CordID="#RentAdjust";
			processState('#AddRentState',res);
			metailShow('#AddRentAdjust',res);
			$("#AdjustBanID").text(res.data.detail.BanID);
			$("#AdjustBanAddress").text(res.data.detail.BanAddress);
			$("#AdjustFloorID").text(res.data.detail.FloorID);
			$("#AdjustTenantName").text(res.data.detail.TenantName);
			$("#AdjustTenantTel").text(res.data.detail.TenantTel);
			$("#AdjustTenantNumber").text(res.data.detail.TenantNumber);
			$("#AdjustCreateTime").text(res.data.detail.CreateTime);
			$("#AdjustHouseArea").text(res.data.detail.HouseArea);
			$("#AdjustLeasedArea").text(res.data.detail.LeasedArea);
			$('.AdjustOwnType').text(res.data.detail.OwnerTypes[0].OwnerType);
			$('#AdjustPrice').text(res.data.detail.OwnerTypes[0].HousePrerent);
			$('.AdjustOwnTypeA').text(res.data.detail.OwnerTypes[1].OwnerType);
			$('#AdjustPriceA').text(res.data.detail.OwnerTypes[1].HousePrerent);
			$('#AdjustHouseNum').text(res.data.detail.HouseID);
			$('#AdjustNewPrice').text(res.data.detail.NewHousePrerent);
			$('#AdjustNewPriceA').text(res.data.detail.NewAnathorHousePrerent);
		}else if(type==13){
			$('.SplitNum').unbind('click');
			$('.SplitRoom').children().remove();
			$('.SplitRoom2').children().remove();
			CordID="#SplitHouse";
			processState('#SplitFileState',res);
			metailShow('#SplitFile',res);
			var Oldarr=[];
			var OldRoomNumbers=res.data.detail.OldHouseInfo.RoomNumbers;
			for(var i in OldRoomNumbers){
				Oldarr.push(i);
			}
			for(var n=0;n<Oldarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Oldarr[n]+'</i><input type="hidden" value="'+OldRoomNumbers[Oldarr[n]]+'"/></li>';
				$('.SplitRoom').append(RoomHtml);
			}
			var Newarr=[];
			var NewRoomNumbers=res.data.detail.NewHouseInfo.RoomNumbers;
			for(var i in NewRoomNumbers){
				Newarr.push(i);
			}
			for(var n=0;n<Newarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Newarr[n]+'</i><input type="hidden" value="'+NewRoomNumbers[Newarr[n]]+'"/></li>';
				$('.SplitRoom2').append(RoomHtml);
			}
			$("#SplitHouseID").text(res.data.detail.OldHouseInfo.HouseID);
			$("#SplitBanID").text(res.data.detail.OldHouseInfo.BanID);
			$("#SplitBanAddress").text(res.data.detail.OldHouseInfo.BanAddress);
			$("#SplitFloorID").text(res.data.detail.OldHouseInfo.FloorID);
			$("#SplitTenantName").text(res.data.detail.OldHouseInfo.TenantName);
			$("#SplitTenantTel").text(res.data.detail.OldHouseInfo.TenantTel);
			$("#SplitTenantNumber").text(res.data.detail.OldHouseInfo.TenantNumber);
			$("#SplitCreateTime").text(res.data.detail.OldHouseInfo.CreateTime);
			$("#SplitHouseArea").text(res.data.detail.OldHouseInfo.HouseArea);
			$("#SplitLeasedArea").text(res.data.detail.OldHouseInfo.LeasedArea);
			$("#SplitAddID").text(res.data.detail.NewHouseInfo.BanID);
			$("#SplitAddAddress").text(res.data.detail.NewHouseInfo.BanAddress);
			$("#SplitAddFloor").text(res.data.detail.NewHouseInfo.FloorID);
			$("#SplitAddName").text(res.data.detail.NewHouseInfo.TenantName);
			$("#SplitAddTel").text(res.data.detail.NewHouseInfo.TenantTel);
			$("#SplitAddNumber").text(res.data.detail.NewHouseInfo.TenantNumber);
			$("#SplitAddTime").text(res.data.detail.NewHouseInfo.CreateTime);
			$("#SplitAddArea").text(res.data.detail.NewHouseInfo.HouseArea);
			$("#SplitAddLeased").text(res.data.detail.NewHouseInfo.LeasedArea);
			$("#SplitAddNum").text(res.data.detail.NewHouseInfo.HouseID);
			
		}else if(type==14){
			$('.SplitNum').unbind('click');
			$('.HoldRoom').children().remove();
			$('.HoldRoom2').children().remove();
			CordID="#HouseHolds";
			processState('#HouseHoldsState',res);
			metailShow('#HouseHoldsFile',res);
			var Oldarr=[];
			var OldRoomNumbers=res.data.detail.OldHouseInfo.RoomNumbers;
			for(var i in OldRoomNumbers){
				Oldarr.push(i);
			}
			for(var n=0;n<Oldarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Oldarr[n]+'</i><input type="hidden" value="'+OldRoomNumbers[Oldarr[n]]+'"/></li>';
				$('.HoldRoom').append(RoomHtml);
			}
			var Newarr=[];
			var NewRoomNumbers=res.data.detail.NewHouseInfo.RoomNumbers;
			for(var i in NewRoomNumbers){
				Newarr.push(i);
			}
			for(var n=0;n<Newarr.length;n++){
				var RoomHtml = '<li><i class="SplitNum cur">'+Newarr[n]+'</i><input type="hidden" value="'+NewRoomNumbers[Newarr[n]]+'"/></li>';
				$('.HoldRoom2').append(RoomHtml);
			}
			$("#HoldsHouseNum").text(res.data.detail.OldHouseInfo.HouseID);
			$("#HoldsBanID").text(res.data.detail.OldHouseInfo.BanID);
			$("#HoldsBanAddress").text(res.data.detail.OldHouseInfo.BanAddress);
			$("#HoldsFloorID").text(res.data.detail.OldHouseInfo.FloorID);
			$("#HoldsTenantName").text(res.data.detail.OldHouseInfo.TenantName);
			$("#HoldsTenantTel").text(res.data.detail.OldHouseInfo.TenantTel);
			$("#HoldsTenantNumber").text(res.data.detail.OldHouseInfo.TenantNumber);
			$("#HoldsCreateTime").text(res.data.detail.OldHouseInfo.CreateTime);
			$("#HoldsHouseArea").text(res.data.detail.OldHouseInfo.HouseArea);
			$("#HoldsLeasedArea").text(res.data.detail.OldHouseInfo.LeasedArea);
			$("#CancelID").text(res.data.detail.NewHouseInfo.BanID);
			$("#CancelAddress").text(res.data.detail.NewHouseInfo.BanAddress);
			$("#CancelFloor").text(res.data.detail.NewHouseInfo.FloorID);
			$("#CancelName").text(res.data.detail.NewHouseInfo.TenantName);
			$("#CancelTel").text(res.data.detail.NewHouseInfo.TenantTel);
			$("#CancelNumber").text(res.data.detail.NewHouseInfo.TenantNumber);
			$("#CancelTime").text(res.data.detail.NewHouseInfo.CreateTime);
			$("#CancelArea").text(res.data.detail.NewHouseInfo.HouseArea);
			$("#CancelLeased").text(res.data.detail.NewHouseInfo.LeasedArea);
			$("#CancelNum").text(res.data.detail.NewHouseInfo.HouseID);
		}
		// layer.open({
		// 	type:1,
		// 	area:['950px','800px'],
		// 	resize:false,
		// 	zIndex:100,
		// 	title:['查看明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		// 	content:$(CordID)
		// });
	});
});
$(document).on('click','.SplitNum',function() {
	var val =$(this).next().val();
	console.log(val);
	$.get('/ph/Room/detail/RoomID/'+val,function(res){
		res = JSON.parse(res);
		$("#DRoomID").text(res.data.RoomID);
		$("#DBanID").text(res.data.BanID);
		$("#DHouseID").text(res.data.HouseID);
		$("#DRoomType").text(res.data.RoomType);
		$("#DUnitID").text(res.data.UnitID);
		$("#DFloorID").text(res.data.FloorID);
		$("#DRentPoint").text(res.data.RentPoint);
		$("#DUseArea").text(res.data.UseArea);
		$("#DLeasedArea").text(res.data.LeasedArea);
		$("#DItems").text(res.data.Items);
		$("#DRoomNumber").text(res.data.RoomNumber);
		$('.BanAddress').text(res.data.BanAddress);
		$('#RoomNumber').text(res.data.RoomNumber);
		layer.open({
			type:1,
			area:['800px','600px'],
			resize:false,
			zIndex:100,
			title:['房间明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#RoomDetail'),
			btn:['确定','取消'],
			success:function(){}
		});
	})															
});

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
	console.log(id);
	layer.photos({
	  photos: id
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