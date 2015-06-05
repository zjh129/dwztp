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
		</ul>
	</div>
	<table class="table" layoutH="138" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>留言者身份</th>
				<th>昵称</th>
				<th>标题</th>
				<th>联系方式</th>
				<th>IP</th>
				<th>留言时间</th>
				<th align="center">是否显示</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="art_id" rel="<?php echo ($vo["id"]); ?>">
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php if(empty($vo["userid"])): ?>游客<?php else: ?>注册会员<?php endif; ?></td>
				<td><?php if(empty($vo["userid"])): echo ($vo["nickname"]); else: ?><a title="查看编辑会员" target="navTab" rel="member_edit" href="<?php echo U('Member/edit',array('u_id'=>$vo['userid']));?>"><?php echo ($vo["u_name"]); ?></a><?php endif; ?></td>
				<td><?php echo ($vo["title"]); ?></td>
				<td><?php echo ($vo["tel"]); ?></td>
				<td><?php echo ($vo["ip"]); ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
				<td><?php if(($vo["disp"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('Book/change_disp');?>?id=<?php echo ($vo["id"]); ?>&disp=0"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('Book/change_disp');?>?id=<?php echo ($vo["id"]); ?>&disp=1"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?></td>
				<td align="center">
                    <?php if( ishavepower('Book/edit') ){ ?><a title="查看回复留言" target="dialog" mask=true rel="member_edit" href="<?php echo U('Book/edit',array('id'=>$vo['id']));?>" class="btnEdit">查看回复留言</a><?php } ?>
                    <?php if( ishavepower('Book/del') ){ ?><a title="你确定删除该条留言吗？" target="ajaxTodo" href="<?php echo U('Book/del',array('id'=>$vo['id']));?>" class="btnDel">删除留言</a><?php } ?>
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