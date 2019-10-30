<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/users/{user}/edit', 'UserController@edit');

Route::patch('/users/{user}', 'UserController@update');

Route::resource('/bo', 'BuildObjectController')->middleware('auth');

Route::get('/order/create', 'OrderController@create')->middleware('auth')->name('order.create');
Route::post('order/create', 'OrderController@addItemFromCreate')->middleware('auth')->name('order.addItemCreate');
Route::patch('order/{order}/set-object', 'OrderController@setObject')->middleware('auth');

Route::put('order/{order}/edit', 'OrderController@addItemFromEdit')->middleware('auth')->name('order.addItemEdit');
Route::get('order/{order}/edit', 'OrderController@edit')->middleware('auth')->name('order.edit');
Route::put('order', 'OrderController@store')->middleware('auth')->name('order.store');
Route::get('order/{order}', 'OrderController@show')->middleware('auth')->name('order.show');
Route::get('order/{order}/comments/create', 'OrderController@addComment')->middleware('auth')->name('order.addComment');

Route::post('order/{order}/comments', 'OrderController@storeComment')->middleware('auth')->name('order.storeComment');
Route::put('order/{order}/reapprove', 'OrderController@reApprove')->middleware('auth');
Route::delete('order/items/{item}', 'OrderController@destroyItem')->middleware('auth');


//Approve
Route::get('approve/{order}', 'OrderController@startApprove')->middleware('auth');
Route::put('approve/{order}', 'OrderController@makeApprove')->middleware('auth');


//execution
Route::get('exec/{order}/assign', 'ExecutionController@assign')->middleware('auth');
Route::patch('exec/{order}', 'ExecutionController@assignStore')->middleware('auth');
