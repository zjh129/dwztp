<?php
class MemberModel extends CommonModel{
	protected $_validate	=	array(
			array('account','','账号已经存在',0,'unique',1),//帐号新增时验证是否已存在
			array('r_password','password','重复密码不正确',0,'confirm'),
			array('u_name','require','真实姓名必填'),
			array('u_phone','require','电话号码必填'),
			array('u_school','require','请填写学校名称'),
			array('u_grade','require','请填写班级')
	);
	protected $_auto		=	array(
			array('password','md5',Model::MODEL_BOTH,'function'), // 对password字段在新增的时候使md5函数处理
			array('u_vip','isvip',Model::MODEL_BOTH ,'callback'),
			array('createtime','time',1,'function')
	);
	
	//回调函数，判断是否满足VIP
	protected function isvip()
	{
		if ( isset( $_POST['u_vip'] ) ) {
			return (int)$_POST['u_vip'];
		}else{
			$isvip	=	1;
			empty( $_POST['u_phone'] ) && $isvip = 0;
			empty( $_POST['u_school'] ) && $isvip = 0;
			empty( $_POST['u_grade'] ) && $isvip = 0;
			return $isvip;
		}
	}
}