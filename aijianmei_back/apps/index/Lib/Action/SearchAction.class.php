<?php
class SearchAction extends Action {
    public function dosearch()
    {
		$nums=10;
		$keyword=addslashes($_GET['skword']);
		if($_GET['pg']>0){
			$pg=intval($_GET['pg']);
		}else{
			$pg=1;
		}
		//分类搜索结果
		$cateSql="select id from ai_article_category where name like '%".$keyword."%'";
		//文章
		$arlSql="select id,title,brief,create_time,img,reader_count as click,1 from ai_article where category_id in (".$cateSql.") or keyword like '%".$keyword."%' or title like '%".$keyword."%'";
		//视频
		$videoSql="select id,title,brief,create_time,link AS img,click,2 from ai_video where category_id in (".$cateSql.") or keyword like '%".$keyword."%' or title like '%".$keyword."%'";
		//天天锻炼
		$dailySql="select a.id,a.title,a.content as brief,a.create_time,b.link as img,read_count as click,4 from ai_daily a left join ai_daily_video b on a.id=b.daily_id where a.keyword like '%".$keyword."%' or a.title like '%".$keyword."%'";
		
		$allsql="select count(*) as cnums from ($arlSql union all $videoSql union all $dailySql) as t";
		$countinfo=$this->getDataCache(md5($allsql));
		if(!$countinfo){
			$countinfo=M('')->query($allsql);
			$this->setDataCache(md5($allsql),$countinfo);
		}
		$limitsql="select * from ($arlSql union all $videoSql union all $dailySql) as t order by create_time desc limit ".($pg-1)*$nums.",$nums";
		$searchInfo=$this->getDataCache(md5($limitsql));
		if(!$searchInfo){
			$searchInfo=M('')->query($limitsql);
			foreach($searchInfo as $key => $value){
				$searchInfo[$key]['commentCount']=$this->getCountCommentsByType($value['id'],$value['1']);
				if($value['1']>1){
					$searchInfo[$key]['img']=$this->getVideoDataImg($value['img']);
				}
				else
				{	
					if($value['img']!=''){
						$searchInfo[$key]['img']='/public/images/article/'.$value['img'];
					}
				}
				if($value['1']==1){
					$searchInfo[$key]['url']='/index-Index-articleDetail-'.$value['id'].'.html';
					$searchInfo[$key]['shareurl']='http://www.aijianmei.com/index-Index-articleDetail-'.$value['id'].'.html';
				}
				if($value['1']==2){
					$getCsql="select link,htmlurl from ai_video where id='".$value['id']."'";
					$channelinfo=M('')->query($getCsql);
					$searchInfo[$key]['url']='/index-Train-videoDetail-'.$value['id'].'.html';
					$searchInfo[$key]['shareurl']=($channelinfo[0]['htmlurl']!='')?$channelinfo[0]['htmlurl']:$channelinfo[0]['link'];
				}
				if($value['1']==4){
					$getCsql="select a.channel,a.img,b.link,b.htmlurl from ai_daily a left join ai_daily_video b on a.id=b.daily_id where a.id='".$value['id']."'";
					$channelinfo=M('')->query($getCsql);
					$searchInfo[$key]['url']='/index-Index-daily-'.$value['id'].'-'.$channelinfo[0]['channel'].'.html';
					$searchInfo[$key]['shareurl']=($channelinfo[0]['htmlurl']!='')?$channelinfo[0]['htmlurl']:$channelinfo[0]['link'];
					if($channelinfo[0]['img']!=''&&$channelinfo[0]['link']=='null'){
						$searchInfo[$key]['img']='/public/images/article/'.$channelinfo[0]['img'];
					}
				}
			}
			$this->setDataCache(md5($limitsql),$searchInfo);
		}
		//print_r($searchInfo);
		$pageArr=$this->pageHtml($countinfo[0]['cnums'],$nums,$pg,'search_'.$keyword.'_l','.html');
		$this->assign('searchpage', $pageArr['html']);
		$this->assign('cnums', $countinfo[0]['cnums']);
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		
		foreach ($keywordInfo as $key=>$value) {
			foreach ($value as $k=>$v) {
				foreach ($v as $k1=>$v1) {
					if(!in_array($v1,$keywordInfoTmp[$k])&&$k!=''){
						$keywordInfoTmp[$k][]=$v1;
					}
				} 
			} 
		}
		$this->assign('_KeyWordList',$keywordInfoTmp);

		$this->assign('cssFile', 'training');
		$this->assign('searchInfo', $searchInfo);
		$this->assign('keyword', $keyword);
		$this->display('search');
	}
	public function goodcomment()
	{
		if($_GET['pg']>0){
			$pg=intval($_GET['pg']);
		}else{
			$pg=1;
		}
		$nums=10;
		$countcomSql="select count(*) as cnums from ai_comments where ingood=1";
		$countcomArr=M('')->query($countcomSql);
		$count=$countcomArr?$countcomArr[0]['cnums']:0;
		$pageArr=$this->pageHtml($count,$nums,$pg,'goodcomment_','.html');
		$comSql="select * from ai_comments where ingood=1 order by create_time desc limit ".($pg-1)*$nums.",$nums";
		$comlists=$this->getDataCache(md5($comSql));
		if(!$comlists){
			$comlists=M('')->query($comSql);
			foreach($comlists as $key=>$value){
			switch($value['parent_type']){
				case 1:
					$sql=$titleinfo=$title=null;
					$sql="select title from ai_article where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
					$comlists[$key]['tourl']="/index-Index-articleDetail-".$value['parent_id'].".html";
				break;
				case 2:
					$sql=$titleinfo=$title=null;
					$sql="select title from ai_video where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
					$comlists[$key]['tourl']="/index-Train-videoDetail-".$value['parent_id'].".html";
				break;			
				case 4:
					$sql=$titleinfo=$title=null;
					$sql="select title,channel from ai_daily where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
					$comlists[$key]['tourl']='/index-Index-daily-'.$value['parent_id'].'-'.$titleinfo[0]['channel'].'.html';
				break;			
			}
			$comlists[$key]['userSname']=getUserName($value['uid'],'zh',12);
			$comlists[$key]['userLname']=getUserName($value['uid']); 			
			$comlists[$key]['userimg']=getUserFace($value['uid'],'s');
			}
			$this->setDataCache(md5($comSql),$comlists);
		}

		$this->assign('comlistspage', $pageArr['html']);
		$this->assign('comlists', $comlists);
		
		$keywordInfo=unserialize(include_once("PublicCache/keywordInfo.php"));
		$this->assign('_CommentList',unserialize(include_once("PublicCache/CommentListCache.php")));
		$searchKeyword=array_merge($keywordInfo['train'],$keywordInfo['plan'],$keywordInfo['nutri'],$keywordInfo['append'],$keywordInfo['lifestyle']);

		foreach ($keywordInfo as $key=>$value) {
			foreach ($value as $k=>$v) {
				foreach ($v as $k1=>$v1) {
					if(!in_array($v1,$keywordInfoTmp[$k])&&$k!=''){
						$keywordInfoTmp[$k][]=$v1;
					}
				} 
			} 
		}
		$this->assign('_KeyWordList',$keywordInfoTmp);
		$this->assign('cssFile', 'training');
		$this->display('goodcomment');
	}
	
