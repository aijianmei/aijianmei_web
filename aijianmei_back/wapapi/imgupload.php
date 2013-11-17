<?php
error_reporting(0);
//header('Content-type: text/json');
header ( "Content-Type:application/json;charset=utf-8" );
ob_start();
var_dump($_REQUEST);
var_dump($_FILES);
$info=ob_get_contents();
ob_end_clean();
file_put_contents("tmp.txt",$info);


$_dbConfig = require_once ('config.inc.php');
function C_mysqlQuery($sql) {
	global $_dbConfig;
	$con = mysql_connect ( $_dbConfig ['DB_HOST'], $_dbConfig ['DB_USER'], $_dbConfig ['DB_PWD'] );
	if (! $con) {
		die ( 'Could not connect: ' . mysql_error () );
	}
	$db_selected = mysql_select_db ( "aijianmei", $con );
	mysql_query ( "set names 'utf8'" );
	$result = mysql_query ( $sql, $con );
	return $result;
}
function C_mysqlAll($sql) {
	$resultTmp = array ();
	$row = $res = null;
	$res = C_mysqlQuery ( $sql );
	while ( $row = mysql_fetch_assoc ( $res ) ) {
		$resultTmp [] = ( array ) $row;
	}
	foreach ( $resultTmp as $ke => $ve ) {
		foreach ( $ve as $kx => $vx ) {
			$resultTmp [$ke] [$kx] = ( string ) $vx;
		}
	}
	return $resultTmp;
}
function C_mysqlOne($sql) {
	$resultTmp = array ();
	$res = C_mysqlQuery ( $sql );
	@$row = mysql_fetch_assoc ( $res );
	if (is_array ( $row )) {
		foreach ( $row as $ke => $ve ) {
			$resultTmp [0] [$ke] = ( string ) $ve;
		}
	}
	return $resultTmp;
}

//foreach ($_FILES as $key=>$value) {
// 	 move_uploaded_file ( $_FILES [$key] ['tmp_name'], $key.".jpg" );
//} 


require_once ('reimg.php');
$uid = $_REQUEST ['uid'];
if (empty ( $uid )) {
	$data['ret'] = '10001';
	$data['dat']['uid'] = 0;
	echo json_encode ( $data );
	exit ();
}

$basedir = dirname ( dirname ( __FILE__ ) );
function Aimkdirs($dir)  
{  
	if(!is_dir($dir))  
	{  
		if(!Aimkdirs(dirname($dir))){  
			return false;  
		}  
		if(!mkdir($dir,0777)){  
			return false;  
		}  
	}  
	return true;  
}  
Aimkdirs("$basedir/data/uploads/avatar/$uid/"); 
$srcImage = "$basedir/data/uploads/avatar/$uid/original.jpg";
if (move_uploaded_file ( $_FILES ['photo'] ['tmp_name'], $srcImage )) {
	if (is_file ( $srcImage )) {
		$fileDir = "$basedir/data/uploads/avatar/$uid/big.jpg";
		$srcSize = getimagesize($srcImage);
		if($srcSize[0] >= 150){
			//@imageSizeFormate ( $srcImage, 150, $fileDir );
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(150, 150,'exact');
			$resize->saveImage($fileDir);
		}
		$fileDir = "$basedir/data/uploads/avatar/$uid/middle.jpg";
		if($srcSize[0] >= 50){
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(50, 50,'exact');
			$resize->saveImage($fileDir);
		}
		$fileDir = "$basedir/data/uploads/avatar/$uid/small.jpg";
		if($srcSize[0] >= 30){
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(30, 30,'exact');
			$resize->saveImage($fileDir);
		}
		$iosAvatar="iosAvatar".time().".jpg";
		$iosAvatarUrl = "$basedir/data/uploads/avatar/$uid/".$iosAvatar;
		if($srcSize[0] >= 50){
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(100,round(($srcSize[1]*100)/$srcSize[0]),'exact');
			$resize->saveImage($iosAvatarUrl);
		}
		$data['dat']['avatarimage'] = "http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar;
		C_mysqlOne ( "UPDATE ai_others SET iosAvatar = '" . $iosAvatar . "' WHERE uid ='".$_POST ['uid']."'" );
	}
}

$srcImage = "$basedir/data/uploads/avatar/$uid/background.jpg";
if (move_uploaded_file ( $_FILES ['backgroundimage'] ['tmp_name'], $srcImage )) {
	if (is_file ( $srcImage )) {
		$data['dat']['backgroundimage'] = "http://www.aijianmei.com/data/uploads/avatar/$uid/background.jpg";
	} else {
		$data['dat']['backgroundimage'] = '0';
	}
}

