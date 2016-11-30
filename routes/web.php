<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lazy_tree', 'EmployeeController@index');
Route::get('/lazy_tree/{id}', 'EmployeeController@lazy_tree');
Route::get('/list', 'EmployeeController@grid');

Route::post('/add', 'EmployeeController@store');
Route::get('/create', 'EmployeeController@create');
Route::get('/edit/{id}', 'EmployeeController@edit');
Route::put('/update/{employee}', 'EmployeeController@update');
Route::delete('/delete/{employee}', 'EmployeeController@destroy');

Auth::routes();