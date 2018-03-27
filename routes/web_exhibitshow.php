<?php

// 藏品展览的相关路由
Route::group([
    'prefix' => 'exhibitshow',
    'namespace' => 'ExhibitShow',
], function () {
    Route::get('apply', 'LoginController@showLoginForm')->name('admin.exhibitshow.apply');
    Route::get('show', 'LoginController@showLoginForm')->name('admin.exhibitshow.show');
    Route::get('position', 'LoginController@showLoginForm')->name('admin.exhibitshow.position');
});