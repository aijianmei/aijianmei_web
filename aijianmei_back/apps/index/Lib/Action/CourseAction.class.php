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

		$this->countUserExercise();


		$this->setUserRankInfo($uid,$faid);

		$myActionList=$this->actionListToString($actionList);

		$couserinfo=$this->getCourseInfo($uid,$faid,$date);

		$rAvgdata=array();
		$countNums=count($couserinfo);
		foreach ($couserinfo as $key => $value) {
			$numCount		+=$value['loginfo']['nums'];
			$weightCount	+=$value['loginfo']['weight'];
			$timeCount		+=$value['loginfo']['time'];
		}
		$rAvgdata['numsAvg'] 	=round($numCount/$countNums);
		$rAvgdata['weigthAvg'] =round($weightCount/$countNums);
		$rAvgdata['timeAvg'] 	=round($timeCount/$countNums);

		$couserAvg   =$this->getCourseInfoAvg($uid,$faid,$date);

		$healthInfo  =$this->getUserHealthById($uid);

		//var_dump($healthInfo);

		$toticString =$this->gettoticString($healthInfo);

		$imageList	 =$this->getLogImage();

		$logList=$this->getLog();
//var_dump($imageList);exit;
		$this->assign ( 'rAvgdata', $rAvgdata);
		$this->assign ( 'myActionList', $myActionList);
		$this->assign ( 'logList', $logList);
		$this->assign ( 'imageList', $imageList);
		$this->assign ( 'toticString', $toticString);
		$this->assign ( 'couserinfo', $couserinfo);
		$this->assign ( 'couserAvg', $couserAvg);
		$this->assign ( 'actionList', $actionList);
		$this->assign ( 'userHealth', $healthInfo);
		$this->assign ( 'keywordInfo', $this->getUserKeyword($uid));
		$this->assign ( 'userDes', getUserDes($uid));
		$this->assign ( 'userName', getUserName($uid));
		$this->assign ( 'headertitle', '健身计划' );
		$this->assign ( 'cssFile', 'index' );
		$this->assign ( 'cssFile', 'index' );
		$this->display ( 'tool' );
	}

	public function setUserRankInfo($uid,$aid){
		//所有的排行
//$this->getUserRankById($uid,'',$aid,true);

		$duserRankList=$this->getUserRank('',$aid);
		$userRankList=$this->getUserRank();
		$userRankList_7=$this->getUserRank(7);
		$userRankList_30=$this->getUserRank(30);
		$userRankList_all=$this->getUserRank('','',true);

		$this->assign ( 'userRankList', $userRankList);
		$this->assign ( 'userRankList_7', $userRankList_7);
		$this->assign ( 'userRankList_30', $userRankList_30);
		$this->assign ( 'userRankList_all', $userRankList_all);

		$this->assign ( 'userRankNum', $this->getUserRankById($uid));
		$this->assign ( 'userRankNum7', $this->getUserRankById($uid,7));
		$this->assign ( 'userRankNum30', $this->getUserRankById($uid,30));
		$this->assign ( 'userRankNumall', $this->getUserRankById($uid,'','',true));

		//单项排行
		$duserRankList=$this->getUserRank('',$aid);
		$duserRankList_7=$this->getUserRank(7,$aid);
		$duserRankList_30=$this->getUserRank(30,$aid);
		$duserRankList_all=$this->getUserRank('',$aid,true);


		$this->assign ( 'duserRankList', $duserRankList);
		$this->assign ( 'duserRankList_7', $duserRankList_7);
		$this->assign ( 'duserRankList_30', $duserRankList_30);
		$this->assign ( 'duserRankList_all', $duserRankList_all);



		$this->assign ( 'duserRankNum', $this->getUserRankById($uid,'',$aid));
		$this->assign ( 'duserRankNum7', $this->getUserRankById($uid,7,$aid));
		$this->assign ( 'duserRankNum30', $this->getUserRankById($uid,30,$aid));
		$this->assign ( 'duserRankNumall', $this->getUserRankById($uid,'',$aid,true));

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
		$edate=date("Ymd",time());
		//$sdate=reNorTime(-1);
		$uid=$this->mid;
		$sql="select * from ai_user_course_log_image where date<=$edate and uid=$uid order by date desc limit 2";
		$res=M('')->query($sql);
		$data['default']['image']='/Templates/tool/images/tool/pic.png';
		$data['pre']['image']='/Templates/tool/images/tool/pic.png';
		if(!empty($res)){
			if($res[0]['date']==$edate){
				$data['default']=$res[0];
				$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']:'/Templates/tool/images/tool/pic.png';
				$data['pre']=$res[1];
				$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/pic.png';
			}else{
				$data['default']['date']=$edate;
				$data['default']['image']='/Templates/tool/images/tool/pic.png';
				$data['pre']=$res[0];
				$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/pic.png';
			}

		}
		return !empty($data) ? $data :'';
	}
	protected function getLog(){
		$baseDir=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$data=$res=$edate=$sdate=$uid=null;
		$edate=date("Ymd",time());
		$uid=$this->mid;
		$sql="select * from ai_user_course_log where date<=$edate and uid=$uid order by date desc limit 2";
		$res=M('')->query($sql);
		//exit;
		$data['default']['image']='/Templates/tool/images/tool/rj_1.png';
		$data['pre']['image']='/Templates/tool/images/tool/rj_1.png';

		if(!empty($res)){
			if($res[0]['date']==$edate){
				$data['default']=$res[0];
				$data['default']['image']=is_file($baseDir.$data['default']['image'])?$data['default']['image']:'/Templates/tool/images/tool/rj_1.png';
				$data['pre']=$res[1];
				$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/rj_1.png';
			}else{
				$data['default']['date']=$edate;
				$data['default']['image']='/Templates/tool/images/tool/rj_1.png';
				$data['pre']=$res[1];
				$data['pre']['image']=is_file($baseDir.$data['pre']['image'])?$data['pre']['image']:'/Templates/tool/images/tool/rj_1.png';
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
		$sql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`=$date order by `group` asc";
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
	//获取对应日期之前的平均值
	public function getCourseInfoAvg($uid,$aid,$date){
		$date= date("Ymd",strtotime($date)-86400);
		$sql=$countNums=$numCount=null;
		$rdata=$data=array();
		$sql = "select * from ai_user_course_list where `uid`=$uid and `aid`=$aid  and `date`<=$date";
		$data=M('')->query($sql);
		if (! empty ( $data )) {
			$countNums=count($data);
			foreach ( $data as $k => &$value ) {
				$value ['loginfo'] = unserialize ( $value ['loginfo'] );
				$value ['cnum'] = $this->num2Char($k+1);
				$numCount+=$value ['loginfo']['nums'];
				$weightCount+=$value ['loginfo']['weight'];
				$timeCount+=$value ['loginfo']['time'];
			}
			$rdata['numsAvg'] 	=round($numCount/$countNums);
			$rdata['weigthAvg'] =round($weightCount/$countNums);
			$rdata['timeAvg'] 	=round($timeCount/$countNums);
		}else{
			$rdata['numsAvg'] ='0';
			$rdata['weigthAvg'] ='0';
			$rdata['timeAvg'] ='0';
		}
		return $rdata;
	}
	protected function getUserHealthById($uid){
		$sql="select body_weight as weight,targetWeight,nowWeight,weightTime,targetTime from ai_user_health_info where uid=$uid";
		$data=M('')->query($sql);
		if(empty($data)){
			$data[0]['weight']	    =0;
			$data[0]['targetWeight']=0;
			$data[0]['nowWeight'] 	=0;
			$data[0]['pertent'] 	=0;
			$data[0]['klu'] 		=0;
			$data[0]['isfitness']   =1;
			$data[0]['wtime'] 		=1;
			$data[0]['isfitness']   =1;
			$data[0]['weightTime']  =date("Y-m-d",time());
			$data[0]['targetTime']  =date("Y-m-d",time());
		}else{
			$prefino=$this->getWeigthPertent($data[0]['weight'],$data[0]['targetWeight'],$data[0]['nowWeight']);
			$data[0]['pertent']  	=round($prefino['pertent'],1);
			$data[0]['klu'] 		=$prefino['klu'];
			if($data[0]['klu']>0){
				$data[0]['isfitness']   =$data[0]['targetWeight']< $data[0]['weight'] ? 1 : 2;
			}else{
				$data[0]['klu']=abs($data[0]['klu']);
				$data[0]['isfitness']   =$data[0]['targetWeight']< $data[0]['weight'] ? 2 : 1;
			}
			$data[0]['weightTime']  =date("Y-m-d",$data[0]['weightTime']);
			$data[0]['targetTime']  =date("Y-m-d",$data[0]['targetTime']);
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

		protected function countUserExercise(){
			/* 获取所有的用户健身数据 */
			/* 统计前一天 */
			/* 额外可初始化数据 */
			/* 时间区间组合块 */
			/* 数据分类统计写入库 */
			static $_init = true;
			$startTime    = $endTime = $dateString = null;
			$data         = $result  = array();
			$startTime    = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
			$endTime      = mktime(23, 59, 59, date("m"), date("d")-1, date("Y"));
			$dateString   = $_init==false ? " where date>='".$startTime."' and date<='".$endTime."'" : '';
			$getUserLogSql= "select * from ai_user_course_list {$dateString}";
			$data         = M('')->query($getUserLogSql);
			foreach ($data as $key => &$value) {
				$value['loginfo']=unserialize($value['loginfo']);
				$result[$value['date']][$value['uid']]['group'][$value['group']]=$value['loginfo']['weight'] * $value['loginfo']['nums'];
				$result[$value['date']][$value['uid']]['uid']		=$value['uid'];
				$result[$value['date']][$value['uid']]['date']		=$value['date'];
				$result[$value['date']][$value['uid']]['aid']		=$value['aid'];
			}
			foreach ($result as $date => $uidinfo) {
				foreach ($uidinfo as $uid => &$value) {
					foreach ($value['group'] as $val) {
						$result[$date][$uid]['exercise']+=$val;
					}
					unset($result[$date][$uid]['group']);
				}
			}
			$checkData=$checkSql=$insertSql=$updateSql=null;
			foreach ($result as $key => $value) {
				foreach ($value as $k => $v) {
					$uid     =$v['uid'];
					$aid     =$v['aid'];
					$date    =$v['date'];
					$exercise=$v['exercise'];
					$checkSql="select * from `ai_user_exercise_log` where `uid`='".$uid."' and `aid`='".$aid."' and `date`='".$date."'";
					$checkData=M('')->query($checkSql);
					if(!empty($checkData)){
						$updateSql="UPDATE `ai_user_exercise_log` SET  `exercise` =  '".$exercise."',`create_time` =  '".time()."' WHERE `uid` =  '".$uid."' and `aid` =  '".$aid."' and `date` =  '".$date."'";
						M('')->query($updateSql);
					}else{
						$insertSql ="INSERT INTO `ai_user_exercise_log` (`id` ,`uid` ,`aid` ,`date` ,`exercise` ,`create_time`)VALUES (NULL ,  '".$uid."',  '".$aid."',  '".$date."',  '".$exercise."',  '".time()."')";
						M('')->query($insertSql);	
					}
				}
			}
		}
		protected function getUserRank($dateType=null,$aid=null,$isAll=false){
			$dateString=$startTime=$endTime=$where=null;
			if(!empty($dateType)){
				$startTime    = date('Ymd',mktime(0, 0, 0, date("m"), date("d")-$dateType, date("Y")));
				$endTime      = date('Ymd',time());
				$where 		  = " WHERE date>='".$startTime."' and date<='".$endTime."'";
			}else{
				$where 		  = " WHERE date='".date('Ymd',time())."'";
			}
			if(!empty($aid)){
				$where=$where." and aid='".$aid."'";
			}
			if($isAll==true&&empty($aid)){$where=null;}
			if($isAll==true&&!empty($aid)){$where="where aid=$aid";}
			$getSql="SELECT SUM(  `exercise` ) AS exercise, uid FROM ai_user_exercise_log $where GROUP BY uid ORDER BY exercise DESC limit 10";
			$data=M('')->query($getSql);
			foreach ($data as $key => &$value) {
				$value['userFace']=getUserFace($value['uid'],'m');
				$value['userName']=getUserName($value['uid']);

			}
			return $data;
		}
		protected function getUserRankById($uid,$dateType=null,$aid=null,$isAll=false){
			$dateString=$startTime=$endTime=$where=null;
			if(!$uid) return false;
			if(!empty($dateType)){
				$startTime    = date('Ymd',mktime(0, 0, 0, date("m"), date("d")-$dateType, date("Y")));
				$endTime      = date('Ymd',time());
				$where 		  = " WHERE date>='".$startTime."' and date<='".$endTime."'";
			}else{
				$where 		  = " WHERE date='".date('Ymd',time())."'";
			}
			if(!empty($aid)){
				$where=$where." and aid='".$aid."'";
			}

			if($isAll==true){$where=null;}
			$tmpTable="SELECT SUM(  `exercise` ) AS exercise, uid,date FROM ai_user_exercise_log  $where GROUP BY uid ORDER BY exercise";
			if(!empty($where)){
				$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  $where and uid=$uid GROUP BY uid ORDER BY exercise";
			}elseif(!empty($aid)){
				$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  where uid=$uid and aid=$aid GROUP BY uid ORDER BY exercise";
			}else{
				$tmpUTable="SELECT SUM(  `exercise` ) AS exercise FROM ai_user_exercise_log  where uid=$uid GROUP BY uid ORDER BY exercise";				
			}

			$getRankSql="select count(*) as num from ($tmpTable) as tmp where tmp.exercise >= ($tmpUTable)";
			$data=M('')->query($getRankSql);
			if($data[0]['num']==0){
				$checkSql="select * from ai_user_exercise_log where uid=$uid and date='".date('Ymd',time())."'";
				$check=M('')->query($checkSql);
				if(empty($check)) return 0;
			}
			return $data[0]['num']>0 ? intval($data[0]['num']):1;
		}
	}
	?>