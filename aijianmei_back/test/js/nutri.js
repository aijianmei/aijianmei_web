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
})