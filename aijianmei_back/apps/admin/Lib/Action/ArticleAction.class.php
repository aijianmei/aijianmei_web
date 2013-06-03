<?php 
class ArticleAction extends AdministratorAction {
	public function bulkImport(){
		//替换数组 转化为对应标识
		$channelArr=array(
			'上班族健身'=>'1',
			'日常健身'=>'2',
			'专业运动员'=>'3',
			'健美运动员'=>'4',);
		$action=$_POST['action'];
		$path='exceluploadlist/';
		//$path='/data/home/htdocs/exceluploadlist/';
		if(!empty($action)&&$action=='UploadExcelFile')
		{
			$UFileName=$_FILES['UploadFile']['name'];
			$FilePre_arr=explode(".",$UFileName);
			$FilePre=$FilePre_arr[1];
			if($_FILES['UploadFile']['tmp_name'])
			{
				$Tmp_FileName=$path.$_FILES['UploadFile']['name'];
				if(move_uploaded_file($_FILES['UploadFile']['tmp_name'],$Tmp_FileName))
				{
					$error_string='上传成功!\\n';
					//$Tmp_FileName='test.xls';
					$exceldata=$this->ReadExcelInfo($Tmp_FileName,2);
					$is_pass=0;
					//$exceldata[2][3]=strtotime($exceldata[2][3]);
					//print_r($exceldata);exit;
					if($is_pass!=1)
					{
						$succcount=0;
						foreach($exceldata as $key => $value)
						{
							//sleep(1);
							$insertdata['uid'] = $this->mid;
							$insertdata['title'] = t($value[0]);
							$insertdata['channel'] = intval($channelArr[$value[1]]);
							$insertdata['content'] = t($value[4]);
							$insertdata['keyword'] = t($value[5]);
							//$data['videos']  = t($_POST['videos']);
							$insertdata['create_time'] = time();
							$insertdata['gotime'] = strtotime($value[3]);
							$insertdata['img']=null;
							$newfilename=null;
							$newfilename=$value[2];
							$insertdata['img'] = $newfilename;
							$vid = M('daily')->add($insertdata);
							//print_r($insertdata);
							if($vid>0){$succcount++;}
							/*video part start*/
							$vdata=null;
							$vdata['daily_id'] = $vid;
							$vdata['link'] = $value[6];
							$vdata['htmlurl'] = $value[7];
							$vdata['wapurl'] = $value[8];
							$vdata['title'] = $value[9];
							$vdata['intro'] = $value[10];
							$vdata['create_time'] = time();
							M('daily_video')->add($vdata);
							/*video part end*/
						}
					}
				}
				else
				{
					$error_string='上传失败!\\n';
				}	
			}
		
		}
		$this->assign('succcount', $succcount);
		$list=$this->listDir($path);
		$listRes=array();
		foreach($list as $k=>$v){
			if($v){
			$listRes[$k]['name']=$v;
			$listRes[$k]['ctime']=date("Y-m-d",filectime($path.$v));
			$listRes[$k]['url']=$path.$v;
			}
		}
		$this->assign('listRes', $listRes);
		$this->display();
	}


    public function add()
    {
        if(isset($_POST['title'])) {
            $data['id']       = intval($_POST['aid']);
            $data['uid']      = $this->mid;
            $data['title']    = t($_POST['title']);
            $data['category_id'] = intval($_POST['category']);
            $data['source']   = t($_POST['source']);
            $data['brief']    = t($_POST['brief']);
            $data['author']   = t($_POST['author']);
            $data['content']  = t($_POST['content']);
            $data['keyword']  = t($_POST['keyword']);			
            $data['create_time'] = time();
            $data['iswaterimg']  = t($_POST['iswaterimg']);
            
            
            //print_r($_POST);exit;
            if(isset($_FILES['img']['name'])) {
                if(!move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/public/images/article/'.$_FILES['img']['name'])) 				{
                    echo 'add error '.'<br />';					
                }
                //$waterImage='water.png';
                //$this->imageWaterMark($_SERVER['DOCUMENT_ROOT'].'/public/images/article/'.$_FILES['img']['name'],9,$waterImage);
                $data['img'] = $_FILES['img']['name'];
            }
            if (!empty($data['title']) &&
                !empty($data['category_id']) &&
                !empty($data['content'])) {
                
                if ( $data['id'] > 0 ) {
                    unset($data['create_time']);
                    unset($data['uid']);
                    M('article')->save($data);
                }else {
                    M('article')->add($data);
                }
                $insertId=M('article')->getLastInsID();
                if(!empty($_POST['morecategory'])){
                    foreach($_POST['morecategory'] as $key => $value){
                       D('Article')->addArticeGroup($insertId,$value);
                    }
                }  
                echo '<script>alert("success")</script>';		
                //$this->redirect('/index.php?app=admin&mod=Article&act=borswe');
            }
            
            
        }
        $cate = $this->getCategories();
        $this->assign('categories', $cate);
        $this->display();
    }
    
