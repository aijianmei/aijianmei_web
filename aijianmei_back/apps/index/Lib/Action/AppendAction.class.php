<?php
class AppendAction extends Action {
	public function index()
	{
		$map['channel'] = '4';
		$cate = M('article_category')->where($map)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $parent[$c['id']] = $c;
			else $parent[$c['parent']]['children'][] = $c; 
			$cate_id[] = $c['id'];
		}
		$articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $parent);
		
		/*$cate = M('article_category')->where(array('channel'=>'4'))->findAll();
		foreach($cate as $c) {
			if($c['parent']==NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;;
			$cate_id[] = $c['id'];
		}*/
		$map['category_id'] = array('in', implode(',', $cate_id));
		$articles = M('article')->where($map)->findAll();
		//print_r($articles);
		$hotArticles = D('Article')->getAppendArticles('click');
		$this->assign('hotArticles', $hotArticles);
		//foreach($hotArticles as $a) echo $a['title'];//$a['title']=substr($a['title'],0,10)."...";
		
		$lastArticles = D('Article')->getAppendArticles('create_time');
		$this->assign('lastArticles', $lastArticles);
		//$this->assign('cate', $cate);
		$this->assign('articles', $articles);
		//$this->assign('categories', $realCate);
		$this->assign('cssFile', 'add');
		$this->display();
	}
	
	public function articleList()
	{
		$order = isset($_GET['order']) ? t($_GET['order']) : 'create_time';
		$id = intval($_GET['id']);
		$cate = M('article_category')->where(array('channel'=>'4'))->findAll();
		foreach($cate as $c) {
			if($c['parent']==NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;;
			$cate_id[] = $c['id'];
		}
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		$articleCount = M('article')->where(array('category_id'=>$id))->count();
		$pager = api('Pager');
		$pager->setCounts($articleCount);
		$pager->setList(10);
		$pager->makePage();
		$pageArray = (array)$pager;
		$this->assign('pager', $pageArray);
		$from = ($pager->pg-1) * $pager->countlist;
		$articles = M('article')->where(array('category_id'=>$id))->order("$order desc")->limit("$from,$pager->countlist")->findAll();
		echo "$id ";
		//echo "from:$from<br>$pager->pg-1<br>countlist:$pager->countlist";
		$this->assign('articles', $articles);
		print_r($articles);
		$this->assign('categories', $realCate);
		//print_r($articles);
		echo 
		$this->assign('cssFile', 'add');
		
		$hotArticles = D('Article')->getAppendArticles('click');
		$this->assign('hotArticles', $hotArticles);
		//foreach($hotArticles as $a) echo $a['title'];
		$a['title']=substr($a['title'],0,10)."...";		
		$lastArticles = D('Article')->getAppendArticles('create_time');
		$this->assign('lastArticles', $lastArticles);
		
		$this->display('list');
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
}
?>
