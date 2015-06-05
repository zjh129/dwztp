<?php
class MemberAction extends CommonAction{
	/*
	 * 会员列表
	 */
	public function index() {
		$Member			=	M('Member');
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['keywords']	=	$this -> _post('keywords');//查询关键字
		$map	=	array();
		if ( !empty( $data['keywords'] ) ){
			$map['title']		=	array('like','%'.$data['keywords'].'%');
		}
		$data['totalCount']	=	$Member -> where( $map ) -> count();
		$data['list']		=	$Member -> field('id,account,u_name,u_phone,u_school,u_grade,u_vip,u_reg,last_login_time,last_login_ip,status,createtime') -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('createtime desc') -> select();

		$this -> assign( $data );
		$this -> display();
	}
	/*
	 * 会员新增
	 */
	public function add()
	{
		if ($_POST) {
			$Member		=	D('Member');
			if ( $Member -> create() ) {
				if ( $Member -> add() ) {
					ajaxReturn(200 , "新增会员成功",'member','Member/index');
				}else{
					ajaxReturn(300,'新增会员失败:'.$Member -> getDbError() );
				}
			}else{
				ajaxReturn(300,"错误：".$Member -> getError() );
			}
		}else{
			$data['course_config_data']	=	F('course_config_data');
			$this	->	assign( $data );
			$this	->	display();
		}
	}
	/*
	 * 会员编辑
	 */
	public function edit()
	{
		
		if ( $_POST ) {
			$Member		=	D('Member');
			if ( $data	=	$Member -> create() ) {
				//如果没有输入密码，则表示不修改密码
				if ( empty( $_POST['password'] ) ) {
					unset( $data['password'] );
				}
				if ( $Member -> save( $data ) ) {
					ajaxReturn(200 , "编辑会员信息成功",'member','Member/index');
				}else{
					ajaxReturn(300,'编辑会员信息失败:'.$Member -> getDbError() );
				}
			}else{
				ajaxReturn(300,"错误：".$Member -> getError() );
			}
		}else{
			$Member		=	D('MemberView');
			$u_id		=	$this -> _get('u_id');
			empty( $u_id ) && ajaxReturn(300,"请选择要编辑的会员");
			$data['udata']			=	$Member	->	find( $u_id );
			empty( $data['udata'] ) && ajaxReturn(300,"会员信息不存在");
			$data['course_config_data']	=	F('course_config_data');
			$this	->	assign( $data );
			$this	->	display();
		}
	}
	/*
	 * 删除帐号
	 */	
	public function del()
	{
		$uid			=	$this -> _get('u_id');
		empty( $uid ) && ajaxReturn(300,"请选择要删除的会员");
		$Member			=	M( 'Member' );
 		$Attach			=	D('Attach');
 		$udata			=	$Member -> find( $uid );
 		if ( $Member -> delete( $uid ) ){
 			$Attach		->	del( $udata['u_photo'] );
 			ajaxReturn( 200,'删除会员成功','member','Member/index','' );
 		}else{
 			ajaxReturn(300,"删除会员失败：".$Member -> getDbError() );
 		}
	}
	/*
	 * 改变VIP状态
	 */
	public function change_isvip()
	{
		$udata['id']	=	$this -> _get('u_id');
		empty( $udata['id'] ) && ajaxReturn(300,"请选择会员");
		$udata['u_vip']	=	$this -> _get('isvip');
		$Member			=	M('Member');
		if ( $Member -> save( $udata ) ) {
			ajaxReturn(200, $udata['u_vip'] == 1 ? "设置VIP成功" : "取消VIP成功", "member", "Member/index", "forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
	/*
	 * 改变是否交费
	*/
	public function change_isreg()
	{
		$udata['id']	=	$this -> _get('u_id');
		empty( $udata['id'] ) && ajaxReturn(300,"请选择会员");
		$udata['u_reg']	=	$this -> _get('isreg');
		$Member			=	M('Member');
		if ( $Member -> save( $udata ) ) {
			ajaxReturn(200, $udata['u_reg'] == 1 ? "设置已交费成功" : "取消交费成功", "member", "Member/index", "forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
	/*
	 * 改变激活状态
	*/
	public function change_status()
	{
		$udata['id']	=	$this -> _get('u_id');
		empty( $udata['id'] ) && ajaxReturn(300,"请选择会员");
		$udata['status']	=	$this -> _get('status');
		$Member			=	M('Member');
		if ( $Member -> save( $udata ) ) {
			ajaxReturn(200, $udata['status'] == 1 ? "激活会员成功" : "禁用会员成功", "member", "Member/index", "forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
	/*
	 * 课程列表配置函数
	 */
	public function course_config() {
		$configname		=	'course_config_data';
		if ($_POST) {
			$data		=	$this -> _post('courselist');
			$data		=	explode( PHP_EOL , $data );
			if (  F( $configname , $data ) ){
				ajaxReturn(200 , "更新课程列表值成功",'member','Member/index');
			}else{
				ajaxReturn(300,"更新列表值失败");
			}
		}else{
			$value			=	F( $configname );
			$data['value']	=	implode( PHP_EOL , $value );
			$this	->	assign( $data );
			$this	->	display();
		}
	}
}