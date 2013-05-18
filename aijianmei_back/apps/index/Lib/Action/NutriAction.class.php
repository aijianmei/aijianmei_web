<?php
class NutriAction extends Action {
    function show_banner(){
		 $change_1="nutri_1.jpg";
         $change_2="nutri_2.jpg";
         $change_3="nutri_3.jpg";
         $change_4="nutri_4.jpg";
         $articleid_1="26";
         $articleid_2="34";
         $articleid_3="41";
         $articleid_4="32";
         $name_1="6个燃脂的提示";
         $name_2="7个肌肉养成的营养规则";
         $name_3="初学者运动前的营养指导 ";
         $name_4="制定减肥目标";
         $describe_1="燃脂需要一个专门针对你自身营养和锻炼的方法。营养是修长身材的基础，而锻炼就像是是把所有因素凝聚起来的催化剂。如果你能按照下面列出来的6个提示去办，你便能有效地减少你身上多余的脂肪…";
         $describe_2="7个肌肉养成的营养规则
营养领域是一个完全不同的世界，计算卡路里和大量营养素的比例可要比在健身房里做几组运动难多了。下面我将会列出一些基本的原则来帮助你踏上正轨
";
         $describe_3="一个健康好看的身型不是从你进入健身房那一刻才开始形成的。下面我会教你如何在健身前吸收营养，让你甩掉脂肪和增加肌肉。";
         $describe_4="你没有理由放弃，我会帮助你，通过提供有用的信息跟你一起达到你的目标。现在开始制定一个目标，读下面的文字，接着付诸行动……";
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
		 		 $bannerinfo=array(
		'1'=>array(
			'name'=>'6个燃脂的提示',
			'img'=>'../Public/images/banner/nutri_1.jpg',
			'url'=>'/index-Index-articleDetail-26.html'
			),
		'2'=>array(
			'name'=>'7个肌肉养成的营养规则',
			'img'=>'../Public/images/banner/nutri_2.jpg',
			'url'=>"/index-Index-articleDetail-34.html"),
		'3'=>array(
			'name'=>'初学者运动前的营养指导',
			'img'=>'../Public/images/banner/nutri_3.jpg',
			'url'=>"/index-Index-articleDetail-41.html"),
		'4'=>array(
			'name'=>'制定减肥目标',
			'img'=>'../Public/images/banner/nutri_4.jpg',
			'url'=>"/index-Index-articleDetail-32.html"),
		);
		 $this->assign('_bannerInfo',$bannerinfo);
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
			$pg=1;
		}
		
		
        //assign hotArticles
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =3";
		$countsql = "select count(*) as cnums from ai_article a ,($orderTableSql) t where a.id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,'/index.php?app=index&mod=Nutri&act=index&ctype=2&pg=');
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
		//$hotArticles = D('Article')->getTrainArticles($order);
        $hotArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,3);
        //print_r( $hotArticles);
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,'/index.php?app=index&mod=Nutri&act=index&ctype=1&pg=');
		$pagerArray = $pagerData['html'];
        //assign lastArticles		
        $order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,3);
		$this->assign('lastArticlespage', $pagerArray);
        $this->assign('lastArticles', $lastArticles);
		
		
		
		
		//print_r($lastArticles);
        $this->show_banner();//显示banner
		//header current add by kon at 20130415
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['nutri']);
        $this->assign('headertitle', '营养');
		 //header current add by kon at 20130415
		$this->assign('_current', 'nutri');
        $this->display('nutri_index');
    }
    
    public function articleList()
    {
        $pg=$_GET['pg']?$_GET['pg']:1;
		$nums=5;
        $this->assign('cssFile', 'training');
        
		$id = intval($_GET['id']);
        //$this->display();
		
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pg=1;
		}

        //assign hotArticles
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
		$countsql = "select count(*) as cnums from ai_article a ,($orderTableSql) t where a.id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,"/index.php?app=index&mod=Nutri&act=articleList&id=$id&ctype=2&pg=");
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
		//$hotArticles = D('Article')->getTrainArticles($order);
        $hotArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,3);
        //print_r( $hotArticles);
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,"/index.php?app=index&mod=Nutri&act=articleList&id=$id&ctype=1&pg=");
		$pagerArray = $pagerData['html'];
        //assign lastArticles		
        $order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,3);
		$this->assign('lastArticlespage', $pagerArray);
        $this->assign('lastArticles', $lastArticles);
		
		
		
		
		//print_r($lastArticles);
        $this->show_banner();//显示banner
		//header current add by kon at 20130415
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['nutri']);
		$keymenu=array('29'=>'增肌','28'=>'减脂','31'=>'一般饮食知识');
         $this->assign('headertitle', $keymenu[$id]);
		 //header current add by kon at 20130415
		$this->assign('_current', 'nutri');
        $this->display('nutri_list');
    }
    
    /*public function videoList()
    {
        $id = intval($_GET['id']);
        $this->display();
    }*/
    
    //get append video list
    public function videoList()
    {
        $id = intval($_GET['id']);
        $this->assign('cssFile', 'video');
        $this->assign('cssFile', 'training');
        $cate = M('article_category')->where(array('channel'=>'2', 'type'=>'1'))->findAll();
        
        foreach($cate as $c) {
            if($c['parent']==NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }

        $this->assign('categories', $realCate);
        $map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
        $articles = M('article')->where($map)->findAll();
        $this->assign('articles', $articles);
        
        //get hotArticles
        $order = 'click';
        $hotArticles = D('Article')->getNutriArticles($order);
        $this->assign('hotArticles', $hotArticles);
        //print_r($hotArticles);
        //get lastArticles
        $lastArticles = D('Article')->getNutriArticles('create_time');
        $this->assign('lastArticles', $lastArticles);
        $this->show_banner();//banner 滚动图片列表
        $this->display('vlist');
    }
    
    //get append video detail
    public function videoDetail()
    {
        $id = intval($_GET['id']);
        $table = (isset($_GET['from']) && $_GET['from']=='daily') ? 'daily_video' : 'video';
        $video = M($table)->where(array('id'=>$id))->find();
        //$videoInfo = D('Article')->getVideoInfoByLink($video['link']);
        //print_r($video);
        //$this->assign('videoInfo', $videoInfo);
        $this->assign('video', $video);
        $this->assign('cssFile', 'v');
        $this->display('video');
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
