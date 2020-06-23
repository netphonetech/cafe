<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#ITEMS
Route::get('/items', 'ItemsController@index')->name('items');
Route::post('/items/add', 'ItemsController@store')->name('item-add');
Route::post('/items/destroy', 'ItemsController@destroy')->name('item-destroy');
Route::post('/items/update', 'ItemsController@update')->name('item-update');
Route::post('/items/delete', 'ItemsController@destroy')->name('item-delete');
