<?php 
class AcomModel extends Model {
    //M('login_record')->where($map)->delete();
    //return $this->where($map)->field($field)->order($order)->limit($limit)->findAll();
    //$this->where("`node_id`=$node_id")->find();
    //$this->table(C('DB_PREFIX').'user_set')->findall();
    //M('login_record')->where($map)->delete();
    //
    public function moduleInit($type){
			if($type==1){
				$styleString='<style>
    		#videolist{float:left;width:100%; padding:0px;}
    		#videolist .childlist{ height:60px; border-bottom:1px solid #F00; padding:0px;}
    		#videolist .childlist ul{ list-style:none; margin:0px; padding:0px;}
    		#videolist .childlist li{ list-style:none; float:left; padding-left:5px; padding-top:5px;}
    		#videolist .childlist li img{ border:1px solid #30F;}
    		</style>';
    		$containerString="<div id='videolist'>%s</div>";	
			$childconString="<div class='childlist' style='background-color:%s'>
    		<ul>
    		<li><a href='%s'><img src=%s width='45' height='45' /></a></li>
    		<li><a href='%s'><img src=%s width='45' height='45' /></a></li>
    		<li><a href=%s>%s</a><p>%s</p></li>
    		</ul>
    		</div>";
    	
    		$data['styleString']=$styleString;
    		$data['containerString']=$containerString;
    		$data['childconString']=$childconString;
    		$data['fieldList'][0]=array('背景颜色CCC/red'=>'span');
    		$data['fieldList'][1]=array('图片一链接'=>'link');
    		$data['fieldList'][2]=array('图片一地址'=>'src');
    		$data['fieldList'][3]=array('图片二链接'=>'link');
    		$data['fieldList'][4]=array('图片二地址'=>'src');
    		$data['fieldList'][5]=array('标题链接'=>'link');
    		$data['fieldList'][6]=array('标题内容'=>'span');
    		$data['fieldList'][7]=array('简介内容'=>'p');
    		return $data;
			}
    }
    
    public function moduleHtml($fieldList){
    	foreach ($fieldList as $key=>$value) {
    	 	 if(is_array($value)){
    	 	 	foreach ($value as $k=>$v) {
    	 	  		if($v=='link'||$v=='span'||$v=='p'){
    	 	  			$html.=$k.'<input type="text" name="'.$k.'"></br>';
    	 	  		}
    	 	  		if($v=='src'){
    	 	  			$html.=$k.'<input type="file" name="'.$k.'"></br>';
    	 	  		}
    	 	  } 	
    	 	 }
    	}
    	return  $html;
    }
    public function moduleEditHtml($fieldList,$dataList){
    	foreach ($fieldList as $key=>$value) {
    		if(is_array($value)){
    			foreach ($value as $k=>$v) {
    				if($v=='link'||$v=='span'||$v=='p'){
    					$html.=$k.'<input type="text" name="'.$k.'" value="'.$dataList[$key].'"></br>';
    				}
    				if($v=='src'){
    					$html.=$k.'<img src="'.$dataList[$key].'"><input type="file" name="'.$k.'"><input type="hidden" name="old'.$k.'" value="'.$dataList[$key].'"></br>';
    				}
    			}
    		}
    	}
    	return  $html;
    }    
    
    /* DB */
    public function getOne($table,$where,$field='*'){
    	$sql=null;
    	$table=C('DB_PREFIX').$table;
    	$sql="SELECT $field FROM $table $where limit 1";
    	$result=M('')->query($sql);
    	return $result[0];
    }
    public function getAll($table,$where=null,$field='*',$limitType=false,$limit=0,$nums=15){
    	$sql=null;
    	$table=C('DB_PREFIX').$table;
    	$limitString=$limitType==true? "limit ".$limit.",".$nums : '';
    	$sql="SELECT $field FROM $table $where $limitString";
    	return M('')->query($sql);
    }
    public function InsertOne($table,$data){
		if(empty($table)||empty($data)) return false;
		$table=C('DB_PREFIX').$table;
		$insertKey=$insertVal=null;
		if(is_array($data)){
			foreach($data as $key => &$value){
				$insertKey.=empty($insertKey) ? $key :",".$key ;
				$insertVal.=empty($insertVal) ? "'".$value."'"  : ",'".$value."'" ;
			}
			$insertSql=null;
			$insertSql="INSERT INTO $table ($insertKey)values($insertVal)";
			return M('')->query($insertSql);
		}   	
    }
    public  function UpdateOne($table,$data,$where) {
    	if(empty($table)||empty($data)||empty($where)) return false;
    	$table=C('DB_PREFIX').$table;
    	$setString=null;
    	foreach($data as $key => &$value){
    		$setString.=empty($setString)? $key."='".$value."'" : ",".$key."='".$value."'";
    	}
    	$updateSql=null;
    	echo $updateSql="UPDATE  $table SET  $setString $where";
    	return M('')->query($updateSql);
    }
    /*  
     * @author Kontem
     * @date 2013-7-10
     * @name 模块组件的插入
     * @parameter $mdata模块组信息(array) $uploadPath图片上传路径 $parentId 父级id
     * @return true or false
     * */
    public function addmodules($mdata,$uploadPath=null,$parentId=null,$action='add') {
    	$uploadPath= !empty($uploadPath) ? $uploadPath : 'navupload/videomodule/' ;//初始化图片对应的路径
    	$result=array();
    	if(is_array($mdata['fieldList'])){
    		$tmp=array();
    		$tmp=$mdata['fieldList'];
    		foreach($tmp as $key => &$value){
    			if(is_array($value)){
    				$fieldKeyArr=array();
    				//单独获取组件元素类型
    				$fieldVal=array_values($value);
    				$fieldVal=$fieldVal[0];
    				//单独获取组件元素名称
    				$fieldKey=array_keys($value);
    				$fieldKey=$fieldKey[0];

    				if($fieldVal=='src'){
    					$tmpFile=$_FILES[$fieldKey]['tmp_name'];
    					$targetFile=$uploadPath . time() .".jpg";
    					if(move_uploaded_file($tmpFile, $targetFile)){
    						$result[]=$targetFile;
    					}else{
    						
    						if($action=='add'){
    							$result[]=null;
    						}else{
    							$result[]=$_POST["old".$fieldKey];
    						}
    					}
    				}else{
    					$result[]=$_POST[$fieldKey];
    				}
    			}
    		}
    	}
    	if($action=='add'){
    	/* 数据组件入库start */
    	$data=null;
    	$data=array(
    		'id'=>'','content'=>serialize($result),
    		'moduleid'=>$parentId,'sequence'=>$_POST['sequence']
    	);
		/*}}}end  */
    		return $this->InsertOne('nav_module_content',$data);
    	}elseif($action=='edit'){
				/* 数据组件入库start */
			$data = null;
			$data = array (
					'content' => serialize ( $result ),
					'sequence' => $_POST ['sequence'] 
			);
			/* }}}end */
			return $this->UpdateOne ( 'nav_module_content', $data, "where id=$parentId" );
    	}
    	//$mdata['childconString']=vsprintf($mdata['childconString'],$result);
    }
}
?>