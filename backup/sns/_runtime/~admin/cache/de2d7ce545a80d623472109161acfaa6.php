<?php if (!defined('THINK_PATH')) exit();?><div class="so_main">
  <div class="page_tit">平台配置</div>
  
  <div class="form2">
    <form method="post" action="<?php echo Addons::adminUrl('saveAdminConfig');?>">
    <dl class="lineD">
        <dt>开启同步登录功能：</dt>
        <dd>
            <?php foreach($data as $key=>$value){ ?>
                <label><input type="checkbox" name="open[]" value="<?php echo ($key); ?>" <?php if(in_array($key,$config['open'])){ ?>checked<?php } ?>/><?php echo $alias[$key] ?></label>
            <?php } ?>
            <br /><br />
            <p>当开启对应的平台，在用户登录时就能看到对应的平台同步登录按钮</p>
        </dd>
    </dl>
      <?php foreach($data as $key=>$value){ ?>
          <?php $aliasName = $alias[$key];
              $url  = $applyUrl[$key];
              $platformKey = trim($config[$value[0]]);
              $platformSKey = trim($config[$value[1]]); ?>
            <dl class="">
              <dt><?php echo ($aliasName); ?>KEY：</dt>
              <dd>
                <input name="<?php echo ($value[0]); ?>" type="text" value="<?php echo ($platformKey); ?>">
                <label>申请地址：<a href="<?php echo ($url); ?>" target="_blank"><?php echo ($url); ?></a></label>
              </dd>
            </dl>
            <dl class="lineD">
              <dt><?php echo ($aliasName); ?>密匙：</dt>
              <dd>
                <input name="<?php echo ($value[1]); ?>" type="text" value="<?php echo ($platformSKey); ?>">
              </dd>
    </dl>
      <?php } ?>
    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
    </form>
  </div>
</div>