function renren_login() {
	XN.Connect.requireSession(function(){
		XN.Main.get_sessionState().waitUntilReady(function(){
			window.location.href="/api/rr_login";					
	   });		    
	});
}

function bhget(id) {
  return document.getElementById(id);
}

function show_indicator(text) {
	var info = $('#ajax-indicator');
    if (info.length==0) {
       info = $("<div id=\"ajax-indicator\" style=\"display:none;\"><span>正在加载…</span></div>").appendTo("body");
    }
	info.html(text);
	var t = (document.documentElement.clientHeight) / 2 + document.documentElement.scrollTop - 15;
	info.css({'top': t}).show();
}

function hide_indicator() {
  $('#ajax-indicator').hide();
}

function trim(s){
    if (s == null) {
        return null;
    }
    return s.replace(/(^[\s]*)|([\s]*$)/g, "");
}

function formatNumber(num, precision){
    var pow = Math.pow(10, precision);
    var v = Math.round(num * pow) / pow;
    return v;
}

function is_empty(s){
    var str = trim(s);
    return str == null || str == "";
}

function click_tag(input_id, tag_name){
	var the_input = bhget(input_id);
    var v = the_input.value;
    if (v != '') {
        the_input.value = v + " " + tag_name;
    }
    else {
        the_input.value = tag_name;
    }
    the_input.focus();
}

function change_radio(player_id, url){
    var player = bhget(player_id);
    if (player) {
        player.url = url;
        player.src = url;
        player.controls.play();
    } else {
        alert("请用IE浏览器，并安装Windows Media Player，才能收听");
    }
}

function change_div(prev_div, next_div){
    prev = $('#'+prev_div);
    next = $('#'+next_div);
    if (prev) {
        prev.hide();
    }
    if (next) {
        next.show();
    }
}

function mouseover_effect(button){
    button.style.backgroundPositionY = 'bottom';
    button.style.left = 1 + 'px';
    button.style.top = 1 + 'px';
}

function mouseout_effect(button){
    button.style.backgroundPositionY = 'top';
    button.style.left = 0 + 'px';
    button.style.top = 0 + 'px';
}

function get_cookie(cn) {
	var strCookie=document.cookie;
	var arrCookie=strCookie.split("; ");
	var ret = "";
	for(var i=0;i<arrCookie.length;i++){
		var arr=arrCookie[i].split("=");
		if(cn==arr[0]){
			ret = arr[1];
			break;
		}
	}
	return ret; 	
}

function set_cookie(cn,v,options) {
	 var expires = '';
	 var path = options.path ? '; path=' + (options.path) : '';
     var domain = options.domain ? '; domain=' + (options.domain) : '';
     var secure = options.secure ? '; secure' : '';
	 if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
	 	 var date;
         if (typeof options.expires == 'number') {
            date = new Date();
            date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
         } else {
            date = options.expires;
         }
         expires = '; expires=' + date.toUTCString();
	 }
     document.cookie = [cn, '=', encodeURIComponent(v), expires, path, domain, secure].join('');
}

function addToFavorite(sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，有劳您手动添加。");
        }
    }
}

function copyToClipboard(txt) 
{
	var content = txt;
	if(window.clipboardData) {
	      window.clipboardData.clearData();
	      if (window.clipboardData.setData("Text", content)) {
		  	alert("成功复制到剪切板！");
		  } else {
		  	alert("复制失败请查看您的浏览器");
		  }
	} else if(navigator.userAgent.indexOf("Opera") != -1) {
	   window.location = content;
	   alert("成功复制到剪切板！");
	} else if (window.netscape)	{
	   try 
	   {
	        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
	   } 
	   catch (e) 
	   {
	        alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
	        return;
	   }
	   var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
	   if (!clip)
	        return;
	   var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
	   if (!trans)
	        return;
	   trans.addDataFlavor('text/unicode');
	   var str = new Object();
	   var len = new Object();
	   var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
	   var copytext = content;
	   str.data = copytext;
	   trans.setTransferData("text/unicode",str,copytext.length*2);
	   var clipid = Components.interfaces.nsIClipboard;
	   if (!clip)
	        return;
	   clip.setData(trans,null,clipid.kGlobalClipboard);
	   alert("成功复制到剪切板！");
	} else {
	   alert("暂时无法支持您所用的浏览器");
	}
}

