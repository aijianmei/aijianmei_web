<?php 
class RegModel extends Model {
	public function getUserNameByEmail($email)
	{
		$sql=$result=null;
		$sql="select * from ai_user where email='".$email."'";
		$result=M('')->query($sql);
		return $result;
  }
  public function dbUpdateInfo($table,$data,$where){
  		$updateStr=null;
  		if(empty($table)||empty($data))return false;
  		
  		if(isset($where)&&!is_string($where))return false;
  		
  		if(is_array($data)){
  			foreach ($data as $key => $value) {
  			 	$updateStr.=empty($updateStr)? $key."=>'".$value."'" : ",".$key."=>'".$value."'";
  			}
  		}elseif(is_string($data)){
  			$updateStr=(string)$data;
  		}else{
  			return false;	
  		}
  		$upsql="UPDATE ".$table." SET ".$updateStr." WHERE ".$where."";
  		M('')->query($upsql);
  }
  public function dbInsertInfo($table,$data){
  		$insertKeyStr=$insertValStr=$insertString=null;
  		if(empty($table)||empty($data))return false;

  		if(is_array($data)){
  			foreach ($data as $key => $value) {
  			 	$insertKeyStr.=empty($insertKeyStr)? $key : ",".$key;
  			 	$insertValStr.=empty($insertValStr)? "'".$value."'": ",'".$value."'";
  			}
  			$insertString="(".$insertKeyStr.")VALUES (".$insertValStr.")";
  		}elseif(is_string($data)){
  			$updateStr=(string)$data;
  			$insertString=$updateStr;
  		}else{
  			return false;	
  		}
  		$sql="INSERT INTO $table $insertString";
  		return M('')->query($sql);
  }
  public function getUserId($userEmail,$password){
  	
  	$sql="select uid from ai_user where email='".$userEmail."' and password='".md5($password)."'";
		$result=M('')->query($sql);
		return $result[0]['uid'];	
  }
}
?>