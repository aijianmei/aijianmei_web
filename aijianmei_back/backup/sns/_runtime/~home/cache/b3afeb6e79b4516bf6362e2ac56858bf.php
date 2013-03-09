<?php if (!defined('THINK_PATH')) exit();?><?php if($visitor_list): ?><div class="right_box lineS_btm">
<h2><?php echo ($visitor_title); ?></h2> 
	<ul class="visitor_list">
	    <?php if(is_array($visitor_list)): ?><?php $i = 0;?><?php $__LIST__ = $visitor_list?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li>
	    	<?php echo getUserSpace($vo["uid"],'','','{uavatar=m}') ?>
	        <?php echo getUserSpace($vo["uid"],'fn','','{uname}') ?>
		</li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	</ul>
</div><?php endif; ?>