<?php
class MemberViewModel extends ViewModel{
	public $viewFields	=	array(
			'Member'		=>	array('id','account','password','u_name','u_phone','u_school','u_grade','u_vip','u_address','u_birthday','u_photo','u_qq','u_email','u_course','u_time','u_lever','u_reg','last_login_time','last_login_ip','login_count','remark','status','createtime','_type' => 'LEFT'),
			'Attach'		=>	array('savepath','savename','thumbname','_on'=>'Member.u_photo=Attach.id','_type' => 'LEFT'),
	);
}