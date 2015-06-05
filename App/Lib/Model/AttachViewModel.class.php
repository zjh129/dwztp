<?php
class AttachViewModel extends ViewModel
{
	public $viewFields	=	array(
			'Attach'	=>	array('id','adduser','type','size','extension','savepath','savename','thumbname','createtime','_type' => 'LEFT'),
			'User'		=>	array('account','nickname','_on' => 'Attach.adduser=User.id')
			);
}