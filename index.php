<?php
header("Content-Type:text/html; charset=utf-8");
define('THINK_PATH','./ThinkPHP/');
//定义项目名称
define('APP_NAME', 'App');
//定义项目路径
define('APP_PATH', './App/');
//开启调试模式
define('APP_DEBUG', TRUE );
//加载框架文件
require THINK_PATH.'/ThinkPHP.php';