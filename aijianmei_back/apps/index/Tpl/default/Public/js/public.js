function gbcount(message,total,used,remain) 
{
	var max; 
	max = total.value; 
	if (message.value.length > max) { 
		message.value = message.value.substring(0,max); 
		used.value = max; 
		remain.value = 0; 
		alert("留言不能超过 300 个字!"); 
	} 
	else 
	{ 
		used.value = message.value.length; 
		remain.value = max - used.value; 
	} 
}
/*author kontem video like ajax start*/
function recordlike(){
		var vid=$("#videoid").val();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			dataType:"json",
			data: "act=recordlike&data=ford&vid="+vid,
			success: function(data)
			{
				if(data==1){
				var video_num_like=$("#video_num_like").val();
				video_num_like=video_num_like*1+1;
				$(".num_like").html(video_num_like);
				}
				else{
				alert("你已经赞过了�?);
				}
			}
		});
}
/*}}}end*/
$(function(){
    var sWidth = $("#banner").width(), //获取焦点图的宽度（显示面积）
        len = $("#banner .ul_1 li").length, //获取焦点图个�?
        index = 0,
        tab; 

    //下一页切�?
    $(".ps_right").click(function(){
        index++;
        if(index == len) {index = 0;}
        move(index);
    })
    //上一页切�?
    $(".ps_left").click(function(){
        index--;
        if(index == -1) {index = len - 1;}
        move(index);
    })

    //点击切换
    $("#banner .ul_2 li").click(function(){
        index = $("#banner .ul_2 li").index(this);
        move(index);
    })

    //自动切换函数
    $("#banner").hover(
        function(){
            clearInterval(tab)
        },
        function(){
            tab = setInterval(function(){
                move(index);
                index++;
                if(index == len) {index = 0;}
            },3000)
        }
    ).trigger("mouseleave");

    //定义移动函数
    var move = function(index){
        var nowleft = -index*sWidth;
        $("#banner .ul_1").stop(true,false).animate({"left":nowleft},300);
        $("#banner .ul_2 li").css("border","3px solid transparent").eq(index).css("border","3px solid #4298CE");
        $("#banner .ul_2").css("width","860px")
    }

    //透明效果  版图修改过这些地�?
    $(".lay_banner").hover(
        function(){
            $('.massage').css("opacity","0.8")
        },
        function(){
            $('.massage').css("opacity","0.3")
        }
    )
})

