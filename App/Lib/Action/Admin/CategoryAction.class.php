<?php
/*
 * 商品分类控制器
 * 
 */
class CategoryAction extends CommonAction {
    
    /*
     * +-------------------------------------------------
     * //
     * //商品分类列表
     * +-------------------------------------------------
     */
    public function index() {
    	$cat_data = $goods_data = $page_data = array();
    	
    	$Category = M("Category");
    	$cat_data =	$Category -> field( array('cat_id','cat_name','sort','parent_id','is_show') ) -> order('sort asc,cat_id asc') -> select() ;
    	
    	load('extend');
		$cat_data = list_to_tree($cat_data, 'cat_id', 'parent_id');
		$page_data['cat_data'] = table_category_tree_data($cat_data, 0);
		
	    if(!empty($cat_data)){
	    	unset($cat_data);
	    	$Goods = M('Goods');
	    	$sql = "SELECT `cat_id`, COUNT(`cat_id`) AS goods_num FROM __TABLE__ WHERE `cat_id`!='0' GROUP BY `cat_id`";
	    	$tmp_goods_data = $Goods->query($sql);
	    	
	    	if(!empty($tmp_goods_data)){
	    		foreach($tmp_goods_data as $goods){
	    			$goods_data[$goods['cat_id']] = $goods;
	    		}
	    	}
	    	unset($tmp_goods_data);
	    	$page_data['goods_data'] = $goods_data;
	    	unset($goods_data);
	    }
	    
    	$this->assign($page_data);
        $this->display();
    }
     /*
     * +-------------------------------------------------
     * //
     * //添加商品分类
     * +-------------------------------------------------
     */
    public function add() {
    	
    	if(!isset($_POST['submit_chk'])){
    		$Category = M("Category");
    		//显示添加商品分类页面
    	    $cat_data = $page_data = array();
    	    
    	    $cat_data = category_data_pocess(); //使用缓存的商品分类数据
			$page_data['cat_select'] = category_select($cat_data, 'category_id', 0, '&nbsp&nbsp&nbsp&nbsp');
			$page_data['max_sort']		=	$Category	->	max('sort') + 1;
			$this->assign($page_data);
	        $this->display();
    	} else {
    		//提交商品分类数据
    		$ins_data = $cat_data = array();
    		
    		$cat_name = isset($_POST['cat_name']) && !empty($_POST['cat_name']) ? trim($_POST['cat_name']) : '';
    		$parent_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : FALSE;
			$template_file = isset($_POST['template_file']) && !empty($_POST['template_file']) ? trim($_POST['template_file']) : '';
    		$keywords = isset($_POST['keywords']) && !empty($_POST['keywords']) ? trim($_POST['keywords']) : '';
    		$cat_desc = isset($_POST['cat_desc']) && !empty($_POST['cat_desc']) ? trim($_POST['cat_desc']) : '';
    		$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : 0;
    		$is_show = isset($_POST['is_show']) ? (int)$_POST['is_show'] : 0;
			
    		if(empty($cat_name)){
    			ajaxReturn(300, '商品分类名称不能为空！');
    		}
    		
    		if($parent_id === FALSE){
    			ajaxReturn(300, '请选择商品分类的上层分类！');
    		}
    		
    		$Category = M("Category");
    		
    		$ins_data = array(
    							'cat_name' => $cat_name,
    							'parent_id' => $parent_id,
    							'template_file' => $template_file,
    							'keywords' => $keywords,
    							'cat_desc' => $cat_desc,
    							'sort' => $sort,
    							'is_show' => $is_show,
    					);
    		
    		if($Category->data($ins_data)->add()){
    			category_data_pocess('w');//添加修改商品分类时缓存一次商品分类数据
				
    			ajaxReturn(200, '商品分类的添加成功！', 'cat_index', 'Category/index');
    		} else {
    			ajaxReturn(300, '商品分类的添加失败，请重试！');
    		}
    	}
    }
    
