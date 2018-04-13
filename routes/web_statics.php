<?php

// 統計信息的相关路由
Route::group([
    'prefix' => 'statics',
    'namespace' => 'Statics',
], function () {
    //鉴定统计
    Route::get('identify', 'IdentifyController@index')->name('admin.statics.identify');
    Route::get('copy', 'CopyController@index')->name('admin.statics.copy');
    //展品增减统计
    Route::get('exhibit', 'ExhibitController@index')->name('admin.statics.exhibit');
    //展品来源统计
    Route::get('exhibit/src', 'ExhibitController@src')->name('admin.statics.exhibit.src');
    //展品状态统计
    Route::get('exhibit/status', 'ExhibitController@status_func')->name('admin.statics.exhibit.status');
    //展品详细统计
    Route::get('exhibit/type', 'ExhibitController@type')->name('admin.statics.exhibit.type');
    Route::get('repaire', 'RepaireController@index')->name('admin.statics.repaire');
});