window.onload=function(){
    var mp;
    initMap();
	var bs = mp.getBounds();   //获取可视区域
    var bssw = bs.getSouthWest();   //可视区域左下角
    var bsne = bs.getNorthEast();   //可视区域右上角
    var topLat = bsne.lat;
    var bottomLat = bssw.lat;
    var leftLng = bssw.lng;
    var rightLng = bsne.lng;
    var aLabel = [];

mp.setMapStyle({
    styleJson:[
    	{
            "featureType": "building",
            "elementType": "all",
            "stylers": {
                      "visibility": "on"
            }
          },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": {
                "lightness": 2,
				"visibility": "on"
            }
        },
        {
            "featureType": "highway",
            "elementType": "geometry",
            "stylers": {
                "color": "#f49935",
				"visibility": "off"
            }
        },
        {
            "featureType": "railway",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        },
	    {
	        "featureType": "arterial",
	        "elementType": "all",
	        "stylers": {
	                  "visibility": "on"
	        }
	    },
        {
            "featureType": "local",
            "elementType": "labels",
            "stylers": {
                "visibility": "on"
            }
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": {
                "color": "#d1e5ff"
            }
        },
        {
            "featureType": "poilabel",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }
    ]
});
	var area_array = null;
	function setCircle(area,room_size){
		mp.clearOverlays();
		for(var i in area){
			var point = new BMap.Point(parseFloat(area[i].GpsX), parseFloat(area[i].GpsY));
			if(room_size == 16){
				radius = 150;
			}else if(room_size == 17){
				radius = 80;
			}else if(room_size == 18){
				radius = 50;
			}

			var circle = new BMap.Circle(point,radius,{
				strokeStyle:'dashed',
				strokeWeight:'1px',
				fillColor:'#1188F0',
				fillOpacity:'0.9'
			});
			mp.addOverlay(circle);
			var opts_1 = {
			  position : point, 
			  offset   : new BMap.Size(-45, -20) 
			}
			var label_1 = new BMap.Label(area[i].name, opts_1);
				label_1.setStyle({
					 color : "#FFF",
					 fontSize : "12px",
					 height : "20px",
					 lineHeight : "20px",
					 fontFamily:"微软雅黑",
					 border:0,
					 display:'block',
					 width:'90px',
					 textAlign:'center',
					 background:'none'

				 });
			mp.addOverlay(label_1);
			var opts_2 = {
			  position : point, 
			  offset   : new BMap.Size(-45, 0) 
			}
			var label_2 = new BMap.Label(area[i].detail.length+'栋', opts_2);
				label_2.setStyle({
					 color : "#FFF",
					 fontSize : "18px",
					 height : "20px",
					 lineHeight : "20px",
					 fontFamily:"微软雅黑",
					 border:0,
					 display:'block',
					 width:'90px',
					 textAlign:'center',
					 background:'none'

				 });
			mp.addOverlay(label_2);

		}
	}

	function initMap(){
      	createMap();//创建地图
      	setMapEvent();//设置地图事件
      	addMapControl();//向地图添加控件
      	addMapOverlay();//向地图添加覆盖物
    }
    function createMap(){
      	mp = new BMap.Map("allmap",{
	      	minZoom:16,
	      	maxZoom:24,
			enableMapClick: false
       	});
      	mp.centerAndZoom(new BMap.Point(114.322549,30.559567),15);
    }
    function setMapEvent(){
      	mp.enableScrollWheelZoom();
      	mp.enableKeyboard();
      	mp.enableDragging();
      	mp.enableDoubleClickZoom()
    }
    function addClickHandler(target,window){
      	target.addEventListener("click",function(){
        	target.openInfoWindow(window);
      	});
    }
    function addMapOverlay(){

    }
    //向地图添加控件
    function addMapControl(){
      	var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
      	scaleControl.setUnit(BMAP_UNIT_METRIC);
      	mp.addControl(scaleControl);
      	var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
      	mp.addControl(navControl);
      	var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
      	mp.addControl(overviewControl);
    }
	
	$('#cha2').click(function(){
    	$('.contentM').css('display','none');
    })

    function ComplexCustomOverlay(point,text,address){
      	this._point = point;
      	this._text = text;
      	this._address = address;
    }

    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
      this._map = map;
      var div = this._div = document.createElement("div");
      div.style.position = "absolute";
      div.style.zIndex = 0;    
      div.style.color = "white";
      div.style.lineHeight = "18px";
      div.style.whiteSpace = "nowrap";
      div.style.MozUserSelect = "none";
      div.style.fontSize = "12px";
      div.style.textAlign='center';
      div.className='aDiv';
      var span = this._span = document.createElement("span");
      span.style.padding = "5px";
      span.style.backgroundColor = "#2d69f9";
      span.style.borderRadius = '4px';
      div.appendChild(span);
      span.appendChild(document.createTextNode(this._address));
      var ban_id = document.createAttribute("ban_id");
      ban_id.value = this._text;
      span.setAttributeNode(ban_id);
      var that = this;
      var arrow = this._arrow = document.createElement("div");
      arrow.style.width = "0px";
      arrow.style.position = "relative";
      arrow.style.height = "0px";
      arrow.style.borderLeft = "8px solid transparent";
      arrow.style.borderRight = "8px solid transparent";
      arrow.style.borderTop="8px solid #2d69f9";
      arrow.style.left="17px";
      arrow.style.top="2px";
      arrow.className='aR'
      div.appendChild(arrow);
      
      div.onmouseover = function(){
        this.children[0].className='bgO';
    	this.children[1].className='borderO';
    	this.style.zIndex=100;
      }
      div.onmouseout = function(){
       	this.children[0].className='bgB';
    	this.children[1].className='borderB';
    	this.style.zIndex=0;
      }
