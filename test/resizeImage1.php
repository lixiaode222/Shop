<?php
ob_clean();
$filename="帆布鞋.jpg";
$filename=iconv("UTF-8", "gbk",$filename);
info=getimagesize($filename);
list($src_w,$src_h,$imagetype)=getimage$size($filename);
$mime=image_type_to_mime_type($imagetype);
//生成imagecretefromjpeg这个字符串
$createFun=str_replace("/", "createfrom", $mime);
//生成imagejpeg这个字符串
$outFun=str_replace("/", null, $mime);
//生成画布资源
$src_image=$createFun($filename);
$dst_50_image=imagecreatetruecolor(50, 50);
$dst_220_image=imagecreatetruecolor(220, 220);
$dst_350_image=imagecreatetruecolor(350, 350);
$dst_800_image=imagecreatetruecolor(800, 800);
//重采样
imagecopyresampled($dst_50_image, $src_image, 0, 0, 0, 0, 50, 50, $src_w, $src_h);
imagecopyresampled($dst_220_image, $src_image, 0, 0, 0, 0, 220, 220, $src_w, $src_h);
imagecopyresampled($dst_350_image, $src_image, 0, 0, 0, 0, 350, 350, $src_w, $src_h);
imagecopyresampled($dst_800_image, $src_image, 0, 0, 0, 0, 800, 800, $src_w, $src_h);
//输出目标图像
$outFun($dst_50_image,"images/image_50".$filename);
$outFun($dst_220_image,"images/image_220".$filename);
$outFun($dst_350_image,"images/image_350".$filename);
$outFun($dst_800_image,"images/image_800".$filename);
//销毁画布资源
imagedestroy($dst_50_image);
imagedestroy($dst_220_image);
imagedestroy($dst_350_image);
imagedestroy($dst_800_image);
imagedestroy($src_image);
//
echo "生成缩略图成功";
?>