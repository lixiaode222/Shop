<?php
/**
 * [getRandomString description]              生成验证码字符串
 * @param  integer $type   [description]      验证码类型 1：数字   2：字母   3：数字加字母
 * @param  integer $length [description]      验证码长度
 * @return [type]          [description]      返回验证码字符串
 */
function getRandomString($type=1,$length=4){
if($type==1){
	$chars = join('',range(0, 9));
}elseif ($type==2) {
	$chars = join('',array_merge(range('a', 'z'),range('A', 'Z'))); 
}elseif ($type==3) {
	$chars = join('',array_merge(range(0, 9),range('a', 'z'),range('A', 'Z')));
}
if($length>strlen($chars)){
	exit('字符串长度不够');
}
$chars=str_shuffle($chars);
return substr($chars,0,$length);
}

/*
生成唯一字符串
 */
function getUniName(){
	return md5(uniqid(microtime(true),true));
}

/**
 * [getExt 得到文件扩展名]
 * @param  [type] $filename [文件名字]
 * @return [type]           [description]
 */
function getExt($filename){
	$mid=explode(".", $filename);
    $res=strtolower(end($mid));
    return $res;
}
?>