<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
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
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="blank"></div>
<div class="block clearfix">
  
  <div class="AreaL">
    
    <div class="box">
     <div class="box_1">
      <h3><span><?php echo $this->_var['lang']['shop_notice']; ?></span></h3>
      <div class="boxCenterList RelaArticle">
        <?php echo $this->_var['shop_notice']; ?>
      </div>
     </div>
    </div>
    <div class="blank5"></div>
    
  
<?php echo $this->fetch('library/cart.lbi'); ?>
<?php echo $this->fetch('library/category_tree.lbi'); ?>
<?php echo $this->fetch('library/top10.lbi'); ?>
<?php echo $this->fetch('library/promotion_info.lbi'); ?>
<?php echo $this->fetch('library/order_query.lbi'); ?>
<?php echo $this->fetch('library/invoice_query.lbi'); ?>
<?php echo $this->fetch('library/vote_list.lbi'); ?>
<?php echo $this->fetch('library/email_list.lbi'); ?>


  </div>
  
  
  <div class="AreaR">
   
    
    
                                <!-- <div class="box_1 clearfix">
                                  <div class="f_l" id="focus">
                                  <!-- <?php echo $this->fetch('library/index_ad.lbi'); ?>
                                   </div>
                                   
                                   <!--<div id="mallNews" class="f_r">
                                    <div class="NewsTit"></div>
                                    <div class="NewsList tc">
-->                                     
                            
                                    <?php echo $this->fetch('library/new_articles.lbi'); ?>
                                  <!--  </div>
                                   </div>-->
                                   <!--news end--
                                 </div>-->
   
   
  <!-- <div class="clearfix">
                
                <?php echo $this->fetch('library/recommend_promotion.lbi'); ?>
                
      <!-- <div class="box f_r brandsIe6">
       <div class="box_1 clearfix" id="brands">
        #BeginLibraryItem "/library/brands.lbi" --><!-- #EndLibraryItem
       </div> -->
      <!-- </div>
    </div>
  <div class="blank5"></div> --> 
   
<?php echo $this->fetch('library/recommend_best.lbi'); ?>
<?php echo $this->fetch('library/recommend_new.lbi'); ?>
<?php echo $this->fetch('library/recommend_hot.lbi'); ?>
<?php echo $this->fetch('library/auction.lbi'); ?>
<?php echo $this->fetch('library/group_buy.lbi'); ?>

  </div>
  
</div>
<div class="blank5"></div>

<div class="block">
  <div class="box">
   <div class="helpTitBg clearfix">
    <?php echo $this->fetch('library/help.lbi'); ?>

   </div>
  </div>
</div>
<div class="blank"></div>


<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
<!-- <div id="bottomNav" class="box">
 <div class="box_1">
  <div class="links clearfix">
    <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
   <!--  <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a> -->
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['txt_links']): ?>
    <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
   <!--  [<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>] -->
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endif; ?>
  <!-- </div>
 </div>
</div> -->
<?php endif; ?>

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
