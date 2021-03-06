<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php if(($ts['site']['page_title'])  !=  ""): ?><?php echo ($ts['site']['page_title']); ?>
<?php else: ?>
    <?php echo ($ts['site']['site_header_title']); ?><?php endif; ?>    
</title>
<link rel="shortcut icon" href="__THEME__/favicon.ico" />
<meta name="keywords" content="<?php echo ($ts['site']['site_header_keywords']); ?>" />
<meta name="description" content="<?php echo ($ts['site']['site_header_description']); ?>" />
<script>
	var _UID_   = <?php echo (int) $uid; ?>;
	var _MID_   = <?php echo (int) $mid; ?>;
	var _ROOT_  = '__ROOT__';
	var _THEME_ = '__THEME__';
	var _PUBLIC_ = '__PUBLIC__';
	var _LENGTH_ = <?php echo (int) $GLOBALS['ts']['site']['length']; ?>;
	var _LANG_SET_ = '<?php echo LANG_SET; ?>';
	var $CONFIG = {};
		$CONFIG['uid'] = _UID_;
		$CONFIG['mid'] = _MID_;
		$CONFIG['root_path'] =_ROOT_;
		$CONFIG['theme_path'] = _THEME_;
		$CONFIG['public_path'] = _PUBLIC_;
		$CONFIG['weibo_length'] = <?php echo (int) $GLOBALS['ts']['site']['length']; ?>;
		$CONFIG['lang'] =  '<?php echo LANG_SET; ?>';
    var bgerr;
    try { document.execCommand('BackgroundImageCache', false, true);} catch(e) {  bgerr = e;}
</script>
<!-- 全局风格CSS -->
<link href="__THEME__/public.css?20110820" rel="stylesheet" type="text/css" />
<link href="__THEME__/layout.css?20110820" rel="stylesheet" type="text/css" />
<link href="__THEME__/main.css?20110820" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/js/tbox/box.css?20110820" rel="stylesheet" type="text/css" />
<!-- 核心JS加载 -->
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js?20110824"></script>
<script type="text/javascript" src="__PUBLIC__/js/tbox/box.js?20110824"></script>
<script type="text/javascript" src="__PUBLIC__/js/scrolltopcontrol.js?20110824"></script>
<script type="text/javascript" src="__PUBLIC__/js/weibo.js?20110824"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.jgrow.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.isotope.min.js"></script>

<!-- 编辑器样式文件 -->
<link href="__PUBLIC__/js/editor/editor/theme/base-min.css" rel="stylesheet"/>
<!--[if lt IE 8]><!-->
<link href="__PUBLIC__/js/editor/editor/theme/cool/editor-pkg-sprite-min.css" rel="stylesheet"/>
<!--<![endif]-->
<!--[if gte IE 8]><!-->
<link href="__PUBLIC__/js/editor/editor/theme/cool/editor-pkg-min-datauri.css" rel="stylesheet"/>
<!--<![endif]-->
<?php echo Addons::hook('public_head',array('uid'=>$uid));?>
</head>

<body class="page_home">
<div class="wrap">

