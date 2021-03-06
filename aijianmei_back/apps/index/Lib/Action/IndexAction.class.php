﻿<?php
class IndexAction extends Action {
function show_banner($type){
    if($type==1){
         $articleid_1="74";
         $articleid_2="72";
         $articleid_3="70";
         $articleid_4="69";
         $name_1="体重训练之锻炼";
         $name_2="体重训练之营养";
         $name_3="体重训练：辅助品 ";
         $name_4="体重训练：生活方式";
         $describe_1="如果你的目标是“不去健身房，短时间塑造健美身材”，那你就来对地方了。通过我们网站每天更新的健身资讯，你就能在指尖的点击间获取专业科学的健身规划。";
         $describe_2="最佳的身体体脂水平需要三个主要的东西：合适的营养、规律的锻炼和有效率的恢复。阅读一下这篇文章来确保你身体正确的自我修复，剩下的就是控制好你的营养摄入了。";
         $describe_3="所谓营养辅助品，就是辅助那些你从食物上面得到营养的东西。它们可以帮助你提升整体营养水平和为了达到特定目标而所需的条件。";
         $describe_4="不管你是谁、在哪里运动、或者你有多少经验，有几点你必须要遵守以成功达到目标。健身是很长的一个过程，而不是由一个月的随机零散的几个锻炼就完成了。";
         $change_1="1-1.jpg";
         $change_2="1-2.jpg";
         $change_3="1-3.jpg";
         $change_4="1-4.jpg";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
          $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
        }else if($type==2)
        {
         $articleid_1="79";
         $articleid_2="78";
         $articleid_3="77";
         $articleid_4="76";
         $name_1="日常健身：锻炼";
         $name_2="日常健身：营养";
         $name_3="日常健身：辅助品 ";
         $name_4="日常健身：生活方式";
         $describe_1="我们所提供的锻炼计划和内容适用不同年龄层的男女朋友。在这里，女性朋友们可以拥有苗条、性感的身材，而男性朋友则可以收获强壮、结实的体魄。";
         $describe_2="你的目标是提高健身水平、显得更修长和增加整体的健康状况，对吗？如果是，那么这个营养计划会帮助你踏上正轨。";
         $describe_3="营养辅助品是在传统日常的食物来源之外为你提供额外的营养。他们有助于那些缺少特定营养的人补充营养，或者是对那种需要某种额外营养的人提供帮助。";
         $describe_4="健身计划是设计来促成这些目标的，你的目标是承诺跟随这些健身计划，读并且跟随我们的营养信息并且给予身体时间来恢复和改变，那是你健身的三个基础：营养、锻炼、恢复。";
         $change_1="2-1.jpg";
         $change_2="2-2.jpg";
         $change_3="2-3.jpg";
         $change_4="2-4.jpg";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
          $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
        }else if($type==3)
        {
         $articleid_1="90";
         $articleid_2="89";
         $articleid_3="88";
         $articleid_4="87";
         $name_1="运动员：锻炼";
         $name_2="运动员：营养";
         $name_3="运动员：辅助品";
         $name_4="运动员：生活方式";
         $describe_1="无论是足球、篮球还是羽毛球运动员，这些计划的出发点都是帮助你达到最专业、具有竞争力的运动员水准。";
         $describe_2="如果你的目标是锻炼出像运动员一样的身材，那么你的饮食是至关重要的。首先，从了解自己的体脂水平开始，然后开始向你的目标进发！";
         $describe_3="营养辅助品在保持运动员动力、身体恢复还有为巅峰状态作准备方面扮演着至关重要的角色。";
         $describe_4="我们的目标是为了帮助我们的运动员成为中国最好的运动员，如果你跟随我们的每日例行运动。花点时间读网站上关于营养和辅助品的推荐，你肯定能把身体推到新的健身水平去。";
         $change_1="3-1.jpg";
         $change_2="3-2.jpg";
         $change_3="3-3.jpg";
         $change_4="3-4.jpg";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);	
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
         $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
        }else 
        {
         $articleid_1="91";
         $articleid_2="84";
         $articleid_3="82";
         $articleid_4="75";
         $name_1="健身运动员：锻炼";
         $name_2="健身运动员：营养";
         $name_3="健身运动员：辅助品";
         $name_4="健身运动员：生活方式";
         $describe_1="我们会指导你在健身的正轨锻炼——阅读我们关于训练、营养和补充品文章和教学视频，你会懂得很多丰富的健身知识，这对你实现目标来说非常重要。";
         $describe_2="营养特别容易被忽视，你每天需要3-5餐，并且中间最好夹杂一些小吃。这样吃一段时间，例如三个月，加上锻炼，你会迟早都能达到目标了。";
         $describe_3="通过在正确的时间服用适合分量的营养辅助品，你可以帮助你的身体来达到膳食不能达到的境界。";
         $describe_4="你要理解拥有完美身体的过场是很漫长而且顺序渐进的。不存在什么“一个月完美计划”，紧紧跟随我们的锻炼计划，在每天的锻炼中都投入努力和精力。";
         $change_1="4-1.jpg";
         $change_2="4-2.jpg";
         $change_3="4-3.jpg";
         $change_4="4-4.jpg";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);	
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
         $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
        }

    }

    public function newindex() 
    {
		ob_start();
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
                    service('Shop')->login($logId['uid']); // 同步登录商城
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
					$data['is_email']=0;
                    
                    //print_r($data);
                    
                    $uid = M('user')->add($data);				
                    service('Passport')->loginLocal($uid);	
                    
                    // 同步注册商城
                    service('Shop')->register($data['uname'], $data['email'], $data['password']);				
                    
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
	
            }catch (DengluException $e) {
                echo $e->geterrorDescription();
            }
        }

        if(!empty($_REQUEST['code'])) {
            require_once $_SERVER['DOCUMENT_ROOT'].'/saetv2.ex.class.php';
            $sina = new SaeTOAuthV2('3622140445', 'f94d063d06365972215c62acaadf95c3');
            $token = $sina->getAccessToken('code', array('code'=>$_REQUEST['code'], 'redirect_uri'=>'http://www.aijianmei.com/index.php'));
            $client = new SaeTClientV2('3622140445', 'f94d063d06365972215c62acaadf95c3', $token['access_token']);

            $uid_get = $client->get_uid();
            $uid = $uid_get['uid'];
            $user_message = $client->show_user_by_id( $uid);
            //print_r($user_message);

            //$logId = M('others')->field('uid')->where(array('mediaID'=>'3', 'mediaUserID'=>$user_message['id'], 'personID'=>$user_message['idstr']))->find();
            echo $log_sql = 'select uid from ai_others where mediaID=3 and mediaUserID='.$user_message['id'].' and personID='.$user_message['idstr'].'';
            //echo $log_sql;
			exit;
            $logId = M('')->query($log_sql);
            //var_dump($logId);
            $setMailSql="select email from ai_user where uid='".$logId[0]['uid']."'";
            $setMail = M('')->query($setMailSql);
            if($logId) {
                service('Passport')->loginLocal($logId[0]['uid']);
				$_SESSION['sinalogin']=1;
				$checkEmailSql="select email from ai_user where uid='".$logId[0]['uid']."'";
				$checkEmailArr=M('')->query($checkEmailSql);
				if(empty($checkEmailArr[0]['email'])){
					redirect(U('index/User/loginUserInfo'));
				}
				$get_usernameSql="select * from ai_user where email='".$checkEmailArr[0]['email']."'";
				$get_usernameInfo = M('')->query($get_usernameSql);
				$getUidSql='select user_id,user_name,email,password from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
				$uid = M('')->query($getUidSql);
				$_SESSION['user_id']   = $uid[0]['user_id'];
				$_SESSION['user_name'] = $uid[0]['user_name'];
				$_SESSION['email']     = $uid[0]['email'];
				$_SESSION['ways']++;
				if($_SESSION['mid']>0){
					$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
				}
				setcookie("LOGGED_AIUSER", $checkEmailArr[0]['email'], time()+3600*24*30);
				setcookie('LOGGED_AICOD', md5("aijianmeipwd".$get_usernameInfo[0]['password']), time()+3600*24*30);		
				setcookie("ECS[user_id]",  $_SESSION['user_id'],time()+3600*24*30);  //set cookie         
				setcookie("ECS[password]", $uid[0]['password'],time()+3600*24*30);
				ob_get_clean();				
				//print_r($_COOKIE);
				if($_SESSION['refer_url']!=''&&$_SESSION['shoprefer_url']==''){
					$reurl=$_SESSION['refer_url'];
					unset($_SESSION['refer_url']);
					redirect($reurl);
					//print_r($_SESSION);exit;
					//redirect(U('index/Index/index'));
				}
				elseif($_SESSION['shoprefer_url']!=''){
					$reurl=$_SESSION['shoprefer_url'];
					unset($_SESSION['shoprefer_url']);
					redirect($reurl);
				}else{
					redirect(U('index/Index/index'));
				}
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
				$_SESSION['mid']=$uid;
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
                //mysql_query($other_sql);
                M('')->query($other_sql);
				//redirect(U('index/User/loginUserInfo'));
                //M('others')->add($other);
				$_SESSION['sinalogin']=1;
				print_r($other);exit;
				if($other['mediaUserID']==2578458467){
					redirect(U('index/User/register'));
				}
				redirect(U('index/User/loginUserInfo'));
            }
        }
        if($_POST['email']!=''&&$_POST['emailact']=='upemail'){
            $umailsql="update ai_others set email='".trim($_POST['email'])."' where uid='".addslashes($_POST['emailuid'])."'";
            M('')->query($umailsql);
        }
        
        
        if(!empty($_GET['apiType'])&&$_GET['apiType']=='renren'){
            //print_r($_GET);
            //print_r($_SERVER);
        }
        if(!empty($_GET['qquid'])&&$_GET['qqapi']=='login'){
            service('Passport')->loginLocal($_GET['qquid']);
			$_GET['qquid']=addslashes($_GET['qquid']);
			$checkEmailSql="select email from ai_user where uid='".$_GET['qquid']."'";
			$checkEmailArr=M('')->query($checkEmailSql);
			if(empty($checkEmailArr[0]['email'])){
				$_SESSION['sinalogin']=1;
				redirect(U('index/User/loginUserInfo'));
				//redirect(U('home/Account/index',array('esg'=>'needemail')));
			}
			$get_usernameSql="select * from ai_user where email='".$checkEmailArr[0]['email']."'";
			$get_usernameInfo = M('')->query($get_usernameSql);
			$getUidSql='select user_id,user_name,email,password from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
			$uid = M('')->query($getUidSql);
			$_SESSION['user_id']   = $uid[0]['user_id'];
			$_SESSION['user_name'] = $uid[0]['user_name'];
			$_SESSION['email']     = $uid[0]['email'];
			$_SESSION['ways']++;
			if($_SESSION['mid']>0){
				$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
			}
			@setcookie("LOGGED_AIUSER", $checkEmailArr[0]['email'], time()+3600*24*30);
			@setcookie('LOGGED_AICOD', md5("aijianmeipwd".$get_usernameInfo[0]['password']), time()+3600*24*30);		
			@setcookie("ECS[user_id]",  $_SESSION['user_id'],time()+3600*24*30);  //set cookie         
			@setcookie("ECS[password]", $uid[0]['password'],time()+3600*24*30);
			if($_SESSION['refer_url']!=''){
				$reurl=$_SESSION['refer_url'];
				unset($_SESSION['refer_url']);
				redirect($reurl);
			}
			elseif($_SESSION['shoprefer_url']!=''){
				$reurl=$_SESSION['shoprefer_url'];
				unset($_SESSION['shoprefer_url']);
				redirect($reurl);
			}else{
				redirect(U('index/Index/index'));
			}
        }
        $this->setTitle('index');
        $this->assign('uid',$this->mid);
        $this->assign('cssFile','index');
        

        //add by kon at 20130410 start
        /*首页添加最新4篇文章视频*/
        
        $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
        $sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by create_time desc limit 0,4";
		$hotvideos=null;
		$hotvideos=$this->getDataCache(md5($sql));
		if(!$hotvideos){
			$hot_video = M('')->query($sql);
			foreach($hot_video as $k=>$v) {
				$hotvideos[$k] = $v;
				$data = json_decode($this->getVideoData($v['link']));
				$hotvideos[$k]['logo'] = $data->data[0]->logo;
				$hotvideos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);
				unset($hotvideos[$key]['content']);				
			}
			$this->setDataCache(md5($sql),$hotvideos);
		}	
		$this->assign('hotvideos', $hotvideos);
		
        /*首页添加最新4篇文章*/
        $sql = "select a.* from ai_article a group by a.id order by a.create_time desc limit 0,4";
		$hotArticles=null;
		$hotArticles=$this->getDataCache(md5($sql));
		if(!$hotArticles){
			$hotArticles = M('')->query($sql);
			foreach ($hotArticles as $key => $value) {
				$hotArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
				unset($hotArticles[$key]['content']);
			}
			$this->setDataCache(md5($sql),$hotArticles);
		}
        $this->assign('hotArticles', $hotArticles);
        //add by kon at 20130410 end
		
		//header current add by kon at 20130415
		$this->assign('_current', 'index');
        $this->display();
    }
	
	public function index() 
    {
    $bannerinfo=unserialize(include('PublicCache/advImgCache.php'));
    $bannerinfo=$bannerinfo['index'];

    foreach ($bannerinfo['imginfo'] as $key=>$value) {
     	 $bannerinfoTmp[$key]['name']=$value['title'];
     	 $bannerinfoTmp[$key]['img']='../'.$value['img'];
     	 $bannerinfoTmp[$key]['url']=$value['url'];
    } 

    $bannerinfo=$bannerinfoTmp;
		/*$bannerinfo=array(
		'1'=>array(
			'name'=>'新手变身"肌肉型男"必看',
			'img'=>'../Public/images/banner/index_1.jpg',
			'url'=>'/index-Index-articleDetail-52.html'
			),
		'2'=>array(
			'name'=>'爱健美专属：每日健身计划',
			'img'=>'../Public/images/banner/index_2.jpg',
			'url'=>"/index-Index-articleDetail-93.html"),
		'3'=>array(
			'name'=>'七招营养秘笈，吃出“肌肉”',
			'img'=>'../Public/images/banner/index_3.jpg',
			'url'=>"/index-Index-articleDetail-34.html")
		);*/
		$this->assign('_bannerInfo',$bannerinfo);	
		ob_start();
        if (!empty($_GET['token'])) {
            require_once $_SERVER['DOCUMENT_ROOT'].'/Denglu.php';
            $api = new Denglu('44031dena3J8cuBsQeX40lcpjSsPM3', '85015440v4NfCVj6aTNfZAg0idQv03', 'utf-8');
            
            try {
                $userInfo = $api->getUserInfoByToken($_GET['token']);
                //print_r($userInfo);exit;

                $logId = M('others')->field('uid')->where(array('mediaID'=>$userInfo['mediaID'], 'mediaUserID'=>$userInfo['mediaUserID'], 'personID'=>$userInfo['personID']))->find();
                //print_r($logId);
                if($logId) {
                    service('Passport')->loginLocal($logId['uid']);
                    service('Shop')->login($logId['uid']); // 同步登录商城
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
										$data['is_email']=0;
                    
                    //print_r($data);
                    
                    $uid = M('user')->add($data);				
                    service('Passport')->loginLocal($uid);	
                    
                    // 同步注册商城
                    service('Shop')->register($data['uname'], $data['email'], $data['password']);				
                    
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
	
            }catch (DengluException $e) {
                echo $e->geterrorDescription();
            }
        }

        if(!empty($_REQUEST['code'])) {
            require_once $_SERVER['DOCUMENT_ROOT'].'/saetv2.ex.class.php';
            $sina = new SaeTOAuthV2('3622140445', 'f94d063d06365972215c62acaadf95c3');
            $token = $sina->getAccessToken('code', array('code'=>$_REQUEST['code'], 'redirect_uri'=>'http://www.aijianmei.com/index.php'));
            $client = new SaeTClientV2('3622140445', 'f94d063d06365972215c62acaadf95c3', $token['access_token']);
			
            $uid_get = $client->get_uid();
            $uid = $uid_get['uid'];
            $user_message = $client->show_user_by_id( $uid);
            //print_r($user_message);

			//if($user_message['id']==2578458467){echo $_REQUEST['code'];exit;}
            //$logId = M('others')->field('uid')->where(array('mediaID'=>'3', 'mediaUserID'=>$user_message['id'], 'personID'=>$user_message['idstr']))->find();
            $log_sql = 'select id,uid from ai_others where mediaID=3 and mediaUserID='.$user_message['id'].'';
            //echo $log_sql;
            $logId = M('')->query($log_sql);
            //var_dump($logId);
            $setMailSql="select password,email,uname from ai_user where uid='".$logId[0]['uid']."'";
            $setMail = M('')->query($setMailSql);
			if($setMail[0]['password']==null||$setMail[0]['email']==null){
				$sql=null;
				$sql="delete from ai_others where id='".$logId[0]['id']."'";
				M('')->query($sql);
				$sql="delete from ai_user where uid='".$logId[0]['uid']."'";
				M('')->query($sql);
				$sql="delete from ecs_users where user_name='".$$setMail[0]['uname']."'";
				M('')->query($sql);
				$logId=null;
			}
			if($logId) {
				service('Passport')->loginLocal($logId[0]['uid']);
				$_SESSION['sinalogin']=1;
				$upsql="update `aijianmei`.`ai_others` set profileImageUrl='". $user_message['profile_image_url']."' where uid='".$logId[0]['uid']."'";
				M('')->query($upsql);
				$checkEmailSql="select email from ai_user where uid='".$logId[0]['uid']."'";
				$checkEmailArr=M('')->query($checkEmailSql);
				if(empty($checkEmailArr[0]['email'])){
					redirect(U('index/User/edituserinfo'));
				}
				$get_usernameSql="select * from ai_user where email='".$checkEmailArr[0]['email']."'";
				$get_usernameInfo = M('')->query($get_usernameSql);
				$getUidSql='select user_id,user_name,email,password from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
				$uid = M('')->query($getUidSql);
				$_SESSION['user_id']   = $uid[0]['user_id'];
				$_SESSION['user_name'] = $uid[0]['user_name'];
				$_SESSION['email']     = $uid[0]['email'];
				$_SESSION['ways']++;
				if($_SESSION['mid']>0){
					$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
				}
				setcookie("LOGGED_AIUSER", $checkEmailArr[0]['email'], time()+3600*24*30);
				setcookie('LOGGED_AICOD', md5("aijianmeipwd".$get_usernameInfo[0]['password']), time()+3600*24*30);		
				setcookie("ECS[user_id]",  $_SESSION['user_id'],time()+3600*24*30);  //set cookie         
				setcookie("ECS[password]", $uid[0]['password'],time()+3600*24*30);
				
			/*forum 论坛 登陆api start by kontem at20130626*/
			$pwUserInfoSql="select * from ai_pwforum.pw_user where username='".$uid[0]['user_name']."' and email='".$uid[0]['email']."'";
			$pwUserInfo=M('')->query($pwUserInfoSql);
			//检测用户是否已经有论坛对应的账号
			if(empty($pwUserInfo[0])){
			//不存在则调用注册api
			$post_data=array( 
				'username' => $uid[0]['user_name'],
			  'email' => $uid[0]['email'],
			  'password' =>'ai123456',
			  'repassword' =>'ai123456',
			  );
			$inserTmpSql=null;
			$inserTmpSql="INSERT INTO  aijianmei.ai_forum_tmp_user (id ,email ,password)
			VALUES (NULL ,  '".$uid[0]['email']."',  'ai123456')";  
			M('')->query($inserTmpSql);
			$url=AIBASEURL."/forum/pwApi.php?pwact=register";
			$out=_CurlPost($url,$post_data);//targetUrl postData
			}
			$pwUserInfoSql="select * from ai_pwforum.pw_user where username='".$uid[0]['user_name']."' and email='".$uid[0]['email']."'";
			$pwUserInfo=M('')->query($pwUserInfoSql);
			//$this->pwImgCopy($_SESSION['mid'],$pwUserInfo[0]['uid']);
			//调用登陆api
			$tmpPassword=M('')->query("select password from ai_forum_tmp_user where email='".$uid[0]['email']."'");
			$url=AIBASEURL."/forum/pwApi.php?pwact=login";
			$post_data=array(
				'username' => $uid[0]['user_name'],
			  'password' =>$tmpPassword[0]['password'],
			  'is_sinalogin' =>1,
			 );
			$_SESSION['pwai_url']=_CurlPost($url,$post_data);
			/*论坛部分自己回调登陆*/
			/*forum 论坛 登陆api end*/

				
				ob_get_clean();				
				//print_r($_COOKIE);
				if($_SESSION['refer_url']!=''&&$_SESSION['shoprefer_url']==''){
					$reurl=$_SESSION['refer_url'];
					unset($_SESSION['refer_url']);
					redirect($reurl);
					//print_r($_SESSION);exit;
					//redirect(U('index/Index/index'));
				}
				elseif($_SESSION['shoprefer_url']!=''){
					$reurl=$_SESSION['shoprefer_url'];
					unset($_SESSION['shoprefer_url']);
					redirect($reurl);
				}else{
					redirect(U('index/Index/index'));
				}
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
                $sql = 'insert into ai_user (`uname`,`sex`,`location`,`is_active`,`ctime`,`upic_type`) values ("'.$data['uname'].'","'.$data['sex'].'","'.$data['location'].'","'.$data['is_active'].'","'.$data['ctime'].'",2)';
                M('')->query($sql);

                $uid = mysql_insert_id();
                //var_dump($uid);
                //$uid = M('user')->add($data);				
                service('Passport')->loginLocal($uid);
								$_SESSION['mid']=$uid;
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
                //mysql_query($other_sql);
                M('')->query($other_sql);
				//redirect(U('index/User/loginUserInfo'));
                //M('others')->add($other);
				$_SESSION['sinalogin']=1;

					redirect(U('index/Reg/register'));

				//redirect(U('index/User/register'));
				//redirect(U('index/User/loginUserInfo'));
            }
        }
        if($_POST['email']!=''&&$_POST['emailact']=='upemail'){
            $umailsql="update ai_others set email='".trim($_POST['email'])."' where uid='".addslashes($_POST['emailuid'])."'";
            M('')->query($umailsql);
        }

        if(!empty($_GET['qquid'])&&$_GET['qqapi']=='login'){
            service('Passport')->loginLocal($_GET['qquid']);
						$_GET['qquid']=addslashes($_GET['qquid']);
						$checkEmailSql="select uname,email from ai_user where uid='".$_GET['qquid']."'";
						$checkEmailArr=M('')->query($checkEmailSql);
						if(empty($checkEmailArr[0]['email'])){//检测是否有注册邮箱 没有就跳转到注册页面
							$_SESSION['sinalogin']=1;
								redirect(U('index/Reg/register'));
							//redirect(U('index/User/register'));
						}
						$get_usernameSql="select * from ai_user where email='".$checkEmailArr[0]['email']."'";
						$get_usernameInfo = M('')->query($get_usernameSql);
						$getUidSql='select user_id,user_name,email,password from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
						$uid = M('')->query($getUidSql);
						$_SESSION['user_id']   = $uid[0]['user_id'];
						$_SESSION['user_name'] = $uid[0]['user_name'];
						$_SESSION['email']     = $uid[0]['email'];
						$_SESSION['ways']++;
						if($_SESSION['mid']>0){
							$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
						}
						@setcookie("LOGGED_AIUSER", $checkEmailArr[0]['email'], time()+3600*24*30);
						@setcookie('LOGGED_AICOD', md5("aijianmeipwd".$get_usernameInfo[0]['password']), time()+3600*24*30);		
						@setcookie("ECS[user_id]",  $_SESSION['user_id'],time()+3600*24*30);  //set cookie         
						@setcookie("ECS[password]", $uid[0]['password'],time()+3600*24*30);
						
						/*forum 论坛 登陆api start by kontem at20130626*/
						$pwUserInfoSql="select * from ai_pwforum.pw_user where username='".$uid[0]['user_name']."' and email='".$uid[0]['email']."'";
						$pwUserInfo=M('')->query($pwUserInfoSql);
						//检测用户是否已经有论坛对应的账号
						if(empty($pwUserInfo[0])){
							//不存在则调用注册api
							$post_data=array( 
								'username' => $uid[0]['user_name'],
			 		 			'email' => $uid[0]['email'],
			  				'password' =>'ai123456',
			  				'repassword' =>'ai123456',
			  			);
							$inserTmpSql=null;
							$inserTmpSql="INSERT INTO  aijianmei.ai_forum_tmp_user (id ,email ,password)
							VALUES (NULL ,  '".$uid[0]['email']."',  'ai123456')";  
							M('')->query($inserTmpSql);
							$url=AIBASEURL."/forum/pwApi.php?pwact=register";
							$out=_CurlPost($url,$post_data);//targetUrl postData
						}
						$pwUserInfoSql="select * from ai_pwforum.pw_user where username='".$uid[0]['user_name']."' and email='".$uid[0]['email']."'";
						$pwUserInfo=M('')->query($pwUserInfoSql);
						//$this->pwImgCopy($_SESSION['mid'],$pwUserInfo[0]['uid']);
						//调用登陆api
						$tmpPassword=M('')->query("select password from ai_forum_tmp_user where email='".$uid[0]['email']."'");
						$url=AIBASEURL."/forum/pwApi.php?pwact=login";
						$post_data=array(
							'username' => $uid[0]['user_name'],
			  			'password' =>$tmpPassword[0]['password'],
			 	 			'is_sinalogin' =>1,
			 			);
			 			$_SESSION['pwai_url']=_CurlPost($url,$post_data);
						/*论坛部分自己回调登陆*/
						/*forum 论坛 登陆api end*/
						
						if($_SESSION['refer_url']!=''){
							$reurl=$_SESSION['refer_url'];
							unset($_SESSION['refer_url']);
							redirect($reurl);
						}
						elseif($_SESSION['shoprefer_url']!=''){
							$reurl=$_SESSION['shoprefer_url'];
							unset($_SESSION['shoprefer_url']);
							redirect($reurl);
						}else{
							redirect(U('index/Index/index'));
						}
        }
        $this->setTitle('index');
        $this->assign('uid',$this->mid);
        $this->assign('cssFile','index');
        //$pg=
				$nums=5;
        //add by kon at 20130410 start
        /*首页添加最新5篇视频*/
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		
		$countsql = "select count(*) as cnums from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by create_time desc";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		//分页
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pglimit=$pg=1;
		}
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=index&act=index&ctype=3&pg=');
		$pagerArray = $pagerData['html'];

		//print_r($pagerArray);
        $sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by create_time desc limit ".(($pglimit-1)*20).",$nums";
		$newvideos=$hot_video=null;
		$newvideos=$this->getDataCache(md5($sql));
		if(!$newvideos){
			$hot_video = M('')->query($sql);
			foreach($hot_video as $k=>$v) {
				$newvideos[$k] = $v;
				$data = json_decode($this->getVideoData($v['link']));
				$newvideos[$k]['logo'] = $data->data[0]->logo;
				$newvideos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);            
			}
			$this->setDataCache(md5($sql),$newvideos);
		}
		$this->assign('newvideosPage', $pagerArray);
        $this->assign('newvideos', $newvideos);
		
		/*首页添加最热5篇视频*/
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		$countsql = "select count(*) as cnums from ai_video v,($orderTableSql) t where v.category_id=t.aid ";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pg,'/index.php?app=index&mod=index&act=index&ctype=4&pg=');
		$pagerArray = $pagerData['html'];
		  
    $sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by click desc limit ".($pg-1)*$nums.",$nums";
		$hotvideos=$hot_video=null;
		$hotvideos=$this->getDataCache(md5($sql));
		if(!$hotvideos){
			$hot_video = M('')->query($sql);
			foreach($hot_video as $k=>$v) {
				$hotvideos[$k] = $v;
				$data = json_decode($this->getVideoData($v['link']));
				$hotvideos[$k]['logo'] = $data->data[0]->logo;
				$hotvideos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);            
			}
			$this->setDataCache(md5($sql),$hotvideos);
		}
		$this->assign('hotvideosPage', $pagerArray);
    $this->assign('hotvideos', $hotvideos);
		
    /*首页添加最新5篇文章*/
		//getDataCache($key)
		//setDataCache($key,$data)
		$countsql="select count(*) as cnums from ai_article";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=index&act=index&ctype=1&pg=');
		$pagerArray = $pagerData['html'];
		$sql = "select a.* from ai_article a group by a.id order by a.create_time desc limit ".($pg-1)*$nums.",$nums";
		$newArticles=null;
		$newArticles=$this->getDataCache(md5($sql));
		if(!$newArticles){
			$newArticles = M('')->query($sql);
			foreach ($newArticles as $key => $value) {
				unset($newArticles[$key]['content']);
				unset($newArticles[$key]['wapcontent']);
				$newArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
			}
			$this->setDataCache(md5($sql),$newArticles);
		}
		//print_r($newArticles);
		$this->assign('newArticlespage', $pagerArray);
		$this->assign('newArticles', $newArticles);
		
		/*首页添加最热5篇文章*/
		
		$countsql="select count(*) as cnums from ai_article";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=index&act=index&ctype=2&pg=');
		$pagerArray = $pagerData['html'];
		
    $sql = "select a.* from ai_article a group by a.id order by a.reader_count desc limit ".($pg-1)*$nums.",$nums";
		$hotArticles=null;
		$hotArticles=$this->getDataCache(md5($sql));
		if(!$hotArticles){
			$hotArticles = M('')->query($sql);
			foreach ($hotArticles as $key => $value) {
				unset($hotArticles[$key]['content']);
				unset($hotArticles[$key]['wapcontent']);
				$hotArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
			}
			$this->setDataCache(md5($sql),$hotArticles);
		}
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        //add by kon at 20130410 end
		
		//header current add by kon at 20130415
		//print_r($_SESSION);

		$prolist=unserialize(include('PublicCache/proListCache.php'));
		$this->assign('prolist', $prolist);
		$this->assign('_current', 'index');
        //$this->display();
		$this->display('newindex');
    }
    public function setmail()
    {
        $this->assign('cssFile', 'register');
        $this->display('setmail');
    }
    
    
    public function app()
    {
        $this->display();
    }

    public function articleDetail()
    {	
        $pagenums=7;
        $o = $_GET['o'];
        if($o=='like') {
            if($this->mid) {				
                $is_vote = M('article_vote')->where(array('uid'=>$this->mid, 'article_id'=>$_GET['id']))->find();
                if(!empty($is_vote)) {
                    echo '<script type="text/javascript">alert("已经投票");</script>';
                }else {
                    M('')->query('update ai_article set `like`=`like`+1 where id='.$_GET['id']);
                    $data['uid'] = $this->mid;
                    $data['article_id'] = $_GET['id'];
                    M('')->query('insert into ai_article_vote (`uid`,`article_id`) values ("'.$this->mid.'","'.$_GET['id'].'"');
                }				
            }else {
                
            }
        }elseif($o=='unlike') {
            if($this->mid) {
                $is_vote = M('article_vote')->where(array('uid'=>$this->mid, 'article_id'=>$_GET['id']))->find();
                if(!empty($is_vote)) {
                    echo '<script type="text/javascript">alert("已经投票");</script>';
                }else {
                    M('')->query('update ai_article set `unlike`=`unlike`+1  where id='.$_GET['id']);
                    M('article_vote')->add(array('uid'=>$this->mid, 'article_id'=>$_GET['id']));
                }
            }else {
                
            }
        }
        $string="update ai_article set reader_count=reader_count+1 where id=".$_GET['id'];
        M('')->query($string);
        global $ts;
            
        $id = (int) $_GET['id'];
        $map['id'] = $id;
        $article = M('article')->where($map)->find();
		preg_match_all("/src\s*=\s*[\"|\']?\s*([^\"\'\s]*)/i",str_ireplace("\\","",$article['content']),$out);
		$aimgsrc=$out[1][0];
		$article['dateStrng']=_returnNdate($article['create_time']);
        $this->assign('article', $article); 
        $this->assign('aimgsrc', $aimgsrc); 
        
        $commentCounts = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->count();
        $pager = api('Pager');
        $pager->setCounts($commentCounts);
        $pager->setList($pagenums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;		
        $pagerArray = (array)$pager;
        $this->assign('pager', $pagerArray);
        //$articleComments = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->limit("$from,$pager->countlist")->findAll();
        $sql="select * from ai_comments where parent_id=$id and parent_type=1 order by create_time desc limit $from,$pager->countlist";
        $result=null;
        $result=M('article')->query($sql);
        foreach($result as $key=> $value){
            $result[$key]['user'] = getUserInfo($value['uid']);
        }
        $this->assign('commentCounts', $commentCounts?$commentCounts:0);
        $this->assign('comments', $result);
        $this->assign('hotComments', $hotArticlecomments);
        
        $promote = M('promote')->find();
        $this->assign('promote', $promote);
        
        $promoteArticle = M('article')->where(array('is_promote'=>1))->findAll();
        foreach($promoteArticle as $key =>$value){
            $promoteArticle[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        
        $this->assign('promote_article', $promoteArticle);
        $this->assign('cssFile', 'article');
        $this->assign('uid', $this->mid);

        $string="select category_id,name,channel,parent from ai_article,ai_article_category where ai_article.category_id=ai_article_category.id and ai_article.id=".$id;
        $result=mysql_query($string);
        $result=mysql_fetch_array($result);
        $channel=$result['channel'];
        $tree_category_id=$result['category_id'];
        switch($channel){
            case 1: {$tree_channel="健身计划 ";$tree_channel_en="Plan";$_current='plan';}break;
            case 2:{$tree_channel="锻炼 ";$tree_channel_en="Train";$_current='train';}break;
            case 3:{$tree_channel="营养 ";$tree_channel_en="Nutri";$_current='nutri';}break;
            case 4:{$tree_channel="辅助品 ";$tree_channel_en="Append";$_current='append';}break;
			case 5:{$tree_channel="生活方式 ";$tree_channel_en="Lifestyle";$_current='lifestyle';}break;
        }
        $tree_parent=$result['parent'];		
        $tree_name=$result['name'];
        $result=mysql_query("select name from ai_article_category where id=".$tree_parent);
        $tree_parentName=mysql_fetch_assoc($result);
        $this->assign("first",trim($tree_channel));
        $this->assign("second",trim($tree_parentName['name']));
		if($channel==1){
			if($tree_name=='天天锻炼-基础锻炼'){
				$planlistid=2;
			}elseif($tree_name=='天天锻炼-运动员锻炼'){
				$planlistid=3;
			}elseif($tree_name=='天天锻炼-肌肉锻炼'){
				$planlistid=4;
			}
			$this->assign("planlistid",$planlistid);
		}
        $this->assign("third",trim($tree_name));
        $this->assign("tree_parent",$tree_parent);
        $this->assign("tree_channel_en",$tree_channel_en);
        $this->assign('headertitle', $article['title']);
        $this->assign("tree_category_id",$tree_category_id);
		$this->assign('channel', $channel);
		$this->assign('_current', $_current);
		$this->assign('_act', 1);
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
        static $nums=7;
        $type = (int) $_GET['type'];
        $page = (int) $_GET['pg']?(int) $_GET['pg']:1;
        //$info=D('Article')->getDaily($type) old part
        $info_countnums = count(D('Article')->getDaily($type));
        //the new part by kontem 2013-03-29
        $info = D('Article')->getDailyLimit($type,($page-1)*$nums,$nums);
        $cate = M('article_category')->where(array('type'=>'2'))->findAll();
        $this->assign('info', $info);

		//print_r($info);
        $this->assign('cssFile', 'every');
        //目录树
        $channel=$type;
        switch($channel){
            case 2: {
				$tree_channel="初阶-基础锻炼";
				$tree_channel_en=1;
				$bannerTopInfo['title']='初阶-基础锻炼';
				$bannerTopInfo['img']='cj.png';
				$bannerTopInfo['aimg_1']='2-1.jpg';$bannerTopInfo['aid_1']=79;$bannerTopInfo['aimg_title1']='基础锻炼：健身';
				$bannerTopInfo['aimg_2']='2-2.jpg';$bannerTopInfo['aid_2']=78;$bannerTopInfo['aimg_title2']='基础锻炼：营养';
				$bannerTopInfo['aimg_3']='2-3.jpg';$bannerTopInfo['aid_3']=77;$bannerTopInfo['aimg_title3']='基础锻炼：辅助品';
				$bannerTopInfo['aimg_4']='2-4.jpg';$bannerTopInfo['aid_4']=76;$bannerTopInfo['aimg_title4']='基础锻炼：生活方式';
				}break;
            case 3:{$tree_channel="中阶-运动员锻炼";$tree_channel_en=2;
				$bannerTopInfo['title']='中阶-运动员锻炼';
				$bannerTopInfo['img']='zj.png';
				$bannerTopInfo['aimg_1']='3-1.jpg';$bannerTopInfo['aid_1']=90;$bannerTopInfo['aimg_title1']='中阶锻炼：健身';
				$bannerTopInfo['aimg_2']='3-2.jpg';$bannerTopInfo['aid_2']=89;$bannerTopInfo['aimg_title2']='中阶锻炼：营养';
				$bannerTopInfo['aimg_3']='3-3.jpg';$bannerTopInfo['aid_3']=88;$bannerTopInfo['aimg_title3']='中阶锻炼：辅助品';
				$bannerTopInfo['aimg_4']='3-4.jpg';$bannerTopInfo['aid_4']=87;$bannerTopInfo['aimg_title4']='中阶锻炼：生活方式';
			}break;
            case 4:{$tree_channel="高阶-肌肉锻炼";$tree_channel_en=3;
				$bannerTopInfo['title']='高阶-肌肉锻炼';
				$bannerTopInfo['img']='gj.png';
				$bannerTopInfo['aimg_1']='4-1.jpg';$bannerTopInfo['aid_1']=91;$bannerTopInfo['aimg_title1']='高阶锻炼：健身';
				$bannerTopInfo['aimg_2']='4-2.jpg';$bannerTopInfo['aid_2']=84;$bannerTopInfo['aimg_title2']='高阶锻炼：营养';
				$bannerTopInfo['aimg_3']='4-3.jpg';$bannerTopInfo['aid_3']=82;$bannerTopInfo['aimg_title3']='高阶锻炼：辅助品';
				$bannerTopInfo['aimg_4']='4-4.jpg';$bannerTopInfo['aid_4']=75;$bannerTopInfo['aimg_title4']='高阶锻炼：生活方式';
			}break;
        }
        $this->assign("first",$tree_channel);
        $this->assign("bannerTopInfo",$bannerTopInfo);
        //banner 滚动图片列表
        $this->show_banner($type);
        //-------END--------
        $pager = api('Pager');
        $pager->setCounts($info_countnums);
        $pager->setList($nums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;		
        $pagerArray = (array)$pager;
        $this->assign('pager', $pagerArray);
        $this->assign('headertitle', $tree_channel);
		$this->assign('_current', 'plan');
		$this->assign('cssFile','plan');
        //$this->display();
		$this->display('dailywork');
    }
    
    public function daily()
    {
        $pagenums=7;
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
        $upReaderCountSql="update ai_daily set read_count=read_count+1 where id=$id";
        M('')->query($upReaderCountSql);
        
        $daily = M('daily')->where(array('id'=>$id))->find();
		$daily['dateStrng']=_returnNdate($daily['create_time']);
		//print_r($daily);
        $videos = M('daily_video')->where(array('daily_id'=>$id))->findAll();
        
        foreach ($videos as $k=>$v) {
            if (!empty($v['link'])&&$v['link']!='null') {
                $videos[$k]['img'] = D('Article')->getVideoImgById($v['id']);
				$data = json_decode($this->getVideoData($v['link']));
				$videos[$k]['logo'] = $data->data[0]->logo;
            }
			else{
				unset($videos[$k]);
			}
        }
		//print_r($videos);
        $commentsCount = M('comments')->where(array('parent_type'=>'4', 'parent_id'=>$id))->count();
        $pager = api('Pager');
        $pager->setCounts($commentsCount);
        $pager->setList($pagenums);
        $pager->makePage();
        $from = ($pager->pg-1) * $pager->countlist;
        $pagerArray = (array)$pager;
        $this->assign('pager', $pagerArray);
        $comments = M('comments')->where(array('parent_type'=>'4', 'parent_id'=>$id))->order('`create_time` DESC')->limit("$from,$pager->countlist")->findAll();
        foreach($comments as $k=>$c) {
            $comments[$k] = $c;
            $comments[$k]['userInfo'] = getUserInfo($c['uid']);
        }
		
		$comments = $this->arr2tree($comments);
		$comhtml=$this->tree2html($comments);
		$this->assign('comhtml', $comhtml);
		//print_r($comments);
		//tree2html($tree);  
		//print_r($tree); 
		
        //print_r($daily);
        $this->assign('commentsCount', $commentsCount);
        $this->assign('daily', $daily);
        $this->assign('videos', $videos);
        $this->assign('comments', $comments);
        $this->assign('cssFile', 'article');
        
        $promote = M('promote')->find();
        $this->assign('promote', $promote);
        
        $promoteArticle = M('article')->where(array('is_promote'=>1))->findAll();
        foreach ($promoteArticle as $key => $value) {
            $promoteArticle[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }

        //add others ArticleInfo kon 20130331
        //$otherArticleSql = M('article')->where(array('uid'=>$daily['uid']))->findAll();
        $otherArticleSql = "select * from ai_article where uid=".$daily['uid']." and id > ".$daily['id']." order by id desc limit 0,3";
        $otherArticle=mysql_query($otherArticleSql);
        $result=array();
        while ($row = mysql_fetch_assoc($otherArticle)) {
            $result[]=$row;
        }
        $this->assign('otherArticle', $result);
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
            case 4:{$tree_channel="辅助品";$tree_channel_en="Append";}break;
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
        $this->assign('headertitle', trim($daily['title']));
		$this->assign('_current', 'plan');
		$this->assign('metatype', '1');
        $this->display();
    }
    
    public function selectRegister()
    {
		$_SESSION['regrefer_url']='';
		$_SESSION['regrefer_url'] = $_SERVER["HTTP_REFERER"];
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
        $area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
        $this->assign('children', $child);
        $this->assign('area', $area);
        //print_r($area);
        $this->assign('cssFile', 'register');
        $this->display();
    }
    
    public function getCity()
    {
        $pid = $_GET['pid'];
        $area = M('area')->where(array('pid'=>$pid))->order('`area_id` ASC')->findAll();
        
        
        echo json_encode($area);
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
        $area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
        $this->assign('children', $child);
        $this->assign('area', $area);
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
        $area = M('area')->where(array('pid'=>'0'))->order('`area_id` ASC')->findAll();
        foreach($area as $a) {
            $child[$a['area_id']] = M('area')->where(array('pid'=>$a['area_id']))->order('`area_id` ASC')->findAll();	
        }
        $this->assign('children', $child);
        $this->assign('area', $area);
        $this->assign('cssFile', 'register');
        $this->display();
    }
    
    public function doRegister()
    {
        // 验证码
        // /* $verify_option = $this->_isVerifyOn('register');*/
        if ((md5(strtoupper($_POST['verifyStr'])) != $_SESSION['verify'])){
            $this->error(L('error_security_code'));
            exit;
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
            //$this->error(L('username_format_error'));
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
        $data['city']     = $_POST['city'];
        $data['address']  = $_POST['address'];
        $data['goal']     = $_POST['goal'];
        $data['im']       = $_POST['begin'];
		$data['im']       = $_POST['begin'];
        include_once('shopApi.php');
        $sdata=$data;
        $sdata['password']=$_POST['password'];
        _postCurlRegister($sdata);
        $uid = M('user')->add($data);
        $data['uid'] = $uid;
        M('user_attr')->add($data);
        service('Passport')->loginLocal($uid);
		
		$get_usernameSql="select * from ai_user where email='".$_POST['email']."'";
		$get_usernameInfo = M('')->query($get_usernameSql);
		$getUidSql='select user_id,user_name,email from ecs_users where user_name="'.$get_usernameInfo[0]['uname'].'"';
		$uid = M('')->query($getUidSql);
		$_SESSION['user_id']   = $uid[0]['user_id'];
		$_SESSION['user_name'] = $uid[0]['user_name'];
		$_SESSION['email']     = $uid[0]['email'];
		$_SESSION['ways']++;
		$time = time() - 3600;
		if($_SESSION['mid']>0){
			$_SESSION['userInfo'] = D('User', 'home')->getUserByIdentifier($_SESSION['mid']);
		}
		@setcookie("ECS[user_id]",  $_SESSION['user_id'], $time, '/');  //set cookie         
		@setcookie("ECS[password]", '', $time, '/');
				if($_SESSION['refer_url']!=''){
					$reurl=$_SESSION['refer_url'];
					unset($_SESSION['refer_url']);
					redirect($reurl);
				}
				elseif($_SESSION['shoprefer_url']!=''){
					$reurl=$_SESSION['shoprefer_url'];
					unset($_SESSION['shoprefer_url']);
					redirect($reurl);
				}else{
					redirect(U('index/Index/index'));
				}
		//redirect(U('home/Account/index'));
		redirect(U('index/User/loginUserInfo'));
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
    
    public function about_us()
    {
        $this->assign('cssFile', 'about_us');
        $this->display();	
    }
    
    public function feedback()
    {
        if(!empty($_POST['email'])&&!empty($_POST['content'])){
            $insertsql="insert into ai_feedback_info (email,content,isread,create_time) values ('".$_POST['email']."','".$_POST['content']."','0','".time()."')";
            $logId = M('')->query($insertsql);
        }
        $this->assign('cssFile', 'about_us');
        $this->display('feedback');	
    }
    
    public function founders()
    {
        $this->assign('cssFile', 'about_us');
        $this->display();
    }
    
    public function ad()
    {
        $this->assign('cssFile', 'about_us');
        $this->display();
    }
    
    public function privacy()
    {
        $this->assign('cssFile', 'about_us');
        $this->display();
    }
    
    public function join()
    {
        $this->assign('cssFile', 'about_us');
        $this->display();
    }
    
    public function __call($name, $arguments)
    {
        //echo contact;
        $this->assign('cssFile', 'about_us');
        $this->display($name);
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
    protected function getVideoData($link)
    {
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
        return $json;
    }

    public function footer()
    {
        $id = intval($_GET['id']);
        $content = D('Article')->getFooterContent($id);
        if ($content === FALSE) $content = D('Article')->getFooterContent(1);
        $this->assign('content',$content);
		$this->assign('hid',$id);
        $this->assign('cssFile','about_us');
        $this->display('foot');
    }
	
	function arr2tree($tree, $rootId = 0)
	{
		$return = array();  
		foreach($tree as $leaf) {  
			if($leaf['topParent'] == $rootId){
				foreach($tree as $subleaf){
					if($subleaf['topParent'] == $leaf['id']){
						$leaf['children'] = $this->arr2tree($tree, $leaf['id']);
						break;
					}
				}
				$return[] = $leaf;
			}
		}
		return $return;  
	}
	
	function tree2html($tree) {
	/*<div class="target_content">
		<span class="staircase">1楼</span>
			<a class="name">huifei</a>
			<p>高兴是人类最原始的最求，只能让大家高兴，管他是那个国家的。中国人为什么总被排挤在潮流之外，其实都是中国人自己造成的，当别人都在高兴的时候，中国人则是在旁边指指点点，这不好，那不好，好像只有这样才能显出自己的高人一等。</p>
</div>*/
    foreach($tree as $leaf) {  
        $htmlStr.='<div class="target_content"><a class="name">' .$leaf['userInfo']['uname']."</a>";  
        if(!empty($leaf['children']))$htmlStr.=$this->tree2html($leaf['children']);  
        $htmlStr.='<p>'.$leaf['content'].'</p>';  
    }  
    return  $htmlStr.='</div>';  
}


function pageHtml($count,$nums,$pg=null,$url=null)
{
		$pager=null;
		$listnum=ceil($count/$nums);
		if($pg==1||!$pg){
			$pre='<a>上一页</a>';
		}else
		{
			$pre='<a href="'.$url.($pg-1).'">上一页</a>';
		}
		if($pg==$listnum){
			$next='<a>下一页</a>';
		}else
		{
			$next='<a href="'.$url.($pg+1).'">下一页</a>';
		}
		for($i=1;$i<=$listnum;$i++){
			if($i==$pg){
				$cuCss='class="pg_current_page"';
			}else{
				$cuCss='';
			}
			if(!$pg){
				if($i==1){
					$cuCss='class="pg_current_page"';
				}
			}
			$pageArr[$i]='<a '.$cuCss.' href="'.$url.$i.'">'.$i.'</a>';
		}
		if($listnum>10){
			if($pg>5&&($listnum-$pg)>=5){
				$snum=$pg-5;
				$enum=$pg+5;
			}
			if($pg<5&&($listnum-$pg)>5){
				$snum=1;
				$enum=10;
			}
			if($pg>5&&($listnum-$pg)<5){
				$snum=$pg-5-(5-($listnum-$pg))+1;
				$enum=$listnum;
			}
			if($pg==5){
				$snum=1;
				$enum=10;
			}
			foreach($pageArr as $k=>$v)
			{
				if($k<$snum||$k>$enum){
					unset($pageArr[$k]);
				}else{
					$pagehtml.=$v;
				}
			}
		}else{

			foreach($pageArr as $k =>$v)
			{
				$pagehtml.=$v;
			}
		}
		
		$html['backstr']=$pre;
		$html['nextstr']=$next;
		$html['thestr']=$pagehtml;
		return array('html'=>$html);
}
}
?>
