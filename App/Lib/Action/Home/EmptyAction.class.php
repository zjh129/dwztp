<?php
class EmptyAction extends Action
{
	public function _empty( $method )
	{
		$this -> assign(array(
				'waitSecond'	=>	2,
				'status'		=>	0,
				'msgTitle'		=>	'您访问的页面不存在',
				//'message'		=>	'您访问的页面不存在',
				'jumpUrl'		=>	U('Index/index')
		));
		$this -> display( C('TMPL_ACTION_ERROR') );
	}
}