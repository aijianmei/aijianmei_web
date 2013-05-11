$(function(){
	//the covers over the pictures
	$("div.plan_item").bind({
		mouseleave: function(){
			$(this).find(".plan_cover").slideDown(300);
		},
		mouseenter: function(){
			$(this).find("div.plan_cover").slideUp(300);
		}
	});
	//textarea 
	$("textarea#user").bind({
		focusin: function(){
			$(this).next().hide();
			console.log("sfsadf");
		},
		focusout: function(){
			$(this).next().show();
		}
	});
});