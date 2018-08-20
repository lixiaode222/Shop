<?php
require_once('../lib/string.func.php');
require_once('doAction.php');
header("content-type:text/html;charset=utf-8");

//print_r($_FILES);
/**
 * [buildInfo 构建上传文件信息]
 * @return [array] [上传文件信息的数组]
 */
function buildInfo(){
	$i=0;
	foreach($_FILES as $v){
		if(is_string($v['name'])){
			//如果是string证明是二维数组，也就证明是单文件上传
			$file[$i]=$v;
			$i++;
		}else{
			//如果不是string证明是三维数组，也就证明是多文件上传
			foreach ($v['name'] as $key => $val){
				$files[$i]['name']=$val;
				$files[$i]['size']=$v['size'][$key];
				$files[$i]['tmp_name']=$v['tmp_name'][$key];
				$files[$i]['error']=$v['error'][$key];
				$files[$i]['type']=$v['type'][$key];
				$i++;
			}
		}
	}
	return $files;
}

function uploadFile($path="uploads",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true){

	//判断目录中是否有uploads这个文件夹,没有的话就创建这个文件夹
	if(!file_exists($path)){
		mkdir($path,0777,true);
	}
	$i=0;
	//
	$files=buildInfo();
	foreach($files as $file){
		//判断是否上传成功
		if($file['error']===UPLOAD_ERR_OK){
         //取出文件扩展名
         $ext=getExt($file['name']);
         //判断上传的文件是否在可上传文件类型里面
         if(!in_array($ext, $allowExt)){
         	exit("非法文件类型");
         }
         //判断上传文件是否是一个真正的图片类型
         if($imgFlag){
         	if(!getimagesize($file['tmp_name'])){
         		exit("不是一个真正的图片类型");
         	}
         }
         //判断上传文件的大小是否在合理的范围里
         if($file['size']>$maxSize){
         	exit("上传文件过大");
         }
         //判断文件是否是通过HTTP POST方式上传的
         if(!is_uploaded_file($file['tmp_name'])){
         	exit("不是通过HTTP POST方式上传上来的");
         }
         //把文件移动指定的目录下面,并且产生一个唯一的名字
         $filename=getUniName().".".$ext;
         $destination=$path."/".$filename;
         if(move_uploaded_file($file['tmp_name'], $destination)){
              $file['name']=$filename;
              //取消掉不需要返回的内容
              unset($file['error'],$file['tmp_name'],$file['size'],$file['type']);
              $uploadedFile[$i]=$file;
              $i++;
         }
         
		}else{
			//匹配错误信息
			switch ($file['error']) {
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
			//输出处理结果
			echo $mes;
		}
	}
	return $uploadedFile;
}

$fileInfo=uploadFile();
print_r($fileInfo);
?>
