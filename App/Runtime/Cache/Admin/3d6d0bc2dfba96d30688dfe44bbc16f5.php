<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
  <input type="hidden" name="pageNum" value="1" />
  <input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
  <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>" />
  <input type="hidden" name="type_id" value="<?php echo ($type_id); ?>" />
</form>
<div class="pageHeader">
  <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo U('Attribute/index');?>" method="post">
    <div class="searchBar">
      <ul class="searchContent">
        <li>
          <label>关键字：</label>
          <input type="text" name="keywords" value=""/>
        </li>
        <li>
          <label>商品类型：</label>
          <select class="combox" name="type_id">
            <?php if(is_array($goodstype_list)): $i = 0; $__LIST__ = $goodstype_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type_id"]); ?>"
              <?php if(($vo["type_id"]) == $type_id): ?>selected<?php endif; ?>
              ><?php echo ($vo["type_name"]); ?>
              </option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </li>
      </ul>
      <div class="subBar">
        <ul>
          <li>
            <div class="buttonActive">
              <div class="buttonContent">
                <button type="submit">检索</button>
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
      <?php if( ishavepower('Attribute/add') ){ ?><li><a class="add" href="<?php echo U('Attribute/add');?>?type_id=<?php echo ($type_id); ?>" target="dialog" height="400" width="750" mask=true><span>添加</span></a></li><?php } ?>
      <?php if( ishavepower('Attribute/edit') ){ ?><li><a class="edit" href="<?php echo U('Attribute/edit');?>?type_id=<?php echo ($type_id); ?>&attr_id={attr_id}" target="dialog" height="400" width="750" mask=true warn="请选择一条属性"><span>修改</span></a></li><?php } ?>
      <?php if( ishavepower('Attribute/batchdel') ){ ?><li><a title="确实要删除这些属性吗?" target="selectedTodo" rel="ids" postType="string" href="<?php echo U('Attribute/batchdel?type_id='.$type_id);?>" class="delete"><span>批量删除</span></a></li><?php } ?>
    </ul>
  </div>
  <table class="table" layoutH="138" width="100%">
    <thead>
      <tr>
        <th><input type="checkbox" group="ids" class="checkboxCtrl">
          <label>编号</label></th>
        <th>属性名称</th>
        <th>商品类型名称</th>
        <th>属性值的录入方式</th>
        <th>可选值列表</th>
        <th>排序</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="attr_id" rel="<?php echo ($vo["attr_id"]); ?>">
          <td><input name="ids" value="<?php echo ($vo["attr_id"]); ?>" type="checkbox">
            <?php echo ($vo["attr_id"]); ?></td>
          <td><?php echo ($vo["attr_name"]); ?></td>
          <td><?php echo ($vo["type_name"]); ?></td>
          <td>
          <?php switch($vo["attr_input_type"]): case "0": ?>手工录入<?php break;?>
          <?php case "1": ?>从列表中选择<?php break;?>
          <?php case "2": ?>多行文本框<?php break; endswitch;?></td>
          <td><?php echo (str_replace(PHP_EOL,',',$vo["attr_value"])); ?></td>
          <td><?php echo ($vo["sort"]); ?></td>
          <td>
          <?php if( ishavepower('Attribute/edit') ){ ?><a title="编辑" target="dialog" mask=true height="400" width="750" href="<?php echo U('Attribute/edit');?>?type_id=<?php echo ($type_id); ?>&attr_id=<?php echo ($vo["attr_id"]); ?>" class="btnEdit">编辑</a><?php } ?>
          <?php if( ishavepower('Attribute/del') ){ ?><a title="删除" target="ajaxTodo" href="<?php echo U('Attribute/del');?>?type_id=<?php echo ($type_id); ?>&attr_id=<?php echo ($vo["attr_id"]); ?>" class="btnDel">删除</a><?php } ?>
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
  <div class="panelBar">
    <div class="pages"> <span>显示</span>
      <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
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