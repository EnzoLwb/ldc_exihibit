<?php

namespace App\Models;
use App\Models\BaseMdl;

class ExhibitLogout extends BaseMdl
{
	protected $primaryKey = 'logout_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
	//申请状态 ：0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝
	protected $apply_status=['未提交申请','等待审批','审批通过','审批拒绝'];
	//判断申请状态
	public function applyStatus($key)
	{
		return $key>3?'未知状态':$this->apply_status[$key];
	}
}
