<?php
require_once '../include.php';
$act=$_REQUEST['act'];
if($act=="waterText"){
	$id=$_REQUEST['id'];
	$mes=doWaterText($id);
}elseif($act=="waterPic"){
	$id=$_REQUEST['id'];
	$mes=doWaterPic($id);
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