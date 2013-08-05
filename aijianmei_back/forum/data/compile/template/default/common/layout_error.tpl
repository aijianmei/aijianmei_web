<!doctype html>
<html>
<head>
<meta charset="<?php echo htmlspecialchars(Wekit::V('charset'), ENT_QUOTES, 'UTF-8');?>" />
<title><?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','title'), ENT_QUOTES, 'UTF-8');?> - Powered by phpwind</title>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="generator" content="phpwind v<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','version'), ENT_QUOTES, 'UTF-8');?>" />
<meta name="description" content="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','description'), ENT_QUOTES, 'UTF-8');?>" />
<meta name="keywords" content="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','seo','keywords'), ENT_QUOTES, 'UTF-8');?>" />
<link rel="stylesheet" href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/'.Wekit::C('site', 'theme.site.default').'/css'.Wekit::getGlobal('theme','debug'); ?>/core.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" />
<link rel="stylesheet" href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/'.Wekit::C('site', 'theme.site.default').'/css'.Wekit::getGlobal('theme','debug'); ?>/style.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" />
<!-- <base id="headbase" href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','base'), ENT_QUOTES, 'UTF-8');?>/" /> -->
<?php echo Wekit::C('site', 'css.tag');?>
<script>
//全局变量 Global Variables
var GV = {
	JS_ROOT : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/',										//js目录
	JS_VERSION : '<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>',											//js版本号(不能带空格)
	JS_EXTRES : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','extres'), ENT_QUOTES, 'UTF-8');?>',
	TOKEN : '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>',	//token $.ajaxSetup data
	U_CENTER : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=space'; ?>',		//用户空间(参数 : uid)
<?php 
$loginUser = Wekit::getLoginUser();
if ($loginUser->isExists()) {
?>
	//登录后
	U_NAME : '<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>',										//登录用户名
	U_AVATAR : '<?php echo htmlspecialchars(Pw::getAvatar($loginUser->uid), ENT_QUOTES, 'UTF-8');?>',							//登录用户头像
<?php 
}
?>
	U_AVATAR_DEF : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>/face/face_small.jpg',					//默认小头像
	U_ID : parseInt('<?php echo htmlspecialchars($loginUser->uid, ENT_QUOTES, 'UTF-8');?>'),									//uid
	REGION_CONFIG : '',														//地区数据
	CREDIT_REWARD_JUDGE : '<?php echo $loginUser->showCreditNotice();?>',			//是否积分奖励，空值:false, 1:true
	URL : {
		LOGIN : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=u&c=login'; ?>',										//登录地址
		QUICK_LOGIN : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=u&c=login&a=fast'; ?>',								//快速登录
		IMAGE_RES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>',										//图片目录
		CHECK_IMG : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=u&c=login&a=showverify'; ?>',							//验证码图片url，global.js引用
		VARIFY : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=verify&a=get'; ?>',									//验证码html
		VARIFY_CHECK : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=verify&a=check'; ?>',							//验证码html
		HEAD_MSG : {
			LIST : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=message&c=notice&a=minilist'; ?>'							//头部消息_列表
		},
		USER_CARD : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=space&c=card'; ?>',								//小名片(参数 : uid)
		LIKE_FORWARDING : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=post&a=doreply'; ?>',							//喜欢转发(参数 : fid)
		REGION : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=misc&c=webData&a=area'; ?>',									//地区数据
		SCHOOL : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=misc&c=webData&a=school'; ?>',								//学校数据
		EMOTIONS : "<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=emotion&type=bbs'; ?>",					//表情数据
		CRON_AJAX : '<?php echo htmlspecialchars($runCron, ENT_QUOTES, 'UTF-8');?>',											//计划任务 后端输出执行
		FORUM_LIST : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=forum&a=list'; ?>',								//版块列表数据
		CREDIT_REWARD_DATA : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=u&a=showcredit'; ?>',					//积分奖励 数据
		AT_URL: '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=remind'; ?>',									//@好友列表接口
		TOPIC_TYPIC: '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=forum&a=topictype'; ?>'							//主题分类
	}
};
</script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/wind.js?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<?php
PwHook::display(array(PwSimpleHook::getInstance("head"), "runDo"), array(), "", $__viewer);
?>
<link href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/'.Wekit::C('site', 'theme.site.default').'/css'.Wekit::getGlobal('theme','debug'); ?>/register.css?v=<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
</head>
<body>
<div class="wrap">
<?php if ($site_info_notice = Wekit::C('site','info.notice')) {?>
<style>.header_wrap{top:108px;}body{padding-top:154px;}</style><div id="notice"><?php echo htmlspecialchars($site_info_notice, ENT_QUOTES, 'UTF-8');?></div>
<?php }?>
<header class="header_wrap" style="background: #f4f4f4;box-shadow: 0 1px 4px rgba(0,0,0,0);">

