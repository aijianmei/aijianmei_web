<?php
/**
 * 个人空间
 */
class SpaceAction extends Action
{
	function _initialize() {
		if (!is_numeric($_GET['uid']) && is_string($_GET['uid'])) {
			$domainuser = D('User')->getUserByIdentifier(h($_GET['uid']), 'domain');
	   		if ($domainuser) {
	   			$this->uid = $domainuser['uid'];
	   			$this->assign('uid',$this->uid);
	   		}else {
	   			$this->assign('jumpUrl',$_SERVER['HTTP_REFERER']);
   	   			$this->error(L('user_not_exist'));
	   		}
		} else {
			$this->assign('uid', intval($_GET['uid']));
		}

		if ('detail' != ACTION_NAME) {
			$user_info = D('User')->getUserByIdentifier($this->uid);
	   	   	if ($user_info) {
	   	   		$userinfo = array(
	   	   						'微博地址' => U('home/Space/index', array('uid' => $user_info['domain'] ? $user_info['domain'] : $this->uid)),
	   	   						'性别'    => getSex($user_info['sex']),
	   	   						'所在地'  => $user_info['location'],
	   	   					);
    			// 基本信息-钩子
	   	   		Addons::hook('home_space_profile_base', array('uid' => $this->uid, 'user_info' => & $userinfo));
				$this->assign('userinfo', $userinfo);
				$this->assign('user_credit', service('Credit')->getUserCredit($this->uid));
	   	   	} else {
	   	   		$this->assign('jumpUrl',$_SERVER['HTTP_REFERER']);
   	   			$this->error(L('user_not_exist'));
	   		}

	       	$this->__getSpaceCount( $this->uid );
		}
	}

	private function __getSpaceCount($uid) {
		$followInfo = getUserFollow($uid);
		$data['followstate'] = D('Follow','weibo')->getState($this->mid, $uid, 0);
		$data['isBlackList'] = isBlackList($this->mid,$uid);
		$data['privacy']     = D('UserPrivacy','home')->getPrivacy($this->mid,$uid);
		$data['spaceCount']['miniblog']   = model('UserCount')->getUserWeiboCount($uid);
		$data['spaceCount']['following']  = $followInfo['following'];
		$data['spaceCount']['follower']   = $followInfo['follower'];
		$data['spaceCount']['message']   = 0;
		$data['hotTopic'] = D('Topic','weibo')->getHot();
		$data['usertags'] = D('UserTag')->getUserTagList( $this->uid );
		$this->assign( $data );
	}

    // 用户空间首页
    public function index()
    {
    	$this->_canViewSpace();

        $menu['weibo'] = L('weibo');
        Addons::hook('home_space_tab', array('uid' => $this->uid, 'menu' => & $menu));
        $this->assign('space_menu', $menu);

        $data['user'] = D('User')->getUserByIdentifier($this->uid);
		//判断用户是否存在
		if(!$data['user']['uid']){
			$this->assign('jumpUrl', $_SERVER['HTTP_REFERER']);
			$this->error('用户不存在或已被删除！');
		}
		
        $data['type'] = $_GET['type'] ? h($_GET['type']) : 'weibo';
        if ('weibo' === $data['type']) {
	        $weiboType = $data['weibo_type'] = h($_GET['weibo_type']);
	        $data['list'] = D('Operate','weibo')->getSpaceList($this->uid, $weiboType);
			//微博menu组装
	        $data['weibo_menu'] = array(
	                        ''  => L('all'),
	                        'original' => L('original'),
	                      );
	        Addons::hook('home_index_weibo_tab', array(&$data['weibo_menu']));
	    	if(!empty($weiboType)) {
	            $this->assign('typeClass',"on");
	            $this->assign('view','block');
	        }else{
	            $this->assign('typeClass','off');
	            $this->assign('view','none');
	        }
        }

        //print_r($data);
        $this->assign($data);
        $this->setTitle($data['user']['uname'] . '的空间');
    	$this->display();
    }

    //个人资料
    public function profile()
    {
    	$this->_canViewSpace();

    	$pUserProfile = D('UserProfile');
    	$pUserProfile->uid = $this->uid;
    	$data['userInfo']  = $pUserProfile->getUserInfo(true);
        // 个人情况-钩子
    	Addons::hook('home_space_profile_intro', array('uid' => $this->uid, 'intro' => & $data['userInfo']['intro']['list']));
    	// 联系方式-钩子
    	Addons::hook('home_space_profile_contact', array('uid' => $this->uid, 'contact' => & $data['userInfo']['contact']['list']));
    	$this->assign( $data );
    	$this->setTitle(getUserName($this->uid) . '的详细资料');
    	$this->display();
    }

