<?php
///////////////// Password protect ////////////////////////////////////////////////////////////////
// define('ADMIN_USERNAME','admin'); 	// Admin Username
// define('ADMIN_PASSWORD','admin');  	// Admin Password
// if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
//            $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
// 			Header("WWW-Authenticate: Basic realm=\"Memcache Login\"");
// 			Header("HTTP/1.0 401 Unauthorized");

// 			echo <<<EOB
// 				<html><body>
// 				<h1>Rejected!</h1>
// 				<big>Wrong Username or Password!</big>
// 				</body></html>
// EOB;
// 			exit;
// }
///////////////// Password protect ////////////////////////////////////////////////////////////////

header("Content-type: text/html; charset=utf-8");
$basedir = '.';

$auto = 1;

checkdir($basedir);
echo '<br />验证完毕，如果没有红色文件证明一切正常！';
function checkdir($basedir){
	if($dh = opendir($basedir)) {
		while(($file = readdir($dh)) !== false) {
			if($file != '.' && $file != '..' && $file != '.svn'){
				if(!is_dir($basedir."/".$file)) {
					if(checkBOM("$basedir/$file")==1){
						echo "filename: $basedir/$file <font color=red>存在，自动删除.</font> <br>";
					}
				}else{
					$dirname = $basedir."/".$file;
					checkdir($dirname);
				}
			}
		}
		closedir($dh);
	}
}

function checkBOM($filename) {
	global $auto;
	$contents = file_get_contents($filename);
	$charset[1] = substr($contents, 0, 1);
	$charset[2] = substr($contents, 1, 1);
	$charset[3] = substr($contents, 2, 1);
	if(ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
		if($auto == 1) {
			$rest = substr($contents, 3);
			@file_put_contents($filename, $rest, LOCK_EX);
			return 1;
		} else {
			return 0;
		}
	}
	else return("不存在");
}
?>