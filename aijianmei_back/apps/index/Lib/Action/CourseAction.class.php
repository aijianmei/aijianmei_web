<?php
class CourseAction extends Action {
	public function index() {
		//print_r($_SESSION['mid']);
		$this->assign ( 'headertitle', '健身计划' );
		$this->assign ( '_current', 'plan' );
		$this->assign ( 'cssFile', 'index' );
		$this->display ( 'tool' );
	}
}
?>
