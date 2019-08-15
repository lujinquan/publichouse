var mapJson = [
	{mX:114.213846,mY:30.671054,BanId:0301080101,aDd:'民主路171#'},
	{mX:113.763113,mY:30.83591,BanId:0301080102,aDd:'民主路172#'},
	{mX:114.243742,mY:30.64471,BanId:0301080103,aDd:'民主路173#'},
	{mX:114.453586,mY:30.74011,BanId:0301080104,aDd:'民主路174#'},
	{mX:114.503029,mY:30.566133,BanId:0301080105,aDd:'民主路175#'},
	{mX:114.365624,mY:30.540258,BanId:0301080106,aDd:'民主路176#'},
	{mX:114.282836,mY:30.394831,BanId:0301080107,aDd:'民主路177#'},
	{mX:114.216721,mY:30.679005,BanId:0301080108,aDd:'民主路178#'},
	{mX:113.956859,mY:30.657635,BanId:0301080109,aDd:'民主路179#'},
	{mX:114.137383,mY:30.657635,BanId:0302080101,aDd:'民主路181#'}
	];
function bigMap(){
	
	var marker2= [];
	var _href=window.location.href;
	var aHref =_href.split('=')[1].split(','); 
		var map2 = new BMap.Map("allmap2",{enableMapClick: false});    
		var point = new BMap.Point(parseFloat(aHref[0]),parseFloat(aHref[1]));
		map2.centerAndZoom(point, 15); 
		var marker = new BMap.Marker(point);
		map2.addOverlay(marker);   //主坐标
		var infoWindow ='';
		map2.addEventListener("click",function(e){
				if(e.overlay){
					return;
				}else{
					map2.removeOverlay(marker);
							opsiX =  e.point.lng;
							opsiY = e.point.lat;
							point = new BMap.Point(opsiX,opsiY);
							marker = new BMap.Marker(point);  // 创建标注
							map2.addOverlay(marker); 
				}												
				});		
		$('.cha').click(function(){
			window.opener.postMessage({'x':opsiX,'y':opsiY},'*');
			$('.bg').addClass('hide');
			$('#allmap').addClass('hide');
			window.close();
		})	
		for(var i=0;i<mapJson.length;i++){
			point = new BMap.Point(mapJson[i].mX,mapJson[i].mY);
			var icon = new BMap.Icon('img/market.png', new BMap.Size(20, 20), {
    			anchor: new BMap.Size(10, 20),
    			infoWindowAnchor: new BMap.Size(10, 5)
		});
		// marker2[i] = new BMap.Marker(point,{icon:icon});// 创建标注
		// marker2[i].mX = mapJson[i].mX;
		// marker2[i].mY = mapJson[i].mY;
		// marker2[i].BanId = mapJson[i].BanId;
		// marker2[i].aDd = mapJson[i].aDd;
		// map2.addOverlay(marker2[i]); 		
		// marker2[i].addEventListener("click",function(e){			
		// 		var opsiX =this.mX;
		// 		var opsiY = this.mY;
		// 		sContent ="<table style='border:1px solid black; width:500px; height:50px;text-align:center;margin:15px 0;' cellspacing='0'>"+
		// 	"<thead>"+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋编号</th> "+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋地址</th>"+"<th style='border-bottom:1px solid black;'>操作</th>"+"</thead>"+"<tbody>"+
		// 	"<tr>"+"<td style='border-right:1px solid black'>"+this.BanId+"</td>"+
		// 	"<td style='border-right:1px solid black'>"+this.aDd+"</td>"+"<td>"+
		// 			"<a href='#' style='margin-right:10px'>查看明细</a>"+
		// 			"<a href='#'>查看房屋</a>"+
		// 		"</td>"+"</tr>"+"</tbody>"+"</table>";	
		//  infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象 
		// 		point = new BMap.Point(opsiX,opsiY);	            	
	 //           this.openInfoWindow(infoWindow,point); //开启信息窗口
	        
	 //    });
		}		
	map2.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
	map2.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
}
// function bigMap2(){
	
// 	var marker2= [];
// 	var _href=window.location.href;
// 	var aHref =_href.split('=')[1].split(','); 
	
