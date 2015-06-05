<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>网站后台管理</title>
<link href="__PUBLIC__/Admin/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="__PUBLIC__/Admin/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="__PUBLIC__/Admin/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="__PUBLIC__/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="__PUBLIC__/Admin/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lte IE 9]>
<script src=""__PUBLIC__/Admin/js/speedup.js" type="text/javascript"></script>
<![endif]-->
<!--引入Jquery外部库-->
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.3.min.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/jquery.cookie.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/jquery.validate.min.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/jquery.bgiframe.js"></script><script type="text/javascript" src="__PUBLIC__/xheditor/xheditor-1.1.14-zh-cn.min.js"></script><script type="text/javascript" src="__PUBLIC__/uploadify/scripts/jquery.uploadify.js"></script>
<!--fineuploader-->
<link href="__PUBLIC__/file-uploader/fineuploader.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="__PUBLIC__/file-uploader/jquery.fineuploader-3.0.js"></script>
<!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
<script type="text/javascript" src="__PUBLIC__/Admin/chart/raphael.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/chart/g.raphael.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/chart/g.bar.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/chart/g.line.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/chart/g.pie.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/chart/g.dot.js"></script>
<!--引入dwz核心库-->
<script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.core.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.util.date.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.validate.method.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.regional.zh.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.barDrag.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.drag.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.tree.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.accordion.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.ui.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.theme.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.switchEnv.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.alertMsg.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.contextmenu.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.navTab.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.tab.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.resize.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.dialog.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.dialogDrag.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.sortDrag.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.cssTable.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.stable.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.taskBar.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.ajax.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.pagination.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.database.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.datepicker.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.effects.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.panel.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.checkbox.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.history.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.combox.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.print.js"></script><script type="text/javascript" src="__PUBLIC__/Admin/js/dwz.regional.zh.js"></script>

<!-- ColorPicker - jQuery plugin -->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/colorpicker/css/colorpicker.css" /><script type="text/javascript" src="__PUBLIC__/colorpicker/js/colorpicker.js"></script><script type="text/javascript" src="__PUBLIC__/colorpicker/js/eye.js"></script><script type="text/javascript" src="__PUBLIC__/colorpicker/js/utils.js"></script>

