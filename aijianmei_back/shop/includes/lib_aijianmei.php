<?php
session_start();
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * 爱健美主站用户注册
 */
function aijianmei_register($username, $email, $password, $other=array())
{
	$sql = "insert into `ai_user` (`uname`,`email`,`password`) values ('".$username."', '".$email."', '".md5($password)."')";	
	
	$mid = $GLOBALS['db']->query($sql);
	aijianmei_login($username, $password);
	return true;
}

/**
 * 爱健美主站登录
 */
function aijianmei_login($username, $password)
{
	$sql = "select uid from ai_user where `uname`='".$username."'";
	$mid = $GLOBALS['db']->getOne($sql);
	$_SESSION['mid'] = $mid;
	return true;
}

/**
 * 退出爱健美主站
 */
function aijianmei_logout()
{
	$_SESSION['mid'] = '';
	unset($_SESSION['mid']);	
}


/**
 * 判断爱健美主站用户名是否存在
 * @param string $username 用户名
 * @return boolean
 */
function aijianmei_registered($username)
{
	$res = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ai_user WHERE uname = '".$username."'");
    return $res;
}

/**
 * 判断爱健美主站邮箱是否存在
 * @param string $email 邮箱
 * @return boolean
 */
function aijianmei_email($email)
{
	$res = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ai_user WHERE email = '".$email."'");
    return $res;
}

/**
 * 判断爱健美主站是否存在该用户
 */
function can_login_aijianmei($username, $password)
{
	$res = $GLOBALS['db']->getOne('SELECT count(*) FROM ai_user WHERE `uname`="'.$username.'" and `password`="'.md5($password).'"');
	return $res;
}

/**
 * 根据用户名获取用户邮箱
 */
function get_aijianmei_email($username)
{
	$res = $GLOBALS['db']->getOne('SELECT email FROM ai_user WHERE `uname`="'.$username.'"');
	return $res;	
}
?>