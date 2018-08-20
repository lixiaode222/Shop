<?php


/**
 * [addAlbum 添加相册]
 * @param [type] $arr [description]
 */
function addAlbum($arr){
	insert("imooc_album",$arr);
}

/**
 * [getProImgById 根据商品的ID去找一张它的图片]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getProImgById($id){
  $sql="select albumPath from imooc_album where pid={$id} limit 1";
  $rows=fetchOne($sql);
  return $rows;
}

/**
 * [getProImgsById 根据商品的ID去得到所有的图片]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getProImgsById($id){
  $sql="select albumPath from imooc_album where pid={$id}";
  $rows=fetchAll($sql);
  return $rows;
}

/**
 * [doWateText 文字水印]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function doWaterText($id){
  $rows=getProImgsById($id);
  foreach($rows as $row){
  	$filename="../image_800/".$row['albumPath'];
  	waterText($filename);
  }
  $mes="添加文字水印成功<a href='listProImages.php'>返回列表</a>";
  return $mes;
}

/**
 * [doWatePic 图片水印]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function doWaterPic($id){
  $rows=getProImgsById($id);
  foreach($rows as $row){
  	$filename="../image_800/".$row['albumPath'];
  	waterPic($filename);
  }
  $mes="添加图片水印成功<a href='listProImages.php'>返回列表</a>";
  return $mes;
}
?>