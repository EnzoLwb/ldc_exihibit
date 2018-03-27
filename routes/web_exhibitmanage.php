<?php

// 藏品管理的相关路由
Route::group([
    'prefix' => 'exhibitmanage',
    'namespace' => 'ExhibitManage',
], function () {
    Route::get('storageroom', 'LoginController@showLoginForm')->name('admin.exhibitmanage.storageroom');
    Route::get('disinfection', 'LoginController@logout')->name('admin.exhibitmanage.disinfection');
    Route::get('instorageroom', 'LoginController@logout')->name('admin.exhibitmanage.instorageroom');
    Route::get('outstorageroom', 'LoginController@logout')->name('admin.exhibitmanage.outstorageroom');
    Route::get('exhibituse', 'LoginController@logout')->name('admin.exhibitmanage.exhibituse');
    Route::get('exhibitlook', 'LoginController@logout')->name('admin.exhibitmanage.exhibitlook');
    Route::get('exhibitbackroom', 'LoginController@logout')->name('admin.exhibitmanage.exhibitbackroom');
    Route::get('transfer', 'LoginController@logout')->name('admin.exhibitmanage.transfer');
    Route::get('accidentregistration', 'LoginController@logout')->name('admin.exhibitmanage.accidentregistration');
});