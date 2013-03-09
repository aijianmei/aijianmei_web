<?php

class StoreAction extends Action {


	public function __construct(){
		parent::__construct();
		Load('extend');
		import("ORG.Util.Page"); 
		
	$category = M('storecategory');
	$cat_1_list = $category->where('type=1')->order('sort_order desc , id asc')->select();
	$cat_2_list = $category->where('type=2')->order('sort_order desc , id asc')->select();
	$cat_3_list = $category->where('type=3')->order('sort_order desc , id asc')->select();
	
	

	$this->assign('cat_1_list',$cat_1_list);
	$this->assign('cat_2_list',$cat_2_list);
	$this->assign('cat_3_list',$cat_3_list);
	$this->assign('module_name',MODULE_NAME);
		}



    public function index(){
	
	

	
	$this->display();
    }
	
	
	public function store_list(){
	
	
	
	
	
	
	$this->display();
	}
	
	
	
}


?>