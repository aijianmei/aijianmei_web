<?php exit;?>a:3:{s:8:"template";a:19:{i:0;s:66:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/index.dwt";i:1;s:80:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/page_header.lbi";i:2;s:73:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/cart.lbi";i:3;s:82:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/category_tree.lbi";i:4;s:74:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/top10.lbi";i:5;s:83:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/promotion_info.lbi";i:6;s:80:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/order_query.lbi";i:7;s:82:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/invoice_query.lbi";i:8;s:78:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/vote_list.lbi";i:9;s:79:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/email_list.lbi";i:10;s:77:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/index_ad.lbi";i:11;s:81:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/new_articles.lbi";i:12;s:88:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/recommend_promotion.lbi";i:13;s:83:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/recommend_best.lbi";i:14;s:82:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/recommend_new.lbi";i:15;s:82:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/recommend_hot.lbi";i:16;s:76:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/auction.lbi";i:17;s:78:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/group_buy.lbi";i:18;s:73:"D:/core/aijianmei_web/aijianmei_back/shop/themes/default/library/help.lbi";}s:7:"expires";i:1366300627;s:8:"maketime";i:1366297027;}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="ECSHOP演示站" />
<meta name="Description" content="ECSHOP演示站" />
<title>ECSHOP演示站 - Powered by ECShop</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="themes/default/style.css" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|ECSHOP演示站 - Powered by ECShop" href="feed.php" />
<script type="text/javascript" src="js/common.js"></script><script type="text/javascript" src="js/index.js"></script></head>
<script type="text/javascript" src="themes/default/js/transport.js"></script>
<script type="text/javascript" src="themes/default/js/utils.js"></script>
<body>
<div class="body"></div>
              <div class="sheet">
                <div class="log">
                    <button class="close_btn"></button>
                    <h3>登录爱健美</h3>
                    <div class="ai_account">
                        <form action="/index.php?app=home&mod=Public&act=doLogin" method="post">
                            <h4 class="tit">使用注册邮箱登录</h4>
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
                            <div class="checkCode">
                            </div>
                            <button type="submit" class="submit_btn">登录</button>
                        </form>
                    </div>
                    <div class="other_account clearfix">
                        <h4 class="tit">使用合作网站账号登录</h4>
                        <div class="accounts">
                    <a class="copsina" style="width:128px;height:32px;" href="https://api.weibo.com/oauth2/authorize?response_type=code&client_id=3622140445&redirect_uri=http://www.aijianmei.com/index.php&state=50068_sina_899064&with_offical_account=1"></a>
                    <a class="copqq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100328471 &redirect_uri=www.aijianmei.com/qqlogin.php&scope=" style="width:128px;height:32px;"></a>
                         <script type='text/javascript' charset='utf-8'>
                            (function() {
                                var _dl_time = new Date().getTime();
                                var _dl_login = document.getElementById('denglu_login_js');
                                _dl_login.id = _dl_login.id + '_' + _dl_time;
                                _dl_login.src = 'http://open.denglu.cc/connect/logincode?appid=44031dena3J8cuBsQeX40lcpjSsPM3&v=1.0.2&widget=1&styletype=1&size=452_132&asyn=true&time=' + _dl_time;
                            })();
                        </script>
                        </div>
                        <span class="clearfix">未注册过爱健美也可以直接登录哦</span>
                        <a class="cop5" href="{:U('index/Index/selectRegister')}">爱健美注册</a>
                        
                    </div>
                </div>  
            </div>
            <div class="head">
                <div class="most_top">
                                <ul class="top_ms clearfix">
                                    <li><a href="javascript:;" class="login">登录 </a>|</li>
                                    <li><a href="/index.php?app=index&mod=Index&act=selectRegister">注册 </a></li>
                                </ul>
                    <ul class="after_ms">
                        <li class="person_massage">
                            <div>
                                <img src="<php>echo getUserFace(getMid(),'s')</php>" alt="no" />
                                <span>kon</span>
                            </div>
                        </li>
                        <li class="more"><a href="">帐号<span class="triangle"></span> </a>
                            <ul class="account">
                                <li><a href="/index.php?app=home&mod=Account&act=index">个人资料</a></li>
                                <li><a href="/index.php?app=home&mod=Public&act=logout">退出帐号</a></li>
                            </ul>
                        </li>
                        <li class="special_buy">
                            <a class="car_buy">购物车</a>
                        </li>
                    </ul>
                </div>
                <div class="header">
                    <div class="h_bg">
                        <a href="/index.php?app=index"><div class="logo_1">logo</div></a>
                        <ul class="nav">
                            <li class="nav_current"><i class="ag_current"></i><a href="/index.php?app=index"><span class="home">首页</span></a></li>
                            <li><i class="ag_current"></i><a href='#'><span class="store">商店</span></a></li>
                            <li><i class="ag_current"></i><a href="/index.php?app=index&mod=Plan">健身计划</a></li>
                            <li><i class="ag_current"></i><a href="/index.php?app=index&mod=Train">锻炼</a>
                            </li>
                            <li><i class="ag_current"></i><a href="/index.php?app=index&mod=Nutri">营养</a>
                            </li>
                            <li><i class="ag_current"></i><a href="/index.php?app=index&mod=Append">辅助品</a></li>
                            <li class="forum"><i class="ag_current"></i><a href="#">论坛</a></li>
                            <li class="friends"><i class="ag_current"></i><a href="#">交友互动</a></li>
                        </ul>
                    </div>
                </div>
            </div>
  <div class="wrapper">
