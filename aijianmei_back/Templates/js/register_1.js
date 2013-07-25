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
		var newdom = new getdom,
			rg_text_tip = newdom.getElementsByClass('rg_text_tip')[0],
			rg_password_tip = newdom.getElementsByClass('rg_password_tip')[0],
			rg_passwd_again = newdom.getElementsByClass('rg_passwd_again')[0];
		function fm_jugde(jugde_1,jugde_2,jugde_3){
			var judge_1 = /^[^ ]{6,16}$/,
				judge_2 = /^\d{1,8}$/,
				judge_3 = /^\d{9,16}$/,
				judge_4 = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/,
				judge_5 = /^[a-zA-Z]{6,16}$/,
				id_jd = [],
				jd = [],
				argument_len = arguments.length,
				txt = newdom.Id('text'),
				passwd = newdom.Id('password'),
				passwd_again = newdom.Id('password_again');
			for(var i = 0;i < argument_len;i++){
				id_jd[i] = newdom.Id(arguments[i]);
				jd[i] = newdom.getElementsByClass(arguments[i])[0];
			}
			jd_len = id_jd.length;
			for(var i = 0;i < jd_len;i++){
				if(id_jd[i]){
					id_jd[i].index = i;
					id_jd[i].onfocus = function(){
						jd[this.index].style.display = 'none';
						if(this.index == 1){
							rg_password_tip.style.color = '#21ace3';
							rg_password_tip.innerHTML = '请输入密码';
						}
						if(this.index == 2 && passwd.value == ""){
							rg_passwd_again.style.color = '#c00000';
							rg_passwd_again.innerHTML = '密码为空,请先输入密码';
						}
					}
					id_jd[i].onblur = function(){
						if(id_jd[this.index].value == ""){
							jd[this.index].style.display = 'block';
							if(this.index == 1){
								rg_password_tip.style.color = '#c00000';
								rg_password_tip.innerHTML = '密码不能为空';
							}
							if(this.index == 2){
								rg_passwd_again.style.color = '#c00000';
								rg_passwd_again.innerHTML = '请再次输入密码';
							}	
						}
						else{
							if(this.index == 1){
								if(passwd.value.length < 6 || passwd.value.length > 16 || judge_1.test(passwd.value) == false || judge_2.test(passwd.value) == true){
									rg_password_tip.style.color = '#c00000';
									rg_password_tip.innerHTML = '您的密码格式不正确';
								}
							}
							if(passwd.value.length >= '9' && passwd.value.length <= '16' && judge_3.test(passwd.value) == true){
								rg_password_tip.style.color = '#21ace3';
								rg_password_tip.innerHTML = '您的密码可以再复杂一点';
							}
							if(passwd.value.length >= '6' && passwd.value.length <= '16' && judge_4.test(passwd.value) == true || judge_5.test(passwd.value) == true){
								rg_password_tip.style.color = '#21ace3';
								rg_password_tip.innerHTML = '您的密码很安全';
							}
							// else{
							// 	rg_password_tip.innerHTML = '您的密码很安全';
							// }
							if(this.index == 2 && passwd.value != passwd_again.value){
								rg_passwd_again.style.color = '#c00000';
								rg_passwd_again.innerHTML = '两次密码输入不一致';
							}
							if(this.index == 2 && passwd.value == passwd_again.value){
								rg_passwd_again.style.color = '#21ace3';
								rg_passwd_again.innerHTML = '密码一致';
							}
						}
					}
				}		
			}
		}
		fm_jugde('text','password','password_again');