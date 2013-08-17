//weight
var actionVal='';
var changeWeight = function(input, show){

	$(".weiSaveBtn").click(function(){
		var innerVal = $(input).val();		
		innerVal += "kg";
		$(show).find(".innerText").text(innerVal);
		
		progress();
	});
	//计算进度条长度
	var progress = function(){
		var goal = $("#goalW").val(),//目标的数值
			cur = $("#curW").val(),//当前数值
			init = $("#initW").val(),//原始数值
			allPro = Math.abs(init - goal),
			nowPro =Math.abs(cur - goal),
			percentage = nowPro / allPro * 100;
			
			/* add by kontem 20130808 start*/
			if(goal*1 > init*1){//目标数值大于原始值 增重
				if(cur*1 < init*1){//当前数值 < 原始数值 无用功直接 0%
					percentage="0%";
				}else{//否则计算对应完成度的百分比
					percentage = (cur-init) / (goal-init) * 100;
				}
				if(cur*1>goal*1){//当前数值>目标的数值 则目标已经超标完成 直接是100%
					percentage=100;
				}
			}else{//目标数值大于原始值 减肥
				if(cur*1 < init*1 && cur*1>goal*1){//当前数值 < 原始数值  并且大于目标值 则 减肥有效果 仍需继续努力
					percentage = (init-cur) / (init-goal) * 100;
				}else if(cur*1 < init*1 && cur*1<goal*1 ){ //当前数值 小于原始值 并且小于目标值 减肥完美超额完成...估计要增肥了
					percentage = 100;//完成度自然100..
				}else if(cur*1>init*1){//当前数值 > 原始数值  好吧你减肥失败了 增重成功了...完成度0 哭也没用啊 混蛋
					percentage="0%";
				}
			}
			/* add by kontem 20130808 end*/
			
			if(percentage <= 100)
				percentage = percentage.toFixed(1) + "%";
			else
				percentage = "0%";
			
			$(".innerPro").css("width", percentage);
			$(".percent").text(percentage);
	}
	
}
changeWeight("#initW", ".initWeight");
changeWeight("#goalW", ".goalWeight");
changeWeight("#curW", ".curWeight");

//datepicker
var dateVar = (new Date()).getFullYear() + '-' + ((new Date()).getMonth() + 1) + '-' + (new Date()).getDate();	
$(".curDate").text(dateVar);//set date of current weight.
			
var setDateVal = function (datepicker){
		$( datepicker ).datepicker();
		$( datepicker).datepicker( "option", "dateFormat","yy-mm-dd" );
		$(datepicker).datepicker('option', 'maxDate', '0');
		$( datepicker).datepicker( "setDate",dateVar );
	},
	//点击左右加减一天
	toggleDateVal = function (toggleDate){
		$(toggleDate).click(function(){		
			var utc;
			dateVar = $(this).parent().find("input").val();
			
			if($(this).hasClass("preDate")){	
				utc = Date.parse(dateVar)  - 24*60*60*1000;
			}
			else if($(this).hasClass("nextDate")){
				utc = Date.parse(dateVar)  + 24*60*60*1000;
			}
			
			var date = new Date(utc),				
				y = date.getFullYear(),
				m = date.getMonth() + 1,
				d = date.getDate();
			dateVar = y + '-' + m + '-' + d;
			$(this).parent().find("input").datepicker( "setDate",dateVar );
		});
	};

setDateVal(".calendar");
toggleDateVal(".toggleDate");

//高亮样式
var highLight = function(ele, curClass){
	$(ele).children().bind("click", function(){		
		$(this).addClass(curClass).siblings().removeClass(curClass);
	});
}

highLight(".chartDate", "curChart");
highLight(".rankLine", "curRanking");
highLight(".siderBtn", "curGroup");


//tab
$(".dataTab").children().bind("click", function(){
	var _index = $(this).index();
	$(this).find("span").css("display","none");
	$(this).siblings().find("span").css("display", "block");
	$(".userArea").eq(_index).css("display","block").siblings().css("display","none");
})

//用户 
var userlist=[{
				"part" : "我的锻炼",
				"lists" : 
					["卧推", "卧推卧推", "卧推卧推上肢", "上肢1","上肢a", "上肢b", 
					 "上肢v", "上肢d", "上肢e", "上肢上肢上肢", "上肢上肢上肢上肢上肢上肢", "上肢f",
					 "上肢r", "上肢", "上肢", "上肢","上肢", "上肢名字很长很长很长很长很长很","卧推",
					 "卧推卧推", "卧推卧推上肢", "上肢1","上肢a", "上肢b", 
					 "上肢v", "上肢d", "上肢e", "上肢上肢上肢", "上肢上肢上肢上肢上肢上肢", "上肢f",
					 "上肢r", "上肢", "上肢", "上肢","上肢", "上肢名字很长很长很长很长很长很", 
					 "上肢v", "上肢d", "上肢e", "上肢上肢上肢", "上肢上肢上肢上肢上肢上肢", "上肢f",
					 "上肢r", "上肢", "上肢", "上肢","上肢", "上肢名字很长很长很长很长很长很"
					]
			}];
