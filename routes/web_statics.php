<?php

// 統計信息的相关路由
Route::group([
    'prefix' => 'statics',
    'namespace' => 'Statics',
], function () {
    Route::get('identify', 'LoginController@showLoginForm')->name('admin.statics.identify');
    Route::get('copy', 'LoginController@showLoginForm')->name('admin.statics.copy');
    Route::get('exhibit', 'LoginController@showLoginForm')->name('admin.statics.exhibit');
    Route::get('repaire', 'LoginController@showLoginForm')->name('admin.statics.repaire');

});