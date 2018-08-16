$('.print2').click(function(event){
	event.stopPropagation();
	var houseID = $(this).val();
	console.log(houseID);
	layer.open({
		type:1,
		area:['750px','700px'],
		resize:false,
		zIndex:100,
		title:['租约申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#print2'),
		btn:['打印','取消'],
		success:function(){
			$.get('/ph/LeaseAudit/detail/ChangeOrderID/'+houseID,function(res){
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

		}
	})
});

