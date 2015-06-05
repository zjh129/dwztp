<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('Role/edit');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
  <input type="hidden" name="id" value="<?php echo ($id); ?>" />
  <input type="hidden" name="level" value="<?php echo ($level); ?>" />
  <input type="hidden" name="pid" value="<?php echo ($id); ?>" />
    <div class="pageFormContent" layoutH="56">
      <dl>
        <dt>角色名称：</dt>
        <dd>
          <input name="name" class="required" type="text" value="<?php echo ($name); ?>" size="30" alt="请输入角色名称" />
        </dd>
      </dl>
      <dl style="height:auto;">
        <dt>状态：</dt>
        <dd>
          <label style="width:100px; float:left;">
            <input name="status" type="radio" id="status_0" value="1"<?php if(($status) == "1"): ?>checked="checked"<?php endif; ?> />
            激活</label>
          <label style="width:100px; float:left;">
            <input type="radio" name="status" value="0" id="status_1"<?php if(($status) == "0"): ?>checked="checked"<?php endif; ?> />
            不激活</label>
        </dd>
      </dl>
      <dl style="height:auto;">
        <dt>注释：</dt>
        <dd>
          <textarea name="remark" rows="3" cols="30"><?php echo ($remark); ?></textarea>
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