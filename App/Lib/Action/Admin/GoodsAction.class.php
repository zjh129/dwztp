<?php

/*
 * 商品管理控制器
 * 
 */

class GoodsAction extends CommonAction {
	/*
	 * /商品列表显示
	 */
    public function index() {

        $Goodstype = M('Goods');
        $data['numPerPage'] = (int) $this->_post('numPerPage', "", 20); //每页显示多少条
        $data['currentPage'] = (int) $this->_post('pageNum', "", 1); //当前页
        $data['valcat_id']	=	$this -> _post('cat_id');
        $data['keywords'] = $this->_post('keywords'); //查询关键字
        //分类调用
        $cat_data = category_data_pocess();
        $data['cat_select']		=	category_select($cat_data, 'cat_id', $data['valcat_id'] , '&nbsp&nbsp&nbsp&nbsp');
        
        $map = array();
        $map['is_delete'] = array('eq', '0'); //删除的数据不取出来

        if (!empty($data['keywords'])) {
            $map['goods_name'] = array('like', '%' . $data['keywords'] . '%');
        }
        if ( !empty( $data['valcat_id'] ) ){
        	//获取该分类子类ID数组
        	$child_catid		=	get_cur_category_child_ids( $data['valcat_id'] , $cat_data );
        	array_push( $child_catid , $data['valcat_id'] );//将本分类ID添加到分类数组中
        	$map['cat_id']		=	array('IN', $child_catid );
        }

        $data['totalCount'] = $Goodstype->where($map)->count();
        $data['list'] = $Goodstype->where($map)->order('create_time DESC')->page(($data['currentPage']) . ',' . $data['numPerPage'])->select();
        $this->assign($data);

        $this->display();
    }
    /*
     * 商品添加
     */
    public function add()
    {
    	$Goods		=	D('Goods');
    	if ( $_POST ){
    		if ( $Goods -> autoCheckToken( $_POST ) ){
    			$data['goods_name']			=	$this -> _post('goods_name');
    			$data['short_desc']			=	$this -> _post('short_desc');
    			$data['cat_id']				=	$this -> _post('category_id');
    			$data['weight']				=	$this -> _post('weight');
    			$data['goods_sn']			=	'sn-' . mt_rand(1, 1000) . '-' . date("YmdHis");
    			$data['goods_type']			=	$this -> _post('goods_type');
    			$data['market_price']		=	$this -> _post('market_price');
    			$data['shop_price']			=	$this -> _post('shop_price');
    			$data['goods_nums']			=	$this -> _post('goods_nums');
    			$data['keywords']			=	$this -> _post('keywords');
    			$data['goods_brief']		=	$this -> _post('goods_brief');
    			$data['goods_thumb']		=	$this -> _post('goods_thumb');
    			$data['goods_desc']			=	$this -> _post('goods_desc',false);
    			$data['online_sale']		=	$this -> _post('online_sale');
    			$data['is_recommend']		=	$this -> _post('is_recommend');
    			$data['sale_num']			=	$this -> _post('sale_num');
    			$data['pop_num']			=	$this -> _post('pop_num');
    			$data['is_new']				=	$this -> _post('is_new');
    			$data['is_hot']				=	$this -> _post('is_hot');
    			$data['is_best']			=	$this -> _post('is_best');
    			$data['album']				=	$this -> _post('album');
    			$data['create_time']		=	time();
    			empty( $data['cat_id'] ) && ajaxReturn(300,"请选择商品所属分类");
    			empty( $data['goods_type'] ) && ajaxReturn(300,"请选择商品所属类型");
	    		if ( $Goods -> add( $data ) ){//添加成功
	    			$goods_id		=	$Goods -> getLastInsID();//获取最后插入的商品id
	    			$GoodsAttr		=	M('GoodsAttr');
	    			$attr_input		=	$_POST['attr'];
	    			$attrdata		=	array();
	    			foreach ( $attr_input as $k => $v ){
	    				array_push( $attrdata , 
		    				array(
			    				'goods_id' => $goods_id ,
			    				'attr_id' => $k , 
			    				'attr_value' => is_array( $v ) ? implode(',', $v ) : $v )
	    				 );
	    			}
	    			$GoodsAttr -> addAll( $attrdata );
	    			ajaxReturn(200,"商品添加成功",'goodindex','Goods/index');
	    		}else{//添加失败
	    			ajaxReturn(300,'添加商品错误：'.$Goods -> getDbError() );
	    		}
    		}else{
    			ajaxReturn(300,"警告,非法提交表单");
    		}
    	}else{
    		$cat_data = category_data_pocess();
    		$data['cat_select']		=	category_select($cat_data, 'category_id', 0, '&nbsp&nbsp&nbsp&nbsp');
    		$data['goodstype']		=	F('goodstype_data');
    		//权重值自动计算
    		$data['maxweight']	=	$Goods -> max('weight');
    		$this -> assign( $data );
    		$this -> display();
    	}
    }
    /*
     * 商品编辑
    */
    public function edit()
    {
    	$Goods		=	D('Goods');
    	if ( $_POST ){
    		if ( $Goods -> autoCheckToken( $_POST ) ){
    			$goods_id					=	(int)$this -> _post('goods_id');
    			$data['goods_name']			=	$this -> _post('goods_name');
    			$data['short_desc']			=	$this -> _post('short_desc');
    			$data['cat_id']				=	$this -> _post('category_id');
    			$data['weight']				=	$this -> _post('weight');
    			$data['goods_type']			=	$this -> _post('goods_type');
    			$data['market_price']		=	$this -> _post('market_price');
    			$data['shop_price']			=	$this -> _post('shop_price');
    			$data['goods_nums']			=	$this -> _post('goods_nums');
    			$data['keywords']			=	$this -> _post('keywords');
    			$data['goods_brief']		=	$this -> _post('goods_brief');
    			$data['goods_thumb']		=	$this -> _post('goods_thumb');
    			$data['goods_desc']			=	$this -> _post('goods_desc',false);
    			$data['online_sale']		=	$this -> _post('online_sale');
    			$data['is_recommend']		=	$this -> _post('is_recommend');
    			$data['sale_num']			=	$this -> _post('sale_num');
    			$data['pop_num']			=	$this -> _post('pop_num');
    			$data['is_new']				=	$this -> _post('is_new');
    			$data['is_hot']				=	$this -> _post('is_hot');
    			$data['is_best']			=	$this -> _post('is_best');
    			$data['album']				=	$this -> _post('album');
    			$data['last_update']		=	time();
    			empty( $data['cat_id'] ) && ajaxReturn(300,"请选择商品所属分类");
    			empty( $data['goods_type'] ) && ajaxReturn(300,"请选择商品所属类型");
    			if ( $Goods -> where("goods_id =$goods_id") -> save( $data ) ){//添加成功
    				//处理商品类型属性值
    				$GoodsAttr		=	M('GoodsAttr');
    				$GoodsAttr		->	delete( array('goods_id' => array('eq',$goods_id ) ) );
    				$attr_input		=	$_POST['attr'];
    				$attrdata		=	array();
    				foreach ( $attr_input as $k => $v ){
    					array_push( $attrdata ,
    					array(
    					'goods_id' => $goods_id ,
    					'attr_id' => $k ,
    					'attr_value' => is_array( $v ) ? implode(',', $v ) : $v )
    					);
    				}
    				$GoodsAttr -> addAll( $attrdata );
    				
    				ajaxReturn(200,"商品编辑成功",'goodindex','Goods/index');
    			}else{//添加失败
    				ajaxReturn(300,'编辑商品错误：'.$Goods -> getDbError() );
    			}
    		}else{
    			ajaxReturn(300,"警告,非法提交表单");
    		}
    	}else{
    		$goods_id				=	$this -> _get('goods_id');
    		if ( !empty( $goods_id ) ){
    			$Attach					=	M('Attach');
    			$data['data']			=	$Goods -> find( $goods_id );
	    		$cat_data = category_data_pocess();
	    		$data['cat_select']		=	category_select($cat_data, 'category_id', $data['data']['cat_id'], '&nbsp&nbsp&nbsp&nbsp');
	    		$data['goodstype']		=	F('goodstype_data');
	    		!empty( $data['data']['goods_thumb'] ) && $data['thumbdata'] = $Attach -> find( $data['data']['goods_thumb'] );
	    		!empty( $data['data']['album'] ) && $data['ablumdata']	= $Attach -> where( array('id' => array('in' , $data['data']['album'] ) ) ) -> select();
	    		//var_dump($data['ablumdata']);
	    		$this -> assign( $data );
	    		$this -> display();
    		}else{
    			ajaxReturn(300,"请选择要编辑的商品");
    		}
    	}
    }
    /*
     * +----------------------------------------------
     * 删除商品,不是真实意义上的删除。做软删除
     * +----------------------------------------------
     * @param gid 商品编号
     * +----------------------------------------------
     */

