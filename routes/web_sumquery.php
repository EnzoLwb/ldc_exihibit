<?php
// 综合查询相关路由
Route::group([
    'prefix' => 'sumquery',
    'namespace' => 'SumQuery',
], function () {
    Route::get('exhibitquery', 'LoginController@showLoginForm')->name('admin.sumquery.exhibitquery');
    Route::get('exhibitqueryfor', 'LoginController@showLoginForm')->name('admin.sumquery.exhibitqueryfor');
    Route::get('authorityquery', 'LoginController@showLoginForm')->name('admin.sumquery.authorityquery');
});