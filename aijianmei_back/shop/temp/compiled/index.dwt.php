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
   
    <div class="box clearfix">
    
    
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
    </div>
    <div class="blank5"></div>
   
   
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
