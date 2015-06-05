<?php
/*
 * 权限模型
 */
class AccessModel extends Model {
	/*
	 * 判断指定角色的指定节点id是否存在,存在返回true，否则返回false
	 */
	function isExist( $roleid , $nodeid  )
	{
		$data	=	$this -> where( "role_id = $roleid and node_id=$nodeid" ) -> find();
		return empty( $data ) ? false : true ;
	}
}