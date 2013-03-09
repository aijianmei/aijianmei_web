$(function(){
	//验证码获取焦点
	$(".show").click(function(){
		$("#text_2").focus()
	})
	$("#text_2").focus(function(){
  				if($("#text_2").val() == ""){
	   				$(".show").css("color","#E2E2E2");
   				}
  	});
  	$("#text_2").keydown(function(){
   		$(".show").hide();
  	});
  	$("#text_2").blur(function(){
   		if($("#text_2").val() == ""){
   			$(".show").show();
   			$(".show").css("color","#ccc");
   		}
 	});
})