<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<?php if( ishavepower('System/add') ){ ?><li><a class="add" href="<?php echo U('System/add');?>" target="dialog" mask=true title="添加系统参数"><span>添加</span></a></li><?php } ?>
			<?php if( ishavepower('System/add') ){ ?><li><a class="edit" href="<?php echo U('System/add');?>?id={sid}" target="dialog" mask=true title="修改系统参数" warn="请选择一条数据"><span>修改</span></a></li><?php } ?>
            <?php if( ishavepower('System/create_cache') ){ ?><li><a class="icon" href="<?php echo U('System/create_cache');?>" target="ajaxTodo" ><span>生成缓存</span></a></li><?php } ?>
		</ul>
	</div>
	<table class="table" layoutH="138" width="100%">
		<thead>
			<tr>
				<th><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th orderField="accountNo" class="asc">ID</th>
				<th orderField="accountName">名称</th>
				<th orderField="accountKey">标识</th>
				<th orderField="accountDes">值</th>
				<th orderField="accountDes">字段描述</th>
				<th>建档日期</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid" rel="<?php echo ($vo["id"]); ?>">
				<td><input name="ids" value="<?php echo ($vo["id"]); ?>" type="checkbox"></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["name"]); ?></td>
				<td><?php echo ($vo["key"]); ?></td>
				<td><?php echo ($vo["value"]); ?></td>
				<td><?php echo ($vo["des"]); ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
				<td align="center">
					<?php if( ishavepower('System/del') ){ ?><a title="删除" target="ajaxTodo" href="<?php echo U('System/del');?>?id=<?php echo ($vo["id"]); ?>" class="btnDel">删除</a><?php } ?>
					<?php if( ishavepower('System/add') ){ ?><a title="编辑" target="dialog" mask=true title="编辑系统参数" href="<?php echo U('System/add');?>?id=<?php echo ($vo["id"]); ?>" class="btnEdit">编辑</a><?php } ?>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>