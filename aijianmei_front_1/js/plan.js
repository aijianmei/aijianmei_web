$(function(){
	//the covers over the pictures
	$("div.plan_item,li.article_item").bind({
		mouseleave: function(){
			$(this).find(".cover_cont").slideDown(300);
			$(this).find(".plan_cover").slideDown(300);			
		},
		mouseenter: function(){
			$(this).find(".cover_cont").slideUp(300);
			$(this).find("div.plan_cover").slideUp(300);			
		}
	});
	//textarea 
	$("textarea#user").bind({
		focusin: function(){
			$(this).next().hide();
		},
		focusout: function(){
			$(this).next().show();
		}
	});
	//天天锻炼页面“查看”按钮
	$(".groups").find("li.acts").bind({
		mouseleave : function(){
			$(this).find(".intoBtn").hide();
			console.log("dfds")
		},
		mouseenter : function(){
			$(this).find(".intoBtn").show();
		}
	});
	//天天锻炼页面
	$(".dailyTop").find("li").last().css("margin-right","0px");
	
});