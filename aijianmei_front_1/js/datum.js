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
        arr_weight = [40,55,70,85]
        div = [],
        dt_choice_year = newdom.getElementsByClass('dt_choice_year'),
        dt_choice_height = newdom.getElementsByClass('dt_choice_height'),
        dt_choice_weight = newdom.getElementsByClass('dt_choice_weight');

    // year
    for(var i = 1;i < len_dt_year - 1;i++){
        a_dt_year[i].index = i;
        for(var x = 0,y = 0;x < 15;x++){
            var  a = document.createElement('a');
            a.className = 'dt_year_target';
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
            a.className = 'dt_height_target';
            y = arr_height[i - 1] + x;
            a.innerHTML = y + 'cm';
            dt_choice_height[i - 1].appendChild(a);//add <a> to div
        }
        a_dt_height[i].onmouseover = function(){
            dt_choice_height[this.index - 1].style.display = 'block';
        }
        a_dt_height[i].onmouseout = function(){
            dt_choice_height[this.index - 1].style.display = 'none';
        }  
    }
    // weight
    for(var i = 1;i < len_dt_weight - 1;i++){
        a_dt_weight[i].index = i;
        for(var x = 0,y = 0;x < 15;x = x + 0.5){
            var  a = document.createElement('a');
            a.className = 'dt_weight_target';
            y = arr_weight[i - 1] + x;
            a.innerHTML = y + 'kg';
            dt_choice_weight[i - 1].appendChild(a);//add <a> to div
        }
        a_dt_weight[i].onmouseover = function(){
            dt_choice_weight[this.index - 1].style.display = 'block';
        }
        a_dt_weight[i].onmouseout = function(){
            dt_choice_weight[this.index - 1].style.display = 'none';
        }  
    } 
    //dt_year_target add click event
    var dt_year_target = newdom.getElementsByClass('dt_year_target'),
        len_year_target = dt_year_target.length,
        dt_year = newdom.getElementsByClass("dt_year")[0],
        dt_year_edit = newdom.getElementsByClass("dt_year_edit")[0],
        dt_year_finish = newdom.getElementsByClass("dt_year_finish")[0],
        dt_year_change = newdom.getElementsByClass("dt_year_change")[0],
        dt_year_target = newdom.getElementsByClass('dt_year_target'),
        dt_year_input = newdom.getElementsByClass("dt_year_input")[0],
        dt_year_write = newdom.getElementsByClass("dt_year_write")[0],
        //for height
        dt_height_target = newdom.getElementsByClass('dt_height_target'),
        len_height_target = dt_height_target.length,
        dt_height = newdom.getElementsByClass("dt_height")[0],
        dt_height_edit = newdom.getElementsByClass("dt_height_edit")[0],
        dt_height_finish = newdom.getElementsByClass("dt_height_finish")[0],
        dt_height_change = newdom.getElementsByClass("dt_height_change")[0],
        dt_height_input = newdom.getElementsByClass("dt_height_input")[0],
        dt_height_write = newdom.getElementsByClass("dt_height_write")[0],
         //for weight
        dt_weight_target = newdom.getElementsByClass('dt_weight_target'),
        len_weight_target = dt_weight_target.length,
        dt_weight = newdom.getElementsByClass("dt_weight")[0],
        dt_weight_edit = newdom.getElementsByClass("dt_weight_edit")[0],
        dt_weight_finish = newdom.getElementsByClass("dt_weight_finish")[0],
        dt_weight_change = newdom.getElementsByClass("dt_weight_change")[0],
        dt_weight_input = newdom.getElementsByClass("dt_weight_input")[0],
        dt_weight_write = newdom.getElementsByClass("dt_weight_write")[0];
    //act_change add click event
    var act_change = function(obj_1,obj_2,obj){
        if(obj){
            obj.onclick = function(){
                obj_1.style.display = "block";
                obj_2.style.display = "none";
            }
        }    
    }       
    //choice_this 
    //year_this&&year_input   
    var choice_year_this = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_year_finish.innerHTML = _target.innerHTML;
        dt_year.style.display = "none";
        dt_year_edit.style.display = "block";
        act_change(dt_year,dt_year_edit,dt_year_change);
        default_year = _target.index;
    }
    var choice_year_input = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_year_write.value = "";
        dt_year.style.display = "none";
        dt_year_input.style.display = "block";

        //for dt_year_write
        dt_year_write.focus();
        dt_year_write.onblur = function(){
            if(dt_year_write.value != ""){
                dt_year_finish.innerHTML = this.value + '岁';
                dt_year_edit.style.display = "block";
                dt_year_input.style.display = "none";
                act_change(dt_year,dt_year_edit,dt_year_change);
                default_year = _target.index;
                // console.log(default_weight)
            }   
            else{
               dt_year.style.display = "block";
               dt_year_input.style.display = "none"; 
            }
        }
    }
    //height_this&&height_input
    var choice_height_this = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_height_finish.innerHTML = _target.innerHTML;
        dt_height.style.display = "none";
        dt_height_edit.style.display = "block";
        act_change(dt_height,dt_height_edit,dt_height_change);
        default_height = _target.index;
    }
    var choice_height_input = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_height_write.value = "";
        dt_height.style.display = "none";
        dt_height_input.style.display = "block";

        //for dt_height_write
        dt_height_write.focus();
        dt_height_write.onblur = function(){
            if(dt_height_write.value != ""){
                dt_height_finish.innerHTML = this.value + 'cm';
                dt_height_edit.style.display = "block";
                dt_height_input.style.display = "none";
                act_change(dt_height,dt_height_edit,dt_height_change);
                default_height = _target.index;
                // console.log(default_weight)
            }  
            else{
               dt_height.style.display = "block";
               dt_height_input.style.display = "none"; 
            } 
        }
    }
    //weight_this&&weight_input
    var choice_weight_this = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_weight_finish.innerHTML = _target.innerHTML;
        dt_weight.style.display = "none";
        dt_weight_edit.style.display = "block";
        act_change(dt_weight,dt_weight_edit,dt_weight_change);
        default_weight = _target.index;
    }
    var choice_weight_input = function(e){
        var _e = window.event ? window.event : e || arguments[0],
            _target = _e.target ? _e.target : _e.srcElement;
        dt_weight_write.value = "";
        dt_weight.style.display = "none";
        dt_weight_input.style.display = "block";

        //for dt_weight_write
        dt_weight_write.focus();
        dt_weight_write.onblur = function(){
            if(dt_weight_write.value != ""){
                dt_weight_finish.innerHTML = this.value + 'kg';
                dt_weight_edit.style.display = "block";
                dt_weight_input.style.display = "none";
                act_change(dt_weight,dt_weight_edit,dt_weight_change);
                default_weight = _target.index;
                // console.log(default_weight)
            }  
            else{
               dt_weight.style.display = "block";
               dt_weight_input.style.display = "none"; 
            } 
        }
    }
    //year
    a_dt_year[0].index = 100;
    a_dt_year[len_dt_year - 1].index = 200;
    addevent(a_dt_year[0],'click',choice_year_input);
    addevent(a_dt_year[len_dt_year - 1],'click',choice_year_input);
    for(var i = 0;i < len_year_target;i++){
        dt_year_target[i].index = i;
        if(dt_year_target[i]){
            addevent(dt_year_target[i],'click',choice_year_this);
            if(default_year){
                if(default_year == 100){
                    a_dt_year[0].click();
                }
                else if(default_year == 200){
                    a_dt_year[len_dt_year - 1].click();
                }
                else{
                    dt_year_target[default_year].click();
                }
            }
        }   
    }
    //height
    a_dt_height[0].index = 100;
    a_dt_height[len_dt_height - 1].index = 200;
    addevent(a_dt_height[0],'click',choice_height_input);
    addevent(a_dt_height[len_dt_height - 1],'click',choice_height_input);
    for(var i = 0;i < len_height_target;i++){
        dt_height_target[i].index = i;
        if(dt_height_target[i]){
            addevent(dt_height_target[i],'click',choice_height_this);
            if(default_height){
                if(default_height == 100){
                    a_dt_height[0].click();
                }
                else if(default_height == 200){
                    a_dt_height[len_dt_height - 1].click();
                }
                else{
                    dt_height_target[default_height].click();
                }
            }
        }   
    }
    //weight
    a_dt_weight[0].index = 100;
    a_dt_weight[len_dt_weight - 1].index = 200;
    addevent(a_dt_weight[0],'click',choice_weight_input);
    addevent(a_dt_weight[len_dt_weight - 1],'click',choice_weight_input);
    for(var i = 0;i < len_weight_target;i++){
        dt_weight_target[i].index = i;
        if(dt_weight_target[i]){
            addevent(dt_weight_target[i],'click',choice_weight_this);
            if(default_weight){
                if(default_weight == 100){
                    a_dt_weight[0].click();
                }
                else if(default_weight == 200){
                    a_dt_weight[len_dt_weight - 1].click();
                }
                else{
                    dt_weight_target[default_weight].click();
                }
            }
        }   
    }

    //for keycode enter to dt_weight_height_year_input
    document.onkeydown = function(event){//回车事件触发onblur
        if(event.keyCode == 13){
            var activename = document.activeElement.id; // 当前获取焦点的对象
            if(activename == 'tag' || 'dt_year_write' || 'dt_height_write' || 'dt_weight_write'){
                document.getElementById(activename).blur();
            }
        }
    };

    // add tag
    var tag_id = newdom.Id('tag'),
        tag_class= newdom.getElementsByClass('tag')[0],
        dt_wrap_sure = newdom.getElementsByClass('dt_wrap_sure')[0],
        text = 'underfined',
        dt_sure_remove = newdom.getElementsByClass('dt_sure_remove');
    //     div = document.createElement('div'),
    //     text = '<span class="dt_sure_content">伟勉</span><span class="dt_sure_remove">×</span>>';
    // div.className = 'dt_sure';
    // div.innerHTML = text;
    tag_id.onfocus = function(){
        tag_class.style.display = "none";
    }
    tag_id.onblur = function(){
        if(tag_id.value != ""){
            //add dt_sure
            var div = document.createElement('div');
            text = '<span class="dt_sure_content">' + tag_id.value + '</span><span class="dt_sure_remove">×</span>';
            div.className = 'dt_sure';
            div.innerHTML = text;
            dt_wrap_sure.appendChild(div);
        }
            

        tag_id.value = "";
        tag_class.style.display = "block";

        // dt_sure_remove add click event
        dt_sure_remove = newdom.getElementsByClass('dt_sure_remove');
        if(dt_sure_remove){
            var len_dt_remove = dt_sure_remove.length;
            for(var i = 0;i < len_dt_remove;i++){
                dt_sure_remove[i].onclick = function(){
                    // this.parentNode.style.display = 'none';
                    dt_wrap_sure.removeChild(this.parentNode)
                }
            }
        }
    }
    // dt_sure_remove add click event
    if(dt_sure_remove){
        var len_dt_remove = dt_sure_remove.length;
        for(var i = 0;i < len_dt_remove;i++){
            dt_sure_remove[i].onclick = function(){
                // this.parentNode.style.display = 'none';
                dt_wrap_sure.removeChild(this.parentNode)
            }
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
