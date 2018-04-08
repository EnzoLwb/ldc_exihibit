<?php

namespace App\Models\ExhibitRepair;

use App\Models\BaseMdl;
/**
 * 藏品修复申请模型
 *
 * @author lwb 20180407
 */
class RepairApply extends BaseMdl
{
	protected $primaryKey = 'repair_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token'
	];
	//申请状态 ：0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝
	protected $apply_status=['未提交申请','等待审批','审批通过','审批拒绝'];
	//判断申请状态
	public function applyStatus($key)
	{
		return $key>3?'未知状态':$this->apply_status[$key];
	}
}
