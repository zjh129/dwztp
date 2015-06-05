<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <div class="pageFormContent nowrap" layoutH="0">
    <fieldset>
      <legend>用户详细信息</legend>
      <dl>
        <dt>用户帐号：</dt>
        <dd>
          <?php echo ($data["account"]); ?>
        </dd>
      </dl>
      <dl>
        <dt>用户名称：</dt>
        <dd>
          <?php echo ($data["nickname"]); ?>
        </dd>
      </dl>
      <dl>
        <dt>最后登录时间：</dt>
        <dd>
          <?php if(!empty($data["last_login_time"])): echo (date("Y-m-d H:i:s",$data["last_login_time"])); endif; ?>
        </dd>
      </dl>
      <dl>
        <dt>最后登录IP：</dt>
        <dd>
          <?php if(!empty($data["last_login_ip"])): echo ($data["last_login_ip"]); endif; ?>
        </dd>
      </dl>
      <dl>
        <dt>登录次数：</dt>
        <dd>
          <?php echo ($data["login_count"]); ?>
        </dd>
      </dl>
      <dl>
        <dt>电子邮箱：</dt>
        <dd>
          <?php echo ($data["email"]); ?>
        </dd>
      </dl>
      <dl>
        <dt>备注：</dt>
        <dd>
          <?php echo ($data["remark"]); ?>
        </dd>
      </dl>
      <dl>
        <dt>创建时间：</dt>
        <dd>
          <?php if(!empty($data["create_time"])): echo (date("Y-m-d H:i:s",$data["create_time"])); endif; ?>
        </dd>
      </dl>
      <dl>
        <dt>激活状态：</dt>
        <dd>
          <?php if(($data["status"]) == "1"): ?><font color="#006600">已激活</font><?php else: ?><font color="#FF0000">已锁定</font><?php endif; ?>
        </dd>
      </dl>
    </fieldset>
  </div>
</div>