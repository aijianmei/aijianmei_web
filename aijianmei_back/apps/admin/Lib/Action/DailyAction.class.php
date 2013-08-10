<?php
class DailyAction extends AdministratorAction {
	public function bulkImport() {
		// 替换数组 转化为对应标识
		$channelArr = array (
				'上班族健身' => '1',
				'日常健身' => '2',
				'专业运动员' => '3',
				'健美运动员' => '4' 
		);
		$action = $_POST ['action'];
		$path = 'exceluploadlist/';
		// $path='/data/home/htdocs/exceluploadlist/';
		if (! empty ( $action ) && $action == 'UploadExcelFile') {
			$UFileName = $_FILES ['UploadFile'] ['name'];
			$FilePre_arr = explode ( ".", $UFileName );
			$FilePre = $FilePre_arr [1];
			if ($_FILES ['UploadFile'] ['tmp_name']) {
				$Tmp_FileName = $path . $_FILES ['UploadFile'] ['name'];
				if (move_uploaded_file ( $_FILES ['UploadFile'] ['tmp_name'], $Tmp_FileName )) {
					$error_string = '上传成功!\\n';
					// $Tmp_FileName='test.xls';
					$exceldata = $this->ReadExcelInfo ( $Tmp_FileName, 2 );
					$is_pass = 0;
					// $exceldata[2][3]=strtotime($exceldata[2][3]);
					// print_r($exceldata);exit;
					if ($is_pass != 1) {
						$succcount = 0;
						foreach ( $exceldata as $key => $value ) {
							// sleep(1);
							$insertdata ['uid'] = $this->mid;
							$insertdata ['title'] = t ( $value [0] );
							$insertdata ['channel'] = intval ( $channelArr [$value [1]] );
							$insertdata ['content'] = t ( $value [4] );
							$insertdata ['keyword'] = t ( $value [5] );
							// $data['videos'] = t($_POST['videos']);
							$insertdata ['create_time'] = time ();
							$insertdata ['gotime'] = strtotime ( $value [3] );
							$insertdata ['img'] = null;
							$newfilename = null;
							$newfilename = $value [2];
							$insertdata ['img'] = $newfilename;
							$vid = M ( 'daily' )->add ( $insertdata );
							// print_r($insertdata);
							if ($vid > 0) {
								$succcount ++;
							}
							/* video part start */
							$vdata = null;
							$vdata ['daily_id'] = $vid;
							$vdata ['link'] = $value [6];
							$vdata ['htmlurl'] = $value [7];
							$vdata ['wapurl'] = $value [8];
							$vdata ['title'] = $value [9];
							$vdata ['intro'] = $value [10];
							$vdata ['create_time'] = time ();
							M ( 'daily_video' )->add ( $vdata );
							/* video part end */
						}
					}
				} else {
					$error_string = '上传失败!\\n';
				}
			}
		}
		$this->assign ( 'succcount', $succcount );
		$list = $this->listDir ( $path );
		$listRes = array ();
		foreach ( $list as $k => $v ) {
			if ($v) {
				$listRes [$k] ['name'] = $v;
				$listRes [$k] ['ctime'] = date ( "Y-m-d", filectime ( $path . $v ) );
				$listRes [$k] ['url'] = $path . $v;
			}
		}
		$this->assign ( 'listRes', $listRes );
		$this->display ();
	}
	public function uploadImg() {
		$targetfilename = time () . rand () . ".jpg";
		$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/daily/' . $targetfilename;
		if ($_FILES ['image_file'] ['tmp_name'] != '') {
			move_uploaded_file ( $_FILES ['image_file'] ['tmp_name'], $newfilename );
		}
		echo "<textarea>/public/images/daily/" . $targetfilename . "?" . rand () . "</textarea>";
		echo "<textarea>$targetfilename</textarea>";
		exit ();
	}
	public function addDaily() {
		if (isset ( $_POST ['title'] )) {
			$data ['uid'] = $this->mid;
			$data ['title'] = t ( $_POST ['title'] );
			$data ['channel'] = intval ( $_POST ['channel'] );
			$data ['content'] = t ( $_POST ['content'] );
			$data ['keyword'] = t ( $_POST ['keyword'] );
			$data ['create_time'] = time ();
			$data ['isreset']	= $_POST['isreset'];
			$data ['gotime'] = strtotime ( $_POST ['gotime'] );
			if (isset ( $_FILES ['img'] ['name'] )) {
				$targetfilename = time () . rand () . ".jpg";
				$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/daily/' . $targetfilename;
				move_uploaded_file ( $_FILES ['img'] ['tmp_name'], $newfilename );
				$data ['img'] = $targetfilename;
			}
			if (isset ( $_FILES ['shareimg'] ['name'] )) {
				$targetfilename = 'share' . time () . rand () . ".jpg";
				$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/daily/' . $targetfilename;
				move_uploaded_file ( $_FILES ['shareimg'] ['tmp_name'], $newfilename );
				$data ['shareimg'] = $targetfilename;
			}
			if (! empty ( $data ['title'] ) && ! empty ( $data ['content'] )) {
				if ($data ['id'] > 0) {
					unset ( $data ['uid'] );
					unset ( $data ['create_time'] );
					M ( 'daily' )->save ( $data );
					$vid = $data ['id'];
				} else {
					$vid = M ( 'daily' )->add ( $data );
				}
				foreach ( $_POST ['vtitle'] as $key => $value ) {
					$dailyVideoData = array ();
					$dailyVideoData ['vtitle'] = $value;
					$dailyVideoData ['vtitlecontent'] = $_POST ['vtitlecontent'] [$key];
					$dailyVideoData ['eq'] = $_POST ['eq'] [$key];
					$dailyVideoData ['channel'] = $_POST ['channel'] [$key];
					$dailyVideoData ['vtitleurl'] = $_POST ['vtitleurl'] [$key];
					$dailyVideoData ['imgLeft'] = $_POST ['imgLeft'] [$key];
					$dailyVideoData ['imgLeftUrl'] = $_POST ['imgLeftUrl'] [$key];
					$dailyVideoData ['imgRight'] = $_POST ['imgRight'] [$key];
					$dailyVideoData ['imgRightUrl'] = $_POST ['imgRightUrl'] [$key];
					$res = $this->addDailyVideo ( $dailyVideoData, $vid );
				}
				echo '<script>alert("success")</script>';
			}
		}
		// $this->display('');
		$this->display ( 'newform' );
	}
	function addDailyVideo($data, $did) {
		if (empty ( $data ))
			return false;
		$sql = "INSERT INTO  `aijianmei`.`ai_daily_video_list` (`id` ,`dailyid` ,`content`)
   						VALUES (NULL ,  '" . $did . "',  '" . serialize ( $data ) . "')";
		$res = M ( '' )->query ( $sql );
		return $res;
	}
	public function editDaily() {
		$id = intval ( $_GET ['id'] );
		if (! empty ( $_POST ['title'] )) {
			$data ['id'] = $id;
			$data ['uid'] = $this->mid;
			$data ['title'] = t ( $_POST ['title'] );
			$data ['channel'] = intval ( $_POST ['channel'] );
			$data ['content'] = t ( $_POST ['content'] );
			$data ['isreset']	= $_POST['isreset'];
			$data ['keyword'] = t ( $_POST ['keyword'] );
			$data ['create_time'] = time ();
			$data ['gotime'] = strtotime ( $_POST ['gotime'] );
			if (isset ($_FILES ['img'] ['tmp_name'])&&!empty($_FILES ['img'] ['tmp_name'])) {
				$targetfilename = time () . rand () . ".jpg";
				$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/daily/' . $targetfilename;
				move_uploaded_file ( $_FILES ['img'] ['tmp_name'], $newfilename );
				$data ['img'] = $targetfilename;
			}
			if (isset ($_FILES ['shareimg'] ['tmp_name'])&&!empty($_FILES ['shareimg'] ['tmp_name'])) {
				$targetfilename = 'share' . time () . rand () . ".jpg";
				$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/daily/' . $targetfilename;
				move_uploaded_file ( $_FILES ['shareimg'] ['tmp_name'], $newfilename );
				$data ['shareimg'] = $targetfilename;
			}
			unset ( $data ['uid'] );
			unset ( $data ['create_time'] );
			M ( 'daily' )->save ( $data );
			M ()->query ( "delete from ai_daily_video_list where dailyid=$id" );
			foreach ( $_POST ['vtitle'] as $key => $value ) {
				$dailyVideoData = array ();
				$dailyVideoData ['vtitle'] = $value;
				$dailyVideoData ['vtitlecontent'] = $_POST ['vtitlecontent'] [$key];
				$dailyVideoData ['eq'] = $_POST ['eq'] [$key];
				$dailyVideoData ['channel'] = $_POST ['vchannel'] [$key];
				$dailyVideoData ['vtitleurl'] = $_POST ['vtitleurl'] [$key];
				$dailyVideoData ['imgLeft'] = $_POST ['imgLeft'] [$key];
				$dailyVideoData ['imgLeftUrl'] = $_POST ['imgLeftUrl'] [$key];
				$dailyVideoData ['imgRight'] = $_POST ['imgRight'] [$key];
				$dailyVideoData ['imgRightUrl'] = $_POST ['imgRightUrl'] [$key];
				if(!empty($dailyVideoData ['vtitle'])){
					$res = $this->addDailyVideo ( $dailyVideoData, $id );
				}
			}
		}
		
		$article = M ( 'daily' )->where ( array (
				'id' => $id 
		) )->find ();
		$dailylist = M ( 'daily_video_list' )->where ( array (
				'dailyid' => $id 
		) )->order ( 'id asc' )->findAll ();
		$article ['gotime'] = date ( "Y-m-d", $article ['gotime'] );
		foreach ( $dailylist as $key => $value ) {
			$dailylist [$key] ['content'] = unserialize ( $value ['content'] );
		}
		$this->assign ( 'daily', $article );
		$this->assign ( 'dailylist', $dailylist );
		$this->assign ( 'type', 'edit' );
		$this->display ( 'enewform' );
	}
	public function deleteDailyVideo() {
		if (! isset ( $_POST ['ids'] )) {
			echo '0';
			exit ();
		}
		$vid = intval ( $_POST ['ids'] );
		$res=M('daily_video_list')->where (array('id' => $vid ))->delete ();
		echo $res ? '1' : '0';
	}
	public function daily() {
		$pg=$_GET['pg'] ? intval($_GET['pg']) :1;
		$nums=15;
		$dailycount = M ( 'daily' )->order ( 'create_time desc' )->findAll ();
		//$daily=M ( 'daily' )->order ( 'create_time desc' )->findAll ();
		$from=($pg-1)*$nums;
		$daily=M ( '' )->query ( "select * from ai_daily order by create_time desc limit {$from},{$nums}");
		foreach ( $daily as $k => $value ) {
			$daily [$k] ['create_time'] = date ( "Y-m-d", $value ['create_time'] );
			$daily [$k] ['gotime'] = $value ['gotime'] != null ? date ( "Y-m-d", $value ['gotime'] ) : '未填写';
		}
		$pageArr=$this->pageHtml (count($dailycount), $nums,$pg, '/index.php?app=admin&mod=Daily&act=daily&pg=%s');

		$this->assign ( 'pageArr', $pageArr );
		$this->assign ( 'daily', $daily );
		$this->display ('dailyform');
	}
	public function doDeleteDaily() {
		$this->delete ( 'daily' );
	}
	protected function getCategories() {
		$category = M ( 'article_category' )->findAll ();
		return $category;
	}
	protected function delete($table) {
		if (! isset ( $_POST ['ids'] )) {
			echo '0';
			exit ();
		}
		$map ['id'] = array (
				'in',
				t ( $_POST ['ids'] ) 
		);
		echo M ( $table )->where ( $map )->delete () ? '1' : '0';
	}
	
