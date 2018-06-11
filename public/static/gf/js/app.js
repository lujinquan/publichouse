// 状态设置
$(".not-process").prop('disabled',true);



(function($) {
  'use strict';

  $(function() {
    var $fullText = $('.admin-fullText');
    $('#admin-fullscreen').on('click', function() {
      $.AMUI.fullscreen.toggle();
    });

    // $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function() {
    //   $fullText.text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
    // });
  });

  $(".piaochecked").on("click",function(){
      $(".piaochecked").removeClass("on_check");
      $(this).hasClass("on_check")? $(this).removeClass("on_check"):$(this).addClass("on_check");
     //或者这么写
    // $(this).toggleClass( "on_check" );
  })

})(jQuery);
var length2='';
var queryData = {
       Institution : $('#queryOne').val()||'',
       BanAddress : $('#queryTwo').val()||'',
       TenantName : $('#queryThr').val()||'',
       pageNum : $('#pageNum').val()|| 1,
       init:function(){
         this.Institution = $('#queryOne').val()||'';
         this.BanAddress = $('#queryTwo').val()||'';
         this.TenantName = $('#queryThr').val()||'';
        // this.pageNum = 1;
       },
       show : function(id){
        var self = this;
          layer.open({
            type:1,
            area:['1100px','700px'],
            zIndex:100,
            title:['查询器','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
            btn:['确认','取消'],
            content:$('#dataQuery'),
            success:function(){
              $("#"+id).blur();
              self.postData();
            },
            yes:function(layerIndex){
              this.pageNum=1;
              $("#"+id).blur();
              layer.close(layerIndex);
            }
          });
       },
      getInstitution:function(){
        $.get("/ph/Api/get_all_institution",function(res){
          res = JSON.parse(res);
          console.log(res);
          $("#queryOne").remove();
          if(res.data==null){
            var length =0;
          }else{
            var length=res.data.length
            var selectDom = $("<select id='queryOne'></select>");
          for(var i = 0;i < length;i++){
            var optionDom = $("<option value="+res.data[i].id+">"+res.data[i].Institution+"</option>");
            selectDom.append(optionDom);
          }
          $("#addSelect").after(selectDom);
          }
          // var length =res.data?0:res.data.length;
          
        })
       },
        postData :function(){
          $.post('/ph/Api/get_all_info',{InstitutionID:this.Institution,BanAddress:this.BanAddress,TenantName:this.TenantName,page:this.pageNum},function(res){
            res = JSON.parse(res);
            console.log(res);
            var length = res.data.data.length;
            length2 = res.data.total;
            var  tbodyDom= $('<tbody></tbody>');
            for(var i = 0;i < length;i++){
              var trDom = $("<tr><td>"+res.data.data[i].BanID+"</td><td>"+res.data.data[i].HouseID+"</td>\
              <td>"+res.data.data[i].UnitID+"</td><td>"+res.data.data[i].FloorID+"</td><td>"+res.data.data[i].TenantName+"</td><td>"+res.data.data[i].BanAddress+"</td>\
              </tr>");
              tbodyDom.append(trDom);
            }
            $("#dataQuery table tbody").remove();
            $("#dataQuery table thead").after(tbodyDom);
          });
       },
      pagePrev :function(){
        this.pageNum = parseInt(this.pageNum);

          if(this.pageNum > 1){
            this.pageNum--;
            this.postData();
            $('#pageNum').val(this.pageNum);
          }else{
            layer.msg('已经是首页了！！');
          }
        },
      pageNext:function(){
        console.log(length2);
        this.pageNum = parseInt(this.pageNum);
        if(this.pageNum!=Math.ceil(length2/15)){
          this.pageNum++;
          this.postData();
          $('#pageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageNumChange:function(){
        var self = this;
        $('#pageNum').change(function(){
          self.pageNum = $(this).val();
          console.log(self.pageNum);
        })
      },
      query:function(){
        this.pageNum=1;
        this.init();
        this.postData();
        $('#pageNum').val(this.pageNum);
      },
      getValue:function(number,id){
        $("#dataQuery table").off('click');
        $("#dataQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          if(number == 1){
            $("#"+id).val($($(this).context).find('td').eq(0).text());
          }else if(number == 2){
            $("#"+id).val($($(this).context).find('td').eq(1).text());
          }
        });
      },
      getValue2:function(number,id,n){
        $("#dataQuery table").off('click');
        $("#dataQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          if(number == 1){
            $("."+id).eq(n).val($($(this).context).find('td').eq(0).text());
          }else if(number == 2){
            $("."+id).eq(n).val($($(this).context).find('td').eq(1).text());
          }
        });
      },
      action:function(number,id){
        var self = this;
        $("#"+id).off('focus');
        $("#"+id).focus(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(number,id);
        });
      },
       action2:function(number,id){
        var self = this;
        //$("#"+id).off('focus');
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(number,id);
      },
      actionD:function(number,id){
        var self = this;
        //$("#"+id).off('focus');
        $("#"+id).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(number,id);
        });
      },
       actionC:function(number,id,n){
        var self = this;
        $("."+id).eq(n).unbind('dblclick');
        $("."+id).eq(n).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue2(number,id,n);
        });
      },
}

    $('#pagePrev').click(function(){
        queryData.pagePrev();
    });
    $('#pageNext').click(function(){
        queryData.pageNext();
    });
    $('#queryClick').click(function(){
        queryData.query();
    });