function selectText(oDiv){
	try {
	  var rng = document.body.createTextRange();
	  rng.moveToElementText(oDiv);
	  rng.select();		
	} catch(Error) {
	  //do nothing
	}
}

function switch_div(div_name){
    var div = bhget(div_name);
    if (div) {
        if (div.style.display == "block" || div.style.display == "" || div.style.display == null) {
            div.style.display = "none";
			return false;
        }
        else {
            div.style.display = "block";
			return true;
        }
    }
	return false;
}

function showMainMenu(i, j){
    var menu = $("#mainmenu_" + i);
    var nav = $("#mainnav_" + j);
    menu.show();
    nav.css({"backgroundPosition":"center","color":"#CC3388"});
}
function closeMainMenu(i, j){
    var menu = $("#mainmenu_" + i);
    var nav = $("#mainnav_" + j);
    menu.hide();
	if (nav.attr("className") == "current") {
		nav.css({"backgroundPosition":"bottom","color":"#339944"});
	} else {
		nav.css({"backgroundPosition":"top","color":"#CC3388"});
	}
}

var agt = navigator.userAgent.toLowerCase();
var isop = (agt.indexOf("opera") != -1);
var isie = (agt.indexOf("msie") != -1) && document.all && !isop;
var isie5 = isie && (agt.indexOf("msie 5") != -1);
var isie6 = isie && (agt.indexOf("msie 6") != -1);
var isie7 = isie && (agt.indexOf("msie 7") != -1);
var isie8 = isie && (agt.indexOf("msie 8") != -1);
var isff = agt.indexOf("firefox") != -1;

function noticeMergeOptions(default_options,options) {
	if (options) {
		if (options.timeout) default_options.timeout = options.timeout;
		if (options.title) default_options.title = options.title;
		if (options.body_text) default_options.body_text = options.body_text;
	}
}

function showNotice(notice_text, options){
	var default_options = {className:"pop-notice",title:"提示信息",timeout:5,body_text:null};
	noticeMergeOptions(default_options,options);
	doShowInfo(notice_text, default_options);
}
function showWarning(notice_text, options) {
	var default_options = {className:"pop-warning",title:"提醒信息",timeout:6,body_text:null};
	noticeMergeOptions(default_options,options);
	doShowInfo(notice_text, default_options);
}
function showError(notice_text, options) {
	var default_options = {className:"pop-error",title:"提示信息",timeout:15,body_text:null,show_error:true};
	noticeMergeOptions(default_options,options);
	doShowInfo(notice_text, default_options);
}
function showMessage(title,message_text, options) {
	var id = (new Date()).getTime();
	var html = "<div id='info_"+id+"' class='jqmWindow jqmWindowInfo jq-msg'><div class='jq-title'><span class='jq-title-name'>"+title+"</span><a href='#' class='jqmClose jq-title-close'></a></div>" + 
	           "<div class='text-wrap'>";
	html += "<div class='text'>"+message_text+"</div>";
	html += "<div class='timer' id='infot_"+id+"'></div></div>"
	html += "</div>";
	var info = $(document.body).append(html);
	$("#info_"+id).jqm({
		overlay: 0,
		modal: false
	});
	$("#info_"+id).jqmShow();	
	
	if (options && options.timeout>0) {
	   $("#info_"+id).attr("timeout",options.timeout || 4);
	   noticeTimeout(id);
	}
}
function showTip(id,tip_text,css,timeout) {
	$("<div id='tip_"+id+"' class='"+css+"'>" +
	              "<div class='head'><div class='head-left'></div><div class='head-right'></div><a class='close jqmClose' href='javascript:void(0)'></a></div>" +
				  "<p>"+tip_text+"</p>"+
			 "</div>").appendTo($(document.body));	
	$("#tip_"+id).jqm({
		overlay: 0,
		modal: false
	});
	$("#tip_"+id).jqmShow();
	
	if (timeout>0) {
	   $("#tip_"+id).attr("timeout",timeout || 4);
	   tipTimeout(id);
	}
}

