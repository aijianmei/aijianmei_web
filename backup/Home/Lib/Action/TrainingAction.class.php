<?php

class TrainingAction extends Action {


	public function __construct(){
		parent::__construct();
		Load('extend');
		import("ORG.Util.Page"); 
		
		import("@.ORG.Category");
		$this->cat = new Category('Trainingcategory', array('cid', 'fid', 'name', 'fullname'));
		$this->cat_list = $this->cat->getList('',0,'sort_order desc,cid asc'); 
		
		$li = $this->cat->getList('fid=0',0,'sort_order desc,cid asc');
		
		foreach ($li as $value)
		{
			$value['list'] = $this->cat->getList('fid='.$value['cid'],$value['cid'],'sort_order desc,cid asc');
			$lis[] = $value;
		}
		
		
		$this->training = M('training');
		
		$this->assign('module_name',MODULE_NAME);
		$this->assign('lis',$lis);
		$this->assign('cat_list',$this->cat_list);
		}



    public function index(){

	

	
	$this->display();
    }
	
	
	public function training_list(){
	
	
	
	
	$this->display();
	}
	
	
	public function view() {
	
	
	
	
	}
}


?>