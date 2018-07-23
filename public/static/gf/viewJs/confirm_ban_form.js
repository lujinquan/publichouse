
//创建地图

//map.enableScrollWheelZoom(true);
////

//FormMap.enableScrollWheelZoom(true);
//

//ModifyMap.enableScrollWheelZoom(true);
/*楼栋信息*/
//var FormMap = new BMap.Map("FormMap",{enableMapClick: false}); 
var areaArray = null;
$.get('/ph/Api/get_relation_area',function(res){
	console.log(res);
	var  j = 0,
		array = [];
		array[0] = [];
	for(var i = 0;i < res.length;i++){
		if(res[i].Pid == j){
			array[j].push(res[i]);
		}else{
			j++;
			array[j] = [];
			array[j].push(res[i]);
		}
	}
	areaArray = array;
	console.log(areaArray);
	areaLink("#AreaTwo","#AreaThree",array);
	areaLink("#AreaTw","#AreaThre",array);
});

function areaLink(idOne,idTwo,data){
	var str = "";
	for(var k = 0;k < data[1].length;k++){
		str += "<option  value="+data[1][k].id+">"+data[1][k].AreaTitle+"</option>";
	}
	str = $(str);
	$(idOne).append(str);
	$(idOne).change(function(){
		$(idTwo).empty();
		var value = $(this).val();
		console.log(data[value]);
		var option = "";
		for(var k = 0;k < data[value].length;k++){
			option += "<option  value="+data[value][k].id+">"+data[value][k].AreaTitle+"</option>";
		}
		option = $(option);
		$(idTwo).append(option);
	});
}
// 修改中，地址绑定
function initAreaLink(idOne,idTwo,data){
	$(idTwo).empty();
	var value = $(idOne).val();
	console.log(data[value]);
	var option = "";
	if(data[value]){
		for(var k = 0;k < data[value].length;k++){
		option += "<option  value="+data[value][k].id+">"+data[value][k].AreaTitle+"</option>";
	}
	}
	
	option = $(option);
	$(idTwo).append(option);
}

var flag = true;//多次提交标识;
$("#addBan").click(function(){
	$('#banForm').css('display','block');
	var FormMap = new BMap.Map("FormMap",{enableMapClick: false});
	var opsiX=114.334228;
	var opsiY = 30.560372;
	var oJwd = document.getElementById('getPosition');
	var point = new BMap.Point(opsiX,opsiY);
	FormMap.centerAndZoom(point, 15); // 创建Map实例	
	FormMap.clearOverlays();
		var marker = new BMap.Marker(point); // 创建标注
		FormMap.addOverlay(marker);   
		oJwd.value=opsiX+','+opsiY;
		FormMap.addEventListener("click",function(e){
				opsiX =  e.point.lng;
				opsiY = e.point.lat;
				point = new BMap.Point(opsiX,opsiY);
	        if(e.overlay){        	
	            marker.ondblclick=function(){
	            	url='/public/baidumap/big.html?position='+oJwd.value;
	            	window.open(url,'parent');
	    		};
	        }else{
	           	FormMap.clearOverlays()			
				marker = new BMap.Marker(point);  // 创建标注
				FormMap.addOverlay(marker); 
	        	oJwd.value=opsiX+','+opsiY;
	        	
	    	}
	    });//小地图
        window.addEventListener('message', function(e) {
        	FormMap.clearOverlays();	
			point = new BMap.Point(e.data.x,e.data.y);
			FormMap.centerAndZoom(point, 15); 
			marker = new BMap.Marker(point); 
			FormMap.addOverlay(marker); 
			oJwd.value=e.data.x+','+e.data.y;
    		// console.log(e.source === window.opener);  // true
    	});

	    FormMap.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
		FormMap.disableDoubleClickZoom() //禁用双击放大。
		FormMap.enableScrollWheelZoom(true);

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
				data.append('LandCertificate',$('#LandShow').prop('src'));
				data.append('RealEstate',$('#EstateShow').prop('src'));
				data.append('BanImageIDS',$('#imgShow').prop('src'));
				console.log(data);

				if(flag ==true){
					flag = false;
					$.ajax({
						url:"/ph/BanInfo/add",
						type:"post",
						data:data,
						dataType:'JSON',
						processData: false,
	            		contentType: false
					}).done(function(result){
						if(result.retcode == 2000){
						layer.msg(result.msg);
						layer.close(thisIndex);
						location.reload();
						}else{
							// layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
							// 	layer.close(conIndex);
								
							// });
							flag = true;
							layer.msg(result.msg);
						}
						
					});
				}
			},
			end:function(){
				$('#banForm').css('display','none');
			}
		});
});
//修改
//var ModifyMap = new BMap.Map("ModifyMap",{enableMapClick: false});

