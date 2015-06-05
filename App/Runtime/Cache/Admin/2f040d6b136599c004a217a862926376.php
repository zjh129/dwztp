<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
<h2 class="contentTitle">角色用户选取</h2>
<form method="post" action="<?php echo U('Role/selectuser');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
<input type="hidden" name="role_id" id="role_id" value="<?php echo ($roleid); ?>" />
	<div class="pageFormContent" layoutH="98">
    <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label><input type="checkbox" name="user[]" value="<?php echo ($vo["id"]); ?>"<?php if(in_array( $vo['id'] , $roleuserlist )){ echo ' checked';} ?> /><?php echo ($vo["account"]); ?> <?php echo ($vo["nickname"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="formBar">
		<label style="float:left"><input type="checkbox" class="checkboxCtrl" group="user[]" />全选</label>
		<ul>
			<li><div class="button"><div class="buttonContent"><button type="button" class="checkboxCtrl" group="user[]" selectType="invert">反选</button></div></div></li>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
		</ul>
	</div>
</form>
</div>