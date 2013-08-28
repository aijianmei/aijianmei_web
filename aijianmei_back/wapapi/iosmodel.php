<?php
class iosModel{
	protected $ttf = 'FZSJSJW.TTF';
	public function __construct(){
		$this->db=new ckmysql();
		return $this;
	}
	//运动管理 通过uid date 获取对应的图片信息
	public function getUserImage($uid,$startDate=null,$endDate=null,$dateType='default'){
		$dateTypeArray=array('default','pre','next');
		
		$limitNum= ($dateType=='default') ? 2 : 1;
		
		$data=$sql=null;
		if(!in_array($dateType,$dateTypeArray))return false;
		
		$dateCondition=$this->setDateString($startDate,$endDate,$dateType);
		
		$sql="select * from ai_user_course_log_image where uid=$uid {$dateCondition} order by date desc limit $limitNum";
		$data=$this->db->_query($sql);
		return $data;
	}
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
	//返回用户动作列表
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
	public function getActionInfoByName($name){
			$sql="select * from ai_action_list where name like '%".$name."%'";
			$data=$this->db->_query($sql);
			return $data[0];
	}
	public function getActionIdByName($name) {
		$sql = $data = null;
		$name = ( string ) $name;
		$sql = "select * from ai_action_list where `name`='" . $name . "'";
		$data =$this->db->_query( $sql );
		return ! empty ( $data ) ? $data [0] ['id'] : false;
	}
	//文件简易校验 1判断后缀 以及tmp_name 非空
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
	//运动管理 图片信息 日期条件 组合
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
}
