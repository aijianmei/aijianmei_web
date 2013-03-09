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
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<div class="content_holder">
<div class="content"><!-- 内容 begin  --> 
     <?php echo Addons::hook('home_index_left_top_outline');?>
<div class="user_app"><!-- 用户组件列表 begin -->
    <?php echo Addons::hook('home_index_left_top');?>

	<div class="user_app_top"></div>
    <div class="user_app_box">
  <div class="userinfo">
    	<div class="userpic" onmouseover="this.className='userpic over'" onmouseout="this.className='userpic'" >
			<span id="my_face"><?php echo getUserSpace($mid,'nocard','','{uavatar}') ?></span>
			<a class="pic" href="<?php echo U('home/account/index');?>#face">上传头像</a>
		</div>
  		<div class="user_name">
        	<h2><?php echo ($userInfoCache['uname']); ?><?php Addons::hook('user_name_end', array('uid'=>$mid, 'html'=>&$user_name_end));echo $user_name_end; ?><?php echo (getUserGroupIcon($mid)); ?></h2>
            <?php $user_credit = $userInfoCache['credit'];
            	foreach($user_credit as $k => $v) { ?>
           		<p><?php echo ($v['alias']); ?>：<a href="<?php echo U('home/Account/credit');?>" title="<?php echo ($v['credit']); ?>"><span class="cRed"><?php echo ($v['credit']); ?></span></a></p>
            <?php }
                unset($user_credit); ?>
        </div>
  </div>
  <?php echo Addons::hook('home_index_left_avatar_bottom');?>
  <!--关注-->
  <div class="user_follow app_line">
  	<span><a href="<?php echo U('home/space/follow',array('type'=>'following', 'uid'=>$mid));?>"><strong><?php echo ($userInfoCache['following']); ?></strong><br />关注</a></span>
    <span class="app_lineL"><a href="<?php echo U('home/space/follow',array('type'=>'follower', 'uid'=>$mid));?>"><strong><?php echo ($userInfoCache['follower']); ?></strong><br />粉丝</a></span>
    <span class="app_lineL"><a href="<?php echo U('home/space/index',array('uid'=>$uid));?>"><strong id="miniblog_count"><?php echo ($userInfoCache['miniNum']); ?></strong><br />微博</a></span>
  </div>
  <!--关注 end-->
  <div class="celerity_menu app_line">
  	<ul>
        <li><a href="<?php echo U('home/user/index');?>" <?php echo getMenuState('user/index');?>><span class="ico_side ico_home"></span>我的首页</a></li>
        <li><a href="<?php echo U('home/user/atme');?>" <?php echo getMenuState('user/atme');?>><span class="ico_side ico_atme"></span>提到我的 
        <span id="app_left_count_atme"><?php if(($userCount['atme'])  >  "0"): ?>(<font color="red"><?php echo ($userCount["atme"]); ?></font>)<?php endif; ?></span>
        </a>
        </li>
        <li><a href="<?php echo U('home/user/collection');?>" <?php echo getMenuState('user/collection');?>><span class="ico_side ico_favorites"></span>我的收藏</a></li>
        <li><a href="<?php echo U('home/user/comments');?>" <?php echo getMenuState('user/comments');?>><span class="ico_side ico_comment"></span>我的评论 
        <span id="app_left_count_comment"><?php if(($userCount['comment'])  >  "0"): ?>(<font color="red"><?php echo ($userCount["comment"]); ?></font>)<?php endif; ?></span>
        </a>
        </li>
        <?php if(Addons::requireHooks('home_index_left_tab')): ?><?php echo Addons::hook('home_index_left_tab', array(&$menu));?>
            <?php if(is_array($menu)): ?><?php $i = 0;?><?php $__LIST__ = $menu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo U('home/user/' . $vo['act']);?>" <?php echo getMenuState('user/' . $key);?>><?php echo ($vo['name']); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?><?php endif; ?>
  	</ul>
  </div>
  <div class="celerity_menu app_line">
  	<ul>
  	    <?php if(is_array($install_app)): ?><?php $i = 0;?><?php $__LIST__ = $install_app?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if(empty($vo['app_alias'])) continue; ?>
  	        <li>
				<a href="<?php echo ($vo["app_entry"]); ?>" title="<?php echo ($vo["description"]); ?>" class="user_app_link" >
				<?php if($vo['sidebar_entry']){ ?>
				    <span class="user_app_entry" target="_blank" url="<?php echo ($vo["sidebar_entry"]); ?>"><?php echo ($vo["sidebar_title"]); ?></span>
                <?php } ?>
                <img src="<?php echo getAppIconUrl($vo['icon_url'],$vo['app_name']);;?>" class="user_app_icon" /><?php echo (getShort($vo["app_alias"],5,'...')); ?></a>

  	        </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  	</ul>
  </div>
    
	<div class="app_add app_line">
    <span class="right"><span class="ico_app_manage"></span><a href="<?php echo U('home/Index/editapp');?>">管理</a></span>
    <span><span class="ico_app_add"></span><a href="<?php echo U('home/Index/addapp');?>">添加</a></span>
    </div>

    <?php echo Addons::hook('home_index_left_middle');?>

    </div>
	<div class="user_app_btm"></div>
    <?php echo Addons::hook('home_index_left_bottom');?>
    <?php if (Addons::requireHooks('home_index_left_advert')) { ?>
    	<?php echo Addons::hook('home_index_left_advert', array($ts['ad']['left']));?>
    <?php } else { ?>
		<?php if(is_array($ts['ad']['left'])): ?><?php $i = 0;?><?php $__LIST__ = $ts['ad']['left']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="ad_left"><div class="ke-post"><?php echo ($vo["content"]); ?></div></div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    <?php } ?>
	</div><!-- 用户组件列表 end -->
