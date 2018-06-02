//明细
$('.detailsBtn').click(function(){
	layer.open({
		type:1,
		area:['800px','700px'],
		resize:false,
		zIndex:100,
		title:['明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#detailForm'),
		success:function(){

		},
		yes:function(){

		}
	});
});
//补充资料
$('.addMaterial').click(function(){
	var thisValue = $(this).val();
	layer.open({
		type:1,
		area:['800px','700px'],
		resize:false,
		zIndex:100,
		title:['补充资料','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#addDetailThree'),
		success:function(){
			$.get('',function(){
				
			});
			var one = new file({
				button:"#picture",
				show:"#pictureShow",
				upButton:"#picturetUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"图纸"
			});
			var two = new file({
				button:"#plan",
				show:"#planShow",
				upButton:"#plantUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"维修方案"
			});
			var three = new file({
				button:"#picTh",
				show:"#picThShow",
				upButton:"#picThUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"维修方案"
			});
			var four = new file({
				button:"#planTh",
				show:"#planThShow",
				upButton:"#planThUp",
				size:1024,
				url:"/ph/ChangeApply/add",
				ChangeOrderID:'',
				Type:1,
				title:"维修方案"
			});
		},
		yes:function(){

		}
	});
});
//中修
$('#addMRepair').click(function(){
	layer.open({
		type:1,
		area:['1000px','700px'],
		resize:false,
		zIndex:100,
		title:['维修计划','color:#FFF;font-size:1.6rem;font-weight:600;'],
		btn:['确定','取消'],
		content:$('#bigRepaiForm'),
		success:function(){

		},
		yes:function(){

		}
	});
});