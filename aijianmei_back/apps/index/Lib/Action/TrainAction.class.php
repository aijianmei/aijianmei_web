<?php
class TrainAction extends Action {
    function show_banner(){			//banner 滚动图片列表
         $change_1="training_1.jpg";
         $change_2="training_2.jpg";
         $change_3="training_3.jpg";
         $change_4="training_4.jpg";
         $articleid_1="46";
         $articleid_2="52";
         $articleid_3="50";
         $articleid_4="96";
         $name_1="身体的三种不同类型";
         $name_2="锻炼肌肉的基本要素";
         $name_3="完美的健身伙伴";
         $name_4="8个开始体重训练的原因";
         $describe_1="人的身体有三种不同的体型：肥胖型体质、体育型体质和消瘦型体质。为了方便能更有针对性地训练，你要知道自己属于哪一种。";
         $describe_2="怎样是最好的训练方法呢？如果你的目标是多增加肌肉，那就按照下面这些基本训练方法，踏上获得强壮体型之路。";
         $describe_3="没有什么比带一个健身伙伴更能增加健身的高强度啊！一个了解你训练方式而且陪在你身边的健身伙伴是不可或缺的。";
         $describe_4="老实说，我们当中的很多人并没有时间一个星期去几次健身房，然后每次花个45分钟来健身。我有一个好消息给你们……";
		 //new banner add
		 
		$bannerinfo=unserialize(include('PublicCache/advImgCache.php'));
    $bannerinfo=$bannerinfo['train'];

    foreach ($bannerinfo['imginfo'] as $key=>$value) {
     	 $bannerinfoTmp[$key]['name']=$value['title'];
     	 $bannerinfoTmp[$key]['img']='../'.$value['img'];
     	 $bannerinfoTmp[$key]['url']=$value['url'];
    } 

    $bannerinfo=$bannerinfoTmp;


		/*$bannerinfo=array(
		'1'=>array(
			'name'=>'你不可不知的“身体类型”',
			'img'=>'../Public/images/banner/training_1.jpg',
			'url'=>'/index-Index-articleDetail-46.html'
			),
		'2'=>array(
			'name'=>'打造“型男”的健身秘诀',
			'img'=>'../Public/images/banner/training_2.jpg',
			'url'=>"/index-Index-articleDetail-52.html"),
		'3'=>array(
			'name'=>'最佳拍档！健身更高效！',
			'img'=>'../Public/images/banner/training_3.jpg',
			'url'=>"/index-Index-articleDetail-50.html"),
		'4'=>array(
			'name'=>'健身小科普：了解“体脂率”',
			'img'=>'../Public/images/banner/training_4.jpg',
			'url'=>"/index-Index-articleDetail-115.html"),
		);*/
		 $this->assign('_bannerInfo',$bannerinfo);
		 //}}}end
		 
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
         $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
        //-------END--------
        }

