<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepairinPost extends FormRequest
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
     * 内修文物表单验证
     * @author lwb 20180408
     * @return array
     */
	public function rules()
	{
		return [
			'name'=>'required',
			'repair_order_name'=>'required',
			'pickup_date'=>'required|date|before:return_date',
			'return_date'=>'required|date',
		];
	}
	public function messages()
	{
		return [
			'required'=>':attribute 为必填项',
			'date'=>':attribute 规范日期格式',
			'pickup_date.before'=>'提取时间要小于归还时间',
		];
	}
	public function attributes()
	{
		return [
			'name'=>'藏品名称',
			'repair_order_name'=>'档案号',
			'pickup_date'=>'提取时间',
			'return_date'=>'归还时间',
		];
	}
}
