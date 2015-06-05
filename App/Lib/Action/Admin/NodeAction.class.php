<?php
class NodeAction extends CommonAction
{
	public function _before_index() {
		load('extend');
		$Node	=	D("Node");
		$list	=	$Node -> field( array('id',' title','name','sort','pid','level') ) -> order('sort asc,id asc') -> select() ;
		$list	=	list_to_tree($list);
		$this->assign('nodeList',$list);
	}
	public function index()
	{
		$this -> display();
	}
	//增加子节点
	public function add()
	{
		$node	=	D('Node');
		if ( $_POST ){
			if ( $node -> create() ){
				if ( $node -> add() ){
					ajaxReturn(200,'添加节点成功','node','Node/index');
				}else {
					ajaxReturn(300,'添加节点失败:'.$node -> getDbError() );
				}
			}else{
				ajaxReturn(300, $node -> getError() );
			}
		}else{
			$pid	=	$this -> _get('pid');
			if ( $pid ){
				$pdata	=	$node -> find( $pid );
				if ( $pdata['level'] == 3 ){
					ajaxReturn(300,"该级别下不能添加子节点");
				}else{
					$pdata['level']	=	$pdata['level']+1;
					$pdata['sort']	=	$node -> where( array('pid'=> array('EQ',$pid ) ) ) -> max('sort')+1;
					$this -> assign($pdata);
					$this -> display();
				}
			}else{
				ajaxReturn(300,"您还未选择父节点");
			}
		}
	}
	//批量增加节点
	public function patchAdd()
	{
		if ( $_POST ){
			$Node	=	D('Node');
			if ( !empty( $_POST['name'] ) ){
				$error	=	array(0);
				$right	=	array(1);
				foreach ( $_POST['name'] as $k => $v ){
					$data['name']		=	$_POST['name'][$k];
					$data['title']		=	$_POST['title'][$k];
					$data['remark']		=	$_POST['remark'][$k];
					$data['status']		=	$_POST['status'][$k];
					$data['level']		=	$Node -> getlevel( $_POST['pid'][$k]);
					$data['sort']		=	$_POST['sort'][$k];
					$data['pid']		=	$_POST['pid'][$k];
					if ( $Node -> checkNodeOnly( array( 'name' => $data['name'],'pid' => $data['pid'] ) ) ){
						if ( $Node -> data( $data ) -> add( $data ) ){
							array_push( $right , $data['name'] );
						}else{
							array_push( $error , $data['name'] );
						}
					}else{
						array_push( $error , $data['name']);
					}
					unset( $data );
				}
				ajaxReturn(200 , "数据添加成功,信息反馈(成功添加:[".implode(',', $right)."],重复数据或添加失败:[".implode(',', $error)."])",'node',"Node/index");
			}else{
				ajaxReturn(300,'您还未设置添加内容');
			}
		}else{
			$this -> display();
		}
	}
	//批量增加显示父节点
	public function patchParlist()
	{
		load('extend');
		$Node	=	D("Node");
		$list	=	$Node -> where('level in (1,2)') -> field( array('id',' title','name','sort','pid','level') ) -> order('sort asc,id asc') -> select() ;
		$list	=	list_to_tree($list);
		$this->assign('nodeList',$list);
		$param	=	$_POST;
		$this -> assign('param',$param);
		$this -> display();
	}
	//批量增加状态选择
	public function patchStatus()
	{
		$param	=	$_POST;
		$this -> assign('param',$param);
		$this -> display();
	}
	//编辑节点
	public function edit()
	{
		$id		=	$this -> _get('id');
		$Node	=	D('Node');
		if ( $_POST ){
			if ( $data	=	$Node -> create() ){
				if ( $Node -> save() ){
					ajaxReturn(200,'修改节点成功','node','Node/index');
				}else{
					ajaxReturn(300,'修改节点错误：'.$Node -> getDbError() );
				}
			}else{
				ajaxReturn(300,$Node -> getError() );
			}
		}else{
			if ( $id ){
				$Ndata	=	$Node -> find( $id );
				$this -> assign( $Ndata );
				$this -> display();
			}else{
				ajaxReturn(300,"请选择要编辑的节点");
			}
		}
	}
	//删除节点
	public function del()
	{
		$id		=	$this -> _get('id');
		if ( $id ){
			$Node	=	D('Node');
			$ndata	=	$Node -> find( $id );
			if ( $ndata['level'] == 1 ){
				ajaxReturn(300,"顶级节点不能删除");
			}
			$chiarr	=	$Node -> getchilarr( $id );//获取当前节点ID的子节点集
			$map['id']	=	array('in' , $chiarr );
			if ( $Node -> where( $map ) -> delete() ){
				ajaxReturn( 200,"删除节点成功","node" , "Node/index",'forward' );
			}else{
				ajaxReturn(300,"删除节点失败:".$Node -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的节点");
		}
	}
	//排序方法
	public function sort()
	{
		$Category	=	D('Node');
		$reback		=	$Category -> MoveUpDown( $this -> _get( 'move'), $this -> _get('id') ,'id','sort',array('pid' => array('EQ',$this -> _get('pid') )) );
		if ( $reback['success'] == 1 ) {
			ajaxReturn( 200, $reback['msg'], 'node', 'Node/index',"forward");
		}else{
			ajaxReturn( 300 , $reback['msg'] );
		}
	}
}