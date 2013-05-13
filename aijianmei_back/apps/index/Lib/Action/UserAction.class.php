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
		$this->display('register_1');
	}
	public function doregister()
	{
		$this->display('register_2');
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

    echo "<textarea><img style='width:150px;height:150px;' src='".$fdata['data']['picurl']."'/></textarea>";
	exit;
	}
	
	function upload(){
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
	
}
?>