function sendFeed() {
	XN.Main.apiClient.feed_publishTemplatizedAction(1,{"feed_type":"发布了","topic_link":"http://www.boohee.com/posts/view/116020","topic_title":"只教人生死相许"},{"content":"男孩和女孩是在医院相遇的，同病相怜，很快便成了好朋友。终于有一天，医院告知他们病情已到无法医治的地步。他们各自回家后病情在一天天加重，但他们都没有忘记曾经的一个约定，那就是写信鼓舞对方。"},function(result,ex){})
}

function tipTimeout(id){
	var tip = $("#tip_"+id);
    if (tip[0]) {
        var n = tip.attr('timeout') - 1;
        tip.attr('timeout',n)
        if (n > 0) {          
            setTimeout("tipTimeout('" + id + "')", 1000);
        } else {
            tip.jqmHide();
        }
    }
}

function doShowInfo(notice_text, options){
	var id = (new Date()).getTime();
	var body_text = "";
	if (options.body_text) {
		body_text = options.body_text;
	} else if (options["show_error"] && $('#error_div')[0]) {
        body_text = $('#error_div').html();
    } 
	var body_html = "<h2 class='title'>" + notice_text + "</h2>" + "<div class='text'>"+body_text+"</div><div class='timer' id='infot_"+id+"'></div>";
	inlinePopHolder("info_"+id, options.title, body_html, options.className).appendTo($(document.body));
	$("#info_"+id).jqm({
		overlay: 0,
		modal: false
	});
	$("#info_"+id).jqmShow();
	
	if (options.timeout>0) {
	   $("#info_"+id).attr("timeout",options.timeout || 4);
	   noticeTimeout(id);
	}
}

function noticeTimeout(info_id){
    var info = $("#info_"+info_id);
    if (info[0]) {
        var n = info.attr('timeout') - 1;
        info.attr('timeout',n)
        var timeoutInfo = "#infot_" + info_id;
        if (n > 0) {
            $(timeoutInfo).html("[该提示信息将在&nbsp;<b>" + n + "</b>&nbsp;秒后自动关闭]");
            setTimeout("noticeTimeout('" + info_id + "')", 1000);
        } else {
            info.jqmHide();
        }
    }
}

function input_can(date, options) {
	var can_url = '/can?date='+date;
	if (options && options['from']) {
		can_url += '&from='+options['from'];
	}
	if (options && options['search_type']) {
		can_url += '&search_type='+options['search_type'];
	}
	if ($('#can_dialog').size()==0) {
		ajaxPopHolder('can_dialog', '卡路里计算器', 'can_context', 'pop-can').appendTo($(document.body));
	    $('#can_dialog').jqm({modal:true});		
	}
	$('#can_context').load(can_url,"",function() {
		$('#can_dialog').jqmShow();
	}); 	
}

var fav_dialog = null;
function input_favorite(fav) {
	if (fav_dialog==null) {
		ajaxPopHolder('fav_dialog', '加入我的收藏', 'fav_context', 'pop-fav').appendTo($(document.body));
        fav_dialog = $('#fav_dialog');
		fav_dialog.jqm({modal:true});
	}
	jQuery.get("/favorite/favorite_input",fav,function(data) {
		if (data.indexOf("notice:") == 0) {
			var msg = data.slice(7,100);
			showNotice(msg);
		}
		else if (data.indexOf("warn:") == 0) {
		  	var msg = data.slice(5,100);
			showWarning(msg);
		} else {
			$("#fav_context").html(data);
			fav_dialog.jqmShow();
		}		
	});	
}

function input_favorite_close() {
	if (fav_dialog) {
		fav_dialog.jqmHide();
	}
}

function toggle_md(id){	
	switch_div('tw_' + id);
    $("#up_" + id).toggleClass("on");
    $("#up_" + id).toggleClass("off");
}

