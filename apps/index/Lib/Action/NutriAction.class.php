<?php
class NutriAction extends Action {
	public function index()
	{
		$cate = M('article_category')->where(array('channel'=>'3'))->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;
		}
		//print_r($realCate);
		$this->assign('categories', $realCate);
		$this->assign('cssFile', 'nutri');
		$this->display();
	}
	
	public function articleList()
	{
		$id = intval($_GET['id']);
		
		$cate = M('article_category')->where(array('channel'=>'3'))->findAll();
		foreach($cate as $c) {
			if($c['parent'] == NULL) $realCate[$c['id']] = $c;
			else $realCate[$c['parent']]['children'][] = $c;
			$cate_id[] = $c['id'];
		}
		$map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
		$articles = M('article')->where($map)->findAll();
		var_dump($articles);
		$this->assign('articles', $articles);
		$this->assign('categories', $realCate);
		$this->assign('cssFile', 'nutri');
		$this->display('list');
	}
	
	public function videoList()
	{
		$id = intval($_GET['id']);
		$this->display();
	}
}
?>
