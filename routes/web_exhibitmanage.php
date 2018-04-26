<?php

// 藏品管理的相关路由
Route::group([
    'prefix' => 'exhibitmanage',
    'namespace' => 'ExhibitManage',
], function () {
    //移库列表
    Route::get('storageroom', 'IndexController@storageroom')->name('admin.exhibitmanage.storageroom');
    //展示修改展品的所在仓库页面
    Route::get('add_storageroom', 'IndexController@add_storageroom')->name('admin.exhibitmanage.add_storageroom');
    //storage_room_save  保存展品的所在仓库信息
    Route::post('storage_room_save', 'IndexController@storage_room_save')->name('admin.exhibitmanage.storage_room_save');
    //消毒管理
    Route::get('disinfection', 'DisinfectionController@index')->name('admin.exhibitmanage.disinfection');
    //增加消毒记录
    Route::get('add_disinfection', 'DisinfectionController@add_disinfection')->name('admin.exhibitmanage.add_disinfection');
    //保存消毒记录
    Route::post('disinfection_save', 'DisinfectionController@disinfection_save')->name('admin.exhibitmanage.disinfection_save');
    //删除消毒记录
    Route::post('del_disinfection', 'DisinfectionController@del_disinfection')->name('admin.exhibitmanage.del_disinfection');

    //入库管理
    Route::get('instorageroom', 'InstorageManageController@index')->name('admin.exhibitmanage.instorageroom');
    Route::get('add_instorageroom', 'InstorageManageController@add_instorageroom')->name('admin.exhibitmanage.add_instorageroom');
    //入库管理提交申请
    Route::post('submit_instorageroom', 'InstorageManageController@submit_instorageroom')->name('admin.exhibitmanage.submit_instorageroom');
    //入库管理信息保存
    Route::post('instorageroom_save', 'InstorageManageController@instorageroom_save')->name('admin.exhibitmanage.instorageroom_save');
    //出库申请
    Route::get('outstorageroom/oustorageapply', 'InstorageManageController@oustorageapply')->name('admin.exhibitmanage.outstorageroom.oustorageapply');
    //新增文物出库申请
    Route::get('outstorageroom/add_oustorageapply', 'InstorageManageController@add_oustorageapply')->name('admin.exhibitmanage.outstorageroom.add_oustorageapply');
    //新增辅助文物出库申请
    Route::get('outstorageroom/add_sub_oustorageapply', 'InstorageManageController@add_sub_oustorageapply')->name('admin.exhibitmanage.outstorageroom.add_sub_oustorageapply');
    Route::post('outstorageroom/oustorageapply_submit', 'InstorageManageController@oustorageapply_submit')->name('admin.exhibitmanage.outstorageroom.oustorageapply_submit');
    //提交审核
    Route::post('outstorageroom/oustorageapply_save', 'InstorageManageController@oustorageapply_save')->name('admin.exhibitmanage.outstorageroom.oustorageapply_save');
    //藏品出库
    Route::get('outstorageroom/exhibitout', 'InstorageManageController@exhibitout')->name('admin.exhibitmanage.outstorageroom.exhibitout');
    //展示藏品出库添加页面
    Route::get('outstorageroom/add_exhibitout', 'InstorageManageController@add_exhibitout')->name('admin.exhibitmanage.outstorageroom.add_exhibitout');
    //保存出库单子
    Route::post('outstorageroom/exhibitout_save', 'InstorageManageController@exhibitout_save')->name('admin.exhibitmanage.outstorageroom.exhibitout_save');

    Route::get('outstorageroom', 'LoginController@logout')->name('admin.exhibitmanage.outstorageroom');
    Route::get('exhibituse', 'LoginController@logout')->name('admin.exhibitmanage.exhibituse');
    Route::get('exhibitlook', 'LoginController@logout')->name('admin.exhibitmanage.exhibitlook');

    //藏品回库
    Route::get('exhibitbackroom', 'ExhibitBackRoomController@index')->name('admin.exhibitmanage.exhibitbackroom');
    Route::get('add_exhibitbackroom', 'ExhibitBackRoomController@add_exhibitbackroom')->name('admin.exhibitmanage.add_exhibitbackroom');
    Route::post('save_exhibitbackroom', 'ExhibitBackRoomController@save_exhibitbackroom')->name('admin.exhibitmanage.save_exhibitbackroom');
    //藏品回库提交
    Route::post('submit_exhibitbackroom', 'ExhibitBackRoomController@submit_exhibitbackroom')->name('admin.exhibitmanage.submit_exhibitbackroom');
    //移库管理
    Route::get('transfer', 'TransferController@index')->name('admin.exhibitmanage.transfer');
    Route::get('add_transfer', 'TransferController@add_transfer')->name('admin.exhibitmanage.add_transfer');

    //事故登记
    Route::get('accidentregistration', 'AccidentRegistrationController@index')->name('admin.exhibitmanage.accidentregistration');
    Route::post('accidentregistration_submit', 'AccidentRegistrationController@accidentregistration_submit')->name('admin.exhibitmanage.accidentregistration_submit');
    Route::post('accidentregistration_save', 'AccidentRegistrationController@accidentregistration_save')->name('admin.exhibitmanage.accidentregistration_save');
    Route::get('add_accidentregistration', 'AccidentRegistrationController@add_accidentregistration')->name('admin.exhibitmanage.add_accidentregistration');
    Route::post('accident_del', 'AccidentRegistrationController@accident_del')->name('admin.exhibitmanage.accident_del');

    //根据库房room_number获得排架列表
    Route::get('frame_list', 'InstorageManageController@frame_list')->name('admin.exhibitmanage.frame_list');
});