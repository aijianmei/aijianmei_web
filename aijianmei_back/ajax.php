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
'recordlike'=>'data',
'ajaxInMore'=>'data',
'ajaxTrainMore'=>'data',
'sedaylike'=>'data',
'checkUserName'=>'data',
'getrecomarticles'=>'page',
'getRecomArticleList'=>'data',
'delDetaiCommont'=>'data',
'senfplike'=>'data');
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
	$value = preg_replace("/<[^><]*script[^><]*>/i",'',$value);
	$value = preg_replace("/<[\/\!]*?[^<>]*?>/si",'',$value); 
	return $value = is_array($value) ? array_map('MooAddslashes', $value) : addslashes($value);
}

if(!empty($_REQUEST['act'])&&!empty($_actAllowArr[$_REQUEST['act']]))
{
    if(function_exists($_REQUEST['act'])){
        $_REQUEST['act']($_REQUEST[$_actAllowArr[$_REQUEST['act']]]);exit;
    }
    exit;
}

function getRecomArticleList($data=null){
	$promoteArticle=C_mysqlQuery("SELECT * FROM ai_article where is_promote=1 ORDER BY RAND() limit 6");
			while($row=mysql_fetch_assoc($promoteArticle)){
				$row['title']=msubstr($row['title'],0,18);
				$resultTmp[]=$row;
			}
	echo json_encode($resultTmp);
	exit;
}
function delDetaiCommont($data=null){
	$delid=$_POST['delid'];
	$uid=$_POST['uid'];
	$mid=$_SESSION['mid'];
	$ptype=$_POST['ptype']?$_POST['ptype']:1;
	if($mid!=$uid) return false;
	if(($delid >0)==false) return false;
	
	$delSql="delete from ai_comments where uid=$mid and parent_type=$ptype and id=$delid";
	C_mysqlQuery($delSql);
	if(mysql_affected_rows()>0){
	echo 1;	
	}else{
	echo 0;
	}
	exit;
}





function checkUserName(){
	$username=$_POST['username'];
	$mid=$_SESSION['mid']?$_SESSION['mid']:0;
	if($mid > 0){$conid=" and uid!=$mid";}
	$sql="select * from ai_user where uname='".$username."'";
	$result=C_mysqlQuery($sql);
		while($row=mysql_fetch_assoc($result)){
			$resultTmp[]=$row;
		}
		if($mid>0){
			if(empty($resultTmp)||$mid==$resultTmp[0]['uid']){
				echo 1;
			}else{
				echo 2;
			}
		}else{
			if(empty($resultTmp)){
				echo 1;	
			}else{
				echo 2;
			}	
		}
	exit;
}

function getrecomarticles(){
	$page=$_POST['page']?$_POST['page']:1;
	$from=$page-1;
	$countSql="select count(*) as num from ai_article where is_promote=1";
	$result=C_mysqlQuery($countSql);
	$num=$result[0]['num'];
	$cpage=ceil($num/6);
	$sql="select id,title,img from ai_article where is_promote=1 limit $from,6";
	$result=C_mysqlQuery($sql);
	while($row=mysql_fetch_assoc($result)){
			$resultTmp[]=$row;
	}
	foreach($resultTmp as $k=>&$value){
	 	 $value['img']="/public/images/article/".$value['img'];
	 	 $value['url']="/index-Index-articleDetail-".$value['id'].".html";
	} 
	echo json_encode($resultTmp);
	exit;
}



