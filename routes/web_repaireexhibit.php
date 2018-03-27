<?php

// 藏品展览的相关路由
Route::group([
    'prefix' => 'repaireexhibit',
    'namespace' => 'RepaireExhibit',
], function () {
    Route::get('apply', 'LoginController@showLoginForm')->name('admin.repaireexhibit.apply');
    Route::get('index', 'LoginController@showLoginForm')->name('admin.repaireexhibit.index');

});