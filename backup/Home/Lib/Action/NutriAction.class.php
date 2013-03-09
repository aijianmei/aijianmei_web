<?php

class NutriAction extends Action {


	public function __construct(){
		parent::__construct();
		Load('extend');
		import("ORG.Util.Page"); 
		
		$this->assign('module_name',MODULE_NAME);
		}



    public function index(){

	
	
	
	$this->display();
    }
	
	
	
}


?>