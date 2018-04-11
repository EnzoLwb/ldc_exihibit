<?php

namespace App\Models;

/**
 * 其它文物管理信息登记模型
 *
 * @package App\Models
 */
class Subsidiary extends BaseMdl
{
	protected $primaryKey = 'subsidiary_id';
	// 不可被批量赋值的属性，反之其他的字段都可被批量赋值
	protected $guarded = [
		'_token','file'
	];
	//申请状态 ：0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝
	static $apply_status=['未提交申请','等待审批','审批通过','审批拒绝'];
	static $type=['未定级文物登记账',
		'复制品登记账','仿制品登记账','资料登记账',
		'借入文物登记账','代管文物登记账','外借文物登记账'
	];
	//判断申请状态
	public function applyStatus($key)
	{
		return $key>3?'未知状态':self::$apply_status[$key];
	}
	//判断种类类别
	public function typeName($key)
	{
		return self::$type[$key];
	}
}