    public function index()
    {
				$pg=$_GET['pg']?$_GET['pg']:1;
				$nums=5;
        $this->assign('cssFile', 'training');
        $map['channel'] = '2';
        $cate = M('article_category')->where($map)->findAll();
        foreach($cate as $c)
            if($c['parent'] == NULL) $parent[$c['id']] = $c;
        foreach($cate as $c) {
            if($c['parent'] != NULL) $parent[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        
        $articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
        foreach ($articles as $key => $value) {
            $articles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('articles', $articles);
        $this->assign('categories', $parent);
        //$this->display();
		
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pglimit=$pg=1;
		}
		
    //assign hotArticles
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		$countsql = "select count(*) as cnums from ai_article a ,($orderTableSql) t where a.id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=Train&act=index&ctype=2&pg=');
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
    $hotArticles = D('Article')->getTrainArticlesList($order,'',($pglimit-1)*20,$nums);
		$this->assign('hotArticlespage', $pagerArray);
    $this->assign('hotArticles', $hotArticles);   
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=Train&act=index&ctype=1&pg=');
		$pagerArray = $pagerData['html'];

    $order = 'create_time';
    $lastArticles = D('Article')->getTrainArticlesList($order,'',($pglimit-1)*20,$nums);
		$this->assign('lastArticlespage', $pagerArray);
    $this->assign('lastArticles', $lastArticles);
		
		
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		$countsql = "select count(*) as cnums from ai_video v,($orderTableSql) t where v.category_id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=Train&act=index&ctype=3&pg=');
		$pagerArray = $pagerData['html'];
		
		$order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastVideoList = D('Article')->getTrainVideoList($order,'',($pglimit-1)*20,$nums);
		$this->assign('lastVideoListpage', $pagerArray);
        $this->assign('lastVideoList', $lastVideoList);
		//print_r($lastVideoList);
		//print_r($lastVideoList);
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,'/index.php?app=index&mod=Train&act=index&ctype=4&pg=');
		$pagerArray = $pagerData['html'];
		$order = 'click';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $hotVideoList = D('Article')->getTrainVideoList($order,'',($pglimit-1)*20,$nums);
		$this->assign('hotVideoListpage', $pagerArray);
    $this->assign('hotVideoList', $hotVideoList);
		
		
		
		//print_r($lastArticles);
    $this->show_banner();//显示banner
    $this->assign('headertitle', '锻炼');
		//header current add by kon at 20130415
		$this->assign('_current', 'train');
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		//print_r($keywordInfo['train']);
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['train']);
		$this->display('train_index');
    }
    public function newindex()
    {
        $this->assign('cssFile', 'training');
        $map['channel'] = '2';
        $cate = M('article_category')->where($map)->findAll();
        foreach($cate as $c)
            if($c['parent'] == NULL) $parent[$c['id']] = $c;
        foreach($cate as $c) {
            if($c['parent'] != NULL) $parent[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        
        $articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
        foreach ($articles as $key => $value) {
            $articles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('articles', $articles);
        $this->assign('categories', $parent);
        //$this->display();
        
        //assign hotArticles
        $order = 'reader_count';
        $hotArticles = D('Article')->getTrainArticles($order);
        foreach ($hotArticles as $key => $value) {
            $hotArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        //print_r( $hotArticles);
        $this->assign('hotArticles', $hotArticles);
        
        //assign lastArticles		
        $order = 'create_time';
        $lastArticles = D('Article')->getTrainArticles($order);
        foreach ($lastArticles as $key => $value) {
            $lastArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('lastArticles', $lastArticles);

        $this->show_banner();//显示banner
        $this->assign('headertitle', '锻炼');
		//header current add by kon at 20130415
		$this->assign('_current', 'train');
        $this->display('train_index');
    }    
    public function articleList()
    {
		$id = intval($_GET['id']);
		$pg=$_GET['pg']?$_GET['pg']:1;
		$nums=5;
        $this->assign('cssFile', 'training');
        $map['channel'] = '2';
        /*$cate = M('article_category')->where($map)->findAll();
        foreach($cate as $c)
            if($c['parent'] == NULL) $parent[$c['id']] = $c;
        foreach($cate as $c) {
            if($c['parent'] != NULL) $parent[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        
        $articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
        foreach ($articles as $key => $value) {
            $articles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('articles', $articles);
        $this->assign('categories', $parent);
        //$this->display();*/
		
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pglimit=$pg=1;
		}
		
		$order = 'reader_count';
        //assign hotArticles
		$orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
        $countsql = "select count(*) as cnums  from ai_article a where id in ($orderTableSql) or category_id=$id  order by ".$order." desc";
		
		//$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		//$countsql = "select count(*) as cnums from ai_article a ,($orderTableSql) t where a.id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		///index.php?app=index&mod=Train&act=articleList&id=$id
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,"/index.php?app=index&mod=Train&act=articleList&id=$id&ctype=2&pg=");
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
		//$hotArticles = D('Article')->getTrainArticles($order);
        $hotArticles = D('Article')->getTrainArticlesList($order,$id,($pglimit-1)*20,$nums);
        //print_r( $hotArticles);
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,"/index.php?app=index&mod=Train&act=articleList&id=$id&ctype=1&pg=");
		$pagerArray = $pagerData['html'];
        //assign lastArticles		
        $order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastArticles = D('Article')->getTrainArticlesList($order,$id,($pglimit-1)*20,$nums);
		$this->assign('lastArticlespage', $pagerArray);
        $this->assign('lastArticles', $lastArticles);
		
	
        $this->show_banner();//显示banner
		$keymenu=array('51'=>'锻炼方法','38'=>'基础知识','47'=>'特定锻炼视频');
        $this->assign('headertitle', $keymenu[$id]);
		//header current add by kon at 20130415
		$this->assign('_current', 'train');
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['train']);
        $this->display('train_list');
    }
    
    public function videoList()
    {
		$id = intval($_GET['id']);
		$pg=$_GET['pg']?$_GET['pg']:1;
		$nums=5;
		$this->assign('cssFile', 'training');
		$map['channel'] = '2';
		$cate = M('article_category')->where($map)->findAll();
		foreach($cate as $c){
			if($c['parent'] == NULL) $parent[$c['id']] = $c;
        foreach($cate as $c) {
            if($c['parent'] != NULL) $parent[$c['parent']]['children'][] = $c;
            
            $cate_id[] = $c['id'];
        }
    }
		
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pglimit=$pg=1;
		}
		
		//$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
		$countsql = "select count(*) as cnums from ai_video ";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,"/index.php?app=index&mod=Train&act=videoList&id=$id&ctype=1&pg=");
		$pagerArray = $pagerData['html'];
		//print_r($pagerArray);
		$order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastVideoList = D('Article')->getTrainVideoList($order,'',($pglimit-1)*20,$nums);
		$this->assign('lastVideoListpage', $pagerArray);
        $this->assign('lastVideoList', $lastVideoList);
		//print_r($lastVideoList);
		//print_r($lastVideoList);
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],20,$pglimit,"/index.php?app=index&mod=Train&act=videoList&id=$id&ctype=2&pg=");
		$pagerArray = $pagerData['html'];
		$order = 'click';
		//$lastArticles = D('Article')->getTrainArticles($order);
		$hotVideoList = D('Article')->getTrainVideoList($order,'',($pglimit-1)*20,$nums);
		$this->assign('hotVideoListpage', $pagerArray);
        $this->assign('hotVideoList', $hotVideoList);
		
		
		
		//print_r($lastArticles);
		$this->show_banner();//显示banner
		$this->assign('headertitle', '锻炼视频');
		//header current add by kon at 20130415
		$this->assign('_current', 'train');
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['train']);
        $this->display('train_vlist');
    }
    
    public function videoDetail()
    {
        $nums=7;
        $id = intval($_GET['id']);
        $pnum = intval($_GET['pg'])?intval($_GET['pg']):0;
        $table = (isset($_GET['from']) && $_GET['from']=='daily') ? 'daily_video' : 'video';
        $video = M($table)->where(array('id'=>$id))->find();
        if($table=='video') M('')->query('update `ai_video` set `click`=`click`+1 where `id`='.$id);
        
        $video['create_time']=date("Y-m-d H:i:s",$video['create_time']);
        $otherVideo=D('Article')->getVideoCategory($table,$video['category_id'],2);
				$videoLogoData=null;
        $videoLogoData=json_decode($this->getVideoData($video['link']));
				$video['logo'] = $videoLogoData->data[0]->logo;
        foreach($otherVideo as $k=>$v){
            $data = json_decode($this->getVideoData($v['link']));
            $otherVideo[$k]['CommNumber']=D('Article')->getVideoCountRecommentsById($v['id']);
            $otherVideo[$k]['logo'] = $data->data[0]->logo;
            $otherVideo[$k]['CommNumber']=$otherVideo[$k]['CommNumber']?$otherVideo[$k]['CommNumber']:0;
        }

        $getRecommentsSql="select * from ai_comments where parent_id=$id and parent_type=2";
        $Recomments=M('')->query($getRecommentsSql);
        $cRecomnums=count($Recomments);
        $pager = api('Pager');
        $pager->setCounts(count($Recomments));
        //$pager->setStyle($style);
        $pager->setList($nums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;		
        $pagerArray = (array)$pager;
        #$pagerArray['thestr']=printf($pagerArray['thestr'],$str);
        $this->assign('pager', $pagerArray);
        $cRecomnums=$cRecomnums?$cRecomnums:0;
        $this->assign('cRecomnums', $cRecomnums);
        $recommecntListSql="select a.*,b.uname as username from ai_comments a left join ai_user b on a.uid=b.uid where a.parent_id=$id and a.parent_type=2 order by a.create_time desc limit $pnum , $nums";
        $RecommentsList=M('')->query($recommecntListSql);
        foreach($RecommentsList as $key => $value){
            $RecommentsList[$key]['img']=getUserFace($value['uid'],'m');
            $RecommentsList[$key]['create_time']=date("Y-m-d H:i:s",$RecommentsList[$key]['create_time']);
        }
        $this->assign('RecommentsList', $RecommentsList);
//        $sql = "select * from ai_".$table." where category_id=$Category order by id desc limit 0,$nums";
//        $result = M('')->query($sql);
        $this->assign('otherVideo', $otherVideo);
        //print_r($_SESSION);
        $this->assign('video', $video);
        $this->assign('cssFile', 'v');
		$this->assign('_current', 'train');
		$this->assign('_TrainVType','1');
        $this->display('video');
    }
    
    protected function getVideoData($link)
    {
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
        return $json;
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
			if($pg>5&&($listnum-$pg)>5){
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
