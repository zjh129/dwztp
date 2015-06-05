<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('Public/checkLogin');?>" class="pageForm" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div class="pageFormContent" layoutH="58">
      <div class="unit">
        <label>用户名：</label>
        <input type="text" name="account" size="30" class="required" />
      </div>
      <div class="unit">
        <label>密码：</label>
        <input type="password" name="password" size="30" class="required" />
      </div>
      <div class="unit">
        <label>验证码：</label>
        <input type="text" name="verify" size="10" class="required" /><img alt="" src="<?php echo U('Public/verify');?>" style="cursor:pointer;" onClick="this.src='<?php echo U('Public/verify');?>?'+Math.random()">
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li>
          <div class="buttonActive">
            <div class="buttonContent">
              <button type="submit">提交</button>
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