$("#reviseBan").click(function(){
//	$('#modifyForm').css('display','block');
	
	
	var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var BanID = obj.eq(i).val();
			console.log(BanID);
		}
	}
	//var vanId = $('.checkId').eq(0).val();
		if(BanID == undefined){
			layer.msg('请先选择要修改的信息');
		}else{
			
			$.get('/ph/ConfirmBanInfo/edit/BanID/'+BanID,function(res){
				res = JSON.parse(res);
				console.log(res);
				if(res.data.BanGpsX==""||res.data.BanGpsY==""){
					res.data.BanGpsX = "114.334228";
					res.data.BanGpsY = "30.560372";
				};
				$('#AreaFou').val(res.data.AreaFour);
				$("#BanID").prop("value",res.data.BanID);          //楼栋编号
				$("#AnathorBanID").prop("value",res.data.AnathorBanID);          //楼栋编号
				if(res.data.AnathorBanID == res.data.BanSysID){
					$("input[name='BanSysID'][value='2']").prop('checked',true);
				}else{
					$("input[name='BanSysID'][value='1']").prop('checked',true);
				}
				$("#BanNumber").prop("value",res.data.BanNumber);          //栋号
				$("#OldBanID").prop("value",res.data.OldBanID);          //原楼栋编号
				$("#banid").prop("value",res.data.BanID);          //隐藏域楼栋编号
				$('#BanPropertyID').prop("value",res.data.BanPropertyID);     //产权证号
				$('#BanYear').prop("value",res.data.BanYear);                //建造年份
				$('#TotalHouseholds').prop("value",res.data.TotalHouseholds);      //总户数
				$('#BanFloorNum').prop("value",res.data.BanFloorNum);        //层数
				$('#BanFloorStart').prop("value",res.data.BanFloorStart);    //起始楼层号
				$('#BanFreeholdI').prop("value",res.data.BanFreeholdID);    //不动产证号
				$('#BanLandI').prop("value",res.data.BanLandID);            //土地证号
				$('#BanUnitNum').prop("value",res.data.BanUnitNum);          //单元数量

				$('#AreaFour').prop("value",res.data.AreaFour);          //详细地址
				$('#editCoveredArea').prop("value",res.data.CoveredArea);          //占地面积
				$('#editActualArea').prop("value",res.data.ActualArea);          //证载面积
				$('#EnterpriseArea').prop("value",res.data.EnterpriseArea);
				$('#PartyArea').prop('value',res.data.PartyArea);
				$('#CivilArea').prop('value',res.data.CivilArea);
				$('#PreRent').prop("value",res.data.PreRent);          //核定租金
				$('#BanRatio').prop("value",res.data.BanRatio);          //栋系数
				// $('#TotalOprice').prop("value",res.data.TotalOprice);          //楼栋原价
				$('#EnterprisePrice').prop("value",res.data.EnterpriseOprice);          //企业原价
				$('#PartyPrice').prop("value",res.data.PartyOprice);          //机关原价
				$('#CivilPrice').prop("value",res.data.CivilOprice);          //民用原价
				$('#EnterpriseNumber').prop("value",res.data.EnterpriseNum);          //企业栋数
				$('#PartyNumber').prop("value",res.data.PartyNum);          //机关栋数
				$('#CivilNumber').prop("value",res.data.CivilNum);          //民用栋数
				$("#CivilRent").val(res.data.CivilRent); //民用规租
				$("#PartyRent").val(res.data.PartyRent); //机关规租
				$("#EnterpriseRent").val(res.data.EnterpriseRent); //企业规租

				if(res.data.IfElevator=="0"){
					$(".IfElevatorM").val("0");
				}else if(res.data.IfElevator=="1"){
					console.log('bbbb');
					$(".IfElevatorM").val("1");
				}else{
					console.log('ccc');
					$(".IfElevatorM").val("2");
				}
				if(res.data.IfFirst==1){
					$("input[name=IfFirst]").prop('checked',true);
				}else{
					$("input[name=IfFirst]").prop('checked',false);
				};
				// $('#IfFirst').html(res.data.IfFirst);

				$("select[name='HistoryIf'] option[value='"+res.data.HistoryIf+"']").attr("selected","selected"); //是否优秀建筑
				$("select[id='AreaTw'] option[value='"+res.data.AreaTwo+"']").prop("selected","selected");
				initAreaLink("#AreaTw","#AreaThre",areaArray);
				$("select[id='AreaThre'] option[value='"+res.data.AreaThree+"']").prop("selected","selected");
				$("select[id='BanStatus'] option[value='"+res.data.BanStatus+"']").attr("selected","selected");
				$("select[id='RemoveStatus'] option[value='"+res.data.RemoveStatus+"']").attr("selected","selected");

				$('#BanUsearea').prop("value",res.data.BanUsearea);          //使用面积
				$('#PropertySource').prop("value",res.data.PropertySource);          //产权来源
				$('#imgChange').prop("href",res.data.BanImageIDS); 		//影像资料
				$('#xy').prop("value",res.data.BanGpsX+','+res.data.BanGpsY); 		//经纬度

				$(".DamageGraded option[value='"+res.data.DamageGrade+"']").attr("selected","selected");        //完损等级
				$("#ownerType option[value='"+res.data.OwnerType+"']").attr("selected","selected");          //楼栋产别
				$("#AnathorOwnerType option[value='"+res.data.AnathorOwnerType+"']").attr("selected","selected");          //楼栋产别
				$(".StructureTyped option[value='"+res.data.StructureType+"']").attr("selected","selected");      //结构类别
				$("#tubulationID option[value='"+res.data.TubulationID+"']").attr("selected","selected");           //机构id（管段）
				$(".UseNatured option[value='"+res.data.UseNature+"']").attr("selected","selected");                 //使用性质
				$("input[name='CutIf'][value='"+res.data.CutIf+"']").attr("checked","checked");   //产权是否分隔
				$("input[name='HistoryIf'][value='"+res.data.HistoryIf+"']").attr("checked","checked");  //是否历史优秀建筑
				$("input[name='ReformIf'][value='"+res.data.ReformIf+"']").attr("checked","checked");    //是否改造产
				$("input[name='ProtectculturalIf'][value='"+res.data.ProtectculturalIf+"']").attr("checked","checked");   //是否文物保护单位
				//$("input[name='RemoveStatus'][value='"+res.data.RemoveStatus+"']").attr("checked","checked"); 


				if(res.data.BanImageIDS){
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
				}
				
				
				//获取坐标地址
				$('#modifyForm').css('display','block');
				var ModifyMap = new BMap.Map("ModifyMap",{enableMapClick: false});
				
				ModifyMap.clearOverlays();
				var pointer = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);					
				ModifyMap.centerAndZoom(pointer, 15);	
//				ModifyMap.setCenter(pointer);
				marker = new BMap.Marker(pointer);
				ModifyMap.addOverlay(marker); 
//				ModifyMap.centerAndZoom(pointer, 15);
				var xy = document.getElementById('xy');
				xy.value=res.data.BanGpsX+','+res.data.BanGpsY;
				ModifyMap.addEventListener("click",function(e){
				opsiX =  e.point.lng;
				opsiY = e.point.lat;
				point = new BMap.Point(opsiX,opsiY);
				
				
		        if(e.overlay){        	
		            marker.ondblclick=function(){
		            	url='/public/baidumap/big.html?position='+xy.value;
		            	window.open(url,'parent');
			    	};
			    }else{
		           	ModifyMap.clearOverlays()			
					marker = new BMap.Marker(point);  // 创建标注
					ModifyMap.addOverlay(marker); 
		        	xy.value=opsiX+','+opsiY;
			    }
	        });//小地图
				//获取坐标地址结束
				
				window.addEventListener('message', function(e) {
		        ModifyMap.clearOverlays();	
	   			point = new BMap.Point(e.data.x,e.data.y);
	   			ModifyMap.centerAndZoom(point, 15); 
	   			
	   			marker = new BMap.Marker(point); 
	   			ModifyMap.addOverlay(marker); 
	   			xy.value=e.data.x+','+e.data.y;})
				ModifyMap.enableScrollWheelZoom(true);
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
//					$('#modifyForm').css('display','block');
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
							url:"/ph/ConfirmBanInfo/edit",  
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
					},
					end:function(){
					$('#modifyForm').css('display','none');
				}
				})
				
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