//更多动作选择
$.getJSON("json/actions.json", function(data){
	$.merge(userlist,data);
	data = userlist;
	var tmpMenu = [],
		listsArr = [],
		_objLen = data.length,
		_listLen = data[0].lists.length;
	//获取左侧栏“部位”
	for(var i=0;i<_objLen;i++){
		var obj = data[i];	
		tmpMenu.push('<li class="moreList">' + obj.part + '</li>');		
	}
	
	for(var j=0;j<_listLen;j++){
		listsArr.push('<li class="showList">' + data[0].lists[j] + '</li>');
	}

	$(".moreSider").append(tmpMenu.join(""));
	$("#actionsList").append(listsArr.join(""));
	
}).done(function(data){
		$.merge(userlist,data);
		data = userlist;
		$(".moreList").first().addClass("curList");
		highLight(".moreSider", "curList");
		
		//导航栏当前高亮显示
		$(".actNav>li").live("click", function(){
			actionVal=$(this).text();
			$(this).addClass("curAct").siblings().removeClass("curAct");
		});
		
		//点击导航栏“更多”按钮下拉
		$(".moreBtn").click(function(){
			$(".moreAct").slideDown();
			//第一次下拉时默认状态
			var ulHeight = $("#actionsList").height();
			if(ulHeight > 320){
				$(".nextSelect").show();
			}
		});
		
		//收起
		$(".hideBtn, .showList").live("click",function(){
			//若所选动作已存在于导航栏，则直接给高亮显示
			if($(this).hasClass("showList")){
				var txt = $(this).text(),
					navTxt = [],
					_navLen = $(".actNav").find("li").length,
					i = 0;

				for(i;i<_navLen;i++){
					navTxt[i] = $(".actNav").find("li").eq(i).text();
					if(txt == navTxt[i]){
						$(".actNav").find(".curAct").removeClass("curAct");
						actionVal=$(".actNav").find("li").eq(i).text();
						$(".actNav").find("li").eq(i).addClass("curAct");
						break;
					}
				}
				if(i==_navLen){
					$(".actNav").find(".curAct").removeClass("curAct");					
					$(".actNav").prepend('<li class="curAct">' + txt + '<span></span></li>');
					listLength();
				}	
			}
			$(".moreAct").slideUp();
		});		
		
		//"更多"左边选择部位
		$(".moreList").bind("click", function(){
			$("#actionsList").empty().css("top","0px");//清空右侧
			$(".preSelect").hide();//当前为第一页，不能点击“上一页”
			//重新读取json，填充到右侧
			var _index = $(this).index(),
				listsArr = [],
				_listLen = data[_index].lists.length;
			for(var j=0;j<_listLen;j++){
				listsArr.push('<li class="showList">' + data[_index].lists[j] + '</li>');
			}
			$("#actionsList").append(listsArr.join(""));
			
			//是否需要翻页
			var ulHeight = $("#actionsList").height();
			if(ulHeight > 320){
				$(".nextSelect").show();
			}
			else{
				$(".nextSelect").hide();
			}
		});
		
		//选择动作“更多”左右换页
		$(".selectMore").bind("click", function(){
			var nowTop = $("#actionsList").css("top"),
				ulHeight = $("#actionsList").height();
			nowTop = parseInt(nowTop);
			
			if($(this).hasClass("preSelect") && nowTop<0){
				nowTop += 320;
				console.log(nowTop)
				$(".nextSelect").show();
				if(nowTop == 0){
					$(".preSelect").hide();
				
				}
			}
			else if($(this).hasClass("nextSelect") && (nowTop>(320-ulHeight))){
				nowTop -= 320;	
				$(".preSelect").show();
				if(nowTop <= (320-ulHeight)){
					$(".nextSelect").hide();
				}
			}	
			$("#actionsList").css("top", nowTop+"px");
		})

});

//控制导航栏显示
var listLength = function(){
	var actList = [],
		allList = $(".actNav").find("li").last().index(),
		anvLength = 0;		
	for(var i=0;i<=allList;i++){
		actList[i] = $(".actNav>li").eq(i).text();
		anvLength += actList[i].length * 18 +32;
		
		//若长度大于800，则将后面的list移除
		while(anvLength > 800){
			anvLength -= ($(".actNav").find("li").last().width() + 32);
			$(".actNav>li").last().remove();
		}
	}
}
listLength();

