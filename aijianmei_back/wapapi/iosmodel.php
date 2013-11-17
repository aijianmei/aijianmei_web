<?php
class iosModel{
	/**
	 * [$ttf 指定的字体文件]
	 * @var string
	 */
	protected $ttf = 'FZSJSJW.TTF';
	/**
	 * [$courseMaxNum 运动管理列表最大值]
	 * @var integer
	 */
	protected $courseMaxNum = 7;
	protected $baseUrl 		= 'http://www.aijianmei.com';
	/**
	 * [__construct init db]
	 */
	public function __construct(){
		$this->db=new ckmysql();
		return $this;
	}
	/**
	 * [getUserImage 获取用户运动相关的相片]
	 * @param  [int] $uid
	 * @param  [int] $startDate
	 * @param  [int] $endDate
	 * @param  string $dateType
	 * @return [array]
	 */
	function getUserImage($uid,$startDate=null,$endDate=null,$dateType='default'){
		$dateTypeArray=array('default','pre','next');
		
		$limitNum= ($dateType=='default') ? 2 : 1;
		
		$data=$sql=null;
		if(!in_array($dateType,$dateTypeArray))return false;
		
		$dateCondition=$this->setDateString($startDate,$endDate,$dateType);
		
		echo $sql="select * from ai_user_course_log_image where uid=$uid {$dateCondition} order by date desc limit $limitNum";
		$data=$this->db->_query($sql);
		return $data;
	}
	/**
	 * [getUserlogImage 获取用户运动相关日志记录]
	 * @param  [int] $uid
	 * @param  [int] $startDate
	 * @param  [int] $endDate
	 * @param  string $dateType
	 * @return [array]
	 */
	public function getUserlogImage($uid,$startDate=null,$endDate=null,$dateType='default'){
		$dateTypeArray=array('default','pre','next');
		
		$limitNum= ($dateType=='default') ? 2 : 1;
		
		$data=$sql=null;
		if(!in_array($dateType,$dateTypeArray))return false;
		
		$dateCondition=$this->setDateString($startDate,$endDate,$dateType);
		
		$sql="select * from ai_user_course_log where uid=$uid {$dateCondition} order by date desc limit $limitNum";
		$data=$this->db->_query($sql);
		return $data;
	}
	/**
	 * [postUserImage 提交用户运动管理相片]
	 * @param  int $uid
	 * @param  int $date
	 * @param  string $targetFile
	 * @return [type]
	 */	
	public function postUserImage($uid,$date,$targetFile){
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
	}	
	/**
	 * setUserLogImg 处理用户提交的日志
	 * @param int $uid
	 * @param int $date
	 * @param string $text
	 */
	public function setUserLogImg($uid,$date,$text) {
		$sizeArray = array (
			18,
			514,
			384, 
			);
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
	}
	/**
	 * generatePngByFont 重新生成指定的字体文字 已经对应的做字数控制并且换行
	 * @param  string $text
	 * @param  array $sizeArray
	 * @param  int $uid
	 * @param  string $savePath
	 * @param  string $backImg
	 * @return null
	 */
	public function generatePngByFont($text, $sizeArray, $uid, $savePath = null, $backImg = null) {
		if (empty ( $text ) || ! ($uid > 0))return false;

		$fontSize = $sizeArray [0];
		$imgWidth = $sizeArray [1];
		$imgHeight = $sizeArray [2];
		$savePath = ! empty ( $savePath ) ? ( string ) $savePath : '';
		// 字体类型，瘦金体
		$font = $this->ttf;
		$text = $this->formatFontString ( $text );
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

	/**
	 * [getUserDefaultActionListByUid 返回用户动作列表]
	 * @param  int $uid
	 * @return array 
	 */
	public function getUserDefaultActionListByUid($uid){
		$actionListTmp=$actionList=null;
		$checkSql="select uid,actionList from ai_user_course_default_alist where uid=$uid";
		$checkData=$this->db->_query($checkSql);
		//var_dump($checkData);
		if(!empty($checkData)){
			$actionList=array();
			$actionList=unserialize($checkData[0]['actionList']);
		}else{
			$recommendActionList=$this->getRecommendActionList();
			foreach ($recommendActionList as $key => $value) {
				$newCommendActionList[$key]=$value['name'];
			}
			$actionList=$newCommendActionList;
		}
		foreach ($actionList as $key=> &$value) {
		 	 $actionListTmp[$key]['id']=$this->getActionIdByName($value);
		 	 $actionListTmp[$key]['name']=$value;
		} 
		return $actionListTmp;
	}
	/**
	 * [getActionInfoByName 通过动作名称返回对应的动作信息]
	 * @param  string $name
	 * @return array
	 */
	public function getActionInfoByName($name){
			$sql="select * from ai_action_list where name='".$name."'";//注:默认动作名称 唯一因此直接使用查询 不做模糊
			$data=$this->db->_query($sql);
			return $data[0];
	}
	/**
	 * [getActionIdByName 通过动作名称返回对应的id 单纯只是简易处理]
	 * @param  string $name
	 * @return int
	 */
	public function getActionIdByName($name) {
		$sql = $data = null;
		$name = ( string ) $name;
		$sql = "select * from ai_action_list where `name`='" . $name . "'";
		$data =$this->db->_query( $sql );
		return ! empty ( $data ) ? intval($data [0] ['id']) : false;
	}
	/**
	 * [checkFileInfo 文件简易校验 1判断后缀 以及tmp_name 非空]
	 * @param  string $fileKey $_FILES 对应的文件key值
	 * @return true or false
	 */
	public function checkFileInfo($fileKey){
		$allowed_types = array('jpg', 'gif', 'png');
		$filename = $_FILES[$fileKey]['name'];
		#正则表达式匹配出上传文件的扩展名
		preg_match('|\.(\w+)$|', $filename, $ext);
		#转化成小写
		$ext = strtolower($ext[1]);
		#判断是否在被允许的扩展名里
		return (!in_array($ext, $allowed_types)&&!empty($_FILES[$fileKey]['tmp_name']))? false : true;
	}
	/**
	 * [setDateString 运动管理 图片信息 日期条件 组合]
	 * @param int $startDate
	 * @param int $endDate
	 * @param string $dateType 如当天 前后一天 
	 */
	protected function setDateString($startDate,$endDate,$dateType){
		$condition=null;
		if(!empty($startDate)&&!empty($endDate)){
			if(intval($startDate)>intval($endDate)){
				$tmpDate	=null;
				$tmpDate	=$endDate;
				$endDate	=$startDate;
				$startDate=$endDate;
				$condition=" and date>={$startDate} and date<={$endDate}";	
			}
		}elseif(!empty($dateType)&&!empty($startDate)){
			if($dateType=='default'){
				$condition=" and date={$startDate}";	
			}elseif ($dateType=='pre') {
				$condition=" and date<{$startDate}";	
			}else{
				$condition=" and date>{$startDate}";	
			}
		}
		return $condition;
	}
	/**
	 * [formatFontString 重写对应的输入内容进行固定宽度的换行]
	 * @param  string $string
	 * @return string
	 */
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
	/**
	 * [formatCourseNum 针对ios客户端提交的特殊的字符串拼接模式]
	 * @param  array $data
	 * @return array
	 */
	public function formatCourseNum($data){
		foreach ($data as $key=>&$value){
			$value=str_replace("(","",$value);
			$value=str_replace(")","",$value);
			$value=str_replace(" ","",$value);
			$value=intval($value);
		}
		return $data;
	}
	/**
	 * [postUserCourse 更新/插入/删除 对应的运动数据 根据接口数组的个数判断]
	 * @param  int $uid
	 * @param  int $aid
	 * @param  array $number
	 * @param  array $weight
	 * @param  array $time
	 * @param  int $date
	 * @return null
	 */
	public function postUserCourse($uid,$aid,$number,$weight,$time,$date){

		foreach ( $number as $key => $value ) {
			$loginfo = null;
			/**
			 * [$group 根据键值作为组号]
			 * @var int
			 */
			$group = $key + 1;
			$loginfo ['nums'] = intval ( $value );
			$loginfo ['weight'] = intval ( $weight[$key] );
			$loginfo ['time'] = intval ( $time[$key] );
			$loginfo = serialize ( $loginfo );
			$checkSql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid and `group`=$group and `date`=$date";
			$checkData = $this->db->_query( $checkSql );//根据查询状态而操作
			if (empty ( $checkData )) {
				$insertSql = "INSERT INTO ai_user_course_list (`id` ,`uid` ,`aid` ,`date` ,`loginfo` ,`create_time` ,`group`)
				VALUES (NULL ,  '" . $uid . "',  '" . $aid . "',  '" . $date . "',  '" . $loginfo . "', '" . time () . "',  '" . $group . "')";
				$this->db->_query( $insertSql );
			} else {
				$updateSql = "UPDATE ai_user_course_list SET  loginfo ='" . $loginfo . "',`create_time` = '" . time () . "' where  `uid`=$uid and `aid`=$aid and `group`=$group and `date`=$date";
				$this->db->_query( $updateSql );
			}
		}
		/**
		 * $delStartNums 判断数据清除的起始节点
		 */
		$delStartNums=count($number);
		if($delStartNums < $this->courseMaxNum){//如果小于最大值 7 则默认为删除多余数据
			$delSql="DELETE FROM ai_user_course_list WHERE `uid`=$uid AND `aid`=$aid AND `group`> $delStartNums AND `date`=$date";
			$this->db->_query( $delSql );
		}
	}
	/**
	 * [getUserRank 获取全站排名信息]
	 * @param  int  	$dateType
	 * @param  int  	$aid
	 * @param  boolean  $isAll
	 * @return array
	 */
	public function getUserRank($dateType=null,$aid=null,$isAll=false){
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
		return !empty($data)?$data:null;
	}
	/**
	 * [getUserRankById 通过uid获取运动管理排名信息]
	 * @param  int  $uid
	 * @param  int  $dateType
	 * @param  int  $aid
	 * @param  boolean $isAll
	 * @return array
	 */
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
		$tmpTable="SELECT SUM(  `exercise` ) AS exercise, uid,date FROM ai_user_exercise_log  $where GROUP BY uid ORDER BY exercise";
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
			$checkSql="select * from ai_user_exercise_log where uid=$uid and date='".date('Ymd',time())."'";
			$check=$this->db->_query($checkSql);
			if(empty($check)) return 0;
		}
		return $data[0]['num']>0 ? intval($data[0]['num']):1;
	}
	/**
	 * [getUserFace 获取用户头像]
	 * @param  int $uid
	 * @param  string $size
	 * @return string
	 */
	protected function getUserFace($uid, $size) {
		$size = ($size) ? $size : 'm';
		if ($size == 'm') {
			$type = 'middle';
		} elseif ($size == 's') {
			$type = 'small';
		} else {
			$type = 'big';
		}
		$imgtpye = $this->db->_query( "select `upic_type` from ai_user where `uid`='" . $uid . "'" );

		$uid_to_path = '/' . $uid;
		$userface = $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		if ($imgtpye [0] ['upic_type'] == 1) {
			return $this->baseUrl . '/data/uploads/avatar' . $uid_to_path . '/' . $type . '.jpg';
		} else {
			$apiImg = $this->db->_query( "select profileImageUrl from ai_others where uid='" . $uid . "' and profileImageUrl!=''" );
			if (! empty ( $apiImg )) {
				$userface = $apiImg [0] ['profileImageUrl'];
				return $userface;
			}
			return $this->baseUrl . "/images/user_pic_{$type}.gif";
		}
	}
	/**
	 * [getUserName 获取用户呢称]
	 * @param  int $uid
	 * @return string
	 */
	protected function getUserName($uid) {
		$sql="select `uname` from ai_user where `uid`='".intval($uid)."'";
		$username =$this->db->_query( $sql );
		return $username [0] ['uname'];
	}
	/**
	 * setLog 用于测试开发 
	 * @param string $fileName
	 * @param array $data
	 */
	public function setLog($fileName=null,$data=null){
		$fileName= !empty($fileName) ? $fileName : "tmp.txt";
		ob_start();
		var_dump($data);
		$info=ob_get_contents();
		ob_end_clean();
		file_put_contents($fileName,$info);
	}
}
