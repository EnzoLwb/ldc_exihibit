<?php

namespace App\Models;

/**
 * 地区库模型
 *
 * @author lxp 20170904
 * @package App\Models
 */
class Region extends BaseMdl
{
	protected $primaryKey = 'region_id';

	/**
	 * 不可被批量赋值的属性。
	 * 为空时则所有的属性都可以被批量赋值
	 *
	 * @var array
	 */
	protected $guarded = [];
}
