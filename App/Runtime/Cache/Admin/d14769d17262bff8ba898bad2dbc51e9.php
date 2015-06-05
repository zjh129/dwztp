<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
    <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
</form>


<div class="pageHeader">
	<form rel="pagerForm"onsubmit="return navTabSearch(this);" action="<?php echo U('Article/index');?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					关键字：<input type="text" value="<?php echo ($keywords); ?>" name="keywords" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
		  </ul>
	  </div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<?php if( ishavepower('Member/add') ){ ?><li><a class="add" href="<?php echo U('Member/add');?>" target="navTab" rel="member_add"><span>新增会员</span></a></li><?php } ?>
            <?php if( ishavepower('Member/edit') ){ ?><li><a class="edit" href="<?php echo U('Member/edit');?>?u_id={u_id}" target="navTab" rel="member_edit" title="修改会员信息" warn="请指定要修改的会员"><span>修改会员信息</span></a></li><?php } ?>
            <li class="line">line</li>
            <?php if( ishavepower('Member/course_config') ){ ?><li><a class="icon" href="<?php echo U('Member/course_config');?>" target="dialog" mask=true title="配置课程列表"><span>配置课程列表</span></a></li><?php } ?>
		</ul>
	</div>
	<table class="table" layoutH="138" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>帐号</th>
				<th>真实姓名</th>
				<th>联系方式</th>
				<th>学校</th>
				<th>班级</th>
				<th>是否VIP</th>
				<th>是否交费</th>
				<th>最后登录时间</th>
				<th>最后登录IP</th>
				<th>注册时间</th>
				<th align="center">激活状态</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="art_id" rel="<?php echo ($vo["id"]); ?>">
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["account"]); ?></td>
				<td><?php echo ($vo["u_name"]); ?></td>
				<td><?php echo ($vo["u_phone"]); ?></td>
				<td><?php echo ($vo["u_school"]); ?></td>
				<td><?php echo ($vo["u_grade"]); ?></td>
				<td><?php if(($vo["u_vip"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('Member/change_isvip');?>?u_id=<?php echo ($vo["id"]); ?>&isvip=0"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('Member/change_isvip');?>?u_id=<?php echo ($vo["id"]); ?>&isvip=1"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?></td>
				<td><?php if(($vo["u_reg"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('Member/change_isreg');?>?u_id=<?php echo ($vo["id"]); ?>&isreg=0"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('Member/change_isreg');?>?u_id=<?php echo ($vo["id"]); ?>&isreg=1"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["last_login_time"])); ?></td>
				<td><?php echo ($vo["last_login_ip"]); ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
				<td>
                <?php if( ishavepower('Member/change_status') ){ ?>
                <?php if(($vo["status"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('Member/change_status');?>?u_id=<?php echo ($vo["id"]); ?>&status=0"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('Member/change_status');?>?u_id=<?php echo ($vo["id"]); ?>&status=1"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?>
                <?php } ?></td>
				<td align="center">
                    <?php if( ishavepower('Member/edit') ){ ?><a title="编辑会员" target="navTab" rel="member_edit" href="<?php echo U('Member/edit',array('u_id'=>$vo['id']));?>" class="btnEdit">编辑会员</a><?php } ?>
                    <?php if( ishavepower('Member/del') ){ ?><a title="你确定删除该会员吗？" target="ajaxTodo" href="<?php echo U('Member/del',array('u_id'=>$vo['id']));?>" class="btnDel">删除会员</a><?php } ?>
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