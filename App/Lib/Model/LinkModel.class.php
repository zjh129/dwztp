<?php
class LinkModel extends CommonModel
{
	protected $_validate	=	array(
			array('title','require','标题必填'),
			array('url','require','友情链接地址必填')
	);
	protected $_auto		=	array(
			array('create_time','time',1,'function'),
			array('update_time','time',2,'function'),
	);
}