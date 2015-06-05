<?php if (!defined('THINK_PATH')) exit();?><div class="pageHeader">
	<?php if( ishavepower('ArtCategory/add') ){ ?><a class="button" href="<?php echo U('ArtCategory/add');?>" target='dialog' rel='cat_add' width="510" height="380" mask="true" title="添加商品分类"><span>添加文章分类</span></a><?php } ?>
</div>

<div class="pageContent">
	<table class="table" width="100%" layoutH="70">
		<thead>
			<tr>
				<th width="300" style="padding-left:10px; text-align: center;">分类名称</th>
				<th width="150" align="center">商品数量</th>
				<th width="150" align="center">是否显示</th>
				<th width="150" align="center">排序</th>
				<th width="350" align="center">操作</th>
			</tr>
		</thead>
		<tbody id="category_tree">
		<?php if(is_array($cat_data)): $i = 0; $__LIST__ = $cat_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo ($vo["parent_id"]); ?>_<?php echo ($vo["cat_id"]); ?>" class="<?php echo ($vo["parent_id"]); ?>">
				<td style="padding-left:10px;"><img id="ico_<?php echo ($vo["parent_id"]); ?>_<?php echo ($vo["cat_id"]); ?>" border="0" height="9" width="9" onclick="fold_cats(this);" style="margin-left:<?php echo ($vo["level"]); ?>em; margin-right:5px;" src="__PUBLIC__/images/tree_minus.gif"/><?php echo ($vo["cat_name"]); ?></td>
				<td><?php echo (intval($goods_data[$vo['cat_id']]['goods_num'])); ?></td>
				<td><?php if(($vo["is_show"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('ArtCategory/set_show_status');?>?cat_id=<?php echo ($vo["cat_id"]); ?>&isshow=0"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('ArtCategory/set_show_status');?>?cat_id=<?php echo ($vo["cat_id"]); ?>&isshow=1"><img src="__PUBLIC__/images/error.gif" /><?php endif; ?></td>
				<td>
                <a target="ajaxTodo" title="顶置？" href="<?php echo U('ArtCategory/sort',array('move'=>'top','cat_id'=>$vo['cat_id'],'pid'=>$vo['parent_id']) );?>"><img src="__PUBLIC__/images/movetop.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="上移？" href="<?php echo U('ArtCategory/sort',array('move'=>'up','cat_id'=>$vo['cat_id'],'pid'=>$vo['parent_id']) );?>"><img src="__PUBLIC__/images/moveup.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="下移？" href="<?php echo U('ArtCategory/sort',array('move'=>'down','cat_id'=>$vo['cat_id'],'pid'=>$vo['parent_id']) );?>"><img src="__PUBLIC__/images/movedown.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="置末？" href="<?php echo U('ArtCategory/sort',array('move'=>'bottom','cat_id'=>$vo['cat_id'],'pid'=>$vo['parent_id']) );?>"><img src="__PUBLIC__/images/movebottom.gif" /></a>&nbsp;</td>
				<td>
					<?php if( ishavepower('ArtCategory/edit') ){ ?><a title="编辑商品?" target='dialog' href="<?php echo U('ArtCategory/edit');?>?cat_id=<?php echo ($vo["cat_id"]); ?>" width="510" height="380" mask="true" class="btnEdit">编辑</a><?php } ?>
                    <?php if( ishavepower('ArtCategory/del') ){ ?><a title="确定要删除吗?" target="ajaxTodo" href="<?php echo U('ArtCategory/del');?>?cat_id=<?php echo ($vo["cat_id"]); ?>"  class="btnDel">移除</a><?php } ?>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	<div class="panelBar"></div>
</div>

<script type="text/javascript">
	function fold_cats(obj){
		var cur_img = $(obj); //当前点击的折叠图标
		var cur_cat_row = cur_img.parents('tr'); //当前点击?所在table行
		var cur_row_cid = cur_cat_row.attr('id');
		var cur_pid = parseInt(cur_cat_row.attr('class')); //当前点击?的父类id
		var all_cats = $("#category_tree tr"); //所有的?所在table行(tr)
		var cur_status = cur_img.attr('src').indexOf('minus.gif') != -1 ? 'none' : 'block'; //当前点击状态,根据显示图标进行判断
		var find_flag = false; //找到当前点击所在table行标识
		
		if(cur_status == 'none'){
			$(cur_img).attr('src', '__PUBLIC__/images/tree_plus.gif');
		} else {
			$(cur_img).attr('src', '__PUBLIC__/images/tree_minus.gif');
		}
		
		all_cats.each(function(){
			if($(this).attr('id') == cur_row_cid){
				find_flag = true; //找到当前点击所在table所有行的位置，一下行则为当前?的子类;
			} else {
				if(find_flag == true){ 
					//当find_flag为true下面的行为子类，需要排除不是当前?的子类行
					var loop_pid = parseInt($(this).attr('class')); //当前遍历到的?行的父id
					if(loop_pid > cur_pid){
						//判断当前点击行的父id和遍历行的父id大小关系，遇到同级或更小?id的说明已经到了当前点击?的子类的末尾了
						if(cur_status == 'none'){
							$(this).hide();
							$("#ico_"+$(this).attr('id')).attr('src', '__PUBLIC__/images/tree_minus.gif');
						} else {
							$(this).show();
						}
					} else { 
						//不是当前?的子类跳出剩下行的遍历判断
						find_flag = false;
						return false;
					}
				}
			}
		});
	}
</script>