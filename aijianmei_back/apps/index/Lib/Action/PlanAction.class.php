<?php
class PlanAction extends Action {
	function show_banner(){
		 $change_1="plan_1.jpg";
		 $change_2="plan_2.jpg";
		 $change_3="plan_3.jpg";
		 $change_4="plan_4.jpg";
		 $articleid_1="69";
		 $articleid_2="76";
		 $articleid_3="89";
		 $articleid_4="91";
		 $name_1="体重训练：生活方式";
		 $name_2="日常健身：生活方式";
		 $name_3="运动员：营养 ";
		 $name_4="健身运动员：锻炼";
		 $describe_1="不管你是谁、在哪里运动、或者你有多少经验，有几点你必须要遵守以成功达到目标。健身是很长的一个过程，而不是由一个月的随机零散的几个锻炼就完成了。";
		 $describe_2="健身计划是设计来促成这些目标的，你的目标是承诺跟随这些健身计划，读并且跟随我们的营养信息并且给予身体时间来恢复和改变，那是你健身的三个基础：营养、锻炼、恢复。";
		 $describe_3="如果你的目标是锻炼出像运动员一样的身材，那么你的饮食是至关重要的。首先，从了解自己的体脂水平开始，然后开始向你的目标进发！";
		 $describe_4="我们会指导你在健身的正轨锻炼——阅读我们关于训练、营养和补充品文章和教学视频，你会懂得很多丰富的健身知识，这对你实现目标来说非常重要。";
		 $this->assign('change_1',$change_1);
		 $this->assign('change_2',$change_2);
		 $this->assign('change_3',$change_3);
		 $this->assign('change_4',$change_4);
		 $this->assign('articleid_1',$articleid_1);
		 $this->assign('articleid_2',$articleid_2);
		 $this->assign('articleid_3',$articleid_3);
		 $this->assign('articleid_4',$articleid_4);
		  $this->assign('describe_1',$describe_1);
		 $this->assign('describe_2',$describe_2);
		 $this->assign('describe_3',$describe_3);
		 $this->assign('describe_4',$describe_4);
		 $this->assign('name_1',$name_1);
		 $this->assign('name_2',$name_2);
		 $this->assign('name_3',$name_3);
		 $this->assign('name_4',$name_4);
		//-------END--------	

	}
	public function index() 
	{
		$this->assign('cssFile', 'plan');
		$daily = M('daily')->findAll();
		foreach ($daily as $d) {
			$article[$d['channel']][] = $d;
		}
		$this->assign('article', $article);
		
		$shangban = M('article')->where(array('category_id'=>'43'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('shangban', $shangban);
		
		$richang =  M('article')->where(array('category_id'=>'44'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('richang', $richang);
		
		$zhuanye =  M('article')->where(array('category_id'=>'45'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('zhuanye', $zhuanye);
		
		$jianmei =  M('article')->where(array('category_id'=>'46'))->limit('0,4')->order('id desc')->findAll();
		$this->assign('jianmei', $jianmei);

		$this->show_banner();//banner 滚动图片列表
	
		$this->display();
	}
	
	public function plan_loss()
	{
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
		
		$coach = D('Article')->getCoach();
		$this->assign('coach', $coach);
		$this->assign('cssFile', 'plan');
		$this->display();
	}

	public function gym()
	{
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
		
		$gym = D('Article')->getGym();
		$this->assign('gym', $gym);
		$this->assign('cssFile', 'plan');
		$this->display();
	}

}
?>
