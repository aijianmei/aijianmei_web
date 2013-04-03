$(function(){
    var sWidth = $("#banner").width(), //获取焦点图的宽度（显示面积）
        len = $("#banner .ul_1 li").length, //获取焦点图个数
        index = 0,
        tab; 

    //下一页切换
    $(".ps_right").click(function(){
        index++;
        if(index == len) {index = 0;}
        move(index);
    })
    //上一页切换
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

    //透明效果  版图修改过这些地方
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
	$("#login").click(function(){
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
	//顶部top部分，鼠标滑过显示更多内容	
	$(".more").mouseover(function(){
		$(this).children($("ul")).show();
		$(this).children($("a")).first().addClass("on");
		$(this).mouseout(function(){
			$(this).children($("a")).first().removeClass("on");
			$(".more>ul").hide();
		})		
	})
	//导航栏样式
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



            //为obj的子元素添加有色边框
            var getaction = function(classname,obj){
                var newdom = new getdom,
                    classname = newdom.getElementsByClass(classname);	
                var defaule = {
                    'color': obj.choicecolor ? obj.choicecolor : '#D273FF',
                    'borderwidth':obj.choiceborderwidth ? obj.choiceborderwidth : '3px'
                }

                //获取对象索引号
                var getindex = function(obj){
                    for(var i = 0;i < classname.length;i++){
                        switch(obj){
                            case classname[i]:return i;
                            break;
                        }
                        
                    }
                }
                var getborder = function(num){
                    for(var i = 0;i <　classname.length;i++){
                        if(i == num){
                            classname[num].style.borderColor = defaule.color;
                            classname[num].style.borderWidth = defaule.borderwidth;
                            classname[num].style.borderStyle = 'solid'
                        }
                    }
                        
                }
                var clearborder = function(num){
                    for(var i = 0;i <　classname.length;i++){
                        if(i == num){
                            classname[num].style.borderColor = '';
                            classname[num].style.borderWidth = '';
                        }
                    }
                        
                }

                for(var i = 0;i <　classname.length;i++){
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
            //改变obj的背景原色
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
            //为需要添加提示内容的函数，选用需要添加的对象obj;
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
                        //获取data-original-title的内容
                        var datatitle = function(){
                            var div = document.createElement('div');
                                textnode = document.createTextNode(text);
                            div.appendChild(textnode);
                            title.appendChild(div);
                        }
                        datatitle()
                        //确定obj的位置，并是提示对齐被提示内容
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
                addevent(Obj,"mouseover",handle);
                addevent(Obj,"mouseout",remove);
            }
// //视频列表 切换分类
// $("li.select>a").mouseover(function(){
// 	$(this).addClass("pre").siblings().removeClass("pre");
    
// })	
//鼠标移上图片显示进入
$("li .show_enter").add("div .show_enter").mouseover(function(){
	$(this).children(".enter_icon").css("display","block");
	$(this).children("img").css("border-color","#21ace3");
	$(this).children(".v_enter").css('background','url(images/wm3.png) no-repeat 0 -490px')
	$(this).mouseout(function(){
		$(this).children(".enter_icon").css("display","none");
		$(this).children("img").css("border-color","transparent");
		$(this).children(".v_enter").css('background','')
	})
});
//添加目录动态快---------------------------------------
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

//公共部分！！！选择页面，上下页切换
    $(".page a").hover(
        function(){
            $(this).css("border-color","#21ace3")
        },
        function(){
            $(this).css("border-color","")
        }
    )
//动态改变背景图片，用在那些背景鼠标过去按钮原色变化的对象上
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
            // move('background','images/wm2.png','-220px')第一个是对象class属性，第二个是地址，第三个是雪碧图的Y值
































            //对象fade，添加一个功能，屏蔽按钮，显示产品即将推出
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
                    div_2.innerHTML = '<div class="modal_header"><a class="closed">×</a><h3>我们正在检测中</h3></div><p class="modal_body">即将推出，敬请期待...</p>';
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
            fade.init('store');
            fade.init('forum');
            fade.init('friends');
            if(document.getElementById('teach')){
                fade.init('teach');
            }

