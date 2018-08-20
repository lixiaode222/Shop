<?php

/**
 * [checkAdmin 查看管理员]
 * @param  [type] $sql [description]
 * @return [type]      [description]
 */
function checkAdmin($sql){
  return fetchOne($sql);
}


/**
 * [addAdmin 添加管理员]
 */
function addAdmin(){
	$link=connect();
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	if(insert('imooc_admin',$arr)){
		$mes="管理员添加成功!<br/><a href='addAdmin.php'>继续添加管理员</a>|<a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes="管理员添加失败!<br/><a href='addAdmin.php'>重新添加管理员</a>";
	}
	return $mes;
}

/**
 * [getAllAdmin 得到所有的管理员名单]
 * @return [type] [返回结果集]
 */
function getAllAdmin(){
	$sql="select id,username,email from imooc_admin ";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 * [editAdmin 编辑管理员]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function editAdmin($id){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
    if(update('imooc_admin',$arr,"id={$id}")){
    	$mes="管理员编辑成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
    	$mes="管理员编辑失败!<br/><a href='listAdmin.php'>请重新修改管理员</a>";
    }
    return $mes;
}
/**
 * [delAdmin 删除管理员]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function delAdmin($id){
	if(delete("imooc_admin","id={$id}")){
		$mes="管理员删除成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
	}else{
	    $mes="管理员删除失败!<br/><a href='listAdmin.php'>请重新删除管理员</a>";
	}
	return $mes;
}

function getAdminByPage($pageSize=2){
$sql="select * from imooc_admin";
$totalRows=getResultNum($sql);
global $totalPage;
$totalPage=ceil($totalRows/$pageSize);
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page)){
	$page=1;
}
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,username,email from imooc_admin limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
return $rows;
}
?>