<?php
function ajaxReturn($status=200,$message='提示信息',$navTabId='',$forwardUrl='', $callbackType = 'closeCurrent' , $alias	=	array() ,$type='JSON') {
	$result  =  array();
	$result['statusCode']	=	$status;
	$result['message']		=	$message;
	$result['navTabId']		=	$navTabId;
	$result['callbackType']	=	$callbackType;
	$result['forwardUrl']	=	U( $forwardUrl );
	if ( !empty( $alias ) ){
		$result	=	array_merge( $result , $alias );
	}
	if(strtoupper($type)=='JSON') {
		// 返回JSON数据格式到客户端 包含状态信息
		header("Content-Type:text/html; charset=utf-8");
		exit( json_encode($result) );
	}elseif(strtoupper($type)=='XML'){
		// 返回xml格式数据
		header("Content-Type:text/xml; charset=utf-8");
		exit(xml_encode($result));
	}
}

//生成商品分类select
function category_select($cat_data, $select_id = 'category_id', $select_index = 0, $pad_str='—', $child = '_child'){
	$cat_select = '';
	
	//定义select的option函数
	if( !function_exists('recursive_category_option') ){
		function recursive_category_option($cat_data, $level, $select_index, $pad_str = '——', $child = '_child'){
			$cat_option = '';
			if(!empty($cat_data)){
				foreach($cat_data as $cat){
					if(isset($cat['level'])){
						$level = (int)$cat['level'];
					}
					$cat_option .= '<option value="'.$cat['cat_id'].'"'.($cat['cat_id'] == $select_index ? ' selected="selected"' : '').'>'.str_repeat($pad_str, $level).$cat['cat_name'].'</option>'; //$pad_str
					if(isset($cat[$child]) && !empty($cat[$child])){
						$cat_option .= recursive_category_option($cat[$child], ($level+1), $select_index, $pad_str, $child);
					}
				}
			}
			return $cat_option;
		}
	}
	
	$cat_select .= '<select class="combox" id="'.$select_id.'" name="'.$select_id.'">';
	$cat_select .= '<option value="0">顶级分类</option>';
	$cat_select .= recursive_category_option($cat_data, 0, $select_index, $pad_str, $child);
	$cat_select .= '</select>';
	
	return $cat_select;
}

//商品分类列表数据
function table_category_tree_data($cat_data, $level = 0, $child = '_child'){
	$cat_tree_data = array();
	
	//定义select的option函数
	if( !function_exists('recursive_category_tree') ){
		function recursive_category_tree($cat_data, $level, $child = '_child'){
			$category_data = array();
			if(!empty($cat_data)){
				foreach($cat_data as $cat){
					if(!isset($cat['level'])){
						$cat['level'] = (int)$level;
					} else {
						$level = (int)$cat['level'];
					}
					
					$child_cat = isset($cat[$child]) ? $cat[$child] : array();
					unset($cat[$child]); //去除需要多于的子类数据
					$category_data[] = $cat;
					
					if(!empty($child_cat)){
						$category_data = array_merge($category_data, recursive_category_tree($child_cat, ($level+1), $child));
					}
				}
			}
			return $category_data;
		}
	}
	$cat_tree_data = recursive_category_tree($cat_data, $level, $child);
	
	return $cat_tree_data;
}

//找到当前分类的子类数据
function get_cur_category_child_data($cur_catid, $cat_data, $child = '_child'){
	$child_data = array();
	
	if(!empty($cat_data)){
		foreach($cat_data as $cat){
			if($cur_catid == $cat['cat_id']){
				if(isset($cat[$child])){
					return $cat[$child];
				} else {
					return array();
				}
			}
			
			if(isset($cat[$child])){
				$child_data = get_cur_category_child_data($cur_catid, $cat[$child], $child);
				if(!empty($child_data)){
					return $child_data;
				}
			}
		}	
	}
	
	return $child_data;
}

//获取分类数据的所有子类id
function categroy_child_ids($child_data, $child = '_child'){
	$child_ids = array();
	
	if(!empty($child_data)){
		foreach($child_data as $cat){
			$child_ids[] = $cat['cat_id'];
			
			if(isset($cat[$child])){
				$child_ids = array_merge($child_ids, categroy_child_ids($cat[$child], $child));
			}
		}
	}
	
	return $child_ids;
}

//获取当前指定分类数据的所有子类id
function get_cur_category_child_ids($cur_catid, $cat_data, $child = '_child'){
	$child_ids = $child_data = array();
	
	$child_data = get_cur_category_child_data($cur_catid, $cat_data, $child);
	
	if(empty($child_data)){
		return $child_ids;
	}
	$child_ids = categroy_child_ids($child_data, $child);
	
	return $child_ids;
}

//从商品分类缓存文件获取数据，或写入商品分类数据到商品分类缓存文件中,默认是商品类型分类
function category_data_pocess($op='r' , $dataname = 'cat_data' ,$table = "Category" ){
	$cat_data = array();
	$cat_data = F( $dataname );
	
	if(empty($cat_data) || $op == 'w'){
		$Category = M( $table );
    	$cat_data =	$Category -> field( array('cat_id','cat_name','sort','parent_id','is_show','cat_desc') ) -> order('sort asc,cat_id asc') -> where("is_show='1'") -> select();
		
    	if(!empty($cat_data)) {
			load('extend');
			orig_category_data($cat_data , 'orig_'.$dataname ); //商品分类原始数据orig_cat_data
			$cat_data = list_to_tree($cat_data, 'cat_id', 'parent_id');
			F($dataname, $cat_data); //写入商品分类文件缓存
		}
	}
	
	return $cat_data;
}

