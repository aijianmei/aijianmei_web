<?php
class AppendAction extends Action {
    function show_banner(){
            //banner 滚动图片列表
         $change_1="append_1.jpg";
         $change_2="append_2.jpg";
         $change_3="append_3.jpg";
         $change_4="append_4.jpg";
         $articleid_1="60";
         $articleid_2="92";
         $articleid_3="56";
         $articleid_4="57";
         $name_1="为什么你现在就需要蛋白质营养品";
         $name_2="蛋白质的种类和益处的介绍";
         $name_3="肌肉生长你所需的6种营养辅助品";
         $name_4="肌氨酸";
         $describe_1="蛋白质是身体用作功能的三种大量营养素之一 ,充足的蛋白质摄入量对身体健康是至关重要的。很多人在食物中吸取蛋白质会有困难…… ";
         $describe_2="蛋白质的辅助品种类繁多，包括了蛋白粉、增重粉、替餐奶昔和蛋白质条，它们都含有大量的蛋白质。它们便携，可以在一天中的任何时刻食用，这是正餐所没有办法做到的。";
         $describe_3="把这些营养辅助品加到你的节食计划当中，这样是增加肌肉和能力的最快、最有效率的方法。下面这6种营养辅助品会使你的身体达到一个代谢同化、燃烧脂肪、增加肌肉的阶段…… 

";
         $describe_4="肌氨酸能提高肌肉的力量和耐力，提高身体恢复力和减低疲劳感，显然这些对你的训练很有帮助。肌氨酸是一种天然的供能物质，而主要供能对象是肌肉细胞。

";
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
		 
		//new banner add
		 $bannerinfo=array(
		'1'=>array(
			'name'=>'为什么你现在就需要蛋白质营养品',
			'img'=>'../Public/images/banner/append_1.jpg',
			'url'=>'/index-Index-articleDetail-60.html'
			),
		'2'=>array(
			'name'=>'蛋白质的种类和益处的介绍',
			'img'=>'../Public/images/banner/append_2.jpg',
			'url'=>"/index-Index-articleDetail-92.html"),
		'3'=>array(
			'name'=>'肌肉生长你所需的6种营养辅助品',
			'img'=>'../Public/images/banner/append_3.jpg',
			'url'=>"/index-Index-articleDetail-56.html"),
		'4'=>array(
			'name'=>'肌氨酸',
			'img'=>'../Public/images/banner/append_4.jpg',
			'url'=>"/index-Index-articleDetail-57.html"),
		);
		 $this->assign('_bannerInfo',$bannerinfo);
		 //}}}end
		 
		 
        //-------END--------

        }

    public function index()
    {
		$pg=$_GET['pg']?$_GET['pg']:1;
		$nums=5;
        $map['channel'] = '4';
		if($_GET['pg']>0){
			$pg=intval($_GET['pg'])+intval($_GET['pg'])-1;
			$pglimit=intval($_GET['pg']);
		}else{
			$pg=1;
		}
		
		
        //assign hotArticles
		$orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =4";
		$countsql = "select count(*) as cnums from ai_article a ,($orderTableSql) t where a.id=t.aid";
		$countInfo=$this->getDataCache(md5($countsql));
		if(!$countInfo){
			$countInfo = M('')->query($countsql);
			$this->setDataCache(md5($countsql),$countInfo);
		}
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,'/index.php?app=index&mod=Append&act=index&ctype=2&pg=');
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
		//$hotArticles = D('Article')->getTrainArticles($order);
        $hotArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,4);
        //print_r( $hotArticles);
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,'/index.php?app=index&mod=Append&act=index&ctype=1&pg=');
		$pagerArray = $pagerData['html'];
        //assign lastArticles		
        $order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastArticles = D('Article')->getArticlesListType($order,'',($pg-1)*$nums,$nums,4);
		$this->assign('lastArticlespage', $pagerArray);
        $this->assign('lastArticles', $lastArticles);
        $this->assign('cssFile', 'training');
        $this->show_banner();//banner 滚动图片列表
        $this->assign('headertitle', '辅助品');
		//header current add by kon at 20130415
		$this->assign('_current', 'append');
		//header current add by kon at 20130415
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['append']);
        //$this->display();
		$this->display('append_index');
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
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,"/index.php?app=index&mod=Append&act=articleList&id=$id&ctype=2&pg=");
		$pagerArray = $pagerData['html'];
		
		$order = 'reader_count';
		//$hotArticles = D('Article')->getTrainArticles($order);
        $hotArticles = D('Article')->getArticlesListType($order,$id,($pg-1)*$nums,$nums,4);
        //print_r( $hotArticles);
		$this->assign('hotArticlespage', $pagerArray);
        $this->assign('hotArticles', $hotArticles);
        
		
		$pagerData=$this->pageHtml($countInfo[0]['cnums'],10,$pglimit,"/index.php?app=index&mod=Append&act=articleList&id=$id&ctype=1&pg=");
		$pagerArray = $pagerData['html'];
        //assign lastArticles		
        $order = 'create_time';
		//$lastArticles = D('Article')->getTrainArticles($order);
        $lastArticles = D('Article')->getArticlesListType($order,$id,($pg-1)*$nums,$nums,4);
		$this->assign('lastArticlespage', $pagerArray);
        $this->assign('lastArticles', $lastArticles);
				//print_r($lastArticles);
        $this->show_banner();//显示banner
		//header current add by kon at 20130415
        //$this->display();
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$this->assign('_KeyWordList',$keywordInfo['append']);
		$this->assign('headertitle', '辅助品');
		$this->assign('_current', 'append');
        $this->display('append_list');
    }
    //get append video list
    public function videoList()
    {
        $id = intval($_GET['id']);
        $this->assign('cssFile', 'video');
        $this->assign('cssFile', 'add');
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
        
        $hotArticles = D('Article')->getAppendArticles('click');
        $this->assign('hotArticles', $hotArticles);
        //foreach($hotArticles as $a) echo $a['title'];//$a['title']=substr($a['title'],0,10)."...";		
        $lastArticles = D('Article')->getAppendArticles('create_time');
        $this->assign('lastArticles', $lastArticles);
        
        $video = D('Article')->getAppendVideo('create_time');
        $this->assign('video', $video);
        
        $this->show_banner();//banner 滚动图片列表
        $this->display('vlist');
        /*$id = intval($_GET['id']);
        $videos = M('video')->where(array('category_id'=>$id))->findAll();
        //print_r($videos);
        $cate = M('article_category')->where(array('channel'=>'2', 'type'=>'2'))->findAll();
        foreach($cate as $c) {
            if($c['parent']==NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        $this->assign('videos', $videos);
        $this->assign('categories', $realCate);
                print_r( $realCate);
        $this->assign('cssFile', 'video');
        $this->assign('cssFile', 'add');
        $this->display('vlist');*/
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
