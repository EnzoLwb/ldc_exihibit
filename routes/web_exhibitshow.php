<?php

// 藏品展览的相关路由
Route::group([
	'prefix' => 'exhibitshow',
	'namespace' => 'Exhibitshow',
], function () {
	Route::get('apply', 'ApplyController@index')->name('admin.exhibitshow.apply');
	Route::get('apply/add', 'ApplyController@add')->name('admin.exhibitshow.apply.add');
	Route::get('apply/edit/{id}', 'ApplyController@edit')->name('admin.exhibitshow.apply.edit');
	Route::post('apply/save', 'ApplyController@save')->name('admin.exhibitshow.apply.save');
	Route::get('apply/delete/{id}', 'ApplyController@delete')->name('admin.exhibitshow.apply.delete');

	Route::get('show', 'ShowController@index')->name('admin.exhibitshow.show');
	Route::get('show/add', 'ShowController@add')->name('admin.exhibitshow.show.add');
	Route::get('show/edit/{id}', 'ShowController@edit')->name('admin.exhibitshow.show.edit');
	Route::post('show/save', 'ShowController@save')->name('admin.exhibitshow.show.save');
	Route::get('show/delete/{id}', 'ShowController@delete')->name('admin.exhibitshow.show.delete');

	Route::get('position', 'PositionController@index')->name('admin.exhibitshow.position');
	Route::get('position/add', 'PositionController@add')->name('admin.exhibitshow.position.add');
	Route::get('position/edit/{id}', 'PositionController@edit')->name('admin.exhibitshow.position.edit');
	Route::post('position/save', 'PositionController@save')->name('admin.exhibitshow.position.save');
	Route::get('position/delete/{id}', 'PositionController@delete')->name('admin.exhibitshow.position.delete');
});