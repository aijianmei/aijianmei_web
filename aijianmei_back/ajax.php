<?php
session_start();
define('SITE_PATH', getcwd());
$_dbConfig=require_once('config.inc.php');
/*
switch($_REQUEST['act']) {
    case 'check_email' : check_email($_REQUEST['email']); break;	
}

function check_email($email) {
    $db = mysql_connect('localhost', 'root', 'will123');
    mysql_select_db('aijianmei', $db);
    $res = mysql_query('select uid from ai_user where `email`="'.$email.'"', $db);
    $res = mysql_fetch_row($res);
    if(empty($res)) {
        echo 0;
    }else {
        echo 1;
    }
    mysql_close($db);
}
*/
$_actAllowArr=array('check_email'=>'email','check_Verify'=>'Verify');
if(!empty($_REQUEST['act'])&&!empty($_actAllowArr[$_REQUEST['act']]))
{
    if(function_exists($_REQUEST['act'])){
        $_REQUEST['act']($_REQUEST[$_actAllowArr[$_REQUEST['act']]]);exit;
    }
}

function check_email($email) {
    global $_dbConfig;
    $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    mysql_select_db('aijianmei', $db);
    $res = mysql_query('select uid from ai_user where `email`="'.$email.'"', $db);
    $res = mysql_fetch_row($res);
    mysql_close($db);
    if(empty($res)) {
        echo 0;
    }else {
        echo 1;
    }
    exit;
}


function check_Verify($verify)
{
    if($_SESSION['verify']==md5(strtoupper($verify)))
    {
        echo 1;
    }
    else{
        echo 0;
    }
   exit;
}


?>