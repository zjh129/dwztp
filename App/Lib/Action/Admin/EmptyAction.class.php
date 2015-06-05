<?php
class EmptyAction extends Action
{
	public function _empty( $method )
	{
		$this -> assign('waitSecond' , 3 );
		$this -> assign('msgTitle' , '404错误');
		$this -> assign('message' , '您访问的页面不存在');
		$this -> assign('jumpUrl' , U('Index/index') );
		$this -> display( C('TMPL_ACTION_ERROR') );	
	}
}