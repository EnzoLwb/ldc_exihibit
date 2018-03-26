<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'accepted' => 'The :attribute must be accepted.',
	'active_url' => 'The :attribute is not a valid URL.',
	'after' => 'The :attribute must be a date after :date.',
	'alpha' => 'The :attribute may only contain letters.',
	'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
	'alpha_num' => 'The :attribute may only contain letters and numbers.',
	'array' => 'The :attribute must be an array.',
	'before' => 'The :attribute must be a date before :date.',
	'between' => [
		'numeric' => 'The :attribute must be between :min and :max.',
		'file' => 'The :attribute must be between :min and :max kilobytes.',
		'string' => 'The :attribute must be between :min and :max characters.',
		'array' => 'The :attribute must have between :min and :max items.',
	],
	'boolean' => 'The :attribute field must be true or false.',
	'confirmed' => 'The :attribute confirmation does not match.',
	'date' => 'The :attribute is not a valid date.',
	'date_format' => 'The :attribute does not match the format :format.',
	'different' => 'The :attribute and :other must be different.',
	'digits' => 'The :attribute must be :digits digits.',
	'digits_between' => 'The :attribute must be between :min and :max digits.',
	'distinct' => 'The :attribute field has a duplicate value.',
	'email' => '请输入正确的邮箱地址',
	'mobile' => '请输入正确的手机号',
	'exists' => 'The selected :attribute is invalid.',
	'filled' => 'The :attribute field is required.',
	'image' => 'The :attribute must be an image.',
	'in' => '请输入有效的:attribute',
	'in_array' => 'The :attribute field does not exist in :other.',
	'integer' => '请输入一个整数',
	'ip' => '请填写正确的IP地址',
	'json' => 'The :attribute must be a valid JSON string.',
	'max' => [
		'numeric' => ':attribute不能大于:max',
		'file' => 'The :attribute may not be greater than :max kilobytes.',
		'string' => ':attribute不能超过:max个字符',
		'array' => 'The :attribute may not have more than :max items.',
	],
	'mimes' => 'The :attribute must be a file of type: :values.',
	'min' => [
		'numeric' => ':attribute不能小于:min',
		'file' => 'The :attribute must be at least :min kilobytes.',
		'string' => ':attribute至少需要输入:min个字符',
		'array' => 'The :attribute must have at least :min items.',
	],
	'not_in' => 'The selected :attribute is invalid.',
	'numeric' => ':attribute必须为一个数字',
	'present' => 'The :attribute field must be present.',
	'regex' => 'The :attribute format is invalid.',
	'required' => ':attribute不能为空',
	'required_if' => 'The :attribute field is required when :other is :value.',
	'required_unless' => 'The :attribute field is required unless :other is in :values.',
	'required_with' => 'The :attribute field is required when :values is present.',
	'required_with_all' => 'The :attribute field is required when :values is present.',
	'required_without' => 'The :attribute field is required when :values is not present.',
	'required_without_all' => 'The :attribute field is required when none of :values are present.',
	'same' => 'The :attribute and :other must match.',
	'size' => [
		'numeric' => 'The :attribute must be :size.',
		'file' => 'The :attribute must be :size kilobytes.',
		'string' => 'The :attribute must be :size characters.',
		'array' => 'The :attribute must contain :size items.',
	],
	'string' => 'The :attribute must be a string.',
	'timezone' => 'The :attribute must be a valid zone.',
	'unique' => '您输入的:attribute已存在，请重新输入',
	'url' => 'The :attribute format is invalid.',

	'captcha' => '验证码错误，请重新填写',
	'idcard' => '身份证错误，请重新填写',
	'file' => '请上传相关附件',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'password' => [
			'confirmed' => '两次输入的密码不一致'
		],
		'privs' => [
			'required' => '请选择权限'
		],
		'groupid' => [
			'required' => '请选择一个用户组'
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [
		'username' => '用户名',
		'password' => '密码',
		'phone' => '手机号',
		'email' => '邮箱地址',
		'captcha' => '验证码',
		'groupname' => '用户组名称',
		'cate_name' => '分类名称',
		'title' => '标题',
		'cate_id' => '分类',
		'content' => '内容',
		'old_password' => '原密码',
		'smscode' => '短信验证码'
	],

];
