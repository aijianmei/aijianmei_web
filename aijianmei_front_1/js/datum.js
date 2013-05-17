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
    }
}
var init = function(){
    var newdom = new getdom,
        nav_child = newdom.getElementsByClass('nav_child'),
        len_1 = nav_child.length,
        dt_year = newdom.getElementsByClass('dt_year')[0],
        dt_height = newdom.getElementsByClass('dt_height')[0],
        dt_weight = newdom.getElementsByClass('dt_weight')[0],
        a_dt_year = dt_year.children,
        a_dt_height = dt_height.children,
        a_dt_weight = dt_weight.children,
        len_dt_year = a_dt_year.length,
        len_dt_height = a_dt_height.length,
        len_dt_weight = a_dt_weight.length,
        arr_year = [10,25,40,55],
        arr_height = [140,155,170,185],
        div = [],
        dt_choice_year = newdom.getElementsByClass('dt_choice_year'),
        dt_choice_height = newdom.getElementsByClass('dt_choice_height');

    // year
    for(var i = 1;i < len_dt_year - 1;i++){
        a_dt_year[i].index = i;
        for(var x = 0,y = 0;x < 15;x++){
            var  a = document.createElement('a');
            a.className = 'dt_target';
            y = arr_year[i - 1] + x;
            a.innerHTML = y + '岁';
            dt_choice_year[i - 1].appendChild(a);//add <a> to div
        }
        a_dt_year[i].onmouseover = function(){
            dt_choice_year[this.index - 1].style.display = 'block';
        }
        a_dt_year[i].onmouseout = function(){
            dt_choice_year[this.index - 1].style.display = 'none';
        }  
    } 
    // height
    for(var i = 1;i < len_dt_height - 1;i++){
        a_dt_height[i].index = i;
        for(var x = 0,y = 0;x < 15;x++){
            var  a = document.createElement('a');
            a.className = 'dt_target';
            y = arr_height[i - 1] + x;
            a.innerHTML = y + '岁';
            dt_choice_height[i - 1].appendChild(a);//add <a> to div
        }
        a_dt_height[i].onmouseover = function(){
            dt_choice_height[this.index - 1].style.display = 'block';
        }
        a_dt_height[i].onmouseout = function(){
            dt_choice_height[this.index - 1].style.display = 'none';
        }  
    }
    //dt_target add click event
    var dt_target = newdom.getElementsByClass('dt_target'),
        len_dt_target = dt_target.length,
        dt_year = newdom.getElementsByClass("dt_year")[0],
        dt_year_edit = newdom.getElementsByClass("dt_year_edit")[0],
        dt_year_finish = newdom.getElementsByClass("dt_year_finish")[0],
        dt_year_change = newdom.getElementsByClass("dt_year_change")[0];
    //act_change add click event
    var act_change = function(){
        if(dt_year_change){
            dt_year_change.onclick = function(){
                dt_year.style.display = "block";
                dt_year_edit.style.display = "none";
            }
        }    
    }       
    //choice_this    
    var choice_this = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_year_finish.innerHTML = _target.innerHTML;
        dt_year.style.display = "none";
        dt_year_edit.style.display = "block";
        act_change();
    }
    for(var i = 0;i < len_dt_target;i++){
        if(dt_target[i]){
            addevent(dt_target[i],'click',choice_this)
        }   
    }






    // head
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
}
init(); 