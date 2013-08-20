<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>爱健美IOS客户端下载</title>
<script type="text/javascript" src="Templates/tool/js/jquery.js"></script>
<style>
html,body{height:100%;}
body,div,ul{ padding:0px; margin:0px;}
ul{list-style:none;}
#sub{  position: absolute;z-index:2; background:url(Templates/images/appdownloadbutton.png); width:300px; height:80px;left:25%;}
#backImage{position:absolute;z-index:1; margin:0px; width:100%; height:100%}
#intro{width:300px;height:588px;background:url(Templates/images/appc_bg.png) no-repeat;position:absolute;right:25%;z-index:1000;}
#inner{position: absolute;top: 101px;left: 21px;}
</style>
<script type="text/javascript">
	window.onload = function(){
		var bodyHeight =  document.body.clientHeight,
			sub = document.getElementById("sub"),
			intro = document.getElementById("intro");
		intro.style.top = (bodyHeight-588)/2 + "px";
		sub.style.bottom = (bodyHeight-588)/2 + "px";
		
		setInterval(randImg,3000);
	}
	function randImg(){
		var lists = document.getElementsByTagName("LI"),
			_len = lists.length,
			j;
		for(var i=0;i<_len;i++){
			if(lists[i].style.display == "block"){
				lists[i].style.display = "none";
				if(i == (_len-1))
					j = 0;
				else 
					j = i+1;
				lists[j].style.display = "block";
				break;
			}
		}
		
	}
</script>
</head>


<body>
<img src="Templates/images/appdownload_<?php echo rand(1,3);?>.jpg"  id="backImage"/>
<a href="https://itunes.apple.com/us/app/ai-jian-mei/id683646344?ls=1&mt=8" id="sub" target="_blank"></a>
<div id="intro">
	<ul id="inner" style="top:101px;">
		<li style="display:block;" class="appShows"><img src="Templates/images/appc_2.jpg" alt="app" /></li>
		<li style="display:none;" class="appShows"><img src="Templates/images/appc_3.jpg" alt="app" /></li>
		<li style="display:none;" class="appShows"><img src="Templates/images/appc_4.jpg" alt="app" /></li>
		<li style="display:none;" class="appShows"><img src="Templates/images/appc_5.jpg" alt="app" /></li>
		<li style="display:none;" class="appShows"><img src="Templates/images/appc_1.jpg" alt="app" /></li>
	</ul>
</div>
</body>
</html>
