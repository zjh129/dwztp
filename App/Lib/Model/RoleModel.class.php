<?php
class RoleModel extends CommonModel
{
	var $temp = array();
	//自动验证
	protected $_validate	=	array(
			
			);
	//自动完成
	protected $_auto	=	array(
			array('createtime','time',1,'function')
			);
	/*
	 * 获得子节点的所有ID数组
	*/
	public function getchilarr($id){
		array_push($this -> temp, $id);
		$data	=	$this -> field('id') -> where("pid = $id") -> select();
		if (count($data) >0 ){
			foreach ($data as $v){
				$this -> getchilarr($v['id']);
			}
		}
		return $this -> temp;
	}
}