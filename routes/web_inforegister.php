<?php

// 信息登记的相关路由
Route::group([
    'prefix' => 'inforegister',
    'namespace' => 'InfoRegister',
], function () {
    Route::get('exhibitmanage', 'IndexController@exhibitmanage')->name('admin.inforegister.exhibitmanage');
    Route::get('add_exhibit', 'IndexController@add_exhibit')->name('admin.inforegister.add_exhibit');
    //保存伪总账信息
    Route::post('fake_exhibit_save', 'IndexController@fake_exhibit_save')->name('admin.inforegister.fake_exhibit_save');
    //提交进入总账
    Route::post('fake_exhibit_submit', 'IndexController@fake_exhibit_submit')->name('admin.inforegister.fake_exhibit_submit');
    Route::get('subsidiary', 'IndexController@subsidiary')->name('admin.inforegister.subsidiary');
    Route::get('add_subsidiary', 'IndexController@add_subsidiary')->name('admin.inforegister.add_subsidiary');

});