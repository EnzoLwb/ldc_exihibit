<?php

// 账目管理的相关路由
Route::group([
    'prefix' => 'accountmanage',
    'namespace' => 'AccountManage',
], function () {
    Route::get('sumaccount', 'LoginController@showLoginForm')->name('admin.accountmanage.sumaccount');
    Route::get('subsidiary', 'LoginController@logout')->name('admin.accountmanage.subsidiary');
});