<?php

// 藏品征集的相关路由
Route::group([
    'prefix' => 'exhibitcollect',
    'namespace' => 'ExhibitCollect',
], function () {
    Route::get('apply', 'LoginController@showLoginForm')->name('admin.exhibitcollect.apply');
    Route::get('getin', 'LoginController@logout')->name('admin.exhibitcollect.getin');
});