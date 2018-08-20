<?php
ob_clean();


/**
 * [getRandomColor description]   创建随机颜色
 * @param  [type] $image [description]  输入画布资源
 * @return [type]        [description]  返回随机颜色
 */
function getRandomColor($image){
   $randomColor=imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
   return $randomColor;
}


/**
 * [verifyImage description]  创建验证码
 * @param  integer $type      [验证码类型]
 * @param  integer $length    [验证码长度]
 * @param  string  $sess_name [see_name的名称]
 * @param  integer $pixel     [像素点的个数]
 * @param  integer $line      [线的个数]
 * @return [type]             [description]
 */
function verifyImage($type=1,$length=4,$sess_name='verify',$pixel=50,$line=3){
$width=80;
$height=30;
$image=imagecreatetruecolor($width, $height);
//创建颜色
$white=imagecolorallocate($image, 255, 255, 255);
$black=imagecolorallocate($image, 0, 0, 0);
//用白色矩形填充画布
imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
$chars=getRandomString($type,$length);
$_SESSION[$sess_name]=$chars;
$fontfile='../fonts/simsun.ttc';
//生成验证码
for($i=0;$i<$length;$i++){
	$size=mt_rand(15,17);
	$angle=mt_rand(-15,15);
	$x=8+$i*$size;
	$y=25;
	$color=getRandomColor($image);
	$text=substr($chars,$i,1);
	imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
}
for($i=1;$i<=$pixel;$i++){
    imagesetpixel($image, mt_rand(0,$width), mt_rand(0,$height), getRandomColor($image));
}

for($i=1;$i<=$line;$i++){
    imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height),getRandomColor($image));
}
header('content-type:image/gif');
imagegif($image);
imagedestroy($image);
}


/**
 * [thumb 生成文件缩略图]
 * @param  [string]  $filename         [文件名]
 * @param  [string]  $destination      [保存的地址]
 * @param  [int]  $dst_w            [缩略图的宽默认为null]
 * @param  [int]  $dst_h            [缩略图的高默认为null]
 * @param  boolean $isReservedSource [是否删除原文件默认为false]
 * @param  float   $scale            [缩放比例默认为0.5]
 * @return [string]                    [缩略图的地址]
 */
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

/**
 * [waterText 添加文字水印]
 * @param  [type] $filename [文件名字]
 * @param  string $text     [文字内容]
 * @param  string $fontfile [字体文件]
 * @return [type]           [description]
 */
function waterText($filename,$text="imooc.com",$fontfile="simsun.ttc"){
$fileInfo=getimagesize($filename);
$mime=$fileInfo['mime'];
$createFun=str_replace('/', 'createfrom', $mime);
$outFun=str_replace('/', null, $mime);
$image=$createFun($filename);
$color=imagecolorallocatealpha($image, 255, 0, 0, 50);
$fontfile="../fonts/{$fontfile}";
imagettftext($image, 28, 0, 0, 14, $color, $fontfile, $text);
//header("content-type:".$mime);
$outFun($image,$filename);
imagedestroy($image);
}


/**
 * [waterPic 添加图片水印]
 * @param  [type]  $dst_file [文件名字]
 * @param  string  $src_file [LOGO的文件名字]
 * @param  integer $pct      [透明度]
 * @return [type]            [description]
 */
function waterPic($dst_file,$src_file="../images/logo.jpg",$pct=30){
$src_info=getimagesize($src_file);
$dst_info=getimagesize($dst_file);
$src_w=$src_info[0];
$src_h=$src_info[1];
$src_mime=$src_info['mime'];
$dst_mime=$dst_info['mime'];
$src_createFun=str_replace('/', 'createfrom', $src_mime);
$dst_createFun=str_replace('/', 'createfrom', $dst_mime);
$src_outFun=str_replace('/', null, $src_mime);
$dst_outFun=str_replace('/', null, $dst_mime);
$src_im=$src_createFun($src_file);
$dst_im=$dst_createFun($dst_file);
imagecopymerge($dst_im, $src_im, 0, 0, 0, 0, $src_w, $src_h,$pct);
//header('content-type:'.$dst_mime);
$dst_outFun($dst_im,$dst_file);
imagedestroy($dst_im);
imagedestroy($src_im);
}
?>