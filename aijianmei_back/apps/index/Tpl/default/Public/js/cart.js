function $$(id){
	return document.getElementById(id);
};

var Help = {
    AddEvent: function(element, type, handler) {
        if (element.addEventListener) {				
            element.addEventListener(type, handler, false);
            this.AddEvent = function(element, type, handler)	
            {													
                element.addEventListener(type, handler, false);
            };
        }
        else if (element.attachEvent) {				
            element.attachEvent("on" + type, handler);
             this.AddEvent = function(element, type, handler)
            {
                element.attachEvent("on" + type, handler);
            };
        }
        else {										
            element["on" + type] = handler;
            this.AddEvent = function(element, type, handler)
            {
                element["on" + type] = handler;
            };
        }
    }
};
var _checked = false;
var all = function(options){
	var that = this,
		allSelect = $$("allSelect"),
		selectList = document.getElementsByName("product"),
		_checked = allSelect.checked;
	
	for(var i = 0; i < selectList.length; i++){
		selectList[i].checked = _checked;
	}
	if(_checked){
		$(".del").click(function(){
			console.log("sgdfg")
		})
	}
}

Help.AddEvent(allSelect, "click", all);




