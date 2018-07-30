//审批
$('.BtnApprove').click(function(){
	var value = $(this).val(),
		CordID = "#approveForm";
	$(".breaks").hide();
	$(".pause").hide();
	$(".WriteOff").hide();
	$('.rent_reduction').hide();
	$('.cancel').hide();
	$('#SerialNumber').text('房屋编号:');
	$(".LHide").css('display','block');
	console.log(value);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		var type = res.data.detail.type;
		if(type == 1){
			new file({
                show: "#noticeBookShow",
                upButton: "#noticeBookUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#noticeBook",
                ChangeOrderID: '',
                Type: 1,
                title: "审通知书"
            });
            $('.rent_reduction').show();
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
        	$('.derateMoney').text(res.data.detail.InflRent);
        	$('.derateType').text(res.data.detail.CutName);
        	$('.derateNumber').text(res.data.detail.IDnumber);
            $('.derateTime').text(res.data.detail.MuchMonth+'月');
        	if(res.data.config.status == '1'){
				$('.status_2').show();
			}else{
				$('.status_2').hide();
			}
			processState('#derateState',res);
			metailShow('#deratePhotos',res);
			layerBox(value,'derate','租金减免审批',1,res.data.config.status);
		}else if(type == 2){
			$('.status_2').hide();
			$(".emptyRentHouseID").text(res.data.detail.HouseID);
			$(".emptyRentBanID").text(res.data.detail.BanID);
            $(".emptyRentAddress").text(res.data.detail.BanAddress);
            $(".emptyRentUseNature").text(res.data.detail.UseNature);
            $(".emptyRentHouseUsearea").text(res.data.detail.HouseUsearea);
            $(".emptyRentLeasedArea").text(res.data.detail.LeasedArea);
            $(".emptyRentOwnertype").text(res.data.detail.OwnerType);
            $(".emptyRentHousePrerent").text(res.data.detail.HousePrerent);
            $(".emptyRentCreateTime").text(res.data.detail.OrderCreateTime);
            $(".emptyRentReason").text(res.data.detail.Remark);
			$(".emptyRentTenantID").text(res.data.detail.Tenant.TenantID);
			$(".emptyRentTenantName").text(res.data.detail.Tenant.TenantName);
            $(".emptyRentTenantNumber").text(res.data.detail.Tenant.TenantNumber);
            $(".emptyRentTenantTel").text(res.data.detail.Tenant.TenantTel);
            if(res.data.detail.Tenant == ''){
            	$('.empty_rent_cancel').hide();
            	var title = '新增空租';
            }else{
            	$('.empty_rent_cancel').show();
            	var title = '取消空租';
            }
            if(res.data.config.status == '1' && res.data.detail.Tenant == ''){
				$('.status_2').show();
			}else{
				$('.status_2').hide();
			}
			new file({
                show: "#descriptionReportShow",
                upButton: "#descriptionReportUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#descriptionReport",
                ChangeOrderID: '',
                Type: 1,
                title: "空租情况说明报告"
            });
            new file({
                show: "#personalCheckApplicationShow",
                upButton: "#personalCheckApplicationUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#personalCheckApplication",
                ChangeOrderID: '',
                Type: 1,
                title: "个人退房申请"
            });
            new file({
                show: "#unitCheckApplicationShow",
                upButton: "#unitCheckApplicationUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#unitCheckApplication",
                ChangeOrderID: '',
                Type: 1,
                title: "单位退房申请"
            });
            new file({
                show: "#tenantLeaseShow",
                upButton: "#tenantLeaseUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#tenantLease",
                ChangeOrderID: '',
                Type: 1,
                title: "租户租约"
            });
            new file({
                show: "#tenantIDFileShow",
                upButton: "#tenantIDFileUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#tenantIDFile",
                ChangeOrderID: '',
                Type: 1,
                title: "租户身份证"
            });
            new file({
                show: "#emptyRentOtherShow",
                upButton: "#emptyRentOtherUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#emptyRentOther",
                ChangeOrderID: '',
                Type: 1,
                title: "其他"
            });
            processState('#emptyRentState',res);
			metailShow('#emptyRentPhotos',res);
			layerBox(value,'emptyRent',title,1,res.data.config.status);
		}else if(type == 3){
			new file({
                show: "#pauseUploadReportShow",
                upButton: "#pauseUploadReportUp",
                size: 10240,
                url: "/ph/ChangeApply/add",
                button: "#pauseUploadReport",
                ChangeOrderID: '',
                Type: 1,
                title: "上传报告"
            });
        	var house_str = '';
        	$('.pauseBanId').text(res.data.detail.ban.BanID);
        	$('.pauseAddress').text(res.data.detail.ban.BanAddress);
        	$('.pauseOwnerType').text(res.data.detail.ban.OwnerType);
        	$('.pauseInflRent').text(res.data.detail.InflRent);
        	$('.pauseCreateTime').text(res.data.detail.OrderCreateTime);
        	if(res.data.config.status == '1'){
				$('.status_2').show();
			}else{
				$('.status_2').hide();
			}
        	for(var i = 0;i < res.data.detail.house.length;i++){
        		house_str += '<tr>\
	                <td style="width:200px;">'+(i+1)+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].HouseID+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].TenantName+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].HousePrerent+'</td>\
	                <td style="width:350px;">'+res.data.detail.house[i].BanAddress+'</td>\
	            </tr>';
        	}
        	$('#pauseHouseDetail').empty();
        	$('#pauseHouseDetail').append($(house_str));
			processState('#pauseRentState',res);
			metailShow('#pauseRentPhotos',res);
			layerBox(value,'pause','暂停计租审批',1,res.data.config.status);
		}else if(type == 4){
			$('.oldCancelHouseID').text(res.data.detail.HouseID);
        	$('.oldCancelBanID').text(res.data.detail.BanID);
        	$('.oldCancelAddress').text(res.data.detail.BanAddress);
        	$('.oldCancelOwnertype').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.oldCancelUseNature').text(res.data.detail.UseNature);
        	$('.oldCancelHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.oldCancelLeasedArea').text(res.data.detail.LeasedArea);
        	$('.oldCancelHousePrerent').text(res.data.detail.HousePrerent);
        	$('.oldCancelTenantName').text(res.data.detail.TenantName);
        	$('.oldCancelTenantNumber').text(res.data.detail.TenantNumber);
        	$('.oldCancelTenantTel').text(res.data.detail.TenantTel);
        	$('.oldCancelReason').text(res.data.detail.Remark);


        	$('.oldCancelYear').text(res.data.detail.OldYearRent);
        	$('.oldCancelMonth').text(res.data.detail.Deadline);
        	$('.oldCancelMonthMoney').text(res.data.detail.OldMonthRent);
			if(res.data.config.status == '1'){
				$('.status_2').show();
				new file({
	                show: "#oldCancelBookShow",
	                upButton: "#oldCancelBooktUp",
	                size: 10240,
	                url: "/ph/ChangeApply/add",
	                button: "#oldCancelBook",
	                ChangeOrderID: '',
	                Type: 1,
	                title: "陈欠核销情况说明报告"
	            });
	            new file({
	                show: "#oldCancelOtherShow",
	                upButton: "#oldCancelOtherUp",
	                size: 10240,
	                url: "/ph/ChangeApply/add",
	                button: "#oldCancelOther",
	                ChangeOrderID: '',
	                Type: 1,
	                title: "其它"
	            });
			}else{
				$('.status_2').hide();
			}
			processState('#oldCancelState',res);
			metailShow('#oldCancelPhotos',res);
			layerBox(value,'oldCancel','陈欠核销详情',1,res.data.config.status);
		}else if(type == 8){
			$('.status_2').hide();
			$('.cancel').show();
			$('.CancelType').text(res.data.detail.CancelType);
        	$('.cancelHouseID').text(res.data.detail.HouseID);
        	$('.cancelUseNature').text(res.data.detail.UseNature);
        	$('.cancelDamageGrade').text(res.data.detail.DamageGrade);
        	$('.cancelOwnerTypes').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.cancelLeasedArea').text(res.data.detail.LeasedArea);
        	$('.cancelHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.cancelHousePrerent').text(res.data.detail.HousePrerent);
        	$('.cancelTenantName').text(res.data.detail.TenantName);
        	$('.cancelTenantNumber').text(res.data.detail.TenantNumber);
        	$('.cancelTenantTel').text(res.data.detail.TenantTel);
        	$('.cancelUnitID').text(res.data.detail.UnitID);
        	$('.cancelFloorID').text(res.data.detail.FloorID);
        	$('.Remark').text(res.data.detail.Remark);
        	$('.cancelCreateTime').text(res.data.detail.OrderCreateTime);
        	var house_str = '';
        	for(var i = 0;i < res.data.detail.Ban.length;i++){
        		house_str += '<tr>\
	                <td style="width:150px;">'+(i+1)+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].banID+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].houseArea+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].cancelHouseUsearea+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].housePrice+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].cancelPrent+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].HouseAdress+'</td>\
	            </tr>';
        	}
        	$('#cancelHouseDetail').empty();
        	$('#cancelHouseDetail').append($(house_str));
			if(res.data.config.status == '1'){
				$('.status_2').show();
				new file({
	                show: "#cancelUploadReportShow",
	                upButton: "#cancelUploadReportUp",
	                size: 10240,
	                url: "/ph/ChangeApply/add",
	                button: "#cancelUploadReport",
	                ChangeOrderID: '',
	                Type: 1,
	                title: "注销报告"
	            });
			}else{
				$('.status_2').hide();
			}
			processState('#cancelState',res);
			metailShow('#cancelPhotos',res);
			layerBox(value,'cancel','注销审批',1,res.data.config.status);
		}else if(type == 5){

		}else if(type == 6){//维修

		}else if(type == 7){//新发租

		}else if(type == 9){//房屋调整
            $('.houseAdjustHouseID').text(res.data.detail.HouseID);
            $('.houseAdjustRemark').text(res.data.detail.Remark);
            $('.houseAdjustCreateTime').text(res.data.detail.OrderCreateTime);
            var banObj = res.data.detail.Ban;
            var ban_info_clone = $('.ban_info').eq(0).clone();
            $('.ban_info').remove();
            for(var i = 0;i < banObj.length;i++){
                var ban_info = ban_info_clone.clone();
                ban_info.find('td').eq(0).text(banObj[i].BanID);
                ban_info.find('td').eq(1).text(banObj[i].BanAddress);
                ban_info.find('td').eq(2).text(banObj[i].PreRent);
                ban_info.find('td').eq(3).text(banObj[i].PreRentChange);
                ban_info.find('td').eq(4).text(banObj[i].PreRentAfter);
                ban_info.find('td').eq(5).text(banObj[i].BanUsearea);
                ban_info.find('td').eq(6).text(banObj[i].BanUseareaChange);
                ban_info.find('td').eq(7).text(banObj[i].BanUseareaAfter);
                ban_info.find('td').eq(8).text(banObj[i].TotalArea);
                ban_info.find('td').eq(9).text(banObj[i].TotalAreaChange);
                ban_info.find('td').eq(10).text(banObj[i].TotalAreaAfter);
                ban_info.find('td').eq(11).text(banObj[i].TotalOprice);
                ban_info.find('td').eq(12).text(banObj[i].TotalOpriceChange);
                ban_info.find('td').eq(13).text(banObj[i].TotalOpriceAfter);
                $('.adjusHouse_table').append(ban_info.show());
            }
            if(res.data.config.status == '1'){
                $('.status_2').show();
                new file({
                    show: "#adjustExplainShow",
                    upButton: "#adjustExplainUp",
                    size: 10240,
                    url: "/ph/ChangeApply/add",
                    button: "#adjustExplain",
                    ChangeOrderID: '',
                    Type: 1,
                    title: "调整说明"
                });
                new file({
                    show: "#HAOtherShow",
                    upButton: "#HAOtherUp",
                    size: 10240,
                    url: "/ph/ChangeApply/add",
                    button: "#HAOther",
                    ChangeOrderID: '',
                    Type: 1,
                    title: "其它"
                });
            }else{
                $('.status_2').hide();
            }
            processState('#HAState',res);
            metailShow('#HAPhotos',res);
            layerBox(value,'houseAdjust','房屋调整审批',1,res.data.config.status);
		}else if(type == 10){//管段调整

		}else if(type == 11){//租金追加调整
        	$('.rentAddHouseID').text(res.data.detail.HouseID);
        	$('.rentAddBanID').text(res.data.detail.BanID);
        	$('.rentAddAddress').text(res.data.detail.BanAddress);
        	$('.rentAddUseNature').text(res.data.detail.UseNature);
        	$('.rentAddHouseUseArea').text(res.data.detail.HouseUsearea);
        	$('.rentAddLeasedArea').text(res.data.detail.LeasedArea);
        	$('.rentAddTenantName').text(res.data.detail.TenantName);
        	$('.rentAddTenantNumber').text(res.data.detail.TenantNumber);
        	$('.rentAddTenantTel').text(res.data.detail.TenantTel);
        	$('.rentAddOwnerType').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.rentAddHousePrerent').text(res.data.detail.HousePrerent);
        	$('.rentAddDamageGrade').text(res.data.detail.DamageGrade);
        	$('.rentAddYear').text(res.data.detail.OldYearRent);
        	$('.rentAddMonth').text(res.data.detail.OldMonthRent);
        	$('.rentAddReason').text(res.data.detail.Remark);
        	processState('#rentAddState',res);
        	metailShow('#rentAddPhotos',res);
			var this_index = layer.open({
		        type: 1,
		        area: ['990px','780px'],
		        resize: false,
		        zIndex: 100,
		        title: ['租金追加调整审批', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
		        content: $('#rentAdd'),
		        btn:['通过','不通过'],
		        success: function(){

		        },
		        yes:function(){
		        	var formData = new FormData();
					formData.append('ChangeOrderID',value);
		        	processPass(formData,this_index);
		        },
		        btn2:function(){
					noPass(value)
				}
		    })
		}else if(type==12){
			$('.status_2').hide();
			$('#rentAdjustment').show();
			
        	$('.rentHouseID').text(res.data.detail.HouseID);
        	$('.rentType').text(res.data.detail.CancelType);
        	$('.rentUseNature').text(res.data.detail.UseNature);
        	$('.rentDamageGrade').text(res.data.detail.DamageGrade);
        	$('.rentOwnerTypes').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.rentLeasedArea').text(res.data.detail.LeasedArea);
        	$('.rentHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.rentHousePrerent').text(res.data.detail.HousePrerent);
        	$('.rentTenantName').text(res.data.detail.TenantName);
        	$('.rentTenantNumber').text(res.data.detail.TenantNumber);
        	$('.rentTenantTel').text(res.data.detail.TenantTel);
        	$('.rentRemark').text(res.data.detail.Remark);

        	var house_str = '';
        	for(var i = 0;i < res.data.detail.Ban.length;i++){
        		house_str += '<tr>\
	                <td style="width:150px;">'+(i+1)+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].banID+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].addRentMoney+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].HouseAdress+'</td>\
	            </tr>';
        	}
        	$('#rentBanDetail').empty();
        	$('#rentBanDetail').append($(house_str));
			if(res.data.config.status == '1'){
				$('.status_2').show();
				new file({
	                show: "#rentUploadReportShow",
	                upButton: "#rentUploadReportUp",
	                size: 10240,
	                url: "/ph/ChangeApply/add",
	                button: "#rentUploadReport",
	                ChangeOrderID: '',
	                Type: 1,
	                title: "规定租金调整说明"
	            });
			}else{
				$('.status_2').hide();
			}
			processState('#rentState',res);
			metailShow('#rentPhotos',res);
			layerBox(value,'rentAdjustment','规定租金审批',1,res.data.config.status);
		}else if(type==13){
			
		}else if(type==14){
            $('#buildingAdjustBanID').text(res.data.detail.BanID);
            $('#buildingAdjustAddress').text(res.data.detail.BanAddress);
            $('#buildingAdjustOwnerType').text(res.data.detail.OwnerType);
            $('#buildingAdjustBanUnitNum').text(res.data.detail.BanUnitNum);
            $('#buildingAdjustCoveredArea').text(res.data.detail.CoveredArea);
            $('#buildingAdjustTotalArea').text(res.data.detail.TotalArea);
            $('#buildingAdjustBanUsearea').text(res.data.detail.BanUsearea);
            $('#buildingAdjustTotalOprice').text(res.data.detail.TotalOprice);
            $('#buildingAdjustBanPrerent').text(res.data.detail.PreRent);
            $('#buildingAdjustReason').text(res.data.detail.Remark);
            $('#beforeAdjustDamageGrade').text(res.data.detail.beforeDamage);
            $('#beforeAdjustStructureType').text(res.data.detail.beforeStructure);
            $('#afterAdjustDamageGrade').text(res.data.detail.afterDamage);
            $('#afterAdjustStructureType').text(res.data.detail.afterStructure);
            if(res.data.config.status == '1'){
                $('.status_2').show();
                new file({
                    show: "#buildingAdjustOtherShow",
                    upButton:"#buildingAdjustOtherUp",
                    size: 10240,
                    url: "/ph/ChangeApply/add",
                    button: "#buildingAdjustOther",
                    ChangeOrderID: '',
                    Type: 1,
                    title: "其它"
                });
            }else{
                $('.status_2').hide();
            }
            processState('#buildingAdjustState',res);
            metailShow('#buildingAdjustPhotos',res);
            layerBox(value,'buildingAdjustment','楼栋调整',1,res.data.config.status);
		}
	});
})



