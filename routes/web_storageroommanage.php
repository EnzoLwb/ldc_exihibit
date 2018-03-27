<?php

// 账目管理的相关路由
Route::group([
	'prefix' => 'storageroommanage',
	'namespace' => 'Storageroommanage',
], function () {
	//    Route::get('peopleinoutmanage', 'LoginController@showLoginForm')->name('admin.storageroommanage.peopleinoutmanage');
	//    Route::get('roomenv', 'LoginController@showLoginForm')->name('admin.storageroommanage.roomenv');

	Route::get('roomstruct', 'RoomStructController@index')->name('admin.storageroommanage.roomstruct');
	Route::get('roomstruct/add', 'RoomStructController@add')->name('admin.storageroommanage.roomstruct.add');
	Route::get('roomstruct/edit/{id}', 'RoomStructController@edit')->name('admin.storageroommanage.roomstruct.edit');
	Route::post('roomstruct/save', 'RoomStructController@save')->name('admin.storageroommanage.roomstruct.save');
	Route::get('roomstruct/delete/{id}', 'RoomStructController@delete')->name('admin.storageroommanage.roomstruct.delete');

	Route::get('roomlist', 'RoomlistController@index')->name('admin.storageroommanage.roomlist');
	Route::get('roomlist/add', 'RoomlistController@add')->name('admin.storageroommanage.roomlist.add');
	Route::get('roomlist/edit/{id}', 'RoomlistController@edit')->name('admin.storageroommanage.roomlist.edit');
	Route::post('roomlist/save', 'RoomlistController@save')->name('admin.storageroommanage.roomlist.save');
	Route::get('roomlist/delete/{id}', 'RoomlistController@delete')->name('admin.storageroommanage.roomlist.delete');
});