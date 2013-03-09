$(function(){


//五六级商店页面底部共同部分
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
//五六级商店页面底部共同部分

	//广告增加效果
	$(".advert").mouseover(function(){
			var index = $(this).index() - 1;
			for(var i = 0;i < $(".advert").length;i++){
				if(i == index){
					$(".ba_color:eq("+i+")").fadeOut(500)
				}
				if(i != index){
					$(".ba_color:eq("+i+")").fadeIn(1000)
				}
			}
	})
	$(".md_right").mouseleave(function(){
		$(".advert .ba_color").fadeOut(500)
	})

	//点击切换TAB
	$(".lay_nav li").bind(
		'click',function(){
			var index = $(this).index();
			$(".lay_nav a").removeClass('underline').eq(index).addClass('underline')
			$(".md_left").removeClass('show_left').eq(index).addClass('show_left')
		}
	)


	//产品更多图片观看
	$(".more_pic").bind(
		'mouseover',function(){
			var src = $(this).children().attr("src")
			$(".show_food img").attr('src',src)
			if($(".more_pic").has('border_color')){	//增加有色边框
				$(".more_pic").removeClass('border_color')
			}
			$(this).addClass('border_color')	
		}
	)
	
	//放大镜
	$(".show_food").mouseleave(function(){  
        $(".small").css({"display":"none"});  
        $(".enlarge").css("display","none");  
    }).mousemove(function(e){  
        topset=$(this).offset().top;  
        leftset=$(this).offset().left;
        width = $(this).width()+5;
        height = $(this).height()+5;
        if(e.pageX<leftset+80){  
            LTX=leftset;  
        }
        else if(e.pageX>leftset+width-80)  
            LTX=leftset+width-160;  
        else  
            LTX=e.pageX-80;
        if(e.pageY<topset+80)  
            LTY=topset;  
        else if(e.pageY>topset+height-80)  
            LTY=topset+height-160;  
        else  
            LTY=e.pageY-80;

        $(".small").css({"top":LTY,"left":LTX,"display":"block"});
        position_x="-"+Math.round((LTX-leftset)*2)+"px";  
        position_y="-"+Math.round((LTY-topset)*6)+"px"; 
        $(".enlarge").css({"display":"block"});  
        $(".enlarge img").css({"top":position_y,"left":position_x});  
    });  
})

