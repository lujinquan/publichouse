$('.addLease').click(function(){
	layer.open({
		type:1,
		area:['1200px','750px'],
		resize:false,
		zIndex:100,
		title:['租约申请','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseAdd'),
		btn:['确认','取消'],
		success:function(){

		},
		yes:function(){

		}
	})
})

$('.BtnDetail').click(function(){
	layer.open({
		type:1,
		area:['1100px','750px'],
		resize:false,
		zIndex:100,
		title:['租约详情','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#leaseDetail'),
		btn:['确认','取消'],
		success:function(){

		},
		yes:function(){

		}
	})
})