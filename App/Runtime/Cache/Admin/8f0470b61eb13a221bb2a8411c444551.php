<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">商品编辑</h2>
<div style="display:block; overflow:hidden; line-height:21px;">
  <div class="tabs">
    <div class="tabsHeader">
      <div class="tabsHeaderContent">
        <ul>
          <li><a href="javascript:;"><span>基本信息</span></a></li>
          <li><a href="javascript:;"><span>详细描述</span></a></li>
          <li><a href="javascript:;"><span>其他信息</span></a></li>
          <li><a href="javascript:;"><span>商品属性</span></a></li>
          <li><a href="javascript:;"><span>商品相册</span></a></li>
        </ul>
      </div>
    </div>
    <form method="post" action="__ACTION__" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone)">
    <input type="hidden" name="goods_id" id="goods_id" value="<?php echo ($data["goods_id"]); ?>" />
    <div class="tabsContent" layoutH="115"> 
      <!--基本信息-->
      <div>
        <div class="pageFormContent nowrap" layoutH="158">
          <dl>
            <dt>商品名称：</dt>
            <dd>
              <input type="text" name="goods_name" maxlength="20" style="width:400px;" value="<?php echo ($data["goods_name"]); ?>" class="required" />
              <span class="info">请输入文章标题</span> </dd>
          </dl>
          <dl>
            <dt>商品简短描述：</dt>
            <dd>
              <input type="text" name="short_desc" value="<?php echo ($data["short_desc"]); ?>" style="width:300px;" />
              <span class="info"></span> </dd>
          </dl>
          <dl>
            <dt>所属分类：</dt>
            <dd> <?php echo ($cat_select); ?> </dd>
          </dl>
          <dl>
            <dt>权重：</dt>
            <dd>
              <input id="weight" type="text" name="weight" class="required digits" style="width:50px;"  value="<?php echo ($data["weight"]); ?>" />
              <span class="info">(越小越靠前)</span> </dd>
          </dl>
          <dl>
            <dt>市场价：</dt>
            <dd>
              <input name="market_price" type="text" class="number" style="width:80px;" value="<?php echo ($data["market_price"]); ?>" id="market_price" />
            </dd>
          </dl>
          <dl>
            <dt>商城价：</dt>
            <dd>
              <input name="shop_price" type="text" class="number" style="width:80px;" value="<?php echo ($data["shop_price"]); ?>" id="shop_price" />
            </dd>
          </dl>
          <dl>
            <dt>商品数量：</dt>
            <dd>
              <input name="goods_nums" type="text" class="digits" style="width:80px;" value="<?php echo ($data["goods_nums"]); ?>" id="goods_nums" />
            </dd>
          </dl>
          <dl>
            <dt>商品关键词：</dt>
            <dd>
              <input type="text" name="keywords" value="<?php echo ($data["keywords"]); ?>" style="width:400px;" />
            </dd>
          </dl>
          <dl>
            <dt>商品摘要：</dt>
            <dd>
              <textarea name="goods_brief" cols="80" rows="2" id="goods_brief"><?php echo ($data["goods_brief"]); ?></textarea>
            </dd>
          </dl>
          <dl>
            <dt>缩略图：</dt>
            <dd>
              <input name="goods_thumb" id="goodsedit_attachmentid" value="<?php echo ($data["goods_thumb"]); ?>" type="hidden">
              <div id="goodsedit_attach"></div>
              <span class="info"></span>
              </dd>
          </dl>
          <dl>
            <dt>图片预览：</dt>
            <dd> <img name="thumbimg" id="goodsedit_thumbimg" src="<?php if(empty($$thumbdata)): echo ($thumbdata["savepath"]); echo ($thumbdata["thumbname"]); else: ?>__PUBLIC__/images/no_picture.jpg<?php endif; ?>" /> </dd>
          </dl>
        </div>
      </div>
      <!--详细描述-->
      <div>
        <textarea class="editor" name="goods_desc" rows="8" cols="100" style="height:400px;"
