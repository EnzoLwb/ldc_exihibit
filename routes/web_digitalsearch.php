<?php

// 数字查询
Route::group([
	'prefix' => 'digitalsearch',
	'namespace' => 'DigitalSearch',
], function () {
    //综合查询
    //展品查询
    Route::get('/exhibit', 'ExhibitController@index')->name('admin.digitalsearch.exhibit');
    //鉴定查询
    Route::get('/identify', 'IdentifyController@index')->name('admin.digitalsearch.identify');
    //修复查询
    Route::get('/repaire', 'ExhibitController@index')->name('admin.digitalsearch.repaire');
    //复制品查询
    Route::get('/copy', 'CopyController@index')->name('admin.digitalsearch.copy');
    //辅助账查看
    Route::get('/view_sub', 'CopyController@view_subsidiary')->name('admin.digitalsearch.view_subsidiary');
    //仿制品查询
    Route::get('/copy_by', 'CopyController@copy_by')->name('admin.digitalsearch.copy.copy_by');
});