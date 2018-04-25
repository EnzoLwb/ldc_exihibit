<?php

// 账目管理的相关路由
Route::group([
    'prefix' => 'accountmanage',
    'namespace' => 'AccountManage',
], function () {
    Route::get('sumaccount', 'IndexController@sumaccount')->name('admin.accountmanage.sumaccount');
    Route::get('add_sumaccount', 'IndexController@add_sumaccount')->name('admin.accountmanage.add_sumaccount');

    Route::get('subsidiary', 'IndexController@subsidiary')->name('admin.accountmanage.subsidiary');
    Route::get('subsidiary/excel', 'IndexController@subsidiary_excel')->name('admin.accountmanage.subsidiary.excel');
    //总账查看
    Route::get('view_sumaccount', 'IndexController@view_sumaccount')->name('admin.accountmanage.view_sumaccount');

    //根据总账或者辅助账类型，获得明细
    Route::get('item_list', 'IndexController@item_list')->name('admin.accountmanage.item_list');
    //修复申请中涉及的藏品
    Route::get('repair_item_list', 'IndexController@repair_item_list')->name('admin.accountmanage.repair_item_list');
});