<?php 
class RegAction extends Action {
	public function register(){
		//根据不同入口切换注册页面
		
		//清理第三方注册的无效用户信息
		$sql="delete from ai_others where uid in (select uid from ai_user where uname is null)";
		M('')->query($sql);
		$sql="delete from ai_user where uname is null";
		M('')->query($sql);
		if($_SESSION['regrefer_url']==''&& $_SESSION['refer_url']!=''){
			$_SESSION['regrefer_url'] = $_SESSION['refer_url'];
		}
		//print_r($_SESSION);
		if($_SESSION['sinalogin']==1&&$_SESSION['mid']>0){
			$this->display('account_third');//第三方注册
		}else{
			$this->display('account');//本地注册
		}
	}
	public function doregister()
	{
		session_start();
		if($_SESSION['sinalogin']==1){$_SESSION['deslogin']=1;}
		
		@$userName		= $_POST['name'];
		$userEmail		= $_POST['email'];
		$password			= $_POST['password'];
		$repassword		= $_POST['repassword'];
		
		$check=D('Reg')->getUserNameByEmail($userEmail);
		if(!$check&&($password==$repassword)){
			//第三方注册 start
			if($_SESSION['mid']>0&&$_SESSION['sinalogin']==1){
				$upsql=$mid=null;
				$mid=intval($_SESSION['mid']);
				$upsql="UPDATE ai_user SET email = '".$userEmail."',password='".md5($password)."' WHERE uid =$mid";
				M('')->query($upsql);
				//$getSimgSql="select * from ai_others where uid='".$_SESSION['mid']."'";
				//$ImgArr=M('')->query($getSimgSql);
				//$this->assign('imgurl',$ImgArr[0]['profileImageUrl']);
				$_SESSION['otherlogin']=1;
				$getuidname="select * from ai_user where uid='".$mid."'";
				$getuidinfo=M('')->query($getuidname);
				$userName=$getuidinfo[0]['uname'];
				
				$this->ecshopreg($mid,$userName,$password,$userEmail);//商城注册

			  /*forum 论坛 登陆api start by kontem at20130626*/
			  
			  $this->forumreg($userName,$password,$userEmail);//论坛注册
			  $inserTmpSql=null;
			  $inserTmpSql="INSERT INTO  aijianmei.ai_forum_tmp_user (id ,email ,password)
			  VALUES (NULL ,  '".$userEmail."',  '".$password."')";  
			  M('')->query($inserTmpSql);
			  $url=AIBASEURL."/forum/pwApi.php?pwact=register";
			  $out=_CurlPost($url,$post_data);//targetUrl postData
			  $_SESSION['locallogin_password']=$password;
			  
			  
			  service('Passport')->loginLocal($userName,$password,1);//本地登陆
				$this->ecshoplogin($userName,$password);//商城登陆
				$_SESSION['pwai_url']=$this->forumlogin($userName,$password);//论坛登陆
				if($mid > 0){
					$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($mid);
			  }
			  unset($_SESSION['sinalogin']);  
			}
			else
			{
				$_SESSION['deslogin']=1;
				$_SESSION['locallogin']=1;
				$insertdata=array(
				'uname'			=>	$userName,'email'			=>	$userEmail,'password'	=>	md5($password),
				'ctime'			=>	time(),   'is_active'	=>	1,         'is_init'	=>  1,'identity'	=>  1,);
				
				D('Reg')->dbInsertInfo('ai_user',$insertdata);//用户注册				
				$mid=D('Reg')->getUserId($userEmail,$password);//获取用户id				
				$_SESSION['locallogin_password']=$password;
				$this->ecshopreg($mid,$userName,$password,$userEmail);//商城注册
				$this->forumreg($userName,$password,$userEmail);//论坛注册
				
				service('Passport')->loginLocal($userName,$password,1);//本地登陆
				$this->ecshoplogin($userName,$password);//商城登陆
				$_SESSION['pwai_url']=$this->forumlogin($userName,$password);//论坛登陆
				if($mid > 0){
					$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($mid);
				}				
			}
			$_SESSION['allowbackreg']=1;
			$_SESSION['allowbackmid']=$mid;
			$_SESSION['loginIcpkey']=md5('aijianmei'.$mid);
		}
		$this->display('account_love');
	}
	
	public function setchannelinfo(){
		$mid=$_SESSION['allowbackmid']?$_SESSION['allowbackmid']:$_SESSION['mid'];
		if($mid>0){
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
		}

		if($_SESSION['regrefer_url']!=''){
			$_SESSION['deslogin']=0;
			$_SESSION['regrefer_msg']='恭喜你成功注册“爱健美”';
			redirect(U('index/Public/Transit'));
		}else{
			$_SESSION['regrefer_url']=U('index/Index/index');
			$_SESSION['deslogin']=0;
			$_SESSION['regrefer_msg']='恭喜你成功注册“爱健美”';
			redirect(U('index/Public/Transit'));	
		} 
	}
	
	public function ecshopreg($mid,$name,$password,$email){
		$sql="select uname,email from ai_user where uid =$mid";
		$shopinserinfo=M('')->query($sql);
		include_once('shopApi.php');
		$sdata=null;
		$sdata['uname']=addslashes($shopinserinfo[0]['uname']);
		$sdata['password']=addslashes($password);
		$sdata['email']   =addslashes($shopinserinfo[0]['email']);
		_postCurlRegister($sdata);
	}
	public function ecshoplogin($username,$password){
		$getUidSql='select user_id,user_name,email from ecs_users where user_name="'.$username.'"';
		$uid = M('')->query($getUidSql);
		$_SESSION['user_id']   = $uid[0]['user_id'];
		$_SESSION['user_name'] = $uid[0]['user_name'];
		$_SESSION['email']     = $uid[0]['email'];
		$_SESSION['ways']++;
		@setcookie("ECS[user_id]",  $uid[0]['user_id'], time()+3600*24*30);
		@setcookie("ECS[password]", md5($password), time()+3600*24*30);
	}
	
	public function forumreg($name,$password,$email){
		/*forum 论坛 登陆api start by kontem at20130626*/
		$pwUserInfoSql="select * from ai_pwforum.pw_user where username='".$name."' and email='".$email."'";
		$pwUserInfo=M('')->query($pwUserInfoSql);
		//检测用户是否已经有论坛对应的账号
		if(empty($pwUserInfo[0])){
			//不存在则调用注册api
			$post_data=array( 
				'username' => $name,
			  'email' => $email,
			  'password' =>$password,
			  'repassword' =>$password,
			  );
			$url=AIBASEURL."/forum/pwApi.php?pwact=register";
			_CurlPost($url,$post_data);//targetUrl postData
		}
	}
	public function forumlogin($name,$password){
		//调用登陆api
		$url=AIBASEURL."/forum/pwApi.php?pwact=login";
		$post_data=array(
			'username' => $name,
			'password' => $password,
		);
		return _CurlPost($url,$post_data);
	}
}
?>