//明细
$('.BtnDetail').click(function(){
	var value = $(this).val();
	$(".breaks").hide();
	$(".pause").hide();
	$('.rent_reduction').hide();
	$('.cancel').hide();
	$('#SerialNumber').text('房屋编号:');
	$(".LHide").css('display','block');
	console.log(value);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		var type = res.data.detail.type;
		if(type == 1){
			$('.status_2').hide();
			$('.rent_reduction').show();
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
        	$('.derateMoney').text(res.data.detail.InflRent);
        	$('.derateType').text(res.data.detail.CutName);
        	$('.derateNumber').text(res.data.detail.IDnumber);
        	$('.derateTime').text(res.data.detail.MuchMonth+'月');
			processState('#derateState',res);
			metailShow('#deratePhotos',res);
			layerBox(value,'derate','租金减免详情',2);
		}else if(type == 2){
			$('.status_2').hide();
			$(".emptyRentHouseID").text(res.data.detail.HouseID);
			$(".emptyRentBanID").text(res.data.detail.BanID);
            $(".emptyRentAddress").text(res.data.detail.BanAddress);
            $(".emptyRentUseNature").text(res.data.detail.UseNature);
            $(".emptyRentHouseUsearea").text(res.data.detail.HouseUsearea);
            $(".emptyRentLeasedArea").text(res.data.detail.LeasedArea);
            $(".emptyRentOwnertype").text(res.data.detail.OwnerType);
            $(".emptyRentHousePrerent").text(res.data.detail.HousePrerent);
            $(".emptyRentCreateTime").text(res.data.detail.OrderCreateTime);
            $(".emptyRentReason").text(res.data.detail.Remark);

			$(".emptyRentTenantID").text(res.data.detail.Tenant.TenantID);
			$(".emptyRentTenantName").text(res.data.detail.Tenant.TenantName);
            $(".emptyRentTenantNumber").text(res.data.detail.Tenant.TenantNumber);
            $(".emptyRentTenantTel").text(res.data.detail.Tenant.TenantTel);
            if(res.data.detail.Tenant == ''){
            	$('.empty_rent_cancel').hide();
            	var title = '新增空租';
            }else{
            	$('.empty_rent_cancel').show();
            	var title = '取消空租';
            }
            processState('#emptyRentState',res);
			metailShow('#emptyRentPhotos',res);
			layerBox(value,'emptyRent',title,2);
		}else if(type == 3){
        	var house_str = '';
        	$('.pauseBanId').text(res.data.detail.ban.BanID);
        	$('.pauseAddress').text(res.data.detail.ban.BanAddress);
        	$('.pauseOwnerType').text(res.data.detail.ban.OwnerType);
        	$('.pauseInflRent').text(res.data.detail.InflRent);
        	$('.pauseCreateTime').text(res.data.detail.OrderCreateTime);
        	$('.status_2').hide();
        	for(var i = 0;i < res.data.detail.house.length;i++){
        		house_str += '<tr>\
	                <td style="width:200px;">'+(i+1)+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].HouseID+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].TenantName+'</td>\
	                <td style="width:200px;">'+res.data.detail.house[i].HousePrerent+'</td>\
	                <td style="width:350px;">'+res.data.detail.house[i].BanAddress+'</td>\
	            </tr>';
        	}
        	$('#pauseHouseDetail').empty();
        	$('#pauseHouseDetail').append($(house_str));
			processState('#pauseRentState',res);
			metailShow('#pauseRentPhotos',res);
			layerBox(value,'pause','暂停计租详情',2);
		}else if(type == 4){
			$('.status_2').hide();
			$('.oldCancelHouseID').text(res.data.detail.HouseID);
        	$('.oldCancelBanID').text(res.data.detail.BanID);
        	$('.oldCancelAddress').text(res.data.detail.BanAddress);
        	$('.oldCancelOwnertype').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.oldCancelUseNature').text(res.data.detail.UseNature);
        	$('.oldCancelHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.oldCancelLeasedArea').text(res.data.detail.LeasedArea);
        	$('.oldCancelHousePrerent').text(res.data.detail.HousePrerent);
        	$('.oldCancelTenantName').text(res.data.detail.TenantName);
        	$('.oldCancelTenantNumber').text(res.data.detail.TenantNumber);
        	$('.oldCancelTenantTel').text(res.data.detail.TenantTel);
        	
			$('.oldCancelReason').text(res.data.detail.Remark);

        	$('.oldCancelYear').text(res.data.detail.OldYearRent);
        	$('.oldCancelMonth').text(res.data.detail.Deadline || '无');
        	$('.oldCancelMonthMoney').text(res.data.detail.OldMonthRent);
			processState('#oldCancelState',res);
			metailShow('#oldCancelPhotos',res);
			layerBox(value,'oldCancel','陈欠核销详情',2);
		}else if(type == 8){
			$('.status_2').hide();
			$('.cancel').show();
			$('.CancelType').text(res.data.detail.CancelType);
        	$('.cancelHouseID').text(res.data.detail.HouseID);
        	$('.cancelUseNature').text(res.data.detail.UseNature);
        	$('.cancelDamageGrade').text(res.data.detail.DamageGrade);
        	$('.cancelOwnerTypes').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.cancelLeasedArea').text(res.data.detail.LeasedArea);
        	$('.cancelHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.cancelHousePrerent').text(res.data.detail.HousePrerent);
        	$('.cancelTenantName').text(res.data.detail.TenantName);
        	$('.cancelTenantNumber').text(res.data.detail.TenantNumber);
        	$('.cancelTenantTel').text(res.data.detail.TenantTel);
        	$('.cancelUnitID').text(res.data.detail.UnitID);
        	$('.cancelFloorID').text(res.data.detail.FloorID);
        	$('.Remark').text(res.data.detail.Remark);
        	$('.cancelCreateTime').text(res.data.detail.OrderCreateTime);
        	var house_str = '';
        	for(var i = 0;i < res.data.detail.Ban.length;i++){
        		house_str += '<tr>\
	                <td style="width:150px;">'+(i+1)+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].banID+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].houseArea+'</td>\
	                <td style="width:150px;">'+res.data.detail.Ban[i].cancelHouseUsearea+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].housePrice+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].cancelPrent+'</td>\
	                <td style="width:200px;">'+res.data.detail.Ban[i].HouseAdress+'</td>\
	            </tr>';
        	}
        	$('#cancelHouseDetail').empty();
        	$('#cancelHouseDetail').append($(house_str));

			processState('#cancelState',res);
			metailShow('#cancelPhotos',res);
			layerBox(value,'cancel','注销详情',2);
		}else if(type == 5){

		}else if(type == 6){//维修

		}else if(type == 7){//新发租

		}else if(type == 9){//房屋调整
            $('.houseAdjustHouseID').text(res.data.detail.HouseID);
            $('.houseAdjustRemark').text(res.data.detail.Remark);
            $('.houseAdjustCreateTime').text(res.data.detail.OrderCreateTime);
            var banObj = res.data.detail.Ban;
            var ban_info_clone = $('.ban_info').eq(0).clone();
            $('.ban_info').remove();
            for(var i = 0;i < banObj.length;i++){
                var ban_info = ban_info_clone.clone();
                ban_info.find('td').eq(0).text(banObj[i].BanID);
                ban_info.find('td').eq(1).text(banObj[i].BanAddress);
                ban_info.find('td').eq(2).text(banObj[i].PreRent);
                ban_info.find('td').eq(3).text(banObj[i].PreRentChange);
                ban_info.find('td').eq(4).text(banObj[i].PreRentAfter);
                ban_info.find('td').eq(5).text(banObj[i].BanUsearea);
                ban_info.find('td').eq(6).text(banObj[i].BanUseareaChange);
                ban_info.find('td').eq(7).text(banObj[i].BanUseareaAfter);
                ban_info.find('td').eq(8).text(banObj[i].TotalArea);
                ban_info.find('td').eq(9).text(banObj[i].TotalAreaChange);
                ban_info.find('td').eq(10).text(banObj[i].TotalAreaAfter);
                ban_info.find('td').eq(11).text(banObj[i].TotalOprice);
                ban_info.find('td').eq(12).text(banObj[i].TotalOpriceChange);
                ban_info.find('td').eq(13).text(banObj[i].TotalOpriceAfter);
                $('.adjusHouse_table').append(ban_info.show());
            }
            processState('#HAState',res);
            metailShow('#HAPhotos',res);
            layerBox(value,'houseAdjust','房屋调整明细',2);
		}else if(type == 10){//管段调整

		}else if(type == 11){//租金追加调整
        	$('.rentAddHouseID').text(res.data.detail.HouseID);
        	$('.rentAddBanID').text(res.data.detail.BanID);
        	$('.rentAddAddress').text(res.data.detail.BanAddress);
        	$('.rentAddUseNature').text(res.data.detail.UseNature);
        	$('.rentAddHouseUseArea').text(res.data.detail.HouseUsearea);
        	$('.rentAddLeasedArea').text(res.data.detail.LeasedArea);
        	$('.rentAddTenantName').text(res.data.detail.TenantName);
        	$('.rentAddTenantNumber').text(res.data.detail.TenantNumber);
        	$('.rentAddTenantTel').text(res.data.detail.TenantTel);
        	$('.rentAddOwnerType').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.rentAddHousePrerent').text(res.data.detail.HousePrerent);
        	$('.rentAddDamageGrade').text(res.data.detail.DamageGrade);
        	$('.rentAddYear').text(res.data.detail.OldYearRent);
        	$('.rentAddMonth').text(res.data.detail.OldMonthRent);
        	$('.rentAddReason').text(res.data.detail.Remark);
        	processState('#rentAddState',res);
        	metailShow('#rentAddPhotos',res);
        	layerBox(value,'rentAdd','租金追加调整审批',2);
		}else if(type == 12){
			$('.status_2').hide();
        	$('.rentHouseID').text(res.data.detail.HouseID);
        	$('.rentType').text(res.data.detail.CancelType);
        	$('.rentUseNature').text(res.data.detail.UseNature);
        	$('.rentDamageGrade').text(res.data.detail.DamageGrade);
        	$('.rentOwnerTypes').text(res.data.detail.OwnerTypes[0].OwnerType);
        	$('.rentLeasedArea').text(res.data.detail.LeasedArea);
        	$('.rentHouseUsearea').text(res.data.detail.HouseUsearea);
        	$('.rentHousePrerent').text(res.data.detail.HousePrerent);
        	$('.rentTenantName').text(res.data.detail.TenantName);
        	$('.rentTenantNumber').text(res.data.detail.TenantNumber);
        	$('.rentTenantTel').text(res.data.detail.TenantTel);
        	$('.rentRemark').text(res.data.detail.Remark);

        	var house_str = '';
        	for(var i = 0;i < res.data.detail.Ban.length;i++){
        		house_str += '<tr>\
	                <td style="width:150px;">'+(i+1)+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].banID+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].addRentMoney+'</td>\
	                <td style="width:250px;">'+res.data.detail.Ban[i].HouseAdress+'</td>\
	            </tr>';
        	}
        	$('#rentBanDetail').empty();
        	$('#rentBanDetail').append($(house_str));
			processState('#rentState',res);
			metailShow('#rentPhotos',res);
			layerBox(value,'rentAdjustment','规定租金审批',2);
		}else if(type==13){

		}else if(type==14){
            $('#buildingAdjustBanID').text(res.data.detail.BanID);
            $('#buildingAdjustAddress').text(res.data.detail.BanAddress);
            $('#buildingAdjustOwnerType').text(res.data.detail.OwnerType);
            $('#buildingAdjustBanUnitNum').text(res.data.detail.BanUnitNum);
            $('#buildingAdjustCoveredArea').text(res.data.detail.CoveredArea);
            $('#buildingAdjustTotalArea').text(res.data.detail.TotalArea);
            $('#buildingAdjustBanUsearea').text(res.data.detail.BanUsearea);
            $('#buildingAdjustTotalOprice').text(res.data.detail.TotalOprice);
            $('#buildingAdjustBanPrerent').text(res.data.detail.PreRent);
            $('#buildingAdjustReason').text(res.data.detail.Remark);
            $('#beforeAdjustDamageGrade').text(res.data.detail.beforeDamage);
            $('#beforeAdjustStructureType').text(res.data.detail.beforeStructure);
            $('#afterAdjustDamageGrade').text(res.data.detail.afterDamage);
            $('#afterAdjustStructureType').text(res.data.detail.afterStructure);
            processState('#buildingAdjustState',res);
            metailShow('#buildingAdjustPhotos',res);
            layerBox(value,'buildingAdjustment','楼栋调整',2);
		}
	});
});
$('.BtnDelete').click(function(){
	var value = $(this).val();
	console.log(value);
	$.get('/ph/ChangeAudit/delete/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		layer.msg(res.msg);
		if(res.retcode == '2000'){
			location.reload();
		}
	})
})

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
			var ImgDom = $("<li style='width:100px;display:inline-block;'><img style='width:100px;' layer-pid="+i+" data-original="+
				img_array[i][j]+" src="+img_array[i][j] + " alt="+img_title[i]+"/></li>");
			FatherDom.append(ImgDom);
		}
	}
	console.log(id);
	// layer.photos({
	//   photos: id
	//   ,anim: 5
	// });
	$(id+' img').click(function(){
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
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1].RoleName+"［"+res.data.record[k-1].UserNumber+"］于"+res.data.record[k-1].CreateTime+res.data.record[k-1].Step+"；</p>");
		}else{
			var RecordDom = $("<p style='font-weight:600;'>"+k+"."+res.data.record[k-1].RoleName+"［"+res.data.record[k-1].UserNumber+"］于"+res.data.record[k-1].CreateTime+res.data.record[k-1].Status+"，原因："+res.data.record[k-1].Reson+"；</p>");
		}
		FatherDom.append(RecordDom);
	}
}
// 详情与审批流程弹出框
function layerBox(value,id,name,operation,status){
	var this_index = layer.open({
        type: 1,
        area: ['990px','780px'],
        resize: false,
        zIndex: 100,
        title: [name, 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#'+id+''),
        btn:operation==1?['通过','不通过']:'',
        success: function(){

        },
        yes:function(){
        	if(status == '1'){
        		var formData = fileTotall.getArrayFormdata() || new FormData();
        	}else{
        		var formData = new FormData();
        	}
			formData.append('ChangeOrderID',value);
        	processPass(formData,this_index);
        },
        btn2:function(){
			noPass(value)
		}
    })
}
// 审批通过事件
function processPass(formData,this_index){
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
            layer.close(this_index);
            location.reload();
        }
	})
}
// 审批不通过事件
function noPass(value){
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

//计租表
$('#rentMeterButton,#rentMaterQuery').click(function() {
    $('.RentExample:gt(0)').remove();
    var HouseID = $('.derateHouseID').text()||$('.houseAdjustHouseID').text();
    $.get('/ph/Api/get_rent_table_detail/HouseID/' + HouseID, function(res) {
        res = JSON.parse(res);
        console.log(res);
        $('.RentBan').text(res.data.banDetail.BanID);
        $('.RentStructure').text(res.data.banDetail.StructureType);
        $('.RentAddress').text(res.data.banDetail.BanAddress);
        $('.RentPoint').text(res.data.banDetail.NewPoint);
        $('.RentName').text(res.data.houseDetail.TenantName);
        $('.RentLayer').text(res.data.houseDetail.FloorID);
        $('.BanFloorNum').text(res.data.banDetail.BanFloorNum);
        $('.RentComprising').text(res.data.houseDetail.ComprisingArea);
        $('.RentWallpaper').text(res.data.houseDetail.WallpaperArea);
        $('.RentCeramic').text(res.data.houseDetail.CeramicTileArea);
        $('.RentBath').text(res.data.houseDetail.BathtubNum);
        $('.RentBasin').text(res.data.houseDetail.BasinNum);
        $('.RentBelow').text(res.data.houseDetail.BelowFiveNum);
        $('.RentMore').text(res.data.houseDetail.MoreFiveNum);
        $('.RentApproved').text(res.data.houseDetail.ApprovedRent);
        $('.RentRemit').text(res.data.houseDetail.RemitRent);
        $('.RentPump').text(res.data.houseDetail.PumpCost);
        $('.RentReceive').text(res.data.houseDetail.ReceiveRent);
        $('.RentHouseArea').text(res.data.houseDetail.HouseUsearea);
        $('.diffRent').text(res.data.houseDetail.DiffRent);
        $('.agreementRent').text(res.data.houseDetail.ProtocolRent);
        $('.RentLeased').text(res.data.houseDetail.LeasedArea);
        $('.RentEle').text(res.data.houseDetail.IfElevatorName);
        $('.OweLink').prop('href', "/ph/RentUnpaid/index?HouseID=" + HouseID);
        if (res.data.houseDetail.IfWater == 0) {
            $('.RentW').prop({
                checked: false
            });
        } else {
            $('.RentW').prop({
                checked: true
            });
        }
        if (res.data.houseDetail.IfFirst  == 0) {
            $('.RentE').prop({
                checked: false
            });
        } else {
            $('.RentE').prop({
                checked: true
            });
        }
        //产别
        var OwnTypes = res.data.houseDetail.OwnerTypes;
        $('.RentType').eq(0).text(OwnTypes[0].OwnerType);
        $('.RentPrice').eq(0).text(OwnTypes[0].HousePrerent);
        if (OwnTypes[1].OwnerType == 0) {
            $('.RentType').eq(1).text('无');
            $('.RentPrice').eq(1).text('无');
        } else {
            $('.RentType').eq(1).text(OwnTypes[1].OwnerType);
            $('.RentPrice').eq(1).text(OwnTypes[1].HousePrerent);
        }
        //房间信息
        var RentRoom = res.data.roomDetail;
        var RentA = [];
        for (var i in RentRoom) {
            RentA.push(i);
        }
        var RentHtml = '';
        var time = 0;
        for (var a = 0; a < RentA.length; a++) {
            var num = RentA[a];
            $('.addPrice').before($(".RentExample").eq(0).clone(true));
            $(".RentExample").eq(a + 1).css('display', 'block');
            $(".RentRoomName").eq(a + 1).text(RentRoom[num][0].RoomName);
            for (var j = 0; j < RentRoom[num].length; j++) {
                var aH = res.data.roomDetail[num][j].HouseID.split(',');
                var Shtml = '';
                for (var h = 0; h < aH.length; h++) {
                    if (aH.length == 1) {
                        Shtml = '';
                        Shtml += '<option>' + aH[0] + '</option>';
                    } else {
                        Shtml += '<option>' + aH[h] + '</option>';
                    }
                }
                RentHtml += '<ul class="am-u-md-12 house_style RentDate ul-mr"><li style="width:9%" class="RentID">' + res.data.roomDetail[num][j].RoomID + '</li>' + '<li style="width:5%" class="RentNum">' + res.data.roomDetail[num][j].RoomNumber + '</li>' + '<li style="width:9%" class="RentBanA">' + res.data.roomDetail[num][j].BanID + '</li>' + '<li style="width:5%" class="RentPublic">' + res.data.roomDetail[num][j].RoomPublicStatus + '</li>' + '<li style="width:9%" class="RentHouse">' + aH[0] + '</li>' +'<li style="width:6%" class="RentPro">' + res.data.roomDetail[num][j].OwnerType + '</li>'+'<li style="width:6%" class="RentU">' + res.data.roomDetail[num][j].UnitID + '</li>' + '<li style="width:6%" class="RentL">' + res.data.roomDetail[num][j].FloorID + '</li>' + '<li style="width:7%" class="RentArea">' + res.data.roomDetail[num][j].UseArea + '</li>' + '<li style="width:7%" class="RentCut">' + res.data.roomDetail[num][j].RentPoint + '</li>' + '<li style="width:7%" class="RentLeasedArea">' + res.data.roomDetail[num][j].LeasedArea + '</li>' + '<li style="width:7%" class="RentChat">' + res.data.roomDetail[num][j].FloorPoint + '</li>' + '<li style="width:7%" class="RentMp">' + res.data.roomDetail[num][j].RoomRentMonth + '</li>' + '<li style="width:5%" class="RentStatus">' + res.data.roomDetail[num][j].Status + '</li></ul>';
                $('.RoomDeT').eq(j).css('display', 'block');
                $('.RoomDeT').eq(j).parent().children().eq(0).removeClass('nomal').addClass('active');
                $('.pull').eq(j).prop('src', '/public/static/gf/icons/triU.png');
            } //小长度             
            $('.RentTit').eq(a + 1).after(RentHtml);
            RentHtml = '';
            $('.RoomDeT').eq(1).css('display', 'block');
            $('.RoomDeT').eq(1).parent().children().eq(0).removeClass('nomal').addClass('active');
            $('.pull').eq(1).prop('src', '/public/static/gf/icons/triU.png');
            //$('.RoomDeT').eq(1).previousSibling().removeClass('nomal').addClass('active');
        } //大长度
    })
    layer.open({
        type: 1,
        skin: 'yue-class',
        area: ['1300px', '700px'],
        zIndex: 1000,
        resize: false,
        title: ['计租表', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#RentForm')
    });
});