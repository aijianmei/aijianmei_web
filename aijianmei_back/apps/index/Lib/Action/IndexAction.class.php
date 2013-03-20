<?php
class IndexAction extends Action {
	public function index() 
	{
		if (!empty($_GET['token'])) {
			require_once $_SERVER['DOCUMENT_ROOT'].'/Denglu.php';
			$api = new Denglu('44031dena3J8cuBsQeX40lcpjSsPM3', '85015440v4NfCVj6aTNfZAg0idQv03', 'utf-8');
			
			try {
				
				$userInfo = $api->getUserInfoByToken($_GET['token']);
				//print_r($userInfo);
				
				$logId = M('others')->field('uid')->where(array('mediaID'=>$userInfo['mediaID'], 'mediaUserID'=>$userInfo['mediaUserID'], 'personID'=>$userInfo['personID']))->find();
				//print_r($logId);
				if($logId) {
					service('Passport')->loginLocal($logId['uid']);
				}else {
					$data['email'] = $userInfo['email'];
					$data['password'] = '';
					$data['uname'] = $userInfo['screenName'];
					//$data['province'] = $userInfo['province'];
					//$data['city']  = $userInfo['city'];
					$data['sex']   = $userInfo['gender'];
					$data['location'] = $userInfo['location'];
					$data['is_active'] = 1;
					$data['ctime'] = time();
					
					//print_r($data);
					
					$uid = M('user')->add($data);				
					service('Passport')->loginLocal($uid);					
					
					$other['uid'] = $uid;
					$other['mediaID'] = $userInfo['mediaID'];
					$other['friendsCount'] = $userInfo['friendsCount'];
					$other['favouritesCount'] = $userInfo['favouritesCount'];
					$other['profileImageUrl'] = $userInfo['profileImageUrl'];
					$other['mediaUserID'] = $userInfo['mediaUserID'];
					$other['url']  = $userInfo['url'];
					$other['homepage'] = $userInfo['homepage'];
					$other['description'] = $userInfo['description'];
					$other['domain'] = $userInfo['domain'];
					$other['followersCount'] = $userInfo['followersCount'];
					$other['statusesCount']  = $userInfo['statusesCount'];
					$other['personID'] = $userInfo['personID'];
					
					M('others')->add($other);
				}
				
				
				//redirect(U('index/Index/index'));
			}catch (DengluException $e) {
				echo $e->geterrorDescription();
			}
		}

		if(!empty($_REQUEST['code'])) {
			require_once $_SERVER['DOCUMENT_ROOT'].'/saetv2.ex.class.php';
			$sina = new SaeTOAuthV2('3622140445', 'f94d063d06365972215c62acaadf95c3');	

			$token = $sina->getAccessToken('code', array('code'=>$_REQUEST['code'], 'redirect_uri'=>'http://dev.aijianmei.com/index.php'));
			$client = new SaeTClientV2('3622140445', 'f94d063d06365972215c62acaadf95c3', $token['access_token']);

			$uid_get = $client->get_uid();
			$uid = $uid_get['uid'];
			$user_message = $client->show_user_by_id( $uid);
			//print_r($user_message);

			//$logId = M('others')->field('uid')->where(array('mediaID'=>'3', 'mediaUserID'=>$user_message['id'], 'personID'=>$user_message['idstr']))->find();
			$log_sql = 'select uid from ai_others where mediaID=3 and mediaUserID='.$user_message['id'].' and personID='.$user_message['idstr'].'';
			//echo $log_sql;
			$logId = M('')->query($log_sql);
			//var_dump($logId);
			if($logId) {
				service('Passport')->loginLocal($logId[0]['uid']);	
			}else {
				$data['email'] = '';
				$data['password'] = '';
				$data['uname'] = $user_message['screen_name'] ? $user_message['screen_name'] : $user_message['name'];
				//$data['province'] = $userInfo['province'];
				//$data['city']  = $userInfo['city'];
				$data['sex']   = $user_message['gender']=='m' ? 1 : 0;
				$data['location'] = $user_message['location'];
				$data['is_active'] = 1;
				$data['ctime'] = time();
				
				//print_r($data);
				$sql = 'insert into ai_user (`uname`,`sex`,`location`,`is_active`,`ctime`) values ("'.$data['uname'].'","'.$data['sex'].'","'.$data['location'].'","'.$data['is_active'].'","'.$data['ctime'].'")';
				M('')->query($sql);

				$uid = mysql_insert_id();
				//var_dump($uid);
				//$uid = M('user')->add($data);				
				service('Passport')->loginLocal($uid);

				$other['uid'] = $uid;
				$other['mediaID'] = '3';
				$other['friendsCount'] = $user_message['friends_count'];
				$other['favouritesCount'] = $user_message['favourites_count'];
				$other['profileImageUrl'] = $user_message['profile_image_url'];
				$other['mediaUserID'] = $user_message['id'];
				$other['url']  = $user_message['url'];
				$other['homepage'] = $user_message['url'];
				$other['description'] = $user_message['description'];
				$other['domain'] = $user_message['domain'];
				$other['followersCount'] = $user_message['followers_count'];
				$other['statusesCount']  = $user_message['statuses_count'];
				$other['personID'] = $user_message['idstr'];
				
				//print_r($other);
				$other_sql = 'INSERT INTO `aijianmei`.`ai_others` 
				( `uid`, `mediaID`, `friendsCount`, `favouritesCount`, `profileImageUrl`,
				 `mediaUserID`, `url`, `homepage`, `description`, `domain`, `followersCount`, 
				 `statusesCount`, `personID`) VALUES ( 
				 "'.$other['uid'].'", "'.$other['mediaID'].'", "'.$other['friendsCount'].'", 
				 "'.$other['favouritesCount'].'", "'.$other['profileImageUrl'].'", "'.$other['mediaUserID'].'", 
				 "'.$other['url'].'", "'.$other['homepage'].'", "'.$other['description'].'", 
				 "'.$other['domain'].'", "'.$other['followersCount'].'", "'.$other['statusesCount'].'", "'.$other['personID'].'")';
				echo $other_sql;
				//mysql_query($other_sql);
				M('')->query($other_sql);

				//M('others')->add($other);	
			}

		}
		
		
		$this->setTitle('index');
		$this->assign('uid',$this->mid);
		$this->assign('cssFile','index');
		
		$daily = M('daily')->findAll();
		
		$shangban = M('article')->where(array('category_id'=>'43'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('shangban', $shangban);
		
		$richang =  M('article')->where(array('category_id'=>'44'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('richang', $richang);
		
		$zhuanye =  M('article')->where(array('category_id'=>'45'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('zhuanye', $zhuanye);
		
		$jianmei =  M('article')->where(array('category_id'=>'46'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('jianmei', $jianmei);
		
		$this->assign('daily', $daily);
		$this->display();
	}

	public function app()
	{
		$this->display();
	}

	public function articleDetail()
	{	
		$o = $_GET['o'];
		if($o=='like') {
			if($this->mid) {				
				$is_vote = M('article_vote')->where(array('uid'=>$this->mid, 'article_id'=>$_GET['id']))->find();
				if(!empty($is_vote)) {
					echo '<script type="text/javascript">alert("已经投票");</script>';
				}else {
					/* $like = M('article')->field('like')->where(array('id'=>$_GET['id']))->find();
					$data['id'] = $_GET['id'];
					$data['like'] = $like['like'];
					M('article')->save($data);
					 */
					M('')->query('update ai_article set `like`=`like`+1 where id='.$_GET['id']);
					$data['uid'] = $this->mid;
					$data['article_id'] = $_GET['id'];
					M('')->query('insert into ai_article_vote (`uid`,`article_id`) values ("'.$this->mid.'","'.$_GET['id'].'"');
				}				
			}else {
				//echo '<script type="text/javascript">alert("请登录")</script>';
			}
		}elseif($o=='unlike') {
			if($this->mid) {
				$is_vote = M('article_vote')->where(array('uid'=>$this->mid, 'article_id'=>$_GET['id']))->find();
				if(!empty($is_vote)) {
					echo '<script type="text/javascript">alert("已经投票");</script>';
				}else {
					/* $unlike = M('article')->field('unlike')->where(array('id'=>$_GET['id']))->find();
					$data['id'] = $_GET['id'];
					$data['unlike'] = $unlike['unlike'];
					M('article')->save($data); */
					M('')->query('update ai_article set `unlike`=`unlike`+1  where id='.$_GET['id']);
					M('article_vote')->add(array('uid'=>$this->mid, 'article_id'=>$_GET['id']));
				}
			}else {
				//echo '<script type="text/javascript">alert("请登录")</script>';
			}
		}
		global $ts;
			
		$id = (int) $_GET['id'];
		$map['id'] = $id;
		$article = M('article')->where($map)->find();
		$this->assign('article', $article); 
		
		
		$commentCounts = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->count();
		
		$pager = api('Pager');
		$pager->setCounts($commentCounts);
		$pager->setList(10);
		$pager->makePage();
		$from = ($pager->pg -1) * $pager->countlist;		
		$pagerArray = (array)$pager;
		$this->assign('pager', $pagerArray);
		//print_r($pagerArray);
		
		$articleComments = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->limit("$from,$pager->countlist")->findAll();
		foreach($articleComments as $ac) {
			$comments[$ac['id']]['content'] = $ac;
			$comments[$ac['id']]['user'] = getUserInfo($ac['uid']);			
			$comments[$ac['id']]['children'] = M('comments')->where(array('topParent'=>$ac['id'], 'parent_type'=>'3'))->order('`create_time` asc')->findAll();
		}
		
		$hotComments = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->order('`like` desc')->limit("$from,$pager->countlist")->findAll();
		foreach($hotComments as $ac) {
			$hotArticlecomments[$ac['id']]['content'] = $ac;
			$hotArticlecomments[$ac['id']]['user'] = getUserInfo($ac['uid']);
			$hotArticlecomments[$ac['id']]['children'] = M('comments')->where(array('topParent'=>$ac['id'], 'parent_type'=>'3'))->order('`create_time` asc')->findAll();
		}
		$this->assign('hotComments', $hotArticlecomments);
		
		$promote = M('promote')->find();
		$this->assign('promote', $promote);
		
		$promoteArticle = M('article')->where(array('is_promote'=>1))->findAll();
		
		$this->assign('promote_article', $promoteArticle);
		
		$this->assign('comments', $comments);

		$this->assign('cssFile', 'article');
		$this->assign('uid', $this->mid);

		//目录树
		//$tree_channel_en 一级目录
		//$tree_parent 二级目录
		//$tree_category_id 三级目录
		//article['id']  四级目录
		$string="select category_id,name,channel,parent from ai_article,ai_article_category where ai_article.category_id=ai_article_category.id and ai_article.id=".$id;
		$result=mysql_query($string);
		$result=mysql_fetch_array($result);
		$channel=$result['channel'];
		$tree_category_id=$result['category_id'];
		switch($channel){
			case 1: {$tree_channel="健身计划 ";$tree_channel_en="Plan";}break;
			case 2:{$tree_channel="锻炼 ";$tree_channel_en="Train";}break;
			case 3:{$tree_channel="营养 ";$tree_channel_en="Nutri";}break;
			case 4:{$tree_channel="补充 ";$tree_channel_en="Append";}break;
		}
		$tree_parent=$result['parent'];		
		$tree_name=$result['name'];
		$result=mysql_query("select name from ai_article_category where id=".$tree_parent);
		$tree_parentName=mysql_fetch_array($result);
		$this->assign("first",$tree_channel);
		$this->assign("second",$tree_parentName['name']);
		$this->assign("third",$tree_name);
		$this->assign("tree_parent",$tree_parent);
		$this->assign("tree_channel_en",$tree_channel_en);
		$this->assign("tree_category_id",$tree_category_id);
		
		$this->display('detail');
	}
	
	public function addArticleLikeCount()
	{
		$id = intval($_POST['id']);
		$save['like'] = intval($_POST['count']);
		echo M('article')->where(array('id'=>$id))->save($save) ? '1' : '0';
	}
	
	
	public function addArticleUnlikeCount()
	{
		$id = intval($_POST['id']);
		$save['unlike'] = intval($_POST['count']);
		echo M('article')->where(array('id'=>$id))->save($save) ? '1' : '0';
	}
	
	public function addArticleComment()
	{
		if (isset($_POST['comment'])) {
			$this->addComment(t($_POST['comment']), intval($_POST['aid']), '1');
			/* $data['content'] = t($_POST['comment']);
			$data['uid'] = $this->mid;
			$data['parent_id'] = intval($_POST['aid']);
			$data['parent_type'] = '1';
			$data['create_time'] = time();
			
			if(!empty($data['content']) &&
			   !empty($data['uid']) &&
			   !empty($data['parent_id'])) {
				M('comments')->add($data);
			} */
						
		}
	}
	
	public function addDailyComment()
	{
		if (isset($_POST['comment'])) {
			$this->addComment(t($_POST['comment']), intval($_POST['aid']), '4');
			/* $data['content'] = t($_POST['comment']);
			$data['uid']     = $this->mid;
			$data['parent_id'] = intval($_POST['aid']);
			$data['parent_type'] = '4'; // 类型为4表示评论的是天天锻炼的文章
			$data['create_time'] = time();
			
			if(!empty($data['content']) &&
					!empty($data['uid']) &&
					!empty($data['parent_id'])) {
				M('comments')->add($data);
			} */
		}
	}
	
	public function addVideoComment()
	{
		if(isset($_POST['comment'])) {
			$this->addComment(t($_POST['comment']), intval($_POST['aid']), '2'); // 类型2表示的是视频
		}
	}
	
	public function addDailyVideoComment()
	{
		if(isset($_POST['comment'])) {
			$this->addComment(t($_POST['comment']), intval($_POST['aid']), '3'); // 类型3表示的是评论
		}
	}
	
	protected function addComment($content, $parent_id, $parent_type) {
		$data['content'] = $content;
		$data['uid']     = $this->mid;
		$data['parent_id'] = $parent_id;
		$data['parent_type'] = $parent_type;
		$data['create_time'] = time();
		
		if(!empty($data['content']) &&
				!empty($data['uid']) &&
				!empty($data['parent_id'])) {
			$cid = M('comments')->add($data);
			return $cid;
		}
		
		return false;
	}
	
	public function articleList()
	{
		$id = (int) $_GET['id'];
		$this->assign('cssFile', 'classify');
		$this->display('list');
	}

	public function videoList()
	{
		$this->assign('cssFile', 'video');
		$this->display('vlist');
	}

	public function videoDetail()
	{
		$this->display('vdetail');
	}

	public function coach()
	{
		$this->assign('cssFile', 'teach');
		$this->display();
	}

	public function info()
	{
		
		$type = (int) $_GET['type'];
		$info = D('Article')->getDaily($type);
		//print_r($info);
		$cate = M('article_category')->where(array('type'=>'2'))->findAll();
		$this->assign('info', $info);
		$this->assign('cssFile', 'every');

		//目录树
		$channel=$type;
		switch($channel){
			case 1: {$tree_channel="上班族健身 ";$tree_channel_en=1;}break;
			case 2:{$tree_channel="日常健身 ";$tree_channel_en=2;}break;
			case 3:{$tree_channel="运动员 ";$tree_channel_en=3;}break;
			case 4:{$tree_channel="健身运动员 ";$tree_channel_en=4;}break;
		}
		$this->assign("first",$tree_channel);
		//banner 滚动图片列表
		 $change_1="1.jpg";
		 $change_2="2.jpg";
		 $change_3="3.jpg";
		 $change_4="4.jpg";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		//-------END--------


		$this->display();
	}
	
	public function daily()
	{
		$id = intval($_GET['id']);
		$o = $_GET['o'];
		if($o=='like_comment') {
			$comment_id = $_GET['comment_id'];
			$data['id'] = $_GET['comment_id'];
			
			M('')->query('UPDATE `ai_comments` SET `like`=`like`+1 where `id`='.$comment_id);
		}elseif($o=='like') { // add like to daily article
        	M('')->query('update ai_daily set `like`=`like`+1 where `id`='.$id);
            echo json_encode(M('daily')->field('like')->where(array('id'=>$id))->find());
            return;
        }elseif($o=='unlike') { // add unlike to daily article
        	M('')->query('update ai_daily set `unlike`=`unlike`+1 where `id`='.$id);
            echo json_encode(M('daily')->field('unlike')->where(array('id'=>$id))->find());
            return;
        }
		
		$daily = M('daily')->where(array('id'=>$id))->find();
		$videos = M('daily_video')->where(array('daily_id'=>$id))->findAll();
		
		foreach ($videos as $k=>$v) {
			if (!empty($v['link'])) {
				$videos[$k]['img'] = D('Article')->getVideoImgById($v['id']);
			}
		}
		
		$commentsCount = M('comments')->where(array('parent_type'=>'4', 'parent_id'=>$id))->count();
		$pager = api('Pager');
		$pager->setCounts($commentsCount);
		$pager->setList(10);
		$pager->makePage();
		$from = ($pager->pg-1) * $pager->countlist;
		$pagerArray = (array)$pager;
		$this->assign('pager', $pagerArray);
		
		$comments = M('comments')->where(array('parent_type'=>'4', 'parent_id'=>$id))->limit("$from,$pager->countlist")->findAll();
		foreach($comments as $k=>$c) {
			$comments[$k] = $c;
			$comments[$k]['userInfo'] = getUserInfo($c['uid']);
		}
		//print_r($daily);
		$this->assign('daily', $daily);
		$this->assign('videos', $videos);
		$this->assign('comments', $comments);
		$this->assign('cssFile', 'article');
        
        $promote = M('promote')->find();
		$this->assign('promote', $promote);
		
		$promoteArticle = M('article')->where(array('is_promote'=>1))->findAll();
		
		$this->assign('promote_article', $promoteArticle);
        
        $string="select category_id,name,channel,parent from ai_article,ai_article_category where ai_article.category_id=ai_article_category.id and ai_article.id=".$id;
		$result=mysql_query($string);
		$result=mysql_fetch_array($result);
		$channel=$result['channel'];
		$tree_category_id=$result['category_id'];
		switch($channel){
			case 1: {$tree_channel="健身计划 ";$tree_channel_en="Plan";}break;
			case 2:{$tree_channel="锻炼 ";$tree_channel_en="Train";}break;
			case 3:{$tree_channel="营养 ";$tree_channel_en="Nutri";}break;
			case 4:{$tree_channel="补充 ";$tree_channel_en="Append";}break;
		}
		$tree_parent=$result['parent'];		
		$tree_name=$result['name'];
		$result=mysql_query("select name from ai_article_category where id=".$tree_parent);
		$tree_parentName=mysql_fetch_array($result);
		$this->assign("first",$tree_channel);
		$this->assign("second",$tree_parentName['name']);
		$this->assign("third",$tree_name);
		$this->assign("tree_parent",$tree_parent);
		$this->assign("tree_channel_en",$tree_channel_en);
		$this->assign("tree_category_id",$tree_category_id);
        
        $this->assign('parent', $_GET['type']);
		$this->display();
	}
	
	public function selectRegister()
	{
		$this->display('select_register');
	}
	
	public function register()
	{
		if (service('Passport')->isLogged())
			redirect(U('index/Index/index'));
		
		//验证码
		$opt_verify = $this->_isVerifyOn('register');
		if ( $opt_verify ) {
			$this->assign('register_verify_on', 1);
		}
		
		Addons::hook('public_before_register');
		
		// 邀请码
		$invite_code = h($_REQUEST['invite']);
		$invite_info = null;
		
		// 是否开放注册
		$register_option = model('Xdata')->get('register:register_type');
		if ($register_option == 'closed') { // 关闭注册
			$this->error(L('reg_close'));
		
		} else if ($register_option == 'invite') { // 邀请注册
			// 邀请方式
			$invite_option = model('Invite')->getSet();
			if ($invite_option['invite_set'] == 'close') { // 关闭邀请
				$this->error(L('reg_invite_close'));
			} else { // 普通邀请 OR 使用邀请码
				if (!$invite_code)
					$this->error(L('reg_invite_warming'));
				else if (!($invite_info = $this->__getInviteInfo($invite_code)))
					$this->error(L('reg_invite_code_error'));
			}
		} else { // 公开注册
			if (!($invite_info = $this->__getInviteInfo($invite_code)))
				unset($invite_code, $invite_info);
		}
		$this->assign('cssFile', 'register');
		$this->display();
	}
	
	public function registerCoach()
	{
		if (service('Passport')->isLogged())
			redirect(U('index/Index/index'));
		
		//验证码
		$opt_verify = $this->_isVerifyOn('register');
		if ( $opt_verify ) {
			$this->assign('register_verify_on', 1);
		}
		
		Addons::hook('public_before_register');
		
		// 邀请码
		$invite_code = h($_REQUEST['invite']);
		$invite_info = null;
		
		// 是否开放注册
		$register_option = model('Xdata')->get('register:register_type');
		if ($register_option == 'closed') { // 关闭注册
			$this->error(L('reg_close'));
		
		} else if ($register_option == 'invite') { // 邀请注册
			// 邀请方式
			$invite_option = model('Invite')->getSet();
			if ($invite_option['invite_set'] == 'close') { // 关闭邀请
				$this->error(L('reg_invite_close'));
			} else { // 普通邀请 OR 使用邀请码
				if (!$invite_code)
					$this->error(L('reg_invite_warming'));
				else if (!($invite_info = $this->__getInviteInfo($invite_code)))
					$this->error(L('reg_invite_code_error'));
			}
		} else { // 公开注册
			if (!($invite_info = $this->__getInviteInfo($invite_code)))
				unset($invite_code, $invite_info);
		}
		$this->assign('cssFile', 'register');
		$this->display();
	}
	
	public function registerGym()
	{
		if (service('Passport')->isLogged())
			redirect(U('index/Index/index'));
		
		//验证码
		$opt_verify = $this->_isVerifyOn('register');
		if ( $opt_verify ) {
			$this->assign('register_verify_on', 1);
		}
		
		Addons::hook('public_before_register');
		
		// 邀请码
		$invite_code = h($_REQUEST['invite']);
		$invite_info = null;
		
		// 是否开放注册
		$register_option = model('Xdata')->get('register:register_type');
		if ($register_option == 'closed') { // 关闭注册
			$this->error(L('reg_close'));
		
		} else if ($register_option == 'invite') { // 邀请注册
			// 邀请方式
			$invite_option = model('Invite')->getSet();
			if ($invite_option['invite_set'] == 'close') { // 关闭邀请
				$this->error(L('reg_invite_close'));
			} else { // 普通邀请 OR 使用邀请码
				if (!$invite_code)
					$this->error(L('reg_invite_warming'));
				else if (!($invite_info = $this->__getInviteInfo($invite_code)))
					$this->error(L('reg_invite_code_error'));
			}
		} else { // 公开注册
			if (!($invite_info = $this->__getInviteInfo($invite_code)))
				unset($invite_code, $invite_info);
		}
		$this->assign('cssFile', 'register');
		$this->display();
	}
	
	public function doRegister()
	{
		// 验证码
		/* $verify_option = $this->_isVerifyOn('register');
		if ($verify_option && (md5(strtoupper($_POST['verify'])) != $_SESSION['verify'])){
			$this->error(L('error_security_code'));
			exit;
		} */
		
		// 参数合法性检查
		$required_field = array(
				'email'		=> 'Email',
				'nickname'  => L('username'),
				'password'	=> L('password'),
				'repassword'=> L('retype_password'),
		);
		foreach ($required_field as $k => $v)
			if (empty($_POST[$k]))
			$this->error($v . L('not_null'));
		
		if (!$this->isValidEmail($_POST['email']))
			$this->error(L('email_format_error_retype'));
		if (!$this->isValidNickName($_POST['nickname']))
			$this->error(L('username_format_error'));
		if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16 || $_POST['password'] != $_POST['repassword'])
			$this->error(L('password_rule'));
		if (!$this->isEmailAvailable($_POST['email']))
			$this->error(L('email_used_retype'));
		
		// 是否需要Email激活
		$need_email_activate = intval(model('Xdata')->get('register:register_email_activate'));
		$data['email'] = $_POST['email'];
		$data['password'] = md5($_POST['password']);
		$data['uname'] = $_POST['nickname'];
		$data['is_active'] = '1';
		$data['is_init']  = '1';
		$data['sex']      = $_POST['sex'];
		$data['province'] = $_POST['province'];
		$data['city']     = $_POST['province'];
		$data['address']  = $_POST['address'];
		$data['goal']     = $_POST['goal'];
		$data['im']       = $_POST['begin'];
		
		$uid = M('user')->add($data);
		$data['uid'] = $uid;
		M('user_attr')->add($data);
		service('Passport')->loginLocal($uid);
		
		redirect(U('index/Index/index'));
	}
	
	public function doRegisterCoach()
	{
		// 验证码
		$verify_option = $this->_isVerifyOn('register');
		if ($verify_option && (md5(strtoupper($_POST['verify'])) != $_SESSION['verify'])){
			//$this->error(L('error_security_code'));
			//exit;
		}
		
		// 参数合法性检查
		$required_field = array(
				'email'		=> 'Email',
				'nickname'  => L('username'),
				'password'	=> L('password'),
				'repassword'=> L('retype_password'),
		);
		foreach ($required_field as $k => $v)
			if (empty($_POST[$k]))
			$this->error($v . L('not_null'));
		
		if (!$this->isValidEmail($_POST['email']))
			$this->error(L('email_format_error_retype'));
		if (!$this->isValidNickName($_POST['nickname']))
			$this->error(L('username_format_error'));
		if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16 || $_POST['password'] != $_POST['repassword'])
			$this->error(L('password_rule'));
		if (!$this->isEmailAvailable($_POST['email']))
			$this->error(L('email_used_retype'));
		
		// 是否需要Email激活
		$need_email_activate = intval(model('Xdata')->get('register:register_email_activate'));
		$data['email'] = $_POST['email'];
		$data['password'] = md5($_POST['password']);
		$data['uname'] = $_POST['nickname'];
		$data['sex']      = $_POST['sex'];
		$data['province'] = $_POST['province'];
		$data['city']     = $_POST['city'];
		$data['address']  = $_POST['address'];
		$data['goodat']   = $_POST['goodat'];
		$data['belong_gym']=$_POST['belong_gym'];
		
		$uid = M('user')->add($data);
		$data['uid'] = $uid;
		M('coach')->add($data);
		
		$group['user_group_id'] = '2';
		$group['user_group_title'] = '教练';
		$group['uid'] = $uid;
		M('user_group_link')->add($group);
		service('Passport')->loginLocal($uid);
		
		redirect(U('index/Index/index'));
		
	}
	
	public function doRegisterGym()
	{
		// 验证码
		$verify_option = $this->_isVerifyOn('register');
		if ($verify_option && (md5(strtoupper($_POST['verify'])) != $_SESSION['verify'])){
			//$this->error(L('error_security_code'));
			//exit;
		}
		
		// 参数合法性检查
		$required_field = array(
				'email'		=> 'Email',
				'nickname'  => L('username'),
				'password'	=> L('password'),
				'repassword'=> L('retype_password'),
		);
		foreach ($required_field as $k => $v)
			if (empty($_POST[$k]))
			$this->error($v . L('not_null'));
		
		if (!$this->isValidEmail($_POST['email']))
			$this->error(L('email_format_error_retype'));
		if (!$this->isValidNickName($_POST['nickname']))
			$this->error(L('username_format_error'));
		if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16 || $_POST['password'] != $_POST['repassword'])
			$this->error(L('password_rule'));
		if (!$this->isEmailAvailable($_POST['email']))
			$this->error(L('email_used_retype'));
		
		// 是否需要Email激活
		$need_email_activate = intval(model('Xdata')->get('register:register_email_activate'));
		$data['email']  = $_POST['email'];
		$data['password'] = md5($_POST['password']);
		$data['uname'] = $_POST['nickname'];
		$data['location'] = $_POST['address'];
		
		$uid = M('user')->add($data);
		$gym['uid'] = $uid;
		M('gym')->add($gym);
		
		$group['user_group_id'] = '3';
		$group['user_group_title'] = '健身房';
		$group['uid'] = $uid;
		M('user_group_link')->add($group);
		service('Passport')->loginLocal($uid);
		
		redirect(U('index/Index/index'));
	}
	
	/*
	 * remindMe 获取邮箱
	 */
	public function remindMe()
	{
		$data['email'] = t($_POST['email']);
		$data['createtime'] = time();
		$data['client_ip'] = $_SERVER['REMOTE_ADDR'];
		
		if ($_POST['method']=='ajax') {
			$id = M('remind')->add($data);
			if($id) echo 1;
			else    echo 0;
			return;
		}
		M('remind')->add($data);
		// display template
	}
	
	//检查Email地址是否合法
	public function isValidEmail($email) {
		if(UC_SYNC){
			$res = uc_user_checkemail($email);
			if($res == -4){
				return false;
			}else{
				return true;
			}
		}else{
			return preg_match("/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/i", $email) !== 0;
		}
	}
	
	//检查Email是否可用
	public function isEmailAvailable($email = null) {
		$return_type = empty($email) ? 'ajax' 		   : 'return';
		$email		 = empty($email) ? $_POST['email'] : $email;
	
		$res = M('user')->where('`email`="'.$email.'"')->find();
		if(UC_SYNC){
			$uc_res = uc_user_checkemail($email);
			if($uc_res == -5 || $uc_res == -6){
				$res = true;
			}
		}
	
		if ( !$res ) {
			if ($return_type === 'ajax') echo 'success';
			else return true;
		}else {
			if ($return_type === 'ajax') echo L('email_used');
			else return false;
		}
	}
	
	// 检查验证码是否可用
	public function isVerifyAvailable($verify = null) {
		$return_type = empty($verify) ? 'ajax' : 'return';
		$verify = empty($verify) ? $_POST['verify'] : $verify;
		$verify_option = $this->_isVerifyOn('register');
		if($verify_option && md5(strtoupper($verify)) == $_SESSION['verify']) {
			if($return_type === 'ajax') {
				echo 'success';
			} else {
				return true;
			}
		} else {
			if($return_type === 'ajax') {
				echo '验证码输入错误';
			} else {
				return false;
			}
		}
	
	}
	
	//检查昵称是否符合规则，且是否为唯一
	public function isValidNickName($name) {
	
		$return_type  = empty($name)  ? 'ajax' 		   			: 'return';
		$name		  = empty($name)  ? t($_POST['nickname']) 	: $name;
	
		//昵称不能是纯数字昵称
		if(is_numeric($name)){
			echo '昵称不能是纯数字昵称';
			return;
		}
	
		//检查禁止注册的用户昵称
		$audit = model('Xdata')->lget('audit');
		if($audit['banuid']==1){
			$bannedunames = $audit['bannedunames'];
			if(!empty($bannedunames)){
				$bannedunames = explode('|',$bannedunames);
				if(in_array($name,$bannedunames)){
					if ($return_type === 'ajax') {
						echo '这个昵称禁止注册';
						return;
					} else {
						$this->error('这个昵称禁止注册');
					}
				}
			}
		}
	
		if (UC_SYNC) {
			$uc_res = uc_user_checkname($name);
			if($uc_res == -1 || !isLegalUsername($name)){
				if ($return_type === 'ajax') { echo L('username_rule');return; }
				else return false;
			}
		} else if (!isLegalUsername($name)) {
			if ($return_type === 'ajax') { echo L('username_rule');return; }
			else return false;
		} else if (checkKeyWord($name)) {
			if ($return_type === 'ajax') {
				echo '昵称含有敏感词';
				return;
			} else {
				$this->error('昵称含有敏感词');
			}
		}
	
		if ($this->mid) {
			$res = M('user')->where("uname='{$name}' AND uid<>{$this->mid}")->count();
			$nickname = M('user')->getField('uname',"uid={$this->mid}");
			if (UC_SYNC && ($uc_res == -2 || $uc_res == -3) && $nickname != $name) {
				$res = 1;
			}
		} else {
			$res = M('user')->where("uname='{$name}'")->count();
			if(UC_SYNC && ($uc_res == -2 || $uc_res == -3)){
				$res = 1;
			}
		}
	
		if ( !$res ) {
			if ($return_type === 'ajax') echo 'success';
			else return true;
		}else {
			if ($return_type === 'ajax') echo L('username_used');
			else return false;
		}
	}
	
	public function getVideoImg()
	{
		header("Content-Type:image/jpeg");
		$id = intval($_GET['id']);
		if(!$id) return 'error';
		$img = D('Article')->getVideoImgById($id);
		$type = getimagesize($img);
		//print_r($type);
		$data = fread(fopen($img,'rb'),filesize($img));
		echo $data;
		//echo $img;
		//return $img;
	}
	
	private function _isVerifyOn($type='login'){
		// 检查验证码
		if($type!='login' && $type!='register') return false;
		$opt_verify = $GLOBALS['ts']['site']['site_verify'];
		return in_array($type, $opt_verify);
	}
	
	private function __getInviteInfo($invite_code)
	{
		$res = null;
		$invite_option = model('Invite')->getSet();
		switch (strtolower($invite_option['invite_set'])) {
			case 'close':
				$res = null;
				break;
			case 'common':
				$res = D('User', 'home')->getUserByIdentifier($invite_code, 'uid');
				break;
			case 'invitecode':
				$res = model('Invite')->checkInviteCode($invite_code);
				if ($res['is_used'])
					$res = null;
				break;
		}
	
		return $res;
	}
}
?>
