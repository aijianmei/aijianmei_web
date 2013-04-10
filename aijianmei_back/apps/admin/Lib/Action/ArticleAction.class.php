<?php 
class ArticleAction extends AdministratorAction {
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
				$waterImage='water.png';
				$this->imageWaterMark($_SERVER['DOCUMENT_ROOT'].'/public/images/article/'.$_FILES['img']['name'],9,$waterImage);
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
            $data['brief'] = t($_POST['brief']);
            $data['create_time'] = time();			

            
            if(!empty($data['link']) &&
               !empty($data['title'])) {
                
                if($data['id']>0) {
                    unset($data['create_time']);
                    unset($data['uid']);
                    M('video')->save($data);
                }else {
                    M('video')->add($data);
                }
                
                //$this->redirect('/index.php?app=admin&mod=Article&act=video');
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
            //$data['videos']  = t($_POST['videos']);
            $data['create_time'] = time();
            
            if(isset($_FILES['img']['name'])) {
                @move_uploaded_file($_FILES['img']['tmp_name'], '/var/www/html/aijianmei/public/article/'.$_FILES['img']['name']);
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
                $titles = $_POST['v_title'];
                $intros = $_POST['v_intro'];
                if(is_array($videos) && is_array($titles) && is_array($intros)) {
                    $length = min(array(count($videos), count($titles), count($intros)));
                    for($i=0;$i<=$length;$i++) {
                        if($videos[$i]!=''){
                        $vdata['daily_id'] = $vid;
                        $vdata['link'] = $videos[$i];
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
        //print_r($article);
        //print_r($videos);
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
        $daily = M('daily')->findAll();
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
	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000") 
	{ 
     $isWaterImage = FALSE; 
     $formatMsg = "�ݲ�֧�ָ��ļ���ʽ������ͼƬ���������ͼƬת��ΪGIF��JPG��PNG��ʽ��";
     //��ȡˮӡ�ļ� 
     if(!empty($waterImage) && file_exists($waterImage)) 
     { 
         $isWaterImage = TRUE; 
         $water_info = getimagesize($waterImage); 
         $water_w     = $water_info[0];//ȡ��ˮӡͼƬ�Ŀ� 
         $water_h     = $water_info[1];//ȡ��ˮӡͼƬ�ĸ�
         switch($water_info[2])//ȡ��ˮӡͼƬ�ĸ�ʽ 
         { 
             case 1:$water_im = imagecreatefromgif($waterImage);break; 
             case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
             case 3:$water_im = imagecreatefrompng($waterImage);break; 
             default:die($formatMsg); 
         } 
     }
     //��ȡ����ͼƬ 
     if(!empty($groundImage) && file_exists($groundImage)) 
     { 
         $ground_info = getimagesize($groundImage); 
         $ground_w     = $ground_info[0];//ȡ�ñ���ͼƬ�Ŀ� 
         $ground_h     = $ground_info[1];//ȡ�ñ���ͼƬ�ĸ�
         switch($ground_info[2])//ȡ�ñ���ͼƬ�ĸ�ʽ 
         { 
             case 1:$ground_im = imagecreatefromgif($groundImage);break; 
             case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
             case 3:$ground_im = imagecreatefrompng($groundImage);break; 
             default:die($formatMsg); 
         } 
     } 
     else 
     { 
         die("��Ҫ��ˮӡ��ͼƬ�����ڣ�"); 
     }
     //ˮӡλ�� 
     if($isWaterImage)//ͼƬˮӡ 
     { 
         $w = $water_w; 
         $h = $water_h; 
         $label = "ͼƬ��"; 
     } 
     else//����ˮӡ 
     { 
         $temp = imagettfbbox(ceil($textFont*2.5),0,"./cour.ttf",$waterText);//ȡ��ʹ�� TrueType ������ı��ķ�Χ 
         $w = $temp[2] - $temp[6]; 
         $h = $temp[3] - $temp[7]; 
         unset($temp); 
         $label = "��������"; 
     } 
     if( ($ground_w<$w) || ($ground_h<$h) ) 
     { 
         echo "��Ҫ��ˮӡ��ͼƬ�ĳ��Ȼ��ȱ�ˮӡ".$label."��С���޷�����ˮӡ��"; 
         return; 
     } 
     switch($waterPos) 
     { 
         case 0://��� 
             $posX = rand(0,($ground_w - $w)); 
             $posY = rand(0,($ground_h - $h)); 
             break; 
         case 1://1Ϊ���˾��� 
             $posX = 0; 
             $posY = 0; 
             break; 
         case 2://2Ϊ���˾��� 
             $posX = ($ground_w - $w) / 2; 
             $posY = 0; 
             break; 
         case 3://3Ϊ���˾��� 
             $posX = $ground_w - $w; 
             $posY = 0; 
             break; 
         case 4://4Ϊ�в����� 
             $posX = 0; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 5://5Ϊ�в����� 
             $posX = ($ground_w - $w) / 2; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 6://6Ϊ�в����� 
             $posX = $ground_w - $w; 
             $posY = ($ground_h - $h) / 2; 
             break; 
         case 7://7Ϊ�׶˾��� 
             $posX = 0; 
             $posY = $ground_h - $h; 
             break; 
         case 8://8Ϊ�׶˾��� 
             $posX = ($ground_w - $w) / 2; 
             $posY = $ground_h - $h; 
             break; 
         case 9://9Ϊ�׶˾��� 
             $posX = $ground_w - $w; 
             $posY = $ground_h - $h; 
             break; 
         default://��� 
             $posX = rand(0,($ground_w - $w)); 
             $posY = rand(0,($ground_h - $h)); 
             break;     
     }
     //�趨ͼ��Ļ�ɫģʽ 
     imagealphablending($ground_im, true);
     if($isWaterImage)//ͼƬˮӡ 
     { 
         imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//����ˮӡ��Ŀ���ļ�         
     } 
     else//����ˮӡ 
     { 
         if( !empty($textColor) && (strlen($textColor)==7) ) 
         { 
             $R = hexdec(substr($textColor,1,2)); 
             $G = hexdec(substr($textColor,3,2)); 
             $B = hexdec(substr($textColor,5)); 
         } 
         else 
         { 
             die("ˮӡ������ɫ��ʽ����ȷ��"); 
         } 
         imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));         
     }
     //����ˮӡ���ͼƬ 
     @unlink($groundImage); 
     switch($ground_info[2])//ȡ�ñ���ͼƬ�ĸ�ʽ 
     { 
         case 1:imagegif($ground_im,$groundImage);break; 
         case 2:imagejpeg($ground_im,$groundImage);break; 
         case 3:imagepng($ground_im,$groundImage);break; 
         default:die($errorMsg); 
     }
     //�ͷ��ڴ� 
     if(isset($water_info)) unset($water_info); 
     if(isset($water_im)) imagedestroy($water_im); 
     unset($ground_info); 
     imagedestroy($ground_im); 
}
}
?>