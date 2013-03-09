<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>爱健美</title>
	<link rel="stylesheet" href="../Public/css/public.css" />
	<?php if($module_name == 'Store'): ?><link rel="stylesheet" href="../Public/css/store.css" /><?php endif; ?>
	<?php if($module_name == 'Plan'): ?><link rel="stylesheet" href="../Public/css/plan.css" /><?php endif; ?>
	<?php if($module_name == 'Training'): ?><link rel="stylesheet" href="../Public/css/training.css" /><?php endif; ?>
	<?php if($module_name == 'Nutri'): ?><link rel="stylesheet" href="../Public/css/nutri.css" /><?php endif; ?>
	<?php if($module_name == 'Add'): ?><link rel="stylesheet" href="../Public/css/add.css" /><?php endif; ?>
	<?php if($module_name == 'Intro'): ?><link rel="stylesheet" href="../Public/css/about_us.css" /><?php endif; ?>
	<?php if($module_name == 'Article'): ?><link rel="stylesheet" href="../Public/css/article.css" /><?php endif; ?>
<script type="text/javascript">

var url = '../Public/';

</script>
</head>
<body>
	<div class="body"></div>
			<div class="sheet">
				<div class="log">
					<button class="close_btn"></button>
					<h3>登陆爱健美</h3>
					<div class="ai_account">
						<form action="">
							<h4 class="tit">使用注册邮箱登陆</h4>
							<div class="text_input">
								<label for="mail">爱健美注册邮箱</label>
								<input type="text" id="mail"/>
								<span class="tip">请输入正确的邮箱地址</span>
							</div>
							<div class="text_input">
								<label for="psd">密码</label>
								<input type="password" id="psd"/>
								<span class="tip">密码长度为6~16个的数字或者字母</span>
							</div>
							<button type="submit" class="submit_btn">登陆</button>
							<a href="retrieve" class="forget">忘记密码</a>
						</form>
					</div>
					<div class="other_account clearfix">
						<h4 class="tit">使用合作网站账号登陆</h4>
						<div class="accounts">
							<a class="cop1" href="#"></a>
							<a class="cop2" href=""></a>
							<a class="cop3" href=""></a>
							<a class="cop4" href=""></a>
							<a class="cop5" href=""></a>
							<a class="cop6" href=""></a>
						</div>
						<span class="clearfix">未注册过爱健美也可以直接登陆哦</span>
						
					</div>
				</div>	
			</div><!-- End sheet -->
	<div class="wrapper">
		<div id="header">
				<ul class="top">
					<li><a id="login">登陆 </a>|</li>
					<li><a href="account.html">注册 </a>|</li>
					<li class="more"><a href="#">消息<span class="triangle"></span> </a>|
							<ul class="message">
								<li><a href="letter.html">查看私信</a></li>
								<li><a href="comment.html">查看评论</a></li>
								<li><a href="mention.html">查看@我</a></li>
								<li><a href="fans.html">查看粉丝</a></li>
								<li><a href="inform.html">查看通知</a></li>
								<li><a href="order.html">查看预约</a></li>
							</ul>
						</li>
						<li class="more"><a href="">帐号<span class="triangle"></span> </a>
							<ul class="account">
								<li><a href="information.html">个人资料</a></li>
								<li><a href="receive.html">收货地址</a></li>
								<li><a href="mod_face.html">修改头像</a></li>
								<li><a href="bind.html">绑定帐号</a></li>
								<li><a href="">退出帐号</a></li>
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
						<a href="__APP__">
							<img src="../Public/images/logo.png" alt="aijianmei" />
						</a>
					</div>
				<ul id="nav">
						<li class="home" ><a href="__APP__"><span>首页</span></a></li>
						<li  class="store <?php if($module_name == 'Store'): ?>now_position<?php endif; ?>"><a href="__APP__/Store"><span>商店</span></a></li>
						<li <?php if($module_name == 'Plan'): ?>class="now_position"<?php endif; ?>><a href="__APP__/Plan">健身计划</a></li>
						<li <?php if($module_name == 'Training'): ?>class="now_position"<?php endif; ?>><a href="__APP__/Training">锻炼</a></li>
						<li <?php if($module_name == 'Nutri'): ?>class="now_position"<?php endif; ?>><a href="__APP__/Nutri">营养</a></li>
						<li <?php if($module_name == 'Add'): ?>class="now_position"<?php endif; ?>><a href="__APP__/Add">补充</a></li>
						<li><a href="activity.html">论坛</a></li>
						<li><a href="__ROOT__/sns">交友互动</a></li>
				</ul>
				<span class="position">爱健美/首页</span>
		</div>


