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
    	var tab_move = function(e){
    		var _e = window.event ? window.event : e || arguments[0],
    			_target = _e.target ? _e.target : _e.srcElement;
    		for(var i = 0;i < child_len;i++){
    			if(obj_child[i] == _target){
    				obj_child[i].className = class_1;
    				tab_content[i].className = obj_2 + class_2;
    			}
    			else{
    				obj_child[i].className = '';
    				tab_content[i].className = obj_2;
    			}
    		}
    	}
    	if(tab_obj){
    		addevent(tab_obj,'click',tab_move);
    	}
    },
    hover : function(obj_1,obj_2){
    	var obj = aijianmei.getobj(obj_1),
    		show_obj = aijianmei.getobj(obj_2);
    	var show = function(){
    		show_obj.style.display = "block";
    	}
    	var hidden = function(){
    		show_obj.style.display = "none";
    	}
    	if(obj){
    		addevent(obj,'mouseover',show);
    		addevent(obj,'mouseout',hidden)
    	}
    },
    opacity : function(obj,filter,speed){
		var newdom = new getdom,
			obj = newdom.getElementsByClass(obj)[0],
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
	}
}
var init = function(){
    var newdom = new getdom;
    aijianmei.hover('more','account')
}
init();	