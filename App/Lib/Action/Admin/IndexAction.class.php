<?php
class IndexAction extends CommonAction
{
	// 框架首页
	public function index() {
		// 统计数据
		$info = array(
				'操作系统'				=>	PHP_OS,
				'运行环境'				=>	$_SERVER["SERVER_SOFTWARE"],
				'PHP运行方式'			=>	php_sapi_name(),
				'ThinkPHP版本'			=>	THINK_VERSION,
				'上传附件限制'			=>	ini_get('upload_max_filesize'),
				'执行时间限制'			=>	ini_get('max_execution_time').'秒',
				'服务器时间'				=>	date("Y年n月j日 H:i:s"),
				'北京时间'				=>	gmdate("Y年n月j日 H:i:s",time()+8*3600),
				'服务器域名/IP'			=>	$_SERVER['SERVER_NAME'].' [ '.$_SERVER['SERVER_ADDR'].' ]',
				'剩余空间'				=>	round((disk_free_space(".")/(1024*1024)),2).'M',
				'register_globals'		=>	get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
				'magic_quotes_gpc'		=>	(1===get_magic_quotes_gpc())?'YES':'NO',
				'magic_quotes_runtime'	=>	(1===get_magic_quotes_runtime())?'YES':'NO',
		);
		$this->assign('info',$info);
		$this->display();
	}
	// 首页
	public function main() {
		// 统计数据
		$info = array(
				'操作系统'				=>	PHP_OS,
				'运行环境'				=>	$_SERVER["SERVER_SOFTWARE"],
				'PHP运行方式'			=>	php_sapi_name(),
				'ThinkPHP版本'			=>	THINK_VERSION,
				'上传附件限制'			=>	ini_get('upload_max_filesize'),
				'执行时间限制'			=>	ini_get('max_execution_time').'秒',
				'服务器时间'				=>	date("Y年n月j日 H:i:s"),
				'北京时间'				=>	gmdate("Y年n月j日 H:i:s",time()+8*3600),
				'服务器域名/IP'			=>	$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
				'剩余空间'				=>	round((disk_free_space(".")/(1024*1024)),2).'M',
				'register_globals'		=>	get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
				'magic_quotes_gpc'		=>	(1===get_magic_quotes_gpc())?'YES':'NO',
				'magic_quotes_runtime'	=>	(1===get_magic_quotes_runtime())?'YES':'NO',
		);
		$this->assign('info',$info);
		$this->display();
	}
	//修改密码
	public function changepwd()
	{
		if ( !empty( $_POST ) )
		{
			 //对表单提交处理进行处理或者增加非表单数据
			if(md5($_POST['verify'])	!= session('verify') ) {
				$data		=	array('statusCode'	=>	300,'message'	=>	'验证码错误');
				ajaxReturn(300,'验证码错误');
			}
			$map	=	array();
	        $map['password']= md5( $_POST['oldPassword'] );
	        if( isset( $_POST['account'] ) ) {
	            $map['account']		=	$_POST['account'];
	        }elseif( session( '?'.C('USER_AUTH_KEY') ) ) {
	            $map['id']			=	session( C('USER_AUTH_KEY') );
	        }
	        //检查用户
	        $User    =   M("User");
	        if( ! $User -> where($map) -> field('id') -> find() ) {
	        	ajaxReturn(300,'旧密码不符或者用户名错误');
	        }else {
				$User	->	password	=	md5( $_POST['newPassword'] );
				$User	->	id			=	session( C('USER_AUTH_KEY') );
				$User	->	save();
				session( C('USER_AUTH_KEY') , null );
				session( 'admindata' , null );
				$data		=	array('statusCode'	=>	201,'message'	=>	'修改密码成功,重新登录','callbackType'	=>	'closeCurrent' );
				ajaxReturn(201,'修改密码成功,重新登录');
	         }
		}else{
			$this -> display();
		}
	}
}