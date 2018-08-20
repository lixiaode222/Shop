<?php
require_once('../lib/string.func.php');
header("content-type:text/html;charset=utf-8");
//上传的数据保存在$_FILES里面
//打印的话会发现是有一个二维的数组
//print_r($_FILES);
//首先我们把数组的内容取出来
$filename=$_FILES['myFile']['name'];
$type=$_FILES['myFile']['type'];
$tmp_name=$_FILES['myFile']['tmp_name'];
$error=$_FILES['myFile']['error'];
$size=$_FILES['myFile']['size'];


/**
 * [uploadFile 单文件上传]
 * @param  [array]  $fileInof [传过来的文件信息的数组]
 * @param  [string] $path     [文件保存的文件夹]
 * @param  array   $allowExt [允许上传的文件类型的数组]
 * @param  integer $maxSize  [允许上传的最大文件大小]
 * @param  boolean $imgFlag  [description]
 * @return [type]            [description]
 */
function uploadFile1($fileInfo,$path="uploads",$allowExt=array("gif","jpeg","jpg","png","wbmp"),$maxSize=2097152,$imgFlag=true){
//设置允许上传的文件类型
//$allowExt=array("gif","jpeg","jpg","png","wbmp");
//设置上传文件最大大小
//$maxSize=2097152;
//初始化imgFlage
//$imgFlag=true;
//判断一下错误信息
if($fileInfo['error']==UPLOAD_ERR_OK){
	//判断上传的文件是否是运行上传的文件类型
	$ext=getExt($fileInfo['name']);
	if(!in_array($ext, $allowExt)){
		exit("非法文件类型");
	}
if($fileInfo['size']>$maxSize){
	exit("文件过大");
}
//验证图片是否是一个真正的图片类型
if($imgFlag){
   //可以用getimagesize()来验证
   $info=getimagesize($fileInfo['tmp_name']);
   if(!$info){
    exit("不是真正的图片类型");
   }
}
   //需要判断下文件是否是通过HTTP POST方式上传上来的
   //is_uploaded_file($tmp_name);
   if(is_uploaded_file($fileInfo['tmp_name'])){
      //移动临时文件到指定目录
      $filename=getUniName().".".$ext;
      //$path="uploads";
      if(!file_exists($path)){
      	mkdir($path,0777,true);
      }
      $destination=$path."/".iconv("UTF-8", "gbk",$filename);
      if(move_uploaded_file($fileInfo['tmp_name'], $destination)){
         $mes="文件上传成功";
      }else{
      	$mes="文件移动失败";
      }
   }else{
   	$mes="文件不是通过HTTP POST方式上传上来的";
   }
}else{
	switch ($fileInfo['error']) {
		case 1:
		    $mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
		    break;
		case 2:
		    $mes="超过了表单设置上传文件大小";//UPLOAD_ERR_FORM_SIZE
		    break;
		case 3:
		    $mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
		    break;
		case 4:
		    $mes="没有文件被上传";//UPLOAD_ERR_NO_FILE
		    break;
		case 6:
		    $mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
		    break;
		case 7:
		    $mes="文件不可写";//UPLOAD_ERR_CANT_WRITE
		    break;
		case 8:
		    $mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
		    break;

	}
}
return $mes;
}
?>