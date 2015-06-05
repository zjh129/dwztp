<?php
class CommonAction extends Action
{
	//自动验证
	function _initialize() {
		//后台密钥登陆，否则隐藏地址
		$key	=	$_GET['loginkey']?$_GET['loginkey']:cookie('loginkey');
		if ( $key != 'myloginkey' ){
			Load('extend');
			send_http_status(404);
			exit;
		}else{
			cookie('loginkey' , $key);
		}
		//判断是否已登录，若未登录提示未登录返回登录界面
		if ( !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE'))) && ! session('?'.C('USER_AUTH_KEY')) ) {
			//跳转到认证网关
			$this->error('您已经退出，请重新登录！', U( C('USER_AUTH_GATEWAY') ));
		}
		import('ORG.Util.RBAC');
		// 用户权限检查
        if ( C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
        	if (!RBAC::AccessDecision(GROUP_NAME)) {
                //检查认证识别号
                if ( ! session('?'.C('USER_AUTH_KEY')) ) {
                    //跳转到认证网关
                    redirect( U( C('USER_AUTH_GATEWAY') ) );
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect( C('RBAC_ERROR_PAGE') );
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', U( C('USER_AUTH_GATEWAY')  ) );
                    }
                    // 提示错误信息
                    ajaxReturn( 300,  L('_VALID_ACCESS_') );
                }
            }
        }
	}
	public function _empty()
	{
		ajaxReturn(300, "页面不存在");
	}
}