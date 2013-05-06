<?php
class TrainAction extends Action {
    function show_banner(){			//banner 滚动图片列表
         $change_1="training_1.jpg";
         $change_2="training_2.jpg";
         $change_3="training_3.jpg";
         $change_4="training_4.jpg";
         $articleid_1="46";
         $articleid_2="52";
         $articleid_3="50";
         $articleid_4="96";
         $name_1="身体的三种不同类型";
         $name_2="锻炼肌肉的基本要素";
         $name_3="完美的健身伙伴";
         $name_4="8个开始体重训练的原因";
         $describe_1="人的身体有三种不同的体型：肥胖型体质、体育型体质和消瘦型体质。为了方便能更有针对性地训练，你要知道自己属于哪一种。";
         $describe_2="怎样是最好的训练方法呢？如果你的目标是多增加肌肉，那就按照下面这些基本训练方法，踏上获得强壮体型之路。";
         $describe_3="没有什么比带一个健身伙伴更能增加健身的高强度啊！一个了解你训练方式而且陪在你身边的健身伙伴是不可或缺的。";
         $describe_4="老实说，我们当中的很多人并没有时间一个星期去几次健身房，然后每次花个45分钟来健身。我有一个好消息给你们……";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
         $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
        //-------END--------
        }

    public function index()
    {
        $this->assign('cssFile', 'training');
        $map['channel'] = '2';
        $cate = M('article_category')->where($map)->findAll();
        foreach($cate as $c)
            if($c['parent'] == NULL) $parent[$c['id']] = $c;
        foreach($cate as $c) {
            if($c['parent'] != NULL) $parent[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        
        $articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
        foreach ($articles as $key => $value) {
            $articles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('articles', $articles);
        $this->assign('categories', $parent);
        //$this->display();
        
        //assign hotArticles
        $order = 'reader_count';
        $hotArticles = D('Article')->getTrainArticles($order);
        foreach ($hotArticles as $key => $value) {
            $hotArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        //print_r( $hotArticles);
        $this->assign('hotArticles', $hotArticles);
        
        //assign lastArticles		
        $order = 'create_time';
        $lastArticles = D('Article')->getTrainArticles($order);
        foreach ($lastArticles as $key => $value) {
            $lastArticles[$key]['CommNumber']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('lastArticles', $lastArticles);

        $this->show_banner();//显示banner
        $this->assign('headertitle', '锻炼');
		//header current add by kon at 20130415
		$this->assign('_current', 'train');
        $this->display();
    }
    
    public function articleList()
    {
        $id = intval($_GET['id']);
        $ordercon= $_GET['ordercon']?$_GET['ordercon']:'id';
        $timecon = $_GET['timecon']?$_GET['timecon']:'';
        $this->assign('cssFile', 'video');
        $this->assign('cssFile', 'training');
        $cate = M('article_category')->where(array('channel'=>'2', 'type'=>'1'))->findAll();
        
        foreach($cate as $c) {
            if($c['parent']==NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        
        //get hotArticles
        $order = 'reader_count';
        $hotArticles = D('Article')->getTrainArticles($order, $id);
        foreach($hotArticles as $key => $value){
            $hotArticles[$key]['recomnums']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('hotArticles', $hotArticles);
        //get lastArticles		
        $order = 'create_time';
        $hotArticles = D('Article')->getTrainArticles($order, $id);
        foreach($hotArticles as $key => $value){
            $hotArticles[$key]['recomnums']=D('Article')->getCountRecommentsById($value['id']);
        }
        $this->assign('lastArticles', $hotArticles);
        $this->assign('categories', $realCate);
        $map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
        
        $sqlcount="select aid as id from ai_article_category_group where category_id=$id union select id from ai_article where category_id=$id";
        $countArr = M('')->query($sqlcount);
        $count = count($countArr);
        $pager = api('Pager');
        $pager->setCounts($count);
        //$pager->styleInit($style);
        $pager->setList(7);
        $pager->makePage();
        $from = ($pager->pg-1) * $pager->countlist;
        //print_r($map);
        $categoryStr=is_array($map['category_id'])? $map['category_id'][1]:$map['category_id'];
        if($ordercon!='recomnums'){
            if($timecon){
                $dataArr=getDateInfo($timecon);
                $timeStr="and create_time >='".$dataArr['start']."' and create_time <='".$dataArr['end']."'";
            }
            $comtmpsql="select * from ai_article where category_id in ($categoryStr)  $timeStr order by $ordercon desc limit $from,$pager->countlist ";
            $articles=M('')->query($comtmpsql);
        }
        else{
            //$map['category_id']=array('in', '29,30,31');
            $comtmpsql="SELECT a. * , COUNT( b.id ) AS cnums FROM ai_article a LEFT JOIN ai_comments b ON a.id = b.parent_id
        WHERE a.category_id IN ($categoryStr) GROUP BY b.parent_id UNION SELECT * , 0 AS cnums FROM ai_article a WHERE category_id IN ($categoryStr) AND id NOT IN (SELECT parent_id FROM ai_comments)";
            $timeStr=null;
            if($timecon){
                $dataArr=getDateInfo($timecon);
                $timeStr="where  t.create_time >='".$dataArr['start']."' and t.create_time <='".$dataArr['end']."'";
            }
            $comtmpsql="select * from ($comtmpsql) t $timeStr order by t.cnums desc limit $from,$pager->countlist ";
            $articles=M('')->query($comtmpsql);
        }
        //print_r($articles);

        //M('')->query($articlesSql);
        $pageArray = (array)$pager;
        $articlesSQl="select * from ai_article where id in ($sqlcount) or category_id=$id group by id order by create_time limit $from,$pager->countlist";
        $articles = M('')->query($articlesSQl);
        //$articles = M('article')->where($map)->limit("$from,$pager->countlist")->findAll();
        $this->assign('pager', $pageArray);
        $this->assign('articles', $articles);
        $this->show_banner();//显示banner
        foreach($realCate as $k =>$v){
            foreach($v['children'] as $k1=>$v1){
                if($v1['id']==$id)
                {
                    
                    $this->assign('headertitle', $v1['name']);
                }
            }
        }
		$this->assign('_current', 'train');
        $this->display('list');
    }
    
    public function videoList()
    {
        $id = intval($_GET['id']);
        $this->assign('cssFile', 'video');
        $this->assign('cssFile', 'training');
        $cate = M('article_category')->where(array('channel'=>'2', 'type'=>'1'))->findAll();
        foreach($cate as $c) {
            if($c['parent']==NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        $this->assign('categories', $realCate);
        $map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
        $articles = M('article')->where($map)->findAll();
        $this->assign('articles', $articles);
        
        //get hotArticles
        $order = 'click';
        $hotArticles = D('Article')->getTrainArticles($order);
        foreach($hotArticles as $key => $value){
            $hotArticles[$key]['recommons']=D('Article')->getVideoCountRecommentsById($value['id']);
        }
        $this->assign('hotArticles', $hotArticles);
        //get lastArticles		
        $order = 'create_time';
        $lastArticles = D('Article')->getTrainArticles($order);
        foreach($lastArticles as $key => $value){
            $lastArticles[$key]['recommons']=D('Article')->getVideoCountRecommentsById($value['id']);
        }
        $this->assign('lastArticles', lastArticles);
        //最热视频
        $hot_video = D('Article')->getTrainVideo('click', $id);
        foreach($hot_video as $k=>$v) {
            $hotvideos[$k] = $v;
            $data = json_decode($this->getVideoData($v['link']));
            $hotvideos[$k]['logo'] = $data->data[0]->logo;
            $hotvideos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);            
        }
        //print_r($videos);
        $this->assign('hot_video', $hotvideos);
        
        //最新视频
        $new_video = D('Article')->getTrainVideo('create_time', $id);
        foreach($new_video as $k=>$v) {
            $newvideos[$k] = $v;
            $data = json_decode($this->getVideoData($v['link']));
            $newvideos[$k]['logo'] = $data->data[0]->logo;
            $newvideos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);            
        }
        $this->assign('new_video', $newvideos);
        
        // all video
        
        $pagenums=8;
        $page = (int) $_GET['pg']?(int) $_GET['pg']:0; 
        //$videos = D('Article')->getTrainVideo('id', $id);
        $sql = "select * from ai_video where category_id=".$id." order by id desc";
        $videosCountArr = M('')->query($sql);
        $counnums=count($videosCountArr);
        $pager = api('Pager');
        $pager->setCounts($counnums);
        $pager->setList($pagenums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;		
        $pagerArray = (array)$pager;
        $this->assign('pager', $pagerArray);
        $videos = M('')->query("select * from ai_video where category_id=".$id." order by id desc limit $from,$pager->countlist");
        foreach($videos as $k=>$v) {
            $videos[$k] = $v;
            $data = json_decode($this->getVideoData($v['link']));
            $videos[$k]['logo'] = $data->data[0]->logo;
            $videos[$k]['recommons']=D('Article')->getVideoCountRecommentsById($v['id']);            
        }
        $this->assign('videos', $videos);
        $this->show_banner();//显示banner
		$this->assign('_current', 'train');
        $this->display('vlist');
    }
    
    public function videoDetail()
    {
        $nums=7;
        $id = intval($_GET['id']);
        $pnum = intval($_GET['pg'])?intval($_GET['pg']):0;
        $table = (isset($_GET['from']) && $_GET['from']=='daily') ? 'daily_video' : 'video';
        $video = M($table)->where(array('id'=>$id))->find();
        if($table=='video') M('')->query('update `ai_video` set `click`=`click`+1 where `id`='.$id);
        
        $video['create_time']=date("Y-m-d H:i:s",$video['create_time']);
        $otherVideo=D('Article')->getVideoCategory($table,$video['category_id'],2);
		$videoLogoData=null;
        $videoLogoData=json_decode($this->getVideoData($video['link']));
		$video['logo'] = $videoLogoData->data[0]->logo;
        foreach($otherVideo as $k=>$v){
            $data = json_decode($this->getVideoData($v['link']));
            $otherVideo[$k]['CommNumber']=D('Article')->getVideoCountRecommentsById($v['id']);
            $otherVideo[$k]['logo'] = $data->data[0]->logo;
            $otherVideo[$k]['CommNumber']=$otherVideo[$k]['CommNumber']?$otherVideo[$k]['CommNumber']:0;
        }

        $getRecommentsSql="select * from ai_video_comments where pid=$id";
        $Recomments=M('')->query($getRecommentsSql);
        $cRecomnums=count($Recomments);
        $pager = api('Pager');
        $pager->setCounts(count($Recomments));
        //$pager->setStyle($style);
        $pager->setList($nums);
        $pager->makePage();
        $from = ($pager->pg -1) * $pager->countlist;		
        $pagerArray = (array)$pager;
        #$pagerArray['thestr']=printf($pagerArray['thestr'],$str);
        $this->assign('pager', $pagerArray);
        $cRecomnums=$cRecomnums?$cRecomnums:0;
        $this->assign('cRecomnums', $cRecomnums);
        $recommecntListSql="select a.*,b.uname as username from ai_video_comments a left join ai_user b on a.uid=b.uid where a.pid=$id order by a.create_time desc limit $pnum , $nums";
        $RecommentsList=M('')->query($recommecntListSql);
        foreach($RecommentsList as $key => $value){
            $getimgsql="select profileImageUrl from ai_others where uid='".$value['uid']."'";
            $getimgArr=M('')->query($getimgsql);
            if($getimgArr['profileImageUrl'])
            {
                $RecommentsList[$key]['img']=$getimgArr['profileImageUrl'];
            }
            else{
                if(is_file("data/uploads/avatar/".$value['uid']."/middle.jpg")){
                    $RecommentsList[$key]['img']="/data/uploads/avatar/".$value['uid']."/middle.jpg";
                }
                else{
                    $RecommentsList[$key]['img']="public/themes/newstyle/images/user_pic_middle.gif";
                }
            }
            $RecommentsList[$key]['create_time']=date("Y-m-d H:i:s",$RecommentsList[$key]['create_time']);
        }
        $this->assign('RecommentsList', $RecommentsList);
        $sql = "select * from ai_".$table." where category_id=$Category order by id desc limit 0,$nums";
        $result = M('')->query($sql);
        $this->assign('otherVideo', $otherVideo);
        //print_r($_SESSION);
        $this->assign('video', $video);
        $this->assign('cssFile', 'v');
		$this->assign('_current', 'train');
		$this->assign('_TrainVType','1');
        $this->display('video');
    }
    
    protected function getVideoData($link)
    {
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
        return $json;
    }
}
?>
