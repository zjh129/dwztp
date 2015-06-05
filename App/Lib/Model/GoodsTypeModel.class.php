<?php
class GoodsTypeModel extends CommonModel
{
	protected $_validate	=	array(
			array('type_name','','该商品类型已存在',0,'unique',1),
			array('is_enable',array(0,1),'请选择有效的状态值',0,'in',3)
			);
	public function getarray( $where = array() )
	{
		return $this -> where( $where ) -> select();
	}
}