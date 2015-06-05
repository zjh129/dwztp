<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('System/add');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
  <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    <div class="pageFormContent" layoutH="57">
      <dl>
        <dt>字段名</dt>
        <dd>
          <input name="name" class="required" type="text" size="30" value="<?php echo ($data["name"]); ?>" alt="请输入字段名称" />
        </dd>
      </dl>
      <dl>
        <dt>字段标识：</dt>
        <dd>
          <input name="key" class="required" type="text" size="30" value="<?php echo ($data["key"]); ?>" alt="请输入客户名称" />
        </dd>
      </dl>
      <dl style="height:auto;">
        <dt>字段值：</dt>
        <dd>
          <textarea class="required" cols="45" rows="5" name="value"><?php echo ($data["value"]); ?></textarea>
        </dd>
      </dl>
      <dl>
        <dt>字段描述</dt>
        <dd>
        	<input name="des" type="text" size="50" value="<?php echo ($data["des"]); ?>" alt="请输入字段描述" />
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