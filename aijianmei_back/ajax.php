<?php
switch($_REQUEST['act']) {
	case 'check_email' : check_email($_REQUEST['email']); break;	
}

function check_email($email) {
	$db = mysql_connect('localhost', 'root', 'will123');
	mysql_select_db('aijianmei', $db);
	$res = mysql_query('select uid from ai_user where `email`="'.$email.'"', $db);
	$res = mysql_fetch_row($res);
	if(empty($res)) {
		echo 0;
	}else {
		echo 1;
	}
	mysql_close($db);
}
?>