<?php
header ( "charset=utf-8" );
session_start ();
error_reporting ( 0 );
define ( 'SITE_PATH', dirname ( dirname ( __FILE__ ) ) ); // 路径常量定义

$dbConfig = include_once ('../config.inc.php'); // 加载配置文件
define ( '_DBHOST', $dbConfig ['DB_HOST'] );
define ( '_DBUSER', $dbConfig ['DB_USER'] );
define ( '_DBPASSWORD', $dbConfig ['DB_PWD'] );
define ( '_DBNAME', $dbConfig ['DB_NAME'] );
include_once 'db.class.php';
include_once 'reimg.php';
include_once 'functions.php';
/*
 * 40004 对应方法不存在 40003 动作标识错误 40001 非允许动作标识
 */
class Ajax {
	protected $allowAction = array (
		'setUserLogImg',
		'postUserCourseInfo',
		'getCourseInfo',
		'postWeightInfo',
		'postUserLogPic',
		'getUserLogImage',
		'getUserLog',
		'postUserDefaultAction',
		'getDefaultUserLineData',
		'getUserLogAllInfo',
		);
	protected $ttf = 'FZSJSJW.TTF';
	public function __construct() {
		$this->mid=intval($_SESSION['mid']);
		@$doAction = $_REQUEST ['act'] ? ( string ) $_REQUEST ['act'] : die ( 40003 );
		$this->db = new ckmysql ();
		$this->checkRequest ();
		if (! in_array ( $doAction, $this->allowAction ))
			die ( 40001 );
		return $this;
	}
	public function __call($name, $args) {
		die ( 40004 );
	}
	public function getDefaultUserLineData(){
		if(!$this->mid>0) die();
		$uid=$this->mid;
		$date=$group=null;
		$nowDate		=date('Ymd',time());
		@$date 			=$_POST['date'] ? $_POST['date']: $nowDate;
		@$group 		=$_POST['group'] ? $_POST['group'] :1;
		@$selectTagType =$_POST['selectTagType'] ? $_POST['selectTagType'] :7;
		@$aid			=$_POST['aid'] ? $this->getActionIdByName ( $_POST ['aid'] ):$this->getUserFaid($uid);
		$allDate    	=$this->generateFormatDate($date,$selectTagType);
		$startDate  	=$allDate['startDate'];
		$endDate		=$allDate['endDate'];
		if($selectTagType=='365'){
			@$timeList   	=getMonthsList($date);
		}else{
			@$timeList   	=$this->generateTimeList($startDate,$endDate);
		}
		
		//var_dump($timeList);
		$sql 		="select * from ai_user_course_list where `date`>='".$startDate."' and `date`<='".$endDate."' and `uid`=$uid and `group`=$group and `aid`=$aid";
		//if($selectTagType>7){echo $sql;}
		$data 	= $this->db->_query($sql);

		$resData=null;
		foreach ($data as $key => $value) {
			$resData[$value['date']]=unserialize($value['loginfo']);
		}
		if($selectTagType=='365'){
			$resData 	= $this->sumLineData($resData);
		}
		//var_dump(expression)
		$max=$this->getArrayMax($resData)+10;

		foreach ($timeList as $key => $value) {
			if(@$_POST['out']=='obj'){
				$keynum=0;
				$keynum=$key+1;
				if($selectTagType=='7'){
					if(empty($resData[$value]['time'])) $resData[$value]['time']=0;
					@$timelistString[]=date('md',strtotime($value));
				}else{
					@$timelistString[]=$keynum;
				}
				if(empty($resData[$value]['nums'])) $resData[$value]['nums']=0;
				if(empty($resData[$value]['weight'])) $resData[$value]['weight']=0;
				if(empty($resData[$value]['time'])) $resData[$value]['time']=0;
				$numsString[]=$resData[$value]['nums'];
				$weightString[]=$resData[$value]['weight'];
				$timeString[]=$resData[$value]['time'];
			}else{

				if(empty($resData[$value]['nums'])) $resData[$value]['nums']=0;
				@$numsString.=empty($numsString)? '"'.$resData[$value]['nums'].'"' : ',"'.$resData[$value]['nums'].'"';

				if(empty($resData[$value]['weight'])) $resData[$value]['weight']=0;
				@$weightString.=empty($weightString)? '"'.$resData[$value]['weight'].'"' : ',"'.$resData[$value]['weight'].'"';

				if(empty($resData[$value]['time'])) $resData[$value]['time']=0;
				@$timeString.=empty($timeString)? '"'.$resData[$value]['time'].'"' : ',"'.$resData[$value]['time'].'"';
				@$timelistString.=empty($timelistString)? '"'.date('md',strtotime($value)).'"':',"'.date('md',strtotime($value)).'"';
			}
		}
		if(@$_POST['out']!='obj'){
			echo $this->generateFormatString(array('nums' => $numsString,'weight' => $weightString,'ctime' => $timeString,'timelist' => $timelistString,'max'=>$max));
		}else{
			//echo $sql;
			$ndata['nums']=$numsString;
			$ndata['weight']=$weightString;
			$ndata['ctime']=$timeString;
			$ndata['timelist']=$timelistString;
			$ndata['max']=$max;
			echo json_encode($ndata);
		}
		//echo $numsString;
		exit;

	}
	protected function sumLineData($data){
		$result=array();
		foreach ($data as $key => &$value) {
			$newkey=substr($key, 0,6);
			$result[$newkey]['nums']+=$value['nums'];
			$result[$newkey]['weight']+=$value['weight'];
			$result[$newkey]['time']+=$value['time'];
		}
		return $result;
	}
	public function postUserDefaultAction(){
		if(!$this->mid>0) die();
		$uid=$this->mid;
		$DateString=explode(",", (string)$_POST['DateString']);
		krsort($DateString);
		$DateString=serialize($DateString);
		$sql="INSERT INTO ai_user_course_default_alist VALUES('".$uid."','".$DateString."') ON DUPLICATE KEY UPDATE actionList='".$DateString."'";
		$this->db->_query($sql);
		exit;
	}

