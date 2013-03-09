<?php if (!defined('THINK_PATH')) exit();?><div class="person_Fans app_line">
    <h2><?php echo ($uname); ?>的粉丝</h2>
    <ul class="fans_person">
    <?php if(is_array($list["data"])): ?><?php $i = 0;?><?php $__LIST__ = $list["data"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li>
            <div class="userPic"><?php echo getUserSpace($vo["fid"],'','','{uavatar}') ?></div>
        </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </ul>
    <div class="right"><a href="<?php echo U('home/space/follow',array('uid'=>$uid,'type'=>'follower'));?>">更多&raquo;</a> </div>
</div>