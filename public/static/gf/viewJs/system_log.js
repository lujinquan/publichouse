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
			console.log(res);
			for(var x in res){
				for(var k in res[x]){
						console.log(res[x][k]);
						thtml += '<td>'+res[x][k]+'</td>';
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