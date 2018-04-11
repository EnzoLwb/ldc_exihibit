<?php

// 藏品鉴定的相关路由
Route::group([
    'prefix' => 'exhibitidentify',
    'namespace' => 'ExhibitIdentify',
], function () {
    //鉴定申请列表
    Route::get('apply', 'ExhibitController@apply')->name('admin.exhibitidentify.exhibit');
    //鉴定申请提供数据
    Route::get('get_exhibit_list', 'ExhibitController@get_exhibit_list')->name('admin.exhibitidentify.get_exhibit_list');
    //鉴定申请添加页面展示
    Route::get('add', 'ExhibitController@add')->name('admin.exhibitidentify.add');
    //鉴定申请保存
    Route::post('apply_save', 'ExhibitController@apply_save')->name('admin.exhibitidentify.apply_save');
    //删除申请
    Route::get('apply_del', 'ExhibitController@apply_del')->name('admin.exhibitidentify.apply_del');
    //申请提交审核
    Route::post('apply_submit', 'ExhibitController@apply_submit')->name('admin.exhibitidentify.apply_submit');
    // 申请的图文模式
    Route::get('apply_pic_mode', 'ExhibitController@apply_pic_mode')->name('admin.exhibitidentify.apply_pic_mode');
    Route::get('add_identify_result', 'ExhibitController@add_identify_result')->name('admin.exhibitidentify.add_identify_result');
    Route::get('manage', 'ExhibitController@manage')->name('admin.exhibitidentify.manage');
    //鉴定专家列表
    Route::get('expert', 'ExpertController@expert')->name('admin.exhibitidentify.expert');
    //展示专家修改新增页面
    Route::get('expert_add', 'ExpertController@expert_add')->name('admin.exhibitidentify.expert_add');
    //保存专家信息
    Route::post('expert_save', 'ExpertController@expert_save')->name('admin.exhibitidentify.expert_save');
    //删除专家信息
    Route::get('expert_del', 'ExpertController@expert_del')->name('admin.exhibitidentify.expert_del');
    //修改专家状态
    Route::post('change_expert_status', 'ExpertController@change_expert_status')->name('admin.exhibitidentify.change_expert_status');
});