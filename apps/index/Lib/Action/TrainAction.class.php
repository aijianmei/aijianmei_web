<?php
class TrainAction extends Action {
	public function index()
	{
		$this->assign('cssFile', 'training');
		$map['channel'] = '2';
		$cate = M('article_category')->where($map)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $parent[$c['id']] = $c;
			else $parent[$c['parent']]['children'][] = $c; 
			$cate_id[] = $c['id'];
		}
		
		$articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $parent);
		$this->display();
	}
	
	public function articleList()
	{
		$id = intval($_GET['id']);
		$this->assign('cssFile', 'video');
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
		
		$this->display('list');
	}
	
	public function videoList()
	{
		$id = intval($_GET['id']);
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
		$this->assign('cssFile', 'video');
		$this->display('vlist');
	}
	
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
