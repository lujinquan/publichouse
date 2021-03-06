//新增租金减免
var aN = 1;
$('#addH').click(function() {
    aN++;
    var aContent = "<div class='am-u-md-3' style='margin-bottom:10px;float:left'>" + "<input type='text' name='buildID_" + aN + "'id='NLHouseID_" + aN + "' placeholder='房屋编号' required/>" + "</div>";
    $('.addB').append(aContent);
    queryData.actionD(2, 'NLHouseID_' + aN);
});
$('#addApply').click(function() {
    var checkId = $("input:checked").val();
    $(".rent_reduction").hide();
    $(".cancel").hide();
    $(".PauseRent").hide();
    $(".CancelRent").hide();
    $(".WriteOff").hide();
    $('#DQueryData').off('click');
    $('#houseLabel').text('房屋编号：');
    switch (checkId){
        case "1":
            layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增租金减免', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#derateApplyForm'),
                btn: ['确定', '取消'],
                success: function() {
                    $(".rent_reduction").show();
                    $('#DQueryData').on("click", function() {
                        var HouseID = $('#getInfo_1').val();
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            $("#BanID").text(res.data.BanID);
                            $("#BanAddress").text(res.data.BanAddress);
                            $("#CreateTime").text(res.data.CreateTime);
                            $("#useNature").text(res.data.UseNature);
                            $("#HouseUsearea").text(res.data.HouseUsearea);
                            $("#LeasedArea").text(res.data.LeasedArea);
                            $("#TenantName").text(res.data.TenantName);
                            $("#TenantNumber").text(res.data.TenantNumber);
                            $("#TenantTel").text(res.data.TenantTel);
                            $("#OwnTypeD").text(res.data.OwnerType);
                            $("#monthRent").text(res.data.HousePrerent);
                        });
                    });
                    houseQuery.action('getInfo_1','1');
                    new file({
                        button: "#basic",
                        show: "#basicShow",
                        upButton: "#basicUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    new file({
                        button: "#annualRentalContract",
                        show: "#annualRentalContractShow",
                        upButton: "#basicUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "年租房合同(协议)"
                    });
                    var one = new file({
                        button: "#ID",
                        show: "#IDShow",
                        upButton: "#IDUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var two = new file({
                        button: "#houseBook",
                        show: "#houseBookShow",
                        upButton: "#houseBookUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var three = new file({
                        button: "#household",
                        show: "#householdShow",
                        upButton: "#householdUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    // var four = new file({
                    //     button: "#cutRent",
                    //     show: "#cutRentShow",
                    //     upButton: "#cutRentUp",
                    //     size: 102400,
                    //     url: "/ph/ChangeApply/add",
                    //     ChangeOrderID: '',
                    //     Type: 1,
                    //     title: "证件上传"
                    // });
                    var five = new file({
                        button: "#houseSecurity",
                        show: "#houseSecurityShow",
                        upButton: "#houseSecurityUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var six = new file({
                        button: "#nonCardinality",
                        show: "#nonCardinalityShow",
                        upButton: "#nonCardinalityUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    new file({
                        button: "#noticeBook",
                        show: "#noticeBookShow",
                        upButton: "#noticeBookUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#getInfo_1').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！',{time:4000});
                    } else {
                        var formData = fileTotall.getArrayFormdata();
                        formData.append("CutType", $('#CutType').val());
                        formData.append("IDnumber", $('#IDnumber').val());
                        formData.append("validity", $('#validity').val());
                        formData.append("HouseID", $('#getInfo_1').val());
                        formData.append("RemitRent", $('#RemitRent').val());
                       
                        if($('.CutHide').css('display')=='block'){
                            formData.append("ARemitRent", $('#ARemitRent').val());
                        }
                        formData.append("type", 1);
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                if(res.retcode == '2000'){
                                    layer.close(thisIndex);
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_p_style").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "2":
            // layer.open({
            //     type:1,
            //     area:['350px','200px'],
            //     resize:false,
            //     zIndex:100,
            //     title:['空租','background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
            //     content:"<div style='text-align:center;padding:50px 0;'><button id='addEmptyRent' style='background: #2e77ef;color: #FFF;border: none;padding: 10px 15px;border-radius: 2px;'>新增空租</button>\
            //     <button id='cancelEmptyRent' style='background: #2e77ef;color:#FFF;border:none;padding:10px 15px;margin-left:20px;border-radius: 2px;'>取消空租</button></div>",
            //     success:function(){
            //         $('#addEmptyRent').off('click');
            //         $('#addEmptyRent').click(function(){
            //             addEmptyRent();
            //         });
            //         $('#cancelEmptyRent').off('click');
            //         $('#cancelEmptyRent').click(function(){
            //             cancelEmptyRent();
            //         });
            //     }
            // })
            addEmptyRent()
            break;
        case "3":
            $(".PauseRent").show();
            var value;
            var house_array = [];
            var thisLayer = layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                title: ['新增暂停计租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: $('#pauseRent'),
                btn:['保存','取消'],
                success: function(){
                    $('.type_3').show();
                    $('.type_15').hide();
                    $('.type_15_search').css('visibility','hidden');
                    var fun = new getBanList();
                    fun.getData('/ph/Api/get_all_ban',3);
                    $('#banLinkSearch').click(function(){
                        fun.search($('#banLinkInput').val());
                    })
					$('#banLinkInput').bind('keypress', function (event) { 
					   if (event.keyCode == "13") { 
					    $("#banLinkSearch").click();
					   }
					 })
                    // var seven = new file({
                    //     show: "#pauseMaterialShow",
                    //     upButton: "#pauseMaterialUp",
                    //     size: 102400,
                    //     url: "/ph/ChangeApply/add",
                    //     button: "#pauseMaterial",
                    //     ChangeOrderID: '',
                    //     Type: 1,
                    //     title: "非基数异动核算凭单"
                    // });
                    $('#pauseHouseQuery').off('click');
                    $('#pauseHouseQuery').on('click', function(){
                        $('#pauseHouseAdd').empty();
                        var ban_link_house = layer.open({
                            type: 1,
                            area: ['990px','780px'],
                            resize: false,
                            zIndex: 100,
                            title: ['新增暂停计租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                            content: $('#banLinkHouseForm'),
                            btn: ['确定', '取消'],
                            success: function() {

                            },
                            yes: function() {
                                var form_str = '';
                                var HousePrerent = 0;
                                var count = 0;
                                house_array = [];
                                var type = $('#pauseHouseChoose tr:eq(0) td:eq(2)').text();
                                for(var i = 0;i <$('#pauseHouseChoose tr').length;i++ ){
                                    if($("#pauseHouseChoose .house_check:eq("+i+") input[type='checkbox']").is(':checked')){
                                        count++;
                                        form_str += '<tr>\
                                            <td style="width:200px;">'+count+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(4)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(2)").text()+'</td>\
                                            <td style="width:350px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text()+'</td>\
                                        </tr>';
                                        HousePrerent += parseFloat($("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text());
                                        house_array.push($("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text());
                                    }
                                }
                                $('#pauseBanID').text(fun.initData.BanID);
                                $('#pauseBanAddress').text(fun.initData.BanAddress);
                                $('#pauseOwnerType').text(fun.initData.OwnerType);
                                $('#pauseHousePrerent').text(HousePrerent.toFixed(2));
                                $('#pauseHouseDetail').empty();
                                $('#pauseHouseDetail').append(form_str);
                                layer.close(ban_link_house);
                            },
                            end: function() {

                            }
                        });
                    });
                },
                yes:function(thisIndex){
                    var data = new FormData();
                    data.append('banID',$('#pauseBanID').text());
                    data.append('type',3);
                    house_array.forEach(function(value,index){
                        data.append("houseID[]",value);
                    });
                    console.log(data);
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            if(res.retcode == '2000'){
                                layer.close(thisIndex);
                                location.reload();
                            }
                        }
                    });
                },
                end:function(){
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_p_style").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "4":
            layer.open({
                type: 1,
                area: ['990px', '600px'],
                resize: false,
                zIndex: 100,
                title: ['新增陈欠核销', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#oldCancel'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('oldCancelHouseID','1');
                    $('#oldCancelQuery').on("click", function() {
                        var HouseID = $('#oldCancelHouseID').val();
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#oldCancelBanID").text(res.data.BanID);
                            $("#oldCancelBanAddress").text(res.data.BanAddress);
                            $("#oldCanceluseNature").text(res.data.UseNature);
                            $("#oldCancelHouseUsearea").text(res.data.HouseUsearea);
                            $("#oldCancelLeasedArea").text(res.data.LeasedArea);
                            $("#oldCancelTenantName").text(res.data.TenantName);
                            $("#oldCancelTenantNumber").text(res.data.TenantNumber);
                            $("#oldCancelTenantTel").text(res.data.TenantTel);
                            $("#oldCancelOwnTypeD").text(res.data.OwnerType);
                            $("#oldCancelmonthRent").text(res.data.HousePrerent);
                            $("#oldCancelYearBefore").val(res.data.ArrearRent);
							$(".money_sum").text(res.data.ArrearRent);
                            $(".cancel_money").text('0');
                            $('.month_ul li').removeClass('active');
                            $('.month_ul').empty();
                            for(var i = 0;i < res.data.Room.length;i++){
                                var li_dom = '<li value='+res.data.Room[i].UnpaidRent+'>'+res.data.Room[i].OrderDate.substring(4)+'</li>';
                                $('.month_ul').append(li_dom);
                            }
                        });
						$(".money_sum").text('');
                    });
                    var eight = new file({
                        button: "#WriteOffReport",
                        show: "#WriteOffShow",
                        upButton: "#WriteOffUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "暂停计租报告"
                    });
                    $('.month_ul').on('click','li',function(){
						$(this).prevAll().addClass('active');
						$(this).nextAll().removeClass('active');
						if($(this).hasClass('active')){
							$(this).removeClass('active');
						}else{
							$(this).addClass('active');
						}
						 var sum = 0;
						 var lis = $(".month_ul li.active");
						for(var i = 0; i< lis.length; i++){
							sum += parseFloat($(lis[i]).attr('value')) * 100;
						}
						// console.log(typeof($('.cancel_money').text()));
						$('.cancel_money').text(sum / 100);     
						var sum2 = parseFloat($('.cancel_money').text()).toFixed(2)*100 + parseFloat($('#oldCancelYearBefore').val()).toFixed(2)*100;
						var sum3 = parseFloat($('.cancel_money').text()).toFixed(2)*100;
						
						  if($('#oldCancelYearBefore').val()=='')
						  {
						  	$('.money_sum').text(sum3.toFixed(2) / 100);
						  }
						  else{
						  	$('.money_sum').text(sum2.toFixed(2) / 100);
						  }
						if(!$(".month_ul li").hasClass("active")){$('.cancel_money').text(0);}
								
                    });
					$("#oldCancelYearBefore").change(function(){
						var sum2 = parseFloat($('.cancel_money').text()).toFixed(2)*100 + parseFloat($('#oldCancelYearBefore').val()).toFixed(2)*100;
						var sum3 = parseFloat($('.cancel_money').text()).toFixed(2)*100;
						if($('#oldCancelYearBefore').val()=='')
						{
							$('.money_sum').text(sum3.toFixed(2) / 100);
						}
						else{
							$('.money_sum').text(sum2.toFixed(2) / 100);
						}
					});
                },
                yes: function(thisIndex){
                    if ($('#oldCancelHouseID').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！',{time:4000});
                    } else {
                        var formData = new FormData();
                        var oldCancelMonthBefore = [];
                        for(var i = 0;i < $('.month_ul li').length;i++){
                            if($('.month_ul li').eq(i).hasClass('active')){
                                oldCancelMonthBefore.push(parseInt($('.month_ul li').eq(i).text()));
                            }
                        }
                        formData.append("HouseID", $('#oldCancelHouseID').val());
                        formData.append("oldCancelYearBefore",$('#oldCancelYearBefore').val());
                        formData.append("oldCancelMonthBefore",oldCancelMonthBefore.join(','));
                        formData.append("cancel_money",$('.cancel_money').text());
                        formData.append("oldCancelReason",$('#oldCancelReason').val());
                        formData.append("type", 4);
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                layer.close(thisIndex);
                                location.reload();
                            }
                        });
						
                    }
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "5":
            var thisLayer = layer.open({
                type: 1,
                area: ['300px', '200px'],
                resize: false,
                title: ['新增房改', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: "<div class='am-form' style='margin:30px 0;text-align:center;'><input id='ChangeHouseID' type='number' style='width:200px;display:inline-block;' /></div>",
                btn: ['确认', '取消'],
                success: function() {
                    houseQuery.action('ChangeHouseID','1');
                },
                yes: function() {
                    // $('#ChangeBtn').off('click');
                    // $('#ChangeBtn').on('click',function(){
                    var HouseID = $("#ChangeHouseID").val()
                    console.log(HouseID);
                    $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                        res = JSON.parse(res);
                        console.log(res);
                        layer.msg(res.msg,{time:4000});
                        $(".CHouseId").text(HouseID);
                        $(".CBanID").text(res.data.BanID);
                        $(".CHouseAddress").text(res.data.BanAddress);
                        $(".CFloor").text(res.data.FloorID);
                        $(".CTenantName").text(res.data.TenantName);
                        $(".CTenantTel").text(res.data.TenantTel);
                        $(".CTenantNumber").text(res.data.TenantNumber);
                        $(".CArea").text(res.data.HouseArea);
                        $(".CLeasedArea").text(res.data.LeasedArea);
                        $(".CType").text(res.data.OwnerType);
                        $(".CUseProp").text(res.data.UseNature);
                        $(".CHouseStructure").text(res.data.StructureType);
                        $(".CBuiltYear").text(res.data.CreateTime);
                    });
                    // });
                    var ChangeType = $(".CType").eq(0).text();
                    layer.close(thisLayer); //弹窗关闭
                    if (ChangeType != '市属' && ChangeType != '区属') {
                        $('.material_1').show();
                        $('.material_2').hide();
                        $('.material_3').hide();
                        new file({
                            button: "#CHouseApp_1",
                            show: "#CHouseApp_1Show",
                            upButton: "#CHouseApp_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_1",
                            show: "#CApprovalForm_1Show",
                            upButton: "#CApprovalForm_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_1",
                            show: "#InvoiceSale_1Show",
                            upButton: "#InvoiceSale_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CHouseUse",
                            show: "#CHouseUseShow",
                            upButton: "#CHouseUseUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋使用权证（权属证明书）原件/复印件"
                        });
                        new file({
                            button: "#CLastRentInvoice_1",
                            show: "#CLastRentInvoice_1Show",
                            upButton: "#CLastRentInvoice_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_1",
                            show: "#CPublicFundInvoice_1Show",
                            upButton: "#CPublicFundInvoice_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "公共部位维修基金发票"
                        });
                        new file({
                            button: "#CCopyOfHouse",
                            show: "#CCopyOfHouseShow",
                            upButton: "#CCopyOfHouseUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "住房证复印件"
                        });
                        new file({
                            button: "#CReApproval",
                            show: "#CReApprovalShow",
                            upButton: "#CReApprovalUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改批文"
                        });
                        new file({
                            button: "#CTransactionList",
                            show: "#CTransactionListShow",
                            upButton: "#CTransactionListUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改交易清册（住户加盖私章）"
                        });
                        new file({
                            button: "#CReAgreement_1",
                            show: "#CReAgreement_1Show",
                            upButton: "#CReAgreement_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改协议书（住户加盖私章）"
                        });
                        new file({
                            button: "#CAttorney",
                            show: "#CAttorneyShow",
                            upButton: "#CAttorneyUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "委托书（加住户私章）"
                        });
                        new file({
                            button: "#CLicenseCopy",
                            show: "#CLicenseCopyShow",
                            upButton: "#CLicenseCopyUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "营业执照复印件"
                        });
                        new file({
                            button: "#CAffidavit_1",
                            show: "#CAffidavit_1Show",
                            upButton: "#CAffidavit_1Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "具结书（公司对房地局出具）"
                        });
                        new file({
                            button: "#CProofOfFund",
                            show: "#CProofOfFundShow",
                            upButton: "#CProofOfFundUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "资金证明（商业银行出具的二联单）"
                        });
                        new file({
                            button: "#CRegistration",
                            show: "#CRegistrationShow",
                            upButton: "#CRegistrationUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋登记申请书"
                        });
                        new file({
                            button: "#CAssessment",
                            show: "#CAssessmentShow",
                            upButton: "#CAssessmentUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "评估单"
                        });
                        new file({
                            button: "#CLegalCertificate",
                            show: "#CLegalCertificateShow",
                            upButton: "#CLegalCertificateUp",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "法人代表证明"
                        });
                    } else if (ChangeType == '市属') {
                        $('.material_1').hide();
                        $('.material_2').show();
                        $('.material_3').hide();
                        new file({
                            button: "#CHouseApp_2",
                            show: "#CHouseApp_2Show",
                            upButton: "#CHouseApp_2Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_2",
                            show: "#CApprovalForm_2Show",
                            upButton: "#CApprovalForm_2Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_2",
                            show: "#InvoiceSale_2Show",
                            upButton: "#InvoiceSale_2Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CLastRentInvoice_2",
                            show: "#CLastRentInvoice_2Show",
                            upButton: "#CLastRentInvoice_2Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_2",
                            show: "#CPublicFundInvoice_2Show",
                            upButton: "#CPublicFundInvoice_2Up",
                            size: 102400,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "公共部位维修基金发票"
                        });
                        new file({
                            button: "#CReAgreement_2",
                            show: "#CReAgreement_2Show",
                            upButton: "#CReAgreement_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改协议书"
                        });
                        new file({
                            button: "#CCopyOfProp",
                            show: "#CCopyOfPropShow",
                            upButton: "#CCopyOfPropUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "产权复印件"
                        });
                        new file({
                            button: "#CPicture",
                            show: "#CPictureShow",
                            upButton: "#CPictureUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "图纸"
                        });
                        new file({
                            button: "#CHouseInformation",
                            show: "#CHouseInformationShow",
                            upButton: "#CHouseInformationUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋信息单（房地局出具）"
                        });
                        new file({
                            button: "#CReBooklet",
                            show: "#CReBookletShow",
                            upButton: "#CReBookletUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "户口簿"
                        });
                        new file({
                            button: "#CCopyOfCard",
                            show: "#CCopyOfCardShow",
                            upButton: "#CCopyOfCardUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "身份证复印件2分（夫妻双方）"
                        });
                        new file({
                            button: "#CWorkCertificate",
                            show: "#CWorkCertificateShow",
                            upButton: "#CWorkCertificateUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "工领证明材料复印件（退休证等）"
                        });
                        new file({
                            button: "#CAffidavit_2",
                            show: "#CAffidavit_2Show",
                            upButton: "#CAffidavit_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "具结书"
                        });
                    } else if (ChangeType == '区属') {
                        $('.material_1').hide();
                        $('.material_2').hide();
                        $('.material_3').show();
                        new file({
                            button: "#CHouseApp_3",
                            show: "#CHouseApp_3Show",
                            upButton: "#CHouseApp_3Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_3",
                            show: "#CApprovalForm_3Show",
                            upButton: "#CApprovalForm_3Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_3",
                            show: "#InvoiceSale_3Show",
                            upButton: "#InvoiceSale_3Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CLastRentInvoice_3",
                            show: "#CLastRentInvoice_3Show",
                            upButton: "#CLastRentInvoice_3Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_3",
                            show: "#CPublicFundInvoice_3Show",
                            upButton: "#CPublicFundInvoice_3Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "公共部位维修基金发票"
                        });
                    }
                    layer.open({
                        type: 1,
                        area: ['990px', '800px'],
                        resize: false,
                        title: ['房改申请', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                        zIndex: 100,
                        content: $('#HouseChange'),
                        btn: ['确认', '取消'],
                        success: function() {},
                        yes: function(thisIndex) {
                            if ($('.CHouseId').text() == "" || $(".CBanID").text() == "") {
                                layer.msg('房屋编号存在问题呢！！！',{time:4000});
                            } else {
                                var formData = fileTotall.getArrayFormdata();
                                formData.append("HouseID", $('.CHouseId').text());
                                formData.append("type", 5);
                                $.ajax({
                                    type: "post",
                                    url: "/ph/ChangeApply/add",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        res = JSON.parse(res);
                                        layer.msg(res.msg,{time:4000});
                                        layer.close(thisIndex);
                                        location.reload();
                                    }
                                });
                            }
                        },
                        end: function() {
                            $("input[type='text']").val('');
                            $("input[type='number']").val('');
                            $(".label_content").text('');
                            $(".img_content").text('');
                            $("select").val('');
                            location.reload();
                        }
                    });
                }
            });
            break;
        case "6":
            layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增维修异动', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#repairChange'),
                btn: ['确定', '取消'],
                success: function() {
                    banQuery.action('houseID','1');
                    $('#DRquery').off('click');
                    $('#DRquery').on("click", function() {
                        var BanID = $("#houseID").val();
                        $.get('/ph/Api/get_ban_info/BanID/' + BanID, function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            $("#RCBanAddress").text(res.data.BanAddress);
                            $("#RCStructureType").text(res.data.StructureType);
                            $("#RCDamageGrade").text(res.data.DamageGrade);
                            $("#HouseArea").text(res.data.HouseUsearea);
                            $("#LeasedArea").text(res.data.LeasedArea);
                            $("#TenantName").text(res.data.TenantName);
                            $("#TenantNumber").text(res.data.TenantNumber);
                            $("#TenantTel").text(res.data.TenantTel);
                            $("#RUseNature").text(res.data.UseNature);
                            $("#ROwnerType").text(res.data.OwnerType);
                            $("#RBanFloorNum").text(res.data.BanFloorNum);
                            $("#RBanUnitNum").text(res.data.BanUnitNum);
                            $("#RCoveredArea").text(res.data.CoveredArea);
                            $("#RTotalArea").text(res.data.TotalArea);
                            //$("#BanAddress").text(res.data.BanAddress);
                        });
                    });
                    var nine = new file({
                        button: "#survey",
                        show: "#surveyShow",
                        upButton: "#surveyUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "房屋勘察表"
                    });
                    var ten = new file({
                        button: "#pic",
                        show: "#picShow",
                        upButton: "#picUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "房屋勘察表"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#houseID').val() == "") {
                        layer.msg('房屋编号不能为空！！！',{time:4000});
                    } else {
                        var picData = fileTotall.getArrayFormdata();
                        var formData = new FormData($('#repairChange')[0]);
                        formData.append("type", 6);
                        formData.delete("pic"); //IE不兼容delete写法
                        formData.delete("survey");
                        var dong = picData.entries();
                        for (var i = 0;; i++) {
                            var dongData = dong.next();
                            if (dongData.done == true) {
                                break;
                            }
                            formData.append(dongData.value[0], dongData.value[1]);
                        };
                        // for(var i of dong){
                        // 	console.log(i[1]);
                        // 	formData.append(i[0],i[1]);
                        // };
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                layer.close(thisIndex);
                                location.reload();
                            }
                        });
                    }
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "7":
            var thisLayer = layer.open({
                type: 1,
                area: ['700px', '700px'],
                resize: false,
                title: ['新发租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: $('#newRent'),
                btn: ['确定', '取消'],
                success: function() {
                   houseQuery.action('newRentHouseID','0');
                   $('#newRentQuery').on("click", function() {
                        var HouseID = $('#newRentHouseID').val();
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            $('.newRentTenentID').text(res.data.TenantID);
                            $('.newRentTenent').text(res.data.TenantName);
                            $('.newRentNumber').text(res.data.TenantNumber);
                            $('.newRentTel').text(res.data.TenantTel);
                            $('.newRentUnit').text(res.data.UnitID);
                            $('.newRentFloor').text(res.data.FloorID);
                            $('.newRentBanArea').text(res.data.HouseArea);
                            $('.newRentPrice').text(res.data.OldOprice);
                            $('#newRentBanInfo').attr('value',res.data.BanID);
                        });
                    });
                },
                yes: function(thisIndex) {
                    if ($('#newRentHouseID').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！',{time:4000});
                    }else{
                        var formData = new FormData();
                        formData.append("HouseID", $('#newRentHouseID').val());
                        formData.append("Remark", $('#newRentReason').val());
                        formData.append("TenantID",$('.newRentTenentID').val());
                        formData.append("TenantName", $('.newRentTenent').val());
                        formData.append("TenantNumber", $('.newRentNumber').val());
                        formData.append("TenantTel", $('.newRentTel').val());
                        formData.append("UnitID", $('.newRentUnit').val());
                        formData.append("FloorID", $('.newRentFloor').val());
                        formData.append("HouseArea", $('.newRentBanArea').val());
                        formData.append("OldOprice", $('.newRentPrice').val());
						formData.append("NewLeaseType", $('#NewLeaseType option:selected').val());
                        formData.append("type", 7);
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                if(res.retcode == "2000"){
                                    layer.close(thisIndex);
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "8":
            houseQuery.action('getcancel','1');
            var layer_cancelRent = layer.open({
                type:1,
                area:['990px', '700px'],
                resize:false,
                zIndex:99,
                title:['新增注销', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content:$('#cancel'),
                btn: ['确定', '取消'],
                success:function(){
                   $('#cancelQueryData').on("click", function() {
                        var HouseID = $('#getcancel').val();
                        $.get('/ph/Api/check_house_cancel_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            if(res.retcode == '4002'){
                                layer.msg(res.msg,{time:4000});
                            }
							else{
                                //console.log(res);
                                $('#cancelUseNature').text(res.data.UseNature);
                                $('#cancelDamageGrade').text(res.data.DamageGrade);
                                $('#cancelHouseUsearea').text(res.data.HouseUsearea);
                                $('#cancelLeasedArea').text(res.data.LeasedArea);
                                $('#cancelHousePrerent').text(res.data.HousePrerent);
                                $('#cancelTenantName').text(res.data.TenantName);
                                $('#cancelTenantNumber').text(res.data.TenantNumber);
                                $('#cancelTenantTel').text(res.data.TenantTel);
                                $('#cancelUnitID').text(res.data.UnitID);
                                $('#cancelFloorID').text(res.data.FloorID);
                                $('#cancelOwnerType').text(res.data.OwnerType);
                                $("#cancelPumpCosts").text(res.data.PumpCost);
                                $("#cancelDiffRents").text(res.data.DiffRent);
                                $('.housePrice').val('');
                                var DOM = $('.cancel_BanNumber').eq($('.cancel_BanNumber').length - 1).clone();
                                $('#addBanNumber').empty();
                                for(var i = 0;i < res.data.Ban.length;i++){
                                    var ban_dom = DOM.clone().show();
                                    ban_dom.find('.banID').text(res.data.Ban[i].BanID);
                                    ban_dom.find('.HouseAdress').text(res.data.Ban[i].BanAddress);
                                    ban_dom.find('.banOwnerType').text(res.data.Ban[i].OwnerType);
                                    $('#addBanNumber').append(ban_dom);
                                }
                                //$('.cancel_BanNumber:eq(0)').remove();
                                var housePrerent = parseFloat(res.data.HousePrerent) + parseFloat(res.data.PumpCost) + parseFloat(res.data.DiffRent);
                                console.log(housePrerent);
                                $('.cancelPrent').eq(0).val(housePrerent);
                                $('.cancelHouseUsearea').eq(0).val(res.data.LeasedArea);

                                $('.houseArea').on('input propertychange',function(){
                                    var number = parseFloat(res.data.TotalOprice)/parseFloat(res.data.TotalArea)*parseFloat($(this).val());
                                    $('.housePrice').val(number.toFixed(2));
                                }); 
                            }
                        });
                    });
                    new file({
                        button: "#housingBill",
                        show: "#housingBillShow",
                        upButton: "#housingBillUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "武汉市直管公有住房出售收入专用票据"
                    });
                    new file({
                        button: "#housingApprovalForm",
                        show: "#housingApprovalFormShow",
                        upButton: "#housingApprovalFormUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "武昌区房地局出售直管公有住房审批表"
                    });
                    new file({
                        button: "#housingApprovalFormOther",
                        show: "#housingApprovalFormOtherShow",
                        upButton: "#housingApprovalFormOtherUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "其他"
                    });
                },
                yes:function(thisIndex){
                    if ($('#getcancel').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！',{time:4000});
                    } else {
                        var formData = fileTotall.getArrayFormdata() || new FormData();
                        var BanArray = [];
                        formData.append("HouseID", $('#getcancel').val());
                        formData.append("cancelType", $('#cancelType').val());
                        formData.append("cancelReason", $('#cancelReason').val());
                        formData.append("type", 8);
                        for(var i = 0;i < $('.cancel_BanNumber').length-1;i++){
                            formData.append("Ban["+i+"][banID]", $('.cancel_BanNumber .banID').eq(i).text());
                            formData.append("Ban["+i+"][HouseAdress]", $('.cancel_BanNumber .HouseAdress').eq(i).text());
                            formData.append("Ban["+i+"][houseArea]", $('.cancel_BanNumber .houseArea').eq(i).val());
                            formData.append("Ban["+i+"][housePrice]", $('.cancel_BanNumber .housePrice').eq(i).val());
                            formData.append("Ban["+i+"][cancelPrent]", $('.cancel_BanNumber .cancelPrent').eq(i).val());
                            formData.append("Ban["+i+"][cancelHouseUsearea]", $('.cancel_BanNumber .cancelHouseUsearea').eq(i).val());
                        }
                        
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                if(res.retcode == '2000'){
                                    layer.close(thisIndex);
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                end:function(){
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_p_style").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            })
            break;
        case "9":
            var ban_length = 0;
            $('.table_data_2').hide();
            $('.table_data_3').hide();
            layer.open({
                type: 1,
                area: ['990px', '710px'],
                resize: false,
                zIndex: 100,
                title: ['新增房屋调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#houseAdjust'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('houseAdjustHouse','1');
					//新增房屋调整资料上传
					new file({
					    button: "#housingReadjust",
					    show: "#housingReadjustShow",
					    upButton: "#housingReadjustUp",
					    size: 102400,
					    url: "/ph/ChangeApply/add",
					    ChangeOrderID: '',
					    Type: 1,
					    title: "武汉市直管公有住房出售收入专用票据1"
					});
					new file({
					    button: "#housingApprovalChart",
					    show: "#housingApprovalChartShow",
					    upButton: "#housingApprovalChartUp",
					    size: 102400,
					    url: "/ph/ChangeApply/add",
					    ChangeOrderID: '',
					    Type: 1,
					    title: "武昌区房地局出售直管公有住房审批表1"
					});
                    $('#houseAdjustQuery').off('click');
                    $('#houseAdjustQuery').on("click", function() {
						$(".HARent,.HALeasedArea,.HABanArea,.HAPrice").val('0.00');
						
                        var houseID = $("#houseAdjustHouse").val()
                        $.get('/ph/Api/get_house_info/HouseID/' + houseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res.data.Ban);
                            ban_length = res.data.Ban.length;
                            // if(ban_length == 2){
                            //      $('.table_data_2').show();
                            // }else if(ban_length == 3){
                            //     $('.table_data_2').show();
                            //     $('.table_data_3').show();
                            // }
                            $('.table_data_2').hide();
                            $('.table_data_3').hide();
                            for(var i = 0; i < res.data.Ban.length;i++){
                                $('.HABanID').eq(i).text(res.data.Ban[i].BanID);
                                $('.HAAddress').eq(i).text(res.data.Ban[i].BanAddress);
                                $('.HABeforeRent').eq(i).text(res.data.Ban[i].PreRent);
                                $('.HABeforeLeasedArea').eq(i).text(res.data.Ban[i].BanUsearea);
                                $('.HABeforeBanArea').eq(i).text(res.data.Ban[i].TotalArea);
                                $('.HABeforePrice').eq(i).text(res.data.Ban[i].TotalOprice);
                                $('.HAAfterRent').eq(i).val(res.data.Ban[i].PreRent);
                                $('.HAAfterLeasedArea').eq(i).val(res.data.Ban[i].BanUsearea);
                                $('.HAAfterBanArea').eq(i).val(res.data.Ban[i].TotalArea);
                                $('.HAAfterPrice').eq(i).val(res.data.Ban[i].TotalOprice);

                                $('.table_data_'+(i+1)).show();
                            }
                            $('.HARent').off('input');
                            $('.HARent').on('input',function(){
                                var this_index = $(this).index('.HARent');
                                var number_1 = res.data.Ban[this_index].PreRent;
                                var number_2 = $('.HARent').eq(this_index).val() || "0";
                                if(number_2 < 0){
                                    number_2 = Math.abs(number_2).toString();
                                    $('.HAAfterRent').eq(this_index).val(numberMethod(number_1,number_2,'-'));
                                }else{
                                    $('.HAAfterRent').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                                }
                                
                            });
                            $('.HALeasedArea').off('input');
                            $('.HALeasedArea').on('input',function(){
                                var this_index = $(this).index('.HALeasedArea');
                                var number_1 = res.data.Ban[this_index].BanUsearea;
                                var number_2 = $('.HALeasedArea').eq(this_index).val() || "0";
                                if(number_2 < 0){
                                    number_2 = Math.abs(number_2).toString();
                                    $('.HAAfterLeasedArea').eq(this_index).val(numberMethod(number_1,number_2,'-'));
                                }else{
                                    $('.HAAfterLeasedArea').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                                }
                            });
                            $('.HABanArea').off('input');
                            $('.HABanArea').on('input',function(){
                                var this_index = $(this).index('.HABanArea');
                                var number_1 = res.data.Ban[this_index].TotalArea;
                                var number_2 = $('.HABanArea').eq(this_index).val() || "0";
                                if(number_2 < 0){
                                    number_2 = Math.abs(number_2).toString();
                                    $('.HAAfterBanArea').eq(this_index).val(numberMethod(number_1,number_2,'-'));
                                }else{
                                    $('.HAAfterBanArea').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                                }
                            });
                            $('.HAPrice').off('input');
                            $('.HAPrice').on('input',function(){
                                var this_index = $(this).index('.HAPrice');
                                var number_1 = res.data.Ban[this_index].TotalOprice;
                                var number_2 = $('.HAPrice').eq(this_index).val() || "0";
                                if(number_2 < 0){
                                    number_2 = Math.abs(number_2).toString();
                                    $('.HAAfterPrice').eq(this_index).val(numberMethod(number_1,number_2,'-'));
                                 }else{
                                    $('.HAAfterPrice').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                                 }
                            });
                            layer.msg(res.msg,{time:4000});
                        });
                    });
                },
                yes: function(thisIndex) {
                    if ($('#houseAdjustHouse').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！',{time:4000});
                    } else {
                        var formData = fileTotall.getArrayFormdata() ||  new FormData();
                        formData.append("HouseID", $('#houseAdjustHouse').val());
                        formData.append("Remark", $('#houseAdjustReason').val());
                        for(var i = 0;i < ban_length;i++){
                            formData.append("Ban["+i+"][BanID]", $('.HABanID').eq(i).text());
                            formData.append("Ban["+i+"][BanAddress]", $('.HAAddress').eq(i).text());
                            formData.append("Ban["+i+"][PreRent]", $('.HABeforeRent').eq(i).text());
                            formData.append("Ban["+i+"][BanUsearea]", $('.HABeforeLeasedArea').eq(i).text());
                            formData.append("Ban["+i+"][TotalArea]", $('.HABeforeBanArea').eq(i).text());
                            formData.append("Ban["+i+"][TotalOprice]", $('.HABeforePrice').eq(i).text());
                            formData.append("Ban["+i+"][PreRentChange]", $('.HARent').eq(i).val());
                            formData.append("Ban["+i+"][BanUseareaChange]", $('.HALeasedArea').eq(i).val());
                            formData.append("Ban["+i+"][TotalAreaChange]", $('.HABanArea').eq(i).val());
                            formData.append("Ban["+i+"][TotalOpriceChange]", $('.HAPrice').eq(i).val());
                            formData.append("Ban["+i+"][PreRentAfter]", $('.HAAfterRent').eq(i).val());
                            formData.append("Ban["+i+"][BanUseareaAfter]", $('.HAAfterLeasedArea').eq(i).val());
                            formData.append("Ban["+i+"][TotalAreaAfter]", $('.HAAfterBanArea').eq(i).val());
                            formData.append("Ban["+i+"][TotalOpriceAfter]", $('.HAAfterPrice').eq(i).val());
                        }
                        formData.append("type", 9);
                        $.ajax({
                            type: "post",
                            url: "/ph/ChangeApply/add",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                res = JSON.parse(res);
                                layer.msg(res.msg,{time:4000});
                                if(res.retcode == "2000"){
                                    layer.close(thisIndex);
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "10":
            var PipeAdjust = layer.open({
                type: 1,
                area: ['400px', '200px'],
                resize: false,
                title: ['选择管段类型', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: "<div class='text-center'><button class='am-btn am-btn-secondary pip-btn' value='101'>按栋调整</button>\
								<button class='am-btn am-btn-secondary pip-btn' value='102'>按户调整</button></div>",
                success: function() {
                    $('.pip-btn').off('click');
                    $('.pip-btn').on('click', function() {
                        pipBtn = $(this).val();
                        console.log(pipBtn);
                        if (pipBtn == "101") {
                            layer.open({
                                type: 1,
                                area: ['990px', '700px'],
                                resize: false,
                                zIndex: 100,
                                title: ['新增管段调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                content: $('#Pipe'),
                                btn: ['确定', '取消'],
                                success: function() {
                                    $('#PipeBan').show();
                                    $('#PipeHouse').hide();
                                    $('.RentTipsBan').show();
                                    $('.RentTipsHouse').hide();
                                    banQuery.action('PipeBanID','1');
                                    $('#PipeQuery').off('click');
                                    $('#PipeQuery').on('click', function() {
                                        var BanID = $("#PipeBanID").val()
                                        $.get('/ph/Api/get_ban_info/BanID/' + BanID, function(res) {
                                            res = JSON.parse(res);
                                            console.log(res);
                                            layer.msg(res.msg,{time:4000});
                                            $("#PipeBanAddress").text(res.data.BanAddress);
                                            $("#NLUseNature").text(res.data.UseNature);
                                            $("#NLFloorID").text(res.data.FloorID);
                                            $("#NLOwnerType").text(res.data.OwnerType);
                                            $("#PipeOwnerType").text(res.data.OwnerType);
                                            $("#NLHouseArea").text(res.data.HouseArea);
                                            $("#PipeDamageGrade").text(res.data.DamageGrade);
                                            //$("#TenantTel").text(res.data.TenantTel);
                                            //$("#BanAddress").text(res.data.BanAddress);
                                            $("#PipeUseNature").text(res.data.UseNature);
                                            $("#PipeFloorID").text(res.data.BanFloorNum);
                                            $("#PipeBuilding").text(res.data.BanUnitNum);
                                            $("#PipeCorverArea").text(res.data.CoveredArea);
                                            $("#PipeStructureType").text(res.data.StructureType);
                                            $("#PipeHouseArea").text(res.data.TotalArea);
                                            $("#PipeTubulationID").text(res.data.TubulationID);
                                        });
                                    });
                                    new file({
                                        button: "#PipeApplication",
                                        show: "#PipeApplicationShow",
                                        upButton: "#PipeApplicationUp",
                                        size: 10240,
                                        url: "/ph/ChangeApply/add",
                                        ChangeOrderID: '',
                                        Type: 1,
                                        title: "异动申请表"
                                    });
                                },
                                yes: function(thisIndex) {
                                    var formData = fileTotall.getArrayFormdata();
                                    formData.append("BanID", $('#PipeBanID').val());
                                    formData.append("InstitutionID", $('#PipeAdjusted').val());
                                    formData.append("type", 10);
                                    $.ajax({
                                        type: "post",
                                        url: "/ph/ChangeApply/add",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(res) {
                                            res = JSON.parse(res);
                                            layer.msg(res.msg,{time:4000});
                                            layer.close(thisIndex);
                                            location.reload();
                                        }
                                    });
                                },
				                end: function() {
				                    $("input[type='text']").val('');
				                    $("input[type='number']").val('');
				                    $(".label_content").text('');
				                    $(".img_content").text('');
				                    $("select").val('');
                                    location.reload();
				                }
                            });
                        } else {
                            layer.open({
                                type: 1,
                                area: ['990px', '700px'],
                                resize: false,
                                zIndex: 100,
                                title: ['新增管段调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                content: $('#Pipe'),
                                btn: ['确定', '取消'],
                                success: function() {
                                    $('#PipeBan').hide();
                                    $('#PipeHouse').show();
                                    $('.RentTipsBan').hide();
                                    $('.RentTipsHouse').show();
                                    $('#PipeName').text('房屋编号：');
                                    houseQuery.action('PipeBanID','1');
                                    $('#PipeQuery').off('click');
                                    $('#PipeQuery').on('click', function() {
                                        var HouseID = $("#PipeBanID").val()
                                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                                            res = JSON.parse(res);
                                            console.log(res);
                                            layer.msg(res.msg,{time:4000});
                                            $("#PipeBanNumd").text(res.data.BanID);
                                            $("#PipeHouseAddressd").text(res.data.BanAddress);
                                            $("#PipeLayerd").text(res.data.FloorID);
                                            $("#PipeRenterd").text(res.data.TenantName);
                                            $("#PipePhoneNumd").text(res.data.TenantTel);
                                            $("#PipeIDd").text(res.data.TenantNumber);
                                            $("#PipeTimed").text(res.data.CreateTime);
                                            $("#PipeBulid").text(res.data.CoveredArea);
                                            $("#PipeRentArea").text(res.data.LeasedArea);
                                            $('#PipeTubulationID').text(res.data.TubulationID);
                                        });
                                    });
                                    new file({
                                        button: "#PipeApplication",
                                        show: "#PipeApplicationShow",
                                        upButton: "#PipeApplicationUp",
                                        size: 10240,
                                        url: "/ph/ChangeApply/add",
                                        ChangeOrderID: '',
                                        Type: 1,
                                        title: "异动申请表"
                                    });
                                },
                                yes: function(thisIndex) {
                                    var formData = fileTotall.getArrayFormdata();
                                    formData.append("HouseID", $('#PipeBanID').val());
                                    formData.append("InstitutionID", $('#PipeAdjusted').val());
                                    formData.append("type", 10);
                                    $.ajax({
                                        type: "post",
                                        url: "/ph/ChangeApply/add",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(res) {
                                            res = JSON.parse(res);
                                            layer.msg(res.msg,{time:4000});
                                            layer.close(thisIndex);
                                            location.reload();
                                        }
                                    });
                                },
				                end: function() {
				                    $("input[type='text']").val('');
				                    $("input[type='number']").val('');
				                    $(".label_content").text('');
				                    $(".img_content").text('');
				                    $("select").val('');
                                    location.reload();
				                }
                            });
                        }	
                    })
                }
            })
            break;
        case "11":
            layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增追加调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#RentAdditional'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('getRentAdd','0,1');
                    new file({
                        button: "#otherBills",
                        show: "#otherBillsShow",
                        upButton: "#otherBillsUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "其他(票据)"
                    });
                    $('#RentAddQueryData').off('click');
                    $('#RentAddQueryData').on('click', function() {
                        var HouseID = $("#getRentAdd").val()
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#RentAddBanID").text(res.data.BanID);
                            $("#RentAddAddress").text(res.data.BanAddress);
                            $("#RentAddTenantName").text(res.data.TenantName);
                            $("#RentAddTenantTel").text(res.data.TenantTel);
                            $("#RentAddTenantNumber").text(res.data.TenantNumber);
                            $("#RentAddUseNature").text(res.data.UseNature);
                            $("#RentAddHouseUseArea").text(res.data.HouseUsearea);
                            $("#RentAddLeasedArea").text(res.data.LeasedArea);
                            $("#RentAddOwnerType").text(res.data.OwnerType);
                            $("#RentAddHousePrerent").text(res.data.HousePrerent);
                            $("#RentAddDamageGrade").text(res.data.DamageGrade);
                        });
                    });
                },
                yes: function(thisIndex) {
						if($("#otherBillsShow").html()==""){
							layer.msg('请上传相应附件！',{time:4000});
						}else{
							var formData = fileTotall.getArrayFormdata();
							formData.append("HouseID",$('#getRentAdd').val());
							formData.append("RentAddYear",$('#RentAddYear').val());
							formData.append("RentAddMonth",$('#RentAddMonth').val());
							formData.append("RentAddReason",$('.RentAddReason').val());
							formData.append("IfTakeBack",$('input[name="IfTakeBack"]:checked').val());
							formData.append("type", 11);
							$.ajax({
							    type: "post",
							    url: "/ph/ChangeApply/add",
							    data: formData,
							    processData: false,
							    contentType: false,
							    success: function(res) {
							        res = JSON.parse(res);
							        layer.msg(res.msg,{time:4000});
							        layer.close(thisIndex);
							        location.reload();
							    }
							});
						}
                    
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case "12":
            layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增租金调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#RentAdjustment'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('getRent','1');
                    $('#RentQueryData').off('click');
                    $('#RentQueryData').on('click', function() {
                        var HouseID = $("#getRent").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#RentUseNature").text(res.data.UseNature);
                            $("#RentDamageGrade").text(res.data.DamageGrade);
                            $("#RentOwnerType").text(res.data.OwnerType);
                            $("#RentHouseUsearea").text(res.data.HouseUsearea);
                            $("#RentLeasedArea").text(res.data.LeasedArea);
                            $("#RentHousePrerent").text(res.data.HousePrerent);
                            $("#RentTenantName").text(res.data.TenantName);
                            $("#RentTenantNumber").text(res.data.TenantNumber);
                            $("#RentTenantTel").text(res.data.TenantTel);

                            var DOM = $('.Rent_BanNumber').eq($('.Rent_BanNumber').length - 1).clone();
                            $('#addRent').empty();
                            for(var i = 0;i < res.data.Ban.length;i++){
                                var ban_dom = DOM.clone().show();
                                ban_dom.find('.banID').text(res.data.Ban[i].BanID);
                                ban_dom.find('.HouseAdress').text(res.data.Ban[i].BanAddress);
                                $('#addRent').append(ban_dom);
                            }
                        });
                    });
                },
                yes: function(thisIndex) {
                    var formData = new FormData();
                    formData.append("type", 12);
                    formData.append("HouseID", $('#getRent').val());
                    formData.append("RentReason", $('#RentReason').val());
                    for(var i = 0;i < $('.Rent_BanNumber').length - 1;i++){
                        formData.append("Ban["+i+"][banID]", $('.Rent_BanNumber .banID').eq(i).text());
                        formData.append("Ban["+i+"][HouseAdress]", $('.Rent_BanNumber .HouseAdress').eq(i).text());
                        formData.append("Ban["+i+"][addRentMoney]", $('.Rent_BanNumber .addRentMoney').eq(i).val());
                    }
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            layer.close(thisIndex);
                            location.reload();
                        }
                    });
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case '13':
            layer.open({
                type: 1,
                area: ['950px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增分户', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#SplitHouse'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('SplitHouseNum','0,1');
                    $('#SplitQuery').off('click');
                    $('#SplitQuery').on('click', function() {
                        var HouseID = $("#SplitHouseNum").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#SplitBanID").text(res.data.BanID);
                            $("#SplitBanAddress").text(res.data.BanAddress);
                            $("#SplitFloorID").text(res.data.FloorID);
                            $("#SplitTenantName").text(res.data.TenantName);
                            $("#SplitTenantTel").text(res.data.TenantTel);
                            $("#SplitTenantNumber").text(res.data.TenantNumber);
                            $("#SplitCreateTime").text(res.data.CreateTime);
                            $("#SplitHouseArea").text(res.data.HouseArea);
                            $("#SplitLeasedArea").text(res.data.LeasedArea);
                            console.log(res.data.RoomNumbers[13]);
                            var arr = [];
                            var RoomNumbers = res.data.RoomNumbers;
                            for (var i in RoomNumbers) {
                                arr.push(i);
                            }
                            for (var n = 0; n < arr.length; n++) {
                                var RoomHtml = '<li><input type="checkbox"><i class="SplitNum cur">' + arr[n] + '</i><input type="hidden" value="' + RoomNumbers[arr[n]] + '"/></li>';
                                $('.SplitRoom').append(RoomHtml);
                            }
                            // for(var i=0;i<RoomNumL;i++){
                            // 	var RoomHtml = '<li><label><input type="checkbox"><i>'+res.data.RoomNumbers[i]+'</i><input type="text" name=SplitRoom[]/></label></li>';
                            // 	$('.SplitRoom').append(RoomHtml);
                            // }
                            // $('.SplitRoom').append()
                        });
                    });
                    $('.SplitRoom').on('click', '.SplitNum', function() {
                        var val = $(this).next().val();
                        console.log(val);
                        $.get('/ph/Room/detail/RoomID/' + val, function(res) {
                            res = JSON.parse(res);
                            $("#DRoomID").text(res.data.RoomID);
                            $("#DBanID").text(res.data.BanID);
                            $("#DHouseID").text(res.data.HouseID);
                            $("#DRoomType").text(res.data.RoomType);
                            $("#DUnitID").text(res.data.UnitID);
                            $("#DFloorID").text(res.data.FloorID);
                            $("#DRentPoint").text(res.data.RentPoint);
                            $("#DUseArea").text(res.data.UseArea);
                            $("#DLeasedArea").text(res.data.LeasedArea);
                            $("#DItems").text(res.data.Items);
                            $("#DRoomNumber").text(res.data.RoomNumber);
                            $('.BanAddress').text(res.data.BanAddress);
                            $('#RoomNumber').text(res.data.RoomNumber);
                            layer.open({
                                type: 1,
                                area: ['990px', '600px'],
                                resize: false,
                                zIndex: 100,
                                title: ['房间明细', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                content: $('#RoomDetail'),
                                btn: ['确定', '取消'],
                                success: function() {}
                            });
                        })
                    });
                    houseQuery.action('SplitAddNum','0,1');
                    $('#SplitAddQuery').off('click');
                    $('#SplitAddQuery').on('click', function() {
                        var HouseID = $("#SplitAddNum").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#SplitAddID").text(res.data.BanID);
                            $("#SplitAddAddress").text(res.data.BanAddress);
                            $("#SplitAddFloor").text(res.data.FloorID);
                            $("#SplitAddName").text(res.data.TenantName);
                            $("#SplitAddTel").text(res.data.TenantTel);
                            $("#SplitAddNumber").text(res.data.TenantNumber);
                            $("#SplitAddTime").text(res.data.CreateTime);
                            $("#SplitAddArea").text(res.data.HouseArea);
                            $("#SplitAddLeased").text(res.data.LeasedArea);
                        });
                    });
                    new file({
                        button: "#SplitApplication",
                        show: "#SplitApplicationShow",
                        upButton: "#SplitApplicationUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "书面申请（双方）"
                    });
                    new file({
                        button: "#SplitRegister",
                        show: "#SplitRegisterShow",
                        upButton: "#SplitRegisterUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "户口簿"
                    });
                    new file({
                        button: "#SplitCard",
                        show: "#SplitCardShow",
                        upButton: "#SplitCardUp",
                        size: 102400,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "身份证（双方）"
                    });
                    new file({
                        button: "#SplitRent",
                        show: "#SplitRentShow",
                        upButton: "#SplitRentUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "租赁合同"
                    });
                    new file({
                        button: "#SplitAdvice",
                        show: "#SplitAdviceShow",
                        upButton: "#SplitAdviceUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "共同居住人意见书（签字）"
                    });
                },
                yes: function(thisIndex) {
                    var RoomNums = [];
                    for (var j = 0; j < $('.SplitRoom').children().length; j++) {
                        if ($('.SplitRoom li').eq(j).children().eq(0).prop('checked') === true) {
                            console.log($('.SplitRoom li').eq(j).children().eq(0).prop('checked'));
                            RoomNums.push($('.SplitRoom li').eq(j).children().eq(2).prop('value'));
                        }
                    }
                    var formData = fileTotall.getArrayFormdata();
                    formData.append("HouseID", $("#SplitHouseNum").val());
                    formData.append("SplitHouseID", $("#SplitAddNum").val());
                    formData.append('RoomNum', RoomNums);
                    formData.append("type", 13);
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            layer.close(thisIndex);
                            location.reload();
                        }
                    });
                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
        case '14':
            layer.open({
                type: 1,
                area: ['700px', '750px'],
                resize: false,
                zIndex: 100,
                title: ['新增楼栋调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#buildingAdjust'),
                btn: ['确定', '取消'],
                success: function() {
                    banQuery.action('buildingAdjustBan','1');
					new file({
					    button: "#buildingProperty",
					    show: "#buildingPropertyShow",
					    upButton: "#buildingPropertyUp",
					    size: 102400,
					    url: "/ph/ChangeApply/add",
					    ChangeOrderID: '',
					    Type: 1,
					    title: "产权证"
					});
					new file({
					    button: "#buildingTransfer",
					    show: "#buildingTransferShow",
					    upButton: "#buildingTransferUp",
					    size: 102400,
					    url: "/ph/ChangeApply/add",
					    ChangeOrderID: '',
					    Type: 1,
					    title: "产权清册及其他"
					});
                    $('#buildingAdjustQuery').off('click');
                    $('#buildingAdjustQuery').on('click', function() {
                        var BanID = $("#buildingAdjustBan").val();
                        console.log(BanID);
                        $.get('/ph/Api/get_ban_info/BanID/' + BanID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg,{time:4000});
                            $("#buildingAdjustAddress").text(res.data.BanAddress);
                            $("#buildingAdjustOwnerType").text(res.data.OwnerType);
                            $("#buildingAdjustBanUnitNum").text(res.data.BanUnitNum);
                            $("#buildingAdjustCoveredArea").text(res.data.CoveredArea);
                            $("#buildingAdjustTotalArea").text(res.data.TotalArea);
                            $("#buildingAdjustBanUsearea").text(res.data.BanUsearea);
                            $("#buildingAdjustTotalOprice").text(res.data.TotalOprice);
                            $("#buildingAdjustBanPrerent").text(res.data.PreRent);
                            $("#beforeAdjustDamageGrade").text(res.data.DamageGrade);
                            $("#beforeAdjustStructureType").text(res.data.StructureType);
                        });
                    });
                },
                yes: function(thisIndex, layero) {
                     var formData = fileTotall.getArrayFormdata() || new FormData();
                    formData.append("BanID", $("#buildingAdjustBan").val());
                    formData.append("remark", $("#buildingAdjustReason").val());
                    formData.append("afterAdjustDamageGrade", $("#afterAdjustDamageGrade").val());
                    formData.append("afterAdjustStructureType", $("#afterAdjustStructureType").val());
					formData.append("afterAdjustadd", $("#afterAdjustadd").val());
                    formData.append("type", 14);
					//console.log($("#buildingPropertyShow").length);
					if($("#buildingPropertyShow").html()=="")
						{
							layer.msg("产权证必填！",{time:4000});
							return false;
							
						}
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            if(res.retcode == '2000'){
                                layer.close(thisIndex);
                                location.reload();
                            }
                        }
                    });

                },
                end: function() {
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_content").text('');
                    $(".img_content").text('');
                    $("select").val('');
                    location.reload();
                }
				
            });
            break;
        case '15': case '16':
           // $(".batchRent").show();
            var value;
            var house_array = [];

            console.log(checkId);

            var thisLayer = layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                title: ['租金调整（批量）', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: $('#batchRent'),
                btn:['保存','取消'],
                success: function(){
                    $('.type_3').hide();
                    $('.type_15').show();
                    var fun = new getBanList();
                    // fun.getData('/ph/Api/get_all_ban',15);
                    $('#banLinkSearch').click(function(){
                        fun.getSearchData('/ph/Api/get_all_ban',$('.getOwnerType').val(),$('#banLinkInput').val(),checkId);
                    });
                    $('#batchRentQuery').off('click');
                    $('#batchRentQuery').on('click', function(){
                        fun.getSearchData('/ph/Api/get_all_ban',$('.getOwnerType').val(),$('#banLinkInput').val(),checkId);
                        $('#pauseHouseAdd').empty();
                        var ban_link_house = layer.open({
                            type: 1,
                            area: ['990px','780px'],
                            resize: false,
                            zIndex: 100,
                            title: ['房屋选择', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                            content: $('#banLinkHouseForm'),
                            btn: ['确定', '取消'],
                            success: function() {

                            },
                            yes: function() {
                                var HousePrerent = 0;
                                var count = 0;
                                var form_str = '';//table表字符串化(因为现在数据没有筛选)
                                house_array = [];
                                var type = $('#pauseHouseChoose tr:eq(0) td:eq(2)').text();
                                for(var i = 0;i <$('#pauseHouseChoose tr').length;i++ ){
                                    if($("#pauseHouseChoose .house_check:eq("+i+") input[type='checkbox']").is(':checked')){
                                        count++;
                                        form_str += '<tr>\
                                            <td style="width:200px;">'+count+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(2)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(3)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(4)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text()+'</td>\
                                        </tr>';
                                        HousePrerent += parseFloat($("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text());
                                        house_array.push($("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text());
                                    }
                                }
                                $('#batchBanID').text(fun.initData.BanID);
                                $('#batchBanAddress').text(fun.initData.BanAddress);
                                $('#batchOwnerType').text(fun.initData.OwnerType);
                                $('#batchHousePrerent').text(fun.initData.PreRent);
                                $('#batchHouseMoney').text(HousePrerent.toFixed(2));
                                
                                $('#batchHouseDetail').empty();
                                $('#batchHouseDetail').append(form_str);
                                layer.close(ban_link_house);
                            },
                            end: function() {

                            }
                        });
                    });
                },
                yes:function(thisIndex){
                    console.log(checkId);
                    var data = new FormData();
                    data.append('banID',$('#batchBanID').text());
                    data.append('type',checkId);
                    house_array.forEach(function(value,index){
                        data.append("houseID[]",value);
                    });
                    data.append('batchReason',$('#batchReason').val());
                    data.append('diff',$('#batchHouseMoney').text());
                    // data.append('table_str',form_str);
                    console.log(data);
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg,{time:4000});
                            if(res.retcode == '2000'){
                                layer.close(thisIndex);
                                location.reload();
                            }
                        }
                    });
                },
                end:function(){
                    $("input[type='text']").val('');
                    $("input[type='number']").val('');
                    $(".label_p_style").text('');
                    $("select").val('');
                    location.reload();
                }
            });
            break;
			 case '17':
			   // $(".batchRent").show();
			    var value;
			    var house_array = [];
			
			    console.log(checkId);
			
			    var thisLayer = layer.open({
			        type: 1,
			        area: ['990px', '700px'],
			        resize: false,
			        title: ['租金调整(仅针对楼层调整后)', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
			        zIndex: 100,
			        content: $('#batchRent'),
			        btn:['保存','取消'],
			        success: function(){
			            $('.type_3').hide();
			            $('.type_15').show();
			            var fun = new getBanList();
			            // fun.getData('/ph/Api/get_all_ban',15);
			            $('#banLinkSearch').click(function(){
			                fun.getSearchData('/ph/Api/get_change_ban',$('.getOwnerType').val(),$('#banLinkInput').val(),checkId);
			            });
			            $('#batchRentQuery').off('click');
			            $('#batchRentQuery').on('click', function(){
			                fun.getSearchData('/ph/Api/get_change_ban',$('.getOwnerType').val(),$('#banLinkInput').val(),checkId);
			                $('#pauseHouseAdd').empty();
			                var ban_link_house = layer.open({
			                    type: 1,
			                    area: ['990px','780px'],
			                    resize: false,
			                    zIndex: 100,
			                    title: ['房屋选择', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
			                    content: $('#banLinkHouseForm'),
			                    btn: ['确定', '取消'],
			                    success: function() {
			
			                    },
			                    yes: function() {
			                        var HousePrerent = 0;
			                        var count = 0;
			                        var form_str = '';//table表字符串化(因为现在数据没有筛选)
			                        house_array = [];
			                        var type = $('#pauseHouseChoose tr:eq(0) td:eq(2)').text();
			                        for(var i = 0;i <$('#pauseHouseChoose tr').length;i++ ){
			                            if($("#pauseHouseChoose .house_check:eq("+i+") input[type='checkbox']").is(':checked')){
			                                count++;
			                                form_str += '<tr>\
			                                    <td style="width:200px;">'+count+'</td>\
			                                    <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text()+'</td>\
			                                    <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(2)").text()+'</td>\
			                                    <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(3)").text()+'</td>\
			                                    <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(4)").text()+'</td>\
			                                    <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text()+'</td>\
			                                </tr>';
			                                HousePrerent += parseFloat($("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text());
			                                house_array.push($("#pauseHouseChoose .house_check:eq("+i+") td:eq(1)").text());
			                            }
			                        }
			                        $('#batchBanID').text(fun.initData.BanID);
			                        $('#batchBanAddress').text(fun.initData.BanAddress);
			                        $('#batchOwnerType').text(fun.initData.OwnerType);
			                        $('#batchHousePrerent').text(fun.initData.PreRent);
			                        $('#batchHouseMoney').text(HousePrerent.toFixed(2));
			                        
			                        $('#batchHouseDetail').empty();
			                        $('#batchHouseDetail').append(form_str);
			                        layer.close(ban_link_house);
			                    },
			                    end: function() {
			
			                    }
			                });
			            });
			        },
			        yes:function(thisIndex){
			            console.log(checkId);
			            var data = new FormData();
			            data.append('banID',$('#batchBanID').text());
			            data.append('type',checkId);
			            house_array.forEach(function(value,index){
			                data.append("houseID[]",value);
			            });
			            data.append('batchReason',$('#batchReason').val());
			            data.append('diff',$('#batchHouseMoney').text());
			            // data.append('table_str',form_str);
			            console.log(data);
			            $.ajax({
			                type: "post",
			                url: "/ph/ChangeApply/add",
			                data: data,
			                processData: false,
			                contentType: false,
			                success: function(res) {
			                    res = JSON.parse(res);
			                    layer.msg(res.msg,{time:4000});
			                    if(res.retcode == '2000'){
			                        layer.close(thisIndex);
			                        location.reload();
			                    }
			                }
			            });
			        },
			        end:function(){
			            $("input[type='text']").val('');
			            $("input[type='number']").val('');
			            $(".label_p_style").text('');
			            $("select").val('');
			            location.reload();
			        }
			    });
			    break;
				case '18':
				//输入框不能为空
				function initialvalue(){
					$(".j-house-box tbody tr").each( function(){
						if($(this).find(".house_original input").val()==""){
							$(this).find(".house_original input").val(0);
						}
						if($(this).find(".house_builtuparea input").val()==""){
							$(this).find(".house_builtuparea input").val(0);
						}
					})	
				}
				   layer.open({
				       type: 1,
				       area: ['700px', '750px'],
				       resize: false,
				       zIndex: 100,
				       title: ['楼栋注销', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
				       content: $('#buildingcancel'),
				       btn: ['确定', '取消'],
				       success: function() {
				           banQuery.action('buildingcancelQueryBan','1');
				   		new file({
				   		    button: "#cancelUploadReport",
				   		    show: "#cancelUploadReportShow",
				   		    upButton: "#cancelUploadReportUp",
				   		    size: 102400,
				   		    url: "/ph/ChangeApply/add",
				   		    ChangeOrderID: '',
				   		    Type: 1,
				   		    title: "注销报告"
				   		});
				   		new file({
				   		    button: "#CollectionDetails",
				   		    show: "#CollectionDetailsShow",
				   		    upButton: "#CollectionDetails",
				   		    size: 102400,
				   		    url: "/ph/ChangeApply/add",
				   		    ChangeOrderID: '',
				   		    Type: 1,
				   		    title: "征收明细表"
				   		});
				           $('#buildingcancelQuery').off('click');
				           $('#buildingcancelQuery').on('click', function() {
				               var BanID = $("#buildingcancelQueryBan").val();
				               console.log(BanID);
				               $.get('/ph/Api/get_ban_info/ChangeType/18/BanID/' + BanID, function(res) {
				                   res = JSON.parse(res);
				                   console.log(res);
				                   layer.msg(res.msg,{time:4000});
                                   $("#buildingcancelAddress").text(res.data.BanAddress);
				                   $("#floor_number").text(res.data.BanID);
								   $('.j-house-box tbody').html('');
								  if(res){ 
                                      var HouseInfo = res.data.HouseInfo;
									  for(var i=0;i<HouseInfo.length;i++) {
											var trData ='<tr>\
														<td class="house_number"><input type="hidden" name="house_id['+i+']" value="'+HouseInfo[i].HouseID+'">'+HouseInfo[i].HouseID+'</td>\
														<td class="house_lessee"><input type="hidden" name="TenantName['+i+']" value="'+HouseInfo[i].TenantName+'">'+HouseInfo[i].TenantName+'</td>\
														<td class="house_original"><input type="number" min="0" class="layui-input" lay-verify="required" name="house_original['+i+']" value="'+HouseInfo[i].OldOprice+'"></td>\
														<td class="house_builtuparea"><input type="number" min="0" class="layui-input" lay-verify="required" name="house_builtuparea['+i+']" value="'+HouseInfo[i].HouseArea+'"></td>\
														<td class="house_prescribed"><input type="hidden" name="HousePrerent['+i+']" value="'+HouseInfo[i].HousePrerent+'">'+HouseInfo[i].HousePrerent+'</td>\
														<td class="house_rentalarea"><input type="hidden" name="LeasedArea['+i+']" value="'+HouseInfo[i].LeasedArea+'">'+HouseInfo[i].LeasedArea+'</td>\
													</tr>';
										  initialvalue();
										  $('.j-house-box tbody').append(trData);
									  }
									  
								   var sumrule =0,//规定租金异动初始金额
								           sumruleold =0;//规定租金异动后金额
								       var sumuse =0,//使用面积异动初始面积
								           sumuseold =0;//使用面积异动后面积
								       var sumbuildings =0,//建筑面积异动初始面积
								           sumbuildingsold =0;//建筑面积异动后面积
								       var sumoriginal =0,//房屋原价异动初始面积
								           sumoriginalold =0;//房屋原价异动后面积
								      $("#floor_prescribed label").text(res.data.PreRent);//获取表格规定租金
								      $("#floor_prescribed input").val(res.data.PreRent);//获取隐藏域的值
								      $("#floor_areaofuse label").text(res.data.BanUsearea);//获取表格使用面积
								      $("#floor_areaofuse input").val(res.data.BanUsearea);//获取隐藏域的值
								      $("#floor_builtuparea label").text(res.data.TotalArea);//获取表格建筑面积
								      $("#floor_builtuparea input").val(res.data.TotalArea);//获取隐藏域的值
								      $("#floor_original label").text(res.data.TotalOprice);//获取表格房屋原价
								      $("#floor_original input").val(res.data.TotalOprice);//获取隐藏域的值						   
								  //基数异动c初始值
								   var trList = $(".j-house-box tbody").children("tr");
								   for (var k=0;k<trList.length;k++) {
									   var tdArrs = trList.eq(k).find("td"); //遍历td
									    //规定租金计算
									   sumrule += parseFloat(tdArrs.eq(4).text()).toFixed(2)*100;
									   $(".cancel_change_1 label").text(sumrule.toFixed(2) / 100);
									   $(".cancel_change_1 input").val(sumrule.toFixed(2) / 100)//获取隐藏域的值
									   sumruleold = parseFloat($('.cancel_before_1 label').text()).toFixed(2)*100 -sumrule ;
									   $('.cancel_after_1 label').text(sumruleold.toFixed(2) / 100);
									   $('.cancel_after_1 input').val(sumruleold.toFixed(2) / 100);//获取隐藏域的值
									   //使用面积计算
									   sumuse += parseFloat(tdArrs.eq(5).text()).toFixed(2)*100;
									   $(".cancel_change_2 label").text(sumuse.toFixed(2) / 100);
									   $(".cancel_change_2 input").val(sumuse.toFixed(2) / 100);//获取隐藏域的值
									   sumuseold = parseFloat($('.cancel_before_2 label').text()).toFixed(2)*100 -sumuse ;
									   $('.cancel_after_2 label').text(sumuseold.toFixed(2) / 100);
									   $('.cancel_after_2 input').val(sumuseold.toFixed(2) / 100);//获取隐藏域的值
									   //建筑面积
										sumbuildings += parseFloat(tdArrs.eq(3).find("input").val()).toFixed(2)*100;
										$(".cancel_change_3 label").text(sumbuildings.toFixed(2) / 100);
										$(".cancel_change_3 input").val(sumbuildings.toFixed(2) / 100);//获取隐藏域的值
										sumbuildingsold = parseFloat($('.cancel_before_3 label').text()).toFixed(2)*100 -sumbuildings ;
										$('.cancel_after_3 label').text(sumbuildingsold.toFixed(2) / 100);
										$('.cancel_after_3 input').val(sumbuildingsold.toFixed(2) / 100);//获取隐藏域的值
									   //房屋原价
										sumoriginal += parseFloat(tdArrs.eq(2).find("input").val()).toFixed(2)*100;
										$(".cancel_change_4 label").text(sumoriginal.toFixed(2) / 100);
										$(".cancel_change_4 input").val(sumoriginal.toFixed(2) / 100);//获取隐藏域的值
										sumoriginalold = parseFloat($('.cancel_before_4 label').text()).toFixed(2)*100 -sumoriginal ;
										$('.cancel_after_4 label').text(sumoriginalold.toFixed(2) / 100);
										$('.cancel_after_4 input').val(sumoriginalold.toFixed(2) / 100);//获取隐藏域的值
								     }
								       //输入框建筑面积改变重新计算
								       $(".house_builtuparea").bind("input propertychange",function(){
								       	initialvalue();
								       	sumbuildings = 0;
								       	var trList = $(".j-house-box tbody").children("tr");
								       	for (var j=0;j<trList.length;j++) {
								       		var tdArr = trList.eq(j).find("td"); //遍历td  
								       			sumbuildings += parseFloat(tdArr.eq(3).find("input").val()).toFixed(2)*100;//输入框改变建筑面积
								       			$(".cancel_change_3 label").text(sumbuildings.toFixed(2) / 100);
								       			$(".cancel_change_3 input").val(sumbuildings.toFixed(2) / 100);//获取隐藏域的值
								       			sumbuildingsold = parseFloat($('.cancel_before_3 label').text()).toFixed(2)*100 -sumbuildings ;
								       			$('.cancel_after_3 label').text(sumbuildingsold.toFixed(2) / 100);
								       			$('.cancel_after_3 input').val(sumbuildingsold.toFixed(2) / 100);//获取隐藏域的值
								       		
								       	}
								       });
								       //输入框房屋原价改变重新计算
								       $(".house_original").bind("input propertychange",function(){
								       	initialvalue();
								       	sumoriginal = 0;
								       	var trList = $(".j-house-box tbody").children("tr");
								       	for (var j=0;j<trList.length;j++) {
								       		var tdArr = trList.eq(j).find("td"); //遍历td  
								       			sumoriginal += parseFloat(tdArr.eq(2).find("input").val()).toFixed(2)*100;
								       			$(".cancel_change_4 label").text(sumoriginal.toFixed(2) / 100);
								       			$(".cancel_change_4 input").val(sumoriginal.toFixed(2) / 100);//获取隐藏域的值
								       			sumoriginalold = parseFloat($('.cancel_before_4 label').text()).toFixed(2)*100 -sumoriginal ;
								       			$('.cancel_after_4 label').text(sumoriginalold.toFixed(2) / 100);
								       			$('.cancel_after_4 input').val(sumoriginalold.toFixed(2) / 100);//获取隐藏域的值
								       	}
								       });
								   
								   }
								   else{
									   Layer.msg("没数据！");
								   }
								   
				               });
							   
							   
							   
				           });
				       },
				       yes: function(thisIndex, layero) {
						   
				            var formData = fileTotall.getArrayFormdata() || new FormData();
				            //formData.append("type", 18);
						    //formData.append('cause',$('#buildingcancelReason').val())//事由
						  /* formData.append('floor_number',$('#floor_number').text())//楼栋编号
						   formData.append('floor_prescribed',$('#floor_prescribed label').text())//异动前规定租金
						   formData.append('cancel_change_1',$('.cancel_change_1 label').text())//异动规定租金
						   formData.append('changes_floor_prescribed',$('#changes_floor_prescribed label').text())//异动后规定租金
						   formData.append('floor_areaofuse',$('#floor_areaofuse').text())//异动前使用面积
						   formData.append('cancel_change_2',$('.cancel_change_2 label').text())//异动使用面积
						   formData.append('changes_floor_areaofuse',$('#changes_floor_areaofuse label').text())//异动后使用面积
						   formData.append('floor_builtuparea',$('#floor_builtuparea').text())//异动前建筑面积
						   formData.append('cancel_change_3',$('.cancel_change_3 label').text())//异动建筑面积
						   formData.append('changes_floor_builtuparea',$('#changes_floor_builtuparea label').text())//异动后建筑面积
						   formData.append('floor_builtuparea',$('#floor_original').text())//异动前房屋原价
						   formData.append('cancel_change_4',$('.cancel_change_4 label').text())//异动房屋原价
						   formData.append('changes_floor_original',$('#changes_floor_original label').text())//异动后房屋原价 */
						   var formdatas = $('#buildingcancel').serializeArray();
						   console.log(formdatas);
						   for(let j in formdatas)  
						   {
							   formData.append(formdatas[j].name,formdatas[j].value)//异动前规定租金
						   };
						   formData.append('type',18);
						   formData.append('cancelReason',$('#buildingcancelReason').val())
						   formData.append('banID',$('#floor_number').text())
						   /* var cancelReason = $('#buildingcancelReason').val();
                           var banID = $('#floor_number').text();

                           formdatas += '&type=18&cancelReason='+cancelReason+'&banID='+banID; */
						   //formdatas.split("&");
                          // console.log(formdatas.split("&"));
                           //console.log(formdatas);
                            //var jsondata = eval('(' + formdatas + ')');
				           $.ajax({
				               type: "post",
				               url: "/ph/ChangeApply/add",
				               data: formData,
				               processData: false,
				               contentType: false,
				               success: function(res) {
				                   res = JSON.parse(res);
				                   layer.msg(res.msg,{time:4000});
				                   if(res.retcode == '2000'){
				                       layer.close(thisIndex);
				                       location.reload();
				                   }
				               }
				           });
				   
				       },
				       end: function() {
				           $("input[type='text']").val('');
				           $("input[type='number']").val('');
				           $(".label_content").text('');
				           $(".img_content").text('');
				           $("select").val('');
				           location.reload();
				       }
				   	
				   });
				    break;
        default:
            layer.msg('请选择选项！',{time:4000});
    }
});
//流程配置函数
function processState(id, res) {
    var ConfigLength = res.data.config.config.length;
    var RecordLength = res.data.record.length;
    var FatherDom = $(id);
    var status = parseInt(res.data.config.status) * 2 - 1;
    FatherDom.empty();
    for (var i = 0; i < ConfigLength; i++) {
        var SpanDom = $('<span class="process_style">' + res.data.config.config[i] + '</span><span>——></span>');
        FatherDom.append(SpanDom);
    }
    FatherDom.find('span').last().remove();
    for (var j = 0; j < status; j++) {
        if (j % 2 == 0) {
            FatherDom.find('span').eq(j).addClass('process_style_active');
        } else {
            FatherDom.find('span').eq(j).addClass('line_style');
        }
    }
    for (var k = 1; k <= RecordLength; k++) {
        if (res.data.record[k - 1].Status == 2) {
            var RecordDom = $("<p style='font-weight:600;'>" + k + "." + res.data.record[k - 1].RoleName + "［" + res.data.record[k - 1].UserNumber + "］于" + res.data.record[k - 1].CreateTime + res.data.record[k - 1].Step + "；</p>");
        } else {
            var RecordDom = $("<p style='font-weight:600;'>" + k + "." + res.data.record[k - 1].RoleName + "［" + res.data.record[k - 1].UserNumber + "］于" + res.data.record[k - 1].CreateTime + res.data.record[k - 1].Status + "，原因：" + res.data.record[k - 1].Reson + "；</p>");
        }
        FatherDom.append(RecordDom);
    }
}
$('#DQTenant').off('click');
$('#DQTenant').click(function() {
    var ID = $('#TenantInput').val();
    console.log(ID);
    $.get('/ph/Api/get_tenant_info/TenantID/' + ID, function(res) {
        res = JSON.parse(res);
        if (res.retcode == '2000') {
            $('#TenantNameO').text(res.data.TenantName);
            $('#TenantTelO').text(res.data.TenantTel);
        } else {
            layer.msg(res.msg,{time:4000});
        }
    });
});



//暂停计租楼栋与房屋联动
function getBanList(){
    this.initData = {
        BanAddress:"",
        BanID:"",
        PreRent:null,
        OwnerType:"",
        banData:null,
        filterData:null
    };
    this.getData = function(url,type){
        var self = this;
        $.get(url, function(res) {
            res = JSON.parse(res);
            console.log(res);
            self.initData.banData = res.data;
            self.renderDom(res.data,type);
        });
    };
    this.renderDom = function(data,type){
        var self = this;
        var ban_str = '';
        if(type==3){
            for(var i = 0;i < data.length;i++){
                ban_str += '<tr>\
                    <td style="width:150px;" data-PreRent="'+data[i].PreRent+'">'+data[i].BanID+'</td>\
                    <td style="width:150px;">'+data[i].DamageGrade+'</td>\
                    <td style="width:150px;">'+data[i].StructureType+'</td>\
                    <td style="width:150px;">'+data[i].OwnerType+'</td>\
                    <td style="width:150px;">'+data[i].UseNature+'</td>\
                    <td style="width:200px;">'+data[i].AreaFour+'</td>\
                </tr>'
            }
        }else{
            for(var i = 0;i < data.length;i++){
                ban_str += '<tr>\
                    <td style="width:150px;" data-PreRent="'+data[i].PreRent+'">'+data[i].BanID+'</td>\
                    <td style="width:150px;">'+data[i].DamageGrade+'</td>\
                    <td style="width:150px;">'+data[i].StructureType+'</td>\
                    <td style="width:150px;">'+data[i].OwnerType+'</td>\
                    <td style="width:150px;">'+data[i].UseNature+'</td>\
                    <td style="width:200px;">'+data[i].AreaFour+'</td>\
                    <td style="width:150px;">'+data[i].count+'</td>\
                </tr>'
            }
        }

        $('.allChoose').prop('checked',false);
        $('#pauseBanAdd').empty();
        $('#pauseBanAdd').append($(ban_str));

        var click_flag = 0;
        $('#pauseBanAdd tr').click(function(){
            var BanID = $(this).find('td').eq(0).text();
            var BanAddress = $(this).find('td').eq(5).text();
            var OwnerType = $(this).find('td').eq(3).text();
            var PreRent = $(this).find('td').eq(0).attr('data-PreRent');
            self.initData.BanAddress = BanAddress;
            self.initData.BanID = BanID;
            self.initData.OwnerType = OwnerType;
            self.initData.PreRent = PreRent;
            banLinkHouse(BanID,BanAddress,type);
            $('#pauseHouseChoose').empty();
            self.setColor($(this),'#pauseBanAdd tr');
        })
    };
    this.search = function(val){
        console.log(val);
        this.initData.filterData = this.initData.banData.filter(function(data){
            return data.AreaFour.indexOf(val) > -1;
        })
        this.renderDom(this.initData.filterData,3);
    };
    this.getSearchData = function(url,ownerType,address,type){
        var self = this;
        var load_2 = layer.load();//加载动画
        $.post(url,{OwnerType:ownerType,AreaFour:address,flag:true,ChangeType:type}, function(res) {
            res = JSON.parse(res);
            layer.close(load_2);//加载动画结束
            console.log(res);
            self.initData.banData = res.data;
            self.renderDom(res.data,type);
        });
    };
    this.setColor = function(this_dom,dom){
        var thisIndex = this_dom.index(dom);
        if(click_flag%2 == 0){
            $(dom).eq(click_flag).find('td').css('background-color','#f9f9f9');
        }else{
            $(dom).eq(click_flag).find('td').css('background-color','#ffffff');
        }
        click_flag = thisIndex;
        console.log(thisIndex);
        $(dom).eq(thisIndex).find('td').css('background','#DEF2FF');
    };
}


function banLinkHouse(BanID,BanAddress,type){
    if(type == 3){
        var get_url = '/ph/Api/get_all_house/BanID/'+BanID+'/ChangeType/'+type;
    }else if(type == 15 || type == 16 || type == 17){
        var get_url = '/ph/Api/get_house_diff?BanID='+BanID+'&ChangeType='+type;
    }
    var load_1 = layer.load();//加载动画
    $.get(get_url,function(res){
        layer.close(load_1);//加载动画结束
        res = JSON.parse(res);
        console.log(res);
        var house_str = '';
        if(type == 3){
            for(var i = 0;i < res.data.length;i++){
                //console.log(res.data[i].StatusType);
                if(res.data[i].StatusType == 0){
                   house_str += '<tr class="house_check">\
                        <td style="width:150px;"><input type="checkbox"></td>\
                        <td style="width:150px;">'+res.data[i].HouseID+'</td>\
                        <td style="width:150px;">'+res.data[i].OwnerType+'</td>\
                        <td style="width:150px;">'+res.data[i].UseNature+'</td>\
                        <td style="width:150px;">'+res.data[i].TenantName+'</td>\
                        <td style="width:350px;">'+res.data[i].HousePrerent+'</td>\
                    </tr>';
                }else if(res.data[i].StatusType == 1){ //暂停计租的
                    house_str += '<tr class="j-suspend" disabled="disabled">\
                        <td style="width:150px;"><input type="checkbox" disabled="disabled"></td>\
                        <td style="width:150px;">'+res.data[i].HouseID+'</td>\
                        <td style="width:150px;">'+res.data[i].OwnerType+'</td>\
                        <td style="width:150px;">'+res.data[i].UseNature+'</td>\
                        <td style="width:150px;">'+res.data[i].TenantName+'</td>\
                        <td style="width:350px;">'+res.data[i].HousePrerent+'</td>\
                    </tr>';
                }else if(res.data[i].StatusType == 2){ //欠租的
                    house_str += '<tr class="j-arrears" disabled="disabled">\
                        <td style="width:150px;"><input type="checkbox" disabled="disabled"></td>\
                        <td style="width:150px;">'+res.data[i].HouseID+'</td>\
                        <td style="width:150px;">'+res.data[i].OwnerType+'</td>\
                        <td style="width:150px;">'+res.data[i].UseNature+'</td>\
                        <td style="width:150px;">'+res.data[i].TenantName+'</td>\
                        <td style="width:350px;">'+res.data[i].HousePrerent+'</td>\
                    </tr>';
                }
                
                
            }
        }else if(type == 15 || type == 16 || type == 17){
            for(var i = 0;i < res.data.length;i++){
                house_str += '<tr class="house_check">\
                    <td style="width:150px;"><input type="checkbox" ></td>\
                    <td style="width:150px;">'+res.data[i].HouseID+'</td>\
                    <td style="width:150px;">'+res.data[i].TenantName+'</td>\
                    <td style="width:150px;">'+res.data[i].HousePrerent+'</td>\
                    <td style="width:150px;">'+res.data[i].ApprovedRent+'</td>\
                    <td style="width:350px;color:'+((parseFloat(res.data[i].Diff)>0)?'red':'green')+'">'+res.data[i].Diff+'</td>\
                </tr>';
            }
        }

        $('.allChoose').prop('checked',false);
        $('#pauseHouseAdd').empty();
        $('#pauseHouseAdd').append($(house_str));
		
        $('#pauseHouseAdd .house_check').click(function(){
            if($(this).find("input[type='checkbox']").prop('checked')){
                $(this).find("input[type='checkbox']").prop('checked',false);
                layer.msg('已经添加！',{time:4000});
            }else{
                $(this).find("input[type='checkbox']").prop('checked',true);
                tr_add($(this),$(this).find("td").eq(1).text());
            }
        })
		//添加不能选中代码
		/* $('#pauseHouseAdd .house_check.j-arrears,#pauseHouseAdd .house_check.j-suspend').click(function(){
			 $(this).find("input[type='checkbox']").prop('checked',false);
			 layer.msg('当前状态不可点击！',{time:4000});
			 tr_remove($(this),$(this).find("td").eq(1).text());
		})	 */
		$('#pauseHouseAdd .house_check.j-arrears,#pauseHouseAdd .house_check.j-suspend').unbind(); 
        $("#pauseHouseAdd .house_check input[type='checkbox']").click(function(event){
            event.stopPropagation();
            if($(this).prop('checked')){
                tr_add($(this).parents('.house_check'),$(this).parents('.house_check').find("td").eq(1).text());
            }else{
                tr_remove($(this).parents('.house_check').find("td").eq(1).text());
            }
        })
    })
}
$('.allChoose').click(function(){
    if($(this).prop('checked')){
        $("#pauseHouseAdd .house_check input[type='checkbox']").prop('checked',true);
		//添加不能选中代码
		 $("#pauseHouseAdd .house_check.j-arrears input[type='checkbox'],#pauseHouseAdd .house_check.j-suspend input[type='checkbox']").prop('checked',false);
        for(var j = 0;j < $("#pauseHouseAdd .house_check").length;j++){
            console.log(j);
            var dom = $("#pauseHouseAdd .house_check").eq(j);
            tr_add(dom,dom.find("td").eq(1).text());
        }
    }else{
        $("#pauseHouseAdd .house_check input[type='checkbox']").prop('checked',false);
    }
})
$("#pauseHouseChoose").on("click",".house_check input[type='checkbox']",function(event){
    event.stopPropagation();
    if(!$(this).prop('checked')){
        $(this).parents('tr').remove();
    }
})
function tr_add(dom,houseID){
    var flag = false;
    for(var i = 0;i < $('#pauseHouseChoose tr').length;i++){
        if($('#pauseHouseChoose tr:eq('+i+') td:eq(1)').text() == houseID){
            flag = true;
        }
    }
    if(!flag){
        $('#pauseHouseChoose').append(dom.clone());
    }else{
        layer.msg('已经添加！',{time:4000});
    }
}

function tr_remove(houseID){
    for(var i = 0;i < $('#pauseHouseChoose tr').length;i++){
        if($('#pauseHouseChoose tr:eq('+i+') td:eq(1)').text() == houseID){
            $('#pauseHouseChoose tr:eq('+i+')').remove();
        }
    }
}





//计租表
$('#rentMeterButton,#rentMaterQuery,#newRentDetail,#cancelRentMeter').click(function() {
    $('.RentExample:gt(0)').remove();
    console.log($('.RoomDeT').hasClass('RentDate'));
    var HouseID = $('#getInfo_1').val() || $('#houseAdjustHouse').val() || $('#newRentHouseID').val()||$('#getcancel').val();
    $.get('/ph/Api/get_rent_table_detail/HouseID/' + HouseID, function(res) {
        res = JSON.parse(res);
        console.log(res);
        $('.RentBan').text(res.data.banDetail.BanID);
        $('.RentStructure').text(res.data.banDetail.StructureType);
        $('.RentAddress').text(res.data.banDetail.BanAddress);
        $('.RentPoint').text(res.data.banDetail.NewPoint);
        $('.RentName').text(res.data.houseDetail.TenantName);
        $('.RentLayer').text(res.data.houseDetail.FloorID);
        $('.RentUnit').text(res.data.houseDetail.UnitID);
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
        content: $('#RentForm')
    });
});


// 新增空租
function addEmptyRent(){
    $('.empty_rent_cancel').hide();
    layer.open({
        type: 1,
        area: ['990px', '600px'],
        resize: false,
        zIndex: 100,
        title: ['新增空租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#emptyRent'),
        btn: ['确定', '取消'],
        success: function() {
            houseQuery.action('emptyRentHouse','1');
            $('#emptyRentQuery').on("click", function() {
                var HouseID = $('#emptyRentHouse').val();
                $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                    res = JSON.parse(res);
                    $("#emptyRentBanID").text(res.data.BanID);
                    $("#emptyRentBanAddress").text(res.data.BanAddress);
                    $("#emptyRentUseNature").text(res.data.UseNature);
                    $("#emptyRentHouseUsearea").text(res.data.HouseUsearea);
                    $("#emptyRentLeasedArea").text(res.data.LeasedArea);
                    $("#emptyRentOwnTypeD").text(res.data.OwnerType);
                    $("#emptyRentmonthRent").text(res.data.HousePrerent);
                });
            });
        },
        yes: function(thisIndex) {
            if ($('#emptyRentHouse').val() == "") {
                layer.msg('房屋编号存在问题呢！！！',{time:4000});
            } else {
                var formData = new FormData();
                formData.append("type", 2);
                formData.append("emptyRentType",1);//1为新增空租，2为取消空租
                formData.append("HouseID", $('#emptyRentHouse').val());
                formData.append("emptyRentReason", $('#emptyRentReason').val());
                $.ajax({
                    type: "post",
                    url: "/ph/ChangeApply/add",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        res = JSON.parse(res);
                        layer.msg(res.msg,{time:4000});
                        if(res.retcode == '2000'){
                            layer.close(thisIndex);
                            location.reload();
                        }
                    }
                });
            }
        },
        end: function() {
            $("input[type='text']").val('');
            $("input[type='number']").val('');
            $(".label_content").text('');
            $(".img_content").text('');
            $("select").val('');
            location.reload();
        }
    });
}

// 取消空租
function cancelEmptyRent(){
    $('.empty_rent_cancel').show();
    layer.open({
        type: 1,
        area: ['990px', '600px'],
        resize: false,
        zIndex: 100,
        title: ['取消空租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
        content: $('#emptyRent'),
        btn: ['确定', '取消'],
        success: function() {
            houseQuery.action('emptyRentHouse','1');
            tenantQuery.action('emptyRentTenantID','','1');
            $('#emptyRentQuery').on("click", function() {
                var HouseID = $('#emptyRentHouse').val();
                $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                    res = JSON.parse(res);
                    $("#emptyRentBanID").text(res.data.BanID);
                    $("#emptyRentBanAddress").text(res.data.BanAddress);
                    $("#emptyRentUseNature").text(res.data.UseNature);
                    $("#emptyRentHouseUsearea").text(res.data.HouseUsearea);
                    $("#emptyRentLeasedArea").text(res.data.LeasedArea);
                    $("#emptyRentOwnTypeD").text(res.data.OwnerType);
                    $("#emptyRentmonthRent").text(res.data.HousePrerent);
                });
            });
            $('#emptyRentQueryTenantID').on("click", function() {
                var TenantID = $('#emptyRentTenantID').val();
                $.get('/ph/Api/get_tenant_info/TenantID/' + TenantID, function(res) {
                    res = JSON.parse(res);
                    $("#emptyRentTenantName").text(res.data.TenantName);
                    $("#emptyRentTenantNumber").text(res.data.TenantNumber);
                    $("#emptyRentTenantTel").text(res.data.TenantTel);
                });
            });
        },
        yes: function(thisIndex) {
            if ($('#emptyRentHouse').val() == "") {
                layer.msg('房屋编号存在问题呢！！！',{time:4000});
            } else {
                var formData = new FormData();
                formData.append("type", 2);
                formData.append("emptyRentType",2);
                formData.append("HouseID", $('#emptyRentHouse').val());
                formData.append("TenantID", $('#emptyRentTenantID').val());
                formData.append("emptyRentReason", $('#emptyRentReason').val());
                $.ajax({
                    type: "post",
                    url: "/ph/ChangeApply/add",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        res = JSON.parse(res);
                        layer.msg(res.msg,{time:4000});
                        layer.close(thisIndex);
                        location.reload();
                    }
                });
            }
        },
        end: function() {
            $("input[type='text']").val('');
            $("input[type='number']").val('');
            $(".label_content").text('');
            $(".img_content").text('');
            $("select").val('');
            location.reload();
        }
    });
}

