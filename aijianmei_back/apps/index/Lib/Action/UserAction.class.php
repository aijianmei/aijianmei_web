<?php 
class UserAction extends Action {
    function getSavePath(){
        $savePath = SITE_PATH.'/data/uploads/avatar'.convertUidToPath($this->uid);
        if( !file_exists( $savePath ) ) mk_dir( $savePath  );
        return $savePath;
    }
	public function setinfo()
	{
		$this->display('GetPwd_First');
	}
	public function sendemail()
	{
		if ((md5(strtoupper($_POST['verifyStr'])) != $_SESSION['verify'])&&$_SESSION['is_PortMail']!=1){
			if($_POST['sendact']!='resend'){
				redirect(U('index/User/setinfo'));
			}
		}
		if($_GET['sendact']=='resend'){$_POST['email']=$_SESSION['is_PortMailname'];}
		$_SESSION['is_PortMail']=1;
		$_SESSION['is_PortMailname']=$_POST['email'];
		$codeurl=md5("aijianmei".$_POST['email']);
		$toemail=$_POST['email'];
		$check_sql="select * from ai_returncode_log where codeurl='".$codeurl."' and uname='".$_POST['email']."' and out_time>".time();
		$checkArr=M('')->query($check_sql);		
		if(!$checkArr[0]['id']){
			$_baseUrl=SITE_URL."/index.php?app=index&mod=User&act=getmailcode&uname=".$_POST['email']."&acitve=";
			$_baseUrl.=$codeurl;
			$out_time=time()+3600;
			$out_time_str=date("Y-m-d H:i:s",$out_time);
			$insertSql="INSERT INTO ai_returncode_log (codeurl,uname,out_time,create_time)VALUES ('".$codeurl."','".$_POST['email']."','".$out_time."','".time()."')";
			M('')->query($insertSql);
			$service = service('Mail');
			$subject = '重置密码邮件|爱健美网';
			$content = '
			亲爱的用户：您好！</br>
					您收到这封这封电子邮件是因为您申请了一个新的密码。假如这不是您本人所申请, 请不用理会这封电子邮件, 但是如果您持续收到这类的信件骚扰, 请您尽快联络管理员。
					要使用新的密码, 请使用以下链接启用密码。</br>
					<a href="'.$_baseUrl.'">'.$_baseUrl.'</a>
					(如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可。该链接使用后将立即失效。)</br>
					注意:请您在收到邮件1个小时内('.$out_time_str.'前)使用，否则该链接将会失效。</br>
					爱健美网 '.SITE_URL;
			@$info = $service->send_email($toemail, $subject, $content);
		}
		else{
			$out_time=$checkArr[0]['out_time'];
			$out_time_str=date("Y-m-d H:i:s",$out_time);
			$_baseUrl=SITE_URL."/index.php?app=index&mod=User&act=getmailcode&uname=".$_POST['email']."&acitve=";
			$_baseUrl.=$codeurl;
			$service = service('Mail');
			$subject = '重置密码邮件|爱健美网';
			$content = '
					亲爱的用户：您好！</br>
					您收到这封这封电子邮件是因为您申请了一个新的密码。假如这不是您本人所申请, 请不用理会这封电子邮件, 但是如果您持续收到这类的信件骚扰, 请您尽快联络管理员。
					要使用新的密码, 请使用以下链接启用密码。</br>
					<a href="'.$_baseUrl.'">'.$_baseUrl.'</a>
					(如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可。该链接使用后将立即失效。)</br>
					注意:请您在收到邮件1个小时内('.$out_time_str.'前)使用，否则该链接将会失效。</br>
					爱健美网 '.SITE_URL;
			@$info = $service->send_email($toemail, $subject, $content);
		}
        if($_POST['sendact']=='resend'){
			echo json_encode($info);
			exit;
		}
		$this->assign('is_send', $info);
		$this->assign('email', addslashes($_POST['email']));
		$this->display('GetPwd_Second');
	}
	
	public function getmailcode()
	{
		$is_passver=0;
		if(md5("aijianmei".$_GET['uname'])==$_GET['acitve']){
			$getLogSql="select * from ai_returncode_log where uname='".addslashes($_GET['uname'])."' and out_time>".time();
			$getLogInfo=M('')->query($getLogSql);
			if($getLogInfo[0]['id']>0){
				$is_passver=1;
				$_SESSION['psonkey']=md5($_GET['uname']);
			}
		}
		if($is_passver!=1){redirect(U('index/User/setinfo'));}
		$this->assign('email',$_GET['uname']);
		$this->display('GetPwd_Third');
	}
	
