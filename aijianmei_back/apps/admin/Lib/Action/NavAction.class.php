<?php
class NavAction extends Action {
	
	public function _initialize() {
		$_Menus=array();
		$_Menus[0]='顶部导航';
		$_Menus[1]='底部导航';
		$_Menus[2]='独立页面';
		
		$_MenusStu=array();
		$_MenusStu[0]='关闭';
		$_MenusStu[1]='开启';
		$this->assign('_Menus', $_Menus);
		$this->assign('_MenusStu', $_MenusStu);
		$this->assign('isAdmin', 1);
	}
	public function addvideoList(){
		if($_POST['videoaction']=='addmodulelist'){
			$data=array(
				'name'=>$_POST['name'],
				'type'=>$_POST['type'],
			);
			D('Acom')->InsertOne('nav_module_list',$data);
			redirect(U('admin/Nav/videoListManager'));
		}
		$this->display('addvideoList');
	}
	public function videoListManager(){
		/*
		@todo import to config files
		*/ 
		$moduleType=array(
		'1'=>'视频页面组件',
		//'2'=>'视频页面组件',
		//'3'=>'视频页面组件'
		);
		$moduleList=D('Acom')->getAll('nav_module_list');
		$this->assign('moduleList', $moduleList);
		$this->assign('moduleType', $moduleType);
		$this->display('videoListManager');
	}
	public function editmodule() {
		$id=$_GET['id'];
		if(! $id>0) return ;
		
		$moduleinfo=D('Acom')->getOne('nav_module_content',"where id=$id");
		$type=D('Acom')->getOne('nav_module_list',"where id=".$moduleinfo['moduleid']);
		$contentList=D('Acom')->moduleInit($type['type']);//获取模块默认设置的元素集
		$editHtml=D('Acom')->moduleEditHtml($contentList['fieldList'],unserialize($moduleinfo['content']));
		/*  编辑模块组件 part*/
		if($_POST['vaction']=='editmodules'){
			/* vaction权值判断进行相关组件数据整合插入 */
			D('Acom')->addmodules($contentList,$uploadPath,$id,'edit');
		}
		/* }}}end */
		
		$moduleinfo=D('Acom')->getOne('nav_module_content',"where id=$id");
		$this->assign('addHtml', $editHtml);
		$this->assign('sequence', $moduleinfo['sequence']);
		$this->display('videoListEditContent');
	}
	
