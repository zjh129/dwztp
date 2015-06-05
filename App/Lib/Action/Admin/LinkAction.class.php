<?php
class LinkAction extends CommonAction
{
	/*
	 * 友情链接列表
	 */
	public function index()
	{
		$data['link_type']	=	C('LINK_TYPE');
		$Link				=	M('Link');
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['type']		=	$this -> _post('type',"",0);
		$data['keywords']	=	$this -> _post('keywords');//查询关键字
		
		$map	=	array();
		if ( !empty( $data['keywords'] ) ){
			$map['title']		=	array('like','%'.$data['keywords'].'%');
		}
		if ( !empty( $data['type'] ) ){
			$map['type']		=	array('EQ', $data['type'] );
		}
		$data['totalCount']	=	$Link -> where( $map ) -> count();
		$data['list']		=	$Link -> field('id,title,url,type,sort,status,create_time') -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('sort asc,create_time desc') -> select();
		$this	->	assign( $data );
		$this	->	display();
	}
	/*
	 * 添加友情链接
	 */
	public function add()
	{
		if ( $_POST ) {
			$Link		=	D('Link');
			if ( $Link -> create() ) {
				if ( $Link -> add() ) {
					ajaxReturn(200 , "添加友情链接成功",'link','Link/index');
				}else{
					ajaxReturn(300,'添加友情链接失败:'.$Link -> getDbError() );
				}
			}else {
				ajaxReturn(300,"错误：".$Link -> getError() );
			}
		}else{
			$data['link_type']	=	C('LINK_TYPE');
			$this				->	assign( $data );
			$this -> display();
		}
	}
	/*
	 * 编辑友情链接信息
	 */
	public function edit()
	{
		if ( $_POST ) {
			$Link		=	D('Link');
			if ( $Link -> create() ) {
				if ( $Link -> save() ) {
					ajaxReturn(200 , "修改友情链接成功",'link' , 'Link/index');
				}else{
					ajaxReturn(300,"修改友情链接失败:".$Link ->getDbError() );
				}
			}else{
				ajaxReturn(300,"错误：".$Link -> getError() );
			}
		}else{
			$linkid				=	$this -> _get('linkid');
			empty( $linkid ) && ajaxReturn(300,"请选择要编辑的友情链接");
			$data['link_type']	=	C('LINK_TYPE');
			$Link				=	D( 'LinkView' );
			$data['linkdata']	=	$Link -> find( $linkid );
			empty( $data['linkdata'] ) && ajaxReturn(300 , "友情链接信息不存在");
			$this	->	assign( $data );
			$this	->	display();
		}
	}
	/*
	 * 删除友情链接
	 */
	public function del()
	{
		$linkid		=	$this -> _get('linkid');
		if ( !empty( $linkid ) ){
			$Link			=	M('Link');
			$Attach			=	D('Attach');
			$linkdata		=	$Link -> find( $linkid );
			if ( $Link -> delete( $linkid ) ){
				$Attach		->	del( $linkdata['logo'] );
				ajaxReturn( 200,'删除友情链接成功','','','' );
			}else{
				ajaxReturn(300,"删除友情链接失败：".$Link -> getDbError() );
			}
		}else{
			ajaxReturn(300,"请选择要删除的友情链接");
		}
	}
	/*
	 * 更改友情链接开启状态
	 */
	public function change_status()
	{
		$udata['id']	=	$this -> _get('link_id');
		empty( $udata['id'] ) && ajaxReturn(300,"请选择友情链接");
		$udata['status']	=	$this -> _get('status');
		$Link			=	M('Link');
		if ( $Link -> save( $udata ) ) {
			ajaxReturn(200, $udata['status'] == 1 ? "启用友情链接成功,请更新缓存" : "禁用友情链接成功", "link", "Link/index", "forward");
		}else{
			ajaxReturn(300,"操作失败");
		}
	}
	/*
	 * 更新友情链接缓存
	 */
	public function create_cache(){
		$linktype		=	C('LINK_TYPE');
		$temp			=	array();//保存分组排序后的友情链接数组
		$Link			=	D('LinkView');
		foreach ( $linktype as $k => $v ){
			$map		=	array(
					'type'		=>	array('EQ', $k ),
					'status'	=>	array('EQ' , 1)
			);
			$temp[ $k ]		=	$Link -> field('id,title,url,logo,savepath,savename,thumbname,type,sort,status,create_time')
			-> where( $map )
			-> order('sort asc,create_time desc') -> select();
		}
		F('link_data',$temp );
		ajaxReturn(200,'更新缓存成功','link','Link/index','forward');
	}
}