	public function getUserLogAllInfo(){
		$baseDir=dirname(dirname(__FILE__));
		$data=$res=$edate=$sdate=$uid=null;
		$nowDate	=date('Ymd',time());
		$date 		=$_POST['date'] ? $_POST['date']: $nowDate;
		$edate      =$this->reNorTime(1,strtotime($date));
		$sdate      =$this->reNorTime(-1,strtotime($date));
		$uid=$this->mid;
		$sql="select * from ai_user_course_log_image where date>=$sdate and date<=$edate and uid=$uid";
		$res=$this->db->_query($sql);
		$data['default']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		$data['next']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		$data['pre']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==$date){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['default']['date']=$date;
				}elseif($value['date']==$edate){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['next']['date']=$edate;
				}elseif ($value['date']==$sdate) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['pre']['date']=$sdate;
				}
			}
		}
		$json['imageInfo']=$data;

		//-----------------------------------------------------------------------------------

		$baseDir=dirname(dirname(__FILE__));
		$data=$res=$edate=$sdate=$uid=null;
		$edate=$this->reNorTime(1,strtotime($date));
		$sdate=$this->reNorTime(-1,strtotime($date));
		$uid=$this->mid;
		$sql="select * from ai_user_course_log where date>=$sdate and date<=$edate and uid=$uid";
		$res=$this->db->_query($sql);
		$data['default']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		$data['next']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		$data['pre']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==$date){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['default']['date']=$date;
				}elseif($value['date']==$edate){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['next']['date']=$edate;
				}elseif ($value['date']==$sdate) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['pre']['date']=$sdate;
				}
			}
		}
		$json['logInfo']=$data;
		echo json_encode($json);exit;
		//return !empty($data) ? $data :'';
	}
	public function getUserLogImage(){
		if(!$this->mid>0) die();
		$baseDir=dirname(dirname(__FILE__));
		$uid=$this->mid;
		$date=!empty($_POST['date'])? intval($_POST['date']):die(40003);
		$dataType=!empty($_POST['dataType'])? intval($_POST['dataType']):die(40003);
		$nowDate=date('Ymd',strtotime($date));
		$startDate	=$this->reNorTime(-1,strtotime($date));
		$endDate	=$this->reNorTime(1,strtotime($date));
		$sql="select * from ai_user_course_log_image where date>=$startDate and date<=$endDate and uid=$uid";
		$res=$this->db->_query($sql);
		$data['default']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		$data['default']['date']=$nowDate;
		$data['next']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		$data['next']['date']=$startDate;
		$data['pre']['image']='/Templates/tool/images/tool/pic.png?'.rand();
		$data['pre']['date']=$endDate;
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==$nowDate){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['default']['date']=$nowDate;
				}elseif($value['date']==$startDate){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['next']['date']=$startDate;
				}elseif ($value['date']==$endDate) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']."?".rand():'/Templates/tool/images/tool/pic.png';
					$data['pre']['date']=$endDate;
				}
			}
		}
		//$data=$this->reBuildData($dataType,$data,$nowDate);
		echo json_encode($data);
		exit;
	}
	public function getUserLog(){

		if(!$this->mid>0) die();
		$baseDir=dirname(dirname(__FILE__));
		$uid=$this->mid;
		$date=!empty($_POST['date'])? intval($_POST['date']):die(40003);
		$dataType=!empty($_POST['dataType'])? intval($_POST['dataType']):die(40003);
		$nowDate=date('Ymd',strtotime($date));
		$startDate	=$this->reNorTime(-1,strtotime($date));
		$endDate	=$this->reNorTime(1,strtotime($date));
		$sql="select * from ai_user_course_log where date>=$startDate and date<=$endDate and uid=$uid";
		$res=$this->db->_query($sql);
		$data['default']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		$data['default']['date']=$nowDate;
		$data['next']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		$data['next']['date']=$startDate;
		$data['pre']['image']='/Templates/tool/images/tool/rj_1.png?'.rand();
		$data['pre']['date']=$endDate;
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==$nowDate){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']."?".rand():'/Templates/tool/images/tool/rj_1.png';
					$data['default']['date']=$nowDate;
				}elseif($value['date']==$startDate){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']."?".rand():'/Templates/tool/images/tool/rj_1.png';
					$data['next']['date']=$startDate;
				}elseif ($value['date']==$endDate) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']."?".rand():'/Templates/tool/images/tool/rj_1.png';
					$data['pre']['date']=$endDate;
				}
			}
		}
		//$data=$this->reBuildData($dataType,$data,$nowDate);
		echo json_encode($data);
		exit;
	}
	public function postUserLogPic(){
		if(!$this->mid>0) die();
		$uid=$this->mid;
		$targetFile="/public/images/userLogImage/".time().rand().".jpg";
		$date=$_POST['date']?intval($_POST['date']):die(40001);
		move_uploaded_file($_FILES['img']['tmp_name'],SITE_PATH.$targetFile);
		$resize = new ResizeImage(SITE_PATH.$targetFile);
		$resize->resizeTo(450, 300,'exact');
		$resize->saveImage(SITE_PATH.$targetFile);
		$checkSql="select * from ai_user_course_log_image where `uid`='".$uid."' and `date`='".$date."'";
		$checkData=$this->db->_query($checkSql);
		if(empty($checkData)){
			$insertSql="INSERT INTO `ai_user_course_log_image` (`id` ,`uid` ,`date` ,`image` ,`create_time`)
			VALUES (NULL ,  '".$uid."',  '".$date."',  '".$targetFile."',  '".time()."')";
			$this->db->_query($insertSql);		
		}else{
			$updateSql="UPDATE `ai_user_course_log_image` SET `image`='".$targetFile."'
			WHERE `uid` ='".$uid."' and date='".$date."'";
			$this->db->_query($updateSql);	
		}
		
		ob_end_clean ();
		echo "<textarea>".$targetFile."?".rand()."</textarea>";
		exit ();
	}
	public function postWeightInfo(){
		$uid=$_SESSION['mid'];
		if(!$uid > 0) die();
		$weight=intval($_POST['weight']);
		$targetWeight=intval($_POST['tweight']);
		$nowWeight=intval($_POST['nweight']);
		$checkSql="select * from ai_user_health_info where `uid` =$uid";
		$checkResult=$this->db->_query($checkSql);
		if(!empty($checkResult)){
			$updateSql="UPDATE  ai_user_health_info SET `body_weight` =  '".$weight."',
			`targetWeight` =  '".$targetWeight."',`nowWeight`='".$nowWeight."',`targetTime` =  '".time()."'
			WHERE `uid` =$uid LIMIT 1 ";
			$this->db->_query($updateSql);
		}else{
			$insertSql="INSERT INTO  ai_user_health_info (`uid` ,`body_weight` ,`height` ,`age` ,`targetWeight` ,`nowWeight` 
				,`weightTime` ,`targetTime`)VALUES ('".$uid."','".$weight."','0','0','".$targetWeight."','".$nowWeight."','".time()."','".time()."')";
$this->db->_query($updateSql);
}
		if($targetWeight > $weight){//目标数值大于原始值 增重
			$calorie=($targetWeight-$nowWeight)*7700;
		}else{
			$calorie=($nowWeight-$targetWeight)*7700;
		}
		$data['status']=1;
		$data['calorie']=$calorie;
		echo json_encode($data);
		exit;
	}
	public function getCourseInfo() {
		$uid = $_REQUEST ['uid'];
		
		$aid = $this->getActionIdByName ( $_REQUEST ['aid'] );
		if (! $aid) {
			die ();
		}
		$date = date ( "Ymd", strtotime ( str_replace ( ".", "-", $_REQUEST ['date'] ) ) );
		$sq = null;
		$sql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`=$date";
		$data = $this->db->_query ( $sql );
		$resultHtml=null;
		if (! empty ( $data )) {
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$colorCss= ($k+1)%2==0 ?'evenRow':'oddRow';
				$resultHtml.= '<div class="actGroup actGroupKon '.$colorCss.' clearfix"><div class="col1 col">第'.$this->num2Char($k+1).'组</div><div class="col2 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['nums'].'" name="nums[]" class="figure" readonly/><span class="add"></span></div><div class="col3 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['weight'].'" name="weight[]" class="figure" readonly/><span class="add"></span></div><div class="col4 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['time'].'" name="time[]" class="figure" readonly/><span class="add"></span></div></div>';
			}
			echo  $resultHtml ;
		} else {
			$data[0]['loginfo']['nums']=0;
			$data[0]['loginfo']['weight']=0;
			$data[0]['loginfo']['time']=0;
			$data[0]['cnum'] ='一';
			$data[1]['loginfo']['nums']=0;
			$data[1]['loginfo']['weight']=0;
			$data[1]['loginfo']['time']=0;
			$data[1]['cnum'] ='二';
			$data[2]['loginfo']['nums']=0;
			$data[2]['loginfo']['weight']=0;
			$data[2]['loginfo']['time']=0;
			$data[2]['cnum'] ='三';
			$data[3]['loginfo']['nums']=0;
			$data[3]['loginfo']['weight']=0;
			$data[3]['loginfo']['time']=0;
			$data[3]['cnum'] ='四';
			foreach ( $data as $k => &$value ) {
				$colorCss= ($k+1)%2==0 ?'evenRow':'oddRow';
				$resultHtml.='<div class="actGroup actGroupKon '.$colorCss.' clearfix"><div class="col1 col">第'.$this->num2Char($k+1).'组</div><div class="col2 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['nums'].'" name="nums[]" class="figure" readonly/><span class="add"></span></div><div class="col3 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['weight'].'" name="weight[]" class="figure" readonly/><span class="add"></span></div><div class="col4 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['time'].'" name="time[]" class="figure" readonly/><span class="add"></span></div></div>';
			}
			echo $resultHtml;
		}
		exit ();
	}
	public function postUserCourseInfo() {
		$uid = $_REQUEST ['uid'];
		$aid = $this->getActionIdByName ( $_REQUEST ['aid'] );
		$date = date ( "Ymd", strtotime ( str_replace ( ".", "-", $_REQUEST ['date'] ) ) );
		$this->checkUserId ( $uid );

		foreach ( $_POST ['nums'] as $key => $value ) {
			$loginfo = null;
			$group = $key + 1;
			// $date = date ( 'Ymd', strtotime ( $date ) );
			$loginfo ['nums'] = intval ( $value );
			$loginfo ['weight'] = intval ( $_POST ['weight'] [$key] );
			$loginfo ['time'] = intval ( $_POST ['time'] [$key] );
			$loginfo = serialize ( $loginfo );
			$checkSql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid and `group`=$group and `date`=$date";
			$checkData = $this->db->_query ( $checkSql );
			if (empty ( $checkData )) {
				$insertSql = "INSERT INTO ai_user_course_list (`id` ,`uid` ,`aid` ,`date` ,`loginfo` ,`create_time` ,`group`)
				VALUES (NULL ,  '" . $uid . "',  '" . $aid . "',  '" . $date . "',  '" . $loginfo . "', '" . time () . "',  '" . $group . "')";
				$this->db->_query ( $insertSql );
			} else {
				$updateSql = "UPDATE ai_user_course_list SET  loginfo ='" . $loginfo . "',`create_time` = '" . time () . "' where  `uid`=$uid and `aid`=$aid and `group`=$group and `date`=$date";
				$this->db->_query ( $updateSql );
			}
		}
		// print_r($_REQUEST);
		exit ();
	}
	protected function getActionIdByName($name) {
		$sql = $data = null;
		$name = ( string ) $name;
		$sql = "select * from ai_action_list where `name`='" . $name . "'";
		$data = $this->db->_query ( $sql );
		return ! empty ( $data ) ? $data [0] ['id'] : false;
	}
	protected function checkUserId($uid) {
		if ($uid == $_SESSION ['mid']) {
			return true;
		} else {
			die ( 40003 );
		}
		exit ();
	}
	public function setUserLogImg() {
		$text = $_POST ['writeLog'];
		$date=$_POST['date']?intval($_POST['date']):die(40001);
		$sizeArray = array (
			18,
			466,
			313 
			);
		$uid = $this->mid;
		//$targetFile='a.png';
		$targetFile="/public/images/userLog/".time().rand().".jpg";
		$this->generatePngByFont ( $text, $sizeArray, $uid, SITE_PATH.$targetFile, 'bgImg.png' );

		$checkSql="select * from ai_user_course_log where `uid`='".$uid."' and `date`='".$date."'";
		$checkData=$this->db->_query($checkSql);
		if(empty($checkData)){
			$insertSql="INSERT INTO `ai_user_course_log` (`id` ,`uid` ,`date` ,`image` ,`create_time`)
			VALUES (NULL ,  '".$uid."',  '".$date."',  '".$targetFile."',  '".time()."')";
			$this->db->_query($insertSql);		
		}else{
			$updateSql="UPDATE `ai_user_course_log` SET `image`='".$targetFile."'
			WHERE `uid` ='".$uid."' and date='".$date."'";
			$this->db->_query($updateSql);	
		}
		ob_end_clean ();
		echo json_encode($targetFile);
		exit ();
	}
	protected function getImgSize($path) {
		if (! is_file ( $path ))
			return false;
		$sizeData = array ();
		$sizeData = getimagesize ( $path );
		return array_slice ( $sizeData, 0, 2 );
	}
	protected function checkRequest() {
		if (! empty ( $_REQUEST ['auact'] )) {
			foreach ( $_REQUEST as $key => $value ) {
				$_REQUEST [$key] = $this->MooAddslashes ( $value );
			}
			foreach ( $_POST as $key => $value ) {
				$_POST [$key] = MooAddslashes ( $value );
			}
			foreach ( $_GET as $key => $value ) {
				$_GET [$key] = MooAddslashes ( $value );
			}
		}
	}
	// addcslashes
	protected function MooAddslashes($value) {
		$value = preg_replace ( "/<[^><]*script[^><]*>/i", '', $value );
		$value = preg_replace ( "/<[\/\!]*?[^<>]*?>/si", '', $value );
		return $value = is_array ( $value ) ? array_map ( 'MooAddslashes', $value ) : addslashes ( $value );
	}
	// 编码转化utf8
	protected function toUtf8($string) {
		if (empty ( $string ))
			return false;
		return iconv ( 'GB2312', 'UTF-8', $string );
	}
	protected function generateFontWith($string, $size) {
		if (empty ( $string ))
			return false;
		$f = $b = null;
		$f = $this->ttf;
		$b = imagettfbbox ( $size, 0, $f, $string );
		return $b [2] - $b [0];
	}
	protected function formatFontString($string, $nums) {
		mb_internal_encoding ( 'UTF-8' );
		$data = array ();
		$nstr = null;
		$offet = 0;
		if (strlen ( $string ) > $nums) {
			while ( strlen ( $string ) > $nums ) :
				$nstr = mb_strcut ( $string, $offet, $nums );
			$offet = strlen ( $nstr );
			$string = substr ( $string, $offet );
			$data [] = $nstr;
			endwhile
			;
			$data = implode ( "\n", $data );
		} else {
			$data = $string;
		}
		return $data;
	}
	public function getUserFaid($uid){
		$defaultActionList=$this->getDefaultActionList($uid);
		if(empty($defaultActionList)){
			$actionList=$this->getRecommendActionList();
			$faid=intval($actionList[0]['id']);
		}else{
			$actionList=$defaultActionList;
			$faid=intval($actionList[0]['id']);
		}
		return $faid;
	}

	protected function getDefaultActionList($uid){
		$sql="select * from ai_user_course_default_alist where uid=$uid";
		$data=$this->db->_query($sql);
		$data[0]['actionList']=unserialize($data[0]['actionList']);

		foreach ($data[0]['actionList'] as $key => $value) {
			$tmpdata[$key]['name']=$value;
			$nameinfo=$this->getActionInfoByName($value);
			$tmpdata[$key]['id']=$nameinfo['id'];
		}
		return $tmpdata;
	}
	protected function getRecommendActionList(){
		$sql="select * from ai_action_list where recommend=1";
		$data=$this->db->_query($sql);
		return $data;
	}
	protected function getActionInfoByName($name){
		$sql="select * from ai_action_list where name like '%".$name."%'";
		$data=$this->db->_query($sql);
		return $data[0];
	}

	protected function reBuildData($dataType,$data,$date=null){
		$dtmp=$data['default'];$ptmp=$data['pre'];$ntmp=$data['next'];
		if($dataType=="pre"){
			$data['default']=$ptmp;
			$data['pre']=$dtmp;
			$data['next']=$ntmp;
			$data['next']['date']=date('Ymd',strtotime($date)-(24*3600));
		}
		/*if($dataType=="next"){
			$data['default']=$ntmp;
			$data['pre']=$dtmp;
			$data['next']=$ptmp;
			$data['pre']['date']=date('Ymd',strtotime($date)-(24*3600));
		}*/
		return $data;
	}
	protected function num2Char($num){
		$charArr = array('1' =>'一' , '2' => '二','3' => '三' ,'4' => '四' ,'5' => '五' ,'6' => '六' ,
			'7' => '七' , '8' => '八', '9' => '九' );
		return !empty($num)?$charArr[$num]:$num;
	}
	protected function reNorTime($k=0,$cdate=null){
		if($k!=0&&$k>0){
			$timeDate=0;
			$cdate= !empty($cdate) ? $cdate : time();
			$timeDate=$cdate + ($k*3600*24);

		}elseif($k!=0&&$k<0){
			$timeDate=0;
			$cdate= !empty($cdate) ? $cdate : time();
			$timeDate=$cdate - abs($k*3600*24);
		}else{
			$timeDate= !empty($cdate) ? $cdate : time();

		}
		return date("Ymd",$timeDate);
	}
	public function getArrayMax($data){
		static $max=0;
		foreach ($data as $key => $value) {
			if(is_array($value)){
				$this->getArrayMax($value,$max);
			}else{
				$max = ($max > intval($value)) ? $max : intval($value);
			}
		}

		return $max;
	}

	protected function generateFormatDate($date,$format){
		$nowDate=date('Ymd',time());
		$format=intval($format);
		if($format==7||$format==30){		
			$endDate=$date;
			$startDate=$this->reNorTime((-$format)+1,strtotime($date));
		}
		if($format==365){
			$allDateInfo=getMonthsList($date);
			$startDate=$allDateInfo[1]."01";
			$endDate=$allDateInfo[12]."31";
		}
		return array('startDate' =>$startDate ,'endDate' => $endDate);
	}
	protected function generateTimeList($startDate,$endDate,$timeFormat='Ymd'){
		$startDate = strtotime($startDate); 
		$endDate   = strtotime($endDate);
		$date      = null;
		for($i=$startDate; $i<=$endDate;$i+=(24*3600)) 
		{

			$date[]=date($timeFormat,$i);
		}
		return $date; 
	}

	protected function generateFormatString($data){
		$format="{\"lineData\":[{\"line\":[%s]},{\"line\":[%s]},{
			\"line\":[%s]}],\"ticks\":[%s],\"max\":[%s]}";
			return sprintf($format,$data['nums'],$data['weight'],$data['ctime'],$data['timelist'],$data['max']);
		}
	// 生成文字日记图片
		protected function generatePngByFont($text, $sizeArray, $uid, $savePath = null, $backImg = null) {
			if (empty ( $text ) || ! ($uid > 0))
				return false;
			$fontSize = $sizeArray [0];
			$imgWidth = $sizeArray [1];
			$imgHeight = $sizeArray [2];
			$savePath = ! empty ( $savePath ) ? ( string ) $savePath : '';
		// 字体类型，瘦金体
			$font = $this->ttf;

			$text = $this->formatFontString ( $text, 54 );

		// $winfo=$this->generateFontWith($text,18);

		// exit;
		// 创建一个长为500高为80的空白图片
			$img = imagecreate ( $imgWidth, $imgHeight );

			if (! empty ( $backImg )) {
				$backImgSize = $this->getImgSize ( $backImg );
			$simage = imagecreatefrompng ( $backImg ); // 读取我们的背景图片
			                                           // imagecopy($img,$simage,0,0,0,0,466,313);
			imagecopy ( $img, $simage, 0, 0, 0, 0, $backImgSize [0], $backImgSize [1] );
		}
		
		// 给图片分配颜色
		// imagecolorallocate($img, 100, 200, 100);
		// 设置字体颜色
		$black = imagecolorallocate ( $img, 0, 0, 0 );
		// 将ttf文字写到图片中
		imagettftext ( $img, $fontSize, 0, 13, 32, $black, $font, $text );
		// 发送头信息
		// header('Content-Type: image/png');
		// 输出图片
		// imagegif($img);
		// Imagepng($img);
		if (! empty ( $savePath )) {
			Imagepng ( $img, $savePath );
		}
		ImageDestroy ( $img );
	}

}

$_CI = new Ajax ();
$_CI->$_REQUEST ['act'] ();
exit ();