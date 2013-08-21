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
		joo(gloData,'line1');
	},function(){
		$(".changeLine,.chartBtn").click(function(){
			if($(this).attr('groupNum')){
				selectGroupType=$(this).attr('groupNum');
			}
			$("#line1").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo(gloData,'line1');
		});
		$("#datepicker2").change(function (){
			lineDataDate=$("#datepicker2").val();
			lineDataDate=lineDataDate.replace(/-/g, "");
			$("#line1").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo(gloData,'line1');
		});
		$(".linePreDate,.lineNextDate").click(function (){
			lineDataDate=$("#datepicker2").val();
			lineDataDate=lineDataDate.replace(/-/g, "");
			$("#line1").empty();
			getDefaultUserLineData();
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 10;
			gloData['size'] = 20;
			joo(gloData,'line1');
		});

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

function joo(gloData,divid){
	$.jqplot.config.enablePlugins = true;			
	plot1 = $.jqplot(divid, [gloData['s1'], gloData['s2'], gloData['s3']], {
		series: [{label: '1st Qtr'},{label: '2st Qtr'}],
		seriesDefaults:{
			lineWidth: gloData['lineWidth'],
			markerOptions: {
				show: true,
				size: gloData['size'] //点的大小
			}
		},
		seriesColors: [ gloData['color'], "#1B52C1", "#FE3400", "#579575", "#839557", "#958c12",
		"#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"
		],
		legend: {show:true, location: 'nw'},
		axes:{
			xaxis:{
				renderer:$.jqplot.CategoryAxisRenderer, ticks:gloData['ticksVal']
			},
			yaxis:{
				min:0, max:gloData['ymax'], numberTicks:9,//y轴范围、点数
				tickOptions: {
					formatString: '%.2f'//浮点数
				}
			}
		},
		highlighter: {
			bringSeriesToFront: true,
			lineWidthAdjust: 5,
			sizeAdjust: 10,
			tooltipLocation: 'n',
			tooltipAxes: 'y',
			tooltipFormatString: '<b><i><span style="color:red;">顶个你个</span></i></b> %.2f ',
			useAxesFormatters: true
		},
		grid: {
			drawGridLines: true,        // wether to draw lines across the grid or not.
			gridLineColor: 'transparent',    // *Color of the grid lines.
			background: 'transparent',      // CSS color spec for background color of grid.
			borderColor: 'transparent',     // CSS color spec for border around grid.
			borderWidth: 0,           // pixel width of border around grid.
			shadow: false,               // draw a shadow for grid.
			shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
			shadowOffset: 1.5,          // offset from the line of the shadow.
			shadowWidth: 3,             // width of the stroke for the shadow.
			shadowDepth: 3,             // Number of strokes to make when drawing shadow.
										// Each stroke offset by shadowOffset from the last.
			shadowAlpha: 0.07,           // Opacity of the shadow
			renderer: $.jqplot.CanvasGridRenderer,  // renderer to use to draw the grid.
			rendererOptions: {}         // options to pass to the renderer.  Note, the default
										// CanvasGridRenderer takes no additional options.
									}
								});
}


