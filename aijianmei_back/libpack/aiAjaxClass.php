<?php
header("charset=utf-8");
define('SITE_PATH',dirname(dirname(__FILE__)));//路径常量定义

$dbConfig=include_once('../config.inc.php');//加载配置文件
define('_DBHOST'		,$dbConfig['DB_HOST']);
define('_DBUSER'		,$dbConfig['DB_USER']);
define('_DBPASSWORD',$dbConfig['DB_PWD']);
define('_DBNAME'		,$dbConfig['DB_NAME']);
include_once 'db.class.php';

class Ajax{
	public function __construct() {
		$this->db=new ckmysql();
		return $this;
	}
	public function index(){
		$text="叼你老豆叼你老豆叼你\n老豆叼你老豆\n叼你老豆\n叼你老豆\n叼你老妹\n";
		$sizeArray=array(18,1000,500);
		$uid=264;
		$this->generatePngByFont($text,$sizeArray,$uid,'','bgImg.png');
	}
	
	//编码转化utf8
	protected function toUtf8($string){
		if(empty($string)) return false;
		return iconv('GB2312','UTF-8',$string);
	}
	//生成文字日记图片
	protected function generatePngByFont($text,$sizeArray,$uid,$savePath=null,$backImg=null){
		if(empty($text)||!($uid>0))return false;
		$fontSize		=$sizeArray[0];
		$imgWidth		=$sizeArray[1];
		$imgHeight	=$sizeArray[2];
		$savePath		=!empty($savePath) ? (string)$savePath : '';
		//字体类型，瘦金体
		$font ="FZSJSJW.TTF";
		
		//创建一个长为500高为80的空白图片
		$img = imagecreate($imgWidth,$imgHeight);
		
		if(!empty($backImg)){
			$simage =imagecreatefrompng($backImg); // 读取我们的背景图片
			imagecopy($img,$simage,0,0,0,0,466,313); 
		}
		
		//给图片分配颜色
		imagecolorallocate($img, 100, 200, 100);
		//设置字体颜色
		$black = imagecolorallocate($img, 0, 0, 0);
		//将ttf文字写到图片中
		imagettftext($img, $fontSize, 0, 10, 40, $black, $font, $text);
		//发送头信息
		header('Content-Type: image/png');
		//输出图片
		//imagegif($img);
		Imagepng($img);
		if(!empty($savePath)){
			Imagepng($img,$savePath);
		}
		ImageDestroy($img);
	}

}

$_CI = new Ajax();
$_CI -> index();
exit;