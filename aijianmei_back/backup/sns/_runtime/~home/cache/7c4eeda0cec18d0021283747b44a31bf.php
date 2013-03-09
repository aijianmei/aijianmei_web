<?php if (!defined('THINK_PATH')) exit();?><?php if($user_verified['info']): ?><dl class="certif">
	    <dt><img src="<?php echo SITE_URL;?>/addons/plugins/UserVerified/html/icon24x24.png" alt="<?php echo ($user_verified['info']); ?>" /></dt>
        <dd>
            <h2>身份认证</h2>
            <p><?php echo ($user_verified['info']); ?></p>
        </dd>
    </dl><?php endif; ?>