	public function videoListContent(){
		/* 定义组件图片存放目录 */
		$uploadPath='navupload/videomodule/';
		/*  
		 * 通过id获取指定组件相关的组合元素
		 * */
		$id=$_GET['id'];
		$type=D('Acom')->getOne('nav_module_list',"where id=$id",'name,type');
		$contentList=D('Acom')->moduleInit($type['type']);//获取模块默认设置的元素集
		$addHtml=D('Acom')->moduleHtml($contentList['fieldList']);//生成对应的html标签 新增页面使用
		
		/*  新增模块组件 part*/
		if($_POST['vaction']=='addmodules'){
			/* vaction权值判断进行相关组件数据整合插入 */
			D('Acom')->addmodules($contentList,$uploadPath,$id);
		}
		/* }}}end */
		/*
		 * 获取ai_nav_module_content 里面存在的
		 *   */
		$moduleList=D('Acom')->getAll('nav_module_content',"where moduleid=$id");
		
		foreach($moduleList as $key => &$value){
			$contentListTmp=$contentList;
			$value['content']=$contentListTmp['styleString'].sprintf($contentListTmp['containerString'],vsprintf($contentListTmp['childconString'],unserialize($value['content'])));
		}

		//$mdata['childconString']=vsprintf($mdata['childconString'],$result);
		$this->assign('fname', $type['name']);
		$this->assign('moduleList', $moduleList);
		$this->assign('addHtml', $addHtml);
		$this->assign('contentList', $contentList);
		$this->display('videoListContent');
	}	
	public function keywordmanager(){
		$modelArr=array(
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);
		$sql=null;
		$sql="select * from ai_nav_keyword_category where status=1 order by model,sequence";
		$allcateinfo=M('')->query($sql);
		foreach ($allcateinfo as &$value) {
		 	 $value['model']=$modelArr[$value['model']];
		}
		$nums=15;
		$type=$_GET['type']?$_GET['type']:1;
		$sql="select * from ai_nav_keyword ";
		$comlistscount=M('')->query($sql);
		$pager = api('Pager');
		$pager->setCounts(count($comlistscount));
		$pager->setList($nums);
		$pager->makePage();
		$from = ($pager->pg -1) * $pager->countlist;
		$pagerArray = (array)$pager;

		$getkeywordSql="select a.id,a.name,a.model,a.sequence,a.status,b.name as categoryid from ai_nav_keyword a left join ai_nav_keyword_category b on a.categoryid=b.id order by a.model limit $from,$nums";

		$keywords=M('')->query($getkeywordSql);
		foreach ($keywords as $key => &$value) {
		 	 // loop through values
		 	 $value['model']=$modelArr[$value['model']]; 
		} 
		$this->assign('allcateinfo', $allcateinfo);
		$this->assign('pager', $pagerArray);
		$this->assign('keywords', $keywords);
		$this->display('keywords');
	}
	public function editkeywords(){
		$modelArr=array(
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);
		$id=$_GET['id'];
		if($_POST['nav_action']=='doedit'){
			$sql="UPDATE  ai_nav_keyword SET name = '".$_POST['name']."',
			sequence  = '".$_POST['sequence']."',model='".$_POST['model']."',status='".$_POST['status']."',
			categoryid ='".$_POST['categoryid']."'
			WHERE  id ='".$_POST['id']."'";
			M('')->query($sql);	
		}
		$sql="select * from ai_nav_keyword where id=$id";
		$keywordinfo=M('')->query($sql);
		$allcateinfo=M('')->query("select * from ai_nav_keyword_category");
		$this->assign('allcateinfo', $allcateinfo);
		$this->assign('modelArr', $modelArr);
		$this->assign('keywordinfo', $keywordinfo[0]);
		$this->display('editkeywords');
	}
	public function changecateall(){
		$sql="UPDATE ai_nav_keyword SET categoryid= '".$_POST['changeCateId']."' where id in (".$_POST['login_record_id'].")";
		$res=M('')->query($sql);
		echo 1;
		return;
	}
	
	public function keywordcategorymanager(){
		$modelArr=array(
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);

		if($_POST['cate_action']=='add'){
			$insertSql=null;
			$insertSql="INSERT INTO ai_nav_keyword_category (
			id,name,model,sequence,status)VALUES (NULL,'".$_POST['categoryname']."',
			'".$_POST['model']."','".$_POST['sequence']."','".$_POST['status']."')";
			M('')->query($insertSql);
		}
		$sql="select * from ai_nav_keyword_category order by model";
		
