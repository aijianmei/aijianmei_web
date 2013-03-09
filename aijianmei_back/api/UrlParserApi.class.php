<?php 
require_once 'VideoUrlParser.class.php';
class UrlParserApi extends Api {
	public function getVideoInfo($url)
	{
		$url = 'http://www.56.com/u68/v_NjI2NTkxMzc.html';
		$info = VideoUrlParser::parse($url);
		//var_dump($info);
		return $info;
	}
}
?>