function ajaxInMore($data){
	ob_end_clean();
	$nums=15;
	$type=intval($_POST['type']);
	$page=intval($_POST['pg']);
	$mtype=intval($_POST['mtype'])?intval($_POST['mtype']):2;
	$lid=intval($_POST['lid'])?intval($_POST['lid']):0;
	$froms=$page+$page-1;
	if($type==1||$type==2){
		$order=($type==1)?'create_time':'reader_count';
		//$sql = "select a.* from ai_article a group by a.id order by a.".$order." desc limit ".$froms*$nums.",$nums";
		if($lid>0){$cateStr='AND a.category_id in ('.$lid.')';}else{$cateStr='';}
		$orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id $cateStr";
		$sql = "select a.* from ai_article a where id in ($orderTableSql) group by a.id  order by ".$order." desc limit ".(($page-1)*20+5).",$nums";
		$result=null;
		$result=getDataCache(md5($sql));
		
		if(empty($result)){
			$result=C_mysqlQuery($sql);
			while($row=mysql_fetch_assoc($result)){
				$resultTmp[]=$row;
			}
			$result=null;
			$result=$resultTmp;
			foreach ($result as $key => $value) {
				unset($result[$key]['content']);
				unset($result[$key]['wapcontent']);
				$result[$key]['CommNumber']=getCountRecommentsById($value['id'],$type);
			}
			setDataCache(md5($sql),$result);
		}
		foreach($result as $k =>$value){
		$returnHtml.='<div class="cont_module clearfix"><div class="cont_side_1"><a href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank"><img alt="'.$value['title'].'" style="width:215px;height:145px;" src="../public/images/article/'.$value['img'].'"></a>
								<div class="show_share clearfix" style="margin-left:40px;">
									<wb:share-button count="n" type="button" size="big"  appkey="3622140445" url="http://www.aijianmei.com/index-Index-articleDetail-'.$value['id'].'.html" pic="http://www.aijianmei.com/public/images/article/'.( $value['front_cover']? $value['front_cover'] :$value['img']).'" title="'.$value['title'].'" ralateuid="2692984661" width="300" height="30"></wb:share-button>
								</div>
							</div>
							<div class="cont_side_2">
								<h3 class="cont_title"><a href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank">'.$value['title'].'</a></h3>
								<span class="cont_tip">
								<span class="cont_comefrom">爱健美团队</span>发表于
								<span class="cont_pb_time">'.date("Y-m-d",$value['create_time']).'</span></span>
								<p>'.$value['brief'].'</p>
								<a class="cont_read_more" href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank">阅读全文></a>
								<div class="cont_share clearfix">
                                    <span class="cont_rec">评论数:<span>'.$value['CommNumber'].'</span></span>
								</div>
							</div>
						</div>';
		}
		echo $returnHtml;
		exit;
	}
	if($type==3||$type==4){
		$order=($type==1)?'create_time':'reader_count';
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$mtype";
		$sql = "select v.* from ai_video v order by v.click desc limit ".(($page-1)*20+5).",$nums";
		$result=null;
		$result=getDataCache(md5($sql));
		if(empty($result)){
			$result=C_mysqlQuery($sql);
			while($row=mysql_fetch_assoc($result)){
				$resultTmp[]=$row;
			}
			$result=$resultTmp;
			//print_r($result);
			foreach($result as $k=>$v) {
				
				$result[$k] = $v;
				$data = json_decode(getVideoData($v['link']));
				$result[$k]['logo'] = $data->data[0]->logo;
				$result[$k]['recommons']=getVideoCountRecommentsById($v['id']);            
			}
			//print_r($result);
			setDataCache(md5($sql),$result);
		}
		//print_r($result);
		$returnHtml=null;
		foreach($result as $k =>$value){
			$returnHtml.='<div class="cont_module clearfix"><div class="cont_vd_1"><a  class="cont_vd_link"  href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank">
			<img style="width:215px;height:145px;" alt="'.$value['title'].'" src="'.$value['logo'].'"><span class="cont_vd_bg" style="display: none;"></span></a><div class="show_share clearfix" style="margin-left:40px;">
			<wb:share-button count="n" type="button" size="big"  appkey="3622140445" url="'.$value['htmlurl'].'?>" pic="'.$value['logo'].'"  title="'.$value['title'].'" ralateuid="2692984661" width="300" height="30">
			</wb:share-button></div></div><div class="cont_vd_2"><h3 class="cont_vd_title"><a href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank">'.$value['title'].'</a></h3>
								<div class="cont_vd_dt">
									<p>标签:<span>'.$value['keyword'].'</span></p>
									<p>简介:<span>'.msubstr($value['brief'],0,54).'</span></p>
								</div>
								<a class="cont_vd_see" href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank"></a>
								<div class="cont_share clearfix">
                                    <span class="cont_rec">评论数:<span>'.$value['recommons'].'</span></span>
								</div>
							</div>
						</div>';
		}
		echo $returnHtml;
		exit;
	}
	exit;
}