<div class="block clearfix">
	<div id="banner">
			<div class="lay_banner">
			<ul class="ul_1 clearfix">
				<li class="change_1">
					<a>
						<img src="themes/default/images/1.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/2.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/4.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/5.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
			</ul>
			</div>
			<div class="choice_area">
			<ul class="ul_2 clearfix">
				<li class="first_choice">
					<img src="themes/default/images/1.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/2.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/4.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/5.jpg" alt="" class="relative_pic" />
				</li>
			</ul>
			<a class="ps_left"></a>
			<a class="ps_right"></a>
			</div>
		</div>	
        <script type="text/javascript" src="http://dev.aijianmei.com/apps/index/Tpl/default/Public/js/jquery.js"></script>
        <script type="text/javascript" src="../apps/index/Tpl/default/Public/js/public.js"></script>
</div>
<div class="clearfix" style="width:940px;margin-top:20px;">
<div id="search"  class="clearfix">
  <div class="keys f_l">
   <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("请输入搜索关键词！");
            return false;
        }
    }
    -->
    
    </script>
      </div>
  <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
   <select name="category" id="category" class="B_input">
      <option value="0">所有分类</option>
      <option value="1" >a</option>    </select>
   <input name="keywords" type="text" id="keyword" value="" class="B_input" style="width:110px;"/>
   <input name="imageField" type="submit" value="" class="go" style="cursor:pointer;" />
   <a href="search.php?act=advanced_search">高级搜索</a>
   </form>
</div>
</div>
<div class="blank"></div>
<div class="block clearfix">
  
  <div class="AreaL">
    
    <div class="box">
     <div class="box_1">
      <h3><span>商店公告</span></h3>
      <div class="boxCenterList RelaArticle">
              </div>
     </div>
    </div>
    <div class="blank5"></div>
    
  
<!--<script type="text/javascript" src="js/transport.js"></script><div class="cart" id="ECS_CARTINFO">
 554fcae493e564ee0dc75bdf2ebf94cacart_info|a:1:{s:4:"name";s:9:"cart_info";}554fcae493e564ee0dc75bdf2ebf94ca</div>
<div class="blank5"></div>-->
<div class="box">
 <div class="box_1">
  <div id="category_tree">
         <dl>
     <dt><a href="category.php?id=1">a</a></dt>
            
       </dl>
     
  </div>
 </div>
</div>
<div class="blank5"></div>
<div class="box">
 <div class="box_2">
  <div class="top10Tit"></div>
  <div class="top10List clearfix">
    </div>
 </div>
</div>
<div class="blank5"></div>
<script>var invalid_order_sn = "无效订单号"</script>
<div class="box">
 <div class="box_1">
  <h3><span>订单查询</span></h3>
  <div class="boxCenterList">
    <form name="ecsOrderQuery">
    <input type="text" name="order_sn" class="inputBg" /><br />
    <div class="blank5"></div>
    <input type="button" value="查询该订单号" class="bnt_blue_2" onclick="orderQuery()" />
    </form>
    <div id="ECS_ORDER_QUERY" style="margin-top:8px;">
          </div>
  </div>
 </div>
</div>
<div class="blank5"></div>
554fcae493e564ee0dc75bdf2ebf94cavote|a:1:{s:4:"name";s:4:"vote";}554fcae493e564ee0dc75bdf2ebf94ca<div class="box">
 <div class="box_1">
  <h3><span>邮件订阅</span></h3>
  <div class="boxCenterList RelaArticle">
    <input type="text" id="user_email" class="inputBg" /><br />
    <div class="blank5"></div>
    <input type="button" class="bnt_blue" value="订阅" onclick="add_email_list();" />
    <input type="button" class="bnt_bonus"  value="退订" onclick="cancel_email_list();" />
  </div>
 </div>
