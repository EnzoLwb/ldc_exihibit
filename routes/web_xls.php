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
});