<?php
class SystemAction extends CommonAction
{
	//系统参数列表
	public function index()
	{
		$System	=	M('System');
		$data['list']	=	$System	->	select();
		$this -> assign( $data );
		$this -> display();
	}
	//增加系统参数
	public function add()
	{
		$System	=	D('System');
		if ( $_POST ){
			if ( $data	=	$System -> create() ){
				if ( empty( $data['id'] ) ){//新增
					if ( $System -> add() ){
						ajaxReturn(200,'新增系统参数成功','system','System/index');
					}else{
						ajaxReturn(300,'新增数据失败：'.$System -> getDbError() );
					}
				}else{//编辑
					if ( $System -> save() ){
						ajaxReturn(200,'编辑系统参数成功','system','System/index');
					}else{
						ajaxReturn(300,'编辑数据失败：'.$System -> getDbError());
					}
				}
			}else{
				ajaxReturn(300,$System -> getError());
			}
		}else{
			if ( $this -> _get("id") ){
				$data['data']	=	$System -> find( $this -> _get("id") );
				$this	->	assign( $data );
			}
			$this -> display();
		}
	}
	//删除数据
	public function del()
	{
		$System	=	D('System');
		if ( $this -> _get("id") ){
			if ( $System -> delete( $this -> _get("id") ) ){
				ajaxReturn(200,'删除系统参数成功','system','System/index','forward');
			}else{
				ajaxReturn(300,'删除系统参数错误：'.$System -> getDbError() );
			}
		}else{
			ajaxReturn(300,'请选择要删除的数据');
		}
	}
	//生成缓存
	public function create_cache()
	{
		$System	=	D('System');
		$list	=	$System	->	select();
		$temp	=	array();
		foreach ( $list as $k => $v ){
			$temp[$v['key']]	=	$v;
		}
		F('system_data',$temp );
		ajaxReturn(200,'更新缓存成功','system','System/create_cache','forward');
	}
}