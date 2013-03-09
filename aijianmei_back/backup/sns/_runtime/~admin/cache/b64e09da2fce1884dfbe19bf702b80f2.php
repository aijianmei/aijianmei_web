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
<?php if (!$is_support) { ?>
    <h3 style="color:red;">注意: 自动升级程序仅适用于ThinkSNS 2.1 Final Build 10920 / 10992, 而您的站点的版本为: <?php echo ($system_version); ?></h3>
<?php }else { ?>
    <div id="container" class="so_main">
        <div class="page_tit">欢迎使用<?php echo ($ts['site']['site_name']); ?></div>
        <div class="Toolbar_inbox" style="color:red;">提示：升级前，请先备份数据库和代码。然后下载升级包，通过ftp工具等方法上传升级文件，覆盖代码。然后点击“升级”，直到完成升级。</div>
        <div class="list">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <th class="line_l" style="width:40px;">应用名</th>
             <th class="line_l" style="width:80px;">当前版本</th>
             <th class="line_l" style="width:65px;">当前版本号</th>
             <th class="line_l" style="width:65px;">是否有更新</th>
             <th class="line_l" style="width:80px;">最新版本</th>
             <th class="line_l" style="width:65px;">最新版本号</th>
             <th class="line_l" style="width:80px;">下载地址</th>
             <th class="line_l">ChangeLog</th>
             <th class="line_l" style="width:30px;">操作</th>
            </tr>
        <?php foreach ($current_version as $app => $version) { ?>
          <tr overstyle='on'>
            <td><?php echo ($app); ?></td>
            <td><?php echo $app == 'core' ? $system_version : '&nbsp;' ?></td>
            <td><?php echo ($version); ?></td>
            <?php $error = '';
            if ($lastest_version['error'])
                $error = $lastest_version['error_message'];
            else if ($lastest_version[$app]['error'])
                $error = $lastest_version[$app]['error_message']; ?>
            <?php if (!$error) { ?>
              <td><?php echo $lastest_version[$app]['has_update'] ? '<span style="color:red;">有更新</span>' : '无更新'; ?></td>
              <td><?php echo ($lastest_version[$app]['lastest_version']); ?></td>
              <td><?php echo ($lastest_version[$app]['lastest_version_number']); ?></td>
              <td>
              <?php if ($lastest_version[$app]['has_update']) { ?>
                <a href="<?php echo ($lastest_version[$app]['download_url']); ?>" target="_blank">http://www.thinksns.com</a>
              <?php } else { echo ''; } ?>
              </td>
              <td><pre><?php echo ($lastest_version[$app]['changelog']); ?></pre></td>
              <td>
              <?php // 检查升级用SQL文件, 以确定"下载"还是"升级"
              $temp_version = $lastest_version[$app]['lastest_version_number'];
              if ($app == 'core')
                  $path = SITE_PATH . '/update/core_' . $temp_version . '.sql';
              else
                  $path = SITE_PATH . '/apps/' . $app . '/Appinfo/' . $app . '_' . $temp_version . '.sql'; ?>
              <?php if ($lastest_version[$app]['has_update'] && is_file($path)) { ?>
                <a href="<?php echo U('admin/Home/doUpdate', array('app_name'=>$app));?>" onclick="return confirm('升级前请备份数据库, 确认升级?');">升级</a>
              <?php }else if ($lastest_version[$app]['has_update']) { ?>
                <a href="<?php echo ($lastest_version[$app]['download_url']); ?>" target="_blank">下载</a>
              <?php }else { echo ''; } ?>
              </td>
            <?php }else { ?>
              <td>错误: <span style="color:red;"><?php echo ($error); ?></span></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            <?php } ?>
          </tr>
        <?php } ?>
        </table>
        </div>
        <div class="Toolbar_inbox">&nbsp;</div>
    </div>
    <script>
    //鼠标移动表格效果
    $(document).ready(function(){
        $("tr[overstyle='on']").hover(
          function () {
            $(this).addClass("bg_hover");
          },
          function () {
            $(this).removeClass("bg_hover");
          }
        );
    });
    </script>
<?php } ?>
</body>
</html>