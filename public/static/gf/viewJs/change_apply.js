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
    console.log(checkId);
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
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    new file({
                        button: "#annualRentalContract",
                        show: "#annualRentalContractShow",
                        upButton: "#basicUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "年租房合同(协议)"
                    });
                    var one = new file({
                        button: "#ID",
                        show: "#IDShow",
                        upButton: "#IDUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var two = new file({
                        button: "#houseBook",
                        show: "#houseBookShow",
                        upButton: "#houseBookUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var three = new file({
                        button: "#household",
                        show: "#householdShow",
                        upButton: "#householdUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    // var four = new file({
                    //     button: "#cutRent",
                    //     show: "#cutRentShow",
                    //     upButton: "#cutRentUp",
                    //     size: 10240,
                    //     url: "/ph/ChangeApply/add",
                    //     ChangeOrderID: '',
                    //     Type: 1,
                    //     title: "证件上传"
                    // });
                    var five = new file({
                        button: "#houseSecurity",
                        show: "#houseSecurityShow",
                        upButton: "#houseSecurityUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    var six = new file({
                        button: "#nonCardinality",
                        show: "#nonCardinalityShow",
                        upButton: "#nonCardinalityUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                    new file({
                        button: "#noticeBook",
                        show: "#noticeBookShow",
                        upButton: "#noticeBookUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#getInfo_1').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
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
                                layer.msg(res.msg);
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
                    var fun = new getBanList();
                    fun.getData();
                    $('#banLinkSearch').click(function(){
                        fun.search($('#banLinkInput').val());
                    })
                    // var seven = new file({
                    //     show: "#pauseMaterialShow",
                    //     upButton: "#pauseMaterialUp",
                    //     size: 10240,
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
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(2)").text()+'</td>\
                                            <td style="width:200px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(5)").text()+'</td>\
                                            <td style="width:350px;">'+$("#pauseHouseChoose .house_check:eq("+i+") td:eq(6)").text()+'</td>\
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
                            layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                            $(".cancel_money").text('0');
                            $('.month_ul li').removeClass('active');
                            $('.month_ul').empty();
                            for(var i = 0;i < res.data.Room.length;i++){
                                var li_dom = '<li value='+res.data.Room[i].UnpaidRent+'>'+res.data.Room[i].OrderDate.substring(4)+'</li>';
                                $('.month_ul').append(li_dom);
                            }
                        });
                    });
                    var eight = new file({
                        button: "#WriteOffReport",
                        show: "#WriteOffShow",
                        upButton: "#WriteOffUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "暂停计租报告"
                    });
                    $('.month_ul').on('click','li',function(){
                        if($(this).hasClass('active')){
                            $(this).removeClass('active');
                            $('.cancel_money').text(numberMethod($('.cancel_money').text(),$(this).attr('value'),'-'));
                        }else{
                            $(this).addClass('active');
                            $('.cancel_money').text(numberMethod($('.cancel_money').text(),$(this).attr('value'),'+'));
                                
                        }
                    });
                },
                yes: function(thisIndex){
                    if ($('#oldCancelHouseID').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
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
                                layer.msg(res.msg);
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
                        layer.msg(res.msg);
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
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_1",
                            show: "#CApprovalForm_1Show",
                            upButton: "#CApprovalForm_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_1",
                            show: "#InvoiceSale_1Show",
                            upButton: "#InvoiceSale_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CHouseUse",
                            show: "#CHouseUseShow",
                            upButton: "#CHouseUseUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋使用权证（权属证明书）原件/复印件"
                        });
                        new file({
                            button: "#CLastRentInvoice_1",
                            show: "#CLastRentInvoice_1Show",
                            upButton: "#CLastRentInvoice_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_1",
                            show: "#CPublicFundInvoice_1Show",
                            upButton: "#CPublicFundInvoice_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "公共部位维修基金发票"
                        });
                        new file({
                            button: "#CCopyOfHouse",
                            show: "#CCopyOfHouseShow",
                            upButton: "#CCopyOfHouseUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "住房证复印件"
                        });
                        new file({
                            button: "#CReApproval",
                            show: "#CReApprovalShow",
                            upButton: "#CReApprovalUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改批文"
                        });
                        new file({
                            button: "#CTransactionList",
                            show: "#CTransactionListShow",
                            upButton: "#CTransactionListUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改交易清册（住户加盖私章）"
                        });
                        new file({
                            button: "#CReAgreement_1",
                            show: "#CReAgreement_1Show",
                            upButton: "#CReAgreement_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改协议书（住户加盖私章）"
                        });
                        new file({
                            button: "#CAttorney",
                            show: "#CAttorneyShow",
                            upButton: "#CAttorneyUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "委托书（加住户私章）"
                        });
                        new file({
                            button: "#CLicenseCopy",
                            show: "#CLicenseCopyShow",
                            upButton: "#CLicenseCopyUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "营业执照复印件"
                        });
                        new file({
                            button: "#CAffidavit_1",
                            show: "#CAffidavit_1Show",
                            upButton: "#CAffidavit_1Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "具结书（公司对房地局出具）"
                        });
                        new file({
                            button: "#CProofOfFund",
                            show: "#CProofOfFundShow",
                            upButton: "#CProofOfFundUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "资金证明（商业银行出具的二联单）"
                        });
                        new file({
                            button: "#CRegistration",
                            show: "#CRegistrationShow",
                            upButton: "#CRegistrationUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋登记申请书"
                        });
                        new file({
                            button: "#CAssessment",
                            show: "#CAssessmentShow",
                            upButton: "#CAssessmentUp",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "评估单"
                        });
                        new file({
                            button: "#CLegalCertificate",
                            show: "#CLegalCertificateShow",
                            upButton: "#CLegalCertificateUp",
                            size: 10240,
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
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_2",
                            show: "#CApprovalForm_2Show",
                            upButton: "#CApprovalForm_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_2",
                            show: "#InvoiceSale_2Show",
                            upButton: "#InvoiceSale_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CLastRentInvoice_2",
                            show: "#CLastRentInvoice_2Show",
                            upButton: "#CLastRentInvoice_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_2",
                            show: "#CPublicFundInvoice_2Show",
                            upButton: "#CPublicFundInvoice_2Up",
                            size: 10240,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "公共部位维修基金发票"
                        });
                        new file({
                            button: "#CReAgreement_2",
                            show: "#CReAgreement_2Show",
                            upButton: "#CReAgreement_2Up",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房改协议书"
                        });
                        new file({
                            button: "#CCopyOfProp",
                            show: "#CCopyOfPropShow",
                            upButton: "#CCopyOfPropUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "产权复印件"
                        });
                        new file({
                            button: "#CPicture",
                            show: "#CPictureShow",
                            upButton: "#CPictureUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "图纸"
                        });
                        new file({
                            button: "#CHouseInformation",
                            show: "#CHouseInformationShow",
                            upButton: "#CHouseInformationUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "房屋信息单（房地局出具）"
                        });
                        new file({
                            button: "#CReBooklet",
                            show: "#CReBookletShow",
                            upButton: "#CReBookletUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "户口簿"
                        });
                        new file({
                            button: "#CCopyOfCard",
                            show: "#CCopyOfCardShow",
                            upButton: "#CCopyOfCardUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "身份证复印件2分（夫妻双方）"
                        });
                        new file({
                            button: "#CWorkCertificate",
                            show: "#CWorkCertificateShow",
                            upButton: "#CWorkCertificateUp",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "工领证明材料复印件（退休证等）"
                        });
                        new file({
                            button: "#CAffidavit_2",
                            show: "#CAffidavit_2Show",
                            upButton: "#CAffidavit_2Up",
                            size: 1024,
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
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "购买直管公有住房申请表"
                        });
                        new file({
                            button: "#CApprovalForm_3",
                            show: "#CApprovalForm_3Show",
                            upButton: "#CApprovalForm_3Up",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "武汉市房产管理局出售单元式直管公房审批表"
                        });
                        new file({
                            button: "#InvoiceSale_3",
                            show: "#InvoiceSale_3Show",
                            upButton: "#InvoiceSale_3Up",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "售房发票"
                        });
                        new file({
                            button: "#CLastRentInvoice_3",
                            show: "#CLastRentInvoice_3Show",
                            upButton: "#CLastRentInvoice_3Up",
                            size: 1024,
                            url: "",
                            //ChangeOrderID:res.data.detail.ChangeOrderID,
                            title: "最后一月租金发票"
                        });
                        new file({
                            button: "#CPublicFundInvoice_3",
                            show: "#CPublicFundInvoice_3Show",
                            upButton: "#CPublicFundInvoice_3Up",
                            size: 1024,
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
                                layer.msg('房屋编号存在问题呢！！！');
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
                                        layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "房屋勘察表"
                    });
                    var ten = new file({
                        button: "#pic",
                        show: "#picShow",
                        upButton: "#picUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "房屋勘察表"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#houseID').val() == "") {
                        layer.msg('房屋编号不能为空！！！');
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
                                layer.msg(res.msg);
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
            var value = 1,
                new_6_value = 1;
            var thisLayer = layer.open({
                type: 1,
                area: ['910px', '200px'],
                resize: false,
                title: ['选择新发租类型', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                zIndex: 100,
                content: "<button class='am-btn am-btn-secondary NLbtn' value='1'>空租新发租</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='2'>接管</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='3'>还建</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='4'>新建</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='5'>合建</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='6'>加改扩</button>\
				<button class='am-btn am-btn-secondary NLbtn' value='9'>其他</button>",
                success: function() {
                    $('.NLbtn').off('click');
                    $('.NLbtn').on('click', function() {
                        $('.addBuild').hide();
                        value = $(this).val();
                        console.log(value);
                        layer.close(thisLayer);
                        if (value != 6) {
                            if (value != 1 && value != 6) {
                                $('#NLIDName').text('楼栋编号：');
                                $('.NLShow').hide();
                                banQuery.action('NLHouseID','0');
                            } else if (value == 1) {
                                $('#NLIDName').text('房屋编号：');
                                $('.NLShow').show();
                                houseQuery.action('NLHouseID','1');
                                tenantQuery.action('TenantInput','','0,1')
                                $('#NLAquery').off('click');
                                $('#NLAquery').on('click', function() {
                                    var HouseID = $("#NLHouseID").val()
                                    $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                                        res = JSON.parse(res);
                                        console.log(res);
                                        layer.msg(res.msg);
                                        $("#NLBanAddress").text(res.data.BanAddress);
                                        $("#NLUseNature").text(res.data.UseNature);
                                        $("#NLFloorID").text(res.data.FloorID);
                                        $("#NLOwnerType").text(res.data.OwnerType);
                                        $("#NLStructureType").text(res.data.StructureType);
                                        $("#NLHouseArea").text(res.data.HouseArea);
                                        $("#NLDamageGrade").text(res.data.DamageGrade);
                                        $("#FloorIDo").text(res.data.FloorID);
                                        //$("#TenantTel").text(res.data.TenantTel);
                                        //$("#BanAddress").text(res.data.BanAddress);
                                    });
                                });
                                $('#TenantInput').off('blur');
                                $('#TenantInput').on('blur', function() {
                                    var TenantID = $(this).val();
                                });
                            }
                            layer.open({
                                type: 1,
                                area: ['990px', '600px'],
                                resize: false,
                                zIndex: 100,
                                title: ['新增新发租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                content: $('#NewLease'),
                                btn: ['确定', '取消'],
                                success: function() {
                                    new file({
                                        button: "#NLApplication",
                                        show: "#NLApplicationShow",
                                        upButton: "#NLApplicationUp",
                                        size: 1024,
                                        url: "/ph/ChangeApply/add",
                                        ChangeOrderID: '',
                                        Type: 1,
                                        title: "暂停计租报告"
                                    });
                                },
                                yes: function(thisIndex) {
                                    if ($('#NLHouseID').val() == "") {
                                        layer.msg('房屋编号存在问题呢！！！');
                                    } else {
                                        var formData = fileTotall.getArrayFormdata();
                                        if (value != 1 && value != 6) {
                                            formData.append("BanID", $('#NLHouseID').val());
                                        } else if (value == 7) {
                                            //return false;
                                            formData.append("BanID", $('#NLHouseID').val());
                                            formData.append("HouseID", $('#NLHouseID_1').val());
                                            
                                        } else {
                                            formData.append("HouseID", $('#NLHouseID').val());
                                            formData.append("TenantID", $('#TenantInput').val());
                                        }
                                        formData.append("type", 7);
                                        formData.append("value", value);
                                        $.ajax({
                                            type: "post",
                                            url: "/ph/ChangeApply/add",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(res) {
                                                res = JSON.parse(res);
                                                layer.msg(res.msg);
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
                        } else {
                            var new_6 = layer.open({
                                type: 1,
                                area: ['400px', '200px'],
                                resize: false,
                                title: ['选择新发租类型', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                zIndex: 100,
                                content: "<button class='am-btn am-btn-secondary new_6_btn' value='7'>加建</button>\
								<button class='am-btn am-btn-secondary new_6_btn' value='8'>扩建</button>",
                                success: function() {
                                    $('.new_6_btn').off('click');
                                    $('.new_6_btn').on('click', function() {
                                        new_6_value = $(this).val();
                                        console.log(new_6_value);
                                        $('.NLShow').hide();
                                        if (new_6_value == "8") {
                                            $('.move').hide();
                                            $('#NLAquery').show();
                                            $('.addBuild').hide();
                                            houseQuery.action('NLHouseID','1');
                                            $('.expand').show();
                                            $('#NLAquery').click(function() {
                                                $('.nomalRoom').children().remove();
                                                $('.deleteRoom').children().remove();
                                                $('.modifyRoom').children().remove();
                                                $('.unconfirmedRoom').children().remove();
                                                var HouseID = $('#NLHouseID').val();
                                                $.get('/ph/Api/get_house_detail_status/HouseID/' + HouseID, function(res) {
                                                    res = JSON.parse(res);
                                                    // console.log(res.data.nomalRoom.length);
                                                    if (res.data.nomalRoom) {
                                                        var nR = res.data.nomalRoom;
                                                        for (var n = 0; n < nR.length; n++) {
                                                            $('.nomalRoom').append('<li>' + nR[n] + '</li>');
                                                        }
                                                    };
                                                    if (res.data.deleteRoom) {
                                                        var nR = res.data.deleteRoom;
                                                        for (var n = 0; n < nR.length; n++) {
                                                            $('.deleteRoom').append('<li>' + nR[n] + '</li>');
                                                        }
                                                    };
                                                    if (res.data.editRoom) {
                                                        console.log('aaaaa');
                                                        var nR = res.data.editRoom;
                                                        for (var n = 0; n < nR.length; n++) {
                                                            $('.modifyRoom').append('<li>' + nR[n] + '</li>');
                                                        }
                                                    };
                                                    if (res.data.unconfirmedRoom) {
                                                        var nR = res.data.unconfirmedRoom;
                                                        for (var n = 0; n < nR.length; n++) {
                                                            $('.unconfirmedRoom').append('<li>' + nR[n] + '</li>');
                                                        }
                                                    };
                                                })
                                                $('.expand').on('click', 'li', function() {
                                                    var val = $(this).text();
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
                                                            title: ['房间明细', 'color:#FFF;font-size:1.6rem;font-weight:600;'],
                                                            content: $('#RoomDetail'),
                                                            btn: ['确定', '取消'],
                                                            success: function() {}
                                                        });
                                                    })
                                                });
                                            })
                                        } else {
                                            $('.addBuild').show();
                                            $('#NLIDName').text('楼栋编号：');
                                            banQuery.action('NLHouseID','2');
                                            houseQuery.action('NLHouseID_1','0');
                                            houseQuery.action('NLHouseID_3','0');
                                            houseQuery.action('NLHouseID_4','0');
                                        }
                                        layer.open({
                                            type: 1,
                                            area: ['990px', '600px'],
                                            resize: false,
                                            zIndex: 100,
                                            title: ['新增新发租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                                            content: $('#NewLease'),
                                            btn: ['确定', '取消'],
                                            success: function() {
                                                new file({
                                                    button: "#NLApplication",
                                                    show: "#NLApplicationShow",
                                                    upButton: "#NLApplicationUp",
                                                    size: 1024,
                                                    url: "/ph/ChangeApply/add",
                                                    ChangeOrderID: '',
                                                    Type: 1,
                                                    title: "暂停计租报告"
                                                });
                                                new file({
                                                    button: "#NLApplication2",
                                                    show: "#NLApplicationShow2",
                                                    upButton: "#NLApplicationUp",
                                                    size: 1024,
                                                    url: "/ph/ChangeApply/add",
                                                    ChangeOrderID: '',
                                                    Type: 1,
                                                    title: "暂停计租报告"
                                                });
                                            },
                                            yes: function(thisIndex) {
                                                if ($('#NLHouseID').val() == "") {
                                                    layer.msg('房屋编号存在问题呢！！！');
                                                } else {
                                                    var aL = $('.addB').children();
                                                    var formData = fileTotall.getArrayFormdata();
                                                    if(new_6_value == "8"){
                                                        formData.append("HouseID", $('#NLHouseID').val());
                                                    }else{
                                                        formData.append("BanID", $('#NLHouseID').val());
                                                    }
                                                    formData.append("houseId[]", $('#NLHouseID_1').val());
                                                    for (var l = 0; l < aL.length; l++) {
                                                        var tem = aL.eq(l).find('input').val();
                                                        formData.append("houseId[]", tem);
                                                    }
                                                    formData.append("type", 7);
                                                    formData.append("value", new_6_value);
                                                    $.ajax({
                                                        type: "post",
                                                        url: "/ph/ChangeApply/add",
                                                        data: formData,
                                                        processData: false,
                                                        contentType: false,
                                                        success: function(res) {
                                                            res = JSON.parse(res);
                                                            layer.msg(res.msg);
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
                                    });
                                }
                            })
                        }
                    });
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
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
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
                            $('.cancelPrent').eq(0).val(res.data.HousePrerent);
                            $('.cancelHouseUsearea').eq(0).val(res.data.HouseUsearea);

                        });
                    });
                    new file({
                        button: "#housingBill",
                        show: "#housingBillShow",
                        upButton: "#housingBillUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "武汉市直管公有住房出售收入专用票据"
                    });
                    new file({
                        button: "#housingApprovalForm",
                        show: "#housingApprovalFormShow",
                        upButton: "#housingApprovalFormUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "武昌区房地局出售直管公有住房审批表"
                    });
                },
                yes:function(thisIndex){
                    if ($('#getcancel').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
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
                                layer.msg(res.msg);
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
                    $('#houseAdjustQuery').off('click');
                    $('#houseAdjustQuery').on("click", function() {
                        var houseID = $("#houseAdjustHouse").val()
                        $.get('/ph/Api/get_house_info/HouseID/' + houseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res.data.Ban);
                            ban_length = res.data.Ban.length;
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
                            }
                            $('.HARent').off('input');
                            $('.HARent').on('input',function(){
                                var this_index = $(this).index('.HARent');
                                var number_1 = res.data.Ban[this_index].PreRent;
                                var number_2 = $('.HARent').eq(this_index).val() || "0";
                                $('.HAAfterRent').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                            });
                            $('.HALeasedArea').off('input');
                            $('.HALeasedArea').on('input',function(){
                                var this_index = $(this).index('.HALeasedArea');
                                var number_1 = res.data.Ban[this_index].BanUsearea;
                                var number_2 = $('.HALeasedArea').eq(this_index).val() || "0";
                                $('.HAAfterLeasedArea').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                            });
                            $('.HABanArea').off('input');
                            $('.HABanArea').on('input',function(){
                                var this_index = $(this).index('.HABanArea');
                                var number_1 = res.data.Ban[this_index].TotalArea;
                                var number_2 = $('.HABanArea').eq(this_index).val() || "0";
                                $('.HAAfterBanArea').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                            });
                            $('.HAPrice').off('input');
                            $('.HAPrice').on('input',function(){
                                var this_index = $(this).index('.HAPrice');
                                var number_1 = res.data.Ban[this_index].TotalOprice;
                                var number_2 = $('.HAPrice').eq(this_index).val() || "0";
                                $('.HAAfterPrice').eq(this_index).val(numberMethod(number_1,number_2,'+'));
                            });
                            layer.msg(res.msg);
                        });
                    });
                },
                yes: function(thisIndex) {
                    if ($('#houseAdjustHouse').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
                    } else {
                        var formData = new FormData();
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
                                layer.msg(res.msg);
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
                                            layer.msg(res.msg);
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
                                        size: 1024,
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
                                            layer.msg(res.msg);
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
                                            layer.msg(res.msg);
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
                                        size: 1024,
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
                                            layer.msg(res.msg);
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
                    houseQuery.action('getRentAdd','1');
                    new file({
                        button: "#otherBills",
                        show: "#otherBillsShow",
                        upButton: "#otherBillsUp",
                        size: 1024,
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
                            layer.msg(res.msg);
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
                    var formData = fileTotall.getArrayFormdata();
                    formData.append("HouseID",$('#getRentAdd').val());
                    formData.append("RentAddYear",$('#RentAddYear').val());
                    formData.append("RentAddMonth",$('#RentAddMonth').val());
                    formData.append("RentAddReason",$('.RentAddReason').val());
                    formData.append("type", 11);
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                            layer.msg(res.msg);
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
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "书面申请（双方）"
                    });
                    new file({
                        button: "#SplitRegister",
                        show: "#SplitRegisterShow",
                        upButton: "#SplitRegisterUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "户口簿"
                    });
                    new file({
                        button: "#SplitCard",
                        show: "#SplitCardShow",
                        upButton: "#SplitCardUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "身份证（双方）"
                    });
                    new file({
                        button: "#SplitRent",
                        show: "#SplitRentShow",
                        upButton: "#SplitRentUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "租赁合同"
                    });
                    new file({
                        button: "#SplitAdvice",
                        show: "#SplitAdviceShow",
                        upButton: "#SplitAdviceUp",
                        size: 1024,
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
                            layer.msg(res.msg);
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
                    $('#buildingAdjustQuery').off('click');
                    $('#buildingAdjustQuery').on('click', function() {
                        var BanID = $("#buildingAdjustBan").val();
                        console.log(BanID);
                        $.get('/ph/Api/get_ban_info/BanID/' + BanID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
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
                yes: function(thisIndex) {
                    var formData = new FormData();
                    formData.append("BanID", $("#buildingAdjustBan").val());
                    formData.append("remark", $("#buildingAdjustReason").val());
                    formData.append("afterAdjustDamageGrade", $("#afterAdjustDamageGrade").val());
                    formData.append("afterAdjustStructureType", $("#afterAdjustStructureType").val());
                    formData.append("type", 14);
                    $.ajax({
                        type: "post",
                        url: "/ph/ChangeApply/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            res = JSON.parse(res);
                            layer.msg(res.msg);
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
            layer.msg('请选择选项！');
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
            layer.msg(res.msg);
        }
    });
});

//暂停计租楼栋与房屋联动
function getBanList(){
    this.initData = {
        BanAddress:"",
        BanID:"",
        OwnerType:"",
        banData:null,
        filterData:null
    };
    this.getData = function(){
        var self = this;
        $.get('/ph/Api/get_all_ban', function(res) {
            res = JSON.parse(res);
            console.log(res);
            self.initData.banData = res.data;
            self.renderDom(res.data);
        });
    };
    this.renderDom = function(data){
        var self = this;
        var ban_str = '';
        for(var i = 0;i < data.length;i++){
            ban_str += '<tr>\
                <td style="width:150px;">'+data[i].BanID+'</td>\
                <td style="width:150px;">'+data[i].DamageGrade+'</td>\
                <td style="width:150px;">'+data[i].StructureType+'</td>\
                <td style="width:150px;">'+data[i].OwnerType+'</td>\
                <td style="width:150px;">'+data[i].UseNature+'</td>\
                <td style="width:350px;">'+data[i].AreaFour+'</td>\
            </tr>'
        }
        $('#allChoose').prop('checked',false);
        $('#pauseBanAdd').empty();
        $('#pauseBanAdd').append($(ban_str));
        $('#pauseBanAdd tr').click(function(){
            var BanID = $(this).find('td').eq(0).text();
            var BanAddress = $(this).find('td').eq(5).text();
            var OwnerType = $(this).find('td').eq(3).text();
            self.initData.BanAddress = BanAddress;
            self.initData.BanID = BanID;
            self.initData.OwnerType = OwnerType;
            banLinkHouse(BanID,BanAddress);
            $('#pauseHouseChoose').empty();
        })
    };
    this.search = function(val){
        console.log(val);
        this.initData.filterData = this.initData.banData.filter(function(data){
            return data.AreaFour.indexOf(val) > -1;
        })
        this.renderDom(this.initData.filterData);
    }
}
function banLinkHouse(BanID,BanAddress){
    $.get('/ph/Api/get_all_house/BanID/'+BanID,function(res){
        res = JSON.parse(res);
        var house_str = '';
        for(var i = 0;i < res.data.length;i++){
            house_str += '<tr class="house_check">\
                <td style="width:150px;"><input type="checkbox" ></td>\
                <td style="width:150px;">'+res.data[i].HouseID+'</td>\
                <td style="width:150px;">'+res.data[i].OwnerType+'</td>\
                <td style="width:150px;">'+res.data[i].UseNature+'</td>\
                <td style="width:150px;">'+res.data[i].TenantName+'</td>\
                <td style="width:350px;">'+res.data[i].HousePrerent+'</td>\
                <td style="width:350px;display:none;">'+BanAddress+'</td>\
            </tr>';
        }
        $('#allChoose').prop('checked',false);
        $('#pauseHouseAdd').empty();
        $('#pauseHouseAdd').append($(house_str));
        $('#pauseHouseAdd .house_check').click(function(){
            if($(this).find("input[type='checkbox']").prop('checked')){
                $(this).find("input[type='checkbox']").prop('checked',false);
                layer.msg('已经添加！');
            }else{
                $(this).find("input[type='checkbox']").prop('checked',true);
                tr_add($(this),$(this).find("td").eq(1).text());
            }
        })
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
$('#allChoose').click(function(){
    if($(this).prop('checked')){
        $("#pauseHouseAdd .house_check input[type='checkbox']").prop('checked',true);
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
        layer.msg('已经添加！');
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
$('#rentMeterButton,#rentMaterQuery').click(function() {
    $('.RentExample:gt(0)').remove();
    console.log($('.RoomDeT').hasClass('RentDate'));

    var HouseID = $('#getInfo_1').val() || $('#houseAdjustHouse').val();
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
        $('.RentReceive').text(res.data.houseDetail.ReceiveRent);
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
                RentHtml += '<ul class="am-u-md-12 house_style RentDate ul-mr"><li style="width:9%" class="RentID">' + res.data.roomDetail[num][j].RoomID + '</li>' + '<li style="width:5%" class="RentNum">' + res.data.roomDetail[num][j].RoomNumber + '</li>' + '<li style="width:9%" class="RentBanA">' + res.data.roomDetail[num][j].BanID + '</li>' + '<li style="width:5%" class="RentPublic">' + res.data.roomDetail[num][j].RoomPublicStatus + '</li>' + '<li style="width:9%" class="RentHouse">' + aH[0] + '</li>' +'<li style="width:6%" class="RentPro">' + res.data.roomDetail[num][j].OwnerType + '</li>'+'<li style="width:6%" class="RentU">' + res.data.roomDetail[num][j].UnitID + '</li>' + '<li style="width:6%" class="RentL">' + res.data.roomDetail[num][j].FloorID + '</li>' + '<li style="width:7%" class="RentArea">' + res.data.roomDetail[num][j].UseArea + '</li>' + '<li style="width:7%" class="RentCut">' + res.data.roomDetail[num][j].RentPoint + '</li>' + '<li style="width:7%" class="RentLeasedArea">' + res.data.roomDetail[num][j].LeasedArea + '</li>' + '<li style="width:7%" class="RentChat">' + res.data.roomDetail[num][j].FloorPoint + '</li>' + '<li style="width:7%" class="RentMp">' + res.data.roomDetail[num][j].RoomRentMonth + '</li>' + '<li style="width:5%" class="RentStatus">' + res.data.roomDetail[num][j].Status + '</li></ul>';
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
                layer.msg('房屋编号存在问题呢！！！');
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
                        layer.msg(res.msg);
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
                layer.msg('房屋编号存在问题呢！！！');
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
                        layer.msg(res.msg);
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