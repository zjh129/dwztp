<?php
class CommonAction extends Action
{
    public $origmenudata = array();//菜单列表
    public $posArr = array();//当前位置数组
	public function _initialize()
	{
	    //菜单栏
	    $this->menudata =   F('menu_data');
	    $this->origmenudata = F('orig_menu_data');
	    //子菜单缓存
	    //$this -> keytochilarr	=	F('keytochilarr');
	    $this -> assign('menudata' , $this->menudata );
	    $this -> assign('system_data' , F('system_data') );
	}
	/**
	 * 单页访问
	 */
	public function view($id){
	    $id  = $this -> _get('id'); 
	    if ( !empty( $id ) ) {
	        $Single			=	M('Single');
	        $data			=	$Single -> find( $id );
	        //当前位置
	        $pos = array(
	            1 => '首页>公司概况>公司简介',
	            2 => '首页>公司概况>研发团队',
	            3 => '首页>客服中心>常见问题',
	            4 => '首页>客服中心>支付方式',
	            5 => '首页>客服中心>联系我们',
	        );
	        $this->assign('position', $pos[$id]);
	        //栏目选中状态，文章id对应栏目id
	        $this -> assign( $data );
	        if ( !empty( $data['template_file'] ) ){
	            $this -> display( $data['template_file'] );
	        }else{
	            $this -> display();
	        }
	    }else{
	        $this -> error("请指定文章");
	    }
	}
	/**
	 * 文章列表
	 * @param int $catId
	 */
	public function _artlist($catId){
	    $catId || $this -> error("请指定分类");
	    load('extend');
	    $orgcatlist	=	F('orig_artcat_data');
	    $catdata	=	list_search($orgcatlist,array('cat_id'=>$catId));
	    $catdata || $this->error("分类不存在");
	    $titledata = array(
	        'title'			=>	$catdata[0]['cat_name'],
	        'keywords'		=>	$catdata[0]['keywords'],
	        'description'	=>	$catdata[0]['cat_desc']
	    );
	    $artObj = D('ArticleView');
	    $pagenum = 8;
	    $map = array('catid'=>$catId);//查询条件
	    $data['list']		=	$artObj -> field("id,title,des,content,subtime,savepath,savename") -> where( $map ) -> order('createtime desc') -> page($this -> _get('p',"",1).','.$pagenum) -> select();
	    import("ORG.Util.Page");
	    $count				=	$artObj -> where( $map ) -> count();
	    $Page				=	new Page($count,$pagenum);
	    //配置分页模板
	    $Page	-> setConfig('theme', ' <span class="pager-nolink" nolinkclass="pager-nolink">共%totalRow% %header% %nowPage%/%totalPage%  页</span>   %first% %upPage% %prePage%  %linkPage%  %nextPage% %downPage% %end%');
	    $data['pager']		=	$Page -> show();
	    $this -> assign( array_merge( $data , $titledata ) );
	    if ( empty( $catdata[0]['template_file'] ) ){
	        $this -> display();
	    }else{
	        $this -> display( $catdata[0]['template_file'] );
	    }
	}
	/**
	 * 文章阅读
	 * @param int $artId
	 */
	public function _artview($artId){
	    $artId || $this->error("请选择文章");
	    $artObj = D('ArticleView');
	    $data = $artObj->find($artId);
	    $data || $this->error("内容不存在");
	    $this->assign($data);
	    $this->display();
	}
	/**
	 * 初始化当前位置数组
	 * @param int $id
	 */
	public function _initPos($id){
	    $menuList = $this->origmenudata;
	    if ($menuList){
	        foreach ($menuList as $k => $v){
	            if ($v['id'] == $id){
	                array_unshift($this->posArr, $v);
	                if ($v['pid']){
	                    self::_initPos($v['pid']);
	                }
	                break;
	            }
	        }
	    }
	}
	public function _position($id){
	    self::_initPos($id);
	    array_unshift($this->posArr, array("title"=> "首页","isoutsite"=>0,"trueurl"=>"Index/index","param"=>"","target"=>"_self"));
	    $posStr = '';
	    $split = ' > ';
	    foreach ($this->posArr as $v){
	        $posStr .= '<a href="'.($v['isoutsite'] == 1 ? $v['trueurl'] : U($v['trueurl'],$v['param'])).'" target="'.$v['target'].'" title="'.$v['title'].'">'.$v['title'].'</a>'.$split;
	    }
	    return $posStr;
	}
	public function _empty( $method )
	{
		$this -> assign(array(
				'waitSecond'	=>	2,
				'status'		=>	0,
				'msgTitle'		=>	'您访问的页面不存在',
				//'message'		=>	'您访问的页面不存在',
				'jumpUrl'		=>	U('Index/index')
		));
		$this -> display( C('TMPL_ACTION_ERROR') );
	}
}