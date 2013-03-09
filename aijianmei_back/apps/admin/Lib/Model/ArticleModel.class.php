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
}
?>