// 租户查询开始 调用方式：tenantQuery.action(id,houseID,status);
var tenantQuery = {
       Institution : $('#tenantOne').val()||'',
       tenantName : $('#tenantTwo').val()||'',
       tenantTel : $('#tenantThr').val()||'',
       pageNum : $('#tenantPageNum').val()|| 1,
       status:0,
       houseID:'',
       init:function(){
         this.Institution = $.trim($('#tenantOne').val())||'';
         this.tenantName = $.trim($('#tenantTwo').val())||'';
         this.tenantTel = $.trim($('#tenantThr').val())||'';
       },
       show : function(id){
        var self = this;
          layer.open({
            type:1,
            area:['1100px','700px'],
            zIndex:100,
            title:['租户查询器','background-color:#2E77EF;color:#FFF;font-size:1.6rem;font-weight:600;text-align:center;'],
            btn:['确认','取消'],
            content:$('#tenantQuery'),
            success:function(){
              $("#"+id).blur();
              self.postData();
            },
            yes:function(layerIndex){
              this.pageNum=1;
              $("#"+id).blur();
              layer.close(layerIndex);
            }
          });
       },
      getInstitution:function(){
        $.get("/ph/Api/get_all_institution",function(res){
          res = JSON.parse(res);
          console.log(res);
          $("#queryOne").remove();
          if(res.data==null){
            var length =0;
          }else{
            var length=res.data.length
            var selectDom = $("<select id='queryOne'></select>");
          for(var i = 0;i < length;i++){
            var optionDom = $("<option value="+res.data[i].id+">"+res.data[i].Institution+"</option>");
            selectDom.append(optionDom);
          }
          $("#tenantAddSelect").after(selectDom);
          }
        })
       },
        postData :function(){
          $.post('/ph/Api/get_all_tenant_info',
            {InstitutionID:this.Institution,TenantName:this.tenantName,TenantTel:this.tenantTel,page:this.pageNum,Status:this.status,HouseID:this.houseID}
            ,function(res){
            res = JSON.parse(res);
            console.log(res);
            var length = res.data.data.length;
            length2 = res.data.total;
            var  tbodyDom= $('<tbody></tbody>');
            for(var i = 0;i < length;i++){
              var trDom = $("<tr><td>"+res.data.data[i].TenantID+"</td><td>"+res.data.data[i].TenantName+"</td>\
              <td>"+res.data.data[i].TenantTel+"</td><td>"+res.data.data[i].TenantNumber+"</td><td>"+res.data.data[i].BankID+"</td><td>"+res.data.data[i].BankName+"</td>\
              </tr>");
              tbodyDom.append(trDom);
            }
            $("#tenantQuery table tbody").remove();
            $("#tenantQuery table thead").after(tbodyDom);
            $("#tenantTotalPage").text(res.data.totalPage);
          });
       },
      pagePrev :function(){
        this.pageNum = parseInt(this.pageNum);

          if(this.pageNum > 1){
            this.pageNum--;
            this.postData();
            $('#tenantPageNum').val(this.pageNum);
          }else{
            layer.msg('已经是首页了！！');
          }
        },
      pageNext:function(){
        console.log(length2);
        this.pageNum = parseInt(this.pageNum);
        if(this.pageNum < Math.ceil(length2/15)){
          this.pageNum++;
          this.postData();
          $('#tenantPageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageGo:function(){
        this.pageNum = $('#tenantPageNum').val();
        if(this.pageNum <= Math.ceil(length2/15)){
          this.postData();
          $('#tenantPageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageNumChange:function(){
        var self = this;
        $('#tenantPageNum').change(function(){
          self.pageNum = $(this).val();
          console.log(self.pageNum);
        })
      },
      query:function(){
        this.pageNum=1;
        this.init();
        this.postData();
        $('#tenantPageNum').val(this.pageNum);
      },
      getValue:function(id,callback){
        $("#tenantQuery table").off('click');
        $("#tenantQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          $("#"+id).val($($(this).context).find('td').eq(0).text());
          callback();
        });
      },
      action:function(id,houseID,status,callback){
        var self = this;
        if(callback == undefined){
          callback = function(){};
        }
        this.status = status.split(',');
        this.houseID = houseID;
        $("#"+id).off('dblclick');
        $("#"+id).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(id,callback);
        });
      }
}
$('#tenantPagePrev').click(function(){
    tenantQuery.pagePrev();
});
$('#tenantPageNext').click(function(){
    tenantQuery.pageNext();
});
$('#tenantPageGo').click(function(){
    tenantQuery.pageGo();
});
$('#tenantQueryClick').click(function(){
    tenantQuery.query();
});
$('#tenantQuery').on("keydown",function(e){
  var theEvent = e || window.event;
  var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
  if(code == 13){
    tenantQuery.query();
  }
});
//租户查询结束

// 楼栋查询开始 调用方式：banQuery.action(id,status);
var banQuery = {
       Institution : $('#banOne').val()||'',
       BanAddress : $('#banTwo').val()||'',
       pageNum : $('#banPageNum').val()|| 1,
       status:0,
       init:function(){
         this.Institution = $.trim($('#banOne').val())||'';
         this.BanAddress = $.trim($('#banTwo').val())||'';
       },
       show : function(id){
        var self = this;
          layer.open({
            type:1,
            area:['1100px','700px'],
            zIndex:100,
            title:['楼栋查询器','background-color:#2E77EF;color:#FFF;font-size:1.6rem;font-weight:600;text-align:center;'],
            btn:['确认','取消'],
            content:$('#banQuery'),
            success:function(){
              $("#"+id).blur();
              self.postData();
            },
            yes:function(layerIndex){
              this.pageNum=1;
              $("#"+id).blur();
              layer.close(layerIndex);
            }
          });
       },
      getInstitution:function(){
        $.get("/ph/Api/get_all_institution",function(res){
          res = JSON.parse(res);
          console.log(res);
          $("#queryOne").remove();
          if(res.data==null){
            var length =0;
          }else{
            var length=res.data.length
            var selectDom = $("<select id='queryOne'></select>");
          for(var i = 0;i < length;i++){
            var optionDom = $("<option value="+res.data[i].id+">"+res.data[i].Institution+"</option>");
            selectDom.append(optionDom);
          }
          $("#banAddSelect").after(selectDom);
          }
        })
       },
        postData :function(){
          $.post('/ph/Api/get_all_ban_info',
            {InstitutionID:this.Institution,BanAddress:this.BanAddress,page:this.pageNum,Status:this.status}
            ,function(res){
            res = JSON.parse(res);
            console.log(res);
            var length = res.data.data.length;
            length2 = res.data.total;
            var  tbodyDom= $('<tbody></tbody>');
            for(var i = 0;i < length;i++){
              var trDom = $("<tr><td>"+res.data.data[i].BanID+"</td><td>"+res.data.data[i].DamageGrade+"</td>\
              <td>"+res.data.data[i].StructureType+"</td><td>"+res.data.data[i].OwnerType+"</td><td>"+res.data.data[i].UseNature+"</td><td>"+res.data.data[i].BanAddress+"</td>\
              </tr>");
              tbodyDom.append(trDom);
            }
            $("#banQuery table tbody").remove();
            $("#banQuery table thead").after(tbodyDom);
            $("#banTotalPage").text(res.data.totalPage);
          });
       },
      pagePrev :function(){
        this.pageNum = parseInt(this.pageNum);

          if(this.pageNum > 1){
            this.pageNum--;
            this.postData();
            $('#banPageNum').val(this.pageNum);
          }else{
            layer.msg('已经是首页了！！');
          }
        },
      pageNext:function(){
        console.log(length2);
        this.pageNum = parseInt(this.pageNum);
        if(this.pageNum < Math.ceil(length2/15)){
          this.pageNum++;
          this.postData();
          $('#banPageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageGo:function(){
        this.pageNum = $('#banPageNum').val();
        if(this.pageNum <= Math.ceil(length2/15)){
          this.postData();
          $('#banPageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageNumChange:function(){
        var self = this;
        $('#banPageNum').change(function(){
          self.pageNum = $(this).val();
          console.log(self.pageNum);
        })
      },
      query:function(){
        this.pageNum=1;
        this.init();
        this.postData();
        $('#banPageNum').val(this.pageNum);
      },
      getValue:function(id){
        $("#banQuery table").off('click');
        $("#banQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          $("#"+id).val($($(this).context).find('td').eq(0).text());
        });
      },
      getValueA:function(className,n){
        $("#banQuery table").off('click');
        $("#banQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          $("."+className).eq(n).val($($(this).context).find('td').eq(0).text());
        });
      },
      action:function(id,status){
        var self = this;
        this.status = status.split(',');
        console.log(this.status);
        $("#"+id).off('dblclick');
        $("#"+id).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(id);
        });
      },
      actionA:function(className,id,status,n){
        var self = this;
        this.status = status.split(',');
        $("."+className).eq(n).off('dblclick');
        $("."+className).eq(n).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValueA(className,n);
        });
      }
}
$('#banPagePrev').click(function(){
    banQuery.pagePrev();
});
$('#banPageNext').click(function(){
    banQuery.pageNext();
});
$('#banPageGo').click(function(){
    banQuery.pageGo();
});
$('#banQueryClick').click(function(){
    banQuery.query();
});
$('#banQuery').on("keydown",function(e){
  var theEvent = e || window.event;
  var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
  if(code == 13){
    banQuery.query();
  }
});
//楼栋查询结束

