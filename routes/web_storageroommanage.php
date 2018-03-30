<?php

// 仓库的相关路由
Route::group([
	'prefix' => 'storageroommanage',
	'namespace' => 'Storageroommanage',
], function () {
	//人员出入管理
	Route::get('peopleinoutmanage', 'PeopleInOutManageController@index')->name('admin.storageroommanage.peopleinoutmanage');
	Route::get('peopleinoutmanage/add', 'PeopleInOutManageController@add')->name('admin.storageroommanage.peopleinoutmanage.add');
	Route::get('peopleinoutmanage/edit/{id}', 'PeopleInOutManageController@edit')->name('admin.storageroommanage.peopleinoutmanage.edit');
	Route::post('peopleinoutmanage/save', 'PeopleInOutManageController@save')->name('admin.storageroommanage.peopleinoutmanage.save');
	Route::get('peopleinoutmanage/delete/{id}', 'PeopleInOutManageController@delete')->name('admin.storageroommanage.peopleinoutmanage.delete');
	//库房环境
	Route::get('roomenv', 'RoomEnvController@index')->name('admin.storageroommanage.roomenv');
	Route::get('roomenv/add', 'RoomEnvController@add')->name('admin.storageroommanage.roomenv.add');
	Route::get('roomenv/edit/{id}', 'RoomEnvController@edit')->name('admin.storageroommanage.roomenv.edit');
	Route::post('roomenv/save', 'RoomEnvController@save')->name('admin.storageroommanage.roomenv.save');
	Route::get('roomenv/delete/{id}', 'RoomEnvController@delete')->name('admin.storageroommanage.roomenv.delete');
	//库房结构管理
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