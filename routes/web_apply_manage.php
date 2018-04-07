<?php

// 操作XLS文件
Route::group([
	'prefix' => 'applymanage',
	'namespace' => 'ApplyManage',
], function () {
    //待审批的申请列表
    Route::get('export_collect_apply', 'ApplyController@export_collect_apply')->name('admin.applymanage.export_collect_apply');
    //征集申请拒绝批量审核通过
    Route::post('collect_apply_pass', 'ApplyController@collect_apply_pass')->name('admin.applymanage.collect_apply_pass');
    //征集申请拒绝批量审核拒绝
    Route::post('collect_apply_refuse', 'ApplyController@collect_apply_refuse')->name('admin.applymanage.collect_apply_refuse');

    //鉴定申请  批量通过
    Route::post('identify_apply_pass', 'ApplyController@identify_apply_pass')->name('admin.applymanage.identify_apply_pass');
    //鉴定申请  批量拒绝
    Route::post('identify_apply_refuse', 'ApplyController@identify_apply_refuse')->name('admin.applymanage.identify_apply_refuse');

    //出库申请  批量通过
    Route::post('exhibit_outer_pass', 'ApplyController@exhibit_outer_pass')->name('admin.applymanage.exhibit_outer_pass');
    //出库申请  批量拒绝
    Route::post('exhibit_outer_refuse', 'ApplyController@exhibit_outer_refuse')->name('admin.applymanage.exhibit_outer_refuse');
});