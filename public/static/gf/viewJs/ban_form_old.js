
//创建地图
var map = new BMap.Map("allMap");
map.centerAndZoom(new BMap.Point(114.334228,30.560372), 19);
map.enableScrollWheelZoom(true);

var FormMap = new BMap.Map("FormMap");
FormMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 19);
FormMap.enableScrollWheelZoom(true);

var ModifyMap = new BMap.Map("ModifyMap");
ModifyMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 19);
ModifyMap.enableScrollWheelZoom(true);
/*楼栋信息*/
$("#addBan").click(function(){
	$("#InputForm input[type='text']").val("");
		//获取坐标地址
		var pointer = new BMap.Point(114.334228,30.560372);
		FormMap.setCenter(pointer);
		var marker = new BMap.Marker(pointer);
  		FormMap.addOverlay(marker);
  		FormMap.panBy(190,110);
  		FormMap.addEventListener("click",function(e){
  			var lng = e.point.lng;
  			var lat = e.point.lat;
  			$('#getPosition').val(lng +','+lat);
  			FormMap.clearOverlays();
  			marker = new BMap.Marker(new BMap.Point(lng,lat));
  			FormMap.addOverlay(marker);
  		});
		//获取坐标地址结束

		//上传文件并预览
		var imgShow = $('#imgShow');
		var imageUp = $('#imageUp');
		var LandCertificate = $('#LandCertificate');
		var LandShow = $('#LandShow');
		var RealEstate = $('#RealEstate');
		var EstateShow = $('#EstateShow');
		readFile(LandCertificate,LandShow);
		readFile(RealEstate,EstateShow);
		readFile(imageUp,imgShow);

		layer.open({
			type:1,
			area:['800px','600px'],
			resize:false,
			zIndex:100,
			title:['添加楼栋','color:#FFF;font-size:1.6rem;font-weight:600;'],
			btn:['确定','取消'],
			content:$('#banForm'),
			succcess:function(){

			},
			yes:function(thisIndex){
				var data = new FormData($('#banForm')[0]);
				console.log(data);
				$.ajax({
					url:"/ph/BanInfo/add",
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
						layer.msg(result.msg);
						layer.close(thisIndex);
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
});

$("#reviseBan").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var BanID = obj.eq(i).val();
		}
	}
	//var vanId = $('.checkId').eq(0).val();
		if(BanID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{
			$.get('/ph/BanInfo/edit/BanID/'+BanID,function(res){
				res = JSON.parse(res);
				console.log(res);
				if(res.data.BanGpsX==""||res.data.BanGpsY==""){
					res.data.BanGpsX = "114.334228";
					res.data.BanGpsY = "30.560372";
				};
				$('#AreaFou').val(res.data.BanAddress);
				$("#BanID").prop("value",res.data.BanID);          //楼栋编号
				$("#banid").prop("value",res.data.BanID);          //隐藏域楼栋编号
				$('#BanPropertyID').prop("value",res.data.BanPropertyID);     //产权证号
				$('#BanYear').prop("value",res.data.BanYear);                //建造年份
				$('#TotalHouseholds').prop("value",res.data.TotalHouseholds);      //总户数
				$('#BanFloorNum').prop("value",res.data.BanFloorNum);        //层数
				$('#BanFloorStart').prop("value",res.data.BanFloorStart);    //起始楼层号
				$('#BanFreeholdI').prop("value",res.data.BanFreeholdID);    //不动产证号
				$('#BanLandI').prop("value",res.data.BanLandID);            //土地证号
				$('#BanUnitNum').prop("value",res.data.BanUnitNum);          //单元数量

				$('#EnterpriseArea').prop("value",res.data.EnterpriseArea);          //企业建面
				$('#PartyArea').prop("value",res.data.PartyArea);          //机关建面
				$('#CivilArea').prop("value",res.data.CivilArea);          //民建面

				$('#AreaFour').prop("value",res.data.AreaFour);          //详细地址
				$('#editCoveredArea').prop("value",res.data.CoveredArea);          //占地面积
				$('#editActualArea').prop("value",res.data.ActualArea);          //证载面积
				$('#editPreRent').prop("value",res.data.PreRent);          //核定租金
				$('#BanRatio').prop("value",res.data.BanRatio);          //栋系数
				$('#TotalOprice').prop("value",res.data.TotalOprice);          //楼栋原价


				$("select[name='HistoryIf'] option[value='"+res.data.HistoryIf+"']").attr("selected","selected"); //是否优秀建筑
				$("select[id='AreaTw'] option[value='"+res.data.AreaTwo+"']").attr("selected","selected");
				$("select[name='AreaThree'] option[value='"+res.data.AreaThree+"']").attr("selected","selected");
				$("select[id='BanStatus'] option[value='"+res.data.BanStatus+"']").attr("selected","selected");

				$('#BanUsearea').prop("value",res.data.BanUsearea);          //使用面积
				$('#PropertySource').prop("value",res.data.PropertySource);          //产权来源
				$('#imgChange').prop("href",res.data.BanImageIDS); 		//影像资料
				$('#xy').prop("value",res.data.BanGpsX+','+res.data.BanGpsY); 		//经纬度

				$("select[name='DamageGrade'] option[value='"+res.data.DamageGrade+"']").attr("selected","selected");        //完损等级
				$("#ownerType option[value='"+res.data.OwnerType+"']").attr("selected","selected");          //楼栋产别
				$("select[name='StructureType'] option[value='"+res.data.StructureType+"']").attr("selected","selected");      //结构类别
				$("#tubulationID option[value='"+res.data.TubulationID+"']").attr("selected","selected");           //机构id（管段）
				$(".UseNatured option[value='"+res.data.UseNature+"']").attr("selected","selected");                 //使用性质
				$("input[name='CutIf'][value='"+res.data.CutIf+"']").attr("checked","checked");   //产权是否分隔
				$("input[name='HistoryIf'][value='"+res.data.HistoryIf+"']").attr("checked","checked");  //是否历史优秀建筑
				$("input[name='ReformIf'][value='"+res.data.ReformIf+"']").attr("checked","checked");    //是否改造产
				$("input[name='ProtectculturalIf'][value='"+res.data.ProtectculturalIf+"']").attr("checked","checked");   //是否文物保护单位
				$("input[name='RemoveStatus'][value='"+res.data.RemoveStatus+"']").attr("checked","checked"); 
				if(res.data.BanImageIDS.length ==3){
				$('#imgShowOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
				$('#imgShowTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
				$('#imgShowThree').attr('src',res.data.BanImageIDS[2].FileUrl);		//图片影像
			}else if(res.data.BanImageIDS.length ==2){
				$('#imgShowOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
				$('#imgShowTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
			}else if(res.data.BanImageIDS.length ==1){
				$('#imgShowOne').attr('src',res.data.BanImageIDS[0].FileUrl);	
			}
				// $('#imgShowOne').prop('src',res.data.BanImageIDS[0].FileUrl);//土地证电子版
				// $('#imgShowTwo').prop('src',res.data.BanImageIDS[1].FileUrl);//不动产电子版
				// $('#imgShowThree').prop('src',res.data.BanImageIDS[2].FileUrl);//影像资料
				//获取坐标地址
				var pointer = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);
				ModifyMap.setCenter(pointer);
				ModifyMap.panBy(190,110);
				//ModifyMap.panTo(pointer);
				var marker = new BMap.Marker(pointer);
		  		ModifyMap.addOverlay(marker);
		  		ModifyMap.addEventListener("click",function(e){
		  			var lng = e.point.lng;
		  			var lat = e.point.lat;
		  			$('#xy').val(lng +' , '+lat);
		  			ModifyMap.clearOverlays();
		  			marker = new BMap.Marker(new BMap.Point(lng,lat));
		  			ModifyMap.addOverlay(marker);
		  		});
				//获取坐标地址结束
				//
				//影像资料修改
				var editLandCertificate = $('#editLandCertificate');
				var imgShowOne = $('#imgShowOne');
				readFile(editLandCertificate,imgShowOne);
				var editRealEstate = $('#editRealEstate');
				var imgShowTwo = $('#imgShowTwo');
				readFile(editRealEstate,imgShowTwo);
				var editImgReload = $('#editImgReload');
				var imgShowThree = $('#imgShowThree');
				readFile(editImgReload,imgShowThree);

				layer.open({
					type:1,
					zIndex:100,
					title:['修改楼栋','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:$('#modifyForm'),
					area:['800px','600px'],
					resize:false,
					btn:['确定','取消'],
					yes:function(thisIndex){
						var data = new FormData($('#modifyForm')[0]);
						console.log(data);
						$.ajax({
							url:"/ph/BanInfo/edit",
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
								layer.msg(result.msg);
								layer.close(thisIndex);
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
			});
		}
});

$("#deleteBan").click(function(){
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var BanID = obj.eq(i).val();
		}
	}
	//var vanId = $('.checkId').eq(0).val();
		if(BanID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{

			layer.open({
				type:1,
				area:['600px','130px'],
				title:['删除楼栋','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#deleteChoose'),
				// btn:['确定','取消'],
				// yes:function(thisIndex){
				// 	// var oChecked='';
				// 	// if($('input[name=banDeleteType]:checked').val()==undefined){
				// 	// 	oChecked='';
						
				// 	// }else{
				// 	// 	oChecked=$('input[name=banDeleteType]:checked').val();
				// 	// }
				// 						// console.log($('input[name=banDeleteType]:checked').val());
				// 	// layer.confirm('确定楼栋删除信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
				// 	// 	console.log($('input[name=banDeleteType]:checked').val());
				// 	// 	$.get('/ph/ConfirmBanInfo/delete/BanID/'+BanID+'/style/'+oChecked,function(result){
				// 	// 		result = JSON.parse(result);
				// 	// 		console.log(result);
				// 	// 		if(result.retcode  == '2000' ){
				// 	// 			layer.msg(result.msg);
				// 	// 			location.reload();
				// 	// 		}else{
				// 	// 			layer.msg(result.msg);
				// 	// 		}
				// 	// 	});
				// 	// 	layer.close(index);
				// 	// 	layer.close(thisIndex);
				// 	// });
				// }//
			})
		}
});

$(".details_btn").click(function(){
	var BanID = $(this).val();
	console.log(BanID);
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/'
	// 	});
		$.get('/ph/BanInfo/detail/BanID/'+BanID,function(res){
			res = JSON.parse(res);
			console.log(res);
			if(res.data.BanGpsX==""||res.data.BanGpsY==""){
				res.data.BanGpsX = "114.334228";
				res.data.BanGpsY = "30.560372";
			};
			$('p[id=BanID]').text(res.data.BanID);                 //楼栋编号
			$('p[id=BanAddress]').text(res.data.BanAddress);       //楼栋地址
			$('p[id=BanPropertyID]').text(res.data.BanPropertyID); //产权证号
			$('p[id=BanYear]').text(res.data.BanYear);             //建造年份
			$('p[id=DamageGrade]').text(res.data.DamageGrade);     //完损等级
			$('p[id=OwnerType]').text(res.data.OwnerType);         //楼栋产别
			$('p[id=PreRent]').text(res.data.PreRent);             //规定租金
			$('p[id=StructureType]').text(res.data.StructureType); //结构类型
			$('p[id=TubulationID]').text(res.data.TubulationID);   //机构名称
			$('p[id=UseNature]').text(res.data.UseNature);         //使用性质
			$('p[id=BanFloorNum]').text(res.data.BanFloorNum);     //总楼层数
			$('p[id=BanFloorStart]').text(res.data.BanFloorStart); //起始楼层数
			$('p[id=BanFreeholdID]').text(res.data.BanFreeholdID); //不动产证号

			$('#DetailsTotalHouseHolds').text(res.data.TotalHouseholds);
			$('#detailsTotalArea').text(res.data.TotalArea);
			$('#detailActualArea').text(res.data.ActualArea);
			$('#detailBanArea').text(res.data.BanArea);
			$('#detailEnterpriseArea').text(res.data.EnterpriseArea);
			$('#detailPartyArea').text(res.data.PartyArea);
			$('#detailCivilArea').text(res.data.CivilArea);
			//$('#detailBanArea').text(res.data.BanArea); //计算租金

			$('p[id=BanLandID]').text(res.data.BanLandID);         //土地证号
			$('p[id=BanUnitNum]').text(res.data.BanUnitNum);       //总单元数
			$('p[id=CivilArea]').text(res.data.CivilArea);         //民建面
			$('p[id=PartyArea]').text(res.data.PartyArea);         //机关建面
			$('p[id=EnterpriseArea]').text(res.data.EnterpriseArea);         //企业建面
			$('p[id=BanUsearea]').text(res.data.BanUsearea);       //使用面积
			$('p[id=CutIf]').text(res.data.CutIf);                 //产权是否分隔
			$('p[id=HistoryIf]').text(res.data.HistoryIf);         //是否历史优秀建筑
			$('p[id=ProtectculturalIf]').text(res.data.ProtectculturalIf);  //是否文物保护建筑
			$('p[id=ReformIf]').text(res.data.ReformIf);           //是否改造产
			$('p[id=TotalArea]').text(res.data.TotalArea);         //合建面积
			$('p[id=PropertySource]').text(res.data.PropertySource);         //产权来源
			$('p[id=RemoveStatus]').text(res.data.RemoveStatus);         //拆迁状态
			$('p[id=BanGpsXY]').text(res.data.BanGpsX+','+res.data.BanGpsY);         //经纬度
			$('#detailImgOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
			$('#detailImgTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
			$('#detailImgThree').attr('src',res.data.BanImageIDS[2].FileUrl);		//图片影像

			var pointer = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);
			map.setCenter(pointer);
			map.panBy(190,110);
			//map.panTo(pointer);
			var marker = new BMap.Marker(pointer);
	  		map.addOverlay(marker);
	  		map.addEventListener("click",function(e){
	  			var lng = e.point.lng;
	  			var lat = e.point.lat;
	  			$('#position').text(lng +','+lat);
	  			map.clearOverlays();
	  			marker = new BMap.Marker(new BMap.Point(lng,lat));
	  			map.addOverlay(marker);
	  		});


			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				title:['查看明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#banDetail2')
			});
		})
	// })
});
//结构明细
$(".structureBtn").click(function(){
	var BanID = $(this).val();
	console.log(BanID);
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/'
	// 	});
		$.get('/ph/BanInfo/strucDetail/BanID/'+BanID,function(res){
			res = JSON.parse(res);
			console.log(res);
			$('#Ban').text(res.data.BanID);
			$('#BanAddre').text(res.data.BanAddress);
			$('#StructureTy').text(res.data.StructureType);
			$('#DamageGra').text(res.data.DamageGrade);
			$('#BanUnitN').text(res.data.BanUnitNum);
			$('#BanFloorN').text(res.data.BanFloorNum);
//结构的单元DOM渲染
			$(".BuildUnit").empty();//清空子元素
			var UnitDom = $("<tr></tr>");
			UnitDom.append("<th>实际楼层</th>");
			for(var i = 1;i < parseInt(res.data.BanUnitNum) + 1;i++){
				UnitDom.append($("<th>"+i+"单元</th>"));
			}
			$(".BuildUnit").append(UnitDom);
//结构的楼层DOM渲染
			$(".BuildFloor").empty();//清空子元素
			for(var i = 1;i < ((parseInt(res.data.BanFloorNum) + 1) > 9 ? parseInt(res.data.BanFloorNum) + 1 : 9);i++){
				var FloorDom = $("<tr></tr>");
				FloorDom.append($("<td>"+i+"</td>"));
				for(var j = 1;j < parseInt(res.data.BanUnitNum) + 1;j++){
					var DoorDom = $("<td></td>");
					for(var k in res.data.allHouse[j][i]){
						if(k != 0){
							DoorDom.append($("<span class='ban_span' value='"+res.data.allHouse[j][i][k]+"'>"+k+"</span>"));
						}
					}
					FloorDom.append(DoorDom);
				}
				$(".BuildFloor").append(FloorDom);
			}
		$('.ban_span').on('click',function(){
			var SHouseId = $(this).attr("value");
			console.log(SHouseId);
			$.get('/ph/BanInfo/strucDetail/HouseID/'+SHouseId,function(res){
				res = JSON.parse(res);
				console.log(res);
				$("#dongStruc").text(res.data.InstitutionID || '暂无');
				$("#dongName").text(res.data.TenantID || '暂无');
				$("#dongFloor").text(res.data.FloorID || '暂无');
				$("#dongUnit").text(res.data.UnitID || '暂无');
				$("#dongDoor").text(res.data.DoorID || '暂无');
				$("#dongRent").text(res.data.HousePrerent || '暂无');
				$("#dongPrice").text(res.data.Oprice || '暂无');
				$("#dongArea").text(res.data.ComprisingArea || '暂无');
				$("#dongBuilArea").text(res.data.HouseArea || '暂无');
				$("#dongCost").text(res.data.PumpCost || '暂无');
				$("#dongBase").text(res.data.HouseBase || '暂无');
				$('#StructHouse').css('display','block');
			});
		});
//结构的楼层DOM渲染结束
			layer.open({
				type:1,
				area:['800px','500px'],
				resize:false,
				title:['楼栋结构','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#banStructure'),
				cancel:function(){
					$('#StructHouse').css('display','none');
				}
			});
		});
	// });
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

$('#DBanID').change(function(){
	Validation.digit($(this).val(),10);
});