    public function edit()
    {
        $id = intval($_GET['id']);
        if($id == 0) die(0);
        $article = M('article')->where(array('id'=>$id))->select();
        $this->assign('article', $article[0]);
        $cate = $this->getCategories();
        $articleGroup=D('Article')->getArticeGroup($id,$article[0]['category_id']);
        $this->assign('articleGroup', $articleGroup);
        $this->assign('categories', $cate);
        $this->assign('type', 'edit');
        $this->display('edit');
    }
    
    public function doEdit()
    {
        $img = $_POST['img'];
        if(isset($_POST['id'])) {
            //$data['uid']      = $this->mid;
            $id               = t($_POST['id']);
            $data['title']    = t($_POST['title']);
            $data['category_id'] = intval($_POST['category']);
            $data['source']   = t($_POST['source']);
            $data['brief']    = t($_POST['brief']);
            $data['author']   = t($_POST['author']);
            $data['content']  = t($_POST['content']);
            $data['keyword']  = t($_POST['keyword']);
            $data['update_time'] = time();
            //$data['create_time'] = time();
                
        
            if( $_FILES['img']['name']!= NULL) {
                if(!move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/public/images/article/'.$_FILES['img']['name'])) {
                    echo 'picture upload failed '.'<br />';					
                }
                $data['img'] = $_FILES['img']['name'];
            }
                
            if (!empty($data['title']) &&
                    !empty($data['category_id']) &&
                    !empty($data['content'])) {
                M('article')->where(array('id'=>$id))->save($data);
                if(!empty($_POST['morecategory'])){
                    D('Article')->cleanArticeGroup($id);
                    foreach($_POST['morecategory'] as $key => $value){
                       D('Article')->insertArticeGroup($id,$value);
                    }
                }   
                echo '<script>alert("success")</script>';
                //$this->redirect('/index.php?app=admin&mod=Article&act=borswe');
            }			
        }
        /*echo $data['title']."<br>";
        echo $data['category_id']."<br>";
        echo $data['content']."<br>";	
        echo '<script>alert("success? or not failure")</script>';*/
    }
    
    public function broswe()
    {	
        $o = $_GET['o'];
        if($o=='promote') {
            $is_promote = M('article')->field('is_promote')->where(array('id'=>$_GET['id']))->find();
            $data['id'] = $_GET['id'];
            $data['is_promote'] = $is_promote['is_promote']==0 ? 1 : 0;			

            M('')->query('update ai_article set is_promote='.$data['is_promote'].' where id='.$data['id']);
        }
		$articles = D('Article')->getArticles();
        $this->assign('article', $articles);
        $this->display();
    }
    
    public function addCategory()
    {
        if(isset($_POST['name'])) {
            $data['id'] = intval($_POST['cate_id']);
            $data['name'] = t($_POST['name']);
            $data['parent'] = intval($_POST['parent'])==0 ? NULL : intval($_POST['parent']);
            $data['channel'] = intval($_POST['channel']);
            $data['type'] = intval($_POST['content']);
            //print_r($data);
            if($data['id']>0) {
                M('article_category')->save($data);
            }else {
                if (!empty($data['name'])) M('article_category')->add($data);
            }
            
        }
        $cate = $this->getCategories();
        $this->assign('categories', $cate);
        
        $cate_id = intval($_GET['id']);
        $name = M('article_category')->where(array('id'=>$cate_id))->find();
        $this->assign('cate_id', $cate_id);
        $this->assign('name', $name['name']);
        if ($cate_id>0) $this->assign('type', 'edit');
        $this->display();
    }
    
