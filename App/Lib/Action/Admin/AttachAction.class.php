<?php
class AttachAction extends CommonAction
{
	/*
	 * 附件管理首页
	 */
	public function index()
	{
		$Attach			=	D('AttachView');
		$data['numPerPage']	=	(int)$this -> _post('numPerPage',"",20);//每页显示多少条
		$data['currentPage']=	(int)$this -> _post('pageNum',"",1);//当前页
		$data['extension']	=	$this -> _post('extension');
		$data['source']		=	$this -> _post('source');
		$data['subtime']	=	$this -> _post('subtime');
		$map	=	array();
		if ( !empty( $data['extension'] ) ){
			$map['extension']		=	array('eq',$data['extension']);
		}
		if ( !empty( $data['source'] ) ){
			$map['source']		=	array('eq',$data['source']);
		}
		if ( !empty( $data['subtime'] ) ){
			$startsubtime		=	strtotime( $data['subtime'] );
			$endsubtime			=	strtotime("+1 day" , $startsubtime );
			$map['_string']		=	"createtime >= $startsubtime AND createtime < $endsubtime";
		}
		//echo date("Y-m-d H:i:s" , $startsubtime )."|||".date("Y-m-d H:i:s" , $endsubtime );
		$data['totalCount']	=	$Attach -> where( $map ) -> count();
		$data['list']		=	$Attach -> field('id,account,type,name,size,extension,savepath,savename,createtime') -> where( $map ) -> page(($data['currentPage']).','.$data['numPerPage'] ) -> order('createtime desc') -> select();
		$data['conext']		=	$Attach -> Distinct(true) -> field('extension') -> select();
		$data['sourcetypelist']	=	C('ATTACH_SOURCE');
		$this -> assign( $data );
		$this -> display();
	}
	/*
	 * 图片上传方法，返回上传文件信息数组
	 */
	private function imgupload( $allowtype	= array() , $type = 'image' )
	{
		import("ORG.Net.UploadFile");
		$upload		=	new UploadFile();// 实例化上传类
		$upload -> maxSize		=	3145728*100 ;// 设置附件上传大小
		if ( $allowtype == "*" ){
			
		}elseif ( empty( $allowtype ) ){
			$upload -> allowExts	=	array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		}else{
			$upload	-> allowExts	=	$allowtype;
		}
		$upload -> savePath		=	'./Public/Uploads/'.$type.'/';// 设置附件上传目录
		$upload -> saveRule		=	'uniqid';
		$upload	-> thumb		=	true;
		$upload	-> thumbMaxWidth	=	"200";
		$upload	-> thumbMaxHeight	=	"200";
		if( ! $upload -> upload() ) {// 上传错误提示错误信息
			return $upload -> getErrorMsg();
		}else{// 上传成功 获取上传文件信息
			return $upload -> getUploadFileInfo();
		}
	}
	/*
	 * 上传图片私有方法，简化代码
	 */
	private function myuploadimg( $allowtype	= array() , $type = 'image' , $source	=	1 )
	{
		$msg	=	array();
		$uploadinfo		=	$this -> imgupload( $allowtype , $type );
		if ( is_array( $uploadinfo ) ){//上传成功，处理信息
			$attach		=	M('Attach');
			$attachdata	=	array(
					'adduser'	=>	$_SESSION[C('USER_AUTH_KEY')],
					'source'	=>	$source,
					'type'		=>	$uploadinfo[0]['type'],
					'size'		=>	$uploadinfo[0]['size'],
					'name'		=>	$uploadinfo[0]['name'],
					'extension'	=>	$uploadinfo[0]['extension'],
					'savepath'	=>	substr($uploadinfo[0]['savepath'], 1),
					'savename'	=>	$uploadinfo[0]['savename'],
					'thumbname'	=>	"thumb_".$uploadinfo[0]['savename'],
					'createtime'	=>	time()
			);
			$attach		->	add( $attachdata );
			$msg	=	array('success'=>true,'id' =>$attach -> getLastInsID(),'attachmentPath' => $attachdata['savepath'].$attachdata['thumbname'] );
		}else{
			$msg	=	array( 'error' => $uploadinfo );
		}
		exit( json_encode( $msg ) );
	}
	/*
	 * 文章模块图片上传
	 */
	public function artuploadimg()
	{
		$this	->	myuploadimg( array() , $type = 'image' , $source	=	1);
	}
	/*
	 * 文章模块附件上传
	 */
	public function artuploadattach()
	{
	    $this	->	myuploadimg( '*' , 'attach' , $source	=	9);
	}
	/*
	 * 会员照片编辑图片上传
	*/
	public function memberuploadimg()
	{
		$this	->	myuploadimg( array() , 'member/photo' , 7 );
	}
	/*
	 * 友情链接图片上传
	*/
	public function linkuploadimg()
	{
		$this	->	myuploadimg( array() , 'link' , 2 );
	}
	/*
	 * 附件下载
	 */
	public function download()
	{
		$attachid	=	$this -> _get('attach_id');
		if ( !empty( $attachid ) ) {
			$Attach		=	D('Attach');
			import("ORG.Net.Http");
			Load('extend');
			$attach_data	=	$Attach  ->	find( $attachid );
			if ( file_exists( '.'.$attach_data['savepath'].$attach_data['savename'] ) == TRUE ) {
				$showname = auto_charset( empty( $attach_data['name'] ) ? $attach_data['savename'] : $attach_data['name'] ,'utf-8','gbk');
				$Attach -> where('id='.$attachid) -> setInc('download_count',1);
				ob_start();
				Http::download('.'.$attach_data['savepath'].$attach_data['savename'], $showname );
				ob_end_clean();
			}else{
				if ( IS_AJAX ) {
					ajaxReturn(300,'下载文件不存在');
				}else{
					$this -> error("下载文件不存在");
				}
			}
		}else{
			if ( IS_AJAX ) {
				ajaxReturn(300,'请选择要下载的附件');
			}else{
				$this -> error("请选择要下载的附件");
			}
		}
	}
	/*
	 * 附件删除
	 */
	public function del()
	{
		$attachid	=	$this -> _get('attach_id');
		if ( !empty( $attachid ) ){
			$Attach		=	D('Attach');
			if ( $Attach -> deldata( $attachid ) ){
				ajaxReturn( 200 , "删除附件成功:",'','','');
			}else{
				ajaxReturn( 300 , "删除附件失败：".$Attach -> getDbError() );
			}
		}else{
			ajaxReturn(300,'请选择要删除的附件');
		}
	}
	
