<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>添加用户</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
        $(document).ready(function(){
        	$("#selectFileBtn").click(function(){
        		$fileField = $('<input type="file" name="thumbs[]"/>');
        		$fileField.hide();
        		$("#attachList").append($fileField);
        		$fileField.trigger("click");
        		$fileField.change(function(){
        		$path = $(this).val();
        		$filename = $path.substring($path.lastIndexOf("\\")+1);
        		$attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
        		$attachItem.find(".left").html($filename);
        		$("#attachList").append($attachItem);		
        		});
        	});
        	$("#attachList>.attachItem").find('a').live('click',function(obj,i){
        		$(this).parents('.attachItem').prev('input').remove();
        		$(this).parents('.attachItem').remove();
        	});
        });
</script>
</head>
<body>
<h3>添加用户</h3>
<form action="doUserAction.php?act=addUser" method="post" enctype="multipart/form-data">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">名称</td>
		<td><input type="text" name="username" placeholder="请输入名称"/></td>
	</tr>
	<tr>
		<td align="right">密码</td>
		<td><input type="password" name="password" placeholder="请输入密码"/></td>
	</tr>
		<tr>
		<td align="right">邮箱</td>
		<td><input type="text" name="email" placeholder="请输入邮箱"/></td>
	</tr>
	</tr>
		<tr>
		<td align="right">性别</td>
		<td><input type="radio" name="sex" value="1" checked="cheked" />男
			<input type="radio" name="sex" value="2"  />女
			<input type="radio" name="sex" value="3"  />保密
		</td>
	</tr>
	</tr>
	<tr>
		<td align="right">头像</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
		<tr>
		<td colspan="2"><input type="submit" value="添加用户" /></td>
	</tr>
	
</table>
</form>
</body>
</html>