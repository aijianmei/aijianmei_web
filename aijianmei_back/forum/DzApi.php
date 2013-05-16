<?php
define('APPTYPEID', 0);
define('CURSCRIPT', 'member');

require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();
//print_r($_G['setting']);
//print_r($_G['setting']['reginput']);
$inNameFd=$_G['setting']['reginput'];
$dreferer = dreferer();
//echo $turl=$_G['setting']['discuzurl']."/member.php?mod=register";

/*<input type="hidden" name="regsubmit" value="yes" />
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="referer" value="$dreferer" />
			<input type="hidden" name="activationauth" value="{if $_GET[action] == 'activation'}$activationauth{/if}" />*/

$url = $_G['setting']['discuzurl']."/member.php?mod=register";
$post_data = array(
    $inNameFd['username'] => 'test001',
    $inNameFd['password'] => '123456',
    $inNameFd['password2'] => '123456',
    $inNameFd['email'] => 'kontem123@t.com',
    'regsubmit' =>'yes',
    'formhash' =>FORMHASH,
    'referer'=>$dreferer,
	'activationauth'=>'',
	'aijianmeiDzapi'=>md5('ckon'),
);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
print_r($output);
