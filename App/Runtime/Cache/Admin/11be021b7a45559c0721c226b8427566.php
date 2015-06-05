<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
    <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
    <input type="hidden" name="type" value="<?php echo ($type); ?>" />
</form>


<div class="pageHeader">
	<form rel="pagerForm"onsubmit="return navTabSearch(this);" action="__ACTION__" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					关键字：<input type="text" value="<?php echo ($keywords); ?>" name="keywords" />
				</td>
				<td>
					<select class="combox" name="type">
                    	<option value="0">请选择</option>
                    	<?php if(is_array($link_type)): $k = 0; $__LIST__ = $link_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>" <?php if(($k) == $type): ?>selected="selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
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
			<?php if( ishavepower('Link/add') ){ ?><li><a class="add" href="<?php echo U('Link/add');?>" target="navTab" rel="link_add"><span>添加友情链接</span></a></li><?php } ?>
            <?php if( ishavepower('Link/edit') ){ ?><li><a class="edit" href="<?php echo U('Link/edit');?>?linkid={linkid}" target="navTab" rel="link_edit" title="编辑友情链接" warn="请指定要修改的友情链接"><span>修改友情链接</span></a></li><?php } ?>
            <li class="line">line</li>
            <?php if( ishavepower('Link/create_cache') ){ ?><li><a class="icon" href="<?php echo U('Link/create_cache');?>" target="ajaxTodo" ><span>更新友情链接缓存</span></a></li><?php } ?>
		</ul>
	</div>
	<table class="table" layoutH="138" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>标题</th>
				<th>URL</th>
				<th>排序</th>
				<th>类目</th>
				<th>状态</th>
				<th>添加时间</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="linkid" rel="<?php echo ($vo["id"]); ?>">
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["title"]); ?></td>
				<td><?php echo ($vo["url"]); ?></td>
				<td><?php echo ($vo["sort"]); ?></td>
				<td><?php echo ($link_type[ $vo['type'] ]); ?></td>
				<td><?php if(($vo["status"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('Link/change_status',array('link_id' => $vo['id'],'status' => 0));?>"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('Link/change_status',array('link_id' => $vo['id'],'status'=>1));?>"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
				<td align="center">
                    <?php if( ishavepower('Link/edit') ){ ?><a title="编辑" target="navTab" rel="link_edit" href="<?php echo U('Link/edit',array('linkid'=>$vo['id']));?>" class="btnEdit">编辑</a><?php } ?>
                    <?php if( ishavepower('Link/del') ){ ?><a title="你确定删除该友情链接吗？" target="ajaxTodo" href="<?php echo U('Link/del',array('linkid'=>$vo['id']));?>" class="btnDel">删除</a><?php } ?>
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