$('#HouseChange,#HouseRemove,#DateTogther,#DateLose').click(function(){
		var obj = $('.checkId');
	var objLength = $('.checkId').length;
	for(var i = 0;i < obj.length;i++){
		if(obj[i].checked){
			var BanID = obj.eq(i).val();
		}
	}
	var oV= $(this).val();
	layer.confirm('确定楼栋删除信息',{title:'提示信息',icon:'2',skin:'lan_class'},function(index){
						$.get('/ph/ConfirmBanInfo/delete/BanID/'+BanID+'/style/'+oV,function(result){
							result = JSON.parse(result);
							console.log(result);
							if(result.retcode  == '2000' ){
								layer.msg(result.msg);
								location.reload();
							}else{
								layer.msg(result.msg);
							}
						})
					})
})


$(".ConfirmBanBtn").click(function(){

	var banID = $(this).val();

	layer.confirm('请确认此楼栋信息无误',{title:'提示信息',icon:'1',skin:'lan_class'},function(index){
		$.get('/ph/ConfirmBanInfo/confirm/BanID/'+banID,function(result){
			result = JSON.parse(result);
			
			if(result.retcode  == '2000' ){
				layer.msg(result.msg);
				location.reload();
			}else{
				layer.msg(result.msg);
			}
		});
	});

});
//var allMap = new BMap.Map("allMap",{enableMapClick: false});

