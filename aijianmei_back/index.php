<?php
session_start();
error_reporting(0); //调试、找错时请弃用这一行配置，注释下一行配置
//error_reporting(E_ERROR | E_PARSE | E_STRICT);

//print_r($_COOKIE);
//网站根路径设置
define('SITE_PATH', getcwd());
define('RUNTIME_ALLINONE', false);	// 是否开启AllInOne模式 (开启时, NO_CACHE_RUNTIME 和 APP_DEBUG将失效)
define('NO_CACHE_RUNTIME', true);	// 是否关闭核心文件的编译缓存 (开启AllInOne模式时设置无效, 将自动置为false)
define("AIBASEURL",'http://' . $_SERVER['HTTP_HOST']);
$allowregAct=array('newShowImg1','doregister','ShowImg','newShowImg','newupload','upload','setchannelinfo','fishuserinfo','saveuserinfo','uploadImageFile');
if(@$_SESSION['deslogin']==1&&!in_array($_GET['act'],$allowregAct)){$_SESSION=null;}
if(@$_SESSION['needSetcookie']!=''){
	setcookie("LOGGED_AIUSER",$_SESSION['needSetcookie']['LOGGED_AIUSER'], time()+3600*24*30,"/");
	setcookie('LOGGED_AICOD',$_SESSION['needSetcookie']['LOGGED_AICOD'], time()+3600*24*30,"/");
	setcookie("ECS[user_id]",$_SESSION['needSetcookie']['ECS[user_id]'],time()+3600*24*30,"/");  //set cookie         
	setcookie("ECS[password]",$_SESSION['needSetcookie']['ECS[password]'],time()+3600*24*30,"/");
	unset($_SESSION['needSetcookie']);
}
//载入核心文件
require(SITE_PATH.'/core/sociax.php');

//实例化一个网站应用实例
$App = new App();
$App->run();
//print_r($_SESSION);

