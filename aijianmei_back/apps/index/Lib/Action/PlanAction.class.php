<?php
class PlanAction extends Action {
	function show_banner() {
		
		$bannerinfo=unserialize(include('PublicCache/advImgCache.php'));
    $bannerinfo=$bannerinfo['plan'];
    foreach ($bannerinfo['imginfo'] as $key=>$value) {
     	 $bannerinfoTmp[$key]['name']=$value['title'];
     	 $bannerinfoTmp[$key]['img']='../'.$value['img'];
     	 $bannerinfoTmp[$key]['url']=$value['url'];
    } 

    $bannerinfo=$bannerinfoTmp;
		$this->assign ( 'bannerinfo', $bannerinfo );
		// -------END--------
	}
	public function index() {
		$pg = $_GET ['pg'] ? $_GET ['pg'] : 1;
		$this->show_banner();
		$nums = 7;
		/* 基础锻炼视频列表 */
		$sdaily = $this->getDailyVideoList ( 2, $pg, $nums, 'create_time' );
		$this->assign ( 'sdaily', $sdaily ['data'] );
		
		$sdailyPager = $this->pageHtml ( $sdaily ['count'], $nums, $pg, "/plan_c1_%s.html" );
		$this->assign ( 'sdailyPager', $sdailyPager );
		
		/* 运动员视频列表 */
		$mdaily = $this->getDailyVideoList ( 3, $pg, $nums, 'create_time' );
		$this->assign ( 'mdaily', $mdaily ['data'] );
		$mdailyPager = $this->pageHtml ( $mdaily ['count'], $nums, $pg, "/plan_c2_%s.html" );
		$this->assign ( 'mdailyPager', $mdailyPager );
		
		/* 肌肉锻炼视频列表 */
		$bdaily = $this->getDailyVideoList ( 4, $pg, $nums, 'create_time' );
		$this->assign ( 'bdaily', $bdaily ['data'] );
		$bdailyPager = $this->pageHtml ( $bdaily ['count'], $nums, $pg, "/plan_c3_%s.html" );
		$this->assign ( 'bdailyPager', $bdailyPager );
		
		/* 获取特定健身计划列表 */
		$FitnessProgramList = $this->getFitnessProgramList ( $pg, $nums );
		$fPager = $this->pageHtml ( count ( $FitnessProgramList ), $nums, $pg, "/plan_c4_%s.html" );
		$this->assign ( 'FitnessProgramList', $FitnessProgramList );
		$this->assign ( 'fPager', $fPager );
		
		$HotFitnessProgram=$this->getHotFitnessProgram(3);
		$this->assign ( 'HotFitnessProgram', $HotFitnessProgram );
		// var_dump($daily[0]['videolist']);exit;
		$this->assign ( 'headertitle', '健身计划' );
		$this->assign ( '_current', 'plan' );
		$this->assign ( 'cssFile', 'index' );
		$this->display ( 'newdaily' );
	}
	
	public function fitnessProgramDetail(){
		$pagenums=10;
		$id=$_GET['id']?$_GET['id']:0;
		if(!$id>0) die(403);
		
  	$map['id'] = $id;
  	//$article = M('fitness_program')->where($map)->find();
  	$article = M('')->query("select * from ai_fitness_program where id=$id");
  	if($article[0]['parentid']!=0){
  		$pfid=$article[0]['parentid'];
  		$this->assign('pfid', $pfid); 
  		}
  	if(empty($article)) die(403);
		$article[0]['dateStrng']=_returnNdate($article[0]['create_time']);
		$this->assign('article', $article[0]); 
		
		$commentid= $pfid>0 ? $pfid : $id;
		$commentCounts = M('comments')->where(array('parent_id'=>$commentid, 'parent_type'=>'5'))->count();


		$pg=$_GET['pg']?$_GET['pg']:1;

		$pagerArray = $this->pageHtml ( $commentCounts, $pagenums,$pg, '/fpdetail_'.$id.'_%s.html');
		$this->assign('pager', $pagerArray);
		$from=($pg-1)*$pagenums;
		$sql="select * from ai_comments where parent_id=$commentid and parent_type=5 order by create_time desc limit $from,$pagenums";
		$result=null;
		$result=M('')->query($sql);
		foreach($result as $key=> $value){
			//^\#\d{1,}楼\s$

			preg_match_all("/^\#\d{1,}楼\s/",$value['content'],$matches,PREG_SET_ORDER);
      $replyidString=$matches[0][0];
      preg_match_all("/\d{1,}/",$replyidString,$floornums,PREG_SET_ORDER);
      $floornums=$floornums[0][0];
      if($floornums>0){
       $result[$key]['content']=preg_replace('/^\#\d{1,}楼\s/','<a href="#replay'.$floornums.'">#'.$floornums.'楼 </a>',$value['content']);
    	}
			$result[$key]['floor']=$this->getFloor($key,$pg,$pagenums,$commentCounts);
			$result[$key]['user'] = getUserInfo($value['uid']);
		}

		$this->assign('commentCounts', $commentCounts?$commentCounts:0);
		$this->assign('comments', $result);
		
		
		$promoteArticleList=M('')->query("SELECT * FROM ai_article where is_promote=1 ORDER BY RAND() limit 3");
		$promoteArticle=M('')->query("SELECT * FROM ai_article where is_promote=1 ORDER BY RAND() limit 6");
 
		$this->assign('promoteArticleList', $promoteArticleList);
		$this->assign('promote_article', $promoteArticle);
		
		
		$this->assign('cssFile','training');
		$this->display ( 'fitnessProgramDetail' );
	}
	
