<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">节点批量增加</h2>
<form action="<?php echo U('Node/patchAdd');?>" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
<div class="pageContent">
	<div class="pageFormContent" layoutH="97">
		<div class="tabs">
			<div class="tabsContent">
				<div>
					<table class="list nowrap itemDetail" addButton="新增" width="100%">
						<thead>
							<tr>
								<th type="text" name="name[#index#]" size="20" fieldClass="required">节点标识</th>
								<th type="text" name="title[#index#]" size="30" fieldClass="required">节点标题</th>
								<th type="enum" name="status[#index#]" enumUrl="<?php echo U('Node/patchStatus');?>">状态</th>
								<th type="textarea" name="remark[#index#]" size="30" height="30">注释</th>
								<th type="text" name="sort[#index#]" defaultVal="#index#" fieldClass="required digits" size="5">排序</th>
                                <th type="enum" name="pid[#index#]" enumUrl="<?php echo U('Node/patchParlist');?>">父节点</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>
		
	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
		</ul>
	</div>
</div>
</form>