<?php function getMenuState($type){
	$type = split('/',$type);
	if( strtolower(MODULE_NAME)==strtolower($type[0]) && ( strtolower(ACTION_NAME)==strtolower($type[1]) || $type[1]=='*') ){
		return 'class="on"';
	}
} ?>
  <div class="main">
    <div class="mainbox">
      <div class="mainbox_R">
	    <?php if(is_array($ts['ad']['right_top'])): ?><?php $i = 0;?><?php $__LIST__ = $ts['ad']['right_top']?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><div class="ke-post setskinbox lineS_btm">
			<?php echo ($vo['content']); ?>
		</div><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	    <?php echo Addons::hook('home_index_right_top');?>
        <div class="right_box">
          <h2><a href="javascript:void(0)" onclick="$('.quick_win').show()" class="right" style="font-weight:400;font-size:12px">添加</a>关注的话题</h2>
          <div style="display:none;" class="quick_win">
            <a href="javascript:void(0)" onclick="$('.quick_win').hide()" class="del" title="关闭"></a>
            <p>
              <input type="text" class="text" name="quick_name" style=" width:130px;display:block;margin:0 0 5px 0"/>
              <input type="button" onclick="addFollowTopic()" value="保存" class="btn_b" />
            </p>
            <p class="cGray2">请添加想关注的话题</p>
          </div>
          <ul class="topic_list" rel="followTopicArea">
            <?php if(is_array($followTopic)): ?><?php $i = 0;?><?php $__LIST__ = $followTopic?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li onmouseover="$(this).find('.del').show()" onmouseout="$(this).find('.del').hide()"><a class="del right" style="display:none" title="删除" href="javascript:void(0)" onclick="deleteFollowTopic(this,'<?php echo ($vo["topic_id"]); ?>')"></a><a href="<?php echo U('home/user/topics',array('k'=>urlencode($vo['name'])));?>" title="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
          </ul>
        </div>
		
        <div class="right_box">
    	<?php echo W('HotTopic', array('type'=>'recommend'));?>
        </div>
      </div>
      <div class="mainbox_C main_pad">
      <div class="tab-menu"><!-- 切换标签 begin  -->
        <ul>
          <li><a id="feed_colleague_item" rel="colleague" class="<?php if(($type)  ==  "receive"): ?>on<?php endif; ?> feed_item" href="<?php echo U('home/user/comments',array('type'=>'receive','from_app'=>$from_app));?>"><span>收到的评论</span></a></li>
          <li><a id="feed_all_item" rel="all" class="<?php if(($type)  ==  "send"): ?>on<?php endif; ?> feed_item" href="<?php echo U('home/user/comments',array('type'=>'send','from_app'=>$from_app));?>"><span>发出的评论</span></a></li>

        </ul>
      </div>
      <div class="MenuSub ">
	      <span class="right pr5">共<?php echo ($list["count"]); ?>条</span>
	      <a href="<?php echo U('home/user/comments',array('type'=>$type, 'from_app'=>'weibo'));?>" <?php if(($from_app)  ==  "weibo"): ?>class="on"<?php endif; ?> >微博<?php if($type == 'receive' && $userCount['weibo_comment'] > 0) { ?><em> (<font color="red"><?php echo ($userCount['weibo_comment']); ?></font>)</em><?php } ?></a> | 
		  <a href="<?php echo U('home/user/comments',array('type'=>$type, 'from_app'=>'other'));?>" <?php if(($from_app)  ==  "other"): ?>class="on"<?php endif; ?> >其它应用<?php if($type == 'receive' && $userCount['global_comment'] > 0) { ?> <em> (<font color="red"><?php echo ($userCount['global_comment']); ?></font>)</em><?php } ?></a>
	  </div>
      <div class="feedBox"> 
        <ul class="feed_list">
        <?php if($type=='send' && !empty($list['data'])){ ?>
        <li class="t"><span class="left" style="padding:0px 5px 0 6px;"><input onclick="checkAllReply(this)" type="checkbox" /></span>
        <a href="#">全选</a> | <a href="javascript:void(0)" onclick="doDelete()">删除</a>
        </li>
        <?php } ?>
