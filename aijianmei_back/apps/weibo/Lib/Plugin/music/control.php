<?php 
include_once 'function.php';
switch ($do_type){
	case 'before_publish':
			if($_POST['url']){
				$return['boolen'] = 1;
				$return['data']   = getShortUrl($_POST['url']);
			}else{
				$return['boolen'] = 0;
				$return['message'] = '添加失败';
			}
			exit( json_encode($return) );
		break;
		
	case 'publish':
	        	$typedata['songurl']  = $type_data;
		break;
}