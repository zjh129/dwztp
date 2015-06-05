<?php
class MenuModel extends CommonModel{
	var $temp = array();
	protected $_validate	=	array(
			array('title','require','请输入菜单标题',0),
			array('isoutsite',array(0,1),'站外链应为有效数值',0,'in'),
			array('trueurl','require','请输入链接地址',0),
			array('sort','number','排序值应该为数字',0,'regex'),
			array('disp',array(0,1),'请选择有效的状态值',0,'in'),
			array('pid','require','没有选择父节点ID'),
			array('pid','number','父节点值应为数字',0,'regex')
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