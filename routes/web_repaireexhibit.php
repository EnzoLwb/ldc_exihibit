<?php

// 藏品展览的相关路由
Route::group([
	'prefix' => 'repaireexhibit',
	'namespace' => 'RepaireExhibit',
], function () {
	Route::get('apply', 'ApplyController@index')->name('admin.repaireexhibit.apply');
	Route::get('apply/add', 'ApplyController@add')->name('admin.repaireexhibit.apply.add');
	Route::get('apply/edit/{id}', 'ApplyController@edit')->name('admin.repaireexhibit.apply.edit');
	Route::post('apply/save', 'ApplyController@save')->name('admin.repaireexhibit.apply.save');
	Route::get('apply/delete/{id}', 'ApplyController@delete')->name('admin.repaireexhibit.apply.delete');

	Route::get('repairin', 'RepairInController@index')->name('admin.repaireexhibit.repairin');
	Route::get('repairin/add', 'RepairInController@add')->name('admin.repaireexhibit.repairin.add');
	Route::get('repairin/edit/{id}', 'RepairInController@edit')->name('admin.repaireexhibit.repairin.edit');
	Route::post('repairin/save', 'RepairInController@save')->name('admin.repaireexhibit.repairin.save');
	Route::get('repairin/delete/{id}', 'RepairInController@delete')->name('admin.repaireexhibit.repairin.delete');

	Route::get('repairout', 'RepairOutController@index')->name('admin.repaireexhibit.repairout');
	Route::get('repairout/add', 'RepairOutController@add')->name('admin.repaireexhibit.repairout.add');
	Route::get('repairout/edit/{id}', 'RepairOutController@edit')->name('admin.repaireexhibit.repairout.edit');
	Route::post('repairout/save', 'RepairOutController@save')->name('admin.repaireexhibit.repairout.save');
	Route::get('repairout/delete/{id}', 'RepairOutController@delete')->name('admin.repaireexhibit.repairout.delete');

});