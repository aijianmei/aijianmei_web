<?php
error_reporting ( 0 );
header ( "Content-Type:application/json;charset=utf-8" );
require_once ('reimg.php');
$_dbConfig = require_once ('config.inc.php');
function C_mysqlQuery($sql) {
	global $_dbConfig;
	/*
	 * $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']); mysql_select_db('aijianmei', $db); mysql_query("set names 'utf8'"); $res = mysql_query($sql, $db);
	 */
	
	$con = mysql_connect ( $_dbConfig ['DB_HOST'], $_dbConfig ['DB_USER'], $_dbConfig ['DB_PWD'] );
	if (! $con) {
		die ( 'Could not connect: ' . mysql_error () );
	}
	$db_selected = mysql_select_db ( "aijianmei", $con );
	mysql_query ( "set names 'utf8'" );
	$result = mysql_query ( $sql, $con );
	return $result;
}
function C_mysqlAll($sql) {
	$resultTmp = array ();
	$row = $res = null;
	$res = C_mysqlQuery ( $sql );
	while ( $row = mysql_fetch_assoc ( $res ) ) {
		$resultTmp [] = ( array ) $row;
	}
	foreach ( $resultTmp as $ke => $ve ) {
		foreach ( $ve as $kx => $vx ) {
			$resultTmp [$ke] [$kx] = ( string ) $vx;
		}
	}
	return $resultTmp;
}
function C_mysqlOne($sql) {
	$resultTmp = array ();
	$res = C_mysqlQuery ( $sql );
	@$row = mysql_fetch_assoc ( $res );
	if (is_array ( $row )) {
		foreach ( $row as $ke => $ve ) {
			$resultTmp [0] [$ke] = ( string ) $ve;
		}
	}
	return $resultTmp;
}

// 全输入简易过滤
if (! empty ( $_REQUEST ['auact'] )) {
	foreach ( $_REQUEST as $key => $value ) {
		$_REQUEST [$key] = MooAddslashes ( $value );
	}
	foreach ( $_POST as $key => $value ) {
		$_POST [$key] = MooAddslashes ( $value );
	}
	foreach ( $_GET as $key => $value ) {
		$_GET [$key] = MooAddslashes ( $value );
	}
}

