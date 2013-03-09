<?php
    if (!defined('THINK_PATH')) exit();
    $config	= require './config.php';
    $array=array(
	
        'APP_AUTOLOAD_PATH'=>'@.TagLib',
		'DEFAULT_THEME' => 'default',
    );
    return array_merge($config,$array);
?>