<?php
class RoleAction extends CommonAction
{
	public function _before_index()
	{
		load('extend');
		$Role	=	D('Role');
		$list	=	$Role -> field( array('id','name','pid','level') ) -> order('id asc') -> select() ;
		$list	=	list_to_tree($list);
		$this->assign('roleList',$list);
	}
	//角色列表
	public function index()
	{
		$this -> display();
	}
	//增加角色
	public function add()
	{
		$Role	=	D('Role');
		if ( $_POST ){
			if ( $data	=	$Role -> create() ){
				if ( $Role -> add() ){
					ajaxReturn(200,'添加角色成功','role','Role/index');
				}else {
					ajaxReturn(300,'添加角色失败:'.$Role -> getDbError() );
				}
			}else{
				ajaxReturn(300, $Role -> getError() );
			}
		}else{
			$pid	=	$this -> _get('pid');
			if ( $pid ){
				$pdata	=	$Role -> find( $pid );
				if ( $pdata['level'] == 3 ){
					ajaxReturn(300,"该角色下不能再添加子角色");
				}else{
					$pdata['level']	=	$pdata['level']+1;
				}
			}else {
				$pdata	=	array('level' => 1,'id'=>0);
			}
			$this -> assign($pdata);
			$this -> display();
		}
	}
	//编辑节点
	public function edit()
	{
		$id		=	$this -> _get('id');
		$Role	=	D('Role');
		if ( $_POST ){
			if ( $data	=	$Role -> create() ){
				if ( $Role -> save() ){
					ajaxReturn(200,'修改角色成功','node','Node/index');
				}else{
					ajaxReturn(300,'修改角色错误：'.$Role -> getDbError() );
				}
			}else{
				ajaxReturn(300,$Role -> getError() );
			}
		}else{
			if ( $id ){
				$Ndata	=	$Role -> find( $id );
				$this -> assign( $Ndata );
				$this -> display();
			}else{
				ajaxReturn(300,"请选择要编辑的角色");
			}
		}
	}
	//删除角色
	public function del()
	{
		$id		=	$this -> _get('id');
		if ( $id ){
			$Role	=	D('Role');
			$ndata	=	$Role -> find( $id );
			/*if ( $ndata['level'] == 1 ){
				ajaxReturn(300,"顶级节点不能删除");
			}*/
			$chiarr	=	$Role -> getchilarr( $id );//获取当前节点ID的子节点集
			$map['id']	=	array('in' , $chiarr );
			if ( $Role -> where( $map ) -> delete() ){
				ajaxReturn( 200,"删除节点成功","role" , "Role/index",'forward' );
			}else{
				ajaxReturn(300,"删除节点失败:".$Role -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的节点");
		}
	}
	/*
	 * 角色权限授予
	 */
	public function selectnode()
	{
		if ( $_POST ){
			$roleid	=	$this -> _post('roleid');
			empty( $roleid ) && ajaxReturn(300 , '请指定要授权的角色');
			$access	=	D("Access");
			//使用先删除后插入的方式
			$access -> where( 'role_id='.$roleid ) -> delete();
			$nodestrarr	=	explode(',' , $_POST['nodestr'] );//接收以选择的节点数组串
			$tempdata	=	array();
			$access	->	startTrans();
			//循环节点值执行插入
			foreach ( $nodestrarr as $nodestrv ){
				$strarr	=	stripos( $nodestrv , "-" ) == false ? array( $nodestrv ) :  explode('-', $nodestrv );
				//循环该该节点切割后的数组
				foreach ( $strarr as $k => $v ){
					if ( $access -> isExist( $roleid , $v ) == false ){
						$tempdata[]	=	array(
										'role_id' => $roleid ,
										'node_id' => $v ,
										'level' => $k+1 ,
										'pid' => $k == 0 ? 0 : $strarr[$k-1]
										);
					}
				}
				unset( $strarr );
			}
			$save	=	$access	-> addAll( $tempdata );
			if ( is_int( $save ) ) {
				$access -> commit();
				ajaxReturn(200,'角色授权成功','node','Node/index');
			}else{
				$access -> rollback();
				ajaxReturn(300,"角色授权失败");
			}
		}else{
			load('extend');
			$data['roleid']	=	$this -> _get('roleid');
			empty( $data['roleid'] ) && ajaxReturn(300 , "请选择要编辑权限的角色");
			$Node	=	D("Node");
			$access	=	M("Access");
			//列出所有节点
			$list	=	$Node -> field( array('id',' title','name','sort','pid','level') ) -> order('sort asc,id asc') -> select() ;
			$data['nodeList']	=	list_to_tree($list);
			//查询出该角色所有的节点列表
			$data['usernodearr']	=	array();
			if ( !empty( $data['roleid'] ) ){
				$map['role_id']	=	array('eq', $data['roleid'] );//查询条件
				$usernodels	=	$access -> where( $map ) -> select();
				foreach ( $usernodels as $vo ){
					$data['usernodearr'][]	=	$vo['node_id'];
				}
			}
			if ( empty( $data['usernodearr'] ) ) {
				$data['usernodearr']	=	array(15,16,17,18);//首次授权默认将后台模块全选
			}
			$this->assign( $data );
			$this -> display();
		}
	}
	/*
	 * 角色的用户选择
	 */
	public function selectuser()
	{
		if ( $_POST ){
			$roleuser		=	M('RoleUser');
			$secuserarr		=	$_POST['user'];
			$roleid			=	$this -> _post('role_id');
			$roleuser		->	startTrans();//开启事务
			//先删除该角色下的所有用户，然后再添加
			$act1	=	$roleuser -> where( "role_id=$roleid" ) -> delete();
			if ( !empty( $secuserarr ) ){
				$roleuserlist	=	array();
				foreach ( $secuserarr as $v ){
					$roleuserlist[]	=	array('role_id'	=>	$roleid,'user_id'	=>	$v );	
				}
				$act2	=	$roleuser -> addAll( $roleuserlist );
			}else{
				$act2	=	0;
			}
			if ( $act1!==false && $act2 !== false ) {
				$roleuser -> commit();
				ajaxReturn(200,'角色用户选取成功','node','Node/index');
			}else{
				$roleuser -> rollback();
				ajaxReturn(300,'角色用户选取失败');
			}
		}else{
			//读取系统的用户列表
			$user		=	D("User");
			$roleuser	=	M('RoleUser');
			$data['userlist']   =  $user -> field('id,account,nickname') -> where('id<>1') -> select();
			//获取当前用户组信息
			$data['roleid']		=	isset($_GET['roleid'])?$_GET['roleid']:'';//角色id
			$data['roleuserlist']	=	array();
			if( !empty( $data['roleid'] ) ) {
				//获取当前组的用户列表
				$list	=	$roleuser -> where('role_id='.$data['roleid']) -> select();
				foreach ($list as $vo){
					$data['roleuserlist'][]	=	$vo['user_id'];
				}
			}
			$this -> assign( $data );
			$this -> display();
		}
	}
}