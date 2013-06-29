<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
$_SESSION['ai_pwlogin_allow']=null;
$ai_pwreg=$_REQUEST['ai_pwreg'];
$ai_pwlogin=$_REQUEST['ai_pwlogin'];
if($ai_pwreg==1||$ai_pwlogin==1){
	$_SESSION['ai_pwlreg_allow']=1;
}


if($_SESSION['pwai_url']!=''){
	$_SESSION['ai_pwlreg_allow']=2;
	//$_SESSION['ai_pwlogin_allow']=1;
	$_SESSION['airel']=1;
	$ai_url=$_SESSION['pwai_url'];
	unset($_SESSION['pwai_url']);
	echo "<script>window.location =\"$ai_url\";</script>";
	exit();
}


$noremAction=array('login');
if(!in_array($_GET['c'],$noremAction)&&$_SESSION['pwai_url']==''){
	$_SESSION['refer_url']=$_SESSION['refer_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$_SESSION['pwrefer_url']=$_SESSION['refer_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

if($_SESSION['aipw_ck_winduser']!=''){
	setcookie('ghL_winduser', $_SESSION['aipw_ck_winduser'],31536000);
	$_COOKIE['ghL_winduser']=$_SESSION['aipw_ck_winduser'];
	unset($_SESSION['aipw_ck_winduser']);
}

define("AIPWURL","http://www.kon_aijianmei.com");
require './src/wekit.php';
Wekit::run('phpwind');
//var_dump($_COOKIE);
//echo $_SESSION['refer_url'];
//var_dump($_SESSION['refer_url']);
