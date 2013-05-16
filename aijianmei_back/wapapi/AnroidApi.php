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

$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
$sql = "select a.id as article_id,a.title as article_title,a.like as article_good,a.unlike as article_bad,a.author as article_author  from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.create_time desc limit 0,8";
$lastArticles=C_mysqlQuery($sql);
while($row = mysql_fetch_assoc($lastArticles)){
    $lastArticlesTmp[]=$row;
}
$lastArticles=null;
$lastArticles=$lastArticlesTmp;
foreach ($lastArticles as $key => $value) {
		//print_r($value);exit;
		$sql=null;$numsArr=null;
        $sql="select count(*) as nums from ai_comments where parent_id=".$value['article_id'];
        $numsArr=C_mysqlQuery($sql);
		$row=null;
		$row=mysql_fetch_assoc($numsArr);
        $nums=!empty($row['nums'])?$row['nums']:0;
		$lastArticles[$key]['article_comments']=$nums;
}
echo json_encode((object)array('article'=>$lastArticles));
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