<?php

// 統計信息的相关路由
Route::group([
    'prefix' => 'statics',
    'namespace' => 'Statics',
], function () {
    Route::get('identify', 'IdentifyController@index')->name('admin.statics.identify');
    Route::get('copy', 'CopyController@index')->name('admin.statics.copy');
    Route::get('exhibit', 'ExhibitController@index')->name('admin.statics.exhibit');
    Route::get('repaire', 'RepaireController@index')->name('admin.statics.repaire');

});