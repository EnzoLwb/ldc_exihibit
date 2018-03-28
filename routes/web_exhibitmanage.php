<?php

// 藏品管理的相关路由
Route::group([
    'prefix' => 'exhibitmanage',
    'namespace' => 'ExhibitManage',
], function () {
    //仓库列表
    Route::get('storageroom', 'IndexController@storageroom')->name('admin.exhibitmanage.storageroom');
    //添加新的仓库
    Route::get('add_storageroom', 'IndexController@add_storageroom')->name('admin.exhibitmanage.add_storageroom');
    //消毒管理
    Route::get('disinfection', 'DisinfectionController@index')->name('admin.exhibitmanage.disinfection');
    //增加消毒记录
    Route::get('add_disinfection', 'DisinfectionController@add_disinfection')->name('admin.exhibitmanage.add_disinfection');

    //入库管理
    Route::get('instorageroom', 'InstorageManageController@index')->name('admin.exhibitmanage.instorageroom');
    Route::get('add_instorageroom', 'InstorageManageController@add_instorageroom')->name('admin.exhibitmanage.add_instorageroom');

    //出库申请
    Route::get('outstorageroom/oustorageapply', 'InstorageManageController@oustorageapply')->name('admin.exhibitmanage.outstorageroom.oustorageapply');
    Route::get('outstorageroom/add_oustorageapply', 'InstorageManageController@add_oustorageapply')->name('admin.exhibitmanage.outstorageroom.add_oustorageapply');
    //藏品出库
    Route::get('outstorageroom/exhibitout', 'InstorageManageController@exhibitout')->name('admin.exhibitmanage.outstorageroom.exhibitout');
    Route::get('outstorageroom/add_exhibitout', 'InstorageManageController@add_exhibitout')->name('admin.exhibitmanage.outstorageroom.add_exhibitout');

    Route::get('outstorageroom', 'LoginController@logout')->name('admin.exhibitmanage.outstorageroom');
    Route::get('exhibituse', 'LoginController@logout')->name('admin.exhibitmanage.exhibituse');
    Route::get('exhibitlook', 'LoginController@logout')->name('admin.exhibitmanage.exhibitlook');

    //藏品回库
    Route::get('exhibitbackroom', 'ExhibitBackRoomController@index')->name('admin.exhibitmanage.exhibitbackroom');
    Route::get('add_exhibitbackroom', 'ExhibitBackRoomController@add_exhibitbackroom')->name('admin.exhibitmanage.add_exhibitbackroom');
    //移库管理
    Route::get('transfer', 'TransferController@index')->name('admin.exhibitmanage.transfer');
    Route::get('add_transfer', 'TransferController@add_transfer')->name('admin.exhibitmanage.add_transfer');

    //事故登记
    Route::get('accidentregistration', 'AccidentRegistrationController@index')->name('admin.exhibitmanage.accidentregistration');

    Route::get('add_accidentregistration', 'AccidentRegistrationController@add_accidentregistration')->name('admin.exhibitmanage.add_accidentregistration');
});