
		<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
        <script type="text/javascript" src="../apps/index/Tpl/default/Public/js/jquery.js"></script>
        <script type="text/javascript" src="../apps/index/Tpl/default/Public/js/public.js"></script>
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
</div>

<div class="clearfix" style="width:940px;">
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
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script>
    <?php if ($this->_var['searchkeywords']): ?>
   <?php echo $this->_var['lang']['hot_search']; ?> ：
   <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
   <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <?php endif; ?>
  </div>
  <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
   <select name="category" id="category" class="B_input">
      <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
      <?php echo $this->_var['category_list']; ?>
    </select>
   <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="B_input" style="width:110px;"/>
   <input name="imageField" type="submit" value="" class="go" style="cursor:pointer;" />
   <a href="search.php?act=advanced_search"><?php echo $this->_var['lang']['advanced_search']; ?></a>
   </form>
</div>
</div>
