<?php
class PlanAction extends Action {
	public function index() 
	{
		$this->assign('cssFile', 'plan');
		$daily = M('daily')->findAll();
		foreach ($daily as $d) {
			$article[$d['channel']][] = $d;
		}
		$this->assign('article', $article);
		$this->display();
	}
	
	public function plan_loss()
	{
		$this->assign('cssFile', 'plan');
		if($_GET['sex']=='m') {
			$this->display('plan_loss_m');
		}elseif ($_GET['sex']=='f') {
			$this->display('plan_loss_f');
		}else {
			$this->display();
		}		
	}
	
	public function plan_build()
	{
		$this->assign('cssFile', 'plan');
		if($_GET['sex']=='m') {
			$this->display('plan_build_m');
		}elseif ($_GET['sex']=='f') {
			$this->display('plan_build_f');
		}else {
			$this->display();
		}
	}

	public function coach()
	{
		$coach = D('Article')->getCoach();
		$this->assign('coach', $coach);
		$this->assign('cssFile', 'plan');
		$this->display();
	}

	public function gym()
	{
		$gym = D('Article')->getGym();
		$this->assign('gym', $gym);
		$this->assign('cssFile', 'plan');
		$this->display();
	}

}
?>
