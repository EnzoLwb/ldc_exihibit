<?php

// 藏品注销的相关路由
Route::group([
    'prefix' => 'exhibitlogout',
    'namespace' => 'Exhibitlogout',
], function () {
	Route::get('', 'ExhibitlogoutController@index')->name('admin.exhibitlogout');
	Route::get('add', 'ExhibitlogoutController@add')->name('admin.exhibitlogout.add');
	Route::get('edit/{id}', 'ExhibitlogoutController@edit')->name('admin.exhibitlogout.edit');
	Route::post('save', 'ExhibitlogoutController@save')->name('admin.exhibitlogout.save');
	Route::get('delete/{id}', 'ExhibitlogoutController@delete')->name('admin.exhibitlogout.delete');
	Route::post('apply_submit', 'ExhibitlogoutController@apply_submit')->name('admin.exhibitlogout.apply_submit');
	Route::get('excel', 'ExhibitlogoutController@excel')->name('admin.exhibitlogout.excel');
});