// 目前只适用于加减法 浮点小数加减法
var  number1=0;
var  number2=0;
function numberMethod(number1,number2,method){
    var array_1 = number1.split('.');
    var array_2 = number2.split('.');
    var number = 0;
    var multiple = 0;
    var dot_diff_1 = 0;
    var dot_diff_2 = 0;
    array_1[1] = (array_1[1] == undefined ? '0' : array_1[1]);
    array_2[1] = (array_2[1] == undefined ? '0' : array_2[1]);
    if(array_1[1].length > array_2[1].length){
        multiple = array_1[1].length;
        dot_diff_2 = array_1[1].length - array_2[1].length;
    }else{
        multiple = array_2[1].length;
        dot_diff_1 = array_2[1].length - array_1[1].length;
    }
    number1 = parseFloat(array_1[0]) * Math.pow(10,multiple)+parseFloat(array_1[1]) * Math.pow(10,dot_diff_1);
    number2 = parseFloat(array_2[0]) * Math.pow(10,multiple)+parseFloat(array_2[1]) * Math.pow(10,dot_diff_2);
    if(method == '+'){
        number = (number1 + number2)/Math.pow(10,multiple);
    }else if(method == '-'){
        number = (number1 - number2)/Math.pow(10,multiple);
    }
    return number;
}