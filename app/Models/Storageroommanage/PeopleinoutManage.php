<?php

namespace App\Models\Storageroommanage;
use App\Models\BaseMdl;

/**
 * 人员出入管理模型
 *
 * @author lwb 201803029
 */
class PeopleinoutManage extends BaseMdl
{
	protected $primaryKey = 'pio_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
}
