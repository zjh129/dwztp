<?php
class AttributeModel extends CommonModel
{
	protected $_validate	=	array(
			array('type_id','require','请选择属性所属商品类型'),
			);
	public function getattrlist( $where = array() )
	{
		return $this -> where( $where ) -> order('sort desc,attr_id asc') -> select();
	}
}