<?php if(isset($_SESSION["userInfo"])): ?><?php if(isMobile()){ ?>
<!--顶部导航-->
<style>
.page_home{background:#e4e4e4 repeat center top;_padding:0}
.content_holder{margin-top:10px;}
</style>
<div class="top_holder">
 <div class="header">
 <div class="logo_holder">
    <!--个人信息区-->
    <ul class="person per-info">
    <li><?php echo getUserSpace($mid,'fb14 username nocard info-bg','','',false);?></li>
    <li class="header_dropdown"><a href="#" class="application li-bg">消息<span class="ico_arrow arrow-bg"></span></a>
          <div class="dropmenu ip-dropmenu">
                <ul class="message_list_container message_list_new">
                </ul>
                <dl class="message">
          <dd><a href="<?php echo U('home/message/index');?>">查看私信<?php if(($userCount['message'])  >  "0"): ?>(<?php echo ($userCount["message"]); ?>)<?php endif; ?></a></dd> 
          <dd><a href="<?php echo U('home/user/atme');?>">查看@我<?php if(($userCount['atme'])  >  "0"): ?>(<?php echo ($userCount["atme"]); ?>)<?php endif; ?></a></dd> 
          <dd><a href="<?php echo U('home/user/comments');?>">查看评论<?php if(($userCount['comment'])  >  "0"): ?>(<?php echo ($userCount["comment"]); ?>)<?php endif; ?></a></dd> 
          <dd><a href="<?php echo U('home/message/notify');?>">系统通知<?php if(($userCount['notify'])  >  "0"): ?>(<?php echo ($userCount["notify"]); ?>)<?php endif; ?></a></dd> 
          <dd><a href="<?php echo U('home/message/appmessage');?>">应用消息<?php if(($userCount['appmessage'])  >  "0"): ?>(<?php echo ($userCount["appmessage"]); ?>)<?php endif; ?></a></dd> 
                </dl>
                <dl class="square_list">
                <dd><a href="javascript:ui.sendmessage(0)">发私信</a></dd>
                </dl>
          </div>
        </li>
    <li class="header_dropdown"><a href="#" class="application li-bg">帐号<span class="ico_arrow arrow-bg"></span></a>
          <div class="dropmenu ip-dropmenu">
                <dl class="setup">
                <dd><a href="<?php echo U('home/User/findfriend');?>"><span class="ico_pub ico_pub_find"></span>找人</a></dd>
                <dd><a href="<?php echo U('home/Account');?>"><span class="ico_pub ico_pub_set"></span>设置</a></dd>
                <dd><a href="<?php echo U('home/Account/invite');?>"><span class="ico_pub ico_pub_invitation"></span>邀请</a></dd>
                <dd><a href="<?php echo U('home/Account/weiboshare');?>"><span class="ico_pub ico_pub_tool"></span>小工具</a></dd>
                <?php echo Addons::hook('header_account_tab', array('menu' => & $header_account_drop_menu));?>
                <?php if(is_array($header_account_drop_menu)): ?><?php $i = 0;?><?php $__LIST__ = $header_account_drop_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($vo['url']); ?>"><span class="ico_pub ico_pub_<?php echo ($vo['act']); ?>"></span><?php echo ($vo['name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                <?php if(($isSystemAdmin)  ==  "TRUE"): ?><dd><a href="<?php echo U('admin/index/index');?>"><span class="ico_pub"><img src="__THEME__/images/audit.png" /></span>后台管理</a></dd><?php endif; ?>
                </dl>
                <dl class="square_list_add">
                <dd><a href="<?php echo U('home/Public/logout');?>"><span class="ico_pub ico_pub_signout"></span>退出</a></dd>
                </dl>
          </div>
        </li>
    </ul>
  <!--/个人信息区-->
  <!--消息提示框-->
    <div id="message_list_container" class="layer_massage_box" style="display:none;">
      <ul id="is_has_message" class="message_list_container">
        </ul>
        <a href="javascript:void(0)" onclick="ui.closeCountList(this)" class="del"></a>
    </div>
  <!--/消息提示框-->
    
    <div class="nav nav-left">
      <ul>
        <li><a href="<?php echo U('home');?>" class="fb14 nav-bg">首页</a></li>
    <li class="header_dropdown"><a href="#" class="application li-bg">广场<span class="ico_arrow arrow-bg"></span></a>
          <div class="dropmenu ip-dropmenu">
                <dl class="square_list">
                <dd><a href="<?php echo U('home/Square/top');?>"><span class="ico_pub ico_pub_billboard"></span>风云榜</a></dd>
                <dd><a href="<?php echo U('home/Square/star');?>"><span class="ico_pub ico_pub_hall"></span>名人堂</a></dd>
                <?php echo Addons::hook('header_square_tab', array('menu' => & $header_square_expend_menu));?>
                <?php if(is_array($header_square_expend_menu)): ?><?php $i = 0;?><?php $__LIST__ = $header_square_expend_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo U('home/Square/' . $vo['act'], $vo['param']);?>"><span class="ico_pub ico_pub_<?php echo ($vo['act']); ?>"></span><?php echo ($vo['name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
            </dl>
          </div>
        </li>
        <li class="header_dropdown"><a href="#" class="application li-bg">应用<span class="ico_arrow arrow-bg"></span></a>
          <div class="dropmenu ip-dropmenu">
            <dl class="app_list">
                <?php foreach ($ts['user_app'] as $_temp_type => $_temp_apps) { ?>
                <?php foreach ($_temp_apps as $_temp_app) { ?>
                    <dd>
                        <?php if($_temp_type == 'local_app' || $_temp_type == 'local_default_app') { ?>
                        <a href="<?php echo $_temp_app['app_entry'];?>" class="a14">
                            <img class="app_ico" src="<?php echo $_temp_app['icon_url'];?>" />
                            <?php echo $_temp_app['app_alias'];?>
                        </a>
                        <?php }else { ?>
                        <a href="__ROOT__/apps/myop/userapp.php?id=<?php echo $_temp_app['app_id'];?>" class="a14">
                            <img class="app_ico" src="http://appicon.manyou.com/icons/<?php echo $_temp_app['app_id'];?>" />
                            <?php echo $_temp_app['app_alias'];?>
                        </a>
                        <?php }?>
                    </dd>
                <?php } // end of foreach?>
                <?php } // end of foreach?>
                </dl>
                <dl class="app_list_add">
                <dd><a href="<?php echo U('home/Index/addapp');?>"><span class="ico_app_add"></span>添加更多应用</a></dd>
                </dl>
          </div>
        </li>
		
      </ul>
    </div>
 </div>
  <form action="<?php echo U('home/user/search');?>" id="quick_search_form" method="post">
    <div>
    <div class="soso br3 line"><label id="_header_search_label" style="display: block;" onclick="$(this).hide();$('#_header_search_text').focus();">搜名字/标签/微博</label><input type="text" class="line-text" value="" name="k" id="_header_search_text" onblur="if($(this).val()=='') $('#_header_search_label').show();"/></div><input name="" type="button" onclick="$('#quick_search_form').submit()" class="ip-serach hand br3"/></div>
  <script>
  if($('#_header_search_text').val()=='')
    $('#_header_search_label').show();
  else
    $('#_header_search_label').hide();
  </script>
    </form>
  </div>
</div>
<?php }else{ ?>
<!--顶部导航-->
<div class="header_holder">
 <div class="header">
 <div class="logo_holder">
    <div class="logo"><a href="<?php echo U('home/Index');?>"><img src="<?php echo $ts['site']['site_logo']?$ts['site']['site_logo']:__THEME__.'/images/logo.png'; ?>" style="_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=crop)" /></a></div>
    <form action="<?php echo U('home/user/search');?>" id="quick_search_form" method="post">
    <div class="soso br3"><label id="_header_search_label" style="display: block;" onclick="$(this).hide();$('#_header_search_text').focus();">搜名字/标签/微博</label><input type="text" class="so_text" value="" name="k" id="_header_search_text" onblur="if($(this).val()=='') $('#_header_search_label').show();"/><input name="" type="button" onclick="$('#quick_search_form').submit()" class="so_btn hand br3"/></div>
	<script>
	if($('#_header_search_text').val()=='')
		$('#_header_search_label').show();
	else
		$('#_header_search_label').hide();
	</script>
    </form>
    <div class="nav">
      <ul>
        <li><a href="<?php echo U('home');?>" class="fb14">首页</a></li>
		<li class="header_dropdown"><a href="<?php echo U('home/Square/index');?>" class="application">广场<span class="ico_arrow"></span></a>
          <div class="dropmenu">
                <dl class="square_list">
                <dd><a href="<?php echo U('home/Square/top');?>">风云榜</a></dd>
                <dd><a href="<?php echo U('home/Square/star');?>">名人堂</a></dd>
                <?php echo Addons::hook('header_square_tab', array('menu' => & $header_square_expend_menu));?>
				<?php if(is_array($header_square_expend_menu)): ?><?php $i = 0;?><?php $__LIST__ = $header_square_expend_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo U('home/Square/' . $vo['act'], $vo['param']);?>"><?php echo ($vo['name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
            </dl>
          </div>
        </li>
        <?php if(!empty($my_group_list)){ ?>
		<li id="iframe_group_li" class="header_dropdown"><a href="<?php echo U('group/index/newIndex');?>" class="application">群组<span class="ico_arrow"></span></a>
          <div id="iframe_group" class="dropmenu"><iframe id="iframe_g" style="position:absolute;_filter:alpha(opacity=0);opacity=0;z-index:-1;width:100%;height:100%;top:0;left:0;scrolling:no;" frameborder="0" src="about:blank"></iframe>
                <dl class="group_list">
                            <?php $moreGroup = false; ?>
                            <?php foreach($my_group_list as $key=>$value){ ?>
                                <dd><a href="<?php echo U('group/group/index',array('gid'=>$value['id']));?>"><?php echo ($value['name']); ?></a></dd>
                                 <?php if($key>=5){
                                       $moreGroup = true;
                                       break;
                                       } ?>
                            <?php } ?>
                </dl>
                <dl class="group_list_add">
                <dd><?php if($moreGroup){ ?><a href="<?php echo U('group/SomeOne');?>" class="right">更多&raquo;</a><?php } ?><a href="<?php echo U('group/Index/add');?>">创建群组</a></dd>
                </dl>
          </div>
        </li>
        <?php } ?>
        <li id="iframe_app_li" class="header_dropdown"><a href="<?php echo U('home/Index/addapp');?>" class="application">应用<span class="ico_arrow"></span></a>
          <div id="iframe_app" class="dropmenu"><iframe id="iframe_a" style="position:absolute;_filter:alpha(opacity=0);opacity=0;z-index:-1;width:100%;height:100%;top:0;left:0;scrolling:no;" frameborder="0" src="about:blank"></iframe>
            <dl class="app_list">
                <?php foreach ($ts['user_app'] as $_temp_type => $_temp_apps) { ?>
                <?php foreach ($_temp_apps as $_temp_app) { ?>
                    <dd>
                        <?php if($_temp_type == 'local_app' || $_temp_type == 'local_default_app') { ?>
                        <a href="<?php echo $_temp_app['app_entry'];?>" class="a14">
                            <img class="app_ico" src="<?php echo $_temp_app['icon_url'];?>" />
                            <?php echo $_temp_app['app_alias'];?>
                        </a>
                        <?php }else { ?>
                        <a href="__ROOT__/apps/myop/userapp.php?id=<?php echo $_temp_app['app_id'];?>" class="a14">
                            <img class="app_ico" src="http://appicon.manyou.com/icons/<?php echo $_temp_app['app_id'];?>" />
                            <?php echo $_temp_app['app_alias'];?>
                        </a>
                        <?php }?>
                    </dd>
                <?php } // end of foreach?>
                <?php } // end of foreach?>
                </dl>
                <dl class="app_list_add">
                <dd><a href="<?php echo U('home/Index/addapp');?>"><span class="ico_app_add"></span>添加更多应用</a></dd>
                </dl>
          </div>
        </li>
  		<?php echo Addons::hook('header_topnav', array('menu' => & $header_topnav));?>
  		<?php if(is_array($header_topnav)): ?><?php $i = 0;?><?php $__LIST__ = $header_topnav?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo ($vo['url']); ?>" class="fb14"><?php echo ($vo['name']); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
      </ul>
    </div>
 </div>
	<!--个人信息区-->
    <ul class="person">
		<li><?php echo getUserSpace($mid,'fb14 username nocard','','',false);?></li>
		<li class="header_dropdown" id="message_show"><a href="<?php echo U('home/message/index');?>" class="application">消息<span class="ico_arrow"></span></a>
          <div class="dropmenu">
                <ul class="message_list_container message_list_new">
                </ul>
                <dl class="message">
      					<dd><a href="<?php echo U('home/message/index');?>">查看私信<?php if(($userCount['message'])  >  "0"): ?>(<?php echo ($userCount["message"]); ?>)<?php endif; ?></a></dd> 
      					<dd><a href="<?php echo U('home/user/atme');?>">查看@我<?php if(($userCount['atme'])  >  "0"): ?>(<?php echo ($userCount["atme"]); ?>)<?php endif; ?></a></dd> 
      					<dd><a href="<?php echo U('home/user/comments');?>">查看评论<?php if(($userCount['comment'])  >  "0"): ?>(<?php echo ($userCount["comment"]); ?>)<?php endif; ?></a></dd> 
      					<dd><a href="<?php echo U('home/message/notify');?>">系统通知<?php if(($userCount['notify'])  >  "0"): ?>(<?php echo ($userCount["notify"]); ?>)<?php endif; ?></a></dd> 
      					<dd><a href="<?php echo U('home/message/appmessage');?>">应用消息<?php if(($userCount['appmessage'])  >  "0"): ?>(<?php echo ($userCount["appmessage"]); ?>)<?php endif; ?></a></dd> 
                </dl>
                <dl class="square_list">
                <dd><a href="javascript:ui.sendmessage(0)">发私信</a></dd>
                </dl>
          </div>
        </li>
		<li class="header_dropdown" id="account_show"><a href="<?php echo U('home/Account');?>" class="application">帐号<span class="ico_arrow"></span></a>
          <div class="dropmenu">
                <dl class="setup">
                <dd><a href="<?php echo U('home/User/findfriend');?>">找人</a></dd>
                <dd><a href="<?php echo U('home/Account');?>">设置</a></dd>
                <dd><a href="<?php echo U('home/Account/invite');?>">邀请</a></dd>
                <dd><a href="<?php echo U('home/Account/weiboshare');?>">小工具</a></dd>
                <?php echo Addons::hook('header_account_tab', array('menu' => & $header_account_drop_menu));?>
				        <?php if(is_array($header_account_drop_menu)): ?><?php $i = 0;?><?php $__LIST__ = $header_account_drop_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($vo['url']); ?>"><?php echo ($vo['name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                <?php if(($isSystemAdmin)  ==  "TRUE"): ?><dd><a href="<?php echo U('admin/index/index');?>">后台管理</a></dd><?php endif; ?>
                </dl>
                <dl class="square_list_add">
                <dd><a href="<?php echo U('home/Public/logout');?>">退出</a></dd>
                </dl>
          </div>
        </li>
    </ul>
	<!--/个人信息区-->
	<!--消息提示框-->
    <div id="message_list_container" class="layer_massage_box" style="display:none;">
    	<ul id="is_has_message" class="message_list_container">
        </ul>
        <a href="javascript:void(0)" onclick="ui.closeCountList(this)" class="del"></a>
    </div>
	<!--/消息提示框-->
  </div>
</div>
<!--/顶部导航-->
<?php } ?><?php endif; ?>
<?php if( !isset($_SESSION["userInfo"])): ?><div class="header_holder">
    <div class="header">
      <div class="logo"><a href="<?php echo U('home/Index');?>"><img src="<?php echo $ts['site']['site_logo']?$ts['site']['site_logo']:__THEME__.'/images/logo.png'; ?>" style="_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=crop)" /></a></div>
      <div id="indt" class="nav_sub br3">
        <p>
      	<?php if(($ts['site']['site_anonymous_square'])  ==  "1"): ?><a href="<?php echo U('home/Square');?>">微博广场</a>&nbsp;|&nbsp;<?php endif; ?>
      	<a href="<?php echo U('home/Public/register');?>">注册</a>&nbsp;|&nbsp;
      	<a href="javascript:ui.quicklogin();">登录</a>
        <p>
      </div>
  </div>
</div><?php endif; ?>
<?php echo constant(" 头部广告 *");?>
<?php if(is_array($ts['ad']['header'])): ?><?php $i = 0;?><?php $__LIST__ = $ts['ad']['header']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="ad_header"><div class="ke-post"><?php echo ($vo['content']); ?></div></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>  

<script>
$(document).ready(function(){
	$(".header_dropdown").hover(
		function(){ 
      var type = $(this).attr('id');
      if(type == 'message_show' || type == 'account_show') {
        var obj = document.getElementById('message_list_container');
        if(obj !== null) {
          var isHas = $('#is_has_message').html();
          if(isHas) {
            $('#message_list_container').css("display", 'none');
          }
        }
      }
      $(this).addClass("hover"); 
    },
		function(){ 
      var type = $(this).attr('id');
      if(type == 'message_show' || type == 'account_show') {
        var obj = document.getElementById('message_list_container');
        if(obj !== null) {
          var isHas = $('#is_has_message').html();
          if(isHas) {
            $('#message_list_container').css("display", '');
          }
        }
      }
      $(this).removeClass("hover"); 
    }
	);
	
	<?php if($mid > 0) { ?>
		ui.countNew();
		setInterval("ui.countNew()",120000);
	<?php } ?>
});
</script>

<?php echo constant(" 注册引导 *");?>
<?php if(!$mid && APP_NAME.'/'.MODULE_NAME != 'home/Public' && APP_NAME.'/'.MODULE_NAME != 'home/Index'){ ?>
<div class="content no_bg" style=" margin-bottom:10px;overflow:hidden;zoom:1">
  <div  style="padding:10px 15px;zoom:1;overflow:hidden;">
    <div style="float:right; width:220px; text-align:center; padding-top:5px;font-size:14px"><a class="regbtn4" title="立即注册" href="<?php echo U('home/Public/register');?>"> &nbsp;</a><br />
      有帐号？<a href="<?php echo U('home/Public/login');?>"><strong>马上登录</strong></a></div>
    <div style=" margin-right:250px;">
      <h2 class="f18px lh30 fB">欢迎来到<?php echo ($ts['site']['site_name']); ?>，赶紧注册吧！</h2>
      <p class="f14px cGray2">微博是一个大家表达真实自我的即时广播平台。赶紧开通微博，获得朋友、同事最新动态，通过网页、手机随时随地记录自己的点滴生活！</p>
    </div>
  </div>
</div>
<?php } ?>

<script type="text/javascript">
$(function() {
  $('#iframe_group_li').live('mousemove', function() {
    var group_width = $('#iframe_group').width();
    var group_height = $('#iframe_group').height();
    $('#iframe_g').css('width', group_width);
    $('#iframe_g').css('height', group_height);
  });
  $('#iframe_app_li').live('mousemove', function() {
    var app_width = $('#iframe_app').width();
    var app_height = $('#iframe_app').height();
    $('#iframe_a').css('width', app_width);
    $('#iframe_a').css('height', app_height);
  });
});
</script>
<link rel="stylesheet" type="text/css" href="../Public/css/square.css"/>
<script type="text/javascript" src="../Public/js/square.js"></script>
<script type="text/javascript" src="../Public/js/square.slide.js"></script>
<script>
$(document).ready(function(){
	<?php if($aboutkey){ ?>
	//今日看点
	var scrtime;
	var $ul = $('#topic_user_list');
	var $u  = $ul.find('.topic_user:first');

	$ul.hover(function(){
         clearInterval(scrtime);

 	},function(){
		scrtime = setInterval(function(){
			$u.fadeOut("slow",function(){
				if($u.css('display')=='none'){
					$next = $u.next();
					if($next.hasClass('topic_user')){
						$u = $next;
					}else{
						$u = $ul.find('.topic_user:first');
					}
					$u.fadeIn();
				}else{
					$u.css('display','block');
				}
			});
		},4500);

 	}).trigger("mouseleave");
	<?php } ?>

	//活跃用户
	<?php if($hotUserSlide): ?>hot_user_slide();<?php endif; ?>

	//名人推荐
	star_list();

	//微博列表
	$("#square_list_tab a").click(function(){
		var $a = $(this);
		if(!$a.hasClass("on")){
			$("#square_list_tab a").removeClass("on");
			$a.addClass("on");
		}

		var url = $a.attr("source");
		square_index_weibo(url);
		return false;
	});
	square_index_weibo();
	
	
	
});
  var weibo = $.weibo({
          timeStep : 60000
    });

</script>
<div class="content_holder">
  <div class="content content_bg">
  	<div class="tab_Squ">
		<ul>
		<li><a href="<?php echo U('home/Square/index');?>" <?php if('index' == ACTION_NAME): ?>class="on"<?php endif; ?>>广场首页</a></li>
		<li><a href="<?php echo U('home/Square/top');?>" <?php if('top' == ACTION_NAME): ?>class="on"<?php endif; ?>>风云榜</a></li>
		<li><a href="<?php echo U('home/Square/star');?>" <?php if('star' == ACTION_NAME): ?>class="on"<?php endif; ?>>名人堂</a></li>
			<?php if(is_array($expend_menu)): ?><?php $i = 0;?><?php $__LIST__ = $expend_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo U('home/Square/' . $vo['act'], $vo['param']);?>" <?php if(ACTION_NAME == $vo['act']): ?>class="on"<?php endif; ?>><?php echo ($vo['name']); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
		</ul>
</div>
    <div class="wrap_Squ"> 
        <div class="mainbox_appR">
        <?php echo Addons::hook('home_square_index_right_top');?>
        <div class="right_box">
          <?php echo W('HotTopic', array('type'=>'recommend',limit=>5));?>
          <?php echo W('HotTopic', array('type'=>'auto','limit'=>5));?>
        </div>
        <?php echo Addons::hook('home_square_index_right_bottom');?>
        <?php if (Addons::requireHooks('home_index_right_advert')) { ?>
            <?php echo Addons::hook('home_index_right_advert', array($ts['ad']['right']));?>
        <?php } else { ?>
            <?php if(is_array($ts['ad']['right'])): ?><?php $i = 0;?><?php $__LIST__ = $ts['ad']['right']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="ad_right"><div class="ke-post lineS_btm"><?php echo ($vo["content"]); ?></div></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
        <?php } ?>
        <!--粉丝榜-->
        <div class="right_box">
          <h2>粉丝榜</h2>
          <ul class="fans_toplist">
            <?php if(is_array($topfollow)): ?><?php $i = 0;?><?php $__LIST__ = $topfollow?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if($key>2){ $class='no'; }else{ $class='no top'.($key+1); } ?>
          <li>
            <em class="<?php echo ($class); ?>"><?php echo ($key+1); ?></em>
            <a href="<?php echo U('home/space/index',array('uid'=>$vo['uid']));?>"><img src="<?php echo (getUserFace($vo["uid"])); ?>" class="userFace"/></a>
            <div>
                <?php echo getUserSpace($vo["uid"],'OverH nam ','','{uname}') ?>
                <p><span><?php echo ($vo["count"]); ?></span>粉丝数</p>
            </div>
          </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
          </ul>
        </div>
        <!--/粉丝榜-->
      </div>
    <div class="mainbox_appC" >
        <?php echo Addons::hook('home_square_index_top');?>
        <?php if($aboutkey){ ?>
		<div class="Hotspot_box">
            <?php if(($mid)  >  "0"): ?><div class="hotspot_tit"><span><a href="javascript:void(0)" onclick="weibo.quickpublish('#<?php echo (addslashes(str_replace('"','&quot;',$aboutkey))); ?># ')">我也说几句&raquo;</a></span><strong>今日看点:</strong>大家一起聊<a href="<?php echo U('home/User/topics',array('k'=>$aboutkey));?>"><?php echo ($aboutkey); ?></a>"吧</div><?php endif; ?>
            <div class="topic">
                <div id="topic_user_list">
                <?php if(is_array($userlist)): ?><?php $i = 0;?><?php $__LIST__ = $userlist?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="topic_user" <?php if($i > 1){echo 'style="display:none;"';}else{echo 'style="display:block;"';} ?>>
                      <div class="dd left">
                        <span class="userPic mb10">
                          <?php echo getUserSpace($vo["uid"],'','','{uavatar}') ?>
                        </span>
                      </div>
                      <div class="dd left" style="width:480px">
                        <h3>
                          <?php echo getUserSpace($vo["uid"],'','','{uname}') ?>
                        </h3>
                        <p><?php echo ($vo["userinfo"]["location"]); ?> <a href="<?php echo U('home/Space/follow',array('uid'=>$vo['uid'],'type'=>'follower'));?>">粉丝<?php echo (intval($vo["follower"])); ?>人</a></p>
                        <p style=" height:35px; overflow:hidden; display:block; line-height: 18px;"><a href="<?php echo U('home/space/detail',array('id'=>$vo['weibo_id']));?>"><?php echo (getShort($vo["content"],66)); ?></a> (<?php echo (friendlyDate($vo["ctime"])); ?>)</p>
                      </div>
                  </div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                </div>
            </div>
		</div><!--今日看点-->
		<?php } ?>
        <div class="laSOSO">
           <div class="sosobox">
            <input type="text" id="s_keyword" class="text mr5 left" style="width:300px;"><input type="button" onclick="s_search('topic')" value="搜微博" class="btn_b mr5"><input type="button" onclick="s_search('user')" value="搜人" class="btn_b"></div>
        </div><!--搜索框-->
        <?php if($hotUser): ?><div class="tab-menu">
            <ul>
              <li><a class="feed_item on"  href="javascript:void(0)" ><span>活跃用户</span></a></li>
            </ul>
          </div><!--活跃用户标题-->
          <div id="hot_user_list">
                <a href="#" ref="pre_slide" class="pre_slide"><!--<?php if($hotUserSlide): ?>&lt;<?php else: ?>&nbsp;<?php endif; ?>--></a>
                <div id="hot_user_slides" class="slides_container" style="position:relative; overflow:hidden;">
                  <?php if(is_array($hotUser)): ?><?php $i = 0;?><?php $__LIST__ = $hotUser?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$hu): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="hot_user_slide" style="position:absolute;<?php if($i>1){echo 'display:none;';}else{echo 'display:block;';} ?>">
                    <?php if(is_array($hu)){ ?>
                    <?php foreach($hu as $u){ ?>
                        <div class="left" style="width:126px; height:60px; overflow:hidden;padding-right:10px">
                          <div class="userPic" ><?php echo getUserSpace($u["uid"],'','','{uavatar}') ?></div>
                          <div style="margin-left:60px;">
                            <?php echo getUserSpace($u["uid"],'','','{uname}') ?><br />
                            <span class="lh30 cGray2"><a href="<?php echo U('home/space/follow',array('uid'=>$u['uid'],'type'=>'follower'));?>">粉丝<?php echo ($u["follower"]); ?>人</a></span>
                          </div>
                        </div>
                    <?php }} ?>
                  </div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                </div>
                <a href="#" ref="next_slide" class="next_slide"><!--<?php if($hotUserSlide): ?>&gt;<?php else: ?>&nbsp;<?php endif; ?>--></a>
            </div><!--活跃用户列表--><?php endif; ?>
        <?php if($star_list): ?><div>
              <div class="tab-menu">
                  <ul>
                      <span class="right"><a href="<?php echo U('home/Square/star');?>" target="_blank">更多&raquo;</a></span>
                      <li><a class="feed_item on"  href="javascript:void(0)" ><span>名人推荐</span></a></li>
                  </ul>
              </div>
	          <div id="star_list" class="star_list">
	            <img src="__THEME__/images/icon_waiting.gif" width="20" style="margin:33px 50% 0 50%;" />
	          </div>
	        </div><?php endif; ?><!--名人推荐-->
        <?php echo Addons::hook('home_square_index_middle');?>
        <div class="tab-menu" id="square_list_tab"><!-- 切换标签 begin  -->
          <ul>
            <?php if(is_array($square_list_menu)): ?><?php $i = 0;?><?php $__LIST__ = $square_list_menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a class="feed_item <?php if(!$key): ?>on<?php endif; ?>" source="<?php echo U('home/square/index_weibo', array('type'=>$key));?>"><span><?php echo ($vo); ?></span></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
          </ul>
        </div><!--tabmenu-->
        <div id="square_list"><img src="__THEME__/images/icon_waiting.gif" width="20" style="margin:33px 50% 0 50%;" /></div><!--微博列表-->
        </div>
    </div>
