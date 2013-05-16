<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
    <div class="body"></div>
    <div class="sheet" id="sheet">
        <div class="log">
            <button class="close_btn"></button>
            <h3>登录爱健美</h3>
            <div class="ai_account">
                <form action="/index.php?app=home&mod=Public&act=doLogin" method="post">
                    <h4 class="tit">使用注册邮箱登录</h4>
                    <div class="text_input">
                        <label for="mail" class="label_1">爱健美注册邮箱</label>
                        <input type="text" id="mail" name="email" />
                        <span class="tip">请输入正确的邮箱地址</span>
                    </div>
                    <div class="text_input">
                        <label for="psd"  class="label_2">密码</label>
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
                <a class="cop5" href="<?php echo $this->_var['aijianmeiurl']; ?>/index.php?app=index&mod=Index&act=selectRegister">爱健美注册</a>
                
            </div>
        </div>  
    </div>
    <div class="head">
        <div class="most_top">
		    <?php if ($this->_var['ecs_session']['user_id'] > 0): ?>
			<ul class="after_ms">
                <li class="person_massage">
                    <div>
                        <img src="<?php echo $this->_var['ecs_session']['user_img']; ?>" alt="no" />
                        <span><?php echo $this->_var['ecs_session']['user_name']; ?></span>
                    </div>
                </li>
                <li class="more"><a href="">帐号<span class="triangle"></span> </a>
                    <ul class="account">
                        <li><a href="<?php echo $this->_var['aijianmeiurl']; ?>/index.php?app=home&mod=Account&act=index">个人资料</a></li>
                        <li><a href="<?php echo $this->_var['aijianmeiurl']; ?>/index.php?app=home&mod=Public&act=logout">退出帐号</a></li>
                    </ul>
                </li>
                <li class="special_buy">
                    <a class="car_buy">购物车</a>
                </li>
            </ul>
			<?php else: ?>
			<ul class="top_ms clearfix">
				<li><a href="javascript:;" class="login">登录 </a>|</li>
				<li><a href="<?php echo $this->_var['aijianmeiurl']; ?>/index.php?app=index&mod=Index&act=selectRegister">注册 </a></li>
			</ul>
			<?php endif; ?>
        </div>
        <div class="header">
            <div class="h_bg">
                <a href="/index.php?app=index"><div class="logo_1">logo</div></a>
                <ul class="nav">
                    <li><i class="ag_current"></i><a href="/index.html"><span class="home">首页</span></a></li>
                    <li  class="nav_current"><i class="ag_current"></i><a href='/shop'><span class="store">商店</span></a></li>
                    <li><i class="ag_current"></i><a href="/Plan.html">健身计划</a></li>
                    <li><i class="ag_current"></i><a href="/Train.html">锻炼</a>
                    </li>
                    <li><i class="ag_current"></i><a href="/Nutri.html">营养</a>

                    </li>
                    <li><i class="ag_current"></i><a href="/Append.html">辅助品</a></li>
                    <li class="forum"><i class="ag_current"></i><a href="#">论坛</a></li>
                    <li class="friends"><i class="ag_current"></i><a href="#">交友互动</a></li>
                </ul>
            </div>
        </div>
    </div>
  <div class="wrapper">

