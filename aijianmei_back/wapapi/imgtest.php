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




//foreach ($_FILES as $key=>$value) {
// 	 move_uploaded_file ( $_FILES [$key] ['tmp_name'], $key.".jpg" );
//} 


require_once ('reimg.php');
$uid = $_POST ['uid'];
if (empty ( $uid )) {
	$data[0]['errorCode'] = '10001';
	$data[0]['uid'] = 0;
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
			$resize->resizeTo(150, 150);
			$resize->saveImage($fileDir);
		}
		$fileDir = "$basedir/data/uploads/avatar/$uid/middle.jpg";
		if($srcSize[0] >= 50){
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(50, 50);
			$resize->saveImage($fileDir);
		}
		$fileDir = "$basedir/data/uploads/avatar/$uid/small.jpg";
		if($srcSize[0] >= 30){
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(30, 30);
			$resize->saveImage($fileDir);
		}
		$data[0]['avatarimage'] = "http://www.aijianmei.com/data/uploads/avatar/$uid/original.jpg";
	}
}

$srcImage = "$basedir/data/uploads/avatar/$uid/background.jpg";
if (move_uploaded_file ( $_FILES ['backgroundimage'] ['tmp_name'], $srcImage )) {
	if (is_file ( $srcImage )) {
		$data[0]['backgroundimage'] = "http://www.aijianmei.com/data/uploads/avatar/$uid/background.jpg";
	} else {
		$data[0]['backgroundimage'] = '0';
	}
}

$data[0]['errorCode'] = '0';
$data[0]['uid'] = $uid;
echo json_encode ( $data );
exit ();