	  public function getFloor($key,$page,$pnums,$commentCounts){
  	if($page!=1){
  		$start=$commentCounts-$page*$pnums;
  	}else{
  		$start=$commentCounts;		
  	}
  	$floornums=$start-$key;
  	return $floornums;
  } 
	
	
	public function getHotFitnessProgram($nums=3,$order='order by click desc'){
		$sql=$data=null;
		$sql="select * from ai_fitness_program where parentid=0 $order limit $nums";
		$data=M('')->query($sql);
		return $data;
	}
	public function getFitnessProgramList($pg, $nums, $order = null) {
		$data = null;
		$from = ($pg - 1) * $nums;
		$condition = "where parentid=0 ";
		$condition .= ! empty ( $order ) ? " order by $order desc" : '';
		$sql = "select * from ai_fitness_program $condition limit $from,$nums";
		$data = M ( '' )->query ( $sql );
		foreach ( $data as &$value ) {
			$value ['create_time'] = date ( 'Y/m/d', $value ['create_time'] );
			$value ['comments']=$this->getCountNums('ai_comments', "where parent_type=5 and parent_id='".$value['id']."'");
		}
		return $data;
	}
	public function showVideoWindows() {
		// if(empty($_GET['vid'])){
		// $getDailyVideoByIdSql-"select * from ai";
		// }
 		if(empty($_GET['vid'])||empty($_GET['id'])){
 			header('HTTP/1.1 403 Forbidden');
 			exit();
 		}
		$id=$_GET['id']? intval($_GET['id']):0;
		$vid=$_GET['vid']? intval($_GET['vid']):0;
		$videoInfo=$this->getVideoById($id,$vid);
		$videoInfo['turl']="/index-Train-videoDetail-$vid.html";
		$this->assign ( 'videoInfo', $videoInfo );
		
		
		$this->display ( 'videoWindow' );
	}
	
