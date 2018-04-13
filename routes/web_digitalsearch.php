<?php

// 数字查询
Route::group([
	'prefix' => 'digitalsearch',
	'namespace' => 'DigitalSearch',
], function () {
    //综合查询
    //展品查询
    Route::get('/exhibit', 'ExhibitController@index')->name('admin.digitalsearch.exhibit');
    Route::get('/identify', 'IdentifyController@index')->name('admin.digitalsearch.identify');
    Route::get('/repaire', 'ExhibitController@index')->name('admin.digitalsearch.repaire');
    Route::get('/copy', 'ExhibitController@index')->name('admin.digitalsearch.copy');
});