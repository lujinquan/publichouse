// require.config({
//  baseUrl:"/public/static/gf/",
//  paths:{
//      "jquery":"js/jquery.min",
//      "layer":"layer/layer"
//  }
// });
//创建地图
//创建地图
var map = new BMap.Map("mapHouse");
map.centerAndZoom(new BMap.Point(114.334228, 30.560372), 15);
map.enableScrollWheelZoom(true);
/*房屋信息*/
/*房屋新增*/
$('.QBtn').click(function() {
    queryData.action2(1, 'DBanID');
})
$("#addHouse").click(function() {
    $("#InputForm input[type='text']").val("");
    // require(["layer","jquery"],function(layer){
    //  layer.config({  //真实layer的配置路径
    //      path:'/public/static/gf/layer/'
    //  });
    var imgUp = $('#imgUp');
    var imgShow = $('#imgShow');
    readFile(imgUp, imgShow);
    banQuery.action('DBanID','0,1');//楼栋查询器
    tenantQuery.action('aTenantID','','0,1');
    layer.open({
        type: 1,
        area: ['800px', '600px'],
        resize: false,
        zIndex: 100,
        title: ['添加房屋', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#houseForm'),
        btn: ['确定', '取消'],
        yes: function(thisIndex) {
            var data = new FormData($('#houseForm')[0]);
            // console.log(data);
            $.ajax({
                url: "/ph/HouseInfo/add",
                type: "post",
                data: data,
                dataType: 'JSON',
                processData: false,
                contentType: false
            }).done(function(result) {
                // console.log(result);
                if (result.retcode == 2000) {
                    // layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
                    //  layer.close(thisIndex);
                    //  layer.close(conIndex);
                    //  location.reload();
                    // });
                    layer.close(thisIndex);
                    layer.msg(result.msg,{time:4000});
                    location.reload();
                } else {
                    // layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
                    //  layer.close(conIndex);
                    //  location.reload();
                    // });
                    layer.msg(result.msg,{time:4000});
                }
            });
        },
			end:function(){
			location.reload();
		}
    });
    // })
});
/*修改房屋信息*/
$('.QBtn2').click(function() {
    queryData.action2(1, 'BanI');
})
$("#reviseHouse").click(function() {
    var obj = $('.checkId');

    var objLength = $('.checkId').length;
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].checked) {
            var HouseID = obj.eq(i).val();
        }
    }
    // console.log(HouseID);
    banQuery.action('BanI','0,1');
    //banQuery.action('BanI','2');
    tenantQuery.action('TenantI','','0,1');
    //var vanId = $('.checkId').eq(0).val();
    // require(["layer","jquery"],function(layer){
    //  layer.config({  //真实layer的配置路径
    //      path:'/public/static/gf/layer/'
    //  });
    if (HouseID == undefined) {
        layer.msg('请先选择要修改的信息',{time:4000});
    } else {
        $.get('/ph/HouseInfo/edit/HouseID/' + HouseID, function(res) {
            res = JSON.parse(res);
            // console.log(res);
            $("#mDHouseID").val(res.data.HouseID); //房屋编号
            $("#houseid").prop("value", res.data.HouseID); //隐藏域房屋编号
            $("#HouseI").prop("value", res.data.HouseID);
            $("#BanI").prop("value", res.data.BanID); //楼栋编号
            $('#UnitI').prop("value", res.data.UnitID); //单元号
            $('#FloorI').prop("value", res.data.FloorID); //楼层号
            $('#DoorI').prop("value", res.data.DoorID); //门牌号码
            $('#PumpCos').prop("value", res.data.PumpCost); //泵费
            $('#RepairCos').prop("value", res.data.RepairCost); //维修费
            $('#HouseBas').prop("value", res.data.HouseBase); //房屋基数
            $('#OldOpric').prop("value", res.data.OldOprice); //计算原价
            $('#Opric').prop("value", res.data.Oprice); //实际原价
            $('#TenantI').prop("value", res.data.TenantID); //租户ID
            $('#LeasedAre').prop("value", res.data.LeasedArea); //计租面积
            $('#HouseUseare').prop("value", res.data.HouseUsearea); //使用面积
            $('#MHousePrerent').prop("value", res.data.HousePrerent); //规定租金
            $('#ReceiveRen').prop("value", res.data.ReceiveRent); //应收租金
            $('#RemitRen').prop("value", res.data.RemitRent); //减免租金
            $('#ArrearRen').prop("value", res.data.ArrearRent); //欠租情况
            $('#ArrearrentReaso').prop("value", res.data.ArrearrentReason); //欠租情况
            $('#HouseAre').prop("value", res.data.HouseArea); //户建面
            $('#ComprisingAre').prop("value", res.data.ComprisingArea); //套内建面
            $('#DiffRen').prop("value", res.data.DiffRent); //租差
            $('#ProtocolRen').prop("value", res.data.ProtocolRent); //协议租金
            $("select[id='UseNature'] option[value='" + res.data.UseNature + "']").prop("selected", "selected"); //使用性质
            $("input[name='NonliveIf'][value='" + res.data.NonliveIf + "']").prop("checked", "checked"); //是否住改非
            $("input[name='IfLeft'][value='" + res.data.IfLeft + "']").prop("checked", "checked"); //是否自遗
            $("input[name='IfSuspend'][value='" + res.data.IfSuspend + "']").prop("checked", "checked"); //是否暂停计租
            $("input[name='HouseChangeStatus'][value='" + res.data.HouseChangeStatus + "']").prop("checked", "checked"); //是否房改
            $("#OwnerType").val(res.data.OwnerType); //产别
            $('#mApprovedRent').val(res.data.ApprovedRent);
            $("#mhall").val(res.data.Hall);
            $("#mtoilet").val(res.data.Toilet);
            $("#mkitchen").val(res.data.Kitchen);
            $("#mInnerAisle").val(res.data.InnerAisle);
            if (res.data.IfWater == '1') {
                $("#mIfWater").prop('checked', true);
            } else {
                $("#mIfWater").prop('checked', false);
            }
            $('#mwallcloth').val(res.data.WallpaperArea);
            $('#mFloorTile').val(res.data.CeramicTileArea);
            $('#mbathtub').val(res.data.BathtubNum);
            $('#mbasin').val(res.data.BasinNum);
            $('#mspace').val(res.data.BelowFiveNum);
            $('#mattic').val(res.data.MoreFiveNum);
            $('#imgChange').prop('src', res.data.HouseImageIDS.FileUrl);
            var imgReload = $('#imgReload');
            var imgChange = $('#imgChange');
            readFile(imgReload, imgChange);
            layer.open({
                type: 1,
                area: ['800px', '600px'],
                resize: false,
                zIndex: 100,
                title: ['修改房屋', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#houseModifyForm'),
                btn: ['确定', '取消'],
                yes: function(thisIndex) {
                    if ($("#mIfWater").prop('checked') == true) {
                        $("#mIfWater").val(1);
                    } else {
                        $("#mIfWater").val(0);
                    }
                    var data = new FormData($('#houseModifyForm')[0]);
                    data.append('IfWater', $("#mIfWater").val());
                    $.ajax({
                        url: "/ph/HouseInfo/edit",
                        type: "post",
                        data: data,
                        dataType: 'JSON',
                        processData: false,
                        contentType: false
                    }).done(function(result) {
                        // console.log(result);
                        if (result.retcode == 2000) {
                            // layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
                            //  layer.close(thisIndex);
                            //  layer.close(conIndex);
                            //  location.reload();
                            // });
                            layer.close(thisIndex);
                            layer.msg(result.msg,{time:4000});
                            location.reload();
                        } else {
                            // layer.confirm(result.msg,{title:'提示信息',icon:'1',skin:'lan_class'},function(conIndex){
                            //  layer.close(conIndex);
                            // });
                            layer.msg(result.msg,{time:4000});
                        }
                    });
                },
			end:function(){
				location.reload();
			}
            });
        })
    }
    // })
});
/*删除房屋信息*/
$("#deleteHouse").click(function() {
    var obj = $('.checkId');
    var objLength = $('.checkId').length;
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].checked) {
            var HouseID = obj.eq(i).val();
        }
    }
    // require(["layer","jquery"],function(){
    //  layer.config({
    //      path:'/public/static/gf/layer/',
    //      skin:'lan_class'
    //  });
    if (HouseID == undefined) {
        layer.msg('请先选择要修改的信息',{time:4000});
    } else {
        layer.open({
            type: 1,
            area: ['600px', '130px'],
            title: ['删除房屋', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
            content: $('#deleteChoose'),
        })
    }
    // })
});
$('#HouseChange,#HouseRemove,#DateTogther,#DateLose').click(function() {
    var obj = $('.checkId');
    var objLength = $('.checkId').length;
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].checked) {
            var HouseID = obj.eq(i).val();
        }
    }
    var oV = $(this).val();
    layer.confirm('确定房屋删除信息', {
        title: '提示信息',
        icon: '2',
        skin: 'lan_class'
    }, function(index) {
        $.get('/ph/HouseInfo/delete/HouseID/' + HouseID + '/style/' + oV, function(result) {
            result = JSON.parse(result);
            // console.log(result);
            if (result.retcode == '2000') {
                layer.msg(result.msg,{time:4000});
                location.reload();
            } else {
                layer.msg(result.msg,{time:4000});
            }
        })
    })
})
$(".ConfirmHouseBtn").click(function() {
    var houseID = $(this).val();
    layer.confirm('请确认此房屋信息无误', {
        title: '提示信息',
        icon: '1',
        skin: 'lan_class'
    }, function(index) {
        $.get('/ph/HouseInfo/confirm/HouseID/' + houseID, function(result) {
            result = JSON.parse(result);
            if (result.retcode == '2000') {
                layer.msg(result.msg,{time:4000});
                location.reload();
            } else {
                layer.msg(result.msg,{time:4000});
            }
        });
    });
});
// $("#houseOut").click(function(){
//  $.get('/ph/HouseInfo/out',function(res){
//      console.log(res);
//  });
// });
/*房屋明细*/
$(".HouseDetailBtn").click(function() {
    $('#Drecord').html('');
    var HouseID = $(this).val();
    // console.log(HouseID);
    // require(["layer","jquery"],function(){
    //  layer.config({
    //      path:'/public/static/gf/layer/'
    //  });
    $.get('/ph/HouseInfo/detail/HouseID/' + HouseID, function(res) {
        res = JSON.parse(res);
        // console.log(res);
        $('p[id=HouseID]').text(res.data.HouseID); //房屋编号
        $('p[id=BanID]').text(res.data.BanID); //楼栋编号
        $('p[id=InstitutionID]').text(res.data.InstitutionID); //机构
        $('p[id=UnitID]').text(res.data.UnitID); //单元号
        $('p[id=FloorID]').text(res.data.FloorID); //楼层号
        $('p[id=HousePID]').text(res.data.HousePID); //产权证号
        $('p[id=DoorID]').text(res.data.DoorID); //门牌号
        $('p[id=HouseUsearea]').text(res.data.HouseUsearea); //使用面积
        $('p[id=NonliveIf]').text(res.data.NonliveIf); //是否住改非
        $('p[id=LeasedArea]').text(res.data.LeasedArea); //计租面积
        $('#HousePrerent').text(res.data.HousePrerent); //规定租金
        $('p[id=ReceiveRent]').text(res.data.ReceiveRent); //应收租金
        $('p[id=RemitRent]').text(res.data.RemitRent); //减免租金
        $('p[id=UseNature]').text(res.data.UseNature); //使用性质
        $('p[id=PumpCost]').text(res.data.PumpCost); //泵费
        $('p[id=RepairCost]').text(res.data.RepairCost); //维修费
        $('p[id=HouseBase]').text(res.data.HouseBase); //房屋基数
        $('p[id=OldOprice]').text(res.data.OldOprice); //计算原价
        $('p[id=Oprice]').text(res.data.Oprice); //实际原价
        $('p[id=TenantID]').text(res.data.TenantID); //租户姓名
        $('p[id=ArrearRent]').text(res.data.ArrearRent); //欠租情况
        $('p[id=ArrearrentReason]').text(res.data.ArrearrentReason); //欠租原因
        $('p[id=HouseArea]').text(res.data.HouseArea); //户建面积
        $('p[id=ComprisingArea]').text(res.data.ComprisingArea); //套内建面
        $('#ComprisingImg').attr('src', res.data.HouseImageIDS); //图片影像
        // $('.Countnumber').text(res.data.BanID);//楼栋编号    
        $('#Countprice').text(res.data.PumpCost); //泵费  
        $('#Countchat').text(res.data.RegulationRate); //层次调解率
        $('#Countcut').text(res.data.RemitRent); //减免租金
        $('#Commonliving').text(res.data.Hall); //厅堂
        $('#Commonwc').text(res.data.Toilet); //卫生间
        $('#Commonkit').text(res.data.Kitchen); //厨房
        $('#Commonway').text(res.data.InnerAisle); //内走道
        $('#Countrepaire').text(res.data.RepairCost); //维修费
        $('#IfWater').text(res.data.IfWater);
        $('#IfElevator').text(res.data.IfElevator);
        $('#IfFirst').text(res.data.IfElevator);
        $('#DMoreFiveNum').text(res.data.MoreFiveNum);
        $('#DBelowFiveNum').text(res.data.BelowFiveNum);
        $('#DBasinNum').text(res.data.BasinNum);
        $('#DBathtubNum').text(res.data.BathtubNum);
        $('#DCeramicTileArea').text(res.data.CeramicTileArea);
        $('#DWallpaperArea').text(res.data.WallpaperArea);
        var htmlC = '';
        var htmlC1 = '';
        if (res.data.RoomDetail == undefined || res.data.RoomDetail == '') {
            res.data.RoomDetail = '';
        } else {
            for (var i = 0; i < res.data.RoomDetail.length; i++) {
                var aRoom1 = res.data.RoomDetail[i][0];
                var aRoom2 = res.data.RoomDetail[i][1];
                htmlC += "<div class='am-u-md-12' style='border-bottom:1px solid black'>" + "<div class='am-u-md-6'>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>楼栋编号：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom1[0] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>楼栋地址：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber' style='height:64px;'>" + aRoom1[4] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>单元：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom1[1] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>楼层号：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom1[2] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>共用情况：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom1[3] + "</p>" + "</div>" + "</div>" + "</div>" + "<div class='am-u-md-6'>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>房间编号:</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<a style='cursor: pointer;' href='/ph/Room/index.html?RoomID=" + aRoom2[0] + "'><p class='detail_p_style Countnumber'>" + aRoom2[0] + "</p></a>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>房间间号:</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style RoomNumber'>" + aRoom2[4] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>房间类型：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom2[1] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12'>" + "<label for='doc-select-8' class='label_style'>使用面积：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom2[2] + "</p>" + "</div>" + "</div>" + "<div class='am-form-group am-u-md-12' >" + "<label for='doc-select-8' class='label_style' style='margin-bottom: 32px;'>计租面积：</label>" + "<div class='am-u-md-8' style='float:left;'>" + "<p class='detail_p_style Countnumber'>" + aRoom2[3] + "</p>" + "</div>" + "</div>" + "</div>" + "</div>";
                $('.add_1').html(htmlC);
                // $('.add_2').html(htmlC1);
            }
        }
        var Bans = res.data.bans;
        var BansHtml = '';
		$('#j-storied').html();
        if (Bans && Bans.length != 0) {
            for (var i = 0; i < Bans.length; i++) {          
                BansHtml += '<li><span class="j-size">'+Bans[i].AreaFour+'</span><span>'+Bans[i].BanID+'</span></li>'; 
            }
            $('#j-storied').html(BansHtml);
            BansHtml = '';
        }

        var ARecord = res.data.change_record;
        var aHtml = '';
        if (ARecord && ARecord.length != 0) {
            for (var i = 0; i < ARecord.length; i++) {
                for (var j = 0; j < 4; j++) {
                    aHtml = ARecord[i][1] + '完成' + '<a href="/ph/ChangeRecord/index?ChangeOrderID=' + ARecord[i][0] + '" class="am-text-secondary" target="_blank">' + ARecord[i][2] + '</a>' + '异动，申请机构' + ARecord[i][3];
                }
                $('#Drecord').append("<li>" + aHtml + "</li>");
                aHtml = '';
            }
        }
        if (res.data.IfWater) {
            $('#Water').attr('checked', true);
        } else {
            $('#Water').attr('checked', false); //水
        }
        if (res.data.IfEmpty) {
            $('#ifempty').attr('checked', true);
        } else {
            $('#ifempty').attr('checked', false); //空房
        }
        //          $('#Countrepaire').text(res.data.RepairCost);//居住第一层
        $('p[id=xy]').text(res.data.BanGpsX + ',' + res.data.BanGpsY); //套内建面
        var pointer = new BMap.Point(res.data.BanGpsX, res.data.BanGpsY);
        map.setCenter(pointer);
        map.panBy(190, 110);
        //ModifyMap.panTo(pointer);
        var marker = new BMap.Marker(pointer);
        map.addOverlay(marker);
        map.addEventListener("click", function(e) {
            var lng = e.point.lng;
            var lat = e.point.lat;
            $('#xy').val(lng + ' , ' + lat);
            map.clearOverlays();
            marker = new BMap.Marker(new BMap.Point(lng, lat));
            map.addOverlay(marker);
        });
        layer.open({
            type: 1,
            area: ['1000px', '600px'],
            resize: false,
            title: ['房屋明细', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
            content: $('#houseDetail')
        });
    })
    // })
});

// 修改加计租金里面的8户以上共用
$('#jiaji').on('change',function(){
    var jiaji = $('#jiaji').val();
    var houseid = $('#house_id').val();
    $.get('/ph/HouseInfo/jiaji/jiaji/'+jiaji+'/houseid/'+houseid,function(res){
        res = JSON.parse(res);
        console.log(res);
        if(res.retcode == 2000){
            layer.msg(res.msg,{time:4000});
        }
    });
});
$('.j-upload').on('mouseover','.j-upload-img',function(){
            $(this).find(".img_close").removeClass('j-hide');
        });	
   $('.j-upload').on('mouseleave','.j-upload-img',function(){
        $(this).find(".img_close").addClass('j-hide');
    });
	//删除图片
	$('.j-upload').on('click','.img_close',function(){
		/* $(this).prev().hide(); */
		$(this).prev().attr("src","/public/static/gf/icons/noimg.png");;
		var obj = $(this).parents(".am-u-md-12").find("input");
		obj.val("")
	})
/* 	$('.j-upload').on('click','.am-field-valid',function(){
	       $(this).parents(".am-u-md-12").find(".j-upload-img img").show();
	}) */
function readFile(fileUp, fileShow) {
    if (typeof FileReader === 'undefined') {
        fileShow.text('浏览器不支持！');
    } else {
        fileUp.on('change', function() {
            var file = this.files[0];
            if (!/image\/\w+/.test(file.type)) {
                layer.msg('文件必须是图片！',{time:4000});
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                fileShow.attr('src', this.result);
            }
        })
    }
}
//计租表
var RlengthBan = 0;
$('.RentForm').click(function() {
    $('.RentExample:gt(0)').remove();
    // if($('ul').hasClass('RentDate')){
    //  var RentHtml='';
    // $('.RentDate').innerHTML(RentHtml);
    // }
    var HouseID = $(this).val();
    $.get('/ph/Api/get_rent_table_detail/HouseID/' + HouseID, function(res) {
        res = JSON.parse(res);
        // console.log(res);
        $('.RentBan').text(res.data.banDetail.BanID);
        $('#house_id').val(res.data.houseDetail.HouseID);
        $('.RentStructure').text(res.data.banDetail.StructureType);
        $('.RentAddress').text(res.data.banDetail.BanAddress);
        $('.RentPoint').text(res.data.banDetail.NewPoint);
        $('.RentName').text(res.data.houseDetail.TenantName);
        $('.RentLayer').text(res.data.houseDetail.FloorID);
        // $('.RentUnit').text(res.data.houseDetail.UnitID);
        $('.BanFloorNum').text(res.data.banDetail.BanFloorNum);
        $('.RentComprising').text(res.data.houseDetail.ComprisingArea);
        $('.RentWallpaper').text(res.data.houseDetail.WallpaperArea);
        $('.RentCeramic').text(res.data.houseDetail.CeramicTileArea);
        $('.RentBath').text(res.data.houseDetail.BathtubNum);
        $('.RentBasin').text(res.data.houseDetail.BasinNum);
        $('.RentBelow').text(res.data.houseDetail.BelowFiveNum);
        $('.RentMore').text(res.data.houseDetail.MoreFiveNum);
        $('.RentApproved').text(res.data.houseDetail.ApprovedRent);
        $('.RentRemit').text(res.data.houseDetail.RemitRent);
        $('.RentPump').text(res.data.houseDetail.PumpCost);
        $('.RentReceive').text(res.data.houseDetail.RentMonth);
        $('.RentHouseArea').text(res.data.houseDetail.HouseUsearea);
        $('.diffRent').text(res.data.houseDetail.DiffRent);
        $('.agreementRent').text(res.data.houseDetail.ProtocolRent);
        $('.RentLeased').text(res.data.houseDetail.LeasedArea);
        $('.RentEle').text(res.data.houseDetail.IfElevatorName);
        $('.OweLink').prop('href', "/ph/RentUnpaid/index?HouseID=" + HouseID);
        if (res.data.houseDetail.IfWater == 0) {
            $('.RentW').prop({
                checked: false
            });
        } else {
            $('.RentW').prop({
                checked: true
            });
        }
        // if (res.data.houseDetail.IfElevator == 0) {
        //     $('.RentS').prop({
        //         checked: false
        //     });
        // } else {
        //     $('.RentS').prop({
        //         checked: true
        //     });
        // }
        if (res.data.houseDetail.IfFirst  == 0) {
            $('.RentE').prop({
                checked: false
            });
        } else {
            $('.RentE').prop({
                checked: true
            });
        }
        //产别
        var OwnTypes = res.data.houseDetail.OwnerTypes;
        $('.RentType').eq(0).text(OwnTypes[0].OwnerType);
        $('.RentPrice').eq(0).text(OwnTypes[0].HousePrerent);
        if (OwnTypes[1].OwnerType == 0) {
            $('.RentType').eq(1).text('无');
            $('.RentPrice').eq(1).text('无');
        } else {
            $('.RentType').eq(1).text(OwnTypes[1].OwnerType);
            $('.RentPrice').eq(1).text(OwnTypes[1].HousePrerent);
        }
        //房间信息
        var RentRoom = res.data.roomDetail;
        var RentA = [];
        for (var i in RentRoom) {
            RentA.push(i);
        }
        var RentHtml = '';
        var time = 0;
        for (var a = 0; a < RentA.length; a++) {
            var num = RentA[a];
            $('.addPrice').before($(".RentExample").eq(0).clone(true));
            $(".RentExample").eq(a + 1).css('display', 'block');
            $(".RentRoomName").eq(a + 1).text(RentRoom[num][0].RoomName);
            for (var j = 0; j < RentRoom[num].length; j++) {
                var aH = res.data.roomDetail[num][j].HouseID.split(',');
                var Shtml = '';
                for (var h = 0; h < aH.length; h++) {
                    if (aH.length == 1) {
                        Shtml = '';
                        Shtml += '<option>' + aH[0] + '</option>';
                    } else {
                        Shtml += '<option>' + aH[h] + '</option>';
                    }
                }
                RentHtml += '<ul class="am-u-md-12 house_style RentDate ul-mr"><li style="width:9%" class="RentID">' + res.data.roomDetail[num][j].RoomID + '</li>' + '<li style="width:5%" class="RentNum">' + res.data.roomDetail[num][j].RoomNumber + '</li>' + '<li style="width:9%" class="RentBanA">' + res.data.roomDetail[num][j].BanID + '</li>' + '<li style="width:5%" class="RentPublic">' + res.data.roomDetail[num][j].RoomPublicStatus + '</li>' + '<li style="width:9%" class="RentHouse">' + aH[0] + '</li>' +'<li style="width:6%" class="RentPro">' + res.data.roomDetail[num][j].OwnerType + '</li>'+'<li style="width:6%" class="RentU">' + res.data.roomDetail[num][j].UnitID + '</li>' + '<li style="width:6%" class="RentL">' + res.data.roomDetail[num][j].FloorID + '</li>' + '<li style="width:7%" class="RentArea">' + res.data.roomDetail[num][j].UseArea + '</li>' + '<li style="width:7%" class="RentCut">' + res.data.roomDetail[num][j].RentPoint + '</li>' + '<li style="width:6%" class="RentLeasedArea">' + res.data.roomDetail[num][j].LeasedArea + '</li>' + '<li style="width:7%" class="RentChat">' + res.data.roomDetail[num][j].FloorPoint + '</li>'
                + '<li style="width:4%" class="RentMp">' + res.data.roomDetail[num][j].RoomPrerent + '</li>' + '<li style="width:5%" class="RentMp">' + res.data.roomDetail[num][j].RoomRentMonth + '</li>'+'<li style="width:4%" class="RentStatus">' + res.data.roomDetail[num][j].Status + '</li></ul>';
                $('.RoomDeT').eq(j).css('display', 'block');
                $('.RoomDeT').eq(j).parent().children().eq(0).removeClass('nomal').addClass('active');
                $('.pull').eq(j).prop('src', '/public/static/gf/icons/triU.png');
            } //小长度             
            $('.RentTit').eq(a + 1).after(RentHtml);
            RentHtml = '';
            $('.RoomDeT').eq(1).css('display', 'block');
            $('.RoomDeT').eq(1).parent().children().eq(0).removeClass('nomal').addClass('active');
            $('.pull').eq(1).prop('src', '/public/static/gf/icons/triU.png');
            //$('.RoomDeT').eq(1).previousSibling().removeClass('nomal').addClass('active');
        } //大长度
    })
    layer.open({
        type: 1,
        skin: 'yue-class',
        area: ['1300px', '700px'],
        zIndex: 1000,
        resize: false,
        title: ['计租表', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
        btn: ['打印','修改', '取消'],
        content: $('#RentForm'),
        yes: function(){
        	
        		$('.layui-layer-btn0').prop({'href':'/ph/HouseInfo/pdf/HouseID/'+HouseID,'target':'_blank'});
        	
        },
        btn2:function(thisIndex) {
            layer.close(thisIndex);
            $.get('/ph/Api/get_edit_rent_table_detail/HouseID/' + HouseID, function(res) {
                res = JSON.parse(res);
                // console.log(res);
                $('.ModifyDetail:gt(0)').remove();
                 var HouseID= res.data.houseDetail.HouseID;
                $('.RentWallpaperd').prop('value', res.data.houseDetail.WallpaperArea);
                $('.RentCeramicd').prop('value', res.data.houseDetail.CeramicTileArea);
                $('.RentBathd').prop('value', res.data.houseDetail.BathtubNum);
                $('.RentBasind').prop('value', res.data.houseDetail.BasinNum);
                $('.RentBelowd').prop('value', res.data.houseDetail.BelowFiveNum);
                $('.RentMored').prop('value', res.data.houseDetail.MoreFiveNum);
                $('.RentPumpd').prop('value', res.data.houseDetail.PumpCost);
                var OwnerTypes=res.data.houseDetail.OwnerTypes;
                $('.RentPriced').eq(0).prop('value', OwnerTypes[0].HousePrerent);
                $('.RentPriced').eq(1).prop('value', OwnerTypes[1].HousePrerent);
                if(res.data.houseDetail.AnathorOwnerType==0){
                    $('.ROwnerTypeS').eq(0).prop('value', 0);
                }else{
                      $('.ROwnerTypeS').eq(0).prop('value', res.data.houseDetail.AnathorOwnerType);
                }
                $('.ROwnerTypeF').eq(0).prop('value',res.data.houseDetail.OwnerType);
              
                $('.diffRentd').val(res.data.houseDetail.DiffRent);
                $('.agreementRentd').val(res.data.houseDetail.ProtocolRent);
                if (res.data.houseDetail.IfWater == 0) {
                    $('.RentWd').prop({
                        checked: false
                    });
                    $('.RentWd').prop('value', '0');
                } else {
                    $('.RentWd').prop({
                        checked: true
                    });
                    $('.RentWd').prop('value', '1');
                }
                if (res.data.houseDetail.IfElevator == 0) {
                    $('.RentSd').prop({
                        checked: false
                    });
                    $('.RentSd').prop('value', '0');
                } else {
                    $('.RentSd').prop({
                        checked: true
                    });
                    $('.RentSd').prop('value', '1');
                }
                if (res.data.houseDetail.IfFirst == 0) {
                    $('.RentEd').prop({
                        checked: false
                    });
                    $('.RentEd').prop('value', '0');
                } else {
                    $('.RentEd').prop({
                        checked: true
                    });
                    $('.RentEd').prop('value', '1');
                }
                $('.RentWd').click(function() {
                    if ($('.RentWd').is(':checked')) {
                        $(this).prop('value', '1');
                    } else {
                        $(this).prop('value', '0');
                    }
                });
                $('.RentSd').click(function() {
                    if ($('.RentSd').is(':checked')) {
                        $(this).prop('value', '1');
                    } else {
                        $(this).prop('value', '0');
                    }
                });
                $('.RentEd').click(function() {
                    if ($('.RentEd').is(':checked')) {
                        $(this).prop('value', '1');
                    } else {
                        $(this).prop('value', '0');
                    }
                });
                var Atypes = res.data.roomTypes;
                $('.RoomDeTd').css('display', 'none');
                for (var m = 0; m < 12; m++) {
                    $('.addP').before($(".ModifyDetail").eq(0).clone(true));
                    $(".ModifyDetail").eq(m + 1).css('display', 'block');
                    $('.Mrname').eq(m + 1).text(Atypes[m + 1]);
                    $(".ModifyDetail").eq(m + 1).addClass('' + m);
                }
                var RentRoom = res.data.roomDetail;
                var RentA = [];
                for (var i in RentRoom) {
                    RentA.push(i);
                }
                var RentHtml2 = '';
                var aStatus = [];
                var aOwnT=[];
                for (var a = 0; a < RentA.length; a++) {
                    var num = RentA[a];
                    
                    for (var j = 0; j < RentRoom[num].length; j++) {
                        var sRoom = res.data.roomDetail[num][j].HouseID.split(',');
                        aStatus.push(res.data.roomDetail[num][j].Status);
                        var sRoomD = [];
                        for (var s = 0; s < 5; s++) {
                            if (sRoom[s] == undefined) {
                                sRoom[s] = '';
                            }
                        }
                        var Shtml = '';
                        var p = 0;
                        var RentPointNum = 1 - parseInt(res.data.roomDetail[num][j].RentPoint) / 100;
                        RentPointNum = parseFloat(RentPointNum.toFixed(2));
                        if (RentPointNum == 0) {
                            RentPointNum = 1;
                        }
                        RentHtml2 += '<ul class="am-u-md-12 house_style exRoom ul-mr" style="height:35px;">' + '<li style="width:5%;height:35px"><input type="text" class="RoomStyle fontS1" readonly="readonly" name="MRoomID" value=' + res.data.roomDetail[num][j].RoomID + '></li>' + '<li style="width:3%" class="m5"><input type="text" class="fontS1" name="MRoomNumber" value=' + res.data.roomDetail[num][j].RoomNumber + '></li>' + '<li style="width:6%" class="m5"><input type="text"  name="MBanID" class="QueryBanID fontS1" value=' + res.data.roomDetail[num][j].BanID + '></li>' + '<li style="width:8%" class="m5"><input type="text"  name="MHouse1" class="QueryHouse fontS1" value=' + sRoom[0] + '></li>' + '<li style="width:7%" class="m5"><input type="text"  name="MHouse2" class="QueryHouse fontS1" value=' + sRoom[1] + '></li>' + '<li style="width:7%" class="m5"><input type="text"  name="MHouse3" class="QueryHouse fontS1" value=' + sRoom[2] + '></li>' +'<li style="width:7%" class="m5"><input type="text"  name="MHouse3" class="QueryHouse fontS1" value=' + sRoom[3] + '></li>'+ '<li style="width:7%" class="m5"><input type="text"  name="MHouse3" class="QueryHouse fontS1" value=' + sRoom[4] + '></li>'+'<li style="width:4%" class="m5"><select class="fontS1 MownT" name="MownT"><option class="fontS1" value="1">市属</option><option class="fontS1" value="2">区属</option><option class="fontS1" value="3">代管</option><option class="fontS1" value="5">自管</option><option class="fontS1" value="6">生活</option><option class="fontS1" value="7">托管</option></select></li>'+'<li style="width:3%" class="m5"><input type="text" class="fontS1"  name="MUnitID" value=' + res.data.roomDetail[num][j].UnitID + '></li>' + '<li style="width:3%" class="m5"><input type="text" class="fontS1"  name="MFloorID" value=' + res.data.roomDetail[num][j].FloorID + '></li>' + '<li style="width:4%" class="m5"><input type="text" name="MUseArea" class="fontS1" value=' + res.data.roomDetail[num][j].UseArea + '></li>' + '<li style="width:4%" class="m5"><input type="hidden"  value=' + RentPointNum + '><input type="text" readonly="readonly"  class="QueryCut fontS1" value=' + res.data.roomDetail[num][j].RentPoint + '></li>' + '<li style="width:4%;height:35px">' + res.data.roomDetail[num][j].LeasedArea + '</li>' + '<li style="width:6%;height:35px">' + res.data.roomDetail[num][j].FloorPoint + '</li>'
                            +'<li style="width:4%;height:35px"><input type="text" class="fontS1" value=' + res.data.roomDetail[num][j].RoomPrerent + '></li>'
                            +'<li style="width:5%;height:35px">' + res.data.roomDetail[num][j].RoomRentMonth + '</li>'
                            +'<li style="width:3%" class="delSD"><input type="hidden" class="pStatus" value="0"><img src="/public/static/gf/icons/del.png" class="del-style"></li>' + '</ul>';
                        $('.RoomDeTd').eq(num).css('display', 'block');
                        $('.RoomDeTd').eq(num).parent().children().eq(0).removeClass('nomal').addClass('active');
                        $('.pulld').eq(num).prop('src', '/public/static/gf/icons/triU.png');
                        aOwnT.push(res.data.roomDetail[num][j].OwnerType);
                    } //小长度 
                    // for(var n=0;n<10;n++){
                        // for (var a = 0; a < RentA.length; a++) {
                        //         var num = RentA[a];
                        //         console.log(num);
                        //        $('.ModifyDetail').eq(num-1).children().eq(0).removeClass('nomal').addClass('active');
                        //         $('.ModifyDetail').eq(num-1).children().eq(1).css('display','block');
                        //     }
                    // }
                               
                    $('.Mnum').eq(num).css('display', 'block');
                    $('.addRoom').eq(num).parent().before(RentHtml2);
                    //$("#MownT option[value='"+res.data.roomDetail[num][j].OwnerType+"']").attr("select","selected"); 
                    RentHtml2 = '';
                    $('.RoomStyle').click(function() {
                        $(this).removeClass('am-field-valid');
                    });
                    $('.RoomStyle').focus(function() {
                        $(this).removeClass('am-field-valid');
                    });
                    // 
                } //大长度
                var aS = $('.delSD').length;
               
                for(var i=0;i<$(".MownT").length;i++){
                    $(".MownT").eq(i).val(aOwnT[i]).attr('select','selected');

                    // console.log($(".MownT").eq(i).find('option'));
                }
                for (var n = 0; n < aS; n++) {
                    $('.delSD').eq(n).attr('index', n);
                }
    
                $('.delSD').click(function() {
                    var RoomV = '';
                    var Child = $(this).children();
                    var _this = $(this).attr('index');
                    //if (Child.eq(1).hasClass('del-style') && aStatus[_this - 1] != 0) {
                       // Child.eq(1).replaceWith('<div class="am-text-secondary cur">取消</div>');
                       // Child.eq(0).prop('value', 1);
                   // } else if (Child.eq(1).hasClass('del-style') && aStatus[_this - 1] == 0) {
                        RoomV = $(this).parent().children().eq(0).find('input').prop('value');
                        var RoomIndex = $(this).parent().index('.exRoom');
                        
                        $('#PriceForm table').eq(RoomIndex - 1).remove();
                        $(this).parent().remove();
                  //  } else {
                        //Child.eq(1).replaceWith('<img src="/public/static/gf/icons/del.png" class="del-style">');
                       // Child.eq(0).prop('value', 0);
                   // }
                    $('#aSumRoom').append($('.deleteRoom').eq(0).clone().attr('value', RoomV));
                });
                for (var n = 0; n < $('.QueryBanID').length; n++) {
                    banQuery.actionA('QueryBanID','','0,1',n);
                }
                for (var n = 0; n < $('.QueryHouse').length; n++) {
                    houseQuery.actionA('QueryHouse','','0,1',n);
                }
                var Aname = [];
                for (var l = 0; l < 12; l++) {
                    $("." + l + " li input:first-child").attr('name', 'RoomType[' + l + '][]');
                    $("." + l + " li select").attr('name', 'RoomType[' + l + '][]');
                }
                for (var n = 0; n < $('.QueryCut').length - 1; n++) {
                    $('#PriceForm').append($('.PriceBoxNum').eq(0).clone(true));
                }
                 var RentIDS = [];
                    var BoxLength = $(".PriceBoxNum").eq(0).find('input').length;
                    for (var j = 0; j < RentA.length; j++) {
                        var num = RentA[j];
                        for (var a = 0; a < res.data.roomDetail[num].length; a++) {
                            var name = res.data.roomDetail[num][a].RoomID;
                            var IDS = res.data.roomDetail[num][a].RentPointIDS.split(',');
                            IDS.push(name);
                            RentIDS.push(IDS);
                        }
                    }
               
                for (var a = 0; a < RentIDS.length; a++) {
                        for (var b = 0; b < RentIDS[a].length; b++) {
                            
                            if ($('.exRoom').eq(a+1).children().eq(0).find('input').prop('value') == RentIDS[a][RentIDS[a].length - 1]) {
                                for (var j = 0; j < BoxLength; j++) {
                                	
                                    if ($(".PriceBoxNum").eq(a+1).find("input[name='PriceBox']").eq(j).prop('value') == RentIDS[a][b-1]) {
                                        $(".PriceBoxNum").eq(a+1).find("input[name='PriceBox']").eq(j).prop('checked', true);
                                    }
                                }
                            }
                        }
                    }
                    
                $(document).on('click', '.QueryCut', function() {
                    
                    var _self = $(this);
                    var bIndex = $(this).index('.QueryCut');
                    
                    //var RentIDS = [];
                    var BoxLength = $(".PriceBoxNum").eq(bIndex).find('input').length;
                    
                   
                    for (var b = 0; b < $('.QueryCut').length - 1; b++) {
                        $('.PriceBoxNum').hide();
                    }
                    //for (var a = 0; a < RentIDS.length; a++) {
                        //for (var b = 0; b < RentIDS[a].length; b++) {
                            //if ($('.exRoom').eq(bIndex).children().eq(0).find('input').prop('value') == RentIDS[a][RentIDS[a].length - 1]) {
                                //for (var j = 0; j < BoxLength; j++) {
                                   // if ($(".PriceBoxNum").eq(bIndex).find("input[name='PriceBox']").eq(j).prop('value') == RentIDS[a][b]) {
                                       // $(".PriceBoxNum").eq(bIndex).find("input[name='PriceBox']").eq(j).prop('checked', true);
                                    //}
                               // }
                          //  }
                       // }
                   // }
                    $('.PriceBoxNum').eq(bIndex).show();
                    layer.open({
                        type: 1,
                        area: ['600px', '500px'],
                        resize: false,
                        zIndex: 100,
                        title: ['基价折减', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
                        content: $('#PriceForm'),
                        btn: ['确定', '取消'],
                        yes: function(child) {
                            BoxLength = $(".PriceBoxNum").eq(bIndex).find('input').length;
                            var value = 0;
                            for (var j = 0; j < BoxLength; j++) {
                                if ($(".PriceBoxNum").eq(bIndex).find("input[name='PriceBox']").eq(j).prop('checked') === true) {
                                    value += parseInt($(".PriceBoxNum").eq(bIndex).find('.PriceValue').eq(j).text());
                                    //TempData.push($(".PriceBoxNum").eq(bIndex-1).find("input[name='PriceBox']").eq(j).val());
                                }
                                _self.prop('value', value + "%");
                                var right = parseFloat((1 - parseInt(_self.val()) / 100).toFixed(2))
                                if (right == 0) {
                                    right = 1;
                                };
                                _self.prev().val(right);
                            }
                            layer.close(child);
                        }
                    });
                });
                for (var n = 1; n < $('.exRoom').length; n++) {
                    if (aStatus[n - 1] == '3') {
                      
                        $('.exRoom').eq(n).find('input').prop('readonly', 'readonly').css('backgroundColor', '#e1e1e1').unbind('dblclick');
                        $('.exRoom').eq(n).children().eq(9).children().eq(1).prop('disabled', true);
                    }
                }
				$(".ModifyDetail.11 .exRoom").each(function(){
				  $(this).find('li:gt(1):lt(12) .fontS1').attr('readonly','readonly').unbind("dblclick").css('background-color','#f6f6f6');
				  $(this).find('li:gt(1):lt(12) .fontS1').removeClass("QueryCut");
				});
            });
            layer.open({
                type: 1,
                area: ['1500px', '800px'],
                resize: false,
                zIndex: 77,
                title: ['计租表修改', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
                btn: ['保存', '取消'],
                content: $('#RentFormM'),
                yes: function() {
                    var data = new FormData($('#RentFormM')[0]);
                    data.append('AddRent[RIfWater]', $(".RentWd").val());
                    data.append('AddRent[HouseID]', HouseID);
                    //     for(var n=1;n<$('.exRoom').length;n++){
                    //     if(aStatus[n-1]=='3'){
                    //         $('.exRoom').eq(n).children().eq(9).children().eq(1).prop('disabled',false);
                    //     }
                    // }
                    for (var i = 1; i < $('.PriceBoxNum').length; i++) {
                        var arr = [];
                        for (var j = 0; j < $(".PriceBoxNum").eq(i).find('input').length; j++) {
                            if ($(".PriceBoxNum").eq(i).find("input[name='PriceBox']").eq(j).prop('checked') === true) {
                                arr.push($(".PriceBoxNum").eq(i).find("input[name='PriceBox']").eq(j).val());
                            }
                        }
                        data.append('PriceBox' + i, arr);
                    }
                    $.ajax({
                        url: "/ph/HouseInfo/renttable",
                        type: "post",
                        data: data,
                        dataType: 'JSON',
                        processData: false,
                        contentType: false
                    }).done(function(result) {
                        if (result.retcode == 2000) {
                            layer.msg(result.msg,{time:4000});
                            location.reload();
                        } else {
                            layer.msg(result.msg,{time:4000});
                        }
                    });
					
                }, //保存提交
                end: function() {
                    layer.close(thisIndex);
                    location.reload();
                }
            })
        },//xiugai
        end: function() {
            //location.reload();
        }
    });
});
var aImg = $('.pull');
var aImg2 = $('.pulld');
$('.RoomDeT').css('display', 'none');
for (var p = 0; p < aImg.length; p++) {
    $('.titRD').eq(p).click(function() {
        var aSrc = $(this).find('img').prop('src').split('/');
        if (aSrc[aSrc.length - 1] == 'NtriD.png') {
            $(this).next().show();
            $(this).find('img').prop('src', '/public/static/gf/icons/triU.png');
            $(this).removeClass('nomal').addClass('active');
        } else {
            $(this).next().hide();
            $(this).find('img').prop('src', '/public/static/gf/icons/NtriD.png');
            $(this).removeClass('active').addClass('nomal');
        }
    });
}
for (var p = 0; p < aImg2.length; p++) {
    $('.titR').eq(p).click(function() {
        var aSrc = $(this).find('img').prop('src').split('/');
        if (aSrc[aSrc.length - 1] == 'NtriD.png') {
            $(this).next().show();
            $(this).find('img').prop('src', '/public/static/gf/icons/triU.png');
            $(this).removeClass('nomal').addClass('active');
        } else {
            $(this).next().hide();
            $(this).find('img').prop('src', '/public/static/gf/icons/NtriD.png');
            $(this).removeClass('active').addClass('nomal');
        }
    });
}
//增加点击
$(document).on('click', '.addRoom', function() {
    $('.QueryCut').blur();
    $(this).parent().siblings().css('display', 'block');
    $(this).parent().before($(".exRoom").eq(0).clone());
    $(this).parent().parent().find('.exRoom').css('display', 'block');
    // $(this).parent().parent().find('.exRoom').eq(0).css('display','none');
    for (var l = 0; l < 12; l++) {
        $("." + l + " li input:first-child").attr('name', 'RoomType[' + l + '][]');
        $("." + l + " li select").attr('name', 'RoomType[' + l + '][]');
    }
    for (var n = 0; n < $('.QueryBanID').length; n++) {
        banQuery.actionA('QueryBanID','','0,1',n);
    }
    for (var n = 0; n < $('.QueryHouse').length; n++) {
        houseQuery.actionA('QueryHouse','','0,1', n);
    }
	//营业编辑不可点击栏目设置
	$(".ModifyDetail.11 .exRoom").each(function(){
	  $(this).find('li:gt(1):lt(12) .fontS1').attr('readonly','readonly').unbind("dblclick").css('background-color','#f6f6f6');
	  $(this).find('li:gt(1):lt(12) .fontS1').removeClass("QueryCut");
	   $(this).find('li:gt(1):lt(12) select').css('visibility','hidden');
	});
    // var PointBox=[]
    // var beforeLength =$('.QueryCut').length;
    var _index = $(this).parent().prev().index('.exRoom ');
    //console.log(_index);
    var RoomLength = $('.exRoom').length;
    //console.log(RoomLength);
    var BoxLength = $('#PriceForm table').length;
    if($('#PriceForm').children().length==0){
        
        $('#PriceForm').append($('.PriceBoxNum').eq(0).clone(true));
    }else{
         if (_index > BoxLength) {
        $('#PriceForm table').eq(_index - 2).after($('.PriceBoxNum').eq(0).clone(true));
    } else {
        $('#PriceForm table').eq(_index - 1).before($('.PriceBoxNum').eq(0).clone(true));
    }
    }
    //console.log(BoxLength)
   
    // for (var i = 0; i < $('.del-styled').length; i++) {
    //     $('.del-styled').eq(i).click(function() {
    //          console.log(_index);
    //         $(this).parent().parent().remove();
    //         $('#PriceForm table').eq(_index-1).remove();
    //     });
    // }
})
$(document).on('click', '.del-styled', function() {
    var RoomIndex = $(this).parent().parent().index('.exRoom');
    $('#PriceForm table').eq(RoomIndex - 1).remove();
    // console.log(RoomIndex);
    $(this).parent().parent().remove();
});
$('.RoomStyle').click(function() {
    $(this).removeClass('am-field-valid');
});
$('.RoomStyle').focus(function() {
    $(this).removeClass('am-field-valid');
});
$('.PriceBoxNum').on('click', '.Boxes', function(event) {
    event.stopPropagation();
})
$('.PriceBoxNum').on('click', 'tr', function(event) {
    if ($(this).children().eq(0).find('input').prop('checked') == true) {
        $(this).children().eq(0).find('input').prop('checked', false);
        event.stopPropagation();
    } else {
        $(this).children().eq(0).find('input').prop('checked', 'checked');
        event.stopPropagation();
    }
})
//新增房间
//计租表修改
//打印
$('#bulkPrint').click(function() {
	var HouseArr=[];
	for(var i=0;i<$('.check001').length;i++){
		var HouseID = $('.check001').eq(i).children().eq(2).text();
		
		 HouseArr.push(HouseID);
	}
	$.ajax({
		  type: 'POST',
		  url: '/ph/HouseInfo/pdf/',
		  data: {' HouseArr': HouseArr},
		
		  dataType: JSON,
		  success: function(){

		  }
		});
});

// 收欠明细
$('.BeInDebt').click(function(){
    var HouseId = $(this).val();
    var tenant_name = $(this).attr('data-tenantName');
    layer.open({
        type: 1,
        area: ['1240px', '600px'],
        resize: false,
        title: ['收欠明细', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#BeInDebt'),
        btn: ['确定', '取消'],
        success:function(){
            $('#BeBanID').text(HouseId);
            $('#BeTenantName').text(tenant_name);
            // 表格初始化
            $(".debt input").val('');
            $(".monthly_collection input").val('');
            $(".year_collection input").val('');
            $('#beDebt').val('');
            // 表格初始化完成
            $.get('/ph/Api/queryRentEntry/HouseID/'+HouseId,function(res){
                res = JSON.parse(res);
                // console.log(res);
                if(res.data.length != 0){
                    var last_data = res.data.pop();
                    $('#beDebt').val(last_data[1]);
                    for(var i = 0;i < 12;i++){
                        $(".debt input").eq(i).val(res.data[i][0]=="0.00"?'':res.data[i][0]);
                        $(".monthly_collection input").eq(i).val(res.data[i][1]=="0.00"?'':res.data[i][1]);
                        $(".year_collection input").eq(i).val(res.data[i][2]=="0.00"?'':res.data[i][2]);
                    }
                }
            })
        },
        yes:function(thisIndex){
            var data = [];
            var current_arr = [];
            var beDebt = $('#beDebt').val();
            var last_arr = [HouseId,beDebt];
            for(var i = 0;i < 12;i++){
                current_arr = [];
                current_arr.push($(".debt input").eq(i).val());
                current_arr.push($(".monthly_collection input").eq(i).val());
                current_arr.push($(".year_collection input").eq(i).val());
                data.push(current_arr);
            }
            data.push(last_arr);
            // console.log(data);
            $.post('/ph/HouseInfo/rentEntry',{data:data},function(res){
                res = JSON.parse(res);
                // console.log(res);
                if(res.retcode == '2000'){
                    layer.close(thisIndex)
                }
                layer.msg(res.msg,{time:4000});
            })
        }
    });
})