<!--Header end -->

		<div id="content">
			<div class="content_left clearfix">
				<h1 class="title_1">爱健美文章</h1>
				<span class="goal">瘦身</span>
				<span class="goal_part">腰部 XX XX</span>
				<div class="essay_ct">
					<h2 class="title_2">腰部瘦身最关键的几个步骤</h2>
					<div class="web_expend_1">
						<a class="sprite_7">1343</a>
						<span class="prompt">腰部瘦身</span>
						<span>新华网</span>			
						<span>我要分享</span>
						<a class="sprite_1"></a>
						<a class="sprite_2"></a>
						<a class="sprite_3"></a>
						<a class="sprite_4"></a>
						<a class="sprite_5"></a>
						<a class="sprite_6"></a>
						
					</div>
					<div class="video clearfix">
						<a><img src="../Public/images/article/4.png" alt="no" class="video_pic" /></a>
						<div class="detail">
							<p>教你如何能“吃”去脂肪</p>
							<p>食用以下事物，可有效地抑制因摄取</p>
							<p>脂肪较多而引起的多种病症</p>
						</div>
					</div>
					<div class="food_pic">
						<a href="store_5.html"><img src="../Public/images/article/5.png" alt="no" border="0" /></a>
						<p class="food_ms">对瘦身有帮助的食物</p>
					</div>
					<div class="article">
						<h3 class="title_3">1、食用以下食物，可有效地抑制因摄取脂肪较多而引起的多种病症。</h3>
						<p>洋葱：含前列腺素Ａ，有舒张血管，降低血压等功能；还含有烯丙基三硫化合物及少量
							硫氨基酸，可降血脂，预防动脉硬化。40岁以上者更要常吃。
						</p>
						<p>苹果：因富含果胶、纤维素、维生素C等，有非常好的降脂作用。如果每天吃两个苹果，
							坚持一个月，大多数人血液中导致对心血管有害的低密度脂蛋白胆固醇会大大降低，而对心
						</p>
						<p>大蒜：含硫化合物，可减少血液中的胆固醇，可阻止血栓的形成，有助于增加高密度脂
							蛋白，保护心脏动脉。	
						</p>
						<p>牛奶：含较多的乳清酸和钙质，这些物质既能抑制胆固醇积于动脉血管壁，能抑制人体
							内胆固醇合成酶的活性，还可减少胆固醇的吸收。
						</p>
						<h3>2、食用以下食物，可有效地抑制因摄取脂肪较多而引起的多种病症。</h3>
						<p>洋葱：含前列腺素Ａ，有舒张血管，降低血压等功能；还含有烯丙基三硫化合物及少量
							硫氨基酸，可降血脂，预防动脉硬化。40岁以上者更要常吃。
						</p>
						<p>苹果：因富含果胶、纤维素、维生素C等，有非常好的降脂作用。如果每天吃两个苹果，
							坚持一个月，大多数人血液中导致对心血管有害的低密度脂蛋白胆固醇会大大降低，而对心
						</p>
						<p>大蒜：含硫化合物，可减少血液中的胆固醇，可阻止血栓的形成，有助于增加高密度脂
							蛋白，保护心脏动脉。	
						</p>
						<p>牛奶：含较多的乳清酸和钙质，这些物质既能抑制胆固醇积于动脉血管壁，能抑制人体
							内胆固醇合成酶的活性，还可减少胆固醇的吸收。
						</p>
					</div>
					<div class="web_expend_2">
						<span class="read_time">
							<a style="height:16px;width:52px;line-height:16px;background:0;">
								<span>阅读</span>
								<span>0</span>
								<span class="triangle"></span>
							</a>
							<div class="page_times" style="postion:absolute;display:none;right:0px;width:50px; background:white;line-height:20px;border:1px solid #ccc;">
								<p>页面1</p>
								<p>页面1</p>	
							</div>
						</span>
						<a class="sprite_8"><span class="praise">100</span></a>
						<a class="sprite_9"><span class="praise">100</span></a>
						<span class="relay">转发到</span>
						<a class="sprite_1"></a>
						<a class="sprite_2"></a>
						<a class="sprite_3"></a>
						<a class="sprite_4"></a>
						<a class="sprite_5"></a>
						<a class="sprite_6"></a>
						<a class="collect">收藏</a>
						
						
					</div>
					<div class="border_comment">
						<span class="word_num">0/300</span>
						<span>登录</span>|
						<span>注册</span>
						
						<div class="textarea"><textarea class="comment_inp" name="comment">有什么感想，来说说吧</textarea></div>
						<a class="comment">发表评论</a>
					</div>
					<div class="check_comment">
						<a class="comment_1">全部评论(0)</a>
						<a class="comment_2 comment_3">精选评论</a>
					</div>
					<div class="cm_content tab_2">
						<div class="cm_top">
							<span class="page_1">
								<span class="lay_page">
									<a class="choice_page">1</a>
									<a>2</a>
									<a>3</a>
									<a>4</a>
									<a>5</a>
								</span>
								<a class="pre_page">上一页</a>
								<a class="next_page">下一页</a>
							</span>
							<span>第0页</span>  <span>第0条</span>
							
						</div>
						<div class="cm_bottom">
							<h5 class="title_5">推荐精华</h5>
							<div class="target">
								<div class="target_pic">
									<img src="../Public/images/article/9.png" alt="no" />
									<span class="care">关注</span>
								</div>
								<a class="name">huifei</a>
								<p>高兴是人类最原始的最求，只能让大家高兴，管他是那个国家的。中国人为什么总被排挤在潮流之外，其实都是中国人自己造成的，当别人都在高兴的时候，中国人则是在旁边指指点点，这不好，那不好，好像只有这样才能显出自己的高人一等。</p>
								<p class="bottom_ms">
									<span class="to">
										<a>转发<span>(0)</span></a>
										<a>回复<span>(0)</span></a>
									</span>	
									<span>22个小时前</span>
									<span>来自<em></em></span>
									
								</p>
							</div>
						</div>	
					</div>
					<div class="cm_content tab_1">
						<div class="cm_top">
							<span class="page_1">
								<span class="lay_page">
									<a class="choice_page">1</a>
									<a>2</a>
									<a>3</a>
									<a>4</a>
									<a>5</a>
								</span>
								<a class="pre_page">上一页</a>
								<a class="next_page">下一页</a>
							</span>
							<span>第0页</span>  <span>第0条</span>
							
						</div>
						<div class="cm_bottom">
							<h5 class="title_5">全部推荐</h5>
							<div class="target">
								<div class="target_pic">
									<img src="../Public/images/article/9.png" alt="no" />
									<span class="care">关注</span>
								</div>
								<a class="name">huifei</a>
								<p>高兴是人类最原始的最求，只能让大家高兴，管他是那个国家的。中国人为什么总被排挤在潮流之外，其实都是中国人自己造成的，当别人都在高兴的时候，中国人则是在旁边指指点点，这不好，那不好，好像只有这样才能显出自己的高人一等。</p>
								<p class="bottom_ms">
									<span class="to">
										<a>转发<span>(0)</span></a>
										<a>回复<span>(0)</span></a>
									</span>	
									<span>22个小时前</span>
									<span>来自<em></em></span>
									
								</p>
							</div>
							<div class="target">
								<div class="target_pic">
									<img src="../Public/images/article/9.png" alt="no" />
									<span class="care">关注</span>
								</div>
								<a class="name">huifei</a>
								<p>高兴是人类最原始的最求，只能让大家高兴，管他是那个国家的。中国人为什么总被排挤在潮流之外，其实都是中国人自己造成的，当别人都在高兴的时候，中国人则是在旁边指指点点，这不好，那不好，好像只有这样才能显出自己的高人一等。</p>
								<p class="bottom_ms">
									<span class="to">
										<a>转发<span>(0)</span></a>
										<a>回复<span>(0)</span></a>
									</span>
									<span>22个小时前</span>
									<span>来自<em></em></span>
										
								</p>
							</div>
						</div>
					</div>
					<div class="relation">
						<h5 class="title_6"><a class="add_relation">相关推荐</a></h5>
						<p>计划生育实施之后、、</p>
						<p>计划生育实施之后、、</p>
						<p>计划生育实施之后、、</p>
						<p>计划生育实施之后、、</p>
					</div>
				</div>
			</div>
			<div class="content_right">
				<a href="store_5.html"><img src="../Public/images/article/1.png" alt="no" border="0" /></a>
				<h4 class="title_4">精华推荐</h4>
					<div class="recommend">
						<a><img src="../Public/images/article/2.png" alt="no" border="0" /></a>
						<p class="intro">新闻百科：为什么大陆同胞赴美不用、、、</p>
					</div>
					<div class="recommend">
						<a><img src="../Public/images/article/2.png" alt="no" border="0" /></a>
						<p class="intro">新闻百科：为什么大陆同胞赴美不用、、、</p>
					</div>
			</div>
		</div>
		<div id="footer">
		</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/public.js"></script>
	<script type="text/javascript" src="js/article.js"></script>
</body>
</html>