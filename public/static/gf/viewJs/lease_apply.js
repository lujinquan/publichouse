$('.addLease').click(function(){
	houseQuery.action('leaseHouseInput','1');
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
					$('#applyAdress').val(res.data.house.BanAddress);
					$('#applyStruct').val(res.data.house.StructureType);
					$('#applyHouseFloor').val(res.data.house.BanFloorNum);
					$('#applyLiveFloor').val(res.data.house.FloorID);
					$('#applyRentName').val(res.data.house.TenantName);
					$('#applyRentNumber').val(res.data.house.TenantNumber);
					$('#applyRentTel').val(res.data.house.TenantTel);
					$('#applyRoom1_data5').val(res.data.house.Hall);
					$('#applyRoom2_data5').val(res.data.house.Kitchen);
					$('#applyRoom3_data5').val(res.data.house.Toilet);
					$('#applyRoom4_data5').val(res.data.house.InnerAisle);
					$('#applyRoom5_data6').val(res.data.house.BelowFiveNum);
					$('#applyRoom6_data6').val(res.data.house.MoreFiveNum);
					$('#applyRoom7_data9').val(res.data.house.PumpCost);

					var ws = 1;
					var fb = 13;
					var wfb = 13;
					for(var i = 0;i < res.data.room.length;i++){
						var this_data = res.data.room[i];
						
						switch(this_data.RoomType){
							case "1":
								$('#applyRoom'+ws+'_data1').val(this_data.RoomNumber);
								$('#applyRoom'+ws+'_data2').val(this_data.UseArea);
								$('#applyRoom'+ws+'_data3').val(this_data.LeasedArea);
								$('#applyRoom'+ws+'_data4').val(this_data.RoomRentMonth);
								ws++;
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
								$('#applyRoom'+fb+'_data2').val(this_data.RoomNumber);
								$('#applyRoom'+fb+'_data3').val(this_data.UseArea);
								$('#applyRoom'+fb+'_data4').val(this_data.LeasedArea);
								$('#applyRoom'+fb+'_data5').val(this_data.RoomRentMonth);
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
							case "8":
									$('#applyRoom'+wfb+'_data5').val(this_data.RoomNumber);
									$('#applyRoom'+wfb+'_data6').val(this_data.UseArea);
									$('#applyRoom'+wfb+'_data7').val(this_data.LeasedArea);
									$('#applyRoom'+wfb+'_data8').val(this_data.RoomRentMonth);
									wfb++;
								break;
						}
					}
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
			var data = new FormData($('#MyForm')[0]);
			var formData = fileTotall.getArrayFormdata();
			if(formData){
				var ent = formData.entries(); //不兼容IE
				while(item = ent.next()){
					if(item.done){
						break;
					}
					data.append(item.value[0],item.value[1]);
				}
			}
			data.delete('leaseApplication1');
			data.delete('leaseApplication2');
			data.delete('leaseApplication3');
			data.append('houseID',$('#leaseHouseInput').val());
			$.ajax({
                type: "post",
                url: "/ph/LeaseApply/add",
                data: data,
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
		}
	})
})

$('.BtnDetail').click(function(){
	layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约详情','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		btn:['确认','取消'],
		success:function(){

		},
		yes:function(){

		}
	})
})