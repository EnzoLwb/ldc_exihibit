<?php

namespace App\Models\Storageroommanage;

use App\Models\BaseMdl;

/**
 * Class RoomList  库房盘点
 * @author  lwb 20180403
 * @package App\Models\Storageroommanage
 */
class RoomList extends BaseMdl
{
	protected $primaryKey = 'check_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
	//申请是否通过 1为通过 0为未通过 2为审核中
	public $apply_status=['未通过','申请通过','申请审核中'];
	//盘点是否完成 1为已完成 0为未完成 2为正在执行
	public $check_status=['盘点未开始','盘点已完成','盘点正在执行'];
	//判断申请状态
	public function applyStatus($key)
	{
		return $key>2?'未知状态':$this->apply_status[$key];
	}
	//判断盘点状态
	public function checkStatus($key)
	{
		return $key>2?'未知状态':$this->check_status[$key];
	}
}
