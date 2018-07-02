$(".SystemDetailBtn").click(function(){
	var SystemID = $(this).val();
	console.log(SystemID);
	// require(["layer","jquery"],function(){
	// 	layer.config({
	// 		path:'/public/static/gf/layer/'
	// 	});
		$.get('/ph/Api/get_log_info?id='+SystemID,function(res){
			var thtml=''
			var thtml2='';
			
			res = JSON.parse(res);
			result = res['data'];
			console.log(result);
			for(var x in result){
				for(var k in result[x]){
						console.log(result[x][k]);
						thtml += '<td>'+result[x][k]+'</td>';
				}
				thtml2+='<tr class="am-form-group am-form-inline am-form">'+thtml+'</tr>';
					$('#tbo').html(thtml2);
					thtml='';
				
			}
			
			
			
			layer.open({
				type:1,
				area:['800px','600px'],
				resize:false,
				title:['日志明细','color:#FFF;font-size:1.6rem;font-weight:600;'],
				content:$('#SystemDetail')
			});
		})
	// })
});