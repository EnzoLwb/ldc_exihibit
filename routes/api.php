<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$route_group = ['namespace' => 'Api'];
$platformArray = config('platform');

// 接口版本号，例：v=1，值为正整数
$version = isset($_REQUEST['v']) ? intval($_REQUEST['v']) : '';
if ($version) {
	$route_group['namespace'] .= '\\' . 'V' . $version;
}

// 接口平台，例：p=i，代表IOS
$p_key = isset($_REQUEST['p']) ? $_REQUEST['p'] : '';
if ($p_key && isset($platformArray[$p_key])) {
	$route_group['namespace'] .= '\\' . $platformArray[$p_key];
}

// 根据平台和接口版本拼接命名空间
Route::group($route_group, function () {
	// 用户相关接口
	include_once 'api_user.php';

	Route::get('/', 'HomeController@index');

	// 需要登录验证的路由
	Route::group([
		'middleware' => 'auth:api'
	], function () {
	});
});
