<?php if (!defined('THINK_PATH')) exit();?>    <!--发送私信弹窗-->
    <dl class="pop_send_massage">
        <dd>
            <label>收信人：</label>
            <div class="pop_form_r">
                <div style="width:283px;"><?php echo W('SelectFriends',array('uid'=>$touid));?></div>
                 <!--<?php if($touid){ ?>
                    <input type="hidden" style="width:220px;" onblur="this.className='text'" onfocus="this.className='text2'" class="text" id="message_to" value="<?php echo ($touid); ?>"/>
                    <input type="text" readonly disabled=true style="width:220px;" onblur="this.className='text'" onfocus="this.className='text2'" class="text" value="<?php echo (getUserName($touid)); ?>"/>
                <?php }else{ ?>
                    <input type="text" style="width:220px;" onblur="this.className='text'" onfocus="this.className='text2'" class="text" id="message_to"/>
                <?php } ?>-->
            </div>
            <div class="c"></div>
        </dd>
        <dd>
            <label>内容：</label>
            <div class="pop_form_r">
            <textarea style="width:280px; height:80px;" id="message_content" onblur="this.className='text'" onfocus="this.className='text2'" class="text"></textarea>
            </div>
        </dd>
        <dd>
        <label>
        &nbsp;
        <!--<a href="javascript:void(0)" target_set="message_content" onclick="ui.emotions(this)" class="a52"><img class="icon_add_face_d" src="__THEME__/images/zw_img.gif" />表情</a>-->
        </label>
    	<div class="pop_form_r"><input type="button" value="发送" class="btn_b" onclick="doPostMessage();" id="postbut"/></div>
        </dd>
    </dl>
    <!--发送私信弹窗-->
<script>
function butstate(type){
	if( type == 'open' ){
		$('#postbut').attr('disabled','');
		$('#postbut').val('发送');
	}
	if( type == 'close' ){
		$('#postbut').attr('disabled','true');
		$('#postbut').val('Loading......');
	}
}
    function doPostMessage() {
    	butstate('close');
        var message_to      = $('#ui_fri_ids').val();
        var message_title   = $('#message_title').val();
        var message_content = $('#message_content').val();
            message_content = message_content.replace(/(^\s*)|(\s*$)/g, "");
        if (message_to == "") {
        	ui.error("请选择好友");
        	butstate('open');
        	return false;
        }
        if (message_title == "") {
        	ui.error("请填写标题");
        	butstate('open');
        	return false;
        }
        if (message_content == "") {
        	ui.error("请填写内容");
        	butstate('open');
        	return false;
        }
        $.post("<?php echo U('home/Message/doPost');?>", {to:message_to, title:message_title, content:message_content}, function(res){
        	if (res == '1') {
                ui.success('发送成功');
                if ('msglist' == $CONFIG.location) {
                	setTimeout('location.reload()', 400);
                }
                ui.box.close();
            }else if(res == '-1') {
            	ui.error('发信频率太快啦, 请10秒后重试');
            	butstate('open');
            }else if(res == '-2') {
            	ui.error('最多发送给10个人');
            	butstate('open');
            }else if(res == '-3'){
               alert('抱歉根据用户的设置，您暂时不能给TA发私信哦');
               setTimeout(location.reload());
            }else {
                ui.error('发送失败');
                butstate('open');
            }
        });
    }

// 限制Textarea文本框的输入大小
$(function() {
    $('#message_content').keydown(function(event) {
        if(this.value.length > 200 && event.which != '8' && event.which != '46') {
            event.preventDefault();
            return;
        }
    });
});
</script>