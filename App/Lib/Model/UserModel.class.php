<?php
class UserModel extends CommonModel
{
	//表单数据验证
	protected $_validate	=	array(
			array('account','require','帐号必填'),
			array('account','','该帐号名已存在', 0 , 'unique' , Model::MODEL_INSERT ),
			array('nickname','require','请填写该帐号的名称'),
			array('password','require','密码必须填写!',0,'regex',Model::MODEL_INSERT ),
			array('email','email','邮箱格式错误！'),
			//array('email','checkemail','此邮箱已存在',1,'callback',Model::MODEL_INSERT),
			);
	//数据的自动完成
	protected $_auto    =    array(
			//array(填充字段,填充内容,填充条件,附加规则)
			array('status',1),
			array('create_time','time',1,'function'),
			array('password','md5',1,'function'),
	);
}