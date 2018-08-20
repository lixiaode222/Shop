<?php

/**
 * [alertMes 失败时提示和跳转页面]
 * @param  [string] $mes [失败时的提示]
 * @param  [string] $url [要跳转的页面地址]
 * @return [type]      [description]
 */
function alertMes($mes,$url){
    echo "<script>alert('$mes');</script>";
	echo "<script>window.location='$url';</script>";
}

/**
 * [checkLogined 检查是否有登陆]
 * @return [type] [description]
 */
function checkLogined(){
	if($_SESSION['adminId']==""&&$_COOKIE['adminId']==""){
		alertMes("请先登陆","login.php");
	}
}



/**
 * [logout 注销操作]
 * @return [type] [description]
 */
function logout(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}
	if(isset($_COOKIE['adminId'])){
		setcookie("adminId","",time()-1);
	}
	if(isset($_COOKIE["adminName"])){
		setcookie("adminName","",time()-1);
	}
	session_destroy();
	alertMes("注销成功","login.php");
}
?>