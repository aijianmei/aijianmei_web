<?php
class ckmysql {
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
	public function _query($sql) {
		if ((stristr ( strtolower ( $sql ), 'select' ) !== FALSE) && is_string ( $sql )) {
			$_resultTmp = mysql_query ( $sql, $this->con );
			return $this->toAssocArray ( $_resultTmp );
		} elseif ((stristr ( strtolower ( $sql ), 'update' ) !== FALSE) || (stristr ( strtolower ( $sql ), 'delete' ) !== FALSE)) {
			mysql_query ( $sql, $this->con );
			return mysql_affected_rows ();
		} elseif (stristr ( strtolower ( $sql ), 'insert' ) !== FALSE) {
			mysql_query ( $sql, $this->con );
			return mysql_insert_id ();
		} else {
			return;
		}
	}
	public function selectOne() {
		$argsCount = func_num_args ();
		$arg_list = func_get_args ();
		$sql = $argsCount == 1 ? $arg_list : $this->makeSql ( $argsCount, $arg_list, 'select' );
		$sql .= " limit 1";
		$_resultTmp = mysql_query ( $sql, $this->con );
		return $this->toAssocArray ( $_resultTmp );
	}
	public function selectAll() {
		$argsCount = func_num_args ();
		$arg_list = func_get_args ();
		$sql = $argsCount == 1 ? $arg_list : $this->makeSql ( $argsCount, $arg_list, 'selectall' );
		$_resultTmp = mysql_query ( $sql, $this->con );
		return $this->toAssocArray ( $_resultTmp );
	}
	public function makeSql($argsCount, $arg_list, $type) {
		if ($argsCount == 1 && $type == 'select') {
			if (stristr ( strtolower ( $arg_list [0] ), 'select' ) === FALSE) {
				$sql = "SELECT * FROM $arg_list [0]";
			}
		} elseif ($argsCount == 2 && $type == 'select') {
			$table = $arg_list [0];
			$cond = $arg_list [1];
			$sql = "SELECT * FROM $table $cond";
		} elseif ($argsCount == 3 && $type == 'select') {
			$table = $arg_list [0];
			$cond = $arg_list [1];
			$filds = $arg_list [2];
			$sql = "SELECT $filds FROM $table $cond";
		} elseif ($argsCount == 3 && $type == 'selectall') {
			$table = $arg_list [0];
			$cond = $arg_list [1];
			$limit = $arg_list [2];
			$sql = "SELECT * FROM $table $cond limit $limit";
		}
		return $sql;
	}
	public function insert($table, $data) {
		$insertString = $this->_makeInsertFields ( $data );
		$sql = "INSERT INTO $table $insertString";
		mysql_query ( $sql, $this->con );
		return mysql_insert_id ();
	}
	public function update($table, $data, $where) {
		if (! empty ( $where )) {
			if (stristr ( $where, '=' ) == FALSE) {
				$this->_errorMessage ( 40003 );
			}
		}
		// UPDATE `aijianmei`.`ai_nav_module_list` SET `name` = '1233',`type` = '14' WHERE `ai_nav_module_list`.`id` =4;
		$sql = "UPDATE $table SET " . $this->_makeUpdateFields ( $data ) . " WHERE $where";
		mysql_query ( $sql, $this->con );
		return mysql_affected_rows ();
	}
	public function delete($table,$where){
		if (! empty ( $where )) {
			if (stristr ( $where, '=' ) == FALSE) {
				$this->_errorMessage ( 40003 );
			}
		}
		$sql="DELETE FROM $table $where";
		mysql_query ( $sql, $this->con );
		return mysql_affected_rows ();
	}
	/*public function __destruct() {
		mysql_close ();
	}*/
	protected function toAssocArray($_result, $isFinedOne = null) {
		$_resultTmp = array ();
		if ($_result) {
			$nums = 0;
			while ( $row = mysql_fetch_assoc ( $_result ) ) {
				$_resultTmp [] = $row;
				$nums ++;
			}
			if ($isFinedOne == 1)
				return $_resultTmp [0];
			return $_resultTmp;
		} else {
			return false;
		}
	}
	protected function _makeUpdateFields($arguments) {
		$UpdateFields = null;
		if (is_array ( $arguments )) {
			foreach ( $arguments as $key => $value ) {
				$UpdateFields .= empty ( $UpdateFields ) ? "`" . $key . "` = '" . $value . "'" : ",`" . $key . "` = '" . $value . "'";
			}
		}
		return $UpdateFields;
	}
	protected function _makeCondition($arguments) {
		$UpdateFields = null;
		if (is_array ( $arguments )) {
			foreach ( $arguments as $key => $value ) {
				$UpdateFields .= empty ( $UpdateFields ) ? "`" . $key . "` = '" . $value . "'" : " AND `" . $key . "` = '" . $value . "'";
			}
		}
		return $UpdateFields;
	}
	protected function _makeInsertFields($arguments) {
		$UpdateFields = $UpdateFieldsKey = $UpdateFieldsVal = null;
		if (is_array ( $arguments )) {
			foreach ( $arguments as $key => $value ) {
				$UpdateFieldsKey .= empty ( $UpdateFieldsKey ) ? $key : "," . $key;
				$UpdateFieldsVal .= empty ( $UpdateFieldsVal ) ? "'" . $value . "'" : ",'" . $value . "'";
			}
			$UpdateFields = "(" . $UpdateFieldsKey . ") values (" . $UpdateFieldsVal . ")";
		}
		
		return $UpdateFields;
	}
	protected function _errorMessage($code) {
		$_errorMessage = null;
		switch ($code) {
			case '500' :
				$_errorMessage = '数据库链接错误';
				break;
			case '301' :
				$_errorMessage = '参数错误';
				break;
			case '404' :
				$_errorMessage = '未知错误';
				break;
			case '40003' :
				$_errorMessage = '条件错误或者参数错误';
				break;
		}
		return $this->_error = $_errorMessage;
	}
}


