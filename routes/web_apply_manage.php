<?php
// 操作XLS文件
Route::group([
	'prefix' => 'applymanage',
	'namespace' => 'ApplyManage',
], function () {
    //待审批的申请列表(默认是征集申请)
    Route::get('export_collect_apply', 'ApplyController@export_collect_apply')->name('admin.applymanage.export_collect_apply');
    //历史申请记录列表(默认是征集申请)
    Route::get('history_apply', 'ApplyController@history_apply')->name('admin.applymanage.history_apply');

    //征集申请拒绝批量审核通过
    Route::post('collect_apply_pass', 'ApplyController@collect_apply_pass')->name('admin.applymanage.collect_apply_pass');
    //征集申请拒绝批量审核拒绝
    Route::post('collect_apply_refuse', 'ApplyController@collect_apply_refuse')->name('admin.applymanage.collect_apply_refuse');

    //鉴定申请  批量通过
    Route::post('identify_apply_pass', 'ApplyController@identify_apply_pass')->name('admin.applymanage.identify_apply_pass');
    //鉴定申请  批量拒绝
    Route::post('identify_apply_refuse', 'ApplyController@identify_apply_refuse')->name('admin.applymanage.identify_apply_refuse');

    //事故申请  批量通过
    Route::post('accident_audit', 'ApplyController@accident_audit')->name('admin.applymanage.accident_audit');

    //展览申请  批量通过
    Route::post('show_audit', 'ApplyController@show_audit')->name('admin.applymanage.show_audit');

    //出库申请  批量通过
    Route::post('exhibit_outer_pass', 'ApplyController@exhibit_outer_pass')->name('admin.applymanage.exhibit_outer_pass');
    //出库申请  批量拒绝
    Route::post('exhibit_outer_refuse', 'ApplyController@exhibit_outer_refuse')->name('admin.applymanage.exhibit_outer_refuse');

    //库房盘点申请
	Route::post('storageCheck_apply', 'ApplyController@storageCheck_apply')->name('admin.applymanage.storageCheck_apply');

	//藏品注销申请
	Route::post('logOut_apply', 'ApplyController@logOut_apply')->name('admin.applymanage.logOut_apply');

	//藏品修复申请
	Route::post('repair_apply', 'ApplyController@repair_apply')->name('admin.applymanage.repair_apply');

	//其它文物登记申请
	Route::post('subsidiary_apply', 'ApplyController@subsidiary_apply')->name('admin.applymanage.subsidiary_apply');

	//总账审核申请
    Route::post('fake_exhibit_audit', 'ApplyController@fake_exhibit_audit')->name('admin.applymanage.fake_exhibit_audit');
    //入库申请
    Route::post('into_room_audit', 'ApplyController@into_room_audit')->name('admin.applymanage.into_room_audit');
});