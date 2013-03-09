<?php if (!defined('THINK_PATH')) exit();?><div class="so_main">
    <div class="form2">
        <form method="post" action="<?php echo Addons::adminUrl('saveConfig');?>">
            <dl class="lineD">
                <dt>
                    最近来访出现的位置控制：
                </dt>
                <dd>
                    <?php $home = "";
                        $space = "";
                        if(in_array('home',$config['open'])) $home="checked";
                        if(in_array('space',$config['open'])) $space="checked"; ?>
                    <label>
                        <input type="checkbox" name="open[]" value="home" <?php echo ($home); ?>/>个人首页
                    </label>
                    <label>
                        <input type="checkbox" name="open[]" value="space" <?php echo ($space); ?>/>个人空间
                    </label>
                    <p>
                       控制最近来访出现的位置
                    </p>
                </dd>
            </dl>
            <dl class="lineD">
                <dt>
                    出现多少来访的人：
                </dt>
                <dd>
                    <select name="limit">
                        <?php for($i=1;$i<25;$i++){ ?>
                            <?php $selected="";
                                if($config['limit']==$i){
                                    $selected = "selected";
                                } ?>
                            <option value="<?php echo ($i); ?>" <?php echo ($selected); ?>><?php echo ($i); ?>个</option>
                        <?php } ?>
                    </select>
                    <p>
                        限制最近来访者在页面上出现的个数。根据不同的模板显示不同的个数保持美观
                    </p>
                </dd>
            </dl>
            <div class="page_btm">
                <input type="submit" class="btn_b" value="确定" />
            </div>
        </form>
    </div>
</div>