/**
 * Created by DDD on 2017/7/10.
 */
var fileTotall = {
    array:[],
    groupArray:[],
    getGroupArray:function(){

    },
    totalUpLoad:function(url){
        var length = this.totalArray.length;
        var formData = new FormData();
        console.log(this.totalArray);
        if(length == 0){
            layer.msg('请选择文件！');
        }else{
            for(var i = 0; i < length;i++){
                if(this.totalArray[i] != null){
                    formData.append(this.totalArray[i][this.totalArray[i].length-1],this.totalArray[i]);
                }
            }
            $.ajax({
                type:"post",
                url:url,
                data:formData,
                processData:false,
                contentType:false,
                success:function(res){
                    res = JSON.parse(res);
                    layer.msg(res.msg);
                }
            });
        }
    },
    arrayUpload:function(url){
        console.log(this.array);//图片命名规则
        var length = this.array.length;
        var formData = new FormData();
        if(length == 0){
            layer.msg("请选择要上传的文件");
        }else{
            var currentTitle = this.array[0].title,j = 0;
            for(var i = 0; i < length; i++){
                if(this.array[i] != null){
                    formData.append(this.array[i].title+"["+j+"]",this.array[i]);
                }
                if(this.array[i+1] != null){
                    if(currentTitle == this.array[i+1].title){
                        j++;
                    }else{
                        currentTitle = this.array[i+1].title;
                        j = 0;
                    }
                }else{
                    j++;
                }
            }
            $.ajax({
                type:"post",
                url:url,
                data:formData,
                processData:false,
                contentType:false,
                success:function(res){
                    res = JSON.parse(res);
                    layer.msg(res.msg);
                }
            });
        }
    },
    getArrayFormdata:function(){
        console.log(this.array);//图片命名规则
        var length = this.array.length;
        var formData = new FormData();
        if(length == 0){
            layer.msg("请选择要上传的文件");
        }else{
            var currentTitle = this.array[0].title,j = 0;
            for(var i = 0; i < length; i++){
                if(this.array[i] != null){
                    formData.append(this.array[i].title+"["+j+"]",this.array[i]);
                }
                if(this.array[i+1] != null){
                    if(currentTitle == this.array[i+1].title){
                        j++;
                    }else{
                        currentTitle = this.array[i+1].title;
                        j = 0;
                    }
                }else{
                    j++;
                }
            }
        }
        return formData;
    }
};
function file(opt){
    this.filesArray = [];
    this.size = opt.size||4096;
    this.url = opt.url;
    this.name = opt.button.substring(1);
    this.button = $(opt.button);
    this.show = $(opt.show);
    this.id = opt.show;
    this.UpButton = $(opt.upButton);
    this.ChangeOrderID = opt.ChangeOrderID;
    this.TitleName = opt.title;
    this.init();
}
file.prototype.init = function(){
    var that = this;
    this.fileShow();
    this.UpButton.off('click');
    this.UpButton.on('click',function(){
        that.upload();
    });
}
file.prototype.fileShow = function(){
    var that = this;
    this.button.off('change');
    this.button.on('change',function(){
        that.fileShowEvent();
        console.log(this.value);
    });
}
file.prototype.fileShowEvent = function(){
    var that = this;
    var files = this.button[0].files;
    for(var i = 0;i < files.length;i++){
        if(files[i].size/1024 > this.size){
            layer.msg('图片过大！');
            continue;
        }else if(this.filesArray.some(function(data){return data.name==files[i].name})){
            layer.msg('上传文件重复！');
            continue;
        }else{
            files[i].title = this.name;
            this.filesArray.push(files[i]);
            fileTotall.array.push(files[i]);//*
            var reader = new FileReader();
            reader.readAsDataURL(files[i]);
            reader.onload = function(e){
                var newImg = $("<div style='display:inline-block;position:relative;'>\
                                    <img style='height:100px;margin:10px 5px;' src='"+this.result+"'/>\
                                    <span style='position:absolute;top:4px;right:8px;cursor:pointer; class='img_close'>X</span>\
                                </div>");
                that.show.append(newImg);
                that.show.find('span').off('click');
                that.show.find('span').on('click',function(){
                    that.remove($(this).parent().index(),$(this).index('.img_close'));
                });
            }
        }
    }
    console.log(this.filesArray);
}
file.prototype.upload = function(){
    var length = this.filesArray.length;
    var formData = new FormData();
    if(length == 0){
        layer.msg('请选择文件！');
    }else{
        for(var i = 0; i < length;i++){
            if(this.filesArray[i] != null){
                formData.append(this.name+"["+i+"]",this.filesArray[i]);
            }
        }
        formData.append("ChangeOrderID",this.ChangeOrderID);
        formData.append("title",this.TitleName);
        $.ajax({
            type:"post",
            url:this.url,
            data:formData,
            processData:false,
            contentType:false,
            success:function(data){
                
            }
        });
    }
}
file.prototype.remove = function(index,filetotall_index){
    this.filesArray.splice(index,1);
    this.show.find('div').eq(index).remove();
    fileTotall.array.splice(index,1);
}