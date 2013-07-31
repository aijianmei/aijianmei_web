<?php
session_start();
header("content-type:text/html; charset=utf-8");
error_reporting(0);

define('AIBASEURL',"http://www.kon_aijianmei.com");


 if(!empty($_REQUEST['pwact'])){
     foreach($_REQUEST as $key => $value){
        $_REQUEST[$key]=MooAddslashes($value);
    }
    foreach($_POST as $key => $value){
        $_POST[$key]=MooAddslashes($value);
    }
    foreach($_GET as $key => $value){
        $_GET[$key]=MooAddslashes($value);
    }
}

//addcslashes 
function MooAddslashes($value) {
	return $value = is_array($value) ? array_map('MooAddslashes', $value) : addslashes($value);
}

$action=$_GET['pwact'] ? (string)$_GET['pwact']:null;
if(empty($action)){
	exit();
}
if($action=='register'){
	pwregister();
}elseif($action=='login'){
	pwlogin();	
}elseif($action=='logout'){
	pwlogout();
}elseif($action=='editpassword'){
	pweditpassword();
}
exit;

function pwregister(){
	//print_r($_POST);
	$url = AIBASEURL."/forum/index.php?m=u&c=register&a=dorun&ai_pwreg=1";
	$post_data = array(
  	'username' => $_POST['username'],
		'password'=>$_POST['password'],
		'repassword'=>$_POST['repassword'],
		'email'=>$_POST['email'],
		'csrf_token'=>'1cb4d5adea13ce1fb',
	);
	echo $output=_curlApiPost($url,$post_data);
	exit;
}
function pwlogin(){
	$urlsina=$_POST['is_sinalogin']==1?'&is_sinalogin=1':'';
	$url = AIBASEURL."/forum/index.php?m=u&c=login&a=dologin&ai_pwlogin=1".$urlsina;
	$post_data = array(
  'username' => $_POST['username'],
	'password'=>$_POST['password'],
	'csrf_token'=>'1cb4d5adea13ce1fb',
	'rememberme'=>'31536000',
	);
	$output=_curlApiPost($url,$post_data);
	echo $_SESSION['pwai_url']=$output;
	exit;
}

function pwlogout(){
	//<a href="http://www.kon_aijianmei.com/forum/index.php?m=u&amp;c=login&amp;a=logout" rel="nofollow"><em class="icon_quit"></em>ÍË³ö</a>
	$url=AIBASEURL."/forum/index.php?m=u&c=login&a=logout";
	$output=_curlApiGet($url);
	exit;
}

function pweditpassword(){
	$url = AIBASEURL."/forum/index.php?m=profile&c=password&a=edit&ai_pwlogin=1";
	$post_data = array(
  'oldPwd' => $_POST['oldPwd'],
	'newPwd'=>$_POST['newPwd'],
	'rePwd'=>$_POST['rePwd'],
	);
	echo _curlApiPost($url,$post_data);
	exit;
}



function _curlApiPost($url,$post_data=null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}


function _curlApiGet($url){
	return file_get_contents($url);
}

