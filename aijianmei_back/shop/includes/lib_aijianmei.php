<?php
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
	$_SESSION['mid'] = $mid;
	return true;
}

/**
 * 爱健美主站登录
 */
function aijianmei_login($username, $password)
{
	$sql = "select uid from ai_user where `uname`='".$username."' and `password`='".md5($password)."'";
	$mid = $GLOBALS['db']->getOne($sql);
	$_SESSION['mid'] = $mid;
	return true;
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
?>