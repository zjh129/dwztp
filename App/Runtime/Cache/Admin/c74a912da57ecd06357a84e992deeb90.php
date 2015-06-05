<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">角色管理</h2>
<div class="panelBar">
  <ul class="toolBar">
    <?php if( ishavepower('Role/add') ){ ?><li><a class="add" href="<?php echo U('Role/add');?>" target="dialog" mask=true><span>添加</span></a></li><?php } ?> 
  </ul>
</div>
<div id="Role_box" style="float:left; display:block; margin:10px; overflow:auto; width:800px; height:400px; border:solid 1px #CCC; line-height:21px; background:#FFF;">
  <ul class="tree treeFolder expand">
    <?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a><?php echo ($vo["name"]); ?></a> <span>
      <?php if( ishavepower('Role/add') ){ ?><a title="增加【<?php echo ($vo["name"]); ?>】子角色" target="dialog" mask=true height="315" width="600" href="<?php echo U('Role/add');?>?pid=<?php echo ($vo["id"]); ?>" class="btnAdd">增加子角色</a><?php } ?> 
      <?php if( ishavepower('Role/edit') ){ ?><a title="编辑" target="dialog" mask=true href="<?php echo U('Role/edit');?>?id=<?php echo ($vo["id"]); ?>" class="btnEdit">编辑</a><?php } ?> 
      <?php if( ishavepower('Role/selectnode') ){ ?><a title="角色授权" target="dialog" mask=true href="<?php echo U('Role/selectnode',array('roleid' => $vo['id'] ));?>" class="btnInfo">角色授权</a><?php } ?> 
      <?php if( ishavepower('Role/selectuser') ){ ?><a title="选择用户" target="dialog" mask=true href="<?php echo U('Role/selectuser',array('roleid' => $vo['id'] ));?>" class="btnAssign">选择用户</a><?php } ?> 
      <?php if( ishavepower('Role/del') ){ ?><a title="你确定删除【<?php echo ($vo["name"]); ?>】角色吗？" target="ajaxTodo" href="<?php echo U('Role/del');?>?id=<?php echo ($vo["id"]); ?>" class="btnDel">删除</a><?php } ?> 
      </span>
        <?php if(!empty($vo["_child"])): ?><ul>
            <?php if(is_array($vo["_child"])): $i = 0; $__LIST__ = $vo["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo1): $mod = ($i % 2 );++$i;?><li><a><?php echo ($chivo1["name"]); ?></a> <span>
              <?php if( ishavepower('Role/add') ){ ?><a title="增加【<?php echo ($chivo1["name"]); ?>】子角色" target="dialog" mask=true height="315" width="600" href="<?php echo U('Role/add');?>?pid=<?php echo ($chivo1["id"]); ?>" class="btnAdd">增加子角色</a><?php } ?> 
              <?php if( ishavepower('Role/edit') ){ ?><a title="编辑" target="dialog" mask=true href="<?php echo U('Role/edit');?>?id=<?php echo ($chivo1["id"]); ?>" class="btnEdit">编辑</a><?php } ?> 
              <?php if( ishavepower('Role/selectnode') ){ ?><a title="角色授权" target="dialog" mask=true href="<?php echo U('Role/selectnode',array('roleid' => $chivo1['id'] ));?>" class="btnInfo">角色授权</a><?php } ?> 
              <?php if( ishavepower('Role/selectuser') ){ ?><a title="选择用户" target="dialog" mask=true href="<?php echo U('Role/selectuser',array('roleid' => $chivo1['id'] ));?>" class="btnAssign">选择用户</a><?php } ?> 
              <?php if( ishavepower('Role/del') ){ ?><a title="你确定删除【<?php echo ($chivo1["name"]); ?>】角色吗？" target="ajaxTodo" href="<?php echo U('Role/del');?>?id=<?php echo ($chivo1["id"]); ?>" class="btnDel">删除</a></span><?php } ?> 
                <?php if(!empty($chivo1["_child"])): ?><ul>
                    <?php if(is_array($chivo1["_child"])): $i = 0; $__LIST__ = $chivo1["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo2): $mod = ($i % 2 );++$i;?><li><a><?php echo ($chivo2["name"]); ?></a> <span>
                      <?php if( ishavepower('Role/edit') ){ ?><a title="编辑" target="dialog" mask=true href="<?php echo U('Role/edit');?>?id=<?php echo ($chivo2["id"]); ?>" class="btnEdit">编辑</a><?php } ?> 
                      <?php if( ishavepower('Role/selectnode') ){ ?><a title="角色授权" target="dialog" mask=true href="<?php echo U('Role/selectnode',array('roleid' => $chivo2['id'] ));?>" class="btnInfo">角色授权</a><?php } ?> 
                      <?php if( ishavepower('Role/selectuser') ){ ?><a title="选择用户" target="dialog" mask=true href="<?php echo U('Role/selectuser',array('roleid' => $chivo2['id'] ));?>" class="btnAssign">选择用户</a><?php } ?> 
                      <?php if( ishavepower('Role/del') ){ ?><a title="你确定要删除【<?php echo ($chivo2["name"]); ?>】角色吗？" target="ajaxTodo" href="<?php echo U('Role/del');?>?id=<?php echo ($chivo2["id"]); ?>" class="btnDel">删除</a><?php } ?> 
                      </span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul><?php endif; ?>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul><?php endif; ?>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
</div>
<style type="text/css">
#Role_box li > div{width:70%;float:left;}
#Role_box li > span{width:220px;float:right; text-align:right;}
</style>
<script type="text/javascript">
$(function(){
	$("#Role_box li span a").css({"display":"inline-block","text-indent":"1000em","float":"none"});
	$("#Role_box .btnAssign,.btnInfo").attr({"width":"300","height":"500"});
	});
</script>