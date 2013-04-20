		
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
  			$(".password").keydown(function(){
   				$(".label_2").hide();
  			});
  			$(".password").blur(function(){
  				if($(".password").val() != ""){
   					$(".password").css("box-shadow","");
   				}
   				if($(".password").val() == ""){
   					$(".password").css("box-shadow","");
   					$(".label_2").show();
   					$(".label_2").css("color","#ACACAC");
   				}
 			});


  			//获取焦点
 			$(".label_1").click(function(){
 				$(".login_email").focus()
 			});
 			$(".label_2").click(function(){
 				$(".password").focus()
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
	});
})