<script type="text/javascript">
$(function(){
	DWZ.init("__PUBLIC__/Admin/dwz.frag.xml", {
		//loginUrl:"<?php echo U('Public/logindialog');?>", loginTitle:"登录",	// 弹出登录对话框
		loginUrl:"<?php echo U('Public/login');?>",	// 跳到登录页面
		statusCode:{ok:200,changepwd:201, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		debug:true,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"__PUBLIC__/Admin/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});
</script>
</head>

<body scroll="no">
<div id="layout">
  <div id="header">
    <div class="headerNav"> <a class="logo" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">标志</a>
      <ul class="nav">
        <!--<li id="switchEnvBox"><a href="javascript:">（<span>北京</span>）切换城市</a>
						<ul>
							<li><a href="sidebar_1.html">北京</a></li>
							<li><a href="sidebar_2.html">上海</a></li>
							<li><a href="sidebar_2.html">南京</a></li>
							<li><a href="sidebar_2.html">深圳</a></li>
							<li><a href="sidebar_2.html">广州</a></li>
							<li><a href="sidebar_2.html">天津</a></li>
							<li><a href="sidebar_2.html">杭州</a></li>
						</ul>
					</li>-->
        <?php if( ishavepower('Index/changepwd') ){ ?><li><a href="<?php echo U('Index/changepwd');?>" target="dialog" mask=true title="修改密码" width="600">修改密码</a></li><?php } ?>
        <!--<li><a href="http://blog.srabbit.com/" target="_blank">博客</a></li>
        <li><a href="http://weibo.com/fuckyoulove" target="_blank">微博</a></li>-->
        <li><a href="<?php echo U('Public/logout');?>" onclick="javascript:return confirm('你确定要退出系统吗？');">退出</a></li>
      </ul>
      <ul class="themeList" id="themeList">
        <li theme="default">
          <div class="selected">蓝色</div>
        </li>
        <li theme="green">
          <div>绿色</div>
        </li>
        <!--<li theme="red"><div>红色</div></li>-->
        <li theme="purple">
          <div>紫色</div>
        </li>
        <li theme="silver">
          <div>银色</div>
        </li>
        <li theme="azure">
          <div>天蓝</div>
        </li>
      </ul>
    </div>
    
    <!-- navMenu --> 
    
  </div>
  <div id="leftside">
    <div id="sidebar_s">
      <div class="collapse">
        <div class="toggleCollapse">
          <div></div>
        </div>
      </div>
    </div>
    <div id="sidebar">
      <div class="toggleCollapse">
        <h2>主菜单</h2>
        <div>收缩</div>
      </div>
      <div class="accordion" fillSpace="sidebar">
      <?php if( ishavepower('Index/main') || ishavepower('Attach/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>主面板</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('Index/main') ){ ?><li><a href="<?php echo U('Index/main');?>" target="navTab" rel="main">我的主页</a></li><?php } ?>
            <?php if( ishavepower('Attach/index') ){ ?><li><a href="<?php echo U('Attach/index');?>" target="navTab" rel="attach">附件管理</a></li><?php } ?>
          </ul>
        </div><?php } ?>        
        <?php if( ishavepower('System/index') || ishavepower('Single/index') || ishavepower('Menu/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>前台管理</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('System/index') ){ ?><li><a href="<?php echo U('System/index');?>" target="navTab" rel="system">系统参数</a></li><?php } ?>
            <?php if( ishavepower('Single/index') ){ ?><li><a href="<?php echo U('Single/index');?>" target="navTab" rel="single">单页管理</a></li><?php } ?>
            <?php if( ishavepower('Menu/index') ){ ?><li><a href="<?php echo U('Menu/index');?>" target="navTab" rel="menu">前台菜单</a></li><?php } ?>
          </ul>
        </div><?php } ?>
        <?php if( ishavepower('Member/index') || ishavepower('Book/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>会员管理</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('Member/index') ){ ?><li><a href="<?php echo U('Member/index');?>" target="navTab" rel="member">注册会员管理</a></li><?php } ?>
            <?php if( ishavepower('Book/index') ){ ?><li><a href="<?php echo U('Book/index');?>" target="navTab" rel="book">留言板管理</a></li><?php } ?>
          </ul>
        </div><?php } ?>
        <?php if( ishavepower('Article/index') || ishavepower('ArtCategory/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>文章管理</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('Article/index') ){ ?><li><a href="<?php echo U('Article/index');?>" target="navTab" rel="article">文章列表</a></li><?php } ?>
            <?php if( ishavepower('ArtCategory/index') ){ ?><li><a href="<?php echo U('ArtCategory/index');?>" target="navTab" rel="artcat_index">文章分类</a></li><?php } ?>
          </ul>
        </div><?php } ?>
        <?php if( ishavepower('Goods/index') || ishavepower('Category/index') || ishavepower('GoodsType/index') || ishavepower('Attribute/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>商品管理</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
           	<?php if( ishavepower('Goods/index') ){ ?><li><a href="<?php echo U('Goods/index');?>" target="navTab" rel="goodindex">商品列表</a></li><?php } ?>
            <?php if( ishavepower('Category/index') ){ ?><li><a href="<?php echo U('Category/index');?>" target="navTab" rel="cat_index">商品分类</a></li><?php } ?>
            <?php if( ishavepower('GoodsType/index') ){ ?><li><a href="<?php echo U('GoodsType/index');?>" target="navTab" rel="goodstype">商品类型</a></li><?php } ?>
            <?php if( ishavepower('Attribute/index') ){ ?><li><a href="<?php echo U('Attribute/index');?>" target="navTab" rel="attribute">商品属性列表</a></li><?php } ?>
          </ul>
        </div><?php } ?>
        <?php if( ishavepower('Link/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>友情链接</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('Link/index') ){ ?><li><a href="<?php echo U('Link/index');?>" target="navTab" rel="link">友情链接列表</a></li><?php } ?>
          </ul>
        </div><?php } ?>
        <?php if( ishavepower('Node/index') || ishavepower('Role/index') || ishavepower('User/index') ){ ?>
        <div class="accordionHeader">
          <h2><span>Folder</span>后台管理</h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
            <?php if( ishavepower('Node/index') ){ ?><li><a href="<?php echo U('Node/index');?>" target="navTab" rel="node">节点设置</a></li><?php } ?>
            <?php if( ishavepower('Role/index') ){ ?><li><a href="<?php echo U('Role/index');?>" target="navTab" rel="role">角色管理</a></li><?php } ?>
            <?php if( ishavepower('User/index') ){ ?><li><a href="<?php echo U('User/index',array('rel'=>'user'));?>" target="navTab" rel="user">后台用户</a></li><?php } ?>
          </ul>
        </div><?php } ?>
      </div>
    </div>
  </div>
  <div id="container">
    <div id="navTab" class="tabsPage">
      <div class="tabsPageHeader">
        <div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
          <ul class="navTab-tab">
            <li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
          </ul>
        </div>
        <div class="tabsLeft">left</div>
        <!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
        <div class="tabsRight">right</div>
        <!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
        <div class="tabsMore">more</div>
      </div>
      <ul class="tabsMoreList">
        <li><a href="javascript:;">我的主页</a></li>
      </ul>
      <div class="navTab-panel tabsPageContent layoutBox">
        <div class="pageFormContent" layoutH="56">
        <h2 class="contentTitle">系统信息</h2>
          <fieldset>
            <legend>版权信息</legend>
            <div style="padding:10px;">本系统基于国内知名的PHP框架-TinkPHP，适合架设小型企业站，免费开源.</div>
          </fieldset>
          <fieldset>
            <legend>系统参数</legend>
            <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl class="nowrap">
                <dt style="width:150px; color:#090;"><?php echo ($key); ?></dt>
                <dd><?php echo ($vo); ?></dd>
              </dl><?php endforeach; endif; else: echo "" ;endif; ?>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="footer">Copyright &copy; 2012 <!--<a href="demo_page2.html" target="dialog">DWZ团队</a> Tel：010-52897073--></div>
</body>
</html>