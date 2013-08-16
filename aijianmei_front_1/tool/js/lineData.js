var jsonurl='json/lineData.json?4241';
var gloData=[];
(function getData(){
	$.getJSON(jsonurl, function(data){
		console.log(gloData)
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
	})
	.done(function(){
		gloData['color']="#34BE4E";
		gloData['lineWidth'] = 15;
		gloData['size'] = 25;
		joo(gloData,'line1');
	},function(){
			$(".t2").click(function(){
			$("#line1").empty();
			gloData['s1']=[5, 3, 1, 2, 1, 3, 1];
//gloData['s2']=[5, 3, 1, 2, 1, 3, 1];			
			gloData['color']="#34BE4E";
			gloData['lineWidth'] = 5;
			gloData['size'] = 10;
			joo(gloData,'line1');
		})		
	})
})();
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
				show:false,
				min:0,
				max:8, 
				numberTicks:9,//y轴范围、点数
				tickOptions: {
				formatString: '%d'//浮点数
				}
			
			}
		},
		highlighter: {
			bringSeriesToFront: true,
			lineWidthAdjust: 5,
			sizeAdjust: 20,
			tooltipLocation: 'n',
			tooltipAxes: 'y',
			tooltipFormatString: '<span class="tipText"></span> %.2f',
			useAxesFormatters: false
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


