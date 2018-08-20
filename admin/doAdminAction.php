<?php
require_once '../include.php';
$act=$_REQUEST['act'];
if($act=="logout"){
	logout();
}elseif($act=="addAdmin"){
	$mes=addAdmin();
}elseif($act=="editAdmin"){
	$id=$_REQUEST['id'];
    $mes=editAdmin($id);
}elseif($act=="delAdmin"){
	$id=$_REQUEST['id'];
	$mes=delAdmin($id);
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