<?php
$_dbConfig = require_once ('config.inc.php');


define('_DBHOST',$_dbConfig ['DB_HOST']);
define('_DBUSER',$_dbConfig ['DB_USER']);
define('_DBPASSWORD',$_dbConfig ['DB_PWD']);
define('_DBPORT','3306');
define('_DBNAME','aijianmei');


function C_mysqlQuery($sql) {
	global $_dbConfig;
	$con = mysql_connect ( $_dbConfig ['DB_HOST'], $_dbConfig ['DB_USER'], $_dbConfig ['DB_PWD'] );
	if (! $con) {
		die ( 'Could not connect: ' . mysql_error () );
	}
	$db_selected = mysql_select_db ( "aijianmei", $con );
	mysql_query ( "set names 'utf8'" );
	$result = mysql_query ( $sql, $con );
	return $result;
}
function C_mysqlAll($sql) {
	$resultTmp = array ();
	$row = $res = null;
	$res = C_mysqlQuery ( $sql );
	while ( $row = mysql_fetch_assoc ( $res ) ) {
		$resultTmp [] = ( array ) $row;
	}
	foreach ( $resultTmp as $ke => $ve ) {
		foreach ( $ve as $kx => $vx ) {
			$resultTmp [$ke] [$kx] = ( string ) $vx;
		}
	}
	return $resultTmp;
}
function C_mysqlOne($sql) {
	$resultTmp = array ();
	$res = C_mysqlQuery ( $sql );
	@$row = mysql_fetch_assoc ( $res );
	if (is_array ( $row )) {
		foreach ( $row as $ke => $ve ) {
			$resultTmp [0] [$ke] = ( string ) $ve;
		}
	}
	return $resultTmp;
}

// 全输入简易过滤
if (! empty ( $_REQUEST ['auact'] )) {
	foreach ( $_REQUEST as $key => $value ) {
		$_REQUEST [$key] = MooAddslashes ( $value );
	}
	foreach ( $_POST as $key => $value ) {
		$_POST [$key] = MooAddslashes ( $value );
	}
	foreach ( $_GET as $key => $value ) {
		$_GET [$key] = MooAddslashes ( $value );
	}
}

// addcslashes
function MooAddslashes($value) {
	$value = preg_replace ( "/<[^><]*script[^><]*>/i", '', $value );
	$value = preg_replace ( "/<[\/\!]*?[^<>]*?>/si", '', $value );
	return $value = is_array ( $value ) ? array_map ( 'MooAddslashes', $value ) : addslashes ( $value );
}

function setInputLog($fileName=null){
	$fileName= !empty($fileName) ? $fileName : "tmp.txt";
	ob_start();

	var_dump($_GET);
	var_dump($_POST);
	var_dump($_FILES);

	$info=ob_get_contents();
	ob_end_clean();
	file_put_contents($fileName,$info);
}
function getMonthsList($start, $end=null)
{
	//!empty($end)? cother($start,$end) : '' ;
	$result=$skey=$key=null;
	for ($i = 0; $i <12; $i++) {
	 	  $skey="-{$i} month";
	 	  $key=12-$i;
	 	  $result[$key]=date('Ym',strtotime($skey ,strtotime($start)));
	}
	ksort($result);
	return $result;
}