	public function updateUinfo()
	{	
		if($_SESSION['psonkey']==md5($_POST['email'])){
			$sql="UPDATE  `aijianmei`.`ai_user` SET  `password` = '".md5($_POST['password'])."' WHERE  `ai_user`.`email` ='".$_POST['email']."'";
			M('')->query($sql);
			$shopupsql="UPDATE ecs_users SET  password = '".md5($_POST['password'])."' WHERE  email ='".$_POST['email']."'";
			M('')->query($shopupsql);
			$dsql="DELETE FROM `aijianmei`.`ai_returncode_log` WHERE `ai_returncode_log`.`uname` = '".$_POST['email']."'";
			M('')->query($dsql);
			$uidsql="select * from ai_user where email ='".$_POST['email']."'";
			$uid=M('')->query($uidsql);
			S('S_userInfo_'. $uid[0]['uid'],null);
			unset($_SESSION['psonkey']);
		}else{
			redirect(U('index/User/setinfo'));
		}
		//print_r($_SESSION['psonkey']);
		$this->display('GetPwd_Fourth');
	}
	public function register(){
		if($_SESSION['regrefer_url']==''&& $_SESSION['refer_url']!=''){
			$_SESSION['regrefer_url'] = $_SESSION['refer_url'];
		}
		$this->display('register_1');
	}
	public function doregister()
	{
		//$_SESSION['allowbackreg']=$_SESSION['allowbackmid']=null;
		if($_SESSION['sinalogin']==1){$_SESSION['deslogin']=1;}
		$userEmail=addslashes($_POST['email']);
		$password=addslashes($_POST['password']);
		$repassword=addslashes($_POST['repassword']);
		$checksql="select * from ai_user where email='".$userEmail."'";
		$check=M('')->query($checksql);
		if(!$check&&($password==$repassword)){
			//第三方注册 start
			if($_SESSION['mid']>0&&$_SESSION['sinalogin']==1){
				$upsql=$mid=null;
				$mid=intval($_SESSION['mid']);
				$upsql="UPDATE ai_user SET email = '".$userEmail."',password='".md5($password)."' WHERE uid =$mid";
				M('')->query($upsql);
				$getSimgSql="select * from ai_others where uid='".$_SESSION['mid']."'";
				$ImgArr=M('')->query($getSimgSql);
				$this->assign('imgurl',$ImgArr[0]['profileImageUrl']);
				$_SESSION['otherlogin']=1;
				$getuidname="select * from ai_user where uid='".$mid."'";
				$getuidinfo=M('')->query($getuidname);
				
				include_once('shopApi.php');
				$sdata=null;
				$sdata['uname']=addslashes($getuidinfo[0]['uname']);
				$sdata['password']=addslashes($password);
				$sdata['email']   =addslashes($userEmail);
				_postCurlRegister($sdata);	
			}
			else
			{
				$_SESSION['deslogin']=1;
				$_SESSION['locallogin']=1;
				$insertSql="INSERT INTO ai_user (email,password,ctime,is_active,is_init,identity)VALUES ('".$userEmail."','".md5($password)."','".time()."','1','1','1')";
				M('')->query($insertSql);
				$getuidsql="select uid from ai_user where email='".$userEmail."' and password='".md5($password)."'";
				$uidinfo=M('')->query($getuidsql);
				$mid=$uidinfo[0]['uid'];
				$_SESSION['locallogin_password']=$password;
				//service('Passport')->login($uidinfo[0]['uid']);
			}
			$_SESSION['allowbackreg']=1;
			$_SESSION['allowbackmid']=$mid;
			$_SESSION['loginIcpkey']=md5('aijianmei'.$mid);
		}
		$this->display('register_2');
	}
	
	public function setchannelinfo(){
		if($_SESSION['loginIcpkey']!=md5('aijianmei'.$_SESSION['allowbackmid'])){
			$_SESSION=null;
			redirect(U('index/index/index'));
		}
		if($_SESSION['allowbackreg']==1){
			$mid=$_SESSION['allowbackmid'];
			if($mid>0&&addslashes($_GET['psd'])=='sub'){
				$keyTmp=array();
				foreach($_POST['sk'] as $k=>$v){
					if(!in_array($v,$keyTmp)){
						$keyTmp[]=$v;
					}	
				}
				$checksql="select * from ai_user_keywords where uid='".$mid."'";
				$checkinfo=M('')->query($checksql);
				if(!$checkinfo){
					$insertSql="insert into ai_user_keywords (uid,keyword)values('".$mid."','".serialize($keyTmp)."')";
					M('')->query($insertSql);
				}
				if($_SESSION['otherlogin']==1){
					service('Passport')->loginLocal($mid);
					redirect(U('index/user/edituserinfo'));
					// if($_SESSION['refer_url']!=''){
						// redirect($_SESSION['refer_url']);
					// }else{
						// redirect(U('index/index/index'));
					// }
				}else{
					redirect(U('index/user/fishuserinfo'));
				}
			}
		}
		$this->display('register_3');
	}
	
