<?php

// 操作XLS文件
Route::group([
	'prefix' => 'excel',
	'namespace' => 'Excel',
], function () {
    //导出征集申请
    Route::get('export', 'ExcelController@export_collect_apply')->name('admin.excel.export_collect_apply');
    //导出征集单子
    Route::get('export_collect_recipe', 'ExcelController@export_collect_recipe')->name('admin.excel.export_collect_recipe');
    //导出鉴定申请的单子
    Route::get('export_identify_apply', 'ExcelController@export_identify_apply')->name('admin.excel.export_identify_apply');
    //导出消毒记录的单子
    Route::get('export_disinfection', 'ExcelController@export_disinfection')->name('admin.excel.export_disinfection');
    //导出出库申请的单子
    Route::get('export_outer_apply', 'ExcelController@export_outer_apply')->name('admin.excel.export_outer_apply');
    //导出出库记录的单子
    Route::get('export_exhibit_outer', 'ExcelController@export_exhibit_outer')->name('admin.excel.export_exhibit_outer');
    //导出事故登记单子
    Route::get('export_accident', 'ExcelController@export_accident')->name('admin.excel.export_accident');
    //入库管理导出
    Route::get('export_exhibit', 'ExcelController@export_exhibit')->name('admin.excel.export_exhibit');
    //导出回库单子
    Route::get('export_returnstorage', 'ExcelController@export_returnstorage')->name('admin.excel.export_returnstorage');
    //导出展览申请单子
    Route::get('export_show_apply', 'ExcelController@export_show_apply')->name('admin.excel.export_show_apply');
    //导出展品展览的单子
    Route::get('export_show_position', 'ExcelController@export_show_position')->name('admin.excel.export_show_position');
    //导出 伪总账的信息
    Route::get('export_fake_exhibit', 'ExcelController@export_fake_exhibit')->name('admin.excel.export_fake_exhibit');
    //导出总账信息
    Route::get('export_sum_account', 'ExcelController@export_sum_account')->name('admin.excel.export_sum_account');

});