<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo U('Role/selectnode');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
  <input type="hidden" name="roleid" id="roleid" value="<?php echo ($roleid); ?>" />
  <input id="nodestr" type="hidden" value="" name="nodestr">
    <div class="pageFormContent nowrap" style=" float:left; display:block; margin:10px; overflow:auto; width:255px; height:400px; border:solid 1px #CCC; line-height:21px; background:#FFF;" layoutH="76">
      <ul class="tree treeFolder treeCheck expand" oncheck="kkk">
        <?php if(is_array($nodeList)): $i = 0; $__LIST__ = $nodeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a tname="node[]" tvalue="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></a>
            <?php if(!empty($vo["_child"])): ?><ul>
                <?php if(is_array($vo["_child"])): $i = 0; $__LIST__ = $vo["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo1): $mod = ($i % 2 );++$i;?><li><a tname="node[]" tvalue="<?php echo ($vo["id"]); ?>-<?php echo ($chivo1["id"]); ?>"><?php echo ($chivo1["title"]); ?></a>
                  <?php if(!empty($chivo1["_child"])): ?><ul>
                    <?php if(is_array($chivo1["_child"])): $i = 0; $__LIST__ = $chivo1["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chivo2): $mod = ($i % 2 );++$i;?><li><a tname="node[]" tvalue="<?php echo ($vo["id"]); ?>-<?php echo ($chivo1["id"]); ?>-<?php echo ($chivo2["id"]); ?>" <?php if(in_array(($chivo2["id"]), is_array($usernodearr)?$usernodearr:explode(',',$usernodearr))): ?>checked="checked"<?php endif; ?>><?php echo ($chivo2["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul><?php endif; ?>
                  </li><?php endforeach; endif; else: echo "" ;endif; ?>
              </ul><?php endif; ?>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
   <div id="resultBox"></div>
    <div class="formBar">
      <ul>
        <li>
          <div class="buttonActive">
            <div class="buttonContent">
              <button type="submit" onclick="javascript:subresult()">提交</button>
            </div>
          </div>
        </li>
        <li>
          <div class="button">
            <div class="buttonContent">
              <button type="button" class="close">取消</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </form>
</div>
<script type="text/javascript">
function kkk(){
	var json = arguments[0], result="";
	//$ischecked	=	json.checked==true ? "checked" :"";
	
//	alert(json.checked);

	$(json.items).each(function(i){
		$("input[value='"+this.value+"']").attr("checked", json.checked );
		//result += "<p>name:"+this.name + " value:"+this.value+" text: "+this.text+"</p>";
		//$(this).attr("checked", "checked" );
	});
	/*$("#resultBox").html(result);*/
	
}
function subresult()
{
	var result = [];
	$("div .checked input").each(function(index, element) {
        result[index] = $(this).val();
    });
	$("#nodestr").val(result.join(','));
}
</script>