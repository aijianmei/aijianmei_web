<?php
class NutriAction extends Action {
    function show_banner(){
             $change_1="nutri_1.jpg";
         $change_2="nutri_2.jpg";
         $change_3="nutri_3.jpg";
         $change_4="nutri_4.jpg";
         $articleid_1="26";
         $articleid_2="34";
         $articleid_3="41";
         $articleid_4="32";
         $name_1="6个燃脂的提示";
         $name_2="7个肌肉养成的营养规则";
         $name_3="初学者运动前的营养指导 ";
         $name_4="制定减肥目标";
         $describe_1="燃脂需要一个专门针对你自身营养和锻炼的方法。营养是修长身材的基础，而锻炼就像是是把所有因素凝聚起来的催化剂。如果你能按照下面列出来的6个提示去办，你便能有效地减少你身上多余的脂肪…";
         $describe_2="7个肌肉养成的营养规则
营养领域是一个完全不同的世界，计算卡路里和大量营养素的比例可要比在健身房里做几组运动难多了。下面我将会列出一些基本的原则来帮助你踏上正轨
";
         $describe_3="一个健康好看的身型不是从你进入健身房那一刻才开始形成的。下面我会教你如何在健身前吸收营养，让你甩掉脂肪和增加肌肉。";
         $describe_4="你没有理由放弃，我会帮助你，通过提供有用的信息跟你一起达到你的目标。现在开始制定一个目标，读下面的文字，接着付诸行动……";
         $this->assign('change_1',$change_1);
         $this->assign('change_2',$change_2);
         $this->assign('change_3',$change_3);
         $this->assign('change_4',$change_4);
         $this->assign('articleid_1',$articleid_1);
         $this->assign('articleid_2',$articleid_2);
         $this->assign('articleid_3',$articleid_3);
         $this->assign('articleid_4',$articleid_4);
          $this->assign('describe_1',$describe_1);
         $this->assign('describe_2',$describe_2);
         $this->assign('describe_3',$describe_3);
         $this->assign('describe_4',$describe_4);
         $this->assign('name_1',$name_1);
         $this->assign('name_2',$name_2);
         $this->assign('name_3',$name_3);
         $this->assign('name_4',$name_4);
        //-------END--------	

    }
    public function index()
    {
        $map['channel'] = '3';
        $cate = M('article_category')->where($map)->findAll();
        foreach($cate as $c) {
            if($c['parent'] == NULL) $parent[$c['id']] = $c;
            else $parent[$c['parent']]['children'][] = $c; 
            $cate_id[] = $c['id'];
        }
        $articles = M('article')->where(array('category_id'=>array('in', implode(',', $cate_id))))->order('id desc')->limit(8)->findAll();
        $this->assign('articles', $articles);
        $this->assign('categories', $parent);
        
        
        /*$cate = M('article_category')->where(array('channel'=>'3'))->order('id desc')->limit(8)->findAll();
        foreach($cate as $c) {
            if($c['parent'] == NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
        }*/
        
        $order = 'reader_count';
        $hotArticles = D('Article')->getNutriArticles($order);
        $this->assign('hotArticles', $hotArticles);
        //print_r($hotArticles);
        
        $lastArticles = D('Article')->getNutriArticles('create_time');
        $this->assign('lastArticles', $lastArticles);
        //print_r($lastArticles);
        //print_r($realCate);
        //$this->assign('categories', $realCate);
        //$this->assign('cate', $cate);
        $this->assign('cssFile', 'training');
        $this->show_banner();//banner 滚动图片列表
        $this->display();
    }
    
    public function articleList()
    {
        $id = intval($_GET['id']);
        
        $cate = M('article_category')->where(array('channel'=>'3'))->findAll();
        foreach($cate as $c) {
            if($c['parent'] == NULL) $realCate[$c['id']] = $c;
            else $realCate[$c['parent']]['children'][] = $c;
            $cate_id[] = $c['id'];
        }
        $map['category_id'] = $id ? $id : array('in', implode(',', $cate_id));
        
        $count = M('article')->where($map)->count();
                $style['pre'] = 'prev';
                $style['next'] = 'next';
                $style['current'] = 'current_page';
        $pager = api('Pager');
        $pager->setCounts($count);
        //$pager->styleInit($style);
        $pager->setList(6);
        $pager->makePage();
        $from = ($pager->pg-1) * $pager->countlist;
        $articles = M('article')->where($map)->limit("$from,$pager->countlist")->findAll();               
        $pageArray = (array)$pager;
        $this->assign('pager', $pageArray);
        //var_dump($articles);
        
        //get hotArticles
        $order = 'reader_count';
        $hotArticles = D('Article')->getNutriArticles($order, $id);
        foreach($hotArticles as $key => $value){
            $sql=null;$numsArr=null;
            $sql="select count(*) as nums from ai_comments where parent_id=".$value['id'];
            $numsArr= M('')->query($sql);
            $hotArticles[$key]['recomnums']=$numsArr['nums'];
        }
        $this->assign('hotArticles', $hotArticles);
        //print_r($hotArticles);
        //get lastArticles
        $lastArticles = D('Article')->getNutriArticles('create_time', $id);
        foreach($lastArticles as $key => $value){
            $sql=null;$numsArr=null;
            $sql="select count(*) as nums from ai_comments where parent_id="$value['id'];
            $numsArr= M('')->query($sql);
            $lastArticles[$key]['recomnums']=$numsArr['nums'];
        }
        $this->assign('lastArticles', $lastArticles);
        $this->assign('articles', $articles);
        $this->assign('categories', $realCate);
        //$this->assign('cssFile', 'video');
        $this->assign('cssFile', 'training');
        
        $this->show_banner();//banner 滚动图片列表
        $this->display('list');
    }
    
    /*public function videoList()
    {
        $id = intval($_GET['id']);
        $this->display();
    }*/
    
    //get append video list
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
        $hotArticles = D('Article')->getNutriArticles($order);
        $this->assign('hotArticles', $hotArticles);
        //print_r($hotArticles);
        //get lastArticles
        $lastArticles = D('Article')->getNutriArticles('create_time');
        $this->assign('lastArticles', $lastArticles);
        $this->show_banner();//banner 滚动图片列表
        $this->display('vlist');
    }
    
    //get append video detail
    public function videoDetail()
    {
        $id = intval($_GET['id']);
        $table = (isset($_GET['from']) && $_GET['from']=='daily') ? 'daily_video' : 'video';
        $video = M($table)->where(array('id'=>$id))->find();
        //$videoInfo = D('Article')->getVideoInfoByLink($video['link']);
        //print_r($video);
        //$this->assign('videoInfo', $videoInfo);
        $this->assign('video', $video);
        $this->assign('cssFile', 'v');
        $this->display('video');
    }
}
?>
