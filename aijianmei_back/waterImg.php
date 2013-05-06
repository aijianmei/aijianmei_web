<?php
$uploadfile='test.jpg';
$waterImage='water.png';
$dir="data/uploads/2013/";
$filearr = read_dir_all( $dir );
print_r($dir);
imageWaterMark($uploadfile,9,$waterImage);


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
     //imagealphablending($ground_im, true);
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


function read_dir_all($dir) { 

 $ret = array('dirs'=>array(), 'files'=>array()); 
 #�ļ�����
 $confile = array('png','jpg','gif');
 #�Ƿ���Ŀ¼
 if(!is_dir( $dir )){
  return $ret;
 }
 
 if ($handle = opendir($dir)) { 
 
  while (false !== ($file = readdir($handle))) {
  
   if($file != '.' && $file !== '..') { 
   
    $cur_path = $dir . DIRECTORY_SEPARATOR . $file; 
    #��׺��������jpg��png��gif,
    $file_extre = explode(".", $cur_path);
    $filesort = array_pop($file_extre);
    if(!in_array(strtolower($filesort),$confile)){
     continue;
    }    
    if(is_dir($cur_path)) { 
    
     #�ݹ����
     $ret['dirs'][$cur_path] = read_dir_all($cur_path); 
     
    } else { 
    
     $ret['files'][] = $cur_path; 
    } 
   } 
  } 
  
  closedir($handle); 
 
 } 
 return $ret; 
}