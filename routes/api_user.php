<?php

// 用户登录
Route::post('users/login', 'UsersController@login');
// 用户注册
Route::post('users/register', 'UsersController@register');
// 验证码显示
Route::get('cpt/show', 'CptController@show');
// 验证码显示
Route::get('cpt/check', 'CptController@check');
// 发送短信验证码
Route::post('send_sms', 'CptController@send_sms');
// 忘记（修改）密码
Route::post('users/password', 'UsersController@password');
// 第三方用户登录
Route::post('users/login_bind', 'UsersController@login_bind');
// 第三方用户注册
Route::post('users/register_bind', 'UsersController@register_bind');

Route::group([
	'middleware' => 'auth:api'
], function () {
	// 用户信息
	Route::get('users/info', 'UsersController@info');
	// 修改用户头像
	Route::post('users/avatar', 'UsersController@avatar');
	// 修改用户昵称
	Route::post('users/nickname', 'UsersController@nickname');
	// 用户登出
	Route::get('users/logout', 'UsersController@logout');
});
