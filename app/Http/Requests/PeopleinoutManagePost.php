<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleinoutManagePost extends FormRequest
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
     * Get the validation rules that apply to the request.
     * @author lwb 20180331
     * @return array
     */
    public function rules()
    {
        return [
			'storeroom_id'=>'required|numeric|max:1000000000',
			'comein_member'=>'required|max:100',
			'comein_time'=>'required|date|before:real_goout_time',
			'plan_goout_time'=>'required|date',
			'real_goout_time'=>'required|date',
		];
    }
    public function messages()
	{
		return [
			'required'=>':attribute 为必填项',
			'comein_member.max'=>':attribute 不能超过100个字',
			'storeroom_id.max'=>':attribute 不能超过10位数',
			'date'=>':attribute 规范日期格式',
			'numeric'=>'请将 :attribute 改为数字',
			'comein_time.before'=>'入库时间要小于出库时间',
		];
	}
	public function attributes()
	{
		return [
			'storeroom_id'=>'库房编号',
			'comein_member'=>'入库人员',
			'comein_time'=>'入库时间',
			'plan_goout_time'=>'预计出库时间',
			'real_goout_time'=>'实际出库时间',
		];
	}
}