    // 查看微博详细
    function detail(){
    	$intId = intval( $_GET['id'] );
	    $data['mini']      =  D('Operate','weibo')->getOneLocation( $intId );
	    //收藏
	    $map['uid'] = $this->mid;
	    $map['weibo_id'] = intval( $_GET['id'] );
	    $res = D('Favorite')->where($map)->find();
	    if($res){
	    	$data['mini']['is_favorited'] = 1;
	    }
	    if(!$data['mini']) $this->error(L('post_arg_error'));
		$data['comment']   =  D('Comment','weibo')->getComment( $intId );
		$data['privacy'] = D('UserPrivacy','home')->getPrivacy($this->mid,$data['mini']['uid']);
    	$this->assign( $data );
	    $this->uid = $data['mini']['uid'];

		$user_info = D('User')->getUserByIdentifier($this->uid);
	   	if ($user_info) {
			$this->assign('userinfo',$user_info);
	   	}
	    $this->__getSpaceCount( $this->uid );

		//SEO优化: 标题栏增加微博内容摘要
	    $this->setTitle(getUserName($this->uid) . ':'.getShort($data['mini']['content'],30).'...');
	    $this->assign('weibo_id',$intId);
    	$this->display();
    }

	/*
	 * 微博文档下载页
	 */
	public function file()
	{
		$aid	=	intval($_REQUEST['id']);
		$uid	=	intval($_REQUEST['uid']);

		$user_info = D('User')->getUserByIdentifier($this->uid);
	   	if ($user_info) {
			$this->assign('userinfo',$user_info);
	   	}
	    $this->__getSpaceCount( $this->uid );

		$attach	=	model('Attach')->field('id,userId,name,extension,size,uploadTime')->where("id={$aid} AND userId={$uid}")->find();
		$this->assign('data', $attach);
		$this->display();
	}

    //关注
    function follow(){
    	$this->_canViewSpace();

    	$data['type'] = ($_GET['type']=='follower')?'follower':'following';
    	if($data['type'] == 'following'){
    		//关注分组列表
	    	$data['gid']  = is_numeric($_GET['gid'])?$_GET['gid']:'all';
	    	$group_list = D('FollowGroup','weibo')->getGroupList($this->uid);
	    	//调整分组列表
	    	if(!empty($group_list)){
		    	$group_count = count($group_list);
		    	for($i=0;$i<$group_count;$i++){
		    		if($group_list[$i]['follow_group_id'] != $data['gid']){
		    			$group_list[$i]['title'] = (strlen($group_list[$i]['title'])+mb_strlen($group_list[$i]['title'],'UTF8'))/2>8?getShort($group_list[$i]['title'],3).'...':$group_list[$i]['title'];
		    		}
		    		if($i<2){
		    			$data['group_list_1'][] = $group_list[$i];
		    		}else{
		    			if($group_list[$i]['follow_group_id'] == $data['gid']){
		    				$data['group_list_1'][2]  = $group_list[$i];
		    				continue;
		    			}
		    			$data['group_list_2'][] = $group_list[$i];
		    		}
		    	}
		    	if(empty($data['group_list_1'][2]) && !empty($data['group_list_2'][0])){
		    		$data['group_list_1'][2] = $data['group_list_2'][0];
		    		unset($data['group_list_2'][0]);
		    	}
	    	}
    	}

    	// 关注的人列表
    	$data['list'] = D('Follow','weibo')->getList($this->uid,$data['type'],0,$data['gid']);
    	$this->assign($data);
    	$this->setTitle(getUserName($this->uid) . '的' . ($data['type'] == 'follower' ? '粉丝' : '关注'));
    	$this->display();

    }

    //小名片
    public function showSpaceCard(){
		$uid = intval( $_GET['uid'] );
    	if($uid){
			$data = getUserInfo($uid);

			$usertags = D('UserTag')->getUserTagList( $this->uid );
			foreach($usertags as $v){
				$tags[]	=	'<a href="'.U('home/User/searchtag',array('k'=>$v['tag_name'])).'">'.$v['tag_name'].'</a>';
			}
			$data['location']		=	getLocation($data['province'],$data['city']);
			if(!$data['location'])	$data['location'] ='<br />';
			$data['tags']			=	(!$tags)?'无':implode(' ',$tags);
			$data['following_url']	=	U('home/Space/follow',array('type'=>'following','uid'=>$uid));
			$data['follower_url']	=	U('home/Space/follow',array('type'=>'follower','uid'=>$uid));
			$data['space_url']		=	U('home/Space/index',array('uid'=>$uid));
			$data['space_link']		=	getUserSpace($uid,'nocard','_blank');
			$data['follow_state']	=	($this->mid==$uid)?'self':D('Follow','weibo')->getState($this->mid, $uid, 0);
			$data['fu_state']       = 	($this->mid==$uid)?'self':D('Follow','weibo')->getState($uid, $this->mid, 0);
			$map['uid'] = $this->mid;
			$map['fid'] = $uid;
			$data['black']			= M('user_blacklist')->where($map)->find();unset($map);
			$this->ajaxReturn($data,L('get_success'),1);
    	}else{
    		$this->ajaxReturn('',L('get_success'),0);
    	}
    }

    private function _canViewSpace()
    {
    	$user_set = D('UserPrivacy')->getUserSet($this->uid);
    	if (1 == $user_set['space']) {
    	    // 我关注的人
    	    if ($this->mid && $this->mid != $this->uid && 'unfollow' === getFollowState($this->uid, $this->mid, 0)) {
	    		$this->error('对方不允许访问');
    	    }
    	} else {
    		// 所有人（不包括黑名单）
	    	if ($this->mid && $this->mid != $this->uid && isBlackList($this->uid, $this->mid)) {
	    		$this->error('对方不允许访问');
	    	}
    	}
    }
}