		$categoryList=M('')->query($sql);
		$this->assign('categoryList', $categoryList);
		$this->assign('modelArr', $modelArr);
		$this->display('keywordscategory');
	}
	public function editkeywordcategory(){
		$modelArr=array(
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);
		if($_POST['nav_action']=='doedit'){
			$sql="UPDATE  ai_nav_keyword_category SET name = '".$_POST['name']."',
			sequence  = '".$_POST['sequence']."',model='".$_POST['model']."',status='".$_POST['status']."'
			WHERE  id ='".$_POST['id']."'";
			M('')->query($sql);
		}
		
		$sql="select * from ai_nav_keyword_category where id='".$_GET['id']."'";
		$cateinfo=M('')->query($sql);
		$this->assign('cateinfo', $cateinfo[0]);
		$this->assign('modelArr', $modelArr);
		$this->display('editkeywordcategory');
	}
	public function doDelkeywordscategory(){
		$res=M('nav_keyword_category')->where("id in(".$_POST['login_record_id'].")")->delete();
		if($res)
		{
			//$this->savemenuinfo();
			echo 1;
		}
		else{
			echo 0;
			return;
		}
	}
	public function doDelkeword(){
		$res=M('nav_keyword')->where("id in(".$_POST['login_record_id'].")")->delete();
		if($res)
		{
			//$this->savemenuinfo();
			echo 1;
		}
		else{
			echo 0;
			return;
		}
	}
	
	public function homepage() {
		 $action=$_POST['nav_action']?addslashes($_POST['nav_action']):'';
		 foreach($_POST as $k=>$v){
			$_POST[$k]=addslashes($v);
			if($k=='selected_flag'&&$v=='默认为英文名称'){
				$_POST[$k]=$_POST['menu_name_en'];
			}
		 }
		 $checksql="select * from ai_nav_menu where menu_name='".$_POST['menu_name']."'";
		 $res=M('')->query($checksql);
		 if($action&&$action=='add'&&!$res){
			M('nav_menu')->add($_POST);
			$this->savemenuinfo();
		 }
		 $menusInfo = M('nav_menu')->order('partent_id asc')->findAll();
		 foreach($menusInfo as $k => $v){
			if(intval($v['partent_id'])>0){
				$getPartentInfoSql=null;
				$PartentInfo=array();
				$getPartentInfoSql="select * from ai_nav_menu where id='".$v['partent_id']."'";
				$PartentInfo=M('')->query($getPartentInfoSql);
				if($PartentInfo)$menusInfo[$k]['pinfo']=$PartentInfo[0];
			}
		 }
		 $FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息
		 //print_r($FmenusInfo);
		 $this->assign('menusInfo', $menusInfo);
		 $this->assign('FmenusInfo', $FmenusInfo);
		 $this->display();
	}
		//****删除用户登录日志****
    public function doDel() {
		$res=M('nav_menu')->where("id in(".$_POST['login_record_id'].")")->delete();
    	if($res)
		{
			$this->savemenuinfo();
			echo 1;
		}
		else{
			echo 0;
			return;
		}
    }
		//****删除用户登录日志****
    public function donavDel() {
		$res=M('nav_list')->where("id in(".$_POST['login_record_id'].")")->delete();
		$res=M('nav_content')->where("nid in(".$_POST['login_record_id'].")")->delete();
    	if($res)
		{
			$this->saveImginfo();
			echo 1;
		}
		else{
			echo 0;
			return;
		}
    }
	
	public function editNav()
	{
		$action=$_POST['nav_action']?addslashes($_POST['nav_action']):'';
		$id=$_GET['id']?addslashes($_GET['id']):'';
		if($action&&$action=='edit'&&$id>0){
			$uStr=null;
			$uStr.="set menu_name='".$_POST['menu_name']."',";
			$uStr.="menu_name_en='".$_POST['menu_name_en']."',";
			$uStr.="link='".$_POST['link']."',";
			$uStr.="sort='".$_POST['sort']."',";
			$uStr.="type='".$_POST['type']."',";
			$uStr.="status='".$_POST['status']."',";
			$uStr.="selected_flag='".$_POST['selected_flag']."',";
			$uStr.="partent_id='".$_POST['partent_id']."'";
			$upsql="update ai_nav_menu $uStr where id='".$id."'";
			M('')->query($upsql);
			$this->savemenuinfo();
		 }
		$menusInfo = M('nav_menu')->where("id=$id")->findAll(); //顶级导航信息
		$FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息
		$this->assign('menu', $menusInfo[0]);
		$this->assign('FmenusInfo', $FmenusInfo);
		$this->display();
	}
	
	public function adv(){
		$modelArr=array(
			'index'=>'首页',
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);
		$this->assign('_modelArr', $modelArr);
		$_ImgType=array();
		$_ImgType[1]='页面轮滚';
		$this->assign('_ImgType', $_ImgType);
		
		$uploadpath="navupload/";
		if($_GET['actimg']=='addinfo'){
			$listdata['nav_name']=$_POST['nav_name'];
			$listdata['type']=$_POST['type'];
			$listdata['status']=$_POST['status'];
			$listdata['menu_id']=$_POST['menu_id'];
			$listdata['create_time']=time();
			$insertId=M('nav_list')->add($_POST);
			if($insertId){
				foreach($_FILES['imgsrc']['tmp_name'] as $k=> $val){
					if($val&&$_FILES['imgsrc']['type'][$k]=='image/jpeg'){
						$pic_path=$uploadpath.time().rand(100,999).'.jpg';}
					if(@copy($val, $pic_path) || @move_uploaded_file($val, $pic_path)) 
					{
						$filedata=null;
						$filedata['nid']=intval($insertId);
						$filedata['title']=$_POST['img_title'][$k];
						$filedata['url']=$_POST['img_url'][$k];
						$filedata['img']=$pic_path;
						$filedata['sort']=$_POST['img_sort'][$k];
						M('nav_content')->add($filedata);
					}
				}
			}
			$this->saveImginfo();
		}
		$nav_listInfo = M('nav_list')->findAll();
		$FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息		
		foreach($nav_listInfo as $k=>$v){
			$getcountSql="select count(*) as num from ai_nav_content where nid='".$v['id']."'";
			$countArr=M('')->query($getcountSql);
			$nav_listInfo[$k]['imgcount']=$countArr[0]['num'];
			foreach($FmenusInfo as $fk=>$fv){
				if($fv['id']==$v['menu_id']){
				$nav_listInfo[$k]['menu_name']=$fv['menu_name'];
				}
			}
		}
		//$FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息
		//print_r($FmenusInfo);
		$this->assign('nav_listInfo', $nav_listInfo);
		$this->assign('FmenusInfo', $FmenusInfo);
		$this->display();
	}
	public function editadv(){
		$modelArr=array(
			'index'=>'首页',
			'plan'=>'健身计划',
			'train'=>'锻炼',
			'nutri'=>'营养',
			'append'=>'辅助品',
			'lifestyle'=>'生活方式',
		);
		$uploadpath='navupload/';
		$id=$_GET['id']?addslashes($_GET['id']):'';
		if($_GET['actimg']=='editinfo'){
			$uStr=null;
			$uStr.="set nav_name='".$_POST['nav_name']."',";
			$uStr.="type='".$_POST['type']."',";
			$uStr.="status='".$_POST['status']."',";
			$uStr.="menu_id='".$_POST['menu_id']."'";
			$upsql="update ai_nav_list $uStr where id='".$id."'";
			M('')->query($upsql);
			//
			$insertId=$id;
			if($insertId){
				foreach($_FILES['imgsrc']['tmp_name'] as $k=> $val){
					$pic_path=$uploadpath.$id."_".$k.'.jpg';
					if($val&&$_FILES['imgsrc']['type'][$k]=='image/jpeg'){
						@copy($val, $pic_path) || @move_uploaded_file($val, $pic_path);
					}
					$checksql="select * from ai_nav_content where id=$k and nid=$insertId";
					$result=M('')->query($checksql);
					if(!$result){
						$filedata=null;
						$filedata['nid']=intval($insertId);
						$filedata['title']=$_POST['img_title'][$k];
						$filedata['url']=$_POST['img_url'][$k];
						$filedata['img']=$pic_path;
						$filedata['sort']=$_POST['img_sort'][$k];
						M('nav_content')->where("id in(".$k.")")->delete();
						M('nav_content')->add($filedata);
					}else{
						$updateSql="UPDATE ai_nav_content SET 
						title = '".$_POST['img_title'][$k]."',
						url = '".$_POST['img_url'][$k]."',
						img = '".$pic_path."',
						sort = '".$_POST['img_sort'][$k]."'
						 WHERE id =$k";	
						M('')->query($updateSql);
					}
				}
			}

		}
		$this->saveImginfo();
		$listInfo = M('nav_list')->where("id=$id")->findAll(); //顶级导航信息
		$imgInfo = M('nav_content')->where("nid=$id")->findAll(); //顶级导航信息
		$FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息
		$this->assign('listInfo', $listInfo[0]);
		$this->assign('_modelArr', $modelArr);
		$this->assign('imgInfo', $imgInfo);
		$this->assign('id', $id);
		$this->assign('FmenusInfo', $FmenusInfo);
		$this->display();
	}
	public function savemenuinfo()
	{
		$menusInfo=$fileName=null;
		$fileName='TopMenuCache.php';
		$menusInfo = M('nav_menu')->where('partent_id=0 and status=1 ')->order('sort asc')->findAll(); //顶级导航信息
		foreach($menusInfo as $key => $value)
		{
			$CmenusInfo=null;
			$CmenusInfo=M('nav_menu')->where("partent_id='".$value['id']."' and status=1 ")->order('sort asc')->findAll();
			$menusInfo[$key]['child']=$CmenusInfo;
		}
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($menusInfo)."';");
	}
	public function keywordcp()
	{
		$modelArr=array(
			'plan'=>1,
			'train'=>2,
			'nutri'=>3,
			'append'=>4,
			'lifestyle'=>5,
		);
		$keywordinfo=null;
		foreach($modelArr as $keyname =>$value){
			$allCateInfo=null;
			$allCateSql="select * from ai_article_category where channel=$value";
			$allCateInfo=M('')->query($allCateSql);
			$cateSelectIdStr=null;
			foreach($allCateInfo as $key =>$value){
				$keywordinfo[$keyname][]=$value['name'];
				$cateSelectIdStr.=empty($cateSelectIdStr)?$value['id']:','.$value['id'];
			}
			if($keyname=='plan'){
				
				$getkeySql="select keyword from ai_daily where keyword!=''";
				$planInfo=M('')->query($getkeySql);
				//print_r($planInfo);
				foreach($planInfo as $key=>$value){
					$keyArr=null;
					$keyArr=explode(',',$value['keyword']);
					if(is_array($keyArr)){
						foreach($keyArr as $k =>$value)
						{	
							$keywordinfo[$keyname][]=$value;
						}
					}
				}
			}
			if($keyname!='plan'){
				$getkeySql="select keyword from ai_article where category_id in($cateSelectIdStr) and keyword!=''";
				$planInfo=M('')->query($getkeySql);
				foreach($planInfo as $key=>$value){
					$keyArr=null;
					$keyArr=explode(',',$value['keyword']);
					if(is_array($keyArr)){
						foreach($keyArr as $k =>$value)
						{
							$keywordinfo[$keyname][]=$value;
						}
					}
				}
			}
			if($keyname=='train'){
				$getkeySql="select keyword from ai_video where category_id in($cateSelectIdStr) and keyword!=''";
				$planInfo=M('')->query($getkeySql);
				foreach($planInfo as $key=>$value){
					$keyArr=null;
					$keyArr=explode(',',$value['keyword']);
					if(is_array($keyArr)){
						foreach($keyArr as $k =>$value)
						{
							$keywordinfo[$keyname][]=$value;
						}
					}
				}
			}
			
		}
		//去重
		foreach($keywordinfo as $key => $value)
		{
			$tmp=array();
			foreach($value as $k1=>$v1){
				if(!in_array($v1,$tmp)){
				$tmp[]=$v1;
				}
			}
			$keywordinfo[$key]=$tmp;
		}
		foreach ($keywordinfo as $key=>$value) {
			foreach ($value as $k=>$v) {
				$getSql=$res=null;
				$getSql="select * from ai_nav_keyword where name='".$v."' and model='".$key."'";
				$res=M('')->query($getSql);
				if(!$res){
					$insertSql=null;
					$insertSql="INSERT INTO  `aijianmei`.`ai_nav_keyword` (
					id ,name ,categoryid,model,sequence ,status)VALUES (NULL ,  '".$v."',  '0',  '".$key."',  '0',  '1')";
					M('')->query($insertSql);
				}
			} 
		}
		$this->saveKeywordCache(); 
	//var_dump($keywordinfo);
		/*echo '<form action="/index.php?app=admin&mod=Nav&act=keywordcp&cleanall=1" method="post">
		请确认初始化所有的关键字吗<input type="submit" value="确定"><input type="hidden" name="cleanall" value="1"></form>';
		//$fileName='keywordInfo.php';
		//file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($keywordinfo)."';");*/
	}
	
	public function saveKeywordCache(){
		$sql="select * from ai_nav_keyword where status=1 order by sequence,model";
		$keywordinfo=M('')->query($sql);
		//var_dump($keywordinfo);
		foreach ($keywordinfo as $key => &$value) {
			 $res=$getcnamesql=null;
		 	 $getcnamesql="select * from ai_nav_keyword_category where id='".$value['categoryid']."'";
		 	 $res=M('')->query($getcnamesql);
		 	 if($res){
		 	 		$value['cname']=$res[0]['name'];
		 	 }
		}
		$keywordinfoTmp=null;
		foreach ($keywordinfo as $key=>&$value) {
				if(!in_array($value['name'],$keywordinfoTmp[$value['model']][$value['cname']]))
				{
					$keywordinfoTmp[$value['model']][$value['cname']][]=$value['name'];
				}
		} 
		$fileName='keywordInfo.php';
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($keywordinfoTmp)."';");
	}
	public function saveImginfo(){
		$fileName='advImgCache.php';
		$advInfoTmp=null;
		$advInfo = M('nav_list')->findAll(); //顶级导航信息
		foreach($advInfo as $k =>$v){
			//$advInfoTmp[$v['nav_name']]=$v;
			//$contentinfo=M('nav_content')->where("nid='".$v['id']."' order by sort asc")->findAll();
			$contentinfo=M()->query("select * from ai_nav_content where nid ='".$v['id']."' order by sort asc");
			$advInfoTmp[$v['nav_name']]['imginfo']=$contentinfo;
		}
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($advInfoTmp)."';");
		//print_r($advInfoTmp);
	}
	
	public function proIndexAd(){
		$uploadpath='navupload/';
		if($_POST['nav_action']=='add'){
			$pic_path=$uploadpath.time().rand().'.jpg';
			if($_FILES['img']['type']=='image/jpeg'){
				copy($_FILES['img']['tmp_name'], $pic_path) || move_uploaded_file($_FILES['img']['tmp_name'], $pic_path);
			}
			$sql="INSERT INTO ai_nav_product_list (id,name,price,link,img,sequence,status)
			VALUES(NULL,'".$_POST['name']."','".$_POST['price']."','".$_POST['link']."','".$pic_path."','".$_POST['sequence']."','".$_POST['status']."')";
			M('')->query($sql);
		}
		$getSql="select * from ai_nav_product_list order by sequence";
		$prolist=M('')->query($getSql);
		$this->prolistCache();			
		$this->assign('prolist', $prolist);
		$this->display();
	}
	public function proIndexAdedit(){
		$uploadpath='navupload/';
		$id=$_GET['id'];
		if($_POST['nav_action']=='doedit'){
			$id=$_POST['eid'];
			unset($_POST['nav_action']);unset($_POST['eid']);
			//print_r($_POST);
			$pic_path=null;
			if($_FILES['img']['type']=='image/jpeg'){
				$pic_path=$uploadpath.time().rand().'.jpg';
				copy($_FILES['img']['tmp_name'], $pic_path) || move_uploaded_file($_FILES['img']['tmp_name'], $pic_path);
				$sql="UPDATE  ai_nav_product_list SET img ='".$pic_path."' WHERE  id =$id";
				M('')->query($sql);
			}
			$sql="UPDATE  ai_nav_product_list SET 
			name ='".$_POST['name']."',price ='".$_POST['price']."',
			link ='".$_POST['link']."',sequence ='".$_POST['sequence']."',status ='".$_POST['status']."'
			WHERE  id =$id";	
			M('')->query($sql);
		}
		$this->prolistCache();
		$getSql="select * from ai_nav_product_list where id=$id";
		$prolist=M('')->query($getSql);			
		$this->assign('prolist', $prolist[0]);
		$this->display();
	}	
	public function placardManager(){
		if($_POST['content']!=''){
			$checkSql="select * from ai_nav_placard";
			$res=M('')->query($checkSql);
			if(!$res){
				$sql="INSERT INTO  `aijianmei`.`ai_nav_placard` (id ,content)
				VALUES (NULL ,  '".t($_POST['content'])."')";
				M('')->query($sql);
			}else{
				$sql="UPDATE ai_nav_placard SET  content = '".t($_POST['content'])."' WHERE id ='".$res[0]['id']."'";
				M('')->query($sql);	
			}		
		}
		$getsql="select * from ai_nav_placard";
		$placardList=M('')->query($getsql);
		$this->assign('prolist', $placardList[0]);
		$this->display('placardManager');
	}
	public function delByType(){
		$tableType=$_POST['tabletype'];
		$tableNameList=array(
			'nav_product_list'=>'nav_product_list',
			'nav_module_content'=>'nav_module_content',
			'nav_module_list'=>'nav_module_list',
		);
		if(!in_array($tableType,$tableNameList)){echo 0;return;}
		
		$res=M($tableType)->where("id in(".$_POST['login_record_id'].")")->delete();
		if($res)
		{
			//$this->saveImginfo();
			echo 1;
		}
		else{
			echo 0;
			return;
		}
	}
	public function prolistCache(){
		$fileName='proListCache.php';
		$getallsql=$listinfo=null;
		$getallsql="select * from ai_nav_product_list order by sequence asc";
		$listinfo=M('')->query($getallsql);
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($listinfo)."';");
	}
}