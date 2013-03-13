<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($ts['site']['site_name']); ?>管理后台</title>
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/js/tbox/box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var _UID_ = "<?php echo ($uid); ?>";
	var _PUBLIC_ = "__PUBLIC__";	
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tbox/box.js"></script>
</head>
<body>

<!-- 编辑器样式文件 -->
<link href="__PUBLIC__/js/editor/editor/theme/base-min.css" rel="stylesheet"/>
<!--[if lt IE 8]>
<link href="__PUBLIC__/js/editor/editor/theme/cool/editor-pkg-sprite-min.css" rel="stylesheet"/>
<![endif]-->
<!--[if gte IE 8]><!-->
<link href="__PUBLIC__/js/editor/editor/theme/cool/editor-pkg-min-datauri.css" rel="stylesheet"/>
<!--<![endif]-->

<?php
// 读取附件大小的配置
$_editor_system_default = model('Xdata')->lget('attach');
$_editor_size_limit = empty($_editor_system_default['attach_max_size']) ? 2 : $_editor_system_default['attach_max_size']; // 默认2M
$_editor_size_limit = floatval($_editor_size_limit) * 1000; // K
?>

<!-- 引入编辑器相关的JS文件 -->
<script src="__PUBLIC__/js/editor/kissy-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/uibase-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/dd-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/component-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/overlay-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/editor/editor-all-pkg-min.js?t=20120401"></script>
<script src="__PUBLIC__/js/editor/editor/biz/ext/editor-plugin-pkg-min.js?t=20120401"></script>
<script>
<?php echo "var limitSize = '".$_editor_size_limit."';"; ?>
var _KISSY_ = {};

function loadEditor(textareaId){
	setTimeout("_loadEditor('"+textareaId+"')",100);}
function _loadEditor(textareaId) {
    KISSY.Editor.Config.base = "__PUBLIC__/js/editor/editor/plugins/";
    KISSY.use('editor', function() {
        var KE = KISSY.Editor;
        var EDITER_UPLOAD = "<?php echo U('home/Attach/kissy'); ?>";
        //编辑器内弹窗 z-index 底限，防止互相覆盖
        KE.Config.baseZIndex = 999999;
        var cfg = {
            attachForm:true,
            baseZIndex:10000,
            focus:false,
            pluginConfig: {
                "image":{
                    upload:{
                        serverUrl:EDITER_UPLOAD,
                        surfix:"png,jpg,jpeg,gif,bmp",
                        sizeLimit:limitSize
                    }
                },
                "flash":{
                    defaultWidth:"300",
                    defaultHeight:"300"
                },
                "resize":{
                    direction:["y"]
                }
            }
        };
        _KISSY_[textareaId] = KE("#"+textareaId, cfg);
        _KISSY_[textareaId].use(
            "font,link,image,flash,xiami-music,smiley");
    });
}

function getEditorContent(textareaId)
{
    return _KISSY_[textareaId].getData();
}

function setEditorContent(textareaId,html)
{
    return _KISSY_[textareaId].setData(html);
}

function getEditorWordCount() {
	var count = 0;
	return count;
}
</script>

<div class="so_main">
  <div id="editTpl_div">
  	<div class="page_tit"><?php if(($type)  ==  "edit"): ?>编辑<?php else: ?>添加<?php endif; ?>文章</div>
	<div class="form2">
	<form method="post" action="<?php echo U('admin/Article/add');?>" enctype="multipart/form-data">
	<?php if(($type)  ==  "edit"): ?><input type="hidden" name="aid" value="<?php echo ($article['id']); ?>"><?php endif; ?>
    <dl class="lineD">
    <!-- 限制标题框字数最大 为16-->
    <script language="JavaScript">
    function WidthCheck(str, maxLen){  
    	 var w = 0;  
    	 var tempCount = 0; 
    	        //length 获取字数数，不区分汉字和英文 
    	 for (var i=0; i<str.value.length; i++) {  
    	                      //charCodeAt()获取字符串中某一个字符的编码 
    	 var c = str.value.charCodeAt(i);  
    	 //单字节加1  
    	 if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {  
    	 w++;  
    	 } 
    	 else {    
    	 w+=2;  
    	 }  
    	 if (w > maxLen) {  
    	 str.value = str.value.substr(0,i); 
    	 break; 
    	 }    
    	 }  
    	}
      </script>
      <dt>标题：</dt>
      <dd>
        <input name="title" type="text" value="<?php echo ($article['title']); ?>" onpropertychange="WidthCheck(this,32);"> *
                    注:限制最多输入16字
	  </dd>
    </dl>
    
    <dl class="lineD">
    	<dt>所属分类：</dt>
    	<dd>
    		<select name="category">
    			<?php foreach($categories as $c) { ?>
    			<option value="<?php echo ($c['id']); ?>" <?php if($article['category_id']==$c['id']){ ?> selected="selected"<?php } ?>><?php echo ($c['name']); ?></option>
    			<?php } ?>
    		</select>
    	</dd>
    </dl>
	
	<dl class="lineD">
		<dt>来源：</dt>
		<dd>
			<input name="source" type="text" value="<?php echo ($article['source']); ?>">
		</dd>
	</dl>
	
	<dl class="lineD">
		<dt>简要介绍：</dt>
		<dd>
			<input name="brief" type="text" value="<?php echo ($article['brief']); ?>" size="40">
		</dd>
	</dl>
	
	<dl class="lineD">
		<dt>作者：</dt>
		<dd>
			<input name="author" type="text" value="<?php echo ($article['author']); ?>" />
		</dd>
	</dl>
	
	<dl class="lineD">
		<dt>图片：</dt>
		<dd>
			<input type="file" name="img" id="img" />
		</dd>
	</dl>

    <dl class="lineD">
    	<dt>内容：</dt>
    	<dd>
    		<textarea name="content" id="content" style="width:650px;height:200px"><?php echo ($article['content']); ?></textarea>
    	</dd>
    </dl>
    
    <dl class="lineD">
    	<dt>关键词（多个关键词用逗号分隔）：</dt>
    	<dd>
    		<input name="keyword" type="text" value="<?php echo ($article['keyword']); ?>" size="40" />
    	</dd>
    </dl>
    
    
	
    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
	</form>
  </div>
  </div>
</div>

<script type="text/javascript" > 
var typeId = "<?php echo ($type_id); ?>";
$(document).ready(function(){
  bindListener();
 });
function bindListener(){
    $("a[name=rmlink]").unbind().click(function(){
        $(this).parent().remove(); 
    })
}
function delImg(obj) {
  var pObj = $(obj).parent();
  pObj.remove();
}

function addimg(){ 
  var banner =  $("input[id=banner]").val();
  var url = $("input[id=bannerUrl]").val();
   $("#mdiv").append('<div> <span style="color:red">*</span>Banner图片：<input type="file" name="banner[]" value=""  id="banner"/><span style="color:red">*</span> 链接地址：<input type="text" name="bannerUrl[]" value="" id="bannerUrl"><a href="javascript:void(0);" onclick="delImg(this)" name="rmlink">删除</a> <br></div>');
   bindListener();
} 
</script>

<script>
$(document).ready(function(){
	loadEditor("content");
  
});
</script>
</body>
</html>