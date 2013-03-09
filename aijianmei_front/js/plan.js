$(function(){
			
	$(".options>a").click(function(){
	
		var that = this;
		
		$(this).closest("li .options").css("display","none");
		$(this).closest("li").removeClass("current").addClass("pass");
		//$(".pass .options").removeClass("select");
		$(this).closest("li").animate({"width":"30"},150,function(){
		
			$(this).next().animate({"width":"415"},250);
			$(this).next().addClass("current");
			
			var $id = that.className;
						
			$(this).next().children().each(function(){
				
				if($(this).attr("id") == $id){
					
					$(this).addClass("select").css("display","inline-block");
					$(this).siblings().removeClass("select");
				}	
			});							
		});
	});
	
	$("div.opt").click(function(){
	
		var $parent = $(this).parent()[0];
		
			if($($parent).hasClass("pass")){
				$(".current").animate({"width":"30"},150);
				$(".current .select").css("display","none");
				
				$($parent).animate({"width":"415"},250);
				$($parent).addClass("current").siblings().removeClass("current");
				$(".current").css("display","block").removeClass("pass");
				
				$(".current .select").css("display","inline-block");
				//console.log($(".current .select"))
				
			}
	})
	
	
});