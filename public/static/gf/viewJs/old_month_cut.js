$('#cutOldButton').click(function(){
	layer.open({
		type:1,
		title:['缴纳欠租','color:#FFF;font-size:1.6rem;font-weight:600;'],
		zIndex: 100,
		area:['800px','600px'],
		content:$('#oldCutForm'),
		btn:['确认','取消'],
		success:function(){
			houseQuery.action('getInfo_1','1');
			$('#DQueryData').off('click');
			$('#DQueryData').on("click", function() {
                var HouseID = $('#getInfo_1').val();
                $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                    res = JSON.parse(res);
                    console.log(res);
                    layer.msg(res.msg);
                    $("#BanID").text(res.data.BanID);
                    $("#BanAddress").text(res.data.BanAddress);
                    $("#CreateTime").text(res.data.CreateTime);
                    $("#FloorID").text(res.data.FloorID);
                    $("#HouseArea").text(res.data.HouseUsearea);
                    $("#LeasedArea").text(res.data.LeasedArea);
                    $("#TenantName").text(res.data.TenantName);
                    $("#TenantNumber").text(res.data.TenantNumber);
                    $("#TenantTel").text(res.data.TenantTel);
                    $("#ArrearRent").text(res.data.ArrearRent);
                });
            });
            $('.debt_month').off('click');
            $('.debt_month').on('click',function(){
            	var classString = $(this).prop('class');
            	if(classString.indexOf('debt_month_active') > -1){
            		$(this).removeClass('debt_month_active');
            	}else{
            		$(this).addClass('debt_month_active');
            	}
            	// $('.debt_month').removeClass('debt_month_active');
            	// $(this).addClass('debt_month_active');
            })
		},
		yes:function(){
			var postData = {
				HouseID : $('#getInfo_1').val(),
				PayYear : $('#year').val(),
				PayRent : $('#oldDebt').val(),
				OldPayMonth:$('#oldRentMonth').val().replace('-','')
			};
			var monthString = [];
			for(var i = 0;i < $('.debt_month').length;i++){
				if($('.debt_month').eq(i).prop('class').indexOf('debt_month_active') > -1){
					monthString.push($('.debt_month').eq(i).val());
				}
			}
			postData.PayMonth = monthString.join(',');
			if(postData.HouseID == ''){
				layer.msg('请填入房间编号');
				return false;
			}
			if(postData.PayYear == ''){
				layer.msg('请填入欠租年份');
				return false;
			}
			// if(postData.PayMonth == ''){
			// 	layer.msg('请填入欠租月份');
			// 	return false;
			// }
			if(postData.PayRent == ''){
				layer.msg('请填入缴纳欠款');
				return false;
			}
			console.log(postData);
			$.post('/ph/OldCutRent/add',postData,function(res){
				res = JSON.parse(res);
				console.log(res);
				layer.msg(res.msg);
				if(res.retcode == '2000'){
					location.reload();
				}
			})
		}
	})
});
$('#cutdeleteOldButton').click(function(){
	var id = $(".radioclass").attr('checked','checked').val();
	console.log(id);
    if(id == null || id == ''){
        layer.msg('选择要删除的选项');
        return ;
    }
    var data = 'id='+id;
    layer.confirm('确定删除?',{icon: 2,skin:'lan_class'},function(){
        $.post('/ph/OldCutRent/delete', data, function(res){
            res = JSON.parse(res);
            console.log(res);
            if(res.data){
                layer.msg('删除成功!');
                $(location).attr('href', '');
            }
        })
    });
});
// 详情detial
$('.detailsBtn').click(function(){
	var HouseID = $(this).val();
	layer.open({
		type:1,
		title:['缴纳欠租','color:#FFF;font-size:1.6rem;font-weight:600;'],
		zIndex: 100,
		area:['800px','600px'],
		content:$('#DoldCutForm'),
		success:function(){
			$.get('/ph/OldMonthRent/detail/id/'+HouseID,function(res){
                res = JSON.parse(res);
                $('#DgetInfo_1').text(res.data.HouseID);
                $("#DBanID").text(res.data.houseDetail.BanID);
                $("#DBanAddress").text(res.data.houseDetail.BanAddress);
                $("#DCreateTime").text(res.data.houseDetail.CreateTime);
                $("#DFloorID").text(res.data.houseDetail.FloorID);
                $("#DHouseArea").text(res.data.houseDetail.HouseUsearea);
                $("#DLeasedArea").text(res.data.houseDetail.LeasedArea);
                $("#DTenantName").text(res.data.houseDetail.TenantName);
                $("#DTenantNumber").text(res.data.houseDetail.TenantNumber);
                $("#DTenantTel").text(res.data.houseDetail.TenantTel);
                $("#Dyear").text(res.data.PayYear+'年');
                $("#Dmonth").text(res.data.PayMonth);
                $("#DoldDebt").text(res.data.PayRent);
			});
		}
	})
})