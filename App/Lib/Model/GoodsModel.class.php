<?php
class GoodsModel extends CommonModel
{
    /*
     * 查询指定条件数据
     */
   public function getarray( $where = array() )
    {
    	return $this -> where( $where ) -> select();
    }
}