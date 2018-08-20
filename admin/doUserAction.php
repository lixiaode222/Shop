<?php
require_once '../include.php';
$act=$_REQUEST['act'];
if($act=="addUser"){
	$mes=addUser();
}elseif($act=="editUser"){
	$id=$_REQUEST['id'];
	$mes=editUser($id);
}elseif($act="delUser"){
	$id=$_REQUEST['id'];
	$mes=delUser($id);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
if($mes){
	echo $mes;
}
?>
</body>
</html>