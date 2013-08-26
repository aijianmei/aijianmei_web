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
			postWeightInfo();
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
		$( datepicker ).datepicker( "option", "dateFormat","yy-mm-dd" );
		$( datepicker ).datepicker('option', 'maxDate', '0');
		$( datepicker ).datepicker( "setDate",dateVar );
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
		if(curClass=='curChart'){
			selectTagType=$(this).attr('selectType');
		}
		if(curClass=='curGroup'){
			selectGroupType=$(this).text();
		}
	});
}

highLight(".chartDate", "curChart");
highLight(".rankLine", "curRanking");
highLight(".siderBtn", "curGroup");

var dateTabType=false;
//tab
$(".dataTab").children().bind("click", function(){
	var _index = $(this).index();
	dateTabType=_index;
	$(this).find("span").css("display","none");
	$(this).siblings().find("span").css("display", "block");
	$(".userArea").eq(_index).css("display","block").siblings().css("display","none");
})
//更多动作选择
//var actionJson='Templates/tool/json/actions.json';
var actionJson='Templates/tool/json/CourseAction.json';
$.getJSON(actionJson, function(data){
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
			$(".actionNameBox").html(actionVal);
			getCourseData(dateContentVar);
			$(this).addClass("curAct").siblings().removeClass("curAct");
			textLength();
			changeTabNameByAction(actionVal);
			$(".siderBtn").find(".chartBtn").eq(0).click();
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
						$(".actionNameBox").html(actionVal);
						getCourseData(dateContentVar);//替换
						textLength();
						$(".siderBtn").find(".chartBtn").eq(0).click();
						changeTabNameByAction(actionVal);
						$(".actNav").find("li").eq(i).addClass("curAct");
						break;
					}
				}
				if(i==_navLen){
					$(".actNav").find(".curAct").removeClass("curAct");		
					$(".actNav").prepend('<li class="curAct">' + txt + '<span></span></li>');
					postUserDefaultAction();
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
				//console.log(nowTop)
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
		$(".figure").css("background","url(Templates/tool/images/tool/sprites2.png) no-repeat -32px -64px")
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
						+ '<input type="text" name="'+inputNameArr[i*1-1]+'" value="0" class="figure" style="background:url(Templates/tool/images/tool/sprites2.png) no-repeat -32px -64px;"/>'
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
	$(".tBody").find(".actGroup").find('.col').find('.cut').die().live('click',function(){
		var tmpNum=$(this).parent().find('input').val();
		if(tmpNum>0){
			tmpNum=tmpNum*1-1
			$(this).parent().find("input").val(tmpNum);
		}
	});
	$(".tBody").find(".actGroup").find('.col').find('.add').die().live('click',function(){
		var tmpNum=$(this).parent().find('input').val();
		tmpNum=tmpNum*1+1;
		$(this).parent().find("input").val(tmpNum);
	});
};
var	delGroup = function(){
		var delIndex = $(this).parent().index(),
			groups = $(".tBody").find(".actGroup").length;
			

		var groupName=$(this).parent().find(".col1").html();
		//根据组号删除对应的数据
		delGroupByName(groupName);

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

$(".editDairyBtn").click(function(){
	$(".userNote>#gla").toggle();
	$(".userUpload").toggle();
	$("#writeForm").toggle();
	if($(".editDairyBtn").attr('style')=="display: none;"){
		$(".editDairyBtn").show();
	}else{
		$(".editDairyBtn").hide();
	}
})
$(".writeSub").click(function(){
	$(".userNote>#gla").toggle();
	$(".userUpload").toggle();
	$("#writeForm").toggle();
	if($(".editDairyBtn").attr('style')=="display: none;"){
		$(".editDairyBtn").show();
	}else{
		$(".editDairyBtn").hide();
	}
	var writeData=$("#write").val();
	//alert(writeData);
	setUserLogImg();
})

function setUserLogImg(){

	var ajaxCallUrl='/libpack/aiAjaxClass.php?act=setUserLogImg';
	var fdata='writeLog='+$("#write").val()+'&date='+uploadImageDate;
	$.ajax({
		type: "POST",
		url:ajaxCallUrl,
		data:fdata,// 要提交的表单
		dataType:'json',
		success: function(msg) {
			$(".userNote").find("#imageBox").find('li[class="userPicCurrent"]').find('img').attr('src',msg);
			$("#write").val('');
		}
	});
}

function postUserDefaultAction(){
	var ajaxCallUrl='/libpack/aiAjaxClass.php?act=postUserDefaultAction';
	var fdata=$(".actNav").find("li").toArray();
	var tmpData=Array();
	for (var i = fdata.length - 1; i >= 0; i--) {
		var obj=fdata[i];
		tmpData.push(obj.innerText);
	};
	var data='DateString='+tmpData;
	$.ajax({
		type: "POST",
		url:ajaxCallUrl,
		data:data,// 要提交的表单
		dataType:'json',
		success: function(msg) {
		}
	});
}

var textLength = function(){
	var len = $(".actionNameBox").text().length;
	//console.log(len);
	//alert();
	if(len>5){
		$(".actionNameBox").css("font-size","20px");
	}else{
		$(".actionNameBox").css("font-size","30px");
	}
}
textLength();
//图片切换
$(".userPicPrev").live("click",function(){
	var _this = this;
	var ajaxCallUrl='/libpack/aiAjaxClass.php?act=getUserLogImage';
	var date=$(_this).attr('date');
	//alert(date);
	$.ajax({
		type: "POST",
		url:ajaxCallUrl,
		data:'date='+date+"&dateTabType="+dateTabType,
		dataType:'json',
		async: false, 
		success: function(msg){
	
			var n = $(_this).parent().queue("fx");
			if(n.length) return false;

			if(!msg.image){

				$(_this).parent().animate({ "right":"-=460px"});
				$(_this).removeClass("userPicPrev").addClass("userPicCurrent");
				$(_this).next().removeClass("userPicCurrent");
				$(_this).parent().find("li[class='userPicCurrent']").next().addClass("userPicNext").siblings().removeClass("userPicNext");

				$(".userPicNext").die().live("click",function(){
					var n = $(_this).parent().queue("fx");
					if(n.length)	return false;
					var that = this;
					if($(that).hasClass("userPicNext")){
						$(that).parent().animate({"right": "+=460px"}, function(){
							$(that).next().addClass("userPicNext");
							$(that).attr("class", "userPicCurrent").prev().attr("class","userPicPrev").siblings().removeClass("userPicPrev");
						})
					}
				})

				return false;
			}
			if(!$(_this).index()){
				var innerHtml='<li><img src="'+msg.image+'" /></li>';
				$(_this).parent().css("width","+=460px").prepend(innerHtml);//获取一张图片，宽度增加
				$(_this).parent().find('li').eq(0).attr({"date":msg.date,"alt":msg.date});
			}
			//查看上一张
			
			/*var _right;
			if($(_this).parent().find("li").length == 3){
				_right = "-=300px";
			}
			else{
				_right = "-=460px";
			}*/

			$(_this).parent().animate({ "right": "-=460px" }, function(){
				$(_this).removeClass("userPicPrev").prev().addClass("userPicPrev");
				$(_this).next().removeClass("userPicCurrent").prev().addClass("userPicCurrent");
				$(_this).parent().find("li[class='userPicCurrent']").next().addClass("userPicNext").siblings().removeClass("userPicNext");
				//查看下一张
				$(".userPicNext").die().live("click",function(){
					var n = $(_this).parent().queue("fx");
					if(n.length)	return false;
					var that = this;
					if($(that).hasClass("userPicNext")){
						$(that).parent().animate({"right": "+=460px"}, function(){
							$(that).next().addClass("userPicNext");
							$(that).attr("class", "userPicCurrent").prev().attr("class","userPicPrev").siblings().removeClass("userPicPrev");
						})
					}
				})
			})


			/*if($(_this).parent().find("li[date='"+msg.date+"']").length >1){
				$(_this).parent().find("li[date='"+msg.date+"']").eq(0).remove();
			}*/
		}//success
	})
})

/*
function checkIntNums(obj){
		var num=$(obj).val();
		num = num.replace(/^[1-9]d*.d*|0.d*[1-9]d*{1}$/g,"<img src='"+baseURL+"Face_13.gif'>");
		var num;
}*/

function delGroupByName(groupName){
	if(userId > 0){
		var ajaxCallUrl='/libpack/aiAjaxClass.php?act=deleteUserCourseInfo&uid='+userId+'&aid='+encodeURIComponent(actionVal)+'&date='+dateContentVar+"&groupName="+encodeURIComponent(groupName);
		$.ajax({
			type: "POST",
			url:ajaxCallUrl,
			data:$('#dataForm').serialize(),// 要提交的表单
			success: function(msg) {
				//alert('保存成功');
				resetAvg();
			}
		});
	}else{
		$(".login").click();	
	}
}

function resetAvg(){
	var countNum=$(".tBody").find(".actGroup").length;
	var allNums=0,allWeight=0,allTime=0;
	if(countNum>0){
		for (var i = countNum - 1; i >= 0; i--) {
			var tmpnums=$(".tBody").find(".actGroup").eq(i).find('input').eq(0).val();
			allNums=allNums*1+tmpnums*1;

			var tmpweight=$(".tBody").find(".actGroup").eq(i).find('input').eq(1).val();
			allWeight=allWeight*1+tmpweight*1;

			var tmptime=$(".tBody").find(".actGroup").eq(i).find('input').eq(2).val();
			allTime=allTime*1+tmptime*1;
		};
		if(isNaN(allNums*1)) allNums=0;
		if(isNaN(allWeight*1)) allWeight=0;
		if(isNaN(allTime*1)) allTime=0;

		$(".numsAvg").html(Math.round(allNums/countNum));
		$(".weigthAvg").html(Math.round(allWeight/countNum));
		$(".timeAvg").html(Math.round(allTime/countNum));	
	}else{
		$(".numsAvg").html(0);
		$(".weigthAvg").html(0);
		$(".timeAvg").html(0);
	}	
}
function isShowDelButton(){
	var tobj=$(".tFooter").find(".save");
	if ($(tobj).is(":visible")) {
		$(".delBtn").show();
	}else{
		$(".delBtn").hide();
	}
}
$(".siderBtn").find(".chartBtn").mouseover(function(){
	$(this).click();
});

$(".tBody").find(".actGroup").find('.col').find('.cut').die().live('click',function(){
	var tmpNum=$(this).parent().find('input').val();
	if(tmpNum>0){
		tmpNum=tmpNum*1-1
		$(this).parent().find("input").val(tmpNum);
	}
});
$(".tBody").find(".actGroup").find('.col').find('.add').die().live('click',function(){
	var tmpNum=$(this).parent().find('input').val();
	tmpNum=tmpNum*1+1;
	$(this).parent().find("input").val(tmpNum);
});
function changeTabNameByAction(actionVal){
	$(".tableTabName").html(actionVal);
	$(".tableLineTabName").html(actionVal);
}

function countCalories(){
	var bodyWeight=$(".curWeight").text();//用户体重
	var countNum=$(".tBody").find(".actGroup").length;//组的个数
	var METs=3; //mets 代谢率

	//calories=((METs * 3.5 * bodyWeight)/200)* minute;
	if(countNum>0){
		for (var i = countNum - 1; i >= 0; i--) {
			var weight=$(".tBody").find(".actGroup").eq(i).find('input').eq(0).val();
			var minute=$(".tBody").find(".actGroup").eq(i).find('input').eq(2).val();
			var METs =(3/20)*weight;
			var	calories=((METs * 3.5 * bodyWeight*1)/200)* minute;
			alert(calories);
		};
		if(isNaN(allNums*1))   allNums=0;
		if(isNaN(allWeight*1)) allWeight=0;
		if(isNaN(allTime*1))   allTime=0;

		$(".numsAvg").html(Math.round(allNums/countNum));
		$(".weigthAvg").html(Math.round(allWeight/countNum));
		$(".timeAvg").html(Math.round(allTime/countNum));	
	}else{
		$(".numsAvg").html(0);
		$(".weigthAvg").html(0);
		$(".timeAvg").html(0);
	}
}
countCalories();