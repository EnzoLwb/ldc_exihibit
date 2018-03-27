<?php

// 藏品鉴定的相关路由
Route::group([
    'prefix' => 'exhibitidentify',
    'namespace' => 'ExhibitIdentify',
], function () {
    Route::get('apply', 'LoginController@showLoginForm')->name('admin.exhibitidentify.apply');
    Route::get('manage', 'LoginController@logout')->name('admin.exhibitidentify.manage');
    Route::get('expert', 'LoginController@logout')->name('admin.exhibitidentify.expert');
});