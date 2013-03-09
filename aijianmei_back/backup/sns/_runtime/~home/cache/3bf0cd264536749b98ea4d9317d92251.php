<?php if (!defined('THINK_PATH')) exit();?>          <div class="setupBox">
          <div class="setItems">
            <div class="setFold setUnfold" rel="verified" >
              <h2>认证资料<span id="verified_tips" class="cRed" style="font-weight:normal;"><?php if ('1' == $verified['verified']) { ?>(认证成功)</span><?php } else if ('0' === $verified['verified']) { ?>(认证中……)<?php } ?></span></h2>
            </div>
            <div style="display: block;" class="setItemsInfo">
				<div class="right" style="width:250px;padding:0 0 0 20px;line-height:20px;"><?php echo (nl2br($verifyruler['verifyruler'])); ?></div>
		      	<div class="data" style="border-right:1px solid #ddd">
		            <form action="<?php echo Addons::createAddonUrl('UserVerified', 'home_account_do');?>" method="POST" id="form_verified" class="form_validator" enctype="multipart/form-data">
		                <ul>
		                <li>
		                    <div class="left" style="width: 15%;text-align:right;display:block">真实姓名：<span class="cRed pr5">*</span></div>
		                    <div class="left" style="width: 50%;">
		                      <div class="left mr5">
		                          <input name="realname" type="text" value="<?php echo ($verified["realname"]); ?>" class="text" style="width:200px;" onfocus="this.className='text2'" onblur="this.className='text'" /><br />
		                          不会公开显示
		                      </div>
		                    </div>
		                </li>
		                <li>
		                    <div class="left" style="width: 15%;text-align:right;display:block">手机号：<span class="cRed pr5">*</span></div>
		                    <div class="left" style="width: 50%;">
		                      <div class="left mr5">
		                          <input name="phone" type="text" value="<?php echo ($verified["phone"]); ?>" class="text" style="width:200px;" onfocus="this.className='text2'" onblur="this.className='text'" /><br />
		                          不会公开显示
		                      </div>
		                    </div>
		                </li>
		                <li>
		                    <div class="left" style="width: 15%;text-align:right;display:block">认证资料：<span class="cRed pr5">*</span></div>
		                    <div class="left" style="width: 50%;">
		                      <div class="left mr5"><textarea name="reason" cols="40" rows="3" onfocus="this.className='text2'" onblur="this.className='text'"><?php echo ($verified["reason"]); ?></textarea></div>
		                    </div>
		                </li>
		                 <li>
		                    <div class="left" style="width: 15%;text-align:right;display:block">附件：</div>
		                    <div class="left mr5" style="width: 50%;">
		                    	<?php echo W('UploadAttach',array('limit' =>'1'));?>
		                    	<div><br>请上传您的有效证扫描件、或其他能有效证明身份的资料！</div>
		                    </div>		                    
		                </li>
		                <li>
		                	<div class="left" style="width: 15%;text-align:right;display:block">&nbsp;</div>
		                	<div class="left" style="width: 50%;">
		                		<input type="hidden" name="id" value="<?php echo ($verified["id"]); ?>" />
		                		<input type="button" id="btn_submit" class="btn_b" value="保存" onclick="return modifyVerified();" />
		                		<!-- <input type="submit" value="保存" /> -->
		                	</div>
		                	<div class="left" style="width: 15%;"></div>
		                </li>
		                </ul>
		            </form>
		        </div>
            </div>
          </div>
          </div>
        <div class="c"></div>
<script>
	$(document).ready(function(){
		var hs = document.location.hash;
		changeModel( hs.replace('#','') );
		$('.setFold').click(function(){
			if( $(this).attr('class')=='setFold' ){
				changeModel( $(this).attr('rel') );
			}else{
				$(this).removeClass('setUnfold');
				$(this).next('.setItemsInfo').hide();
			}
			location.href='#'+$(this).attr('rel');
		})
	});
	
	//切换操作模块
	function changeModel( type ){
		var t = type || 'verified';
		$('.setFold').removeClass('setUnfold');
		$('.setItemsInfo').hide();
		var handle = $('div[rel="'+t+'"]');
		handle.addClass('setUnfold');
		handle.next('.setItemsInfo').show();
	}

	function modifyVerified(o)
	{

		var $btn_submit = $('#btn_submit');
		var $realname = $('input[name="realname"]');
		var $phone = $('input[name="phone"]');
		var $reason = $('textarea[name="reason"]');
		var realname = $realname.val();
		var phone = $phone.val();
		var reason = $reason.val();
		var id = $('input[name="id"]').val();

		if (!realname.match(/^[\u4e00-\u9fa5]+$|^[a-zA-Z\.·]+$/)) {
			ui.error('请输入真实姓名');
			$realname.focus();
			return false;
		} else if (!phone.match(/^[\d]{11}$/)) {
			ui.error('请输入正确的手机号');
			$phone.focus();
			return false;
		} else if (reason.length <= 0) {
			ui.error('请输入认证资料');
			$reason.focus();
			return false;
		}

		<?php if($verified['verified'] == 1): ?>if (!confirm('确定重新申请认证？申请后您原有的认证标识将被收回，通过后即可恢复。')) {
			return false;
		}<?php endif; ?>

		document.getElementById('form_verified').submit();
		// $btn_submit.attr('disabled','true');
		// $.post('<?php echo Addons::createAddonUrl('UserVerified', 'home_account_do');?>', {realname:realname,phone:phone,reason:reason,id:id},function(txt){
		// 	if( 1 == txt ){
		// 		$("#verified_tips").html('(成功提交资料，请等待认证。)');
		// 		ui.success('操作成功,等待认证');
		// 	}else{
		// 		ui.error('操作失败,请稍后再试');
		// 	}
		// 	$btn_submit.removeAttr('disabled');			
		// });
	}
</script>