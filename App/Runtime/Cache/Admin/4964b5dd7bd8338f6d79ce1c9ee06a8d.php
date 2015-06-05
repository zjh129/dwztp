<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">系统信息</h2>
<fieldset>
  <legend>版权信息</legend>
  <div style="padding:10px;">本系统基于国内知名的PHP框架-TinkPHP，免费开源.</div>
</fieldset>
<fieldset>
  <legend>系统参数</legend>
  <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl class="nowrap">
      <dt style="width:150px; color:#090;"><?php echo ($key); ?></dt>
      <dd><?php echo ($vo); ?></dd>
    </dl><?php endforeach; endif; else: echo "" ;endif; ?>
</fieldset>