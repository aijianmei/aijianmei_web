<?php 
class ArticleModel extends Model {
    public function getAllArticles()
    {
        
    }
    
/*
*functionname getDailyLimit
*@author kontem
*@date 2013-03-29
*@getDaily for pages  
*/
    public function getDailyLimit($channel,$limit,$nums)
    {
        $sql = "select d.id,d.title,d.img,d.content,d.create_time,d.like,d.unlike,v.id as vid,v.title as vtitle,v.link,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.channel=".$channel." ORDER BY d.create_time DESC";
        
        $result = M('')->query($sql);
        
        $parser = api('UrlParser');		
        //$info = $parser->getVideoInfo('http://v.youku.com/v_playlist/f12280371o1p0.html');
        //var_dump($info);
        
        foreach ($result as $r) {
            $info = $parser->getVideoInfo($r['link']);
            if($daily[$r['id']]) {
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>$r['link'], 'intro'=>$r['intro'], 'img'=>$info['img']);
            }else {
                $daily[$r['id']]['article'] = array('id'=>$r['id'], 'title'=>$r['title'], 'img'=>$r['img'], 'content'=>$r['content'], 'ctime'=>$r['create_time'], 'like'=>$r['like'], 'unlike'=>$r['unlike']);
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>$r['link'], 'intro'=>$r['intro'], 'img'=>$info['img']);
            }
            
            $daily[$r['id']]['comments'] = $this->getDailyComments($r['id']);
        }
        
        return $daily;
    }
    
    public function getDaily($channel)
    {
        $sql = "select d.id,d.title,d.img,d.content,d.create_time,d.like,d.unlike,v.id as vid,v.title as vtitle,v.link,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.channel=".$channel." ORDER BY d.create_time DESC";
        
        $result = M('')->query($sql);
        
        $parser = api('UrlParser');		
        //$info = $parser->getVideoInfo('http://v.youku.com/v_playlist/f12280371o1p0.html');
        //var_dump($info);
        
        foreach ($result as $r) {
            $info = $parser->getVideoInfo($r['link']);
            if($daily[$r['id']]) {
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>$r['link'], 'intro'=>$r['intro'], 'img'=>$info['img']);
            }else {
                $daily[$r['id']]['article'] = array('id'=>$r['id'], 'title'=>$r['title'], 'img'=>$r['img'], 'content'=>$r['content'], 'ctime'=>$r['create_time'], 'like'=>$r['like'], 'unlike'=>$r['unlike']);
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>$r['link'], 'intro'=>$r['intro'], 'img'=>$info['img']);
            }
            
            $daily[$r['id']]['comments'] = $this->getDailyComments($r['id']);
        }
        
        return $daily;
    }
    
    //get hotArticles or lastArticles
    public function getTrainArticles($order,$id=null)
    {
        if($id) {
            $sql = "select a.* from ai_article a where a.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $sql = "select a.* from ai_article a,ai_article_category c where c.channel=2 and a.category_id=c.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    
    public function getTrainVideo($order,$id=null)
    {
        if($id) {
            $sql = "select v.* from ai_video v where v.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $sql = "select v.* from ai_video v,ai_article_category c where c.channel=2 and v.category_id=c.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;	
    }
    
    public function getNutriArticles($order, $id=null)
    {
        if($id) {
            $sql = "select a.* from ai_article a where a.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $sql = "select a.* from ai_article a,ai_article_category c where c.channel=3 and a.category_id=c.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
        
        return $result;
    }
    
    public function getAppendArticles($order, $id=null)
    {
        if($id) {
            $sql = "select a.* from ai_article a where a.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $sql = "select a.* from ai_article a,ai_article_category c where c.channel=4 and a.category_id=c.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    
    public function getAppendVideo($order, $id=null)
    {
        if($id) {
            $sql = "select v.* from ai_video v where v.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $sql = "select v.* from ai_video v,ai_article_category c where c.channel=4 and v.category_id=c.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    
    
    protected function getDailyComments($id)
    {
        $sql = "select * from ai_comments where parent_type='4' and parent_id=".$id;
        $result = M('')->query($sql);
        
        foreach ($result as $r) {
            $comments[$r['id']] = $r;
            $comments[$r['id']]['userInfo'] = getUserInfo($r['uid']);
        }
        
        return $comments;
    }
    
    public function getVideoImgById($id)
    {
        $parse = api('UrlParser');
        $video = M('daily_video')->where(array('id'=>$id))->find();
        $info = $parse->getVideoInfo($video['link']);
        //print_r($info);
        if( empty($info) || $info==null) return null;
        return $info['img'];
    }
    
    public function getVideoInfoByLink($link)
    {	
        
        $parse = api('UrlParser');
        
        $info = $parse->getVideoInfo($link);
        
        return $info;
    }
    
    public function getGym()
    {
        $sql = "select * from ai_user u,ai_gym g where g.uid=u.uid";
        $result = M('')->query($sql);
        
        return $result;
    }
    
    public function getCoach()
    {
        $sql = "select * from ai_user u,ai_coach c where c.uid=u.uid";
        $result = M('')->query($sql);
        
        return $result;
    }
}
?>