<?php

// 操作XLS文件
Route::group([
	'prefix' => 'applymanage',
	'namespace' => 'ApplyManage',
], function () {
    //待审批的申请列表(默认是征集申请)
    Route::get('export_collect_apply', 'ApplyController@export_collect_apply')->name('admin.applymanage.export_collect_apply');

    //征集申请拒绝批量审核通过
    Route::post('collect_apply_pass', 'ApplyController@collect_apply_pass')->name('admin.applymanage.collect_apply_pass');
    //征集申请拒绝批量审核拒绝
    Route::post('collect_apply_refuse', 'ApplyController@collect_apply_refuse')->name('admin.applymanage.collect_apply_refuse');

    //鉴定申请  批量通过
    Route::post('identify_apply_pass', 'ApplyController@identify_apply_pass')->name('admin.applymanage.identify_apply_pass');
    //鉴定申请  批量拒绝
    Route::post('identify_apply_refuse', 'ApplyController@identify_apply_refuse')->name('admin.applymanage.identify_apply_refuse');

    //库房盘点申请 批量通过
	Route::post('storageCheck_apply_pass', 'ApplyController@storageCheck_apply_pass')->name('admin.applymanage.storageCheck_apply_pass');
	//库房盘点申请  批量拒绝
	Route::post('storageCheck_apply_refuse', 'ApplyController@storageCheck_apply_refuse')->name('admin.applymanage.storageCheck_apply_refuse');

	//藏品注销申请 批量通过
	Route::post('logOut_apply_pass', 'ApplyController@logOut_apply_pass')->name('admin.applymanage.logOut_apply_pass');
	//藏品注销申请  批量拒绝
	Route::post('logOut_apply_refuse', 'ApplyController@logOut_apply_refuse')->name('admin.applymanage.logOut_apply_refuse');

	//藏品修复申请 批量通过
	Route::post('repair_apply_pass', 'ApplyController@repair_apply_pass')->name('admin.applymanage.repair_apply_pass');
	//藏品修复申请  批量拒绝
	Route::post('repair_apply_refuse', 'ApplyController@repair_apply_refuse')->name('admin.applymanage.repair_apply_refuse');
});