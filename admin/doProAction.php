<?php
require_once '../include.php';
$act=$_REQUEST['act'];
if($act=="addPro"){
	$mes=addPro();
}elseif($act=="editPro"){
	$id=$_REQUEST['id'];
    $mes=editPro($id);
}elseif($act=="delPro"){
	$id=$_REQUEST['id'];
    $mes=delPro($id);
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