$(function(){
	//全局变量
	var num_2 = 1,
		num_3 = 2,
		num_4 = 3;
	

	//没有通过协议不能开通
	
	
	$(".protect_box").click(function(){
		if(num_2 == 22 && num_3 == 33 && num_4 == 44){
			if($(".protect_box").attr("checked") == undefined){
				$(".submit_1").removeClass("submit_2")
				$(".submit_1").mouseover(function(){
					$(".open").css("background","gray")
				})
			}
			if($(".protect_box").attr("checked") != undefined){
				$(".submit_1").addClass("submit_2")
				$(".submit_1").hover(
					function(){
						$(".open").css("background","#75c400")
					},
					function(){
						$(".open").css("background","")
					}
				)	
			}
		}
	})



	//点击登录

	$(".loginbutton").mousedown(function(){
		$(".loginbutton").css("background","#79CA00")
	}).mouseup(function(){
		$(".loginbutton").css("background","")
	})


	// //判断邮箱
	// $("#text_1").focus(function(){
	// 	$(".prompt_box_1").html("<p>请输入邮箱</p>")
	// }).blur(function(){
	// 	if($("#text_1").val() == ""){
	// 		$(".prompt_box_1").html("<span>邮箱输入不能为零</span>")
	// 		num_1 = 1;
	// 	}
	// 	else{
	// 		var judge = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
	// 		if(judge.test($("#text_1").val()) == false){
	// 			$(".prompt_box_1").html("<span>邮箱格式错误</span>")
	// 			num_1 = 1;
				
	// 		}
	// 		if(judge.test($("#text_1").val()) == true){
	// 			$(".prompt_box_1").html("<p>邮箱格式正确</p>")
	// 			num_1 = 11;
	// 		}

	// 	}
	// })
	

	//判断密码是否正确
	$("#text_2").focus(function(){

		$(".prompt_box_2").html('<p><span class="w_s"></span> 长度为6~16个字符</p><p><span class="w_s"></span> 不能包括空格</p><p><span class="w_s"></span> 不能是9个以下的纯数字</p>')
	}).blur(function(){
		if($("#text_2").val() == ""){
			$(".prompt_box_2").html('<span class="rank">密码输入不能为零</span>')
			num_2 = 2;
		}
		if($("#text_2").val() != ""){
			var judge_1 = /^[^ ]{6,16}$/,
				judge_2 = /^\d{1,8}$/,
				judge_3 = /^\d{9,16}$/,
				judge_4 = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/,
				judge_5 = /^[a-zA-Z]{6,16}$/;
			if($("#text_2").val().length < '6' || $("#text_2").val().length > '16' || judge_1.test($("#text_2").val()) == false || judge_2.test($("#text_2").val()) == true){
				$(".prompt_box_2").html('<span class="error_form">输入格式不正确</span>')
				num_2 = 2;
			}
			if($("#text_2").val().length >= '9' && $("#text_2").val().length <= '16' && judge_3.test($("#text_2").val()) == true){
				$(".prompt_box_2").html('<span class="rank">安全等级: 弱</span>')
				num_2 = 22;
			}
			if($("#text_2").val().length >= '6' && $("#text_2").val().length <= '16' && judge_4.test($("#text_2").val()) == true || judge_5.test($("#text_2").val()) == true){
				$(".prompt_box_2").html('<span class="rank">安全等级: 中</span>')
				num_2 = 22;
			}
		}
	})
	
	//再次输入密码
	$("#text_3").focus(function(){
		if($("#text_2").val() == ""){
			$(".prompt_box_3").html('<span>密码为空，请先输入密码<span>')
			num_3 = 3;
		}
	}).blur(function(){
		if($("#text_3").val() != $("#text_2").val()){
			$(".prompt_box_3").html('<span style="color:red;">密码不一致<span>')
			num_3 = 3;
		}
		else{
			$(".prompt_box_3").html("")
			num_3 = 33;
		}

	})

	//输入昵称
	$("#text_4").focus(function(){
		$(".prompt_box_4").html('<span>请输入您的昵称</span>')
	}).blur(function(){
		if($("#text_4").val() == ""){
			$(".prompt_box_4").html('<span style="color:red;">昵称不能为零</span>')
			num_4 = 4;
		}
		else{
			$(".prompt_box_4").html('')
			num_4 = 44;
		}
	})


	
})