	/*
	 * 读取Excel 数据方法类 author kontem at 20130504 @param string $FilePath 文件路径 @param string $StartLine 起始行数 @param string $EndLine 结束行数 @return array Data 多维数组
	 */
	function ReadExcelInfo($FilePath, $StartLine = 0, $EndLine = 0) {
		require_once 'libpack/PHPExcel/PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load ( $FilePath );
		$objWorksheet = $objPHPExcel->getActiveSheet ();
		$StartLine = ! empty ( $StartLine ) ? $StartLine : 0;
		
		$k = 1;
		foreach ( $objWorksheet->getRowIterator () as $row ) {
			$cellIterator = $row->getCellIterator ();
			$cellIterator->setIterateOnlyExistingCells ( false );
			$cellIterator->setIterateOnlyExistingCells ( true );
			$plainText = null;
			foreach ( $cellIterator as $cell ) {
				$plainText = ($cell->getValue () instanceof PHPExcel_RichText) ? $cell->getValue ()->getPlainText () : $cell->getValue ();
				if ($cell->getDataType () == PHPExcel_Cell_DataType::TYPE_NUMERIC) {
					$cellstyleformat = $cell->getParent ()->getStyle ( $cell->getCoordinate () )->getNumberFormat ();
					$formatcode = $cellstyleformat->getFormatCode ();
					if (preg_match ( '/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode )) {
						$plainText = gmdate ( "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP ( $plainText ) );
					} else {
						$plainText = PHPExcel_Style_NumberFormat::toFormattedString ( $plainText, $formatcode );
					}
				}
				$data [$k] [] = $plainText;
			}
			$k ++;
		}
		if ($EndLine < 0) {
			$EndLine = $k + $EndLine;
		}
		foreach ( $data as $key => $value ) {
			if ($key < $StartLine) {
				unset ( $data [$key] );
			}
			if ($key > $EndLine && $EndLine != 0) {
				unset ( $data [$key] );
			}
		}
		return $data;
	}
	function listDir($dir) {
		global $resdir;
		if (is_dir ( $dir )) {
			if ($dh = opendir ( $dir )) {
				while ( ($file = readdir ( $dh )) !== false ) {
					if ((is_dir ( $dir . "/" . $file )) && $file != "." && $file != "..") {
						// $this->listDir($dir."/".$file."/");
					} else {
						if ($file != "." && $file != "..") {
							
							if (! in_array ( $file, $resdir ))
								$resdir [] = $file;
						}
					}
				}
				closedir ( $dh );
			}
		}
		return $resdir;
	}
	
		public function pageHtml($count,$nums,$pg=null,$url=null)
	{
		$enum=$snum=0;
		$pager=null;
		$pagehtml=null;
		$listnum=ceil($count/$nums);
		if($pg==1||!$pg){
			$pre='<li><a>Prev</a></li>';
		}else
		{
			$pre='<li><a href="'.$url.($pg-1).'">Prev</a></li>';
			$pre='<li><a href="'.sprintf($url,$pg-1).'">Prev</a></li>';
		}
		if($pg==$listnum){
			$next='<li><a>Next</a></li>';
		}else
		{
			$next='<li><a href="'.$url.($pg+1).'">Next</a></li>';
			$next='<li><a href="'.sprintf($url,$pg+1).'">Next</a></li>';
		}
		for($i=1;$i<=$listnum;$i++){
			if($i==$pg){
				$cuCss='class="active"';
			}else{
				$cuCss='';
			}
			if(!$pg){
				if($i==1){
					$cuCss='class="active"';
				}
			}
			$pageArr[$i]='<li '.$cuCss.'><a href="'.$url.$i.'">'.$i.'</a></li>';
			$pageArr[$i]='<li '.$cuCss.'><a href="'.sprintf($url,$i).'">'.$i.'</a></li>';
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
	function addFitnessProgram(){
		if(isset($_GET['pid'])&&$_GET['pid']>0){
			$pinfo=M('')->query("select * from ai_fitness_program where id ='".$_GET['pid']."'");	
			$parentName=$pinfo[0]['title'];
			$this->assign ('parentId', $_GET['pid'] );
			$this->assign ('parentName', $parentName );
		}

		if(!empty($_POST ['title'])){
		$data['parentid'] =$_GET['pid'] ? intval($_GET['pid']):0;
		$data['title']  	=	$_POST ['title'];
		$image = time () . rand () . ".jpg";
		$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/fitnessProgram/' . $image;
		if ($_FILES ['image'] ['tmp_name'] != '') {
			@move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $newfilename );
		}
		$shareimg = time () . rand () . ".jpg";
		$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/fitnessProgram/' . $shareimg;
		if ($_FILES ['shareimg'] ['tmp_name'] != '') {
			@move_uploaded_file ( $_FILES ['shareimg'] ['tmp_name'], $newfilename );
		}
		$data['imageurl']  =$image;
		$data['shareimgurl']  =$shareimg;
		$data['brief']  =	$_POST ['brief'];
		$data['content']  =	t($_POST ['content']);
		$data['keyword']  =	$_POST ['keyword'];
		$data['create_time']  =	time();
		M ( 'fitness_program' )->add ( $data );
		redirect(U('admin/Daily/fitnessProgram'));
		}
		
		$this->display('addFitnessProgram');
	}
	function editFitnessProgram(){
		if(!empty($_POST ['title'])){
		$data['id']=$_GET['id']?$_GET['id']:die();
		$data['title']  	=	$_POST ['title'];
		$image = time () . rand () . ".jpg";
		$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/fitnessProgram/' . $image;
		if ($_FILES ['image'] ['tmp_name'] != '') {
			@move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $newfilename );
			$data['imageurl']  =$image;
		}
		$shareimg = time () . rand () . ".jpg";
		$newfilename = $_SERVER ['DOCUMENT_ROOT'] . '/public/images/fitnessProgram/' . $shareimg;
		if ($_FILES ['shareimg'] ['tmp_name'] != '') {
			@move_uploaded_file ( $_FILES ['shareimg'] ['tmp_name'], $newfilename );
			$data['shareimgurl']  =$shareimg;
		}
		$data['brief']  =	$_POST ['brief'];
		$data['content']  =	t($_POST ['content']);
		$data['keyword']  =	$_POST ['keyword'];
		$data['create_time']  =	time();
		M ( 'fitness_program' )->save ( $data );
		}
		if(isset($_GET['id'])&&$_GET['id']>0){
			$pinfo=M('')->query("select * from ai_fitness_program where id ='".$_GET['id']."'");	
			$this->assign ('pinfo', $pinfo[0] );
		}
		
		$this->display('editFitnessProgram');
	}
	
	
	function fitnessProgram(){
		$pid=$_GET['pid']?$_GET['pid']:0;
		$data=M('')->query("select * from ai_fitness_program where parentid=$pid");
		$this->assign ('fitnessProgram', $data );
		
		$this->display('fitnessProgram');
	}
	function doDeleteFitnessProgram(){
		if (! isset ( $_POST ['ids'] )) {
			echo '0';
			exit ();
		}
		$vid = intval ( $_POST ['ids'] );
		$res=M('fitness_program')->where (array('id' => $vid ))->delete ();
		echo $res ? '1' : '0';
	}
	function fitnessVideo(){
		var_dump($_REQUEST);
		$this->display('addFitnessVideo');
	}

}
?>