//房屋查询开始 调用方式：houseQuery.action(id,status);
var houseQuery = {
       Institution : $('#houseOne').val()||'',
       TenantName: $('#houseTwo').val()||'',
       BanAddress : $('#houseThr').val()||'',
       pageNum : $('#banPageNum').val()|| 1,
       status:0,
       init:function(){
         this.Institution = $.trim($('#houseOne').val())||'';
         this.TenantName = $.trim($('#houseTwo').val())||'';
         this.BanAddress  = $.trim($('#houseThr').val())||'';
       },
       show : function(id){
        var self = this;
          layer.open({
            type:1,
            area:['990px','700px'],
            zIndex:100,
            title:['房屋查询器','background-color:#2E77EF;color:#FFF;font-size:1.6rem;font-weight:600;text-align:center;'],
            btn:['确认','取消'],
            content:$('#houseQuery'),
            success:function(){
              $("#"+id).blur();
              self.postData();
            },
            yes:function(layerIndex){
              this.pageNum=1;
              $("#"+id).blur();
              layer.close(layerIndex);
            }
          });
       },
      getInstitution:function(){
        $.get("/ph/Api/get_all_institution",function(res){
          res = JSON.parse(res);
          console.log(res);
          $("#queryOne").remove();
          if(res.data==null){
            var length =0;
          }else{
            var length=res.data.length
            var selectDom = $("<select id='queryOne'></select>");
          for(var i = 0;i < length;i++){
            var optionDom = $("<option value="+res.data[i].id+">"+res.data[i].Institution+"</option>");
            selectDom.append(optionDom);
          }
          $("#houseAddSelect").after(selectDom);
          }
        })
       },
        postData :function(){
          $.post('/ph/Api/get_all_house_info',
            {InstitutionID:this.Institution,BanAddress:this.BanAddress,TenantName:this.TenantName,page:this.pageNum,Status:this.status}
            ,function(res){
            res = JSON.parse(res);
            console.log(res);
            var length = res.data.data.length;
            length2 = res.data.total;
            var  tbodyDom= $('<tbody></tbody>');
            for(var i = 0;i < length;i++){
              var trDom = $("<tr><td>"+res.data.data[i].BanID+"</td><td>"+res.data.data[i].HouseID+"</td>\
              <td>"+res.data.data[i].UnitID+"</td><td>"+res.data.data[i].FloorID+"</td><td>"+res.data.data[i].TenantName+"</td><td>"+res.data.data[i].BanAddress+"</td>\
              </tr>");
              tbodyDom.append(trDom);
            }
            $("#houseQuery table tbody").remove();
            $("#houseQuery table thead").after(tbodyDom);
            $("#houseTotalPage").text(res.data.totalPage);
          });
       },
      pagePrev :function(){
        this.pageNum = parseInt(this.pageNum);

          if(this.pageNum > 1){
            this.pageNum--;
            this.postData();
            $('#housePageNum').val(this.pageNum);
          }else{
            layer.msg('已经是首页了！！');
          }
        },
      pageNext:function(){
        console.log(length2);
        this.pageNum = parseInt(this.pageNum);
        if(this.pageNum < Math.ceil(length2/15)){
          this.pageNum++;
          this.postData();
          $('#housePageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageGo:function(){
        this.pageNum = $('#housePageNum').val();
        if(this.pageNum <= Math.ceil(length2/15)){
          this.postData();
          $('#housePageNum').val(this.pageNum);
        }else{
          layer.msg('已经是最后页了！！');
        }
      },
      pageNumChange:function(){
        var self = this;
        $('#housePageNum').change(function(){
          self.pageNum = $(this).val();
          console.log(self.pageNum);
        })
      },
      query:function(){
        this.pageNum=1;
        this.init();
        this.postData();
        $('#housePageNum').val(this.pageNum);
      },
      getValue:function(id){
        $("#houseQuery table").off('click');
        $("#houseQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          $("#"+id).val($($(this).context).find('td').eq(1).text());
        });
      },
      getValueA:function(className,n){
        $("#houseQuery table").off('click');
        $("#houseQuery table").on('click','tbody tr',function(){
          $(this).siblings().css({'background':'none','color':'#000'});
          $(this).css({'background':'#2e77ef','color':'#FFF'});
          $("."+className).eq(n).val($($(this).context).find('td').eq(1).text());
        });
      },
      action:function(id,status){
        var self = this;
        this.status = status.split(',');
        console.log(this.status);
        $("#"+id).off('dblclick');
        $("#"+id).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValue(id);
        });
      },
      actionA:function(className,id,status,n){
        var self = this;
        this.status = status.split(',');
        $("."+className).eq(n).off('dblclick');
        $("."+className).eq(n).dblclick(function(){
            self.pageNumChange();
            self.getInstitution();
            self.show(id);
            self.getValueA(className,n);
        });
      }
}
$('#housePagePrev').click(function(){
    houseQuery.pagePrev();
});
$('#housePageNext').click(function(){
    houseQuery.pageNext();
});
$('#housePageGo').click(function(){
    houseQuery.pageGo();
});
$('#houseQueryClick').click(function(){
    houseQuery.query();
});
$('#houseQuery').on("keydown",function(e){
  var theEvent = e || window.event;
  var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
  if(code == 13){
    houseQuery.query();
  }
});
//房屋查询结束

