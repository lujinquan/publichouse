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
			new file({
		        button: "#leaseApplication1",
		        show: "#leaseApplication1_Show",
		        upButton: "#leaseApplication1_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		    new file({
		        button: "#leaseApplication2",
		        show: "#leaseApplication2_Show",
		        upButton: "#leaseApplication2_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		    new file({
		        button: "#leaseApplication3",
		        show: "#leaseApplication3_Show",
		        upButton: "#leaseApplication3_Up",
		        size: 10240,
		        url: "/ph/ChangeApply/add",
		        ChangeOrderID: '',
		        Type: 1,
		        title: "证件上传"
		    });
		},
		yes:function(){
			var data = new FormData($('#MyForm')[0]);
			var formData = fileTotall.getArrayFormdata();
			var ent = formData.entries(); //不兼容IE
			while(item = ent.next()){
				if(item.done){
					break;
				}
				data.append(item.value[0],item.value[1]);
			}
			$.ajax({
                type: "post",
                url: "/ph/ChangeApply/add",
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    res = JSON.parse(res);
                    layer.msg(res.msg);
                    if(res.retcode == '2000'){
                        
                        location.reload();
                    }
                }
            });
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