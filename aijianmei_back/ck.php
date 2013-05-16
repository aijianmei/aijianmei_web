<include file="../Public/_header" />
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<link rel="stylesheet" href="ckeditor/sample.css">
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>

<div class="so_main">
  <div id="editTpl_div">
    <div class="page_tit"><eq name="type" value="edit">编辑<else/>添加</eq>文章</div>
    <div class="form2">
    <form method="post" action="{:U('admin/Article/add')}" enctype="multipart/form-data">
    <eq name="type" value="edit"><input type="hidden" name="aid" value="{$article['id']}"></eq>
    <dl class="lineD">
    <!-- 限制标题框字数最大 为16-->
    <script language="JavaScript">
    function WidthCheck(str, maxLen){  
        var _zh = str.value ? text.match(/[^ -~]/g) : 0;
        var num = 140-Math.ceil((str.value + (_zh && _zh.length) || 0)/2); 
        }
      </script>
      <dt>标题：</dt>
      <dd>
        <input name="title" type="text" value="{$article['title']}" onpropertychange="WidthCheck(this,32);"> *
                    注:限制最多输入16字
      </dd>
    </dl>
    
    <dl class="lineD" id="categoryDiv">
        <dt>所属分类：</dt>
        <dd id="categoryDiv">
            <select name="category" id="category">
                <php>foreach($categories as $c) {</php>
                <option value="{$c['id']}" <php>if($article['category_id']==$c['id']){</php> selected="selected"<php>}</php>>{$c['name']}</option>
                <php>}</php>
            </select>
            <a href="javascript:void(0);" onclick="getMoreCategory()"> 更多分类</a>
        </dd>
    </dl>
    <dl class="lineD">
        <dt>来源：</dt>
        <dd>
            <input name="source" type="text" value="{$article['source']}">
        </dd>
    </dl>
    
    <dl class="lineD">
        <dt>简要介绍：</dt>
        <dd>
            <input name="brief" type="text" value="{$article['brief']}" size="40">
        </dd>
    </dl>
    
    <dl class="lineD">
        <dt>作者：</dt>
        <dd>
            <input name="author" type="text" value="{$article['author']}" />
        </dd>
    </dl>
    
    <dl class="lineD">
        <dt>图片：</dt>
        <dd>
            <input type="file" name="img" id="img" value="{$article['author']}"/>
            水印<input name="iswaterimg" type="checkbox" value="1" checked="checked"/>
        </dd>
    </dl>

	    <dl class="lineD">
        <dt>内容：</dt>
        <dd>
			<textarea cols="80" id="content" name="content" rows="10">{$article['content']}</textarea>
		<script>

			CKEDITOR.replace( 'content', {
				fullPage: true,
				allowedContent: true,
				extraPlugins: 'wysiwygarea',
				language : 'zh-cn',
				filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
				filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
				filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
				});
	</script>
        </dd>
    </dl>
    
    <dl class="lineD">
        <dt>关键词（多个关键词用逗号分隔）：</dt>
        <dd>
            <input name="keyword" type="text" value="{$article['keyword']}" size="40" />
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
var typeId = "{$type_id}";
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
function getMoreCategory(){
    var innerHtml='<dl class="lineD"><dt>其他分类：</dt><dd><select name="morecategory[]">'+$("#category").html()+'</dd></dl></select>';
     $("#categoryDiv").append(innerHtml)

}
function delCategory(obj){
if (!confirm("确认删除")){ return false;}
var id= $(obj).attr('delid');
$(obj).parent().parent().remove();
}


</script>

<script>
$(document).ready(function(){
    loadEditor("content");
  
});
</script>
<include file="../Public/_footer" />