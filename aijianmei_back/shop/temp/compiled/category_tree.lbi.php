<div class="box">
 <div class="box_1">
  <div class="sider_all">
    <span class="border_line"></span>
    <h4 class="video_all">全部</h4>
    <span class="border_line"></span>
    <div id="category_tree">
      <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
       <dl>
       <?php if ($this->_var['cat']['cat_id']): ?>
       <dt><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></dt>
       <?php else: ?>
       <dd><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></dd>
       <?php endif; ?>
       <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
       <dd><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></dd>
         <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
         <dd>&nbsp;&nbsp;<a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></dd>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         
         </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
    <span class="border_line"></span>
  </div>
 </div>
</div>
<div class="blank5"></div>
