<?php
error_reporting(0);
//header('Content-type: text/json');
header ( "Content-Type:application/json;charset=utf-8" );
ob_start();
var_dump($_POST);
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
$uid = $_POST ['uid'];
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
if (move_uploaded_file ( $_FILES ['avatarimage'] ['tmp_name'], $srcImage )) {
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



		$uid = $_POST ['uid'];
		$username = $_POST ['name'] ? $_POST ['name'] : null;
		$oldusernameinfo = C_mysqlOne ( "select * from ai_user where uid =$uid" );
		$oldusernameinfo = $oldusernameinfo [0];
		if (! empty ( $oldusernameinfo )) {
			$checkunamesql = "select uname from ai_user where uname='" . $username . "' and email!='" . $oldusernameinfo ['email'] . "'";
			$checkuname = C_mysqlOne ( $checkunamesql );
			$checkuname = $checkuname [0];
			if (! empty ( $_POST ['name'] ) && empty ( $checkuname )) { // 用户名
				
				if (empty ( $checkuname )) {
					//$this->updatePWUname ( $oldusernameinfo ['uname'], $oldusernameinfo ['email'], $username );
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
			}
			/*if (! empty ( $_GET ['keyword'] )) { // 标签
				$keywordinfo = explode ( "|", $_GET ['keyword'] );
				$oldkeyword = C_mysqlOne ( "select keyword from ai_user_keywords WHERE uid =$uid" );
				if (! empty ( $oldkeyword [0] )) {
					$oldkeyword = mb_unserialize ( $oldkeyword [0] ['keyword'] );
					foreach ( $oldkeyword as $key => &$value ) {
						foreach ( $keywordinfo as $key1 => &$value1 ) {
							if (! in_array ( $value1, $oldkeyword )) {
								$oldkeyword [] = $value1;
							}
						}
					}
				} else {
					$oldkeyword = $keywordinfo;
				}
				$sql = "INSERT INTO ai_user_keywords VALUES($uid,serialize($oldkeyword)) ON DUPLICATE KEY UPDATE keyword='" . serialize ( $oldkeyword ) . "'";
				C_mysqlOne ( $sql );
			}*/
			if (! empty ( $_POST ['description'] )) { // 个人签名
				$description = $_POST ['description'];
				$sql = "UPDATE ai_others SET description = '" . $description . "' WHERE  uid =$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_POST ['gender'] )) { // 性别
				$sql = "UPDATE ai_user SET sex = '" . $_POST ['gender'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_POST ['age'] )) { // 年龄
				$sql = "UPDATE ai_user_health_info SET age = '" . $_POST ['age'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}

			if (! empty ( $_POST ['weight'] )) { // 体重
				$sql = "UPDATE ai_user_health_info SET body_weight = '" . $_POST ['weight'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_POST ['height'] )) { // 身高
				$sql = "UPDATE ai_user_health_info SET height = '" . $_POST ['height'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_POST ['province'] )) { // 省份
				$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_POST ['province'] . "%'";
				$aidInfo = C_mysqlOne ( $getaidSql );
				$aidInfo = $aidInfo [0];
				$upsql = "UPDATE ai_user SET province='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
				C_mysqlOne ( $upsql );
			}
			if (! empty ( $_POST ['city'] )) { // 城市
				$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_POST ['city'] . "%'";
				$aidInfo = C_mysqlOne ( $getaidSql );
				$aidInfo = $aidInfo [0];
				$upsql = "UPDATE ai_user SET city='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
				C_mysqlOne ( $upsql );
			}
			if(!empty($_POST['profileImageUrl'])&&empty($_FILES ['avatarimage'] ['tmp_name'])){
				$profileImageUrl = $_POST ['profileImageUrl'];
				$sql = "UPDATE ai_others SET profileImageUrl = '" . $profileImageUrl . "' WHERE  id =$uid";
				C_mysqlOne ( $sql );
			}elseif(!empty($_POST['profileImageUrl'])&&!empty($_FILES ['avatarimage'] ['tmp_name'])){
				$sql = "select iosAvatar from ai_others WHERE uid ='".$_POST ['uid']."'";
				$iosAvatar=C_mysqlOne ( $sql );
				$_POST ['profileImageUrl'] ="http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar[0]['iosAvatar'];
			}elseif(empty($_POST['profileImageUrl'])&&!empty($_FILES ['avatarimage'] ['tmp_name'])){
				$sql = "select iosAvatar from ai_others WHERE uid ='".$_POST ['uid']."'";
				$iosAvatar=C_mysqlOne ( $sql );
				$_POST ['profileImageUrl'] ="http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar[0]['iosAvatar'];
			}
		}
$bim = getBmiById ( $uid );
$data['dat']['uid'] = $uid;
$data['dat']['BMIValue'] = $bim;
$data['dat']['name'] = $_POST ['name']?$_POST ['name']:'';
$data['dat']['description'] = $_POST ['description']?$_POST ['description']:'';
$data['dat']['gender'] =$_POST ['gender'];
$data['dat']['sinaUserId'] = $_POST ['sinaUserId']?$_POST ['sinaUserId']:'';
$data['dat']['email'] = $_POST ['email']?$_POST ['email']:'';
$data['dat']['age'] =$_POST ['age']?$_POST ['age']:'';
$data['dat']['weight'] = $_POST ['weight']?$_POST ['weight']:'';
$data['dat']['height'] = $_POST ['height']?$_POST ['height']:'';
$data['dat']['province'] = $_POST ['province']?$_POST ['province']:'';
$data['dat']['city'] = $_POST ['city']?$_POST ['city']:'';
$data['dat']['profileImageUrl'] = $_POST ['profileImageUrl']?$_POST ['profileImageUrl']:'';
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
