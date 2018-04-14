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
	//申请状态 ：0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝
	protected $apply_status=['未提交申请','等待审批','审批通过','审批拒绝'];
	//判断申请状态
	public function applyStatus($key)
	{
		return $key>3?'未知状态':$this->apply_status[$key];
	}
	//查询藏品信息
	public function exhibitDetail()
	{
		return InsideRepair::leftjoin('exhibit','exhibit.exhibit_sum_register_id','inside_repair.exhibit_sum_register_id')->select('inside_repair.*','exhibit.type_num','exhibit.age');
	}
}