	protected function getVideoById($id,$vid){
		$sql=$data=null;
		$sql="select * from ai_daily_video_list where id=$id";
		$data=M('')->query($sql);
		$getvSql="select title,brief,wapurl from ai_video where id=$vid";
		$vdata=M('')->query($getvSql);
		$result=unserialize($data[0]['content']);
		$result['brief']=$vdata[0]['brief'];
		$result['wapurl']=$vdata[0]['wapurl'];
		$result['wtitle']=$vdata[0]['title'];
		return $result;
	}
	public function getDailyVideoList($channelType, $pg, $nums, $order = null) {
		if (empty ( $channelType ) || empty ( $pg ) || empty ( $nums ))
			return;
		$from = ($pg - 1) * $nums;
		$condition = "where channel={$channelType} and gotime<='" . time () . "'";
		$condition .= ! empty ( $order ) ? " order by $order desc" : '';
		$counts = $this->getCountNums ( 'ai_daily', $condition );
		$dailySql = "select * from ai_daily $condition limit $from,$nums";
		$daily = M ( '' )->query ( $dailySql );
		// ai_daily_video_list
		if (is_array ( $daily )) {
			foreach ( $daily as $key => &$value ) {
				$dailyid = $data = null;
				$dailyid = $value ['id'];
				$sql = "select * from ai_daily_video_list where dailyid=$dailyid";
				$videolist = M ( '' )->query ( $sql );
				$daily [$key] ['videolist'] = $this->videoListSort ( $videolist );
				$daily [$key] ['create_time'] = date ( 'Y.m.d', $daily [$key] ['create_time'] );
				$daily [$key] ['gotime'] = date ( 'Y.m.d', $daily [$key] ['gotime'] );
				if ($daily [$key] ['videolist'] == null)
					unset ( $daily [$key] ['videolist'] );
			}
		}
		return array (
				'data' => $daily,
				'count' => $counts 
		);
	}
	protected function videoListSort($videolist) {
		if (empty ( $videolist ))
			return null;
		$keyName = array (
				1 => 'A',
				2 => 'B',
				3 => 'C',
				4 => 'D' 
		);
		$tmpArr = array ();
		foreach ( $videolist as $key => $value ) {
			$videolist [$key] = unserialize ( $value ['content'] );
			$videolist [$key] ['id'] = $value ['id'];
			$tmpArr [$videolist [$key] ['channel']] [$videolist [$key] ['eq']] = $value ['id'];
		}
		ksort ( $tmpArr ); // [A[1=>7,2=>8],B[1=>9,2=>11]] demo array
		foreach ( $tmpArr as $key => $value ) { // foo a/b/c => 1/2/3 ...如此类推
			foreach ( $value as $k => $v ) { // 重新对应序列数组进行数组重组 实现排序
				foreach ( $videolist as $vk => $val ) {
					if ($v == $val ['id']) { // id值吻合则存入数组
						$videolistResult [$keyName [$key]] [] = $val;
					}
				}
			}
		}
		return $videolistResult;
	}
	protected function getCountNums($table, $condition) {
		if (empty ( $table ))
			return 0;
		$sql = $data = null;
		$sql = "select count(*) as nums from {$table} {$condition}";
		$data = M ( '' )->query ( $sql );
		return $data [0] ['nums'] ? intval ( $data [0] ['nums'] ) : 0;
	}
	public function pageHtml($count, $nums, $pg = null, $url = null) {
		$enum = $snum = 0;
		$pager = null;
		$pagehtml = null;
		$listnum = ceil ( $count / $nums );
		if ($pg == 1 || ! $pg) {
			$pre = '<a>上一页</a>';
		} else {
			$pre = '<a href="' . $url . ($pg - 1) . '">上一页</a>';
			$pre = '<a href="' . sprintf ( $url, $pg - 1 ) . '">上一页</a>';
		}
		if ($pg == $listnum) {
			$next = '<a>下一页</a>';
		} else {
			$next = '<a href="' . $url . ($pg + 1) . '">下一页</a>';
			$next = '<a href="' . sprintf ( $url, $pg + 1 ) . '">下一页</a>';
		}
		for($i = 1; $i <= $listnum; $i ++) {
			if ($i == $pg) {
				$cuCss = 'class="pg_current_page"';
			} else {
				$cuCss = '';
			}
			if (! $pg) {
				if ($i == 1) {
					$cuCss = 'class="pg_current_page"';
				}
			}
			$pageArr [$i] = '<a ' . $cuCss . ' href="' . $url . $i . '">' . $i . '</a>';
			$pageArr [$i] = '<a ' . $cuCss . ' href="' . sprintf ( $url, $i ) . '">' . $i . '</a>';
		}
		if ($listnum > 10) {
			if ($pg > 5 && ($listnum - $pg) >= 5) {
				$snum = $pg - 5;
				$enum = $pg + 5;
			}
			if ($pg < 5 && ($listnum - $pg) > 5) {
				$snum = 1;
				$enum = 10;
			}
			if ($pg > 5 && ($listnum - $pg) < 5) {
				$snum = $pg - 5 - (5 - ($listnum - $pg)) + 1;
				$enum = $listnum;
			}
			if ($pg == 5) {
				$snum = 1;
				$enum = 10;
			}
			foreach ( $pageArr as $k => $v ) {
				if ($k < $snum || $k > $enum) {
					// unset($pageArr[$k]);
				} else {
					$pagehtml .= $v;
				}
			}
		} else {
			
			foreach ( $pageArr as $k => $v ) {
				$pagehtml .= $v;
			}
		}
		$html ['backstr'] = $pre;
		$html ['nextstr'] = $next;
		$html ['thestr'] = $pagehtml;
		return $html;
	}
}
?>
