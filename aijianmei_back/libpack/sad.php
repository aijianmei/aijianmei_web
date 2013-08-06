<?php
$f = 'FZSJSJW.TTF';
$s = 'IIIIIIIIWWWWllllLoOWi中华人民共和国';
$z = 14;

$b = imagettfbbox($z,0,$f,$s);

$w = abs($b[2] - $b[0]);
$h = abs($b[5] - $b[3]);

$im = imagecreatetruecolor($w+10, $h+10);
$bei = imagecolorallocate($im, 255, 255, 255);
$red  = imagecolorallocate($im, 255, 0, 0);

imagefilledrectangle($im,5,5,$w,$h,$red);
imagettftext($im, $z, 0, 0, $h, $bei, $f, $s);

imagepng($im,'test.png');
imagedestroy($im);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#apDiv1 {position:absolute;left:10px;top:150px;z-index:1;background-color: #99FFFF;font-size: <?=$z+2?>px;font-family: Arial;}
#apDiv2 {position:absolute;left:10px;top:100px;z-index:2;background-color: #FFFF00;font-size: <?=$z+2?>px;font-family: Arial;}
-->
</style>
</head>
<body>
<div id="apDiv1" style="width:<?=$w?>px;height:<?=$h?>px;"><?=$s?></div>
<div id="apDiv2" style="width:<?=$w?>px;height:<?=$h?>px;"></div>
<img src="test.png?rand=<?php echo rand(); ?>">
</body>
</html>