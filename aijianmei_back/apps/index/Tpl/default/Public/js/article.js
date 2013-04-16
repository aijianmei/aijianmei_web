$(function(){

    //praise
    $(".sprite_8").click(function(){
        if($("#articleid").attr("uid")>0){
            var time = parseInt($(this).children().text());
            time++;
            $.ajax({
            type: "POST",
            url: "ajax.php",
            dataType:"json",
            data: "act=senLike&data=ford&mid="+$("#articleid").attr("uid")+"&articleid="+$("#articleid").val()+"&ptype=like&tname="+$("#articleid").attr("tname"),
            success: function(res){
                if(res==1){
                    $("#sprite_8_num").html(time);
                    alert('投票成功!');
                    }else{
                        alert('你已经投过票了!');
                    }
            }
            });
        }
        else{
            alert("请先登录");
        }
    })
        $(".sprite_9").click(function(){
        if($("#articleid").attr("uid")>0){
            var time = parseInt($(this).children().text());
            time++;
            $.ajax({
            type: "POST",
            url: "ajax.php",
            dataType:"json",
            data: "act=senLike&data=ford&mid="+$("#articleid").attr("uid")+"&articleid="+$("#articleid").val()+"&ptype=unlike&tname="+$("#articleid").attr("tname"),
            success: function(res){
                if(res==1){
                    $("#sprite_9_num").html(time);
                    alert('投票成功!');
                    }else{
                        alert('你已经投过票了!');
                    }
            }
            });
        }
        else{
            alert("请先登录");
        }
    })


    //textarea focus()
    $(".comment_inp").click(function(){
        $(this).html("");
    })
    
    //提示登录
    $("#not_login").click(function(){
        $("div.sheet").show(function(){
            $("#login").css("display","block");
            $(".sheet").css("top", document.body.scrollTop);
            $(".log").css("border-radius","10px");
            $("div.sheet").css("display","block");
            
        });
        console.log(document.body.scrollTop);
    })
    $(".close_btn").click(function(){
        $("body").css("overflow","visible");
        $(".sheet").css("top",0);
    });

    
})

// move('sure_button','../images/icon_result.png','-256px');