<?php
error_reporting(0);
session_start();
function uploadImageFile($size=null) { // Note: GD library is required for this function
$size=empty($size)?150:$size;
$sizeArray=array('50'=>'small','100'=>'middle','150'=>'big');
if(!$_SESSION['allowbackmid']){return;}
$path='data/uploads/avatar/'.$_SESSION['allowbackmid'].'/';
//original.jpg'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$iWidth = $iHeight = $size; // 输出大小
$iJpgQuality = 100;

if ($_FILES) {

// if no errors and size less than 250kb
if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < (2* 1024 * 1024)) {
if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

// new unique filename
//$sTempFileName = 'cache/' . md5(time().rand());
$sTempFileName =  md5(time().rand());
$sTempFileName = $path.$sizeArray[$size];
// move uploaded file into cache folder
move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
move_uploaded_file($_FILES['image_file']['tmp_name'], $path."original.jpg");
// change file permission to 644
@chmod($sTempFileName, 0644);

if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
$aSize = getimagesize($sTempFileName); // try to obtain image info
if (!$aSize) {
@unlink($sTempFileName);
return;
}

// check for image type
switch($aSize[2]) {
case IMAGETYPE_JPEG:
$sExt = '.jpg';

// create a new image from file
$vImg = @imagecreatefromjpeg($sTempFileName);
break;
case IMAGETYPE_PNG:
$sExt = '.png';

// create a new image from file
$vImg = @imagecreatefrompng($sTempFileName);
break;
default:
@unlink($sTempFileName);
return;
}

// create a new true color image
$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

// copy and resize part of an image with resampling
imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

// define a result image filename
$sResultFileName = $sTempFileName . $sExt;

// output image to file
imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
@unlink($sTempFileName);
return $sResultFileName;
}
}
}
}
}
}

$sImage = uploadImageFile();
//echo "<textarea><img src='".$fdata['data']['picurl']."'/></textarea>";
$path='data/uploads/avatar/'.$_SESSION['allowbackmid'].'/';
echo '<textarea><img src="/Templates/Jcrop/'.$sImage.'?'.rand().$path.'" /></textarea>';