    public function Del() {
        //验证参数合法性
        $goods_id = $_REQUEST['goods_id'];
        if (!$goods_id)
            exit('非法参数');

        //做软删除，标识is_delete为1。
        // $sql = "UPDATE ".C('DB_PREFIX')."goods SET is_delete=1 WHERE goods_id=" . $goods_id;
        $update_item = array(
            "is_delete" => 1
        );
        if (M("Goods")->where(" goods_id=" . $goods_id)->save($update_item)){
        	$GoodsAttr		=	M('GoodsAttr');
        	$GoodsAttr		->	delete( array('goods_id' => array('eq',$goods_id ) ) );
        	ajaxReturn(200, "删除商品成功", "goodlistrel", "Goods/index");
        }else{
            ajaxReturn(300, "删除商品失败:" . M()->getDbError());
        }
    }
    /*
     * 显示商品模型列表
     */
    public function ArributeList() {
    	$goods_id		=	$this -> _post('goods_id');
    	$goods_type		=	$this -> _post('goods_type');
    	$goodstype_data	=	F('goodstype_data');
    	$content		=	'';
    	if ( empty( $goods_id ) ){//新增商品时属性列表
    		if ( !empty( $goodstype_data[ $goods_type ]['attrlist'] ) ){
	    		foreach ( $goodstype_data[ $goods_type ]['attrlist'] as $k => $v ){
	    			$content	.=	'<dl>
	                <dt>'.$v['attr_name'].'：</dt>
	                <dd>'.attr_to_form( $name="attr" ,  $v , $value = '' , $class='class="required"' ).'
	                <span class="info"></span>
	                </dd>
	              </dl>';
	    		}
    		}else{
    			$content		=	'该模型还未添加属性【<a style="color:red;" onclick=\'javascript:navTab.openTab("attribute", "'.U('Attribute/index',array('type_id' => $goods_type )).'", { title:"属性列表", fresh:true });\' href="javascript:void(0);">添加属性</a>】';
    		}
    	}else{//编辑商品是属性列表
    		$GoodsAttr		=	D('GoodsAttr');
    		$goodsattrlist	=	$GoodsAttr -> getarr_attrid_to_value( $goods_id );
    		if ( !empty( $goodstype_data[ $goods_type ]['attrlist'] ) ){
    			foreach ( $goodstype_data[ $goods_type ]['attrlist'] as $k => $v ){
    				$content	.=	'<dl>
	                <dt>'.$v['attr_name'].'：</dt>
	                <dd>'.attr_to_form( $name="attr" ,  $v , $goodsattrlist[ $v['attr_id'] ] , $class='class="required"' ).'
	                <span class="info"></span>
	                </dd>
	              </dl>';
    			}
    		}else{
    			$content		=	'该模型还未添加属性【<a style="color:red;" onclick=\'javascript:navTab.openTab("attribute", "'.U('Attribute/index',array('type_id' => $goods_type )).'", { title:"属性列表", fresh:true });\' href="javascript:void(0);">添加属性</a>】';
    		}
    	}
    	exit( $content );
    }
}

?>
