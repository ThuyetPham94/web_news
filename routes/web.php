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
Route::get('/', 'LaravueController@index')->where('any', '.*');

Route::get('success', ['as'=>'active.success', 'uses'=>'LaravueController@success']);

Route::get('forgot', ['as'=>'forgotpassword', 'uses'=>'LaravueController@forgotPassword']);
Route::post('forgot', ['as'=>'forgotpassword.post', 'uses'=>'LaravueController@forgotPassword']);