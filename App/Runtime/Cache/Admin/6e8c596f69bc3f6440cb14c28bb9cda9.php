<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($msgTitle); ?></title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/operatetip.css" />
<meta http-equiv='Refresh' content='<?php echo ($waitSecond); ?>;URL=<?php echo ($jumpUrl); ?>'>
</head>

<body>
<div class="wrapper <?php if(isset($message)): ?>success<?php else: ?>error<?php endif; ?>">
	<div class="box">
		<div class="content">
			<strong class="title"><?php if(isset($message)): echo ($msgTitle); else: echo ($msgTitle); endif; ?></strong>
			<div class="info">
            <?php if(isset($message)): echo ($message); else: echo ($error); endif; ?></div>
		</div>
		<div class="buttons">
			<a class="buttonwrap" href="/"><span class="inner"><strong class="button">返回首页</strong></span></a>
			<a class="buttonwrap" href="<?php echo ($jumpUrl); ?>"><span class="inner"><strong class="button">跳过等待</strong></span></a>
            <a class="buttonwrap" href="javascript:void(0);" onclick="javascript:history.back(1);"><span class="inner"><strong class="button">返回上一页</strong></span></a>
		</div>
	</div>
</div>
</body>
</html>