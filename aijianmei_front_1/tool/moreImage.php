 <?php

$data['postData']=$_POST;
if($_POST['type']=='jumpDate'){

$data['PreImage']= date("Ymd",strtotime($_POST['date'])-86400).'.jpg';
$data['NowImage']= $_POST['date'].'.jpg';
$data['NextImage']= date("Ymd",strtotime($_POST['date'])+86400).'.jpg';

}else{
	$data['image']= $_POST['date'].'.jpg';
}
echo json_encode($data);
exit(); 