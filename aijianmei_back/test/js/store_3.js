$(function(){
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
	//为商品文章分类添加动态边框
	$(".article").hover(
		function(){
			var index = $(".article").index(this);
			$(this).css({'border':'3px solid #ABC3FF','background':'#ddd'})
			$(".article .title_3").eq(index).css('color','#0081BE')
		},
		function(){
			var index = $(".article").index(this);
			$(this).css({'border':'3px solid transparent','background':''})
			$(".article .title_3").eq(index).css('color','')
		}
	)
})