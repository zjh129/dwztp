<?php
class IndexAction extends CommonAction
{
	public function index()
	{
		phpinfo();exit();
		echo "这是第一个首页";
		$this -> display();
	}
	public function kk()
	{
		$this -> redirect('/Index/Index' , array('id'=> 2) , 2 , '页面跳转中...');
	}
}