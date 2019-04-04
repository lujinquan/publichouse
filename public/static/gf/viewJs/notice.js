$('#publish_notice').click(function() {
    layer.open({
        type:1,
        area:['900px','600px'],
        resize:false,
        zIndex:100,
        title:['发布公告','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
        btn:['确定','取消'],
        content:$("#dialog"),
        success:function(){
            $('#title').val('');
            // $('#institution').val('');
            editor = KindEditor.create("#editor");
            editor.html('');
            editor.focus();
        },
        yes:function(add){
            var title = $('#title').val();
            var institution = $('#institution').val();
            var istop = $('#istop').val();
            var content = editor.html();
            if($.trim(title) == ''){
                layer.msg('标题不能为空');return ;
            } else if($.trim(content) == ''){
                layer.msg('内容不能为空');return ;
            }
            content = escape(content);
            console.log(content);
            var data = 'title='+title+'&institution='+institution+'&content='+content+'&istop='+istop;
            $.post('/ph/Notice/add', data, function(res){
                res = JSON.parse(res);
                console.log(res);
                // if(res.data == '1'){
                //     layer.msg('公告已发布');
                //     location.reload();
                // }
                if(res.retcode == 2000){
                    layer.msg('发布成功');
                    layer.close(add);
                }else{
                    layer.msg(res.msg);
                }
                
                // $(location).attr('href', '');
            });

        },
        end:function(){
            KindEditor.remove("#editor");
        },
        cancel:function(){
            KindEditor.remove("#editor");
        }

    });
    
});

$('#modify_notice').click(function(){
    
    var id = $('input:radio:checked').val();
    if(id == null || id == ''){
        layer.msg('选择要修改的公告');
        return ;
    }
    var data = 'id='+id;
    var res = null;

    $.get('/ph/Notice/modify/id/'+id, function(msg){

        msg = JSON.parse(msg);
        $('#modify_title').val(msg.data.Title);
        $('#modify_editor').val(msg.data.Content);
        $("#IsTop option[value='"+msg.data.IsTop+"']").attr("selected","selected");
        $("#InstitutionID option[value='"+msg.data.Institution+"']").attr("selected","selected");
        layer.open({
            type:1,
            area:['900px','650px'],
            resize:false,
            zIndex:100,
            title:['修改公告','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
            btn:['确定','取消'],
            content:$("#modify_dialog"),
            success:function(){
                editor = KindEditor.create("#modify_editor");
                content = unescape(msg.data.Content);
                editor.html(content);
                editor.focus();
            },
            yes:function(modify){
                var title = $('#modify_title').val();
                var institution = $('#InstitutionID option:selected').val();
                var istop = $('#IsTop option:selected').val();
                var content = editor.html();
                console.log(istop);
                if($.trim(title) == ''){
                    layer.msg('标题不能为空s');return ;
                } else if($.trim(content) == ''){
                    layer.msg('内容不能为空');return ;
                }
                var data = 'title='+title+'&institution='+institution+'&content='+content+'&id='+id+'&IsTop='+istop;
                $.post('/ph/Notice/modify', data, function(res){
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.data == '1'){
                        layer.msg('公告已修改');
                        layer.close(modify);
                    }
                    if(res.retcode == 2000){
                        layer.msg('修改成功');
                        layer.close(modify);
                    }else{
                        layer.msg(res.msg);
                    }
                });
                // ue.destroy();
               
                // $(location).attr('href', '');
            },
            end:function(){
                KindEditor.remove("#modify_editor");
            },
            cancel:function(){
                KindEditor.remove("#modify_editor");
            }
        });
    })
    
});

$('#delete_notice').click(function(){
    var id = $('input:radio:checked').val();
    if(id == null || id == ''){
        layer.msg('选择要删除的公告');
        return ;
    }
    var data = 'id='+id;
    layer.confirm('确定删除?',{icon: 2,skin:'lan_class'},function(){
        $.post('/ph/Notice/delete', data, function(res){
            res = JSON.parse(res);
            console.log(res);
            if(res.data){
                layer.msg('删除成功!');
                $(location).attr('href', '');
            }
        })
    });
});

$('.notice_info').click(function(){
    var id = $(this).parent().prev().prev().find('input').val();
    console.log(id);
    var data = 'id='+id;
    var res = null;
    $.ajax({
        url : '/ph/Notice/modify',
        dataType : 'json',
        type : 'get',
        data : data,
        async : false,
        success : function(msg){
            
            res = msg;
        }
    });
    layer.open({
        type:1,
        area:['900px','650px'],
        resize:false,
        zIndex:100,
        title:['发布公告','background-color:#00aaeb;color:#FFF;font-size:1.6rem;font-weight:600;'],
        btn:['确定','取消'],
        content:$("#notice_info_dialog"),
        success:function(){
            content = unescape(res.data.Content);
            $('#title_info').html(res.data.Title);
            $('#update_time_info').html(res.data.CreateTime);
            $('#name_info').html(res.data.Name);
            $('#content_info').html(content);
        }
    });
});