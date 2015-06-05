<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('Attribute/edit');?>" class="pageForm required-validate" onSubmit="return validateCallback(this, dialogAjaxDone);">
  <input type="hidden" name="attr_id" id="attr_id" value="<?php echo ($data["attr_id"]); ?>" />
    <div class="pageFormContent" layoutH="56">
      <dl>
        <dt>属性名称：</dt>
        <dd>
          <input name="attr_name" class="required" type="text" size="30" value="<?php echo ($data["attr_name"]); ?>" />
        </dd>
      </dl>
      <dl>
        <dt>所属商品类型：</dt>
        <dd>
          <label for="type_id"></label>
          <select name="type_id" id="type_id" class="combox">
          <?php if(is_array($goodstype_list)): $i = 0; $__LIST__ = $goodstype_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type_id"]); ?>"<?php if(($vo["type_id"]) == $data["type_id"]): ?>selected<?php endif; ?>><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </dd>
      </dl>
      <dl class="nowrap">
        <dt>属性是否可选：</dt>
        <dd style="width:350px;">
          <label style="width:100px; float:left;">
            <input name="attr_type" type="radio" id="attr_type_0" value="0"<?php if(($data["attr_type"]) == "0"): ?>checked="checked"<?php endif; ?> />
            唯一属性</label>
          <label style="width:100px; float:left;">
            <input type="radio" name="attr_type" value="1" id="attr_type_1"<?php if(($data["attr_type"]) == "1"): ?>checked="checked"<?php endif; ?> />
            单选属性</label>
          <label style="width:100px; float:left;">
            <input type="radio" name="attr_type" value="2" id="attr_type_2"<?php if(($data["attr_type"]) == "2"): ?>checked="checked"<?php endif; ?> />
            复选属性</label>
        </dd>
      </dl>
      <dl class="nowrap">
        <dt>该属性值的录入方式：</dt>
        <dd style="width:520px;">
          <label style="width:100px; float:left;">
            <input name="attr_input_type" type="radio" id="attr_input_type_0" value="0"<?php if(($data["attr_input_type"]) == "0"): ?>checked="checked"<?php endif; ?> />
            手工录入</label>
          <label style="width:280px; float:left;">
            <input type="radio" name="attr_input_type" value="1" id="attr_input_type_1"<?php if(($data["attr_input_type"]) == "1"): ?>checked="checked"<?php endif; ?> />
            从下面的列表中选择（一行代表一个可选值）</label>
          <label style="width:100px; float:left;">
            <input type="radio" name="attr_input_type" value="2" id="attr_input_type_2"<?php if(($data["attr_input_type"]) == "2"): ?>checked="checked"<?php endif; ?> />
            多行文本框</label>
        </dd>
      </dl>
      <dl class="nowrap">
        <dt>可选值列表：</dt>
        <dd>
          <label for="attr_value"></label>
          <textarea name="attr_value" id="attr_value" cols="45" rows="5"><?php echo ($data["attr_value"]); ?></textarea>
        </dd>
      </dl>
      <dl>
        <dt>排序值：</dt>
        <dd>
          <label for="sort"></label>
          <input type="text" class="required digits" name="sort" id="sort" value="<?php echo ($data["sort"]); ?>" />
        </dd>
      </dl>
    </div>
    <div class="formBar">
      <ul>
        <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
        <li>
          <div class="buttonActive">
            <div class="buttonContent">
              <button type="submit">保存</button>
            </div>
          </div>
        </li>
        <li>
          <div class="button">
            <div class="buttonContent">
              <button type="button" class="close">取消</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
	<?php if(($data["attr_input_type"]) != "1"): ?>$("#attr_value").attr({disabled:true});<?php endif; ?>
	$("input[name='attr_input_type']").change(function(){
		if(this.value==1){
			$("#attr_value").attr({disabled:false});
			$("#attr_value").addClass("required");
		}else{
			$("#attr_value").val("");
			$("#attr_value").removeClass("required");
			$("#attr_value").attr({disabled:true});
		}
	});
});
</script>