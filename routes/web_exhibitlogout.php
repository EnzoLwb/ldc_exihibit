<?php

// 藏品注销的相关路由
Route::group([
    'prefix' => 'exhibitlogout',
    'namespace' => 'ExhibitLogout',
], function () {
    Route::get('add', 'LoginController@showLoginForm')->name('admin.exhibitlogout.add');
    Route::get('modify', 'LoginController@showLoginForm')->name('admin.exhibitlogout.modify');
    Route::get('submit', 'LoginController@showLoginForm')->name('admin.exhibitlogout.submit');
    Route::get('export', 'LoginController@showLoginForm')->name('admin.exhibitlogout.export');
    Route::get('print', 'LoginController@showLoginForm')->name('admin.exhibitlogout.print');
    Route::get('picturemode', 'LoginController@showLoginForm')->name('admin.exhibitlogout.picturemode');
    Route::get('query', 'LoginController@showLoginForm')->name('admin.exhibitlogout.query');
});