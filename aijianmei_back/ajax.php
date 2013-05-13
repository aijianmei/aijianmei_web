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
'addDetaiCommont'=>'data',
'senLike'=>'data',
'indexmore'=>'pagenum',
'backEditVideoUrl'=>'data',
'recordlike'=>'data',);
/*ajax */
 if(!empty($_REQUEST['act'])){
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


if(!empty($_REQUEST['act'])&&!empty($_actAllowArr[$_REQUEST['act']]))
{
    if(function_exists($_REQUEST['act'])){
        $_REQUEST['act']($_REQUEST[$_actAllowArr[$_REQUEST['act']]]);exit;
    }
    exit;
}

/*
 *function name recordlike()
 *author kontem
 *date 20130503
 *return json data
 *record user like log
 */
function recordlike($data){
	
	$mid=null;
	$mid=$_SESSION['mid'];
	if(!$mid){echo json_encode(2);exit();}
	$videoid=null;
	$videoid=intval($_POST['vid']);
	$checkLikeSql=null;
	$checkLikeSql="select * from  ai_video_vote where uid=$mid and vid=$videoid";
	$checkLikeInfo=array();
    $checkLikeInfo=C_mysqlQuery($checkLikeSql);
    $checkLikeInfo = mysql_fetch_assoc($checkLikeInfo);
	if($checkLikeInfo){
		echo json_encode(2);
		exit();
	}
	else{
		$usql="update ai_video set `like`=`like`+1 where id=$videoid";
		C_mysqlQuery($usql);
		$insql='insert into ai_video_vote (`uid`,`vid`) values ("'.$mid.'","'.$videoid.'")';
		C_mysqlQuery($insql);
		echo json_encode(1);
		exit();
	}
}



function backEditVideoUrl($data){
	$vid=$_POST['vid']?$_POST['vid']:exit();
    $url=$_POST['url']?$_POST['url']:'';
    $urltype=$_POST['urltype']?$_POST['urltype']:'';
	$sql="UPDATE ai_daily_video SET ".$urltype." = '".$url."' WHERE `id` =$vid";
	$res=C_mysqlQuery($sql);
	//$re['sql']=$sql;
	$re['return']=($res>0)?true:false;
	echo json_encode($re);exit;
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

function indexmore($pagenum){
    global $_dbConfig;
	$page=intval($pagenum);
	if($page<2||$page>5){exit;}
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
	$limits=($page-1)*4;
	$limitnums=4;
	$data=null;
	$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
	$sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by create_time desc limit ".$limits.",".$limitnums;
	//$hot_video = M('')->query($sql);
	$hot_videoRes = mysql_query($sql, $db);
	$hot_video=null;
	$info['isql']=$sql;
	while ($row = mysql_fetch_assoc($hot_videoRes)) {
		$hot_video[]=$row;
	}
	foreach($hot_video as $k=>$v) {
            $hotvideos[$k] = $v;
            $data = json_decode(getVideoData($v['link']));
            $hotvideos[$k]['logo'] = $data->data[0]->logo;
			$sql=null;$numsArr=null;
			$sql="select count(*) as nums from ai_video_comments where pid=".$v['id'];
			$numsArr= mysql_query($sql,$db);
			$nums=mysql_fetch_assoc($numsArr);
			$hotvideos[$k]['recommons']=(!empty($nums['nums']))?$nums['nums']:0;
			$hotvideos[$k]['brief']=msubstr($hotvideos[$k]['brief'],0,78);	
        }
		$info['hotvideos']=$hotvideos;

        $sql = "select a.* from ai_article a group by a.id order by a.create_time desc limit ".$limits.",".$limitnums;
		$hotArticlesArr = mysql_query($sql, $db);
		$hotArticles=null;
		while ($row = mysql_fetch_assoc($hotArticlesArr)) {
			$hotArticles[]=$row;
		}
        foreach ($hotArticles as $key => $value) {
			$sql=null;$numsArr=null;
			$sql="select count(*) as nums from ai_comments where parent_id=".$value['id'];
			$numsArr= mysql_query($sql,$db);
			$nums=mysql_fetch_assoc($numsArr);
            $hotArticles[$key]['CommNumber']=(!empty($nums['nums']))?$nums['nums']:0;;
			unset($hotArticles[$key]['content']);
			$hotArticles[$key]['brief']=msubstr($hotArticles[$key]['brief'],0,78);	
        }
		$info['hotArticles']=$hotArticles;
		echo json_encode($info);
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
    ob_end_clean();
    
    global $_dbConfig;
    $pid=$_POST['pid']?$_POST['pid']:'';
    $uid=$_SESSION['mid'];
	if(!($uid>0)){die();}
    $content=$_POST['content']?trim($_POST['content']):exit();
    $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    //$sql="INSERT INTO ai_video_comments (uid,connect,pid,create_time) VALUES ('".$uid."','".trim($connect)."','".$pid."',".time().")";
    $sql="INSERT INTO ai_video_comments (uid,content,pid,create_time) VALUES ('".$uid."','".$content."','".$pid."',".time().")";
    $res = mysql_query($sql, $db);
    $data=null;
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        $data['content']=$content;
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

function addDetaiCommont($data=null){
    ob_end_clean();
    global $_dbConfig;
    $pid=$_POST['pid']?$_POST['pid']:'';
    $uid=$_POST['uid']?$_POST['uid']:exit();
    $content=$_POST['content']?trim($_POST['content']):exit();
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $sql="INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent) VALUES ('".$uid."','".$content."','".$pid."',1,".time().",'','0')";
    $res = mysql_query($sql, $db);
    $data=null;
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        $data['connect']=$content;
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
    exit();
}

function senLike($data){
    //$mid=$_GET['mid'];
    //$articleid=$_GET['articleid'];
    //$mid=$_POST['mid'];
    $mid=$_SESSION['mid'];
    $articleid=$_POST['articleid'];
    $ptype=$_POST['ptype'];
    $tname=$_POST['tname'];
    $checkLikeSql= $tname=='v'?"select * from ai_article_vote where uid=$mid and article_id=$articleid":"select * from ai_daily_vote where uid=$mid and article_id=$articleid";
    $checkLikeInfo=C_mysqlQuery($checkLikeSql);
    $checkLikeInfo = mysql_fetch_array($checkLikeInfo);
    $a=null;
    if($checkLikeInfo){
        $a="2";
    }else{
        if($_POST['ptype']=='like'&&$tname=='v'){
            $usql="update ai_article set `like`=`like`+1 where id=$articleid";
            C_mysqlQuery($usql);
            $insql='insert into ai_article_vote (`uid`,`article_id`) values ("'.$mid.'","'.$articleid.'")';
            C_mysqlQuery($insql);
        }
        elseif($_POST['ptype']=='unlike'&&$tname=='v'){
            $usql="update ai_article set `unlike`=`unlike`+1 where id=$articleid";
            C_mysqlQuery($usql);
            $insql='insert into ai_article_vote (`uid`,`article_id`) values ("'.$mid.'","'.$articleid.'")';
            C_mysqlQuery($insql); 
        }
        elseif($_POST['ptype']=='like'&&$tname=='d'){
            $usql="update ai_daily set `like`=`like`+1 where id=$articleid";
            C_mysqlQuery($usql);
            $insql='insert into ai_daily_vote (`uid`,`article_id`) values ("'.$mid.'","'.$articleid.'")';
            C_mysqlQuery($insql); 
        }elseif($_POST['ptype']=='unlike'&&$tname=='d'){
            $usql="update ai_daily set `unlike`=`unlike`+1 where id=$articleid";
            C_mysqlQuery($usql);
            $insql='insert into ai_daily_vote (`uid`,`article_id`) values ("'.$mid.'","'.$articleid.'")';
            C_mysqlQuery($insql);
        }
       $a="1";
    }
    echo json_encode($a);
    exit();
}
function C_mysqlQuery($sql){
    global $_dbConfig;
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $res = mysql_query($sql, $db);
    return $res;
}


function getVideoData($link)
{
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
        return $json;
}

function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
		if(function_exists("mb_substr"))
			return mb_substr($str, $start, $length, $charset);
		elseif(function_exists('iconv_substr')) {
			return iconv_substr($str,$start,$length,$charset);
		}
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']	  = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']	  = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
		if($suffix) return $slice."...";
		return $slice;
}

?>