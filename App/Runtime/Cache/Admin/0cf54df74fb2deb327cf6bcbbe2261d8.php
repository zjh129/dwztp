<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">前台菜单管理</h2>
<div class="pageContent layoutBox"  style="height:100%">

<div class="panelBar">
  <ul class="toolBar">
    <?php if( ishavepower('Menu/add') ){ ?><li><a class="add" href="<?php echo U('Menu/add');?>" target="dialog" mask=true width="600" height="400"><span>添加</span></a></li><?php } ?>
    <li class="line">line</li>
    <?php if( ishavepower('Menu/cache') ){ ?><li><a class="icon" href="<?php echo U('Menu/cache');?>" target="ajaxTodo"><span>更新缓存</span></a></li><?php } ?>
  </ul>
</div>
<div id="node_box" style="float:left; display:block; margin:10px; overflow:auto; width:800px; height:550px; border:solid 1px #CCC; line-height:21px; background:#FFF;" layoutH="200">
  <ul class="tree treeFolder expand">
    <?php if(is_array($menuList)): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a><?php echo ($vo["title"]); ?></a> <span>
      			<?php if( ishavepower('Menu/sort') ){ ?>
                <a target="ajaxTodo" title="顶置？" href="<?php echo U('Menu/sort',array('move'=>'top','id'=>$vo['id'],'pid'=>$vo['pid']) );?>"><img src="__PUBLIC__/images/movetop.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="上移？" href="<?php echo U('Menu/sort',array('move'=>'up','id'=>$vo['id'],'pid'=>$vo['pid']) );?>"><img src="__PUBLIC__/images/moveup.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="下移？" href="<?php echo U('Menu/sort',array('move'=>'down','id'=>$vo['id'],'pid'=>$vo['pid']) );?>"><img src="__PUBLIC__/images/movedown.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="置末？" href="<?php echo U('Menu/sort',array('move'=>'bottom','id'=>$vo['id'],'pid'=>$vo['pid']) );?>"><img src="__PUBLIC__/images/movebottom.gif" /></a>&nbsp;<?php } ?>              
                <?php if( ishavepower('Menu/add') ){ ?><a title="增加【<?php echo ($vo["title"]); ?>】子节点" target="dialog" mask=true height="400" width="600" href="<?php echo U('Menu/add',array('pid'=>$vo['id']));?>" class="btnAdd">增加子节点</a><?php } ?>
                <?php if( ishavepower('Menu/edit') ){ ?><a title="编辑" target="dialog" mask=true height="400" width="600" href="<?php echo U('Menu/edit',array('id'=>$vo['id']));?>" class="btnEdit">编辑</a><?php } ?>
                <?php if( ishavepower('Menu/del') ){ ?><a title="你确定删除【<?php echo ($vo["title"]); ?>】节点吗？" target="ajaxTodo" href="<?php echo U('Menu/del',array('id'=>$vo['id']));?>" class="btnDel">删除</a><?php } ?>
                </span>
        <?php if(!empty($vo["_child"])): ?><ul>
            <?php if(is_array($vo["_child"])): $i = 0; $__LIST__ = $vo["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo1): $mod = ($i % 2 );++$i;?><li><a><?php echo ($chivo1["title"]); ?></a> <span>
                <?php if( ishavepower('Menu/sort') ){ ?><a target="ajaxTodo" title="顶置？" href="<?php echo U('Menu/sort',array('move'=>'top','id'=>$chivo1['id'],'pid'=>$chivo1['pid']) );?>"><img src="__PUBLIC__/images/movetop.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="上移？" href="<?php echo U('Menu/sort',array('move'=>'up','id'=>$chivo1['id'],'pid'=>$chivo1['pid']) );?>"><img src="__PUBLIC__/images/moveup.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="下移？" href="<?php echo U('Menu/sort',array('move'=>'down','id'=>$chivo1['id'],'pid'=>$chivo1['pid']) );?>"><img src="__PUBLIC__/images/movedown.gif" /></a>&nbsp;
                <a target="ajaxTodo" title="置末？" href="<?php echo U('Menu/sort',array('move'=>'bottom','id'=>$chivo1['id'],'pid'=>$chivo1['pid']) );?>"><img src="__PUBLIC__/images/movebottom.gif" /></a>&nbsp;<?php } ?>
                
                <?php if( ishavepower('Menu/add') ){ ?><a title="增加【<?php echo ($chivo1["title"]); ?>】子节点" target="dialog" mask=true height="400" width="600" href="<?php echo U('Menu/add',array('pid'=>$chivo1['id']));?>" class="btnAdd">增加子节点</a><?php } ?>
                <?php if( ishavepower('Menu/edit') ){ ?><a title="编辑" target="dialog" mask=true height="400" width="600" href="<?php echo U('Menu/edit',array('id'=>$chivo1['id']));?>" class="btnEdit">编辑</a><?php } ?>
                <?php if( ishavepower('Menu/del') ){ ?><a title="你确定删除【<?php echo ($chivo1["title"]); ?>】节点吗？" target="ajaxTodo" href="<?php echo U('Menu/del',array('id'=>$chivo1['id']));?>" class="btnDel">删除</a><?php } ?>
                </span>
                <?php if(!empty($chivo1["_child"])): ?><ul>
                    <?php if(is_array($chivo1["_child"])): $i = 0; $__LIST__ = $chivo1["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo2): $mod = ($i % 2 );++$i;?><li><a><?php echo ($chivo2["title"]); ?></a> <span class="node3buttons">
                        <?php if( ishavepower('Menu/sort') ){ ?>
                        <a target="ajaxTodo" title="顶置？" href="<?php echo U('Menu/sort',array('move'=>'top','id'=>$chivo2['id'],'pid'=>$chivo2['pid']) );?>"><img src="__PUBLIC__/images/movetop.gif" /></a>&nbsp;
                        <a target="ajaxTodo" title="上移？" href="<?php echo U('Menu/sort',array('move'=>'up','id'=>$chivo2['id'],'pid'=>$chivo2['pid']) );?>"><img src="__PUBLIC__/images/moveup.gif" /></a>&nbsp;
                        <a target="ajaxTodo" title="下移？" href="<?php echo U('Menu/sort',array('move'=>'down','id'=>$chivo2['id'],'pid'=>$chivo2['pid']) );?>"><img src="__PUBLIC__/images/movedown.gif" /></a>&nbsp;
                        <a target="ajaxTodo" title="置末？" href="<?php echo U('Menu/sort',array('move'=>'bottom','id'=>$chivo2['id'],'pid'=>$chivo2['pid']) );?>"><img src="__PUBLIC__/images/movebottom.gif" /></a>&nbsp;<?php } ?>                      
                        <?php if( ishavepower('Menu/edit') ){ ?><a title="编辑" target="dialog" mask=true height="400" width="600" href="<?php echo U('Menu/edit',array('id'=>$chivo2['id']));?>" class="btnEdit">编辑</a><?php } ?>
                        <?php if( ishavepower('Menu/del') ){ ?><a title="你确定要删除【<?php echo ($chivo2["title"]); ?>】节点吗？" target="ajaxTodo" href="<?php echo U('Menu/del',array('id'=>$chivo2['id']));?>" class="btnDel">删除</a><?php } ?>
                        </span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul><?php endif; ?>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul><?php endif; ?>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
   </div>
</div>

<style type="text/css">
#node_box li > div{width:61%;float:left;}
#node_box li > span{width:38%; float:right;}
#node_box li > span > a{ width:22px;float:left;}
</style>
<script type="text/javascript">
$(function(){
	//$(".node3buttons").prevAll("div").remove();
	});
</script>