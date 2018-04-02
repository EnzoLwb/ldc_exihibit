<?php

namespace App\Models\Storageroommanage;

use App\Models\BaseMdl;
/**
 * 库房环境管理
 *
 * @author lwb 20180402
 */
class RoomEnv extends BaseMdl
{
	protected $primaryKey = 'book_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
}
