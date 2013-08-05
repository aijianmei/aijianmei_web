<?php
$dbConfig=include('config.inc.php');
include_once 'db.class.php';
var_dump($dbConfig);
class Ajax{
	public function __construct() {
		$con = mysql_connect ( _DBHOST, _DBUSER, _DBPASSWORD );
		if (! $con) {
			die ( 'Could not connect: ' . mysql_error () );
		}
		mysql_query ( "SET NAMES UTF8" );
		mysql_select_db ( _DBNAME, $con );
		$this->con = $con;
		return $this;
	}
}