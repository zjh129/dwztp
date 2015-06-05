<?php
class BookAction extends CommonAction{
	public function index(){
		$Book			=	D('BookView');
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['keywords']	=	$this -> _post('keywords');//查询关键字
		$map	=	array();
		if ( !empty( $data['keywords'] ) ){
			$map['title']		=	array('like','%'.$data['keywords'].'%');
		}
		$data['totalCount']	=	$Book -> where( $map ) -> count();
		$data['list']		=	$Book -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('createtime desc') -> select();
		
		$this -> assign( $data );
		$this	->	display();
	}
	public function edit()
	{
		$Book	=	M('Book');
		if ( $_POST ) {
			if ( $Book -> create() ) {
				if ( $Book -> save() ) {
					ajaxReturn(200,'回复留言成功','book','Book/index');
				}else{
					ajaxReturn(300,"回复留言失败:".$Book -> getDbError() );
				}
			}else{
				ajaxReturn(300,"信息错误：".$Book -> getError() );
			}
		}else{
			$id		=	$this -> _get('id');
			empty( $id ) && ajaxReturn(300,"请选择要回复的留言");
			$data	=	$Book -> field('id,title,tel,content,answer') -> find( $id );
			$this	-> assign('data' , $data );
			$this	-> display();
		}
	}
	/*
	 * 删除帐号
	 */	
	public function del()
	{
		$id			=	$this -> _get('id');
		empty( $id ) && ajaxReturn(300,"请选择要删除的会员");
		$Book			=	M( 'Book' );
 		if ( $Book -> delete( $id ) ){
 			ajaxReturn( 200,'删除留言成功','book','Book/index','' );
 		}else{
 			ajaxReturn(300,"删除留言失败：".$Book -> getDbError() );
 		}
	}
	/*
	 * 改变显示状态
	 */
	public function change_disp()
	{
		$data['id']	=	$this -> _get('id');
		empty( $data['id'] ) && ajaxReturn(300,"请选择留言");
		$data['disp']	=	$this -> _get('disp');
		$Book			=	M('Book');
		if ( $Book -> save( $data ) ) {
			ajaxReturn(200, $data['disp'] == 1 ? "显示留言成功" : "隐藏留言成功", "book", "Book/index", "forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
}