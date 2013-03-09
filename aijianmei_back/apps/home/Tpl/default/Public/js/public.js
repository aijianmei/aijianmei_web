$(function(){
	$("#login").click(function(){
		$("div.body").slideDown(300,function(){
			$("body").css("overflow","hidden").height("100%");
			$(this).css("display","block");
			$("div.sheet").css("display","block");
		});
	});
	$(".close_btn").click(function(){
		$("body").css("overflow","visible");
		$("div.sheet").slideUp(300,function(){
		$("div.sheet").css("display","none");
		$("div.body").css("display","none");
		});
	});
	
	$(".ai_account input").focus(function(){
		$(this).val(null).siblings().hide();			
	});
	$(".ai_account input").blur(function(){
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
					
})



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
		$("#banner .ul_2 li").css("border","3px solid transparent").eq(index).css("border","3px solid yellow");
	}

	//透明效果
	$("#banner .ul_1 .massage").hover(
		function(){
			$(this).css("opacity","0.6")
		},
		function(){
			$(this).css("opacity","0.3")
		}
	)
})

$(function(){
	$("#login").click(function(){
		$("div.body").slideDown(300,function(){
			$("body").css("overflow","hidden").height("100%");
			$(this).css("display","block");
			$("div.sheet").css("display","block");
		});
	});
	$(".close_btn").click(function(){
		$("body").css("overflow","visible");
		$("div.sheet").slideUp(300,function(){
		$("div.sheet").css("display","none");
		$("div.body").css("display","none");
		});
	});
	
	$(".ai_account input").focus(function(){
		$(this).val(null).siblings().hide();			
	});
	$(".ai_account input").blur(function(){
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
	
//导航栏样式改变	
	$("#nav").children().click(function(){
		if(!($(this).hasClass("home"))){
			$(this).css("background","#2E6A92")
		}
		$(this).siblings().css("background","");
	})
		
					
})



//js for border
			// var addevent = function(element,type,handle){
			// 	if(element.addEventListener){
			// 		element.addEventListener(type,handle,false)
			// 	}
			// 	if(element.attachEvent){
			// 		element.attachEvent("on" + type,handle)
			// 	} 
			// }
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
			}

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
			// var changebutton = function(obj,url,num){

			// 	var newdom = new getdom,
			// 		id = newdom.getElementsByClass(obj),
			// 		image = id.style.backgroundImage;
			// 		var currentpositionY = id.style.backgroundPositionY;
			// 	id.onmouseover = function(){
			// 		if(num != null){
			// 			this.style.background = 'url('+url+')';
			// 			this.style.backgroundPositionX = '0px';
			// 			this.style.backgroundPositionY = num;
						
			// 		}					
			// 		else{
			// 			this.style.background = 'url('+url+')';
			// 		}
			// 		// console.log(this.style.backgroundPosition)			
			// 	}
			// 	id.onmouseout = function(){
			// 		this.style.backgroundImage = image;
			// 		this.style.backgroundPositionX = '0px'
			// 		this.style.backgroundPositionY = currentpositionY;
			// 	}
			// }
