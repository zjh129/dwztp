<?php
class SystemModel extends CommonModel
{
	//自动验证
	protected $_validate	=	array(
			array('name','require','字段名必填'),
			array('key','require','字段标识必填'),
			array('key','','字段标识必须是唯一的',0,'unique',1),
			array('value','require','请输入字段值')
			);
	//自动完成
	protected $_auto		=	array(
			array('createtime','time',1,'function')
			);
}