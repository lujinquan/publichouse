
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [

    // +----------------------------------------------------------------------
    // | 映射字典
    // +----------------------------------------------------------------------

    //网站信息
    'WebSite' => 'web.gf.com',

    //添加楼栋
    'LandCertificate' => '土地证电子版',
    'RealEstate' => '不动产电子版',
    'BanImageIDS' => '楼栋其他影像电子版',

    //添加房屋
    'HouseImageIDS' => '房屋影像资料',

    //使用权变更
    //
    "transferApplication"=>"书面申请报告",
    "approveApplyReport"=>"书面申请报告",
    "acquittance"=>"收据",
    "transferMaterial_1"=>"死亡证",
    "transferMaterial_2"=>"原承租人户口",
    "transferMaterial_3"=>"现承租人户口",
    "transferMaterial_4"=>"住宅租约",
    "transferMaterial_5"=>"结婚证",
    "transferMaterial_6"=>"现承租人身份证",
    "transferMaterial_7"=>"武汉市直管公房承租人过户申请审批表",
    "transferMaterial_8"=>"武汉市直管公房承租人过户协议书",
    "transferMaterial_9"=>"共有子女材料证明",
    "transferMaterial_10"=>"离婚协议书",
    "transferMaterial_11"=>"武汉市公有房屋使用权转让协议",
    "transferMaterial_12"=>"武汉市公有住房承租权有偿转让申请书",
    "transferMaterial_13"=>"同意办理公有住房使用权转让或者代理转让协议",
    "transferMaterial_14"=>"材料承诺书",
    "transferMaterial_15"=>"家庭成员身份证明",
    "transferMaterial_16"=>"缴费承诺书",
    //
    "ReBooklet"=>"更改姓名后户口簿",
    'ReIDCard' => '更改后居民身份证',
    'ReContract' => '国有公房(民用住宅)租赁合同',

    'RecordSheet' => '直管公房有偿转让备案单',

    'CnApplicationForm' => '申请书',
    'CnApBooklet' => '申请人户口簿',
    'CnApIDCard' => '申请人身份证、图章',
    'CnContract' => '国有公房（民用住宅）租赁合同',
    'CnDeathProve' => '原承租人死亡的，提交死亡证明',
    "CnMigProve"=>"原承租人户籍迁出本市的，提交户籍注销证明",
    'CnLitig' => '诉讼离婚的，提交人民法院判决书或者调解书',
    'CnAgreement' => '协议离婚的，提交经民政部门备案的离婚协议书',
    'CnDivorce' => '离婚证',
    'CnAttachmentOne' => '附件一：公有住房指定承租人协议书（需公证）',
    'CnAttachmentTwo' => '附件二：公有住房过户协议书',
    'CnAttachmentThr' => '附件三：公有住房承租声明',
    'CnAttachmentFour' => '附件四：公有住房承租保证',
    'CnAttachmentFive' => '附件五：公有住房承租承诺书',


    'TrApplicationForm' => '住宅租约',
    'TrApBooklet' => '原承租人户口',
    'TrContract' => '现承租人户口',
    'TrApIDCard' => '身份证',
    'TrAgreementOne' => '结婚证',
    'TrAgreementTwo' => '共有子女的证明材料',
    'TrAgreementThr' => '亲属关系证明材料',
    'TrDeathProve' => '死亡证',
    'TrAttachmentOne' => '离婚证',
    'TrAttachmentTwo' => '离婚协议书',
    'TrAttachmentThr' => '过户协议书',
    'TrAttachmentFour' => '武汉市直管公房使用权有偿转让、受让审批表',
    'TrAttachmentFive' => '武汉市公有房屋使用权转让协议',

    //新增租金减免
    'basic' => '低保证',
    'ID' => '身份证',
    'houseBook' => '房产证',
    'household' => '户口本',
    'annualRentalContract' => '年租房合同(协议)',
    'houseSecurity' => '住房保障申请表',
    'nonCardinality' => '非基数异动核算凭单',
    'noticeBook' => '审通知书',

    //新增空租
    'descriptionReport' => '空租情况说明报告',
    'personalCheckApplication' => '个人退房申请',
    'unitCheckApplication' => '单位退房申请',
    'tenantLease' => '租户租约',
    'tenantIDFile' => '租户身份证',
    'emptyRentOther' => '其他',

    //新增暂停计租
    'pauseUploadReport' => '上传报告',
    'pauseMaterial' => '非基数异动核算凭单',

    //新增注销
    'housingBill' => '武汉市直管公有住房出售收入专用票据',
    'housingApprovalForm' => '武昌区房地局出售直管公有住房审批表',
    'cancelUploadReport' => '注销报告',


    //陈欠核销
    'oldCancelBook' => '陈欠核销情况说明报告',
    'oldCancelOther' => '其它',

    //房改
    'CHouseApp_1' => '购买直管公有住房申请表',
    'CApprovalForm_1' => '武汉市房产管理局出售单元式直管公房审批表',
    'InvoiceSale_1' => '售房发票',
    'CHouseUse' => '房屋使用权证（权属证明书）原件/复印件',
    'CLastRentInvoice_1' => '最后一月租金发票',
    'CPublicFundInvoice_1' => '公共部位维修基金发票',
    'CCopyOfHouse' => '住房证复印件',
    'CReApproval' => '房改批文',
    'CTransactionList' => '房改交易清册（住户加盖私章）',
    'CReAgreement_1' => '房改协议书（住户加盖私章）',
    'CAttorney' => '委托书（加住户私章）',
    'CLicenseCopy' => '营业执照复印件',
    'CAffidavit_1' => '具结书（公司对房地局出具）',
    'CProofOfFund' => '资金证明（商业银行出具的二联单）',
    'CRegistration' => '房屋登记申请书',
    'CAssessment' => '评估单',
    'CLegalCertificate' => '法人代表证明',


    'CHouseApp_2' => '购买直管公有住房申请表',
    'CApprovalForm_2' => '武汉市房产管理局出售单元式直管公房审批表',
    'InvoiceSale_2' => '售房发票',
    'CLastRentInvoice_2' => '最后一月租金发票',
    'CPublicFundInvoice_2' => '公共部位维修基金发票',
    'CReAgreement_2' => '房改协议书',
    'CCopyOfProp' => '产权复印件',
    'CPicture' => '图纸',
    'CHouseInformation' => '房屋信息单（房地局出具）',
    'CReBooklet' => '户口簿',
    'CCopyOfCard' => '身份证复印件2分（夫妻双方）',
    'CWorkCertificate' => '工领证明材料复印件（退休证等）',
    'CAffidavit_2' => '具结书',
    'CHouseApp_3' => '购买直管公有住房申请表',
    'CApprovalForm_3' => '武汉市房产管理局出售单元式直管公房审批表',
    'InvoiceSale_3' => '售房发票',
    'CLastRentInvoice_3' => '最后一月租金发票',
    'CPublicFundInvoice_3' => '公共部位维修基金发票',


    //新增维修异动
    'survey' => '房屋勘察表',
    'pic' => '房屋勘察表',


    //新增房屋调整
    'CancelReport' => '暂停计租报告',
    'AdjustSurvey' => '暂停计租报告',
    'AdjustPic' => '暂停计租报告',


    //新增房屋调整
    'homeCkeck' => '房屋勘察表',
    'AdjustSurvey' => '图卡',

    //管段调整
    'PipeApplication' => '管段异动申请表',

    //租金追加调整
    'otherBills' => '其他(票据)',

    //租金调整
    'rentUploadReport' =>'规定租金调整报告',

    // 大修中修分界线
    'middleDevide' => 10,

    // 翻修重建标准（完损等级）
    'reformDevide' => 5,

    // 新发租
    'NLApplication' => '异动申请表',
    'NLApplication2' => '异动申请表',

    // 分户
    'SplitApplication' => '书面申请(双方)',
    'SplitRegister' => '户口簿',
    'SplitCard' => '身份证(双方)',
    'SplitRent' => '租赁合同',
    'SplitAdvice' => '共同居住人意见书(签字)',

    // 楼栋调整
    'buildingAdjustOther' => '其它',

    //库字段映射
    'BanUnitNum' => '单元数',
    'BanFloorNum' => '层数',
    'AreaTwo' => '街道',
    'AreaThree' => '社区',
    'AreaFour' => '详细地址',
    'BanFloorStart' => '起始楼层',
    'InstitutionID' => '机构',
    'TubulationID' => '管段',
    'OwnerType' => '产别',
    'ReformIf' => '是否改造产',
    'BanPropertyID' => '产权证号',
    'BanLandID' => '土地证号',
    'BanFreeholdID' => '不动产证号',
    'CutIf' => '产权是否分隔',
    'BanYear' => '建造年份',
    'DamageGrade' => '完损等级',
    'StructureType' => '结构类别',
    'UseNature' => '使用性质',
    'TotalHouseholds' => '总户数',
    'CoveredArea' => '占地面积',
    'ActualArea' => '证载面积',
    'HistoryIf' => '是否是优秀历史建筑',
    'ProtectculturalIf' => '是否是文物保护单位',
    'BanGpsX' => '经度',
    'BanGpsY' => '纬度',

    'PumpCost' => '泵费',
    'RepairCost' => '房屋维修费',
    'OldOprice' => '计算原价',
    'TenantID' => '租户编号',
    'NonliveIf' => '是否住改非',
    'Hall' => '三户共用厅堂的个数',
    'Toilet' => '三户共用卫生间个数',
    'Kitchen' => '三户共用厨房个数',
    'InnerAisle' => '三户共用室内走道个数',
    'HouseUsearea' => '使用面积',
    'ComprisingArea' => '套内建面',
    'HousePrerent' => '规定租金',
    'WallpaperArea' => '墙纸面积',
    'CeramicTileArea' => '瓷砖的面积',
    'BathtubNum' => '浴盆的个数',
    'BasinNum' => '面盆的个数',
    'BelowFiveNum' => '低于5平米的房间个数',
    'MoreFiveNum' => '高于5米的阁楼个数',
    'TenantName' => '租户姓名',
    'UseArea' => '使用面积',
    'LeasedArea' => '计租面积',
    'IfWater' => '有无上下水',

    'UnitID' => '单元号',
    'FloorID' => '楼层号',

    'RentPointIDS' => '折减率',
    'TenantTel' => '租户电话',
    'TenantAge' => '租户年龄',
    'TenantWeChat' => '租户微信',
    'TenantNumber' => '身份证号码',
    'BankID' => '银行卡账号',
    'ArrearRent' => '欠租情况',
    'TenantSex' => '租户性别',
    'TenantBalance' => '余额',
    'TenantQQ' => '租户QQ号',
    'BankName' => '银行名称',
    'TenantValue' => '租户诚信值',
    'TenantName' => '租户姓名',

    'RoomRentMonth' => '月租金',
    'RentPoint' => '基价折减率',
    'RoomID' => '房间编号',
    'BanID' => '楼栋编号',

    'HouseID' => '房屋编号',
    'DoorID' => '门牌号',
    'HousePreRent' => '规定租金',
    'ReceiveRent' => '应收租金',
    'ArrearrentReason' => '欠租情况',
    'HouseArea' => '建筑面积',
    'HouseUseArea' => '使用面积',
    'ComprisingArea' => '套内建面',
    'DiffRent' => '租差',
    'PlusRent' => '加计租金',
    'ProtocolRent' => '协议租金',
    'WallpaperArea' => '墙纸面积',
    'CeramicTileArea' => '瓷砖的面积',
    'BathtubNum' => '浴盆的个数',
    'BasinNum' => '面盆的个数',
    'BelowFiveNum' => '空间1至1.7米(5㎡以下)',
    'MoreFiveNum' => '阁楼(含1.7米)(5㎡以上)',
    'IfWater' => '是否有上下水',
    'RemitRent' => '减免金额'
];