    public function category()
    {
        $cate = $this->getCategories();
        $this->assign('categories', $cate);
        $this->display();
    }
	public function comment()
    {
		$comType=array(
			'1'=>'文章',
			'2'=>'锻炼视频',
			'3'=>'评论回复',
			'4'=>'天天锻炼',
		);
		$this->assign('_comType', $comType);
		$nums=25;
		$action=$_GET['comact']?$_GET['comact']:'';
		if($action=='ingood'){
			$cid=$_GET['cid']?intval($_GET['cid']):die();
			if($cid>0)
			{
				$upsql="UPDATE  ai_comments SET  ingood =  '1' WHERE  id=$cid";
				M('')->query($upsql);
				$this->setCommentListCache();
			}
		}
		if($action=='degood'){
			$cid=$_GET['cid']?intval($_GET['cid']):die();
			if($cid>0)
			{
				$upsql="UPDATE  ai_comments SET  ingood =  '0' WHERE  id=$cid";
				M('')->query($upsql);
				$this->setCommentListCache();
			}
		}
		$type=$_GET['type']?$_GET['type']:1;
		$sql="select * from ai_comments where parent_type='".$type."'";
		$comlistscount=M('')->query($sql);
		$pager = api('Pager');
        $pager->setCounts(count($comlistscount));
        $pager->setList($nums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;
		$sql="select * from ai_comments where parent_type='".$type."' order by id desc limit $from,$nums";
		$comlists=M('')->query($sql);		
        $pagerArray = (array)$pager;
		$res=M('')->query($sql);
		//print_r($comlists);
        $this->assign('comlists', $comlists);
		$this->assign('type', $type);
		$this->assign('pager', $pagerArray);
        $this->display('comment');
    }
	public function setCommentListCache(){
		$filename='CommentListCache';
		$data=null;
		$comSql="select * from ai_comments where ingood=1 order by create_time desc limit 10";
		$comlists=M('')->query($comSql);
		foreach($comlists as $key=>$value){
			switch($value['parent_type']){
				case 1:
					$sql=$titleinfo=$title=null;
					$sql="select title from ai_article where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
				break;
				case 2:
					$sql=$titleinfo=$title=null;
					$sql="select title from ai_video where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
				break;			
				case 4:
					$sql=$titleinfo=$title=null;
					$sql="select title from ai_daily where id='".$value['parent_id']."'";
					$titleinfo=M('')->query($sql);
					$title=$titleinfo[0]['title'];
					$comlists[$key]['comtotitle']=$title;
				break;			
			}
			$comlists[$key]['userSname']=getUserName($value['uid'],'zh',12);
			$comlists[$key]['userLname']=getUserName($value['uid']); 			
			$comlists[$key]['userimg']=getUserFace($value['uid'],'s');
		}
		file_put_contents("PublicCache/$filename.php","<?php\n\r return '".serialize($comlists)."';");	
	}
	
	
	
	public function doDeletecomment()
    {
        if( empty($_POST['ids']) ) {
            echo 0;
            exit ;
        }
        $map['id'] = array('in', t($_POST['ids']));
        echo M('comments')->where($map)->delete() ? '1' : '0';
        //$this->delete('article_category');
    }
    public function doDeleteCate()
    {
        $this->delete('article_category');
    }
    
    public function doDeleteArticle()
    {
        $this->delete('article');
    }
    
    public function addVideo()
    {
        if(isset($_POST['title'])) {
            $data['id'] = intval($_POST['vid']);
            $data['uid'] = $this->mid;
            $data['title'] = t($_POST['title']);
            $data['category_id'] = intval($_POST['category']);
            $data['link'] = t($_POST['source']);
			$data['htmlurl'] = t($_POST['htmlurl']);
			$data['wapurl'] = t($_POST['wapurl']);
            $data['brief'] = t($_POST['brief']);
			$data['keyword'] = t($_POST['keyword']);
            $data['create_time'] = time();
            if(!empty($data['link']) &&
               !empty($data['title'])) {
                
                if($data['id']>0) {
                    unset($data['create_time']);
                    unset($data['uid']);
                    M('video')->save($data);
					//redirect(U('index/User/loginUserInfo'));
					redirect('/index.php?app=admin&mod=Article&act=editVideo&id='.$data['id']);
                }else {
                    M('video')->add($data);
					redirect('/index.php?app=admin&mod=Article&act=video');
                }
                
                //$this->redirect('/index.php?app=admin&mod=Article&act=editVideo&id=19');
            }
        }
        $id = intval($_GET['id']);
        //if ($id>0) $this->assign('type', 'edit');
        $cate = $this->getCategories();
        $this->assign('categories', $cate);
        $this->display();
    }
    
    public function editVideo()
    {
        $id = intval($_GET['id']);
        
        if($id<=0) exit(0);
        $video = M('video')->where(array('id'=>$id))->find();
        $this->assign('video', $video);
        //print_r($video);
        $this->assign('type', 'edit');
        $cate = $this->getCategories();
        $this->assign('categories', $cate);
        $this->display('addVideo');
    }
    
    public function video()
    {
        $videos = D('Article')->getVideos();
        $this->assign('videos', $videos);
        $this->display();
    }
    
    public function doDeleteVideo()
    {
        if( empty($_POST['ids']) ) {
            echo 0;
            exit ;
        }
        $map['id'] = array('in', t($_POST['ids']));
        echo M('video')->where($map)->delete() ? '1' : '0';
    }
    
    public function addDaily()
    {
        if(isset($_POST['title'])) {
            $data['id'] = intval($_POST['aid']);
            $data['uid'] = $this->mid;
            $data['title'] = t($_POST['title']);
            $data['channel'] = intval($_POST['channel']);
            $data['content'] = t($_POST['content']);
			$data['keyword'] = t($_POST['keyword']);
            //$data['videos']  = t($_POST['videos']);
            $data['create_time'] = time();
			$data['gotime'] = strtotime($_POST['gotime']);
            if(isset($_FILES['img']['name'])) {
				$newfilename=$_SERVER['DOCUMENT_ROOT'].'/public/images/article/'.$_FILES['img']['name'];
                @move_uploaded_file($_FILES['img']['tmp_name'], $newfilename);
                $data['img'] = $_FILES['img']['name'];
            }
            
            if(!empty($data['title']) && !empty($data['content'])) {
                if($data['id']>0) {
                    unset($data['uid']);
                    unset($data['create_time']);
                    M('daily')->save($data);
                    $vid = $data['id'];
                }else {
                    $vid = M('daily')->add($data);
                }
                $videos = $_POST['videos'];
				$htmlurl= $_POST['htmlurl'];
				$wapurl = $_POST['wapurl'];
                $titles = $_POST['v_title'];
                $intros = $_POST['v_intro'];
                if(is_array($videos) && is_array($titles) && is_array($intros)) {
                    $length = min(array(count($videos), count($titles), count($intros)));
                    for($i=0;$i<=$length;$i++) {
                        if($videos[$i]!=''){
                        $vdata['daily_id'] = $vid;
                        $vdata['link'] = $videos[$i];
						$vdata['htmlurl'] = $htmlurl[$i];
						$vdata['wapurl'] = $wapurl[$i];
                        $vdata['title'] = $titles[$i];
                        $vdata['intro'] = $intros[$i];
                        $vdata['create_time'] = time();
                        M('daily_video')->add($vdata);
                        }
                    }
                }
                
                echo '<script>alert("success")</script>';
            }			
        }
        $this->display();
    }
    
    public function editDaily()
    {
        $id = intval($_GET['id']);
        $article = M('daily')->where(array('id'=>$id))->find();
        $videos = M('daily_video')->where(array('daily_id'=>$id))->findAll();
		$article['gotime']=date("Y-m-d",$article['gotime']);
        $this->assign('article', $article);
        $this->assign('video', $videos);
        $this->assign('type', 'edit');
        $this->display('addDaily');
    }
    
    public function deleteDailyVideo()
    {
        $vid = intval($_REQUEST['vid']);
        M('daily_video')->where(array('id'=>$vid))->delete();
    }
    
    public function daily()
    {
        $daily = M('daily')->order('create_time desc')->findAll();
		foreach($daily as $k=>$value){
			$daily[$k]['create_time']=date("Y-m-d",$value['create_time']);
			$daily[$k]['gotime']=$value['gotime']!=null?date("Y-m-d",$value['gotime']):'未填写';
		}
        $this->assign('daily', $daily);
        $this->display();
    }
    
    public function doDeleteDaily()
    {
        $this->delete('daily');
    }
    
    public function addPromote()
    {
        $id = $_GET['id'];
        if($id) {
            $promote = M('promote')->where(array('id'=>$id))->find();
            $this->assign('promote', $promote);
            $this->assign('type', 'edit');
        }
        
        if ($_POST['link'] != '') {
            if($_FILES['image']['name'] != '') {
                @move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$_FILES['image']['name']);
                $data['image'] = $_FILES['image']['name'];
            }
            $data['link'] = $_POST['link'];
            
            M('promote')->add($data);
        }
        
        $this->display();
    }
    
