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
                        var top = window.ActiveXObject ? document.documentElement.scrollTop : document.body.scrollTop || window.pageYOffset;
                        // if(window.ActiveXObject){
                        //     var top = document.documentElement.scrollTop;
                        // }

                        if(top >= 50){
                            obj.className = 'header p_fixed';
                        }
                        else{
                            obj.className = 'header'
                        }
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
                var newdom = new getdom,
                    header = newdom.getElementsByClass('header')[0],
                    login = newdom.getElementsByClass('login')[0],
                    body_1 = newdom.getElementsByClass('body')[0];
                aijianmei.p_fixed(header);
                login.onclick = function(){
                    body_1.style.display = 'block';
                    aijianmei.opacity('body',0.7,10);
                }
                // aijianmei
            }
            init();


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
            if(newdom.getElementsByClass('my_cart')[0]){
                fade.init('my_cart');
            }
            if(document.getElementById('teach')){
                fade.init('teach');
            }

