<?php
/**
 * [addUser 添加用户]
 */
function addUser(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile("../uploads");
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "添加失败<a href='addUser.php'>重新添加</a>";
	}
	if(insert("imooc_user", $arr)){
		$mes="添加成功!<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看列表</a>";
	}else{
		$filename="../uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="添加失败!<br/><a href='arrUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a>";
	}
	return $mes;
}

/**
 * [reg 用户注册]
 * @return [type] [description]
 */
function reg(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile();
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
	if(insert("imooc_user",$arr)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}

/**
 * [login 用户登陆]
 * @return [type] [description]
 */
function login(){
	$username=$_POST['username'];
	//addslashes():使用反斜线引用特殊字符
    $username=addslashes($username);
	$password=md5($_POST['password']);
	$sql="select * from imooc_user where username='{$username}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['username']=$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}

/**
 * [userOut 用户退出]
 * @return [type] [description]
 */
function userOut(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}

	session_destroy();
	header("location:index.php");
}

/**
 * [delAdmin 删除用户]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function delUser($id){
	$sql="select face from imooc_user where id=".$id;
	$row=fetchOne($sql);
	$face=$row['face'];
	if(file_exists("../uploads/".$face)){
		unlink("../uploads/".$face);
	}
	if(delete("imooc_user","id={$id}")){
		$mes="用户删除成功!<br/><a href='listUser.php'>查看用户列表</a>";
	}else{
	    $mes="用户删除失败!<br/><a href='listUser.php'>请重新删除</a>";
	}
	return $mes;
}

/**
 * [editAdmin 编辑用户]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function editUser($id){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
    if(update('imooc_user',$arr,"id={$id}")){
    	$mes="用户编辑成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
    	$mes="用户编辑失败!<br/><a href='listUser.php'>请重新修改</a>";
    }
    return $mes;
}
?>