    public function promote()
    {
        $promotion = M('promote')->findAll();
        $this->assign('promotion', $promotion);
        $this->display();
    }
    
    public function addMuscle()
    {
        $this->display();
    }
    
    public function muscle()
    {
        $this->display();
    }
    
    protected function getCategories()
    {
        $category = M('article_category')->findAll();
        return $category;
    }
    
    protected function delete($table)
    {
        if (!isset($_POST['ids'])) {
            echo '0';
            exit;
        }
        
        $map['id'] = array('in', t($_POST['ids']));
        echo M($table)->where($map)->delete() ? '1' : '0';
    }
   
/*
 * 读取Excel 数据方法类
 * author kontem at 20130504
 * @param string $FilePath     文件路径
 * @param string $StartLine    起始行数
 * @param string $EndLine      结束行数
 * @return array               Data 多维数组
 */
function ReadExcelInfo($FilePath,$StartLine=0,$EndLine=0)
{
	require_once 'libpack/PHPExcel/PHPExcel/IOFactory.php';
	$objPHPExcel = PHPExcel_IOFactory::load($FilePath);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$StartLine=!empty($StartLine)?$StartLine:0;
	
	$k=1;
	foreach ($objWorksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		$cellIterator->setIterateOnlyExistingCells(true);
		$plainText=null;
		foreach ($cellIterator as $cell) {
			$plainText = ($cell->getValue() instanceof PHPExcel_RichText) ?$cell->getValue()->getPlainText() : $cell->getValue();
			if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){   
				$cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();   
				$formatcode=$cellstyleformat->getFormatCode();   
				if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)) {   
					$plainText=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($plainText));   
					}else{   
					$plainText=PHPExcel_Style_NumberFormat::toFormattedString($plainText,$formatcode);   
				}
			}
			$data[$k][]=$plainText;
		}
		$k++;
	}
	if($EndLine<0){$EndLine=$k+$EndLine;}
	foreach($data as $key=>$value)
	{
		if($key < $StartLine){unset($data[$key]);}
		if($key > $EndLine&&$EndLine!=0){unset($data[$key]);}
	}
	return $data;
}
	function listDir($dir)
	{
		global $resdir;
	    if(is_dir($dir))
	    {
	        if ($dh = opendir($dir))
	        {
	            while (($file = readdir($dh)) !== false)
	            {
	                if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
	                {
	                     //$this->listDir($dir."/".$file."/");
	                }
	                else
	                {
	                    if($file!="." && $file!="..")
	                    {
							
	                        if(!in_array($file,$resdir)) $resdir[]=$file;
	                    }
	                }
	            }
	            closedir($dh);
	        }
	    }
		return $resdir;
	}
}
?>