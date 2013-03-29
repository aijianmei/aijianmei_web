<?php
// 分页类
class PagerApi extends Api {
	//IE地址栏地址
	var $url;
	//记录总条数
	var $countall;
	//总页数
	var $page;
	//分页数字链接
	var $thestr;
	//首页、上一页链接
	var $backstr;
	//尾页、下一页链接
	var $nextstr;
        //跳转页面链接
        var $topgstr;
	//当前页码
	var $pg;
	//每页显示记录数量
	var $countlist;
        //默认样式
        var $style;

        //----------------------------------------------------------------------
        
	/**
         * 构造函数，实例化该类的时候自动执行该函数
         *
         * @param <int> $countall 总页数
         * @param <int> $countlist 每页显示数
         */
	function __construct($countall=0, $countlist=20){
		//记录数与每页显示数不能整队时，页数取余后加1
		$this->countall = $countall;
		$this->countlist = $countlist;
		$this->styleInit();
	}

        //----------------------------------------------------------------------

        /**
         * 初始化/设置 样式
         *
         * @param <array> $style
         *  - pre ‘上一页’样式
         *  - num 数字页码样式
         *  - next '下一页'样式
         *  - current ‘当前页’样式
         */
        public function styleInit($style=array())
        {
                $this->style['pre']=isset($style['pre'])?$style['pre']:'';
                $this->style['num']=isset($style['num'])?$style['num']:'';
                $this->style['next']=isset($style['next'])?$style['next']:'';
                $this->style['current']=isset($style['current'])?$style['current']:'';
        }

        //----------------------------------------------------------------------
        
        /**
         * 生成分页html代码
         */
	public function makePage()
	{
		if ($this->countall%$this->countlist!=0){
			$this->page=sprintf("%d",$this->countall/$this->countlist)+1;
		}else{
			$this->page=$this->countall/$this->countlist;
		}
		
		$this->pg=$_GET["pg"];
		//保证pg在未指定的情况下为从第1页开始
		if (!ereg("^[1-9][0-9]*$",$this->pg) || empty($this->pg)){
			$this->pg=1;
		}
		//页码超出最大范围，取最大值
		if ($this->pg>$this->page){
			$this->pg=$this->page;
		}
		//得到当前的URL。具体实现请看最底部的函数实体
		$this->url = $this->getUrl();
		//替换错误格式的页码为正确页码
		if(isset($_GET["pg"]) && $_GET["pg"]!=$this->pg){
			$this->url=str_replace("?pg=".$_GET["pg"],"?pg=$this->pg",$this->url);
			$this->url=str_replace("&pg=".$_GET["pg"],"&pg=$this->pg",$this->url);
		}
		//生成12345等数字形式的分页。
		if ($this->page<=10){
			for ($i=1;$i<$this->page+1;$i++){
				$this->thestr=$this->thestr.$this->makepg($i,$this->pg);
			}
		}else{
			if ($this->pg<=5){
				for ($i=1;$i<10;$i++){
					$this->thestr=$this->thestr.$this->makepg($i,$this->pg);
				}
			}else{
				if (6+$this->pg<=$this->page){
					for ($i=$this->pg-4;$i<$this->pg+6;$i++){
						$this->thestr=$this->thestr.$this->makepg($i,$this->pg);
					}
				}else{
					for ($i=$this->pg-4;$i<$this->page+1;$i++){
						$this->thestr=$this->thestr.$this->makepg($i,$this->pg);
					}
		
				}
			}
		}
		//生成上页下页等文字链接
		$this->backstr = $this->gotoback($this->pg);
		$this->nextstr = $this->gotonext($this->pg,$this->page);
		/*echo (" 共".$this->countall." 条,每页".$this->countlist."条，共".$this->page."页".$this->backstr.$this->thestr.$this->nextstr); */
	}
	
        //----------------------------------------------------------------------

	/**
         * 设置记录总数
         * 
         * @param <int> $total
         */
	public function setCounts($total)
	{
		$this->countall = $total;
	}
	
        //----------------------------------------------------------------------

	/**
         * 设置样式
         * 
         * @param <array> $style
         */
	public function setStyle($style)
	{
                $this->style=$style;
	}

