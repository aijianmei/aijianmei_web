<?php 
class ArticleModel extends Model {
    public function getArticles()
    {
        $sql = "select a.id,a.title,c.name as category,a.author,a.source,a.content,a.create_time,a.keyword,a.is_promote from ai_article as a
                left join ai_article_category as c on c.id=a.category_id";
        $articles = M('')->query($sql);
        return $articles;
    }
    
    public function getVideos()
    {
        $sql = "select v.id,v.title,v.brief,v.link,c.name as category,v.create_time as ctime from ai_video as v
                left join ai_article_category as c on c.id=v.category_id";
        
        $videos = M('')->query($sql);
        return $videos;
    }
    public function insertArticeGroup($id,$category_id)
    {
        $sql = "INSERT INTO ai_article_category_group(aid,category_id)  SELECT $id,$category_id  FROM ai_article_category_group WHERE NOT EXISTS(
        SELECT aid,category_id FROM ai_article_category_group WHERE aid=$id and category_id=$category_id) limit 1";
        $result = M('')->query($sql);
        return $result;
    }
    public function addArticeGroup($id,$category_id){
        $sql = "INSERT INTO ai_article_category_group (aid,category_id) VALUES ($id,$category_id)";
        $result = M('')->query($sql);
        return $result;
    }
    public function cleanArticeGroup($id){
        $sql="delete from ai_article_category_group where aid=$id";
        $result = M('')->query($sql);
        return $result;
    }
    public function getArticeGroup($id,$ownCategory_id=null){
        $sql="select a.aid,a.category_id,b.name from ai_article_category_group a left join ai_article_category b on a.category_id=b.id where a.aid=$id";
        $result = M('')->query($sql);
        if(!empty($ownCategory_id)){
            foreach($result as $key =>$value){
                if($value['category_id']==$ownCategory_id) unset($result[$key]);
            }
        }
        return $result;
    }
}
?>