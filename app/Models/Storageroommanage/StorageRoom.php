<?php

namespace App\Models\Storageroommanage;

use App\Models\BaseMdl;

/**
 * 库房结构管理模型
 *
 * @author lwb 20180402
 */
class StorageRoom extends BaseMdl
{
	protected $primaryKey = 'room_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
}
