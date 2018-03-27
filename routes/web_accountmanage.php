<?php

// 账目管理的相关路由
Route::group([
    'prefix' => 'accountmanage',
    'namespace' => 'AccountManage',
], function () {
    Route::get('sumaccount', 'IndexController@sumaccount')->name('admin.accountmanage.sumaccount');
    Route::get('add_sumaccount', 'IndexController@add_sumaccount')->name('admin.accountmanage.add_sumaccount');

    Route::get('subsidiary', 'IndexController@subsidiary')->name('admin.accountmanage.subsidiary');
    Route::get('add_subsidiary', 'IndexController@add_subsidiary')->name('admin.accountmanage.add_subsidiary');

});