	/*
	 * 文件上传方法，返回上传文件信息数组
	*/
	private function fileupload( $allowtype	= array() , $type = 'file' , $source	=	3)
	{
		import("ORG.Net.UploadFile");
		$upload		=	new UploadFile();
		$upload		->	maxSize  = 3145728*100 ;// 设置附件上传大小
		if ( empty( $allowtype ) ){
			$upload -> allowExts  = array('zip','rar','txt','swf','avi');// 设置附件上传类型
		}else{
			$upload -> allowExts	=	$allowtype;
		}
		$upload -> savePath		=	'./Public/Uploads/'.$type.'/';// 设置附件上传目录
		$upload -> saveRule		=	'uniqid';
		if( ! $upload->upload() ) {// 上传错误提示错误信息
			return $upload->getErrorMsg();
		}else{// 上传成功 获取上传文件信息
			$uploadinfo	=	$upload->getUploadFileInfo();
			//将上传附件数据入库
			$attach		=	M('Attach');
			$attachdata	=	array(
					'adduser'	=>	$_SESSION[C('USER_AUTH_KEY')],
			        'source'    =>  $source,
					'type'		=>	$uploadinfo[0]['type'],
					'size'		=>	$uploadinfo[0]['size'],
					'name'		=>	$uploadinfo[0]['name'],
					'extension'	=>	$uploadinfo[0]['extension'],
					'savepath'	=>	substr($uploadinfo[0]['savepath'], 1),
					'savename'	=>	$uploadinfo[0]['savename'],
					'createtime'	=>	time()
			);
			$attach		->	add( $attachdata );
			//返回数据
			return $attachdata;
		}
	}
	/*
	 * 编辑器部分--超链接文件上传
	 */
	public function editor_linkupload()
	{
		$uploadinfo	=	$this -> fileupload( array('tar','zip','tgz','rar','ppt','pptx','doc','pdf','xls','xlsx') , 'link' , 3 );
		$msgdata	=	array();
		if ( is_array( $uploadinfo ) ) {//附件上传成功，插入数据			
			$msgdata	=	array('err' =>'','msg'=>__ROOT__.$uploadinfo['savepath'].$uploadinfo['savename']);
		}else{
			$msgdata	=	array('err' =>$uploadinfo,'msg'=>'');
		}
		exit( json_encode( $msgdata ) );
	}
	/*
	 * 编辑器部分--图片上传
	 */
	public function editor_imgupload()
	{
		$uploadinfo	=	$this -> fileupload( array('jpg','jpeg','gif','png') , 'img' , 4 );
		$msgdata	=	array();
		if ( is_array( $uploadinfo ) ) {//附件上传成功，插入数据
			$msgdata	=	array('err' =>'','msg'=>__ROOT__.$uploadinfo['savepath'].$uploadinfo['savename']);
		}else{
			$msgdata	=	array('err' =>$uploadinfo,'msg'=>'');
		}
		exit( json_encode( $msgdata ) );
	}
	/*
	 * 编辑器部分--动画文件上传
	 */
	public function editor_flashupload()
	{
		$uploadinfo	=	$this -> fileupload( array('swf') , 'flash' , 5 );
		$msgdata	=	array();
		if ( is_array( $uploadinfo ) ) {//附件上传成功，插入数据
			$msgdata	=	array('err' =>'','msg'=>__ROOT__.$uploadinfo['savepath'].$uploadinfo['savename']);
		}else{
			$msgdata	=	array('err' =>$uploadinfo,'msg'=>'');
		}
		exit( json_encode( $msgdata ) );
	}
	/*
	 * 编辑器部分--媒体文件上传
	 */
	public function editor_mediaupload()
	{
		$uploadinfo	=	$this -> fileupload( array('avi') , 'media' , 6 );
		$msgdata	=	array();
		if ( is_array( $uploadinfo ) ) {//附件上传成功，插入数据
			$msgdata	=	array('err' =>'','msg'=>__ROOT__.$uploadinfo['savepath'].$uploadinfo['savename']);
		}else{
			$msgdata	=	array('err' =>$uploadinfo,'msg'=>'');
		}
		exit( json_encode( $msgdata ) );
	}
}