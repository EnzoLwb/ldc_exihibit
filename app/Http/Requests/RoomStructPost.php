<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomStructPost extends FormRequest
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
	 * 库房结构管理的添加验证
	 * @author lwb 20180402
	 * @return array
	 */
	public function rules()
	{
		return [
			'room_name'=>'required',
			'room_number'=>'required',
			'ifstorage'=>'required',
			'status'=>'required',
		];
	}
	public function messages()
	{
		return [
			'required'=>':attribute 为必填项',
		];
	}
	public function attributes()
	{
		return [
			'room_name'=>'库房库位名称',
			'room_number'=>'库房库位编号',
			'ifstorage'=>'是否库位',
			'status'=>'是否生效',
		];
	}
}
