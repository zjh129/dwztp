<?php
class PublicAction extends CommonAction
{
	public function index()
	{
		//如果通过认证跳转到首页
		redirect(__APP__);
	}
	// 用户登录页面
	public function login() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->display();
		}else{
			$this->redirect( 'Index/index' );
		}
	}
	//弹出登录对话框
	public function logindialog()
	{
		$this -> display();
	}
	// 用户登出
	public function logout()
	{
		$this->assign("jumpUrl", U('Public/login') );
		if( session("?".C('USER_AUTH_KEY') ) ) {
			session(C('USER_AUTH_KEY') , null );
			session( 'admindata' , null );
			$this->success('登出成功！');
		}else {
			$this->error('已经登出！');
		}
	}
	// 登录检测
	public function checkLogin() {
		$postdata	=	array(
				'account'	=>	$this -> _post('account'),
				'password'	=>	$this -> _post('password'),
				'verify'	=>	$this -> _post('verify')
		);
		if( empty( $postdata['account'] ) ) {
			$this	->	error('帐号必填！');
		}elseif ( empty( $postdata['password'] ) ){
			$this	->	error('密码必须！');
		}elseif ( empty( $postdata['verify'] ) ){
			$this	->	error('验证码必须！');
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['account']	=	$postdata['account'];
        $map["status"]	=	array('gt',0);
		if(session('verify') != md5( $postdata['verify'] )) {
			$this->error('验证码错误！');
		}
		import ( 'ORG.Util.RBAC' );
        $authInfo = RBAC::authenticate($map);
        
        //使用用户名、密码和状态的方式进行认证
        if(false === $authInfo) {
            $this->error('帐号不存在或已禁用！');
        }else {
        	//echo md5( $postdata['password'] )."<br>";
        	//echo $authInfo['password'];exit();
            if($authInfo['password'] != md5( $postdata['password'] )) {
            	$this->error('密码错误！');
            }
            session( C('USER_AUTH_KEY') , $authInfo['id'] );
            session( 'admindata' , $authInfo );
            if($authInfo['account']=='admin') {
            	session( C( 'ADMIN_AUTH_KEY' ) , true );
            }
            //保存登录信息
			$User	=	M('User');
			$ip		=	get_client_ip();
			$time	=	time();
            $data = array();
			$data['id']	=	$authInfo['id'];
			$data['last_login_time']	=	$time;
			$data['login_count']	=	array('exp','login_count+1');
			$data['last_login_ip']	=	$ip;
			$User->save($data);

			// 缓存访问权限[有问题]
            //RBAC::saveAccessList();
            //快速缓存用户权限
            F( 'ACCESS_LIST_'.session( C('USER_AUTH_KEY') ) , RBAC::getAccessList( session( C('USER_AUTH_KEY') ) ) );
            
			$this->success('登录成功！', U('Index/index') );
		}
	}
	//验证码显示
	public function verify()
	{
		import("ORG.Util.Image");
		Image::buildImageVerify(6);
	}
}