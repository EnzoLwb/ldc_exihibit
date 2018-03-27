<?php

// 信息登记的相关路由
Route::group([
    'prefix' => 'inforegister',
    'namespace' => 'InfoRegister',
], function () {
    Route::get('exhibitmanage', 'LoginController@showLoginForm')->name('admin.inforegister.exhibitmanage');
    Route::get('subsidiary', 'LoginController@logout')->name('admin.inforegister.subsidiary');
});