$(function(){
	//微博、爱问、预约
	$(".select").click(function(){
		var _index = $(this).index();
		var Py = -44 * _index;
		$(this).parent().css("background-position-y",Py);
		if(_index == 2 | _index == 1){
			$("#enter").css("margin-top","53px");
			$(".dialog").show();							
		}
		else{
			$(".dialog").hide();
			$("#enter").css("margin-top","0px");
		}
	});
	//广告
	$(".close_ad").click(function(){
		$(this).parent().hide("slow");
	});
	//选择日期
	$( "#datepicker" ).datepicker();
	//选择时间
	$(".timepicker").focus(function(){
		$(this).addClass("focus").siblings().removeClass("focus");
		if($(this).attr("id") == "start_time"){
			$(".tp").css("left","197px");
		}
		else{
			$(".tp").css("left","352px");
		}
		$(".tp").show(150);
		$(".hours").click(function(){
			var time = $(this).text();
			var that = $(".dl_time").find("input.focus");
			$(that).val(time);
			$(".tp").hide(150);
		});		
	});
	//评论
	$(".comment").click(function(){
		$(".func1").slideToggle("fast");
	})
	//收藏
	$(".collect,.close_sc").click(function(){
		$(".func2").slideToggle("fast");
	});
	//转发
	$(".transmit").click(function(){
		$(".func3").show();
		$(".covering").css("display","block");
	});
	$(".close_zf").click(function(){
		$(".func3").hide();
		$(".covering").css("display","none");
	})

	
})


var posX;    
var posY;    
var popDiv;    
var dragable;    
function down(e){    
     popDiv = document.getElementById("pop-editor");    
     e = e || window.event; //如果是IE    
     posX = e.clientX - parseInt(popDiv.style.left);       
     posY = e.clientY - parseInt(popDiv.style.top);    
     dragable = true;    
     document.onmousemove = move;    
}    
   
function move(ev){    
    if(dragable == true){    
         ev = ev || window.event;//如果是IE    
         popDiv.style.left = (ev.clientX - posX) + "px";       
         popDiv.style.top = (ev.clientY - posY) + "px";       
     }    
}    
   
function up(){    
     dragable = false;    
}   












