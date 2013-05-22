var ajaxListKey=0;
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
var remove_event = function(element,type,handle){
	if(element.removeEventListener){
		element.removeEventListener(type,handle,false)
	}
	else if(element.detachEvent){
		element.detachEvent("on" + type,handle)
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
			if(obj_opacity > filter){
				var time = function(){
					setTimeout(function(){
						if(obj_opacity > filter){
							obj_opacity = (obj_opacity * 10 - 1)/10;
							obj.style.opacity = (parseFloat(obj.style.opacity) * 10 - 1)/10;
							if(document.all){
								value = parseFloat(value) - 10;
								obj.style.filter = 'alpha(opacity = '+value+')';
							}
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
							if(document.all){
								value = parseFloat(value) + 10;//将字符串转化为数字，使用的是parsefloat
								obj.style.filter = 'alpha(opacity = '+value+')';
							}
							time();
						}
					},speed)
				};
				time();
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
						// console.log(_target.parentNode.offsetLeft)
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
		login_Bg.style.visibility = 'visible';
		login_table.style.visibility = 'visible';
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
		aijianmei.opacity('login_bg',0,10);
		aijianmei.chang_top(login_table,1,294,10);
		login_Bg.style.visibility = 'hidden';
		login_table.style.visibility = 'hidden';
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
    	nav_child = newdom.getElementsByClass('nav_child'),
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
//for textarea write down text,show of obj show number
function change_num(obj,show){
	var newdom = new getdom,
		obj = newdom.getElementsByClass(obj),
	    len = obj.length,
	    show_num = newdom.getElementsByClass(show);
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
