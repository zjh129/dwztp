<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
  <input type="hidden" name="pageNum" value="1" />
  <input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
  <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
</form>
<div class="pageHeader">
  <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo U('User/index');?>" method="post">
    <div class="searchBar">
      <ul class="searchContent">
        <li>
          <label>关键词搜索：</label>
          <input type="text" name="keywords" value="<?php echo ($keywords); ?>"/>
        </li>
      </ul>
      <div class="subBar">
        <ul>
          <li>
            <div class="buttonActive">
              <div class="buttonContent">
                <button type="submit">搜索</button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </form>
</div>
<div class="pageContent">
  <div class="panelBar">
    <ul class="toolBar">
      <?php if( ishavepower('User/add') ){ ?><li><a class="add" href="<?php echo U('User/add');?>" mask="true" target="dialog" width="800" height="400"><span>添加</span></a></li><?php } ?> 
      <li class="line">line</li>
      <?php if( ishavepower('User/edit') ){ ?><li><a class="edit" href="<?php echo U('User/edit');?>?uid={sid_user}" mask="true" target="dialog" width="800" height="400" warn="请选择一个用户"><span>修改</span></a></li><?php } ?> 
      <li class="line">line</li>
      <?php if( ishavepower('User/batchdel') ){ ?><li><a title="确实要删除这些用户吗?" target="selectedTodo" rel="ids" postType="string" href="<?php echo U('User/batchdel');?>" class="delete"><span>批量删除</span></a></li><?php } ?> 
    </ul>
  </div>
  <table class="table" layoutH="138" width="100%">
    <thead>
      <tr>
        <th><input type="checkbox" group="ids" class="checkboxCtrl"></th>
        <th orderField="accountNo" class="asc">用户帐号</th>
        <th orderField="accountName">用户名称</th>
        <th orderField="accountRole">所属角色</th>
        <th>电子邮箱</th>
        <th orderField="accountType">最后登陆时间</th>
        <th orderField="accountCert">最后登录IP</th>
        <th align="center" orderField="accountLevel">登录次数</th>
        <th>创建日期</th>
        <th>激活状态</th>
        <th align="center">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo["id"]); ?>">
          <td><input name="ids" value="<?php echo ($vo["id"]); ?>" type="checkbox"></td>
          <td><?php echo ($vo["account"]); ?></td>
          <td><?php echo ($vo["nickname"]); ?></td>
          <td><?php echo ($vo["role_list"]); ?></td>
          <td><?php echo ($vo["email"]); ?></td>
          <td><?php if(!empty($vo["last_login_time"])): echo (date("Y-m-d H:i:s",$vo["last_login_time"])); endif; ?></td>
          <td><?php if(!empty($vo["last_login_ip"])): echo ($vo["last_login_ip"]); endif; ?></td>
          <td><?php echo ($vo["login_count"]); ?></td>
          <td><?php if(!empty($vo["create_time"])): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
          <td>
          <?php if( ishavepower('User/c_status') ){ ?>
          <?php if(($vo["status"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('User/c_status');?>?act=0&uid=<?php echo ($vo["id"]); ?>"><img src="__PUBLIC__/images/ok.gif" /></a>
            <?php else: ?>
            <a target="ajaxTodo" href="<?php echo U('User/c_status');?>?act=1&uid=<?php echo ($vo["id"]); ?>"><img src="__PUBLIC__/images/locked.gif" /><?php endif; ?>
            <?php } ?> 
            </td>
          <td align="center">
          <?php if( ishavepower('User/view') ){ ?><a title="查看" mask="true" target="dialog" width="800" height="400" href="<?php echo U('User/view');?>?uid=<?php echo ($vo["id"]); ?>" class="btnView">查看</a><?php } ?> 
          <?php if( ishavepower('User/edit') ){ ?><a title="基本信息编辑" mask="true" target="dialog" width="800" height="400" href="<?php echo U('User/edit');?>?uid=<?php echo ($vo["id"]); ?>" class="btnEdit">编辑</a><?php } ?> 
          <?php if( ishavepower('User/del') ){ ?><a title="删除" target="ajaxTodo" href="<?php echo U('User/del');?>?uid=<?php echo ($vo["id"]); ?>" class="btnDel">删除</a><?php } ?> 
          <!--<a title="用户所属角色编辑" width="800" height="400" target="dialog" href="<?php echo U('User/RoleEdit',array('uid'=>$vo['id']));?>" class="btnEdit">权限编辑</a>-->
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
  <div class="panelBar">
    <div class="pages"> <span>显示</span>
      <select class="combox" name="numPerPage" onChange="navTabPageBreak({numPerPage:this.value})">
       <option value="5"<?php if(($numPerPage) == "5"): ?>selected="selected"<?php endif; ?>>5</option>
      	<option value="10"<?php if(($numPerPage) == "10"): ?>selected="selected"<?php endif; ?>>10</option>
        <option value="20"<?php if(($numPerPage) == "20"): ?>selected="selected"<?php endif; ?>>20</option>
        <option value="50"<?php if(($numPerPage) == "50"): ?>selected="selected"<?php endif; ?>>50</option>
        <option value="100"<?php if(($numPerPage) == "100"): ?>selected="selected"<?php endif; ?>>100</option>
        <option value="200"<?php if(($numPerPage) == "200"): ?>selected="selected"<?php endif; ?>>200</option>
      </select>
      <span>条，共<?php echo ($totalCount); ?>条</span> </div>
    <div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="10" currentPage="<?php echo ($currentPage); ?>"></div>
  </div>
</div>