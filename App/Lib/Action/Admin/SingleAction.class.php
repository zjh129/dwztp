<?php
class SingleAction extends CommonAction
{
	//单页列表
	public function index()
	{
		$Single		=	M("Single");
		$list		=	$Single -> select();
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['valartcat_id']	=	$this -> _post('artcat_id');
		$data['keywords']	=	$this -> _post('keywords');//查询关键字
		$map	=	array();
		if ( !empty( $data['keywords'] ) ){
			$map['title']		=	array('like','%'.$data['keywords'].'%');
		}
		$data['list']		=	$Single -> field('id,title,createtime') -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('createtime desc') -> select();
		$this -> assign( $data );
		$this -> display();
	}
	//新增单页
	public function add(){
		if ( $_POST ) {
			$Single		=	M('Single');
			if ( $Single -> autoCheckToken( $_POST ) ){
	 			$data		=	array(
	 					'user'		=>	$_SESSION[C('USER_AUTH_KEY')],
	 					'title'		=>	$this -> _post('title'),
	 					'keywords'	=>	$this -> _post('keywords'),
	 					'des'		=>	$this -> _post('des'),
	 					'content'	=>	$this -> _post('content',false),
	 					'template_file'	=>	$this -> _post('template_file'),
	 					'createtime'		=>	time()
	 					);
	 			if ( $Single -> add( $data ) ){
	 				ajaxReturn(200,'添加单页成功','single','Single/index');
	 			}else{
	 				ajaxReturn(300,'添加单页错误：'.$Single -> getDbError() );
	 			}
	 		}else{
	 			ajaxReturn(300,"警告,非法提交表单");
	 		}
		}else{
			$this	-> display();
		}
	}
	//编辑单页
	public function edit()
	{
		$Single		=	M('Single');
		if ( $_POST ) {
			if ( $Single -> autoCheckToken( $_POST ) ){
	 			$data		=	array(
	 					'id'		=>	$this -> _post('id'),
	 					'user'		=>	$_SESSION[C('USER_AUTH_KEY')],
	 					'title'		=>	$this -> _post('title'),
	 					'keywords'	=>	$this -> _post('keywords'),
	 					'des'		=>	$this -> _post('des'),
	 					'content'	=>	$this -> _post('content',false),
	 					'template_file'	=>	$this -> _post('template_file'),
	 					'createtime'		=>	time()
	 					);
	 			if ( $Single -> save( $data ) ){
	 				ajaxReturn(200,'编辑单页成功','single','Single/index');
	 			}else{
	 				ajaxReturn(300,'添加单页错误：'.$Single -> getDbError() );
	 			}
	 		}else{
	 			ajaxReturn(300,"警告,非法提交表单");
	 		}
		}else{
			$id		=	$this -> _get('art_id');
			if ( $id ) {
				$data['single_data']	=	$Single	->	find( $id );
				$this	->	assign( $data );
				$this	-> display();
			}else{
				ajaxReturn(300 , "请选择要编辑的单页");
			}
		}
	}
	/*
	 * 单页删除
	*/
	public function del()
	{
		$art_id		=	$this -> _get('art_id');
		if ( !empty( $art_id ) ){
			$Single		=	M('Single');
			if ( $Single -> delete( $art_id ) ){
				ajaxReturn( 200,'删除单页成功','','','' );
			}else{
				ajaxReturn( 300,"删除单页失败：".$Single -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的单页");
		}
	}
}