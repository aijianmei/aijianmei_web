<?php
class AppendAction extends Action {
	function show_banner(){
			//banner 滚动图片列表
		 $change_1="append_1.jpg";
	     $change_2="append_2.jpg";
	     $change_3="append_3.jpg";
	     $change_4="append_4.jpg";
	     $articleid_1="60";
		 $articleid_2="56";
		 $articleid_3="92";
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
		//-------END--------

		}
	public function index()
	{
		
		$map['channel'] = '4';
		$cate = M('article_category')->where($map)->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $parent[$c['id']] = $c;
			else $parent[$c['parent']]['children'][] = $c; 
			$cate_id[] = $c['id'];
		}
		//print_r($cate);
		$articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $cate);
		$this->assign('parent_categories', $parent);
		
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
		$this->assign('cssFile', 'training');
		$this->show_banner();//banner 滚动图片列表
/*
		
		*/
		$this->display();
	}
	
	public function articleList()
	{
		/*$id = intval($_GET['id']);
		$this->assign('cssFile', 'video');
		$this->assign('cssFile', 'add');
		$cate = M('article_category')->where(array('channel'=>'4'))->findAll();
		foreach($cate as $c) {
			if($c['parent']==NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;
			$cate_id[] = $c['id'];
		}

		//get hotArticles
		$order = 'click';
		$hotArticles = D('Article')->getAppendArticles($order);
		$this->assign('hotArticles', $hotArticles);
		//get lastArticles		
		$order = 'create_time';
		$hotArticles = D('Article')->getAppendArticles($order);
		$this->assign('lastArticles', $hotArticles);
		
		$this->assign('categories', $realCate);
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		//print_r($map);
		$articles = M('article')->where($map)->findAll();
		$this->assign('articles', $articles);
		
		$this->display('list');*/
		
		$order = isset($_GET['order']) ? t($_GET['order']) : 'create_time';
		$id = intval($_GET['id']);
		$cate = M('article_category')->where(array('channel'=>'4'))->findAll();
		//print_r($cate);
		foreach($cate as $c) {
			if($c['parent']==NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;;
			$cate_id[] = $c['id'];
		}
		
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		// 查询满足要求的总记录数
		$articleCount = M('article')->where(array('category_id'=>$id))->count();
                $style['pre'] = 'prev';
                $style['next'] = 'next';
                $style['current'] = 'current_page';
		$pager = api('Pager');	// 实例化分页类 
		$pager->setCounts($articleCount); //传入总记录数
                $pager->setStyle($style);
		$pager->setList(10);	// 设置每页显示的记录数
		$pager->makePage();		//生成数字分页
		$pageArray = (array)$pager;
		$this->assign('pager', $pageArray);
		
		$from = ($pager->pg-1) * $pager->countlist;
		$articles = M('article')->where(array('category_id'=>$id))->order("$order desc")->limit("$from,$pager->countlist")->findAll();
		$this->assign('articles', $articles);
		$this->assign('categories', $realCate);
		//print_r($articles);
		$this->assign('cssFile', 'add');
		
		$hotArticles = D('Article')->getAppendArticles('click', $id);
		$this->assign('hotArticles', $hotArticles);
		//foreach($hotArticles as $a) echo $a['title'];
		$a['title']=substr($a['title'],0,10)."...";		
		$lastArticles = D('Article')->getAppendArticles('create_time', $id);
		$this->assign('lastArticles', $lastArticles);
		$this->show_banner();//banner 滚动图片列表
		
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
}
?>
