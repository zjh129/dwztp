<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('GoodsType/edit');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
  <input type="hidden" name="type_id" id="type_id" value="<?php echo ($data["type_id"]); ?>" />
    <div class="pageFormContent" layoutH="56">
      <dl>
        <dt>商品类型名称</dt>
        <dd>
          <input name="type_name" class="required" type="text" size="30" value="<?php echo ($data["type_name"]); ?>" />
        </dd>
      </dl>
      <dl>
        <dt>是否启用此商品类型：</dt>
        <dd>
          <label style="width:100px; float:left;">
            <input name="is_enable" type="radio" id="is_enable_0" value="1"<?php if(($data["is_enable"]) == "1"): ?>checked="checked"<?php endif; ?> />
            启用</label>
          <label style="width:100px; float:left;">
            <input type="radio" name="is_enable" value="0" id="is_enable_1"<?php if(($data["is_enable"]) == "0"): ?>checked="checked"<?php endif; ?> />
            不启用</label>
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