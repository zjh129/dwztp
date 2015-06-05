<?php
class ArticleAction extends CommonAction{
	/*
	 * 文章首页列表
	 */
	 public function index()
	 {
	 	$Article			=	D('ArticleView');
	 	$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
	 	$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
	 	$data['valartcat_id']	=	$this -> _post('artcat_id');
	 	$data['keywords']	=	$this -> _post('keywords');//查询关键字
	 	//分类调用
	 	$cat_data			=	category_data_pocess('r' , 'artcat_data' , 'ArtCategory');
	 	$data['cat_select']	=	category_select($cat_data, 'artcat_id', $data['valartcat_id'], '&nbsp&nbsp&nbsp&nbsp');
	 	
	 	$map	=	array();
	 	if ( !empty( $data['keywords'] ) ){
	 		$map['title']		=	array('like','%'.$data['keywords'].'%');
	 	}
	 	if ( !empty( $data['valartcat_id'] ) ){
	 		//获取该分类子类ID数组
	 		$child_catid		=	get_cur_category_child_ids( $data['valartcat_id'] , $cat_data );
	 		array_push( $child_catid , $data['valartcat_id'] );//将本分类ID添加到分类数组中
	 		$map['catid']		=	array('IN', $child_catid );
	 	}
	 	$data['totalCount']	=	$Article -> where( $map ) -> count();
	 	$data['list']		=	$Article -> field('id,title,subtime,cat_name,views,account') -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('createtime desc') -> select();
	 	
	 	
	 	
	 	$this -> assign( $data );
	 	$this -> display();
	 }
	 /*
	  * 文章添加
	  */
	 public function add()
	 {
	 	$article	=	M('Article');
	 	if ( $_POST ){
	 		if ( $article -> autoCheckToken( $_POST ) ){
	 			$attr		=	$this -> _post('attr') ? $this -> _post('attr') : array();
	 			$subtime	=	empty( $_POST['subtime'] ) ? time() :strtotime( $this -> _post('subtime') );
	 			$data		=	array(
	 					'user'		=>	$_SESSION[C('USER_AUTH_KEY')],
	 					'catid'		=>	$this -> _post('artcategory_id'),
	 					'title'		=>	$this -> _post('title'),
	 					'shottitle'	=>	$this -> _post('shottitle'),
	 					'attr'		=>	json_encode( $attr ),
	 					'weight'	=>	$this -> _post('weight'),
	 					'imgid'		=>	$this -> _post('imgid'),
	 					'attachid'	=>	$this -> _post('attachid'),
	 					'keywords'	=>	$this -> _post('keywords'),
	 					'des'		=>	$this -> _post('des'),
	 					'content'	=>	$this -> _post('content',false),
	 					'iscomment'	=>	$this -> _post('iscomment'),
	 					'views'		=>	$this -> _post('views'),
	 					'title_color'=>	$this -> _post('title_color'),
	 					'subtime'	=>	$subtime,
	 					'template_file'	=>	$this -> _post('template_file'),
	 					'createtime'		=>	time()
	 					);
	 			empty( $data['catid'] ) && ajaxReturn(300,"请选择文章所属分类");
	 			if ( $article -> add( $data ) ){
	 				ajaxReturn(200,'添加文章成功','article','Article/index');
	 			}else{
	 				ajaxReturn(300,'添加文章错误：'.$article -> getDbError() );
	 			}
	 		}else{
	 			ajaxReturn(300,"警告,非法提交表单");
	 		}
	 	}else{
	 		$cat_data			=	category_data_pocess('r' , 'artcat_data' , 'ArtCategory');
	 		$data['cat_select']	=	category_select($cat_data, 'artcategory_id', $this -> _get('artcat_id'), '&nbsp&nbsp&nbsp&nbsp');
	 		//权重值自动计算
	 		$data['maxweight']	=	$article -> max('weight');
	 		$data['randviews']	=	rand(1,200);
	 		
	 		$this -> assign( $data );
	 		$this -> display();
	 	}
	 }
	 /*
	  * 文章编辑
	  */
	 public function edit()
	 {
	 	if ( $_POST ){//表单提交
	 		$article	=	M('Article');
	 		if ( $article -> autoCheckToken( $_POST ) ){
	 			$attr		=	$this -> _post('attr') ? $this -> _post('attr') : array();
	 			$subtime	=	empty( $_POST['subtime'] ) ? time() :strtotime( $this -> _post('subtime') );
	 			$data		=	array(
	 					'id'		=>	$this -> _post('art_id'),
	 					'user'		=>	$_SESSION[C('USER_AUTH_KEY')],
	 					'catid'		=>	$this -> _post('artcategory_id'),
	 					'title'		=>	$this -> _post('title'),
	 					'shottitle'	=>	$this -> _post('shottitle'),
	 					'attr'		=>	json_encode( $attr ),
	 					'weight'	=>	$this -> _post('weight'),
	 					'imgid'		=>	$this -> _post('imgid'),
	 					'attachid'	=>	$this -> _post('attachid'),
	 					'keywords'	=>	$this -> _post('keywords'),
	 					'des'		=>	$this -> _post('des'),
	 					'content'	=>	$this -> _post('content',false),
	 					'iscomment'	=>	$this -> _post('iscomment'),
	 					'views'		=>	$this -> _post('views'),
	 					'title_color'=>	$this -> _post('title_color'),
	 					'subtime'	=>	$subtime,
	 					'template_file'	=>	$this -> _post('template_file')
	 			);
	 			empty( $data['catid'] ) && ajaxReturn(300,"请选择文章所属分类");
	 			if ( $article -> save( $data ) ){
	 				ajaxReturn(200,'编辑文章成功','article','Article/index');
	 			}else{
	 				ajaxReturn(300,'编辑文章错误：'.$article -> getDbError() );
	 			}
	 		}else{
	 			ajaxReturn(300,"警告,非法提交表单");
	 		}
	 	}else{//数据显示
	 		$art_id		=	$this -> _get('art_id');
	 		if ( $art_id ){		 				 		
		 		$Article			=	D('ArticleView');
		 		$data['artdata']	=	$Article -> find( $art_id );
		 		
		 		$cat_data			=	category_data_pocess('r' , 'artcat_data' , 'ArtCategory');
		 		$data['cat_select']	=	category_select($cat_data, 'artcategory_id', $data['artdata']['catid'], '&nbsp&nbsp&nbsp&nbsp');
		 		
		 		$this -> assign( $data );
		 		$this -> display();
	 		}else{
	 			ajaxReturn(300,"那个选择要编辑的文章");
	 		}
	 	}
	 }
	 /*
	  * 文章删除
	  */
	 public function del()
	 {
	 	$art_id		=	$this -> _get('art_id');
	 	if ( !empty( $art_id ) ){
	 		$Article		=	M('Article');
	 		$Attach			=	D('Attach');
	 		$artdata		=	$Article -> find( $art_id );
	 		if ( $Article -> delete( $art_id ) ){
	 			$Attach		->	del( $artdata['attachid'] );
	 			ajaxReturn( 200,'删除文章成功','','','' );
	 		}else{
	 			ajaxReturn(300,"删除文章失败：".$Article -> getDbError() );
	 		}
	 	}else{
	 		ajaxReturn(300,"请选择要删除的文章");
	 	}
	 }
}