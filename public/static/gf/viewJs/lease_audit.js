$('.print2').click(function(event){
	event.stopPropagation();
	layer.open({
		type:1,
		area:['750px','700px'],
		resize:false,
		zIndex:100,
		title:['租约申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#print2'),
		btn:['确认','取消'],
		success:function(){

		},
		yes:function(){

		}
	})
})