	public function fishuserinfo(){
		//注册流程权值判断
		if($_SESSION['loginIcpkey']!=md5('aijianmei'.$_SESSION['allowbackmid'])){
			$_SESSION=null;
			redirect(U('index/index/index'));
		}
		$username=$description=$domain=$userArea=$usercity=null;
		$imgurl=null;
		if($_SESSION['locallogin']==1){
			$mid=$_SESSION['allowbackmid'];
			$getUserNameSql="select * from ai_user where uid='".$mid."'";
			$UserNameInfo=M('')->query($getUserNameSql);
			$username=$UserNameInfo[0]['uname'];
			$usersex=$UserNameInfo[0]['sex'];
			$userinfo['province']=$UserNameInfo[0]['province'];
			$userinfo['city']=$UserNameInfo[0]['city'];
			$getUserKeywordSql="select * from ai_user_keywords where uid='".$mid."'";
			$getUserKeyword=M('')->query($getUserKeywordSql);
			$getUserKeyword=unserialize($getUserKeyword[0]['keyword']);
			
			$otherinfoSql="select * from ai_others where uid='".$mid."'";
			$otherinfo=M('')->query($otherinfoSql);
			$description=$otherinfo[0]['description'];
			$domain=$otherinfo[0]['domain'];
			$cemail=$otherinfo[0]['cemail'];
			$ctell=$otherinfo[0]['ctell'];
			
			if(!empty($UserNameInfo[0]['qqopenid'])){
				$user_type='3';
				$qqimg=$otherinfo[0]['profileImageUrl'];
				$this->assign('qqimg',$qqimg);
			}elseif(!empty($otherinfo[0]['profileImageUrl'])){
				$user_type='2';
				$sinaimg=$otherinfo[0]['profileImageUrl'];
				$this->assign('sinaimg',$sinaimg);
			}else{
				$user_type='1';
			}
			$this->assign('user_type',$user_type);
			$filename='data/uploads/avatar/'.$mid.'/middle.png';
			$this->assign('localimg',$filename);
			if(is_file($filename)&&$UserNameInfo[0]['upic_type']==1){$imgurl=$filename;}else{
				$imgurl=$otherinfo[0]['profileImageUrl'];
			}

			//$filename='data/uploads/avatar/'.$mid.'/middle.jpg';
			$filename='data/uploads/avatar/'.$mid.'/middle.jpg';
			$this->assign('localimg',$filename);
			if(is_file($filename)) $imgurl=$filename;
			$this->assign('UserKeyword',$getUserKeyword);
		}elseif($_SESSION['otherlogin']==1){
			$mid=$_SESSION['allowbackmid'];
			$getUserNameSql="select * from ai_user where uid='".$mid."'";
			$UserNameInfo=M('')->query($getUserNameSql);
			$username=$UserNameInfo[0]['uname'];
			$usersex=$UserNameInfo[0]['sex'];
			$userinfo['province']=$UserNameInfo[0]['province'];
			$userinfo['city']=$UserNameInfo[0]['city'];
			$getSimgSql="select * from ai_others where uid='".$mid."'";
			$ImgArr=M('')->query($getSimgSql);
			$imgurl=$ImgArr[0]['profileImageUrl'];
			$description=$ImgArr[0]['description'];
			$domain=$ImgArr[0]['domain'];
			$cemail=$otherinfo[0]['cemail'];
			$ctell=$otherinfo[0]['ctell'];
			$locationInfo=$ImgArr[0]['location'];
			$userLocationInfo=explode(' ',$locationInfo);
			$userArea=$userLocationInfo[0];
			$usercity=$userLocationInfo[1];
		}
		
		//地区选择
		$area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
        $this->assign('children', $child);
        $this->assign('area', $area);
		//}}
		$this->assign('ctell',$ctell);
		$this->assign('cemail',$cemail);
		$this->assign('usersex',$usersex);
		$this->assign('userinfo',$userinfo);
		$this->assign('userArea',$userArea);
		$this->assign('usercity',$usercity);
		$this->assign('domain',$domain);
		$this->assign('description',$description);
		$this->assign('imgurl',$imgurl);
		$this->assign('username',$username);
		$this->assign('cssFile','datum');
		$this->display('datum');
	}
	public function edituserinfo(){
		if(!$_SESSION['mid']){
			if($_SESSION['loginIcpkey']!=md5('aijianmei'.$_SESSION['allowbackmid'])){
				$_SESSION=null;
				redirect(U('index/index/index'));
			}
			$mid=$_SESSION['allowbackmid'];
		}else{
			$mid=$_SESSION['mid'];
		}
		//地区选择
		$area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
		//$areaAll = M('area')->order('`area_id` ASC')->findAll();
        $this->assign('children', $child);
        $this->assign('area', $area);
		//}}
		
		
		$username=$description=$domain=$userArea=$usercity=null;
		$imgurl=null;
		if($mid>0){
			//$mid=$_SESSION['allowbackmid'];
			$getUserNameSql="select * from ai_user where uid='".$mid."'";
			$UserNameInfo=M('')->query($getUserNameSql);
			$username=$UserNameInfo[0]['uname'];
			$usersex=$UserNameInfo[0]['sex'];
			$upic_type=$UserNameInfo[0]['upic_type'];
			if($UserNameInfo[0]['location']!=''&&$UserNameInfo[0]['province']==0&&$UserNameInfo[0]['city']==0){
				$locationArr=$UserNameInfo[0]['location'];
				$locationInfo=explode(' ',$UserNameInfo[0]['location']);
				
				$sql="select * from ai_area where title like '%".$locationInfo[0]."%'";
				$provinceinfo=M('')->query($sql);
				$UserNameInfo[0]['province']=$provinceinfo[0]['area_id'];				
				
				$sql="select * from ai_area where title like '%".$locationInfo[1]."%'";
				$cityinfo=M('')->query($sql);
				$UserNameInfo[0]['city']=$cityinfo[0]['area_id'];
			}
			
			$userinfo['province']=$UserNameInfo[0]['province'];
			$userinfo['city']=$UserNameInfo[0]['city'];

			$getUserKeywordSql="select * from ai_user_keywords where uid='".$mid."'";
			$getUserKeyword=M('')->query($getUserKeywordSql);
			$getUserKeyword=unserialize($getUserKeyword[0]['keyword']);

			$otherinfoSql="select * from ai_others where uid='".$mid."'";
			$otherinfo=M('')->query($otherinfoSql);
			$description=$otherinfo[0]['description'];
			$domain=$otherinfo[0]['domain'];
			$cemail=$otherinfo[0]['cemail'];
			$ctell=$otherinfo[0]['ctell'];
			if(!empty($UserNameInfo[0]['qqopenid'])){
				$user_type='3';
				$qqimg=$otherinfo[0]['profileImageUrl'];
				$this->assign('qqimg',$qqimg);
			}elseif(!empty($otherinfo[0]['profileImageUrl'])){
				$user_type='2';
				$sinaimg=$otherinfo[0]['profileImageUrl'];
				$this->assign('sinaimg',$sinaimg);
			}else{
				$user_type='1';
			}
			$this->assign('user_type',$user_type);
			$filename='data/uploads/avatar/'.$mid.'/middle.jpg';
			if(!is_file(dirname(__FILE__).$filename)){$filename='Templates/images/login_pic.jpg';}
			
			$this->assign('localimg',$filename);
			if($UserNameInfo[0]['upic_type']==1){
					$filename='data/uploads/avatar/'.$mid.'/middle.jpg';
					if(is_file($filename)){
						$imgurl=$filename;
					}else{
						$imgurl='Templates/images/login_pic.jpg';
						}
				}else{
					  $imgurl=$otherinfo[0]['profileImageUrl'];
			}
			
			
			if(is_file('data/uploads/avatar/'.$mid.'/middle.jpg')){
				$this->assign('localimg','data/uploads/avatar/'.$mid.'/middle.jpg');
			}else{
				$this->assign('localimg','Templates/images/login_pic.jpg');
			}
			
			
			
			$healthinfoSql="select * from ai_user_health_info where uid='".$mid."'";
			$healthinfo=M('')->query($healthinfoSql);
			
			$this->assign('healthinfo',$healthinfo[0]);
			
			$this->assign('UserKeyword',$getUserKeyword);
		}
		

		$this->assign('upic_type',$upic_type);
		$this->assign('ctell',$ctell);
		$this->assign('cemail',$cemail);
		$this->assign('usersex',$usersex);
		$this->assign('userinfo',$userinfo);
		$this->assign('userArea',$userArea);
		$this->assign('usercity',$usercity);
		$this->assign('domain',$domain);
		$this->assign('description',$description);
		$this->assign('imgurl',$imgurl);
		$this->assign('username',$username);
		$this->assign('cssFile','datum');
		$this->display('edit_userinfo');
	}
	public function saveuserinfo(){
		//print_r($_POST);
		//注册流程权值判断
		if(!$_SESSION['mid']){
			if($_SESSION['loginIcpkey']!=md5('aijianmei'.$_SESSION['allowbackmid'])){
				$_SESSION=null;
				redirect(U('index/index/index'));
			}
			$mid=$_SESSION['allowbackmid'];
		}else{
			$mid=$_SESSION['mid'];
		}
		$username=$_POST['username'];
		if($mid>0&&$username!=''&&$_GET['args']=='uinfo'){
			if($_SESSION['otherlogin']==1||$_SESSION['locallogin']==1){
			$upsql=null;
			//$upsql="UPDATE ai_user SET uname = '".$username."',sex='".$_POST['sex']."',province='".$_POST['province']."',city='".$_POST['city']."' WHERE uid =$mid";
			$upsql="UPDATE ai_user SET uname = '".$username."',sex=".$_POST['sex'].",province=".$_POST['province'].",city='".$_POST['cityvalue']."',upic_type='1' WHERE uid =$mid";
			M('')->query($upsql);
			
			$keyTmp=array();
				foreach($_POST['keyword'] as $k=>$v){
					if(!in_array($v,$keyTmp)){
						$keyTmp[]=$v;
					}	
				}
			$checkkeywordSql="select * from ai_user_keywords WHERE uid =$mid";
			$cres=M('')->query($checkkeywordSql);
			if($cres){
				$upsql=null;
				$upsql="UPDATE ai_user_keywords SET keyword = '".serialize($keyTmp)."' WHERE uid =$mid";
				M('')->query($upsql);
			}else{
				$upsql=null;
				$upsql="INSERT INTO  ai_user_keywords (uid,keyword)values('".$mid."','".serialize($keyTmp)."')";
				M('')->query($upsql);
			}
			$checksql=null;
			$checksql="select * from ai_user_health_info where uid =$mid";
			$cres=M('')->query($checksql);
			if($cres){
				$upsql=null;
				if($_POST['dt_weight_finish']!=''||$_POST['dt_height_finish']!=''||$_POST['dt_year_finish']!=''){
					$upsql="UPDATE ai_user_health_info SET body_weight = '".$_POST['dt_weight_finish']."'
					,height = '".$_POST['dt_height_finish']."'
					,age = '".$_POST['dt_year_finish']."' WHERE uid =$mid";
					M('')->query($upsql);
				}
			}else{
				$insertSql="INSERT INTO  `aijianmei`.`ai_user_health_info` (`uid` ,`body_weight` ,`height` ,`age`)
				VALUES ($mid, '".$_POST['dt_weight_finish']."','".$_POST['dt_height_finish']."','".$_POST['dt_year_finish']."')";
				M('')->query($insertSql);
			}
			
			$sql="select uname,email from ai_user where uid =$mid";
			$shopinserinfo=M('')->query($sql);
			
			include_once('shopApi.php');
			$sdata=null;
			$sdata['uname']=addslashes($shopinserinfo[0]['uname']);
			$sdata['password']=addslashes($_SESSION['locallogin_password']);
			$sdata['email']   =addslashes($shopinserinfo[0]['email']);
			
			_postCurlRegister($sdata);
			service('Passport')->loginLocal($sdata['uname'],$sdata['password'],1);
			$getUidSql='select user_id,user_name,email from ecs_users where user_name="'.$sdata['uname'].'"';
            $uid = M('')->query($getUidSql);
            $_SESSION['user_id']   = $uid[0]['user_id'];
            $_SESSION['user_name'] = $uid[0]['user_name'];
            $_SESSION['email']     = $uid[0]['email'];
			$_SESSION['ways']++;

			if($_SESSION['mid']>0){
				$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($mid);
			}
			@setcookie("ECS[user_id]",  $getShopUinfo[0]['user_id'], time()+3600*24*30);
			@setcookie("ECS[password]", md5($_POST['password']), time()+3600*24*30);
			
			
			
			$checkotherinfosql="select * from ai_others where uid=$mid";
			$res=M('')->query($checkotherinfosql);
			if(!$res){
				$insertsql=null;
				$other['uid'] = $mid;
				$other['mediaID'] = '3';
				$other['friendsCount'] = 0;
				$other['favouritesCount'] =0;
				$other['profileImageUrl'] = '';
				$other['mediaUserID'] = '';
				$other['url']  = '';
				$other['homepage'] = '';
				$other['description'] = $_POST['description'];
				$other['domain'] = $_POST['sina_domain'];
				$other['followersCount'] = 0;
				$other['statusesCount']  = 0;
				$other['personID'] = 0;
				foreach($other as $key => $value){
					$insertstr.=empty($insertstr)?$key:','.$key;
					$valuestr.=empty($valuestr)?"'".$value."'":",'".$value."'";
				}
				$insertsql = "INSERT INTO `aijianmei`.`ai_others` ($insertstr) VALUES ($valuestr)";
				M('')->query($insertsql);
			}
			else{
				$upsql=null;
				$upsql="UPDATE ai_others SET description = '".$_POST['description']."',domain='".$_POST['sina_domain']."' WHERE uid =$mid";
				M('')->query($upsql);
			}
			}
		}elseif($mid>0&&$_GET['args']=='uppwd'){
			if($_POST['password']==$_POST['repassword']){
				$upsql="update ai_user SET password = '".md5($_POST['password'])."' WHERE password ='".md5($_POST['oldpassword'])."'";
				M('')->query($upsql);
			}
		}elseif($mid>0&&$_GET['args']=='upconnect'){
			if(!empty($_POST['cemail'])&&!empty($_POST['ctell'])){
				$upsql=null;
				$upsql="update ai_others SET cemail = '".$_POST['cemail']."',ctell = '".$_POST['ctell']."' WHERE uid =$mid";
				M('')->query($upsql);
			}
		}
		$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($mid);
		if($_SESSION['regrefer_url']!=''){
			$_SESSION['deslogin']=0;
			$_SESSION['regrefer_msg']='恭喜你成功注册“爱健美”';
			redirect(U('index/Public/Transit'));
		} 
		//service('Passport')->login($mid);
		
		redirect(U('index/Index/index'));
	}
public function saveedituserinfo(){
		//print_r($_POST);
		//注册流程权值判断
		$mid=$_SESSION['mid'];
		$username=$_POST['username'];
		if($mid>0&&$username!=''&&$_GET['args']=='uinfo'){
			if($mid>0){
			$oldusernameinfo=M('user')->where(array('uid'=>$mid))->find();
			//print_r($oldusernameinfo);exit;
			$upsql=null;
			$upsql="UPDATE ai_user SET uname = '".$username."',sex=".$_POST['sex'].",province=".$_POST['province'].",city='".$_POST['cityvalue']."',upic_type='".$_POST['upic_type']."' WHERE uid =$mid";
			M('')->query($upsql);
			$upsql="UPDATE ecs_users SET user_name = '".$username."' WHERE user_name ='".$oldusernameinfo['uname']."'";
			M('')->query($upsql);

			$keyTmp=array();
				foreach($_POST['keyword'] as $k=>$v){
					if(!in_array($v,$keyTmp)){
						$keyTmp[]=$v;
					}	
				}
			
			$checkkeywordSql="select * from ai_user_keywords WHERE uid =$mid";
			$cres=M('')->query($checkkeywordSql);
			if($cres){
				$upsql=null;
				$upsql="UPDATE ai_user_keywords SET keyword = '".serialize($keyTmp)."' WHERE uid =$mid";
				M('')->query($upsql);
			}else{
				$upsql=null;
				$upsql="INSERT INTO  ai_user_keywords (uid,keyword)values('".$mid."','".serialize($keyTmp)."')";
				M('')->query($upsql);
			}

			$checksql=null;
			$checksql="select * from ai_user_health_info where uid =$mid";
			$cres=M('')->query($checksql);
			if($cres){
				$upsql=null;
				if($_POST['dt_weight_finish']!=''||$_POST['dt_height_finish']!=''||$_POST['dt_year_finish']!=''){
					$upsql="UPDATE ai_user_health_info SET body_weight = '".$_POST['dt_weight_finish']."'
					,height = '".$_POST['dt_height_finish']."'
					,age = '".$_POST['dt_year_finish']."' WHERE uid =$mid";
					M('')->query($upsql);
				}
			}else{
				$insertSql="INSERT INTO  `aijianmei`.`ai_user_health_info` (`uid` ,`body_weight` ,`height` ,`age`)
				VALUES ($mid, '".$_POST['dt_weight_finish']."','".$_POST['dt_height_finish']."','".$_POST['dt_year_finish']."')";
				M('')->query($insertSql);
			}
			
			
			$sql="select uname,email from ai_user where uid =$mid";
			$shopinserinfo=M('')->query($sql);
			
			include_once('shopApi.php');
			$sdata=null;
			$sdata['uname']=addslashes($shopinserinfo[0]['uname']);
			$sdata['password']=addslashes($_SESSION['locallogin_password']);
			$sdata['email']   =addslashes($shopinserinfo[0]['email']);
			
			//_postCurlRegister($sdata);
			service('Passport')->loginLocal($sdata['uname'],$sdata['password'],1);
			
			$checkotherinfosql="select * from ai_others where uid=$mid";
			$res=M('')->query($checkotherinfosql);
			if(!$res){
				$insertsql=null;
				$other['uid'] = $mid;
				$other['mediaID'] = '3';
				$other['friendsCount'] = 0;
				$other['favouritesCount'] =0;
				$other['profileImageUrl'] = '';
				$other['mediaUserID'] = '';
				$other['url']  = '';
				$other['homepage'] = '';
				$other['description'] = $_POST['description'];
				$other['domain'] = $_POST['sina_domain'];
				$other['followersCount'] = 0;
				$other['statusesCount']  = 0;
				$other['personID'] = 0;
				foreach($other as $key => $value){
					$insertstr.=empty($insertstr)?$key:','.$key;
					$valuestr.=empty($valuestr)?"'".$value."'":",'".$value."'";
				}
				$insertsql = "INSERT INTO `aijianmei`.`ai_others` ($insertstr) VALUES ($valuestr)";
				M('')->query($insertsql);
			}
			else{
				$upsql=null;
				$upsql="UPDATE ai_others SET description = '".$_POST['description']."',domain='".$_POST['sina_domain']."' WHERE uid =$mid";
				M('')->query($upsql);
			}
			}
		}elseif($mid>0&&$_GET['args']=='uppwd'){
			if($_POST['password']==$_POST['repassword']){
				$upsql="update ai_user SET password = '".md5($_POST['password'])."' WHERE password ='".md5($_POST['oldpassword'])."'";
				M('')->query($upsql);
			}
		}elseif($mid>0&&$_GET['args']=='upconnect'){
			if(!empty($_POST['cemail'])&&!empty($_POST['ctell'])){
				$upsql=null;
				$upsql="update ai_others SET cemail = '".$_POST['cemail']."',ctell = '".$_POST['ctell']."' WHERE uid =$mid";
				M('')->query($upsql);
			}
		}
		$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($mid);
		//service('Passport')->login($mid);
		
		redirect(U('index/User/edituserinfo'));
	}	
	
