<?php
error_reporting(0);
session_start();
define('SITE_PATH', getcwd());
$_dbConfig=require_once('config.inc.php');
$_actAllowArr=array(
'check_email'=>'email',
'check_Verify'=>'Verify',
'delCategory'=>'aid',
'addVideoCommont'=>'data',
'addDetaiCommont'=>'data',);
if(!empty($_REQUEST['act'])&&!empty($_actAllowArr[$_REQUEST['act']]))
{
    if(function_exists($_REQUEST['act'])){
        $_REQUEST['act']($_REQUEST[$_actAllowArr[$_REQUEST['act']]]);exit;
    }
    exit;
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

function delCategory($id){
    global $_dbConfig;
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    $res = mysql_query('delete from  ai_article_category_group where `aid`="'.$id.'"', $db);
    mysql_close($db);
    if($res) {
        echo 1;
    }else {
        echo 0;
    }
    exit;
}


function addVideoCommont($data=null){
    global $_dbConfig;
    $pid=$_POST['pid']?$_POST['pid']:'';
    $uid=$_POST['uid']?$_POST['uid']:exit();
    $connect=$_POST['connect']?trim($_POST['connect']):exit();
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $sql="INSERT INTO ai_video_comments (uid,connect,pid,create_time) VALUES ('".$uid."','".trim($_POST['connect'])."','".$pid."',".time().")";
    $res = mysql_query($sql, $db);
    $data=null;
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        $data['connect']=$connect;
        $data['create_time']=date("Y-m-d H:i:s",time());
        $imgsql="select profileImageUrl from ai_others where uid='".$uid."'";
        $imgsArr=mysql_query($imgsql, $db);
        $row = mysql_fetch_array($imgsArr);
        $data['img'] =$row['profileImageUrl'];
        if(empty($data['img'])){$data['img']="/data/uploads/avatar/$uid/middle.jpg";}
        //$data['img']="/data/uploads/avatar/$uid/middle.jpg";
        echo json_encode($data);
    }else {
        echo json_encode(0);
    }
    mysql_close($db);
    exit;
}

function addDetaiCommont($data=null){
    global $_dbConfig;
    $pid=$_POST['pid']?$_POST['pid']:'';
    $uid=$_POST['uid']?$_POST['uid']:exit();
    $connect=$_POST['content']?trim($_POST['content']):exit();
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $sql="INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent) VALUES ('".$uid."','".$connect."','".$pid."',1,".time().",'','0')";
    $res = mysql_query($sql, $db);
    $data=null;
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        $data['connect']=$connect;
        $data['create_time']=date("Y-m-d H:i:s",time());
        $imgsql="select profileImageUrl from ai_others where uid='".$uid."'";
        $imgsArr=mysql_query($imgsql, $db);
        $row = mysql_fetch_array($imgsArr);
        $data['img'] =$row['profileImageUrl'];
        if(empty($data['img'])){
            $data['img']="data/uploads/avatar/".$uid."/middle.jpg";
            if(!is_file($data['img']))
            {
                $data['img']="public/themes/newstyle/images/user_pic_middle.gif";
            }
        }
        echo json_encode($data);
    }else {
        echo json_encode(0);
    }
    mysql_close($db);
    exit;
}




?>