// 分页及查询问题
$('#queryBtn').click(function(){
  var queryString = $('#queryForm').serialize();
  localStorage.addUrl = queryString;
});
$('.admin-parent a,.ABtn').click(function(){
  localStorage.addUrl = '';
  console.log('aaa');
});
var length = $('.pagination li').length;
for(var i = 0;i < length;i++){
  if($('.pagination li').eq(i).find('a')){
    var queryString = $('#queryForm').serialize();
    localStorage.addUrl = queryString;
    var this_href = $('.pagination li').eq(i).find('a').prop('href');
    $('.pagination li').eq(i).find('a').prop('href',this_href+"&"+localStorage.addUrl);
  }
}
// 分页问题结束
var click_flag = 0;
$('.check001').click(function(){
  var thisIndex = $(this).index('.check001');
  if(click_flag%2 == 0){
    $('.check001').eq(click_flag).find('td').css('background-color','#f9f9f9');
  }else{
    $('.check001').eq(click_flag).find('td').css('background-color','#ffffff');
  }
  click_flag = thisIndex;
	for(var i=0;i<$('.check001').length;i++){
		$('.check001').eq(i).find('span').removeClass('on_check');
		$('.check001').eq(i).find('span').prop('checked',false);
	}
  $('.check001').eq(thisIndex).find('span').addClass('on_check'); 
  $('.check001').eq(thisIndex).find('input').prop('checked',true); 
  $('.check001').eq(thisIndex).find('td').css('background','#DEF2FF');
});
//room
$('.check002').click(function(even){
	var aL= $(this).children().length-1;
	$(this).children().eq(aL).click(function(even){
		event.stopPropagation(); 
	})
	if(	$(this).children().children().eq(0).prop('checked')==true ){
		$(this).children().children().eq(0).prop('checked',false);
		$(this).children().children().eq(1).css("background-position",'-32px 0px');
	}else{
		$(this).children().children().eq(0).prop('checked',true);
		$(this).children().children().eq(1).css("background-position",'0px 0px');
	}
});