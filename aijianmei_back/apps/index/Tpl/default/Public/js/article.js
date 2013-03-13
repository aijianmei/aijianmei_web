$(function(){
	//页面选择
	$(".lay_page a").click(function(){
		$(".lay_page a").removeClass("choice_page")
		$(this).addClass("choice_page")
		if($(".lay_page a").index(this) == 0){
			$(".pre_page").css({'color':'#ccc'})
		}
		else{
			$(".pre_page").css({'color':'#656565','cursor':'pointer'})
		}
		if($(".lay_page a").index(this) == 4){
			$(".next_page").css({'color':'#ccc','cursor':'default'})
		}
		else{
			$(".next_page").css({'color':'#656565'})
		}
	})

	//下一页、上一页//4==$(".tab_2 .lay_page a").length-1
	$(".next_page").click(function(){
		var index = $(".choice_page").index();
		if(index != 4){
			index++;
			$(".pre_page").css({'color':'#656565','cursor':'pointer'})
			$(".lay_page a").removeClass("choice_page")
			$(".lay_page a").eq(index).addClass("choice_page")
		}
		if(index == 4){
			$(".next_page").css({'color':'#ccc','cursor':'default'})
		}
	})
	$(".pre_page").click(function(){
		var index = $(".choice_page").index();
		if(index != 0){
			index--;
			$(".next_page").css({'color':'#656565','cursor':'pointer'})
			$(".lay_page a").removeClass("choice_page")
			$(".lay_page a").eq(index).addClass("choice_page")
		}
		if(index == 0){
			$(".pre_page").css({'color':'#ccc','cursor':'default'})
		}
	})

	//全部评论
	$(".comment_1").click(
		function(){
			$(".comment_2").removeClass("comment_3")
			$(this).addClass("comment_3")
			$(".tab_1").css("display","block")
			$(".tab_2").css("display","none")
		}
	)
	$(".comment_2").click(
		function(){
			$(".comment_1").removeClass("comment_3")
			$(this).addClass("comment_3")
			$(".tab_2").css("display","block")
			$(".tab_1").css("display","none")
		}
	)

	//praise
	$(".sprite_8").add(".sprite_9").click(function(){
		var time = parseInt($(this).children().text());
		time++;
		$(this).children().html(time)
	})

	//页面下拉列表
	$(".read_time").hover(
		function(){
			$(".page_times").css("display","block")
		},
		function(){
			$(".page_times").css("display","none")
		}
	)

	//textarea focus()
	$(".comment_inp").click(function(){
		$(this).html("");
	})
	
	//提示登录
	$("#not_login").click(function(){
		$("div.sheet").show(function(){
			$("#login").css("display","block");
			$(".sheet").css("top", document.body.scrollTop);
			$(".log").css("border-radius","10px");
			$("div.sheet").css("display","block");
			console.log($(document.body.scrollTop));
		});
	})
	$(".close_btn").click(function(){
		$("body").css("overflow","visible");
		$(".sheet").css("top",0);
	});

	
})


// var today = function(){
	// var time = document.getElementsByClassName("time")[0],
		// date = new Date();
		// time.innerHTML = [date.getFullYear(),'-',date.getMonth(),'-',date.getDate(),"&nbsp;&nbsp;",date.toLocaleTimeString()].join("");
// }
// setInterval('today()',1000);
