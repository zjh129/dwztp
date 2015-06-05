<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('Index/changepwd');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div class="pageFormContent" layoutH="58">
      <div class="unit">
        <label>旧密码：</label>
        <input type="password" name="oldPassword" size="30" minlength="5" maxlength="20" class="required" />
      </div>
      <div class="unit">
        <label>新密码：</label>
        <input type="password" id="cp_newPassword" name="newPassword" size="30" minlength="5" maxlength="20" class="required alphanumeric"/>
      </div>
      <div class="unit">
        <label>重复输入新密码：</label>
        <input type="password" name="rnewPassword" size="30" equalTo="#cp_newPassword" class="required alphanumeric"/>
      </div>
      <div class="unit">
        <label>验证码：</label>
        <input type="text" size="10" name="verify" class="required"/>&nbsp;&nbsp;&nbsp;<img alt="" src="<?php echo U('Public/verify');?>" style="cursor:pointer;" onClick="this.src='<?php echo U('Public/verify');?>?'+Math.random()">
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