function showPopBox() {
	$('#pop_box').show();
}

pngfix=function(){var els=document.getElementsByTagName('*');var ip=/\.png/i;var i=els.length;while(i-- >0){var el=els[i];var es=el.style;if(el.src&&el.src.match(ip)&&!es.filter){es.height=el.height;es.width=el.width;es.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+el.src+"',sizingMethod='crop')";el.src="/images/common/clear.gif";}else{var elb=el.currentStyle.backgroundImage;if(elb.match(ip)){var path=elb.split('"');var rep=(el.currentStyle.backgroundRepeat=='no-repeat')?'crop':'scale';es.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+path[1]+"',sizingMethod='"+rep+"')";es.height=el.clientHeight+'px';es.backgroundImage='none';var elkids=el.getElementsByTagName('*');if (elkids){var j=elkids.length;if(el.currentStyle.position!="absolute")es.position='static';while (j-- >0)if(!elkids[j].style.position)elkids[j].style.position="relative";}}}}}

function setPngFix() {
	if (isie && (isie5 || isie6)) {
		window.attachEvent('onload', pngfix);
	}
}

function shortTips(){
	var xOffset = 30;
	var yOffset = 10;
	var wOffset = 210;
	function tarHover(event){
		this.tip = this.title;
		this.title = "";
		var _tip = (this.tip!=this.title) ? this.tip : "" ;
		var dist = event.pageX+xOffset+210;
		if( dist > $(document).width()){
			$("body").prepend("<div id='short_pop_tip' class='pop-tips'><div class='tips-head-right'></div><div class='tips-body'>"+_tip+"</div><div class='tips-foot'></div></div>");
		}else{
			$("body").prepend("<div id='short_pop_tip' class='pop-tips'><div class='tips-head-left'></div><div class='tips-body'>"+_tip+"</div><div class='tips-foot'></div></div>");
		}	    
	}
	function tarOut(){
		$("#short_pop_tip").remove();
		this.title = this.tip;
	}
	$(".short-tips").hover(tarHover,tarOut).mousemove(function(event){
		var dist = event.pageX+xOffset+210;
		if(dist > $(document).width()){
			$("#short_pop_tip").css({left:event.pageX-wOffset+"px",top:event.pageY+yOffset+"px"});
		}else{
			$("#short_pop_tip").css({left:event.pageX-xOffset+"px",top:event.pageY+yOffset+"px"});
		}
	});
}

function initial_load_saving(content_name,sv_type) {	
	jQuery.get("/tinymce/initial_load_saving",{ content_name: content_name,saving_type: sv_type },function(html){	
		if (html=="no_auto_saving") {
			$("#auto_saving_hint").html("薄荷每隔30秒帮您自动保存草稿。");
			period_auto_save(content_name,sv_type);
		} else {
			$("#auto_saving_hint").html(html);
		}
    });
}

function period_auto_save(content_name,sv_type) {
	setInterval("auto_save('"+content_name+"',"+sv_type+");",30000);
}

var auto_save_last_len = 0;
function auto_save(content_name,sv_type) {
    if (typeof(tinyMCE) != 'undefined') {
        tinyMCE.get(content_name).save();
    }
    if (typeof(KE) != 'undefined') {
        KE.util.setData(content_name);
    }
    var ct = $('#'+content_name).val();
	if (ct && ct.length > 0 && ct.length!=auto_save_last_len) {
		auto_save_last_len = ct.length;
		jQuery.post("/tinymce/auto_save", {
			content: ct,
			saving_type: sv_type
		}, function(html){
		   $("#auto_saving_hint").html(html);
		});
	}
}

