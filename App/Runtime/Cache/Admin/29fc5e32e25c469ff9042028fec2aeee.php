<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
    <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
    <input type="hidden" name="cat_id" value="<?php echo ($valcat_id); ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo U('Goods/index');?>" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>关键字：</label>
				<input type="text" name="keywords" value="<?php echo ($keywords); ?>"/>
			</li>
            <li><?php echo ($cat_select); ?></li>
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
      <?php if( ishavepower('Goods/add') ){ ?><li><a class="add" href="<?php echo U('Goods/add');?>" target="navTab" rel="goodsadd" mask=true height="150" title="添加商品"><span>添加</span></a></li><?php } ?>
      
    </ul>
  </div>
  <table class="table" layoutH="138" width="100%">
    <thead>
      <tr>
        <th>序号</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>价格</th>
        <th>上架</th>
        <th>库存</th>
        <th>操作</th>
      </tr>
      
    </thead>
    <tbody>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="type_id" rel="<?php echo ($vo["goods_id"]); ?>">
        <td><?php echo ($vo["goods_id"]); ?></td>
        <td><?php echo ($vo["goods_name"]); ?></td>
        <td><?php echo ($vo["goods_sn"]); ?></td>
        <td><?php echo ($vo["shop_price"]); ?></td>
        <td><?php if($vo['online_sale']==1): ?>是<?php else: ?>否<?php endif; ?></td>
        <td><?php echo ($vo["goods_nums"]); ?></td>
        <td>
        <?php if( ishavepower('Goods/edit') ){ ?><a title="编辑" target="navTab" mask=true href="<?php echo U('Goods/edit',array('goods_id'=>$vo['goods_id']));?>" class="btnEdit">编辑</a><?php } ?>
        <?php if( ishavepower('Goods/del') ){ ?><a title="你确定要删除此此商品吗？" target="ajaxTodo" href="<?php echo U('Goods/del',array('goods_id'=>$vo['goods_id']));?>" class="btnDel">删除</a><?php } ?>
        
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