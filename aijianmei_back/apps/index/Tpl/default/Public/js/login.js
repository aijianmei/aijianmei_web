		
		$(function(){
			// jquery for the first input
  			$(".login_email").focus(function(){
  				if($(".login_email").val() == ""){
	   				$(".login_email").css("box-shadow","0px 0px 7px red");
	   				$(".label_1").css("color","#ccc");
   				}
   				if($(".login_email").val() != ""){
	   				$(".login_email").css("box-shadow","0px 0px 7px red");
   				}
  			});
  			$(".login_email").keydown(function(){
   				$(".label_1").hide();
  			});
  			$(".login_email").blur(function(){
  				if($(".login_email").val() != ""){
   					$(".login_email").css("box-shadow","");
   				}
   				if($(".login_email").val() == ""){
   					$(".login_email").css("box-shadow","");
   					$(".label_1").show();
   					$(".label_1").css("color","#ACACAC");
   				}
 			});



			// jquery for the second input
  			$(".password").focus(function(){
  				if($(".password").val() == ""){
	   				$(".password").css("box-shadow","0px 0px 7px red");
	   				$(".label_2").css("color","#ccc");
   				}
   				if($(".password").val() != ""){
	   				$(".password").css("box-shadow","0px 0px 7px red");
   				}
  			});
			
			$(".passwordlib").focus(function(){
  				if($(".passwordlib").val() == ""){
	   				$(".passwordlib").css("box-shadow","0px 0px 7px red");
	   				$(".label_3").css("color","#ccc");
   				}
   				if($(".passwordlib").val() != ""){
	   				$(".passwordlib").css("box-shadow","0px 0px 7px red");
   				}
  			});
			
			$(".rpasswordlib").focus(function(){
  				if($(".rpasswordlib").val() == ""){
	   				$(".rpasswordlib").css("box-shadow","0px 0px 7px red");
	   				$(".label_4").css("color","#ccc");
   				}
   				if($(".rpasswordlib").val() != ""){
	   				$(".rpasswordlib").css("box-shadow","0px 0px 7px red");
	   				$(".rpasswordlib").css("box-shadow","0px 0px 7px red");
   				}
  			});
						
			$(".email").focus(function(){
  				if($(".email").val() == ""){
	   				$(".email").css("box-shadow","0px 0px 7px red");
	   				$(".label_2").css("color","#ccc");
   				}
   				if($(".email").val() != ""){
	   				$(".email").css("box-shadow","0px 0px 7px red");
	   				$(".email").css("box-shadow","0px 0px 7px red");
   				}
  			});
			
			
  			$(".email").keydown(function(){
   				$(".label_2").hide();
  			});
  			$(".email").blur(function(){
  				if($(".email").val() != ""){
   					$(".email").css("box-shadow","");
   				}
   				if($(".email").val() == ""){
   					$(".email").css("box-shadow","");
   					$(".label_2").show();
   					$(".label_2").css("color","#ACACAC");
   				}
 			});			
			
			
			
  			$(".passwordlib").keydown(function(){
   				$(".label_3").hide();
  			});
  			$(".passwordlib").blur(function(){
  				if($(".passwordlib").val() != ""){
   					$(".passwordlib").css("box-shadow","");
   				}
   				if($(".passwordlib").val() == ""){
   					$(".passwordlib").css("box-shadow","");
   					$(".label_3").show();
   					$(".label_3").css("color","#ACACAC");
   				}
 			});
			
  			$(".rpasswordlib").keydown(function(){
   				$(".label_4").hide();
  			});
  			$(".rpasswordlib").blur(function(){
  				if($(".rpasswordlib").val() != ""){
   					$(".rpasswordlib").css("box-shadow","");
   				}
   				if($(".email").val() == ""){
   					$(".email").css("box-shadow","");
   					$(".label_4").show();
   					$(".label_4").css("color","#ACACAC");
   				}
 			});			
			
			
			
			
			

  			//获取焦点
 			$(".label_1").click(function(){
 				$(".login_email").focus()
 			});
 			$(".label_2").click(function(){
 				$(".email").focus()
 			});
			$(".label_3").click(function(){
 				$(".passwordlib").focus()
 			});
			$(".label_4").click(function(){
 				$(".rpasswordlib").focus()
 			});
 			window.onload = function(){
				$(".login_email").focus()
			}

      //通过协议
      $(".protect_box").click(function(){
        if($(".protect_box").attr("checked") == undefined){
          $(".loginbutton").css("background","gray")
        }
        if($(".protect_box").attr("checked") != undefined){
          $(".loginbutton").css("background","#21ace3")
        }
      })
		});
		
		
//Add style in LoginNxet page of user check.

$(function(){
	$(".cover").mouseover(function(){
			$(this).children(".check").css("background","url(images/login/cover.png) no-repeat");
			$(this).mouseout(function(){
				$(this).children(".check").css("background","none");
			});
	});
	$(".item").click(function(){
		$(this).children(".cover").children("span:last").toggleClass("hasCheck");
		//add js获取选项对应值 kon 0421 start
		lid=$(this).attr("atid");
		if($(this).children(".cover").children("span:last").attr("class")=='hasCheck'){
			$("#CheckVal"+lid).val('1');
		}else{
			$("#CheckVal"+lid).val('0');
		}
		//}}}end
	});
})




