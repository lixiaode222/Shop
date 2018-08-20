<?php
require_once'../lib/string.func.php';
$filename="123.jpg";
thumb($filename,"images_50/".$filename,50,50);
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=false,$scale=0.5){
	list($src_w,$src_h,$imagetype)=getimagesize($filename);
	//如果没有输入缩放后的宽和高就用默认的缩放比例缩放
	if(is_null($dst_w)||is_null($dst_h)){
		$dst_w=ceil($src_w*$scale);
		$dst_h=ceil($src_h*$scale);
	}
	$mime=image_type_to_mime_type($imagetype);
	//得到createFun和outFun用做以后的声明函数
	$createFun=str_replace("/", "createfrom", $mime);
	$outFun=str_replace("/", null, $mime);
	//创建画布资源
	$src_image=$createFun($filename);
	$dst_image=imagecreatetruecolor($dst_w, $dst_h);
	//重采样图片
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	//判断是否存在目录,如果没有就创建
	if($destination&&!file_exists(dirname($destination))){
		mkdir(dirname($destination),0777,true);
	}
	$dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
	//保存图片
	$outFun($dst_image,$dstFilename);
	//销毁资源
	imagedestroy($src_image);
	imagedestroy($dst_image);
	//判断是否删除原文件
	$isReservedSource=false;
	if($isReservedSource){
		unlink($filename);
	}
	return $dstFilename;
}

?>