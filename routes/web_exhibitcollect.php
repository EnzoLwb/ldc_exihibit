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
    Route::get('getin', 'ExhibitController@getin')->name('admin.exhibitcollect.getin');
});