<style>
/*outside head_top*/

.aihead{height: 79px;}
.aiheader{position: fixed;left: 0;top:0;z-index: 1001;height: 79px;width: 100%;background: url(../Templates/images/dh_01.jpg) repeat-x;}
.aiheader .h_bg{margin: 0 auto;width: 960px;height: 72px;text-align: center;line-height: 72px;}
.aiheader .logo_1{float: left;width: 265px;text-indent: -999em;background: url(../Templates/images/wm3.png) 0 -651px no-repeat;}
.aiheader .logo{width:230px;margin: 30px 0 0 20px;float:left;}
.aiheader .logo a{display:block;}
/******** Navigation ************/
.aiheader .ainav{float: left;width: 695px;}
.aiheader .ainav .ainav_child{position: relative;float: left;height: 72px;margin:0 -4px;}
.aiheader .home,.store{display: inline-block;padding-left: 34px;margin-top: 18px;height: 54px;line-height: 37px;}
.aiheader .home{background:url(../Templates/images/sprite.png) -303px -156px no-repeat;}
.aiheader .store{background:url(../Templates/images/sprite.png) -252px -74px no-repeat;}
.aiheader .ainav .ainav_a{font-family: Microsoft YaHei;display: block;padding: 0 11px;color: white;font-size: 24px;word-break:keep-all;line-height: 72px;/*solue with ie6*/}
.aiheader .ainav_current .ainav_a{background: url(../Templates/images/dh_02.jpg) repeat-x;}
.ainav .ainav_child:hover .ainav_a{background: url(../Templates/images/dh_02.jpg) repeat-x;}
/*menu down nav------*/
.aiheader .mn_drop{position: absolute;visibility: hidden;width: 145px;background: #e9e9e9;opacity: 0;z-index: 1000;/*-webkit-transition:opacity .8s;transition:opacity .8s;*/}
.aiheader .ainav .ainav_child:hover .mn_drop{opacity: 1;}
.aiheader .mn_drop li{margin-bottom: 1px;line-height: 14px;background: #fff;}.aiheader .mn_drop .mn_first{margin-top: 0;}
.aiheader .mn_drop a{display: inline-block;width: 100%;margin-top: 1px;padding: 7px 0;background: #f7f7f7;color: #21ace3;}
.aiheader .mn_drop a:hover{background: #fff;}
/*website top ending*************************/
</style>	
	<?php  $_TopMenuInfo=unserialize(include_once(".././PublicCache/TopMenuCache.php")); ?>
		<div class="aihead">
		    <div class="aiheader">
		        <div class="h_bg">
		            <a href="/index.php?app=index"><div class="logo_1">logo</div></a>
		            <ul class="ainav">
					<?php 
						foreach ($_TopMenuInfo as $k => $v) {
						?>
		                <li class="ainav_child <?php  if($v['selected_flag']=='forum'){?>ainav_current<?php  } ?>">
		                	<a class="ainav_a <?php  if($v['selected_flag']=='forum'||$v['selected_flag']=='friends'){echo $v['selected_flag'];}?>" href="<?php echo htmlspecialchars($v[link], ENT_QUOTES, 'UTF-8');?>"><?php  if($v['selected_flag']=='index'){?>
		                	<span class="home"><?php }
  if($v['selected_flag']=='shop'){?><span class="store"><?php  }
 echo htmlspecialchars($v[menu_name], ENT_QUOTES, 'UTF-8');
  if($v['selected_flag']=='index'||$v['selected_flag']=='shop'){?></span><?php  }?></a>
							<ul class="mn_drop">
							<?php  foreach($v['child'] as $k=>$v){ ?>
								<li><a href="<?php echo htmlspecialchars($v['link'], ENT_QUOTES, 'UTF-8');?>" <?php  if($k==0){ ?>class="mn_first" <?php  } ?>><?php echo htmlspecialchars($v['menu_name'], ENT_QUOTES, 'UTF-8');?></a></li>
						<?php  }?>
						</ul>
						</li>
					<?php  }?>
		            </ul>
		        </div>
		    </div>
   		</div>
        <div style="text-align:center; margin-top:8px; margin-bottom:8px;"><img src="../Templates/images/forum_banner.jpg"/></div>
<script>
//获取dom元素
var getdom = function(){
	this.Id = function(id){
		return document.getElementById(id);
	}

	this.getElementsByClass = function(searchClass,node,tag) {
        var classElements = new Array();
        if ( node == null )
                node = document;
        if ( tag == null )
                tag = '*';
        var els = node.getElementsByTagName(tag);
        var elsLen = els.length;
        var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
        for (i = 0, j = 0; i < elsLen; i++) {
                if ( pattern.test(els[i].className) ) {
                        classElements[j] = els[i];
                        j++;
                }
        }
        return classElements;
    }
    this.GetCurrentStyle = function(obj, prop){
	    if (obj.currentStyle){ //IE
	        return obj.currentStyle[prop];
	    }
	    else if (window.getComputedStyle){ //非IE
	        propprop = prop.replace (/([A-Z])/g, "-$1");
	        propprop = prop.toLowerCase ();
	        return document.defaultView.getComputedStyle(obj,null)[propprop];
	    }
	    return null;
	}
}
var aijianmei = {
    newdom : new getdom,
    getobj : function(obj,T){
		return T ? aijianmei.newdom.getElementsByClass(obj) : aijianmei.newdom.getElementsByClass(obj)[0];
	},
	get_css : function(obj,opinions){
		var arr = [],
			len = opinions.length;
		for(var i = 0;i < len;i++){
			arr[i] = aijianmei.newdom.GetCurrentStyle(obj,opinions[i]);
		}
		return arr;
	},
	identifying : function(obj){
		var len = obj.children.length,
			num = Math.round(Math.random()*2 + 2);
			// alert(num)
		for(var i = 0;i < len;i++){
			if(i%num == 0){
				obj.children[i].firstChild.style.background = '#0664B0';
			}
			else if(i%(num + 1) == 0){
				obj.children[i].firstChild.style.background = '#CA5254';
			}
			else if(i%(num - 1) == 0){
				obj.children[i].firstChild.style.background = '#2F9944';
			}
			else{
				obj.children[i].firstChild.style.background = '#F53300';
			}
		}
    },
    tab_change : function(obj_1,class_1,obj_2,class_2){//obj_1 contain tab of child
    	var tab_obj = aijianmei.getobj(obj_1),
    		tab_content = aijianmei.getobj(obj_2,1),
    		obj_child = tab_obj.children,
    		child_len = obj_child.length;
    	for(var i = 0;i < child_len;i++){
    		obj_child[i].index = i;
    		obj_child[i].onclick = function(){
    			for(var i = 0;i < child_len;i++){
	    			if(this.index == i){
	    				obj_child[i].className = class_1;
	    				tab_content[i].className = obj_2 + " " + class_2;
					ajaxListKey=i;
					is_ajax_scroll=true;
	    			}
	    			else{
	    				obj_child[i].className = '';
	    				tab_content[i].className = obj_2;
	    			}
	    		}
    		}
    	}
    },
    hover : function(obj_1,obj_2){
    	var obj = aijianmei.getobj(obj_1,1),
    		show_obj = aijianmei.getobj(obj_2,1),
    		obj_len = obj.length;
    	// var show = function(i){
    		
    	// }
    	// var hidden = function(i){
    		
    	// }
    	for(var i = 0;i < obj_len;i++){
    		obj[i].index = i;
    		if(obj[i]){
    			obj[i].onmouseover = function(){
    				show_obj[this.index].style.display = "block";
    			}
    			obj[i].onmouseout = function(){
    				show_obj[this.index].style.display = "none";
    			}
	    		// addevent(obj[i],'mouseover',show);
	    		// addevent(obj[i],'mouseout',hidden)
	    	}
    	} 	
    },
    // opacity make obj transparency you want.filter is transparency.
    opacity : function(obj,filter,speed){
		var newdom = new getdom,
			obj = newdom.getElementsByClass(obj)[0] || obj,
			ob_opacity = newdom.GetCurrentStyle(obj,'opacity') ? newdom.GetCurrentStyle(obj,'opacity') : 1,
			obj_opacity = [ob_opacity[0],ob_opacity[1], ob_opacity[2]].join(""),
			obj_filter = newdom.GetCurrentStyle(obj,'filter'),//获取filter的值，表现形式为alpha(opacity=10);
			value = obj_filter.replace(/[^0-9]/ig,"");//使用正则表达式转换为数字字符串（80）
		obj.style.opacity = obj_opacity;
		var change_opacity = function(){
			if(document.all){
				if(value/100 > filter){
					var time = function(){
						setTimeout(function(){
							if(value/100 > filter){
								value = parseFloat(value) - 10;
								obj.style.filter = 'alpha(opacity = '+value+')';

								time();
							}
						},speed);
					}
					time();
				}
				else{
					var time = function(){
						setTimeout(function(){
							if(filter > value/100){
								value = parseFloat(value) + 10;//将字符串转化为数字，使用的是parsefloat
								obj.style.filter = 'alpha(opacity = '+value+')';
								time();
							}
						},speed)
					};
					time();
				}
			}
			else{
				if(obj_opacity > filter){
					var time = function(){
						setTimeout(function(){
							if(obj_opacity > filter){
								obj_opacity = (obj_opacity * 10 - 1)/10;
								obj.style.opacity = (parseFloat(obj.style.opacity) * 10 - 1)/10;
								time();
							}
						},speed)
					};
					time();
				}
				else{
					var time = function(){
						setTimeout(function(){
							if(filter > obj_opacity){
								filter = (filter * 10 - 1)/10;
								obj.style.opacity = (parseFloat(obj.style.opacity) * 10 + 1)/10;
								time();
							}
						},speed)
					};
					time();
				}
			}
		}
		change_opacity();
	},
	addtitle : function(obj){
		var Obj = aijianmei.getobj(obj,1),
			len = Obj.length,
			handlewidth = 55,
			title = aijianmei.getobj('title_tip'),
			title_content = aijianmei.getobj('title_content');
		var handle = function(e){
			var _e = window.event ? window.event : e || arguments[0],
    			_target = _e.target ? _e.target : _e.srcElement,
    			text = _target.getAttribute('data-original-title');
			if(window.ActiveXObject){
				_target.setAttribute('title',text)
			}
			else{
				//确定提示内容的宽度，适当调整
				var handlewidth = function(){
					if(text.length < 5){
						title.style.width = '80px';
						handlewidth = 35;
					}
					else if(text.length <11){
						title.style.width = '150px';
						handlewidth = 35;
					}
					else if(text.length < 14){
						title.style.width = '160px';
						handlewidth = 55;
					}
					else{
						title.style.width = '200px';
						handlewidth = 55;
					}
					if(text.length > 26){
						handlewidth = 70;
					}
				}
				handlewidth();
				//获取data-original-title的内容
				var datatitle = function(){
					var div = document.createElement('div');
						textnode = document.createTextNode(text);
					div.appendChild(textnode);
					title_content.appendChild(div);
				}
				datatitle()
				//确定obj的位置，并是提示对齐被提示内容
				var textalign = function(){
					var left = _target.offsetLeft,
						top = _target.offsetTop,
						width = _target.offsetWidth,
						titlewidth = title.style.width,
						align = left + width/2,
						half = parseFloat(titlewidth)/2;
						title.style.left = align - half + 'px';
						title.style.top = top - handlewidth + 'px';
				} 
				textalign();
				title.style.display = 'block';
			}
		}
		var remove = function(){
			title_content.removeChild(title_content.firstChild);
			title.style.display = 'none';
		}
		for(var i = 0;i < len;i++){
			if(Obj[i] && window.XMLHttpRequest){
				addevent(Obj[i],"mouseover",handle);
				if(!document.all){
					addevent(Obj[i],"mouseout",remove);
				}	
			}	
		}	
	},
	// chang_top if you want to make the top of obj go up or down slowly.T choice to up or down,length choice distance you want
	chang_top : function(obj,T,length,speed){  
        var i = 0;
        obj.style.top = aijianmei.newdom.GetCurrentStyle(obj,'top');
        var move = setInterval(function(){
    		if(i < length){
                i = i + 10;
        		if(T){	
        			obj.style.top = parseFloat(obj.style.top) - 10 + 'px';
        		}
                else{
                    obj.style.top = parseFloat(obj.style.top) + 10 + 'px';
                }
            }
            else{
            	clearInterval(move)
            }
    	},speed)  	    
    },
    chang_bottom : function(obj,T,length,speed){  
        var i = 0;
        obj.style.bottom = aijianmei.newdom.GetCurrentStyle(obj,'bottom');
        var move = setInterval(function(){
    		if(i < length){
                i = i + 10;
        		if(T){	
        			obj.style.bottom = parseFloat(obj.style.bottom) - 10 + 'px';
        		}
                else{
                    obj.style.bottom = parseFloat(obj.style.bottom) + 10 + 'px';
                }
            }
            else{
            	clearInterval(move)
            }
    	},speed)  	    
    },
    get : function(obj){
		if(obj.children[1]){
			if(obj.children[1].className == "mn_drop"){
				obj.children[1].style.visibility = 'visible';
			}
		}
	},
	out : function(obj){
		if(obj.children[1]){
			if(obj.children[1].className == "mn_drop"){
				obj.children[1].style.visibility = 'hidden';
			}
		}
	},
	acTion : function(){
		var login_Bg = aijianmei.getobj('login_bg'),
			login_table= aijianmei.getobj('login_table');
		login_Bg.style.display = 'block';
		login_table.style.display = 'block';
		aijianmei.opacity('login_bg',0.5,10);
		aijianmei.chang_top(login_table,0,294,10);
		// for input
		var lg_text = aijianmei.newdom.Id('lg_text'),
			lg_password_id = aijianmei.newdom.Id('lg_password'),
			lg_password_class = aijianmei.getobj('lg_password');
		if(lg_text){
			lg_text.focus()
		}
		if(lg_password_id.value != ''){
			lg_password_class.style.display = 'none';
		}
		// for input end
	},
	removeacTion : function(){
		var login_Bg = aijianmei.getobj('login_bg'),
			login_table= aijianmei.getobj('login_table');
		login_table.style.top = "-222px";
		login_Bg.style.opacity = 0;
		login_Bg.style.filter = 'alpha(opacity=0)'
		// aijianmei.opacity('login_bg',0,10);
		// aijianmei.chang_top(login_table,1,294,10);
		login_Bg.style.display = 'none';
		login_table.style.display = 'none';
		// if(login_Bg.style.opacity == 0){
		// 	login_Bg.style.visibility = 'hidden';
		// 	login_table.style.visibility = 'hidden';
		// }		
	},
	// scrolltop : when you roll your mouse,if its height is equal to height,obj appear,if you click one of arr,obj disappear 
	scrolltop : function(obj,height,arr){
		var obj = aijianmei.getobj(obj),
			arr_len = arr.length,
			T = 1;
		// obj.style.bottom = aijianmei.newdom.GetCurrentStyle(obj,'bottom');
		if(T){
			window.onscroll = function(){
				var scrollTop = document.body.scrollTop || document.pageYOffse || document.documentElement.scrollTop;
				if(scrollTop >= height && T == 1){
					T = 0;
					obj.style.display = 'block';
					aijianmei.chang_bottom(obj,0,70,10);
				}
			}	
		}
		for(var i = 0;i < arr_len;i++){
			var arr_obj = [];
			arr_obj[i] = aijianmei.getobj(arr[i]);
			if(arr_obj[i]){
				arr_obj[i].onclick = function(){
					obj.style.display = "none";
					T = 0;
				}
			}
		}		
	},
	form_jugde : function(jugde_1,jugde_2,jugde_3){
		var id_jd = [],
			jd = [],
			argument_len = arguments.length;
		for(var i = 0;i < argument_len;i++){
			id_jd[i] = aijianmei.newdom.Id(arguments[i]);
			jd[i] = aijianmei.getobj(arguments[i]);
		}
		jd_len = id_jd.length;
		for(var i = 0;i < jd_len;i++){
			if(id_jd[i]){
				id_jd[i].index = i;
				id_jd[i].onfocus = function(){
					jd[this.index].style.display = 'none';
				}
				id_jd[i].onblur = function(){
					if(id_jd[this.index].value == ""){
						jd[this.index].style.display = 'block';
					}
				}
			}		
		}
	}
}
var init = function(){
    var newdom = new getdom,
    	nav_child = newdom.getElementsByClass('ainav_child'),
    	len_1 = nav_child.length,
    	login = newdom.getElementsByClass('login'),
    	len_login = login.length,
    	lg_back = newdom.getElementsByClass('lg_back')[0];
    // for login beginning	
    for(var i = 0;i < len_login;i++){
    	if(login[i]){
    		addevent(login[i],'click',aijianmei.acTion);
    	}
    }
    if(lg_back){
    	addevent(lg_back,'click',aijianmei.removeacTion);
    } 
    //for login ending

	for(var i = 0;i < len_1;i++){
		if(nav_child[i]){
			nav_child[i].onmouseover = function(){
				aijianmei.get(this);		
			}
			nav_child[i].onmouseout = function(){
				aijianmei.out(this);
			}
		}		
	};
    aijianmei.hover('more','account');
}
init();			
</script>	
	
	<div id="J_header" class="header cc" style="background: #488fce;">
		<div class="logo">
			<a href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/',''; ?>">
				<?php  if($__css = Wekit::C('site', 'css.logo')) { ?>
				<!--后台logo上传-->
				<img src="<?php echo htmlspecialchars(Pw::getPath($__css), ENT_QUOTES, 'UTF-8');?>" alt="<?php echo htmlspecialchars(Wekit::C('site','info.name'), ENT_QUOTES, 'UTF-8');?>">
				<?php  } else { ?>
				<img style="height:45px;" src="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/'.Wekit::C('site', 'theme.site.default').'/images'; ?>/logo.png" alt="<?php echo htmlspecialchars(Wekit::C('site','info.name'), ENT_QUOTES, 'UTF-8');?>">
				<?php  } ?>
			</a>
		</div>
		<nav class="nav_wrap">
			<div class="nav">
				<ul>
	<?php  $nav = Wekit::load('SRV:nav.bo.PwNavBo');
		  $nav->setRouter();
		  $currentId =  '';
		   $main = $child = array();
		  if ($nav->isForum()) $nav->setForum($pwforum->foruminfo['parentid'], $fid, $tid);
		  $main = $nav->getNavFromConfig('main', true);
		  foreach($main as $key=>$value){
			if ($value['current']) {
				$current = 'current';
				$currentId = $key;
			} else {
				$current = '';
			}
			$value['child'] && $child[$key] = $value['child'];
		  ?>
					<li class="<?php echo htmlspecialchars($current, ENT_QUOTES, 'UTF-8');?>"><?php echo $value['name'];?></li>
	<?php  } ?>
				</ul>
			</div>
		</nav>
		<?php
PwHook::display(array(PwSimpleHook::getInstance("header_nav"), "runDo"), array(), "", $__viewer);
?>
		<div class="header_search" role="search">
			<form action="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=search&c=s'; ?>" method="post">
				<input type="text" id="s" aria-label="搜索关键词" accesskey="s" placeholder="搜索其实很简单" x-webkit-speech speech name="keyword"/>
				<button type="submit" aria-label="搜索"><span>搜索</span></button>
			<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>
		</div>
		<?php  if (!$loginUser->isExists()) { ?>
<div class="header_login" style="margin-right:10px;">
	<?php
PwHook::display(array(PwSimpleHook::getInstance("header_info_3"), "runDo"), array(), "", $__viewer);
?><a rel="nofollow" href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=u&c=login'; ?>">登录</a><a rel="nofollow" href="<?php echo AIPWURL;?>/index.php?app=index&mod=Index&act=selectRegister">注册</a>
</div>
<?php  } else {
	if ($pwforum && $pwforum->isForum()) {
		$_tmpfid = $pwforum->fid;
		$_tmpcid = $pwforum->getCateId();
	} else {
		$_tmpfid = 0;
		$_tmpcid = $pwforum ? $pwforum->getCateId() : '0';
	}
?>
	<a class="header_login_btn" id="J_head_forum_post" role="button" aria-label="快速发帖" aria-haspopup="J_head_forum_pop" href="#" title="快速发帖" tabindex="-1"><span class="inside"><span class="header_post" >发帖</span></span></a>
	<div id="J_head_forum_pop" tabindex="0" class="pop_select_forum" style="display:none;" aria-label="快速发帖菜单,按ESC键关闭菜单">
		<a id="J_head_forum_close" href="#" class="pop_close" role="button">关闭窗口</a>
		<div class="core_arrow_top" style="left:310px;"><em></em><span></span></div>
		<div class="hd">发帖到其他版块</div>
		<div id="J_head_forum_ct" class="ct cc" data-fid="<?php echo htmlspecialchars($_tmpfid, ENT_QUOTES, 'UTF-8');?>" data-cid="<?php echo htmlspecialchars($_tmpcid, ENT_QUOTES, 'UTF-8');?>">
			<div class="pop_loading"></div>
		</div>
		<div class="ft">
			<div class="associate">
				<label class="fr"><input type="checkbox" id="J_head_forum_join" data-url="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=forum&a=join'; ?>">添加到我的版块</label>
				发帖到：<span id="J_post_to_forum"></span>
			</div>
			<div class="tac">
				<button type="button" class="btn btn_submit disabled" disabled="disabled" id="J_head_forum_sub" data-url="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?c=post'; ?>">确定</button>
			</div>
		</div>
	</div>
	<?php 
		$messageCount = $loginUser->info['notices'] + $loginUser->info['messages'];
		$messageClass = $messageCount ? 'header_message' : 'header_message header_message_none';
	?>
	<a class="header_login_btn" id="J_head_msg_btn" tabindex="0" href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=message&c=message'; ?>" aria-haspopup="J_head_msg_pop" aria-label="消息菜单,按pagedown打开菜单,tab键导航,esc键关闭"><span class="inside"><span class="<?php echo htmlspecialchars($messageClass, ENT_QUOTES, 'UTF-8');?>">消息<em class="core_num J_hm_num"><?php echo htmlspecialchars($messageCount, ENT_QUOTES, 'UTF-8');?></em></span></span></a>
	<!--消息下拉菜单-->
	<div id="J_head_msg_pop" tabindex="0" aria-label="消息下拉菜单,按ESC键关闭菜单" class="header_menu_wrap my_message_menu" style="display:none;">
		<div class="header_menu cc">
			<div class="header_menu_hd" id="J_head_pl_hm"><span class="<?php echo htmlspecialchars($messageClass, ENT_QUOTES, 'UTF-8');?> header_message_down">消息<em class="core_num J_hm_num"><?php echo htmlspecialchars($messageCount, ENT_QUOTES, 'UTF-8');?></em></span></div>
			<div id="J_head_msg" class="my_message_content"><div class="pop_loading"></div></div>
		</div>
	</div>
	<div class="header_login_later">
		<?php
PwHook::display(array(PwSimpleHook::getInstance("header_info_1"), "runDo"), array(), "", $__viewer);
?>
		<a aria-haspopup="J_head_user_menu" aria-label="个人功能菜单,按pagedown打开菜单,tab键导航,esc键关闭" tabindex="0" rel="nofollow" href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=space&uid=', rawurlencode($loginUser->uid); ?>" id="J_head_user_a" class="username" title="<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>"><?php echo htmlspecialchars(Pw::substrs($loginUser->username,6), ENT_QUOTES, 'UTF-8');?><em class="core_arrow"></em></a>
		<?php
PwHook::display(array(PwSimpleHook::getInstance("header_info_2"), "runDo"), array(), "", $__viewer);
?>
		<div class="fl">
		<div id="J_head_user_menu" role="menu" class="header_menu_wrap my_menu_wrap" style="display:none;">
			<div class="header_menu my_menu cc">
				<div class="header_menu_hd" id="J_head_pl_user"><span title="<?php echo htmlspecialchars($loginUser->username, ENT_QUOTES, 'UTF-8');?>" class="username"><?php echo htmlspecialchars(Pw::substrs($loginUser->username,6), ENT_QUOTES, 'UTF-8');?></span><em class="core_arrow_up"></em></div>
				<ul class="ct cc">
				<?php  $nav = Wekit::load('SRV:nav.bo.PwNavBo');
					$myNav = $nav->getNavFromConfig('my');
					foreach($myNav as $key=>$value){
				?>
					<li><?php echo $value['name'];?></li>
				<?php  } 
 
				$_url = '';
				$_panelManage = false;
				if ($loginUser->getPermission('panel_bbs_manage')) {
					$_url = 'manage/content/run';
					$_panelManage = true;
				}
				if (!$_panelManage && $loginUser->getPermission('panel_user_manage')) {
					$_url = 'manage/user/run';
					$_panelManage = true;
				}
				if (!$_panelManage && $loginUser->getPermission('panel_report_manage')) {
					$_url = 'manage/report/run';
					$_panelManage = true;
				}
				if (!$_panelManage && $loginUser->getPermission('panel_recycle_manage')) {
					$_url = 'manage/recycle/run';
					$_panelManage = true;
				}
				if ($_panelManage) {
				?>
					<li><a href="<?php echo htmlspecialchars(WindUrlHelper::createUrl($_url), ENT_QUOTES, 'UTF-8');?>" rel="nofollow"><em class="icon_system"></em>前台管理</a></li>
				<?php } if (Pw::getstatus($loginUser->info['status'], PwUser::STATUS_ALLOW_LOGIN_ADMIN) || Pw::inArray(3, $loginUser->groups)) {?>
					<li><a href="<?php echo htmlspecialchars(Wind::getComponent('router')->getRoute('pw')->checkUrl('admin.php'), ENT_QUOTES, 'UTF-8');?>" target="_blank" rel="nofollow"><em class="icon_admin"></em>系统后台</a></li>
				<?php  } ?>
				</ul>
				<ul class="ft cc">
					<li><a href="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=profile'; ?>"><em class="icon_profile"></em>个人设置</a></li>
					<?php
PwHook::display(array(PwSimpleHook::getInstance("header_my"), "runDo"), array(), "", $__viewer);
?>
					<li><a href="<?php echo AIPWURL;?>/index.php?app=home&mod=Public&act=logout" rel="nofollow"><em class="icon_quit"></em>退出</a></li>
				</ul>
			</div>
		</div>
		</div>
	</div>
	<?php  if ($loginUser->info['message_tone'] > 0 && $messageCount > 0) { ?>
	<audio autoplay="autoplay">
		<source src="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/default/images'; ?>/message/msg.wav" type="audio/wav" />
		<source src="<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/default/images'; ?>/message/msg.mp3" type="audio/mp3" />
		<div style='overflow:hidden;width:0;float:left'><embed src='<?php echo Wind::getComponent('response')->getData('G', 'url', 'themes').'/site/default/images'; ?>/message/msg.wav' width='0' height='0' AutoStart='true' type='application/x-mplayer2'></embed></div>
	</audio>
	<?php  } 
  } ?>
	</div>
</header>
<div style="clear:both;padding-bottom: 200px;"></div>
<?php 
if ($child) {
foreach ($child as $ck => $cv) {
	 if ($currentId == $ck){
?>
	<div class="nav_weak" id="<?php echo htmlspecialchars($ck, ENT_QUOTES, 'UTF-8');?>">
<?php  }else{ ?>
	<div class="nav_weak" id="<?php echo htmlspecialchars($ck, ENT_QUOTES, 'UTF-8');?>" style="display:none">
<?php  } ?>
		<ul class="cc">
			<?php  foreach($cv as $_v){
				$current = $_v['current'] ? 'current' : '';
			?>
			<li class="<?php echo htmlspecialchars($current, ENT_QUOTES, 'UTF-8');?>"><?php echo $_v['name'];?></li>
			<?php  } ?>
		</ul>
	</div>
<?php }} ?>
<div class="tac"> </div>
	<div class="main_wrap">
		<div class="box_wrap register cc">
		<?php $this->content();?>
		</div>
	</div>
<!--.main-wrap,#main End-->
<div class="tac">
 <br />
 
</div>
<div class="footer_wrap">
	<div class="footer">
		<pw-drag id="footer_segment"/>

		<p><span>广州加伦信息科技有限公司- 粤ICP备12085654号</span></p>
		<p><a href="http://www.aijianmei.com">www.aijianmei.com</a></p>
	</div>
	 
	 
	 
	<div id="cloudwind_common_bottom"></div>
	<?php
PwHook::display(array(PwSimpleHook::getInstance("footer"), "runDo"), array(), "", $__viewer);
?>
</div>

<!--返回顶部-->
<a href="#" rel="nofollow" role="button" id="back_top" tabindex="-1">返回顶部</a>

<script>
Wind.use('jquery', 'global');
</script>
</div>
</body>
</html>