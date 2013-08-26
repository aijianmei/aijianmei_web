<?php
/*
 */
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
function reNorTime($k=0){
  if($k!=0&&$k>0){
    $timeDate=time() + ($k*3600*24);
  }elseif($k!=0&&$k<0){
    $timeDate=time() - abs($k*3600*24);
  }else{
    $timeDate=time();
  }
  return date("Ymd",$timeDate);
}

class comfunc{
	public function __construct() {
		$this->db = new ckmysql ();
		return $this;
	}
}