	public function loginUserInfo()
	{
		if($_SESSION['sinalogin']==1){$_SESSION['deslogin']=1;}
		$tplName='login';
		if($_SESSION['mid']>0)
		{
			$check_sql="select * from ai_user where uid='".$_SESSION['mid']."'";
			$resArr=M('')->query($check_sql);
			$this->assign('userinfo',$resArr[0]);
			if(!empty($resArr[0]['email'])){
			 $tplName='loginUpload';
			 if(is_file(SITE_PATH.'/data/uploads/avatar'.convertUidToPath($this->uid).'/original.jpg')){
				$imgurl='/data/uploads/avatar'.convertUidToPath($this->uid).'/original.jpg';
				$this->assign('imgurl', $imgurl);
			 }
			 else{
				$getSimgSql="select * from ai_others where uid='".$_SESSION['mid']."'";
				$ImgArr=M('')->query($getSimgSql);
				$this->assign('imgurl',$ImgArr[0]['profileImageUrl']);
			 }
			}
			else{
			 $getSimgSql="select * from ai_others where uid='".$_SESSION['mid']."'";
			 $ImgArr=M('')->query($getSimgSql);
			 $this->assign('imgurl',$ImgArr[0]['profileImageUrl']);
			 $tplName='login';
			}
		}
		else{
			//redirect(U('index/Index/index'));
		}
		$area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
		$this->assign('refer_url', $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:"/index.php");
		if($_SESSION['sinalogin']==1){
			$this->assign('refer_url',"/index.php");
		}
		$_SESSION['loginBef_url']=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:"/index.php";
        $this->assign('children', $child);
        $this->assign('area', $area);
		$this->display($tplName);
	}
	public function setUserInfo()
	{
		if($_POST['mid']==$_SESSION['mid']&&$_POST['setInfoType']=='others'){
			$upsql="UPDATE ai_user SET password='".md5($_POST['passwordlib'])."',email='".$_POST['email']."', province='".$_POST['province']."',city='".$_POST['city']."',sex='".$_POST['sex']."',is_init=1 where uid='".$_POST['mid']."'";
			M('')->query($upsql);
			$healthArr=M('')->query("select * from ai_user_health where uid='".$_POST['mid']."'");
			
			include_once('shopApi.php');
			$sdata=null;
			$sdata['uname']=addslashes($_POST['uname']);
			$sdata['password']=addslashes($_POST['passwordlib']);
			$sdata['email']   =addslashes($_POST['email']);
			_postCurlRegister($sdata);
			$this->assign('healthArr', $healthArr[0]);
			
			$get_usernameSql="select * from ai_user where email='".$_POST['email']."'";
			$get_usernameInfo = M('')->query($get_usernameSql);
			$getUidSql='select user_id,user_name,email,password from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
			$uid = M('')->query($getUidSql);
			if($uid){
				$_SESSION['user_id']   = $uid[0]['user_id'];
				$_SESSION['user_name'] = $uid[0]['user_name'];
				$_SESSION['email']     = $uid[0]['email'];
				$_SESSION['ways']++;
				if($_SESSION['mid']>0){
					$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
				}
				@setcookie("ECS[user_id]",  $_SESSION['user_id'], time()+3600*24*30);
				@setcookie("ECS[password]", $uid[0]['password'], time()+3600*24*30);
			}
		}
		$_SESSION['deslogin']=0;
		$this->display('loginNext');
	}

