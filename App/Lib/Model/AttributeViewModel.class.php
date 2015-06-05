<?php
class AttributeViewModel extends ViewModel
{
	public $viewFields	=	array(
			'Attribute'	=>	array('attr_id','type_id','attr_name','attr_type','attr_input_type','attr_value','sort'),
			'GoodsType'	=>	array('type_name','_on'=>'Attribute.type_id=GoodsType.Type_id','_type'=>'LEFT')
			);
}