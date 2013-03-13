<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
	<html xmlns:wb=“http://open.weibo.com/wb”>
		<head>
			<meta charset="utf-8"/>
			<title>爱健美</title>
			<link rel="stylesheet" href="../Public/css/public.css" />
			<link rel="stylesheet" href="../Public/css/<?php echo ($cssFile); ?>.css" />	
			<link rel="stylesheet" href="../Public/css/jquery-ui.css" />
			<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>	
		</head>
<body>
		<div class="body"></div>
		<div class="sheet">
				<div class="log">
					<button class="close_btn"></button>
					<h3>登陆爱健美</h3>
					<div class="ai_account">
						<form action="/index.php?app=home&mod=Public&act=doLogin" method="post">
							<h4 class="tit">使用注册邮箱登陆</h4>
							<div class="text_input">
								<label for="mail">爱健美注册邮箱</label>
								<input type="text" id="mail" name="email" />
								<span class="tip">请输入正确的邮箱地址</span>
							</div>
							<div class="text_input">
								<label for="psd">密码</label>
								<input type="password" id="psd" name="password" />
								<span class="tip">密码长度为6~16个的数字或者字母</span>
							</div>
							<button type="submit" class="submit_btn">登陆</button>
							<a href="retrieve.html" class="forget">忘记密码</a>
						</form>
					</div>
					<div class="other_account clearfix">
						<h4 class="tit">使用合作网站账号登陆</h4>
						<div class="accounts">
						<script id='denglu_login_js' type='text/javascript' charset='utf-8'></script>
						<script type='text/javascript' charset='utf-8'>
							(function() {
								var _dl_time = new Date().getTime();
								var _dl_login = document.getElementById('denglu_login_js');
								_dl_login.id = _dl_login.id + '_' + _dl_time;
								_dl_login.src = 'http://open.denglu.cc/connect/logincode?appid=44031dena3J8cuBsQeX40lcpjSsPM3&v=1.0.2&widget=1&styletype=1&size=452_132&asyn=true&time=' + _dl_time;
							})();
						</script>
						</div>
						<span class="clearfix">未注册过爱健美也可以直接登陆哦</span>
						
					</div>
				</div>	
			</div><!-- End sheet -->

			<div class="wrapper">
				<div id="header">
					<ul class="top">
					<?php if(getMid()) { ?>
					<li><span>欢迎你，<?php echo getUserName(getMid()) ?></span>
					<?php } else { ?>
						<li><a href="javascript:;" id="login">登陆 </a>|</li>
						<li><a href="/index.php?app=index&mod=Index&act=selectRegister">注册 </a>|</li>
					<?php } ?>
						<li class="more"><a href="#">消息<span class="triangle"></span> </a>|
							<ul class="message">
								<li><a href="/index.php?app=home&mod=message&act=index">查看私信</a></li>
								<li><a href="/index.php?app=home&mod=user&act=comments">查看评论</a></li>
								<li><a href="/index.php?app=home&mod=user&act=atme">查看@我</a></li>
								<li><a href="/index.php?app=home&mod=space&act=follow&type=follower&uid=<?php echo ($uid); ?>">查看粉丝</a></li>
								<li><a href="/index.php?app=home&mod=message&act=notify">查看通知</a></li>
								<li><a href="order.html">查看预约</a></li>
							</ul>
						</li>
						<li class="more"><a href="">帐号<span class="triangle"></span> </a>
							<ul class="account">
								<li><a href="/index.php?app=home&mod=Account&act=index">个人资料</a></li>
								<li><a href="/index.php?app=home&mod=Account&act=address">收货地址</a></li>
								<li><a href="mod_face.html">修改头像</a></li>
								<li><a href="/index.php?app=home&mod=Account&act=bind">绑定帐号</a></li>
								<li><a href="/index.php?app=home&mod=Public&act=logout">退出帐号</a></li>
							</ul>
						</li>
					</ul>
					<form class="search">
						<fieldset>
							<legend>搜索</legend>
							<label for="search_title">搜索：</label>
							<input type="text" id="search_title" class="search_txt"/>
							<button class="search_btn hide_text" type="submit"></button>
						</fieldset>
					</form>
					<div class="logo">
						<a href="index.hmtl">
							<img src="../Public/images/logo.png" alt="aijianmei" />
						</a>
					</div>
					<ul id="nav">
						<li class="home"><a href="/index.php?app=index"><span>首页</span></a></li>
						<li class="store"><a href='#'><span>商店</span></a></li>
						<li><a href="/index.php?app=index&mod=Plan">健身计划</a></li>
						<li><a href="/index.php?app=index&mod=Train">锻炼</a></li>
						<li><a href="/index.php?app=index&mod=Nutri">营养</a></li>
						<li><a href="/index.php?app=index&mod=Append">补充</a></li>
						<li><a href="#">论坛</a></li>
						<li><a href="<?php echo U('home/User/index');?>">交友互动</a></li>
					</ul>
					<span class="position">爱健美/首页</span>
				</div>

