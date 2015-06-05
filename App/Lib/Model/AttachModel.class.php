<?php
class AttachModel extends CommonModel
{
	/*
	 * 删除
	 */
	public function del( $option )
	{
		if ( !empty( $option ) ){
			if ( is_array( $option ) ){//多文件删除
				foreach ( $option as $v ){
					$this -> deldata( $v );
				}
			}else{//单文件删除
				$this -> deldata( $option );
			}
		}
	}
	/*
	 * 删除数据
	 */
	public function deldata( $id ){
		$attachdata		=	$this -> find( $id );
		$savepath		=	'.'.$attachdata['savepath'];
		!empty( $attachdata['savename'] )&& @unlink( $savepath.$attachdata['savename'] );
		!empty( $attachdata['thumbname'] ) && @unlink( $savepath.$attachdata['thumbname'] );
		return $this -> delete( $id );
	}
}