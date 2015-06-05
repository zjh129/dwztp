<?php
class ArticleViewModel extends ViewModel{
	public $viewFields	=	array(
			'Article'		=>	array('id','catid','title','shottitle','attr','weight','imgid','attachid','keywords','des','content','iscomment','views','title_color','subtime','createtime','template_file' => 'temp_file','_type' => 'LEFT'),
			'Attach'		=>	array('savepath','savename','thumbname','_on'=>'Article.imgid=Attach.id','_type' => 'LEFT'),
			'ArtCategory'	=>	array('cat_name','keywords' => 'cat_keywords','cat_desc','template_file' => 'cat_temp_file','_on' => 'Article.catid=ArtCategory.cat_id','_type' => 'LEFT'),
			'User'			=>	array('account','nickname','_on' => 'Article.user=User.id')
			);
}