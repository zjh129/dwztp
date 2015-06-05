<?php
return array(
		'SHOW_PAGE_TRACE'			=>	false,//是否显示页面trace信息
		'DEFAULT_MODULE'			=>	'Index',//默认模块
		'DEFAULT_ACTION'			=>	'index',//默认操作
		
		'USER_AUTH_KEY'             =>	'memberdata',	// 用户认证SESSION标记
		
		'HTML_CACHE_ON'				=>	false,//静态缓存
		'HTML_CACHE_TIME'			=>	60,
		'HTML_CACHE_RULES'			=>	array(
				'*'=>array('{$_SERVER.REQUEST_URI|md5}'),
		)
	);