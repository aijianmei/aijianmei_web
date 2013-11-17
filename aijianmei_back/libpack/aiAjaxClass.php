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
		'deleteUserCourseInfo',
		'getUserRankByAid',
		'getUserConsumeCalories',
		'showChartPage',
		);
	protected $ttf = 'FZSJSJW.TTF';
	protected $baseUrl = 'http://www.kon_aijianmei.com';
	public function __construct() {
		$this->mid=intval($_SESSION['mid']);
		@$doAction = $_REQUEST ['act'] ? ( string ) $_REQUEST ['act'] : die ( 40003 );
		$this->db = new ckmysql ();
		$this->comfunc = new comfunc ();
		$this->checkRequest ();
		if (! in_array ( $doAction, $this->allowAction ))
			die ( 40001 );
		return $this;
	}
	public function __call($name, $args) {
		die ( 40004 );
	}
	/**
	 * [getUserConsumeCalories 返回用户当前消耗卡路里数量]
	 * @return int 
	 */
	public function getUserConsumeCalories(){
		$uid=$_REQUEST['uid'] ?intval($_REQUEST['uid']):0;
		$this->checkUserId( $uid );
		$date=$_REQUEST['date'] ?intval($_REQUEST['date']):0;
		$sql="select * from ai_user_course_list where `uid`=$uid and `date`=$date";

	}
	public function getUserRankByAid(){
		$aid      =$_REQUEST['aid']?(string)$_REQUEST['aid']:die(40001);
		$aid      =$this->getActionInfoByName($aid);
		$aid  	  =$aid['id'];

		$this->mid!=$_REQUEST['uid'] ? die(40001) : $uid=$this->mid;

		$duserRankList    	=$this->getUserRank('',$aid);
		$duserRankList_7  	=$this->getUserRank(7,$aid);
		$duserRankList_30 	=$this->getUserRank(30,$aid);
		$duserRankList_all	=$this->getUserRank('',$aid,true);

		$duserRankNum 		=$this->getUserRankById($uid,'',$aid);
		$duserRankNum7 		=$this->getUserRankById($uid,7,$aid);
		$duserRankNum30 	=$this->getUserRankById($uid,30,$aid);
		$duserRankNumall 	=$this->getUserRankById($uid,'',$aid,true);

		$data['duserRankList']     =$duserRankList;
		$data['duserRankList_7']   =$duserRankList_7;
		$data['duserRankList_30']  =$duserRankList_30;
		$data['duserRankList_all'] =$duserRankList_all;

		$data['duserRankNum'] 	   =$duserRankNum;
		$data['duserRankNum7'] 	   =$duserRankNum7;
		$data['duserRankNum30']    =$duserRankNum30;
		$data['duserRankNumall']   =$duserRankNumall;

		echo json_encode($data);
		exit;
	}
	public function getDefaultUserLineData(){
		if(!$this->mid>0) die();
		$uid=$this->mid;
		if($_GET['wap']==1){
			$uid=$_REQUEST['uid']?intval($_REQUEST['uid']):0;
		}
		$date=$group=null;
		$nowDate		=date('Ymd',time());
		@$date 			=$_REQUEST['date'] ? $_REQUEST['date']: $nowDate;
		@$group 		=$_REQUEST['group'] ? $_REQUEST['group'] :1;
		@$selectTagType =$_REQUEST['selectTagType'] ? $_REQUEST['selectTagType'] :7;
		if(!is_numeric($_REQUEST['aid'])){
			@$aid			=$_REQUEST['aid'] ? $this->getActionIdByName ( $_REQUEST ['aid'] ):$this->getUserFaid($uid);
		}else{
			$aid=intval($_REQUEST['aid']);
		}
		$allDate    	=$this->generateFormatDate($date,$selectTagType);
		$startDate  	=$allDate['startDate'];
		$endDate		=$allDate['endDate'];
		if($selectTagType=='365'){
			@$timeList  =getMonthsList($date);
		}else{
			@$timeList  =$this->generateTimeList($startDate,$endDate);
		}
		
		//var_dump($timeList);
		$sql 	="select * from ai_user_course_list where `date`>='".$startDate."' and `date`<='".$endDate."' and `uid`=$uid and `group`=$group and `aid`=$aid";
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
					@$timelistString[]=date("m.d",strtotime($value));

					//@$timelistString[]=$keynum;

				}elseif($selectTagType=='365'){
					@$timelistString[]=$keynum-1;
				}elseif($selectTagType=='30'){
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
				@$timelistString.=empty($timelistString)? '"'.date('m.d',strtotime($value)).'"':',"'.date('m.d',strtotime($value)).'"';
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

		$baseDir 		=dirname(dirname(__FILE__));
		$uid 			=$this->mid;
		$date    		=!empty($_POST['date'])? intval($_POST['date']):'';
		if(empty($date)) return '';
		$nowDate  		=date('Ymd',strtotime($date)-86400);
		$dateTabType	=$_POST['dateTabType']?intval($_POST['dateTabType']):1;
		if($dateTabType==1){
			$sql 			="select * from ai_user_course_log_image where date<=$nowDate and uid=$uid order by date desc limit 1";
			$res 			=$this->db->_query($sql);

			$data['date'] 	=$res['0']['date'] ?$res['0']['date'] : $nowDate;
			$data['image'] 	=$res['0']['image']?$res['0']['image']: '';
		}elseif($dateTabType==2){
			$sql    		="select * from ai_user_course_log where date<=$nowDate and uid=$uid order by date desc limit 1";
			$res 			=$this->db->_query($sql);

			$data['date'] 	=$res['0']['date'] ?$res['0']['date'] : $nowDate;
			$data['image'] 	=$res['0']['image']?$res['0']['image']: '';			
		}
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
		$date=date("Ymd",time());
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
		$weight=floatval($_POST['weight']);
		$targetWeight=floatval($_POST['tweight']);
		$nowWeight=floatval($_POST['nweight']);
		$checkSql="select * from ai_user_health_info where `uid` =$uid";
		$checkResult=$this->db->_query($checkSql);
		if(!empty($checkResult)){
			$updateSql="UPDATE  ai_user_health_info SET `body_weight` =  '".$weight."',
			`targetWeight` =  '".$targetWeight."',`nowWeight`='".$nowWeight."',`targetTime` =  '".time()."'
			WHERE `uid` =$uid LIMIT 1 ";
			$this->db->_query($updateSql);

			$updateSql="UPDATE  ai_user_health_info SET `weightTime` =  '".time()."' WHERE `uid` =$uid and weightTime IS NULL LIMIT 1 ";
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
			$countNums=count($data);
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$colorCss= ($k+1)%2==0 ?'evenRow':'oddRow';
				$resultHtml.='<div class="actGroup actGroupKon '.$colorCss.' clearfix"><button type="button" class="delBtn" style="display:block;"></button><div class="col1 col">第'.$this->num2Char($k+1).'组</div><div class="col2 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['nums'].'" name="nums[]" class="figure" readonly/><span class="add"></span></div><div class="col3 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['weight'].'" name="weight[]" class="figure" readonly/><span class="add"></span></div><div class="col4 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['time'].'" name="time[]" class="figure" readonly/><span class="add"></span></div><div class="col5 col">0</div></div>';
				$numCount		+=$value['loginfo']['nums'];
				$weightCount	+=$value['loginfo']['weight'];
				$timeCount		+=$value['loginfo']['time'];
			}
			$res['numsAvg'] 	=round($numCount/$countNums);
			$res['weigthAvg']   =round($weightCount/$countNums);
			$res['timeAvg'] 	=round($timeCount/$countNums);
			$res['beforeAvg']   =$this->getCourseInfoAvg($uid,$aid,$date);
			$res['html']        =$resultHtml ;
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
				$resultHtml.='<div class="actGroup actGroupKon '.$colorCss.' clearfix"><button type="button" class="delBtn" style="display:block;"></button><div class="col1 col">第'.$this->num2Char($k+1).'组</div><div class="col2 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['nums'].'" name="nums[]" class="figure" readonly/><span class="add"></span></div><div class="col3 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['weight'].'" name="weight[]" class="figure" readonly/><span class="add"></span></div><div class="col4 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['time'].'" name="time[]" class="figure" readonly/><span class="add"></span></div><div class="col5 col">0</div></div>';
			}
			$res['numsAvg'] 	=0;
			$res['weigthAvg']   =0;
			$res['timeAvg'] 	=0;
			$res['beforeAvg']   =$this->getCourseInfoAvg($uid,$aid,$date);
			$res['html']        =$resultHtml ;
		}
		echo json_encode($res);
		exit ();
	}
	public function postUserCourseInfo() {
		$uid = $_REQUEST ['uid'];
		$aid = $this->getActionIdByName ( $_REQUEST ['aid'] );
		$date = date ( "Ymd", strtotime ( str_replace ( ".", "-", $_REQUEST ['date'] ) ) );
		//$this->checkUserId ( $uid );

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
		$date=date("Ymd",time());
		$sizeArray = array (
			18,
			466,
			313 
			);
		$uid = $this->mid;
		//$targetFile='a.png';
		$targetFile="/public/images/userLog/".time().rand().".jpg";
		$this->generatePngByFont( $text, $sizeArray, $uid, SITE_PATH.$targetFile, 'bgImg.png' );

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
				$_POST [$key] = $this->MooAddslashes ( $value );
			}
			foreach ( $_GET as $key => $value ) {
				$_GET [$key] = $this->MooAddslashes ( $value );
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
	protected function formatFontString($string) {
		$encoding='UTF-8';
		mb_internal_encoding($encoding);
    	$has = array();
    	$stringlength =mb_strlen($string, $encoding);
    	if((strlen($string)+mb_strlen($string,'UTF8')) <72) return $string;
    	for($i=0;$i < $stringlength;$i++){
    		$c=null;
    		$c = mb_substr ($string, $i, 1 );
    		if(strlen($c)==3){
    			$nlong=$nlong+2;
    		}elseif (strlen($c)==1) {
    			$nlong=$nlong+1;
    		}
    		$nString.=$c;
    		if($nlong>=36){
    			$data[]  =$nString;
    			$nString ='';
    			$nlong=0;
    		}
    	}
		return implode("\n", $data);
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
		$sql="select * from ai_action_list where name='".$name."'";
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

			$text = $this->formatFontString( $text );

			//$text = $this->u8_title_substr($text, 430, '\n');

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

		//获取对应日期之前的平均值
	public function getCourseInfoAvg($uid,$aid,$date){
		$date= date("Ymd",strtotime($date)-86400);
		$sql=$countNums=$numCount=null;
		$rdata=$data=array();
		$sql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`<=$date";
		$data=$this->db->_query($sql);
		if (! empty ( $data )) {
			$countNums=count($data);
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$value ['cnum'] = $this->num2Char($k+1);
				$numCount+=$value ['loginfo']['nums'];
				$weightCount+=$value ['loginfo']['weight'];
				$timeCount+=$value ['loginfo']['time'];
			}
			$rdata['numsAvg'] 	=round($numCount/$countNums);
			$rdata['weigthAvg'] =round($weightCount/$countNums);
			$rdata['timeAvg'] 	=round($timeCount/$countNums);
		}else{
			$rdata['numsAvg'] ='0';
			$rdata['weigthAvg'] ='0';
			$rdata['timeAvg'] ='0';
		}
		return $rdata;
	}
	public function deleteUserCourseInfo(){
		$groupArr=array();
		$groupArr['1']     = "第一组";
		$groupArr['2']     = "第二组";
		$groupArr['3']     = "第三组";
		$groupArr['4']     = "第四组";
		$groupArr['5']     = "第五组";
		$groupArr['6']     = "第六组";
		$groupArr['7']     = "第七组";
		$uid=$this->mid;
		$groupName=$_REQUEST['groupName']?$_REQUEST['groupName']:die();
		$aid = $this->getActionIdByName ( $_REQUEST ['aid'] );
		$date = date ( "Ymd", strtotime ( str_replace ( ".", "-", $_REQUEST ['date'] ) ) );
		if($key=array_search($groupName, $groupArr)){
			$deleteSql="delete from `ai_user_course_list` where `uid`=$uid and `aid`=$aid and `group`=$key and `date`=$date";
			$this->db->_query($deleteSql);
			$updateSql="UPDATE `ai_user_course_list` SET `group`= `group`-1 WHERE `uid`=$uid and `aid`=$aid and `group`>$key and `date`=$date";
			$this->db->_query($updateSql);
		}
		exit;
	}
	//
	protected function getUserRank($dateType=null,$aid=null,$isAll=false){
		$dateString=$startTime=$endTime=$where=null;
		if(!empty($dateType)){
			$startTime    = date('Ymd',mktime(0, 0, 0, date("m"), date("d")-$dateType, date("Y")));
			$endTime      = date('Ymd',time());
			$where 		  = " WHERE date>='".$startTime."' and date<='".$endTime."'";
		}else{
			$where 		  = " WHERE date='".date('Ymd',time())."'";
		}
		if(!empty($aid)){
			$where=$where." and aid='".$aid."'";
		}
		if($isAll==true&&empty($aid)){$where=null;}
		if($isAll==true&&!empty($aid)){$where="where aid=$aid";}
		$getSql="SELECT SUM(  `exercise` ) AS exercise, uid FROM ai_user_exercise_log $where GROUP BY uid ORDER BY exercise DESC limit 10";
		$data=$this->db->_query($getSql);
		foreach ($data as $key => &$value) {
			$value['userFace']=$this->getUserFace($value['uid'],'m');
			$value['userName']=$this->getUserName($value['uid']);

		}
		return $data;
	}
	protected function getUserRankById($uid,$dateType=null,$aid=null,$isAll=false){
		$dateString=$startTime=$endTime=$where=null;
		if(!$uid) return false;
		if(!empty($dateType)){
			$startTime    = date('Ymd',mktime(0, 0, 0, date("m"), date("d")-$dateType, date("Y")));
			$endTime      = date('Ymd',time());
			$where 		  = " WHERE date>='".$startTime."' and date<='".$endTime."'";
		}else{
			$where 		  = " WHERE date='".date('Ymd',time())."'";
		}
		if(!empty($aid)){
			$where=$where." and aid='".$aid."'";
		}

		if($isAll==true){$where=null;}

		if(!empty($aid)&&!empty($where)){
			$tmpTable="SELECT SUM(  `exercise` ) AS exercise, uid,date FROM ai_user_exercise_log $where and `aid`=$aid GROUP BY uid ORDER BY exercise";
		}elseif(!empty($aid)&&empty($where)){
			$tmpTable="SELECT SUM(  `exercise` ) AS exercise, uid,date FROM ai_user_exercise_log where aid=$aid GROUP BY uid ORDER BY exercise";
		}else{
			$tmpTable="SELECT SUM(  `exercise` ) AS exercise, uid,date FROM ai_user_exercise_log $where GROUP BY uid ORDER BY exercise";
		}


		if(!empty($where)){
			$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  $where and uid=$uid GROUP BY uid ORDER BY exercise";
		}elseif(!empty($aid)){
			$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  where uid=$uid and aid=$aid GROUP BY uid ORDER BY exercise";
		}else{
			$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  where uid=$uid GROUP BY uid ORDER BY exercise";				
		}

		$getRankSql="select count(*) as num from ($tmpTable) as tmp where tmp.exercise >= ($tmpUTable)";
		$data=$this->db->_query($getRankSql);
		if($data[0]['num']==0){
			if(!empty($aid)){
				$checkSql="select * from ai_user_exercise_log where uid=$uid and aid=$aid and date='".date('Ymd',time())."'";
			}else{
				$checkSql="select * from ai_user_exercise_log where uid=$uid and date='".date('Ymd',time())."'";	
			}
			$check=$this->db->_query($checkSql);
			if(empty($check)) return 0;
		}
		return $data[0]['num']>0 ? intval($data[0]['num']):1;
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
		$imgtpye = $this->db->_query( "select upic_type from ai_user where uid='" . $uid . "'" );
		$uid_to_path = '/' . $uid;
		$userface = $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		if ($imgtpye [0] ['upic_type'] == 1) {
			return $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		} else {
			$apiImg =$this->db->_query( "select profileImageUrl from ai_others where uid='" . $uid . "' and profileImageUrl!=''" );
			if (! empty ( $apiImg )) {
				$userface = $apiImg [0] ['profileImageUrl'];
				return $userface;
			}
			return $this->baseUrl . "/images/user_pic_{$type}.gif";
		}
	}
	protected function getUserName($uid) {
		$username = $this->db->_query( "select uname from ai_user where uid=$uid" );
		return $username [0] ['uname'];
	}
}

$_CI = new Ajax ();
$_CI->$_REQUEST ['act'] ();
exit ();