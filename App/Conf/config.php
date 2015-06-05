<?php
$db_config		=	require 'db_config.php';
$router_config	=	require 'router_config.php';
$config		=	 array(
	//'配置项'=>'配置值'
	'APP_AUTOLOAD_PATH' =>'@ORG.Uitl',
	//URL模式
	'URL_MODEL'					=>	2,
	'URL_DISPATCH_ON'			=>	1,
	'AUTO_BUILD_HTML'			=>	0,
	'APP_GROUP_LIST'			=>	'Home,Admin',//项目分组设置
	'DEFAULT_GROUP'				=>	'Home',//默认分组
	
	'TMPL_FILE_DEPR'			=>	'_',//分组模版下面模块和操作的分隔符
	'TMPL_L_DELIM'				=>	'{',//模板左标记
	'TMPL_R_DELIM'				=>	'}',//模板右标记
	
	'LOAD_EXT_FILE'				=>	'user',//加载扩展函数库
	
	'URL_HTML_SUFFIX'			=>	'.html',
	
	'TMPL_ACTION_ERROR'			=>	TMPL_PATH.'dispatch_jump.html',//错误提示模板文件
	'TMPL_ACTION_SUCCESS'		=>	TMPL_PATH.'dispatch_jump.html',//正确提示模板文件
	
	'LOAD_EXT_CONFIG'			=>	'user', // 加载扩展配置文件
);
return array_merge( $db_config , $router_config , $config );