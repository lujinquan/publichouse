$('#index_notice_pages').on('click', '.page_notice_index', function(){
	var id = $(this).context.id;
	var search = $('input[name="notice_search"]').val();
	var data = 'id='+id+'&search='+search;
	$.post('/ph/Index/noticePageList', data, function(res){
		res = JSON.parse(res);
		// console.log(res);
		var list = res.data.list;
		$('#index_notice_list_content').empty();
		var  buf = '';
		for (var i = 0; i < list.length; i++) {
			if(list[i].IsTop == 1){
				buf += '<tr><td style="width:70%;font-size:1.5rem;font-weight:bold;"><span class="notice_info" style="cursor:pointer;" id="'+ list[i].id +'">' + list[i].Title + '</span></td><td>'+ list[i].UpdateTime +'</td></tr>';
			}else{
				buf += '<tr><td style="width:70%;font-size:1.25rem;font-weight:normal;"><span class="notice_info" style="cursor:pointer;" id="'+ list[i].id +'">' + list[i].Title + '</span></td><td>'+ list[i].UpdateTime +'</td></tr>';
			}	
		}
		$('#index_notice_list_content').append(buf);

		$('#index_notice_pages').empty();
		$('#index_notice_pages').append(res.data.nav);
	});
});

$('#index_notice_list_content').on('click', '.notice_info', function(){
	id = $(this).context.id;
	// console.log(id);
	var data = 'id='+id;
    var res = null;
	$.ajax({
        url : '/ph/Api/show',
        dataType : 'json',
        type : 'POST',
        data : data,
        async : false,
        success : function(msg){
            res = msg;
        }
    });
    layer.open({
        type:1,
        area:['1000px','700px'],
        
        resize:false,
        zIndex:100,
        title:['公告','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
        btn:['确定','取消'],
        content:$("#notice_info_dialog"),
        success:function(){
        	content = unescape(res.data.Content);
            $('#title_info').html(res.data.Title);
            $('#update_time_info').html(res.data.UpdateTime);
            $('#name_info').html(res.data.Name);
            $('#content_info').html(content);
        }
    });
});

$('#wait_processing').on('click', '.upload_file_index', function(){
	var id = $(this).context.id;
	//console.log(id);
	var data = 'id='+id;
	$.post('/ph/Index/waitProcessing', data, function(res){

		res = JSON.parse(res);
		//alert(res);
		var list = res.data.list;
		//console.log(list);
		$('#index_wait_processing_content').empty();
		var  buf = '';
		for (var i = 0; i < list.length; i++) {
			// buf += '<tr><td width="50%">'+ list[i].Title +'</td><td><a class="am-icon-download" href="downloadFile?file='+ list[i].Url +'"></a></td><td>'+ list[i].Time +'</td></tr>';
			buf += '<tr><td width="20%">'+ (i+1) +'</td><td width="20%">'+ list[i]['ChangeType'] +'</td><td>'+ list[i]['ChangeOrderID'] +'</td><td>'+ list[i]['CreateTime'] +'</td><td><div class="am-dropdown" data-am-dropdown><a style="color:#108EE9;" href="/">立即处理</a></div></td></tr>';
		}
		$('#index_wait_processing_content').append(buf);

		$('#wait_processing').empty();
		$('#wait_processing').append(res.data.nav);
	});
});

$('#upload_file_pages').on('click', '.upload_file_index', function(){
	var id = $(this).context.id;
	var search = $('input[name="file_search"]').val();
	var data = 'id='+id+'&search='+search;
	$.post('/ph/Index/uploadfilePageList', data, function(res){
		res = JSON.parse(res);
		console.log(res);
		var list = res.data.list;
		$('#index_upload_file_list_content').empty();
		var  buf = '';
		for (var i = 0; i < list.length; i++) {
			if(list[i].IsTop == 1){
				buf += '<tr><td width="50%" style="font-size:1.5rem;font-weight:bold;">'+ list[i].Title +'</td><td><a class="index-file-download am-icon-download" href="downloadFile?file='+ list[i].Url +'"></a></td><td>'+ list[i].CreateTime +'</td></tr>';
			}else{
				buf += '<tr><td width="50%" style="font-size:1.25rem;font-weight:normal;">'+ list[i].Title +'</td><td><a class="index-file-download am-icon-download" href="downloadFile?file='+ list[i].Url +'"></a></td><td>'+ list[i].CreateTime +'</td></tr>';
			}	
			
		}
		$('#index_upload_file_list_content').append(buf);

		$('#upload_file_pages').empty();
		$('#upload_file_pages').append(res.data.nav);
	});
});


// $('.am-icon-plus').on('click', '.am-icon-plus', function(){
$('.admin-content-list .am-icon-plus').click(function(){
	var this_index = $(this).parents('li').index()+1;
	console.log(this_index);
	$.post('/ph/Index/secondlevelMenu', function(res){
		res = JSON.parse(res);
		// console.log(res);
		var menu = res.data;
		
		layer.open({
	        type:1,
	        area:['950px','600px'],
	        resize:false,
	        zIndex:100,
	        title:['快捷方式','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
	        btn:['确定','取消'],
	        content:$("#second_menu_list"),
	        success:function(){
	        	var buf = '';
		    	var k = 0;
		    	for (var i = 0; i < menu.length; i++) {
		    		if(k == 0){
		    			buf += '<tr>';
		    		}
		    		buf += '<td width="20%"><input name="short_cut" type="checkbox" value="'+ menu[i].UrlValue+ '" />&nbsp;<font>' + menu[i].Title + '</font></td>';
		    		k++;
		    		if(k == 4){
		    			buf += '</tr>';
		    			k = 0;
		    		}
		    	}
		    	$('#check_menu').empty();
		    	$('#check_menu').append(buf);
		    	var list = $('input[type="checkbox"]');
		    	$('.now-short-cut-list').each(function(i, dom){
		    		var href = $(dom).parent().parent()[0].pathname;
		    		href = href.substr(1);
		    		var img_url = dom.src;
		    		var src = img_url.substr(img_url.indexOf('public') - 1);
		    		var val = href + '|' + src;
		    		val  = decodeURI(val);
		    		// console.log(val + "---");
		    		for(var j = 0; j < list.length; j++){
		    			if(val == list[j].value){
		    				// console.log(val);
		    				list[j].checked = 'checked';
		    			}
		    		}
		    	});
	        },
	        yes:function(dia){
	        	var shortcut_val = $('#check_menu input[type="checkbox"]:checked').val();
	        	
	        	// var arr = new Array();
	        	// if(shortcut.length > 0){
	        	// 	// var arr = new Array(shortcut.length);
	        	// 	for(var i = 0; i < shortcut.length; i++){
	        	// 		// console.log($(shortcut[i]).next());return ;
	        	// 		var info = new Array();
	        	// 		info[0] = shortcut[i].value;
	        	// 		info[1] = $(shortcut[i]).next().html();
	        	// 		arr[i] = info;
	        	// 	}
	        	// }
	        	var data = {
	        		id:this_index,
	        		url:shortcut_val
	        	}
	        	console.log(data);
	        	$.post('/ph/Index/shortCutModify', data, function(res){
	        		res = JSON.parse(res);
	        		// console.log(res);
	        		// $('#show_short_cut_menu').empty();
	        		// buf = '';
	        		// for(var i = 0; i < arr.length; i++){
	        		// 	var kv = arr[i][0].split('|');
	        		// 	buf += '<li><a  class="short-cut-hover" href="'+ '/' + kv[0] +'" style="color:#333;"><span><img class="now-short-cut-list" src="'+ kv[1] +'"/></span><br/>'+ arr[i][1] +'</a></li>';
	        		// }
	        		// buf += '<li><a id="add_short_cut_menu" href="javascript:void(0)" style="color:#333;"><span class="am-icon-btn am-icon-bars short-cut-menu-hover"></span><br/>添加</a></li>';
	        		// $('#show_short_cut_menu').append(buf);
	        		location.reload();
	        	});
	        	layer.close(dia);
        	}
	    });
	});
});
$('.add_work_delete').click(function(){
	var this_index = $(this).parent('li').index()+1;
	console.log(this_index);
	$.get('/ph/Index/shortCutModify/id/'+this_index,function(res){
		location.reload();
	})
})



$('.add_work').mouseenter(function(){
	$(this).find('.add_work_delete').css('display','block');
})
$('.add_work').mouseleave(function(){
	$(this).find('.add_work_delete').css('display','none');
})
/*$('#show_short_cut_menu .short-cut-hover').live('mouseenter',function(){
	console.log('mouseenter');
	$(this).css('width', '66px');
	$(this).css('height', '66px');
	$(this).css('background', 'blue');
	$(this).css('border-radius', '50px');
	var src = $(this).children('span').children('img')[0].src;
	src = decodeURI(src);
	src = 'http://ph.com/public/static/gf/icons/hover/'+src.substr(37, src.length-47)+'hover.png';
	$(this).children('span').children('img').attr('src', src);
	console.log(src);
}).live('mouseleave',function(){
	console.log('mouseleave');
	var src = $(this).children('span').children('img')[0].src;
	src = decodeURI(src);
	src = 'http://ph.com/public/static/gf/icons/'+src.substr(43, src.length-52)+'normal.png';
	$(this).children('span').children('img').attr('src', src);
	console.log(src);
});*/

/*$('#show_short_cut_menu .short-cut-hover').on({
	mouseenter:function(){
		$(this).css('width', '66px');
		$(this).css('height', '66px');
		$(this).css('background', 'blue');
		$(this).css('border-radius', '50px');
		var src = $(this).children('span').children('img')[0].src;
		src = decodeURI(src);
		src = 'http://ph.com/public/static/gf/icons/hover/'+src.substr(37, src.length-47)+'hover.png';
		$(this).children('span').children('img').attr('src', src);
		console.log(src);
	},
	mouseleave:function(){
		var src = $(this).children('span').children('img')[0].src;
		src = decodeURI(src);
		src = 'http://ph.com/public/static/gf/icons/'+src.substr(43, src.length-52)+'normal.png';
		$(this).children('span').children('img').attr('src', src);
		console.log(src);
	}
});*/


$('#check_menu').on('click', 'input[type="checkbox"]', function(){
	var shortcut = $('input[type="checkbox"]:checked');
	if(shortcut.length >= 2){
		$(this).context.checked = false;
		$('#most_count').hide();
		return ;
	} else {
		$('#most_count').hide();
	}
});

$('.waitProcessing').click(function(){
	//alert(1);
	var value = $(this).val();
		console.log(value);
		CordID = "#approveForm";
	$(".breaks").hide();
	$(".pause").hide();
	$(".WriteOff").hide();
	console.log(value);
	$.get('/ph/ChangeAudit/detail/ChangeOrderID/'+value,function(res){
		res = JSON.parse(res);
		console.log(res);
		var type = res.data.detail.type;
		if(type == 1 || type == 2 || type == 3 || type == 4 || type == 8){
			$('.APhouseId').text(res.data.detail.HouseID);
			$('.APAPBanID').text(res.data.detail.BanID);
			$('.APhouseAddress').text(res.data.detail.BanAddress);
			$('.APFloorID').text(res.data.detail.FloorID);
			$('.APtenantName').text(res.data.detail.TenantName);
			$('.APtenantTel').text(res.data.detail.TenantTel);
			$('.APtenantNumber').text(res.data.detail.TenantNumber);
			$('.APcreateTime').text(res.data.detail.CreateTime);
			$('.APhouseArea').text(res.data.detail.HouseArea);
			$('.APleasedArea').text(res.data.detail.LeasedArea);
			//$('#approveName').text(res.data.detail.ChangeType);
			if(type == 1){
				$(".breaks").show();
				$(".pause").hide();
				$(".WriteOff").hide();
				$('#breakType').text(res.data.detail.TenantName);
				$('#IDNumber').text(res.data.detail.TenantName);
				$('#validity').text(res.data.detail.TenantName);
			}else if(type == 2){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").hide();
			}else if(type == 3){
				$(".breaks").hide();
				$(".pause").show();
				$(".WriteOff").hide();
				$('#pauseType').text(res.data.detail.TenantName);
			}else if(type == 4){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").show();
			}else if(type == 8){
				$(".breaks").hide();
				$(".pause").hide();
				$(".WriteOff").hide();
				$('.WriteOffStartTime').text(res.data.detail.CreateTime);
				$('.WriteOffEndTime').text(res.data.detail.WriteOffStartTime);
			}
			processState('#approveState',res);
			metailShow('#layer-photos-demo',res);
			CordID = "#approveForm";
		}else if(type == 5){
			metailShow('#AdjustPhotos',res);
			processState('#AdjustState',res);
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
			CordID = "#houseAdjust";

		}else if(type == 6){
			processState('#RepairState',res);
			metailShow('#RepairPhotos',res);
			CordID = "#repairChange";
		}else if(type == 7){

		}else if(type == 9){
			processState('#AdjustState',res);
			metailShow('#AdjustPhotos',res);
			CordID = "#houseAdjust";
		}

		layer.open({
			type:1,
			area:['800px','800px'],
			resize:false,
			zIndex:100,
			title:['审批','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$(CordID),
			btn:['通过','不通过'],
			yes:function(thisIndex){
				$.post('/ph/ChangeAudit/process/',{ChangeOrderID:value},function(res){
					res = JSON.parse(res);
					console.log(res);
					layer.msg(res.msg);
				});
				layer.close(thisIndex);
			},
			btn2:function(){
				layer.open({
					type:1,
					area:['400px','400px'],
					resize:false,
					zIndex:100,
					title:['不通过原因','color:#FFF;font-size:1.6rem;font-weight:600;'],
					content:'<textarea id="reason" style="width:400px;height:290px;border:none;"></textarea>',
					btn:['确认'],
					yes:function(msgIndex){
						var reasonMsg = $('#reason').val();
						console.log(reasonMsg);
						$.post('/ph/ChangeAudit/process/',{ChangeOrderID:value,reson:reasonMsg},function(res){
							res = JSON.parse(res);
							console.log(res);
							layer.msg(res.msg);
						});
						layer.close(msgIndex);
					}
				})
			}
		});
		layer.photos({
			photos: '#layer-photos-demo'
			,anim: 5
		});
	});
})

$('#file_search').click(function(){
	var search = $('input[name="file_search"]').val();
	var id = 1;
	$.post('/ph/Index/uploadfilePageList', {search:search,id:id}, function(res){
		res = JSON.parse(res);
		var list = res.data.list;
		$('#index_upload_file_list_content').empty();
		var  buf = '';
		for (var i = 0; i < list.length; i++) {
			buf += '<tr><td style="width:50%;padding-left:20px;">'+ list[i].Title +
			'</td><td style="width:20%;"><a class="index-file-download" href="downloadFile?file='+ list[i].Url 
			+'" style="color:#4C84FF;">下载</a></td><td>'+ list[i].Time +'</td></tr>';
		}
		$('#index_upload_file_list_content').append(buf);

		$('#upload_file_pages').empty();
		$('#upload_file_pages').append(res.data.nav);
	})
})

$('#notice_search').click(function(){
	var search = $('input[name="notice_search"]').val();
	var id = 1;
	$.post('/ph/Index/noticePageList', {search:search,id:id}, function(res){
		res = JSON.parse(res);
		var list = res.data.list;
		$('#index_notice_list_content').empty();
		var  buf = '';
		for (var i = 0; i < list.length; i++) {
			buf += '<tr><td style="width:70%;padding-left:20px;"><a class="notice_info" id="'
			+ list[i].id +'" href="javascript:void(0)">' 
			+ list[i].Title + '</a></td><td>'
			+ list[i].UpdateTime +'</td></tr>';
		}
		$('#index_notice_list_content').append(buf);

		$('#index_notice_pages').empty();
		$('#index_notice_pages').append(res.data.nav);
	})
})