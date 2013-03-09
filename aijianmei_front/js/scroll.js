(function($) {
	$.fn.scrollLoading = function(options) {
		var defaults = {
			attr: "data-url",
			container: $(window),
			callback: $.noop
		};
		var params = $.extend({}, defaults, options || {});
		params.cache = [];
		$(this).each(function() {
			var node = this.nodeName.toLowerCase(), url = $(this).attr(params["attr"]);
			//閲嶇粍
			var data = {
				obj: $(this),
				tag: node,
				url: url
			};
			params.cache.push(data);
		});
		
		var callback = function(call) {
			if ($.isFunction(params.callback)) {
				params.callback.call(call.get(0));
			}
		};
		//鍔ㄦ€佹樉绀烘暟鎹�
		var loading = function() {
			
			var contHeight = params.container.height();
			if ($(window).get(0) === window) {
				contop = $(window).scrollTop();
			} else {
				contop = params.container.offset().top;
			}		
			
			$.each(params.cache, function(i, data) {
				var o = data.obj, tag = data.tag, url = data.url, post, posb;

				if (o) {
					post = o.offset().top - contop, post + o.height();
	
					if ((post >= 0 && post < contHeight) || (posb > 0 && posb <= contHeight)) {
						if (url) {
							//鍦ㄦ祻瑙堝櫒绐楀彛鍐�
							if (tag === "img") {
								//鍥剧墖锛屾敼鍙榮rc
								callback(o.attr("src", url));		
							} else {
								o.load(url, {}, function() {
									callback(o);
								});
							}		
						} else {
							// 鏃犲湴鍧€锛岀洿鎺ヨЕ鍙戝洖璋�
							callback(o);
						}
						data.obj = null;	
					}
				}
			});	
		};
		
		//浜嬩欢瑙﹀彂
		//鍔犺浇瀹屾瘯鍗虫墽琛�
		loading();
		//婊氬姩鎵ц
		params.container.bind("scroll", loading);
	};
})(jQuery);