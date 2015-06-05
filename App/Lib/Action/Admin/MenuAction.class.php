<?php
class MenuAction extends CommonAction
{
	var $temp	=	array();
	/*
	 * 列表
	 */
	public function index()
	{
		load('extend');
		$Menu	=	M("Menu");
		$list	=	$Menu -> order('sort asc,id asc') -> select() ;
		$list	=	list_to_tree($list);
		$this	->	assign('menuList',$list);
		$this	->	display();
		
	}
	/*
	 * 新增
	 */
	public function add()
	{
		$Menu	=	D('Menu');
		if ( $_POST ){
			if ( $Menu -> create() ){
				if ( $Menu -> add() ){
					ajaxReturn(200,'添加菜单成功','menu','Menu/index');
				}else {
					ajaxReturn(300,'添加菜单失败:'.$Menu -> getDbError() );
				}
			}else{
				ajaxReturn(300, $Menu -> getError() );
			}
		}else{
			$pid	=	$this -> _get('pid');
			if ( $pid ){
				$pdata	=	$Menu -> find( $pid );
				if ( $pdata['level'] == 3 ){
					ajaxReturn(300,"该级别下不能添加子菜单");
				}else{
					$pdata['pid']	=	$pid;
					$pdata['level']	=	$pdata['level']+1;
					$pdata['sort']	=	$Menu -> where( array('pid'=> array('EQ',$pid ) ) ) -> max('sort')+1;
				}
			}else{
				$pdata	=	array('level' => 1 , 'pid' => 0 );
				$pdata['sort']	=	$Menu -> max('sort')+1;
			}
			$this -> assign($pdata);
			$this -> display();
		}
	}
	/*
	 * 编辑
	 */
	public function edit()
	{
		$Menu	=	D('Menu');
		if ( $_POST ){
			if ( $Menu -> create() ){
				if ( $Menu -> save() ){
					ajaxReturn(200,'修改菜单成功','menu','Menu/index');
				}else{
					ajaxReturn(300,'修改菜单错误：'.$Menu -> getDbError() );
				}
			}else{
				ajaxReturn(300,$Menu -> getError() );
			}
		}else{
			$id		=	$this -> _get('id');
			empty( $id ) && ajaxReturn(300,"请选择要修改的菜单项");
			if ( $id ){
				$Mdata	=	$Menu -> find( $id );
				$this -> assign( $Mdata );
				$this -> display();
			}else{
				ajaxReturn(300,"请选择要编辑的菜单");
			}
		}
	}
	/*
	 * 删除
	 */
	public function del()
	{
		$id		=	$this -> _get('id');
		if ( $id ){
			$Menu	=	D('Menu');
			$mdata	=	$Menu -> find( $id );
			if ( $mdata['level'] == 1 ){
				ajaxReturn(300,"顶级节点不能删除");
			}
			$chiarr	=	$Menu -> getchilarr( $id );//获取当前节点ID的子节点集
			$map['id']	=	array('in' , $chiarr );
			if ( $Menu -> where( $map ) -> delete() ){
				ajaxReturn( 200,"删除节点成功","menu" , "Menu/index",'forward' );
			}else{
				ajaxReturn(300,"删除节点失败:".$Menu -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的节点");
		}
	}
	/*
	 * 排序
	 */
	public function sort()
	{
		$Menu	=	D('Menu');
		$reback		=	$Menu -> MoveUpDown( $this -> _get( 'move'), $this -> _get('id') ,'id','sort',array('pid' => array('EQ',$this -> _get('pid') )) );
		if ( $reback['success'] == 1 ) {
			ajaxReturn( 200, $reback['msg'], 'menu', 'Menu/index',"forward");
		}else{
			ajaxReturn( 300 , $reback['msg'] );
		}
	}
	/*
	 * 缓存
	 */
	public function cache()
	{
		load('extend');
		$Menu	=	M("Menu");
		$list	=	$Menu -> order('sort asc,id asc') -> select() ;
		F('orig_menu_data', $list);
		$list	=	list_to_tree($list);
		//$keytochilarr	=	$this -> child2keyarr( $list );
		F('menu_data' , $list );//原始数据转换为数组形式
		//F('keytochilarr' , $keytochilarr );//栏目唯一key对应子栏目数组
		ajaxReturn( 200,"更新缓存成功","menu" , "Menu/index",'forward' );
	}
	private function child2keyarr( $list , $chilfield = '_child' )
	{
		$temparr	=	array();
		if ( !empty( $list ) ) {
			foreach ( $list as $v ){
				if ( !empty( $v[ $chilfield ] ) ) {
					$this -> child2keyarr( $v[ $chilfield ] );
					$temparr[ $v['id'].$chilfield ]	=	$this -> fitterchildarr( $v[ $chilfield ] , $chilfield );
					$this -> temp	=	array_merge( $this -> temp , $temparr );
				}
			}
		}
		return $this -> temp;
	}
	private function fitterchildarr( $list, $chilfield = '_child' )
	{
		$temp	=	array();
		if ( !empty( $list ) ) {
			foreach ( $list as $v ){
				if ( !empty( $v[ $chilfield ] ) ) {
					unset( $v[ $chilfield ] );
				}
				$temp[]		=	$v;
			}
		}
		return $temp;
	}
}