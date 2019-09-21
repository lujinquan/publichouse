$("#addAttachment").click(function(){
    layer.open({
        type:1,
        area:['900px','500px'],
        resize:false,
        zIndex:100,
        title:['文件上传','color:#FFF;font-size:1.6rem;font-weight:600;'],
        content:$('#filelist'),
        cancel:function(){
            location.reload();
        }
    });
});

$('#deletefile').click(function(){
    var id = $('input:radio:checked').val();
    if(id == null || id == ''){
        layer.msg('选择要删除的公告',{time:4000});
        return ;
    }
    var data = 'id='+id;
    $.post('/ph/Attachment/delete', data, function(res){
        res = JSON.parse(res);
        console.log(res);
        if(res.data){
            layer.msg('删除成功!',{time:4000});
            $(location).attr('href', '');
        }
    })
});