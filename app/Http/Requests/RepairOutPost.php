<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepairOutPost extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * 外修文物表单验证
	 * @author lwb 20180408
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'=>'required',
			'repair_num'=>'numeric',
			'plan_price'=>'numeric',
			'date'=>'required|date',
		];
	}
	public function messages()
	{
		return [
			'required'=>':attribute 为必填项',
			'date'=>':attribute 规范日期格式',
			'numeric'=>'必须为数字',
		];
	}
	public function attributes()
	{
		return [
			'name'=>'藏品名称',
			'repair_num'=>'修复数量',
			'plan_price'=>'估价',
			'date'=>'时间',
		];
	}
}
