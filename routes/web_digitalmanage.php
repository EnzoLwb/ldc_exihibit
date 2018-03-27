<?php
// 数字资源相关路由
Route::group([
    'prefix' => 'digitalmanage',
    'namespace' => 'DigitalManage',
], function () {
    Route::get('document', 'LoginController@showLoginForm')->name('admin.digitalmanage.document');
    Route::get('picture', 'LoginController@showLoginForm')->name('admin.digitalmanage.picture');
    Route::get('video', 'LoginController@showLoginForm')->name('admin.digitalmanage.video');

});