<?php if(is_array($list["data"])): ?><?php $i = 0;?><?php $__LIST__ = $list["data"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if($from_app=='weibo') { ?><!-- 微薄的评论 -->
    
	<?php if($type=='send'){ ?>
            <li class="lineD_btm">
            <div class="left" style="padding:0px 5px 0 6px;"><input name="id[]" type="checkbox" value="<?php echo ($vo["comment_id"]); ?>" /></div>
              <div class="userPic"><?php echo getUserSpace($vo["reply_uid"],'','','{uavatar}') ?></div>
              <div class="feed_c" style="margin-left:90px">
                <div class="msgCnt" style="padding-bottom:0; font-size:12px"><?php echo (format($vo["content"])); ?>(<?php echo (date('m月d日 H:i',$vo["ctime"])); ?>)</div>

			    <div class="feed_c_btm"> 
				<?php if($vo['ismini']){ ?>
					 回复 <?php echo getUserSpace($vo["reply_uid"],'','','{uname}') ?> 的微博："<?php echo (format($vo["mini"]["content"],true)); ?>"
			    <?php }else{ ?>
					 回复 <?php echo getUserSpace($vo["reply_uid"],'','','{uname}') ?> 的评论: "<?php echo (formatComment($vo["comment"]["content"],true)); ?>"
				<?php } ?>
				</div>
                <div class="alR"><a href="<?php echo U('home/Space/detail',array('id'=>$vo['weibo_id']));?>">查看</a><span style="color:#666;"> | </span><a href="javascript:void(0)"  onclick="doDelete(<?php echo ($vo["comment_id"]); ?>)" >删除</a></div>
              </div>
            </li>
	<?php }else{ ?>
            <li class="lineD_btm">
            <div class="left" style="padding:0px 5px 0 6px;"></div>
              <div class="userPic"><?php echo getUserSpace($vo["uid"],'','','{uavatar}') ?></div>
              <div class="feed_c">
                <div class="msgCnt" style="padding-bottom:0; font-size:12px"><?php echo getUserSpace($vo["uid"],'','','{uname}') ?>: <?php echo (formatComment($vo["content"],true)); ?>(<?php echo (friendlyDate($vo["ctime"])); ?>)

                </div>

			    <div class="feed_c_btm"> 
				<?php if($vo['ismini']){ ?>
					 回复我的微博："<?php echo (format($vo["mini"]["content"],true)); ?>"
			    <?php }else{ ?>
					 回复我的评论: "<?php echo (formatComment($vo["comment"]["content"],true)); ?>"
				<?php } ?>
				</div>
                <div class="alR"><a href="<?php echo U('home/Space/detail',array('id'=>$vo['weibo_id']));?>">查看</a><span style="color:#666;"> | </span><a href="javascript:void(0)" rel="comment_reply" callback="dosuccess" uname="<?php echo (getUserName($vo["uid"])); ?>" commentid="<?php echo ($vo["comment_id"]); ?>" minid="<?php echo ($vo["mini"]["id"]); ?>">回复</a></div>
                <div id="comment_list_<?php echo ($vo["comment_id"]); ?>"></div>
              </div>
            </li>
	<?php } ?>
	
<?php }else { ?>

    <!-- 其它应用的评论 -->
    <?php if($type=='send'){ ?>
            <li class="lineD_btm">
            <div class="left" style="padding:0px 5px 0 6px;"><input name="id[]" type="checkbox" value="<?php echo ($vo["id"]); ?>" /></div>
              <div class="userPic"><?php echo getUserSpace($vo["to_uid"],'','','{uavatar}') ?></div>
              <div class="feed_c" style="margin-left:90px">
                <div class="msgCnt" style="padding-bottom:0; font-size:12px"><?php echo (formatComment($vo["comment"],true)); ?>(<?php echo (date('m月d日 H:i',$vo["cTime"])); ?>)</div>
                <div class="feed_c_btm"> 
                    来自<?php echo (getAppAlias($vo["type"])); ?>: <a href="<?php echo ($vo["data"]["url"]); ?>"><?php echo ($vo["data"]["title"]); ?></a>
                </div>
                <div class="alR"><a href="javascript:void(0)" onclick="doDelete(<?php echo ($vo["id"]); ?>)" >删除</a></div>
              </div>
            </li>
    <?php }else{ ?>
            <li class="lineD_btm">
              <div class="userPic"><?php echo getUserSpace($vo["uid"],'','','{uavatar}') ?></div>
              <div class="feed_c" style="margin-left:90px">
                <div class="msgCnt" style="padding-bottom:0; font-size:12px">
                    <?php echo getUserSpace($vo["uid"],'','','{uname}') ?>: <?php echo (formatComment($vo["comment"],true)); ?>(<?php echo (friendlyDate($vo["cTime"])); ?>)
                </div>
                <div class="feed_c_btm"> 
                    来自<?php echo (getAppAlias($vo["type"])); ?>: <a href="<?php echo ($vo["data"]["url"]); ?>"><?php echo ($vo["data"]["title"]); ?></a>
                </div>
                <div class="alR"><a href="javascript:void(0)" rel="comment_reply" callback="dosuccess" commentid="<?php echo ($vo["id"]); ?>" >回复</a></div>
                <div id="comment_list_<?php echo ($vo["id"]); ?>"></div>
              </div>
            </li>
    <?php } ?>

<?php } ?><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php if($type=='send' && !empty($list['data'])){ ?>
           <li class="t"><span class="left" style="padding:0px 5px 0 6px;"><input onclick="checkAllReply(this)" type="checkbox" /></span>
        <a href="#">全选</a> | <a href="javascript:void(0)" onclick="doDelete()">删除</a>
        </li>
        <?php } ?>
        </ul>
      </div>
      <div class="c"></div>
      <div class="page"><?php echo ($list["html"]); ?></div>
    </div>
  </div>
  <div class="clear"></div>
</div>
</div>
</div>
<!-- 内容 end --> 
<script>
	$(document).ready(function(txt){
	<?php if($from_app=='weibo') { ?>
	    $("a[rel='comment_reply']").live('click',function(){
	    	var id         = $(this).attr('minid');
	        var comment_id = $(this).attr('commentid');
	        var uname      = $(this).attr('uname');
	        var callback   = $(this).attr('callback');
		    if( $("#comment_list_"+comment_id).html()=='' ){
			    $("#comment_list_"+comment_id).html('<div class="feed_quote feed_wb" style="text-align:center"><img src="'+ _THEME_+'/images/icon_waiting.gif" width="15"></div>');
			    $.post( U("weibo/Index/loadcomment"),{id:id,quick_reply:"1",quick_reply_comment_id:comment_id,quick_reply_uname:uname,callback:callback},function(txt){
				    $("#comment_list_"+comment_id).html( txt ) ;
			    });
		    }else{
		  	    $("#comment_list_"+comment_id).html('');
		    }
	    });
	<?php }else { ?>
	    $("a[rel='comment_reply']").live('click',function(){
            var comment_id = $(this).attr('commentid');
            var callback   = $(this).attr('callback');
            if( $("#comment_list_"+comment_id).html()=='' ){
                $("#comment_list_"+comment_id).html('<div class="feed_quote feed_wb" style="text-align:center"><img src="'+ _THEME_+'/images/icon_waiting.gif" width="15"></div>');
                $.post( U("home/Comment/quickReply"),{to_id:comment_id,callback:callback},function(txt){
                    $("#comment_list_"+comment_id).html( txt ) ;
                });
            }else{
                $("#comment_list_"+comment_id).html('');
            }
        });
	<?php } ?>
	})


	//选择全部评论
	function checkAllReply(o){
		if(o.checked){
			$("input[name='id[]']").attr('checked',true);
		}else{
			$("input[name='id[]']").removeAttr('checked');
		}
	}
	
	 function dosuccess(txt){
		$("#comment_list_"+txt.data['reply_comment_id']).html('');
		ui.success('回复成功');
	 }
	

  function getChecked() {
    var uids = new Array();
    $.each($('input:checked'), function(i, n){
      uids.push( $(n).val() );
    });
    return uids;
  }
	//提交删除
	function doDelete(id){
    var length = 0;
    if(id) {
        length = 1;         
    }else {
        id    = getChecked();
        length = id.length;
        id    = id.toString();
    }
    if(id=='') {
        ui.error('请先选择一条评论');
        return ;
    }
    if(id == '' || !confirm('删除成功后将无法恢复，确认继续？')) return false;
		var url = "<?php echo $from_app=='weibo' ? U('weibo/Operate/deleteMuleComment') : U('home/Comment/doDelete'); ?>";
		$.post(url,{id:id},function(txt){
			ui.success('删除成功');
			location.replace(location.href);
		})
	}
	
	// 其它应用的评论的快速回复
	function quickReply(id) {
		var comment = $('#comment_'+id).val();
		var with_new_weibo = $('#with_new_weibo_'+id).attr('checked') ? '1' : '0';
		if(comment=='') {
			ui.error('评论不能为空');
			return ;
		}
		$.post(U("home/Comment/doQuickReply"),{to_id:id,comment:comment,with_new_weibo:with_new_weibo},function(res){
			if(res==1){
				ui.success('回复成功');
				$('#comment_'+id).val('');
				$('#comment_quick_reply_'+id).toggle();
			}
		});
	}
</script>
<script>
var weibo = $.weibo({
  timeStep : 60000
});
</script>
<?php echo Addons::hook('weibo_js_plugin');?>
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