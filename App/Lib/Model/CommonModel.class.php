<?php
class CommonModel extends Model
{
	/*
	 * 对字段值置顶
	 */
	public function MoveUpDown( $move, $id , $id_col = 'id' , $oc_col = 'OrderColumn' , $where = array() )
	{
		if( ! in_array( $move , array('up','down','top','bottom') ) ){
			return false;
		}
		$back	=	array('success'=>0,'msg'=>'');
		$this -> startTrans();
		//当前移动数据
		$cut_id_data		=	$this -> field( "$id_col,$oc_col"  ) -> find( $id );
		//获取最小N_Order值 记录的数据
		$min_id_data		=	$this -> field( "$id_col,$oc_col"  ) -> where( $where ) -> order($oc_col.' ASC') -> find();
		//获取最大N_Order值 记录的数据
		$max_id_data		=	$this -> field( "$id_col,$oc_col"  ) -> where( $where ) -> order($oc_col.' DESC') -> find();
		if ( $move == 'up' ) {
			$min_id_data[ $oc_col ] == $cut_id_data[ $oc_col ] && $back['msg']	=	'记录已到顶！';
			//获取上一条记录数据
			$pre_occol_data	=	$this -> field( "$id_col,$oc_col"  ) -> where( array_merge( $where , array($oc_col => array('LT',$cut_id_data[ $oc_col ] ) ) ) ) -> order( $oc_col.' DESC' ) -> find();
			//将上移记录的N_Order设置成上一条记录的N_Order
			$save1	=	$this -> save( array($id_col => $id , $oc_col => $pre_occol_data[ $oc_col ]) );
			//将上一条记录的N_Order设置成要上移记录的N_Order
			$save2	=	$this -> save( array($id_col => $pre_occol_data[ $id_col ] , $oc_col => $cut_id_data[ $oc_col ]) );
			if ( empty( $back['msg'] ) && is_int( $save1 ) && is_int( $save2 ) ) {
				$back	=	array( 'success' => 1 , 'msg'=>"上移成功" );
			}
		}elseif ( $move == 'down' ){
			$max_id_data[ $oc_col ] == $cut_id_data[ $oc_col ] && $back['msg']	=	'记录已到底！';
			//获取下一条记录数据
			$next_occol_data	=	$this -> field( "$id_col,$oc_col"  ) -> where( array_merge( $where , array($oc_col => array('GT',$cut_id_data[ $oc_col ] ) ) ) ) -> order( $oc_col.' ASC' ) -> find();
			//将下移记录的N_Order设置成下一条记录的N_Order
			$save1	=	$this -> save( array( $id_col => $id , $oc_col => $next_occol_data[ $oc_col ] ) );
			//将下一条记录的N_Order设置成要下移记录的N_Order
			$save2	=	$this -> save( array( $id_col => $next_occol_data[ $id_col ] , $oc_col => $cut_id_data[ $oc_col ] ) );
			if ( empty( $back['msg'] ) && is_int( $save1 ) && is_int( $save2 ) ) {
				$back	=	array( 'success' => 1 , 'msg'=>"下移成功" );
			}
		}elseif ( $move == 'top' ){
			$min_id_data[ $oc_col ] == $cut_id_data[ $oc_col ] && $back['msg']	=	'记录已到顶！';
			//将原最小N_Order值 记录的N_Order+1
			$save1	=	$this -> save( array($id_col => $min_id_data[ $id_col ] , $oc_col => $min_id_data[ $oc_col ] + 1 ) );
			//将要置顶的记录的N_Order值设置成最小N_Order值
			$save2	=	$this -> save( array( $id_col => $id , $oc_col => $min_id_data[ $oc_col ] ) );
			//除置顶和原最顶记录外，其他记录的N_Order值+1
			$save3	=	$this -> where( array_merge( $where , array($id_col => array('NOT IN', array($id , $min_id_data[ $id_col ] )  ) ) ) ) -> setInc($oc_col);
			if ( empty( $back['msg'] ) && is_int( $save1 )  && is_int( $save2 )&& is_int( $save3 ) ) {
				$back	=	array( 'success' => 1 , 'msg'=>"顶置成功" );
			}
			//var_dump( $back,$min_id_data,$cut_id_data , $save1 , $save2 , $save3 );
		}elseif ( $move == 'bottom' ){
			$max_id_data[ $oc_col ] == $cut_id_data[ $oc_col ] && $back['msg']	=	'记录已到底！';
			//将原最大N_Order值 记录的N_Order-1
			$save1	=	$this -> save( array($id_col => $max_id_data[ $id_col ] , $oc_col => $max_id_data[ $oc_col ] - 1 ) );
			//将要置末的记录的N_Order值设置成最大N_Order值 
			$save2	=	$this -> save( array( $id_col => $id , $oc_col => $max_id_data[ $oc_col ] ) );
			//除置末和原最末记录外，其他记录的N_Order值-1
			$save3	=	$this -> where( array_merge( $where , array($id_col => array('NOT IN', array($id , $max_id_data[ $id_col ] )  ) ) ) ) -> setDec($oc_col);
			if ( empty( $back['msg'] ) && is_int( $save1 )&& is_int( $save2 ) && is_int( $save3 ) ) {
				$back	=	array( 'success' => 1 , 'msg'=>"置末成功" );
			}
		}
		if ( $back['success'] == 1 ) {
			$this -> commit();
		}else{
			$this -> rollback();
		}
		return $back;
	}
}