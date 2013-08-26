<?php

/*
	is(emoji_docomo_to_unified($test_docomo),	$test_unified, "DoCoMo -> Unified");
	is(emoji_kddi_to_unified($test_kddi),		$test_unified, "KDDI -> Unified");
	is(emoji_softbank_to_unified($test_iphone),	$test_unified, "Softbank -> Unified");
	is(emoji_google_to_unified($test_google),	$test_unified, "Google -> Unified");*/

//error_reporting ( 0 );
header ( "charset=utf-8" );
	include('emoji.php');


$con = mysql_connect('localhost', 'root', '');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_query("set names utf8");
mysql_select_db("aijianmeitmp", $con);

	
	
	# browser sniffing tells us that a docomo phone
	# submitted this text
	//$string="one emoji symbol \"tiger\", it is "U0001f42f" in iOS5, but "ue050" in earlier iOS version";
	$str="\ud83d\ude00";
	//$str = emoji_softbank_to_unified($str);
	$str=urlencode($str);
echo $str;exit;
	$res=emoji_html_to_unified(emoji_docomo_to_unified($str));
	$res=emoji_html_to_unified(emoji_kddi_to_unified($str));
	$res=emoji_html_to_unified(emoji_softbank_to_unified($str));
	/*$content=$_POST['message'];
	$sql="INSERT INTO ai_comments (uid,content,parent_id,parent_type,create_time,source,topParent)
 VALUES ('264','" . htmlspecialchars(emoji_unified_to_html($content)) . "','111','1'," . time () . ",'','0')";

$result = mysql_query($sql);
	$clean_text = emoji_docomo_to_unified($_POST['message']);
	$html = emoji_unified_to_html($clean_text);
	$sql="select * from ai_comments where id=174";
	$result = mysql_query($sql);
	while($row= mysql_fetch_assoc($result)){
		$data[]=$row;
	}
	//var_dump(emoji_html_to_unified( htmlspecialchars_decode($data[0]['content'])));
	$res=emoji_html_to_unified(htmlspecialchars_decode($data[0]['content']));
	//exit;
	/*	$clean_text = emoji_kddi_to_unified($_POST['message']);
	echo $html = emoji_unified_to_html($clean_text);
	
		$clean_text = emoji_softbank_to_unified($_POST['message']);
	echo $html = emoji_unified_to_html($clean_text);
	
		$clean_text = emoji_google_to_unified($_POST['message']);
	echo $html = emoji_unified_to_html($clean_text);
	exit;
	ob_start();
	var_dump($_GET);
	var_dump($_POST);
	var_dump($html);
	var_dump($clean_text);
	$info=ob_get_contents();
	ob_end_clean();
	file_put_contents("tmp_emoji.txt",$info);
	if(!empty($_POST['message'])){
	$data[0]['uid']="0";
	$data [0] ['errorCode'] = '0';
	$data [0] ['html']='U+1F605';
	echo json_encode($data);
	}
	exit;*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="emoji.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?php echo $res; ?>
<body>
</body>
</html>
