<?php
namespace App\Models;

/**
 * 文章分类模型
 *
 * @author lxp 20160705
 */
class Acategory extends BaseMdl
{
	protected $primaryKey = 'cate_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'cate_id'
	];
}
