<?php

namespace App\Models\ExhibitRepair;

use App\Models\BaseMdl;
use App\Models\Exhibit;

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
	//藏品名称
	public function exhibitName($exhibit_sum_register_id)
	{
		$exhibit_sum_register_ids = explode(',',$exhibit_sum_register_id);

		$new_names = '';
		if(!empty($exhibit_sum_register_ids)){
			$list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_ids)->select('name')->get();

			foreach($list as $item1){
				$name = $item1->name;
				$new_names = $new_names.$name.",";
			}
		}
		return rtrim($new_names,',');
	}
}