// addcslashes
function MooAddslashes($value) {
	return $value = is_array ( $value ) ? array_map ( 'MooAddslashes', $value ) : addslashes ( $value );
}
// http://host:port/wapapi/ios.php?aucode=aijianmei&auact=au_login
class IosApi {
	protected $vaucode = 'aijianmei';
	protected $baseUrl = 'http://www.aijianmei.com';
	public $categoryArray = array (
			'train',
			'nutri',
			'append' ,
			'lifestyle'
	);
	public $categoryValues = array (
			'train' => 2,
			'nutri' => 3,
			'append' => 4,
			'lifestyle' => 5 
	);
	public $categoryidValues = array (
			'train' => array (
					"1" => "51",
					"2" => "38",
					"3" => "47",
					"4" => "53" 
			),
			'nutri' => array (
					"1" => '29',
					"2" => "28",
					"3" => "31" 
			),
			'append' => array (
					'1' => '48',
					'2' => '39',
					"3" => "50" 
			),
			'lifestyle' => array () 
	);
	public $errormsg = array (
			'status' => '',
			'error' => '' 
	);
	public $allowAction = array (
			'au_login' => array (
					'email' => 1,
					'userpassword' => 1,
					'usertype' => 0 
			),
			
			'au_register' => array (
					'username' => 0,
					'userpassword' => 0,
					'email' => 0,
					'usertype' => 0,
					'snsid' => 0,
					'profileImageUrl' => 0,
					'sex' => 0,
					'age' => 0,
					'body_weight' => 0,
					'height' => 0,
					'keyword' => 0,
					'province' => 0,
					'city' => 0 
			),
			
			'au_getinformationlist' => array (
					'listtype' => 0,
					'category' => 0,
					'id' => 0,
					'type' => 0,
					'page' => 0,
					'pnums' => 0,
					'uid' => 0,
					'start' => 0,
					'offset' => 0 
			),
			
			'au_getinformationdetail' => array (
					'id' => 1,
					'channel' => 1,
					'uid' => 0 
			),
			
			'au_sendcomment' => array (
			'id' => 0,
			'channel' => 0,
			'channeltype' => 0,
			'uid' => 0,
			'commentcontent' => 0 
			),
			
			'au_delcomment' => array (
					'id' => 1,
					'channel' => 0,
					'channeltype' => 0,
					'uid' => 1 
			),
			
			'au_sendlike' => array (
					'id' => 1,
					'channel' => 0,
					'channeltype' => 0,
					'uid' => 1 
			),
			
			'au_getfplist' => array (
					'type' => 0,
					'page' => 0,
					'pnums' => 0,
					'uid' => 0,
					'start' => 0,
					'offset' => 0 
			),
			'au_getversion' => array (
					'type' => 0 
			),
			'au_sendsuggestion' => array (
					'uid' => 1,
					'content' => 1 
			),
			'au_updateUserInfo' => array (
					'uid' => 1,
					'username' => 0,
					'userface' => 0,
					'userbgimg' => 0,
					'keyword' => 0,
					'description' => 0,
					'sex' => 0,
					'age' => 0,
					'weight' => 0,
					'height' => 0,
					'province' => 0,
					'city' => 0 
			),
			'au_getuserinfobysnsid' => array (
					'snsid' => 1,
					'usertype' => 1 
			),
			'au_updatepassword' => array (
					'uid' => 1,
					'oldpassword' => 1,
					'newpassword' => 1 
			),
			'au_getuserinfobyuid' => array (
					'uid' => 1 
			),
			'au_getuidbysnsid' => array (
					'snsid' => 1 
			),
			'au_uploadimg' => array (
					'uid' => 0,
					'imagetype' => 0 
			),
			'articlestatus' => array (
					'uid' => 0,
					'aid' => 0,
					'vid' => 0 
			),
			'getcommentbyid' => array (
					'id' => 1,
					'channeltype' => 0 
			),
			'getCircleList' => array (
					'id' => 0,
					'uid' => 0,
					'group' => 0,
					'start' => 0,
					'offset' => 0 
			),
			'postCircleList' => array (
					'uid' => 0, 
			),
			'postCircleComment' =>array(
				'uid'=>1,
				'id'=>1,
				'content'=>1,
			),
			'postCircleLike' =>array(
				'uid'=>0,
				'statusId'=>0,
			),
		'getWeightInfo' =>array(
			'uid'=>0,
			),
		'postWeightInfo'=>array(
			'uid'=>0,
			),
		'postFitnessInfo'=>array(
			'uid'=>0,
			),
		'getCourseInfo'=>array(
			'uid'=>0,
			),
		'getAllAtionList'=>array(
			'uid'=>0,
			),
		);
public function __construct() {
	ob_start();
	var_dump($_GET);
	var_dump($_POST);
	var_dump($_FILES);
	$info=ob_get_contents();
	ob_end_clean();
	file_put_contents("tmp.txt",$info);
	$allowArr = $this->allowAction;
	if (! empty ( $_REQUEST ['auact'] ) && isset ( $allowArr [$_REQUEST ['auact']] ) && $_REQUEST ['aucode'] == $this->vaucode) {
		if ($this->checkargs ( $_REQUEST ['auact'] )) {
		} else {
			return $this->errormsg ();
		}
	} else {
		return $this->errormsg ();
	}
}
public function postFitnessInfo(){
	if(empty($_POST[$uid])){
		$data[0]['uid']="0";
		$data[0]['errorCode']="10001";
		echo json_encode($data);
		exit;
	}
	//$aid 		= $_POST['aid']?$_POST['aid']:$_POST['aid'];
	$actionName = $_POST['actionName']?$_POST['actionName']:'';
	$groupId	= $_POST['groupId']?$_POST['groupId']:'';
	
}
public function getAllAtionList(){
	$jsonCache='../Templates/tool/json/jsonCache.json';
	if(!is_file($jsonCache)){
		$targetFile='../Templates/tool/json/CourseAction.json';
		$json = (array)json_decode(file_get_contents($targetFile));
		foreach ($json as $key => $value) {
			$json[$key]=(array)$value;
		}
		$tmp=$json;
		foreach ($tmp as $key => $value) {
			$data[$key]['part']=$value['part'];
			foreach ($value['lists'] as $k => $v) { 

				$data[$key]['lists'][$k]['id']=$this->getActionIdByName($v);
				$data[$key]['lists'][$k]['name']=$v;
			}
		}
		file_put_contents($jsonCache,json_encode($data));
	}else{
		$data= (array)json_decode(file_get_contents($jsonCache));
	}
	echo json_encode($data);
	exit;
}
public function getCourseInfo(){
	$uid=$_REQUEST['uid']?$_REQUEST['uid']:0;
	if(!$uid > 0){
		$data[0]['uid']="0";
		$data[0]['errorCode']="10001";
		echo json_encode($data);
		exit;
	}
	$date 		=$_REQUEST['date']?$_REQUEST['date']:date('Ymd',time());
	$actionName =$_REQUEST['actionName'] ?$_REQUEST['actionName'] :'';
	$aid  		=!empty($actionName)?$this->getActionIdByName($actionName):'';
	$defaultActionList=$this->getDefaultActionList($uid);

	$faid 		=intval($defaultActionList[0]['id']);
	$aid 		=empty($aid)?$faid:$aid;
	$sql  		="select loginfo from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`=$date order by `group` asc";
	$coureInfoTmp      =C_mysqlAll( $sql );

	foreach ($coureInfoTmp as $key => $value) {
		$tmp=null;
		$tmp=unserialize($value['loginfo']);
		$tmp['calories']=0;
		$coureInfo[]=$tmp;
	}
	$data[0]['uid']=0;
	$data[0]['errorCode']=0;
	$data[0]['actionList']=$defaultActionList;
	$data[0]['coureList']=$coureInfo;
	echo json_encode($data);
	exit;
}
public function getWeightInfo(){
	$uid 		 =$_POST['uid']?$_POST['uid']:0;
	if(!$uid > 0){
		$data[0]['uid']="0";
		$data[0]['errorCode']="10001";
		echo json_encode($data);
		exit;
	}
	$weightInfo  = $this->getUserHealthById($uid);
	$weightInfo['calories']=$weightInfo['klu'];
	unset($weightInfo['klu']);
	foreach ($weightInfo as $key => $value) {
		$weightInfo[$key]=(string)$value;
	}
	echo json_encode($weightInfo);
	exit;
}

public function postWeightInfo(){
	$uid 		 =$_POST['uid']?$_POST['uid']:0;
	if(!$uid > 0) die();
	$weight=intval($_POST['weight']);
	$targetWeight=intval($_POST['targetWeight']);
	$nowWeight=intval($_POST['nowWeight']);
	$checkSql="select * from ai_user_health_info where `uid` =$uid";
	$checkResult=C_mysqlOne($checkSql);
	if(!empty($checkResult)){
		$updateSql="UPDATE  ai_user_health_info SET `body_weight` =  '".$weight."',
		`targetWeight` =  '".$targetWeight."',`nowWeight`='".$nowWeight."',`targetTime` =  '".time()."'
		WHERE `uid` =$uid LIMIT 1 ";
		C_mysqlOne($updateSql);
	}else{
		$insertSql="INSERT INTO  ai_user_health_info (`uid` ,`body_weight` ,`height` ,`age` ,`targetWeight` ,`nowWeight` ,`weightTime` ,`targetTime`)VALUES ('".$uid."','".$weight."','0','0','".$targetWeight."','".$nowWeight."','".time()."','".time()."')";
		C_mysqlOne($updateSql);
	}
	if($targetWeight > $weight){//目标数值大于原始值 增重
		$calorie=($targetWeight-$nowWeight)*7700;
	}else{
		$calorie=($nowWeight-$targetWeight)*7700;
	}
	$data [0] ['uid'] 		="0";
	$data [0] ['calorie']	=$calorie;
	echo json_encode($data);
	exit();
}
public function postCircleLike(){
	$uid  	= ! empty ( $_POST ['uid'] ) ? intval ( $_POST ['uid'] ) : '';
	$id 	 	= ! empty ( $_POST ['statusId'] ) ? intval ($_POST ['statusId']) : '';
	if(empty($uid)||empty($id)){
		$data [0] ['uid'] = '0';
		$data [0] ['errorCode'] = '10001';
		echo json_encode ( $data );
		exit ();
	}
	$checkSql="select * from ai_circle_vote where uid=$uid and cid=$id";
	$check=C_mysqlOne ( $checkSql );
	if(empty($check)){
		$updatesql="UPDATE ai_circle_info SET  `like`=`like`+1 WHERE  id=$id";
		C_mysqlOne ( $updatesql );
		$insql = 'insert into ai_circle_vote (`uid`,`cid`) values ("' . $uid . '","' . $id . '")';
		C_mysqlOne ( $insql );	
		$data[0]['uid']=(string)$uid;
		$data[0]['errorCode'] = "0";
		echo json_encode ( $data );
	} else {
		$data[0]['uid']=(string)$uid;
		$data[0]['errorCode'] = "10002";
		echo json_encode ( $data );
	}
}
public function postCircleComment(){
	$uid = ! empty ( $_POST ['uid'] ) ? intval ( $_POST ['uid'] ) : '';
	$content = ! empty ( $_POST ['content'] ) ? $_POST ['content'] : '';
	$id = ! empty ( $_POST ['id'] ) ? intval ($_POST ['id']) : '0';
		if(empty($id)){//评论目标
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		if(empty($uid)){//用户id
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10002';
			echo json_encode ( $data );
			exit ();
		}
		if(empty($content)){//content
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10003';
			echo json_encode ( $data );
			exit ();
		}
		$sql="INSERT INTO  `aijianmei`.`ai_circle_comment` (`id` ,`cid` ,`uid` ,`content` ,`parentid` ,`create_time`)
				VALUES (NULL ,  '".$id ."',   '".$uid ."',  '".$content."',  '0',  '".time()."')";
		C_mysqlOne ( $sql );
		$data [0] ['uid'] = $uid;
		$data [0] ['errorCode'] = '0';
		echo json_encode ( $data );
		exit ();
	}
	protected function getCircleCommentById($id){
		$sql=$result=null;
		$sql="select * from ai_circle_comment where cid=$id";
		$data=C_mysqlAll ( $sql );
		foreach ($data as $key =>$value){
			$result[$key]['avatarProfileUrl']=$this->getUserFace($value['uid']);
			$result[$key]['userName']=$this->getUserName($value['uid']);
			$result[$key]['content']=$value['content'];
			$result[$key]['create_time']=$value['create_time'];
		}
		return  $result;
	}
	protected function checkCircleLike($uid,$cid){
		if(empty($uid)||empty($cid)) return  "1";
		$sql="select * from ai_circle_vote where uid=$uid and cid=$cid";
		$data=C_mysqlAll( $sql );
		return empty($data)?"0":"1";
	}
	
	public function postCircleList() {
		$basedir = dirname(dirname ( __FILE__ ));
		$uid = ! empty ( $_POST ['uid'] ) ? intval ( $_POST ['uid'] ) : '';
		$content = ! empty ( $_POST ['content'] ) ? $_POST ['content'] : '';
		$group = ! empty ( $_POST ['group'] ) ? $_POST ['group'] : '0';
		if (empty ( $uid )) {
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		if (empty ( $content )) {
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10002';
			echo json_encode ( $data );
			exit ();
		}
		
		if (! empty ( $_FILES ['imageurl'] ['tmp_name'] )) {
			$srcImage = null;
			$path = "/upload/circle/$uid/";
			$fname = time () . rand () . '.jpg';
			$this->Aimkdirs ( "$basedir/upload/circle/$uid/" );
			$targetFile = $path . $fname;
			$smallimg = $path ."s".$fname;
			$srcImage = $basedir . $targetFile;
			$smallSrcImage=$basedir . $smallimg;
			move_uploaded_file ( $_FILES ['imageurl'] ['tmp_name'], $srcImage );
			$resize = new ResizeImage($srcImage);
			$resize->resizeTo(50, 50,'exact');
			$resize->saveImage($smallSrcImage);
		}
		
		$insql = "INSERT INTO  `aijianmei`.`ai_circle_info` (`id` ,`uid` ,`group` ,`content`,`imageurl` ,`bigImageUrl` ,`create_time`)
		VALUES (NULL ,  '" . $uid . "',  '" . $group . "',  '" . $content . "',  '" . $smallimg . "',  '" . $targetFile . "',  '" . time () . "')";
		C_mysqlOne ( $insql );
		$data [0] ['uid'] = $uid;
		$data [0] ['errorCode'] = '0';
		echo json_encode ( $data );
		exit ();
	}
	public function getCircleList() {
		//$this->baseUrl='http://www.kon_aijianmei.com/';
		$uid = ! empty ( $_POST ['uid'] ) ? intval ( $_POST ['uid'] ) : '';
		$circleUid = ! empty ( $_POST ['targetUid'] ) ? intval ( $_POST ['targetUid'] ) : '';
		$group = ! empty ( $_POST ['group'] ) ? intval ( $_POST ['group'] ) : '';
		$start = ! empty ( $_POST ['start'] ) ? intval ( $_POST ['start'] ) : 0;
		$offset = ! empty ( $_POST ['offset'] ) ? intval ( $_POST ['offset'] ) : 5;
		$where = '';
		if (! empty ( $circleUid )) {
			$where = " where uid =$circleUid";
		}
		if (! empty ( $group )) {
			$where = " where group =$group";
		}
		$sql = "select * from ai_circle_info $where order by id desc limit $start,$offset";
		$circleList = C_mysqlAll ( $sql );
		if (! empty ( $circleList )) {
			foreach ($circleList as $k=>&$v){
				$v['imageurl']=($this->baseUrl) . $v['imageurl'];
				$v['bigImageUrl']=($this->baseUrl) . $v['bigImageUrl'];
				$v['create_time']=$v['create_time'];
				$v['avatarProfileUrl']=$this->getUserFace($v['uid']);
				$v['userName']=$this->getUserName($v['uid']);
				$v['commentList']=$this->getCircleCommentById($v['id']);
				$v['isLike']=$this->checkCircleLike($uid,$v['id']);
			}
			echo json_encode ( $circleList );
			exit ();
		} else {
			$data [0] ['errorCode'] = '0';
			echo json_encode ( $data );
			exit ();
		}
	}
	public function getcommentbyid(){
		$id=$_GET['id'];
		$channeltype=$_GET['channeltype'];
		if(empty($id)||empty($channeltype)){
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		$getCommentsListSql = "select id,uid,content,create_time from ai_comments where parent_id=$id and parent_type=$channeltype order by create_time desc";
		$CommentsList = C_mysqlAll ( $getCommentsListSql );
		foreach ( $CommentsList as $k => $v ) {
			$CommentsList [$k] ['create_time'] = date ( "Y-m-d", $CommentsList [$k] ['create_time'] );
			$CommentsList [$k] ['userimg'] = $this->getUserFace ( $v ['uid'], 'm' );
			$CommentsList [$k] ['username'] = $this->getUserName ( $v ['uid'] );
		}
		$data = $CommentsList;
		echo json_encode ( $data );
		exit ();
	}
	public function articlestatus(){
		$uid=$_POST['uid'];
		$aid=$_POST['aid'];
		$vid=$_POST['vid'];
		$getStatusListSql="select content from ai_article_status where uid=$uid";
		$result=C_mysqlOne($getStatusListSql);
		$content=unserialize($result[0]['content']);
		if(empty($uid)){	
			$data [0] ['uid'] = '0';
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		
		if(!empty($aid)){
			$content["a".$aid]=1;
		}
		if(!empty($vid)){
			$content["v".$vid]=1;
		}
		$insertSql="INSERT INTO ai_article_status VALUES('".$uid."','".serialize($content)."') ON DUPLICATE KEY UPDATE content='".serialize($content)."'";
		C_mysqlOne($insertSql);
		$data [0] ['uid'] = (string)$uid;
		$data [0] ['errorCode'] = '0';
		echo json_encode ( $data );
		exit ();
	}
	public function au_uploadimg(){
		$uid=$_POST['uid'];
		if(empty($uid)){
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}

		$basedir=dirname(dirname(__FILE__));
		$data [0] ['uid'] =$uid;
		$srcImage="$basedir/data/uploads/avatar/$uid/original.jpg";
		if(move_uploaded_file($_FILES['avatarimage']['tmp_name'], $srcImage)){
			if(is_file($srcImage)){
				$fileDir="$basedir/data/uploads/avatar/$uid/big.jpg";
				@imageSizeFormate($srcImage,150,$fileDir);
				$fileDir="$basedir/data/uploads/avatar/$uid/middle.jpg";
				@imageSizeFormate($srcImage,50,$fileDir);
				$fileDir="$basedir/data/uploads/avatar/$uid/small.jpg";
				@imageSizeFormate($srcImage,30,$fileDir);
				$data[0]['avatarimage']=(string)$this->baseUrl."/data/uploads/avatar/$uid/original.jpg";
			}
		}
		
		$srcImage="$basedir/data/uploads/avatar/$uid/background.jpg";
		if(move_uploaded_file($_FILES['backgroundimage']['tmp_name'], $srcImage)){
			if(is_file($srcImage)){
				$data[0]['backgroundimage']=(string)$this->baseUrl."/data/uploads/avatar/$uid/background.jpg";
			}else{
				$data[0]['backgroundimage']='0';
			}
		}
		$data [0] ['errorCode'] = '0';
		echo json_encode ( $data );
		exit ();
	}
	public function au_getuidbysnsid() {
		$snsid = $_GET ['snsid'];
		if (empty ( $snsid )) {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		$sql = "select uid from ai_others where mediaUserID=$snsid";
		$data = C_mysqlOne ( $sql );
		if (empty($data)) {
			$sql = "select uid from ai_user where qqopenid=$snsid";
			$data = C_mysqlOne ( $sql );
			if (!empty($data)) {
				$data [0] ['uid'] = $data [0] ['uid'];
				$data [0] ['errorCode'] = '0';
				echo json_encode ( $data );
				exit ();
			} else {
				$data [0] ['uid'] = '0';
				$data [0] ['errorCode'] = '10002';
				echo json_encode ( $data );
				exit ();
			}
		} else {
			$data [0] ['uid'] = $data[0]['uid'];
			$data [0] ['errorCode'] = '0';
			echo json_encode ( $data );
			exit ();
		}
		exit ();
	}
	public function au_getuserinfobyuid() {
		$uid = $_GET ['uid'];
		$checkuid = C_mysqlOne ( "select * from ai_user where uid=$uid" );
		if (! empty ( $checkuid )) {
			$data = array ();
			$sql = "select
			a.uid,a.email,a.uname,a.sex,a.province,a.city,a.location,a.qqopenid,
			b.profileImageUrl,b.description,b.domain,b.mediaUserID
			from ai_user a left join ai_others b on a.uid=b.uid where a.uid=$uid";
			$res = C_mysqlOne ( $sql );
			
			$res = $res [0];
			if ($res ['province'] == 0 && $res ['location'] != '') {
				$locationArr = explode ( " ", $res ['location'] );
				$getaidSql = "SELECT title FROM  ai_area WHERE title LIKE '%" . $locationArr [0] . "%'";
				$provinceaid = C_mysqlOne ( $getaidSql );
				$res ['province'] = $provinceaid [0] ['title'];
				if ($res ['city'] != 0) {
					$getaidSql = "SELECT title FROM  ai_area WHERE title LIKE '%" . $locationArr [1] . "%'";
					$cityaid = C_mysqlOne ( $getaidSql );
					$res ['city'] = str_replace ( array (
							"市",
							"区",
							"县" 
					), '', $cityaid [0] ['title'] );
				}
				unset ( $res ['location'] );
			} elseif ($res ['province'] != 0) {
				$province = $res ['province'];
				$getaidSql = "SELECT title FROM  ai_area WHERE area_id LIKE '%" . $res ['province'] . "%'";
				$provinceaid = C_mysqlOne ( $getaidSql );
				$res ['province'] = $provinceaid [0] ['title'];
				if ($res ['city'] != 0) {
					$getaidSql = "SELECT title FROM  ai_area WHERE area_id LIKE '%" . $res ['city'] . "%'";
					$cityaid = C_mysqlOne ( $getaidSql );
					$res ['city'] = str_replace ( array (
							"市",
							"区",
							"县" 
					), '', $cityaid [0] ['title'] );
				} else {
					$getaidSql = "SELECT title FROM  ai_area WHERE pid ='" . $province . "' order by area_id limit 1";
					$cityaid = C_mysqlOne ( $getaidSql );
					$res ['city'] = str_replace ( array (
							"市",
							"区",
							"县" 
					), '', $cityaid [0] ['title'] );
				}
				unset ( $res ['location'] );
			}
			
			$getkeywords = "select keyword from ai_user_keywords where uid=$uid";
			$getkeywordsinfo = C_mysqlOne ( $getkeywords );
			$gethealth = "select body_weight,height,age from ai_user_health_info where uid=$uid";
			$gethealthinfo = C_mysqlOne ( $gethealth );

			$sql = "select iosAvatar from ai_others WHERE uid ='".$uid."'";
			$iosAvatar=C_mysqlOne ( $sql );
			if(!empty($iosAvatar)){
				$iosAvatarUrl="http://www.aijianmei.com/data/uploads/avatar/$uid/".$iosAvatar[0]['iosAvatar'];
			}else{
				$iosAvatarUrl='';
			}


			$data [0] ['uid'] = ( string ) $uid;
			$data [0] ['userType'] = $usertype;
			$data [0] ['profileImageUrl'] = !empty($iosAvatarUrl)? $iosAvatarUrl :( string ) $res ['profileImageUrl'];
			$data [0] ['avatarBackGroundImage'] = ( string ) $res ['avatarBackGroundImage'];
			$data [0] ['name'] = ( string ) $res ['uname'];
			$data [0] ['description'] = ( string ) $res ['description'];
			$data [0] ['gender'] = ( string ) $res ['sex'];
			$data [0] ['sinaUserId'] = ( string ) $res ['mediaUserID'];
			$data [0] ['qqUserId'] = ( string ) $res ['qqopenid'];
			$data [0] ['email'] = ( string ) $res ['email'];
			$data [0] ['password'] = "123456";
			$data [0] ['loginStatus'] = "1";
			$data [0] ['labelsArray'] = unserialize ( $getkeywordsinfo [0] ['keyword'] );
			$data [0] ['age'] = $gethealthinfo [0] ['age'] ? $gethealthinfo [0] ['age'] : '0';
			$data [0] ['height'] = $gethealthinfo [0] ['height'] ? $gethealthinfo [0] ['height'] : '0';
			$data [0] ['weight'] = $gethealthinfo [0] ['body_weight'] ? $gethealthinfo [0] ['body_weight'] : '0';
			$data [0] ['BMIValue'] = ( string ) $this->getBmiById ( $uid );
			$data [0] ['province'] = ( string ) $res ['province'];
			$data [0] ['city'] = ( string ) $res ['city'];
			$data [0] ['errorCode'] = '0';
			echo json_encode ( $data );
			exit ();
		} else {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		exit ();
	}
	public function au_updatepassword() {
		$uid = $_GET ['uid'];
		$oldpassword = $_GET ['oldpassword'];
		$newpassword = $_GET ['newpassword'];
		$checkuser = C_mysqlOne ( "select * from ai_user where uid=$uid" );
		if (! empty ( $checkuser )) {
			$checkoldpassword = C_mysqlOne ( "select * from ai_user WHERE uid=$uid and password='" . md5 ( $_GET ['oldpassword'] ) . "'" );
			if (empty ( $checkoldpassword )) {
				$data [0] ['uid'] = 0;
				$data [0] ['errorCode'] = '10003';
				echo json_encode ( $data );
				exit ();
			}
			$upsql = "update ai_user SET password = '" . md5 ( $_GET ['newpassword'] ) . "' WHERE uid=$uid and password='" . md5 ( $_GET ['oldpassword'] ) . "'";
			C_mysqlOne ( $upsql );
			$getmail = C_mysqlOne ( "select email from ai_user where uid=$uid" );
			$upsql = "update ecs_users SET password = '" . md5 ( $_GET ['newpassword'] ) . "' WHERE email='" . $getmail [0] ['email'] . "'";
			C_mysqlOne ( $upsql );
			$data [0] ['uid'] = $uid;
			$data [0] ['errorCode'] = '0';
			echo json_encode ( $data );
		} else {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10004';
			echo json_encode ( $data );
		}
		exit ();
	}
	public function au_getuserinfobysnsid() {
		$snsid = $_GET ['snsid'];
		$usertype = $_GET ['usertype'];
		$allowType = array (
				'sina',
				'qq' 
		);
		if (! in_array ( $usertype, $allowType )) {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10004';
			echo json_encode ( $data );
		}
		if ($usertype == 'sina') {
			$getemailsql = "select email,uid from ai_user where uid in (select uid from ai_others where mediaUserID=$snsid)";
			$checkuname = C_mysqlOne ( $getemailsql );
			if (! empty ( $checkuname [0] ['email'] )) {
				$data = array ();
				$uid = $checkuname [0] ['uid'];
				$sql = "select
				a.uid,a.email,a.uname,a.sex,a.province,a.city,a.location,a.qqopenid,
				b.profileImageUrl,b.description,b.domain,b.mediaUserID
				from ai_user a left join ai_others b on a.uid=b.uid where a.uid=$uid";
				$res = C_mysqlOne ( $sql );
				
				$res = $res [0];
				if ($res ['province'] == 0 && $res ['location'] != '') {
					$locationArr = explode ( " ", $res ['location'] );
					$getaidSql = "SELECT title FROM  ai_area WHERE ai_area LIKE '%" . $locationArr [0] . "%'";
					$provinceaid = C_mysqlOne ( $getaidSql );
					$res ['province'] = $provinceaid [0] ['title'];
					if ($res ['city'] != 0) {
						$getaidSql = "SELECT title FROM  ai_area WHERE ai_area LIKE '%" . $locationArr [1] . "%'";
						$cityaid = C_mysqlOne ( $getaidSql );
						$res ['city'] = $cityaid [0] ['title'];
					}
					unset ( $res ['location'] );
				} elseif ($res ['province'] != 0) {
					$getaidSql = "SELECT title FROM  ai_area WHERE ai_area LIKE '%" . $res ['province'] . "%'";
					$provinceaid = C_mysqlOne ( $getaidSql );
					$res ['province'] = $provinceaid [0] ['title'];
					if ($res ['city'] != 0) {
						$getaidSql = "SELECT title FROM  ai_area WHERE ai_area LIKE '%" . $res ['city'] . "%'";
						$cityaid = C_mysqlOne ( $getaidSql );
						$res ['city'] = $cityaid [0] ['title'];
					}
					unset ( $res ['location'] );
				}
				
				$getkeywords = "select keyword from ai_user_keywords where uid=$uid";
				$getkeywordsinfo = C_mysqlOne ( $getkeywords );
				$gethealth = "select body_weight,height,age from ai_user_health_info where uid=$uid";
				$gethealthinfo = C_mysqlOne ( $gethealth );
				$data [0] ['uid'] = ( string ) $uid;
				$data [0] ['userType'] = $usertype;
				$data [0] ['profileImageUrl'] = ( string ) $res ['profileImageUrl'];
				$data [0] ['avatarBackGroundImage'] = ( string ) $res ['avatarBackGroundImage'];
				$data [0] ['name'] = ( string ) $res ['uname'];
				$data [0] ['description'] = ( string ) $res ['description'];
				$data [0] ['gender'] = ( string ) $res ['sex'];
				$data [0] ['sinaUserId'] = ( string ) $res ['mediaUserID'];
				$data [0] ['qqUserId'] = ( string ) $res ['qqopenid'];
				$data [0] ['email'] = ( string ) $res ['email'];
				$data [0] ['password'] = "123456";
				$data [0] ['loginStatus'] = "1";
				$data [0] ['labelsArray'] = unserialize ( $getkeywordsinfo [0] ['keyword'] );
				$data [0] ['age'] = $gethealthinfo [0] ['age'] ? $gethealthinfo [0] ['age'] : '0';
				$data [0] ['height'] = $gethealthinfo [0] ['height'] ? $gethealthinfo [0] ['height'] : '0';
				$data [0] ['weigth'] = $gethealthinfo [0] ['body_weight'] ? $gethealthinfo [0] ['body_weight'] : '0';
				$data [0] ['BMIValue'] = ( string ) $this->getBmiById ( $uid );
				$data [0] ['province'] = ( string ) $res ['province'];
				$data [0] ['city'] = ( string ) $res ['city'];
				$data [0] ['errorCode'] = '0';
				echo json_encode ( $data );
				exit ();
			} else {
				$data [0] ['uid'] = 0;
				$data [0] ['errorCode'] = '10001';
				echo json_encode ( $data );
				exit ();
			}
		}
		if ($usertype == 'qq') {
			$getemailsql = "select uid,email from ai_user where qqopenid='" . $snsid . "'";
			$checkuname = C_mysqlOne ( $getemailsql );
			if (! empty ( $checkuname [0] ['email'] )) {
				$data = null;
				$uid = $checkuname [0] ['uid'];
				$sql = "select
				a.uid,a.email,a.uname,a.sex,a.province,a.city,a.location,
				b.friendsCount,b.followersCount,b.profileImageUrl,b.description,b.domain,b.cemail,b.ctell
				from ai_user a left join ai_others b on a.uid=b.uid where a.uid=$uid";
				$res = C_mysqlOne ( $sql );
				$res = $res [0];
				foreach ( $res as $k => $v ) {
					$data [0] [$k] = $v;
				}
				$getkeywords = 'select keyword from ai_user_keywords where uid=$uid';
				$getkeywordsinfo = C_mysqlOne ( $getkeywords );
				
				$gethealth = 'select body_weight,height,age from ai_user_health_info where uid=$uid';
				$gethealthinfo = C_mysqlOne ( $gethealth );
				
				$data ['keywordinfo'] = unserialize ( $getkeywordsinfo [0] ['keyword'] );
				$data ['healthinfo'] = $gethealthinfo [0];
				$data [0] ['uid'] = $uid;
				$data [0] ['errorCode'] = '0';
				
				echo json_encode ( $data );
				exit ();
			} else {
				$data [0] ['uid'] = 0;
				$data [0] ['errorCode'] = '10001';
				echo json_encode ( $data );
				exit ();
			}
		}
		exit ();
	}
	public function au_updateUserInfo() {
		$uid = $_GET ['uid'];
		$username = $_GET ['username'] ? $_GET ['username'] : null;
		$oldusernameinfo = C_mysqlOne ( "select * from ai_user where uid =$uid" );
		$oldusernameinfo = $oldusernameinfo [0];
		if (! empty ( $oldusernameinfo )) {
			$checkunamesql = "select uname from ai_user where uname='" . $username . "' and email!='" . $oldusernameinfo ['email'] . "'";
			$checkuname = C_mysqlOne ( $checkunamesql );
			$checkuname = $checkuname [0];
			if (! empty ( $_GET ['username'] ) && empty ( $checkuname )) { // 用户名
				
				if (empty ( $checkuname )) {
					$this->updatePWUname ( $oldusernameinfo ['uname'], $oldusernameinfo ['email'], $username );
					$upsql = null;
					$upsql = "UPDATE ai_user SET uname = '" . $username . "' WHERE uid =$uid";
					C_mysqlOne ( $upsql );
					$upsql = "UPDATE ecs_users SET user_name = '" . $username . "' WHERE user_name ='" . $oldusernameinfo ['uname'] . "'";
					C_mysqlOne ( $upsql );
				} else {
					$data [0] ['uid'] = $uid;
					$data [0] ['errorCode'] = '4001'; // 用户名已经存在
					echo json_encode ( $data );
					exit ();
				}
			}
			if (! empty ( $_GET ['keyword'] )) { // 标签
				$keywordinfo = explode ( "|", $_GET ['keyword'] );
				$oldkeyword = C_mysqlOne ( "select keyword from ai_user_keywords WHERE uid =$uid" );
				if (! empty ( $oldkeyword [0] )) {
					$oldkeyword = $this->mb_unserialize ( $oldkeyword [0] ['keyword'] );
					foreach ( $oldkeyword as $key => &$value ) {
						foreach ( $keywordinfo as $key1 => &$value1 ) {
							if (! in_array ( $value1, $oldkeyword )) {
								$oldkeyword [] = $value1;
							}
						}
					}
				} else {
					$oldkeyword = $keywordinfo;
				}
				$sql = "INSERT INTO ai_user_keywords VALUES($uid,serialize($oldkeyword)) ON DUPLICATE KEY UPDATE keyword='" . serialize ( $oldkeyword ) . "'";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['description'] )) { // 个人签名
				$description = $_GET ['description'];
				$sql = "UPDATE ai_others SET description = '" . $description . "' WHERE  id =$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['sex'] )) { // 性别
				$sql = "UPDATE ai_user SET sex = '" . $_GET ['sex'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['age'] )) { // 年龄
				$sql = "UPDATE ai_user_health_info SET age = '" . $_GET ['age'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['weight'] )) { // 体重
				$sql = "UPDATE ai_user_health_info SET body_weight = '" . $_GET ['weight'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['height'] )) { // 身高
				$sql = "UPDATE ai_user_health_info SET height = '" . $_GET ['height'] . "' WHERE uid=$uid";
				C_mysqlOne ( $sql );
			}
			if (! empty ( $_GET ['province'] )) { // 省份
				$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_GET ['province'] . "%'";
				$aidInfo = C_mysqlOne ( $getaidSql );
				$aidInfo = $aidInfo [0];
				$upsql = "UPDATE ai_user SET province='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
				C_mysqlOne ( $upsql );
			}
			if (! empty ( $_GET ['city'] )) { // 城市
				$getaidSql = "SELECT area_id FROM  ai_area WHERE title LIKE '%" . $_GET ['city'] . "%'";
				$aidInfo = C_mysqlOne ( $getaidSql );
				$aidInfo = $aidInfo [0];
				$upsql = "UPDATE ai_user SET city='" . $aidInfo ['area_id'] . "' WHERE uid=$uid";
				C_mysqlOne ( $upsql );
			}
			if (! empty ( $_FILES ['image'] ['tmp_name'] )) { // 头像				
				$this->makeAvatar($uid);
			}
			/*if (! empty ( $_FILES ['userbgimg'] ['tmp_name'] )) { // 头像
				$target = dirname ( dirname ( __FILE__ ) ) . "/data/uploads/avatar/" . $uid . "/" . $uid . "bg.jpg";
				move_uploaded_file ( $_FILES ['userbgimg'] ['tmp_name'], $target );
			}*/
		}
		$bim = $this->getBmiById ( $uid );
		$data [0] ['uid'] = $uid;
		$data [0] ['bmi'] = $bim;
		$data [0] ['errorCode'] = '0';
		echo json_encode ( $data );
		exit ();
	}
	public function au_sendsuggestion() {
		$uid = $_GET ['uid'];
		$emailinfo = C_mysqlOne ( "select email from ai_user where uid =$uid" );
		$content = $_GET ['content'];
		$email = $emailinfo [0] ['email'];
		$insertsql = "insert into ai_feedback_info (email,content,isread,create_time) values ('" . $email . "','" . $content . "','0','" . time () . "')";
		C_mysqlOne ( $insertsql );
		$data [0] ['errorCode'] = 0;
		echo json_encode ( $data );
		exit ();
	}
	public function au_getversion() {
		$getVersionSql = "select version,durl,app_update_title,app_update_content from ai_appversion order by id desc limit 1";
		// $getUidSql="UPDATE ai_appversion SET create_time =".time()." WHERE id =1";
		$getUidInfo = C_mysqlOne ( $getVersionSql );
		$uid [0] ['version'] = ( string ) $getUidInfo [0] ['version'];
		$uid [0] ['downloadurl'] = ( string ) $getUidInfo [0] ['durl'];
		$uid [0] ['app_update_title'] = ( string ) $getUidInfo [0] ['app_update_title'];
		$uid [0] ['app_update_content'] = ( string ) $getUidInfo [0] ['app_update_content'];
		echo json_encode ( $uid );
		exit ();
	}
	public function au_login() {
		$email = $_GET ['email'];
		$userpassword = $_GET ['userpassword'];
		$usertype = $_GET ['usertype'];
		$getUidSql = "select uid from ai_user where email='" . $email . "' and password='" . md5 ( $userpassword ) . "'";
		$getUidInfo = C_mysqlOne ( $getUidSql );
		$uid = ( int ) $getUidInfo [0] ['uid'];
		if ($uid > 0) {
			$sql = "select 
			a.uid,a.email,a.uname,a.sex,a.province,a.city,a.location,
			b.friendsCount,b.followersCount,b.profileImageUrl,b.description,b.domain,b.cemail,b.ctell
			from ai_user a left join ai_others b on a.uid=b.uid where a.uid=$uid";
			$res = C_mysqlOne ( $sql );
			$getkeywords = 'select keyword from ai_user_keywords where uid=$uid';
			$getkeywordsinfo = C_mysqlOne ( $getkeywords );
			
			$gethealth = 'select body_weight,height,age from ai_user_health_info where uid=$uid';
			$gethealthinfo = C_mysqlOne ( $gethealth );
			
			$res ['keywordinfo'] = unserialize ( $getkeywordsinfo [0] ['keyword'] );
			$res ['healthinfo'] = $gethealthinfo [0];
			$data [0] ['uid'] = $uid;
			$data [0] ['errorCode'] = '0';
			echo json_encode ( $data );
			exit ();
		} else {
			return $this->errormsg ();
		}
	}
	public function au_register() {
		$allowType = array (
				'local',
				'sina',
				'qq' 
		);
		$allowTypeval = array (
				'local' => 1,
				'sina' => 2,
				'qq' => 3 
		);
		$username = $this->pregCheck ( $_GET ['username'], 'string' );
		$email = $this->pregCheck ( $_GET ['email'], 'email' );
		$userpassword = $_GET ['userpassword'];
		$usertype = $_GET ['usertype'];
		if (! in_array ( $usertype, $allowType )) {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = '10004';
			echo json_encode ( $data );
		}
		$profileImageUrl = $_GET ['profileImageUrl'];
		$sex = $_GET ['sex'];
		$age = $_GET ['age'];
		$snsid = $_GET ['snsid'];
		$body_weight = $_GET ['body_weight'];
		$height = $_GET ['height'];
		$keyword = $_GET ['keyword'];
		$province = $_GET ['province'];
		$city = $_GET ['city'];
		
		$sql = "select uid from ai_user where uname='" . $username . "' and email='" . $email . "'";
		$ares = C_mysqlOne ( $sql );
		if (! empty ( $ares )) {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = "10003";
			echo json_encode ( $data );
			exit ();
		}
		$sql = "select uid from ai_user where uname='" . $username . "'";
		$res = C_mysqlOne ( $sql );
		if (! empty ( $res )) {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = "10001";
			echo json_encode ( $data );
			exit ();
		}
		$sql = "select uid from ai_user where email='" . $email . "'";
		$res = C_mysqlOne ( $sql );
		
		if (empty ( $res [0] ['uid'] )) {
			$insertSql = "insert into ai_user (uname,email,password,sex,location)
			values ('" . $username . "','" . $email . "','" . md5 ( $userpassword ) . "','" . $sex . "','" . $province . " " . $city . "')";
			C_mysqlOne ( $insertSql );
			$getuidSql = "select uid from ai_user where uname='" . $username . "' and password='" . md5 ( $userpassword ) . "' and email='" . $email . "'";
			$uidinformation = C_mysqlOne ( $getuidSql );
			$uid = $uidinformation [0] ['uid'];
			C_mysqlOne ( "UPDATE  `aijianmei`.`ai_user` SET  `is_active` =  '1',`is_init` =  '1' WHERE  `ai_user`.`uid` =$uid" );
			C_mysqlOne ( "UPDATE  `aijianmei`.`ai_user` SET  `upic_type` =  '" . $allowTypeval [$usertype] . "' WHERE  `ai_user`.`uid` =$uid" );
			$this->othersreg ( $uid, $profileImageUrl, $snsid );
			$this->shopreg ( $username, $userpassword, $email );
			$this->insertkeyword ( $keyword, $uid );
			$this->inserthealthinfo ( $age, $body_weight, $height, $uid );
			$data [0] ['errorCode'] = 0;
			$data [0] ['uid'] = intval ( $uid );
			echo json_encode ( $data );
		} else {
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = "10002";
			echo json_encode ( $data );
		}
		exit ();
	}
	public function au_getinformationlist() {
		$listtype = ! empty ( $_GET ['listtype'] ) ? intval ( $_GET ['listtype'] ) : 1; // 默认获取最新的文章视频信息
		$category = $_GET ['category'];
		$categoryid = ! empty ( $_GET ['cateid'] ) ? intval ( $_GET ['cateid'] ) : '';
		$id = ! empty ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : '';
		$type = $_GET ['type'];
		$page = ! empty ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$pnums = ! empty ( $_GET ['pnums'] ) ? intval ( $_GET ['pnums'] ) : 10;
		
		$uid = ! empty ( $_GET ['uid'] ) ? intval ( $_GET ['uid'] ) : '';
		$from = ($page - 1) * $pnums;
		if (isset ( $_GET ['start'] )) {
			$from = $start = ! empty ( $_GET ['start'] ) ? intval ( $_GET ['start'] ) : 0;
		}
		if (isset ( $_GET ['offset'] )) {
			$pnums = $offset = ! empty ( $_GET ['offset'] ) ? intval ( $_GET ['offset'] ) : 10;
		}
		
		$orderSql = null;
		if (! empty ( $category )) {
			if (in_array ( $category, $this->categoryArray )) {
				$channelNum = $this->categoryValues [$category];
				if ($channelNum > 0) {
					$cateSql = "select id from ai_article_category where channel=$channelNum";
					$orderSql = "where category_id in (" . $cateSql . ")";
					$orderTableSql = "SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$channelNum";
				}
			}
		}
		$orderkey = ! empty ( $type ) ? ($type == 'hot' ? 'click' : 'create_time') : 'create_time';
		if ($listtype == 1) {
			$arlSql = "select category_id,id,title,brief,create_time,IFNULL(wapimg,img) as img,reader_count as click,1 from ai_article $orderSql";
			$videoSql = "select category_id,id,title,brief,create_time,link AS img,click,2 from ai_video $orderSql";
			$limitsql = "select * from ($arlSql union all $videoSql) as t order by $orderkey desc limit " . $from . ",$pnums";
		} elseif ($listtype == 2) {
			// $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$type";
			if(!empty($orderTableSql)){
				$limitsql = "select a.category_id,a.id,a.title,a.brief,a.create_time,IFNULL(a.wapimg,a.img) as img,a.reader_count as click,1 from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by $orderkey desc limit " . $from . ",$pnums";
			}else{
				$limitsql = "select a.category_id,a.id,a.title,a.brief,a.create_time,IFNULL(a.wapimg,a.img) as img,a.reader_count as click,1 from ai_article a  group by a.id order by $orderkey desc limit " . $from . ",$pnums";
			}
		} elseif ($listtype == 3 ) {
			$limitsql = "select category_id,id,title,brief,create_time,link AS img,click,2 from ai_video order by $orderkey desc limit " . $from . ",$pnums";
		}
		$cateInfo = $this->categoryidValues [$category];
		if ($cateInfo [$categoryid] > 0 && $categoryid > 0) {
			$cid = $cateInfo [$categoryid];
			$order = $orderkey;
			
			$orderTableSql = "SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($cid)";
			$limitsql = "select a.category_id,a.id,a.title,a.brief,a.create_time,IFNULL(a.wapimg,a.img) as img,a.reader_count as click,2 from ai_article a where id in ($orderTableSql) or category_id=$cid group by a.id  order by " . $order . " desc limit " . $from . "," . $pnums . "";
			if ($category == 'train' && $cid == 53) {
				$limitsql = "select category_id,id,title,brief,create_time,link AS img,click,2 from ai_video  order by $order desc limit " . $from . "," . $pnums . "";
			}
		}
		
		$searchInfo = C_mysqlAll ( $limitsql );
		foreach ( $searchInfo as $k => $v ) {
			if ($listtype == 3) {
				$searchInfo [$k] ["1"] = $searchInfo [$k] ["2"];
			}
			unset ( $searchInfo [$k] ["2"] );
		}
		
		if (empty ( $searchInfo )) {
			$data ['uid'] = (string)$uid;
			$data ['errorCode'] = '10001';
			echo json_encode ( $data );
			exit ();
		}
		foreach ( $searchInfo as $key => $value ) {
			$getchannelNumSql = "select channel from ai_article_category where id='" . $value ['category_id'] . "'";
			$getchannelNum = C_mysqlOne ( $getchannelNumSql );
			$searchInfo [$key] ['Channel'] = ( string ) $getchannelNum ['channel'];
			$searchInfo [$key] ['commentCount'] = ( string ) $this->getCountCommentsByType ( $value ['id'], $value ['1'] );
			foreach ( $value as $rk => $rv ) {
				$searchInfo [$key] [$rk] = ( string ) $rv;
			}
			if ($value ['1'] > 1) {
				$searchInfo [$key] ['img'] = $this->getVideoDataImg ( $value ['img'] );
			} else {
				if ($value ['img'] != '') {
					$searchInfo [$key] ['img'] = $this->baseUrl . '/public/images/article/' . $value ['img'];
				}
				if($value ['wapimg'] != ''){
					$searchInfo [$key] ['img'] = $this->baseUrl . '/public/images/article/' . $value ['wapimg'];
				}
			}
			if ($value ['1'] == 1) {
				$searchInfo [$key] ['channeltype'] = "1";
				$searchInfo [$key] ['url'] = $this->baseUrl . '/index-Index-articleDetail-' . $value ['id'] . '.html';
				$searchInfo [$key] ['shareurl'] = 'http://www.aijianmei.com/index-Index-articleDetail-' . $value ['id'] . '.html';
			}
			if ($value ['1'] == 2) {
				$searchInfo [$key] ['channeltype'] = "2";
				$getCsql = "select link,wapurl from ai_video where id='" . $value ['id'] . "'";
				$channelinfo = C_mysqlAll ( $getCsql );
				$searchInfo [$key] ['url'] = $this->baseUrl . '/index-Train-videoDetail-' . $value ['id'] . '.html';
				$searchInfo [$key] ['shareurl'] = ($channelinfo [0] ['wapurl'] != '') ? $channelinfo [0] ['wapurl'] : $channelinfo [0] ['link'];
			}
			$searchInfo [$key] ['channel'] = $searchInfo [$key] ['Channel'];
			
			$searchInfo [$key] ['create_time'] =date("Y-m-d",$searchInfo [$key] ['create_time']);
			unset ( $searchInfo [$key] ['1'] );
			unset ( $searchInfo [$key] ['Channel'] );
		}
		// print_r($searchInfo);
		if(!empty($uid)){
			$getStatusListSql="select content from ai_article_status where uid=$uid";
			$result=C_mysqlOne($getStatusListSql);
			$content=unserialize($result[0]['content']);
			foreach ($searchInfo as $key => $value){
				if($value['channeltype']==1){
						$searchInfo[$key]['isread']=($content['a'.$value['id']]==1)?'1':'0';
				}elseif($value['channeltype']==2){
						$searchInfo[$key]['isread']=($content['v'.$value['id']]==1)?'1':'0';
				}else{
					$searchInfo[$key]['isread']='0';
				}
			}
		}
		// var_dump($searchInfo);
		echo json_encode ( $searchInfo );
		exit ();
	}
	public function au_getinformationdetail() {
		$id = $_GET ['id'];
		$channel = $_GET ['channel'];
		$channeltype = $_GET ['channeltype'];
		$uid = $_GET ['uid'];
		if ($channeltype != 2) {
			$getDetailSql = "select *,wapcontent as content from ai_article where id=$id limit 1";
		} else {
			$getDetailSql = "select * from ai_video where id=$id limit 1";
		}
		$DetailInformationTmp = C_mysqlOne ( $getDetailSql );
		$DetailInformation = $DetailInformationTmp;
		// $DetailInformation
		$DetailInformation [0] ['create_time'] =$DetailInformation [0] ['create_time'] ;
		$getCommentsListSql = "select id,uid,content,create_time from ai_comments where parent_id=$id and parent_type=$channeltype order by create_time desc";
		$CommentsList = C_mysqlAll ( $getCommentsListSql );
		foreach ( $CommentsList as $k => $v ) {
			$CommentsList [$k] ['create_time'] = $CommentsList [$k] ['create_time'] ;
			$CommentsList [$k] ['userimg'] = $this->getUserFace ( $v ['uid'], 'm' );
			$CommentsList [$k] ['username'] = $this->getUserName ( $v ['uid'] );
		}
		// http://www.kon_aijianmei.com/public/images/article/
		$DetailInformation [0] ['CommentsCount'] = ( string ) count ( $CommentsList );
		$DetailInformation [0] ['CommentsList'] = $CommentsList;
		
		$DetailInformation [0] ['click'] = $DetailInformation [0] ['reader_count'] ? $DetailInformation [0] ['reader_count'] : $DetailInformation [0] ['click'];
		$DetailInformation [0] ['img'] = $this->baseUrl . '/public/images/article/' . $DetailInformation [0] ['img'];
		if ($channeltype == 2) {
			$DetailInformation [0] ['img'] = $this->getVideoDataImg ( $DetailInformation [0] ['link'] );
			$DetailInformation [0] ['author'] = '爱健美团队';
		}
		unset ( $DetailInformation [0] ['keyword'] );
		unset ( $DetailInformation [0] ['unlike'] );
		unset ( $DetailInformation [0] ['front_cover'] );
		unset ( $DetailInformation [0] ['reader_count'] );
		unset ( $DetailInformation [0] ['is_promote'] );
		unset ( $DetailInformation [0] ['status'] );
		unset ( $DetailInformation [0] ['link'] );
		unset ( $DetailInformation [0] ['wapurl'] );
		unset ( $DetailInformation [0] ['uid'] );
		unset ( $DetailInformation [0] ['category_id'] );
		unset ( $DetailInformation [0] ['source'] );
		// print_r($DetailInformation);
		// var_dump($DetailInformation);
		echo json_encode ( $DetailInformation );
		exit ();
	}
	public function au_sendcomment() {
		$id = $_REQUEST ['id'];
		$channel = $_REQUEST ['channel'];
		$channeltype = $_REQUEST ['channeltype'];
		$uid = $_REQUEST ['uid'];
		$content = $_REQUEST ['commentcontent'];
		if(empty($uid)||empty($id)||empty($content )){
			$data [0]['uid'] = "0";
			$data [0]['errorCode'] = "10001";
			echo json_encode ( $data );
			exit ();
		}
		$checkReComSql = "select * from ai_comments where uid=$uid and content='" . $content . "' and parent_type='" . $channeltype . "'";
		$checkReCom = C_mysqlOne ( $checkReComSql );
		if(!empty($checkReCom)){
			$data [0]['uid'] = "0";
			$data [0]['errorCode'] = "10002";
			echo json_encode ( $data );
			exit ();
		}
		$sql = "INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent) VALUES ('" . $uid . "','" . $content . "','" . $id . "','" . $channeltype . "'," . time () . ",'','0')";
		C_mysqlOne ( $sql );
		$getinsertinfosql = "select * from ai_comments where uid=$uid and content='" . $content . "' and parent_type='" . $channeltype . "'";
		$getinsertinfo = C_mysqlOne ( $getinsertinfosql );
		$data = null;
		if (! empty ( $getinsertinfo )) {
			$data [0]['uid'] = (string)$uid;
			$data [0]['errorCode'] = "0";
			echo json_encode ( $data );
			// {"status":"true"}失败返回 {"status":"false","error":"404"}
		} else {
			$data [0]['uid'] = (string)$uid;
			$data [0]['errorCode'] = "10002";
			echo json_encode ( $data );
		}
	}
	public function au_delcomment() {
		$id = $_GET ['id'];
		$channel = $_GET ['channel'];
		$channeltype = $_GET ['channeltype'];
		$uid = $_GET ['uid'];
		
		if(empty($uid)||empty($id)){
			$data [0]['errorCode'] = "10001";
			echo json_encode ( $data );
			exit ();
		}
		
		$sql = "delete from ai_comments where uid=$uid and id=$id";
		C_mysqlOne ( $sql );
		$getinsertinfosql = "select * from ai_comments where uid=$uid and id=$id";
		$getinsertinfo = C_mysqlOne ( $getinsertinfosql );
		$data = null;
		if (empty ( $getinsertinfo )) {
			$data [0]['errorCode'] = "0";
			echo json_encode ( $data );
			// {"status":"true"}失败返回 {"status":"false","error":"404"}
		} else {
			$data [0]['errorCode'] = "10002";
			echo json_encode ( $data );
		}
	}
	public function au_sendlike() {
		$id = $_GET ['id'];
		$channel = $_GET ['channel'];
		$channeltype = $_GET ['channeltype'];
		$uid = $_GET ['uid'];
		
		if(empty($uid)||empty($id)){
			$data [0]['uid']='0';
			$data [0]['errorCode'] = "10001";
			echo json_encode ( $data );
			exit ();
		}
		$checkLikeSql = $channeltype == 1 ? "select * from ai_article_vote where uid=$uid and article_id=$id" : "select * from ai_daily_vote where uid=$uid and article_id=$id";
		$checkLikeInfo = C_mysqlOne ( $checkLikeSql );
		if (empty ( $checkLikeInfo )) {
			if ($channeltype == 1) {
				$usql = "update ai_article set `like`=`like`+1 where id=$id";
				C_mysqlOne ( $usql );
				$insql = 'insert into ai_article_vote (`uid`,`article_id`) values ("' . $uid . '","' . $id . '")';
				C_mysqlOne ( $insql );
			} elseif ($channeltype == 2) {
				$usql = "update ai_daily set `like`=`like`+1 where id=$id";
				C_mysqlOne ( $usql );
				$insql = 'insert into ai_daily_vote (`uid`,`article_id`) values ("' . $uid . '","' . $id . '")';
				C_mysqlOne ( $insql );
			}
			$data[0]['uid']=(string)$uid;
			$data[0]['errorCode'] = "0";
			echo json_encode ( $data );
		} else {
			$data[0]['uid']=(string)$uid;
			$data[0]['errorCode'] = "10002";
			echo json_encode ( $data );
		}
		exit ();
	}
	public function au_getfplist() {
		$type = ! empty ( $_GET ['type'] ) ? intval ( $_GET ['type'] ) + 1 : '';
		$page = ! empty ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$pnums = ! empty ( $_GET ['pnums'] ) ? intval ( $_GET ['pnums'] ) : 10;
		$uid = ! empty ( $_GET ['uid'] ) ? intval ( $_GET ['uid'] ) : '';
		$from = ($page - 1) * $pnums;
		if (isset ( $_GET ['start'] )) {
			$from = $start = ! empty ( $_GET ['start'] ) ? intval ( $_GET ['start'] ) : 0;
		}
		if (isset ( $_GET ['offset'] )) {
			$pnums = $offset = ! empty ( $_GET ['offset'] ) ? intval ( $_GET ['offset'] ) : 10;
		}
		
		$dailyinfo = array ();
		$dailyinfo = $this->getDailyLimit ( $type, $from, $pnums );
		$dailyinfoTmp = array ();
		
		foreach ( $dailyinfo as $key => &$value ) {
			// $dailyinfoTmp[$]
			$dailyinfoTmp [$key] ['id'] = $value ['article'] ['id'];
			$dailyinfoTmp [$key] ['title'] = $value ['article'] ['title'];
			$dailyinfoTmp [$key] ['img'] = ($value ['article'] ['img'] == '' && $value ['video'] [0] ['img'] != '') ? $value ['video'] [0] ['img'] : '/public/images/article/' . $value ['article'] ['img'];
			$dailyinfoTmp [$key] ['content'] = $value ['article'] ['content'];
			$dailyinfoTmp [$key] ['wapurl'] = $value ['video'] [0] ['wapurl'] ? $value ['video'] [0] ['wapurl'] : "NULL";
			// content
			$dailyinfoTmp [$key] ['channel'] = $value ['article'] ['channel'];
			$dailyinfoTmp [$key] ['commentsList'] = $value ['commentsList'];
			$dailyinfoTmp [$key] ['commentCount'] = $value ['commentCount'];
		}
		// var_dump($dailyinfoTmp);
		echo json_encode ( $dailyinfoTmp );
		exit ();
	}
	protected function pregCheck($string, $type) {
		switch ($type) {
			case 'string' :
				$pattren = "/(@([\x{4e00}-\x{9fa5}]|[@#\w])*[^@#\w])/u";
				$restats = false;
				break;
			case 'email' :
				$pattren = "/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i";
				$restats = true;
				break;
			default :
				$pattren = "/(@([\x{4e00}-\x{9fa5}]|[@#\w])*[^@#\w])/u";
				$restats = false;
				break;
		}
		
		if (preg_match ( $pattren, $string ) == $restats) {
			return $string;
		} else {
			return $this->errormsg ();
		}
	}
	protected function insertkeyword($keyinfo, $uid) {
		$keyArr = explode ( "|", $keyinfo );
		if (is_array ( $keyArr )) {
			$keyTmp = array ();
			foreach ( $keyArr as $k => $v ) {
				if (! in_array ( $v, $keyTmp )) {
					$keyTmp [] = $v;
				}
			}
			$checkkeywordSql = "select * from ai_user_keywords WHERE uid =$uid";
			$cres = C_mysqlOne ( $checkkeywordSql );
			if ($cres) {
				$upsql = null;
				$upsql = "UPDATE ai_user_keywords SET keyword = '" . serialize ( $keyTmp ) . "' WHERE uid =$uid";
				C_mysqlOne ( $upsql );
			} else {
				$upsql = null;
				$upsql = "INSERT INTO  ai_user_keywords (uid,keyword)values('" . $uid . "','" . serialize ( $keyTmp ) . "')";
				C_mysqlOne ( $upsql );
			}
		}
	}
	protected function inserthealthinfo($age, $body_weight, $height, $uid) {
		$checksql = null;
		$checksql = "select * from ai_user_health_info where uid =$uid";
		$cres = C_mysqlOne ( $checksql );
		if ($cres) {
			$upsql = null;
			if ($body_weight != '' || $height != '' || $age != '') {
				$upsql = "UPDATE ai_user_health_info SET body_weight = '" . $body_weight . "'
					,height = '" . $height . "'
					,age = '" . $age . "' WHERE uid =$uid";
				C_mysqlOne ( $upsql );
			}
		} else {
			$insertSql = "INSERT INTO  `aijianmei`.`ai_user_health_info` (`uid` ,`body_weight` ,`height` ,`age`)
				VALUES ($uid, '" . $body_weight . "','" . $height . "','" . $age . "')";
			C_mysqlOne ( $insertSql );
		}
	}
	protected function shopreg($username, $password, $userEmail) {
		$sdata = null;
		$sdata ['uname'] = addslashes ( $username );
		$sdata ['password'] = addslashes ( $password );
		$sdata ['email'] = addslashes ( $userEmail );
		$this->_postCurlRegister ( $sdata );
	}
	protected function othersreg($mid, $userimg, $snsid) {
		$insertsql = $insertstr = $valuestr = null;
		$other ['uid'] = $mid;
		$other ['mediaID'] = '3';
		$other ['friendsCount'] = 0;
		$other ['favouritesCount'] = 0;
		$other ['profileImageUrl'] = $userimg;
		$other ['mediaUserID'] = $snsid;
		$other ['url'] = '';
		$other ['homepage'] = '';
		$other ['description'] = '';
		$other ['domain'] = '';
		$other ['followersCount'] = 0;
		$other ['statusesCount'] = 0;
		$other ['personID'] = 0;
		foreach ( $other as $key => $value ) {
			$insertstr .= empty ( $insertstr ) ? $key : ',' . $key;
			$valuestr .= empty ( $valuestr ) ? "'" . $value . "'" : ",'" . $value . "'";
		}
		$insertsql = "INSERT INTO `aijianmei`.`ai_others` ($insertstr) VALUES ($valuestr)";
		C_mysqlQuery ( $insertsql );
	}
	protected function errormsg() {
		$data = null;
		$data [0] ['status'] = false;
		$data [0] ['error'] = 500;
		if ($_REQUEST ['auact'] == 'au_register' || $_REQUEST ['auact'] == 'au_login') {
			$data = null;
			$data [0] ['uid'] = 0;
			$data [0] ['errorCode'] = "10002";
		}
		$this->errormsg = $data;
		echo json_encode ( ( array ) $this->errormsg );
		exit ();
	}
	public function checkargs($key = null) {
		if ($key == null) {
			return;
		}
		$allowArr = $this->allowAction [$key];
		foreach ( $allowArr as $k => $v ) {
			if (empty ( $_REQUEST [$k] ) && $v == 1) {
				return false;
			}
		}
		return true;
	}
	protected function getVideoDataImg($link) {
		$id = str_replace ( 'http://player.youku.com/player.php/sid/', '', $link );
		$id = str_replace ( '/v.swf', '', $id );
		$url = 'http://v.youku.com/player/getPlayList/VideoIDS/' . $id . '/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
		$json = file_get_contents ( $url );
		
		$data = json_decode ( $json );
		$datatmp = $data->data [0];
		
		return @$datatmp->logo;
	}
	protected function getCountCommentsByType($id, $type) {
		$result = array ();
		$sql = "select count(*) as nums from ai_comments where parent_type=$type and parent_id=" . $id;
		// $sql = "select * from ai_video_comments where pid=".$id;
		$result = C_mysqlAll ( $sql );
		
		return ! empty ( $result [0] ['nums'] ) ? $result [0] ['nums'] : 0;
	}
	protected function getUserFace($uid, $size) {
		$size = ($size) ? $size : 'm';
		if ($size == 'm') {
			$type = 'middle';
		} elseif ($size == 's') {
			$type = 'small';
		} else {
			$type = 'big';
		}
		$imgtpye = C_mysqlAll ( "select upic_type from ai_user where uid='" . $uid . "'" );

		$uid_to_path = '/' . $uid;
		$userface = $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		if ($imgtpye [0] ['upic_type'] == 1) {
			return $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		} else {
			$apiImg = C_mysqlAll ( "select profileImageUrl from ai_others where uid='" . $uid . "' and profileImageUrl!=''" );
			if (! empty ( $apiImg )) {
				$userface = $apiImg [0] ['profileImageUrl'];
				return $userface;
			}
			return $this->baseUrl . "/images/user_pic_{$type}.gif";
		}
	}
	protected function getUserName($uid) {
		$username = C_mysqlAll ( "select uname from ai_user where uid=$uid" );
		return $username [0] ['uname'];
	}
	public function getDailyLimit($channel, $limit, $nums) {
		if ($channel != '') {
			$sql = "select d.channel,d.id,d.title,d.img,d.content,d.create_time,d.gotime,d.like,d.unlike,d.read_count,v.id as vid,v.title as vtitle,v.link,v.wapurl,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.channel=" . $channel . " and d.gotime<" . strtotime ( date ( "Y-m-d", time () ) ) . " ORDER BY d.gotime DESC  limit " . $limit . "," . $nums . " ";
		} else {
			$sql = "select d.channel,d.id,d.title,d.img,d.content,d.create_time,d.gotime,d.like,d.unlike,d.read_count,v.id as vid,v.title as vtitle,v.link,v.wapurl,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.gotime<" . strtotime ( date ( "Y-m-d", time () ) ) . " ORDER BY d.gotime DESC  limit " . $limit . "," . $nums . " ";
		}
		$daily = null;
		$daily = $this->getDataCache ( md5 ( $sql ) );
		if (empty ( $daily )) {
			$result = C_mysqlAll ( $sql );
			$daily = array ();
			foreach ( $result as $key => $r ) {
				$daily [$key] = array ();
				$info ['img'] = $this->getVideoDataImg ( $r ['link'] );
				if ($daily [$key]) {
					$daily [$key] ['video'] [] = array (
							'id' => $r ['vid'],
							'title' => $r ['vtitle'],
							'link' => ($r ['link'] != 'null' ? $r ['link'] : ''),
							'wapurl' => ($r ['wapurl'] != 'null' ? $r ['wapurl'] : ''),
							'intro' => $r ['intro'],
							'img' => $info ['img'],
							'read_count' => $r ['read_count'] 
					);
				} else {
					$daily [$key] ['article'] = array (
							'id' => $r ['id'],
							'channel' => $r ['channel'],
							'title' => $r ['title'],
							'img' => $r ['img'],
							'content' => $r ['content'],
							'ctime' => $r ['create_time'],
							'gotime' => $r ['gotime'],
							'like' => $r ['like'],
							'unlike' => $r ['unlike'],
							'read_count' => $r ['read_count'] 
					);
					$daily [$key] ['video'] [] = array (
							'id' => $r ['vid'],
							'title' => $r ['vtitle'],
							'link' => ($r ['link'] != 'null' ? $r ['link'] : ''),
							'wapurl' => ($r ['wapurl'] != 'null' ? $r ['wapurl'] : ''),
							'intro' => $r ['intro'],
							'img' => $info ['img'] 
					);
				}
			}
			$this->setDataCache ( md5 ( $sql ), $daily );
		}
		
		foreach ( $daily as $key => $value ) {
			$daily [$key] ['commentsList'] = $this->getDailyComments ( $value ['article'] ['id'] );
			$daily [$key] ['commentCount'] = ( string ) $this->getCountCommentsByType ( $value ['article'] ['id'], 4 );
		}
		
		foreach ( $daily as $k => $value ) {
			$dailyTmp [] = $value;
		}
		return $dailyTmp;
	}
	protected function getDailyComments($id) {
		$sql = "select id,content,uid from ai_comments where parent_type='4' and parent_id=" . $id;
		$result = C_mysqlAll ( $sql );
		$comments = array ();
		if (! empty ( $result )) {
			foreach ( $result as $r ) {
				$comments [$r ['id']] = $r;
				// $comments[$r['id']]['userInfo'] = getUserInfo($r['uid']);
				$comments [$r ['id']] ['userimg'] = $this->getUserFace ( $r ['uid'], 'm' );
				$comments [$r ['id']] ['username'] = $this->getUserName ( $r ['uid'] );
			}
		}
		return ! empty ( $comments ) ? $comments : "NULL";
	}
	protected function _postCurlRegister($data) {
		$url = 'http://www.aijianmei.com/shop/user.php';
		$post_data = array (
				'password' => $data ['password'],
				'username' => $data ['uname'],
				'email' => $data ['email'],
				'confirm_password' => $data ['password'],
				'act' => 'act_register',
				'back_act' => '',
				'agreement' => 1 
		);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
	}
	public function getDataCache($key) {
		$cachefile = dirname ( dirname ( __FILE__ ) ) . "/DBCache/$key.php";
		if (is_file ( $cachefile )) {
			$data = null;
			$data = $this->mb_unserialize ( include ($cachefile) );
			return $data;
		}
		return '';
	}
	public function setDataCache($key, $data) {
		file_put_contents ( dirname ( dirname ( __FILE__ ) ) . "/DBCache/$key.php", "<?php\n\r return '" . serialize ( $data ) . "';" );
	}
	public function mb_unserialize($serial_str) {
		$serial_str = preg_replace ( '!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
		$serial_str = str_replace ( "\r", "", $serial_str );
		return unserialize ( $serial_str );
	}
	function updatePWUname($ouname, $email, $newname) {
		$sql = "select * from ai_pwforum.pw_user where username =  '" . $newname . "'  and email='" . $email . "'";
		$olduserinfo = C_mysqlOne ( $sql );
		// 用户表更新
		$sql = "UPDATE  ai_pwforum.pw_user SET  username =  '" . $newname . "' WHERE username='" . $ouname . "' and email='" . $email . "'";
		C_mysqlOne ( $sql );
		// wind表更新
		$sql = "UPDATE  ai_pwforum.pw_windid_user SET  username =  '" . $newname . "' WHERE username='" . $ouname . "' and email='" . $email . "'";
		C_mysqlOne ( $sql );
		// bbs threads 更新
		$sql = "UPDATE  ai_pwforum.pw_bbs_forum_statistics SET lastpost_username='" . $newname . "' WHERE lastpost_username='" . $ouname . "'";
		C_mysqlOne ( $sql );
		// bbs
		$sql = "UPDATE  `ai_pwforum`.`pw_bbs_posts` SET  `created_username` ='" . $newname . "' WHERE  created_username ='" . $ouname . "'";
		C_mysqlOne ( $sql );
		
		$sql = "UPDATE `ai_pwforum`.`pw_bbs_threads` SET created_username ='" . $newname . "' WHERE  created_username ='" . $ouname . "'";
		C_mysqlOne ( $sql );
		
		$sql = "UPDATE `ai_pwforum`.`pw_bbs_threads` SET lastpost_username='" . $newname . "' WHERE lastpost_username='" . $ouname . "'";
		C_mysqlOne ( $sql );
	}
	public function getBmiById($uid) {
		$sql = $result = null;
		$sql = "SELECT body_weight,height FROM  ai_user_health_info WHERE uid=$uid ";
		$bmiinfo = C_mysqlOne ( $sql );
		if($bmiinfo [0] ['body_weight']==0||$bmiinfo [0] ['height']==0){
			return 0;
		}
		$bmi = $bmiinfo [0] ['body_weight'] / (($bmiinfo [0] ['height'] / 100) * ($bmiinfo [0] ['height'] / 100));
		return round ( $bmi, 2 );
	}
	public function Aimkdirs($dir) {
		if (! is_dir ( $dir )) {
			if (! $this->Aimkdirs ( dirname ( $dir ) )) {
				return false;
			}
			if (! mkdir ( $dir, 0777 )) {
				return false;
			}
		}
		return true;
	}

	protected function getUserHealthById($uid){
		$sql="select body_weight as weight,targetWeight,nowWeight,weightTime,targetTime from ai_user_health_info where uid=$uid";
		$data=C_mysqlAll($sql);
		if(empty($data)){
			$data[0]['weight']	    =0;
			$data[0]['targetWeight']=0;
			$data[0]['nowWeight'] 	=0;
			$data[0]['pertent'] 	=0;
			$data[0]['klu'] 		=0;
			$data[0]['isfitness']   =1;
			$data[0]['wtime'] 		=1;
			$data[0]['isfitness']   =1;
			$data[0]['weightTime']  =date("Y-m-d",time());
			$data[0]['targetTime']  =date("Y-m-d",time());
		}else{
			$prefino=$this->getWeigthPertent($data[0]['weight'],$data[0]['targetWeight'],$data[0]['nowWeight']);
			$data[0]['pertent']  	=round($prefino['pertent'],1);
			$data[0]['klu'] 		=$prefino['klu'];
			if($data[0]['klu']>0){
				$data[0]['isfitness']   =$data[0]['targetWeight']< $data[0]['weight'] ? 1 : 2;
			}else{
				$data[0]['klu']=abs($data[0]['klu']);
				$data[0]['isfitness']   =$data[0]['targetWeight']< $data[0]['weight'] ? 2 : 1;
			}
			$data[0]['weightTime']  =date("Y-m-d",$data[0]['weightTime']);
			$data[0]['targetTime']  =date("Y-m-d",$data[0]['targetTime']);
		}
		return $data[0];
	}
	protected function getWeigthPertent($weight,$targetWeight,$nowWeight){
		$pertent=0;
		if($targetWeight > $weight){//目标数值大于原始值 增重
			$klu=($targetWeight-$nowWeight)*7700;
				if($nowWeight < $weight){//当前数值 < 原始数值 无用功直接 0%
					$pertent=0;
				}else{//否则计算对应完成度的百分比
					$pertent = ($nowWeight-$weight) / ($targetWeight-$weight) * 100;
				}
				if($nowWeight > $targetWeight){//当前数值>目标的数值 则目标已经超标完成 直接是100%
					$pertent=100;
				}
			}else{//目标数值大于原始值 减肥
				$klu=($nowWeight-$targetWeight)*7700;
				if($nowWeight < $weight && $nowWeight > $targetWeight){//当前数值 < 原始数值  并且大于目标值 则 减肥有效果 仍需继续努力
					$pertent = ($weight-$nowWeight) / ($weight-$targetWeight) * 100;
				}elseif($nowWeight < $weight && $nowWeight < $targetWeight ){ //当前数值 小于原始值 并且小于目标值 减肥完美超额完成...估计要增肥了
					$pertent = 100;//完成度自然100..
				}elseif($nowWeight > $weight){//当前数值 > 原始数值  好吧你减肥失败了 增重成功了...完成度0 哭也没用啊 混蛋
					$pertent=0;
				}
			}
			return array( 'pertent' => $pertent,'klu'=> $klu);
		}
		protected function getActionIdByName($name) {
			$sql = $data = null;
			$name = ( string ) $name;
			$sql = "select * from ai_action_list where `name`='" . $name . "'";
			$data =C_mysqlOne( $sql );
			return ! empty ( $data ) ? $data [0] ['id'] : false;
		}
		protected function getDefaultActionList($uid){
		$sql="select * from ai_user_course_default_alist where uid=$uid";
		$data=C_mysqlAll($sql);
		$data[0]['actionList']=unserialize($data[0]['actionList']);
		foreach ($data[0]['actionList'] as $key => $value) {
			$tmpdata[$key]['name']=$value;
			$nameinfo=$this->getActionInfoByName($value);
			$tmpdata[$key]['id']=$nameinfo['id'];
		}
		return $tmpdata;
	}
	protected function getActionInfoByName($name){
		$sql="select * from ai_action_list where name like '%".$name."%'";
		$data=C_mysqlOne($sql);
		return $data[0];
	}
}

$api = new IosApi ();
echo $api->$_REQUEST ['auact'] ();
//var_dump($api);
//$api;
