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

		//banner 滚动图片列表
		 $change_1="01.jpg";
		 $change_2="02.jpg";
		 $change_3="07.jpg";
		 $change_4="16.jpg";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		//-------END--------
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
