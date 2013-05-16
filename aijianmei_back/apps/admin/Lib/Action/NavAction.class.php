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
		$_ImgType=array();
		$_ImgType[1]='顶部导航';
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

						M('nav_content')->where("id in(".$k.")")->delete();
						
						M('nav_content')->add($filedata);
					}
				}
			}

		}
		$this->saveImginfo();
		$listInfo = M('nav_list')->where("id=$id")->findAll(); //顶级导航信息
		$imgInfo = M('nav_content')->where("nid=$id")->findAll(); //顶级导航信息
		$FmenusInfo = M('nav_menu')->where('partent_id=0')->findAll(); //顶级导航信息
		$this->assign('listInfo', $listInfo[0]);
		$this->assign('imgInfo', $imgInfo);
		$this->assign('id', $id);
		$this->assign('FmenusInfo', $FmenusInfo);
		$this->display();
	}
	public function savemenuinfo()
	{
		$menusInfo=$fileName=null;
		$fileName='TopMenuCache.php';
		$menusInfo = M('nav_menu')->where('partent_id=0')->order('sort asc')->findAll(); //顶级导航信息
		foreach($menusInfo as $key => $value)
		{
			$CmenusInfo=null;
			$CmenusInfo=M('nav_menu')->where("partent_id='".$value['id']."'")->order('sort asc')->findAll();
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
			'append'=>4
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
		
		
		$fileName='keywordInfo.php';
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($keywordinfo)."';");
	}
	public function saveImginfo(){
		$fileName='advImgCache.php';
		$advInfoTmp=null;
		$advInfo = M('nav_list')->findAll(); //顶级导航信息
		foreach($advInfo as $k =>$v){
			$advInfoTmp[$v['nav_name']]=$v;
			$contentinfo=M('nav_content')->where("nid='".$v['id']."'")->findAll();
			$advInfoTmp[$v['nav_name']]['imginfo']=$contentinfo;
		}
		file_put_contents('PublicCache/'.$fileName,"<?php\n\r return '".serialize($advInfoTmp)."';");
	}
}