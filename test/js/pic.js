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
