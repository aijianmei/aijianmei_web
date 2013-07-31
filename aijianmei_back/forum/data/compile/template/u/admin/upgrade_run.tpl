<!doctype html>
<html>
<head>
<meta charset="<?php echo htmlspecialchars(Wekit::V('charset'), ENT_QUOTES, 'UTF-8');?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','c','name'), ENT_QUOTES, 'UTF-8');?></title>
<link href="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','css'), ENT_QUOTES, 'UTF-8');?>/admin_style.css?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>" rel="stylesheet" />
<script>
//全局变量，是Global Variables不是Gay Video喔
var GV = {
	JS_ROOT : "<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','res'), ENT_QUOTES, 'UTF-8');?>/js/dev/",																									//js目录
	JS_VERSION : "<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>",																										//js版本号
	TOKEN : '<?php echo htmlspecialchars(Wind::getComponent('windToken')->saveToken('csrf_token'), ENT_QUOTES, 'UTF-8');?>',	//token ajax全局
	REGION_CONFIG : {},
	SCHOOL_CONFIG : {},
	URL : {
		LOGIN : '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','loginUrl'), ENT_QUOTES, 'UTF-8');?>',																													//后台登录地址
		IMAGE_RES: '<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','images'), ENT_QUOTES, 'UTF-8');?>',																										//图片目录
		REGION : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=misc&c=webData&a=area'; ?>',					//地区
		SCHOOL : '<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','index.php?m=misc&c=webData&a=school'; ?>'				//学校
	}
};
</script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/wind.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/jquery.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>

</head>
<body>
<div class="wrap">
<!-- mod start -->
<form method="post" class="J_ajaxForm" data-role="list" action="<?php echo Wind::getComponent('response')->getData('G', 'url', 'base'),'/','admin.php?m=u&c=upgrade&a=dosave'; ?>">
<!--div class="h_a">会员组提升方案</div-->
<div class="tabs_contents">
	<div class="table_list">
		<table width="100%">
			<col width="120">
			<col width="200">
			<thead>
				<tr>
					<td class="s5">类别</td>
					<td class="s5">系数</td>
					<td class="s5">综合积分</td>
				</tr>
			</thead>
			<tbody class="J_upgrade_list">
				<tr>
					<td>发帖数</td>
					<td><input name="member[postnum]" type="number" class="input" value="<?php echo htmlspecialchars($member['postnum'], ENT_QUOTES, 'UTF-8');?>"></td>
					<td rowspan="100" style="border-left:1px solid #e4e4e4;">
						<div class="J_upgrade_info">
						</div>
					</td>
				</tr>
				<tr>
					<td>精华</td>
					<td><input name="member[digest]" type="number" class="input" value="<?php echo htmlspecialchars($member['digest'], ENT_QUOTES, 'UTF-8');?>"></td>
				</tr>
				<?php  foreach ($credits->cType as $k => $v) { ?>
				<tr>
					<td><?php echo htmlspecialchars($v, ENT_QUOTES, 'UTF-8');?></td>
					<td><input name="member[credit<?php echo htmlspecialchars($k, ENT_QUOTES, 'UTF-8');?>]" type="number" class="input" value="<?php echo htmlspecialchars($member['credit'.$k], ENT_QUOTES, 'UTF-8');?>"></td>
				</tr>
				<?php  } ?>
				<tr>
					<td>会员历史在线时间</td>
					<td><input name="member[onlinetime]" type="number" class="input" value="<?php echo htmlspecialchars($member['onlinetime'], ENT_QUOTES, 'UTF-8');?>"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!-- mod end -->
<div class="btn_wrap">
	<div class="btn_wrap_pd" id="J_sub_wrap">
		<button class="btn btn_submit J_ajax_submit_btn" type="submit">提交</button>
	</div>
</div>
<input type="hidden" name="csrf_token" value="<?php echo WindSecurity::escapeHTML(Wind::getComponent('windToken')->saveToken('csrf_token')); ?>"/></form>

</div>
<script src="<?php echo htmlspecialchars(Wind::getComponent('response')->getData('G','url','js'), ENT_QUOTES, 'UTF-8');?>/pages/admin/common/common.js?v<?php echo htmlspecialchars(NEXT_RELEASE, ENT_QUOTES, 'UTF-8');?>"></script>
<script>
$(function(){

	//计算函数
	var compute = function (list) {
		var arr = [];
		list.find('tr').each(function() {
			var input = $(this).find('input.input');
			if(input) {
				var val = input.val();
				if( val != '') {
					var text = $(this).find('td:first').html();
					arr.push(text + '*' + val);
				}
			}
		});
		list.find('.J_upgrade_info').html( arr.join(' + ') );
	};

	$('.J_upgrade_list').each(function() {
		var list = $(this);
		compute(list);//载入时计算积分规则
		var isIE9 = $.browser.version == '9.0';
		list.find('input').each(function() {
			(function(elem) {
				if(isIE9) {//IE9对下面两个事件支持有缺陷
					var timer;
					$(elem).focus(function() {
						timer = setInterval(function(){
							compute(list);
						}, 64);
					}).blur(function() {
						clearInterval(timer);
					});
				}else if('oninput' in elem){
					elem.on('input',function() {
						compute(list);
					});
				}else{//IE6/7/8
					elem.onpropertychange = function() {
						if (window.event.propertyName == "value"){
							compute(list);
						}
					}
				}
			})(this);
		});
	});

});
</script>
</body>
</html>