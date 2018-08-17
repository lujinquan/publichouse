$('.examine').click(function(event){
	event.stopPropagation();
	var ChangeOrderID = $(this).val();
	var this_index = layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约详情','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		btn:['通过','不通过'],
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+ChangeOrderID,function(res){
				var res = JSON.parse(res);
				var data = res.data.detail;
				console.log(data);
				for(var key in data){
					var name_id = key.replace(/apply/,'detail');
					$('#'+name_id).text(data[key]);
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
		},
		yes:function(){
        	var formData = new FormData();
			formData.append('ChangeOrderID',ChangeOrderID);
        	processPass(formData,this_index);
		},
		btn2:function(){
			noPass(ChangeOrderID);
		}
	})
})
$('.print1').click(function(){
	event.stopPropagation();
	var ChangeOrderID = $(this).val();
	var this_index = layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约打印','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		btn:['打印','取消'],
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+ChangeOrderID,function(res){
				var res = JSON.parse(res);
				var data = res.data.detail;
				console.log(data);
				for(var key in data){
					var name_id = key.replace(/apply/,'detail');
					$('#'+name_id).text(data[key]);
				}
				if(data.QrcodeUrl != ""){
					$('#imghid').show();
					$('#picCode').show().prop('src',data.QrcodeUrl);
				}else{
					$('#imghid').hide();
					$('#picCode').hide();
				}
				// 隐藏流程和附件查看
				$('.print1_hide').hide();

			})
		},
		yes:function(){
			$.get('/ph/LeaseAudit/leasePrint/ChangeOrderID/'+ChangeOrderID,function(res){
				res = JSON.parse(res);
				console.log(res);
				if(res.retcode == '2000'){
					layer.close(this_index);
					setTimeout(function(){
						$('#leaseDetail').show();
						setTimeout("window.print()",500);
					},300);
					$('#leaseDetail').css({'position':'absolute','top':'0px','left':'0px','background':'#fff','z-index': '1000'});
					 
				}else{
					layer.msg(res.msg);
				}
			})
		},
		btn2:function(){
			
		}
	})
})

$('.print2').click(function(event){
	event.stopPropagation();
	var ChangeOrderID = $(this).val();
	$('.admin-content').addClass('am-print-hide');
	console.log(ChangeOrderID);
	var print2 = layer.open({
		type:1,
		area:['750px','700px'],
		resize:false,
		zIndex:100,
		title:['信息单打印','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#print2'),
		btn:['打印','取消'],
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+ChangeOrderID,function(res){
				var res = JSON.parse(res);
				var data = res.data.detail;
				console.log(data);
				for(var key in data){
					var name_id = key.replace(/apply/,'printer_2_');
					$('#'+name_id).text(data[key]);
				}
			})
		},
		yes:function(){
			layer.close(print2);
			setTimeout(function(){
				$('.outerControl').show();
				setTimeout("window.print()",500);
			},300);
			$('.outerControl').css({'position':'absolute','top':'0px','left':'0px','background':'#fff','z-index': '1000'});
			
			// bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
			// sprnstr="<!--startprint-->";//设置打印开始区域  
			// eprnstr="<!--endprint-->";//设置打印结束区域  
			// prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html  
			// prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html 
			// window.document.body.innerHTML=prnhtml;
			 
		},
		btn2:function(){
			
		}
	})
});

$('.detail_btn').click(function(event){
	event.stopPropagation();
	var ChangeOrderID = $(this).val();
	layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约详情','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+ChangeOrderID,function(res){
				var res = JSON.parse(res);
				console.log(res);
				var data = res.data.detail;
				console.log(data);
				for(var key in data){
					var name_id = key.replace(/apply/,'detail');
					$('#'+name_id).text(data[key]);
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
// 上传签字图片
$('.uploadPic').click(function(){
	event.stopPropagation();
	var ChangeOrderID = $(this).val();
	layer.open({
		type:1,
		area:['700px','500px'],
		resize:false,
		zIndex:100,
		title:['上传签字图片','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#uploadPicDiv'),
		btn:['确认','取消'],
		success:function(){
			new file({
                show: "#uploadPicShow",
                upButton:"#uploadPicUp",
                size: 10240,
                url: "/ph/LeaseAudit/uploadSign",
                button: "#uploadPic",
                ChangeOrderID: '',
                Type: 1,
                title: "其它"
            })
		},
		yes:function(){
			var formData = fileTotall.getArrayFormdata();
			formData.append('ChangeOrderID',ChangeOrderID);
			$.ajax({
		        type:"post",
		        url:'/ph/LeaseAudit/uploadSign',
		        data:formData,
		        processData:false,
		        contentType:false,
		        success:function(res){
		            // res = JSON.parse(res);
		               console.log(res);
		            layer.msg(res.msg);
		            // layer.close(this_index);
		            // location.reload();
		        }
			})
		}
	})

})




// 审批通过事件
function processPass(formData,this_index){
	$.ajax({
        type:"post",
        url:'/ph/LeaseAudit/process/',
        data:formData,
        processData:false,
        contentType:false,
        success:function(res){
            res = JSON.parse(res);
               console.log(res);
            layer.msg(res.msg);
            // layer.close(this_index);
            // location.reload();
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
			$.post('/ph/LeaseAudit/process/',{ChangeOrderID:value,reson:reasonMsg},function(res){
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


	var beforePrint = function() {
        console.log('Functionality to run before printing.');
    };

    var afterPrint = function() {
        console.log('Functionality to run after printing');
		$('.outerControl').hide();
		$('#leaseDetail').hide()
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }
    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;



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