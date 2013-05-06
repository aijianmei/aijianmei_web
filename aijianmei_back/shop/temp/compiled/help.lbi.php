<?php if ($this->_var['helps']): ?>
<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');if (count($_from)):
    foreach ($_from AS $this->_var['help_cat']):
?>
<dl>
  <dt><a href='<?php echo $this->_var['help_cat']['cat_id']; ?>' title="<?php echo $this->_var['help_cat']['cat_name']; ?>"><?php echo $this->_var['help_cat']['cat_name']; ?></a></dt>
  <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_0_54419400_1366363039');if (count($_from)):
    foreach ($_from AS $this->_var['item_0_54419400_1366363039']):
?>
  <dd><a href="<?php echo $this->_var['item_0_54419400_1366363039']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item_0_54419400_1366363039']['title']); ?>"><?php echo $this->_var['item_0_54419400_1366363039']['short_title']; ?></a></dd>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
    <div class="block">
    
   <div class="clearfix">
<dl>
  <dt class="dt1"><a href="article_cat-6.html" title="购物指南" rel="nofollow">购物指南</a></dt>
    <dd><a href="help.php?id=11" title="新手需知" rel="nofollow">新手需知</a></dd>
    <dd><a href="help.php?id=62" title="订单状态" rel="nofollow">订单状态</a></dd>
    <dd><a href="help.php?id=65" title="购物流程" rel="nofollow">购物流程</a></dd>
  </dl>
<dl>
  <dt class="dt2"><a href="article_cat-7.html" title="快递发货" rel="nofollow">快递发货</a></dt>
    <dd><a href="help.php?id=12" title="配送范围 " rel="nofollow">配送范围</a></dd>
    <dd><a href="help.php?id=13" title="配送方式 " rel="nofollow">配送方式</a></dd>
    <dd><a href="help.php?id=14" title="收货验收" rel="nofollow">收货验收</a></dd>
  </dl>
<dl>
  <dt class="dt3"><a href="article_cat-8.html" title="如何支付" rel="nofollow">如何支付</a></dt>
    <dd><a href="help.php?id=15" title="网银支付 " rel="nofollow">网银支付</a></dd>
    <dd><a href="help.php?id=16" title="支付宝支付" rel="nofollow">支付宝支付</a></dd>
    <dd><a href="help.php?id=53" title="预存款支付" rel="nofollow">预存款支付</a></dd>
  </dl>
<dl>
  <dt class="dt4"><a href="article_cat-9.html" title="售后服务" rel="nofollow">售后服务</a></dt>
    <dd><a href="help.php?id=18" title="退换货流程" rel="nofollow">退换货流程</a></dd>
    <dd><a href="help.php?id=19" title="退换货政策 " rel="nofollow">退换货政策</a></dd>
    <dd><a href="help.php?id=20" title="退款说明" rel="nofollow">退款说明</a></dd>
  </dl>
<dl>
  <dt class="dt5"><a href="article_cat-10.html" title="常见问题" rel="nofollow">常见问题</a></dt>
    <dd><a href="help.php?id=21" title="投诉建议" rel="nofollow">投诉建议</a></dd>
    <dd><a href="help.php?id=22" title="服务条款" rel="nofollow">服务条款</a></dd>
    <dd><a href="help.php?id=66" title="非会员购物指南" rel="nofollow">非会员购物指南</a></dd>
  </dl>
</div>
</div>