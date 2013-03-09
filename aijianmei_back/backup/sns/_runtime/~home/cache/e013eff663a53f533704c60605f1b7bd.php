<?php if (!defined('THINK_PATH')) exit();?>        <?php if(is_array($sync)): ?><?php $i = 0;?><?php $__LIST__ = $sync?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$v): ?><?php ++$i;?><?php $mod = ($i % 2 )?><label>
                <input type='checkbox' name='sync[]' value='<?php echo ($v); ?>' style="vertical-align:middle;" <?php if($login_bind[$v]){ ?>checked=true<?php } ?> id='<?php echo ($v); ?>_sync' onclick='loginSelectSync(this)' />
                <span><?php echo ($alias[$v]); ?></span>
            </label><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>

<script>
    //同步设置
    function loginSelectSync(o) {
        if(o.checked) {
            $(o).removeAttr('checked');
            $.get( U('home/public/displayAddons') ,{addon:"Login",hook:"login_ajax_bind_publish_weibo",type:$(o).val(),'do':'ajax_bind'},function(txt) {
            	if(txt == '1'){
                    $(o).attr('checked',true);
                }else{
					ui.box.show(txt, {title:'绑定帐号'});
                }
            });
        } else {
            $(o).attr('checked', true);
            $.post(U('home/Widget/addonsRequest'), {
                addon : "Login",
                hook : "login_unbind_publish_weibo",
                type : $(o).val()
            }, function(txt) {
                $(o).removeAttr('checked');
            });
        }
    }
</script>