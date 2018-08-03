// require.config({
// 	baseUrl:"/public/static/gf/",
// 	paths:{
// 		"jquery":"js/jquery.min",
// 		"layer":"layer/layer"
// 	}
// });
//创建地图
//创建地图
var map = new BMap.Map("mapHouse");
map.centerAndZoom(new BMap.Point(114.320506, 30.600157), 19);
map.enableScrollWheelZoom(true);
/*房屋信息*/

/*房屋新增*/
$("#addHouse").click(function(){
	$("#InputForm input[type='text']").val("");
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		var imgUp = $('#imgUp');
		var imgShow = $('#imgShow');
		readFile(imgUp,imgShow);
		layer.open({
			type:1,
			area:['800px','600px'],
			resize:false,
			zIndex:100,
			title:['添加房屋','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#houseForm'),
			btn:['确定','取消'],
			yes:function(thisIndex){
				var data = new FormData($('#houseForm')[0]);
				console.log(data);
				$.ajax({
					url:"/ph/HouseInfo/add",
					type:"post",
					data:data,
					dataType:'JSON',
					processData: false,
					contentType: false
				}).done(function(result){
					console.log(result);
					if(result.retcode == 2000){
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(thisIndex);
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.close(thisIndex);
						layer.msg(result.msg);
						location.reload();
					}else{
						// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
						// 	layer.close(conIndex);
						// 	location.reload();
						// });
						layer.msg(result.msg);
					}
				});
			}
		});
	// })
});
/*修改房屋信息*/
$("#reviseHouse").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var HouseID = obj.eq(i).val();
		}
	}
	console.log(HouseID);
	//var vanId = $('.checkId').eq(0).val();
	// require(["layer","jquery"],function(layer){
	// 	layer.config({	//真实layer的配置路径
	// 		path:'/public/static/gf/layer/'
	// 	});
		if(HouseID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{
			$.get('/ph/HouseInfo/edit/HouseID/'+HouseID,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#mDHouseID").val(res.data.HouseID);          //房屋编号
				$("#houseid").prop("value",res.data.HouseID);          //隐藏域房屋编号
				$("#HouseI").prop("value",res.data.HouseID);
				$("#BanI").prop("value",res.data.BanID);          //楼栋编号
				$('#UnitI').prop("value",res.data.UnitID);        //单元号
				$('#FloorI').prop("value",res.data.FloorID);     //楼层号
				$('#DoorI').prop("value",res.data.DoorID);                //门牌号码
				$('#PumpCos').prop("value",res.data.PumpCost);        //泵费
				$('#RepairCos').prop("value",res.data.RepairCost);        //维修费
				$('#HouseBas').prop("value",res.data.HouseBase);        //房屋基数
				$('#OldOpric').prop("value",res.data.OldOprice);                //计算原价
				$('#Opric').prop("value",res.data.Oprice);      //实际原价
				$('#TenantI').prop("value",res.data.TenantID);        //租户ID
				$('#LeasedAre').prop("value",res.data.LeasedArea);    //计租面积
				$('#HouseUseare').prop("value",res.data.HouseUsearea);    //使用面积
				$('#MHousePrerent').prop("value",res.data.HousePrerent);            //规定租金
				$('#ReceiveRen').prop("value",res.data.ReceiveRent);          //应收租金
				$('#RemitRen').prop("value",res.data.RemitRent);          //减免租金
				$('#ArrearRen').prop("value",res.data.ArrearRent);          //欠租情况
				$('#ArrearrentReaso').prop("value",res.data.ArrearrentReason);          //欠租情况
				$('#HouseAre').prop("value",res.data.HouseArea);          //户建面
				$('#ComprisingAre').prop("value",res.data.ComprisingArea);          //套内建面
				$("select[id='UseNature'] option[value='"+res.data.UseNature+"']").prop("selected","selected");   //使用性质
				$("input[name='NonliveIf'][value='"+res.data.NonliveIf+"']").prop("checked","checked");   //是否住改非
				
				$('#mApprovedRent').val(res.data.ApprovedRent);
				$("#mhall").val(res.data.Hall);
				$("#mtoilet").val(res.data.Toilet);
				$("#mkitchen").val(res.data.Kitchen);
				$("#mInnerAisle").val(res.data.InnerAisle);
				if(res.data.IfWater == '1'){
					$("#mIfWater").prop('checked',true);
				}else{
					$("#mIfWater").prop('checked',false);
				}
				$('#mwallcloth').val(res.data.WallpaperArea);
				$('#mFloorTile').val(res.data.CeramicTileArea);
				$('#mbathtub').val(res.data.BathtubNum);
				$('#mbasin').val(res.data.BasinNum);
				$('#mspace').val(res.data.BelowFiveNum);
				$('#mattic').val(res.data.MoreFiveNum);
				$('#imgChange').prop('src',res.data.HouseImageIDS.FileUrl);
				
				var imgReload = $('#imgReload');
				var imgChange = $('#imgChange');
				readFile(imgReload,imgChange);
				layer.open({
					type:1,
					area:['800px','600px'],
					resize:false,
					zIndex:100,
					title:['修改房屋','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#houseModifyForm'),
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = new FormData($('#houseModifyForm')[0]);
						console.log(data);
						$.ajax({
							url:"/ph/HouseInfo/edit",
							type:"post",
							data:data,
							dataType:'JSON',
							processData: false,
		            		contentType: false
						}).done(function(result){
							console.log(result);
							if(result.retcode == 2000){
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(thisIndex);
								// 	layer.close(conIndex);
								// 	location.reload();
								// });
								layer.close(thisIndex);
								layer.msg(result.msg);
								location.reload();
							}else{
								// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
								// 	layer.close(conIndex);
								// });
								layer.msg(result.msg);
							}
						});
					}
				});
			})
		}
	// })
});
/*删除房屋信息*/
$("#deleteHouse").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var HouseID = obj.eq(i).val();
		}
	}
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/',
	// 		skin:'lan_class'
	// 	});
		if(HouseID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{
			layer.confirm('确定删除房屋信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
						$.get('/ph/HouseInfo/delete/HouseID/'+HouseID,function(result){
							result = JSON.parse(result);
							if(result.retcode  == '2000' ){
								// layer.confirm('删除成功',function(index_2){
								// 	layer.close(index_2);
								// 	location.reload();
								// });
								layer.msg('删除成功');
								location.reload();
							}
						});
				layer.close(index);
			});
		}
	// })
});