	public function pageHtml($count,$nums,$pg=null,$surl=null,$eurl=null)
	{
		$pager=null;
		$listnum=ceil($count/$nums);
		if($pg==1||!$pg){
			$pre='<a>上一页</a>';
		}else
		{
			$pre='<a href="'.$surl.($pg-1).$eurl.'">上一页</a>';
		}
		if($pg==$listnum){
			$next='<a>下一页</a>';
		}else
		{
			$next='<a href="'.$surl.($pg-1).$eurl.'">下一页</a>';
		}
		for($i=1;$i<=$listnum;$i++){
			if($i==$pg){
				$cuCss='class="pg_current_page"';
			}else{
				$cuCss='';
			}
			if(!$pg){
				if($i==1){
					$cuCss='class="pg_current_page"';
				}
			}
			$pageArr[$i]='<a '.$cuCss.' href="'.$surl.$i.$eurl.'">'.$i.'</a>';
		}
		if($listnum>10){
			if($pg>5&&($listnum-$pg)>=5){
				$snum=$pg-5;
				$enum=$pg+5;
			}
			if($pg<5&&($listnum-$pg)>5){
				$snum=1;
				$enum=10;
			}
			if($pg>5&&($listnum-$pg)<5){
				$snum=$pg-5-(5-($listnum-$pg))+1;
				$enum=$listnum;
			}
			if($pg==5){
				$snum=1;
				$enum=10;
			}
			foreach($pageArr as $k=>$v)
			{
				if($k<$snum||$k>$enum){
					unset($pageArr[$k]);
				}else{
					$pagehtml.=$v;
				}
			}
		}else{

			foreach($pageArr as $k =>$v)
			{
				$pagehtml.=$v;
			}
		}
		
		$html['backstr']=$pre;
		$html['nextstr']=$next;
		$html['thestr']=$pagehtml;
		return array('html'=>$html);
	}
	
	protected function getCountCommentsByType($id,$type)
    {
        $sql = "select count(*) as nums from ai_comments where parent_type=$type and parent_id=".$id;
		//$sql = "select * from ai_video_comments where pid=".$id;
        $result = M('')->query($sql);
		return !empty($result[0]['nums'])?$result[0]['nums']:0;
    }
	protected function getVideoDataImg($link)
	{
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
		
		$data = json_decode($json);
		return $data->data[0]->logo;
	}
	
}
?>
