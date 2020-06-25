<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

#ITEMS
Route::get('items', 'ItemsController@index')->name('items');
Route::post('items/add', 'ItemsController@store')->name('item-add');
Route::post('items/destroy', 'ItemsController@destroy')->name('item-destroy');
Route::post('items/update', 'ItemsController@update')->name('item-update');
Route::post('items/delete', 'ItemsController@destroy')->name('item-delete');


#REPORTS
Route::get('reports', 'ReportController@index')->name('reports');
Route::get('report/print', 'ReportController@print')->name('print-report');
Route::post('reports/add', 'ReportController@store')->name('report-add');
Route::post('reports/destroy', 'ReportController@destroy')->name('report-destroy');
Route::post('reports/update', 'ReportController@update')->name('report-update');
Route::post('reports/delete', 'ReportController@destroy')->name('report-delete');


#REPORT ITEMS
Route::get('reports/items', 'ReportController@show')->name('report-items');
Route::post('reports/items/add', 'ReportController@storeItem')->name('report-item-add');
Route::post('reports/items/destroy', 'ReportController@destroyItem')->name('report-item-destroy');
Route::post('reports/items/update', 'ReportController@updateItem')->name('report-item-update');