	public function upUserInfo()
	{
	if(!$_SESSION['mid']){
		redirect(U('index/Index/index'));
	}
	else{
		$check_sql="";
		$valStr="'".intval($_POST['CheckVal1'])."','".intval($_POST['CheckVal2'])."','".intval($_POST['CheckVal3'])."','".intval($_POST['CheckVal4'])."','".intval($_POST['CheckVal5'])."'";
		$insertSql="REPLACE INTO ai_user_health (uid,is_increase_muscle,is_weight_gain,is_lose_weight,is_understand_health,is_fitness_friends) values('".$_SESSION['mid']."',".$valStr.")"; 
		M('')->query($insertSql);
	}
	$_SESSION['deslogin']=0;
	//print_r($_SESSION);
	if($_SESSION['refer_url']!=''&&$_SESSION['shoprefer_url']==''){
		redirect($_SESSION['refer_url']);
		//redirect(U('index/Index/index'));
	}
	elseif($_SESSION['shoprefer_url']!=''){
		$reurl=$_SESSION['shoprefer_url'];unset($_SESSION['shoprefer_url']);
		redirect($reurl);
		//redirect(U('index/Index/index'));
	}
	else{
		redirect(U('index/Index/index'));
	}
	}
	public function ShowImg(){

     //不存在当前上传文件则上传
     // if(!file_exists($_FILES['upload_file']['name'])) 
	 // {
		// move_uploaded_file($_FILES['upload_file']['tmp_name'],$_FILES['upload_file']['name']);
	 // }
	
	$fdata=$this->upload();
    //输出图片文件<img>标签

    echo "<textarea><img src='".$fdata['data']['picurl']."'/></textarea>";
	echo "<textarea><img style='width:150px;height:150px;' src='".$fdata['data']['picurl']."'/></textarea>";
	exit;
	}
	public function newShowImg(){
	$sql="UPDATE ai_user SET upic_type = '1' WHERE uid ='".$_SESSION['allowbackmid']."'";
	M('')->query($sql);
     //不存在当前上传文件则上传
     // if(!file_exists($_FILES['upload_file']['name'])) 
	 // {
		// move_uploaded_file($_FILES['upload_file']['tmp_name'],$_FILES['upload_file']['name']);
	 // }
	$fdata=$this->uploadImageFile(150,'big');
	//$fdata=$this->uploadImageFile(50,'middle');
	//$this->uploadImageFile(30,'small');
	//$fdata=$this->newupload();
    //输出图片文件<img>标签

    //echo "<textarea><img src='".$fdata['data']['picurl']."'/></textarea>";
	echo "<textarea><img src='".$fdata.'?'.rand()."' /></textarea>";
	exit;
	}
	public function newShowImg1(){

     //涓嶅瓨鍦ㄥ綋鍓嶄笂浼犳枃浠跺垯涓婁紶
     // if(!file_exists($_FILES['upload_file']['name'])) 
	 // {
		// move_uploaded_file($_FILES['upload_file']['tmp_name'],$_FILES['upload_file']['name']);
	 // }
	
	$fdata=$this->newupload();
    //杈撳嚭鍥剧墖鏂囦欢<img>鏍囩

    echo "<textarea><img src='".$fdata['data']['picurl']."?".rand()."'/></textarea>";
	echo "<textarea><img class='dt_choice_img' style='width:45px;height:45px;' src='".$fdata['data']['spicurl']."?".rand()."'/></textarea>";
	exit;
	}
	function upload(){
		if($_SESSION['allowbackmid']){$this->uid=$_SESSION['allowbackmid'];}
        $pic_id = time();//使用时间来模拟图片的ID.           
        $pic_path = $this->getSavePath().'/original.jpg';
        $pic_abs_path = __UPLOAD__.'/avatar'.convertUidToPath($this->uid).'/original.jpg';
        //保存上传图片.
        if(empty($_FILES['Filedata'])) {
        	$return['message'] = L('photo_upload_failed');
        	$return['code']    = '0';
        }else{
        	$validExts = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif','image/pjpeg','image/x-png');
        	if(!in_array(strtolower($_FILES['Filedata']['type']), $validExts)) {
        		@unlink($_FILES['Filedata']['tmp_name']);
        		$return['message'] = '仅允许上传jpg,jpeg,png,gif格式图片';
        		$return['code'] = 0;
        		return json_encode($return);
        	}
        	
	        $file = @$_FILES['Filedata']['tmp_name'];
	        file_exists($pic_path) && @unlink($pic_path);
	        if(@copy($_FILES['Filedata']['tmp_name'], $pic_path) || @move_uploaded_file($_FILES['Filedata']['tmp_name'], $pic_path)) 
	        {
	        	@unlink($_FILES['Filedata']['tmp_name']);
	        	/*list($width, $height, $type, $attr) = getimagesize($pic_path);
	        	if($width < 10 || $height < 10 || $width > 3000 || $height > 3000 || $type == 4) {
	        		@unlink($pic_path);
	        		return -2;
	        	}*/
	        	include( SITE_PATH.'/addons/libs/Image.class.php' );
	        	Image::thumb( $pic_path, $pic_path , '' , 300 , 300 );
	        	list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($pic_path);
	        	
	        	$return['data']['picurl'] = 'data/uploads/avatar'.convertUidToPath($this->uid).'/original.jpg';
	        	$return['data']['picwidth'] = $sr_w;
	        	$return['data']['picheight'] = $sr_h;
	        	$return['code']    = '1';
				// 获取源图的扩展名宽高
			$src=$return['data']['picurl'];
		list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
		if($sr_type){
			//获取后缀名
			$ext = image_type_to_extension($sr_type,false);
		} else {
			echo "-1";
			exit;
		}
		
		$big_w = '150';
		$big_h = '150';
		
		$middle_w = '50';
		$middle_h = '50';
		
		$small_w  = '30';
		$small_h  = '30';
		
		$face_path      =   SITE_PATH.'/data/uploads/avatar'.convertUidToPath($this->uid);
		$big_name	    =	$face_path.'/big.jpg';		// 大图
		$middle_name	=	$face_path.'/middle.jpg';		// 中图
		$small_name		=	$face_path.'/small.jpg';
		
		$func	=	($ext != 'jpg')?'imagecreatefrom'.$ext:'imagecreatefromjpeg';
		$img_r	=	call_user_func($func,$src);
		
		$dst_r	=	ImageCreateTrueColor( $big_w, $big_h );
		$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
		ImageFilledRectangle( $dst_r, 0, 0, $big_w, $big_h, $back );
		ImageCopyResampled( $dst_r, $img_r, 0, 0, 0, 0, $big_w, $big_h, $sr_w, $sr_h );
	
		ImagePNG($dst_r,$big_name);  // 生成大图

		// 开始切割大方块头像成中等方块头像
		$sdst_r	=	ImageCreateTrueColor( $middle_w, $middle_h );
		ImageCopyResampled( $sdst_r, $dst_r, 0, 0, 0, 0, $middle_w, $middle_h, $big_w, $big_w );
		ImagePNG($sdst_r,$middle_name);  // 生成中图
		
		
		// 开始切割大方块头像成中等方块头像
		$sdst_s	=	ImageCreateTrueColor( $small_w, $small_h );
		ImageCopyResampled( $sdst_s, $dst_r, 0, 0, 0, 0, $small_w, $small_h, $big_w, $big_w );
		ImagePNG($sdst_s,$small_name);  // 生成中图
		
		ImageDestroy($dst_r);
		ImageDestroy($sdst_r);
		ImageDestroy($sdst_s);
		ImageDestroy($img_r);
	        } else {
	        	@unlink($_FILES['Filedata']['tmp_name']);
	        	$return['message'] = L('photo_upload_failed');
	        	$return['code']    = '0';
	        }	
        }
        return $return;
    }
function newupload(){
		if($_SESSION['allowbackmid']){$this->uid=$_SESSION['allowbackmid'];}
        $pic_id = time();//使用时间来模拟图片的ID.           
        $pic_path = $this->getSavePath().'/original.jpg';
        $pic_abs_path = __UPLOAD__.'/avatar'.convertUidToPath($this->uid).'/original.jpg';
        //保存上传图片.
        if(empty($_FILES['Filedata'])) {
        	$return['message'] = L('photo_upload_failed');
        	$return['code']    = '0';
        }else{
        	$validExts = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif','image/pjpeg','image/x-png');
        	if(!in_array(strtolower($_FILES['Filedata']['type']), $validExts)) {
        		@unlink($_FILES['Filedata']['tmp_name']);
        		$return['message'] = '仅允许上传jpg,jpeg,png,gif格式图片';
        		$return['code'] = 0;
        		return json_encode($return);
        	}
        	
	        $file = @$_FILES['Filedata']['tmp_name'];
	        file_exists($pic_path) && @unlink($pic_path);
	        if(@copy($_FILES['Filedata']['tmp_name'], $pic_path) || @move_uploaded_file($_FILES['Filedata']['tmp_name'], $pic_path)) 
	        {
	        	@unlink($_FILES['Filedata']['tmp_name']);
	        	/*list($width, $height, $type, $attr) = getimagesize($pic_path);
	        	if($width < 10 || $height < 10 || $width > 3000 || $height > 3000 || $type == 4) {
	        		@unlink($pic_path);
	        		return -2;
	        	}*/
	        	include( SITE_PATH.'/addons/libs/Image.class.php' );
	        	Image::thumb( $pic_path, $pic_path , '' , 300 , 300 );
	        	list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($pic_path);
	        	
	        	$return['data']['picurl'] = 'data/uploads/avatar'.convertUidToPath($this->uid).'/original.jpg';
				$return['data']['spicurl'] = 'data/uploads/avatar'.convertUidToPath($this->uid).'/middle.jpg';
	        	$return['data']['picwidth'] = $sr_w;
	        	$return['data']['picheight'] = $sr_h;
	        	$return['code']    = '1';
				// 获取源图的扩展名宽高
			$src=$return['data']['picurl'];
		list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
		if($sr_type){
			//获取后缀名
			$ext = image_type_to_extension($sr_type,false);
		} else {
			echo "-1";
			exit;
		}
		
		$big_w = '150';
		$big_h = '150';
		
		$middle_w = '50';
		$middle_h = '50';
		
		$small_w  = '30';
		$small_h  = '30';
		
		$face_path      =   SITE_PATH.'/data/uploads/avatar'.convertUidToPath($this->uid);
		$big_name	    =	$face_path.'/big.jpg';		// 大图
		$middle_name	=	$face_path.'/middle.jpg';		// 中图
		$small_name		=	$face_path.'/small.jpg';
		
		$func	=	($ext != 'jpg')?'imagecreatefrom'.$ext:'imagecreatefromjpeg';
		$img_r	=	call_user_func($func,$src);
		
		$dst_r	=	ImageCreateTrueColor( $big_w, $big_h );
		$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
		ImageFilledRectangle( $dst_r, 0, 0, $big_w, $big_h, $back );
		ImageCopyResampled( $dst_r, $img_r, 0, 0, 0, 0, $big_w, $big_h, $sr_w, $sr_h );
	
		ImagePNG($dst_r,$big_name);  // 生成大图

		// 开始切割大方块头像成中等方块头像
		$sdst_r	=	ImageCreateTrueColor( $middle_w, $middle_h );
		ImageCopyResampled( $sdst_r, $dst_r, 0, 0, 0, 0, $middle_w, $middle_h, $big_w, $big_w );
		ImagePNG($sdst_r,$middle_name);  // 生成中图
		
		
		// 开始切割大方块头像成中等方块头像
		$sdst_s	=	ImageCreateTrueColor( $small_w, $small_h );
		ImageCopyResampled( $sdst_s, $dst_r, 0, 0, 0, 0, $small_w, $small_h, $big_w, $big_w );
		ImagePNG($sdst_s,$small_name);  // 生成中图
		
		ImageDestroy($dst_r);
		ImageDestroy($sdst_r);
		ImageDestroy($sdst_s);
		ImageDestroy($img_r);
	        } else {
	        	@unlink($_FILES['Filedata']['tmp_name']);
	        	$return['message'] = L('photo_upload_failed');
	        	$return['code']    = '0';
	        }	
        }
        return $return;
    }


function uploadImageFile($size,$name) {
	if($_SESSION['allowbackmid']){$this->uid=$_SESSION['allowbackmid'];}
	//echo $pic_path = $this->getSavePath().'/original.jpg';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$iWidth = $iHeight = $size; // 输出大小
		$iJpgQuality = 100;
		if ($_FILES) {
		// if no errors and size less than 250kb
			if (! $_FILES['image_file']['error']) {
				if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
				//$sTempFileName =  md5(time().rand());
				$sTempFileName =  SITE_PATH.'/data/uploads/avatar/'.$this->uid.'/'.$name;
				// move uploaded file into cache folder
				mkdir(SITE_PATH.'/data/uploads/avatar/'.$this->uid.'/',0777);
				$original='data/uploads/avatar/'.$this->uid.'/original.jpg';
				move_uploaded_file($_FILES['image_file']['tmp_name'],SITE_PATH.'/'.$original);
				//copy('/data/uploads/avatar/'.$this->uid.'/original.jpg', '/data/uploads/avatar/'.$this->uid.'/'.$name);
				//change file permission to 644
				chmod($original, 0777);
				//@chmod($sTempFileName, 0777);
					if (file_exists($original) && filesize($original) > 0) {
						$aSize = getimagesize($original); // try to obtain image info
						if (!$aSize) {
							@unlink($original);
							return;
						}
						// check for image type
						switch($aSize[2]) {
							case IMAGETYPE_JPEG:
							$sExt = '.jpg';
							// create a new image from file
							$vImg = @imagecreatefromjpeg($original);
							break;
							case IMAGETYPE_PNG:
							$sExt = '.png';
							// create a new image from file
							$vImg = @imagecreatefrompng($original);
							break;
							default:
							@unlink($sTempFileName);
							return;
						}
						$sExt = '.jpg';
						// create a new true color image
						$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
						// copy and resize part of an image with resampling
						imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
						// define a result image filename
						$sResultFileName = $sTempFileName . $sExt;
						// output image to file
						imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
						$this->resizeimage($sResultFileName,1/3,SITE_PATH.'/data/uploads/avatar/'.$this->uid.'/middle.jpg');
						$this->resizeimage($sResultFileName,0.2,SITE_PATH.'/data/uploads/avatar/'.$this->uid.'/small.jpg');
						/*$face_path      =   SITE_PATH.'/data/uploads/avatar'.convertUidToPath($this->uid);
						$big_name	    =	$face_path.'/big.jpg';		// 大图
						$middle_name	=	$face_path.'/middle.jpg';		// 中图
						$small_name		=	$face_path.'/small.jpg';
						
						
						$dst_r	=	ImageCreateTrueColor( 150, 150);
						$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
						ImageCopyResampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], 150, 150, (int)$_POST['w'], (int)$_POST['h']);
						ImagePNG($dst_r,$big_name);  // 生成大图
						
						$dst_r	=	ImageCreateTrueColor( 50, 50 );
						$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
						ImageCopyResampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], 50, 50, (int)$_POST['w'], (int)$_POST['h']);
						ImagePNG($dst_r,$middle_name);  // 生成大图
						
						
						$dst_r	=	ImageCreateTrueColor( $iWidth, $iHeight );
						$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
						ImageCopyResampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'],30, 30, (int)$_POST['w'], (int)$_POST['h']);
						ImagePNG($dst_r,$small_name);  // 生成大图
						
						*/
						@unlink($sTempFileName);
						@chmod($big_name, 0777);
						@chmod($small_name, 0777);
						@chmod($middle_name, 0777);
						return '/data/uploads/avatar'.convertUidToPath($this->uid).'/big.jpg';
					}
				}
			}
		}
	}
}


