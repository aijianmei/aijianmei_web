<?php
header("Content-Type:text/html;charset=utf-8");
$_dbConfig=require_once('config.inc.php');
function C_mysqlQuery($sql){
    global $_dbConfig;
    $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $res = mysql_query($sql, $db);
    return $res;
}

//$sql = "select * from ai_daily_video";// 结构ai_video
$sql = "select * from ai_video";
$videos=C_mysqlQuery($sql);
while($row = mysql_fetch_assoc($videos)){
    $videostmp[]=$row;
}
$videosList=null;
$videosList=$videostmp;
foreach ($videosList as $key => $value) {
		if(!empty($value['link'])){
		$scode=null;
		$scode=substr($value['link'],0,strrpos($value['link'],'/'));
		$scode=substr($scode,strrpos($scode,'/')+1);
		if(!empty($scode)){
			//$wapurl="http://player.youku.com/embed/".$scode;
			$htmlurl="http://v.youku.com/v_show/id_".$scode.".html";
			$sql="UPDATE `aijianmei`.`ai_video` SET `htmlurl` = '".$htmlurl."' WHERE `ai_video`.`id` ='".$value['id']."'";
			C_mysqlQuery($sql);
		}
		}
		//$lastArticles[$key]['article_comments']=$nums;
}
exit;
//echo json_encode((object)array('article'=>$lastArticles));
//print_r($a);
//$a=Ckon_mysqli::_Query("UPDATE `aijianmeitmp`.`ai_daily_vote` SET `uid` = '45' WHERE `ai_daily_vote`.`article_id` =83 LIMIT 1");
//print_r($a);exit;
//$updata=array('like'=>'100','unlike'=>'2233',);
//$Condition=array('id'=>'33');
//$insertdata=array('0'=>array('uid'=>'55555'),'1'=>array('uid'=>'44444'),'2'=>array('uid'=>'66677'),);
//echo $insertId=Ckon_mysqli::InsertFrom_T_AI_COMMENTS('uid','xxstring');
//echo $affected_rows=Ckon_mysqli::InsertFrom_T_AI_COMMENTS('uid',$insertdata);
//$a=Ckon_mysqli::UpdateFrom_ai_article($updata,$Condition);
//$SqlAction='DeleteFrom_'._T_AI_COMMENTS;
//$a=Ckon_mysqli::DeleteFrom_T_AI_COMMENTS($Condition);
//print_r($a);