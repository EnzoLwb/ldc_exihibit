<?php
namespace App\Models;

/**
 * 文章模型
 *
 * @author lxp 20160707
 */
class Article extends BaseMdl
{
	protected $primaryKey = 'article_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'cate_id'
	];
}