</div>
    <div class="clear"></div>
</div>
<?php echo Addons::hook('weibo_js_plugin');?>
<!-- 内容 end --> 
<?php if(is_array($ts['ad']['footer'])): ?><?php $i = 0;?><?php $__LIST__ = $ts['ad']['footer']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="ad_footer"><div class="ke-post"><?php echo ($vo['content']); ?></div></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<div class="footer_bg">
<div class="footer">
	<div class="menu">
		<?php foreach($ts['footer_document'] as $k => $v) {
            $v['url'] = isset($v['url']) ? $v['url'] : U('home/Public/document',array('id'=>$v['document_id']));
            $ts['footer_document'][$k] = '<a href="'.$v['url'].'" target="_blank">'.$v['title'].'</a>';
        }
        echo implode('&nbsp;&nbsp;|&nbsp;&nbsp', $ts['footer_document']); ?>
	</div>
	<div>
		Powered by <a href="http://www.thinksns.com/" target="_blank" title="ThinkSNS开源微博系统">ThinkSNS</a>&nbsp;&nbsp; <?php echo ($ts['site']['site_icp']); ?> 
		<?php if(isMobile()) { ?>
			<a href="<?php echo U('home/Public/toWap');?>">访问WAP版</a>
		<?php } ?>
	</div>
</div>
</div>
</div>
<?php $ts['cnzz'] = getCnzz(false);
if (!empty($ts['cnzz'])) { ?>
<div style="display:none;">
<script src="http://s87.cnzz.com/stat.php?id=<?php echo ($ts['cnzz']['cnzz_id']); ?>&web_id=<?php echo ($ts['cnzz']['cnzz_id']); ?>" language="JavaScript" charset="gb2312"></script>
</div>
<?php } ?>
<?php echo Addons::hook('public_footer');?>
</body>
</html>