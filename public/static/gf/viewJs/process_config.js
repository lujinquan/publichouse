//新增审批流程
var stepDom = $('.step').clone();
$('#addProcess').click(function(){
	layer.open({
		type:1,
		area:['500px','600px'],
		resize:false,
		zIndex:100,
		title:['添加流程','color:#FFF;font-size:1.6rem;font-weight:600;'],
		content:$('#addForm'),
		btn:['确定','取消'],
		success:function(){
			$('.step').remove();//先删除，再添加
			var thisStep = stepDom.clone();
			$('#step').append(thisStep);
			$('select,input').attr('disabled',false);
			$('.delete').css('display','inline-block');
			$('#addStep').css('display','block');
			$("input[name='ProcessTitle']").val("");
		},
		yes:function(thisIndex){
			var data = $('#addForm').serializeArray();
			console.log(data);
			$.post('/ph/ProcessConfig/add/',data,function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.msg(res.msg);
				layer.close(thisIndex);
				if(res.retcode == 2000){
					location.reload();
				}
			});
		}
	})
});
//修改审批流程
$('#modifiProcess').click(function(){
	var obj = $('.checkId');
	for(var k in obj){
		if(obj[k].checked){
			var ID = obj[k].value;
		}
	}
	if(ID == undefined){
		layer.msg('请先选择要修改的流程！')
	}else{
		layer.open({
			type:1,
			area:['500px','600px'],
			resize:false,
			zIndex:100,
			title:['修改流程','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#addForm'),
			btn:['确定','取消'],
			success:function(){
				$.get('/ph/ProcessConfig/edit/id/'+ID,function(res){
					res = JSON.parse(res);
					console.log(res);
					var stepLength = res.data.Title.length;
					$("select[name='ProcessTitle'] option[value="+res.data.ProcessTitle+"]").attr("selected","selected");
					$('.step').remove();//先删除，再添加
					for(var i = 0;i < stepLength;i++){
						var thisStep = stepDom.clone();
						$('#step').append(thisStep);
						$('.step').last().find('input').val(res.data.Title[i]).prop("name","Title["+i+"]");
						$('.step').last().find('select').prop("name","RoleID["+i+"]");
						$('.step').last().find("select option[value="+res.data.RoleID[i]+"]").attr("selected",true);
					}
					//$('select').attr('disabled','disabled');
					$("select[name='ProcessTitle']").attr('disabled','disabled');
					$('.delete,#addStep').css('display','none');
				});
			},
			yes:function(thisIndex){
				var data = $('#addForm').serializeArray();
				var id = {name:"id",value:ID};
				data.splice(0,0,id);
				console.log(id);
				$.post('/ph/ProcessConfig/edit',data,function(res){
					res = JSON.parse(res);
					console.log(res);
					layer.close(thisIndex);
					if(res.retcode == 2000){					
						location.reload();
					}
				})
			}
		})
	}
})
//删除审批流程
$('#delProcess').click(function(){
	var obj = $('.checkId');
	for(var k in obj){
		if(obj[k].checked){
			var ID = obj[k].value;
		}
	}
	if(ID == undefined){
		layer.msg('请先选择要删除的流程！')
	}else{
		layer.confirm('确认删除？',{title:'提示信息',icon:'2',skin:'lan_class'},function(conIndex){
			$.get('/ph/ProcessConfig/delete/id/'+ID,function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.close(conIndex);
				if(res.retcode == 2000){
					location.reload();
				}
			});
		});
	}
})
//明细
$('.proDetail').click(function(){
	var ID = $(this).val();
	console.log(ID);
	if(ID == undefined){
		layer.msg('请先选择要修改的流程！')
	}else{
		layer.open({
			type:1,
			area:['500px','600px'],
			resize:false,
			zIndex:100,
			title:['流程明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
			content:$('#addForm'),
			success:function(){
				$.get('/ph/ProcessConfig/edit/id/'+ID,function(res){
					res = JSON.parse(res);
					console.log(res);
					var stepLength = res.data.Title.length;
					$("select[name='ProcessTitle']").find("option[value='"+res.data.ProcessTitle+"']").prop("selected",true);
					$('.step').remove();//先删除，再添加
					for(var i = 0;i < stepLength;i++){
						var thisStep = stepDom.clone();
						$('#step').append(thisStep);
						$('.step').last().find('input').val(res.data.Title[i]).prop("name","Title["+i+"]");
						$('.step').last().find('select').prop("name","RoleID["+i+"]");
						$('.step').last().find("select option[value="+res.data.RoleID[i]+"]").prop("selected",true);
					}
					$('#addForm select,#addForm input').attr('disabled','disabled');
					$('.delete,#addStep').css('display','none');
				});
			}
		})
	}
});
//动态
$('#addStep').click(function(){
	var thisStep = stepDom.clone();
	var length = $('.delete').length;
	$('#step').append(thisStep);
	$('.step').last().find('input').prop("name","Title["+length+"]");
	$('.step').last().find('select').prop("name","RoleID["+length+"]");
});
$('body').on("click",".delete",function(){
	var length = $('.delete').length; 
	var thisIndex = $(this).index($('.delete'));
	console.log(length);
	$('.step').eq(length-1).remove();
});