// $("#houseOut").click(function(){
// 	$.get('/ph/HouseInfo/out',function(res){
// 		console.log(res);
// 	});
// });

/*房屋明细*/
$(".HouseDetailBtn").click(function(){
	var HouseID = $(this).val();
	console.log(HouseID);
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/'
	// 	});
		$.get('/ph/HouseInfo/detail/HouseID/'+HouseID,function(res){
			res = JSON.parse(res);
			console.log(res);
			$('p[id=HouseID]').text(res.data.HouseID);             //房屋编号
			$('p[id=BanID]').text(res.data.BanID);                 //楼栋编号
			$('p[id=InstitutionID]').text(res.data.InstitutionID);       //机构
			$('p[id=UnitID]').text(res.data.UnitID); //单元号
			$('p[id=FloorID]').text(res.data.FloorID);             //楼层号
			$('p[id=HousePID]').text(res.data.HousePID);     //产权证号
			$('p[id=DoorID]').text(res.data.DoorID);         //门牌号
			$('p[id=HouseUsearea]').text(res.data.HouseUsearea);             //使用面积
			$('p[id=NonliveIf]').text(res.data.NonliveIf); //是否住改非
			$('p[id=LeasedArea]').text(res.data.LeasedArea);   //计租面积
			$('p[id=HousePrerent]').text(res.data.HousePrerent);         //规定租金
			$('p[id=ReceiveRent]').text(res.data.ReceiveRent);     //应收租金
			$('p[id=RemitRent]').text(res.data.RemitRent); //减免租金
			$('p[id=UseNature]').text(res.data.UseNature); //使用性质
			$('p[id=PumpCost]').text(res.data.PumpCost);         //泵费
			$('p[id=RepairCost]').text(res.data.RepairCost);       //维修费
			$('p[id=HouseBase]').text(res.data.HouseBase);         //房屋基数
			$('p[id=OldOprice]').text(res.data.OldOprice);         //计算原价
			$('p[id=Oprice]').text(res.data.Oprice);         //实际原价
			$('p[id=TenantID]').text(res.data.TenantID);       //租户姓名
			$('p[id=ArrearRent]').text(res.data.ArrearRent);                 //欠租情况
			$('p[id=ArrearrentReason]').text(res.data.ArrearrentReason);         //欠租原因
			$('p[id=HouseArea]').text(res.data.HouseArea);  //户建面积
			$('p[id=ComprisingArea]').text(res.data.ComprisingArea);           //套内建面
			$('#HouseImageIDS').attr('src',res.data.HouseImageIDS);		//图片影像

			$('p[id=xy]').text(res.data.BanGpsX+','+res.data.BanGpsY);           //套内建面
			var pointer = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);
			map.setCenter(pointer);
			map.panBy(190,110);
			//ModifyMap.panTo(pointer);
			var marker = new BMap.Marker(pointer);
	  		map.addOverlay(marker);
	  		map.addEventListener("click",function(e){
	  			var lng = e.point.lng;
	  			var lat = e.point.lat;
	  			$('#xy').val(lng +' , '+lat);
	  			map.clearOverlays();
	  			marker = new BMap.Marker(new BMap.Point(lng,lat));
	  			map.addOverlay(marker);
	  		});
			
			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				title:['房屋明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#houseDetail')
			});
		})
	// })
});

function readFile(fileUp,fileShow){
	if(typeof FileReader === 'undefined'){
		fileShow.text('浏览器不支持！');
	}else{
		fileUp.on('change',function(){
			var file = this.files[0];
			if(!/image\/\w+/.test(file.type)){
				layer.msg('文件必须是图片！');
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(){
				fileShow.attr('src',this.result);
			}
		})
	}
}