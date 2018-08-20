<?php
$filename="123.jpg";
waterText($filename);
function waterText($filename,$text="imooc.com",$fontfile="simsun.ttc"){
$fileInfo=getimagesize($filename);
$mime=$fileInfo['mime'];
$createFun=str_replace('/', 'createfrom', $mime);
$outFun=str_replace('/', null, $mime);
$image=$createFun($filename);
$color=imagecolorallocatealpha($image, 255, 0, 0, 50);
$fontfile="../fonts/{$fontfile}";
imagettftext($image, 28, 0, 0, 14, $color, $fontfile, $text);
header("content-type:".$mime);
$outFun($image,$filename);
imagedestroy($image);
}