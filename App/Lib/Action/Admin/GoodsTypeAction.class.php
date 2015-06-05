<?php
/*
 * 商品类型管理
 */
class GoodsTypeAction extends CommonAction
{
	/*
	 * 首页列表
	 */
	public function index()
	{
		$Goodstype	=	M('GoodsType');
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",10);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['keywords']	=	$this -> _post('keywords');//查询关键字
		$map	=	array();
		if ( !empty( $data['keywords'] ) ){
			$map['type_name']	=	array('like','%'.$data['keywords'].'%');	
		}
		$data['totalCount']	=	$Goodstype -> where( $map ) -> count();
		$data['list']		=	$Goodstype -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> select();
		$this -> assign( $data );
		$this -> display();
	}
	/*
	 * 添加商品类型
	 */
	public function add()
	{
		if ( $_POST ){
			$goodstype	=	D('GoodsType');
			if ( $data = $goodstype -> create() ){
				if ( $goodstype -> add() ){
					ajaxReturn(200,'添加商品类型成功','goodstype','GoodsType/index');
				}else{
					ajaxReturn(300,'添加商品类型失败:'.$goodstype -> getDbError() );
				}
			}else{
				ajaxReturn(300,"错误：".$goodstype -> getError() );
			}
		}else{
			$this -> display();
		}
	}
	/*
	 * 编辑商品模型
	 */
	public function edit()
	{
		$goodstype	=	D('GoodsType');
		if ( $_POST ){
			if ( $data	=	$goodstype -> create() ){
				if ( $goodstype -> save() ){
					ajaxReturn(200,'编辑商品类型成功','goodstype','GoodsType/index');
				}else{
					ajaxReturn(300,'编辑商品类型失败：'.$goodstype -> getDbError());
				}
			}else{
				ajaxReturn(300,"修改失败：".$goodstype -> getError());
			}
		}else{
			if ( $this -> _get("type_id") ){
				$data['data']	=	$goodstype -> find( $this -> _get("type_id") );
				$this	->	assign( $data );
			}else{
				ajaxReturn(300,"请指定要编辑的商品类型");
			}
			$this -> display();
		}
	}
	/*
	 * 切换指定商品类型的激活状态
	 */
	public function c_enable()
	{
		$data['type_id']	=	$this -> _get('type_id');
		$data['is_enable']	=	$this -> _get('act');
		$goodstype			=	M('GoodsType');
		if ( $goodstype -> save( $data ) ){
			ajaxReturn(200,$data['is_enable'] == 1 ? "激活成功":"锁定成功","goodstype","GoodsType/index","forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
	/*
	 * 删除商品类型
	 */
	public function del()
	{
		$type_id	=	$this -> _get('type_id');
		if( !empty( $type_id ) ){
			$goodstype	=	M('GoodsType');
			$attribute	=	M('Attribute');
			if ( $goodstype -> delete( $type_id ) ){
				$attribute -> where('type_id='.$type_id) -> delete();
				ajaxReturn(200,"删除商品类型成功","goodstype","GoodsType/index","forward");
			}else{
				ajaxReturn(300,"删除商品类型失败:".$goodstype -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请指定要删除的商品类型");
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
		ajaxReturn(200,'更新缓存成功','goodstype','GoodsType/index','forward');
	}
}