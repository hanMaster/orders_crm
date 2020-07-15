<?php

Auth::routes();

Route::post('/push','PushController@store')->middleware('auth');
Route::get('/push','PushController@push')->name('push')->middleware('auth');

Route::get('/', 'HomeController@index')->name('home');
Route::get('pd', 'HomeController@patchDates')->name('patchDates');

Route::get('users/{user}/edit', 'UserController@edit')->middleware('auth');


Route::patch('users/{user}', 'UserController@update')->middleware('auth');
Route::patch('pass/{user}', 'UserController@updatePassword')->middleware('auth');

Route::resource('/bo', 'BuildObjectController')->middleware('auth');

Route::get('/order/create', 'OrderController@create')->middleware('auth')->name('order.create');
Route::post('order/create', 'OrderController@addItemFromCreate')->middleware('auth')->name('order.addItemCreate');
Route::patch('order/{order}/set-name-object', 'OrderController@setNameObject')->middleware('auth');

Route::put('order/{order}/edit', 'OrderController@addItemFromEdit')->middleware('auth')->name('order.addItemEdit');
Route::get('order/{order}/edit', 'OrderController@edit')->middleware('auth')->name('order.edit');
Route::get('order/{order}/starter-edit', 'OrderController@starterEdit')->middleware('auth')->name('order.edit');
Route::get('order/{order}/edit/createItem', 'OrderController@createItem')->middleware('auth')->name('order.addItemFromEdit');

Route::get('order/{order}/edit/{item}/editItem', 'OrderController@editItem')->middleware('auth')->name('order.editItemFromEdit');
Route::put('order/{order}/edit/{item}', 'OrderController@updateItem')->middleware('auth')->name('order.updateItemFromEdit');

Route::put('order', 'OrderController@store')->middleware('auth')->name('order.store');
Route::get('order/{order}', 'OrderController@show')->middleware('auth')->name('order.show');
Route::get('order/{order}/comments/create', 'OrderController@addComment')->middleware('auth')->name('order.addComment');

Route::post('order/{order}/comments', 'OrderController@storeComment')->middleware('auth')->name('order.storeComment');
Route::put('order/{order}/reapprove', 'OrderController@reApprove')->middleware('auth');
Route::delete('order/items/{item}', 'OrderController@destroyItem')->middleware('auth');


//Approve
Route::get('approve/{order}', 'OrderController@startApprove')->middleware('auth');
Route::put('approve/{order}', 'OrderController@makeApprove')->middleware('auth');


//Assign executor
Route::get('exec/{order}/assign', 'ExecutionController@assign')->middleware('auth');
Route::patch('exec/{order}', 'ExecutionController@assignStore')->middleware('auth');
Route::patch('exec-single', 'ExecutionController@assignSingleStore')->middleware('auth');

//executors
Route::get('execute/{order}', 'ExecutionController@execute')->middleware('auth');
Route::patch('execute/{item}', 'ExecutionController@executeItem')->middleware('auth');
Route::post('items-status-change/{order}', 'ExecutionController@itemsStatusChange')->middleware('auth');
Route::post('print/{order}', 'ExecutionController@print')->middleware('auth');

Route::get('execute/{order}/item/{item}', 'ExecutionController@getExecuteItem')->middleware('auth');

//print order
Route::get('print/{order}', 'OrderController@print')->middleware('auth');

//Reject order
Route::get('reject/{order}', 'OrderController@reject')->middleware('auth');
