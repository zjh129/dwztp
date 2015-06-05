<?php
class BookViewModel extends ViewModel
{
	public $viewFields	=	array(
			'Book'		=>	array('id','userid','type','artid','nickname','title','tel','ip','content','answer','disp','createtime','_type' => 'LEFT'),
			'Member'	=>	array('account','u_name','_on' => 'Book.userid=Member.id')
	);
}