function load_saving(content_name,sv_type) {
	jQuery.get("/tinymce/load_saving",{saving_type: sv_type},function(html){
       if (typeof(tinyMCE) != 'undefined') {
         tinyMCE.execInstanceCommand(content_name,'mceSetContent',true,html);
       }
       if (typeof(KE) != 'undefined') {
         KE.html(content_name,html);
       }       
       $("#auto_saving_hint").html("成功恢复草稿，薄荷每隔30秒帮您自动保存草稿。");
       period_auto_save(content_name,sv_type);
    });
}
function clear_saving(content_name,sv_type) {
	jQuery.get("/tinymce/clear_saving",{saving_type: sv_type},function(html){
	  $("#auto_saving_hint").html(html);
	  period_auto_save(content_name,sv_type);
    });
}

/* Inline Popup PlaceHolder:统一样式(直接传内容, 用来兼容以前的三种提示框: error, notice, warning) */
function inlinePopHolder(id, title, content, cssClass){
	return $("<div id='"+id+"' class='popup"+' '+cssClass+"'>" +
	              "<div class='head-wrap'>\
				    <div class='head'></div><div class='head-left'></div><div class='head-right'></div><a class='close jqmClose' href='javascript:void(0)'></a>\
				  </div>" +
				  "<table cellpadding='0' cellspacing='0' class='body-wrap'><tr><td class='body-left'></td>\
					 <td class='body'>\
					   <div class='pop_body'>\
					    <div class='pop-title'>"+title+"&nbsp;</div>\
						<div id='"+id+"_ct' class='pop-content'>"+content+"</div>\
					   </div>\
					 </td><td class='body-right'></td></tr>\
				  </table>"+
				  "<div class='foot-wrap'>\
				     <div class='foot'></div>\
					 <div class='foot-left'></div>\
					 <div class='foot-right'></div>\
				  </div>"+
			 "</div>");	
}

/* Ajax Popup PlaceHolder:统一样式(传内容div的ID, 用来兼容以前的三种弹出框: can, favorite, comment) */
function ajaxPopHolder(id, title, content_id, cssClass){
	return $("<div id='"+id+"' class='popup"+' '+cssClass+"'>" +
	              "<div class='head-wrap'>\
				    <div class='head'></div><div class='head-left'></div><div class='head-right'></div><a class='close jqmClose' href='javascript:void(0)'></a>\
				  </div>" +
				  "<table cellpadding='0' cellspacing='0' class='body-wrap'><tr><td class='body-left'></td>\
					 <td class='body'>\
					   <div class='pop_body'>\
					    <div class='pop-title'>"+title+"&nbsp;</div>\
						<div id='"+content_id+"' class='pop-content'></div>\
					   </div>\
					 </td><td class='body-right'></td></tr>\
				  </table>"+
				  "<div class='foot-wrap'>\
				     <div class='foot'></div>\
					 <div class='foot-left'></div>\
					 <div class='foot-right'></div>\
				  </div>"+
			 "</div>");	
}

/*统一的弹窗Holder, 带autoclose*/
function popHolder(id, title, content, cssClass){
	return $("<div id='"+id+"' class='popup"+' '+cssClass+"'>" +
	              "<div class='head-wrap'>\
				    <div class='head'></div><div class='head-left'></div><div class='head-right'></div><a class='close jqmClose' href='javascript:void(0)'></a>\
				  </div>" +
				  "<table cellpadding='0' cellspacing='0' class='body-wrap'><tr><td class='body-left'></td>\
					 <td class='body'>\
					   <div class='pop_body'>\
					    <div class='pop-title'>"+title+"&nbsp;</div>\
						<div id='"+id+"_ct' class='pop-content'>"+content+"<div class='timer tmot'></div></div>\
					   </div>\
					 </td><td class='body-right'></td></tr>\
				  </table>"+
				  "<div class='foot-wrap'>\
				     <div class='foot'></div>\
					 <div class='foot-left'></div>\
					 <div class='foot-right'></div>\
				  </div>"+
			 "</div>");		
}

/* ************Popup window using jqm***************** */
/* ***************Start********************* */

/*arguments
 * id: id of element that needs auto-close
 */