function ajaxTrainMore($data){
	ob_end_clean();
	$nums=15;
	$type=intval($_POST['type']);
	$page=intval($_POST['pg']);
	$mtype=intval($_POST['mtype'])?intval($_POST['mtype']):2;
	$froms=$page+$page-1;
	if($type==1||$type==2){
		$order=($type==1)?'create_time':'reader_count';
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$mtype";
		$sql = "select a.* from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.".$order." desc limit ".(($page-1)*20+5).",$nums";
		$result=null;
		$result=getDataCache(md5($sql));
		if(empty($result)){
			$result=C_mysqlQuery($sql);
			while($row=mysql_fetch_assoc($result)){
				$resultTmp[]=$row;
			}
			$result=null;
			$result=$resultTmp;
			foreach ($result as $key => $value) {
				unset($result[$key]['content']);
				unset($result[$key]['wapcontent']);
				$result[$key]['CommNumber']=getCountRecommentsById($value['id'],$type);
			}
			setDataCache(md5($sql),$result);
		}
		foreach($result as $k =>$value){
		$returnHtml.='<div class="cont_module clearfix"><div class="cont_side_1"><a href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank"><img alt="'.$value['title'].'" style="width:215px;height:145px;" src="../public/images/article/'.$value['img'].'"></a>
								<div class="show_share clearfix" style="margin-left:40px;">
									<wb:share-button count="n" type="button" size="big"  appkey="3622140445" url="http://www.aijianmei.com/index-Index-articleDetail-'.$value['id'].'.html" pic="http://www.aijianmei.com/public/images/article/'.( $value['front_cover']? $value['front_cover'] :$value['img']).'" title="'.$value['title'].'" ralateuid="2692984661" width="300" height="30"></wb:share-button>
								</div>
							</div>
							<div class="cont_side_2">
								<h3 class="cont_title"><a href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank">'.$value['title'].'</a></h3>
								<span class="cont_tip">
								<span class="cont_comefrom">爱健美团队</span>发表于
								<span class="cont_pb_time">'.date("Y-m-d",$value['create_time']).'</span></span>
								<p>'.$value['brief'].'</p>
								<a class="cont_read_more" href="index-Index-articleDetail-'.$value['id'].'.html" target="_blank">阅读全文></a>
								<div class="cont_share clearfix">
                                    <span class="cont_rec">评论数:<span>'.$value['CommNumber'].'</span></span>
								</div>
							</div>
						</div>';
		}
		echo $returnHtml;
		exit;
	}
	if($type==3||$type==4){
		$order=($type==1)?'create_time':'click';
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$mtype";
		$sql = "select * from ai_video  order by $order desc limit ".(($page-1)*20+5).",$nums";
		$result=null;
		$result=getDataCache(md5($sql));
		if(empty($result)){
			$result=C_mysqlQuery($sql);
			while($row=mysql_fetch_assoc($result)){
				$resultTmp[]=$row;
			}
			$result=$resultTmp;
			//print_r($result);
			foreach($result as $k=>$v) {
				
				$result[$k] = $v;
				$data = json_decode(getVideoData($v['link']));
				$result[$k]['logo'] = $data->data[0]->logo;
				$result[$k]['recommons']=getVideoCountRecommentsById($v['id']);            
			}
			//print_r($result);
			setDataCache(md5($sql),$result);
		}
		//print_r($result);
		$returnHtml=null;
		foreach($result as $k =>$value){
			$returnHtml.='<div class="cont_module clearfix"><div class="cont_vd_1"><a class="cont_vd_link"  href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank">
			<img style="width:215px;height:145px;" alt="'.$value['title'].'" src="'.$value['logo'].'"><span class="cont_vd_bg" style="display: none;"></span></a><div class="show_share clearfix" style="margin-left:40px;">
			<wb:share-button count="n" type="button" size="big"  appkey="3622140445" url="'.$value['htmlurl'].'?>" pic="'.$value['logo'].'"  title="'.$value['title'].'" ralateuid="2692984661" width="300" height="30">
			</wb:share-button></div></div><div class="cont_vd_2"><h3 class="cont_vd_title"><a href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank">'.$value['title'].'</a></h3>
								<div class="cont_vd_dt">
									<p>标签:<span>'.$value['keyword'].'</span></p>
									<p>简介:<span>'.msubstr($value['brief'],0,54).'</span></p>
								</div>
								<a class="cont_vd_see" href="/index-Train-videoDetail-'.$value['id'].'.html" target="_blank"></a>
								<div class="cont_share clearfix">
                                    <span class="cont_rec">评论数:<span>'.$value['recommons'].'</span></span>
								</div>
							</div>
						</div>';
		}
		echo $returnHtml;
		exit;
	}
	exit;
}





