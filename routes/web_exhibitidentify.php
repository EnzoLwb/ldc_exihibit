<?php

// 藏品鉴定的相关路由
Route::group([
    'prefix' => 'exhibitidentify',
    'namespace' => 'ExhibitIdentify',
], function () {
    Route::get('apply', 'ExhibitController@apply')->name('admin.exhibitidentify.apply');
    Route::get('add', 'ExhibitController@add')->name('admin.exhibitidentify.add');
    //录入鉴定结果
    Route::get('add_identify_result', 'ExhibitController@add_identify_result')->name('admin.exhibitidentify.add_identify_result');

    Route::get('manage', 'ExhibitController@manage')->name('admin.exhibitidentify.manage');
    Route::get('expert', 'ExhibitController@expert')->name('admin.exhibitidentify.expert');
    Route::get('expert_add', 'ExhibitController@expert_add')->name('admin.exhibitidentify.expert_add');
});