<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle">单页添加</h2>
<div style="display:block; overflow:hidden; line-height:21px;">
  <div class="tabs">
    <div class="tabsHeader">
      <div class="tabsHeaderContent">
        <ul>
          <li><a href="javascript:;"><span>基本信息</span></a></li>
        </ul>
      </div>
    </div>
    <form method="post" action="__ACTION__" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone)">
    <input name="id" type="hidden" value="<?php echo ($single_data["id"]); ?>" />
      <div class="tabsContent" layoutH="115">
        <div>
          <div class="pageFormContent nowrap" layoutH="158">
            <dl>
              <dt>文章标题：</dt>
              <dd>
                <input type="text" name="title" maxlength="20" style="width:400px;" value="<?php echo ($single_data["title"]); ?>" class="required" />
                <span class="info">请输入文章标题</span> </dd>
            </dl>
            <dl>
              <dt>关键字：</dt>
              <dd>
                <input type="text" name="keywords" value="<?php echo ($single_data["keywords"]); ?>" style="width:400px;" />
              </dd>
            </dl>
            <dl>
              <dt>内容摘要：</dt>
              <dd>
                <textarea name="des" cols="80" rows="2"><?php echo ($single_data["des"]); ?></textarea>
              </dd>
            </dl>
            <dl>
              <dt>单页内容：</dt>
              <dd>
                <textarea class="editor" name="content" rows="8" cols="100" style="height:440px;"
                    upLinkUrl="<?php echo U('Attach/editor_linkupload');?>" upLinkExt="tar,zip,tgz,rar,ppt,pptx,doc,pdf,xls,xlsx,txt"
                    upImgUrl="<?php echo U('Attach/editor_imgupload');?>" upImgExt="jpg,jpeg,gif,png"
                    upFlashUrl="<?php echo U('Attach/editor_flashupload');?>" upFlashExt="swf"
                    upMediaUrl="<?php echo U('Attach/editor_mediaupload');?>" upMediaExt:"avi">
                    <?php echo ($single_data["content"]); ?>
                    </textarea>
              </dd>
            </dl>
            <dl>
              <dt>自定义模板：</dt>
              <dd>
                <input type="text" name="template_file" value="<?php echo ($single_data["template_file"]); ?>" />
                <span class="info">例如：Single_view，（不要加.html）</span></dd>
            </dl>
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