$(function(){

	//praise
	$(".sprite_8").add(".sprite_9").click(function(){
		var time = parseInt($(this).children().text());
		time++;
		$(this).children().html(time)
	})

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
			
		});
		console.log(document.body.scrollTop);
	})
	$(".close_btn").click(function(){
		$("body").css("overflow","visible");
		$(".sheet").css("top",0);
	});

	//消除没有人评论提示文本
	var removetext = function(){
		var newdom = new getdom,
			empty_content = newdom.getElementsByClass("empty_content")[0];
			empty_content.parentNode.style.color = 'blue'
			// alert(empty_content.nextSibling.innerHTML)
			if(empty_content.nextSibling.className != null){
				empty_content.style.display = 'none';
			}
	}
	removetext();
	
})

