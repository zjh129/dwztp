<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
    <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo U('GoodsType/index');?>" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>关键字：</label>
				<input type="text" name="keywords" value="<?php echo ($keywords); ?>"/>
			</li>
		</ul>
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
      <?php if( ishavepower('GoodsType/add') ){ ?><li><a class="add" href="<?php echo U('GoodsType/add');?>" target="dialog" mask=true height="150" title="添加商品类型"><span>添加</span></a></li><?php } ?>
      <?php if( ishavepower('GoodsType/edit') ){ ?><li><a class="edit" href="<?php echo U('GoodsType/edit');?>?type_id={type_id}" target="dialog" mask=true title="编辑商品类型" warn="请指定要修改的商品类型"><span>修改</span></a></li><?php } ?>
      <?php if( ishavepower('GoodsType/update_goodstype_cache') ){ ?><li><a class="icon" href="<?php echo U('GoodsType/update_goodstype_cache');?>" target="ajaxTodo" ><span>生成缓存</span></a></li><?php } ?>
    </ul>
  </div>
  <table class="table" layoutH="138" width="100%">
    <thead>
      <tr>
        <th>序号</th>
        <th>商品类型名称</th>
        <th>状态</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="type_id" rel="<?php echo ($vo["type_id"]); ?>">
        <td><?php echo ($vo["type_id"]); ?></td>
        <td><?php echo ($vo["type_name"]); ?></td>
        <td>
         <?php if( ishavepower('GoodsType/c_enable') ){ ?>
         <?php if(($vo["is_enable"]) == "1"): ?><a target="ajaxTodo" href="<?php echo U('GoodsType/c_enable');?>?act=0&type_id=<?php echo ($vo["type_id"]); ?>"><img src="__PUBLIC__/images/ok.gif" /></a><?php else: ?><a target="ajaxTodo" href="<?php echo U('GoodsType/c_enable');?>?act=1&type_id=<?php echo ($vo["type_id"]); ?>"><img src="__PUBLIC__/images/locked.gif" /><?php endif; ?>
         <?php } ?>
         </td>
        <td>
        <?php if( ishavepower('Attribute/index') ){ ?><a title="商品属性列表" target="navTab" href="<?php echo U('Attribute/index?type_id='.$vo['type_id']);?>" class="btnLook" rel="attribute">商品属性列表</a><?php } ?>
        <?php if( ishavepower('GoodsType/edit') ){ ?><a title="编辑" target="dialog" mask=true href="<?php echo U('GoodsType/edit');?>?type_id=<?php echo ($vo["type_id"]); ?>" class="btnEdit">编辑</a><?php } ?>
        <?php if( ishavepower('GoodsType/del') ){ ?><a title="你确定要删除此此商品类型吗？" target="ajaxTodo" href="<?php echo U('GoodsType/del');?>?type_id=<?php echo ($vo["type_id"]); ?>" class="btnDel">删除</a></td><?php } ?>
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