　    // 将div添加到覆盖物容器中  
      mp.getPanes().labelPane.appendChild(div);//getPanes(),返回值:MapPane,返回地图覆盖物容器列表  labelPane呢???
      return div;
    }
 
    //鼠标经过
    
    //3、绘制覆盖物
    // 实现绘制方法
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
      this._div.style.top  = pixel.y - 30 + "px";
    }
   
    //4、自定义覆盖物添加事件方法
    ComplexCustomOverlay.prototype.addEventListener = function(event,fun){
        this._div['on'+event] = fun;
    }
    
    $.ajax({
        type : 'post',  
        url : '/ph/Api/get_ban_map_point',  
        async: false,  
        success : function(res) {  
           	res = JSON.parse(res);
           	console.log(res.data.point);
			var room_size = mp.getZoom();
           	
			for(var j in res.data.point){
			    res.data.point[j].detail.sort(function(a,b){
			   		return a.BanGpsX - b.BanGpsX
			   	})
				var aDate = res.data.point[j].detail.length;
				aLabel.push(res.data.point[j].detail[0]);
				for (var i = 0; i < aDate; i++) {
					if(res.data.point[j].detail[i].BanGpsX !== aLabel[aLabel.length-1].BanGpsX){
						aLabel.push(res.data.point[j].detail[i]);
					}
				}
				console.log(aLabel);
			}
			area_array = res.data.point;
			if(room_size > 18){
				getM(aLabel);
			}else{
				setCircle(res.data.point,room_size);
			}
        }
    }); 
  	var TubulationID=document.getElementById('doc-select-2');
  	var OwnerTyp=document.getElementById('doc-select-5');
	mp.addEventListener("dragend", function(){
		var room_size = mp.getZoom();
		console.log(room_size);
		if(room_size > 18){
			getM(aLabel);
		}else{
			setCircle(area_array,room_size);
		}
	});
	mp.addEventListener("zoomend", function(){
		var room_size = mp.getZoom();
		console.log(room_size);
		if(room_size > 18){
			getM(aLabel);
		}else{
			setCircle(area_array,room_size);
		}
	});
    TubulationID.onchange = OwnerTyp.onchange = function(){
   		mp.clearOverlays();
    	var TubulationID= $('#doc-select-2').children('option:selected').val();  
        var OwnerTyp =$('#doc-select-5').children('option:selected').val();
    	$.post('/ph/Api/get_ban_map_point',{TubulationID:TubulationID,OwnerType:OwnerTyp},function(res){
    		res = JSON.parse(res);
           	console.log(res.data.point);
           	var room_size = mp.getZoom();
           	aLabel = [];
			for(var j in res.data.point){
			    res.data.point[j].detail.sort(function(a,b){
			   		return a.BanGpsX - b.BanGpsX
			   	})
				var aDate = res.data.point[j].detail.length;
				
				aLabel.push(res.data.point[j].detail[0]);
				for (var i = 0; i < aDate; i++) {
					if(res.data.point[j].detail[i].BanGpsX !== aLabel[aLabel.length-1].BanGpsX){
						aLabel.push(res.data.point[j].detail[i]);
					}
				}
				console.log(aLabel);
			}
			area_array = res.data.point;
			if(room_size > 18){
				getM(aLabel);
			}else{
				setCircle(area_array,room_size);
			}

		})//post
    }

	function getM(a){
		mp.clearOverlays();
		var aDate = a.length;
		console.log(aDate);
		var myCompOverlay = '';
		mp.clearOverlays();
		bs = mp.getBounds();   //获取可视区域
	    bssw = bs.getSouthWest();   //可视区域左下角
	    bsne = bs.getNorthEast();   //可视区域右上角   
	    topLat = bsne.lat;
	    bottomLat = bssw.lat;
	    leftLng = bssw.lng;
	    rightLng = bsne.lng;
		for (var i = 0; i < aDate; i++) {
			if(parseFloat(a[i].BanGpsX)<rightLng &&
				parseFloat(a[i].BanGpsX)>leftLng &&
				parseFloat(a[i].BanGpsY)<topLat &&
				parseFloat(a[i].BanGpsY)>bottomLat){
				myCompOverlay = new ComplexCustomOverlay(new BMap.Point(parseFloat(a[i].BanGpsX),parseFloat(a[i].BanGpsY)),a[i].BanID,a[i].AreaFour);
				mp.addOverlay(myCompOverlay);

				//console.log(myCompOverlay);
				
				var aR=$('.aR');
				var aDiv = $('.aDiv');
    			myCompOverlay.addEventListener('click',function(){
    				for(var i=0;i<aR.length;i++){
	    				aR[i].className='borderB';
	    				aDiv[i].children[0].className='bgB';
	    				aDiv[i].onmouseout=function(){
	    					this.children[0].className='bgB';
					    	this.children[1].className='borderB';
					    	this.style.zIndex=0;
	    				}
	    			}

	    			$('.contentM').css('display','block')
					this.children[0].removeClass='bgB';
					this.children[1].removeClass='borderB';
					this.children[0].className='bgO';
	    			this.children[1].className='borderO';

					this.onmouseout=function(){
						return false;
					}

					var b=$(this).find('span').attr('ban_id');

					$.get('/ph/Api/get_ban_detail_info?BanID='+b,function(res){
						res = JSON.parse(res);
						$('#BanID').html(res.data.top.BanID);
						$('#BanAddress').html(res.data.top.BanAddress);
						$('#PropertySource').html(res.data.top.PropertySource);
						$('#TubulationID').html(res.data.top.TubulationID);
						$('#OwnerType').html(res.data.top.OwnerType);
						$('#BanPropertyID').html(res.data.top.BanPropertyID);
						$('#BanYear').html(res.data.top.BanYear);
						$('#DamageGrade').html(res.data.top.DamageGrade);
						$('#StructureType').html(res.data.top.StructureType);
						$('#UseNature').html(res.data.top.UseNature);
						$('#TotalArea').html(res.data.top.TotalArea);
						$('#TotalOprice').html(res.data.top.TotalOprice);//top
						$('#HouseID li').not(":first").remove(); 
						$('#TenantName li').not(":first").remove(); 
						$('#DoorID li').not(":first").remove(); 
						$('#UnitID li').not(":first").remove(); 
						$('#FloorID li').not(":first").remove(); 
						$('#DetailM li').not(":first").remove(); 
						$('#UseNatured li').not(":first").remove(); 
						$('#RegularPrice li').not(":first").remove(); 
						$('#UseArea li').not(":first").remove(); 

						for(i=0;i<res.data.bottom.length;i++){
							// var newul=$("<li class='houseI'></li>");
							// newul.appendTo($("#HouseID"));
							// newul.html(res.data.bottom[i].HouseID);
							var newul1=$("<li ></li>");
							newul1.appendTo($("#TenantName"));
							newul1.html(res.data.bottom[i].TenantName);
							var newul2=$("<li></li>");
							newul2.appendTo($("#DoorID"));
							newul2.html(res.data.bottom[i].DoorID);
							var newul3=$("<li></li>");
							newul3.appendTo($("#UnitID"));
							newul3.html(res.data.bottom[i].UnitID);
							var newul4=$("<li></li>");
							newul4.appendTo($("#FloorID"));
							newul4.html(res.data.bottom[i].FloorID);
							var newul6=$("<li></li>");
							newul6.appendTo($("#UseNatured"));
							newul6.html(res.data.bottom[i].UseNature);
							var newul7=$("<li></li>");
							newul7.appendTo($("#UseArea"));
							newul7.html(res.data.bottom[i].HouseUsearea);
							var newul8=$("<li></li>");
							newul8.appendTo($("#RegularPrice"));
							newul8.html(res.data.bottom[i].HousePrerent);
							var newul5=$("<li></li>");
							var aInp = $("<input type='button' data="+res.data.bottom[i].HouseID+" value='明细' class='f12 house_M detail-btn' />")
							newul5.appendTo($("#DetailM"));
							aInp.appendTo(newul5);	
						}

						$(".house_M").click(function(){
							// var _this=$(this).index('.house_M');
							// console.log(_this);
							var HouseID = $(this).attr('data');
							console.log(HouseID);

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
								$('#houseDetail').css('display','block');

								layer.open({
									type:1,
									area:['800px','600px'],
									resize:false,
									title:['房屋明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
									content:$('#houseDetail'),
									end:function(){
										$('#houseDetail').css('display','none');
									}
								});
							})
						})
					})
				})
			}
		}
		
	}
}

$("#check_btn").click(function(){
	
	var BanID = $('#BanID').html();
	console.log(BanID);

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
		// if(res.data.BanImageIDS.length != 0){
		// 	$('#detailImgOne').attr('src',res.data.BanImageIDS[0].FileUrl);		//图片影像
		// 	// $('#detailImgTwo').attr('src',res.data.BanImageIDS[1].FileUrl);		//图片影像
		// 	// $('#detailImgThree').attr('src',res.data.BanImageIDS[2].FileUrl);		//图片影像
		// }
		$('#banDetail').css('display','block');
		var allMap = new BMap.Map("allMap",{enableMapClick: false});
		allMap.clearOverlays();
		//		allMap.centerAndZoom(new BMap.Point(114.334228,30.560372), 15);
		var point2 = new BMap.Point(res.data.BanGpsX,res.data.BanGpsY);
		allMap.centerAndZoom(point2, 15);		
		//		allMap.setCenter(point2);
	
		marker = new BMap.Marker(point2);
		allMap.addOverlay(marker);   
		var oA = res.data.BanGpsX+','+res.data.BanGpsY;
        marker.ondblclick = function(){
        	url='/public/baidumap/big2.html?position='+ oA;
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