function autoClose(id){
	ele = $("#"+id);
    if (ele[0]) {
        var n = ele.attr('timeout') - 1;
        ele.attr('timeout',n)
        if (n > 0) {
			if(ele.find(".tmot")[0]){
			  ele.find(".tmot").html("[该提示信息将在&nbsp;<b>" + n + "</b>&nbsp;秒后自动关闭]");	
			}
            setTimeout("autoClose('"+id+"');", 1000);
        } else {
            ele.jqmHide();
        }
    }
}

/*options:
 * content: [#id_of_source_ele_in_page | /remote/source/url | raw_content_not_start_with_#_or_/]
 * *data: key/value pairs for /remote/source/url
 * id:         id of popup window 
 * cssClass:   css class name
 * timeout:    auto hide after timeout
 * position:   default on the center of screen 
 * jqm:        options for jqm function
 */
function popup(title, options){
	var id = "popup_" + (options.id || (new Date()).getTime());
	var _popup = "#"+id;
	if(!$(_popup).length){
		var content = "";
		if (options.content) {
			if(options.content.indexOf("#") == 0){
				content = $(options.content).html();
				$(options.content).remove();//Avoid id confliction.
			}else if(options.content.indexOf("/") == 0){
				$.get(options.content, options.data, function(data){
					options.content = data;
					popup(title, options);
					if (options.callback) {
						eval(options.callback);
					}
				});
				return;
			}else{
				content = options.content;
			}
		}
	    popHolder(id, title, content, options.cssClass).appendTo($(document.body));
		var jqmOptions = options.jqm || {overlay: 0, modal:false};
		var modal = $(_popup).jqm(jqmOptions)
		if (options.drag) {
			modal = modal.jqDrag(".pop-title");
		}
		if (options.resize) {
			modal.jqResize();
		}
		if(options.position){
			$(_popup).css(options.position);
		}else{
		  $(_popup).css({"margin-top":-($(_popup).height()/2)});	
		}
		if (options.timeout>0) {
		   $(_popup).attr("timeout",options.timeout);
		   autoClose(id);
		}		
	}
	$(_popup).jqmShow();
}
/* ****************End********************** */
/* ************Popup window using jqm***************** */


/* ****************hover fixed********************** */
function hoverFixed(){
	$(".hover-fixed").hover(
		function(){	$(this).addClass("hover"); },
		function(){	$(this).removeClass("hover"); }
	);
}

function fixTable2(){
    var the_table = $("table.table2");
	the_table.find("td:first-child").css({"border-left":0});
    the_table.find("th:first-child").css({"border-left":0});
	the_table.find("td:last-child").css({"border-right":0});
	the_table.find("th:last-child").css({"border-right":0});
}

function dropMenu(obj){
	$(obj).each(function(){
        var theSpan = $(this);
        var theMenu = theSpan.find(".drop-menu");
		var tarHeight = theMenu.height();
		theMenu.css({height:0,opacity:0});
		theSpan.hover(
			function(){
				$(this).addClass("hover");
				theMenu.stop().show().animate({height:tarHeight,opacity:1},400);
			},
			function(){
				$(this).removeClass("hover");
				theMenu.stop().animate({height:0,opacity:0},400,function(){
					$(this).css({display:"none"});
				});
			}
    	);
	});
}

