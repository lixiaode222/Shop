<?php

/**
 * [addCate 添加分类]
 */
function addCate(){
	$arr=$_POST;
	if(insert("imooc_cate",$arr)){
		$mes="分类添加成功!<br/><a href='addCate.php'>继续添加分类</a>|<a href='listCate.php'>查看分类</a>";
	}else{
		$mes="分类添加失败!<br/><a href='addCate.php'>重新添加分类</a>|<a href='listCate.php'>查看分类</a>";
	}
	return $mes;
}

/**
 * [editCate 修改分类]
 * @param  [type] $id [ID]
 * @return [type]     [description]
 */
function editCate($id){
	$arr=$_POST;
	if(update("imooc_cate",$arr,"id={$id}")){
    	$mes="分类编辑成功!<br/><a href='listCate.php'>查看分类列表</a>";
    }else{
    	$mes="分类编辑失败!<br/><a href='listCate.php'>请重新修改分类</a>";
    }
    return $mes;
}

/**
 * [delCate 删除分类]
 * @param  [type] $id [ID]
 * @return [type]     [description]
 */
function delCate($id){
	$res=checkProExist($id);
	if(!$res){
		$where="id={$id}";
		if(delete("imooc_cate",$where)){
			$mes="分类删除成功!<br/><a href='listCate.php'>查看分类列表</a>";
		}else{
			$mes="分类删除失败!<br/><a href='listCate.php'>请重新删除分类</a>";
		}
		return $mes;
	}else{
		alertMes("不能删除分类,请先删除该分类下的商品","listPro.php");
	}
}



/**
 * [getCateById 根据ID得到指定分类信息]
 * @param  [type] $id [ID]
 * @return [type]     [分类信息的结果集]
 */
function getCateById($id){
	$sql="select id,cName from imooc_cate where id='{$id}'";
    $row=fetchOne($sql);
    return $row;
}

/**
 * [getAllCate 得到所有商品分类]
 * @return [type] [返回商品分类的数组]
 */
function getAllCate(){
	$sql="select id,cName from imooc_cate";
	$rows=fetchAll($sql);
	return $rows;
}

?>