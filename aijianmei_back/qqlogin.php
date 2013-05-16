<?php
//error_reporting(0);
session_start();

define('SITE_PATH', getcwd());
  //应用的APPID
  $app_id = "100328471";
  //应用的APPKEY
  $app_secret = "c1f91879fc99003bb191b801aa6c3af3";
  //成功授权后的回调地址
  $my_url = "aijianmei.com/qqlogin.php";

  //Step1：获取Authorization Code
  session_start();
  $code = $_REQUEST["code"];
  if(empty($code)) 
  {
     //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); 
     //拼接URL     
     $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'];
     echo("<script> top.location.href='" . $dialog_url . "'</script>");
  }

  //Step2：通过Authorization Code获取Access Token
  if($_REQUEST['state'] == $_SESSION['state']) 
  {
     //拼接URL   
     $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
     . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
     . "&client_secret=" . $app_secret . "&code=" . $code;
     
    $ch = curl_init($token_url) ;  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $response = curl_exec($ch) ;  
    curl_close($ch);
     if (strpos($response, "callback") !== false)
     {
        $lpos = strpos($response, "(");
        $rpos = strrpos($response, ")");
        $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        $msg = json_decode($response);
        if (isset($msg->error))
        {
           echo "<h3>error:</h3>" . $msg->error;
           echo "<h3>msg  :</h3>" . $msg->error_description;
           exit;
        }
     }

     //Step3：使用Access Token来获取用户的OpenID
    $params = array();
    parse_str($response, $params);
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
    // $str  = file_get_contents($graph_url);
    $ch = curl_init($graph_url) ;  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $str = curl_exec($ch) ;  
    curl_close($ch);
     if (strpos($str, "callback") !== false)
     {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
     }
     $user = json_decode($str);
     if (isset($user->error))
     {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
     }
     //echo("Hello " . $user->openid);
     
     $infourl="https://graph.qq.com/user/get_user_info?access_token=".$params['access_token']."&oauth_consumer_key=100328471&openid=$user->openid";
     $ch = curl_init($infourl) ;  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
    $userinfo =(array)json_decode(curl_exec($ch)) ;
    $_dbConfig=require_once('config.inc.php');
    $db = mysql_connect($_dbConfig['DB_HOST'], $_dbConfig['DB_USER'], $_dbConfig['DB_PWD']);
    mysql_select_db('aijianmei', $db);
    mysql_query("set names 'utf8'");
    $check_sql="select * from ai_user where uname='".$userinfo['nickname' ]."' and qqopenid='".$user->openid."'";
    $res = mysql_query($check_sql, $db);
    $checkres = mysql_fetch_assoc($res);
    $uid=null;
    if(!$checkres){
        $userinfo['gender']= $userinfo['gender']=='男'? 1:0;
        $sql = 'insert into ai_user (`uname`,`sex`,`location`,`is_active`,`ctime`,`qqopenid`,is_init) values ("'.$userinfo['nickname'].'","'.$userinfo['gender'].'","","1","'.time().'","'.$user->openid.'","1")';
        mysql_query($sql, $db);
        $uid = mysql_insert_id();
        $other_sql = 'INSERT INTO `aijianmei`.`ai_others` 
                ( `uid`, `profileImageUrl`) VALUES ( 
                 "'.$uid.'", "'.$userinfo['figureurl_1'].'")';
        mysql_query($other_sql);
        
    }
    else{
      $upsql="update `aijianmei`.`ai_others` set profileImageUrl='".$userinfo['figureurl_1']."' where uid='".$checkres['uid']."'";
      mysql_query($upsql, $db);
    }
    $post_data=array(
        'qquid'=> $checkres['uid']?$checkres['uid']:$uid,
        'qqapi'=> 'login',
    );
    $url="index.php?qquid=".$post_data['qquid']."&qqapi=login";
    header("location:$url");
  }
  else 
  {
  echo("The state does not match. You may be a victim of CSRF.");
  }
?>