(function($){
	$.fn.textSlider = function(settings){    
        settings = jQuery.extend({
        	speed : "normal",
			line : 2,
			timer : 1000
    	}, settings);
		return this.each(function() {
			$.fn.textSlider.scllor( $( this ), settings );
    	});
    }; 
	$.fn.textSlider.scllor = function($this, settings){
		//alert($this.html());
		var ul = $( "ul:eq(0)", $this );
		var timerID;
		var li = ul.children();
		var _btnUp=$(".up:eq(0)", $this)
		var _btnDown=$(".down:eq(0)", $this)
		var liHight=$(li[0]).height();
		var upHeight=0-settings.line*liHight;//滚动的高度；
		var scrollUp=function(){
			_btnUp.unbind("click",scrollUp);
			ul.animate({marginTop:upHeight},settings.speed,function(){
				for(i=0;i<settings.line;i++){
                	 //$(li[i]).appendTo(ul);
					 ul.find("li:first").appendTo(ul);
					// alert(ul.html());
                }
               	ul.css({marginTop:0});
                _btnUp.bind("click",scrollUp); //Shawphy:绑定向上按钮的点击事件
			});	
		};
		var scrollDown=function(){
			_btnDown.unbind("click",scrollDown);
			ul.css({marginTop:upHeight});
			for(i=0;i<settings.line;i++){
				ul.find("li:last").prependTo(ul);
            }
			ul.animate({marginTop:0},settings.speed,function(){
                _btnDown.bind("click",scrollDown); //Shawphy:绑定向上按钮的点击事件
			});	
		};
		var autoPlay=function(){
			timerID = window.setInterval(scrollUp,settings.timer);
			//alert(settings.timer);
		};
		var autoStop = function(){
            window.clearInterval(timerID);
        };
		//事件绑定
		ul.hover(autoStop,autoPlay); //.mouseout();
		autoPlay();
		_btnUp.css("cursor","pointer").click( scrollUp );
		_btnUp.hover(autoStop,autoPlay);
		_btnDown.css("cursor","pointer").click( scrollDown );
		_btnDown.hover(autoStop,autoPlay)
	};
})(jQuery);

/* shows and hides ajax indicator */
var gl_show_ajax_indicator = true;
$(document).ready(function(){
	$(document).ajaxStart(function(){
        if (!gl_show_ajax_indicator) return;
        var ajax_idc = $('#ajax-indicator');
        if (ajax_idc.size()==0) {
           ajax_idc = $("<div id=\"ajax-indicator\" style=\"display:none;\"><span>正在加载…</span></div>").appendTo("body");
        }
        var t = (document.documentElement.clientHeight) / 2 + document.documentElement.scrollTop - 15;
        ajax_idc.css({'top': t}).show();
	}).ajaxStop(function(){
	   $('#ajax-indicator').hide();
	});
});

$(document).ready(function(){
	$('a.click_stat').click(function(){
		$.get('/main/click?url='+$(this).attr('href'));
	});
	$('a.click_stat_dt').click(function(){
		$.get('/main/click?dt=1&url='+$(this).attr('href'));
	});
    $("a.popup_login").click(function(){
        popup_login($(this).attr('href'));
        return false;
    });
	$("#rr_logout").click(function(){
		XN.Connect.logout();
	});
});

function popup_login(pre_url,show_reg) {
	var reg = "";
	if ( show_reg ) {
		reg = "<span class='gap40'></span><a target='_blank' class='green-button3' href='/profile/toRegister.htm'>免费注册</a>";
	}	
    var html = "<div><form method='post' action='/profile/login' id='popup_login_form'> \
            <input type='hidden' value='"+pre_url+"' name='pre_url'> \
            <input type='hidden' value='auto' name='login_type'> \
            <p>用户名或已验证的邮箱<br> \
              <input type='text' size='26' name='user_name' id='user_name' class='form-text'>&nbsp;&nbsp; \
              <span class='main-check'><input type='checkbox' value='1' name='auto_login' id='auto_login' tabindex='3'></span><label for='auto_login'>&nbsp;自动登录</label></p> \
            <p>密<span class='txt-dist2'></span><span class='txt-dist2'></span>码&nbsp;&nbsp;<br> \
              <input type='password' size='26' name='passwd' id='passwd' class='form-text'>&nbsp;&nbsp; \
              <a target='_blank' href='/profile/forgot_passwd'>忘记密码?</a></p> \
            <p style='margin-top: 20px;' class='middle- center'><input type='submit' value='登录' class='red-button3'>" + reg + "</p></form></div><br />";
    var title = "请您先登录薄荷";
    if (pre_url=="") {
       title = "登录薄荷";
    }
    if ($("#popup_login").length>0) {
       $("#popup_login_form > input[name='pre_url']").val(pre_url);
       $("#popup_login .pop-title").text(title);
       $("#popup_login").jqmShow();
    } else {
       popup(title,{id:"login",content:html,jqm:{overlay: 50, modal:true}});
    }
}

