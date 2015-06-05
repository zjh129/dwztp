<?php
return array(
	'URL_ROUTER_ON'				=>	true,//开启路由
	'URL_ROUTE_RULES'			=>	array( //定义路由规则
			'Public/about'			=>	array('Single/view','id=1'),//正则路由
			'Public/gonggao'		=>	array('Single/view','id=2'),//正则路由
			'Public/contact'		=>	array('Single/view','id=3'),//正则路由
			'Public/link'			=>	array('Link/index'),//正则路由
	),
);