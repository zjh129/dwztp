<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<form method="post" action="<?php echo U('Category/edit');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone
);">
		<input type="hidden" name="cat_id" value="<?php echo ($cat_id); ?>" />
		<input type="hidden" name="submit_chk" value="1" />
		<div class="pageFormContent" layoutH="56">
			<p>
				<label>商品分类名称：</label>
				<input class="required textInput valid" name="cat_name" type="text" size="30" value="<?php echo ($cat_name); ?>"/>
			</p>
			<p>
				<label>上层分类：</label>
				<?php echo ($cat_select); ?>
			</p>
			<p>
				<label>分类模板：</label>
				<input  type="text" size="30" value="<?php echo ($template_file); ?>"/>
			</p>
			<p>
				<label>排序：</label>
				<input name="sort" type="text" size="15" value="<?php echo ($sort); ?>" />
			</p>
			<p>
				<label>状态：</label>
	          	<label style="width:100px; float:left;">
	            	<input name="is_show" id="status_0" value="1" <?php if(($is_show) == "1"): ?>checked="checked"<?php endif; ?> type="radio">显示
	            </label>
	          	<label style="width:100px; float:left;">
	            	<input name="is_show" value="0" id="status_1" <?php if(($is_show) == "0"): ?>checked="checked"<?php endif; ?> type="radio">隐藏
	            </label>
			</p>
			<p>
				<label>关键字：</label>
				<input name="keywords" type="text" size="30" value="<?php echo ($keywords); ?>"/>
			</p>
			<p>
				<label>分类描述：</label>
				<textarea cols="30" rows="3" name="cat_desc" class="textInput valid"><?php echo ($cat_desc); ?></textarea>
			</p>
		</div>
		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>