//生成获取原始分类数据
function orig_category_data($cat_data = array() , $origname = 'orig_cat_data'){
	$orig_category = array();
	
	if(!empty($cat_data)){
		foreach($cat_data as $cat){
			$orig_category[$cat['cat_id']] = $cat;
		}
		unset($cat_data);
		F($origname, $orig_category);
	} else {
		$orig_category = F($origname);
	}
	
	return $orig_category;
}

//获取祖先分类数据
function get_forfather($cid){
	$forfather = array();
	$parent_id = 0;
	
	if( !function_exists('get_parent_id')){
		function get_parent_id($cid){
			$parent_id = 0;
			$orig_cat_data = orig_category_data();
			
			if(!empty($orig_cat_data)){
				foreach($orig_cat_data as $orig_cat){
					if($orig_cat['cat_id'] == $cid){
						$parent_id = (int)$orig_cat['parent_id'];
					}
				}
			}
			return $parent_id;
		}
	}
	
	$parent_id = get_parent_id($cid);
	
	if($parent_id != 0) {
		$forfather[] = $parent_id;
		$forfather = array_merge(get_forfather($parent_id), $forfather);
	}
	
	return $forfather;
}

//根据属性参数生成相应的表单输入项,
//1:表单名，2：属性一维数组，3：属性值
function attr_to_form( $name="attr" ,  $attr = array() , $value = '' , $class='' )
{
	$formstr	=	'';
	switch ( $attr['attr_input_type'] )//判断属性值录入方式
	{
		case 0://单行文本
			$formstr	=	'<input name="'.$name.'['.$attr['attr_id'].']" '.$class.' type="text" size="30" value="'.$value.'" />';
			break;
		case 1://可选值
			$optionarr	=	explode(PHP_EOL, $attr['attr_value'] );
			if ( $attr['attr_type'] ==0 ){//select
				$formstr	=	'<select name="'.$name.'['.$attr['attr_id'].']" '.$class.'>';
				foreach ( $optionarr as $v ){
					$seced		=	$v==$value ? " selected":"";
					$formstr	.=	'<option value="'.$v.'" '.$seced.'>'.$v.'</option>';
					$seced		=	"";
				}
				$formstr	.=	'</select>';
			}elseif ( $attr['attr_type'] == 1 ){//radio
				foreach ( $optionarr as $k => $v ){
					$seced		=	$v==$value ? ' checked="checked"' :'';
					$formstr	.=	'<label style="width:100px; float:left;">
            <input name="'.$name.'['.$attr['attr_id'].']" type="radio" id="'.$name.'_'.$k.'" '.$seced.' value="'.$v.'" />'.$v.'</label>\n';
					$seced		=	"";
				}
			}elseif ( $attr['attr_type'] == 2 ){//checkbox
				$valuearr	=	explode(',', $value );
				foreach ( $optionarr as $k => $v ){
					$seced		=	in_array($v, $valuearr ) ? ' checked="checked"' :'';
					$formstr	.=	'<label style="width:100px; float:left;"><input type="checkbox" name="'.$name.'['.$attr['attr_id'].'][]" value="'.$v.'" id="'.$name.'['.$attr['attr_id'].']_'.$k.'" '.$seced.' />'.$v.'</label>';
					$seced		=	"";
				}
			}
			break;
		case 2://多行文本
			$formstr	=	'<textarea name="'.$name.'['.$attr['attr_id'].']" '.$class.' cols="45" rows="5">'.$value.'</textarea>';
			break;
	}
	return $formstr;
}
/*
 * 接收商品类型函数
 */

/*
 * 
 * 前台使用的分页函数
 * $num
 */

function multi($num, $perpage, $curpage, $mpurl) {
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if($num > $perpage) {
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}

		//$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'p=1">1 ...</a>' : '').($curpage > 1 ? '<a href="'.$mpurl.'p='.($curpage - 1).'""></a>' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= ($i == $curpage) ? $i.'|' : '<a href="'.$mpurl.'p='.$i.'">'.$i.'</a>|';
		}
                $last_page = '<a href="'  .$mpurl.'p='.($to-1).  '"  >上一页</a>';
                
		$multipage .= ($curpage < $pages ? ($to < $pages ? '<a href="'.$mpurl.'p='.$pages.'">... '.$pages.'</a>'    : '').'<a href="'.$mpurl.'p='.($curpage + 1).'">下一页</a>'  :  $last_page);
		$multipage = $multipage ? $multipage: '';
	}
	return $multipage;
}

function microtime_float()
{
	$uniq_str = '';
	$usec = $sec = 0;
	list($usec, $sec) = explode(" ", microtime());

	$uniq_str = date('YmdHis', $sec) . $usec;
	$uniq_str = str_replace('.', '', $uniq_str);
	
	return $uniq_str;
}
//判断是否有权限
function ishavepower( $model_action )
{
	$accesslist	=	F( 'ACCESS_LIST_'.session( C('USER_AUTH_KEY') ) );
	$accessarr	=	array();
	if ( !empty( $accesslist ) ) {
		foreach ( $accesslist[ strtoupper( GROUP_NAME ) ] as $k1 => $v1 ){
			foreach ( $v1 as $k2 => $v2 ){
				$accessarr[]	=	$k1."/".$k2;
			}
		}
	}
	//超级管理员开放所有权限，普通用户验证模块方法是否有权限
	if ( session("?".C('ADMIN_AUTH_KEY') ) || in_array( strtoupper( $model_action ) , $accessarr ) ) {
		return true;
	} else{
		return false;
	}
}