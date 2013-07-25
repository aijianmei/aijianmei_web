//help object
var help = {
	addEvent:function(element,type,handler)
    {
        if(element.addEventListener)
        {
            element.addEventListener(type,handler,false); 
        }
        else if(element.attachEvent)
        {
            element.attachEvent("on"+type,handler);  
        }
        else
        {
            element["on"+type]= handler; 
        }
    }

};

//input handle block 
(function(){
	var txt = document.getElementById("comment");

	//ipput focus event handler
	function txtFocus(){
		if(txt.value==txt.defaultValue)
		{
			txt.value="";
		}
		 txt.style.color = "#000";
	}

	//input blur event handler
	function txtBlur(){ 
		if(txt.value == "")
		{
			txt.value = txt.defaultValue;
		}
		 txt.style.color="#8C8C8C";
	}
	help.addEvent(txt,"focus",txtFocus);
	help.addEvent(txt,"blur",txtBlur);
})();