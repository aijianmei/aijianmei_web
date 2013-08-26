var jsonurl='/libpack/aiAjaxClass.php?act=getDefaultUserLineData';
var gloData=[];
(function getData(){
	$.getJSON(jsonurl, function(data){
		//console.log(gloData)
		var lineLen = data.lineData.length;		
		for(var i=0;i<lineLen;i++){
			var dotLen = data.lineData[i].line.length;
			var arr = [];
			for(var j=0;j<dotLen;j++){
				arr.push(data.lineData[i].line[j]);
			}
			arr.join("");
			var key='s'+(i*1+1);
			gloData[key]=arr;
		}
		gloData['ticksVal']=data.ticks;
		gloData['max']=data.max;
		//alert(gloData['max']);
	})
	.done(function(){
		gloData['color']="#34BE4E";
		gloData['lineWidth'] = 10;
		gloData['size'] = 20;
		gloData['ymax'] = gloData['max'];
		joo();
	},function(){
		$(".changeLine,.chartBtn").click(function(){
			if($(this).attr('groupNum')){
				selectGroupType=$(this).attr('groupNum');
			}
			$("#canvasDiv").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo();
		});
		$("#datepicker2").change(function (){
			lineDataDate=$("#datepicker2").val();
			lineDataDate=lineDataDate.replace(/-/g, "");
			$("#canvasDiv").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo();
		});
		$(".linePreDate,.lineNextDate").click(function (){
			lineDataDate=$("#datepicker2").val();
			lineDataDate=lineDataDate.replace(/-/g, "");
			$("#canvasDiv").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo();
		});

		/*$(".t2").click(function(){
			$("#canvasDiv").empty();
			joo();
			*/
	})
})();

function getDefaultUserLineData(){
	var ajaxCallUrl='/libpack/aiAjaxClass.php?act=getDefaultUserLineData';
	var fdata="selectTagType="+selectTagType+"&group="+selectGroupType+"&date="+lineDataDate+"&out=obj&aid="+actionVal;
	$.ajax({
		type: "POST",
		url:ajaxCallUrl,
				data:fdata,// 要提交的表单
				async:false,
				dataType:'json',
				success: function(msg) {
					//console.log(msg);
					gloData['s1']		=$.makeArray(msg.nums);
					gloData['s2']		=$.makeArray(msg.weight);
					gloData['s3']		=$.makeArray(msg.ctime);
					gloData['ticksVal']	=$.makeArray(msg.timelist);
					gloData['ymax']		=$.makeArray(msg.max);
				}
			});
}

function joo(){
	var data = [
			{
				name : '个',
				value:gloData['s1'],
				color:'#34BE4E',
				line_width:4
			},
			{
				name : 'kg',
				value:gloData['s2'],
				color:'#1B52C1',
				line_width:4
			},
			{
				name : 'min',
				value:gloData['s3'],
				color:'#FE3400',
				line_width:4
			}
		 ];
	
			var labels = gloData['ticksVal'];//横坐标数据
			
			var chart = new iChart.LineBasic2D({
				render : 'canvasDiv',
				data: data,
				align:'center',
				title : {
					text:'',
					font : '微软雅黑',
					fontsize:24,
					color:'#b4b4b4'
				},
				subtitle : {
					text:'',
					font : '微软雅黑',
					color:'#b4b4b4'
				},
				footnote : {
					text:'',
					font : '微软雅黑',
					fontsize:11,
					fontweight:600,
					padding:'0 28',
					color:'#b4b4b4'
				},
				width : 880,
				height : 280,
				shadow:true,
				shadow_color : '',
				shadow_blur : 8,
				shadow_offsetx : 0,
				shadow_offsety : 0,
				background_color:'#eaeaea',
				tip:{
					enable:true,
					shadow:true,
					listeners:{
						 //tip:提示框对象、name:数据名称、value:数据值、text:当前文本、i:数据点的索引
						parseText:function(tip,name,value,text,i){
							return "</span><span style='color:#005268;font-size:20px;'>"+value+name+"</span>";
						}
					}
				},
				crosshair:{
					enable:true,
					line_color:'#109CD4'//标识线的颜色
				},
				sub_option : {
					smooth : true,
					label:false,
					hollow:false,
					hollow_inside:false,
					point_size:8
				},
				coordinate:{
					width:810,
					height:200,
					striped_factor : 0.18,
					grid_color:'#ddd',//网格线的颜色
					axis:{
						color:'#999',
						width:[0,0,1,1]
					},
					scale:[{
						 position:'left',	
						 start_scale:20,//纵坐标起始值
						 end_scale:10,
						 scale_space:20,
						 scale_size:2,
						 scale_enable : false,
						 label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
						 scale_color:'#9f9f9f'
					},{
						 position:'bottom',	
						 label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
						 scale_enable : false,
						 labels:labels
					}]
				}
			});
			//利用自定义组件构造左侧说明文本
			chart.plugin(new iChart.Custom({
				drawFn:function(){
					//计算位置
					var coo = chart.getCoordinate(),
						x = coo.get('originx'),
						y = coo.get('originy'),
						w = coo.width,
						h = coo.height;
					//在左上侧的位置，渲染一个单位的文字
					chart.target.textAlign('start')
					.textBaseline('bottom')
					.textFont('600 11px 微软雅黑')
					.fillText('',x-40,y-12,false,'#9d987a')
					.textBaseline('top')
					.fillText('',x+w+12,y+h+10,false,'#9d987a');
					
				}
			}));
		//开始画图
		chart.draw();
}