function ajax_popup_login(next_step) {
    var ajax_submit = "$.ajax({async:true, data:$.param($(this).serializeArray()), dataType:'script', type:'post', url:'/profile/login'}); return false;"
    var html = "<div><form method='post' onsubmit=\""+ajax_submit+"\" action='/profile/login' id='ajax_popup_login_form'> \
            <input type='hidden' value='auto' name='login_type'> \
            <p>用户名或已验证的邮箱<br> \
              <input type='text' size='26' name='user_name' id='user_name' class='form-text'>&nbsp;&nbsp; \
              <span class='main-check'><input type='checkbox' value='1' name='auto_login' id='auto_login' tabindex='3'></span><label for='auto_login'>&nbsp;记住我</label></p> \
            <p>密<span class='txt-dist2'></span><span class='txt-dist2'></span>码&nbsp;&nbsp;<br> \
              <input type='password' size='26' name='passwd' id='passwd' class='form-text'>&nbsp;&nbsp; \
              <a target='_blank' href='/profile/forgot_passwd'>忘记密码?</a></p> \
            <p style='margin-top: 20px;' class='middle- center'><input type='submit' value='登录' class='red-button3'> \
              <span class='gap40'></span><a target='_blank' class='green-button3' href='/profile/toRegister.htm'>免费注册</a></p> \
          </form> \
        </div><br />";
    var title = "请您先登录薄荷";
    if ($("#popup_ajax_login").length>0) {
       $("#popup_ajax_login").jqmShow();
    } else {
       popup(title,{id:"ajax_login",content:html,jqm:{overlay: 50, modal:true}});
    }
}

//circleFixed
function circleFixed(o){
	$(o).prepend("<span class='tl'></span><span class='tr'></span><span class='br'></span><span class='bl'></span>");
}

$(document).ready(function(){
	circleFixed("div.notice-bar-wrap");
	circleFixed("div.tips-bar-wrap");
});

$(document).ready(function(){
	shortTips();
});

$(document).ready(function(){
	dropMenu(".drop-menu-effect");
});

$(document).ready(function(){
	hoverFixed();
});

$(document).ready(function(){
	fixTable2();
});


(function($){
	$.fn.blockSlide = function(option){
		var option = $.extend({
				width:400,
				height:200,
				duration:700,
				time:3000,
				arrow:true,
				nextParams:{opacity:0},
				prevParams:{opacity:1},
				easing:"swing"
			},option||{});
		
		this.css({
			width:option.width,
			height:option.height
		})
		.append(option.arrow?"<span class='next'></span><span class='prev'></span>":"")
		.children(".next,.prev").css({
			height:option.height,
			"line-height":(option.height+"px")
		});
		
		var frames = this.children(".frame");
		
		frames.children("div").css({
			width:option.width,
			height:option.height,
			background:"#FFFFFF"
		});
		
		var timer;
		
		function autoSlide(key){
			if(option.time != 0){
				if(key){
					timer = setInterval(nextFrame,option.time);
				}else{
					clearInterval(timer);
				}
			}
		}
		
		autoSlide(true);
		
		function nextFrame(){
			frames.children("div").stop(true,true).filter(":last-child").prev("div").show().end(":last-child").animate(
				option.nextParams,
				option.duration,
				option.easing,
				function(){
					$(this).hide().prependTo(frames).css(option.prevParams);
				}
			);
		}
		
		function prevFrame(){
			frames.children("div").stop(true,true).filter(":first-child").css(option.nextParams).appendTo(frames).show().animate(
				option.prevParams,
				option.duration,
				option.easing,
				function(){
					$(this).prev("div").hide();
				}
			);
		}
		
		this.children(".next").click(function(){
			nextFrame();
		})
		
		this.children(".prev").click(function(){
			prevFrame();
		})
		
		this.hover(
			function(){
				autoSlide(false);
				$(this).children(".next,.prev").fadeIn(200);
			},
			function(){
				autoSlide(true);
				$(this).children(".next,.prev").fadeOut(200);
			}
		)
		
		return this;
	}
})(jQuery);
