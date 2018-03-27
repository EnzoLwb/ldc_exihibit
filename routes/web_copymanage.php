<?php

// 藏品展览的相关路由
Route::group([
    'prefix' => 'copymanage',
    'namespace' => 'CopyManage',
], function () {
    Route::get('selfapply', 'LoginController@showLoginForm')->name('admin.copymanage.selfapply');
    Route::get('otherapply', 'LoginController@showLoginForm')->name('admin.copymanage.otherapply');
    Route::get('register', 'LoginController@showLoginForm')->name('admin.copymanage.register');
});