        //----------------------------------------------------------------------

	/**
         * 设置每页显示的记录数
         * 
         * @param <int> $list
         */
	public function setList($list)
	{
		$this->countlist = $list;
	}

        //----------------------------------------------------------------------

	/**
         * 生成数字分页的辅助函数
         *
         * @param <int> $i 需要生成的页序数
         * @param <int> $pg 当前页序数
         * @return <string> 数字分页的html
         */
	function makepg($i,$pg){
		if ($i==$pg){
			return " <a class='".$this->style['current']."'>".$i."</a>";
		}else{
			return " <a href=".PagerApi::replacepg($this->url,5,$i)." class='".$this->style['num']."'>".$i."</a>";
		}
	}

        //----------------------------------------------------------------------

	/**
         * 生成上一页等信息的函数
         *
         * @param <int> $pg 当前页序数
         * @return <string> ’上一页‘的html代码
         */
	function gotoback($pg){
		if ($pg-1>0){
			return $this->gotoback="<a href=".$this->replacepg($this->url,2,0)." class='".$this->style['pre']."'>上一页</a>";
		}else{
			return $this->gotoback="<a class='".$this->style['pre']."'>上一页</a> ";
		}
	}
        //<a href=".$this->replacepg($this->url,3,0)." class='".$this->style."'>首页</a>

        //----------------------------------------------------------------------

	/**
         * 生成下一页等信息的函数
         *
         * @param <int> $pg 当前页序数
         * @param <int> $page 总页数
         * @return <string> ’下一页‘的html代码
         */
	function gotonext($pg,$page){
		if ($pg < $page){
			return " <a href=".$this->replacepg($this->url,1,0)." class='".$this->style['next']."'>下一页</a>";
		}else{
			return " <a class='".$this->style['next']."'>下一页</a>";
		}
	}
        // <a href=".$this->replacepg($this->url,4,0)." class='".$this->style."'>尾页</a>
        
        //----------------------------------------------------------------------

	/**
         * 处理url中$pg的方法,用于自动生成pg=x
         *
         * @param <string> $url 需要被处理的url
         * @param <int> $flag 处理情况
         *  - 1 生成下一页的链接
         *  - 2 生成上一页的链接
         *  - 3 生成第一页的链接
         *  - 4 生成当前页的链接
         *  - 5 生成第n页的链接
         * @param <int> $i 需要生成的第n页页序数
         *  - 只在flag=5时需要，平时设0
         * @return <string> $url 链接
         */
	function replacepg($url,$flag,$i){
		if ($flag == 1){
			$temp_pg = $this->pg;
			return str_replace("pg=".$temp_pg,"pg=".($this->pg+1),$url);
		}else if($flag == 2) {
			$temp_pg = $this->pg;
			return str_replace("pg=".$temp_pg,"pg=".($this->pg-1),$url);
		}else if($flag == 3) {
			$temp_pg = $this->pg;
			return str_replace("pg=".$temp_pg,"pg=1",$url);
		}else if($flag == 4){
			$temp_pg = $this->pg;
			return str_replace("pg=".$temp_pg,"pg=".$this->page,$url);
		}else if($flag == 5){
			$temp_pg = $this->pg;
			return str_replace("pg=".$temp_pg,"pg=".$i,$url);
		}else{
			return $url;
		}
	}

        //----------------------------------------------------------------------

	/**
         * 获得当前URL的方法
         *
         * @return <string> $url
         */
	function getUrl(){
		$url="http://".$_SERVER["HTTP_HOST"];
		if(isset($_SERVER["REQUEST_URI"])){
			$url.=$_SERVER["REQUEST_URI"];
		}else{
			$url.=$_SERVER["PHP_SELF"];
			if(!empty($_SERVER["QUERY_STRING"])){
				$url.="?".$_SERVER["QUERY_STRING"];
			}
		}
		//在当前的URL里加入pg=x字样
		if (!ereg("(pg=|PG=|pG=|Pg=)", $url)){
			if (!strpos($url,"?")){
				$url = $url."?pg=1";
			}else{
				$url = $url."&pg=1";
			}
		}
		return $url;
	}
		
}