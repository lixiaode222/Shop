<?php
ob_clean();
$filename="帆布鞋.jpg";
$filename=iconv("UTF-8", "gbk",$filename);
//通过图片生成原图片资源
$src_image=imagecreatefromjpeg($filename);
//获得原图片资源的宽和高
list($src_w,$src_h)=getimagesize($filename);
//设定缩放比例(这里我们缩略图所有都是等比缩放)
$scale=0.5;
//得到目标图片资源应有的宽和高
$dst_w=ceil($src_w*$scale);
$dst_h=ceil($src_h*$scale);
//生成目标图片资源
$dst_image=imagecreatetruecolor($dst_w, $dst_h);
//重采样
imagecopyresampled($dst_image, $src_image,0,0,0,0, $dst_w, $dst_h, $src_w, $src_h);
header("content-type:image/jpeg");
imagejpeg($dst_image);
imagedestroy($dst_image);
imagedestroy($src_image);
?>