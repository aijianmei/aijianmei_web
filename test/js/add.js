$(function(){
	//为文章模块添加动态边框效果
	$(".article").hover(
		function(){
			var index = $(this).index();
			$(this).css({'border':'2px solid #D273FF','background':'#D0F6FF'})
		},
		function(){
			var index = $(this).index();
			$(this).css({'border':'2px solid #ccc','background':''})
		}
	)


	//为了add_1增加jq
		//tab键切换
		$(".tab_mune li").mouseover(function(){
			var index = $(this).index()
			$(".tab_mune li").removeClass("add").eq(index).addClass("add");
			$(".ct").addClass("none").eq(index).removeClass("none")
		})

		//点击图片，呈现图片相应的tab
		$(".each_pic").click(function(){
			var index = $(this).parent().index() + 1;
			$(".tab_mune li").removeClass("add").eq(index).addClass("add");
			$(".ct").addClass("none").eq(index).removeClass("none")
		})
})