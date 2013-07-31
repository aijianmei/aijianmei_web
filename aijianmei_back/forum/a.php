<?php

			/*forum 论坛 登陆api start by kontem at20130626*/
define("AIBASEURL","http://www.aijianmei.com");
			//调用登陆api
			$url=AIBASEURL."/forum/pwApi.php?pwact=login";
			$post_data=array(
				'username' => 'C_Kontem',
			  'password' =>'324',
			  'is_sinalogin' =>1,
			 );
			echo _CurlPost($url,$post_data);
			
			
			
	function _CurlPost($url,$post_data=null){

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}