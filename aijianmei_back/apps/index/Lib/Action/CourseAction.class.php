<?php
class CourseAction extends Action {
	public function index() {
		$date=date('Ymd',time());
		$uid=$_SESSION['mid']? intval($_SESSION['mid']):0;
		//echo getUserFace($uid,'b');exit;
		$defaultActionList=$this->getDefaultActionList($uid);
		if(empty($defaultActionList)){
			$actionList=$this->getRecommendActionList();
			$faid=intval($actionList[0]['id']);
		}else{
			$actionList=$defaultActionList;
			$faid=intval($actionList[0]['id']);
		}


		
		$myActionList=$this->actionListToString($actionList);

		$couserinfo=$this->getCourseInfo($uid,$faid,$date);

		$healthInfo=$this->getUserHealthById($uid);

		$toticString=$this->gettoticString($healthInfo);

		$imageList=$this->getLogImage();
		$logList=$this->getLog();


		//var_dump($imageList);exit();
		$this->assign ( 'myActionList', $myActionList);
		$this->assign ( 'logList', $logList);
		$this->assign ( 'imageList', $imageList);
		$this->assign ( 'toticString', $toticString);
		$this->assign ( 'couserinfo', $couserinfo);
		$this->assign ( 'actionList', $actionList);
		$this->assign ( 'userHealth', $healthInfo);
		$this->assign ( 'keywordInfo', $this->getUserKeyword($uid));
		$this->assign ( 'userDes', getUserDes($uid));
		$this->assign ( 'userName', getUserName($uid));
		$this->assign ( 'headertitle', '健身计划' );
		$this->assign ( 'cssFile', 'index' );
		$this->display ( 'tool' );
	}
	protected function actionListToString($actionList){
		$string=null;
		foreach ($actionList as $key => $value) {
			$string.=empty($string)? '"'.$value['name'].'"':',"'.$value['name'].'"';
		}
		return $string;
	}
	protected function getLogImage(){
		$baseDir=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$data=$res=$edate=$sdate=$uid=null;
		$edate=reNorTime(1);
		$sdate=reNorTime(-1);
		$uid=$this->mid;
		$sql="select * from ai_user_course_log_image where date>=$sdate and date<=$edate and uid=$uid";
		$res=M('')->query($sql);
		$data['default']['image']='/Templates/tool/images/tool/pic.png';
		$data['next']['image']='/Templates/tool/images/tool/pic.png';
		$data['pre']['image']='/Templates/tool/images/tool/pic.png';
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==reNorTime()){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']:'/Templates/tool/images/tool/pic.png';
				}elseif($value['date']==reNorTime(1)){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']:'/Templates/tool/images/tool/pic.png';
				}elseif ($value['date']==reNorTime(-1)) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/pic.png';
				}
			}
		}
		return !empty($data) ? $data :'';
	}
	protected function getLog(){
		$baseDir=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$data=$res=$edate=$sdate=$uid=null;
		$edate=reNorTime(1);
		$sdate=reNorTime(-1);
		$uid=$this->mid;
		$sql="select * from ai_user_course_log where date>=$sdate and date<=$edate and uid=$uid";
		$res=M('')->query($sql);
		$data['default']['image']='/Templates/tool/images/tool/rj_1.png';
		$data['next']['image']='/Templates/tool/images/tool/rj_1.png';
		$data['pre']['image']='/Templates/tool/images/tool/rj_1.png';
		if(!empty($res)){
			foreach ($res as $key => $value) {
				if($value['date']==reNorTime()){
					$data['default']=$value;
					$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']:'/Templates/tool/images/tool/pic.png';
				}elseif($value['date']==reNorTime(1)){
					$data['next']=$value;
					$data['next']['image']=is_file($baseDir.$data['next']['image'])?$data['next']['image']:'/Templates/tool/images/tool/pic.png';
				}elseif ($value['date']==reNorTime(-1)) {
					$data['pre']=$value;
					$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/pic.png';
				}
			}
		}
		return !empty($data) ? $data :'';
	}



	protected function gettoticString($healthInfo=null){
		if($healthInfo['weight']>0&&$healthInfo['targetWeight']>0){
			$toticString='尊敬的用户,请及时记录体重数据,以便我们为你提供更好的服务!';
		}
		else{
			$toticString='这是您第一次录入数据，请先填入您的初始体重和目标体重吧!';
		}
		return $toticString;
	}
	protected function getRecommendActionList(){
		$sql="select * from ai_action_list where recommend=1";
		$data=M('')->query($sql);
		return $data;
	}
	protected function getActionInfoByName($name){
		$sql="select * from ai_action_list where name like '%".$name."%'";
		$data=M('')->query($sql);
		return $data[0];
	}
	protected function getDefaultActionList($uid){
		$sql="select * from ai_user_course_default_alist where uid=$uid";
		$data=M('')->query($sql);
		$data[0]['actionList']=unserialize($data[0]['actionList']);
		foreach ($data[0]['actionList'] as $key => $value) {
			$tmpdata[$key]['name']=$value;
			$nameinfo=$this->getActionInfoByName($value);
			$tmpdata[$key]['id']=$nameinfo['id'];
		}
		return $tmpdata;
	}
	protected function getUserKeyword($uid){
		if(!$uid>0) return ;
		$getUserKeywordSql="select * from ai_user_keywords where uid='".$uid."'";
		$getUserKeyword=M('')->query($getUserKeywordSql);
		if (!empty($getUserKeyword)) {
			$getUserKeyword=unserialize($getUserKeyword[0]['keyword']);
			return $getUserKeyword;
		}
		return ;
	}
	protected function getCourseInfo($uid,$aid,$date){
		$sql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`=$date";
		$data=M('')->query($sql);
		if (! empty ( $data )) {
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$value ['cnum'] = $this->num2Char($k+1);
			}
		}else{
			$data[0]['loginfo']['nums']=0;
			$data[0]['loginfo']['weight']=0;
			$data[0]['loginfo']['time']=0;
			$data[0]['cnum'] ='一';
			$data[1]['loginfo']['nums']=0;
			$data[1]['loginfo']['weight']=0;
			$data[1]['loginfo']['time']=0;
			$data[1]['cnum'] ='二';
			$data[2]['loginfo']['nums']=0;
			$data[2]['loginfo']['weight']=0;
			$data[2]['loginfo']['time']=0;
			$data[2]['cnum'] ='三';
			$data[3]['loginfo']['nums']=0;
			$data[3]['loginfo']['weight']=0;
			$data[3]['loginfo']['time']=0;
			$data[3]['cnum'] ='四';

		}
		return $data;
	}
	protected function getUserHealthById($uid){
		$sql="select body_weight as weight,targetWeight,nowWeight,weightTime,targetTime from ai_user_health_info where uid=$uid";
		$data=M('')->query($sql);
		if(empty($data)){
			$data[0]['weight']=0;
			$data[0]['targetWeight']=0;
			$data[0]['nowWeight']=0;
			$data[0]['pertent']=0;
			$data[0]['klu']=0;
			$data[0]['isfitness']=1;
			$data[0]['wtime']=1;
			$data[0]['isfitness']=1;
			$data[0]['weightTime']=date("Y-m-d",time());
			$data[0]['targetTime']=date("Y-m-d",time());
		}else{
			$prefino=$this->getWeigthPertent($data[0]['weight'],$data[0]['targetWeight'],$data[0]['nowWeight']);
			$data[0]['pertent']=round($prefino['pertent'],1);
			$data[0]['klu']=$prefino['klu'];
			$data[0]['isfitness']=$data[0]['targetWeight']< $data[0]['weight'] ? 1 : 2;
			$data[0]['weightTime']=date("Y-m-d",$data[0]['weightTime']);
			$data[0]['targetTime']=date("Y-m-d",$data[0]['targetTime']);
		}
		return $data[0];
	}
	protected function getWeigthPertent($weight,$targetWeight,$nowWeight){
		$pertent=0;
		if($targetWeight > $weight){//目标数值大于原始值 增重
				$klu=($targetWeight-$nowWeight)*7700;
				if($nowWeight < $weight){//当前数值 < 原始数值 无用功直接 0%
					$pertent=0;
				}else{//否则计算对应完成度的百分比
					$pertent = ($nowWeight-$weight) / ($targetWeight-$weight) * 100;
				}
				if($nowWeight > $targetWeight){//当前数值>目标的数值 则目标已经超标完成 直接是100%
					$pertent=100;
				}
			}else{//目标数值大于原始值 减肥
				$klu=($nowWeight-$targetWeight)*7700;
				if($nowWeight < $weight && $nowWeight > $targetWeight){//当前数值 < 原始数值  并且大于目标值 则 减肥有效果 仍需继续努力
					$pertent = ($weight-$nowWeight) / ($weight-$targetWeight) * 100;
				}elseif($nowWeight < $weight && $nowWeight < $targetWeight ){ //当前数值 小于原始值 并且小于目标值 减肥完美超额完成...估计要增肥了
					$pertent = 100;//完成度自然100..
				}elseif($nowWeight > $weight){//当前数值 > 原始数值  好吧你减肥失败了 增重成功了...完成度0 哭也没用啊 混蛋
					$pertent=0;
				}
			}
			return array( 'pertent' => $pertent,'klu'=> $klu);
	}
	protected function num2Char($num){
		$charArr = array('1' =>'一' , '2' => '二','3' => '三' ,'4' => '四' ,'5' => '五' ,'6' => '六' ,
			'7' => '七' , '8' => '八', '9' => '九' );
		return !empty($num)?$charArr[$num]:$num;
	}

}
?>