function resizeimage($srcfile,$rate=.5, $filename = "" ){
$size=getimagesize($srcfile);
switch($size[2]){
case 1:
$img=imagecreatefromgif($srcfile);
break;
case 2:
$img=imagecreatefromjpeg($srcfile);
break;
case 3:
$img=imagecreatefrompng($srcfile);
break;
default:
exit;
}
//源图片的宽度和高度
$srcw=imagesx($img);
$srch=imagesy($img);
//目的图片的宽度和高度
if($size[0] <= $rate || $size[1] <= $rate){
$dstw=$srcw;
$dsth=$srch;
}else{
if($rate <= 1){
$dstw=floor($srcw*$rate);
$dsth=floor($srch*$rate);
}else {
$dstw=$rate;
$rate = $rate/$srcw;
$dsth=floor($srch*$rate);
}
}
//echo "$dstw,$dsth,$srcw,$srch ";
//新建一个真彩色图像
$im=imagecreatetruecolor($dstw,$dsth);
$black=imagecolorallocate($im,255,255,255);

imagefilledrectangle($im,0,0,$dstw,$dsth,$black);
imagecopyresized($im,$img,0,0,0,0,$dstw,$dsth,$srcw,$srch);
// 以 JPEG 格式将图像输出到浏览器或文件
if( $filename ) {
//图片保存输出
imagejpeg($im, $filename );
}else {
//图片输出到浏览器
imagejpeg($im);
}
//释放图片
imagedestroy($im);
imagedestroy($img);
}
}
?>