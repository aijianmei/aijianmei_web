<?php
class NutriAction extends Action {
	public function index()
	{
		$map['channel'] = '3';
		$cate = M('article_category')->where($map)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $parent[$c['id']] = $c;
			else $parent[$c['parent']]['children'][] = $c; 
			$cate_id[] = $c['id'];
		}
		$articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $parent);
		
		
		/*$cate = M('article_category')->where(array('channel'=>'3'))->order('id desc')->limit(8)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;
		}*/
		
		$order = 'click';
		$hotArticles = D('Article')->getNutriArticles($order);
		$this->assign('hotArticles', $hotArticles);
		//print_r($hotArticles);
		
		$lastArticles = D('Article')->getNutriArticles('create_time');
		$this->assign('lastArticles', $lastArticles);
		//print_r($lastArticles);
		//print_r($realCate);
		//$this->assign('categories', $realCate);
		//$this->assign('cate', $cate);
		$this->assign('cssFile', 'nutri');
		$this->display();
	}
	
	public function articleList()
	{
		$id = intval($_GET['id']);
		
		$cate = M('article_category')->where(array('channel'=>'3'))->order('id desc')->limit(2)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;
			$cate_id[] = $c['id'];
		}
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		$articles = M('article')->where($map)->findAll();
		//var_dump($articles);
		$this->assign('articles', $articles);
		$this->assign('categories', $realCate);
		//$this->assign('cssFile', 'video');
		$this->assign('cssFile', 'nutri');
		$this->display('list');
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
		$this->assign('cssFile', 'nutri');
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
}
?>
