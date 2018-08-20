<?php


/**
 * [addPro 添加商品]
 */
function addPro(){
	$arr=$_POST;
	$arr['pubTime']=time();
	$arr['isShow']=1;
	$arr['isHot']=0;
	$path="./uploads";
	$uploadFiles=uploadFile($path);
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $key=>$uploadFile){
			thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
			thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
			thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
			thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
		}
	}
	$res=insert("imooc_pro",$arr);
	$pid=$res;
	if($res&&$pid){
       foreach($uploadFiles as $uploadFile){
       	$arr1['pid']=$pid;
       	$arr1['albumPath']=$uploadFile['name'];
       	addAlbum($arr1);
       }
       $mes="<p>添加成功</P><a href='addPro.php' target = 'mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
		foreach($uploadFiles as $uploadFile){
			if(file_exists("../image_800/".$uploadFile['name'])){
				unlink("../image_800/".$uploadFile['name']);
			}
			if(file_exists("../image_50/".$uploadFile['name'])){
				unlink("../image_50/".$uploadFile['name']);
			}
			if(file_exists("../image_220/".$uploadFile['name'])){
				unlink("../image_220/".$uploadFile['name']);
			}
			if(file_exists("../image_350/".$uploadFile['name'])){
				unlink("../image_350/".$uploadFile['name']);
			}
		}
		$mes="<p>添加失败</P><a href='addPro.php' target = 'mainFrame'>重新添加</a>";
	}
	return $mes;
}


/**
 * [editPro 修改商品信息]
 * @param  [type] $id [需要修改的商品的ID]
 * @return [type]     [description]
 */
function editPro($id){
	$arr=$_POST;
	$arr['isShow']=1;
	$arr['isHot']=0;
	$path="./uploads";
	$uploadFiles=uploadFile($path);
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $key=>$uploadFile){
			thumb($path."/".$uploadFile['name'],"../image_50/".$uploadFile['name'],50,50);
			thumb($path."/".$uploadFile['name'],"../image_220/".$uploadFile['name'],220,220);
			thumb($path."/".$uploadFile['name'],"../image_350/".$uploadFile['name'],350,350);
			thumb($path."/".$uploadFile['name'],"../image_800/".$uploadFile['name'],800,800);
		}
	}
	$res=update("imooc_pro",$arr,"id={$id}");
	$pid=$id;
	if($res&&$pid){
	   if(is_array($uploadFiles)&&$uploadFiles){
       foreach($uploadFiles as $uploadFile){
       	$arr1['pid']=$pid;
       	$arr1['albumPath']=$uploadFile['name'];
       	addAlbum($arr1);
       }
   }
       $mes="<p>修改成功</P><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $uploadFile){
			if(file_exists("../image_800/".$uploadFile['name'])){
				unlink("../image_800/".$uploadFile['name']);
			}
			if(file_exists("../image_50/".$uploadFile['name'])){
				unlink("../image_50/".$uploadFile['name']);
			}
			if(file_exists("../image_220/".$uploadFile['name'])){
				unlink("../image_220/".$uploadFile['name']);
			}
			if(file_exists("../image_350/".$uploadFile['name'])){
				unlink("../image_350/".$uploadFile['name']);
			}
		}
	}
		$mes="<p>修改失败</P><a href='listPro.php' target = 'mainFrame'>重新修改</a>";
	}
	return $mes;
}


/**
 * [getAllImgByProId 得到商品图片的存放路径]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getAllImgByProId($id){
	$sql="select a.albumPath from imooc_album a where pid={$id}";
	$rows=fetchAll($sql);
	return $rows;
}


/**
 * [getProById 根据id得到商品的详细信息]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getProById($id){
   $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.id={$id} ";
   $rows=fetchOne($sql);
   return $rows;
}

/**
 * [delPro 删除商品]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function delPro($id){
	$where="id=$id";
	$res=delete("imooc_pro",$where);
	$proImgs=getAllImgByProId($id);
	if($proImgs&&is_array($proImgs)){
		foreach($proImgs as $proImg){
			if(file_exists("uploads/".$proImg['albumPath'])){
				unlink("uploads/".$proImg['albumPath']);
			}
			if(file_exists("../image_50/".$proImg['albumPath'])){
				unlink("../image_50/".$proImg['albumPath']);
			}
			if(file_exists("../image_220/".$proImg['albumPath'])){
				unlink("../image_220/".$proImg['albumPath']);
			}
			if(file_exists("../image_350/".$proImg['albumPath'])){
				unlink("../image_350/".$proImg['albumPath']);
			}
			if(file_exists("../image_800/".$proImg['albumPath'])){
				unlink("../image_800/".$proImg['albumPath']);
			}			
		}
	}
	$where1="pid={$id}";
	$res1=delete("imooc_album",$where1);
	if($res&&$res1){
	$mes="<p>删除成功</P><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
	$mes="<p>删除失败</P><a href='listPro.php' target = 'mainFrame'>重新修改</a>";
	}
	return $mes;
}

/**
 * [checkProExist 检查分类下是否有产品]
 * @param  [type] $cid [description]
 * @return [type]      [description]
 */
function checkProExist($cid){
  $sql="select * from imooc_pro where cId={$cid}";
  $rows=fetchAll($sql);
  return $rows;
}

/**
 * [getAllPros 得到所有商品]
 * @return [type] [description]
 */
function getAllPros(){
 $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id ";
 $rows=fetchAll($sql);
 return $rows;
}


/**
 * [getPrsByCid 通过分类名称得到商品信息但最多只能显示4个]
 * @param  [type] $cid [description]
 * @return [type]      [description]
 */
function getProsByCid($cid){
$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4";
 $rows=fetchAll($sql);
 return $rows;
}

/**
 * [getSmallProsByCid 通过分类名称得到下4条商品信息]
 * @param  [type] $cid [description]
 * @return [type]      [description]
 */
function getSmallProsByCid($cid){
$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
 $rows=fetchAll($sql);
 return $rows;
}

/**
 * [getProInfo 得到商品的id和名称]
 * @return [type] [description]
 */
function getProInfo(){
	$sql="select id,pName from imooc_pro order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}
?>