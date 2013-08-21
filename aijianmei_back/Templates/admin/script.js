var imgobj=Object;
$(".alogimg").unbind();
$(".uploadimgbutton").unbind();
$("#image_file").unbind();
$("#exec_target").unbind();
$(document).ready(function(){
	$("#image_file").change(function(){
		if($("#image_file").val() != ''){
			$("#upload_form").submit();
		}
	});
	$("#exec_target").load(function(){
		var imgurl = $(window.frames['exec_target'].document.body).find("textarea").eq(0).html();
		var imgname = $(window.frames['exec_target'].document.body).find("textarea").eq(1).html();
		$(imgobj).attr('src',imgurl);
		$(imgobj).parent().find("input[imgurl!=1]").val(imgname);
		
	});
});
$(document).ready(function(){
	$(".uploadimgbutton").click(function(){
		imgobj=$(this).parent().find('img');
		$("#image_file").click();
	});
});