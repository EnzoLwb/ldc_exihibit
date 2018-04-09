<?php

namespace App\Models\ExhibitRepair;

use App\Models\BaseMdl;
/**
 * 内修复文物申请
 * @author lwb 20180408
 */
class InsideRepair extends BaseMdl
{
	protected $primaryKey = 'inside_repair_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
}