//表格加一组、减一组
$(".editSave").click(function(){
	if($(this).hasClass("edit")){
		$(this).hide().next().show();
		$(".actGroup").find("span").show();
		$(".figure").css("background","url(images/tool/sprites2.png) no-repeat -32px -64px")
			.removeAttr("readonly");

		var groupNums=$(".tBody").find(".actGroup").length;

		//加一组
		if(groupNums<=7){
			$(".addBtn").show().die().live("click", addGroup);
		}
		//删除一组
		$(".delBtn").show();
		$(".delBtn").live("click", delGroup);
	}
	else if($(this).hasClass("save")){

		$(this).hide().prev().show();
		$(".actGroup").find("span").hide();
		$(".figure").css("background","none")
			.attr("readonly","readonly");
		$(".addBtn").hide();
		$(".delBtn").hide();

		//保存事件
		saveAddItems();
	}
});
var groupArr 		=    new Array();
	groupArr[1]     = "第一组";
	groupArr[2]     = "第二组";
	groupArr[3]     = "第三组";
	groupArr[4]     = "第四组";
	groupArr[5]     = "第五组";
	groupArr[6]     = "第六组";
	groupArr[7]     = "第七组";
	
var addGroup = function(){
	var inputNameArr = [ "nums[]", "weight[]", "time[]"],
		col = 4,
		colArr = [],
		colText = null;
		var groupNums=$(".tBody").find(".actGroup").length;
		groupNums++;
	if(groupNums<=7){
		for(var i=0; i<col; i++){
			if(0==i){
				colText = groupArr[groupNums];
			}
			else{
				colText = '<span class="cut" style="display:block;"></span>'
						+ '<input type="text" name="'+inputNameArr[i*1-1]+'" value="0" class="figure" style="background:url(images/tool/sprites2.png) no-repeat -32px -64px;"/>'
						+ '<span class="add" style="display:block;"></span>' ;
			}
			colArr.push('<button type="button" class="delBtn" style="display:block;"></button><div class="col col' + (++i) +'">'+ colText +'</div>');
			i--;
		}

		var k = (groupNums*1+1)%2,
			rowClass = null;
		if( k == 0){
			rowClass = "oddRow";
		}
		else{
			rowClass = "evenRow";
		}
		var newRow = '<div class="actGroup actGroupKon clearfix'+ ' '+ rowClass +'">' + colArr.join("") + '</div>';
		$(".tBody").append(newRow);
		if(groupNums == 7){
			$(".addBtn").hide();
		}
	}
};
var	delGroup = function(){
		var delIndex = $(this).parent().index(),
			groups = $(".tBody").find(".actGroup").length;
			
		$(this).parent().remove();
		$(".addBtn").show();

		for(var i=0;i<=groups;i++){
			if(i%2){
				$(".tBody").find(".actGroup").eq(i).removeClass("oddRow").addClass("evenRow");
			}
			else{
				$(".tBody").find(".actGroup").eq(i).removeClass("evenRow").addClass("oddRow");
			}
			$(".tBody").find(".actGroup").find(".col1").eq(i).text(groupArr[++i]);
			--i;
		}
}

$(".editDairyBtn,.writeSub").click(function(){
	$(".userNote>#gla").toggle();
	$(".userUpload").toggle();
	$("#writeForm").toggle();

});
//控制表格文字大小
var textLength = function(){
	var len = $(".thead>.col1").text().length,
		dLen = $(".col1>.rowTip").text().length,
		tLen = len - dLen;
	if(tLen>5){
		$(".thead>.col1").css("font-size","20px");
	}
	else{
		$(".thead>.col1").css("font-size","30px");
	}
}
textLength();

//图片切换
$(".userPicPrev").live("click",function(){

	var _this = this;
	var ajaxCallUrl='/tool/moreImage.php';
	var date=$(_this).attr('date');

	$.ajax({
		type: "POST",
		url:ajaxCallUrl,
		data:'date='+date+'&type=shareImage',
		dataType:'json',
		success: function(msg){
			var n = $(_this).parent().queue("fx");
			if(n.length)	return false;
		
			var innerHtml='<li><img src="images/'+msg.image+'" /></li>';
			$(_this).parent().css("width","+=460px").prepend(innerHtml);//获取一张图片，宽度增加
			$(_this).parent().find('li').eq(0).find('img').attr({"date":date,"alt":date});
			
			//查看上一张
			$(_this).parent().animate({ "right": "-=460px" }, function(){
				$(_this).removeClass("userPicPrev").prev().addClass("userPicPrev");
				$(_this).next().removeClass("userPicCurrent").prev().addClass("userPicCurrent");
				$(".userPicCurrent").next().addClass("userPicNext").siblings().removeClass("userPicNext");
				//查看下一张
				$(".userPicNext").die().live("click",function(){
					var n = $(_this).parent().queue("fx");
					if(n.length)	return false;

					var that = this;
					if($(that).hasClass("userPicNext")){
						$(_this).parent().animate({"right": "+=460px"}, function(){
							$(that).next().addClass("userPicNext");
							$(that).attr("class", "userPicCurrent").prev().attr("class","userPicPrev").siblings().removeClass("userPicPrev");
						})
					}
				})
			})
		}//success
	})
})





