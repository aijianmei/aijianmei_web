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
<link href="../Public/account.css" rel="stylesheet" type="text/css" />
<link href="../Public/js/setavatar/css/imgareaselect-default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery.form.js"></script>
<script type="text/javascript" src="../Public/js/avatar/avatar.js"></script>
<script type="text/javascript" src="../Public/js/account.js"></script>
<script type="text/javascript" src="../Public/js/setavatar/jquery.imgareaselect.min.js"></script>
<div class="content_holder">
<div class="content"><!-- 内容 begin  --> 
  <div class="main no_l"><!-- 右侧内容 begin  -->
    <div class="mainbox">
      <div class="mainbox_appC no_r">
        <div class="tab-menu"><!-- 切换标签 begin  -->
      <ul>
        <?php if(is_array($accountmenu)): ?><?php $i = 0;?><?php $__LIST__ = $accountmenu?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo U('home/Account/'.$vo['act'], $vo['param']);?>" <?php if(ACTION_NAME==$vo['act']){ ?>class="on"<?php } ?> ><span><?php echo ($vo["name"]); ?></span></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
      </ul>
    </div>
    <!-- 切换标签 end  -->
    <div class="mainbox_C_C">
		<div class="setupBox">
          <div class="setItems">
            <div class="setFold setUnfold" rel="base" >
              <h2>基本资料</h2>
              <div class="setStep"> <span class="txt1">用户基本信息</span></div>
            </div>
            <div style="display: block;" class="setItemsInfo">
		      <div class="data">
              <!-- 基本资料 begin  -->
		          <form action="<?php echo U('home/Account/update');?>" method="post" dotype="ajax" class="form_validator" type="base" id="regform" oncomplete="false">
			        <input type="hidden" name="dotype" value="upbase">
		            <dl class="set_basic">
		                <dd>
		                    <label>昵称：</label>
		                    <div class="left">
		                      <div class="left mr5"><input name="nickname" maxLength="110" type="text" class="text" value="<?php echo ($userInfo["detail"]["uname"]); ?>" /><br />
		                      2-10位个中英文、数字、下划线和中划线<br />
		                      修改昵称会造成已发布微博中@你的昵称失效
		                      </div>
		                    </div>
		                </dd>
		                <dd id="isLocation" style="display:none;">
		                    <label>所在地区：</label>
		                    <div class="left" style="_width:600px"><iframe style="position:absolute;_filter:alpha(opacity=0);opacity=0;z-index:-1;width:100%;height:100%;top:0;left:0;scrolling:no;" frameborder="0" src="about:blank"></iframe>
							      <script>ui.getarea('area','',<?php echo ($userInfo["detail"]["province"]); ?>,<?php echo ($userInfo["detail"]["city"]); ?>);</script>
		                    </div>
		                </dd>
						
		                <dd>
		                    <label>性别：</label>
                            <div class="left">
		                        <label><input name="sex" type="radio" value="1" <?php if(($userInfo["detail"]["sex"])  ==  "1"): ?>checked='true'<?php endif; ?> /> 男</label> &nbsp;&nbsp;&nbsp;
		                        <label><input name="sex" type="radio" value="0" <?php if(($userInfo["detail"]["sex"])  ==  "0"): ?>checked='true'<?php endif; ?>  dataType="Group"  msg="必须选定一个性别" /> 女</label>
		                    </div>
						</dd>
		          </dl>
				  <?php echo Addons::hook('home_account_profile_base');?>
		          <dl class="set_basic"><dd><label>&nbsp;</label><input type="submit" class="btn_b" value="保存" /></dd></dl>
		          </form>
		        </div>
                <!-- 基本资料 end  -->
            </div>
          </div>
		  <div class="setItems">
            <div class="setFold" rel="tags">
              <h2>个人标签</h2>
              <div class="setStep"> <span class="txt1">添加描述自己职业、兴趣爱好等方面的词语，让更多人找到你，让你找到更多同类</span></div>
            </div>
            <div class="setItemsInfo"> 
				<div class="setupTag_box">
                	<div class="setupTag_boxL">
                            	<input type="text" id="tag_input" class="text mr5 left"  maxlength="110" style=" width:170px">
                                <a class="btn_b" href="javascript:void(0);" id="add_tag" onclick="doUserTag()"><em>保存</em></a>
                <div class="mt10 cGray2">选择最适合你的词语，多个标签用'逗号'格开.如 thinksns,web</div></div>
                    <div class="setupTag_boxR">
                    	<p>你可能感兴趣的标签(点击直接添加) ：</p>
                        <div id="rec_tags" class="setupTag_list01">
                        <?php if(is_array($userFavTag)): ?><?php $i = 0;?><?php $__LIST__ = $userFavTag?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><a href="javascript:;" onclick="addTagById(<?php echo ($vo["tag_id"]); ?>)" title="添加标签"><em>+</em><?php echo ($vo["tag_name"]); ?></a><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                       </div>
                       </div>
                    </div>
                    
                 <div class="lineS_top pt10 cGray2">我已经添加的标签</div>
                 <div class="setupTag_list02" id="mytagshow2">
                    <ul id="tag_list" class="tagList">
						<?php if(is_array($userTag)): ?><?php $i = 0;?><?php $__LIST__ = $userTag?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a class="a1" href="<?php echo U('home/user/searchtag',array('k'=>$vo['tag_name']));?>"><?php echo ($vo["tag_name"]); ?></a><a class="a2" onclick="deleteTag(this)" tagid="<?php echo ($vo["user_tag_id"]); ?>" href="javascript:;"><img class="del" src="__THEME__/images/zw_img.gif" /></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
					</ul>
                    <div class="clear"></div>
                    </div>
                </div>
			</div>
          <div class="setItems">
            <div class="setFold" rel="intro">
              <h2>个人情况</h2>
              <div class="setStep"> <span class="txt1">个人详情，将出现在个人空间详细资料里</span></div>
            </div>
            <div style="display:none;"  class="setItemsInfo"> 
				 <div class="data">
                 <!-- 个人情况 begin  -->
					<form action="<?php echo U('home/Account/update');?>" method="post" dotype="ajax" class="form_validator" type="intro" >
					<input type="hidden" name="dotype" value="upintro">
					    <dl class="set_basic">
					        <?php if(is_array($userInfo["intro"]["list"])): ?><?php $i = 0;?><?php $__LIST__ = $userInfo["intro"]["list"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd>
						          <label><?php echo ($vo["name"]); ?>：</label>
                                  <div class="left">
						            <input type="text"  class="text" style="width:400px;" onfocus="this.className='text2'" onblur="this.className='text'"  name="intro[<?php echo ($vo["field"]); ?>]" value="<?php echo ($vo["value"]); ?>"/>
						          </div>
					            </dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
						</dl>
						<?php echo Addons::hook('home_account_profile_intro');?>
						<dl class="set_basic">
					        <dd><label>&nbsp;</label><input type="submit" class="btn_b" value="保存" /></dd>
						</dl>					
					</form>
				</div>
                <!-- 个人情况 end  -->
			</div>
          </div>
		  
          <div class="setItems">
            <div class="setFold" rel="contact" >
              <h2>联系方式</h2>
              <div class="setStep"> <span class="txt1">补充联系方式，更方便你的朋友联系上你</span></div>
            </div>
            <div style="display:none;"  class="setItemsInfo"> 
				 <div class="data">
                 <!-- 联系方式 begin  -->
					<form action="<?php echo U('home/Account/update');?>" method="post" dotype="ajax" class="form_validator" type="contact" >
					<input type="hidden" name="dotype" value="upcontact">
					    <dl class="set_basic">
					        <?php if(is_array($userInfo["contact"]["list"])): ?><?php $i = 0;?><?php $__LIST__ = $userInfo["contact"]["list"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd>
						          <label><?php echo ($vo["name"]); ?>：</label><div class="left">
						            <input type="text" id="old_<?php echo ($vo['name']); ?>" class="text" style="width:400px;" onfocus="this.className='text2'" onblur="this.className='text'"  name="contact[<?php echo ($vo["field"]); ?>]" value="<?php echo ($vo["value"]); ?>"/>
						          </div>
					            </dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
					</dl>
						<?php echo Addons::hook('home_account_profile_contact');?>
							<dl class="set_basic">
					        <dd><label>&nbsp;</label><input type="submit" class="btn_b" value="保存" /></dd>
					</dl>
					
					</form>
				</div>
                <!-- 联系方式 end  -->
			</div>
          </div>

          <div class="setItems">
              <div class="setFold" rel="education" >
              <h2>教育、工作情况</h2>
              <div class="setStep"> <span class="txt1">教育、工作情况</span></div>
            </div>
            <div style="display:none;"  class="setItemsInfo"> 
		        <div class="data">
                <!-- 教育情况 begin  -->
		            <div>
					<ul id="profileList">
						<?php if(is_array($userInfo["profile"]["list"])): ?><?php $i = 0;?><?php $__LIST__ = $userInfo["profile"]["list"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li id="pro_<?php echo ($vo["id"]); ?>">
							<?php switch($vo['module']): ?><?php case "education":  ?><div id="div_action_702" class="projectlist">
										<h3><a href="javascript:profile_del(<?php echo ($vo["id"]); ?>);" class="right"><span class="del"> &nbsp;</span></a>
										[教育]<a   target="_blank"><?php echo ($vo["school"]); ?></a>
										</h3><p><?php echo ($vo["year"]); ?>入学 - <?php echo ($vo["classes"]); ?></p>
									</div><?php break;?>
								<?php case "career":  ?><div id="div_action_702" class="projectlist">
											<h3><a href="javascript:profile_del(<?php echo ($vo["id"]); ?>);" class="right"><span class="del"> &nbsp;</span></a>
											[公司/机构]<a   target="_blank"><?php echo ($vo["company"]); ?></a>
											</h3><p><?php echo ($vo["begintime"]); ?> 至 <?php echo ($vo["endtime"]); ?><br><?php echo ($vo["position"]); ?></p>
									</div><?php break;?><?php endswitch;?>
							</li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
					</ul>
		                <h2 class="lh35  f14px"><strong>添加</strong></h2>
						<form action="<?php echo U('home/account/addproject');?>" class="form_validator" method="post" dotype="ajax" callback="addprofile">
						   <ul>
		                        <li>
                    				<div class="left alR lh25" style="width:15%;">类型：</div>
		                            <div class="left" style="width: 85%;padding:13px 0 0 0;">
		                            	<select name="addtype" onchange="changeEduCar(this)">
												<option value="">请选择</option>
												<option value="education">教育</option>
											    <option value="career">公司/机构</option>
											</select>
		                            </div>								
		                        </li>
							</ul>
							<ul id="educarContent">
							</ul>
								</form>
					</div>         
		        </div>
                <!-- 教育情况 end  -->	
			</div>
          </div>
		  <div class="setItems" id="face">
		    
            <div class="setFold" rel="face" >
			<div style="float:left;margin-right:10px;border:1px solid #8098A8;height:30px;padding:1px;width:30px;"><img src="<?php echo (getUserFace($mid,'s')); ?>" width="30"></div>
              <h2>上传头像</h2>
             <div class="setStep">
			  	<span class="txt1" id="avatarInfo">
				<?php if( isSetAvatar($mid) ){ ?>
					已设置头像
				<?php }else{ ?>
					未设置头像
				<?php } ?>
				</span>
              </div>
            </div>
            <div style=""  class="setItemsInfo"> 
				<div style="padding:10px 0;color:#666;"> 
				<form enctype="multipart/form-data" class="form_validator" method="post" id="uploadpic" name="upform" dotype="ajax" callback="uploadpic" target="upload_target" action="<?php echo U('home/Account/avatar',array('t'=>'upload'));?>">
				<input type="file" name="Filedata" onchange="douploadpic()" id="Filedata"/> 
				<p style="padding-top:8px;" id="fileInfo">仅允许上传jpg,jpeg,png,gif格式图片</p>
				<span style="display:none;" id="loading_gif"><img src="../Public/js/avatar/loading.gif" align="absmiddle" />上传中，请稍侯......</span>  
				</form>
				</div> 
                <div class="picSettings">
                	<div id="photo" class="left" style="width:330px; height:330px; border-right:1px solid #E5E5E5">
					</div>
                    <div class="left" style="width:200px; padding-left:15px;overflow:hidden">
                    	<div style="width:180px;  margin-bottom:20px; font-size:16px"><strong>头像预览</strong></div>
                        <div class="left" style=" width: 150px; height: 150px; border:1px solid #B4B5AF; overflow:hidden;"><img id="photo_big" src="<?php echo (getUserFace($mid,'b')); ?>" /></div>
						
                    </div>
					<form enctype="multipart/form-data" class="form_validator" method="post" name="upform" dotype="ajax" callback="dosaveface" target="_blank" action="<?php echo U('home/Account/avatar',array('t'=>'save'));?>">
				<input type="hidden" name="picurl">
				<input type="hidden" name="x1">
				<input type="hidden" name="y1">
				<input type="hidden" name="x2">
				<input type="hidden" name="y2">
				<input type="hidden" name="w">
				<input type="hidden" name="h">
				<div id="avatar_btn_bar" style="clear:left; padding-top:20px;display:none;"> <input type="submit" class="btn_b" value="保存" />
<input type="button" class="btn_w" value="取消" onclick="unSetFace()" /></div>
				</form>
                    
                </div>
			</div>
          </div>
          <?php echo Addons::hook('home_account_profile_bottom');?>
          <div class="c"></div>
        </div>
      </div>
      </div>
    </div>
  </div>
  <!-- 右侧内容 end  -->
  <div class="c"></div>
</div>
</div>

<script>
	$(document).ready(function(){
		var hs = document.location.hash;
		var up_pic_width =50;
		var up_pic_height =50;

		var type = hs.replace('#','');
		if(type == 'base' || type == '') {
			$('#isLocation').css('display', 'block');
		}
		/*		
		changeModel( hs.replace('#','') );
		$('.setFold').click(function(){
			if( $(this).attr('class')=='setFold' ){
				changeModel( $(this).attr('rel') );
			}else{
				$(this).removeClass('setUnfold');
				$(this).next('.setItemsInfo').hide();
			}
			location.href='#'+$(this).attr('rel');
			if($(this).attr('rel') == 'base') {
				$('#isLocation').css('display', '');
			} else {
				$('#isLocation').css('display', 'none');
			}
		})*/


		$(document).ready(function(){
		var hs = document.location.hash;
		changeModel( hs.replace('#','') );
		$('.setFold').click(function(){
			if( $(this).attr('class')=='setFold' ){
				changeModel( $(this).attr('rel') );
			}else{
				$(this).removeClass('setUnfold');
				$(this).next('.setItemsInfo').hide();
			}
			location.href='#'+$(this).attr('rel');
		})
	});
	
	//切换操作模块
	function changeModel( type ){
		var t = type || 'base';
		$('.setFold').removeClass('setUnfold');
		$('.setItemsInfo').hide();
		var handle = $('div[rel="'+t+'"]');
		handle.addClass('setUnfold');
		handle.next('.setItemsInfo').show();
	}
		
		//监听 form 表单提交
	  	$(".form_validator").bind('submit', function() {
			var callbackfun = $(this).attr('callback');
			var type   = $(this).attr('type');
			var options = {
			    success: function(txt) {
			    	txt = eval("("+txt+")");
					if(callbackfun){
						callback(eval(callbackfun),txt);
					}else{
						  if(txt.boolen){
							  ui.success( txt.message );
						  }else{
							  ui.error( txt.message );
						  }
						  	 
					}
			    }
			};		
	         $(this).ajaxSubmit(options);
			 return false;
	    });
	
	});
	
	function callback(fun,argum){
		fun(argum);
	}
	
	function dosaveface(txt){
		if (txt=='-1') {
			ui.error('更新失败');
		}else {
			alert('更新成功');
	        location.reload();
		}
	}
	
	function douploadpic(){
		$('#loading_gif').show();
		$('input[name="Filedata"]').hide();
		var options = {
			    success: function(txt) {
					uploadpic(txt);
			    }
		};		
		$('#uploadpic').ajaxSubmit(options);
	    return false;		
	}
	var imgrs;
	function uploadpic(txt){
		txt = eval('('+txt+')');
		if(txt.code==1){
			var tmpDate = new Date(); 
			set_UP_W_H(txt.data['picwidth'],txt.data['picheight']);
			var defautlv = ( txt.data['picwidth'] > txt.data['picheight']) ?txt.data['picheight']:txt.data['picwidth'];
	//		$("#photo").attr('src',txt.data['picurl']+'?t='+ tmpDate.getTime());
			$("#photo").html("<img id='photo_img' src="+txt.data['picurl']+'?t='+ tmpDate.getTime()+">");
			$("input[name=picurl]").attr('value',txt.data['picurl']);
		 	$("#photo_big").attr('src',txt.data['picurl']+'?t='+ tmpDate.getTime());
		
		 	imgrs = $('#photo_img').imgAreaSelect({ 
						x1: 0, 
						y1: 0,
					    x2: 100, 
						y2: 100, 
						handles: true,
						onInit:preview,
						onSelectChange:preview,
						onSelectEnd:onSelectEnd,
						aspectRatio: '1:1',
						instance: true,
						parent:$('#photo')
						});
			$('#loading_gif').hide();
			$('#fileInfo').hide();
			$('#avatar_btn_bar').show();
		 }else{
		 	ui.error(txt.message);
		 	$('#loading_gif').hide();
		 	$('#Filedata').show();
		 	$('#fileInfo').show();
		 	document.getElementById("uploadpic").reset()
		 }
	}
	
	//重新上传图片
	function unSetFace(){
		var defaultpic = "<?php echo (getUserFace($mid,b)); ?>"
		$('input[name="Filedata"]').show();
		
		if($("#photo").html()!=''){
	 		imgrs.setOptions({ remove:true });
	 		imgrs.update();
		}
		document.getElementById("uploadpic").reset()
	 	$("#photo").html("");
		$("input[name=picurl]").attr('value','');
	 	$("#photo_big").attr('src',defaultpic);
	 	$('#photo_big').attr('style','');
	 	$('#fileInfo').show();
		$('#avatar_btn_bar').hide();
	}	
	
	function set_UP_W_H(w,h){
		up_pic_width = w;
		up_pic_height = h;
	}	
		
	function onSelectEnd(img,selection){
	    $('input[name=x1]').val(selection.x1);
	    $('input[name=y1]').val(selection.y1);
	    $('input[name=x2]').val(selection.x2);
	    $('input[name=y2]').val(selection.y2); 
	    $('input[name=w]').val(selection.width); 
	    $('input[name=h]').val(selection.height); 
	}
		
	function preview(img, selection) {
		onSelectEnd(img,selection);
		var big_scaleX = 150 / (selection.width || 1);
	    var big_scaleY = 150 / (selection.height || 1);
		
	    $('#photo_big').css({
	        width: Math.round(big_scaleX * up_pic_width) + 'px',
	        height: Math.round(big_scaleY * up_pic_height) + 'px',
	        marginLeft: '-' + Math.round(big_scaleX * selection.x1) + 'px',
	        marginTop: '-' + Math.round(big_scaleY * selection.y1) + 'px'
	    });
	}		
	
	function addprofile(txt){
		var html='';
		if(txt.boolen=="1"){
			txt = txt.data;
			if (txt.addtype == 'education') {
				html= '<li id="pro_'+txt.id+'"><div class="projectlist">' 
					+ '<h3><a href="javascript:profile_del('+txt.id+');" class="right"><span class="del"> &nbsp;</span></a>' 
					+ '[教育]'+ txt.school
					+ '</h3><p>'+ txt.year +'入学 - ' +txt.classes+ '</p></div></li>';
			}else if( txt.addtype == 'career' ){
				html= '<li><div id="div_action_702" class="projectlist">' 
					+ '<h3><a href="javascript:profile_del('+txt.id+');" class="right"><span class="del"> &nbsp;</span></a>' 
					+ '[公司/机构]'+ txt.company
					+ '</h3><p>'+ txt.begintime +' 至 '+ txt.endtime + '<BR>'+ txt.position +'</p></div></li>';
			}
			$('#profileList').append( html );
		}else{
			 ui.error( txt.message );
		}
	}
	
	function profile_del(id){
		$.post('<?php echo U("home/account/delprofile");?>',{id:id},function(txt){
			if(txt){
				$("#pro_"+id).remove();
			}else{
				alert( '删除失败' );
			}
		});
	}
	//个人标签部分
	$(document).ready(function(){
		$('#tag_list').find('li').live("mouseover", function(){
			$(this).addClass('bg');
		});
		$('#tag_list').find('li').live("mouseout", function(){
			$(this).removeClass('bg');
		});
		
	})
	
	function addTagById(tagid){
		$.post(U('home/Account/doUserTag'),{type:'addByid',tagid:tagid},function(txt){
			txt = eval("("+txt+")");
			if(txt.code=='1'){
				var url = "<?php echo U('home/User/searchtag'); ?>&k="+encodeURI(txt.data.tag_name);
				var html = '<li><a class="a1" href="'+url+'">'+txt.data.tag_name+'</a><a class="a2" onclick="deleteTag(this)" tagid="'+txt.data.user_tag_id+'" href="javascript:;"><img class="del" src="__THEME__/images/zw_img.gif" /></a></li>'
				$("#tag_list").append(html);
			}else if(txt.code=='2'){
				ui.error('每个人最多添加10个标签');
			}else if(txt.code=='3'){
				ui.error('标签不能为空');
			}else{
				ui.error('添加失败');
			}
		})
	}
	
	function doUserTag(){
		if(tagName==''){
			alert('Tag名不能为空');
			return false;
		}
		/*过滤单个标签首尾的空格开始*/
		var tagName = $("#tag_input").val();
		var arrTag = tagName.split(',');
		var newTag = '';
		for(key in arrTag){
			var newTag = newTag + arrTag[key].replace(/(^\s*)|(\s*$)/g,"") + ',';
		}
		var tagName = newTag.slice(0,-1);
		/*过滤单个标签首尾的空格结束*/
		$.post(U('home/Account/doUserTag'),{type:'addByname',tagname:tagName},function(txt){
			txt = eval("("+txt+")");
			if(txt.code=='1'){
				var html='';
				$.each(txt.data,function(i,n){
					var url = "<?php echo U('home/User/searchtag'); ?>&k="+encodeURI(n.tag_name);
					html+= '<li><a class="a1" href="'+url+'">'+n.tag_name+'</a><a class="a2" onclick="deleteTag(this)" tagid="'+n.user_tag_id+'" href="javascript:;"><img class="del" src="__THEME__/images/zw_img.gif" /></a></li>'
				});
				$('#tag_input').val('');
				$("#tag_list").append(html);
			}else if(txt.code=='2'){
				ui.error('每个人最多添加10个标签');
			}else if(txt.code=='3'){
				ui.error('标签不能为空');
			}else{
				ui.error('添加失败');
			}
			
		})
	}
	
	function deleteTag(o){
		var tagId = $(o).attr('tagid');
		
		$.post(U('home/Account/doUserTag'),{type:'deltag',tagid:tagId},function(txt){
			$(o).parent('li').fadeOut("slow",function(){
				$(this).remove();
 			}); 
		})
	}
	
</script>

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