$uid = $_REQUEST ['uid'];
$username = $_REQUEST ['name'] ? $_REQUEST ['name'] : null;
$oldusernameinfo = C_mysqlOne ( "select * from ai_user where uid =$uid" );
$oldusernameinfo = $oldusernameinfo [0];
if (! empty ( $oldusernameinfo )) {
	$checkunamesql = "select uname from ai_user where uname='" . $username . "' and email!='" . $oldusernameinfo ['email'] . "'";
	$checkuname = C_mysqlOne ( $checkunamesql );
	$checkuname = $checkuname [0];
	if (! empty ( $_REQUEST ['name'] ) && empty ( $checkuname )) { // 用户名
		if (empty ( $checkuname )) {
			$upsql = null;
			$upsql = "UPDATE ai_user SET uname = '" . $username . "' WHERE uid =$uid";
			C_mysqlOne ( $upsql );
			$upsql = "UPDATE ecs_users SET user_name = '" . $username . "' WHERE user_name ='" . $oldusernameinfo ['uname'] . "'";
			C_mysqlOne ( $upsql );
		} else {
			$data ['dat'] ['uid'] = $uid;
			$data ['ret'] = '4001'; // 用户名已经存在
			echo json_encode ( $data );
			exit ();
		}
	}else{
		if(!empty($oldusernameinfo ['uname'])) $_REQUEST ['name']=$oldusernameinfo ['uname'];
		if(!empty($oldusernameinfo ['email'])) $_REQUEST ['email']=$oldusernameinfo ['email'];

	}

	if (! empty ( $_REQUEST ['description'] )) { // 个人签名
		$description = $_REQUEST ['description'];
		$sql = "UPDATE ai_others SET description = '" . $description . "' WHERE  uid =$uid";
		C_mysqlOne ( $sql );
	}else{
		$list=array();
		$getaidSql = "SELECT description FROM  ai_others  WHERE  uid =$uid";
		$list = C_mysqlOne ( $getaidSql );
		$_REQUEST ['description']=$list[0]['description'];
	}

	if (! empty ( $_REQUEST ['gender'] )) { // 性别
		$sql = "UPDATE ai_user SET sex = '" . $_REQUEST ['gender'] . "' WHERE uid=$uid";
		C_mysqlOne ( $sql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT sex FROM  ai_user  WHERE  uid =$uid";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['gender']=$list[0]['sex'];	
	}

	if (! empty ( $_REQUEST ['age'] )) { // 年龄
		$sql = "UPDATE ai_user_health_info SET age = '" . $_REQUEST ['age'] . "' WHERE uid=$uid";
		C_mysqlOne ( $sql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT age FROM  ai_user_health_info  WHERE  uid =$uid";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['age']=$list[0]['age'];	
	}

	if (! empty ( $_REQUEST ['weight'] )) { // 体重
		$sql = "UPDATE ai_user_health_info SET body_weight = '" . $_REQUEST ['weight'] . "' WHERE uid=$uid";
		C_mysqlOne ( $sql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT body_weight FROM  ai_user_health_info  WHERE  uid =$uid";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['weight']=$list[0]['body_weight'];	
	}

	if (! empty ( $_REQUEST ['height'] )) { // 身高
		$sql = "UPDATE ai_user_health_info SET height = '" . $_REQUEST ['height'] . "' WHERE uid=$uid";
		C_mysqlOne ( $sql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT height FROM  ai_user_health_info  WHERE  uid =$uid";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['height']=$list[0]['height'];	
	}

	if (! empty ( $_REQUEST ['province'] )) { // 省份
		$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_REQUEST ['province'] . "%'";
		$aidInfo = C_mysqlOne ( $getaidSql );
		$aidInfo = $aidInfo [0];
		$upsql = "UPDATE ai_user SET province='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
		C_mysqlOne ( $upsql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT title FROM ai_area WHERE area_id in(SELECT province FROM  ai_user  WHERE  uid =$uid)";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['province']=$list[0]['title'];	
	}

	if (! empty ( $_REQUEST ['city'] )) { // 城市
		$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_REQUEST ['city'] . "%'";
		$aidInfo = C_mysqlOne ( $getaidSql );
		$aidInfo = $aidInfo [0];
		$upsql = "UPDATE ai_user SET city='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
		C_mysqlOne ( $upsql );
	}else{
		$list=array();$listSql=null;
		$listSql = "SELECT title FROM ai_area WHERE area_id in(SELECT city FROM  ai_user  WHERE  uid =$uid)";
		$list = C_mysqlOne ( $listSql );
		$_REQUEST ['city']=$list[0]['title'];	
	}

	$getDafaultImageUrl=null;
	$sql=null;$list=array();
	$sql="SELECT profileImageUrl,mediaUserID FROM ai_others  WHERE  uid =$uid";
	$list=C_mysqlOne ( $sql );
	$_REQUEST ['profileImageUrl']=$list[0]['profileImageUrl'];
	$_REQUEST ['sinaUserId']     =!empty($_REQUEST['sinaUserId']) ? $_REQUEST['sinaUserId']:$list[0]['mediaUserID'];
	if(!empty($_REQUEST['profileImageUrl'])&&empty($_FILES ['photo'] ['tmp_name'])){
		$profileImageUrl = $_REQUEST ['profileImageUrl'];
		$sql = "UPDATE ai_others SET profileImageUrl = '" . $profileImageUrl . "' WHERE  uid =$uid";
		C_mysqlOne ( $sql );
	}elseif(!empty($_REQUEST['profileImageUrl'])&&!empty($_FILES ['photo'] ['tmp_name'])){
		$sql = "select iosAvatar from ai_others WHERE uid ='".$_REQUEST ['uid']."'";
		$iosAvatar=C_mysqlOne ( $sql );
		$_REQUEST ['profileImageUrl'] ="http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar[0]['iosAvatar'];
	}elseif(empty($_REQUEST['profileImageUrl'])&&!empty($_FILES ['photo'] ['tmp_name'])){
		$sql = "select iosAvatar from ai_others WHERE uid ='".$_REQUEST ['uid']."'";
		$iosAvatar=C_mysqlOne ( $sql );
		$_REQUEST ['profileImageUrl'] ="http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar[0]['iosAvatar'];
	}
}
$bim = getBmiById ( $uid );
$data['dat']['uid'] = $uid;
$data['dat']['BMIValue'] = $bim;
$data['dat']['name'] = $_REQUEST ['name']?$_REQUEST ['name']:'';
$data['dat']['description'] = $_REQUEST ['description']?$_REQUEST ['description']:'';
$data['dat']['gender'] =$_REQUEST ['gender'];
$data['dat']['sinaUserId'] = $_REQUEST ['sinaUserId']?$_REQUEST ['sinaUserId']:'';
$data['dat']['email'] = $_REQUEST ['email']?$_REQUEST ['email']:'';
$data['dat']['age'] =$_REQUEST ['age']?$_REQUEST ['age']:'';
$data['dat']['weight'] = $_REQUEST ['weight']?$_REQUEST ['weight']:'';
$data['dat']['height'] = $_REQUEST ['height']?$_REQUEST ['height']:'';
$data['dat']['province'] = $_REQUEST ['province']?$_REQUEST ['province']:'';
$data['dat']['city'] = $_REQUEST ['city']?$_REQUEST ['city']:'';
$data['dat']['profileImageUrl'] = $_REQUEST ['profileImageUrl']?$_REQUEST ['profileImageUrl']:'';
echo json_encode ( $data );
exit ();


function mb_unserialize($serial_str) {
	$serial_str = preg_replace ( '!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
	$serial_str = str_replace ( "\r", "", $serial_str );
	return unserialize ( $serial_str );
}
function getBmiById($uid) {
	$sql = $result = null;
	$sql = "SELECT body_weight,height FROM  ai_user_health_info WHERE uid=$uid ";
	$bmiinfo = C_mysqlOne ( $sql );
	$bmi = $bmiinfo [0] ['body_weight'] / (($bmiinfo [0] ['height'] / 100) * ($bmiinfo [0] ['height'] / 100));
	return round ( $bmi, 2 );
}
function updateList($tablename,$params,$where){
	//update data list info 
	if(is_array($params)){
		$updateString=null;
		foreach ($params as $key => $value) {
			$updateString.= empty($updateString) ? " ".$key." ='".$value."'" : ", ".$key." ='".$value."'" ;
		}
	}elseif($params){
		$updateString=null;
		$updateString=$params;
	}else{
		return;
	}

	if(is_array($where)){
		$whereString=null;
		foreach ($where as $key => $value) {
			$whereString.=empty($whereString) ? " WHERE ".$key." = '".$key."'": " AND ".$key." = '".$key."'";
		}
	}elseif (is_string($where)) {
		$whereString=null;
		$whereString="WHERE {$where}";	
	}else{
		return;
	}
	if(empty($updateString)||empty($whereString)) return;

	$sql = "UPDATE {$tablename} SET {$updateString} {$whereString}";
	C_mysqlOne ( $sql );
}