$(".details_btn").click(function(){
	$('#Drecord').html('');
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

			$("#detailBanNumber").text(res.data.BanNumber);          //栋号
			$("#detailEnterpriseRent").text(res.data.EnterpriseRent); //企业规租
			$('#detailEnterprisePrice').text(res.data.EnterpriseOprice);//企业原价
			$('#detailEnterpriseNumber').text(res.data.EnterpriseNum);//企业栋数
			$("#detailPartyRent").text(res.data.PartyRent); //机关规租
			$('#detailPartyPrice').text(res.data.PartyOprice);    //机关原价
			$('#detailPartyNumber').text(res.data.PartyNum);          //机关栋数
			$("#detailCivilRent").text(res.data.CivilRent); //民用规租
			$('#detailCivilPrice').text(res.data.CivilOprice);          //民用原价
			$('#detailCivilNumber').text(res.data.CivilNum);          //民用栋数

			$('p[id=detailBanPropertyID]').text(res.data.BanPropertyID); //产权证号
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
			$('#detailBanRatio').text(res.data.BanRatio);

			$('#detailsTotalArea').text(res.data.CoveredArea);
			$('#detailActualArea').text(res.data.ActualArea);
			$('#detailBanArea').text(res.data.BanArea);
			$('#detailEnterpriseArea').text(res.data.EnterpriseArea);
			$('#detailPartyArea').text(res.data.PartyArea);
			$('#detailCivilArea').text(res.data.CivilArea);
			//$('#detailBanArea').text(res.data.BanArea); //计算租金
			$('#IfElevator').html(res.data.IfElevator);
			$('#IfFirst').html(res.data.IfFirst);
			$('p[id=BanLandID]').text(res.data.BanLandID);         //土地证号
			$('p[id=BanUnitNum]').text(res.data.BanUnitNum);       //总单元数
			$('p[id=BanUsearea]').text(res.data.BanUsearea);       //使用面积
			$('p[id=CutIf]').text(res.data.CutIf);                 //产权是否分隔
			$('p[id=HistoryIf]').text(res.data.HistoryIf);         //是否历史优秀建筑
			$('p[id=ProtectculturalIf]').text(res.data.ProtectculturalIf);  //是否文物保护建筑
			$('p[id=ReformIf]').text(res.data.ReformIf);           //是否改造产
			$('p[id=TotalArea]').text(res.data.TotalArea);         //合建面积
			$('p[id=detailPropertySource]').text(res.data.PropertySource);         //产权来源
			$('p[id=detailRemoveStatus]').text(res.data.RemoveStatus);         //拆迁状态
			$('p[id=BanGpsXY]').text(res.data.BanGpsX+','+res.data.BanGpsY);         //经纬度
			//记录
			var ARecord = res.data.change_record;
			var aHtml='';
			if(ARecord&&ARecord.length!=0){
				for(var i=0;i<ARecord.length;i++){
					for(var j=0;j<4;j++){
						aHtml=ARecord[i][1]+'完成'+'<a href="/ph/ChangeRecord/index?ChangeOrderID='+ARecord[i][0]+'" class="am-text-secondary" target="_blank">'+ARecord[i][2]+'</a>'+'异动，申请机构'+ARecord[i][3];
					}

					$('#Drecord').append("<li>"+aHtml+"</li>");
					aHtml='';
				}
			}
			
			
			if(res.data.BanImageIDS.length ==3){
				$('#detailImgOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
				$('#detailImgThree').attr('src',res.data.BanImageIDS[2].FileUrl);		//图片影像
			}else if(res.data.BanImageIDS.length ==2){
				$('#detailImgOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
				$('#detailImgTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
			}else if(res.data.BanImageIDS.length ==1){
				$('#detailImgOne').attr('src',res.data.BanImageIDS[0].FileUrl);	
			}

		$('#banDetail').css('display','block');
		var allMap = new BMap.Map("allMap",{enableMapClick: false});
		allMap.clearOverlays();
//		allMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 15);
		var point2 = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);
		allMap.centerAndZoom(point2, 15);		
//		allMap.setCenter(point2);
		
		marker = new BMap.Marker(point2);
		allMap.addOverlay(marker);   
		var oA = res.data.BanGpsX+','+res.data.BanGpsY
	            marker.ondblclick=function(){
	            	url='/public/baidumap/big2.html?position='+oA;
	            	window.open(url,'parent');
	    }
		 allMap.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
		//		allMap.disableDoubleClickZoom() //禁用双击放大。
		   
			allMap.enableScrollWheelZoom(true);
			
			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				title:['楼栋明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#banDetail'),
				
				end:function(){
					$('#banDetail').css('display','none');
				}
				
			});
		})
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
			
			for(var i = 1;i<=res.data.BanFloorNum;i++){
				var FloorDom = $("<tr></tr>");
				FloorDom.append($("<td>"+i+"</td>"));
				for(var j = 1;j < parseInt(res.data.BanUnitNum) + 1;j++){
				  	var DoorDom = $("<td></td>");
				  	// console.log(res.data.allHouse[1][j]);
				  		if(res.data.allHouse[j][i].length!=0){
				  			for(var k=0;k<res.data.allHouse[j][i].length;k++){
				  			// console.log('aaa');
				  			// console.log(res.data.allHouse[i][j].length);
				  			if(res.data.allHouse[j][i][k].DoorID==''){
				  				DoorDom.append($("<span class='ban_span stru-border' value='"+res.data.allHouse[j][i][k].HouseID+"'></span>"));
				  			}else{
				  				DoorDom.append($("<span class='ban_span' value='"+res.data.allHouse[j][i][k].HouseID+"'>"+res.data.allHouse[j][i][k].DoorID+"</span>"));
				  			}
				  		}
				  		}
				  		
				  	
					// for(var k in res.data.allHouse[i][j]){
					// 	if(k != 0){
					// 		DoorDom.append($("<span class='ban_span' value='"+res.data.allHouse[j][i][k]+"'>"+k+"</span>"));
					// 	}
					// }
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
				area:['1000px','600px'],
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

// 打开高拍仪
$('img').click(function(){
	var popWin = window.open('http://web.gf.com/public/unit/index.html');
	// setInterval(function(){
	// 	console.log('fff');
	// 	popWin.postMessage('dsfsdaf',"http://ph.ctnmit.com/");
	// },2000);
	$('#currentId').val($(this).attr('id'));
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