function getCountRecommentsById($id,$type)
{
	$sql=null;$numsArr=null;
	$sql="select count(*) as nums from ai_comments where parent_id=".$id." and parent_type=".$type."";
	//$numsArr= M('')->query($sql);
	$numsArr=C_mysqlQuery($sql);
	$numsArr=mysql_fetch_assoc($numsArr);
	return !empty($numsArr['nums'])?$numsArr['nums']:0;
}
function getVideoCountRecommentsById($id)
{
	$sql=null;$numsArr=null;
	$sql="select count(*) as nums from ai_video_comments where pid=".$id;
	$numsArr=C_mysqlQuery($sql);
	$numsArr=mysql_fetch_assoc($numsArr);
	return !empty($numsArr['nums'])?$numsArr['nums']:0;
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
	if($checkLikeInfo['uid']>0){
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

function senfplike($data){
	$vid=intval($_POST['vid']);
	$mid=$_SESSION['mid'];
	if(!($mid>0)||empty($vid)){
		echo json_encode(3);
		exit;	
	}
	$checksql="select * from ai_fitness_program_vote where uid=$mid and fid=$vid";
	$checksinfo=C_mysqlQuery($checksql);
	$checksinfo=mysql_fetch_assoc($checksinfo);
	if(empty($checksinfo)){
		$usql="update ai_fitness_program set `like`=`like`+1 where id=$articleid";
		C_mysqlQuery($usql);
		$insql='insert into ai_fitness_program_vote (`uid`,`fid`) values ("'.$mid.'","'.$vid.'")';
		C_mysqlQuery($insql);
		echo json_encode(1);exit();	
	}else{
		echo json_encode(2);exit();
	}
}



function sedaylike($data){
	if($_SESSION['mid']>0){
			$mid=$_SESSION['mid'];
			$articleid=addslashes($_POST['did']);
			$checksql="select * from ai_daily_vote where uid=$mid and article_id=$articleid";
			$checksinfo=C_mysqlQuery($checksql);
			$checksinfo=mysql_fetch_assoc($checksinfo);
			if(!$checksinfo){
				$usql="update ai_daily set `like`=`like`+1 where id=$articleid";
				C_mysqlQuery($usql);
				$insql='insert into ai_daily_vote (`uid`,`article_id`) values ("'.$mid.'","'.$articleid.'")';
				C_mysqlQuery($insql);
				echo json_encode(array('result'=>1,'sql'=>$insql));
			}else
			{
				echo json_encode(array('result'=>3));
			}
	}else{
		echo json_encode(array('result'=>2));
	}
	exit;
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
    $ptype=$_POST['ptype'];
		if(!($uid>0)){die();}
    $content=$_POST['content']?trim($_POST['content']):exit();
    $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    //$sql="INSERT INTO ai_video_comments (uid,connect,pid,create_time) VALUES ('".$uid."','".trim($connect)."','".$pid."',".time().")";
    //$sql="INSERT INTO ai_video_comments (uid,content,pid,create_time) VALUES ('".$uid."','".$content."','".$pid."',".time().")";
		$sql="INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent) VALUES ('".$uid."','".$content."','".$pid."',".$ptype.",".time().",'','0')";
    $res = mysql_query($sql, $db);
    $data=null;
    $data['id']=mysql_insert_id();
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        $data['content']=$content;
        $data['create_time']=date("Y-m-d H:i:s",time());
        /*$imgsql="select profileImageUrl from ai_others where uid='".$uid."'";
        $imgsArr=mysql_query($imgsql, $db);
        $row = mysql_fetch_array($imgsArr);
        $data['img'] =$row['profileImageUrl'];
        if(empty($data['img'])){
            $data['img']="data/uploads/avatar/".$uid."/middle.jpg";
            if(!is_file($data['img']))
            {
                $data['img']="public/themes/newstyle/images/user_pic_middle.gif";
            }
        }*/
         $data['img']=getUserFace($uid,'m');
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
    $ptype=$_POST['ptype']?$_POST['ptype']:1;
    $content=$_POST['content']?trim($_POST['content']):exit();
    @$db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    @mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $sql="INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent) VALUES ('".$uid."','".$content."','".$pid."','".$ptype."',".time().",'','0')";
    $res = mysql_query($sql, $db);
    $data=null;
    $data['id']=mysql_insert_id();
    if($res) {
        $data['username']=$_SESSION['userInfo']['uname'];
        
      preg_match_all("/^\#[0-9]{1,}楼\s/",$content,$matches,PREG_SET_ORDER);
      $replyidString=$matches[0][0];
      preg_match_all("/\d{1,}/",$replyidString,$floornums,PREG_SET_ORDER);
      $floornums=$floornums[0][0];
      if($floornums>0){
       $content=preg_replace('/^\#\d楼\s/','<a href="#replay'.$floornums.'">#'.$floornums.'楼 </a>',$content);
    	}
        
        
        $data['connect']=$content;
        $data['create_time']=date("Y-m-d H:i:s",time());
		
		/*$check_type="select upic_type from ai_user where uid=$uid";
		$checkres=mysql_query($imgsql, $check_type);
        $check_typeinfo = mysql_fetch_array($checkres);
		
        $imgsql="select profileImageUrl from ai_others where uid='".$uid."'";
        $imgsArr=mysql_query($imgsql, $db);
        $row = mysql_fetch_array($imgsArr);
        $data['img'] =$row['profileImageUrl'];
        if(empty($data['img'])&&$check_typeinfo['upic_type']==1){
            $data['img']="data/uploads/avatar/".$uid."/middle.jpg";
            if(!is_file($data['img']))
            {
                $data['img']="public/themes/newstyle/images/user_pic_middle.gif";
            }
        }*/
        $countinfo=C_mysqlQuery("select count(*) as num from ai_comments where parent_id=$pid and parent_type=$ptype");
        $countinfo=mysql_fetch_assoc($countinfo);
        $data['floorVal']=$countinfo['num'];
        $data['img']=getUserFace($uid,'m');
        echo json_encode($data);
    }else {
        echo json_encode(0);
    }
    mysql_close($db);
    exit();
}

function senLike($data){

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
function getDataCache($key)
	{
		$cachefile="DBCache/$key.php";
		if(is_file($cachefile))
		{
			$data=null;
			$data=mb_unserialize(include($cachefile));
			return $data;
		}
		return '';
	}
function setDataCache($key,$data)
	{
		file_put_contents("DBCache/$key.php","<?php\n\r return '".serialize($data)."';");
	}
	
function mb_unserialize($serial_str) {
    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    $serial_str= str_replace("\r", "", $serial_str);      
    return unserialize($serial_str);
}	
	
	
	
function getArticlesListType($order,$id=null,$limit,$nums,$type=null)
    {
        if($id) {
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
            $sql = "select a.* from ai_article a where id in ($orderTableSql) or category_id=$id group by a.id  order by ".$order." desc limit ".$limit.",".$nums."";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$type";
            $sql = "select a.* from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.".$order." desc limit ".$limit.",".$nums."";
        }
        $cacheid=md5($sql);
		$result=null;
		$result=getDataCache($cacheid);
		if(!$result){
			$result=C_mysqlQuery($sql);
			while($row=mysql_fetch_assoc($result)){
				$result_tmp[]=$row;
			}
			$result=$result_tmp;
			//$result = M('')->query($sql);
			foreach ($result as $key => $value) {
				$result[$key]['CommNumber']=getCountRecommentsById($value['id']);
			}
			setDataCache($cacheid,$result);
		}
        return $result;
    }	
	
function getUserFace($uid,$size=null){
	$size = ($size)?$size:'m';
	if($size=='m'){
		$type = 'middle';
	}elseif ($size=='s'){
		$type = 'small';
	}else{
		$type = 'big';
	}
	$imgtpyesql= C_mysqlQuery("select upic_type from ai_user where uid='".$uid."'");
	$imgtpye=mysql_fetch_assoc($imgtpyesql);
        
	$uid_to_path = '/'.$uid;
	$userface = 'data/uploads/avatar' . $uid_to_path . '/' . $type. '.jpg';
	if($imgtpye['upic_type']==1){
		if(is_file($userface)){
			return 'data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		}
		else{
			return "Templates/images/login_pic.jpg";
		}
	}else{
		$apiImg= C_mysqlQuery("select profileImageUrl from ai_others where uid='".$uid."' and profileImageUrl!=''");
		$apiImg=mysql_fetch_assoc($apiImg);	
		if(!empty($apiImg)){
            $userface=$apiImg['profileImageUrl'];
            return $userface;
		}
		return "/images/user_pic_{$type}.gif";
	}
}