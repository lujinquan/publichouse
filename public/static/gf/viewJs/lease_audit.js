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
		title:['租约申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
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
			$('#print2').show();
		},
		yes:function(){
			layer.closeAll();
		},
		btn2:function(){
			$('#print2').show();
			bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
			sprnstr="<!--startprint-->";//设置打印开始区域  
			eprnstr="<!--endprint-->";//设置打印结束区域  
			prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html  
			prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html 
			window.document.body.innerHTML=prnhtml;
			setTimeout("window.print()",100);
			window.document.body.innerHTML=bdhtml;
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
				var data = res.data.detail;
				console.log(data);
				for(var key in data){
					var name_id = key.replace(/apply/,'detail');
					$('#'+name_id).text(data[key]);
				}
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
		area:['400px','300px'],
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
                url: "/ph/ChangeApply/add",
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