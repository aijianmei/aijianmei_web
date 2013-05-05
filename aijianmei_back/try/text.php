<?php
	if($_GET['name']){
		$outside = $_GET['name'];
		echo $outside;
	}
		

	if($_GET['ajax'] == 'yes'){
		$arr = array(array("1","2","3","4","5","6","7","8","9","10",),"outside");	
		echo json_encode($arr);// json_encode 这个函数是专门把返回的数组编码，否者返回的值，Ajax就不能得到值
	}
		
?>