<?php
class Ckon_mysqli extends mysqli{
    protected $_mysqliDb;
    public function __construct(){
        parent::__construct(_DBHOST, _DBUSER, _DBPASSWORD, _DBNAME);
        if (mysqli_connect_errno())
        {
          $this->connection_failed = true;
          return _errorMessage(500);
        }
    }
    public function connect($hostname, $username, $password, $database){
        $_db=@new mysqli($hostname, $username, $password, $database);
        return mysqli_connect_errno() ? false : $_db;
    }
    
    public function __call($name,$arguments) {
        //echo $name."|".$arguments;
        return self::_errorMessage(404);
    }
    public static function __callstatic($name,$arguments){
        $_mysqliDb=null;
        $_mysqliDb=self::connect(_DBHOST,_DBUSER,_DBPASSWORD,_DBNAME);
        if(!$_mysqliDb) return false;
        $_mysqliDb->set_charset("utf8");
        $_resultTmp=null;
        $_tableName=null;
        $_fieldsArr=null;
        $_condition=null;
		$_tableName=substr($name,strpos($name,'_',0)+1);
		if(defined($_tableName)) $_tableName=constant($_tableName);
		
        if((stristr($name, 'Select') !== FALSE) && (stristr($name, 'From') !== FALSE))
        {
            $_fieldsArr= empty($arguments)?'*':$arguments[0];
            $_condition= count($arguments)>1?$arguments[1]:'';
            $_resultTmp=self::_Query("SELECT $_fieldsArr FROM $_tableName $_condition",$_mysqliDb);
            return self::toAssocArray($_resultTmp);
        }
        elseif((stristr($name, 'Update') !== FALSE) && (stristr($name, 'From') !== FALSE))
        {
            if(count($arguments)!=2) return self::_errorMessage(301);
            $_fieldsArr= empty($arguments[0])?'':self::_makeUpdateFields($arguments[0]);
            if(!$_fieldsArr) return false;
            $_condition= count($arguments)>1&&!empty($arguments[1])?$arguments[1]:'';
            $_condition= is_array($_condition) ? self::_makeCondition($_condition):(is_string($_condition)?$_condition:'');
            $_resultTmp=self::_Query("UPDATE $_tableName SET $_fieldsArr WHERE $_condition",$_mysqliDb);
            return $_mysqliDb->affected_rows;
        }
        elseif((stristr($name, 'Delete') !== FALSE) && (stristr($name, 'From') !== FALSE))
        {
            if(count($arguments)!=1) return self::_errorMessage(301);
            $_condition= is_array($arguments[0])?self::_makeCondition($arguments[0]):(is_string($arguments[0])?$arguments[0]:'');
            $_resultTmp=self::_Query("DELETE FROM $_tableName WHERE $_condition",$_mysqliDb);
            return $_mysqliDb->affected_rows;
        }
		elseif((stristr($name, 'Insert') !== FALSE) && (stristr($name, 'From') !== FALSE))
        {
            if(count($arguments)<2) return self::_errorMessage(301);
            $keys=null;
			$keys=(string)$arguments[0];
			if(is_array($arguments[1])){
				$valueStr=self::_makeInsertFields($arguments[1]);
				$_resultTmp=self::_Query("INSERT INTO $_tableName ($keys) VALUES $valueStr",$_mysqliDb);
				return $_mysqliDb->affected_rows;
			}elseif(is_string($arguments[1])){
				$valueStr=$arguments[1];
				$_resultTmp=self::_Query("INSERT INTO $_tableName ($keys) VALUES ($valueStr)",$_mysqliDb);
				return $_mysqliDb->insert_id;
			}
        }
        elseif((stristr($name, 'Query') !== FALSE))
        {
            $arguments=count($arguments)==1?$arguments[0]:'';
            if((stristr(strtolower($arguments), 'select') !== FALSE)&&is_string($arguments)){
               $_resultTmp=self::_Query($arguments,$_mysqliDb);
                return self::toAssocArray($_resultTmp);
            }
            elseif((stristr(strtolower($arguments), 'Update') !== FALSE)||(stristr(strtolower($arguments), 'Delete') !== FALSE)||(stristr(strtolower($arguments), 'Insert') !== FALSE)){
                self::_Query($arguments,$_mysqliDb);
                return $_mysqliDb->affected_rows;
            }
			else{
				self::_Query($arguments,$_mysqliDb);
                return $_mysqliDb->affected_rows;
			}
        }
        return false;
    } 
    public function __destruct(){
        //parent::close();
    }
    protected function toAssocArray($_result){
        $_resultTmp=array();
        if(is_object($_result))
        {
            $nums=0;
            while ($row = $_result->fetch_assoc()) {
                $_resultTmp[]=$row;
                $nums++;
            }
            return array('data'=>$_resultTmp,'count'=>$nums,);
        }
        else{
            return false;
        }
        
    }
    protected function _Query($sql,$_mysqliDb){
      return $_mysqliDb->query($sql);
    }
    protected function _makeUpdateFields($arguments){
        $UpdateFields=null;
        if(is_array($arguments)){
            foreach($arguments as $key => $value){
                $UpdateFields.=empty($UpdateFields)? "`".$key."` = '".$value."'":",`".$key."` = '".$value."'";
            }
        }
        return $UpdateFields;
    }
	
	
    protected function _makeCondition($arguments){
        $UpdateFields=null;
        if(is_array($arguments)){
            foreach($arguments as $key => $value){
                $UpdateFields.=empty($UpdateFields)? "`".$key."` = '".$value."'":" AND `".$key."` = '".$value."'";
            }
        }
        return $UpdateFields;
    }
	
	protected function _makeInsertFields($arguments){
        $UpdateFields=null;
        if(is_array($arguments)){
            foreach($arguments as $key => $value){
				if(is_string($value)){
					$UpdateFields.=empty($UpdateFields)? "(".$value.")":",(".$value.")";
				}
				if(is_array($value)){
					$UpdateFieldsTmp=null;
					foreach($value as $k => $v){
						$UpdateFieldsTmp.=empty($UpdateFieldsTmp)? "'".$value."'":",'".$value."'";
					}
					$UpdateFields.=empty($UpdateFields)? "(".$UpdateFieldsTmp.")":",(".$UpdateFieldsTmp.")";
				}				
            }
        }
        return $UpdateFields;
    }
    protected function _errorMessage($code){
        $_errorMessage=null;
        switch($code){
            case '500':
                $_errorMessage['error']='数据库链接错误';
                break;
            case '301':
                $_errorMessage['error']='参数错误';
                break;
            case '404':
                $_errorMessage['error']='未知错误';
                break;                
        }
        return $_errorMessage;
    }
}