</div>
<div class="blank5"></div>
<script type="text/javascript">
var email = document.getElementById('user_email');
function add_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=add&email=' + email.value, '', rep_add_email_list, 'GET', 'TEXT');
  }
}
function rep_add_email_list(text)
{
  alert(text);
}
function cancel_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=del&email=' + email.value, '', rep_cancel_email_list, 'GET', 'TEXT');
  }
}
function rep_cancel_email_list(text)
{
  alert(text);
}
function check_email()
{
  if (Utils.isEmail(email.value))
  {
    return true;
  }
  else
  {
    alert('邮件地址非法！');
    return false;
  }
}
</script>
  </div>
  
  
  <div class="AreaR">
   
    
    
                                <!-- <div class="box_1 clearfix">
                                  <div class="f_l" id="focus">
                                  <!--   <script type="text/javascript">
  var swf_width=484;
  var swf_height=200;
  </script>
  <script type="text/javascript" src="data/flashdata/dynfocus/cycle_image.js"></script>
                                   </div>
                                   
                                   <!--<div id="mallNews" class="f_r">
                                    <div class="NewsTit"></div>
                                    <div class="NewsList tc">
-->                                     
                            
                                    <ul>
</ul>                                  <!--  </div>
                                   </div>-->
                                   <!--news end--
                                 </div>-->
   
   
  <!-- <div class="clearfix">
                
                                
      <!-- <div class="box f_r brandsIe6">
       <div class="box_1 clearfix" id="brands">
        #BeginLibraryItem "/library/brands.lbi" --><!-- #EndLibraryItem
       </div> -->
      <!-- </div>
    </div>
  <div class="blank5"></div> --> 
   
<div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit" id="itemBest">
        </div>
  <div id="show_best_area" class="clearfix goodsBox">
      <div class="goodsItem">
         <span class="best"></span>
           <a href="goods.php?id=2"><img src="images/201304/thumb_img/2_thumb_G_1365745897434.jpg" alt="b" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=2" title="b">b</a></p>
           <font class="f1">
                     ￥100元                     </font>
        </div>
    <div class="goodsItem">
         <span class="best"></span>
           <a href="goods.php?id=1"><img src="images/201304/thumb_img/1_thumb_G_1365745633445.jpg" alt="a" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=1" title="a">a</a></p>
           <font class="f1">
                     ￥0元                     </font>
        </div>
    <div class="goodsItem">
         <span class="best"></span>
           <a href="goods.php?id=4"><img src="images/201304/thumb_img/4_thumb_G_1365746019232.jpg" alt="ab" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=4" title="ab">ab</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="goodsItem">
         <span class="best"></span>
           <a href="goods.php?id=3"><img src="images/201304/thumb_img/3_thumb_G_1365745967901.jpg" alt="sdaf" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=3" title="sdaf">sdaf</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="more"><a href="search.php?intro=best">更多</a></div>
    </div>
</div>
</div>
<div class="blank5"></div>
  <div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit New" id="itemNew">
        </div>
  <div id="show_new_area" class="clearfix goodsBox">
      <div class="goodsItem">
         <span class="news"></span>
           <a href="goods.php?id=2"><img src="images/201304/thumb_img/2_thumb_G_1365745897434.jpg" alt="b" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=2" title="b">b</a></p>
           <font class="f1">
                     ￥100元                     </font>
        </div>
    <div class="goodsItem">
         <span class="news"></span>
           <a href="goods.php?id=4"><img src="images/201304/thumb_img/4_thumb_G_1365746019232.jpg" alt="ab" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=4" title="ab">ab</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="goodsItem">
         <span class="news"></span>
           <a href="goods.php?id=3"><img src="images/201304/thumb_img/3_thumb_G_1365745967901.jpg" alt="sdaf" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=3" title="sdaf">sdaf</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="more"><a href="search.php?intro=new"><!--<img src="themes/default/images/more.gif" />-->更多</a></div>
    </div>