$(function(){
    $(".login").click(function(e){
        var _e = window.event ? window.event : e || arguments[0];
        if(_e.preventDefault){
            _e.preventDefault();
        }
        else{
            _e.returnValue = false;
        }
        if($(".text_input input").val() != ''){
            $(".text_input input").siblings().hide(); 
        }
        $("div.body").slideDown(300,function(){
            $("html").css("overflow","hidden").height("100%");
            $(this).css({"display":"block","opacity":"0.7"});
            $("div.sheet").slideDown(200);
            $("div.sheet").css("display","block");
        });
    });
    $(".close_btn").click(function(){
        $("html").css("overflow","scroll");
        $("div.sheet").slideUp(200,function(){
        $("div.sheet").css("display","none");
        $("div.body").slideUp(300,function(){
            $("div.body").css("display","none");
        });
        
        });
    });


    $(".text_input input").focus(function(){
        $(this).siblings().hide();          
    });
    $(".text_input input").blur(function(){
        if(!($(this).val())){
            $(this).siblings("label").show();
        }
        else{
            var e_reg = new RegExp(),
                p_reg = new RegExp();
                e_reg = /^\w+((_-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|_-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/,
                p_reg = /[0-9A-Za-z]{6,16}/;
            var email = $("#mail").val(),
                psd = $("#psd").val();
                
            if(e_reg.test(email) == false){
                $("#mail").next().show();
            }
            if(p_reg.test(psd) == false){
                //console.log(this);
                $("#psd").next().show();
            }
        }
    });
    //顶部top部分，鼠标滑过显示更多内�?   

    $(".more").mouseover(function(){
        $(this).children($("ul")).show();
        $(this).children($("a")).first().addClass("on");
        $(this).mouseout(function(){
            $(this).children($("a")).first().removeClass("on");
            $(".more>ul").hide();
        })      
    })
    //导航栏样�?
    $("#nav>li").click(function(){
        $(this).addClass("now_position").siblings().removeClass("now_position");
    })
        
                    
});
//js from weimian..................
            //添加事件监听
            var addevent = function(element,type,handle){
                if(element.addEventListener){
                    element.addEventListener(type,handle,false)
                }
                else if(element.attachEvent){
                    element.attachEvent("on" + type,handle)
                } 
                else {
                    element["on" + type] = handler;
                    this.AddEvent = function(element, type, handler)
                    {
                        element["on" + type] = handler;
                    };
                }
            }
            //获取dom元素
            var getdom = function(){
                this.$ = function(id){
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
                p_fixed : function(obj){
                    window.onscroll = function(){
                        var top = document.body.scrollTop || window.pageYOffset || document.documentElement.scrollTop;
                        if(top >= 50){
                            obj.className = 'header p_fixed';
                        }
                        else{
                            obj.className = 'header'
                        }       
                    }
                }
            }
            var init = function(){
                var newdom = new getdom,
                    header = newdom.getElementsByClass('header')[0];
                aijianmei.p_fixed(header);
            }
            init();

            //为obj的子元素添加有色边框
            var getaction = function(classname,obj){
                var newdom = new getdom,
                    classname = newdom.getElementsByClass(classname);   
                var defaule = {
                    'color': obj.choicecolor ? obj.choicecolor : '#D273FF',
                    'borderwidth':obj.choiceborderwidth ? obj.choiceborderwidth : '3px'
                }

                //获取对象索引�?
                var getindex = function(obj){
                    for(var i = 0;i < classname.length;i++){
                        switch(obj){
                            case classname[i]:return i;
                            break;
                        }
                        
                    }
                }
                var getborder = function(num){
                    for(var i = 0;i <�?lassname.length;i++){
                        if(i == num){
                            classname[num].style.borderColor = defaule.color;
                            classname[num].style.borderWidth = defaule.borderwidth;
                            classname[num].style.borderStyle = 'solid'
                        }
                    }
                        
                }
                var clearborder = function(num){
                    for(var i = 0;i <�?lassname.length;i++){
                        if(i == num){
                            classname[num].style.borderColor = '';
                            classname[num].style.borderWidth = '';
                        }
                    }
                        
                }

                for(var i = 0;i <�?lassname.length;i++){
                    classname[i].onmouseover = function(){
                        var index = getindex(this);
                            getborder(index)
                    }
                    classname[i].onmouseout = function(){
                        var index = getindex(this);
                            clearborder(index)
                    }
                }
                    
            }
            //改变obj的背景原�?
            var changecolor = function(obj,color,childcolor){
                    var newgetdom = new getdom,
                        target = newgetdom.getElementsByClass(obj);
                        
                        for(var i = 0;i < target.length;i++){
                            target[i].onmouseover = function(){
                                this.style.background = color;
                                if(this.childNodes[0]){
                                    var targetchlid = this.childNodes[0];
                                    targetchlid.style.color = childcolor;
                                }
                                
                                    
                            }
                            target[i].onmouseout = function(){
                                this.style.background = '';
                                if(this.childNodes[0]){
                                    var targetchlid = this.childNodes[0];
                                    targetchlid.style.color = ''
                                }
                                
                            }       
                        }
                            
            }
            //为需要添加提示内容的函数，�?用需要添加的对象obj;
            var addtitle = function(obj){
                var newdom = new getdom,
                    Obj = newdom.getElementsByClass(obj)[0],
                    title = newdom.getElementsByClass('title_tip')[0],
                    text = Obj.getAttribute('data-original-title');
                var handle = function(){
                    if(window.ActiveXObject){
                        Obj.setAttribute('title',text)
                    }
                    else{
                        //确定提示内容的宽度，适当调整
                        var handlewidth = function(){
                            if(text.length < 5){
                                title.style.width = '80px';
                            }
                            else if(text.length < 9){
                                title.style.width = '120px'
                            }
                            else if(text.length < 13){
                                title.style.width = '160px'
                            }
                            else{
                                title.style.width = '200px'
                            }
                        }
                        handlewidth();
                        //获取data-original-title的内�?
                        var datatitle = function(){
                            var div = document.createElement('div');
                                textnode = document.createTextNode(text);
                            div.appendChild(textnode);
                            title.appendChild(div);
                        }
                        datatitle()
                        //确定obj的位置，并是提示对齐被提示内�?
                        var textalign = function(){
                            var left = Obj.offsetLeft,
                                top = Obj.offsetTop,
                                width = Obj.offsetWidth,
                                titlewidth = title.style.width,
                                align = left + width/2,
                                half = parseFloat(titlewidth)/2;
                                title.style.left = align - half + 'px';
                                title.style.top = top + 30 + 'px';
                        } 
                        textalign();
                        title.style.display = 'block';
                    }
                }
                var remove = function(){
                    title.removeChild(title.lastChild);
                    title.style.display = 'none';
                }
                //addevent(Obj,"mouseover",handle);
                //addevent(Obj,"mouseout",remove);
                ckon(Obj,"mouseout",remove,array);
            }
// //视频列表 切换分类
// $("li.select>a").mouseover(function(){
//  $(this).addClass("pre").siblings().removeClass("pre");
    
// })   
//鼠标移上图片显示进入
$("li .show_enter").add("div .show_enter").mouseover(function(){
    $(this).children(".enter_icon").css("display","block");
    $(this).children("img").css("border-color","#21ace3");
    $(this).children().children(".v_enter").css('background','url(images/wm3.png) no-repeat 0 -490px')
    $(this).mouseout(function(){
        $(this).children(".enter_icon").css("display","none");
        $(this).children("img").css("border-color","transparent");
        $(this).children().children(".v_enter").css('background','')
    })
});
//添加目录动�?�?--------------------------------------
           $('.nav_cf').mouseover(function(){
                var index = $(".nav_cf").index(this);
                $('.title_hint').css('opacity','1').eq(index).css('opacity','0');
                $('.nav_detail').css('opacity','0').eq(index).css('opacity','1');
                $('.bg_opacity').css('opacity','0.4').eq(index).css('opacity','0');
           })
           $('.nav_cf').mouseout(function(){
                $('.nav_detail').css('opacity','0');
                $('.title_hint').css('opacity','1');
           })
           $('.position_nav').mouseleave(function(){
                $('.bg_opacity').css({'opacity':'0'})
           })
//为板块添加css3渐变边框---------------------------
        $(".tr_classify").add(".recommend").add(".tr_top").hover(
            function(){
                $(this).css("box-shadow","0 0 8px #21ace3")
            },
            function(){
                $(this).css("box-shadow","")
            }
        )

//textarea focus()
    $(".comment_inp").click(function(){
        $(this).html("");
    })

//公共部分！！！�?择页面，上下页切�?
    $(".page a").hover(
        function(){
            $(this).css("border-color","#21ace3")
        },
        function(){
            $(this).css("border-color","")
        }
    )
//动�?改变背景图片，用在那些背景鼠标过去按钮原色变化的对象�?
            var move = function(obj,url,num){
                var newdom = new getdom,
                    id = newdom.getElementsByClass(obj),
                    len = id.length,
                    image = id[0].style.backgroundImage,
                    currentpositionY = id[0].style.backgroundPositionY;
                for(var i = 0;i < len;i++){
                    id[i].onmouseover = function(){
                        if(num != null){
                            this.style.background = 'url('+url+')';
                            this.style.backgroundPositionX = '0px';
                            this.style.backgroundPositionY = num;
                            
                        }                   
                        else{
                            this.style.background = 'url('+url+')';
                        }
                        // console.log(this.style.backgroundPosition)           
                    }
                    id[i].onmouseout = function(){
                        this.style.backgroundImage = image;
                        this.style.backgroundPositionX = '0px';
                        this.style.backgroundPositionY = currentpositionY;
                    }
                }
            }
            // move('background','images/wm2.png','-220px')第一个是对象class属�?，第二个是地�?��第三个是雪碧图的Y�?
































            //对象fade，添加一个功能，屏蔽按钮，显示产品即将推�?
            var fade = {
                newdom : new getdom,
                init : function(obj){
                    var Obj = fade.newdom.getElementsByClass(obj)[0] || document.getElementsByTagName(obj)[0] || document.getElementById(obj);
                    Obj.onclick = function(event){
                        var _e = event ? event : window.event;
                        if(_e.preventDefault){
                            _e.preventDefault();
                        }
                        else{
                            _e.returnValue = false;
                        }
                        fade.handlecontent();
                        fade.changestyle('1');
                        this.style.background = '';
                        var closed = fade.newdom.getElementsByClass('closed')[0],
                            fade_in = fade.newdom.getElementsByClass('fade_in')[0];
                        var click_back = function(){
                            fade.changestyle('0');
                            // fade_in.removeAttribute('class')
                            fade_in.className = ''
                        }
                        addevent(closed,'click',click_back);
                        addevent(fade_in,'click',click_back);
                    }
                },
                handlecontent : function(){
                    var body = document.getElementsByTagName('body')[0],
                        div_1 = document.createElement('div'),
                        div_2 = document.createElement('div');
                    div_1.className = 'fade_in';
                    div_2.className = 'modal';
                    div_2.innerHTML = '<div class="modal_header"><a class="closed">×</a><h3>我们正在�?���?/h3></div><p class="modal_body">即将推出，敬请期�?..</p>';
                    body.appendChild(div_1);
                    body.appendChild(div_2);
                },
                changestyle : function(T){
                    var fade_in = fade.newdom.getElementsByClass('fade_in')[0],
                        modal = fade.newdom.getElementsByClass('modal')[0];
                    if(T == '1'){
                        var i = 0,
                            top = fade.newdom.GetCurrentStyle(modal,'top');
                        var round = function(){
                            setTimeout(function(){
                                i = i + 0.05;
                                fade_in.style.opacity = i;
                                top = parseFloat(top) + 20;
                                modal.style.top = top + 'px';
                                if(top < 200){
                                    round()
                                }
                            },1);
                        }
                        round()
                    }
                    else{
                        var i = 0.75,
                            top = fade.newdom.GetCurrentStyle(modal,'top');
                        var round = function(){
                            setTimeout(function(){
                                i = i - 0.05;
                                fade_in.style.opacity = i;
                                top = parseFloat(top) - 20;
                                modal.style.top = top + 'px';
                                if(top > -120){
                                    round()
                                }
                            },10);
                        }
                        round()
                    }   
                }
            };
            var newdom = new getdom;
            if(newdom.getElementsByClass('store')[0]){
                fade.init('store');
            }
            if(newdom.getElementsByClass('forum')[0]){
                fade.init('forum');
            }
            if(newdom.getElementsByClass('friends')[0]){
                fade.init('friends');
            }
            if(newdom.getElementsByClass('my_cart')[0]){
                fade.init('my_cart');
            }
            if(document.getElementById('teach')){
                fade.init('teach');
            }

$(document).ready(function() {
  $("embed").attr({"wmode":"transparent"});
 });
$(function(){
    $(window).scroll(function () {
        if($(window).scrollTop() >= 300)//距离顶部多少高度显示按钮
        {
            $('#goTopBtn').slideDown(200);
        }
        else
        {
            $('#goTopBtn').slideUp(200);
        }
    });    
    $('#goTopBtn').click(function(){
        $('body,html').animate({scrollTop:0},500)
    });     
    //按钮定位
    var win_width= $(window).width();    //窗口宽度
    var content_width= $('.wrapper').width();     //容器宽度
    var topbtn_width= $('#goTopBtn').width(); //按钮宽度
    //alert([win_width - content_width]/2);   
    //距离主体部分的右侧距�?
    var topbtn_posi = ([win_width - content_width ]/2 - topbtn_width - 50);
    $('#goTopBtn').css({'right':topbtn_posi});


}); 
 
 
 			var aijianmei = {
                newdom : new getdom,
                p_fixed : function(obj){
                    window.onscroll = function(){
                        var top = document.body.scrollTop || window.pageYOffset || document.documentElement.scrollTop;
                        if(top >= 50){
                            obj.className = 'header p_fixed';
                        }
                        else{
                            obj.className = 'header'
                        }       
                    }
                },
                change_num : function(obj,show){
	            	var obj = aijianmei.newdom.getElementsByClass(obj),
	            		len = obj.length,
	            		show_num = aijianmei.newdom.getElementsByClass(show);
	            	for(var i = 0;i < len;i++){
	            		obj[i].index = i;
	            		if(obj[i]){
	            			obj[i].onkeyup = function(){
	                			show_num[this.index].innerHTML = this.value.length;
	                		}
	                		obj[i].onkeydown = function(){
	                			show_num[this.index].innerHTML = this.value.length;
	                		}
	            		} 		
	            	}
	            }
            }
            function change_number(obj_1,obj_2){
            	aijianmei.change_num(obj_1,obj_2);
            }
            //change_number('comment_inp','lay_word_num')
            var init = function(){
                var newdom = new getdom,
                    header = newdom.getElementsByClass('header')[0];
                aijianmei.p_fixed(header);
            }
            init();
	



