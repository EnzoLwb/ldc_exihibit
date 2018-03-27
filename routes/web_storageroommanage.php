<?php

// 账目管理的相关路由
Route::group([
    'prefix' => 'storageroommanage',
    'namespace' => 'StorageRoomManage',
], function () {
    Route::get('peopleinoutmanage', 'LoginController@showLoginForm')->name('admin.storageroommanage.peopleinoutmanage');
    Route::get('roomenv', 'LoginController@showLoginForm')->name('admin.storageroommanage.roomenv');
    Route::get('roomstruct', 'LoginController@showLoginForm')->name('admin.storageroommanage.roomstruct');
    Route::get('roomlist', 'LoginController@showLoginForm')->name('admin.storageroommanage.roomlist');
});