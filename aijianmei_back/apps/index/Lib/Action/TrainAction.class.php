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
		
		$articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $parent);
		//$this->display();
		
		//assign hotArticles
		$order = 'click';
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('hotArticles', $hotArticles);
		
		//assign lastArticles		
		$order = 'create_time';
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('lastArticles', $hotArticles);

		//banner 滚动图片列表
		 $change_1="06.jpg";
		 $change_2="13.jpg";
		 $change_3="14.jpg";
		 $change_4="15.jpg";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		//-------END--------
		
		$this->display();
	}
	
	public function articleList()
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
		
		//get hotArticles
		$order = 'click';
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('hotArticles', $hotArticles);
		//get lastArticles		
		$order = 'create_time';
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('lastArticles', $hotArticles);
		
		$this->assign('categories', $realCate);
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		$articles = M('article')->where($map)->findAll();
		$this->assign('articles', $articles);
		
		 //banner 滚动图片列表
		 $change_1="06.jpg";
		 $change_2="13.jpg";
		 $change_3="14.jpg";
		 $change_4="15.jpg";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		//-------END--------
		
		$this->display('list');
	}
	
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
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('hotArticles', $hotArticles);
		//get lastArticles		
		$order = 'create_time';
		$hotArticles = D('Article')->getTrainArticles($order);
		$this->assign('lastArticles', $hotArticles);
		
		 //banner 滚动图片列表
		 $change_1="06.jpg";
		 $change_2="13.jpg";
		 $change_3="14.jpg";
		 $change_4="15.jpg";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		//-------END--------
		
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
		$this->assign('cssFile', 'video');
		$this->assign('cssFile', 'training');
		$this->display('vlist');*/
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
