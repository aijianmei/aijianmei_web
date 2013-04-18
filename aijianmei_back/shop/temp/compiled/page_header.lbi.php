<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div class="block clearfix">
	<div id="banner">
			<div class="lay_banner">
			<ul class="ul_1 clearfix">
				<li class="change_1">
					<a>
						<img src="themes/default/images/1.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/2.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/4.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
				<li class="change_1">
					<a>
						<img src="themes/default/images/5.jpg" alt="no" class="pic_1" />
						<div class="massage" style="display:inline-block;">
							<h1 class="title">此张大图名称</h1>
							<p>大图介绍：阿萨德合肥卡萨帝豪</p>
						</div>
					</a>
				</li>
			</ul>
			</div>
			<div class="choice_area">
			<ul class="ul_2 clearfix">
				<li class="first_choice">
					<img src="themes/default/images/1.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/2.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/4.jpg" alt="" class="relative_pic" />
				</li>
				<li>
					<img src="themes/default/images/5.jpg" alt="" class="relative_pic" />
				</li>
			</ul>
			<a class="ps_left"></a>
			<a class="ps_right"></a>
			</div>
		</div>	
        <script type="text/javascript" src="../apps/index/Tpl/default/Public/js/jquery.js"></script>
        <script type="text/javascript" src="../apps/index/Tpl/default/Public/js/public.js"></script>
</div>

<div class="clearfix" style="width:940px;margin-top:20px;">
<div id="search"  class="clearfix">
  <div class="keys f_l">
   <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
            return false;
        }
    }
    -->
    
    </script>
    <?php if ($this->_var['searchkeywords']): ?>
   <?php echo $this->_var['lang']['hot_search']; ?> ：
   <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
   <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <?php endif; ?>
  </div>
  <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
   <select name="category" id="category" class="B_input">
      <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
      <?php echo $this->_var['category_list']; ?>
    </select>
   <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="B_input" style="width:110px;"/>
   <input name="imageField" type="submit" value="" class="go" style="cursor:pointer;" />
   <a href="search.php?act=advanced_search"><?php echo $this->_var['lang']['advanced_search']; ?></a>
   </form>
</div>
</div>
