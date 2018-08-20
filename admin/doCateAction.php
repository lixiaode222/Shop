<?php
require_once '../include.php';
$act=$_REQUEST['act'];
if($act=="addCate"){
	$mes=addCate();
}elseif($act=="editCate"){
	$id=$_REQUEST['id'];
	$mes=editCate($id);
}elseif($act="delCate"){
	$id=$_REQUEST['id'];
	$mes=delCate($id);
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