// //	console.log(aHref[1]);
// 		var map = new BMap.Map("allmap",{enableMapClick: false});    
// 		var point = new BMap.Point(parseFloat(aHref[0]),parseFloat(aHref[1]));
// 		map.centerAndZoom(point, 15); 
// 		var marker = new BMap.Marker(point);
// 		map.addOverlay(marker);   //主坐标
// 		var infoWindow ='';
// 		marker.addEventListener("click",function(e){
// 				var BanId=0301080100;
// 				var aDd='民主路170#';
// 				var opsiX =114.314169;
// 				var opsiY = 30.599275;
				
// 				sContent ="<table style='border:1px solid black; width:500px; height:50px;text-align:center;margin:15px 0;' cellspacing='0'>"+
// 			"<thead>"+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋编号</th> "+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋地址</th>"+"<th style='border-bottom:1px solid black;'>操作</th>"+"</thead>"+"<tbody>"+
// 			"<tr>"+"<td style='border-right:1px solid black'>"+BanId+"</td>"+
// 			"<td style='border-right:1px solid black'>"+aDd+"</td>"+"<td>"+
// 					"<a href='#' style='margin-right:10px'>查看明细</a>"+
// 					"<a href='#'>查看房屋</a>"+
// 				"</td>"+"</tr>"+"</tbody>"+"</table>";	
// 				infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象 
// 				point = new BMap.Point(opsiX,opsiY);	            	
// 	           marker.openInfoWindow(infoWindow,point); //开启信息窗口    
// 	    });
// 	    $('.cha').click(function(){
// 		$('.bg').addClass('hide');
// 		$('#allmap').addClass('hide');
// 		window.close();
// 	})
// //			map.addEventListener("click",function(e){
// //				if(e.overlay){
// //					return;
// //				}else{
// //					map.removeOverlay(marker);
// //							opsiX =  e.point.lng;
// //							opsiY = e.point.lat;
// //							point = new BMap.Point(opsiX,opsiY);
// //							marker = new BMap.Marker(point);  // 创建标注
// //							map.addOverlay(marker); 
// //				}
// //						
// //						
// //					});
		
	
// 		for(var i=0;i<mapJson.length;i++){
// 			point = new BMap.Point(mapJson[i].mX,mapJson[i].mY);
// 			var icon = new BMap.Icon('img/market.png', new BMap.Size(20, 20), {
//     			anchor: new BMap.Size(10, 20),
//     			infoWindowAnchor: new BMap.Size(10, 5)
// 		});
// 		marker2[i] = new BMap.Marker(point,{icon:icon});// 创建标注
// 		marker2[i].mX = mapJson[i].mX;
// 		marker2[i].mY = mapJson[i].mY;
// 		marker2[i].BanId = mapJson[i].BanId;
// 		marker2[i].aDd = mapJson[i].aDd;
// 		map.addOverlay(marker2[i]); 		
// 		marker2[i].addEventListener("click",function(e){			
// 				var opsiX =this.mX;
// 				var opsiY = this.mY;
// 				sContent ="<table style='border:1px solid black; width:500px; height:50px;text-align:center;margin:15px 0;' cellspacing='0'>"+
// 			"<thead>"+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋编号</th> "+"<th style='border-right:1px solid black;border-bottom:1px solid black;'>楼栋地址</th>"+"<th style='border-bottom:1px solid black;'>操作</th>"+"</thead>"+"<tbody>"+
// 			"<tr>"+"<td style='border-right:1px solid black'>"+this.BanId+"</td>"+
// 			"<td style='border-right:1px solid black'>"+this.aDd+"</td>"+"<td>"+
// 					"<a href='#' style='margin-right:10px'>查看明细</a>"+
// 					"<a href='#'>查看房屋</a>"+
// 				"</td>"+"</tr>"+"</tbody>"+"</table>";	
// 		 infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象 
// 				point = new BMap.Point(opsiX,opsiY);	            	
// 	           this.openInfoWindow(infoWindow,point); //开启信息窗口
	        
// 	    });
// 		}
		

	

// 	map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
// 	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
// }

