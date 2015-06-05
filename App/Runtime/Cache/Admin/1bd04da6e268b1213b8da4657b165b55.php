<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo ($numPerPage); ?>" />
    <input type="hidden" name="extension" value="<?php echo ($extension); ?>" />
    <input type="hidden" name="source" value="<?php echo ($source); ?>" />
    <input type="hidden" name="subtime" value="<?php echo ($subtime); ?>" />
</form>


<div class="pageHeader">
	<form rel="pagerForm"onsubmit="return navTabSearch(this);" action="<?php echo U('Attach/index');?>" method="post">
	<div class="searchBar">
		<table height="30" class="searchContent" width="100%">
			<tr>
			  <td width="10%">文件类型：</td>
			  <td width="10%">
              	<select class="combox" name="extension">
                    <option value="0">全部</option>
                    <?php if(is_array($conext)): $i = 0; $__LIST__ = $conext;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["extension"]); ?>"<?php if(($vo["extension"]) == $extension): ?>selected<?php endif; ?>><?php echo (strtoupper($vo["extension"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select></td>
				<td width="8%">
                    文件来源：
				</td>
				<td width="28%">
                <select class="combox" name="source">
                    <option value="0">全部</option>
                    <?php if(is_array($sourcetypelist)): $k = 0; $__LIST__ = $sourcetypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k); ?>"<?php if(($k) == $source): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select></td>
				<td width="9%">上传时间：</td>
				<td width="35%">
               <input type="text" name="subtime" class="date" dateFmt="yyyy-MM-dd" value="<?php echo ($subtime); ?>" readonly="true" /></td>
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
	<!--<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="<?php echo U('Article/add');?>" target="navTab" rel="article_add"><span>添加</span></a></li>
            <li><a class="edit" href="<?php echo U('Article/edit');?>?art_id={art_id}" target="navTab" title="编辑文章" warn="请指定要修改的文章"><span>修改</span></a></li>
		</ul>
	</div>-->
	<table class="table" layoutH="110" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>上传者</th>
				<th>文件原名</th>
				<th>文件MIMES</th>
				<th>大小(K)</th>
				<th>文件类型</th>
				<th align="center">上传时间</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="art_id" rel="<?php echo ($vo["id"]); ?>">
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["account"]); ?></td>
				<td><?php echo ($vo["name"]); ?></td>
				<td><?php echo ($vo["type"]); ?></td>
				<td><?php echo ($vo["size"]); ?></td>
				<td><?php echo ($vo["extension"]); ?></td>
				<td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
				<td align="center">
                   <?php if( ishavepower('Attach/download') ){ ?><a title="你确定下载该附件吗？" target="dwzExport" targetType="dialog" href="<?php echo U('Attach/download' , array('attach_id' => $vo['id']));?>" class="btnAttach">下载</a><?php } ?>
                    <?php if( ishavepower('Attach/del') ){ ?><a title="你确定删除该附件吗？" target="ajaxTodo" href="<?php echo U('Attach/del',array('attach_id'=>$vo['id']));?>" class="btnDel">删除</a><?php } ?>
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