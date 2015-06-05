<?php
/*
 * 商品属性编辑表
 */
class AttributeAction extends CommonAction
{
	/*
	 * 属性列表
	 */
	public function index()
	{
		$type_id	=	$this -> _param('type_id');
		$goodstype	=	D('GoodsType');
		$attribute	=	D('AttributeView');
		if( empty( $type_id ) ){
			//默认为最小商品类型
			$type_id = $goodstype -> min('type_id');
		}
		if ( !empty( $type_id ) ){
			$data['type_id']		=	$type_id;
			$data['goodstype_list']	=	$goodstype -> getarray( );
			$data['numPerPage']		=	(int)$this -> _post('numPerPage',"",10);//每页显示多少条
			$data['currentPage']	=	(int)$this -> _post('pageNum',"",1);//当前页
			$data['keywords']		=	$this -> _post('keywords');//查询关键字
			$map	=	array();
			$map['type_id']			=	array('eq',$type_id );
			if ( !empty( $data['keywords'] ) ){
				$map['attr_name']	=	array('like','%'.$data['keywords'].'%');
			}
			$data['totalCount']	=	$attribute -> where( $map ) -> count();
			$data['list']		=	$attribute -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('sort desc') -> select();
			$this -> update_goodstype_cache();//更新商品类型缓存
			$this -> assign( $data );
			$this -> display();
		}else{
			ajaxReturn(300 , "请指定商品类型",'goodstype','GoodsType/index');
		}
	}
	/*
	 * 添加属性
	 */
	public function add()
	{
		if ( $_POST ){
			$Attribute		=	M('Attribute');
			$data['type_id']		=	$this -> _post('type_id');
			$data['attr_name']		=	$this -> _post('attr_name');
			$data['attr_type']		=	$this -> _post('attr_type');
			$data['attr_input_type']=	$this -> _post('attr_input_type');
			$data['attr_value']		=	$this -> _post('attr_value');
			$data['sort']			=	$this -> _post('sort');
			if ( $Attribute -> add( $data ) ){
				$this -> update_goodstype_cache();//更新商品类型缓存
				ajaxReturn(200,"添加属性成功",'attribute','Attribute/index?type_id='.$data['type_id']);
			}else{
				ajaxReturn(300,"添加属性失败:".$Attribute -> getDbError());
			}
		}else{
			$goodstype	=	D('GoodsType');
			$data['goodstype_list']	=$goodstype -> getarray( );
			$data['type_id']	=	$this -> _get('type_id');
			$this -> assign($data);
			$this -> display();
		}
	}
	/*
	 * 编辑属性
	 */
	public function edit()
	{
		if ( $_POST ){
			$Attribute		=	M('Attribute');
			if ( $data	=	$Attribute -> create() ){
				if ( $Attribute -> save(  )  ){
					$this -> update_goodstype_cache();//更新商品类型缓存
					ajaxReturn(200,"编辑属性成功",'attribute','Attribute/index?type_id='.$data['type_id']);
				}else{
					ajaxReturn(300,"编辑属性错误:".$Attribute -> getDbError() );
				}
			}else{
				ajaxReturn(300,"错误:".$Attribute -> getError() );
			}
		}else{
			$goodstype	=	D('GoodsType');
			$attribute	=	M('Attribute');
			$data['goodstype_list']	=$goodstype -> getarray( );
			$attr_id	=	$this -> _get('attr_id');
			$data['data']	=	$attribute -> find( $attr_id );
			$this -> assign( $data );
			$this -> display();
		}
	}
	/*
	 * 删除属性
	 */
	public function del()
	{
		$attr_id	=	$this -> _get('attr_id');
		$type_id	=	$this -> _get('type_id');
		if ( !empty( $attr_id ) ){
			$Attribute	=	M('Attribute');
			if ( $Attribute -> delete( $attr_id ) ){
				$this -> update_goodstype_cache();//更新商品类型缓存
				ajaxReturn(200,"删除属性成功",'attribute','Attribute/index?type_id='.$type_id,"forward");
			}else{
				ajaxReturn(300,"删除错误:".$Attribute -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请指定要删除的属性");
		}
	}
	/*
	 * 批量删除
	 */
	public function batchdel()
	{
		$type_id	=	$this -> _get('type_id');
		$ids		=	$this -> _post('ids');
		if ( !empty( $ids ) ){
			$Attribute	=	M('Attribute');
			if ( $Attribute -> where('attr_id in ('.$ids.')') -> delete() ){
				$this -> update_goodstype_cache();//更新商品类型缓存
				ajaxReturn(200,"批量删除属性成功","attribute",'Attribute/index?type_id='.$type_id,"forward");
			}else{
				ajaxReturn(300,"删除错误:".$Attribute -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的属性");
		}
	}
	/*
	 * 生成商品类型的缓存
	 */
	public function update_goodstype_cache()
	{
		$Goodstype	=	M('GoodsType');
		$attribute	=	D('Attribute');
		$map['is_enable']	=	array('eq' , 1);
		$goodstypelist		=	$Goodstype -> where( $map ) -> select();
		$temparr			=	array();
		foreach( $goodstypelist as $gtk => $gtv ){
			$thisgt_attrlist	=	$attribute -> getattrlist( array('type_id' => array('eq',$gtv['type_id'] ) ) );
			$temparr[ $gtv['type_id'] ]	=	array_merge( $gtv , array('attrlist' => $thisgt_attrlist ) );
		}
		if ( F('goodstype_data') != $temparr ){//是否有改变，变化则更新缓存
			F( 'goodstype_data' , $temparr );
		}
	}
}