</div>
</div>
<div class="blank5"></div>
  <div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit Hot" id="itemHot">
        </div>
  <div id="show_hot_area" class="clearfix goodsBox">
      <div class="goodsItem">
         <span class="hot"></span>
           <a href="goods.php?id=2"><img src="images/201304/thumb_img/2_thumb_G_1365745897434.jpg" alt="b" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=2" title="b">b</a></p>
           <font class="f1">
                     ￥100元                     </font>
        </div>
    <div class="goodsItem">
         <span class="hot"></span>
           <a href="goods.php?id=4"><img src="images/201304/thumb_img/4_thumb_G_1365746019232.jpg" alt="ab" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=4" title="ab">ab</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="goodsItem">
         <span class="hot"></span>
           <a href="goods.php?id=3"><img src="images/201304/thumb_img/3_thumb_G_1365745967901.jpg" alt="sdaf" class="goodsimg" /></a><br />
           <p><a href="goods.php?id=3" title="sdaf">sdaf</a></p>
           <font class="f1">
                     ￥1003元                     </font>
        </div>
    <div class="more"><a href="search.php?intro=hot">更多</a></div>
    </div>
</div>
</div>
<div class="blank5"></div>
  
  </div>
  
</div>
<div class="blank5"></div>
<div class="block">
  <div class="box">
   <div class="helpTitBg clearfix">
        <div class="block">
    
   <div class="clearfix">
<dl>
  <dt class="dt1"><a href="article_cat-6.html" title="购物指南" rel="nofollow">购物指南</a></dt>
    <dd><a href="help.php?id=11" title="新手需知" rel="nofollow">新手需知</a></dd>
    <dd><a href="help.php?id=62" title="订单状态" rel="nofollow">订单状态</a></dd>
    <dd><a href="help.php?id=65" title="购物流程" rel="nofollow">购物流程</a></dd>
  </dl>
<dl>
  <dt class="dt2"><a href="article_cat-7.html" title="快递发货" rel="nofollow">快递发货</a></dt>
    <dd><a href="help.php?id=12" title="配送范围 " rel="nofollow">配送范围</a></dd>
    <dd><a href="help.php?id=13" title="配送方式 " rel="nofollow">配送方式</a></dd>
    <dd><a href="help.php?id=14" title="收货验收" rel="nofollow">收货验收</a></dd>
  </dl>
<dl>
  <dt class="dt3"><a href="article_cat-8.html" title="如何支付" rel="nofollow">如何支付</a></dt>
    <dd><a href="help.php?id=15" title="网银支付 " rel="nofollow">网银支付</a></dd>
    <dd><a href="help.php?id=16" title="支付宝支付" rel="nofollow">支付宝支付</a></dd>
    <dd><a href="help.php?id=53" title="预存款支付" rel="nofollow">预存款支付</a></dd>
  </dl>
<dl>
  <dt class="dt4"><a href="article_cat-9.html" title="售后服务" rel="nofollow">售后服务</a></dt>
    <dd><a href="help.php?id=18" title="退换货流程" rel="nofollow">退换货流程</a></dd>
    <dd><a href="help.php?id=19" title="退换货政策 " rel="nofollow">退换货政策</a></dd>
    <dd><a href="help.php?id=20" title="退款说明" rel="nofollow">退款说明</a></dd>
  </dl>
<dl>
  <dt class="dt5"><a href="article_cat-10.html" title="常见问题" rel="nofollow">常见问题</a></dt>
    <dd><a href="help.php?id=21" title="投诉建议" rel="nofollow">投诉建议</a></dd>
    <dd><a href="help.php?id=22" title="服务条款" rel="nofollow">服务条款</a></dd>
    <dd><a href="help.php?id=66" title="非会员购物指南" rel="nofollow">非会员购物指南</a></dd>
  </dl>
</div>
</div>
   </div>
  </div>
</div>
<div class="blank"></div>
<!-- <div id="bottomNav" class="box">
 <div class="box_1">
  <div class="links clearfix">
       <!--  <a href="http://www.ecshop.com/" target="_blank" title="ECSHOP 网上商店管理系统"><img src="http://www.ecshop.com/images/logo/ecshop_logo.gif" alt="ECSHOP 网上商店管理系统" border="0" /></a> -->
               <!--  [<a href="http://www.maifou.net/" target="_blank" title="买否网">买否网</a>] -->
       <!--  [<a href="http://www.wdwd.com/" target="_blank" title="免费开独立网店">免费开独立网店</a>] -->
          <!-- </div>
 </div>
</div> -->
<!-- <div class="foot">
        <div class="f_list">
          <h4>发现爱健美</h4>
          <ul id="app"> 
            <li><a href="store.html">爱健美商店</a></li>
            <li><a href="training.html">锻炼</a></li>
            <li><a href="html">健身计划</a></li>
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
            <li><a href="#">友情链接</a></li>
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
</div> -->
<div class="blank"></div>
<div id="lower_footer"><span>广州加伦信息科技有限公司- 粤ICP备12085654号</span><a href="/index.php?app=index">www.aijianmei.com</a></div>
<!-- #EndLibraryItem
</div>
</body>
</html>