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
        $sql = "select d.id,d.title,d.img,d.content,d.create_time,d.gotime,d.like,d.unlike,d.read_count,v.id as vid,v.title as vtitle,v.link,v.wapurl,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.channel=".$channel." and d.gotime<".time()." ORDER BY d.create_time DESC  limit ".$limit.",".$nums." ";
		$cacheid=md5($sql);
        $daily=$this->getDataCache($cacheid);
		if(!$daily){
		
        $result = M('')->query($sql);
        
        $parser = api('UrlParser');		
        //$info = $parser->getVideoInfo('http://v.youku.com/v_playlist/f12280371o1p0.html');
        //var_dump($info);
        
			foreach ($result as $r) {
            //$info = $parser->getVideoInfo($r['link']);
			//$infogetVideoData($link)
			$data = json_decode($this->getVideoData($r['link']));
			$info['img'] = $data->data[0]->logo;
            if($daily[$r['id']]) {
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>($r['link']!='null'?$r['link']:''), 'wapurl'=>($r['wapurl']!='null'?$r['wapurl']:''), 'intro'=>$r['intro'], 'img'=>$info['img'], 'read_count'=>$r['read_count']);
            }else {
                $daily[$r['id']]['article'] = array('id'=>$r['id'], 'title'=>$r['title'], 'img'=>$r['img'], 'content'=>$r['content'], 'ctime'=>$r['create_time'],'gotime'=>$r['gotime'], 'like'=>$r['like'], 'unlike'=>$r['unlike'],'read_count'=>$r['read_count']);
                $daily[$r['id']]['video'][] = array('id'=>$r['vid'], 'title'=>$r['vtitle'], 'link'=>($r['link']!='null'?$r['link']:''),'wapurl'=>($r['wapurl']!='null'?$r['wapurl']:''), 'intro'=>$r['intro'], 'img'=>$info['img']);
            }
            
            $daily[$r['id']]['comments'] = $this->getDailyComments($r['id']);
			}
        $this->setDataCache($cacheid,$daily);
        
		}
		return $daily;
    }
    
    public function getDaily($channel)
    {
        $sql = "select d.id,d.title,d.img,d.content,d.create_time,d.like,d.unlike,v.id as vid,v.title as vtitle,v.link,v.intro from ai_daily as d
                left join ai_daily_video  as v on v.daily_id=d.id 
                where d.channel=".$channel." and d.gotime<".time()." ORDER BY d.create_time DESC";
        
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
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
            $sql = "select a.* from ai_article a where id in ($orderTableSql) or category_id=$id group by a.id  order by ".$order." desc limit 0,8";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
            $sql = "select a.* from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.".$order." desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    public function getTrainArticlesList($order,$id=null,$limit,$nums)
    {
        if($id) {
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
            $sql = "select a.* from ai_article a where id in ($orderTableSql) or category_id=$id group by a.id  order by ".$order." desc limit ".$limit.",".$nums."";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
            $sql = "select a.* from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.".$order." desc limit ".$limit.",".$nums."";
        }
        $cacheid=md5($sql);
		$result=null;
		$result=$this->getDataCache($cacheid);
		if(!$result){
			$result = M('')->query($sql);
			foreach ($result as $key => $value) {
				$result[$key]['CommNumber']=$this->getCountRecommentsById($value['id']);
			}
			$this->setDataCache($cacheid,$result);
		}
        return $result;
    }
    public function getArticlesListType($order,$id=null,$limit,$nums,$type=null)
    {
        if($id) {
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id in ($id)";
            $sql = "select a.* from ai_article a where id in ($orderTableSql) or category_id=$id group by a.id  order by ".$order." desc limit ".$limit.",".$nums."";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =$type";
            $sql = "select a.* from ai_article a ,($orderTableSql) t where a.id=t.aid group by a.id order by a.".$order." desc limit ".$limit.",".$nums."";
        }
        $cacheid=md5($sql);
		$result=null;
		$result=$this->getDataCache($cacheid);
		if(!$result){
			$result = M('')->query($sql);
			foreach ($result as $key => $value) {
				$result[$key]['CommNumber']=$this->getCountRecommentsById($value['id']);
			}
			$this->setDataCache($cacheid,$result);
		}
        return $result;
    }	
    public function getTrainVideo($order,$id=null)
    {
        if($id) {
            $sql = "select v.* from ai_video v where v.category_id=".$id."  order by ".$order." desc limit 0,8";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
            $sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;	
    }
    public function getTrainVideoList($order,$id=null,$limit,$nums)
    {
        if($id) {
            $sql = "select v.* from ai_video v where v.category_id=".$id."  order by ".$order." desc limit ".$limit.",".$nums."";

        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =2";
            $sql = "select v.* from ai_video v,($orderTableSql) t where v.category_id=t.aid  order by $order desc limit ".$limit.",".$nums."";
        }
		$cacheid=md5($sql);
		$result=null;
		$result=$this->getDataCache($cacheid);
		if(!$result){
			$result = M('')->query($sql);
			foreach ($result as $key => $value) {
				$data =null;
				$data = json_decode($this->getVideoData($value['link']));
				$result[$key]['logo'] = $data->data[0]->logo;
				$result[$key]['CommNumber']=$this->getVideoCountRecommentsById($value['id']);
			}
			$this->setDataCache($cacheid,$result);
		}
        return $result;	
    }
    
    public function getNutriArticles($order, $id=null)
    {
        if($id) {
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id=$id";
            $sql = "select a.* from ai_article a where id in ($orderTableSql) group by a.id order by ".$order." desc limit 0,8";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =3";
            $sql = "select a.* from ai_article a,($orderTableSql) t where a.id=t.aid group by a.id order by $order desc limit 0,8";
        }
        $result = M('')->query($sql);
        
        return $result;
    }
    
    public function getAppendArticles($order, $id=null)
    {
        if($id) {
            $orderTableSql="SELECT aid FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND a.category_id=$id";
            $sql = "select a.* from ai_article a where a.id in ($orderTableSql) group by a.id order by ".$order." desc limit 0,8";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =4";
            $sql = "select a.* from ai_article a,($orderTableSql) t where a.id=t.aid group by a.id order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    
    public function getAppendVideo($order, $id=null)
    {
        if($id) {
            $sql = "select v.* from ai_video v where v.category_id=".$id." order by ".$order." desc limit 0,8";
        }else {
            $orderTableSql="SELECT a.* FROM ai_article_category_group a, ai_article_category c WHERE a.category_id = c.id AND c.channel =4";
            $sql = "select v.* from ai_video v,($orderTableSql) t  where  v.id=t.aid order by $order desc limit 0,8";
        }
        
        $result = M('')->query($sql);
    
        return $result;
    }
    
    
    protected function getDailyComments($id)
    {
        $sql = "select * from ai_comments where parent_type='4' and parent_id=".$id;
		//$sql = "select * from ai_video_comments where pid=".$id;
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
    public function getCountRecommentsById($id)
    {
        $sql=null;$numsArr=null;
        $sql="select count(*) as nums from ai_comments where parent_id=".$id;
        $numsArr= M('')->query($sql);
        return !empty($numsArr[0]['nums'])?$numsArr[0]['nums']:0;
    }
    
    public function getVideoCategory($table,$Category,$nums){
        $sql = "select * from ai_".$table." where category_id=$Category order by id desc limit 0,$nums";
        $result = M('')->query($sql);
        return $result;
    }
    public function getVideoCountRecommentsById($id)
    {
        $sql=null;$numsArr=null;
        $sql="select count(*) as nums from ai_video_comments where pid=".$id;
        $numsArr= M('')->query($sql);
        return !empty($numsArr[0]['nums'])?$numsArr[0]['nums']:0;
    }
    public function getArticlesid($category_id){
        if(is_array($category_id)){
          foreach($category_id as $key=>$value){
              $vstr.=empty($vstr)?$value:",".$value;
          }
          $category_id=$vstr;
        }
        $sql="select aid from ai_article_category_group where category_id in ($category_id)";
        return $Articlesids = M('')->query($sql);
    }

    /**
     * 获取底部页面内容
     *
     * @param <int> $id 底部内容ID
     * @return <boolean> FALSE ID对应内容不存在
     * @return <string> ID对应的内容
     */
    public function getFooterContent($id){
        $sql = "select content from ai_footer where id=$id";
        $query = M('')->query($sql);
        if (empty($query)) return FALSE;
        return $query[0]['content'];
    }
	public function getVideoData($link)
	{
        $id = str_replace('http://player.youku.com/player.php/sid/', '', $link);
        $id = str_replace('/v.swf', '', $id);
        $url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id.'/version/5/source/out?onData=%5Btype%20Function%5D&n=3';
        $json = file_get_contents($url);
        return $json;
	}
}
?>