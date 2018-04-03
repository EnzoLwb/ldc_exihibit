<?php

// 藏品征集的相关路由
Route::group([
    'prefix' => 'exhibitcollect',
    'namespace' => 'ExhibitCollect',
], function () {
    //征集申请
    Route::get('apply', 'ExhibitController@apply')->name('admin.exhibitcollect.apply');
    //新增征集申请
    Route::get('add', 'ExhibitController@add')->name('admin.exhibitcollect.add');


    //apply_save 申请信息提交
    Route::post('apply_save', 'ExhibitController@apply_save')->name('admin.exhibitcollect.apply_save');
    //申请信息删除
    Route::get('apply_del', 'ExhibitController@apply_del')->name('admin.exhibitcollect.apply_del');
    //申请信息提交审核
    Route::post('apply_submit', 'ExhibitController@apply_submit')->name('admin.exhibitcollect.apply_submit');
    //申请列表的图文模式
    Route::get('pic_mode', 'ExhibitController@pic_mode')->name('admin.exhibitcollect.pic_mode');
    //导出列表
    Route::get('export_apply','ExhibitController@export_apply')->name('admin.exhibitcollect.export_apply');

    //接收入馆
    Route::get('getin', 'ExhibitController@getin')->name('admin.exhibitcollect.getin');
    Route::get('getin_add', 'ExhibitController@getin_add')->name('admin.exhibitcollect.getin_add');

    //提交进总账
    Route::post('into_sum_account', 'ExhibitController@into_sum_account')->name('admin.exhibitcollect.into_sum_account');
    Route::post('getin_save', 'ExhibitController@getin_save')->name('admin.exhibitcollect.getin_save');

});