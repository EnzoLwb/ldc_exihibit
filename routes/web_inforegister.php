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
    //其它文物管理相关路由
    Route::get('subsidiary', 'SubsidiaryController@index')->name('admin.inforegister.subsidiary');
	Route::get('subsidiary/add', 'SubsidiaryController@add')->name('admin.inforegister.subsidiary.add');
	Route::get('subsidiary/edit/{id}', 'SubsidiaryController@edit')->name('admin.inforegister.subsidiary.edit');
	Route::post('subsidiary/save', 'SubsidiaryController@save')->name('admin.inforegister.subsidiary.save');
	Route::get('subsidiary/delete/{id}', 'SubsidiaryController@delete')->name('admin.inforegister.subsidiary.delete');
	Route::post('subsidiary/apply_submit', 'SubsidiaryController@apply_submit')->name('admin.inforegister.subsidiary.apply_submit');
	Route::get('subsidiary/excel', 'SubsidiaryController@excel')->name('admin.inforegister.subsidiary.excel');

});