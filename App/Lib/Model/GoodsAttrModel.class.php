<?php
class GoodsAttrModel extends CommonModel {
	/*
	 * 获取指定商品id的商品属性值，并以商品类型属性id对应属性值返回
	 */
	public function getarr_attrid_to_value( $goods_id ){
		$where['goods_id']	=	array('eq' , $goods_id );
		$goods_attr_arr		=	$this -> where( $where ) -> select();
		$temp				=	array();
		foreach( $goods_attr_arr as $k => $v ){
			$temp[ $v['attr_id'] ]		=	$v['attr_value'];
		}
		return $temp;
	}
}