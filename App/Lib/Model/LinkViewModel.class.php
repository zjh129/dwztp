<?php
class LinkViewModel extends ViewModel{
	public $viewFields	=	array(
			'Link'			=>	array('id','title','url','logo','sort','des','status','create_time','type','_type' => 'LEFT'),
			'Attach'		=>	array('savepath','savename','thumbname','_on'=>'Link.logo=Attach.id','_type' => 'LEFT'),
	);
}