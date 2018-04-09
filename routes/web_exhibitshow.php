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
	Route::post('apply/delete', 'ApplyController@delete')->name('admin.exhibitshow.apply.delete');
	//提交审核
    Route::post('apply/submit', 'ApplyController@submit')->name('admin.exhibitshow.apply.submit');


	Route::get('show', 'ShowController@index')->name('admin.exhibitshow.show');
	//展示展位和展品的关联
    Route::get('position_relative', 'ShowController@position_relative')->name('admin.exhibitshow.position_relative');
    Route::post('position_relative_save', 'ShowController@position_relative_save')->name('admin.exhibitshow.position_relative_save');
    Route::post('position_relative_clear', 'ShowController@position_relative_clear')->name('admin.exhibitshow.position_relative_clear');
	Route::get('show/add', 'ShowController@add')->name('admin.exhibitshow.show.add');
	Route::get('show/edit/{id}', 'ShowController@edit')->name('admin.exhibitshow.show.edit');
	Route::post('show/save', 'ShowController@save')->name('admin.exhibitshow.show.save');
	Route::get('show/delete/{id}', 'ShowController@delete')->name('admin.exhibitshow.show.delete');

	Route::get('position', 'PositionController@index')->name('admin.exhibitshow.position');
	Route::get('position/add', 'PositionController@add')->name('admin.exhibitshow.position.add');
	Route::get('position/edit/{id}', 'PositionController@edit')->name('admin.exhibitshow.position.edit');
	Route::post('position/save', 'PositionController@save')->name('admin.exhibitshow.position.save');
	Route::post('position/delete', 'PositionController@delete')->name('admin.exhibitshow.position.delete');
    Route::post('position/status_change', 'PositionController@status_change')->name('admin.exhibitshow.position.status_change');
});