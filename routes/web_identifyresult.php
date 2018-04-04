<?php

// 藏品征集的相关路由
Route::group([
    'prefix' => 'identifyresult',
    'namespace' => 'RecordIdentify',
], function () {
    //鉴定申请表
    Route::get('record_list', 'RecordIdentifyController@record_list')->name('admin.identifyresult.record_list');
    //特定鉴定单据的鉴定结果列表
    Route::get('result_list', 'RecordIdentifyController@result_list')->name('admin.identifyresult.result_list');
    //添加鉴定结果
    Route::get('add_result', 'RecordIdentifyController@add_result')->name('admin.identifyresult.add_result');
});