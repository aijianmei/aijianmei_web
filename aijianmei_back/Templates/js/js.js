function pop (tid,vid)
{
	if(!tid) tid=0;
	if(!vid) vid=0;
	window.open("/VideoWindows-"+tid+"-"+vid, "exercise", "status = 1, height = 450, width = 690, resizable = 0")
	//window.open("file:///G:/aijianmei_web/aijianmei_front_1/video.html", "exercise", "status = 1, height = 450, width = 690, resizable = 0")
}