    //编辑商品分类
    public function edit(){
    	$cat_data = $ins_data = $child_ids = $page_data = array();
    	$cat_id = (int)$this->_get('cat_id');
    	
    	$Category = M("Category");
    	if(!isset($_POST['submit_chk'])){
	    	$cat_data = $Category -> field(array('cat_id', 'cat_name', 'parent_id', 'template_file', 'keywords', 'cat_desc', 'sort', 'is_show'))-> find( $cat_id );
	    	
	    	if(empty($cat_data)){
	    		ajaxReturn(300, '此商品分类不存在，请刷新页面重试！');
	    	}
	    	
	    	$cat_select_data = category_data_pocess();
	    	$page_data['cat_select'] = category_select($cat_select_data, 'category_id', $cat_data['parent_id'], '&nbsp&nbsp&nbsp&nbsp');
	    	$page_data = array_merge($page_data, $cat_data);
	
	    	$this->assign($page_data);
	    	$this->display();
    	} else {
    		//保存修改商品分类数据
    		$cat_id = isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : FALSE;
    		$cat_name = isset($_POST['cat_name']) && !empty($_POST['cat_name']) ? trim($_POST['cat_name']) : '';
    		$parent_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : FALSE;
			$template_file = isset($_POST['template_file']) && !empty($_POST['template_file']) ? trim($_POST['template_file']) : '';
    		$keywords = isset($_POST['keywords']) && !empty($_POST['keywords']) ? trim($_POST['keywords']) : '';
    		$cat_desc = isset($_POST['cat_desc']) && !empty($_POST['cat_desc']) ? trim($_POST['cat_desc']) : '';
    		$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : 0;
    		$is_show = isset($_POST['is_show']) ? (int)$_POST['is_show'] : 0;
			
    		if($cat_id === FALSE){
    			ajaxReturn(300, '数据有误，请刷新页面重试！');
    		}
    		
    		if(empty($cat_name)){
    			ajaxReturn(300, '商品分类名称不能为空！');
    		}
    		
    		if($parent_id === FALSE){
    			ajaxReturn(300, '请选择商品分类的上层分类！');
    		}
    		
    		//检查商品分类上层分类是否是修改前分类的子类
    		$cat_data = category_data_pocess();
    		$child_ids = get_cur_category_child_ids($cat_id, $cat_data);
    		
    		if(!empty($child_ids) && in_array($parent_id, $child_ids)){
    			ajaxReturn(300, '不能将当前分类的上层分类设置到当前分类的子类下！');
    		}
    		
    		$ins_data = array(
    							'cat_id' => $cat_id,
    							'cat_name' => $cat_name,
    							'parent_id' => $parent_id,
    							'template_file' => $template_file,
    							'keywords' => $keywords,
    							'cat_desc' => $cat_desc,
    							'sort' => $sort,
    							'is_show' => $is_show,
    					);
    		
    		if($Category->save($ins_data)){
    			category_data_pocess('w');//添加修改商品分类时缓存一次商品分类数据
    			ajaxReturn(200, '商品分类的修改成功！', 'cat_index', 'Category/index');
    		} else {
    			ajaxReturn(300, '商品分类的修改失败，请重试！');
    		}
    	}
    }
    
    public function del(){
    	$cat_data = $child_data = array();

    	$cat_id = (int)$this->_get('cat_id');
    	
    	if($cat_id < 1){
    		ajaxReturn(300, '商品分类数据有误，请刷新页面重试！');
    	}
    	
    	//当前分类下面是否还有子分类
    	$cat_data = category_data_pocess();
    	$child_data = get_cur_category_child_data($cat_id, $cat_data);
    	
    	if(!empty($child_data)){
    		ajaxReturn(300, '当前要删除的商品分类还有子分类,删除或移动子分类后才能删除此分类！');
    	}
    	
    	//当前分类下是否还有商品
    	$table_pre = C('DB_PREFIX');
    	$Category = M('Category');
    	$sql = "SELECT `goods_id` 
    			FROM `{$table_pre}category` AS c, `{$table_pre}goods` AS g 
    			WHERE c.cat_id = g.cat_id AND c.cat_id='{$cat_id}' LIMIT 1";
    	$goods_data = $Category->query($sql);
		
    	if(!empty($goods_data)){
    		ajaxReturn(300, '当前要删除的商品分类下还有相关商品数据,删除或移动相关商品数据后才能删除此分类！');
    	}
    	
    	//删除商品分类
    	if($Category->where('cat_id='.$cat_id)->delete()){
    		category_data_pocess('w');
    		ajaxReturn(200, '商品分类删除成功！', 'cat_index', 'Category/index',"forward");
    	} else {
    		ajaxReturn(300, '商品分类删除失败，请重试！');
    	}
    	
    }
    //排序方法
    public function sort()
    {
    	$Category	=	D('Category');
    	$reback		=	$Category -> MoveUpDown( $this -> _get( 'move'), $this -> _get('cat_id') ,'cat_id','sort',array('parent_id' => array('EQ',$this -> _get('pid') )) );
    	if ( $reback['success'] == 1 ) {
    		category_data_pocess('w' , 'cat_data' , 'Category'); //更新商品分类缓存文件
    		ajaxReturn( 200, $reback['msg'], 'cat_index', 'Category/index',"forward");
    	}else{
    		ajaxReturn( 300 , $reback['msg'] );
    	}
    }
    //设置商品分类的的显示状态
    public function set_show_status(){
    	$ins_data['cat_id']	= (int)$this -> _get('cat_id');
		$ins_data['is_show'] = (int)$this -> _get('isshow');
		$Category = M('Category');
		
		if ( $Category -> save( $ins_data ) ){
			category_data_pocess('w'); //修改商品分类显示状态成功后更新商品分类缓存文件
			ajaxReturn(200, $ins_data['is_show'] == 1 ? "显示成功" : "隐藏成功", "cat_index", "Category/index", "forward");
		} else {
			ajaxReturn(300,"操作失败");
		}
    }
    
    public function test(){
    	$cat_data = category_data_pocess('w');
    	//var_dump($cat_data);
    	//echo '<pre>'.var_export($cat_data, true).'</pre>';
    	echo '<pre>'.var_export(orig_category_data(), true).'</pre>';
    	//$child_ids = get_cur_category_child_ids(1, $cat_data);
    	//var_dump($child_ids);
    	var_dump(get_forfather(11));
    }
}