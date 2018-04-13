<?php

// 統計信息的相关路由
Route::group([
    'prefix' => 'statics',
    'namespace' => 'Statics',
], function () {
    Route::get('identify', 'IdentifyController@index')->name('admin.statics.identify');
    Route::get('copy', 'CopyController@index')->name('admin.statics.copy');
    //展品增减统计
    Route::get('exhibit', 'ExhibitController@index')->name('admin.statics.exhibit');
    //展品来源统计
    Route::get('exhibit/src', 'ExhibitController@src')->name('admin.statics.exhibit.src');
    Route::get('repaire', 'RepaireController@index')->name('admin.statics.repaire');

});