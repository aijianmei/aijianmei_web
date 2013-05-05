<?php
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 mysql_select_db('aijianmei', $con);
 // $GB2312string = iconv("UTF-8","gb2312//IGNORE",$RequestAjaxString);
 // mysql_query("set names gb2312");
 $usename = $_GET['usename'];
$result = mysql_query("SELECT * FROM usename WHERE name='$usename'");
$info = mysql_fetch_array($result);
// header("Content-type:text/html;charset=GB2312");
if($info){
	$use = $_GET['usename'];
	echo "失败!用户名" + $use + "已经被注册";
}
else{
	echo "恭喜!用户名没有被注册";
}
// while($row = mysql_fetch_array($result))
//   {
//   echo $row['name'];
//   echo $usename;
//   }

mysql_close($con);
?>