upLinkUrl="<?php echo U('Attach/editor_linkupload');?>" upLinkExt="tar,zip,tgz,rar,ppt,pptx,doc,pdf,xls,xlsx,txt"
upImgUrl="<?php echo U('Attach/editor_imgupload');?>" upImgExt="jpg,jpeg,gif,png"
upFlashUrl="<?php echo U('Attach/editor_flashupload');?>" upFlashExt="swf"
upMediaUrl="<?php echo U('Attach/editor_mediaupload');?>" upMediaExt:"avi">
<?php echo ($data["goods_desc"]); ?>
</textarea>
      </div>
      <!--其他信息-->
      <div>
        <div class="pageFormContent nowrap" layoutH="158">
          <dl>
            <dt>商品：</dt>
            <dd>
              <label style="width:80px;">
                <input name="online_sale" type="radio" value="1"<?php if(($data["online_sale"]) == "1"): ?>checked="checked"<?php endif; ?> />
                上架</label>
              <label style="width:80px;">
                <input type="radio" value="0" name="online_sale"<?php if(($data["online_sale"]) == "0"): ?>checked="checked"<?php endif; ?> />
                下架</label>
            </dd>
          </dl>
          <dl>
            <dt>加入推荐：</dt>
            <dd>
               <label style="width:80px;">
                <input name="is_recommend" type="radio" value="1"<?php if(($data["is_recommend"]) == "1"): ?>checked="checked"<?php endif; ?> />
                推荐</label>
              <label style="width:80px;">
                <input name="is_recommend" type="radio" value="0"<?php if(($data["is_recommend"]) == "0"): ?>checked="checked"<?php endif; ?> />
                不推荐</label>
            </dd>
          </dl>
          <dl>
            <dt>商品已售数量：</dt>
            <dd>
              <input type="text" class="digits" name="sale_num" value="<?php echo ($data["sale_num"]); ?>" /></dd>
          </dl>
          <dl>
            <dt>商品人气：</dt>
            <dd>
              <input type="text" class="digits" name="pop_num" value="<?php echo ($data["pop_num"]); ?>" />
              <span class="info"></span></dd>
          </dl>
          <dl>
            <dt>是否新品：</dt>
            <dd>
              <label style="width:80px;">
                <input name="is_new" type="radio" value="1"<?php if(($data["is_new"]) == "1"): ?>checked="checked"<?php endif; ?> />
                推荐</label>
              <label style="width:80px;">
                <input name="is_new" type="radio" value="0"<?php if(($data["is_new"]) == "0"): ?>checked="checked"<?php endif; ?> />
                不推荐</label>
            </dd>
          </dl>
           <dl>
            <dt>是否热销：</dt>
            <dd>
              <label style="width:80px;">
                <input name="is_hot" type="radio" value="1"<?php if(($data["is_hot"]) == "1"): ?>checked="checked"<?php endif; ?> />
                新品</label>
              <label style="width:80px;">
                <input name="is_hot" type="radio" value="0"<?php if(($data["is_hot"]) == "0"): ?>checked="checked"<?php endif; ?> />
                非新品</label>
            </dd>
          </dl>
          <dl>
            <dt>是否精品：</dt>
            <dd>
              <label style="width:80px;">
                <input name="is_best" type="radio" value="1"<?php if(($data["is_best"]) == "1"): ?>checked="checked"<?php endif; ?> />
                精品</label>
              <label style="width:80px;">
                <input name="is_best" type="radio" value="0"<?php if(($data["is_best"]) == "0"): ?>checked="checked"<?php endif; ?> />
                非精品</label>
            </dd>
          </dl>
        </div>
      </div>
      <!--商品属性-->
      <div>
      	<div class="pageFormContent nowrap" layoutH="158">
        <dl>
          <dt>所属类型:</dt>
          <dd>
            <select name="goods_type" id="goodsedit_type" class="combox" onchange="javascript:showAttrList();">
              <option value="0">选择模型</option>
              <?php if(is_array($goodstype)): $i = 0; $__LIST__ = $goodstype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type_id"]); ?>" <?php if(($vo["type_id"]) == $data["goods_type"]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </dd>
        </dl>
        <div id="goodsedit_type_box">
        </div>
        </div>
      </div>
      <!--商品相册-->
      <div>
        <div id="goodsedit_album"></div>
        <input type="hidden" name="album" id="goodsedit_albumlist" value="<?php echo ($data["album"]); ?>" />
        <div id="goodsedit_alblum_box">
        <?php if(is_array($ablumdata)): $i = 0; $__LIST__ = $ablumdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl id="alblum_item_<?php echo ($vo["id"]); ?>" style="width:260px;float:left;padding:5px;"><dt style="text-align:center;"><img name="thumbimg" id="albumlist_thumbimg_<?php echo ($vo["id"]); ?>" src="<?php echo ($vo["savepath"]); echo ($vo["thumbname"]); ?>" /></dt><dd style="text-align:center;"><a href="javascript:void(0);" onclick="javascript:del_alblum( <?php echo ($vo["id"]); ?> )">删除</a><input type="hidden" name="albumlist_<?php echo ($vo["id"]); ?>" id="albumlist_<?php echo ($vo["id"]); ?>'" value="<?php echo ($vo["id"]); ?>" /></dd></dl><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li>
          <div class="buttonActive">
            <div class="buttonContent">
              <button type="submit">提交</button>
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
    <div class="tabsFooter">
      <div class="tabsFooterContent"></div>
    </div>
    </form> 
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var goodsedituploader	=	new	qq.FineUploader({
		element: $('#goodsedit_attach')[0],
		request:{
			endpoint:"<?php echo U('Attach/artuploadimg');?>",
			forceMultipart: true,
			inputName: 'attach'
			},
		multiple: false,
		validation:{
			allowedExtensions:['jpg', 'gif', 'png', 'jpeg']
			},
		callbacks:{
			onComplete: function(id, fileName, responseJSON ){
					if (responseJSON.success) {
						$("#goodsedit_attachmentid").val( responseJSON.id );
						$("#goodsedit_thumbimg").attr("src" , responseJSON.attachmentPath);
					}
				}
			},
		debug: true
		});
	var goodsedit_album_uploader = new qq.FineUploader({
		element: $('#goodsedit_album')[0],
		request:{
			endpoint:"<?php echo U('Attach/artuploadimg');?>",
			forceMultipart: true,
			inputName: 'album'
			},
		validation:{
			allowedExtensions:['jpg', 'gif', 'png', 'jpeg']
			},
		callbacks:{
			onComplete: function(id, fileName, responseJSON ){
					if (responseJSON.success) {
						$("#goodsedit_alblum_box").append('<dl id="alblum_item_'+responseJSON.id+'" style="width:260px;float:left;padding:5px;"><dt style="text-align:center;"><img name="thumbimg" id="albumlist_thumbimg_'+responseJSON.id+'" src="'+responseJSON.attachmentPath+'" /></dt><dd style="text-align:center;"><a href="javascript:void(0);" onclick="javascript:del_alblum( '+responseJSON.id+' )">删除</a><input type="hidden" name="albumlist_'+responseJSON.id+'" id="albumlist_'+responseJSON.id+'" value="'+responseJSON.id+'" /></dd></dl>\n');
						//$("#alblum_box").append('<img src="'+responseJSON.attachmentPath+'" />');
						update_alblum();
						//$("#attachmentid").val( responseJSON.id );
						//$("#thumbimg").attr("src" , responseJSON.attachmentPath);
					}
					if( responseJSON.error ){
						alert( responseJSON.error );
					}
				}
			},
		debug: true
		});
	showAttrList( <?php echo ($data["goods_id"]); ?> );
});
//删除相册图片
function del_alblum( attach_id )
{
	$("#alblum_item_"+attach_id).remove();
	update_alblum();
}
//重新统计相册列表ID集合并赋值到albumlist隐藏输入框中
function update_alblum()
{
	var alblum_list		=	new Array();
	$("#goodsedit_alblum_box input").each(function(index, element) {
        alblum_list[ index ]	=	$(this).val();
    });
	$("#goodsedit_albumlist").val( alblum_list.join(',') );
}
//显示商品属性列表
function showAttrList(goods_id)
{
	/*$.post(
	'<?php echo U("Goods/ArributeList");?>',
	{
		goods_id:goods_id,
		goods_type:$("#goodsedit_type").val()
	},
	function(text){
		$("#goodsedit_type_box").html( text );
	},"text"
	);*/
	$("#goodsedit_type_box").load(
	'<?php echo U("Goods/ArributeList");?>',
	{
		goods_id:goods_id,
		goods_type:$("#goodsedit_type").val()
	}
	);
}
</script>