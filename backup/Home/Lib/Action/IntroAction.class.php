<?php
class IntroAction extends Action {
	
	public function __construct(){
		parent::__construct();
		Load('extend');
		import("ORG.Util.Page"); 
		
		$this->assign('module_name',MODULE_NAME);
		}
	
	public function index() {

		//$this->display();
	}
	
	public function about() {
	
	$this->display();
	}
	
	public function help() {
	
	$this->display();
	}
	
	public function direct() {
	
	
	$this->display();
	}
	
	public function contact() {
	
	
	$this->display();
	}
	
	public function join() {
	
	
	$this->display();
	}
	
	public function ad() {
	
	
	$this->display();
	}
	
	public function privacy() {
	
	
	
	$this->display();
	}
	
	public function app() {
	
	
	$this->display();
	}
	
	public function feedback() {
	
	
	$this->display();
	}

}
?>