<?php
class NodeModel extends CommonModel
{
	var $temp = array();
	protected $_validate	=	array(
			array('name','require','请输入节点标识',0),
			array('name','checkNode','节点已经存在',0,'callback'),
			array('status',array(0,1),'请选择有效的状态值',0,'in'),
			array('sort','number','排序值应该为数字',0,'regex'),
			array('pid','require','没有选择父节点ID'),
			array('pid','number','父节点值应为数字',0,'regex')
	);
	/*
	 * 获取级别值
	*/
	public function getlevel( $pid )
	{
		$map['id']	=	array('eq' , $pid );
		$data	=	$this -> field('level')	-> where($map) -> find();
		return $data['level']+1;
	}
	public function checkNode() {
		if(is_string($_POST['name'])) {
			$map['name']	=	$_POST['name'];
			$map['pid']		=	isset($_POST['pid'])?$_POST['pid']:0;
			$map['status']	=	1;
			if(!empty($_POST['id'])) {
				$map['id']	=	array('neq',$_POST['id']);
			}
			$result	=	$this->where($map)->field('id')->find();
			if($result) {
				return false;
			}else{
				return true;
			}
		}
		return true;
	}
	public function checkNodeOnly( $where ){
		$result	=	$this -> where( $where ) -> field('id') -> find();
		if ( $result ) {
			return false;
		}else{
			return true;
		}
	}
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