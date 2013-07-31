<?php
class PublicAction extends Action {
    public function Transit()
    {
		//U('index/Index/index')
		$jumpUrl=$_SESSION['regrefer_url'];
		$show_msg=$_SESSION['regrefer_msg'];
		//unset($_SESSION['regrefer_url']);
		//unset($_SESSION['regrefer_msg']);
		$waitSecond=3;
		$this->assign('show_msg',$show_msg);
		$this->assign('waitSecond',$waitSecond);
		$this->assign('jumpUrl',$jumpUrl);
		$this->assign('cssFile','index');
		$this->display('layer');
		//$this->display('success');
	}
	public function articleDetail()
  {	
  	$pagenums=7;
  	$string="update ai_article set reader_count=reader_count+1 where id=".$_GET['id'];
  	M('')->query($string);
  	global $ts;
  	$id = (int) $_GET['id'];
  	$map['id'] = $id;
  	$article = M('article')->where($map)->find();
		preg_match_all("/src\s*=\s*[\"|\']?\s*([^\"\'\s]*)/i",str_ireplace("\\","",$article['content']),$out);
		$aimgsrc=$out[1][0];
		$article['dateStrng']=_returnNdate($article['create_time']);
		$this->assign('article', $article); 
		$this->assign('aimgsrc', $aimgsrc); 
		$commentCounts = M('comments')->where(array('parent_id'=>$id, 'parent_type'=>'1'))->count();

		$pg=$_GET['pg']?$_GET['pg']:1;

		$pagerArray = $this->pageHtml ( $commentCounts, $pagenums,$pg, '/articleDetail-'.$id.'-p%s.html', 'rstr' );
		$this->assign('pager', $pagerArray);
		$from=($pg-1)*$pagenums;
		$sql="select * from ai_comments where parent_id=$id and parent_type=1 order by create_time desc limit $from,$pagenums";
		$result=null;
		$result=M('article')->query($sql);
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
		$this->assign('cssFile', 'article');
		$this->assign('uid', $this->mid);
		$ArticleMenu=$this->getArticleMenu($id);
		$this->assign('ArticleMenu', $ArticleMenu);
    $this->assign('headertitle', $article['title']);
		$this->assign('_act', 1);
		$this->assign('cssFile','training');
    $this->display('newarticle');
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
	public function pageHtml($count,$nums,$pg=null,$url=null)
	{
		$enum=$snum=0;
		$pager=null;
		$pagehtml=null;
		$listnum=ceil($count/$nums);
		if($pg==1||!$pg){
			$pre='<a>上一页</a>';
		}else
		{
			$pre='<a href="'.$url.($pg-1).'">上一页</a>';
			$pre='<a href="'.sprintf($url,$pg-1).'">上一页</a>';
		}
		if($pg==$listnum){
			$next='<a>下一页</a>';
		}else
		{
			$next='<a href="'.$url.($pg+1).'">下一页</a>';
			$next='<a href="'.sprintf($url,$pg+1).'">下一页</a>';
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
			$pageArr[$i]='<a '.$cuCss.' href="'.$url.$i.'">'.$i.'</a>';
			$pageArr[$i]='<a '.$cuCss.' href="'.sprintf($url,$i).'">'.$i.'</a>';
		}
		if($listnum>=10){
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
					//unset($pageArr[$k]);
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
		return $html;
	}    
  public function getArticleMenu($id){
  	if(empty($id)) return false;
  	$sql="select * from ai_article where id=$id";
  	$result=M('')->query($sql);
  	$category_id=$result[0]['category_id'];//所属分类id
  	$psql="select * from ai_article_category where id=$category_id";
  	$presult=M('')->query($psql);

  	if(!empty($presult[0]['parent'])){
  		$getParentsql="select * from ai_article_category where channel='".$presult[0]['channel']."' and  parent IS NULL ";
  		$getParentInfo=M('')->query($getParentsql);
  		if(!empty($getParentInfo)){
  			$res[0]['title']=	$getParentInfo[0]['name'];
  			$res[0]['url']=	$this->getListUrlByChannel($presult[0]['channel'],'','parent');
  			$res[1]['title']=	$presult[0]['name'];
  			$res[1]['url']=	$this->getListUrlByChannel($presult[0]['channel'],$presult[0]['id'],'list');
  		}
  	}else {
  		$res[0]['title']=	$presult[0]['name'];
  		$res[0]['url']=	$this->getListUrlByChannel($presult[0]['channel'],$presult[0]['id'],'list');
  	}
  	return $res;	
  }
  
  function getListUrlByChannel($channel,$id=nul,$type='list'){
  	switch ($channel) {
  		case 2:
  		if($type=='list'){
  			$url="/index.php?app=index&mod=Train&act=articleList&id=$id";
  		}else{
  			$url="/Train.html";
  		}
  		break;
  		case 3:
  		if($type=='list'){
  			$url="/index.php?app=index&mod=Nutri&act=articleList&id=$id";
  		}else{
  			$url="/Nutri.html";
  		}
  		break;
  		case 4:
  		  		if($type=='list'){
  			$url="/index.php?app=index&mod=Append&act=articleList&id=$id";
  		}else{
  			$url="/Append.html";
  		}
  		break;
  		case 5:
  		if($type=='list'){
  			$url="/index.php?app=index&mod=Lifestyle&act=articleList&id=$id";
  		}else{
  			$url="/Lifestyle.html";
  		}
  		break;
  	}
  	return $url; 
  }


}
?>
