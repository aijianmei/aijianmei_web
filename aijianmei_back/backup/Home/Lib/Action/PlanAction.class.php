<?php

class PlanAction extends Action {


	public function __construct(){
		parent::__construct();
		Load('extend');
		import("ORG.Util.Page"); 
		
		$this->assign('module_name',MODULE_NAME);
		}



    public function index(){

	
	
	
	$this->display();
    }
	
	public function loss(){
	
	
	
	
	$this->display();
	}
	
	public function build() {
	
	
	$this->display();
	}
	
	public function exer() {
	
	
	$this->display();
	}
	
	public function gym() {
	
	
	$this->display();
	}
}


?>