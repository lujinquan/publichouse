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
                            $("#useNature").text(res.data.FloorID);
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
                    var four = new file({
                        button: "#cutRent",
                        show: "#cutRentShow",
                        upButton: "#cutRentUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "证件上传"
                    });
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
            $(".EmptyRent").show();
            layer.open({
                type: 1,
                area: ['990px', '600px'],
                resize: false,
                zIndex: 100,
                title: ['新增空租', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#derateApplyForm'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('getInfo_1','1');
                    $('#DQueryData').on("click", function() {
                        var HouseID = $('#getInfo_1').val();
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            $("#BanID").text(res.data.BanID);
                            $("#BanAddress").text(res.data.BanAddress);
                            $("#CreateTime").text(res.data.CreateTime);
                            $("#FloorID").text(res.data.BanFloorNum);
                            $("#HouseArea").text(res.data.HouseArea);
                            $("#LeasedArea").text(res.data.LeasedArea);
                            $("#TenantName").text(res.data.TenantName);
                            $("#TenantNumber").text(res.data.TenantNumber);
                            $("#TenantTel").text(res.data.TenantTel);
                            $("#FloorID").text(res.data.FloorID);
                        });
                    });
                    var six = new file({
                        button: "#EmptyReport",
                        show: "#EmptyReportShow",
                        upButton: "#EmptyReportUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "空租报告"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#getInfo_1').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
                    } else {
                        var formData = fileTotall.getArrayFormdata();
                        formData.append("type", 2);
                        formData.append("pause", $("input[name='pause']").val());
                        formData.append("HouseID", $('#getInfo_1').val());
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
                    var seven = new file({
                        show: "#pauseMaterialShow",
                        upButton: "#pauseMaterialUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        button: "#pauseMaterial",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "非基数异动核算凭单"
                    });
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
                                    if($("#pauseHouseChoose .house_check:eq("+i+") input[type='checkbox']").is(':checked') &&
                                        (type == $('#pauseHouseChoose tr:eq('+i+') td:eq(2)').text())){
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
                                    }else{
                                        layer.msg('产别有不同类型！');
                                        return false;
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
                yes:function(){
                    var data = fileTotall.getArrayFormdata();
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
                            layer.close(thisLayer);
                            location.reload();
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
            $(".WriteOff").show();
            layer.open({
                type: 1,
                area: ['990px', '600px'],
                resize: false,
                zIndex: 100,
                title: ['新增陈欠核销', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#derateApplyForm'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('getInfo_1','1');
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
                            $('#OwnerTypec').text(res.data.OwnerType);
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
                },
                yes: function(thisIndex) {
                    if ($('#getInfo_1').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
                    } else {
                        var formData = fileTotall.getArrayFormdata();
                        formData.append("HouseID", $('#getInfo_1').val());
                        formData.append("DateStart", $("input[name='DateStart']").val());
                        formData.append("DateEnd", $("input[name='DateEnd']").val());
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
            $(".cancel").show();
            var layer_cancelRent = layer.open({
                type:1,
                area:['990px', '700px'],
                resize:false,
                zIndex:99,
                title:['新增注销', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content:$('#derateApplyForm'),
                btn: ['确定', '取消'],
                success:function(){
                   $('#DQueryData').on("click", function() {
                        var HouseID = $('#getInfo_1').val();
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#BanID").text(res.data.BanID);
                            $("#BanAddress").text(res.data.BanAddress);
                            $("#CreateTime").text(res.data.CreateTime);
                            $("#useNature").text(res.data.FloorID);
                            $("#HouseUsearea").text(res.data.HouseUsearea);
                            $("#LeasedArea").text(res.data.LeasedArea);
                            $("#TenantName").text(res.data.TenantName);
                            $("#TenantNumber").text(res.data.TenantID);
                            $("#TenantTel").text(res.data.TenantTel);
                            $("#OwnTypeD").text(res.data.OwnerType);
                            $("#monthRent").text(res.data.HousePrerent);
                        });
                    });
                    houseQuery.action('getInfo_1','1');
                    new file({
                        button: "#removeOrder",
                        show: "#removeOrderShow",
                        upButton: "#removeOrderUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "拆迁令"
                    });
                    new file({
                        button: "#redLineMap",
                        show: "#redLineMapShow",
                        upButton: "#redLineMapUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "红线图"
                    });
                    new file({
                        button: "#reimbursementInvoice",
                        show: "#reimbursementInvoiceShow",
                        upButton: "#reimbursementInvoiceUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "补偿款收回的发票"
                    });
                    new file({
                        button: "#Cardinality",
                        show: "#CardinalityShow",
                        upButton: "#CardinalityUp",
                        size: 10240,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "基数异动核算凭单"
                    });
                },
                yes:function(){
                    if ($('#getInfo_1').val() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
                    } else {
                        var formData = fileTotall.getArrayFormdata();
                        formData.append("HouseID", $('#getInfo_1').val());
                        formData.append("cancelType", $('#cancelType').val());
                        formData.append("type", 8);
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
            $(".Ahide").css("display", "none");
            $(".Ahouse").text('楼栋编号：');
            layer.open({
                type: 1,
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增房屋调整', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#houseAdjust'),
                btn: ['确定', '取消'],
                success: function() {
                    banQuery.action('AdjustHouseID','1');
                    $('#DAquery').off('click');
                    $('#DAquery').on("click", function() {
                        var BanID = $("#AdjustHouseID").val()
                        $.get('/ph/Api/get_ban_info/BanID/' + BanID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#ABanID").text(res.data.BanID);
                            $("#ABanAddress").text(res.data.BanAddress);
                            $("#AFloorID").text(res.data.BanFloorNum);
                            $("#ACreateTime").text(res.data.CreateTime);
                            $("#AHouseArea").text(res.data.HouseArea);
                            $("#ALeasedArea").text(res.data.LeasedArea);
                            $("#ATenantName").text(res.data.TenantName);
                            $("#ATenantNumber").text(res.data.TenantNumber);
                            $("#ATenantTel").text(res.data.TenantTel);
                            $("#ADamageGrade").text(res.data.DamageGrade);
                            $("#AStructureType").text(res.data.StructureType);
                        });
                    });
                    var Eleven = new file({
                        button: "#AdjustSurvey",
                        show: "#AdjustSurveyShow",
                        upButton: "#AdjustSurveyUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "暂停计租报告"
                    });
                    var Twelve = new file({
                        button: "#AdjustPic",
                        show: "#AdjustPicShow",
                        upButton: "#AdjustPicUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "暂停计租报告"
                    });
                },
                yes: function(thisIndex) {
                    if ($('#AdjustHouseID').val() == "" || $("#ABanID").text() == "") {
                        layer.msg('房屋编号存在问题呢！！！');
                    } else {
                        var formData = fileTotall.getArrayFormdata();
                        formData.append("BanID", $('#ABanID').text());
                        formData.append("LevelChange", $("select[name='LevelChange']").val());
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
                content: $('#Add'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('AddHouseID','1');
                    $('#AddQuery').off('click');
                    $('#AddQuery').on('click', function() {
                        var HouseID = $("#AddHouseID").val()
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#AddBanID").text(res.data.BanID);
                            $("#AddBanAddress").text(res.data.BanAddress);
                            $("#AddFloorID").text(res.data.FloorID);
                            $("#AddTenantName").text(res.data.TenantName);
                            $("#AddTenantTel").text(res.data.TenantTel);
                            $("#AddTenantNumber").text(res.data.TenantNumber);
                            $("#AddCreateTime").text(res.data.CreateTime);
                            $("#AddHouseArea").text(res.data.HouseArea);
                            $("#AddLeasedArea").text(res.data.LeasedArea);
                            //$("#TenantTel").text(res.data.TenantTel);
                            //$("#BanAddress").text(res.data.BanAddress);
                        });
                    });
                    new file({
                        button: "#AddApplication",
                        show: "#AddApplicationShow",
                        upButton: "#AddApplicationUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "追加租金报告"
                    });
                },
                yes: function(thisIndex) {
                    var formData = fileTotall.getArrayFormdata();
                    formData.append("HouseID", $('#AddHouseID').val());
                    formData.append("AddTime", $('#AddTime').val());
                    formData.append("AddMoney", $('#AddMoney').val());
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
                content: $('#RentAdjust'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('AdjustHouseNum','1');
                    $('#AdjustQuery').off('click');
                    $('#AdjustQuery').on('click', function() {
                        var HouseID = $("#AdjustHouseNum").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#AdjustBanID").text(res.data.BanID);
                            $("#AdjustBanAddress").text(res.data.BanAddress);
                            $("#AdjustFloorID").text(res.data.FloorID);
                            $("#AdjustTenantName").text(res.data.TenantName);
                            $("#AdjustTenantTel").text(res.data.TenantTel);
                            $("#AdjustTenantNumber").text(res.data.TenantNumber);
                            $("#AdjustCreateTime").text(res.data.CreateTime);
                            $("#AdjustHouseArea").text(res.data.HouseArea);
                            $("#AdjustLeasedArea").text(res.data.LeasedArea);
                            $('.AdjustOwnType').text(res.data.OwnerType);
                            $('#AdjustPrice').text(res.data.HousePrerent);
                            $('.AdjustOwnTypeA').text(res.data.AnathorOwnerType);
                            $('#AdjustPriceA').text(res.data.AnathorHousePrerent);
                            $('input[name="AdjustPrice"]').prop('placeholder', res.data.HousePrerent);
                            $('input[name="AdjustPriceA"]').prop('placeholder', res.data.AnathorHousePrerent);
                            // $('input[name="AdjustPrice"]','input[name="AdjustPriceA"]').click(function(){})
                        });
                    });
                    new file({
                        button: "#AdjustImage",
                        show: "#AdjustImaged",
                        upButton: "#AddApplicationUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "追加租金报告"
                    });
                },
                yes: function(thisIndex) {
                    var formData = fileTotall.getArrayFormdata();
                    formData.append("HouseID", $('#AdjustHouseNum').val());
                    formData.append("AdjustPrice", $('input[name="AdjustPrice"]').val());
                    formData.append("AdjustPriceA", $('input[name="AdjustPriceA"]').val());
                    formData.append("type", 12);
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
                area: ['990px', '700px'],
                resize: false,
                zIndex: 100,
                title: ['新增并户', 'background:#2E77EF;text-align:center;color:#FFF;font-size:1.6rem;font-weight:600;'],
                content: $('#HouseHolds'),
                btn: ['确定', '取消'],
                success: function() {
                    houseQuery.action('HoldsHouseNum','1');
                    $('#HoldsQueryy').off('click');
                    $('#HoldsQuery').on('click', function() {
                        var HouseID = $("#HoldsHouseNum").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#HoldsBanID").text(res.data.BanID);
                            $("#HoldsBanAddress").text(res.data.BanAddress);
                            $("#HoldsFloorID").text(res.data.FloorID);
                            $("#HoldsTenantName").text(res.data.TenantName);
                            $("#HoldsTenantTel").text(res.data.TenantTel);
                            $("#HoldsTenantNumber").text(res.data.TenantNumber);
                            $("#HoldsCreateTime").text(res.data.CreateTime);
                            $("#HoldsHouseArea").text(res.data.HouseArea);
                            $("#HoldsLeasedArea").text(res.data.LeasedArea);
                        });
                    });
                    houseQuery.action('CancelNum','1');
                    $('#CancelQuery').off('click');
                    $('#CancelQuery').on('click', function() {
                        var HouseID = $("#CancelNum").val();
                        console.log(HouseID);
                        $.get('/ph/Api/get_house_info/HouseID/' + HouseID, function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            layer.msg(res.msg);
                            $("#CancelID").text(res.data.BanID);
                            $("#CancelAddress").text(res.data.BanAddress);
                            $("#CancelFloor").text(res.data.FloorID);
                            $("#CancelName").text(res.data.TenantName);
                            $("#CancelTel").text(res.data.TenantTel);
                            $("#CancelNumber").text(res.data.TenantNumber);
                            $("#CancelTime").text(res.data.CreateTime);
                            $("#CancelArea").text(res.data.HouseArea);
                            $("#CancelLeased").text(res.data.LeasedArea);
                        });
                    });
                    new file({
                        button: "#CancelApplication",
                        show: "#CancelApplicationShow",
                        upButton: "#CancelApplicationUp",
                        size: 1024,
                        url: "/ph/ChangeApply/add",
                        ChangeOrderID: '',
                        Type: 1,
                        title: "异动申请书"
                    });
                },
                yes: function(thisIndex) {
                    var formData = fileTotall.getArrayFormdata();
                    formData.append("HouseID", $("#HoldsHouseNum").val());
                    formData.append("SplitHouseID", $("#CancelNum").val());
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
$('#rentMeterButton').click(function() {
    $('.RentExample:gt(0)').remove();
    console.log($('.RoomDeT').hasClass('RentDate'));

    var HouseID = $('#getInfo_1').val();
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