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

		$this->show_banner();//显示banner
/*

		*/
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
		$hotArticles = D('Article')->getTrainArticles($order, $id);
		$this->assign('hotArticles', $hotArticles);
		//get lastArticles		
		$order = 'create_time';
		$hotArticles = D('Article')->getTrainArticles($order, $id);
		$this->assign('lastArticles', $hotArticles);
		
		$this->assign('categories', $realCate);
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		
		$count = M('article')->where($map)->count();
		$pager = api('Pager');
		$pager->setCounts($count);
		$pager->setList(6);
		$pager->makePage();
		$from = ($pager->pg-1) * $pager->countlist;
		$pageArray = (array)$pager;
	
		$articles = M('article')->where($map)->limit("$from,$pager->countlist")->findAll();
		$this->assign('pager', $pageArray);
		$this->assign('articles', $articles);
		
		 $this->show_banner();//显示banner
		
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
		$this->show_banner();//显示banner
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
		//$videoInfo = D('Article')->getVideoInfoByArticle($video['Article']);
		//print_r($video);
		//$this->assign('videoInfo', $videoInfo);
		$this->assign('video', $video);
		$this->assign('cssFile', 'v');
		$this->display('video');
	}
}
?>
