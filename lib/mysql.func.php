<?php


/**
 * [connect 连接数据库]
 * @return [type] [连接的标识符]
 */
function connect(){
	$link=mysqli_connect(DB_HOST,DB_USER,DB_PWD)or die(("数据库连接失败Error:").mysql_errno().":".mysql_error());
	//mysqli_set_charset($link,DB_CHARSET);
	mysqli_select_db($link,DB_DBNAME) or die("指定数据库打开失败");
	return $link;
}


/**
 * [insert 记录的插入操作]
 * @param  [string] $table [插入的表名]
 * @param  [array] $array [description]
 * @return [type]        [description]
 */
function insert($table,$array){
  $link=connect();
  $keys=join(',',array_keys($array));
  $vals="'".join("','",array_values($array))."'";
  $sql="insert into {$table}($keys)values({$vals})";
  mysqli_query($link,$sql);
  return mysqli_insert_id($link);
}


/**
 * [update 记录的更新操作]
 * @param  [string] $table [description]
 * @param  [array] $array [description]
 * @param  [string] $where [description]
 * @return [type]        [description]
 */
function update($table, $array, $where=null){
   $link =  connect();
   $str = '';
   foreach ($array as $key => $val){
       if ($str == null) {
           $sep = "";
       } else {
           $sep = ",";
       }
       $str.=$sep."`".$key."`"."='".$val."'";
   }
   $sql = "UPDATE `{$table}` SET {$str}"." ".($where == null? null:"WHERE". " "."`{$table}`".".".$where);
   $result = mysqli_query($link,$sql);
   if ($result){
       return mysqli_affected_rows($link);
   } else {
       return false;
   }
}


/**
 * [delete 记录的删除操作]
 * @param  [string] $table [description]
 * @param  [string] $where [description]
 * @return [type]        [description]
 */
function delete ($table,$where){
   $link =  connect();
   $where = $where==null? null:"where"."`".$table."`".".".$where;
   $sql = "delete from `{$table}` {$where}";
   //echo ($sql);
   $reslt =  mysqli_query($link,$sql);
   if ($reslt){
       return mysqli_affected_rows($link);
   } else {
       return false;
   }

}


/**
 * [fetchOne description]
 * @param  [string] $sql         [sql语句]
 * @param  [type] $result_type [description]
 * @return [type]              [description]
 */
function fetchOne ($sql,$result_type=MYSQLI_ASSOC) {
   $link =  connect();
   $result = mysqli_query($link,$sql);
   if (mysqli_errno($link)){
       die(mysqli_errno($link));
       $mes =  mysqli_errno($link);
       echo "<script>alert('{$mes}');</script>";
   }
   $row = mysqli_fetch_assoc($result);
   return $row;
}


/**
 * [fetchAll 等到结果集的所有记录]
 * @param  [string] $sql         [description]
 * @param  [type] $result_type [description]
 * @return [type]              [description]
 */
function fetchAll($sql,$result_type=MYSQLI_ASSOC){
   $link =  connect();
   $result = mysqli_query($link,$sql);
       while (@$row = mysqli_fetch_array($result,$result_type)){
           $rows[] = $row;
       }
       return isset($rows)?$rows:null;
}


/**
 * [getResultNum 得到结果集的记录条数]
 * @param  [type] $sql [description]
 * @return [type]      [description]
 */
function getResultNum ($sql) {
   $link = connect();
   $result = mysqli_query($link,$sql);
   if ($result) {
       return mysqli_num_rows($result);
   } else {
       return null;
   }
}


/**
 * [getInsertId 得到上一步插入的ID号]
 * @return [type] [description]
 */
function getInsertId(){
   $link = connect();
   return mysqli_insert_id($link);
}
?>
