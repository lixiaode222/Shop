<?php
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
header('content-type:'.$dst_mime);
$dst_outFun($dst_im,$dst_file);
imagedestroy($dst_im);
imagedestroy($src_im);
}
?>