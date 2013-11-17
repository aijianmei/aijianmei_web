<?php
error_reporting ( 0 );
header ( "charset=utf-8" );
$_dbConfig = require_once ('config.inc.php');


define('_DBHOST',$_dbConfig ['DB_HOST']);
define('_DBUSER',$_dbConfig ['DB_USER']);
define('_DBPASSWORD',$_dbConfig ['DB_PWD']);
define('_DBPORT','3306');
define('_DBNAME','aijianmei');

require_once ('db.class.php');//mysql db类
require_once ('iosmodel.php');//model

class msgPush{
	public function __construct(){
		$this->db=new ckmysql();
		return $this;
	}
	public function _pushArticle(){
		$aid=$_REQUEST['id']?intval($_REQUEST['id']):'';
		if(empty($aid)){
			ob_end_clean();
			echo "非法请求!";
			exit;
		}
		$sql="select * from ai_article where id={$aid}";
		$result=$this->db->_query($sql);
		return $result[0]['title'];
	}
	public function _pushVideo(){
		$message=$_REQUEST['msg']?(string)$_REQUEST['msg']:'';
		if(!empty($message)){
			return $message;
		}else{
			exit;
		}
	}
}


define ( 'SITE_PATH', dirname ( dirname ( __FILE__ ) ) ); // 路径常量定义

$msgPush=new msgPush();
$action='_'.$_REQUEST['act'];
$message=$msgPush->$action();

// 这里是我们上面得到的deviceToken，直接复制过来（记得去掉空格）
$deviceToken = 'b44297a10454c9ab2adb72c320da72154e5119bc472a1d6da984741aba799dd6';

// Put your private key's passphrase here:
$passphrase = 'aijianmei2012';

// Put your alert message here:
//$message = 'My first push test!';
//$message;
////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
//这个为正是的发布地址
 //$fp = stream_socket_client(“ssl://gateway.push.apple.com:2195“, $err, $errstr, 60, //STREAM_CLIENT_CONNECT, $ctx);
//这个是沙盒测试地址，发布到appstore后记得修改哦
$fp = stream_socket_client(
'ssl://gateway.sandbox.push.apple.com:2195', $err,
$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
'alert' => $message,
'sound' => 'default'
);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
echo 'Message not delivered' . PHP_EOL;
else
echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
?>