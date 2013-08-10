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
/*
 * 40004 对应方法不存在 40003 动作标识错误 40001 非允许动作标识
 */
class Ajax {
	protected $allowAction = array (
			'setUserLogImg',
			'postUserCourseInfo',
			'getCourseInfo',
			'postWeightInfo' ,
	);
	protected $ttf = 'FZSJSJW.TTF';
	public function __construct() {
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
		if (! empty ( $data )) {
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$colorCss= ($k+1)%2==0 ?'evenRow':'oddRow';
				$resultHtml.='<div class="actGroup actGroupKon '.$colorCss.' clearfix"><div class="col1 col">第'.$this->num2Char($k+1).'组</div><div class="col2 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['nums'].'" name="nums[]" class="figure" readonly/><span class="add"></span></div><div class="col3 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['weight'].'" name="weight[]" class="figure" readonly/><span class="add"></span></div><div class="col4 col"><span class="cut"></span><input type="text" value="'.$value['loginfo']['time'].'" name="time[]" class="figure" readonly/><span class="add"></span></div></div>';
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
		$text = $_POST ['testString'];
		$sizeArray = array (
				18,
				466,
				313 
		);
		$uid = 264;
		$this->generatePngByFont ( $text, $sizeArray, $uid, 'a.png', 'bgImg.png' );
		ob_end_clean ();
		echo "<textarea>a.png</textarea>";
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
	protected function num2Char($num){
		$charArr = array('1' =>'一' , '2' => '二','3' => '三' ,'4' => '四' ,'5' => '五' ,'6' => '六' ,
			'7' => '七' , '8' => '八', '9' => '九' );
		return !empty($num)?$charArr[$num]:$num;
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