<div id="banner">
		<div class="lay_banner">
			<ul class="ul_1 clearfix">
				<li class="change_1">
					<a>
						<img src="../Public/images/banner.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
							<img src="../Public/images/4.png" alt="no" class="png" />
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="../Public/images/1.gif" alt="no" class="pic_2" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
							<img src="../Public/images/4.png" alt="no" class="png" />
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="../Public/images/2.gif" alt="no" class="pic_3" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
							<img src="../Public/images/4.png" alt="no" class="png" />
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="../Public/images/3.gif" alt="no" class="pic_4" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
							<img src="../Public/images/4.png" alt="no" class="png" />
						</div>
					</a>
				</li>
			</ul>
		</div>
		<div class="choice_area">
			<ul class="ul_2 clearfix">
				<li class="first_choice">
					<img src="../Public/images/banner.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="../Public/images/1.gif" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="../Public/images/2.gif" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="../Public/images/3.gif" alt="" class="relative_pic" />
				</li>
			</ul>
			<a class="ps_left"></a>
			<a class="ps_right"></a>
		</div>
	</div>	<!--Banner End -->


<div id="content" class="clearfix">
			<div class="sider_all">
				<span class="corner_left"></span>
				<div class="lay_sider">
					<div class="subsider">
						<span class="border_line"></span>
						<h3 class="video_all">营养</h3>
						<span class="border_line"></span>
						<ul>
							<?php foreach($categories as $c) { ?>
								<li class="each_video all">
									<?php echo ($c['name']); ?>
								</li>
								<?php foreach($c['children'] as $child) { $action=$child['type']=='1'?'articleList':'videoList'; ?>
									<li class="each_video">
										<a href="/index.php?app=index&mod=Nutri&act=<?php echo ($action); ?>&id=<?php echo ($child['id']); ?>"><?php echo ($child['name']); ?></a>
									</li>
								<?php } ?>
							<?php } ?>
							<!-- <li class="each_video">
								<a href="nutri_1.html">减肥营养</a>
							</li>
							<li class="each_video">
								<a href="nutri_1.html">肌肉增益营养</a>
							</li> -->
							<span class="border_line"></span>
						</ul>
					</div>
				</div>
				<span class="corner_bottom"></span>
			</div>

			<div class="right_sider">

				<div class="part_top clearfix">
					<span class="corner_left"></span>
					<div class="lay_top clearfix">
						<h1 class="public_title">最精彩的营养文章</h1>
						<div class="tr_top clearfix">
							<a href="article.html" class="store.html"><img src="../Public/images/nutri/01.jpg" alt="no" class="supple_pic" /></a>
							<div>
								<a href="article.html" class="detail">营养与饮食秘诀</a>
								<p>有一个好的饮食规划才会有一副有成就感的身材</p>
								<a href="article.html" class="purchase">阅读全文</a>
							</div>
						</div>
						<ul class="clearfix">
							<li class="classify">
								<a href="classify.html" class="lay_cf">
									
										<img src="../Public/images/nutri/03.jpg" alt="" class="best" />
										<p>最畅销分类一：XX蛋白粉</p>
										<p class="price"></p>
									
								</a>
							</li>
							<li class="classify">
								<a href="classify.html" class="lay_cf">
									<div>
										<img src="../Public/images/nutri/04.jpg" alt="" class="best" />
										<p>最畅销分类一：XX蛋白粉</p>
										<p class="price"></p>
									</div>
								</a>
							</li>
							<li class="classify">
								<a href="classify.html" class="lay_cf">
									<div>
										<img src="../Public/images/nutri/05.jpg" alt="" class="best" />
										<p>最畅销分类一：XX蛋白粉</p>
										<p class="price"></p>
									</div>
								</a>
							</li>
						</ul>
					</div>
					<span class="corner_bottom"></span>
				</div>

				<div class="part_top clearfix">
					<span class="corner_left"></span>
					<div class="lay_top clearfix">
						<h1 class="public_title">最佳十篇文章</h1>
						<ul class="new_video clearfix">
						<?php foreach($hotArticles as $a) { ?>
							<li class="tr_classify">
								<a href="/index.php?app=index&mod=Index&act=articleDetail&id=<?php echo ($a['id']); ?>" class="video_1"><img src="<?php echo ($SITE_URL); ?>/public/images/article/<?php echo ($a['img']); ?>" width="165px" height="134px" alt=""></a>
								<a href="/index.php?app=index&mod=Index&act=articleDetail&id=<?php echo ($a['id']); ?>" class="plan_article_tl"><?php echo ($a['title']); ?></a>
								<p class="summary"><?php echo ($a['brief']); ?>
								</p>
							</li>
						<?php } ?>
							<!-- <li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/06.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/07.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/06.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/07.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li> -->
						</ul>
						<a class="expend">更多</a>
					</div>
					<span class="corner_bottom"></span>
				</div>

				<div class="part_top clearfix">
					<span class="corner_left"></span>
					<div class="lay_top clearfix">
						<h1 class="public_title">最近补充品文章</h1>
						<ul class="new_video clearfix">
						<?php foreach($lastArticles as $a) { ?>
							<li class="tr_classify">
								<a href="/index.php?app=index&mod=Index&act=articleDetail&id=<?php echo ($a['id']); ?>" class="video_1"><img src="<?php echo ($SITE_URL); ?>/public/images/article/<?php echo ($a['img']); ?>" width="165px" height="134px" alt=""></a>
								<a href="/index.php?app=index&mod=Index&act=articleDetail&id=<?php echo ($a['id']); ?>" class="plan_article_tl"><?php echo ($a['title']); ?></a>
								<p class="summary"><?php echo ($a['brief']); ?>
								</p>
								<!-- <a href="#" class="add_expend">查看所有质量增加程序</a> -->
							</li>
						<?php } ?>
							<!-- <li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/06.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/07.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a href="article.html" class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/06.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/07.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li>
							<li class="article clearfix">
								<a href="article.html" class="article_pic"><img src="../Public/images/add/05.jpg" alt="no" /></a>
								<div class="article_content">
									<a class="title_3">5 healthy lunch ideas</a>
									<p>dont ieave your child's nutnition up to wonding machines and piayfore trades serd him ir</p>
								</div>
							</li> -->
						</ul>
						<a class="expend">更多</a>
					</div>
					<span class="corner_bottom"></span>
				</div>

				<div class="part_top clearfix">
					<span class="corner_left"></span>
					<div class="lay_top clearfix">
						<h1 class="public_title">目录</h1>
						<?php foreach($categories as $c) { ?>
						<h2 class="title_4"><?php echo ($c['name']); ?></h2>
						<ul class="re_nav clearfix">
							<?php foreach($c['children'] as $child) { $action=$child['type']=='1'?'articleList':'videoList'; ?>
									<li class="each_video">
										<a href="/index.php?app=index&mod=Nutri&act=<?php echo ($action); ?>&id=<?php echo ($child['id']); ?>"><?php echo ($child['name']); ?></a>
									</li>
								<?php } ?>
						</ul>
						<?php } ?>
					</div>
					<span class="corner_bottom"></span>
				</div>

			</div>
		</div>

				<div id="footer">
					<div class="f_list">
						<h4>发现爱健美</h4>
						<ul id="app">	
							<li><a href="store.html">爱健美商店</a></li>
							<li><a href="training.html">锻炼</a></li>
							<li><a href="plan.html">健身计划</a></li>
							<li><a href="nutri.html">营养</a></li>
							<li><a href="add.html">补充</a></li>
							<li><a href="pal.html">交友互动</a></li>
						</ul>
					</div>
					<div class="f_list">
						<h4>获取帮助</h4>
						<ul id="article">						
							<li><a href="help.html">新手指南</a></li>
							<li><a href="direct.html">社区指导原则</a></li>
							<li><a href="feedback.html">意见反馈</a></li>
						</ul>
					</div>
					<div class="f_list">
						<h4>关于我们</h4>
						<ul id="video">						
							<li><a href="about_us.html">关于爱健美</a></li>
							<li><a href="contact.html">联系我们</a></li>
							<li><a href="join.html">加入爱健美</a></li>
							<li><a href="ad.html">广告投放与品牌推广</a></li>
							<li><a href="privacy.html">隐私政策</a></li>
						</ul>
					</div>
					<div class="f_list">
						<h4>更多</h4>
						<ul id="teach">					
							<li><a href="app.html">下载IOS客户端</a></li>
							<li><a href="app.html">下载Android客户端</a></li>
							<li><a href="links.html">友情链接</a></li>
						</ul>
					</div>
					<div class="f_list login" >
						<h4>关注我们</h4>
						<ul id="about">
							<li class="sina"><a href="http://weibo.com/aijianmei?topnav=1&wvr=5" target="_blank">新浪微博</a></li>
							<li class="tencent"><a href="http://t.qq.com/aijianmeiweibo" target="_blank">腾讯微博</a></li>
							<li class="netease"><a href="http://t.163.com/aijianmei" target="_blank">网易微博</a></li>
							<li class="public"><a href="#" target="_blank">公共主页</a></li>
							<li class="qZone"><a href="http://user.qzone.qq.com/2816973844/main#home" target="_blank">QQ空间</a></li>
							<li class="douban"><a href="#" target="_blank">豆瓣</a></li>
						</ul>		
					</div>
				</div><!--Footer End-->
				<div id="lower_footer">
					<span>广州加伦信息科技有限公司- 粤ICP备12085654号</span>
					<a href="intro.html">www.aijianmei.com</a>
				</div>
			</div>
			<script type="text/javascript">
			var USER = {
					'id' : <?php echo $uid ? $uid : '0' ?>,
					'name' : '',
			}
			</script>
			<script type="text/javascript" src="../Public/js/jquery.js"></script>
			<script type="text/javascript" src="../Public/js/public.js"></script>
			<script type="text/javascript" src="../Public/js/<?php echo ($cssFile); ?>.js"></script>
			<script type="text/javascript">
			function comments(comment, aid, act) {
				if(!USER.id) {alert('请登录'); return false;}
				var action = 'add'+act+'Comment';
				$.post('/index.php?app=index&mod=Index&act='+action, {'comment':comment, 'aid':aid}, function(msg) {
					//ui.success('success');
					location.reload();
				})
			}
			</script>
		</body>
	</html>