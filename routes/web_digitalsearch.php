<?php

// 数字查询
Route::group([
	'prefix' => 'digitalsearch',
	'namespace' => 'DigitalSearch',
], function () {
    //综合查询
    //展品查询
    Route::get('/exhibit', 'ExhibitController@index')->name('admin.digitalsearch.exhibit');
    //自定义查询
    Route::get('/custom_exhibit', 'ExhibitController@custom_exhibit')->name('admin.digitalsearch.custom_exhibit');
    //鉴定查询
    Route::get('/identify', 'IdentifyController@index')->name('admin.digitalsearch.identify');
    //内外修复查询
    Route::get('/repaire', 'RepairController@index')->name('admin.digitalsearch.repaire');
    Route::get('/repaireout', 'RepairController@repairout')->name('admin.digitalsearch.repaireout');
    //复制品查询
    Route::get('/copy', 'CopyController@index')->name('admin.digitalsearch.copy');
    //辅助账查看
    Route::get('/view_sub', 'CopyController@view_subsidiary')->name('admin.digitalsearch.view_subsidiary');
    //仿制品查询
    Route::get('/copy_by', 'CopyController@copy_by')->name('admin.digitalsearch.copy.copy_by');
});