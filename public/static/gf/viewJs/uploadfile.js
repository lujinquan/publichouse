/**
* @auther：sky
* @description：在上传列表中添加一条文件选择项
*/
function addfilelist(){
	if($("#add").prev().prev().prev().prev().val() && $("#add").prev().prev().prev().val()){
		$("#add").before("<input style='display:inline-block;' type='file' class='files' onchange='preg(this)' name='files[]'><input type='text' class='replace_title' placeholder='请输入标题'' name=''/><span class='waiting' name='witing[]'>待上传</span><hr class='hr'>");
	} else {
		alert("请添加文件或填写标题");
	}
	var inp = $("input[name='files[]']");
	if(inp.length >= 9){
		$("#add").hide();
	}
}
/**
* @auther：sky
* @description：上传文件
*/
function upfiles(){
	hid = 1;
	flag = 1;
	if($('.replace_title').length == 1){
		console.log(   $($('.replace_title')[0])  );
		if( $($('.replace_title')[0]).prev()[0].files.length == 0 || $($('.replace_title')[0]).val() == '' || $($('.replace_title')[0]).val() == null ){
			layer.alert('请添加文件或填写标题');
			hid = 0;
			return ;
		}
	}
	$('.replace_title').each(function(i, dom){
		console.log('file-----====');
		console.log($(dom).prev());
		if($(dom).prev()[0].files.length != 0 && ( $(dom).val() == '' || $(dom).val() == null )){
			flag = 0;
			return false;
		}
	});
	if(flag == 0){
		layer.alert("请添加文件或填写标题");
		return ;
	}
	$("input[name='files[]']").each(function(i, dom){
		var title = $(dom).next().val();
		var file = dom.files[0];
		if(!file)
			return;
		console.log(file.name);
		var fd = new FormData();
		fd.append("file", file);
		fd.append("title", title);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "/ph/Attachment/add", true);
		xhr.onreadystatechange = function(){
			if(this.readyState == 4){
				console.log(this.responseText);
				var res = JSON.parse(this.responseText);
				if(res.msg == "上传成功"){
					$(dom).next().next().css("color", "blue");
				} else {
					$(dom).next().next().css("color", "red");
				}
				$(dom).next().next().text(res.msg);
				console.log(this.responseText);
			}
		}
		xhr.upload.onprogress = function(ev){
			if(ev.lengthComputable){
				var percent = ev.loaded/ev.total*100;
				percent = percent.toFixed(2);
				$(dom).next().next().text(percent + "%");
				$("#bar").width(percent + "%");
				$("#per").text(percent + "%");
			}
		}
		xhr.send(fd);
	});
	if(hid == 1){
		$('#submit').hide();
	}
}

/**
* @auther：sky
* @description：判断文件是否符合上传要求
*/
function preg(dom){
	var arr = new Array('.doc','.docx','xlsx','.xls','.mp4', '.ppt', '.wps', '.txt', '.dwg', '.png', '.jpg', '.jpeg', '.gif', '.bmp', '.tiff', '.tga', '.rar', '.zip', '.pdf');
	var name = dom.files[0].name;
	var suffix = name.substr(name.lastIndexOf('.'));
	// console.log(suffix);
	var flag = false;
	for(var i = 0; i < arr.length; i++){
		if(suffix == arr[i]){
			flag = true;
			break;
		}
	}
	if(dom.files[0].size > 50*1024*1024){
		$(dom).val("");
	} else if(!flag){
		$(dom).val("");
		alert('文件类型不允许!');
	} else {
		console.log(dom.files[0].size);
	}
	// $(dom).next().next().text("待上传");
	// $(dom).next().next().css("color", "grey");
	// $(dom).next().val('');
}
/**
* @auther：sky
* @description：重置上传列表为空
*/
function reset(){
	$("#list").empty();
	var list = '<input type="file"  style="display:inline-block;" class="files" onchange="preg(this)" name="files[]"><input type="text" class="replace_title" placeholder="请输入标题" name=""/><span class="waiting" name="witing[]">待上传</span><hr class="hr"><span id="add" onclick="addfilelist()">添加+</span>'
	$("#list").append(list);
	$('#submit').show();
}